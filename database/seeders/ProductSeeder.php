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
                'image' => 'https://images.unsplash.com/photo-1543160732-23700b1b13b1?q=80&w=1200&auto=format&fit=crop'
            ],
            [
                'category_id' => $categories['vaches'],
                'name' => 'Vache Métisse Azawak',
                'slug' => 'vache-metisse-azawak',
                'description' => 'Vache métisse de haute qualité, excellente production laitière.',
                'price' => 850000,
                'stock' => 3,
                'image' => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?q=80&w=1200&auto=format&fit=crop'
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
                'image' => 'https://images.unsplash.com/photo-1598974357801-cbca100e4811?q=80&w=1200&auto=format&fit=crop'
            ],
            // Poulets
            [
                'category_id' => $categories['poulets'],
                'name' => 'Lot de 50 Poussins Goliath',
                'slug' => 'lot-50-poussins-goliath',
                'description' => 'Poussins de race Goliath, croissance rapide et très résistants.',
                'price' => 45000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1200&auto=format&fit=crop'
            ],
            [
                'category_id' => $categories['poulets'],
                'name' => 'Poulet de Chair (Prêt à cuire)',
                'slug' => 'poulet-chair-pret',
                'description' => 'Poulet bio élevé en plein air, abattu et nettoyé. Poids moyen 1.8kg.',
                'price' => 4500,
                'stock' => 100,
                'image' => 'https://images.unsplash.com/photo-1569337776101-921350a4d53c?q=80&w=1200&auto=format&fit=crop'
            ],
            // Aliments
            [
                'category_id' => $categories['aliments'],
                'name' => 'Sac Aliment Bétail (50kg)',
                'slug' => 'sac-aliment-betail-50kg',
                'description' => 'Mélange nutritif complet pour bovins et ovins. Favorise la croissance et l\'engraissement.',
                'price' => 14500,
                'stock' => 200,
                'image' => 'https://images.unsplash.com/photo-1582560475093-ba66accbc424?q=80&w=1200&auto=format&fit=crop'
            ],
            // Lait
            [
                'category_id' => $categories['lait'],
                'name' => 'Lait Frais de Vache (5L)',
                'slug' => 'lait-frais-vache-5l',
                'description' => 'Lait pur et naturel, trait le matin même. Sans conservateurs.',
                'price' => 3500,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1550583724-125581ff26b7?q=80&w=1200&auto=format&fit=crop'
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }

        // Produits supplémentaires
        $extras = [
            [
                'category_id' => $categories['poulets'] ?? 1,
                'name' => 'Pintade Locale (Plein air)',
                'slug' => 'pintade-locale-plein-air',
                'description' => 'Pintade savoureuse élevée traditionnellement. Idéal pour les repas de fête.',
                'price' => 6500,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1612170153139-6f881ff067e0?q=80&w=1200&auto=format&fit=crop'
            ],
            [
                'category_id' => $categories['lait'] ?? 4,
                'name' => 'Miel Bio de Casamance (1L)',
                'slug' => 'miel-bio-casamance-1l',
                'description' => 'Miel pure forêt de Casamance, riche en arômes et vertus naturelles.',
                'price' => 8000,
                'stock' => 100,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?q=80&w=1200&auto=format&fit=crop'
            ],
            [
                'category_id' => $categories['vaches'] ?? 2,
                'name' => 'Vache Laitière Montbéliarde',
                'slug' => 'vache-laitiere-montbeliarde',
                'description' => 'Excellente race pour la production de lait et de fromage de qualité.',
                'price' => 1200000,
                'stock' => 2,
                'image' => 'https://images.unsplash.com/photo-1547496502-affa22d38842?q=80&w=1200&auto=format&fit=crop'
            ]
        ];

        foreach ($extras as $extra) {
            Product::updateOrCreate(
                ['slug' => $extra['slug']],
                $extra
            );
        }
    }
}
