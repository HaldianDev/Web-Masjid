<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Instruksi Pembayaran Donasi - {{ $donation->reference_id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;855&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-green-950 text-slate-100 min-h-screen flex items-center justify-center p-6 antialiased">

    <div class="max-w-md w-full bg-slate-900/80 backdrop-blur-md rounded-3xl p-8 border border-amber-500/20 shadow-2xl space-y-6" x-data="checkoutSimulator('{{ $donation->reference_id }}')">
        
        <!-- Header -->
        <div class="text-center">
            <span class="text-[10px] tracking-wider uppercase font-bold text-amber-400 bg-emerald-900/60 px-3 py-1 rounded-full border border-amber-500/10">Simulasi Pembayaran</span>
            <h1 class="text-xl font-bold text-white mt-3">Selesaikan Donasi Anda</h1>
            <p class="text-xs text-slate-400 mt-1">Ref: <span class="font-mono text-amber-500 font-semibold">{{ $donation->reference_id }}</span></p>
        </div>

        <!-- Details -->
        <div class="bg-emerald-950/40 border border-emerald-850/60 p-5 rounded-2xl space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-slate-400">Donatur:</span>
                <span class="font-semibold text-white">{{ $donation->donor_name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-400">Metode:</span>
                <span class="font-bold text-amber-400 uppercase">{{ $donation->payment_method }}</span>
            </div>
            <div class="flex justify-between border-t border-emerald-900/50 pt-3">
                <span class="text-slate-400">Jumlah Bayar:</span>
                <span class="font-extrabold text-lg text-emerald-400 font-mono">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- QRIS Visual -->
        @if($donation->payment_method === 'qris' || $donation->payment_method === 'gopay' || $donation->payment_method === 'ovo')
            <div class="flex flex-col items-center justify-center p-6 bg-white rounded-2xl border-4 border-amber-400/50 shadow-inner">
                <!-- QR Code representation in SVG -->
                <svg class="w-48 h-48 text-slate-900" viewBox="0 0 100 100" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0" y="0" width="30" height="30" fill="currentColor" />
                    <rect x="5" y="5" width="20" height="20" fill="white" />
                    <rect x="10" y="10" width="10" height="10" fill="currentColor" />
                    
                    <rect x="70" y="0" width="30" height="30" fill="currentColor" />
                    <rect x="75" y="5" width="20" height="20" fill="white" />
                    <rect x="80" y="10" width="10" height="10" fill="currentColor" />

                    <rect x="0" y="70" width="30" height="30" fill="currentColor" />
                    <rect x="5" y="75" width="20" height="20" fill="white" />
                    <rect x="10" y="80" width="10" height="10" fill="currentColor" />

                    <rect x="40" y="40" width="20" height="20" fill="currentColor" />
                    <rect x="45" y="45" width="10" height="10" fill="white" />

                    <!-- Random modules -->
                    <rect x="40" y="10" width="10" height="20" fill="currentColor" />
                    <rect x="15" y="45" width="10" height="10" fill="currentColor" />
                    <rect x="50" y="75" width="15" height="10" fill="currentColor" />
                    <rect x="75" y="45" width="15" height="15" fill="currentColor" />
                </svg>
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mt-4">Pindai QR Untuk Membayar</span>
                <span class="text-[9px] text-red-500 font-semibold mt-1">Hanya berlaku 10 menit</span>
            </div>
        @else
            <!-- Bank Virtual Account Details -->
            <div class="bg-emerald-950/20 p-5 border border-emerald-800 rounded-2xl space-y-4">
                <div>
                    <span class="text-xs text-slate-400 block font-semibold uppercase">Nomor Virtual Account</span>
                    <div class="flex items-center justify-between mt-1">
                        <span class="font-mono text-lg font-bold text-amber-400 select-all tracking-wider">8827301290382901</span>
                        <button type="button" onclick="navigator.clipboard.writeText('8827301290382901'); alert('Nomor VA disalin!')" class="text-xs bg-emerald-800 hover:bg-emerald-700 text-white px-3 py-1.5 rounded-lg border border-amber-500/10">
                            Salin
                        </button>
                    </div>
                </div>
                <div class="text-xs text-slate-300 space-y-1.5 border-t border-emerald-900/50 pt-3">
                    <span class="font-bold text-white block mb-1">Panduan Transfer VA:</span>
                    <p>1. Masuk ke m-Banking atau ATM pilihan Anda.</p>
                    <p>2. Pilih menu Transfer / Virtual Account.</p>
                    <p>3. Masukkan nomor VA di atas.</p>
                    <p>4. Konfirmasi nama donatur dan jumlah bayar.</p>
                </div>
            </div>
        @endif

        <!-- Action / Simulation buttons -->
        <div class="space-y-3">
            <button @click="triggerSuccess()" class="w-full py-4 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-emerald-950 font-bold rounded-xl shadow-lg shadow-amber-500/15 text-center transition-all hover:scale-[1.01]">
                Simulasikan Pembayaran Sukses
            </button>
            
            <a href="{{ route('home') }}" class="block text-center py-2.5 text-xs text-slate-400 hover:text-white transition-colors">
                Batal & Kembali ke Beranda
            </a>
        </div>

    </div>

    <!-- Payment simulation script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('checkoutSimulator', (referenceId) => ({
                referenceId: referenceId,

                triggerSuccess() {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    fetch(`/donation/checkout/${this.referenceId}/success`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = `/donation/receipt/${this.referenceId}`;
                        } else {
                            alert('Gagal mensimulasikan pembayaran.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Terjadi kesalahan koneksi.');
                    });
                }
            }));
        });
    </script>

</body>
</html>
