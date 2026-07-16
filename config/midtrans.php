<?php

return [
    'enabled' => env('MIDTRANS_ENABLED', true),
    
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    
    'environment' => env('MIDTRANS_ENVIRONMENT', 'sandbox'), // sandbox or production
    
    'is_production' => env('MIDTRANS_ENVIRONMENT', 'sandbox') === 'production',
    'snap_url' => env('MIDTRANS_SNAP_URL', env('MIDTRANS_ENVIRONMENT', 'sandbox') === 'production'
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js'),
    
    // Notification settings
    'notification_url' => env('MIDTRANS_NOTIFICATION_URL', '/api/midtrans/notification'),
    'finish_redirect_url' => env('MIDTRANS_FINISH_URL', '/payments/success'),
    'error_redirect_url' => env('MIDTRANS_ERROR_URL', '/payments/error'),
    'unfinish_redirect_url' => env('MIDTRANS_UNFINISH_URL', '/payments/pending'),
    
    // Payment settings
    'enable_pay_later' => env('MIDTRANS_ENABLE_PAY_LATER', true),
    'enable_installment' => env('MIDTRANS_ENABLE_INSTALLMENT', false),
    'enable_point' => env('MIDTRANS_ENABLE_POINT', false),
];
