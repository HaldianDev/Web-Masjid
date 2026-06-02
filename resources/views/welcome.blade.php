<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile['name'] }} - Portal Resmi</title>
    
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

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-32 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-emerald-900/60 via-emerald-950 to-green-950">
        <!-- Floating geometric elements -->
        <div class="absolute inset-0 opacity-10 pointer-events-none bg-[radial-gradient(#d4af37_1px,transparent_1px)] [background-size:24px_24px]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-7 text-center lg:text-left">
                    <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-emerald-800/60 text-xs font-semibold tracking-wider text-amber-400 border border-amber-500/10 mb-6">
                        🕌 PORTAL KEMAKMURAN MASJID
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6">
                        Menebar Kedamaian, <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 bg-clip-text text-transparent">Membangun Peradaban</span>
                    </h1>
                    <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto lg:mx-0">
                        Selamat datang di portal resmi {{ $profile['name'] }}. Kami berkomitmen untuk mewujudkan pengelolaan masjid yang modern, transparan, dan inklusif demi kemaslahatan seluruh jamaah.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="#donasi-section" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-emerald-950 font-bold rounded-full shadow-xl shadow-amber-500/10 hover:shadow-amber-500/20 text-center transition-all duration-300 transform hover:-translate-y-0.5">
                            Infaq & Sedekah Online
                        </a>
                        <a href="#kegiatan" class="w-full sm:w-auto px-8 py-4 bg-emerald-900/60 hover:bg-emerald-800/80 text-white font-semibold rounded-full border border-amber-500/20 text-center transition-all duration-300">
                            Lihat Agenda Masjid
                        </a>
                    </div>
                </div>
                
                <!-- Mosque Calligraphy / Dynamic Visual Artifact -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-80 h-80 sm:w-96 sm:h-96 rounded-3xl bg-gradient-to-tr from-emerald-800/40 to-amber-500/10 p-8 border border-amber-500/20 shadow-2xl flex flex-col items-center justify-center text-center">
                        <div class="absolute -top-4 -left-4 w-12 h-12 border-t-2 border-l-2 border-amber-400"></div>
                        <div class="absolute -bottom-4 -right-4 w-12 h-12 border-b-2 border-r-2 border-amber-400"></div>
                        
                        <span class="arabic-text text-5xl sm:text-6xl text-amber-400 mb-6">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</span>
                        <p class="text-sm text-slate-300 leading-relaxed max-w-xs">
                            "Hanya yang memakmurkan masjid-masjid Allah ialah orang-orang yang beriman kepada Allah dan Hari Kemudian..."
                        </p>
                        <span class="text-xs text-amber-500 font-semibold mt-4 block">QS. At-Tawbah: 18</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Digital Donation Section (Module 2 - Very Crucial) -->
    <section id="donasi-section" class="py-20 bg-[radial-gradient(ellipse_at_bottom,_var(--tw-gradient-stops))] from-emerald-950 via-emerald-900 to-green-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-emerald-800/50 px-4 py-1.5 rounded-full border border-amber-500/10">DONASI DIGITAL</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">Pundi Amal Sholeh Online</h2>
                <p class="text-slate-300 text-sm mt-3 max-w-xl mx-auto">Salurkan infaq, sedekah, dan donasi pembangunan renovasi terbaik Anda secara transparan. Sistem mendukung simulasi pembayaran instan.</p>
            </div>
            
            <div class="bg-gradient-to-br from-emerald-900/60 to-emerald-950/80 rounded-3xl p-8 border border-amber-500/20 shadow-2xl relative">
                <form action="{{ route('donation.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="donor_name" class="block text-xs font-semibold text-amber-400 uppercase tracking-wide mb-2">Nama Donatur</label>
                            <input type="text" id="donor_name" name="donor_name" required placeholder="Hamba Allah / Nama Anda" class="w-full bg-emerald-950/60 border border-emerald-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 transition-all">
                        </div>
                        <div>
                            <label for="donor_phone" class="block text-xs font-semibold text-amber-400 uppercase tracking-wide mb-2">Nomor Telepon (WA)</label>
                            <input type="text" id="donor_phone" name="donor_phone" placeholder="08xxxxxxxxxx" class="w-full bg-emerald-950/60 border border-emerald-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="amount" class="block text-xs font-semibold text-amber-400 uppercase tracking-wide mb-2">Jumlah Donasi (Rupiah)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-amber-400">Rp</span>
                            <input type="number" id="amount" name="amount" min="1000" required placeholder="Contoh: 50000" class="w-full bg-emerald-950/60 border border-emerald-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl pl-12 pr-4 py-3 text-slate-100 placeholder-slate-500 transition-all font-bold">
                        </div>
                        <!-- Quick buttons -->
                        <div class="flex flex-wrap gap-2 mt-3" x-data>
                            <button type="button" @click="document.getElementById('amount').value = 25000" class="px-4 py-1.5 bg-emerald-950/50 hover:bg-emerald-800/80 text-xs font-semibold rounded-lg border border-emerald-800 text-slate-300">Rp 25.000</button>
                            <button type="button" @click="document.getElementById('amount').value = 50000" class="px-4 py-1.5 bg-emerald-950/50 hover:bg-emerald-800/80 text-xs font-semibold rounded-lg border border-emerald-800 text-slate-300">Rp 50.000</button>
                            <button type="button" @click="document.getElementById('amount').value = 100000" class="px-4 py-1.5 bg-emerald-950/50 hover:bg-emerald-800/80 text-xs font-semibold rounded-lg border border-emerald-800 text-slate-300">Rp 100.000</button>
                            <button type="button" @click="document.getElementById('amount').value = 250000" class="px-4 py-1.5 bg-emerald-950/50 hover:bg-emerald-800/80 text-xs font-semibold rounded-lg border border-emerald-800 text-slate-300">Rp 250.000</button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-amber-400 uppercase tracking-wide mb-3">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                            <label class="relative border border-emerald-800 bg-emerald-950/40 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer hover:border-amber-500/50 transition-all group">
                                <input type="radio" name="payment_method" value="qris" checked class="sr-only">
                                <span class="text-sm font-bold text-slate-200 group-hover:text-amber-400 transition-colors">QRIS</span>
                                <span class="text-[10px] text-slate-400 mt-1">E-Wallet / Bank</span>
                            </label>
                            
                            <label class="relative border border-emerald-800 bg-emerald-950/40 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer hover:border-amber-500/50 transition-all group">
                                <input type="radio" name="payment_method" value="bca" class="sr-only">
                                <span class="text-sm font-bold text-slate-200 group-hover:text-amber-400 transition-colors">BCA</span>
                                <span class="text-[10px] text-slate-400 mt-1">Transfer VA</span>
                            </label>

                            <label class="relative border border-emerald-800 bg-emerald-950/40 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer hover:border-amber-500/50 transition-all group">
                                <input type="radio" name="payment_method" value="mandiri" class="sr-only">
                                <span class="text-sm font-bold text-slate-200 group-hover:text-amber-400 transition-colors">Mandiri</span>
                                <span class="text-[10px] text-slate-400 mt-1">Transfer VA</span>
                            </label>

                            <label class="relative border border-emerald-800 bg-emerald-950/40 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer hover:border-amber-500/50 transition-all group">
                                <input type="radio" name="payment_method" value="gopay" class="sr-only">
                                <span class="text-sm font-bold text-slate-200 group-hover:text-amber-400 transition-colors">Gopay</span>
                                <span class="text-[10px] text-slate-400 mt-1">Gojek App</span>
                            </label>

                            <label class="relative border border-emerald-800 bg-emerald-950/40 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer hover:border-amber-500/50 transition-all group">
                                <input type="radio" name="payment_method" value="ovo" class="sr-only">
                                <span class="text-sm font-bold text-slate-200 group-hover:text-amber-400 transition-colors">OVO</span>
                                <span class="text-[10px] text-slate-400 mt-1">OVO App</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-xs font-semibold text-amber-400 uppercase tracking-wide mb-2">Pesan & Doa (Opsional)</label>
                        <textarea id="notes" name="notes" rows="2" placeholder="Tulis doa atau pesan khusus di sini..." class="w-full bg-emerald-950/60 border border-emerald-800 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 rounded-xl px-4 py-3 text-slate-100 placeholder-slate-500 transition-all"></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-emerald-950 font-bold rounded-xl shadow-lg shadow-amber-500/10 text-center transition-all hover:scale-[1.01] duration-150">
                        Kirim Donasi & Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>
                </section>
            
    
    </body>
</html>
