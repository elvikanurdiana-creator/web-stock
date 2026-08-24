@extends('layouts.admin')
@section('title', 'Manajemen Barang')

@section('content')
    <div class="space-y-6">
        {{-- HEADER BARIS UTAMA --}}
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold tracking-tight text-slate-800">Daftar Barang</h2>
                <p class="text-xs text-slate-400 mt-0.5">Manajemen stok logistik dan persediaan kantor</p>
            </div>

            {{-- KELOMPOK AKSI KANAN (CARI, IMPOR EXCEL, & TAMBAH BARANG) --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                {{-- Form Pencarian --}}
                <form action="{{ route('admin.barang.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                    <div class="relative w-full sm:w-60">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Cari nama barang..." 
                            class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 text-xs focus:outline-none focus:ring-2 focus:ring-bps-blue">
                        
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-bps-blue to-bps-blue-dark text-white px-3.5 py-2 rounded-xl text-xs font-bold transition shadow-sm hover:shadow cursor-pointer uppercase tracking-wider">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.barang.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-slate-500 text-xs hover:bg-slate-50 flex items-center justify-center font-bold" title="Reset">
                            ✕
                        </a>
                    @endif
                </form>

                {{-- Form Impor Excel --}}
                <form action="{{ route('admin.barang.import') }}" method="POST" enctype="multipart/form-data" 
                    class="flex items-center gap-2 bg-white p-1.5 pl-3 pr-1.5 rounded-xl border border-orange-100/70 shadow-sm w-full sm:w-auto">
                    @csrf
                    <input type="file" name="file_excel" required 
                        class="block w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-orange-50 file:text-bps-orange hover:file:bg-orange-100 cursor-pointer focus:outline-none" />
                
                    <button type="submit" 
                        class="bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white text-[11px] font-bold py-2 px-3 rounded-lg shadow-sm hover:shadow transition-all cursor-pointer whitespace-nowrap uppercase tracking-wider">
                        Impor
                    </button>
                </form>

                {{-- Tombol Tambah Barang Manual --}}
                <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-sm hover:shadow-md cursor-pointer whitespace-nowrap uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Manual
                </button>
            </div>
        </div>

        {{-- TABEL DAFTAR BARANG --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-bps-blue/5 border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue uppercase tracking-wider">No</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue uppercase tracking-wider">Foto</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue uppercase tracking-wider">Nama Barang</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue uppercase tracking-wider">Stock</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue uppercase tracking-wider">Satuan</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($barang as $i => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $barang->firstItem() + $i }}</td>
                                
                                {{-- FOTO BARANG --}}
                                <td class="px-6 py-4">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 flex-shrink-0 flex items-center justify-center">
                                        <img src="{{ $item->foto_url }}" alt="{{ $item->nama_barang }}" class="w-full h-full object-cover">
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm font-bold {{ $item->stock < 5 ? 'text-red-600' : 'text-bps-green' }}">
                                        {{ $item->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->satuan }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <button
                                            onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->nama_barang) }}', {{ $item->stock }}, '{{ $item->satuan }}', '{{ $item->foto_url }}')"
                                            class="p-1.5 rounded-lg bg-bps-blue/10 text-bps-blue hover:bg-bps-blue/20 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('admin.barang.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Hapus barang ini beserta fotonya?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-1.5 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition cursor-pointer">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-sm">Belum ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($barang->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $barang->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL TAMBAH BARANG --}}
    <div id="modalTambah" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900">Tambah Barang</h3>
                <button onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Barang</label>
                    <input type="text" name="nama_barang" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue">
                </div>

                {{-- Input Foto Barang --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Barang (Auto Kompres)</label>
                    <input type="file" name="foto" accept="image/*" onchange="autoCompressImage(this)"
                        class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-bps-blue/10 file:text-bps-blue hover:file:bg-bps-blue/20 cursor-pointer" />
                    <span id="compressStatusTambah" class="text-[11px] text-bps-blue mt-1 block font-medium"></span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stock</label>
                        <input type="number" name="stock" min="0" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Satuan</label>
                        <input type="text" name="satuan" placeholder="pcs, unit, dll" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue">
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-bps-blue to-bps-blue-dark text-white text-sm font-semibold hover:from-bps-blue-dark hover:to-bps-blue transition cursor-pointer">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT BARANG --}}
    <div id="modalEdit" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900">Edit Barang</h3>
                <button onclick="document.getElementById('modalEdit').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="formEdit" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Barang</label>
                    <input type="text" id="editNama" name="nama_barang" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue">
                </div>

                {{-- Input Pratinjau & Ubah Foto --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Ganti Foto Barang (Auto Kompres)</label>
                    <div class="flex items-center gap-3 mb-2">
                        <img id="editPreviewFoto" src="" class="w-12 h-12 rounded-xl object-cover border border-gray-200">
                        <span class="text-xs text-gray-400">Foto saat ini</span>
                    </div>
                    <input type="file" name="foto" accept="image/*" onchange="autoCompressImage(this)"
                        class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-bps-blue/10 file:text-bps-blue hover:file:bg-bps-blue/20 cursor-pointer" />
                    <span id="compressStatusEdit" class="text-[11px] text-bps-blue mt-1 block font-medium"></span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stock</label>
                        <input type="number" id="editStock" name="stock" min="0" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Satuan</label>
                        <input type="text" id="editSatuan" name="satuan" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue">
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-bps-orange text-white text-sm font-semibold hover:bg-bps-orange-dark transition cursor-pointer">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, nama, stock, satuan, fotoUrl) {
            document.getElementById('formEdit').action = `/admin/barang/${id}`;
            document.getElementById('editNama').value = nama;
            document.getElementById('editStock').value = stock;
            document.getElementById('editSatuan').value = satuan;
            document.getElementById('editPreviewFoto').src = fotoUrl;
            document.getElementById('modalEdit').classList.remove('hidden');
        }

        // FUNGSI KOMPRES GAMBAR OTOMATIS DI BROWSER
        function autoCompressImage(input) {
            const file = input.files[0];
            if (!file) return;

            const originalMB = (file.size / 1024 / 1024).toFixed(2);
            
            // Pilih elemen status
            const statusElem = input.nextElementSibling;
            statusElem.innerText = `Mengompresi gambar (${originalMB} MB)...`;

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;
                img.onload = function () {
                    // Maksimal dimensi (misal max lebar/tinggi 1000px - sangat cukup untuk foto produk)
                    const maxDimension = 1000;
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > maxDimension) {
                            height = Math.round((height *= maxDimension / width));
                            width = maxDimension;
                        }
                    } else {
                        if (height > maxDimension) {
                            width = Math.round((width *= maxDimension / height));
                            height = maxDimension;
                        }
                    }

                    // Gambar ke Canvas
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    // Konversi ke File Blob (Kualitas 0.7 = 70%)
                    canvas.toBlob(function (blob) {
                        const compressedMB = (blob.size / 1024 / 1024).toFixed(2);
                        
                        // Buat file baru dari blob terkompresi
                        const compressedFile = new File([blob], file.name, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });

                        // Timpa input file dengan file baru yang sudah terkompresi
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        input.files = dataTransfer.files;

                        statusElem.innerText = `✓ Foto berhasil dikompresi: ${originalMB} MB ➔ ${compressedMB} MB`;
                    }, 'image/jpeg', 0.7);
                };
            };
        }
    </script>
@endsection