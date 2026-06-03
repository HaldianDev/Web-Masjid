<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Artikel & Ringkasan Khotbah') }}
            </h2>
            <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                + Tulis Artikel/Khotbah
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
                            <th class="py-3 px-6">Tanggal Terbit</th>
                            <th class="py-3 px-6">Judul Tulisan</th>
                            <th class="py-3 px-6">Kategori</th>
                            <th class="py-3 px-6">Penulis</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($articles as $art)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-mono text-gray-700">
                                    {{ $art->published_at ? $art->published_at->format('d M Y H:i') : $art->created_at->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 font-bold text-gray-900 max-w-xs truncate">{{ $art->title }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] uppercase font-extrabold {{ $art->category === 'khotbah' ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-blue-50 text-blue-800 border-blue-100' }} border">
                                        {{ $art->category === 'khotbah' ? 'Khotbah Jumat' : 'Artikel Religi' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 font-medium">{{ $art->user->name ?? "As-Sa'adah Desa Belambangan" }}</td>
                                <td class="py-4 px-6 flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.articles.edit', $art->id) }}" class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold border border-amber-200 rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" class="confirm-delete">
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
                                <td colspan="5" class="py-8 text-center text-gray-400 font-medium">Belum ada tulisan yang diterbitkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($articles->hasPages())
                <div class="px-6 py-4 border-t border-gray-150">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
