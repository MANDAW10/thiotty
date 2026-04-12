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
                'name' => 'Vaches', 
                'icon' => 'fas fa-cow', 
                'slug' => 'vaches',
                'image' => 'https://images.unsplash.com/photo-1546445317-29f4545e9d53?q=80&w=1200'
            ],
                'name' => 'Chevaux', 
                'icon' => 'fas fa-horse', 
                'slug' => 'chevaux',
                'image' => 'https://images.unsplash.com/photo-1553284965-83fd3e82fa5a?q=80&w=1200'
            ],
                'name' => 'Poulets', 
                'icon' => 'fas fa-egg', 
                'slug' => 'poulets',
                'image' => 'https://images.unsplash.com/photo-1569337776101-921350a4d53c?q=80&w=1200'
            ],
                'name' => 'Aliments de bétail', 
                'icon' => 'fas fa-seedling', 
                'slug' => 'aliments',
                'image' => 'https://images.unsplash.com/photo-1595113316349-9fa4eb24f884?q=80&w=1200'
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
