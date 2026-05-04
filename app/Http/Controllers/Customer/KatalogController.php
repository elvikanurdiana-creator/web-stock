<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Barang;

class KatalogController extends Controller
{
    public function index()
    {
        $barang = Barang::where('stock', '>', 0)->latest()->paginate(12);
        return view('customer.katalog.index', compact('barang'));
    }
}