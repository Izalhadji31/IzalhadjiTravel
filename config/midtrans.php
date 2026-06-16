<?php

return [
    'enabled' => env('MIDTRANS_ENABLED', true),
    
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    
    'environment' => env('MIDTRANS_ENVIRONMENT', 'sandbox'), // sandbox or production
    
    'is_production' => env('MIDTRANS_ENVIRONMENT', 'sandbox') === 'production',
    
    // Notification settings
    'notification_url' => env('MIDTRANS_NOTIFICATION_URL', '/api/midtrans/notification'),
    'finish_redirect_url' => env('MIDTRANS_FINISH_URL', '/bookings/payment-success'),
    'error_redirect_url' => env('MIDTRANS_ERROR_URL', '/bookings/payment-error'),
    'unfinish_redirect_url' => env('MIDTRANS_UNFINISH_URL', '/bookings/payment-pending'),
    
    // Payment settings
    'enable_pay_later' => env('MIDTRANS_ENABLE_PAY_LATER', true),
    'enable_installment' => env('MIDTRANS_ENABLE_INSTALLMENT', false),
    'enable_point' => env('MIDTRANS_ENABLE_POINT', false),
];
