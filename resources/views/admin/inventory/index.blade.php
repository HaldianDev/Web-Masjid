<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inventaris & Aset Fisik Masjid') }}
            </h2>
            <a href="{{ route('admin.inventory.create') }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                + Tambah Aset Baru
            </a>
        </div>
    </x-slot>

    <div class="space-y-6 text-xs">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Inventory List -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Kode Aset</th>
                            <th class="py-3 px-6">Nama Barang</th>
                            <th class="py-3 px-6">Lokasi</th>
                            <th class="py-3 px-6 text-center">Jumlah</th>
                            <th class="py-3 px-6">Kondisi</th>
                            <th class="py-3 px-6">Tanggal Pembelian</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($inventories as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-mono font-bold text-emerald-700">{{ $item->code }}</td>
                                <td class="py-4 px-6">
                                    <span class="font-bold text-gray-900 block">{{ $item->item_name }}</span>
                                    @if($item->notes)
                                        <span class="block text-[10px] text-gray-450 font-normal mt-0.5 max-w-xs truncate">{{ $item->notes }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-semibold">{{ $item->location }}</td>
                                <td class="py-4 px-6 text-center font-mono font-bold text-gray-800">{{ $item->quantity }}</td>
                                <td class="py-4 px-6">
                                    @if($item->condition === 'baik')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-50 text-emerald-850 border border-emerald-150">
                                            Baik
                                        </span>
                                    @elseif($item->condition === 'rusak_ringan')
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-50 text-amber-700 border border-amber-250">
                                            Rusak Ringan
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-red-50 text-red-700 border border-red-150">
                                            Rusak Berat
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-mono text-gray-500">
                                    {{ $item->purchase_date ? \Carbon\Carbon::parse($item->purchase_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="py-4 px-6 flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.inventory.edit', $item->id) }}" class="px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-bold border border-amber-250 rounded-lg">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus aset inventaris ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-650 font-bold border border-red-250 rounded-lg">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 font-semibold">Belum ada aset inventaris yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($inventories->hasPages())
                <div class="px-6 py-4 border-t border-gray-150">
                    {{ $inventories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
