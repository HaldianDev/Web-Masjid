<!-- Top Navigation Header -->
<header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 backdrop-blur-md bg-emerald-950/70 border-b border-amber-500/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center space-x-3 group shrink-0">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-tr from-amber-400 to-amber-500 flex items-center justify-center shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform duration-300">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-emerald-950" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div class="min-w-0">
                <span class="text-base sm:text-xl font-bold tracking-tight text-amber-400 block group-hover:text-amber-300 transition-colors truncate">{{ App\Models\Setting::getValue('masjid_name', 'Masjid Raya Al-Hikmah') }}</span>
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
