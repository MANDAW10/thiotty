<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@thiotty.com'],
            [
                'name' => 'Admin Thiotty',
                'password' => Hash::make('thiotty2026'),
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@test.com'],
            [
                'name' => 'Client Test',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );
    }
}
