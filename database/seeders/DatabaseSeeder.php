<?php

namespace Database\Seeders;

use App\Models\User;
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

        Job::factory(20)->create();
    }

}