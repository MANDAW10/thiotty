<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DeliveryZone;
use App\Models\GalleryItem;
use App\Models\Broadcast;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminExpansionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delivery Zones
        DeliveryZone::create(['name' => 'Dakar Ville', 'fee' => 1500]);
        DeliveryZone::create(['name' => 'Mbour', 'fee' => 3000]);
        DeliveryZone::create(['name' => 'Thiès', 'fee' => 2500]);
        DeliveryZone::create(['name' => 'Saint-Louis', 'fee' => 5000]);

        // Gallery Items
        GalleryItem::create([
            'image' => 'https://images.unsplash.com/photo-1549468057-5b64363bb770?q=80&w=800&auto=format&fit=crop',
            'title' => 'Authenticité Sahélienne',
            'description' => 'Une rigueur inégalée dans le choix de nos produits.',
            'category' => 'Terroir'
        ]);
        GalleryItem::create([
            'image' => 'https://images.unsplash.com/photo-1596733430284-f7437764b1a9?q=80&w=800&auto=format&fit=crop',
            'title' => 'Bien-être Animal',
            'description' => 'Nos élevages sont conduits selon des normes d\'excellence.',
            'category' => 'Elevage'
        ]);
        GalleryItem::create([
            'image' => 'https://images.unsplash.com/photo-1481142889578-df45d4f45112?q=80&w=800&auto=format&fit=crop',
            'title' => 'Richesse Laitière',
            'description' => 'Un lait pur, frais et nutritif pour nos clients.',
            'category' => 'Qualité'
        ]);

        // Broadcasts
        Broadcast::create([
            'title' => 'Livraison Rapide',
            'message' => 'Profitez de la livraison gratuite à Dakar pour toute commande > 50 000 CFA !',
            'type' => 'info',
            'is_active' => true
        ]);
    }
}
