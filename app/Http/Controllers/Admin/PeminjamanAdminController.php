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
                    'title' => '🚗 ' . $item->nama_item,
                    'start' => $item->waktu_mulai->toIso8601String(),
                    'end'   => $item->waktu_selesai->toIso8601String(),
                    'backgroundColor' => '#0284c7', // Warna Biru khusus Mobil Dinas
                    // 💡 INJEKSI EXTENDED PROPS UNTUK TIPPY.JS
                    'extendedProps' => [
                        'keperluan' => $item->keperluan,
                        'user'      => $item->user->username ?? 'Tidak Diketahui'
                    ]
                ];
            });

        // 3. Ambil data RUANG yang disetujui untuk kalender
        $jadwalRuang = Peminjaman::where('status', 'disetujui')
            ->where('jenis_fasilitas', 'ruang')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => '🏢 ' . $item->nama_item,
                    'start' => $item->waktu_mulai->toIso8601String(),
                    'end'   => $item->waktu_selesai->toIso8601String(),
                    'backgroundColor' => '#d97706', // Warna Amber/Oranye khusus Ruang Rapat
                    // 💡 INJEKSI EXTENDED PROPS UNTUK TIPPY.JS
                    'extendedProps' => [
                        'keperluan' => $item->keperluan,
                        'user'      => $item->user->username ?? 'Tidak Diketahui'
                    ]
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

        // KIRIM NOTIFIKASI KE CUSTOMER YANG MENGAJUKAN
        $customer = User::find($peminjaman->user_id);
        if ($customer) {
            $customer->notify(new StatusPeminjamanDiperbarui($peminjaman));
        }

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui!');
    }
}