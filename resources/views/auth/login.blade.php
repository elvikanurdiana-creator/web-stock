<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — BPS Inventory</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen bg-bps-blue flex items-center justify-center font-[Plus_Jakarta_Sans] relative overflow-hidden">

    {{-- Background decorative shapes --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-bps-blue-light/40"></div>
        <div class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-bps-orange/20"></div>
        <div class="absolute top-1/2 left-1/4 w-48 h-48 rounded-full bg-bps-green/20"></div>
        {{-- Grid pattern --}}
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px); background-size: 32px 32px;">
        </div>
    </div>

    <div class="relative z-10 w-full max-w-md px-6">
        {{-- Logo & Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white shadow-2xl mb-4">
                <svg class="w-12 h-12" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="60" height="60" rx="12" fill="#003d82" />
                    <rect x="10" y="10" width="12" height="16" rx="2" fill="#f47920" />
                    <rect x="24" y="16" width="12" height="10" rx="2" fill="#ffffff" />
                    <rect x="38" y="8" width="12" height="18" rx="2" fill="#2e8b57" />
                    <rect x="10" y="34" width="40" height="3" rx="1.5" fill="#f47920" />
                    <rect x="10" y="40" width="28" height="3" rx="1.5" fill="rgba(255,255,255,0.4)" />
                    <rect x="10" y="46" width="18" height="3" rx="1.5" fill="rgba(255,255,255,0.4)" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">BADAN PUSAT STATISTIK</h1>
            <p class="text-[#93c5fd] text-sm mt-1 font-medium">Sistem Manajemen Inventaris</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-xl font-bold text-bps-blue mb-1">Selamat Datang</h2>
            <p class="text-gray-500 text-sm mb-6">Masuk ke akun Anda untuk melanjutkan</p>

            @if (session('error'))
                <div
                    class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->has('username'))
                <div
                    class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $errors->first('username') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="username" value="{{ old('username') }}"
                            placeholder="Masukkan username atau email"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue focus:border-transparent transition"
                            required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" placeholder="Masukkan password"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-bps-blue focus:border-transparent transition"
                            required>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-bps-blue hover:bg-bps-blue-dark text-white font-bold py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm tracking-wide flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    MASUK
                </button>
            </form>
        </div>

        <p class="text-center text-[#93c5fd] text-xs mt-6">© {{ date('Y') }} Badan Pusat Statistik — Sistem
            Inventaris</p>
    </div>
</body>

</html>
