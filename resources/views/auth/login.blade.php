<x-guest-layout>
    <div>

        <div class="w-full max-w-md bg-emerald-950/60 border border-emerald-800 rounded-2xl shadow-2xl p-6 sm:p-8">

            <!-- Title -->
            <div class="text-center mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-amber-400">
                    Login Admin Masjid
                </h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">
                    Masuk untuk mengelola sistem
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" value="Email" class="text-slate-300" />
                    <x-text-input
                        id="email"
                        type="email"
                        name="email"
                        class="block mt-1 w-full bg-emerald-950/60 border-emerald-800 text-slate-100 focus:border-amber-400 focus:ring-amber-400 rounded-lg"
                        :value="old('email')"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" value="Password" class="text-slate-300" />
                    <x-text-input
                        id="password"
                        type="password"
                        name="password"
                        class="block mt-1 w-full bg-emerald-950/60 border-emerald-800 text-slate-100 focus:border-amber-400 focus:ring-amber-400 rounded-lg"
                        required
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember -->
                <div class="flex items-center mb-5">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-emerald-700 text-amber-400 focus:ring-amber-400"
                    >
                    <label for="remember_me" class="ml-2 text-sm text-slate-300">
                        Remember me
                    </label>
                </div>

                <!-- Button -->
                <button type="submit"
                    class="w-full py-3 rounded-lg bg-gradient-to-r from-amber-400 to-amber-500 text-emerald-950 font-bold hover:from-amber-500 hover:to-amber-600 transition transform hover:scale-[1.01]">
                    Log in
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>