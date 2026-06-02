<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bukti Pembayaran Donasi - {{ $donation->reference_id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .print-card { border: none !important; shadow: none !important; background: white !important; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-green-950 text-slate-100 min-h-screen flex items-center justify-center p-6 antialiased">

    <div class="max-w-md w-full bg-slate-900/80 backdrop-blur-md rounded-3xl p-8 border border-amber-500/20 shadow-2xl space-y-6 print-card">
        
        <!-- Success Badge -->
        <div class="text-center">
            <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto mb-4 border border-emerald-500/30">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <span class="text-xs uppercase tracking-wider font-extrabold text-emerald-400">Pembayaran Sukses</span>
            <h1 class="text-2xl font-bold text-white mt-1">Bukti Penerimaan Donasi</h1>
            <span class="text-xs text-slate-400 block mt-1 font-mono">ID: {{ $donation->reference_id }}</span>
        </div>

        <!-- Receipt Table -->
        <div class="border-t border-b border-emerald-850/60 py-4 space-y-3.5 text-sm">
            <div class="flex justify-between">
                <span class="text-slate-400">Nama Donatur</span>
                <span class="font-bold text-white">{{ $donation->donor_name }}</span>
            </div>
            @if($donation->donor_phone)
                <div class="flex justify-between">
                    <span class="text-slate-400">Nomor Telepon</span>
                    <span class="font-medium text-slate-200">{{ $donation->donor_phone }}</span>
                </div>
            @endif
            <div class="flex justify-between">
                <span class="text-slate-400">Metode Pembayaran</span>
                <span class="font-bold text-white uppercase">{{ $donation->payment_method }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Tanggal Transaksi</span>
                <span class="font-medium text-slate-200">{{ $donation->created_at->format('d F Y H:i') }}</span>
            </div>
            @if($donation->notes)
                <div class="border-t border-emerald-900/40 pt-3">
                    <span class="text-xs text-slate-400 block font-semibold mb-1">Catatan/Pesan:</span>
                    <p class="text-xs text-slate-300 italic">"{{ $donation->notes }}"</p>
                </div>
            @endif
            <div class="flex justify-between border-t border-emerald-900/50 pt-4">
                <span class="text-slate-400 font-bold">Total Donasi</span>
                <span class="text-xl font-black text-emerald-400 font-mono">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footnote -->
        <div class="text-center text-xs text-slate-400 leading-relaxed bg-emerald-950/30 p-4 rounded-xl border border-emerald-800/40">
            <p>Jazakumullah Khairan Katsiran.</p>
            <p class="mt-1">Semoga donasi yang Anda salurkan menjadi pembuka pintu berkah dan pahala yang terus mengalir.</p>
        </div>

        <!-- Print / Back actions -->
        <div class="space-y-3 no-print">
            <button onclick="window.print()" class="w-full py-3.5 bg-emerald-800 hover:bg-emerald-700 text-amber-400 border border-amber-500/20 font-bold rounded-xl text-center shadow-lg transition-all">
                Cetak Bukti Pembayaran
            </button>
            <a href="{{ route('home') }}" class="block text-center py-3 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-emerald-950 font-bold rounded-xl shadow-lg transition-all text-sm">
                Kembali ke Beranda
            </a>
        </div>

    </div>

</body>
</html>
