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
                <h2 class="text-xl font-semibold tracking-tight text-bps-blue-dark">Kalender Kesibukan / Jadwal Terisi {{ $jenis === 'mobil' ? 'Mobil Dinas' : 'Ruang Rapat' }}</h2>
                <p class="text-sm text-gray-500">Silakan cek jadwal kosong sebelum mengisi form pengajuan di bawah</p>
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
    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama {{ ucfirst($jenis) }}</label>
    
    <div class="relative flex items-center">
        {{-- Dropdown select dengan gaya tema premium baru --}}
        <select name="nama_item" required
            class="w-full px-3 py-2.5 bg-white border @error('nama_item') border-red-500 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 appearance-none focus:outline-none focus:border-bps-blue focus:ring-4 focus:ring-bps-blue/10 transition-all cursor-pointer">
            
            <option value="" disabled selected hidden>— Pilih {{ ucfirst($jenis) }} —</option>
            
            {{-- Logika pilihan berdasarkan jenis --}}
            @if($jenis === 'mobil')
                {{-- Daftar Nomor Polisi Mobil Dinas --}}
                <option value="L 38" {{ old('nama_item') == 'L 38' ? 'selected' : '' }}>L 38</option>
                <option value="L 1760 HP" {{ old('nama_item') == 'L 1760 HP' ? 'selected' : '' }}>L 1760 HP</option>
                <option value="L 1758 HP" {{ old('nama_item') == 'L 1758 HP' ? 'selected' : '' }}>L 1758 HP</option>
                <option value="L 1759 HP" {{ old('nama_item') == 'L 1759 HP' ? 'selected' : '' }}>L 1759 HP</option>
                <option value="B 1877 PQS" {{ old('nama_item') == 'B 1877 PQS' ? 'selected' : '' }}>B 1877 PQS</option>
                <option value="B 1875 PQS" {{ old('nama_item') == 'B 1875 PQS' ? 'selected' : '' }}>B 1875 PQS</option>
                <option value="S 3351 NP" {{ old('nama_item') == 'S 3351 NP' ? 'selected' : '' }}>S 3351 NP</option>
                <option value="S 3346 NP" {{ old('nama_item') == 'S 3346 NP' ? 'selected' : '' }}>S 3346 NP</option>
            @else
                {{-- Daftar Ruangan BPS --}}
                <option value="Ruang Vicon" {{ old('nama_item') == 'Ruang Vicon' ? 'selected' : '' }}>Ruang Vicon</option>
                <option value="Ruang Aula Majapahit" {{ old('nama_item') == 'Ruang Aula Majapahit' ? 'selected' : '' }}>Ruang Aula Majapahit</option>
            @endif

        </select>

        {{-- Icon panah kustom di sisi kanan --}}
        <div class="absolute right-4 pointer-events-none text-slate-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    @error('nama_item')
        <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
    @enderror
</div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Waktu Mulai</label>
            <input type="datetime-local" name="waktu_mulai" required value="{{ old('waktu_mulai') }}"
                class="w-full px-3 py-2 border @error('waktu_mulai') border-red-500 @else border-gray-300 @enderror rounded-xl text-sm focus:outline-none focus:border-bps-blue focus:ring-4 focus:ring-bps-blue/10">
            @error('waktu_mulai')
                <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Waktu Selesai</label>
            <input type="datetime-local" name="waktu_selesai" required value="{{ old('waktu_selesai') }}"
                class="w-full px-3 py-2 border @error('waktu_selesai') border-red-500 @else border-gray-300 @enderror rounded-xl text-sm focus:outline-none focus:border-bps-blue focus:ring-4 focus:ring-bps-blue/10">
            {{-- 💡 ALERT ERROR SPESIFIK TANGGAL TERBALIK / BENTROK AKAN MUNCUL DI SINI --}}
            @error('waktu_selesai')
                <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Keperluan / Agenda</label>
            <textarea name="keperluan" rows="3" placeholder="Tuliskan alasan peminjaman..."
                class="w-full px-3 py-2 border @error('keperluan') border-red-500 @else border-gray-300 @enderror rounded-xl text-sm focus:outline-none focus:border-bps-blue focus:ring-4 focus:ring-bps-blue/10">{{ old('keperluan') }}</textarea>
            @error('keperluan')
                <span class="text-xs text-red-500 font-semibold mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="w-full py-2.5 rounded-xl text-sm font-semibold bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white transition shadow-[0_8px_24px_-12px_rgba(0,61,130,0.8)] cursor-pointer">
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