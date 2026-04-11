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
            [
                'name' => 'Vaches', 
                'icon' => 'fas fa-cow', 
                'slug' => 'vaches',
                'image' => 'https://images.unsplash.com/photo-1543160732-23700b1b13b1?q=80&w=1200&auto=format&fit=crop'
            ],
            [
                'name' => 'Chevaux', 
                'icon' => 'fas fa-horse', 
                'slug' => 'chevaux',
                'image' => 'https://images.unsplash.com/photo-1598974357801-cbca100e4811?q=80&w=1200&auto=format&fit=crop'
            ],
            [
                'name' => 'Poulets', 
                'icon' => 'fas fa-egg', 
                'slug' => 'poulets',
                'image' => 'https://images.unsplash.com/photo-1569337776101-921350a4d53c?q=80&w=1200&auto=format&fit=crop'
            ],
            [
                'name' => 'Aliments de bétail', 
                'icon' => 'fas fa-seedling', 
                'slug' => 'aliments',
                'image' => 'https://images.unsplash.com/photo-1582560475093-ba66accbc424?q=80&w=1200&auto=format&fit=crop'
            ],
            [
                'name' => 'Lait naturel', 
                'icon' => 'fas fa-tint', 
                'slug' => 'lait',
                'image' => 'https://images.unsplash.com/photo-1550583724-125581ff26b7?q=80&w=1200&auto=format&fit=crop'
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
