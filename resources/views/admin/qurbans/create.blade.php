<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Peserta Qurban Baru') }}
            </h2>
            <a href="{{ route('admin.qurbans.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.qurbans.store') }}" method="POST" class="space-y-6 text-xs" x-data="{ type: 'sapi' }">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="year" class="block font-bold text-gray-750 uppercase tracking-wide">Tahun Pelaksanaan</label>
                    <select id="year" name="year" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="1447 H / 2026" {{ old('year') === '1447 H / 2026' ? 'selected' : '' }}>1447 H / 2026</option>
                        <option value="1448 H / 2027" {{ old('year') === '1448 H / 2027' ? 'selected' : '' }}>1448 H / 2027</option>
                        <option value="1446 H / 2025" {{ old('year') === '1446 H / 2025' ? 'selected' : '' }}>1446 H / 2025</option>
                    </select>
                    <x-input-error :messages="$errors->get('year')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="type" class="block font-bold text-gray-750 uppercase tracking-wide">Tipe Hewan Qurban</label>
                    <select id="type" name="type" required x-model="type" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="sapi">Sapi (Patungan 1/7)</option>
                        <option value="kambing">Kambing (Individu)</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="participant_name" class="block font-bold text-gray-750 uppercase tracking-wide">Nama Jamaah (Shohibul Qurban)</label>
                    <input type="text" id="participant_name" name="participant_name" required value="{{ old('participant_name') }}" placeholder="Nama Lengkap" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                    <x-input-error :messages="$errors->get('participant_name')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block font-bold text-gray-750 uppercase tracking-wide">No. Telepon / HP</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2" x-show="type === 'sapi'">
                    <label for="group_number" class="block font-bold text-gray-750 uppercase tracking-wide">Kelompok Sapi (Nomor)</label>
                    <input type="number" id="group_number" name="group_number" min="1" value="{{ old('group_number') }}" placeholder="1" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800 font-mono font-semibold">
                    <x-input-error :messages="$errors->get('group_number')" class="mt-1" />
                </div>

                <div class="space-y-2" :class="type === 'sapi' ? 'col-span-1' : 'col-span-2'">
                    <label for="amount_paid" class="block font-bold text-gray-750 uppercase tracking-wide">Nilai Pembayaran (Rp)</label>
                    <input type="number" id="amount_paid" name="amount_paid" required min="0" value="{{ old('amount_paid') }}" placeholder="3500000" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800 font-mono font-semibold">
                    <x-input-error :messages="$errors->get('amount_paid')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="status" class="block font-bold text-gray-750 uppercase tracking-wide">Status Pembayaran</label>
                    <select id="status" name="status" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="belum_lunas" {{ old('status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="lunas" {{ old('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-1" />
                </div>
            </div>

            <div class="space-y-2">
                <label for="notes" class="block font-bold text-gray-750 uppercase tracking-wide">Catatan / Keterangan (Opsional)</label>
                <textarea id="notes" name="notes" rows="3" placeholder="Misal: Atas nama almarhum, ukuran hewan, dsb..." class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">{{ old('notes') }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-1" />
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Daftarkan Anggota Qurban
            </button>
        </form>
    </div>
</x-app-layout>
