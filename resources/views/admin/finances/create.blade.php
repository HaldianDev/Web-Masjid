<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Catat Transaksi Kas Masjid') }}
            </h2>
            <a href="{{ route('admin.finances.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-3xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.finances.store') }}" method="POST" class="space-y-6 text-xs">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="type" class="block font-bold text-gray-750 uppercase tracking-wide">Tipe Transaksi</label>
                    <select id="type" name="type" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="in">Kas Masuk (Penerimaan)</option>
                        <option value="out">Kas Keluar (Pengeluaran)</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="category" class="block font-bold text-gray-750 uppercase tracking-wide">Kategori</label>
                    <select id="category" name="category" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                        <option value="infak_jumat">Infak Shalat Jumat</option>
                        <option value="donasi_digital">Donasi Digital</option>
                        <option value="operasional">Operasional Masjid</option>
                        <option value="pemeliharaan">Pemeliharaan & Renovasi</option>
                        <option value="gaji">Gaji Marbot/Petugas</option>
                        <option value="lainnya">Lain-lain</option>
                    </select>
                    <x-input-error :messages="$errors->get('category')" class="mt-1" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="amount" class="block font-bold text-gray-750 uppercase tracking-wide">Jumlah (Rupiah)</label>
                    <input type="number" id="amount" name="amount" min="1" required value="{{ old('amount') }}" placeholder="Contoh: 100000" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800 font-mono font-bold">
                    <x-input-error :messages="$errors->get('amount')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="transaction_date" class="block font-bold text-gray-750 uppercase tracking-wide">Tanggal Transaksi</label>
                    <input type="date" id="transaction_date" name="transaction_date" required value="{{ old('transaction_date', now()->toDateString()) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">
                    <x-input-error :messages="$errors->get('transaction_date')" class="mt-1" />
                </div>
            </div>

            <div class="space-y-2">
                <label for="description" class="block font-bold text-gray-750 uppercase tracking-wide">Deskripsi / Keterangan Transaksi</label>
                <textarea id="description" name="description" rows="4" required placeholder="Tulis rincian penggunaan atau sumber dana secara jelas..." class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-800">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Simpan Transaksi Kas
            </button>
        </form>
    </div>
</x-app-layout>
