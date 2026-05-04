@extends('layouts.admin')
@section('title', 'Manajemen Transaksi')

@section('content')
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-900">Daftar Transaksi Request</h2>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-[#003d82]/5 border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-xs font-bold text-[#003d82] uppercase tracking-wider">No</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-[#003d82] uppercase tracking-wider">
                                Customer</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-[#003d82] uppercase tracking-wider">Barang
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-[#003d82] uppercase tracking-wider">Jumlah
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-[#003d82] uppercase tracking-wider">Status
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-[#003d82] uppercase tracking-wider">
                                Tanggal</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-[#003d82] uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($transaksi as $i => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $transaksi->firstItem() + $i }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $item->user->username ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $item->barang->nama_barang ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $item->jumlah }} <span
                                        class="text-gray-400 font-normal">{{ $item->barang->satuan ?? '' }}</span></td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'disetujui' => 'bg-green-100 text-green-800',
                                            'ditolak' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $colors[$item->status] ?? '' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">{{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->status === 'pending')
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('admin.transaksi.update-status', $item) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <input type="hidden" name="status" value="disetujui">
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-lg bg-[#2e8b57] text-white text-xs font-semibold hover:bg-green-700 transition cursor-pointer">Setujui</button>
                                            </form>
                                            <button onclick="openTolakModal('{{ $item->id }}')"
                                                class="px-3 py-1.5 rounded-lg bg-red-500 text-white text-xs font-semibold hover:bg-red-600 transition cursor-pointer">Tolak</button>
                                        </div>
                                    @else
                                        <span
                                            class="text-xs text-gray-400 italic">{{ $item->alasan ?? 'Sudah diproses' }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($transaksi->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">{{ $transaksi->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Modal Tolak --}}
    <div id="modalTolak" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tolak Pengajuan</h3>
            <form id="formTolak" method="POST" class="space-y-4">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="ditolak">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alasan Penolakan</label>
                    <textarea name="alasan" rows="3" placeholder="Tulis alasan penolakan..."
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 resize-none"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modalTolak').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 cursor-pointer">Batal</button>
                    <button type="submit"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition cursor-pointer">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openTolakModal(id) {
            document.getElementById('formTolak').action = `/admin/transaksi/${id}/status`;
            document.getElementById('modalTolak').classList.remove('hidden');
        }
    </script>
@endsection
