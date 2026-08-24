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
                <h2 class="text-xl font-semibold tracking-tight text-bps-blue-dark">Kalender Monitoring Jadwal Fasilitas</h2>
                <p class="text-xs text-gray-400">Filter dan pantau jadwal booking mobil dinas atau ruang rapat yang telah disetujui</p>
            </div>
            
            {{-- TOMBOL TAB FILTER --}}
            <div class="flex bg-gray-100 p-1 rounded-xl w-fit border border-gray-200">
                <button onclick="switchCalendar('all')" id="btn-all" class="px-4 py-1.5 text-xs font-semibold rounded-lg transition shadow-sm cursor-pointer bg-white text-bps-blue-dark">
                    Semua Fasilitas
                </button>
                <button onclick="switchCalendar('mobil')" id="btn-mobil" class="px-4 py-1.5 text-xs font-semibold rounded-lg transition cursor-pointer text-gray-500 hover:text-gray-700">
                    Mobil Dinas
                </button>
                <button onclick="switchCalendar('ruang')" id="btn-ruang" class="px-4 py-1.5 text-xs font-semibold rounded-lg transition cursor-pointer text-gray-500 hover:text-gray-700">
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
                                            <button type="submit" class="px-3 py-1.5 bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white text-xs font-semibold rounded-xl shadow-sm transition cursor-pointer">
                                                Setuju
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.peminjaman.update-status', $item->id) }}" method="POST" onsubmit="return confirm('Tolak pengajuan peminjaman ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="px-3 py-1.5 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-500 text-white text-xs font-semibold rounded-xl shadow-sm transition cursor-pointer">
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

{{-- SCRIPT INSTANSIASIONAL FULLCALENDAR --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

{{-- Library Tambahan Popper & Tippy untuk Hover Info Kustom --}}
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

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
                },
                // Integrasi Popover Tippy kustom pas kursor didekatkan
                eventDidMount: function(info) {
                    if (info.event.extendedProps.keperluan) {
                        const namaUser = info.event.extendedProps.user || 'Tidak Diketahui';
                        
                        tippy(info.el, {
                            content: `<div class="p-2 space-y-1.5 max-w-[280px] text-left">
                                        <p class="font-bold border-b border-white/20 pb-1 text-amber-400 text-xs">📄 Rincian Kegiatan</p>
                                        <p class="text-[11px] text-slate-200 font-medium"><strong>Pengguna:</strong> ${namaUser}</p>
                                        <p class="text-[11px] leading-relaxed text-slate-100 font-medium whitespace-normal break-words"><strong>Keperluan:</strong> ${info.event.extendedProps.keperluan}</p>
                                      </div>`,
                            allowHTML: true,
                            placement: 'top',
                            theme: 'bps-dark',
                            animation: 'scale',
                            delay: [50, 0],
                        });
                    }
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
    .fc .fc-button-primary { background-color: #043264; border-color: #043264; font-size: 11px; font-weight: 600; text-transform: capitalize; border-radius: 8px; padding: 6px 12px; }
    .fc .fc-button-primary:hover { background-color: #05417c; border-color: #05417c; }
    .fc .fc-button-primary:disabled { background-color: #94a3b8; border-color: #94a3b8; }
    .fc-event { border-radius: 6px; padding: 3px 6px; font-size: 11px; border: none !important; font-weight: 500; cursor: pointer; }
    .fc .fc-toolbar-title { font-size: 16px; font-weight: 700; color: #043264; text-transform: capitalize; }

    /* Desain Balon Tooltip Tippy.js */
    .tippy-box[data-theme~='bps-dark'] {
        background-color: #043264;
        color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .tippy-box[data-theme~='bps-dark'] .tippy-arrow {
        color: #043264;
    }
</style>
@endsection