<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Vaches',
                'icon' => 'fas fa-cow',
                'slug' => 'vaches',
                'image' => 'https://images.unsplash.com/photo-1546445317-29f4545e9d53?q=80&w=1600&auto=format&fit=crop',
            ],
            [
                'name' => 'Chevaux',
                'icon' => 'fas fa-horse',
                'slug' => 'chevaux',
                'image' => 'https://images.unsplash.com/photo-1553284965-83fd3e82fa5a?q=80&w=1600&auto=format&fit=crop',
            ],
            [
                'name' => 'Poulets',
                'icon' => 'fas fa-egg',
                'slug' => 'poulets',
                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1600&auto=format&fit=crop',
            ],
            [
                'name' => 'Aliments de bétail',
                'icon' => 'fas fa-seedling',
                'slug' => 'aliments',
                'image' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?q=80&w=1600&auto=format&fit=crop',
            ],
            [
                'name' => 'Lait naturel',
                'icon' => 'fas fa-tint',
                'slug' => 'lait',
                'image' => 'https://images.unsplash.com/photo-1550583724-125581ff26b7?q=80&w=1200&auto=format&fit=crop',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
