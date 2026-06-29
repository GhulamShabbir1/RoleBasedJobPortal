<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'user_id' => User::where('role', 'employer')->inRandomOrder()->first()?->id ?? User::factory()->create(['role' => 'employer'])->id,
    'name' => fake()->company(),
    'email' => fake()->unique()->companyEmail(),
    'description' => fake()->paragraph(5),
    'city' => fake()->city(),
    'website' => fake()->url(),

    'logo' => fake()->imageUrl(200, 200, 'business', true),
    'certificate' => fake()->imageUrl(400, 300, 'business', true),

    'status' => fake()->randomElement([
        'pending',
        'approved',
        'rejected'
    ]),
];
    }
}
