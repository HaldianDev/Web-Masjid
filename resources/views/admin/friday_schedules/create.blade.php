<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Petugas Jumat') }}
            </h2>
            <a href="{{ route('admin.friday-schedules.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.friday-schedules.store') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <div class="space-y-2">
                <label for="date" class="block font-bold text-gray-750 uppercase tracking-wide">Tanggal Hari Jumat</label>
                <input type="date" id="date" name="date" required value="{{ old('date', now()->next(\Carbon\Carbon::FRIDAY)->toDateString()) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                <x-input-error :messages="$errors->get('date')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label for="khotib" class="block font-bold text-gray-750 uppercase tracking-wide">Nama Khotib</label>
                <input type="text" id="khotib" name="khotib" required value="{{ old('khotib') }}" placeholder="Contoh: K.H. Ahmad Dahlan" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                <x-input-error :messages="$errors->get('khotib')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label for="imam" class="block font-bold text-gray-750 uppercase tracking-wide">Nama Imam</label>
                <input type="text" id="imam" name="imam" required value="{{ old('imam') }}" placeholder="Contoh: Ustadz M. Yusuf" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                <x-input-error :messages="$errors->get('imam')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label for="muadzin" class="block font-bold text-gray-750 uppercase tracking-wide">Nama Muadzin</label>
                <input type="text" id="muadzin" name="muadzin" required value="{{ old('muadzin') }}" placeholder="Contoh: Bilal Bin Rabah" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                <x-input-error :messages="$errors->get('muadzin')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label for="notes" class="block font-bold text-gray-750 uppercase tracking-wide">Catatan Tambahan (Opsional)</label>
                <textarea id="notes" name="notes" rows="3" placeholder="Informasi tambahan atau keterangan..." class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">{{ old('notes') }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-1" />
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Simpan Jadwal Jumat
            </button>
        </form>
    </div>
</x-app-layout>
