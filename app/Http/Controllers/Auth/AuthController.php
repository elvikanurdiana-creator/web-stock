<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Peminjaman; // <--- Memastikan model ini yang dipakai secara konsisten

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('auth_user')) {
            return $this->redirectByRole(session('auth_user.role'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username atau Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('username', $request->username)
                    ->orWhere('email', $request->username)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username' => 'Username/Email atau password salah.'
            ])->withInput();
        }

        session([
            'auth_user' => [
                'id'       => $user->id,
                'username' => $user->username,
                'role'     => $user->role,
            ]
        ]);

        return $this->redirectByRole($user->role);
    }

    public function logout(Request $request)
    {
        // Bersihkan session kustom
        $request->session()->forget('auth_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'customer' => redirect()->route('customer.dashboard'),
            default    => redirect()->route('login'),
        };
    }

    // Method untuk menampilkan halaman depan publik berisi Kalender
    public function showLanding()
    {
        // 1. Ambil jadwal MOBIL yang sudah disetujui admin menggunakan model Peminjaman
        $jadwalMobil = Peminjaman::where('jenis_fasilitas', 'mobil')
            ->where('status', 'disetujui')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => '🚗 ' . $item->nama_item . ' (' . ($item->user->username ?? 'User') . ')',
                    'start' => $item->waktu_mulai->toIso8601String(),
                    'end' => $item->waktu_selesai->toIso8601String(),
                    'backgroundColor' => '#0284c7', // Warna sky blue
                    'extendedProps' => [
                        'keperluan' => $item->keperluan,
                        'user' => $item->user->username ?? 'Tidak Diketahui'
                    ]
                ];
            });

        // 2. Ambil jadwal RUANG yang sudah disetujui admin menggunakan model Peminjaman
        $jadwalRuang = Peminjaman::where('jenis_fasilitas', 'ruang')
            ->where('status', 'disetujui')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => '🏢 ' . $item->nama_item . ' (' . ($item->user->username ?? 'User') . ')',
                    'start' => $item->waktu_mulai->toIso8601String(),
                    'end' => $item->waktu_selesai->toIso8601String(),
                    'backgroundColor' => '#d97706', // Warna amber
                    'extendedProps' => [
                        'keperluan' => $item->keperluan,
                        'user' => $item->user->username ?? 'Tidak Diketahui'
                    ]
                ];
            });

        // Return ke file blade halaman depan (welcome)
        return view('welcome', compact('jadwalMobil', 'jadwalRuang'));
    }
}