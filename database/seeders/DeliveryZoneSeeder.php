<?php

namespace Database\Seeders;

use App\Models\DeliveryZone;
use Illuminate\Database\Seeder;

class DeliveryZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            ['name' => 'Dakar (Standard)', 'fee' => 2000],
            ['name' => 'Dakar (Express)', 'fee' => 3500],
            ['name' => 'Thiès', 'fee' => 4500],
            ['name' => 'Mbour', 'fee' => 5000],
            ['name' => 'Rufisque', 'fee' => 2500],
            ['name' => 'Saint-Louis', 'fee' => 8000],
        ];

        foreach ($zones as $zone) {
            DeliveryZone::create($zone);
        }
    }
}
