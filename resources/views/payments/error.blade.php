<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal - ASR GO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-red-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- Error Icon -->
                <div class="bg-red-600 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-500 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white">Pembayaran Gagal</h1>
                </div>

                <!-- Content -->
                <div class="px-6 py-8">
                    <!-- Order ID -->
                    <div class="bg-red-50 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-600 mb-1">ID Transaksi</p>
                        <p class="font-mono text-lg font-semibold text-gray-900 break-all">{{ $orderId }}</p>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-2">Status Pembayaran</p>
                        <div class="flex items-center">
                            <span class="inline-block px-4 py-2 bg-red-100 text-red-800 rounded-full font-semibold text-sm">
                                Gagal
                            </span>
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-red-800 font-semibold mb-2">Transaksi Anda Ditolak</p>
                        <p class="text-sm text-red-700">
                            Pembayaran tidak berhasil diproses. Silakan coba lagi dengan metode pembayaran yang berbeda atau hubungi dukungan pelanggan kami.
                        </p>
                    </div>

                    <!-- Booking Info -->
                    @if($payment)
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Informasi Pemesanan</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total Pembayaran:</span>
                                    <span class="font-semibold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Waktu:</span>
                                    <span class="font-semibold">{{ $payment->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="space-y-3">
                        <button onclick="retryPayment()" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                            Coba Pembayaran Lagi
                        </button>

                        <a href="{{ route('dashboard') }}" 
                           class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 px-4 rounded-lg text-center transition-colors">
                            Kembali ke Dashboard
                        </a>
                    </div>

                    <!-- Support -->
                    <div class="border-t pt-4 mt-6">
                        <p class="text-center text-sm text-gray-600">
                            Butuh bantuan? <a href="#" class="text-blue-600 hover:text-blue-700 font-semibold">Hubungi Dukungan</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function retryPayment() {
            alert('Fitur pembayaran ulang akan dialihkan ke halaman pembayaran');
            // Redirect to retry logic
            window.history.back();
        }
    </script>
</body>
</html>
