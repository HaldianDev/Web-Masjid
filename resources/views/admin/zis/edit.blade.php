<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Catatan ZIS') }}
            </h2>
            <a href="{{ route('admin.zis.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-3xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.zis.update', $record->id) }}" method="POST" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="person_type" class="block font-bold text-gray-700 uppercase tracking-wide">Status / Hubungan</label>
                    <select id="person_type" name="person_type" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3">
                        <option value="muzakki" {{ $record->person_type === 'muzakki' ? 'selected' : '' }}>Muzakki (Pemberi)</option>
                        <option value="mustahik" {{ $record->person_type === 'mustahik' ? 'selected' : '' }}>Mustahik (Penerima)</option>
                    </select>
                    <x-input-error :messages="$errors->get('person_type')" />
                </div>
                <div class="space-y-2">
                    <label for="type" class="block font-bold text-gray-700 uppercase tracking-wide">Jenis ZIS</label>
                    <select id="type" name="type" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3">
                        <option value="zakat_fitrah_uang" {{ $record->type === 'zakat_fitrah_uang' ? 'selected' : '' }}>Zakat Fitrah (Uang)</option>
                        <option value="zakat_fitrah_beras" {{ $record->type === 'zakat_fitrah_beras' ? 'selected' : '' }}>Zakat Fitrah (Beras)</option>
                        <option value="zakat_maal" {{ $record->type === 'zakat_maal' ? 'selected' : '' }}>Zakat Maal</option>
                        <option value="infaq" {{ $record->type === 'infaq' ? 'selected' : '' }}>Infaq</option>
                        <option value="sedekah" {{ $record->type === 'sedekah' ? 'selected' : '' }}>Sedekah</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="name" class="block font-bold text-gray-700 uppercase tracking-wide">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required value="{{ old('name', $record->name) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3">
                    <x-input-error :messages="$errors->get('name')" />
                </div>
                <div class="space-y-2">
                    <label for="phone" class="block font-bold text-gray-700 uppercase tracking-wide">No. Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $record->phone) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3">
                    <x-input-error :messages="$errors->get('phone')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label for="amount_money" class="block font-bold text-gray-700 uppercase tracking-wide">Jumlah Uang (Rp)</label>
                    <input type="number" id="amount_money" name="amount_money" min="0" value="{{ old('amount_money', $record->amount_money) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 font-mono">
                    <x-input-error :messages="$errors->get('amount_money')" />
                </div>
                <div class="space-y-2">
                    <label for="amount_rice" class="block font-bold text-gray-700 uppercase tracking-wide">Jumlah Beras (kg)</label>
                    <input type="number" step="0.01" id="amount_rice" name="amount_rice" min="0" value="{{ old('amount_rice', $record->amount_rice) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 font-mono">
                    <x-input-error :messages="$errors->get('amount_rice')" />
                </div>
                <div class="space-y-2">
                    <label for="date_recorded" class="block font-bold text-gray-700 uppercase tracking-wide">Tanggal</label>
                    <input type="date" id="date_recorded" name="date_recorded" required value="{{ old('date_recorded', $record->date_recorded->format('Y-m-d')) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3">
                    <x-input-error :messages="$errors->get('date_recorded')" />
                </div>
            </div>

            <div class="space-y-2">
                <label for="notes" class="block font-bold text-gray-700 uppercase tracking-wide">Catatan</label>
                <textarea id="notes" name="notes" rows="3" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3">{{ old('notes', $record->notes) }}</textarea>
                <x-input-error :messages="$errors->get('notes')" />
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Perbarui Catatan ZIS
            </button>
        </form>
    </div>
</x-app-layout>
