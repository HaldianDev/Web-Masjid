<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transparansi Kas - {{ config('app.name', "As-Sa'adah Desa Belambangan") }}</title>
    
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

    <!-- Financial Transparency & ZIS Board (Module 2) -->
    <section class="py-20 bg-emerald-950 border-t border-b border-amber-500/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-400 bg-emerald-800/50 px-4 py-1.5 rounded-full border border-amber-500/10">TRANSPARANSI KAS</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">Laporan Keuangan & ZIS</h2>
                <p class="text-slate-300 text-sm mt-3 max-w-xl mx-auto">Bentuk transparansi total pengelolaan kas, infaq, zakat fitrah, dan sedekah jamaah secara akuntabel.</p>
            </div>
            
            <!-- Cards Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-gradient-to-br from-emerald-900/30 to-emerald-950 p-6 rounded-2xl border border-emerald-850 shadow-xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-800/80 flex items-center justify-center shadow-lg text-emerald-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block font-medium">Total Penerimaan (Inflow)</span>
                        <span class="text-2xl font-bold text-white tracking-tight mt-1 font-mono">Rp {{ number_format($totalIn, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-900/30 to-emerald-950 p-6 rounded-2xl border border-emerald-850 shadow-xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-950/60 flex items-center justify-center shadow-lg text-red-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block font-medium">Total Pengeluaran (Outflow)</span>
                        <span class="text-2xl font-bold text-white tracking-tight mt-1 font-mono">Rp {{ number_format($totalOut, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-emerald-900/30 to-emerald-950 p-6 rounded-2xl border border-emerald-850 shadow-xl flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-400 flex items-center justify-center shadow-lg text-emerald-950">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block font-medium">Saldo Kas Masjid (Net)</span>
                        <span class="text-2xl font-bold text-amber-400 tracking-tight mt-1 font-mono">Rp {{ number_format($balance, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" x-data="{ activeFinTab: 'transaksi' }">
                <!-- Recent transactions table -->
                <div class="lg:col-span-8 bg-gradient-to-b from-emerald-900/20 to-emerald-950/60 p-6 rounded-3xl border border-emerald-850 shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4 border-b border-emerald-850 pb-3 flex-col sm:flex-row gap-2">
                            <h3 class="text-lg font-bold text-white">Transparansi Pembukuan Kas</h3>
                            <div class="flex space-x-2 text-[9px] font-bold uppercase tracking-wider">
                                <button @click="activeFinTab = 'transaksi'" :class="activeFinTab === 'transaksi' ? 'bg-amber-400 text-emerald-950 font-extrabold' : 'bg-emerald-950/40 text-slate-400 border-emerald-800'" class="px-2.5 py-1.5 rounded-lg border transition-all">Terakhir</button>
                                <button @click="activeFinTab = 'mingguan'" :class="activeFinTab === 'mingguan' ? 'bg-amber-400 text-emerald-950 font-extrabold' : 'bg-emerald-950/40 text-slate-400 border-emerald-800'" class="px-2.5 py-1.5 rounded-lg border transition-all">Mingguan</button>
                                <button @click="activeFinTab = 'bulanan'" :class="activeFinTab === 'bulanan' ? 'bg-amber-400 text-emerald-950 font-extrabold' : 'bg-emerald-950/40 text-slate-400 border-emerald-800'" class="px-2.5 py-1.5 rounded-lg border transition-all">Bulanan</button>
                            </div>
                        </div>

                        <!-- Tab: Transaksi Terakhir -->
                        <div x-show="activeFinTab === 'transaksi'" x-transition:enter="transition ease-out duration-250" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead>
                                        <tr class="text-slate-400 border-b border-emerald-800/80">
                                            <th class="py-2.5 px-2">Tanggal</th>
                                            <th class="py-2.5 px-2">Keterangan</th>
                                            <th class="py-2.5 px-2">Kategori</th>
                                            <th class="py-2.5 px-2 text-right">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-emerald-900/40">
                                        @foreach($recentTransactions as $tx)
                                            <tr class="text-slate-300">
                                                <td class="py-3 px-2 font-mono">{{ $tx->transaction_date->format('d/m/Y') }}</td>
                                                <td class="py-3 px-2 max-w-xs truncate" title="{{ $tx->description }}">{{ $tx->description }}</td>
                                                <td class="py-3 px-2 uppercase font-semibold text-[9px] text-amber-400">
                                                    {{ str_replace('_', ' ', $tx->category) }}
                                                </td>
                                                <td class="py-3 px-2 text-right font-mono font-bold {{ $tx->type === 'in' ? 'text-emerald-400' : 'text-red-400' }}">
                                                    {{ $tx->type === 'in' ? '+' : '-' }} {{ number_format($tx->amount, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab: Laporan Mingguan -->
                        <div x-show="activeFinTab === 'mingguan'" x-transition:enter="transition ease-out duration-250" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead>
                                        <tr class="text-slate-400 border-b border-emerald-800/80">
                                            <th class="py-2.5 px-2">Minggu</th>
                                            <th class="py-2.5 px-2 text-right">Penerimaan</th>
                                            <th class="py-2.5 px-2 text-right">Pengeluaran</th>
                                            <th class="py-2.5 px-2 text-right">Saldo Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-emerald-900/40">
                                        @forelse($weeklyFinances as $wf)
                                            <tr class="text-slate-300">
                                                <td class="py-3 px-2 font-bold text-white">Minggu #{{ $wf->week }} ({{ $wf->year }})</td>
                                                <td class="py-3 px-2 text-right font-mono text-emerald-400">Rp {{ number_format($wf->total_in, 0, ',', '.') }}</td>
                                                <td class="py-3 px-2 text-right font-mono text-red-400">Rp {{ number_format($wf->total_out, 0, ',', '.') }}</td>
                                                <td class="py-3 px-2 text-right font-mono font-bold {{ ($wf->total_in - $wf->total_out) >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                                    Rp {{ number_format($wf->total_in - $wf->total_out, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="py-4 text-center text-slate-400">Belum ada laporan mingguan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab: Laporan Bulanan -->
                        <div x-show="activeFinTab === 'bulanan'" x-transition:enter="transition ease-out duration-250" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead>
                                        <tr class="text-slate-400 border-b border-emerald-800/80">
                                            <th class="py-2.5 px-2">Bulan</th>
                                            <th class="py-2.5 px-2 text-right">Penerimaan</th>
                                            <th class="py-2.5 px-2 text-right">Pengeluaran</th>
                                            <th class="py-2.5 px-2 text-right">Saldo Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-emerald-900/40">
                                        @forelse($monthlyFinances as $mf)
                                            <tr class="text-slate-300">
                                                <td class="py-3 px-2 font-bold text-white">
                                                    {{ Carbon\Carbon::create()->month($mf->month)->isoFormat('MMMM') }} ({{ $mf->year }})
                                                </td>
                                                <td class="py-3 px-2 text-right font-mono text-emerald-400">Rp {{ number_format($mf->total_in, 0, ',', '.') }}</td>
                                                <td class="py-3 px-2 text-right font-mono text-red-400">Rp {{ number_format($mf->total_out, 0, ',', '.') }}</td>
                                                <td class="py-3 px-2 text-right font-mono font-bold {{ ($mf->total_in - $mf->total_out) >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                                    Rp {{ number_format($mf->total_in - $mf->total_out, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="py-4 text-center text-slate-400">Belum ada laporan bulanan.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zakat distribution logs (ZIS Summary) -->
                <div class="lg:col-span-4 bg-gradient-to-b from-emerald-900/20 to-emerald-950/60 p-6 rounded-3xl border border-emerald-850 shadow-xl space-y-6">
                    <h3 class="text-lg font-bold text-white mb-2 border-b border-emerald-850 pb-3">Rekap Zakat, Infaq & Sedekah (ZIS)</h3>
                    
                    <div class="space-y-4 text-sm">
                        <div class="p-4 bg-emerald-950/60 rounded-xl border border-emerald-800">
                            <span class="text-xs text-slate-400 block font-medium">Zakat Masuk (Muzakki)</span>
                            <div class="flex items-center justify-between mt-2 font-mono">
                                <span class="text-emerald-400 font-bold">Rp {{ number_format($zisStats['total_muzakki_money'], 0, ',', '.') }}</span>
                                <span class="text-slate-300">{{ number_format($zisStats['total_muzakki_rice'], 1, ',', '.') }} kg Beras</span>
                            </div>
                        </div>

                        <div class="p-4 bg-emerald-950/60 rounded-xl border border-emerald-800">
                            <span class="text-xs text-slate-400 block font-medium">Zakat Disalurkan (Mustahik)</span>
                            <div class="flex items-center justify-between mt-2 font-mono">
                                <span class="text-red-400 font-bold">Rp {{ number_format($zisStats['total_mustahik_money'], 0, ',', '.') }}</span>
                                <span class="text-slate-300">{{ number_format($zisStats['total_mustahik_rice'], 1, ',', '.') }} kg Beras</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 text-center mt-4">
                            <div class="p-3 bg-emerald-950/40 rounded-xl border border-emerald-850">
                                <span class="text-2xl font-bold text-white font-mono block">{{ $zisStats['count_muzakki'] }}</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wide">Muzakki Terdaftar</span>
                            </div>
                            <div class="p-3 bg-emerald-950/40 rounded-xl border border-emerald-850">
                                <span class="text-2xl font-bold text-white font-mono block">{{ $zisStats['count_mustahik'] }}</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wide">Mustahik Terdaftar</span>
                            </div>
                        </div>
                    </div>
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
