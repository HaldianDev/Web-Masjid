<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Buku Kas Masjid') }}
            </h2>
            <a href="{{ route('admin.finances.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                + Catat Transaksi Kas
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 text-xs" x-data="{ activeTab: 'transaksi' }">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Cash Metrics Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">IN</div>
                <div>
                    <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Total Penerimaan</span>
                    <span class="text-xl font-bold text-gray-800 font-mono block mt-1">Rp {{ number_format($totalIn, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-red-100 text-red-650 flex items-center justify-center font-bold">OUT</div>
                <div>
                    <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Total Pengeluaran</span>
                    <span class="text-xl font-bold text-gray-800 font-mono block mt-1">Rp {{ number_format($totalOut, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold">NET</div>
                <div>
                    <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Saldo Bersih Kas</span>
                    <span class="text-xl font-bold text-emerald-600 font-mono block mt-1">Rp {{ number_format($balance, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Tab Headers -->
        <div class="flex border-b border-gray-200 bg-white p-2 rounded-2xl shadow-sm space-x-2">
            <button @click="activeTab = 'transaksi'" 
                    :class="activeTab === 'transaksi' ? 'bg-emerald-700 text-white font-bold' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2.5 rounded-xl transition-all font-semibold">
                Daftar Transaksi
            </button>
            <button @click="activeTab = 'mingguan'" 
                    :class="activeTab === 'mingguan' ? 'bg-emerald-700 text-white font-bold' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2.5 rounded-xl transition-all font-semibold">
                Laporan Mingguan
            </button>
            <button @click="activeTab = 'bulanan'" 
                    :class="activeTab === 'bulanan' ? 'bg-emerald-700 text-white font-bold' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2.5 rounded-xl transition-all font-semibold">
                Laporan Bulanan
            </button>
            <button @click="activeTab = 'tahunan'" 
                    :class="activeTab === 'tahunan' ? 'bg-emerald-700 text-white font-bold' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2.5 rounded-xl transition-all font-semibold">
                Laporan Tahunan
            </button>
        </div>

        <!-- Tab: Daftar Transaksi -->
        <div x-show="activeTab === 'transaksi'" class="space-y-6">
            <!-- Filter Controls -->
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <form method="GET" action="{{ route('admin.finances.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="type" class="block font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Tipe Transaksi</label>
                        <select id="type" name="type" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-3 py-2 text-gray-850">
                            <option value="">Semua</option>
                            <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Uang Masuk (Penerimaan)</option>
                            <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Uang Keluar (Pengeluaran)</option>
                        </select>
                    </div>
                    <div>
                        <label for="category" class="block font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Kategori</label>
                        <select id="category" name="category" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-3 py-2 text-gray-850">
                            <option value="">Semua</option>
                            <option value="infak_jumat" {{ request('category') === 'infak_jumat' ? 'selected' : '' }}>Infak Shalat Jumat</option>
                            <option value="donasi_digital" {{ request('category') === 'donasi_digital' ? 'selected' : '' }}>Donasi Digital</option>
                            <option value="operasional" {{ request('category') === 'operasional' ? 'selected' : '' }}>Operasional Masjid</option>
                            <option value="pemeliharaan" {{ request('category') === 'pemeliharaan' ? 'selected' : '' }}>Pemeliharaan & Renovasi</option>
                            <option value="gaji" {{ request('category') === 'gaji' ? 'selected' : '' }}>Gaji Marbot/Petugas</option>
                            <option value="lainnya" {{ request('category') === 'lainnya' ? 'selected' : '' }}>Lain-lain</option>
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="flex-1 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition-colors">Saring</button>
                        <a href="{{ route('admin.finances.index') }}" class="py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold border border-gray-250 rounded-xl text-center">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Ledger Entries Table -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                                <th class="py-3 px-6">Tanggal</th>
                                <th class="py-3 px-6">Tipe</th>
                                <th class="py-3 px-6">Kategori</th>
                                <th class="py-3 px-6">Deskripsi / Keterangan</th>
                                <th class="py-3 px-6">Pencatat</th>
                                <th class="py-3 px-6 text-right">Jumlah</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150 text-gray-600">
                            @forelse($finances as $tx)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-6 font-mono font-medium text-gray-800">{{ $tx->transaction_date->format('d/m/Y') }}</td>
                                    <td class="py-4 px-6">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $tx->type === 'in' ? 'bg-emerald-50 text-emerald-700 border-emerald-150' : 'bg-red-50 text-red-650 border-red-150' }} border">
                                            {{ $tx->type === 'in' ? 'Masuk' : 'Keluar' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="uppercase tracking-wider text-[10px] font-extrabold text-amber-600">
                                            {{ str_replace('_', ' ', $tx->category) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 font-medium text-gray-900 max-w-xs truncate" title="{{ $tx->description }}">{{ $tx->description }}</td>
                                    <td class="py-4 px-6">{{ $tx->user->name ?? 'System' }}</td>
                                    <td class="py-4 px-6 text-right font-mono font-bold text-sm {{ $tx->type === 'in' ? 'text-emerald-600' : 'text-red-500' }}">
                                        {{ $tx->type === 'in' ? '+' : '-' }} {{ number_format($tx->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6 flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.finances.edit', $tx->id) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold border border-amber-250 rounded-lg">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.finances.destroy', $tx->id) }}" method="POST" class="confirm-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-650 font-bold border border-red-250 rounded-lg">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-400 font-semibold">Belum ada transaksi kas yang sesuai kriteria.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($finances->hasPages())
                    <div class="px-6 py-4 border-t border-gray-150">
                        {{ $finances->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Tab: Laporan Mingguan -->
        <div x-show="activeTab === 'mingguan'">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Tahun</th>
                            <th class="py-3 px-6">Minggu Ke-</th>
                            <th class="py-3 px-6 text-right">Penerimaan (Masuk)</th>
                            <th class="py-3 px-6 text-right">Pengeluaran (Keluar)</th>
                            <th class="py-3 px-6 text-right font-bold">Saldo Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($weeklyRecs as $week)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-mono font-semibold">{{ $week->year }}</td>
                                <td class="py-4 px-6 font-mono font-bold text-emerald-700">Minggu #{{ $week->week }}</td>
                                <td class="py-4 px-6 text-right font-mono text-emerald-600 font-semibold">
                                    Rp {{ number_format($week->total_in, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono text-red-500 font-semibold">
                                    Rp {{ number_format($week->total_out, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono font-bold text-sm {{ ($week->total_in - $week->total_out) >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                    Rp {{ number_format($week->total_in - $week->total_out, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 font-semibold">Belum ada catatan laporan mingguan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab: Laporan Bulanan -->
        <div x-show="activeTab === 'bulanan'">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Tahun</th>
                            <th class="py-3 px-6">Bulan</th>
                            <th class="py-3 px-6 text-right">Penerimaan (Masuk)</th>
                            <th class="py-3 px-6 text-right">Pengeluaran (Keluar)</th>
                            <th class="py-3 px-6 text-right font-bold">Saldo Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($monthlyRecs as $mon)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-mono font-semibold">{{ $mon->year }}</td>
                                <td class="py-4 px-6 font-bold text-emerald-700">
                                    {{ \DateTime::createFromFormat('!m', $mon->month)->format('F') }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono text-emerald-600 font-semibold">
                                    Rp {{ number_format($mon->total_in, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono text-red-500 font-semibold">
                                    Rp {{ number_format($mon->total_out, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono font-bold text-sm {{ ($mon->total_in - $mon->total_out) >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                    Rp {{ number_format($mon->total_in - $mon->total_out, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 font-semibold">Belum ada catatan laporan bulanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab: Laporan Tahunan -->
        <div x-show="activeTab === 'tahunan'">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Tahun</th>
                            <th class="py-3 px-6 text-right">Penerimaan (Masuk)</th>
                            <th class="py-3 px-6 text-right">Pengeluaran (Keluar)</th>
                            <th class="py-3 px-6 text-right font-bold">Saldo Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($yearlyRecs as $yr)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-mono font-bold text-emerald-700 text-sm">{{ $yr->year }}</td>
                                <td class="py-4 px-6 text-right font-mono text-emerald-600 font-semibold">
                                    Rp {{ number_format($yr->total_in, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono text-red-500 font-semibold">
                                    Rp {{ number_format($yr->total_out, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono font-bold text-sm {{ ($yr->total_in - $yr->total_out) >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                    Rp {{ number_format($yr->total_in - $yr->total_out, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400 font-semibold">Belum ada catatan laporan tahunan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
