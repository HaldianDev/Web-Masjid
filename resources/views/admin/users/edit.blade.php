<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Akun Pengguna') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-xs text-gray-500 hover:text-gray-700 font-semibold">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="max-w-xl bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6 text-xs">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label for="name" class="block font-bold text-gray-750 uppercase tracking-wide">Nama Lengkap</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $user->name) }}" placeholder="Nama Lengkap" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label for="email" class="block font-bold text-gray-750 uppercase tracking-wide">Alamat Email</label>
                <input type="email" id="email" name="email" required value="{{ old('email', $user->email) }}" placeholder="email@masjid.com" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <label for="role" class="block font-bold text-gray-750 uppercase tracking-wide">Peran / Hak Akses</label>
                <select id="role" name="role" required class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-850">
                    <option value="" disabled>Pilih Peran...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role', $userRole) === $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-1" />
            </div>

            <div class="p-4 bg-amber-50/50 border border-amber-200/50 rounded-xl">
                <span class="font-bold text-amber-800 block mb-1">Tips Keamanan</span>
                <span class="text-[10px] text-amber-700 block leading-relaxed">Kosongkan kolom kata sandi (password) di bawah ini jika Anda tidak ingin merubahnya. Jika diubah, minimal 8 karakter.</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="password" class="block font-bold text-gray-750 uppercase tracking-wide">Kata Sandi Baru (Opsional)</label>
                    <input type="password" id="password" name="password" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block font-bold text-gray-750 uppercase tracking-wide">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 rounded-xl px-4 py-3 text-gray-805">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>
            </div>

            <button type="submit" class="px-6 py-3 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-xl shadow transition-colors">
                Perbarui Akun Pengguna
            </button>
        </form>
    </div>
</x-app-layout>
