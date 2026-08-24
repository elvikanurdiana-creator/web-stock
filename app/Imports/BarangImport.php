<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari apakah barang dengan nama tersebut sudah ada
        $barangLama = Barang::where('nama_barang', $row['nama_barang'])->first();

        if ($barangLama) {
            // Jika ada, tambahkan stok lama dengan jumlah baru dari Excel
            $barangLama->update([
                'stock' => $barangLama->stock + $row['jumlah']
            ]);
            return null; 
        }

        // Jika belum ada, buat data baru
        return new Barang([
            'nama_barang' => $row['nama_barang'],
            'satuan'      => $row['satuan'],
            'stock'       => $row['jumlah'],
        ]);
    }
}