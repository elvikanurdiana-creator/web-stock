@extends('layouts.customer')
@section('title', 'Sistem Pengajuan Barang')

@section('content')
<div class="space-y-6" x-data="{ activeTab: '{{ request('tab', 'keranjang') }}' }">
    <div>
        <h2 class="text-xl font-semibold tracking-tight text-gray-900">Sistem Pengajuan Barang Kelompok</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola barang yang akan diajukan secara kolektif.</p>
    </div>

    <div class="border-b border-gray-200">
        <nav class="flex space-x-4" aria-label="Tabs">
            <button 
                @click="activeTab = 'keranjang'"
                :class="activeTab === 'keranjang' ? 'border-bps-blue text-bps-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2 cursor-pointer">
                🛒 Keranjang Saya 
                <span :class="activeTab === 'keranjang' ? 'bg-bps-blue text-white' : 'bg-gray-100 text-gray-900'" class="ml-1 px-2.5 py-0.5 rounded-full text-xs font-bold">
                    {{ count($keranjang) }}
                </span>
            </button>
            <button 
                @click="activeTab = 'riwayat'"
                :class="activeTab === 'riwayat' ? 'border-bps-blue text-bps-blue' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2 cursor-pointer">
                📜 Riwayat Pengajuan Kelompok
            </button>
        </nav>
    </div>

    <div>
        {{-- TAB 1: KERANJANG --}}
        <div x-show="activeTab === 'keranjang'" class="space-y-4">
            @if(count($keranjang) > 0)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Barang</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Satuan</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Jumlah Diminta</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($keranjang as $id => $item)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-gray-900">{{ $item['nama_barang'] }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $item['satuan'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route('customer.keranjang.update', $id) }}" method="POST" id="form-update-{{ $id }}" onsubmit="return false;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1" 
                                                    onchange="document.getElementById('form-update-{{ $id }}').submit()"
                                                    onkeydown="if(event.key === 'Enter') { this.blur(); return false; }"
                                                    class="w-20 px-3 py-1.5 rounded-xl border border-gray-200 text-center text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue/30 focus:border-bps-blue">
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('customer.keranjang.delete', $id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold cursor-pointer flex items-center gap-1 ml-auto">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex justify-end border-t border-gray-100">
                        <form action="{{ route('customer.keranjang.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white px-6 py-3 rounded-xl text-sm font-semibold transition shadow-[0_8px_24px_-12px_rgba(0,61,130,0.8)] cursor-pointer">
                                🚀 Kirim Pengajuan Kelompok Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="text-center py-16 bg-white border border-gray-100 rounded-2xl shadow-sm space-y-4">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h4 class="text-base font-bold text-gray-500">Keranjang belanjamu kosong</h4>
                    <a href="{{ route('customer.katalog.index') }}" class="inline-flex items-center justify-center bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white px-4 py-2 rounded-xl text-sm font-semibold transition cursor-pointer shadow-[0_8px_24px_-12px_rgba(0,61,130,0.8)]">
                        Lihat Katalog Barang
                    </a>
                </div>
            @endif
        </div>

        {{-- TAB 2: RIWAYAT PENGAJUAN --}}
<div x-show="activeTab === 'riwayat'" class="space-y-4" style="display: none;">
    @if(count($riwayat) > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-36">Tanggal</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Detail Item Barang</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Status Induk</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Catatan Admin</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($riwayat as $item)
                            <tr class="hover:bg-gray-50/50 transition align-top">
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <div class="space-y-2">
                                        @foreach($item->details as $detail)
                                            <div class="flex items-center justify-between border-b border-gray-50 pb-1.5 last:border-0 last:pb-0">
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-gray-900">x{{ $detail->jumlah_diminta }}</span>
                                                    <span class="text-gray-700">{{ $detail->barang->nama_barang ?? 'Barang Dihapus' }}</span>
                                                </div>
                                                <span class="px-2 py-0.5 text-[11px] font-bold rounded-md
                                                    {{ $detail->status_item === 'Disetujui' ? 'bg-green-50 text-green-700 border border-green-100' : ($detail->status_item === 'Ditolak' ? 'bg-red-50 text-red-700 border border-red-100' : 'bg-gray-50 text-gray-600') }}">
                                                    {{ $detail->status_item ?? 'Pending' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'disetujui' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $colors[$item->status] ?? '' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 italic">
                                    {{ $item->alasan ?? '-' }}
                                </td>
                                
                                {{-- KOLOM AKSI CETAK PDF DENGAN VALIDASI STATUS --}}
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($item->status === 'disetujui')
                                        <a href="{{ route('customer.pengajuan.cetak-pdf', $item->id) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 text-xs font-bold transition shadow-xs">
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Cetak PDF
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum Di-ACC</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white border border-gray-100 rounded-2xl shadow-sm space-y-4">
            <h4 class="text-base font-bold text-gray-500">Belum ada riwayat pengajuan</h4>
        </div>
    @endif
</div>
@endsection