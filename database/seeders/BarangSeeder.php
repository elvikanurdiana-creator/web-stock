<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuan = ['Rim', 'Box', 'Pcs', 'Pack', 'Unit'];
        $items = ['Kertas A4', 'Tinta Printer', 'Flashdisk', 'Mouse', 'Keyboard', 'Buku Agenda', 'Pulpen', 'Map Folder', 'Baterai', 'Webcam'];

        for ($i = 0; $i < 20; $i++) {
            \App\Models\Barang::create([
                'nama_barang' => fake()->randomElement($items) . ' ' . fake()->colorName(),
                'stock' => fake()->numberBetween(10, 100),
                'satuan' => fake()->randomElement($satuan),
            ]);
        }
    }
}
