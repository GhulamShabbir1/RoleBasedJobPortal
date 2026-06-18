<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use App\Models\Job;
use App\Models\CandidateProfile;
use App\Models\Application;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@jobportal.com',
        ]);

        // 3 Employers
        User::factory(3)->employer()->create();

        // 10 Candidates
        User::factory(10)->candidate()->create();

        Company::factory(10)->create();

        Category::factory(10)->create();

        Job::factory(20)->create();

        CandidateProfile::factory(10)->create();

        Application::factory(20)->create();
    }

}