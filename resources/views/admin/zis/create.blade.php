<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Catat Data ZIS Baru') }}
            </h2>
            <a href="{{ route('admin.zis.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-3xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.zis.store') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="person_type" class="block font-bold text-gray-750 uppercase tracking-wide">Status / Hubungan</label>
                    <select id="person_type" name="person_type" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="muzakki">Muzakki (Pemberi Zakat/Sedekah)</option>
                        <option value="mustahik">Mustahik (Penerima Manfaat/Zakat)</option>
                    </select>
                    <x-input-error :messages="$errors->get('person_type')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="type" class="block font-bold text-gray-750 uppercase tracking-wide">Jenis ZIS</label>
                    <select id="type" name="type" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="zakat_fitrah_uang">Zakat Fitrah (Uang)</option>
                        <option value="zakat_fitrah_beras">Zakat Fitrah (Beras)</option>
                        <option value="zakat_maal">Zakat Maal (Harta)</option>
                        <option value="infaq">Infaq</option>
                        <option value="sedekah">Sedekah</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="name" class="block font-bold text-gray-750 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="Nama muzakki atau mustahik" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block font-bold text-gray-750 uppercase tracking-wide">No. Telepon / HP</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx (Opsional)" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label for="amount_money" class="block font-bold text-gray-750 uppercase tracking-wide">Jumlah Uang (Rupiah)</label>
                    <input type="number" id="amount_money" name="amount_money" min="0" value="{{ old('amount_money') }}" placeholder="Isi jika berupa uang" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800 font-mono font-semibold">
                    <x-input-error :messages="$errors->get('amount_money')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="amount_rice" class="block font-bold text-gray-750 uppercase tracking-wide">Jumlah Beras (kg)</label>
                    <input type="number" step="0.01" id="amount_rice" name="amount_rice" min="0" value="{{ old('amount_rice') }}" placeholder="Isi jika berupa beras" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800 font-mono font-semibold">
                    <x-input-error :messages="$errors->get('amount_rice')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="date_recorded" class="block font-bold text-gray-750 uppercase tracking-wide">Tanggal Pencatatan</label>
                    <input type="date" id="date_recorded" name="date_recorded" required value="{{ old('date_recorded', now()->toDateString()) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('date_recorded')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="address" class="block font-bold text-gray-750 uppercase tracking-wide">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3" placeholder="Alamat Donatur / Mustahik (Opsional)" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">{{ old('address') }}</textarea>
                    <x-input-error :messages="$errors->get('address')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="notes" class="block font-bold text-gray-750 uppercase tracking-wide">Catatan / Keterangan</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Keterangan tambahan (Opsional)" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">{{ old('notes') }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                </div>
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Simpan Pencatatan ZIS
            </button>
        </form>
    </div>
</x-app-layout>
