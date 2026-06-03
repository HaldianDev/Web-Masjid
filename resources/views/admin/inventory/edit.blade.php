<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Aset Inventaris') }}
            </h2>
            <a href="{{ route('admin.inventory.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-3xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.inventory.update', $inventory->id) }}" method="POST" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="item_name" class="block font-bold text-gray-750 uppercase tracking-wide">Nama Barang / Aset</label>
                    <input type="text" id="item_name" name="item_name" required value="{{ old('item_name', $inventory->item_name) }}" placeholder="Contoh: AC Standing 5 PK, Genset, Karpet Masjid" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                    <x-input-error :messages="$errors->get('item_name')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="code" class="block font-bold text-gray-750 uppercase tracking-wide">Kode Aset / Inventaris</label>
                    <input type="text" id="code" name="code" required value="{{ old('code', $inventory->code) }}" placeholder="Contoh: AST-2026-AC01" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805 font-mono">
                    <x-input-error :messages="$errors->get('code')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label for="quantity" class="block font-bold text-gray-750 uppercase tracking-wide">Jumlah (Unit/Pcs)</label>
                    <input type="number" id="quantity" name="quantity" min="1" required value="{{ old('quantity', $inventory->quantity) }}" placeholder="1" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800 font-mono font-semibold">
                    <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="condition" class="block font-bold text-gray-750 uppercase tracking-wide">Kondisi Barang</label>
                    <select id="condition" name="condition" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="baik" {{ old('condition', $inventory->condition) === 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak_ringan" {{ old('condition', $inventory->condition) === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="rusak_berat" {{ old('condition', $inventory->condition) === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    <x-input-error :messages="$errors->get('condition')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="purchase_date" class="block font-bold text-gray-750 uppercase tracking-wide">Tanggal Pembelian</label>
                    <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $inventory->purchase_date ? \Carbon\Carbon::parse($inventory->purchase_date)->toDateString() : '') }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('purchase_date')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="location" class="block font-bold text-gray-750 uppercase tracking-wide">Lokasi Penyimpanan</label>
                    <input type="text" id="location" name="location" required value="{{ old('location', $inventory->location) }}" placeholder="Contoh: Ruang Utama, Gudang Masjid" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                    <x-input-error :messages="$errors->get('location')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="notes" class="block font-bold text-gray-750 uppercase tracking-wide">Catatan / Keterangan</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Informasi tambahan, merk, spesifikasi, dsb (Opsional)" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">{{ old('notes', $inventory->notes) }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-1" />
                </div>
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Perbarui Aset Inventaris
            </button>
        </form>
    </div>
</x-app-layout>
