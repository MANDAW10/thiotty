<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryHierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $structure = [
            'Agro-alimentaire' => [
                'Produits Laitiers' => 'lait',
                'Céréales Locales' => 'cereales',
                'Farines & Transformation' => 'farines',
                'Huiles Naturelles' => 'huiles',
            ],
            'Volaille' => [
                'Poulet de Chair' => 'poulets',
                'Pondeuses & Oeufs' => 'pondeuses',
                'Cailles Thiotty' => 'cailles',
                'Poussins Goliath' => 'goliath',
            ],
            'Élevage' => [
                'Bovins (Vaches)' => 'vaches',
                'Ovins (Moutons)' => 'moutons',
                'Aliments Bétail' => 'aliments',
                'Santé Animale' => 'sante-animale',
            ]
        ];

        foreach ($structure as $parentName => $children) {
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($parentName)],
                ['name' => $parentName]
            );

            foreach ($children as $childName => $slug) {
                Category::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $childName,
                        'parent_id' => $parent->id
                    ]
                );
            }
        }
    }
}
