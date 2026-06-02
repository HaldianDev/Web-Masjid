<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Penerimaan Donasi Digital') }}
        </h2>
    </x-slot>

    <div class="space-y-6 text-xs">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 bg-gray-50 border-b border-gray-150 uppercase tracking-wider font-semibold">
                            <th class="py-3 px-6">Tanggal & Waktu</th>
                            <th class="py-3 px-6">ID Referensi</th>
                            <th class="py-3 px-6">Donatur</th>
                            <th class="py-3 px-6">No. Telp</th>
                            <th class="py-3 px-6">Metode</th>
                            <th class="py-3 px-6 text-right">Jumlah</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-gray-600">
                        @forelse($donations as $don)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 font-mono text-gray-700">
                                    {{ $don->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-4 px-6 font-mono font-bold text-gray-900">{{ $don->reference_id }}</td>
                                <td class="py-4 px-6 font-bold text-gray-800">{{ $don->donor_name }}</td>
                                <td class="py-4 px-6">{{ $don->donor_phone ?? '-' }}</td>
                                <td class="py-4 px-6 uppercase font-bold text-[10px] text-amber-600">{{ $don->payment_method }}</td>
                                <td class="py-4 px-6 text-right font-mono font-bold text-emerald-600">
                                    Rp {{ number_format($don->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[9px] uppercase font-extrabold border
                                        @if($don->status === 'success') bg-emerald-50 text-emerald-800 border-emerald-100
                                        @elseif($don->status === 'pending') bg-amber-50 text-amber-800 border-amber-250
                                        @else bg-red-50 text-red-650 border-red-200
                                        @endif">
                                        {{ $don->status }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 italic text-[11px] max-w-xs truncate" title="{{ $don->notes }}">{{ $don->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-gray-400 font-semibold">Belum ada donasi digital yang terekam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($donations->hasPages())
                <div class="px-6 py-4 border-t border-gray-150">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
