<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slide;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slides = [
            [
                'image' => 'https://images.unsplash.com/photo-1547496502-affa22d38842?q=80&w=2600&auto=format&fit=crop',
                'title' => 'L\'Excellence Bovine',
                'subtitle' => 'Élevage de vaches laitières et de boucherie au Sénégal',
                'button_text' => 'Voir Boutique',
                'button_url' => '/shop',
                'order_priority' => 1
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1484557985045-edf745e49ea4?q=80&w=2600&auto=format&fit=crop',
                'title' => 'Élevage Ovin Premium',
                'subtitle' => 'Moutons et chèvres élevés dans le respect des traditions',
                'button_text' => 'Voir Boutique',
                'button_url' => '/shop',
                'order_priority' => 2
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1587593810167-a84920ea0831?q=80&w=2000&auto=format&fit=crop',
                'title' => 'Fermes Avicoles Modernes',
                'subtitle' => 'Production avicole de pointe pour une qualité irréprochable',
                'button_text' => 'Voir Boutique',
                'button_url' => '/shop',
                'order_priority' => 3
            ]
        ];

        foreach ($slides as $slide) {
            Slide::updateOrCreate(['image' => $slide['image']], $slide);
        }
    }
}
