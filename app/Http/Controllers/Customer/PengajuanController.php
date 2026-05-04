<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Riwayat;
use App\Models\TransaksiRequest;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuan = TransaksiRequest::with(['barang'])
            ->where('user_id', session('auth_user.id'))
            ->latest()
            ->paginate(10);

        return view('customer.pengajuan.index', compact('pengajuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah'    => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stock) {
            return back()->with('error', 'Jumlah melebihi stock yang tersedia.');
        }

        $transaksi = TransaksiRequest::create([
            'user_id'   => session('auth_user.id'),
            'barang_id' => $request->barang_id,
            'jumlah'    => $request->jumlah,
            'status'    => 'pending',
        ]);

        Riwayat::create([
            'transaksi_request_id' => $transaksi->id,
            'actor_id'             => session('auth_user.id'),
            'status_sebelumnya'    => null,
            'status_sesudah'       => 'pending',
            'catatan'              => 'Pengajuan dibuat',
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim.');
    }
}