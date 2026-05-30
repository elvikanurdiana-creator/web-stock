@extends('layouts.customer')
@section('title', 'Dashboard Customer')

@section('content')
    <div class="space-y-8">
        {{-- CARD WELCOME --}}
        <div class="bg-linear-to-r from-bps-blue-dark to-bps-green rounded-2xl p-6 text-white shadow-sm">
            <p class="text-[#a7f3d0] text-sm font-medium">Selamat datang,</p>
            <h2 class="text-2xl font-bold mt-1">{{ session('auth_user.username') }} 👋</h2>
            <p class="text-[#bfdbfe] text-sm mt-1">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>

        {{-- 📦 SEKSI 1: REKAP PENGAJUAN BARANG/ASET --}}
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-1.5 h-4 rounded-full bg-bps-blue-dark inline-block"></span>
                <h3 class="text-sm font-bold text-bps-blue-dark uppercase tracking-wider">Rekap Pengajuan Barang</h3>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Total Pengajuan</p>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Menunggu</p>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-bps-green">{{ $stats['disetujui'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Disetujui</p>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-bps-red">{{ $stats['ditolak'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Ditolak</p>
                </div>
            </div>
        </div>

        {{-- 🚗 SEKSI 2: REKAP PEMINJAMAN FASILITAS (MOBIL & RUANG) --}}
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="w-1.5 h-4 rounded-full bg-bps-green inline-block"></span>
                <h3 class="text-sm font-bold text-bps-blue-dark uppercase tracking-wider">Rekap Peminjaman (Mobil & Ruang)</h3>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-gray-900">{{ $peminjamanStats['total'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Total Peminjaman</p>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-yellow-600">{{ $peminjamanStats['pending'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Menunggu</p>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-bps-green">{{ $peminjamanStats['disetujui'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Disetujui</p>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-3xl font-bold text-bps-red">{{ $peminjamanStats['ditolak'] }}</p>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Ditolak</p>
                </div>
            </div>
        </div>

        {{-- 🔗 TOMBOL MENU JALUR CEPAT (QUICK LINKS) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
            <a href="{{ route('customer.katalog.index') }}"
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-2xl bg-bps-blue/10 flex items-center justify-center group-hover:scale-105 transition">
                    <svg class="w-7 h-7 text-bps-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900 group-hover:text-bps-blue transition">Lihat Katalog</p>
                    <p class="text-sm text-gray-500">Cek barang yang tersedia</p>
                </div>
            </a>
            <a href="{{ route('customer.pengajuan.index') }}"
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-2xl bg-bps-green/10 flex items-center justify-center group-hover:scale-105 transition">
                    <svg class="w-7 h-7 text-bps-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-gray-900 group-hover:text-bps-green transition">Pengajuan Saya</p>
                    <p class="text-sm text-gray-500">Lacak status pengajuan</p>
                </div>
            </a>
        </div>
    </div>
@endsection