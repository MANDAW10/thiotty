<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->pluck('id', 'slug')->toArray();

        $products = [
            // Vaches
            [
                'category_id' => $categories['vaches'],
                'name' => 'Vache Gobra Raceur',
                'slug' => 'vache-gobra-raceur',
                'description' => 'Magnifique spécimen de race Gobra, idéal pour l\'élevage et la reproduction. Très robuste et bien alimenté.',
                'price' => 750000,
                'stock' => 5,
                'is_featured' => true,
                'image' => 'vache1.jpg'
            ],
            [
                'category_id' => $categories['vaches'],
                'name' => 'Vache Métisse Azawak',
                'slug' => 'vache-metisse-azawak',
                'description' => 'Vache métisse de haute qualité, excellente production laitière.',
                'price' => 850000,
                'stock' => 3,
                'image' => 'vache2.jpg'
            ],
            // Chevaux
            [
                'category_id' => $categories['chevaux'],
                'name' => 'Cheval Pur-sang Arabe',
                'slug' => 'cheval-pur-sang-arabe',
                'description' => 'Cheval d\'exception pour les amateurs de noblesse. Dressage de base effectué.',
                'price' => 1500000,
                'stock' => 2,
                'is_featured' => true,
                'image' => 'cheval1.jpg'
            ],
            // Poulets
            [
                'category_id' => $categories['poulets'],
                'name' => 'Lot de 50 Poussins Goliath',
                'slug' => 'lot-50-poussins-goliath',
                'description' => 'Poussins de race Goliath, croissance rapide et très résistants.',
                'price' => 45000,
                'stock' => 20,
                'image' => 'poussins.jpg'
            ],
            [
                'category_id' => $categories['poulets'],
                'name' => 'Poulet de Chair (Prêt à cuire)',
                'slug' => 'poulet-chair-pret',
                'description' => 'Poulet bio élevé en plein air, abattu et nettoyé. Poids moyen 1.8kg.',
                'price' => 4500,
                'stock' => 100,
                'image' => 'poulet_chair.jpg'
            ],
            // Aliments
            [
                'category_id' => $categories['aliments'],
                'name' => 'Sac Aliment Bétail (50kg)',
                'slug' => 'sac-aliment-betail-50kg',
                'description' => 'Mélange nutritif complet pour bovins et ovins. Favorise la croissance et l\'engraissement.',
                'price' => 14500,
                'stock' => 200,
                'image' => 'aliment.jpg'
            ],
            // Lait
            [
                'category_id' => $categories['lait'],
                'name' => 'Lait Frais de Vache (5L)',
                'slug' => 'lait-frais-vache-5l',
                'description' => 'Lait pur et naturel, trait le matin même. Sans conservateurs.',
                'price' => 3500,
                'stock' => 50,
                'image' => 'lait.jpg'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
