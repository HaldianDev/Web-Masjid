<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jadwal Shalat - {{ config('app.name', 'Masjid Raya Al-Hikmah') }}</title>
    
    <!-- Fonts: Google Fonts (Outfit & Amiri for elegant arabic vibes) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital@0;1&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind & Alpine (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .arabic-text {
            font-family: 'Amiri', serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #062f1b;
        }
        ::-webkit-scrollbar-thumb {
            background: #d4af37;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #f3cf5a;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-green-950 text-slate-100 min-h-screen antialiased selection:bg-amber-400 selection:text-emerald-950">

    <!-- Top Navigation Header (Re-using structure from welcome.blade.php) -->
    <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 backdrop-blur-md bg-emerald-950/70 border-b border-amber-500/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="#" class="flex items-center space-x-3 group shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-tr from-amber-400 to-amber-500 flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-emerald-950" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="min-w-0">
                    <span class="text-base sm:text-xl font-bold tracking-tight text-amber-400 block group-hover:text-amber-300 transition-colors truncate">As-Sa'adah Desa Belambangan</span>
                    <span class="text-[10px] sm:text-xs text-slate-300 block -mt-1">Pusat Kebajikan & Peradaban Umat</span>
                </div>
            </a>
            
            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-8 text-sm font-medium text-slate-200">
                <a href="{{ route('public.prayer-schedule') }}" class="hover:text-amber-400 transition-colors">Jadwal Shalat</a>
                <a href="{{ route('public.activities') }}" class="hover:text-amber-400 transition-colors">Agenda Kegiatan</a>
                <a href="{{ route('public.profile') }}" class="hover:text-amber-400 transition-colors">Profil Masjid</a>
                <a href="{{ route('public.finance-transparency') }}" class="hover:text-amber-400 transition-colors">Transparansi Kas</a>
                <a href="{{ route('public.articles-list') }}" class="hover:text-amber-400 transition-colors">Artikel & Khotbah</a>
                <a href="{{ route('public.qurban') }}" class="hover:text-amber-400 transition-colors">Qurban</a>
            </nav>

            <div class="flex items-center space-x-3 shrink-0">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="hidden sm:inline-flex px-5 py-2.5 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-emerald-950 font-semibold rounded-full shadow-lg shadow-amber-500/20 text-sm transition-all hover:scale-105 duration-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-flex text-sm font-semibold text-slate-200 hover:text-amber-400 transition-colors">Masuk</a>
                    @endauth
                @endif

                <!-- Hamburger Button (Mobile & Tablet) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden inline-flex items-center justify-center p-2 rounded-xl text-slate-300 hover:text-amber-400 hover:bg-emerald-900/50 focus:outline-none transition-all duration-200" aria-label="Toggle menu">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile & Tablet Dropdown Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             x-cloak
             class="lg:hidden border-t border-amber-500/10 bg-emerald-950/95 backdrop-blur-lg">
            <nav class="max-w-7xl mx-auto px-4 py-4 space-y-1">
                <a href="{{ route('public.prayer-schedule') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-200 hover:text-amber-400 hover:bg-emerald-900/50 transition-all text-sm font-medium">
                    <svg class="w-5 h-5 text-amber-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Jadwal Shalat</span>
                </a>
                <a href="{{ route('public.activities') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-200 hover:text-amber-400 hover:bg-emerald-900/50 transition-all text-sm font-medium">
                    <svg class="w-5 h-5 text-amber-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Agenda Kegiatan</span>
                </a>
                <a href="{{ route('public.profile') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-200 hover:text-amber-400 hover:bg-emerald-900/50 transition-all text-sm font-medium">
                    <svg class="w-5 h-5 text-amber-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span>Profil Masjid</span>
                </a>
                <a href="{{ route('public.finance-transparency') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-200 hover:text-amber-400 hover:bg-emerald-900/50 transition-all text-sm font-medium">
                    <svg class="w-5 h-5 text-amber-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>Transparansi Kas</span>
                </a>
                <a href="{{ route('public.articles-list') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-200 hover:text-amber-400 hover:bg-emerald-900/50 transition-all text-sm font-medium">
                    <svg class="w-5 h-5 text-amber-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span>Artikel & Khotbah</span>
                </a>
                <a href="{{ route('public.qurban') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-slate-200 hover:text-amber-400 hover:bg-emerald-900/50 transition-all text-sm font-medium">
                    <svg class="w-5 h-5 text-amber-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Qurban</span>
                </a>

                <!-- Mobile Auth Links -->
                <div class="border-t border-amber-500/10 pt-3 mt-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="flex items-center justify-center px-4 py-3 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-emerald-950 font-bold rounded-xl shadow-lg shadow-amber-500/10 text-sm transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center justify-center px-4 py-3 bg-emerald-900/60 hover:bg-emerald-800/80 text-amber-400 font-semibold rounded-xl border border-amber-500/20 text-sm transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                Masuk
                            </a>
                        @endauth
                    @endif
                </div>
            </nav>
        </div>
    </header>


    <!-- Interactive Prayer Times Widget (Module 1) -->
    <section id="jadwal" class="py-12 bg-emerald-950 border-t border-b border-amber-500/10 relative" 
             x-data="prayerScheduleData({
                 imsak: '{{ $prayerTimes['imsak'] }}',
                 subuh: '{{ $prayerTimes['subuh'] }}',
                 syuruk: '{{ $prayerTimes['syuruk'] }}',
                 dzuhur: '{{ $prayerTimes['dzuhur'] }}',
                 ashar: '{{ $prayerTimes['ashar'] }}',
                 maghrib: '{{ $prayerTimes['maghrib'] }}',
                 isya: '{{ $prayerTimes['isya'] }}'
             })">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-emerald-900 to-green-950 rounded-3xl p-6 sm:p-10 shadow-2xl border border-amber-500/10">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8 mb-8 border-b border-emerald-800 pb-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Jadwal Shalat Hari Ini</h2>
                        <p class="text-slate-300 text-sm mt-1">
                            Zona Waktu: <span class="text-amber-400 font-semibold">{{ $prayerTimes['city'] }}</span> &bull; Tanggal: {{ date('d F Y') }}
                        </p>
                    </div>
                    <!-- Realtime Countdown Timer -->
                    <div class="bg-emerald-950/80 px-6 py-3 rounded-2xl border border-amber-500/20 text-center w-full lg:w-auto">
                        <span class="text-xs text-slate-400 block tracking-wide uppercase font-semibold">Waktu Menuju <span x-text="nextPrayerName">...</span></span>
                        <span class="text-2xl font-bold text-amber-400 tracking-wider font-mono block mt-1" x-text="countdown">00:00:00</span>
                    </div>
                </div>
                
                <!-- Grid of Prayer Times -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    <!-- Imsak -->
                    <div :class="activePrayer === 'Imsak' ? 'bg-amber-400 text-emerald-950 shadow-lg shadow-amber-400/10 border-amber-400' : 'bg-emerald-950/40 text-slate-300 border-emerald-800'" class="p-5 rounded-2xl text-center border transition-all duration-300 hover:scale-105">
                        <span class="text-xs font-semibold block tracking-wider uppercase opacity-80">Imsak</span>
                        <span class="text-2xl font-bold tracking-tight block mt-2 font-mono">{{ $prayerTimes['imsak'] }}</span>
                    </div>
                    <!-- Subuh -->
                    <div :class="activePrayer === 'Subuh' ? 'bg-amber-400 text-emerald-950 shadow-lg shadow-amber-400/10 border-amber-400' : 'bg-emerald-950/40 text-slate-300 border-emerald-800'" class="p-5 rounded-2xl text-center border transition-all duration-300 hover:scale-105">
                        <span class="text-xs font-semibold block tracking-wider uppercase opacity-80">Subuh</span>
                        <span class="text-2xl font-bold tracking-tight block mt-2 font-mono">{{ $prayerTimes['subuh'] }}</span>
                    </div>
                    <!-- Syuruk -->
                    <div :class="activePrayer === 'Syuruk' ? 'bg-amber-400 text-emerald-950 shadow-lg shadow-amber-400/10 border-amber-400' : 'bg-emerald-950/40 text-slate-300 border-emerald-800'" class="p-5 rounded-2xl text-center border transition-all duration-300 hover:scale-105">
                        <span class="text-xs font-semibold block tracking-wider uppercase opacity-80">Syuruk</span>
                        <span class="text-2xl font-bold tracking-tight block mt-2 font-mono">{{ $prayerTimes['syuruk'] }}</span>
                    </div>
                    <!-- Dzuhur -->
                    <div :class="activePrayer === 'Dzuhur' ? 'bg-amber-400 text-emerald-950 shadow-lg shadow-amber-400/10 border-amber-400' : 'bg-emerald-950/40 text-slate-300 border-emerald-800'" class="p-5 rounded-2xl text-center border transition-all duration-300 hover:scale-105">
                        <span class="text-xs font-semibold block tracking-wider uppercase opacity-80">Dzuhur</span>
                        <span class="text-2xl font-bold tracking-tight block mt-2 font-mono">{{ $prayerTimes['dzuhur'] }}</span>
                    </div>
                    <!-- Ashar -->
                    <div :class="activePrayer === 'Ashar' ? 'bg-amber-400 text-emerald-950 shadow-lg shadow-amber-400/10 border-amber-400' : 'bg-emerald-950/40 text-slate-300 border-emerald-800'" class="p-5 rounded-2xl text-center border transition-all duration-300 hover:scale-105">
                        <span class="text-xs font-semibold block tracking-wider uppercase opacity-80">Ashar</span>
                        <span class="text-2xl font-bold tracking-tight block mt-2 font-mono">{{ $prayerTimes['ashar'] }}</span>
                    </div>
                    <!-- Maghrib -->
                    <div :class="activePrayer === 'Maghrib' ? 'bg-amber-400 text-emerald-950 shadow-lg shadow-amber-400/10 border-amber-400' : 'bg-emerald-950/40 text-slate-300 border-emerald-800'" class="p-5 rounded-2xl text-center border transition-all duration-300 hover:scale-105">
                        <span class="text-xs font-semibold block tracking-wider uppercase opacity-80">Maghrib</span>
                        <span class="text-2xl font-bold tracking-tight block mt-2 font-mono">{{ $prayerTimes['maghrib'] }}</span>
                    </div>
                    <!-- Isya -->
                    <div :class="activePrayer === 'Isya' ? 'bg-amber-400 text-emerald-950 shadow-lg shadow-amber-400/10 border-amber-400' : 'bg-emerald-950/40 text-slate-300 border-emerald-800'" class="p-5 rounded-2xl text-center border transition-all duration-300 hover:scale-105">
                        <span class="text-xs font-semibold block tracking-wider uppercase opacity-80">Isya</span>
                        <span class="text-2xl font-bold tracking-tight block mt-2 font-mono">{{ $prayerTimes['isya'] }}</span>
                    </div>
                </div>

                <!-- Friday Prayer Schedule Staff info -->
                @if($nextFridaySchedule)
                    <div class="mt-8 pt-6 border-t border-emerald-800 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-3xl">🕌</span>
                            <div>
                                <h3 class="text-white font-bold text-sm sm:text-base">Petugas Shalat Jumat Terdekat</h3>
                                <p class="text-slate-300 text-xs mt-0.5">Tanggal Pelaksanaan: <span class="text-amber-400 font-semibold font-mono">{{ $nextFridaySchedule->date->format('d/m/Y') }}</span></p>
                            </div>
                        </div>
                       <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-emerald-950/60 px-6 py-4 rounded-2xl border border-amber-500/10 text-center w-full md:w-auto">
                            <div>
                                <span class="text-[9px] text-slate-400 block tracking-wider uppercase font-bold">Khotib</span>
                                <span class="text-xs sm:text-sm font-bold text-amber-400 block mt-0.5">{{ $nextFridaySchedule->khotib }}</span>
                            </div>
                            <div class="border-x border-emerald-800/80 px-4">
                                <span class="text-[9px] text-slate-400 block tracking-wider uppercase font-bold">Imam</span>
                                <span class="text-xs sm:text-sm font-bold text-white block mt-0.5">{{ $nextFridaySchedule->imam }}</span>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 block tracking-wider uppercase font-bold">Muadzin</span>
                                <span class="text-xs sm:text-sm font-bold text-slate-200 block mt-0.5">{{ $nextFridaySchedule->muadzin }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer (Re-using structure from welcome.blade.php) -->
    <footer class="bg-emerald-950 border-t border-amber-500/20 py-12 text-slate-400 text-sm text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <span class="text-2xl font-bold tracking-tight text-amber-400 block">{{ App\Models\Setting::getValue('masjid_name', 'Masjid Raya Al-Hikmah') }}</span>
            <p class="max-w-md mx-auto">{{ App\Models\Setting::getValue('masjid_address', 'Bandung') }}</p>
            <p class="text-xs text-slate-500 pt-4 border-t border-emerald-900/50">
                &copy; {{ date('Y') }} {{ App\Models\Setting::getValue('masjid_name', 'Masjid Raya Al-Hikmah') }}. Hak cipta dilindungi undang-undang.
            </p>
        </div>
    </footer>

    <!-- Active Prayer Time Script (AlpineJS component helper) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('prayerScheduleData', (timings) => ({
                timings: timings,
                activePrayer: '',
                nextPrayerName: '',
                countdown: '00:00:00',
                timer: null,

                init() {
                    this.updatePrayerStatus();
                    this.timer = setInterval(() => {
                        this.updatePrayerStatus();
                    }, 1000);
                },

                updatePrayerStatus() {
                    const now = new Date();
                    const currentHour = now.getHours();
                    const currentMin = now.getMinutes();
                    const currentSec = now.getSeconds();
                    
                    const timeToSec = (timeStr) => {
                        if (!timeStr) return 0;
                        const [h, m] = timeStr.split(':').map(Number);
                        return h * 3600 + m * 60;
                    };

                    const formatTime = (seconds) => {
                        const h = Math.floor(seconds / 3600).toString().padStart(2, '0');
                        const m = Math.floor((seconds % 3600) / 60).toString().padStart(2, '0');
                        const s = (seconds % 60).toString().padStart(2, '0');
                        return `${h}:${m}:${s}`;
                    };

                    const currentTotalSec = currentHour * 3600 + currentMin * 60 + currentSec;

                    // Prayer times map sorted chronologically
                    const prayers = [
                        { name: 'Imsak', sec: timeToSec(this.timings.imsak), raw: this.timings.imsak },
                        { name: 'Subuh', sec: timeToSec(this.timings.subuh), raw: this.timings.subuh },
                        { name: 'Syuruk', sec: timeToSec(this.timings.syuruk), raw: this.timings.syuruk },
                        { name: 'Dzuhur', sec: timeToSec(this.timings.dzuhur), raw: this.timings.dzuhur },
                        { name: 'Ashar', sec: timeToSec(this.timings.ashar), raw: this.timings.ashar },
                        { name: 'Maghrib', sec: timeToSec(this.timings.maghrib), raw: this.timings.maghrib },
                        { name: 'Isya', sec: timeToSec(this.timings.isya), raw: this.timings.isya }
                    ];

                    let activeIdx = -1;
                    let nextIdx = 0;

                    // Find where we are
                    for (let i = 0; i < prayers.length; i++) {
                        if (currentTotalSec >= prayers[i].sec) {
                            activeIdx = i;
                        }
                    }

                    if (activeIdx === -1) {
                        // Before Imsak: Active is Isya (of yesterday), Next is Imsak
                        this.activePrayer = 'Isya';
                        nextIdx = 0;
                    } else {
                        this.activePrayer = prayers[activeIdx].name;
                        nextIdx = (activeIdx + 1) % prayers.length;
                    }

                    const nextPrayer = prayers[nextIdx];
                    this.nextPrayerName = nextPrayer.name;

                    let diffSec = 0;
                    if (currentTotalSec <= nextPrayer.sec) {
                        diffSec = nextPrayer.sec - currentTotalSec;
                    } else {
                        // Next prayer is tomorrow (e.g. after Isya, next is Imsak tomorrow)
                        diffSec = (24 * 3600 - currentTotalSec) + nextPrayer.sec;
                    }

                    this.countdown = formatTime(diffSec);
                }
            }));
        });
    </script>

</body>
</html>
