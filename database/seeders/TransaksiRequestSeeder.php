<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Barang; // Sesuaikan dengan nama Model Barang kamu (Barang / Barangs)
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransaksiRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil contoh 1 user dan 1 barang dummy yang sudah dibuat seeder sebelumnya
        $user = DB::table('users')->first();
        $barang = DB::table('barang')->first();

        if ($user && $barang) {
            // 1. Buat ID UUID manual untuk transaksi induk
            $transaksiId = (string) Str::uuid();

            // 2. Insert ke tabel Induk (transaksi_requests)
            DB::table('transaksi_requests')->insert([
                'id' => $transaksiId,
                'user_id' => $user->id,
                'status' => 'pending',
                'alasan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Insert ke tabel Anak/Detail (transaksi_request_details)
            DB::table('transaksi_request_details')->insert([
                'transaksi_request_id' => $transaksiId, // Menyambung ke UUID di atas
                'barang_id' => $barang->id,
                'jumlah_diminta' => 3,
                'jumlah_disetujui' => null,
                'status_item' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}