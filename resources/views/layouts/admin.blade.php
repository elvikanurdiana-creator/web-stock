<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — BPS Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-bps-gray font-[Plus_Jakarta_Sans] flex h-screen overflow-hidden">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
        class="w-64 bg-bps-blue-dark text-white flex flex-col flex-shrink-0 shadow-2xl transition-all duration-300">
        {{-- Brand --}}
        <div class="px-6 py-5 border-b border-bps-blue-light">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-bps-orange" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 3h4v8H3zm6-4h4v12H9zm6 2h4v10h-4zm-14 15h20v2H1z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-bold text-[#93c5fd] uppercase tracking-widest leading-none">BPS</p>
                    <p class="text-sm font-bold leading-tight">Inventaris</p>
                </div>
            </div>
        </div>

        {{-- Role Badge --}}
        <div class="px-6 py-3 bg-bps-orange/20 border-b border-bps-blue-light">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-bps-green animate-pulse"></div>
                <span class="text-xs font-semibold text-bps-orange uppercase tracking-wider">
                    {{ session('auth_user.role', 'User') }}
                </span>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <p class="text-xs font-bold text-[#93c5fd]/60 uppercase tracking-widest px-3 mb-3">Menu Utama</p>

            {{-- ─── MENU KHUSUS ADMIN ─── --}}
            @if(session('auth_user.role') === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 group {{ request()->routeIs('admin.dashboard') ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-sm font-semibold">Dashboard Admin</span>
                </a>

                <a href="{{ route('admin.barang.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.barang.*') ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="text-sm font-semibold">Manajemen Barang</span>
                </a>

                <a href="{{ route('admin.transaksi.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.transaksi.*') ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="text-sm font-semibold">Transaksi Barang</span>
                </a>

                {{-- 🆕 MENU BARU ADMIN: Approval Booking Mobil & Ruang --}}
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.peminjaman.*') ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-semibold">Persetujuan Peminjaman</span>
                </a>

                <a href="{{ route('admin.manajemen-user.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('admin.manajemen-user.*') ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="text-sm font-semibold">Manajemen User</span>
                </a>
            @endif

            {{-- ─── MENU KHUSUS CUSTOMER ─── --}}
            @if(session('auth_user.role') === 'customer')
                <a href="{{ route('customer.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('customer.dashboard') ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-sm font-semibold">Dashboard</span>
                </a>

                <a href="{{ route('customer.katalog.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('customer.katalog.*') ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    <span class="text-sm font-semibold">Katalog Barang</span>
                </a>

                <a href="{{ route('customer.pengajuan.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ request()->routeIs('customer.pengajuan.*') ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="text-sm font-semibold">Request Barang</span>
                </a>

                {{-- 🆕 MENU BARU CUSTOMER: Peminjaman Mobil --}}
                <a href="{{ route('customer.peminjaman.index', 'mobil') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ (request()->is('customer/peminjaman/mobil')) ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10M21 16v-4a2 2 0 00-2-2h-6M13 10h4l2 3h4" />
                    </svg>
                    <span class="text-sm font-semibold">Peminjaman Mobil</span>
                </a>

                {{-- 🆕 MENU BARU CUSTOMER: Peminjaman Ruang --}}
                <a href="{{ route('customer.peminjaman.index', 'ruang') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-150 {{ (request()->is('customer/peminjaman/ruang')) ? 'bg-[#f47920] text-white shadow-lg' : 'text-[#bfdbfe] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5" />
                    </svg>
                    <span class="text-sm font-semibold">Peminjaman Ruang</span>
                </a>
            @endif
        
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-bps-blue-light">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-[#bfdbfe] hover:bg-red-500/20 hover:text-red-300 transition-all cursor-pointer text-sm font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- NAVBAR --}}
        <header
            class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <button id="sidebarToggle" class="p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">