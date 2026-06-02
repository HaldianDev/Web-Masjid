<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Artikel / Khotbah') }}
            </h2>
            <a href="{{ route('admin.articles.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-3xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="title" class="block font-bold text-gray-750 uppercase tracking-wide">Judul Artikel / Khotbah</label>
                    <input type="text" id="title" name="title" required value="{{ old('title', $article->title) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="category" class="block font-bold text-gray-750 uppercase tracking-wide">Kategori</label>
                    <select id="category" name="category" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="artikel" {{ $article->category === 'artikel' ? 'selected' : '' }}>Artikel Keagamaan</option>
                        <option value="khotbah" {{ $article->category === 'khotbah' ? 'selected' : '' }}>Ringkasan Khotbah Jumat</option>
                        <option value="dokumentasi" {{ $article->category === 'dokumentasi' ? 'selected' : '' }}>Galeri & Dokumentasi</option>
                    </select>
                    <x-input-error :messages="$errors->get('category')" class="mt-1" />
                </div>
            </div>

            <div class="space-y-2">
                <label for="content" class="block font-bold text-gray-750 uppercase tracking-wide">Konten / Isi Tulisan</label>
                <textarea id="content" name="content" rows="12" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805 leading-relaxed">{{ old('content', $article->content) }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-1" />
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Perbarui Tulisan
            </button>
        </form>
    </div>
</x-app-layout>
