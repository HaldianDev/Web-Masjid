<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pembukuan Zakat, Infaq, Sedekah (ZIS)') }}
            </h2>
            <a href="{{ route('admin.zis.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                + Catat Muzakki / Mustahik
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 text-xs">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- ZIS Metrics Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] text-gray-405 font-bold uppercase tracking-wider block">Muzakki (Uang)</span>
                <span class="text-xl font-bold text-emerald-600 font-mono block mt-1">Rp {{ number_format($totalMuzakkiMoney, 0, ',', '.') }}</span>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] text-gray-450 font-bold uppercase tracking-wider block">Muzakki (Beras)</span>
                <span class="text-xl font-bold text-gray-800 font-mono block mt-1">{{ number_format($totalMuzakkiRice, 1, ',', '.') }} kg</span>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Mustahik (Uang)</span>
                <span class="text-xl font-bold text-red-600 font-mono block mt-1">Rp {{ number_format($totalMustahikMoney, 0, ',', '.') }}</span>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Mustahik (Beras)</span>
                <span class="text-xl font-bold text-gray-800 font-mono block mt-1">{{ number_format($totalMustahikRice, 1, ',', '.') }} kg</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
            <form method="GET" action="{{ route('admin.zis.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="person_type" class="block font-bold text-gray-750 mb-1.5 uppercase tracking-wide">Status</label>
                    <select id="person_type" name="person_type" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-3 py-2 text-gray-850">
                        <option value="">Semua</option>
                        <option value="muzakki" {{ request('person_type') === 'muzakki' ? 'selected' : '' }}>Muzakki (Pemberi)</option>
                        <option value="mustahik" {{ request('person_type') === 'mustahik' ? 'selected' : '' }}>Mustahik (Penerima)</option>
                    </select>
                </div>
                <div>
                    <label for="type" class="block font-bold text-gray-750 mb-1.5 uppercase tracking-wide">Jenis ZIS</label>
                    <select id="type" name="type" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-3 py-2 text-gray-850">
                        <option value="">Semua</option>
                        <option value="zakat_fitrah_uang" {{ request('type') === 'zakat_fitrah_uang' ? 'selected' : '' }}>Zakat Fitrah (Uang)</option>
                        <option value="zakat_fitrah_beras" {{ request('type') === 'zakat_fitrah_beras' ? 'selected' : '' }}>Zakat Fitrah (Beras)</option>
                        <option value="zakat_maal" {{ request('type') === 'zakat_maal' ? 'selected' : '' }}>Zakat Maal (Harta)</option>
                        <option value="infaq" {{ request('type') === 'infaq' ? 'selected' : '' }}>Infaq</option>
                        <option value="sedekah" {{ request('type') === 'sedekah' ? 'selected' : '' }}>Sedekah</option>
                    </select>
                </div>
                <div class="flex space-x-2">
                    <button type="submit" class="flex-1 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl transition-colors">Saring</button>
                    <a href="{{ route('admin.zis.index') }}" class="py-2 px-4 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold border border-gray-250 rounded-xl text-center">Reset</a>
                </div>
            </form>
        </div>

        <!-- Records Table -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Tanggal</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6">Nama Lengkap</th>
                            <th class="py-3 px-6">Jenis ZIS</th>
                            <th class="py-3 px-6 text-right">Uang</th>
                            <th class="py-3 px-6 text-right">Beras (kg)</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($records as $rec)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-mono text-gray-700">{{ $rec->date_recorded->format('d/m/Y') }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border {{ $rec->person_type === 'muzakki' ? 'bg-emerald-50 text-emerald-850 border-emerald-150' : 'bg-red-50 text-red-700 border-red-150' }}">
                                        {{ $rec->person_type }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-bold text-gray-900">
                                    <span>{{ $rec->name }}</span>
                                    @if($rec->phone)
                                        <span class="block text-[10px] text-gray-450 font-normal mt-0.5">{{ $rec->phone }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="uppercase tracking-wider text-[10px] font-extrabold text-amber-600">
                                        {{ str_replace('_', ' ', $rec->type) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right font-mono font-bold text-gray-800">
                                    {{ $rec->amount_money ? 'Rp ' . number_format($rec->amount_money, 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono font-bold text-gray-800">
                                    {{ $rec->amount_rice ? number_format($rec->amount_rice, 1, ',', '.') . ' kg' : '-' }}
                                </td>
                                <td class="py-4 px-6 flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.zis.edit', $rec->id) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold border border-amber-250 rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.zis.destroy', $rec->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ZIS ini?')">
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
                                <td colspan="7" class="py-8 text-center text-gray-400 font-semibold">Belum ada catatan ZIS yang sesuai kriteria.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($records->hasPages())
                <div class="px-6 py-4 border-t border-gray-150">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
