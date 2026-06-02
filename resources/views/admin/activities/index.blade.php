<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Kegiatan Masjid') }}
            </h2>
            <a href="{{ route('admin.activities.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                + Tambah Kegiatan
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-xs font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Tanggal & Waktu</th>
                            <th class="py-3 px-6">Judul Kegiatan</th>
                            <th class="py-3 px-6">Kategori</th>
                            <th class="py-3 px-6">Penceramah</th>
                            <th class="py-3 px-6">Lokasi</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($activities as $act)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <span class="block font-bold text-gray-800">{{ $act->event_date->format('d M Y') }}</span>
                                    <span class="block text-[10px] text-gray-500 font-mono mt-0.5">{{ $act->event_time }}</span>
                                </td>
                                <td class="py-4 px-6 font-bold text-gray-900 max-w-xs truncate">{{ $act->title }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-[9px] uppercase font-extrabold text-emerald-800 border border-emerald-100">
                                        {{ str_replace('_', ' ', $act->category) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">{{ $act->speaker ?? '-' }}</td>
                                <td class="py-4 px-6 font-medium">{{ $act->location }}</td>
                                <td class="py-4 px-6 flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.activities.edit', $act->id) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold border border-amber-200 rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.activities.destroy', $act->id) }}" method="POST" class="confirm-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-650 font-bold border border-red-200 rounded-lg">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400 font-medium">Belum ada kegiatan yang didaftarkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($activities->hasPages())
                <div class="px-6 py-4 border-t border-gray-150">
                    {{ $activities->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
