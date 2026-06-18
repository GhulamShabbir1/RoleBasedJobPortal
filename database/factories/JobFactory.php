<?php

namespace Database\Factories;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle,
            'company_id' => \App\Models\Company::inRandomOrder()->first()->id,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'created_by' => \App\Models\User::inRandomOrder()->first()->id,
            'description' => fake()->paragraph(5),
            'city' => fake()->city,
            'job_type' => fake()->randomElement(['full_time', 'part_time', 'contract', 'internship']),
            'min_salary' => fake()->numberBetween(10000, 50000),
            'max_salary' => fake()->numberBetween(50000, 100000),
            'dead_line' => fake()->date,
            'vacancies' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement(['draft', 'open', 'closed']),
        ];
    }
}
