<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * AdminWorkflowTest
 *
 * Covers all 10 steps of the Admin Workflow:
 *   1.  Login
 *   2.  Dashboard stats
 *   3.  Manage Users  (view all, view details, delete)
 *   4.  Manage Companies (view all)
 *   5.  Approve Company
 *   6.  Reject Company
 *   7.  Manage Categories (create, update, delete, list)
 *   8.  Manage Jobs (list all, delete, close)
 *   9.  Review Applications (view all, view details, update status)
 *   10. Access Everything (role bypass)
 *
 * Business Rules verified:
 *   - Admin role bypasses role middleware (RoleMiddleware admin override).
 *   - Admin can perform employer AND candidate actions.
 *   - Only approved companies can post jobs.
 *   - Admin can approve / reject companies.
 *   - Admin can delete any job.
 *   - Admin can review any application.
 */
class AdminWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private string $token;

    // -------------------------------------------------------------------------
    // Setup
    // -------------------------------------------------------------------------

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Obtain JWT token via auth helper (same pattern as CandidateWorkflowTest)
        $this->token = auth()->login($this->admin);
    }

    // =========================================================================
    // STEP 1: Login
    // =========================================================================

    /**
     * @test  Step 1 – Admin can login and receive a JWT token.
     */
    public function test_admin_can_login_and_receive_token()
    {
        // Use a fresh admin with a known plain-text password
        $password = 'AdminPass123!';
        $freshAdmin = User::factory()->create([
            'role'     => 'admin',
            'password' => bcrypt($password),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => $freshAdmin->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['success', 'data' => ['token']])
                 ->assertJsonFragment(['success' => true]);

        $this->assertNotEmpty($response->json('data.token'));
    }

    // =========================================================================
    // STEP 2: Dashboard
    // =========================================================================

    /**
     * @test  Step 2 – Admin can view dashboard stats.
     */
    public function test_admin_can_view_dashboard_stats()
    {
        // Seed some data
        $employer   = User::factory()->create(['role' => 'employer']);
        $candidate  = User::factory()->create(['role' => 'candidate']);
        $company    = Company::factory()->create(['status' => 'pending', 'user_id' => $employer->id]);
        $company2   = Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        $job        = Job::factory()->create(['company_id' => $company2->id, 'status' => 'open']);
        Application::factory()->create([
            'job_id'       => $job->id,
            'candidate_id' => $candidate->id,
        ]);

        $response = $this->getJson('/api/dashboard/admin', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true])
                 ->assertJsonStructure([
                     'data' => [
                         'totalUsers',
                         'totalCompanies',
                         'totalJobs',
                         'totalApplications',
                         'pendingCompanies',
                     ],
                 ]);

        // Verify pendingCompanies count reflects our seed data
        $data = $response->json('data');
        $this->assertGreaterThanOrEqual(1, $data['pendingCompanies']);
        $this->assertGreaterThanOrEqual(1, $data['totalApplications']);
    }

    // =========================================================================
    // STEP 3: Manage Users
    // =========================================================================

    /**
     * @test  Step 3 – Admin can view all users (candidates AND employers).
     */
    public function test_admin_can_view_all_users()
    {
        User::factory()->create(['role' => 'candidate']);
        User::factory()->create(['role' => 'employer']);

        $response = $this->getJson('/api/users', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        // Should include at least the 2 seeded + admin itself
        $users = $response->json('data');
        $this->assertGreaterThanOrEqual(3, count($users));
    }

    /**
     * @test  Step 3 – Admin can view individual user details.
     */
    public function test_admin_can_view_user_details()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);

        $response = $this->getJson("/api/users/{$candidate->id}", [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true])
                 ->assertJsonFragment(['id' => $candidate->id]);
    }

    /**
     * @test  Step 3 – Admin can delete a user.
     */
    public function test_admin_can_delete_user()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);

        $response = $this->deleteJson("/api/users/{$candidate->id}", [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseMissing('users', ['id' => $candidate->id]);
    }

    /**
     * @test  Step 3 – Admin gets 404 when viewing a non-existent user.
     */
    public function test_admin_gets_404_for_nonexistent_user()
    {
        $response = $this->getJson('/api/users/99999', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(404)
                 ->assertJsonFragment(['success' => false]);
    }

    // =========================================================================
    // STEP 4: Manage Companies
    // =========================================================================

    /**
     * @test  Step 4 – Admin can view all companies (pending, approved, rejected).
     */
    public function test_admin_can_view_all_companies()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        Company::factory()->create(['status' => 'pending',  'user_id' => $employer->id]);
        Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        Company::factory()->create(['status' => 'rejected', 'user_id' => $employer->id]);

        $response = $this->getJson('/api/companies', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        // Admin sees all 3 companies
        $data = $response->json('data');
        $this->assertGreaterThanOrEqual(3, count($data));
    }

    // =========================================================================
    // STEP 5: Approve Company
    // =========================================================================

    /**
     * @test  Step 5 – Admin can approve a pending company.
     */
    public function test_admin_can_approve_company()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $company  = Company::factory()->create(['status' => 'pending', 'user_id' => $employer->id]);

        $response = $this->postJson("/api/companies/{$company->id}/approve", [
            'company_id' => $company->id,
            'notes'      => 'All documents verified.',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('companies', [
            'id'     => $company->id,
            'status' => 'approved',
        ]);
    }

    /**
     * @test  Step 5 – Employer can post jobs after company is approved.
     */
    public function test_employer_can_post_job_after_company_approved()
    {
        $employer  = User::factory()->create(['role' => 'employer']);
        $company   = Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        $category  = Category::factory()->create();
        $empToken  = auth()->login($employer);

        $response = $this->postJson('/api/jobs', [
            'title'       => 'Senior Developer',
            'company_id'  => $company->id,
            'category_id' => $category->id,
            'description' => 'Looking for a senior developer.',
            'city'        => 'Karachi',
            'job_type'    => 'full_time',
            'min_salary'  => 80000,
            'max_salary'  => 120000,
            'deadline'    => now()->addMonth()->toDateString(),
            'vacancies'   => 3,
        ], [
            'Authorization' => 'Bearer ' . $empToken,
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['success' => true]);
    }

    // =========================================================================
    // STEP 6: Reject Company
    // =========================================================================

    /**
     * @test  Step 6 – Admin can reject a pending company.
     */
    public function test_admin_can_reject_company()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $company  = Company::factory()->create(['status' => 'pending', 'user_id' => $employer->id]);

        $response = $this->postJson("/api/companies/{$company->id}/reject", [
            'company_id' => $company->id,
            'reason'     => 'Invalid registration certificate.',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('companies', [
            'id'     => $company->id,
            'status' => 'rejected',
        ]);
    }

    /**
     * @test  Step 6 – Employer cannot post jobs with rejected company.
     */
    public function test_employer_cannot_post_job_with_rejected_company()
    {
        $employer  = User::factory()->create(['role' => 'employer']);
        $company   = Company::factory()->create(['status' => 'rejected', 'user_id' => $employer->id]);
        $category  = Category::factory()->create();
        $empToken  = auth()->login($employer);

        $response = $this->postJson('/api/jobs', [
            'title'       => 'Developer',
            'company_id'  => $company->id,
            'category_id' => $category->id,
            'description' => 'We need developers.',
            'city'        => 'Lahore',
            'job_type'    => 'full_time',
            'min_salary'  => 50000,
            'max_salary'  => 90000,
            'deadline'    => now()->addMonth()->toDateString(),
            'vacancies'   => 1,
        ], [
            'Authorization' => 'Bearer ' . $empToken,
        ]);

        // Should be rejected (403 or 422 depending on implementation)
        $this->assertContains($response->status(), [403, 422, 400]);
        $response->assertJsonFragment(['success' => false]);
    }

    // =========================================================================
    // STEP 7: Manage Categories
    // =========================================================================

    /**
     * @test  Step 7 – Admin can view all categories.
     */
    public function test_admin_can_view_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertGreaterThanOrEqual(3, count($response->json('data')));
    }

    /**
     * @test  Step 7 – Admin can create a category.
     */
    public function test_admin_can_create_category()
    {
        $response = $this->postJson('/api/categories', [
            'name'        => 'Information Technology',
            'description' => 'IT related jobs',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['success' => true])
                 ->assertJsonFragment(['name' => 'Information Technology']);

        $this->assertDatabaseHas('categories', ['name' => 'Information Technology']);
    }

    /**
     * @test  Step 7 – Admin can update a category.
     */
    public function test_admin_can_update_category()
    {
        $category = Category::factory()->create(['name' => 'Finance']);

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name'        => 'Finance & Banking',
            'description' => 'Jobs in finance and banking sector',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('categories', [
            'id'   => $category->id,
            'name' => 'Finance & Banking',
        ]);
    }

    /**
     * @test  Step 7 – Admin can delete a category.
     */
    public function test_admin_can_delete_category()
    {
        $category = Category::factory()->create(['name' => 'Marketing']);

        $response = $this->deleteJson("/api/categories/{$category->id}", [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    // =========================================================================
    // STEP 8: Manage Jobs
    // =========================================================================

    /**
     * @test  Step 8 – Admin can view all jobs (admin-specific endpoint).
     */
    public function test_admin_can_view_all_jobs()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $company  = Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        Job::factory()->count(3)->create(['company_id' => $company->id, 'status' => 'open']);
        Job::factory()->create(['company_id' => $company->id, 'status' => 'closed']);

        $response = $this->getJson('/api/admin/jobs', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertGreaterThanOrEqual(4, count($response->json('data')));
    }

    /**
     * @test  Step 8 – Admin can delete any job (remove inappropriate content).
     */
    public function test_admin_can_delete_inappropriate_job()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $company  = Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        $job      = Job::factory()->create(['company_id' => $company->id, 'status' => 'open']);

        $response = $this->deleteJson("/api/admin/jobs/{$job->id}", [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseMissing('jobs', ['id' => $job->id]);
    }

    /**
     * @test  Step 8 – Admin can close a job.
     */
    public function test_admin_can_close_job()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $company  = Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        $job      = Job::factory()->create(['company_id' => $company->id, 'status' => 'open']);

        $response = $this->postJson("/api/admin/jobs/{$job->id}/close", [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('jobs', [
            'id'     => $job->id,
            'status' => 'closed',
        ]);
    }

    // =========================================================================
    // STEP 9: Review Applications
    // =========================================================================

    /**
     * @test  Step 9 – Admin can view all applications.
     */
    public function test_admin_can_view_all_applications()
    {
        $employer   = User::factory()->create(['role' => 'employer']);
        $candidate1 = User::factory()->create(['role' => 'candidate']);
        $candidate2 = User::factory()->create(['role' => 'candidate']);
        $company    = Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        $job        = Job::factory()->create(['company_id' => $company->id, 'status' => 'open']);

        Application::factory()->create(['job_id' => $job->id, 'candidate_id' => $candidate1->id]);
        Application::factory()->create(['job_id' => $job->id, 'candidate_id' => $candidate2->id]);

        // Admin accesses applications (role:admin bypasses any role restriction)
        $response = $this->getJson('/api/applications', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        // Admin should see both applications
        $data = $response->json('data.data') ?? $response->json('data');
        $this->assertGreaterThanOrEqual(2, count($data));
    }

    /**
     * @test  Step 9 – Admin can view a single application with candidate info.
     */
    public function test_admin_can_view_single_application()
    {
        $employer  = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create(['role' => 'candidate']);
        $company   = Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        $job       = Job::factory()->create(['company_id' => $company->id]);
        $app       = Application::factory()->create([
            'job_id'       => $job->id,
            'candidate_id' => $candidate->id,
            'status'       => 'pending',
        ]);

        $response = $this->getJson("/api/applications/{$app->id}", [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true])
                 ->assertJsonFragment(['id' => $app->id]);
    }

    /**
     * @test  Step 9 – Admin can update/review application status.
     */
    public function test_admin_can_update_application_status()
    {
        $employer  = User::factory()->create(['role' => 'employer']);
        $candidate = User::factory()->create(['role' => 'candidate']);
        $company   = Company::factory()->create(['status' => 'approved', 'user_id' => $employer->id]);
        $job       = Job::factory()->create(['company_id' => $company->id]);
        $app       = Application::factory()->create([
            'job_id'       => $job->id,
            'candidate_id' => $candidate->id,
            'status'       => 'pending',
        ]);

        $response = $this->putJson("/api/applications/{$app->id}", [
            'status' => 'reviewed',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('applications', [
            'id'     => $app->id,
            'status' => 'reviewed',
        ]);
    }

    // =========================================================================
    // STEP 10: Access Everything (Role Bypass)
    // =========================================================================

    /**
     * @test  Step 10 – Admin is NOT blocked by role:employer middleware.
     *        Admin can access employer-protected routes without being an employer.
     */
    public function test_admin_can_access_employer_routes()
    {
        // Admin accessing a route protected by role:employer
        $response = $this->getJson('/api/companies', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        // If role check were strict, admin (role=admin) would get 403.
        // The RoleMiddleware admin override ensures admin always passes.
        $response->assertStatus(200);
    }

    /**
     * @test  Step 10 – Admin is NOT blocked by role:candidate middleware.
     *        Admin can access candidate-protected routes.
     */
    public function test_admin_can_access_candidate_routes()
    {
        // Admin accessing a route protected by role:candidate
        $response = $this->getJson('/api/applications', [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        // Should succeed, not 403
        $this->assertNotEquals(403, $response->status());
        $response->assertJsonFragment(['success' => true]);
    }

    /**
     * @test  Step 10 – Admin can access admin dashboard, not non-admins.
     */
    public function test_non_admin_cannot_access_admin_dashboard()
    {
        $candidate      = User::factory()->create(['role' => 'candidate']);
        $candidateToken = auth()->login($candidate);

        $response = $this->getJson('/api/dashboard/admin', [
            'Authorization' => 'Bearer ' . $candidateToken,
        ]);

        $response->assertStatus(403);
    }

    /**
     * @test  Step 10 – Admin can access user management, not non-admins.
     */
    public function test_non_admin_cannot_manage_users()
    {
        $employer      = User::factory()->create(['role' => 'employer']);
        $employerToken = auth()->login($employer);

        $response = $this->getJson('/api/users', [
            'Authorization' => 'Bearer ' . $employerToken,
        ]);

        $response->assertStatus(403);
    }

    // =========================================================================
    // Business Rules – Extra Guards
    // =========================================================================

    /**
     * @test  Business Rule – Admin can update a user's role.
     */
    public function test_admin_can_update_user_role()
    {
        $user = User::factory()->create(['role' => 'candidate']);

        $response = $this->putJson("/api/users/{$user->id}/role", [
            'role' => 'employer',
        ], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['success' => true]);

        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'role' => 'employer',
        ]);
    }

    /**
     * @test  Business Rule – Admin delete of non-existent application returns error.
     */
    public function test_admin_delete_nonexistent_application_returns_error()
    {
        $response = $this->deleteJson('/api/applications/99999', [], [
            'Authorization' => 'Bearer ' . $this->token,
        ]);

        // findById(99999) returns null → feature throws 404 → controller returns 404 success:false
        $response->assertStatus(404)
                 ->assertJsonFragment(['success' => false]);
    }
}
