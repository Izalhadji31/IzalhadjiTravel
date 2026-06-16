<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - ASR GO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-green-50 to-green-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- Success Icon -->
                <div class="bg-green-600 py-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-500 rounded-full mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white">Pembayaran Berhasil!</h1>
                </div>

                <!-- Content -->
                <div class="px-6 py-8">
                    <!-- Order ID -->
                    <div class="bg-green-50 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-600 mb-1">ID Transaksi</p>
                        <p class="font-mono text-lg font-semibold text-gray-900 break-all">{{ $orderId }}</p>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-2">Status Pembayaran</p>
                        <div class="flex items-center">
                            <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-full font-semibold text-sm">
                                {{ ucfirst($transactionStatus ?? 'success') }}
                            </span>
                        </div>
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
                        @if($booking)
                            @if(class_basename($booking) === 'TravelBooking')
                                <a href="{{ route('bookings.travel.show', $booking) }}" 
                                   class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-colors">
                                    Lihat Detail Travel
                                </a>
                            @else
                                <a href="{{ route('bookings.rental.show', $booking) }}" 
                                   class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg text-center transition-colors">
                                    Lihat Detail Rental
                                </a>
                            @endif
                        @endif

                        <a href="{{ route('dashboard') }}" 
                           class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 px-4 rounded-lg text-center transition-colors">
                            Kembali ke Dashboard
                        </a>
                    </div>

                    <!-- Footer -->
                    <p class="text-center text-sm text-gray-600 mt-6">
                        Terima kasih telah menggunakan ASR GO. Bukti pembayaran telah dikirim ke email Anda.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
