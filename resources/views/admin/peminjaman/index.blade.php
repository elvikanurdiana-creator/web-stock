@extends('layouts.admin')

@section('title', 'Manajemen Persetujuan Peminjaman')

@section('content')
<div class="space-y-6">

    {{-- ─── NOTIFIKASI ALERT SUKSES ─── --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- ─── BAGIAN ATAS: KALENDER GLOBAL DENGAN TAB FILTER ─── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-bps-blue-dark">Kalender Monitoring Jadwal Fasilitas</h2>
                <p class="text-xs text-gray-400">Filter dan pantau jadwal booking mobil dinas atau ruang rapat yang telah disetujui</p>
            </div>
            
            {{-- TOMBOL TAB FILTER --}}
            <div class="flex bg-gray-100 p-1 rounded-xl w-fit border border-gray-200">
                <button onclick="switchCalendar('all')" id="btn-all" class="px-4 py-1.5 text-xs font-bold rounded-lg transition shadow-sm cursor-pointer bg-white text-bps-blue-dark">
                    Semua Fasilitas
                </button>
                <button onclick="switchCalendar('mobil')" id="btn-mobil" class="px-4 py-1.5 text-xs font-bold rounded-lg transition cursor-pointer text-gray-500 hover:text-gray-700">
                    Mobil Dinas
                </button>
                <button onclick="switchCalendar('ruang')" id="btn-ruang" class="px-4 py-1.5 text-xs font-bold rounded-lg transition cursor-pointer text-gray-500 hover:text-gray-700">
                    Ruang Rapat
                </button>
            </div>
        </div>
        
        {{-- Wadah Kalender Admin --}}
        <div id="calendar" class="min-h-[450px]"></div>
    </div>

    {{-- ─── BAGIAN BAWAH: TABEL PERSETUJUAN/APPROVAL ─── --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="mb-6">
            <h2 class="text-lg font-bold text-bps-blue-dark">Daftar Pengajuan Peminjaman Masuk</h2>
            <p class="text-xs text-gray-400">Silakan proses persetujuan berkas peminjaman fasilitas di bawah ini</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-xs font-bold text-gray-500 uppercase bg-gray-50">
                        <th class="p-3">Nama Pemohon</th>
                        <th class="p-3">Fasilitas / Item</th>
                        <th class="p-3">Waktu Pinjam</th>
                        <th class="p-3">Keperluan</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-center">Aksi / Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($peminjaman as $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-3 font-medium text-gray-900">{{ $item->user->username ?? 'User' }}</td>
                            <td class="p-3 font-semibold text-gray-700">
                                <span class="block">{{ $item->nama_item }}</span>
                                <span class="text-xs font-normal text-gray-400 capitalize">
                                    Jenis: <b class="{{ $item->jenis_fasilitas === 'mobil' ? 'text-sky-600' : 'text-amber-600' }}">{{ $item->jenis_fasilitas }}</b>
                                </span>
                            </td>
                            <td class="p-3 text-xs text-gray-600 space-y-0.5">
                                <div class="text-green-600">Mulai: {{ $item->waktu_mulai->format('d M Y - H:i') }}</div>
                                <div class="text-red-600">Selesai: {{ $item->waktu_selesai->format('d M Y - H:i') }}</div>
                            </td>
                            <td class="p-3 text-gray-600 max-w-xs truncate">{{ $item->keperluan ?? '-' }}</td>
                            <td class="p-3">
                                @if($item->status === 'pending')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">Pending</span>
                                @elseif($item->status === 'disetujui')
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-600 border border-green-200">Disetujui</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">Ditolak</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                @if($item->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.peminjaman.update-status', $item->id) }}" method="POST" onsubmit="return confirm('Setujui pengajuan peminjaman ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition cursor-pointer">
                                                Setuju
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.peminjaman.update-status', $item->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan peminjaman ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-sm transition cursor-pointer">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 font-medium">Sudah Diproses</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-gray-400">Belum ada data pengajuan peminjaman fasilitas masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPT INSTANS IASIONAL FULLCALENDAR DENGAN LOGIKA FILTER SWITCH --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    // Siapkan data array dari laravel ke javascript
    const dataMobil = {!! json_encode($jadwalMobil) !!};
    const dataRuang = {!! json_encode($jadwalRuang) !!};
    const dataSemua = [...dataMobil, ...dataRuang]; // Gabungan keduanya

    var calendar;

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if(calendarEl) {
            calendar = new FullCalendar.Calendar(calendarEl, {
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
                events: dataSemua, // Tampilan awal menampilkan semua
                eventTimeFormat: { 
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }
            });
            calendar.render();
        }
    });

    // Fungsi interaktif pengubah data kalender tanpa reload halaman
    function switchCalendar(type) {
        // 1. Hapus semua event yang menempel saat ini
        calendar.removeAllEvents();

        // 2. Isi ulang data event berdasarkan tab yang diklik
        if (type === 'mobil') {
            calendar.addEventSource(dataMobil);
        } else if (type === 'ruang') {
            calendar.addEventSource(dataRuang);
        } else {
            calendar.addEventSource(dataSemua);
        }

        // 3. Update styling CSS active tombol tab-nya
        const tabs = ['all', 'mobil', 'ruang'];
        tabs.forEach(tab => {
            const btn = document.getElementById(`btn-${tab}`);
            if (tab === type) {
                btn.className = "px-4 py-1.5 text-xs font-bold rounded-lg transition shadow-sm cursor-pointer bg-white text-bps-blue-dark";
            } else {
                btn.className = "px-4 py-1.5 text-xs font-bold rounded-lg transition cursor-pointer text-gray-500 hover:text-gray-700";
            }
        });
    }
</script>

<style>
    .fc { font-family: inherit; }
    .fc .fc-button-primary { background-color: #043264; border-color: #043264; }
    .fc .fc-button-primary:hover { background-color: #05417c; border-color: #05417c; }
    .fc-event { border-radius: 6px; padding: 2px 4px; font-size: 0.75rem; border: none !important; }
</style>
@endsection