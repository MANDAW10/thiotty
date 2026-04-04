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
        User::create([
            'name' => 'Admin Thiotty',
            'email' => 'admin@thiotty.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Client Test',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);
    }
}
