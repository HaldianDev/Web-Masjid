<x-app-layout>
    <div class="space-y-6 text-white">

        <!-- Welcome -->
        <div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-emerald-950 
                    border border-amber-500/20 p-6 rounded-2xl shadow-xl flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-white">
                    Assalamu'alaikum, {{ Auth::user()->name }}!
                </h3>
                <p class="text-sm text-emerald-100 mt-1">
                    Selamat datang di Panel DKM As-Sa'adah Desa Belambangan. Gunakan menu sidebar untuk navigasi.
                </p>
            </div>
            <span class="text-5xl hidden sm:block">🕌</span>
        </div>

        <!-- CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- SALDO -->
            <div class="relative overflow-hidden rounded-2xl p-6 
                        bg-gradient-to-br from-emerald-800 via-emerald-900 to-emerald-950
                        border border-emerald-700 shadow-lg hover:scale-[1.02] transition">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-400/10 rounded-full blur-2xl"></div>

                <p class="text-xs font-semibold uppercase text-emerald-200">
                    Saldo Kas
                </p>
                <p class="text-2xl font-bold text-amber-400 font-mono mt-2">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </p>
                <p class="text-xs text-emerald-100 mt-3">
                    Masuk: <span class="text-white font-semibold">
                        Rp {{ number_format($totalIn, 0, ',', '.') }}
                    </span>
                </p>
            </div>

            <!-- DONASI -->
            <div class="relative overflow-hidden rounded-2xl p-6 
                        bg-gradient-to-br from-indigo-900 via-emerald-950 to-emerald-900
                        border border-indigo-700 shadow-lg hover:scale-[1.02] transition">

                <p class="text-xs font-semibold uppercase text-indigo-200">
                    Donasi Digital
                </p>

                <p class="text-2xl font-bold text-amber-400 font-mono mt-2">
                    Rp {{ number_format($totalDonationSuccess, 0, ',', '.') }}
                </p>

                <p class="text-xs mt-3">
                    <span class="text-red-400 font-semibold">
                        Pending: {{ $pendingDonationsCount }} transaksi
                    </span>
                </p>
            </div>

            <!-- KEGIATAN -->
            <div class="rounded-2xl p-6 bg-gradient-to-br from-emerald-900 via-emerald-950 to-emerald-900
                        border border-emerald-700 shadow-lg hover:scale-[1.02] transition">

                <p class="text-xs font-semibold uppercase text-emerald-200">
                    Kegiatan
                </p>

                <p class="text-3xl font-bold text-white mt-2">
                    {{ $activityCount }}
                </p>

                <p class="text-xs mt-3 text-emerald-100">
                    Artikel: <span class="text-white font-semibold">{{ $articleCount }}</span>
                </p>
            </div>

            <!-- ASET -->
            <div class="rounded-2xl p-6 bg-gradient-to-br from-amber-900/40 via-emerald-950 to-emerald-900
                        border border-amber-700/40 shadow-lg hover:scale-[1.02] transition">

                <p class="text-xs font-semibold uppercase text-amber-200">
                    Aset Masjid
                </p>

                <p class="text-3xl font-bold text-white mt-2">
                    {{ $inventoryCount }}
                </p>

                <p class="text-xs mt-3 text-amber-100">
                    Barang terdata
                </p>
            </div>

        </div>

        <!-- ZIS -->
        <div class="rounded-2xl p-6 bg-emerald-950 border border-emerald-800 shadow-lg">

            <h3 class="text-sm font-bold text-amber-400 uppercase mb-4">
                Rekap Zakat, Infaq & Sedekah
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="p-4 rounded-xl bg-emerald-900 border border-emerald-800">
                    <p class="text-xs text-emerald-200">Muzakki Uang</p>
                    <p class="text-lg font-bold text-white font-mono">
                        Rp {{ number_format($zisMuzakkiMoney, 0, ',', '.') }}
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-emerald-900 border border-emerald-800">
                    <p class="text-xs text-emerald-200">Muzakki Beras</p>
                    <p class="text-lg font-bold text-white font-mono">
                        {{ number_format($zisMuzakkiRice, 1, ',', '.') }} kg
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-red-900/30 border border-red-700">
                    <p class="text-xs text-red-200">Mustahik Uang</p>
                    <p class="text-lg font-bold text-white font-mono">
                        Rp {{ number_format($zisMustahikMoney, 0, ',', '.') }}
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-red-900/30 border border-red-700">
                    <p class="text-xs text-red-200">Mustahik Beras</p>
                    <p class="text-lg font-bold text-white font-mono">
                        {{ number_format($zisMustahikRice, 1, ',', '.') }} kg
                    </p>
                </div>

            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- TRANSAKSI -->
            <div class="rounded-2xl p-6 bg-emerald-950 border border-emerald-800">
                <h3 class="text-sm font-bold text-amber-400 mb-4">
                    Transaksi Terakhir
                </h3>

                <div class="space-y-3">
                    @forelse($recentTransactions as $tx)
                        <div class="flex justify-between items-center text-sm border-b border-emerald-800 pb-2">
                            <span class="text-emerald-200 font-mono">
                                {{ $tx->transaction_date->format('d/m/Y') }}
                            </span>

                            <span class="text-white truncate max-w-[180px]">
                                {{ $tx->description }}
                            </span>

                            <span class="font-bold font-mono {{ $tx->type == 'in' ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $tx->type == 'in' ? '+' : '-' }}{{ number_format($tx->amount) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-emerald-200 text-sm">Belum ada transaksi</p>
                    @endforelse
                </div>
            </div>

            <!-- KEGIATAN -->
            <div class="rounded-2xl p-6 bg-emerald-950 border border-emerald-800">
                <h3 class="text-sm font-bold text-amber-400 mb-4">
                    Agenda Kegiatan
                </h3>

                <div class="space-y-3">
                    @forelse($recentActivities as $act)
                        <div class="p-3 rounded-xl bg-emerald-900 border border-emerald-800">
                            <div class="flex justify-between">
                                <p class="text-sm font-bold text-white">
                                    {{ $act->title }}
                                </p>
                                <span class="text-xs text-amber-400 font-mono">
                                    {{ $act->event_date->format('d M') }}
                                </span>
                            </div>

                            <p class="text-xs text-emerald-200 mt-1">
                                {{ $act->location }}
                            </p>
                        </div>
                    @empty
                        <p class="text-emerald-200 text-sm">Belum ada kegiatan</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>