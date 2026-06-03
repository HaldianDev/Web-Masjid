<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pendaftaran & Manajemen Qurban') }}
            </h2>
            <a href="{{ route('admin.qurbans.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                + Daftarkan Shohibul Qurban
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 text-xs">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Qurban Metrics Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">SP</div>
                <div>
                    <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Total Sapi</span>
                    <span class="text-xl font-bold text-gray-800 font-mono block mt-1">{{ $totalSapi }} Ekor</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold">KB</div>
                <div>
                    <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Total Kambing</span>
                    <span class="text-xl font-bold text-gray-800 font-mono block mt-1">{{ $totalKambing }} Ekor</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">LN</div>
                <div>
                    <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Pembayaran Lunas</span>
                    <span class="text-xl font-bold text-emerald-600 font-mono block mt-1">Rp {{ number_format($totalPaidFunds, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-red-100 text-red-650 flex items-center justify-center font-bold">BL</div>
                <div>
                    <span class="text-[10px] text-gray-400 block uppercase font-bold tracking-wider">Belum Lunas</span>
                    <span class="text-xl font-bold text-red-600 font-mono block mt-1">Rp {{ number_format($totalUnpaidFunds, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Filter and Select Year -->
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
            <form method="GET" action="{{ route('admin.qurbans.index') }}" class="flex items-end space-x-4">
                <div class="w-64">
                    <label for="year" class="block font-bold text-gray-700 mb-1.5 uppercase tracking-wide">Tahun Pelaksanaan Qurban</label>
                    <select id="year" name="year" onchange="this.form.submit()" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-3 py-2 text-gray-850">
                        <option value="1447 H / 2026" {{ $year === '1447 H / 2026' ? 'selected' : '' }}>1447 H / 2026</option>
                        <option value="1448 H / 2027" {{ $year === '1448 H / 2027' ? 'selected' : '' }}>1448 H / 2027</option>
                        <option value="1446 H / 2025" {{ $year === '1446 H / 2025' ? 'selected' : '' }}>1446 H / 2025</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Sapi Grouping Visual Board -->
        @if($sapiGroups->isNotEmpty())
            <div class="bg-emerald-950/5 border border-emerald-900/10 p-6 rounded-2xl">
                <h3 class="text-sm font-bold text-emerald-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Pengelompokan Anggota Qurban Sapi (Maks 7 Jamaah/Sapi)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sapiGroups as $groupNum => $members)
                        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-5 space-y-3">
                            <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                                <span class="font-bold text-gray-900 text-sm">Kelompok Sapi #{{ $groupNum }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $members->count() >= 7 ? 'bg-emerald-50 text-emerald-800' : 'bg-amber-50 text-amber-800' }}">
                                    {{ $members->count() }}/7 Jamaah
                                </span>
                            </div>
                            <ol class="space-y-1.5 list-decimal pl-4 font-medium text-gray-700">
                                @foreach($members as $m)
                                    <li class="justify-between">
                                        <span class="font-bold text-gray-900">{{ $m->participant_name }}</span>
                                        <span class="text-[9px] px-1.5 py-0.5 rounded ml-2 uppercase font-extrabold font-mono {{ $m->status === 'lunas' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-650' }}">
                                            {{ $m->status }}
                                        </span>
                                    </li>
                                @endforeach
                                @for($i = $members->count() + 1; $i <= 7; $i++)
                                    <li class="text-gray-400 italic">Slot kosong #{{ $i }}</li>
                                @endfor
                            </ol>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Participants Table -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Nama Shohibul Qurban</th>
                            <th class="py-3 px-6">No. Telp</th>
                            <th class="py-3 px-6">Tipe Hewan</th>
                            <th class="py-3 px-6 text-center">Kelompok Sapi</th>
                            <th class="py-3 px-6 text-right">Biaya Qurban</th>
                            <th class="py-3 px-6">Status Pembayaran</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($participants as $part)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-gray-900 block text-sm">{{ $part->participant_name }}</span>
                                    @if($part->notes)
                                        <span class="block text-[10px] text-gray-450 font-normal mt-0.5 max-w-xs truncate">{{ $part->notes }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-mono">{{ $part->phone ?? '-' }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase border {{ $part->type === 'sapi' ? 'bg-emerald-50 text-emerald-850 border-emerald-150' : 'bg-amber-50 text-amber-700 border-amber-250' }}">
                                        {{ $part->type === 'sapi' ? 'Sapi (1/7)' : 'Kambing' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center font-mono font-bold text-gray-900">
                                    {{ $part->group_number ? 'Sapi #' . $part->group_number : '-' }}
                                </td>
                                <td class="py-4 px-6 text-right font-mono font-bold text-gray-800 text-sm">
                                    Rp {{ number_format($part->amount_paid, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase border {{ $part->status === 'lunas' ? 'bg-emerald-50 text-emerald-850 border-emerald-150' : 'bg-red-50 text-red-700 border-red-150' }}">
                                        {{ $part->status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.qurbans.edit', $part->id) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold border border-amber-250 rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.qurbans.destroy', $part->id) }}" method="POST" onsubmit="return confirm('Hapus pendaftaran qurban ini?')">
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
                                <td colspan="7" class="py-8 text-center text-gray-400 font-semibold">Belum ada peserta qurban terdaftar untuk tahun {{ $year }}.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($participants->hasPages())
                <div class="px-6 py-4 border-t border-gray-150">
                    {{ $participants->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
