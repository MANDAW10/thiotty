<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Vaches', 'icon' => 'fas fa-cow', 'slug' => 'vaches'],
            ['name' => 'Chevaux', 'icon' => 'fas fa-horse', 'slug' => 'chevaux'],
            ['name' => 'Poulets', 'icon' => 'fas fa-egg', 'slug' => 'poulets'],
            ['name' => 'Aliments de bétail', 'icon' => 'fas fa-seedling', 'slug' => 'aliments'],
            ['name' => 'Lait naturel', 'icon' => 'fas fa-tint', 'slug' => 'lait'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
