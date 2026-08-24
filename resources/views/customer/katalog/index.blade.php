@extends('layouts.customer')
@section('title', 'Katalog Barang')

@section('content')
    <div class="space-y-6">
        {{-- HEADER BARIS UTAMA --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-bps-blue/10 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-bps-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-semibold tracking-tight text-gray-900">Katalog Barang Tersedia</h2>
                    <p class="text-sm text-gray-500">Pilih dan tambahkan barang ke dalam kelompok pengajuanmu.</p>
                </div>
            </div>

            <a href="{{ route('customer.keranjang.index') }}" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition shadow-[0_8px_24px_-12px_rgba(0,61,130,0.8)]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Lihat Keranjang
                @if(session('keranjang') && count(session('keranjang')) > 0)
                    <span class="bg-white text-bps-blue-dark text-[11px] px-2 py-0.5 rounded-full font-bold ml-1 shadow-sm">
                        {{ count(session('keranjang')) }}
                    </span>
                @endif
            </a>
        </div>

        {{-- FORM PENCARIAN --}}
        <div class="flex justify-end mb-6">
            <form action="{{ route('customer.katalog.index') }}" method="GET" class="w-full md:w-80 flex gap-2">
                <div class="relative w-full">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama barang..." 
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-bps-blue/30 focus:border-bps-blue">

                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-bps-blue to-bps-blue-dark text-white text-sm font-semibold hover:from-bps-blue-dark hover:to-bps-blue transition cursor-pointer shadow-[0_8px_24px_-12px_rgba(0,61,130,0.8)]">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('customer.katalog.index') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-slate-500 text-sm hover:bg-slate-50 flex items-center justify-center" title="Reset Pencarian">
                        ✕
                    </a>
                @endif
            </form>
        </div>

        {{-- GRID KATALOG BARANG --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @forelse($barang as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:-translate-y-1 hover:shadow-lg transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        {{-- 🖼️ FOTO BARANG (UKURAN LEBIH PROPORSI) --}}
                        <div class="relative w-full h-32 bg-slate-100 border-b border-slate-100 overflow-hidden">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x300?text=No+Image' }}" 
                            alt="{{ $item->nama_barang }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            {{-- Badge Stok --}}
                            <div class="absolute top-2.5 right-2.5">
                                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-sm backdrop-blur-md {{ $item->stock > 10 ? 'bg-emerald-500/90 text-white' : 'bg-amber-500/90 text-white' }}">
                                    Stok: {{ $item->stock }} {{ $item->satuan }}
                                </span>
                            </div>
                        </div>

                        {{-- NAMA BARANG --}}
                        <div class="p-4">
                            <h3 class="text-sm font-semibold tracking-tight text-gray-900 line-clamp-2 min-h-[2.5rem]" title="{{ $item->nama_barang }}">
                                {{ $item->nama_barang }}
                            </h3>
                        </div>
                    </div>

                    {{-- TOMBOL TAMBAH --}}
                    <div class="p-4 pt-0">
                        <button
                            onclick="openAjukanModal('{{ $item->id }}', '{{ addslashes($item->nama_barang) }}', {{ $item->stock }}, '{{ $item->satuan }}', '{{ $item->foto_url }}')"
                            class="w-full bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white py-2 rounded-xl text-xs font-bold transition cursor-pointer shadow-sm">
                            + Tambah ke Keranjang
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-12 text-gray-400">Belum ada barang tersedia.</div>
            @endforelse
        </div>

        @if ($barang->hasPages())
            <div class="flex justify-center mt-6">{{ $barang->links() }}</div>
        @endif
    </div>

    {{-- MODAL MASUKKAN KERANJANG --}}
    <div id="modalAjukan" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 backdrop-blur-xs">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900">Masukkan ke Keranjang</h3>
                <button onclick="document.getElementById('modalAjukan').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="formAjukan" method="POST" class="space-y-4">
                @csrf
                {{-- Detail barang dalam modal --}}
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-4">
                    <img id="ajukanFoto" src="" class="w-14 h-14 rounded-xl object-cover border border-slate-200 flex-shrink-0 shadow-sm">
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Barang Dipilih</p>
                        <p id="ajukanNama" class="font-bold text-slate-900 text-sm truncate"></p>
                        <p id="ajukanStock" class="text-xs text-emerald-600 font-semibold mt-0.5"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah yang Diminta</label>
                    <input type="number" id="ajukanJumlah" name="jumlah" min="1" value="1" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue">
                </div>
                
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modalAjukan').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-slate-50 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-bps-blue text-white text-sm font-semibold hover:bg-bps-blue-dark transition cursor-pointer shadow-md">Masukkan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAjukanModal(id, nama, stock, satuan, fotoUrl) {
            let url = "{{ route('customer.keranjang.add', ':id') }}";
            url = url.replace(':id', id);
            document.getElementById('formAjukan').action = url;

            document.getElementById('ajukanNama').textContent = nama;
            document.getElementById('ajukanFoto').src = fotoUrl;
            document.getElementById('ajukanStock').textContent = `Stok tersedia: ${stock} ${satuan}`;
            document.getElementById('ajukanJumlah').max = stock;
            document.getElementById('modalAjukan').classList.remove('hidden');
        }
    </script>
@endsection