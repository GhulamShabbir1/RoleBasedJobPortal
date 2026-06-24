<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BusinessRulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_employer_cannot_create_second_company()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $token = auth()->login($employer);

        Company::factory()->create(['user_id' => $employer->id, 'status' => 'pending']);

        $response = $this->postJson('/api/companies', [
            'name' => 'Second Company',
            'email' => 'second@company.com',
            'city' => 'Test City',
        ], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(400);
        $this->assertDatabaseCount('companies', 1);
    }

    public function test_company_must_be_approved_before_posting_jobs()
    {
        $employer = User::factory()->create(['role' => 'employer']);
        $token = auth()->login($employer);
        $company = Company::factory()->create(['user_id' => $employer->id, 'status' => 'pending']);

        $response = $this->postJson('/api/jobs', [
            'title' => 'Test Job',
            'description' => 'Test Description',
            'city' => 'Test City',
            'min_salary' => 30000,
            'max_salary' => 50000,
            'job_type' => 'full_time',
            'category' => 'Test Category',
            'company_id' => $company->id,
        ], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(403);
        $this->assertDatabaseCount('jobs', 0);

        $company->update(['status' => 'approved']);

        $response = $this->postJson('/api/jobs', [
            'title' => 'Test Job',
            'description' => 'Test Description',
            'city' => 'Test City',
            'min_salary' => 30000,
            'max_salary' => 50000,
            'job_type' => 'full_time',
            'category' => 'Test Category',
            'company_id' => $company->id,
        ], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(201);
        $this->assertDatabaseCount('jobs', 1);
    }

    public function test_employer_can_only_manage_own_jobs()
    {
        $employer1 = User::factory()->create(['role' => 'employer']);
        $employer2 = User::factory()->create(['role' => 'employer']);

        $company = Company::factory()->create(['user_id' => $employer1->id, 'status' => 'approved']);
        $job = Job::factory()->create(['user_id' => $employer1->id, 'company_id' => $company->id, 'status' => 'open']);

        $token = auth()->login($employer2);
        $response = $this->putJson("/api/jobs/{$job->id}", [
            'title' => 'Updated Job',
        ], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(403);

        $token = auth()->login($employer1);
        $response = $this->putJson("/api/jobs/{$job->id}", [
            'title' => 'Updated Job',
        ], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(200);
    }

    public function test_candidate_can_only_apply_to_open_jobs()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);
        $token = auth()->login($candidate);

        $employer = User::factory()->create(['role' => 'employer']);
        $company = Company::factory()->create(['user_id' => $employer->id, 'status' => 'approved']);
        $closedJob = Job::factory()->create(['user_id' => $employer->id, 'company_id' => $company->id, 'status' => 'closed']);
        $openJob = Job::factory()->create(['user_id' => $employer->id, 'company_id' => $company->id, 'status' => 'open']);

        Storage::fake('local');
        $response = $this->postJson("/api/jobs/{$closedJob->id}/apply", [
            'resume' => 'fake/file.pdf',
        ], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(400);

        $response = $this->postJson("/api/jobs/{$openJob->id}/apply", [
            'resume' => 'fake/file.pdf',
        ], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(201);
    }

    public function test_candidate_cannot_apply_twice_to_same_job()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);
        $token = auth()->login($candidate);

        $employer = User::factory()->create(['role' => 'employer']);
        $company = Company::factory()->create(['user_id' => $employer->id, 'status' => 'approved']);
        $job = Job::factory()->create(['user_id' => $employer->id, 'company_id' => $company->id, 'status' => 'open']);

        Storage::fake('local');
        Application::factory()->create(['candidate_id' => $candidate->id, 'job_id' => $job->id, 'status' => 'pending']);

        $response = $this->postJson("/api/jobs/{$job->id}/apply", [
            'resume' => 'fake/file.pdf',
        ], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(400);
        $this->assertDatabaseCount('applications', 1);
    }

    public function test_resume_is_required_to_apply()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);
        $token = auth()->login($candidate);

        $employer = User::factory()->create(['role' => 'employer']);
        $company = Company::factory()->create(['user_id' => $employer->id, 'status' => 'approved']);
        $job = Job::factory()->create(['user_id' => $employer->id, 'company_id' => $company->id, 'status' => 'open']);

        $response = $this->postJson("/api/jobs/{$job->id}/apply", [], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('resume');
    }

    public function test_closed_job_rejects_new_applications()
    {
        $candidate = User::factory()->create(['role' => 'candidate']);
        $token = auth()->login($candidate);

        $employer = User::factory()->create(['role' => 'employer']);
        $company = Company::factory()->create(['user_id' => $employer->id, 'status' => 'approved']);
        $job = Job::factory()->create(['user_id' => $employer->id, 'company_id' => $company->id, 'status' => 'closed']);

        Storage::fake('local');
        $response = $this->postJson("/api/jobs/{$job->id}/apply", [
            'resume' => 'fake/file.pdf',
        ], ['Authorization' => 'Bearer ' . $token]);

        $response->assertStatus(400);
    }

    public function test_admin_has_full_access_to_all_resources()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $token = auth()->login($admin);

        $employer = User::factory()->create(['role' => 'employer']);
        $company = Company::factory()->create(['user_id' => $employer->id, 'status' => 'approved']);
        $job = Job::factory()->create(['user_id' => $employer->id, 'company_id' => $company->id, 'status' => 'open']);
        $application = Application::factory()->create(['candidate_id' => User::factory()->create(['role' => 'candidate'])->id, 'job_id' => $job->id]);

        $response = $this->deleteJson("/api/jobs/{$job->id}", [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);

        $response = $this->getJson('/api/dashboard/admin', ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(200);
    }
}
