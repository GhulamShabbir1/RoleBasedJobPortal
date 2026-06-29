<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => Job::inRandomOrder()->first()->id,
            'candidate_id' => User::where('role', 'candidate')->inRandomOrder()->first()->id,

            'status' => fake()->randomElement([
                'pending',
                'reviewed',
                'accepted',
                'rejected'
            ]),

            // NOTE: If DB column 'status' is an enum with restricted values,
            // seed must match exactly those values.
            // (This factory keeps same values; mismatch warnings indicate DB enum mismatch.)

            'cover_letter' => fake()->paragraph(),

            'resume_path' => 'resumes/sample.pdf',

            'applied_at' => fake()->dateTime(),
        ];
    }
}
