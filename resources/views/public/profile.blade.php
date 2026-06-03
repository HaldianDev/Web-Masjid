<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Masjid - {{ config('app.name', "As-Sa'adah Desa Belambangan") }}</title>
    
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
    <!-- Top Navigation Header -->
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


    <!-- Profile Section (Module 1) -->
    <section class="py-20 bg-gradient-to-br from-emerald-950 via-emerald-900 to-green-950">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'sejarah' }">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-emerald-800/50 px-4 py-1.5 rounded-full border border-amber-500/10">PROFIL</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">Profil Singkat Masjid</h2>
                <p class="text-slate-300 text-sm mt-3 max-w-xl mx-auto">Pelajari struktur, sejarah, legalitas hukum, dan sarana prasarana penunjang peribadatan jamaah.</p>
            </div>
            
            <!-- Navigation Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-8 bg-emerald-950/80 p-2 rounded-2xl border border-emerald-800 max-w-fit mx-auto">
                <button @click="activeTab = 'sejarah'" :class="activeTab === 'sejarah' ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all">Sejarah</button>
                <button @click="activeTab = 'visi'" :class="activeTab === 'visi' ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all">Visi & Misi</button>
                <button @click="activeTab = 'takmir'" :class="activeTab === 'takmir' ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all">Struktur DKM</button>
                <button @click="activeTab = 'fasilitas'" :class="activeTab === 'fasilitas' ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all">Fasilitas</button>
                <button @click="activeTab = 'legalitas'" :class="activeTab === 'legalitas' ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all">Legalitas Formal</button>
            </div>

            <!-- Tab Contents -->
            <div class="bg-gradient-to-b from-emerald-900/40 to-emerald-950/80 rounded-3xl p-8 sm:p-10 border border-emerald-850 shadow-2xl min-h-[300px]">
                
                <!-- Sejarah -->
                <div x-show="activeTab === 'sejarah'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <h3 class="text-xl font-bold text-white border-b border-emerald-850 pb-3 flex items-center">
                        <span class="w-2.5 h-6 bg-amber-400 rounded-full mr-3"></span>
                        Sejarah Masjid
                    </h3>
                    <p class="text-slate-300 leading-relaxed text-sm whitespace-pre-line">{{ $profile['history'] }}</p>
                </div>

                <!-- Visi & Misi -->
                <div x-show="activeTab === 'visi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
                    <div>
                        <h3 class="text-xl font-bold text-white border-b border-emerald-850 pb-3 flex items-center mb-4">
                            <span class="w-2.5 h-6 bg-amber-400 rounded-full mr-3"></span>
                            Visi DKM
                        </h3>
                        <p class="text-slate-200 text-md italic font-medium">"{{ $profile['vision'] }}"</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white border-b border-emerald-850 pb-3 flex items-center mb-4">
                            <span class="w-2.5 h-6 bg-amber-400 rounded-full mr-3"></span>
                            Misi DKM
                        </h3>
                        <p class="text-slate-300 text-sm whitespace-pre-line leading-relaxed">{{ $profile['mission'] }}</p>
                    </div>
                </div>

                <!-- Struktur Takmir -->
                <div x-show="activeTab === 'takmir'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <h3 class="text-xl font-bold text-white border-b border-emerald-850 pb-3 flex items-center">
                        <span class="w-2.5 h-6 bg-amber-400 rounded-full mr-3"></span>
                        Struktur Organisasi Takmir (DKM)
                    </h3>
                    <p class="text-slate-300 text-sm whitespace-pre-line leading-relaxed">{{ $profile['structure'] }}</p>
                    
                    <div class="mt-8 p-4 bg-emerald-950/40 border border-emerald-800/50 rounded-2xl flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-amber-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-emerald-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs text-slate-300">Bagi pengurus yang terdaftar dan ingin mengubah data profil masjid, silakan masuk ke dashboard administrasi menggunakan akun masing-masing.</p>
                    </div>
                </div>

                <!-- Fasilitas -->
                <div x-show="activeTab === 'fasilitas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <h3 class="text-xl font-bold text-white border-b border-emerald-850 pb-3 flex items-center">
                        <span class="w-2.5 h-6 bg-amber-400 rounded-full mr-3"></span>
                        Sarana & Fasilitas Masjid
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach(explode(',', $profile['facilities']) as $fac)
                            @if(trim($fac))
                                <div class="bg-emerald-950/40 p-4 rounded-xl border border-emerald-800 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 mr-3"></span>
                                    <span class="text-slate-300 text-sm font-medium">{{ trim($fac) }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Legalitas -->
                <div x-show="activeTab === 'legalitas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-6">
                    <h3 class="text-xl font-bold text-white border-b border-emerald-850 pb-3 flex items-center">
                        <span class="w-2.5 h-6 bg-amber-400 rounded-full mr-3"></span>
                        Legalitas & Perizinan DKM
                    </h3>
                    <p class="text-slate-300 text-sm whitespace-pre-line leading-relaxed">{{ $profile['legalities'] }}</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer (Re-using structure from welcome.blade.php) -->
    <footer class="bg-emerald-950 border-t border-amber-500/20 py-12 text-slate-400 text-sm text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <span class="text-2xl font-bold tracking-tight text-amber-400 block">{{ App\Models\Setting::getValue('masjid_name', "As-Sa'adah Desa Belambangan") }}</span>
            <p class="max-w-md mx-auto">{{ App\Models\Setting::getValue('masjid_address', 'Bandung') }}</p>
            <p class="text-xs text-slate-500 pt-4 border-t border-emerald-900/50">
                &copy; {{ date('Y') }} {{ App\Models\Setting::getValue('masjid_name', "As-Sa'adah Desa Belambangan") }}. Hak cipta dilindungi undang-undang.
            </p>
        </div>
    </footer>

</body>
</html>
