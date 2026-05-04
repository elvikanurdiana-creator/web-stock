<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan namespace ini

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1 Admin
        \App\Models\User::create([
            'username' => 'admin_stok',
            'name' => 'Admin Gudang',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'), // Menggunakan Hash::make
            'role' => 'admin',
        ]);

        // 19 Customers
        for ($i = 1; $i <= 19; $i++) {
            \App\Models\User::create([
                'username' => 'user' . $i,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'), // Menggunakan Hash::make
                'role' => 'customer',
            ]);
        }
    }
}