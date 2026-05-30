<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Notifications\StatusPeminjamanDiperbarui;
use App\Models\User;

class PeminjamanAdminController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data peminjaman untuk dibaca oleh @forelse($peminjaman as $item) di tabel
        $peminjaman = Peminjaman::with('user')->latest()->get();

        // 2. Ambil data MOBIL yang disetujui untuk kalender
        $jadwalMobil = Peminjaman::where('status', 'disetujui')
            ->where('jenis_fasilitas', 'mobil')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => '[Mobil] ' . $item->nama_item . ' (' . ($item->user->username ?? 'User') . ')',
                    'start' => $item->waktu_mulai->format('Y-m-d\TH:i:s'),
                    'end'   => $item->waktu_selesai->format('Y-m-d\TH:i:s'),
                    'color' => '#0284c7', // Warna Biru khusus Mobil Dinas
                ];
            });

        // 3. Ambil data RUANG yang disetujui untuk kalender
        $jadwalRuang = Peminjaman::where('status', 'disetujui')
            ->where('jenis_fasilitas', 'ruang')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => '[Ruang] ' . $item->nama_item . ' (' . ($item->user->username ?? 'User') . ')',
                    'start' => $item->waktu_mulai->format('Y-m-d\TH:i:s'),
                    'end'   => $item->waktu_selesai->format('Y-m-d\TH:i:s'),
                    'color' => '#f59e0b', // Warna Amber/Oranye khusus Ruang Rapat
                ];
            });

        // Lempar variabel tabel ($peminjaman) dan variabel kalender ($jadwalMobil, $jadwalRuang) ke view admin
        return view('admin.peminjaman.index', compact('peminjaman', 'jadwalMobil', 'jadwalRuang'));
    }

    public function updateStatus(Request $request, $id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->update([
        'status' => $request->status
    ]);

    // 💡 KIRIM NOTIFIKASI KE CUSTOMER YANG MENGAJUKAN
    // Mengambil objek user berdasarkan user_id di data peminjaman
    $customer = User::find($peminjaman->user_id);
    if ($customer) {
        $customer->notify(new StatusPeminjamanDiperbarui($peminjaman));
    }

    return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui!');
}
}