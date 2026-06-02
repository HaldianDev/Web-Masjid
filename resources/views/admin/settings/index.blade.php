<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil & Pengaturan Masjid') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl space-y-6 text-xs" x-data="{ tab: 'umum' }">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tab Headers -->
        <div class="flex border-b border-gray-200 bg-white p-2 rounded-2xl shadow-sm space-x-2">
            <button @click="tab = 'umum'" 
                    :class="tab === 'umum' ? 'bg-emerald-700 text-white font-bold' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2.5 rounded-xl transition-all font-semibold">
                Informasi Umum
            </button>
            <button @click="tab = 'visi_misi'" 
                    :class="tab === 'visi_misi' ? 'bg-emerald-700 text-white font-bold' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2.5 rounded-xl transition-all font-semibold">
                Visi, Misi & Sejarah
            </button>
            <button @click="tab = 'struktur_organisasi'" 
                    :class="tab === 'struktur_organisasi' ? 'bg-emerald-700 text-white font-bold' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2.5 rounded-xl transition-all font-semibold">
                Struktur Organisasi (Takmir)
            </button>
            <button @click="tab = 'fasilitas_legalitas'" 
                    :class="tab === 'fasilitas_legalitas' ? 'bg-emerald-700 text-white font-bold' : 'text-gray-600 hover:bg-gray-100'"
                    class="px-4 py-2.5 rounded-xl transition-all font-semibold">
                Fasilitas & Legalitas
            </button>
        </div>

        <!-- Form settings -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Tab: Umum -->
                <div x-show="tab === 'umum'" class="space-y-6">
                    <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-3">Informasi Umum Masjid</h3>
                    
                    <div class="space-y-2">
                        <label for="masjid_name" class="block font-bold text-gray-750 uppercase tracking-wide">Nama Masjid</label>
                        <input type="text" id="masjid_name" name="masjid_name" required value="{{ old('masjid_name', $profile['masjid_name']) }}" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                        <x-input-error :messages="$errors->get('masjid_name')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label for="masjid_address" class="block font-bold text-gray-750 uppercase tracking-wide">Alamat Lengkap</label>
                        <textarea id="masjid_address" name="masjid_address" rows="4" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">{{ old('masjid_address', $profile['masjid_address']) }}</textarea>
                        <x-input-error :messages="$errors->get('masjid_address')" class="mt-1" />
                    </div>
                </div>

                <!-- Tab: Visi Misi Sejarah -->
                <div x-show="tab === 'visi_misi'" class="space-y-6">
                    <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-3">Visi, Misi & Sejarah</h3>
                    
                    <div class="space-y-2">
                        <label for="masjid_vision" class="block font-bold text-gray-750 uppercase tracking-wide">Visi Masjid</label>
                        <textarea id="masjid_vision" name="masjid_vision" rows="3" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">{{ old('masjid_vision', $profile['masjid_vision']) }}</textarea>
                        <x-input-error :messages="$errors->get('masjid_vision')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label for="masjid_mission" class="block font-bold text-gray-750 uppercase tracking-wide">Misi Masjid (Gunakan baris baru untuk memisahkan poin)</label>
                        <textarea id="masjid_mission" name="masjid_mission" rows="4" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">{{ old('masjid_mission', $profile['masjid_mission']) }}</textarea>
                        <x-input-error :messages="$errors->get('masjid_mission')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label for="masjid_history" class="block font-bold text-gray-750 uppercase tracking-wide">Sejarah Singkat Masjid</label>
                        <textarea id="masjid_history" name="masjid_history" rows="6" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">{{ old('masjid_history', $profile['masjid_history']) }}</textarea>
                        <x-input-error :messages="$errors->get('masjid_history')" class="mt-1" />
                    </div>
                </div>

                <!-- Tab: Struktur Organisasi -->
                <div x-show="tab === 'struktur_organisasi'" class="space-y-6">
                    <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-3">Struktur Pengurus Takmir</h3>
                    
                    <div class="space-y-2">
                        <label for="masjid_structure" class="block font-bold text-gray-750 uppercase tracking-wide">Struktur Organisasi (Format Nama: Jabatan / Peran)</label>
                        <textarea id="masjid_structure" name="masjid_structure" rows="8" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805 font-mono" placeholder="Ketua Takmir: H. Ahmad Yani&#10;Sekretaris: Ustadz M. Ridwan&#10;Bendahara: H. Soleh">{{ old('masjid_structure', $profile['masjid_structure']) }}</textarea>
                        <x-input-error :messages="$errors->get('masjid_structure')" class="mt-1" />
                    </div>
                </div>

                <!-- Tab: Fasilitas & Legalitas -->
                <div x-show="tab === 'fasilitas_legalitas'" class="space-y-6">
                    <h3 class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-3">Fasilitas & Legalitas Formal</h3>
                    
                    <div class="space-y-2">
                        <label for="masjid_facilities" class="block font-bold text-gray-750 uppercase tracking-wide">Fasilitas Masjid (Gunakan koma atau baris baru)</label>
                        <textarea id="masjid_facilities" name="masjid_facilities" rows="5" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805" placeholder="Gedung Utama AC, Perpustakaan, Area Parkir Luas, Ambulans Gratis">{{ old('masjid_facilities', $profile['masjid_facilities']) }}</textarea>
                        <x-input-error :messages="$errors->get('masjid_facilities')" class="mt-1" />
                    </div>

                    <div class="space-y-2">
                        <label for="masjid_legalities" class="block font-bold text-gray-750 uppercase tracking-wide">Legalitas Formal & Yayasan (Ketetapan Kemenag/No. SK)</label>
                        <textarea id="masjid_legalities" name="masjid_legalities" rows="4" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-855" placeholder="SK Kemenag RI No. 123/Masjid/2020&#10;Akta Notaris Yayasan No. 45 Th. 2018">{{ old('masjid_legalities', $profile['masjid_legalities']) }}</textarea>
                        <x-input-error :messages="$errors->get('masjid_legalities')" class="mt-1" />
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-150">
                    <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                        Simpan Semua Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
