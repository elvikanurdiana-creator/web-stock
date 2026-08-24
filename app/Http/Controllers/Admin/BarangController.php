<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $barang = $query->latest()->paginate(10)->withQueryString();

        return view('admin.barang.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stock'       => 'required|integer|min:1',
            'satuan'      => 'required|string|max:50',
        ]);

        $namaBarang = trim($request->nama_barang);
        $stokTambah = (int) $request->stock;

        // Cari barang berdasar nama (Case Insensitive)
        $existingBarang = Barang::whereRaw('LOWER(nama_barang) = ?', [strtolower($namaBarang)])->first();

        if ($existingBarang) {
            // Jika nama barang sudah ada, tambahkan stoknya
            $existingBarang->increment('stock', $stokTambah);
            
            return back()->with('success', "Stok barang '{$existingBarang->nama_barang}' berhasil ditambahkan.");
        }

        // Jika belum ada, buat barang baru (foto diupload terpisah via edit)
        Barang::create([
            'nama_barang' => $namaBarang,
            'stock'       => $stokTambah,
            'satuan'      => $request->satuan,
            'foto'        => null,
        ]);

        return back()->with('success', 'Barang baru berhasil ditambahkan.');
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only('nama_barang', 'stock', 'satuan');

        // Pengelolaan upload foto hanya di menu update/edit
        if ($request->hasFile('foto')) {
            if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
                Storage::disk('public')->delete($barang->foto);
            }

            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($data);

        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return back()->with('success', 'Barang berhasil dihapus.');
    }

    public function importExcel(Request $request) 
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Membaca isi file Excel
        $rows = \Maatwebsite\Excel\Facades\Excel::toArray(new \App\Imports\BarangImport, $request->file('file_excel'))[0] ?? [];

        foreach ($rows as $row) {
            $namaBarang = trim($row['nama_barang'] ?? $row['nama'] ?? '');
            $stokTambah = (int) ($row['stock'] ?? $row['stok'] ?? $row['jumlah'] ?? 0);
            $satuan     = $row['satuan'] ?? 'Pcs';

            if (empty($namaBarang)) {
                continue;
            }

            $barang = Barang::whereRaw('LOWER(nama_barang) = ?', [strtolower($namaBarang)])->first();

            if ($barang) {
                // Jika barang sudah ada, akumulasi stoknya
                $barang->increment('stock', $stokTambah);
            } else {
                // Jika belum ada, buat baru
                Barang::create([
                    'nama_barang' => $namaBarang,
                    'stock'       => $stokTambah,
                    'satuan'      => $satuan,
                    'foto'        => null,
                ]);
            }
        }

        return redirect()->route('admin.barang.index')->with('success', 'Data dari Excel berhasil diselaraskan ke dalam tabel barang!');
    }
}