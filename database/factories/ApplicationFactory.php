<?php

namespace Database\Factories;

use App\Models\Application;
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
    'status' => fake()->randomElement([
        'pending',
        'reviewed',
        'shortlisted',
        'rejected',
        'hired'
    ]),

    'cover_letter' => fake()->paragraph(),

    'resume_path' => 'resumes/sample.pdf',

    'applied_at' => fake()->dateTime(),
];
    }
}
