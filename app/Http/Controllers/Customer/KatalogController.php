<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dari input bernama 'search'
        $search = $request->input('search');

        // Buat query dasar mengambil barang yang memiliki stok atau aktif
        $query = Barang::query();

        // Jika user mengisi kolom pencarian, filter berdasarkan nama barang
        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%');
        }

        // Ambil datanya (bisa pakai get() atau paginate() jika barangnya banyak)
        $barang = $query->latest()->paginate(12);

        // Kirim data barang beserta kata kunci pencarian kembali ke Blade
        return view('customer.katalog.index', compact('barang', 'search'));
    }
}