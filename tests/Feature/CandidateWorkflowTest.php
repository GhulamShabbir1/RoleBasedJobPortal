<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use App\Models\CandidateProfile;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CandidateWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $candidate;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Create candidate
        $this->candidate = User::factory()->create([
            'role' => 'candidate'
        ]);

        // Login candidate
        $this->token = auth()->login($this->candidate);
    }

    public function test_candidate_can_create_profile_once()
    {
        // Step 3: Create Profile
        $response = $this->postJson('/api/candidate-profiles', [
            'bio' => 'Test bio',
            'skills' => 'PHP, Laravel',
            'experience' => '5 years'
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('candidate_profiles', [
            'user_id' => $this->candidate->id,
            'skills' => 'PHP, Laravel'
        ]);

        // Try creating second profile
        $response2 = $this->postJson('/api/candidate-profiles', [
            'bio' => 'Other bio',
            'skills' => 'React'
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response2->assertStatus(409); // Conflict, already has profile
    }

    public function test_candidate_can_only_see_open_jobs_from_approved_companies()
    {
        $approvedCompany = Company::factory()->create(['status' => 'approved']);
        $pendingCompany = Company::factory()->create(['status' => 'pending']);

        // 1. Open job, approved company (Visible)
        Job::factory()->create(['company_id' => $approvedCompany->id, 'status' => 'open', 'title' => 'Visible Job']);
        
        // 2. Closed job, approved company (Not Visible)
        Job::factory()->create(['company_id' => $approvedCompany->id, 'status' => 'closed', 'title' => 'Closed Job']);
        
        // 3. Open job, pending company (Not Visible)
        Job::factory()->create(['company_id' => $pendingCompany->id, 'status' => 'open', 'title' => 'Pending Company Job']);

        $response = $this->getJson('/api/jobs', ['Authorization' => 'Bearer ' . $this->token]);
        
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data.data');
        $response->assertJsonFragment(['title' => 'Visible Job']);
        $response->assertJsonMissing(['title' => 'Closed Job']);
        $response->assertJsonMissing(['title' => 'Pending Company Job']);
    }

    public function test_candidate_can_search_and_filter_jobs()
    {
        $company1 = Company::factory()->create(['status' => 'approved', 'name' => 'Tech Corp']);
        $company2 = Company::factory()->create(['status' => 'approved', 'name' => 'Design Inc']);
        
        $category = Category::factory()->create(['name' => 'Development']);

        Job::factory()->create([
            'company_id' => $company1->id,
            'category_id' => $category->id,
            'status' => 'open',
            'title' => 'Backend Developer',
            'city' => 'New York',
            'job_type' => 'full_time'
        ]);

        Job::factory()->create([
            'company_id' => $company2->id,
            'status' => 'open',
            'title' => 'Frontend Developer',
            'city' => 'Remote',
            'job_type' => 'part_time'
        ]);

        // Search by title
        $response = $this->getJson('/api/jobs?search=Backend', ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data.data');
        $response->assertJsonFragment(['title' => 'Backend Developer']);

        // Filter by city
        $response2 = $this->getJson('/api/jobs?city=Remote', ['Authorization' => 'Bearer ' . $this->token]);
        if ($response2->status() !== 200) $response2->dump();
        $response2->assertJsonCount(1, 'data.data');
        $response2->assertJsonFragment(['title' => 'Frontend Developer']);
        
        // Filter by category
        $response3 = $this->getJson('/api/jobs?category_id=' . $category->id, ['Authorization' => 'Bearer ' . $this->token]);
        $response3->assertJsonCount(1, 'data.data');
        $response3->assertJsonFragment(['title' => 'Backend Developer']);
    }

    public function test_candidate_can_apply_for_job_with_resume()
    {
        Storage::fake('public');
        $company = Company::factory()->create(['status' => 'approved']);
        $job = Job::factory()->create(['company_id' => $company->id, 'status' => 'open']);

        // Step 8: Apply
        $response = $this->post("/api/jobs/{$job->id}/apply", [
            'job_id' => $job->id,
            'resume' => UploadedFile::fake()->createWithContent('resume.pdf', 'dummy content'),
            'cover_letter' => 'Here is my cover letter'
        ], [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('applications', [
            'job_id' => $job->id,
            'candidate_id' => $this->candidate->id,
            'status' => 'pending'
        ]);
        
        // Missing resume
        $response2 = $this->post("/api/jobs/{$job->id}/apply", [
            'job_id' => $job->id,
        ], [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);
        
        $response2->assertStatus(422); // Validation error
    }

    public function test_candidate_cannot_apply_twice()
    {
        Storage::fake('public');
        $company = Company::factory()->create(['status' => 'approved']);
        $job = Job::factory()->create(['company_id' => $company->id, 'status' => 'open']);

        Application::factory()->create([
            'candidate_id' => $this->candidate->id,
            'job_id' => $job->id,
            'status' => 'pending'
        ]);

        $response = $this->post("/api/jobs/{$job->id}/apply", [
            'job_id' => $job->id,
            'resume' => UploadedFile::fake()->createWithContent('resume.pdf', 'dummy content'),
        ], [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(409); // Conflict, already applied
    }

    public function test_candidate_can_view_own_applications()
    {
        $otherCandidate = User::factory()->create(['role' => 'candidate']);
        
        $job1 = Job::factory()->create();
        $job2 = Job::factory()->create();

        // Candidate's application
        Application::factory()->create([
            'candidate_id' => $this->candidate->id,
            'job_id' => $job1->id
        ]);

        // Other candidate's application
        Application::factory()->create([
            'candidate_id' => $otherCandidate->id,
            'job_id' => $job2->id
        ]);

        $response = $this->getJson('/api/applications', [
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data.data');
        $response->assertJsonFragment(['job_id' => $job1->id]);
        $response->assertJsonMissing(['job_id' => $job2->id]);
    }

    public function test_candidate_cannot_modify_application_status()
    {
        $job = Job::factory()->create();
        $application = Application::factory()->create([
            'candidate_id' => $this->candidate->id,
            'job_id' => $job->id,
            'status' => 'pending'
        ]);

        // Candidate tries to change status via PUT request meant for employers
        $response = $this->putJson("/api/applications/{$application->id}/review", [
            'status' => 'accepted'
        ], ['Authorization' => 'Bearer ' . $this->token]);

        $response->assertStatus(403); // Forbidden because candidate cannot access employer routes
        
        // Ensure status didn't change
        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => 'pending'
        ]);
    }
}
