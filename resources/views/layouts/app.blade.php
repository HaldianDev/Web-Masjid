<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800" x-data="{ mobileSidebarOpen: false }">
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Mobile Top Navbar -->
        <header class="md:hidden bg-emerald-900 text-white h-16 px-4 flex items-center justify-between border-b border-amber-500/20 sticky top-0 z-40">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                <span class="font-bold text-amber-400 tracking-wide text-sm">{{ App\Models\Setting::getValue('masjid_name', 'DKM Al-Hikmah') }}</span>
            </a>
            <button @click="mobileSidebarOpen = !mobileSidebarOpen" class="p-2 rounded-lg hover:bg-emerald-800 text-slate-200 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </header>

        <!-- Left Sidebar (Desktop permanent, Mobile slide-over) -->
        <aside :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
               class="fixed md:sticky top-0 left-0 z-50 w-64 h-screen bg-emerald-950 text-slate-100 flex flex-col justify-between border-r border-amber-500/10 shadow-2xl transition-transform duration-300 ease-in-out">
            
            <!-- Top brand & scrollable menu items -->
            <div class="flex flex-col h-full overflow-y-auto">
                
                <!-- Brand logo and name -->
                <div class="h-20 border-b border-emerald-900/60 px-6 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full bg-amber-400 flex items-center justify-center">
                            <span class="text-emerald-950 font-black text-xs">DKM</span>
                        </div>
                        <div>
                            <span class="font-bold text-amber-400 text-sm block">DKM Al-Hikmah</span>
                            <span class="text-[10px] text-slate-400 block -mt-1">Halaman Depan ↗</span>
                        </div>
                    </a>
                    <button @click="mobileSidebarOpen = false" class="md:hidden text-slate-400 hover:text-white p-1 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- User Quick Info -->
                <div class="px-6 py-4 bg-emerald-900/30 border-b border-emerald-900/50">
                    <span class="text-xs text-slate-400 block">Logged in as:</span>
                    <span class="text-sm font-bold text-white block truncate">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-amber-400 font-semibold px-2 py-0.5 rounded bg-emerald-950 border border-amber-500/20 inline-block mt-1 uppercase">
                        {{ Auth::user()->roles->first()?->name ?? 'User' }}
                    </span>
                </div>

                <!-- Navigation links -->
                <nav class="px-4 py-6 space-y-7">
                    <!-- General -->
                    <div class="space-y-1.5">
                        <span class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">UTAMA</span>
                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span class="text-sm">Ringkasan</span>
                        </a>
                    </div>

                    <!-- Modul Informasi (Marbot, Super Admin) -->
                    @can('manage content')
                        <div class="space-y-1.5">
                            <span class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">KONTEN & INFORMASI</span>
                            <a href="{{ route('admin.activities.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.activities.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-sm">Jadwal & Kegiatan</span>
                            </a>
                            <a href="{{ route('admin.friday-schedules.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.friday-schedules.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="text-sm">Jadwal Jumat</span>
                            </a>
                            <a href="{{ route('admin.articles.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.articles.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                <span class="text-sm">Artikel & Khotbah</span>
                            </a>
                            <a href="{{ route('admin.settings.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-sm">Profil Masjid</span>
                            </a>
                        </div>
                    @endcan
 
                    <!-- Modul Keuangan (Bendahara, Super Admin) -->
                    @can('manage finance')
                        <div class="space-y-1.5">
                            <span class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">KEUANGAN & ZIS</span>
                            <a href="{{ route('admin.finances.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.finances.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="text-sm">Laporan Kas</span>
                            </a>
                            <a href="{{ route('admin.qurbans.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.qurbans.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <span class="text-sm">Pendaftaran Qurban</span>
                            </a>
                            <a href="{{ route('admin.donations.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.donations.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span class="text-sm">Donasi Digital</span>
                            </a>
                            <a href="{{ route('admin.zis.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.zis.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="text-sm">Zakat, Infaq & Sedekah</span>
                            </a>
                        </div>
                    @endcan

                    <!-- Modul Logistik (Marbot, Bendahara, Super Admin) -->
                    @can('manage inventory')
                        <div class="space-y-1.5">
                            <span class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">LOGISTIK & OPERASIONAL</span>
                            <a href="{{ route('admin.inventory.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.inventory.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <span class="text-sm">Inventaris Aset</span>
                            </a>
                        </div>
                    @endcan

                    <!-- Modul User (Super Admin only) -->
                    @can('manage users')
                        <div class="space-y-1.5">
                            <span class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">PENGATURAN SISTEM</span>
                            <a href="{{ route('admin.users.index') }}" 
                               class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-amber-400 text-emerald-950 font-bold' : 'text-slate-300 hover:bg-emerald-900/50 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span class="text-sm">Manajemen User</span>
                            </a>
                        </div>
                    @endcan
                </nav>
            </div>

            <!-- Bottom Log Out Actions -->
            <div class="p-4 border-t border-emerald-900/60 bg-emerald-950">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 rounded-xl bg-red-950/60 hover:bg-red-900/80 text-red-300 text-xs font-bold transition-all border border-red-500/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Main Workspace Area -->
        <div class="flex-1 flex flex-col min-w-0 bg-gray-50">
            <!-- Optional Subheader with title -->
            @isset($header)
                <header class="bg-white border-b border-gray-200 hidden md:block">
                    <div class="max-w-7xl mx-auto py-5 px-6 sm:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Main Content Slot -->
            <main class="flex-grow p-6 sm:p-8">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>
