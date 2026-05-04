@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-bps-blue to-bps-blue-light rounded-2xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#93c5fd] text-sm font-medium">Selamat datang kembali,</p>
                    <h2 class="text-2xl font-bold mt-1">{{ session('auth_user.username') }} 👋</h2>
                    <p class="text-[#bfdbfe] text-sm mt-1">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 rounded-2xl bg-white/10 flex items-center justify-center">
                        <svg class="w-10 h-10 text-bps-orange" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 3h4v8H3zm6-4h4v12H9zm6 2h4v10h-4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-bps-blue/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-bps-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-bps-blue bg-bps-blue/10 px-2.5 py-1 rounded-full">Total</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_barang'] }}</p>
                <p class="text-sm text-gray-500 mt-1 font-medium">Total Barang</p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-bps-green/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-bps-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-bps-green bg-bps-green/10 px-2.5 py-1 rounded-full">User</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                <p class="text-sm text-gray-500 mt-1 font-medium">Total Customer</p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span
                        class="text-xs font-semibold text-yellow-700 bg-yellow-100 px-2.5 py-1 rounded-full">Pending</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                <p class="text-sm text-gray-500 mt-1 font-medium">Menunggu Persetujuan</p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-bps-orange/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-bps-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-bps-orange bg-bps-orange/10 px-2.5 py-1 rounded-full">OK</span>
                </div>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['disetujui'] }}</p>
                <p class="text-sm text-gray-500 mt-1 font-medium">Transaksi Disetujui</p>
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-base font-bold text-gray-900 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('admin.barang.index') }}"
                    class="flex flex-col items-center gap-2 p-4 rounded-xl bg-bps-blue/5 hover:bg-bps-blue/10 transition group">
                    <svg class="w-7 h-7 text-bps-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="text-xs font-semibold text-bps-blue">Kelola Barang</span>
                </a>
                <a href="{{ route('admin.transaksi.index') }}"
                    class="flex flex-col items-center gap-2 p-4 rounded-xl bg-yellow-50 hover:bg-yellow-100 transition">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </a>
                <a href="{{ route('admin.manajemen-user.index') }}"
                    class="flex flex-col items-center gap-2 p-4 rounded-xl bg-bps-green/10 hover:bg-bps-green/20 transition">
                    <svg class="w-7 h-7 text-bps-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="text-xs font-semibold text-bps-green">Manajemen User</span>
                </a>
                <a href="{{ route('admin.transaksi.index') }}"
                    class="flex flex-col items-center gap-2 p-4 rounded-xl bg-bps-orange/10 hover:bg-bps-orange/20 transition">
                    <svg class="w-7 h-7 text-bps-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs font-semibold text-bps-orange">Approve Request</span>
                </a>
            </div>
        </div>
    </div>
@endsection
