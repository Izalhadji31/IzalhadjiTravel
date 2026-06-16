<?php

return [
    'enabled' => env('FONNTE_ENABLED', true),
    
    'api_url' => 'https://api.fonnte.com/send',
    'api_key' => env('FONNTE_API_KEY'),
    'device_key' => env('FONNTE_DEVICE_KEY'),
    
    'default_sender' => env('FONNTE_SENDER', 'ASR GO'),
    
    // Templates
    'templates' => [
        'registration' => 'Selamat datang di ASR GO! Akun Anda telah terdaftar. Nikmati kemudahan booking travel dan rental dengan harga terbaik.',
        
        'booking_created' => 'Booking Anda telah dibuat! Nomor booking: {booking_number}. Total: Rp{total}. Silakan lakukan pembayaran untuk mengkonfirmasi.',
        
        'payment_success' => 'Pembayaran Anda telah berhasil diterima! Terima kasih telah mempercayai ASR GO.',
        
        'armada_assigned' => 'Armada telah ditugaskan untuk booking Anda. Driver: {driver_name}, Nomor telepon: {driver_phone}. Estimasi kedatangan: {eta}',
        
        'trip_departure' => 'Armada Anda akan berangkat dalam 15 menit dari lokasi penjemputan. Pastikan Anda siap!',
        
        'trip_arrival' => 'Selamat datang! Armada telah tiba di lokasi tujuan. Terima kasih telah menggunakan ASR GO!',
        
        'refund_approved' => 'Permintaan pengembalian dana Anda telah disetujui. Dana sebesar Rp{amount} akan dikembalikan dalam 1-3 hari kerja.',
        
        'refund_rejected' => 'Permintaan pengembalian dana Anda telah ditolak. Alasan: {reason}',
    ],
];
