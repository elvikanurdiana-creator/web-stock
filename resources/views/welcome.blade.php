<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Jadwal Fasilitas — BPS Provinsi Jawa Timur</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Memanggil Core FullCalendar v6 --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    {{-- Popper.js dan Tippy.js untuk Tooltip Interaktif Kustom (Teks Full) --}}
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
</head>

<body class="bg-bps-cream-bg font-[Plus_Jakarta_Sans] min-h-screen flex flex-col text-slate-800">

    {{-- HEADER / NAVBAR ATAS --}}
    <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 px-6 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center flex-shrink-0 shadow-sm border border-slate-200/80">
                <svg class="w-5 h-5 text-bps-orange" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M3 3h4v8H3zm6-4h4v12H9zm6 2h4v10h-4zm-14 15h20v2H1z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-bps-orange uppercase tracking-[0.01em] leading-tight">BPS Provinsi Jawa Timur</p>
                <p class="text-[11px] font-medium leading-none text-slate-500 mt-0.5">Sistem Manajemen Persediaan & Fasilitas</p>
            </div>
        </div>

        {{-- Menuju Form Login Asli --}}
        <div>
            <a href="{{ url('/') }}" class="px-4 py-2 bg-gradient-to-r from-bps-blue to-bps-blue-dark hover:from-bps-blue-dark hover:to-bps-blue text-white text-xs font-bold rounded-xl shadow-md transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Kembali ke Login
            </a>
        </div>
    </header>

    {{-- KONTEN UTAMA KALENDER --}}
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 md:p-6 space-y-6">
        
        <div class="text-center py-2 max-w-2xl mx-auto space-y-1">
            <h1 class="text-2xl font-extrabold text-bps-blue-dark tracking-tight md:text-3xl">Monitoring Penggunaan Fasilitas</h1>
            <p class="text-xs md:text-sm text-gray-500 font-medium">Informasi jadwal penggunaan Mobil Dinas dan Ruang Rapat.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 md:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="space-y-0.5">
                    <h2 class="text-base font-bold text-bps-blue-dark">Kalender Jadwal Kegiatan</h2>
                    <div class="flex items-center gap-3 text-[11px] text-gray-400 mt-1">
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-[#0284c7]"></span>Mobil Dinas</span>
                        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded bg-[#d97706]"></span>Ruang Rapat</span>
                    </div>
                </div>
                
                {{-- TAB FILTER INTERAKTIF --}}
                <div class="flex bg-slate-100 p-1 rounded-xl w-fit border border-slate-200">
                    <button onclick="switchCalendar('all')" id="btn-all" class="px-4 py-1.5 text-xs font-bold rounded-lg transition shadow-sm cursor-pointer bg-white text-bps-blue-dark">
                        Semua
                    </button>
                    <button onclick="switchCalendar('mobil')" id="btn-mobil" class="px-4 py-1.5 text-xs font-bold rounded-lg transition cursor-pointer text-gray-500 hover:text-gray-700">
                        Mobil
                    </button>
                    <button onclick="switchCalendar('ruang')" id="btn-ruang" class="px-4 py-1.5 text-xs font-bold rounded-lg transition cursor-pointer text-gray-500 hover:text-gray-700">
                        Ruang
                    </button>
                </div>
            </div>
            
            <div id="calendar" class="min-h-[500px]"></div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 text-center py-4 text-xs text-slate-400 font-medium mt-auto">
        &copy; {{ date('Y') }} Badan Pusat Statistik Provinsi Jawa Timur. All Rights Reserved.
    </footer>

    <script>
        const dataMobil = {!! json_encode($jadwalMobil ?? []) !!};
        const dataRuang = {!! json_encode($jadwalRuang ?? []) !!};
        const dataSemua = [...dataMobil, ...dataRuang];

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
                        right: 'dayGridMonth,timeGridWeek'
                    },
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        week: 'Minggu'
                    },
                    events: dataSemua,
                    eventTimeFormat: { 
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    },
                    // Menggunakan Tippy.js untuk menampilkan full teks keperluan secara instan
                    eventDidMount: function(info) {
                        if (info.event.extendedProps.keperluan) {
                        // Ambil data user dari extendedProps
                        const namaUser = info.event.extendedProps.user || 'Tidak Diketahui';
        
                        tippy(info.el, {
                        content: `<div class="p-2 space-y-1.5 max-w-[280px]">
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

        function switchCalendar(type) {
            calendar.removeAllEvents();
            if (type === 'mobil') {
                calendar.addEventSource(dataMobil);
            } else if (type === 'ruang') {
                calendar.addEventSource(dataRuang);
            } else {
                calendar.addEventSource(dataSemua);
            }

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

        /* Gaya Balon Tooltip Kustom (Theme: bps-dark) */
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
</body>
</html>