<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Tertunda - ASR GO</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-yellow-50 to-yellow-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- Pending Icon -->
                <div class="bg-yellow-600 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-500 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white">Pembayaran Tertunda</h1>
                </div>

                <!-- Content -->
                <div class="px-6 py-8">
                    <!-- Order ID -->
                    <div class="bg-yellow-50 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-600 mb-1">ID Transaksi</p>
                        <p class="font-mono text-lg font-semibold text-gray-900 break-all">{{ $orderId }}</p>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-2">Status Pembayaran</p>
                        <div class="flex items-center">
                            <span class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-semibold text-sm">
                                Menunggu Konfirmasi
                            </span>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-yellow-800">
                            Pembayaran Anda masih dalam proses verifikasi. Kami akan memberitahu Anda segera setelah pembayaran dikonfirmasi.
                        </p>
                    </div>

                    <!-- Booking Info -->
                    @if($booking)
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Informasi Pemesanan</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kode Pemesanan:</span>
                                    <span class="font-semibold">{{ $booking->booking_code }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Total Pembayaran:</span>
                                    <span class="font-semibold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="space-y-3">
                        <button onclick="checkPaymentStatus()" 
                                class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                            Periksa Status
                        </button>

                        <a href="{{ route('dashboard') }}" 
                           class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 px-4 rounded-lg text-center transition-colors">
                            Kembali ke Dashboard
                        </a>
                    </div>

                    <!-- Footer -->
                    <p class="text-center text-sm text-gray-600 mt-6">
                        Jangan tutup halaman ini. Anda akan diberitahu saat pembayaran berhasil.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkPaymentStatus() {
            const button = event.target;
            button.disabled = true;
            button.textContent = 'Memeriksa...';

            fetch("{{ route('payments.check-status', $payment) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.status === 'success') {
                        window.location.href = "{{ route('payments.success') }}?order_id={{ $orderId }}";
                    } else if (data.status === 'failed') {
                        window.location.href = "{{ route('payments.error') }}?order_id={{ $orderId }}";
                    } else {
                        button.disabled = false;
                        button.textContent = 'Masih Tertunda - Cek Lagi';
                    }
                } else {
                    alert('Gagal memeriksa status: ' + data.message);
                    button.disabled = false;
                    button.textContent = 'Periksa Status';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan');
                button.disabled = false;
                button.textContent = 'Periksa Status';
            });
        }

        // Auto-check every 10 seconds
        setInterval(checkPaymentStatus, 10000);
    </script>
</body>
</html>
