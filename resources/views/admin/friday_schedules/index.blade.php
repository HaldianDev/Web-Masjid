<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Jadwal Petugas Shalat Jumat') }}
            </h2>
            <a href="{{ route('admin.friday-schedules.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                + Tambah Petugas Jumat
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 text-xs">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Friday Schedules Table -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Tanggal Jumat</th>
                            <th class="py-3 px-6">Khotib</th>
                            <th class="py-3 px-6">Imam</th>
                            <th class="py-3 px-6">Muadzin</th>
                            <th class="py-3 px-6">Catatan / Keterangan</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($schedules as $sched)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-mono font-bold text-emerald-700">
                                    {{ $sched->date->format('d/m/Y') }}
                                    <span class="block text-[10px] text-gray-400 font-normal mt-0.5">{{ $sched->date->isoFormat('dddd') }}</span>
                                </td>
                                <td class="py-4 px-6 font-bold text-gray-900 text-sm">{{ $sched->khotib }}</td>
                                <td class="py-4 px-6 font-semibold text-gray-850">{{ $sched->imam }}</td>
                                <td class="py-4 px-6 text-gray-700">{{ $sched->muadzin }}</td>
                                <td class="py-4 px-6 text-gray-500 max-w-xs truncate" title="{{ $sched->notes }}">{{ $sched->notes ?? '-' }}</td>
                                <td class="py-4 px-6 flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.friday-schedules.edit', $sched->id) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold border border-amber-250 rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.friday-schedules.destroy', $sched->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal Jumat ini?')">
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
                                <td colspan="6" class="py-8 text-center text-gray-400 font-semibold">Belum ada jadwal petugas Jumat terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($schedules->hasPages())
                <div class="px-6 py-4 border-t border-gray-150">
                    {{ $schedules->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
