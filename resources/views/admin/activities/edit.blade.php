<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Kegiatan Masjid') }}
            </h2>
            <a href="{{ route('admin.activities.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-3xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="title" class="block font-bold text-gray-750 uppercase tracking-wide">Judul Kegiatan</label>
                    <input type="text" id="title" name="title" required value="{{ old('title', $activity->title) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('title')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="category" class="block font-bold text-gray-750 uppercase tracking-wide">Kategori</label>
                    <select id="category" name="category" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="pengajian" {{ $activity->category === 'pengajian' ? 'selected' : '' }}>Pengajian Rutin</option>
                        <option value="tablig_akbar" {{ $activity->category === 'tablig_akbar' ? 'selected' : '' }}>Tablig Akbar</option>
                        <option value="ramadan" {{ $activity->category === 'ramadan' ? 'selected' : '' }}>Kegiatan Ramadan</option>
                        <option value="santunan" {{ $activity->category === 'santunan' ? 'selected' : '' }}>Santunan Sosial</option>
                        <option value="pelatihan" {{ $activity->category === 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                    </select>
                    <x-input-error :messages="$errors->get('category')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="event_date" class="block font-bold text-gray-750 uppercase tracking-wide">Tanggal Kegiatan</label>
                    <input type="date" id="event_date" name="event_date" required value="{{ old('event_date', $activity->event_date->format('Y-m-d')) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('event_date')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="event_time" class="block font-bold text-gray-750 uppercase tracking-wide">Waktu Kegiatan</label>
                    <input type="text" id="event_time" name="event_time" required value="{{ old('event_time', $activity->event_time) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('event_time')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="speaker" class="block font-bold text-gray-750 uppercase tracking-wide">Penceramah / Pengisi Acara</label>
                    <input type="text" id="speaker" name="speaker" value="{{ old('speaker', $activity->speaker) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('speaker')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="location" class="block font-bold text-gray-750 uppercase tracking-wide">Lokasi</label>
                    <input type="text" id="location" name="location" required value="{{ old('location', $activity->location) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('location')" class="mt-1" />
                </div>
            </div>

            <div class="space-y-2">
                <label for="description" class="block font-bold text-gray-750 uppercase tracking-wide">Deskripsi Kegiatan</label>
                <textarea id="description" name="description" rows="4" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">{{ old('description', $activity->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Perbarui Kegiatan
            </button>
        </form>
    </div>
</x-app-layout>
