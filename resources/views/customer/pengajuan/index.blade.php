@extends('layouts.customer')
@section('title', 'Pengajuan Saya')

@section('content')
    <div class="space-y-6">
        <h2 class="text-xl font-bold text-gray-900">Riwayat Pengajuan Saya</h2>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-bps-blue-dark/5 border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue-dark uppercase tracking-wider">No</th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue-dark uppercase tracking-wider">Barang
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue-dark uppercase tracking-wider">Jumlah
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue-dark uppercase tracking-wider">Status
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue-dark uppercase tracking-wider">Alasan
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-bold text-bps-blue-dark uppercase tracking-wider">
                                Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($pengajuan as $i => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $pengajuan->firstItem() + $i }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    {{ $item->barang->nama_barang ?? '-' }}</td>
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
                                <td class="px-6 py-4 text-sm text-gray-500 italic">{{ $item->alasan ?? '—' }}</td>
                                <td class="px-6 py-4 text-xs text-gray-500">{{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-400 text-sm">
                                    Belum ada pengajuan. <a href="{{ route('customer.katalog.index') }}"
                                        class="text-bps-blue-dark font-semibold hover:underline">Lihat katalog →</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($pengajuan->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">{{ $pengajuan->links() }}</div>
            @endif
        </div>
    </div>
@endsection
