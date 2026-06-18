<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\Job;
use App\Models\CandidateProfile;
use App\Models\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin (idempotent)
        User::updateOrCreate(
            ['email' => 'admin@jobportal.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
        ]
    );

    $employers = User::factory(3)->employer()->create();
    $candidates = User::factory(10)->candidate()->create();

    $companies = [];

    foreach ($employers as $employer) {
        $companies[] = Company::factory()->create([
            'user_id' => $employer->id
        ]);
    }

    Category::factory(10)->create();

    $jobs = [];

    foreach ($companies as $company) {
        $jobs[] = Job::factory()->create([
            'company_id' => $company->id,
            'category_id' => Category::inRandomOrder()->first()->id
        ]);
    }

    foreach ($jobs as $job) {
        Application::factory()->create([
            'job_id' => $job->id,
            'candidate_id' => $candidates->random()->id
        ]);
    }
    }}
