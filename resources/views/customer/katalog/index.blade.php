@extends('layouts.customer')
@section('title', 'Katalog Barang')

@section('content')
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-900">Katalog Barang Tersedia</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($barang as $item)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-bps-blue/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-bps-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span
                            class="text-xs font-bold px-2.5 py-1 rounded-full {{ $item->stock > 10 ? 'bg-bps-green/10 text-bps-green' : 'bg-bps-orange/10 text-bps-orange' }}">
                            Stock: {{ $item->stock }} {{ $item->satuan }}
                        </span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-4">{{ $item->nama_barang }}</h3>

                    <button
                        onclick="openAjukanModal('{{ $item->id }}', '{{ $item->nama_barang }}', {{ $item->stock }}, '{{ $item->satuan }}')"
                        class="w-full bg-bps-blue hover:bg-bps-blue-dark text-white py-2.5 rounded-xl text-sm font-semibold transition cursor-pointer">
                        Ajukan Permintaan
                    </button>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-400">Belum ada barang tersedia.</div>
            @endforelse
        </div>

        @if ($barang->hasPages())
            <div class="flex justify-center">{{ $barang->links() }}</div>
        @endif
    </div>

    {{-- Modal Ajukan --}}
    <div id="modalAjukan" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900">Ajukan Permintaan</h3>
                <button onclick="document.getElementById('modalAjukan').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form action="{{ route('customer.pengajuan.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" id="ajukanBarangId" name="barang_id">
                <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <p class="text-xs text-gray-500 font-medium">Barang</p>
                    <p id="ajukanNama" class="font-bold text-gray-900 mt-0.5"></p>
                    <p id="ajukanStock" class="text-xs text-bps-green font-semibold mt-0.5"></p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah yang Diminta</label>
                    <input type="number" id="ajukanJumlah" name="jumlah" min="1" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modalAjukan').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-bps-blue text-white text-sm font-semibold hover:bg-bps-blue-dark transition cursor-pointer">Kirim
                        Pengajuan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAjukanModal(id, nama, stock, satuan) {
            document.getElementById('ajukanBarangId').value = id;
            document.getElementById('ajukanNama').textContent = nama;
            document.getElementById('ajukanStock').textContent = `Stock tersedia: ${stock} ${satuan}`;
            document.getElementById('ajukanJumlah').max = stock;
            document.getElementById('modalAjukan').classList.remove('hidden');
        }
    </script>
@endsection
