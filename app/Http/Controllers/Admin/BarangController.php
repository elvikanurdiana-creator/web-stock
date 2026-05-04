<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::latest()->paginate(10);
        return view('admin.barang.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
        ]);

        Barang::create($request->only('nama_barang', 'stock', 'satuan'));
        return back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stock'       => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
        ]);

        $barang->update($request->only('nama_barang', 'stock', 'satuan'));
        return back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus.');
    }
}