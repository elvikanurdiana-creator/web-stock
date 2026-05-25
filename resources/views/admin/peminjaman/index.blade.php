@extends('layouts.admin')

@section('title', 'Persetujuan Peminjaman')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-bps-blue-dark">Daftar Pengajuan Peminjaman</h2>
            <p class="text-xs text-gray-400">Kelola persetujuan reservasi mobil dinas dan ruang rapat</p>
        </div>
    </div>

    @if($semuaPengajuan->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="text-sm font-medium">Belum ada pengajuan peminjaman saat ini.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-xs font-bold text-gray-500 uppercase bg-gray-50">
                        <th class="p-4">Pegawai (User)</th>
                        <th class="p-4">Jenis</th>
                        <th class="p-4">Nama Aset / Item</th>
                        <th class="p-4">Waktu Peminjaman</th>
                        <th class="p-4">Keperluan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @foreach($semuaPengajuan as $peminjaman)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="p-4 font-semibold text-gray-800">
                                {{ $peminjaman->user->name ?? 'User Tidak Dikenal' }}
                            </td>
                            
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase {{ $peminjaman->jenis_fasilitas === 'mobil' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                    {{ $peminjaman->jenis_fasilitas }}
                                </span>
                            </td>

                            <td class="p-4 font-medium text-gray-700">
                                {{ $peminjaman->nama_item }}
                            </td>

                            <td class="p-4 text-xs text-gray-600 space-y-1">
                                <div class="flex items-center gap-1 text-green-600 font-medium">
                                    <span>Mulai:</span>
                                    <span>{{ $peminjaman->waktu_mulai->format('d M Y - H:i') }} WIB</span>
                                </div>
                                <div class="flex items-center gap-1 text-red-600 font-medium">
                                    <span>Selesai:</span>
                                    <span>{{ $peminjaman->waktu_selesai->format('d M Y - H:i') }} WIB</span>
                                </div>
                            </td>

                            <td class="p-4 text-gray-600 max-w-xs truncate" title="{{ $peminjaman->keperluan }}">
                                {{ $peminjaman->keperluan ?? '-' }}
                            </td>

                            <td class="p-4">
                                @if($peminjaman->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">Pending</span>
                                @elseif($peminjaman->status === 'disetujui')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-600 border border-green-200">Disetujui</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">Ditolak</span>
                                @endif
                            </td>

                            <td class="p-4 text-center">
                                @if($peminjaman->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.peminjaman.update-status', $peminjaman->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-green-600 hover:bg-green-700 text-white transition shadow-sm cursor-pointer">
                                                Setujui
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.peminjaman.update-status', $peminjaman->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 transition cursor-pointer">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 font-medium">Selesai Diproses</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection