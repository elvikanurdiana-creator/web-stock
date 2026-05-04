<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransaksiRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $users = \App\Models\User::where('role', 'customer')->pluck('id')->toArray();
    $barangs = \App\Models\Barang::all();

    for ($i = 0; $i < 20; $i++) {
        $status = fake()->randomElement(['pending', 'disetujui', 'ditolak']);
        
        \App\Models\TransaksiRequest::create([
            'user_id' => fake()->randomElement($users),
            'barang_id' => $barangs->random()->id,
            'jumlah' => fake()->numberBetween(1, 5),
            'status' => $status,
            'alasan' => $status === 'ditolak' ? 'Stok sedang dialokasikan untuk divisi lain' : null,
        ]);
    }
}
}
