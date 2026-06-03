<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Pengguna & Peran (ACL)') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                + Daftarkan Pengguna Baru
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 text-xs">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Nama Lengkap</th>
                            <th class="py-3 px-6">Alamat Email</th>
                            <th class="py-3 px-6">Peran / Hak Akses</th>
                            <th class="py-3 px-6">Terdaftar Pada</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-800 font-bold uppercase">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <span class="font-bold text-gray-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 font-mono text-gray-700">{{ $user->email }}</td>
                                <td class="py-4 px-6">
                                    @php
                                        $role = $user->roles->first()?->name;
                                    @endphp
                                    @if($role === 'Super Admin')
                                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-red-50 text-red-750 border border-red-150">
                                            Super Admin
                                        </span>
                                    @elseif($role === 'Bendahara')
                                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-50 text-amber-700 border border-amber-250">
                                            Bendahara
                                        </span>
                                    @elseif($role === 'Marbot')
                                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-50 text-emerald-850 border border-emerald-150">
                                            Marbot
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-gray-100 text-gray-700 border border-gray-200">
                                            {{ $role ?? 'User' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-mono text-gray-500">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-4 px-6 flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold border border-amber-250 rounded-lg">
                                        Edit
                                    </a>
                                    @if($user->id !== 1 && $user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-650 font-bold border border-red-250 rounded-lg">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 font-semibold">Belum ada pengguna terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-150">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
