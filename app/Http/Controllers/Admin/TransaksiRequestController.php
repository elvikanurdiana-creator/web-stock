<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Riwayat;
use App\Models\TransaksiRequest;
use Illuminate\Http\Request;

class TransaksiRequestController extends Controller
{
    public function index()
    {
        $transaksi = TransaksiRequest::with(['user', 'barang'])->latest()->paginate(10);
        return view('admin.transaksi.index', compact('transaksi'));
    }

    public function updateStatus(Request $request, TransaksiRequest $transaksi)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'alasan' => 'nullable|string|max:500',
        ]);

        $statusSebelumnya = $transaksi->status;

        $transaksi->update([
            'status' => $request->status,
            'alasan' => $request->alasan,
        ]);

        // If approved, reduce stock
        if ($request->status === 'disetujui') {
            $transaksi->barang->decrement('stock', $transaksi->jumlah);
        }

        // Log to riwayat
        Riwayat::create([
            'transaksi_request_id' => $transaksi->id,
            'actor_id'             => session('auth_user.id'),
            'status_sebelumnya'    => $statusSebelumnya,
            'status_sesudah'       => $request->status,
            'catatan'              => $request->alasan,
        ]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}