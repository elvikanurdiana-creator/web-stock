@extends('layouts.customer')

@section('title', 'Peminjaman ' . ucfirst($jenis))

{{-- 💡 Mengamankan CDN FullCalendar di paling atas agar diload duluan oleh browser --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

@section('content')
<div class="space-y-6">

    {{-- ─── NOTIFIKASI ALERT SUKSES (BERHASIL SIMPAN) ─── --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ─── NOTIFIKASI ALERT ERROR (BENTROK JADWAL / GAGAL VALIDASI) ─── --}}
    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- ─── BAGIAN ATAS: KALENDER JADWAL TERISI (DINAMIS) ─── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-6">
            <div>
                <h2 class="text-xl font-bold text-bps-blue-dark">Kalender Kesibukan / Jadwal Terisi {{ $jenis === 'mobil' ? 'Mobil Dinas' : 'Ruang Rapat' }}</h2>
                <p class="text-xs text-gray-400">Silakan cek jadwal kosong sebelum mengisi form pengajuan di bawah</p>
            </div>
            <div class="flex items-center gap-2 text-xs">
                <span class="w-3 h-3 rounded-full {{ $jenis === 'mobil' ? 'bg-sky-500' : 'bg-amber-500' }} inline-block"></span>
                <span class="font-medium text-gray-600">Sudah Terbooking & Disetujui</span>
            </div>
        </div>
        
        {{-- Wadah Utama Kalender --}}
        <div id="calendar" style="min-height: 500px; background: white;"></div>
    </div>

    {{-- ─── BAGIAN BAWAH: GRID FORM & TABLE RIWAYAT ─── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- COLUMN 1: FORM PENGAJUAN --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 h-fit">
            <h2 class="text-lg font-bold text-bps-blue-dark mb-1">Form Pengajuan Peminjaman</h2>
            <p class="text-xs text-gray-400 mb-6">Silakan isi detail reservasi {{ $jenis }} dinas</p>

            <form action="{{ route('customer.peminjaman.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="jenis_fasilitas" value="{{ $jenis }}">

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama {{ ucfirst($jenis) }} / Aset</label>
                    <input type="text" name="nama_item" required placeholder="Contoh: {{ $jenis === 'mobil' ? 'Avanza Plat L 1234 AB' : 'Ruang Rapat Utama Lt. 2' }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-bps-green">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Waktu Mulai</label>
                    <input type="datetime-local" name="waktu_mulai" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-bps-green">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Waktu Selesai</label>
                    <input type="datetime-local" name="waktu_selesai" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-bps-green">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Keperluan / Agenda</label>
                    <textarea name="keperluan" rows="3" placeholder="Tuliskan alasan peminjaman..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-bps-green"></textarea>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-bold bg-bps-green hover:bg-green-700 text-white transition shadow-md cursor-pointer">
                    Kirim Pengajuan
                </button>
            </form>
        </div>

        {{-- COLUMN 2 & 3: RIWAYAT PENGAJUAN SAYA --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-bps-blue-dark mb-1">Riwayat Peminjaman Anda</h2>
            <p class="text-xs text-gray-400 mb-6">Daftar status pengajuan peminjaman {{ $jenis }} Anda</p>

            @if($peminjaman->isEmpty())
                <div class="text-center py-12 text-gray-400 border-2 border-dashed border-gray-100 rounded-xl">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm">Belum ada riwayat peminjaman {{ $jenis }}.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 text-xs font-bold text-gray-500 uppercase bg-gray-50">
                                <th class="p-3">Nama Item</th>
                                <th class="p-3">Waktu Peminjaman</th>
                                <th class="p-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @foreach($peminjaman as $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-3 font-semibold text-gray-700">{{ $item->nama_item }}</td>
                                    <td class="p-3 text-xs text-gray-600 space-y-0.5">
                                        <div class="text-green-600">Mulai: {{ $item->waktu_mulai->format('d M Y - H:i') }}</div>
                                        <div class="text-red-600">Selesai: {{ $item->waktu_selesai->format('d M Y - H:i') }}</div>
                                    </td>
                                    <td class="p-3">
                                        @if($item->status === 'pending')
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">Pending</span>
                                        @elseif($item->status === 'disetujui')
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-600 border border-green-200">Disetujui</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>

{{-- ─── LOGIKA SCRIPT INTERAKTIF FULLCALENDAR ─── --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if(calendarEl) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                timeZone: 'local',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                },
                events: {!! json_encode($peminjamanDisetujui ?? []) !!},
                eventTimeFormat: { 
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }
            });
            calendar.render();
        }
    });
</script>

<style>
    .fc { font-family: inherit; }
    .fc .fc-button-primary { background-color: #043264; border-color: #043264; }
    .fc .fc-button-primary:hover { background-color: #05417c; border-color: #05417c; }
    .fc-event { border-radius: 6px; padding: 2px 4px; font-size: 0.75rem; border: none !important; }
</style>
@endsection