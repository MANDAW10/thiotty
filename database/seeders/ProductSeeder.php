<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

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
                'image' => 'https://images.unsplash.com/photo-1543160732-23700b1b13b1?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['vaches'],
                'name' => 'Vache Métisse Azawak',
                'slug' => 'vache-metisse-azawak',
                'description' => 'Vache métisse de haute qualité, excellente production laitière.',
                'price' => 850000,
                'stock' => 3,
                'image' => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?q=80&w=1200&auto=format&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1598974357801-cbca100e4811?q=80&w=1200&auto=format&fit=crop',
            ],
            // Poulets
            [
                'category_id' => $categories['poulets'],
                'name' => 'Lot de 50 Poussins de chair',
                'slug' => 'lot-50-poussins-goliath',
                'description' => 'Poussins de chair, croissance rapide et très résistants — équivalent qualité marché professionnel.',
                'price' => 32000,
                'sale_price' => 28000,
                'stock' => 20,
                'image' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['poulets'],
                'name' => 'Poulet de Chair (Prêt à cuire)',
                'slug' => 'poulet-chair-pret',
                'description' => 'Poulet bio élevé en plein air, abattu et nettoyé. Poids moyen 1.8kg.',
                'price' => 4500,
                'stock' => 100,
                'image' => 'https://images.unsplash.com/photo-1569337776101-921350a4d53c?q=80&w=1200&auto=format&fit=crop',
            ],
            // Aliments
            [
                'category_id' => $categories['aliments'],
                'name' => 'Sac Aliment Bétail (50kg)',
                'slug' => 'sac-aliment-betail-50kg',
                'description' => 'Mélange nutritif complet pour bovins et ovins. Favorise la croissance et l\'engraissement.',
                'price' => 14500,
                'stock' => 200,
                'image' => 'https://images.unsplash.com/photo-1582560475093-ba66accbc424?q=80&w=1200&auto=format&fit=crop',
            ],
            // Lait
            [
                'category_id' => $categories['lait'],
                'name' => 'Lait Frais de Vache (5L)',
                'slug' => 'lait-frais-vache-5l',
                'description' => 'Lait pur et naturel, trait le matin même. Sans conservateurs.',
                'price' => 3500,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1550583724-125581ff26b7?q=80&w=1200&auto=format&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1612170153139-6f881ff067e0?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['lait'] ?? 4,
                'name' => 'Miel Bio de Casamance (1L)',
                'slug' => 'miel-bio-casamance-1l',
                'description' => 'Miel pure forêt de Casamance, riche en arômes et vertus naturelles.',
                'price' => 8000,
                'stock' => 100,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['vaches'] ?? 2,
                'name' => 'Vache Laitière Montbéliarde',
                'slug' => 'vache-laitiere-montbeliarde',
                'description' => 'Excellente race pour la production de lait et de fromage de qualité.',
                'price' => 1200000,
                'stock' => 2,
                'image' => 'https://images.unsplash.com/photo-1547496502-affa22d38842?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['aliments'] ?? 1,
                'name' => 'Ensilage de qualité (balles)',
                'slug' => 'ensilage-de-qualite',
                'description' => 'Fourrage fermenté haute valeur énergétique pour ruminants.',
                'price' => 125000,
                'stock' => 40,
                'is_featured' => true,
                'image' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['vaches'] ?? 2,
                'name' => 'Génisse Jersey femelle',
                'slug' => 'genisse-jersey-femelle',
                'description' => 'Jeune femelle Jersey, race laitière reconnue.',
                'price' => 3000000,
                'stock' => 1,
                'image' => 'https://images.unsplash.com/photo-1563911305907-b759d2b86604?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['vaches'] ?? 2,
                'name' => 'Mâle Holstein',
                'slug' => 'male-holstein',
                'description' => 'Jeune mâle Holstein sélectionné.',
                'price' => 1800000,
                'stock' => 2,
                'image' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['vaches'] ?? 2,
                'name' => 'Jersey nouveau-né',
                'slug' => 'jersey-nouveau-ne',
                'description' => 'Veau Jersey, suivi sanitaire rigoureux.',
                'price' => 300000,
                'stock' => 4,
                'image' => 'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['poulets'] ?? 1,
                'name' => 'Pigeon fermier',
                'slug' => 'pigeon-fermier',
                'description' => 'Pigeons élevés en volière, chair fine.',
                'price' => 2500,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1552728089-57bdde30beb3?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['chevaux'] ?? 2,
                'name' => 'Mouton / Brebis locale',
                'slug' => 'mouton-brebis-locale',
                'description' => 'Petit ruminant pour viande ou reproduction.',
                'price' => 185000,
                'stock' => 8,
                'image' => 'https://images.unsplash.com/photo-1484557985045-edf745e49ea4?q=80&w=1200&auto=format&fit=crop',
            ],
            [
                'category_id' => $categories['poulets'] ?? 1,
                'name' => 'Viande de bœuf (kg)',
                'slug' => 'viande-de-boeuf-kg',
                'description' => 'Viande fraîche découpée, origine contrôlée.',
                'price' => 5000,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1607623814075-e41dfee430ef?q=80&w=1200&auto=format&fit=crop',
            ],
        ];

        foreach ($extras as $extra) {
            Product::updateOrCreate(
                ['slug' => $extra['slug']],
                $extra
            );
        }
    }
}
