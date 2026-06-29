<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Software Engineering',
                'description' => 'Build and maintain software systems.',
                'icon' => 'fas fa-code',
            ],
            [
                'name' => 'Web Development',
                'description' => 'Front-end and back-end web development.',
                'icon' => 'fas fa-globe',
            ],
            [
                'name' => 'Data Science',
                'description' => 'Analytics, ML, and data-driven decision making.',
                'icon' => 'fas fa-chart-line',
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Design user interfaces and experiences.',
                'icon' => 'fas fa-palette',
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Develop mobile apps for iOS and Android.',
                'icon' => 'fas fa-mobile-alt',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}

