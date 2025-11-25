<?php

return [

    // Mode
    'mode' => env('CCAVENUE_MODE', 'test'),

    // Test credentials
    'test_merchant_id'   => env('CCAVENUE_TEST_MERCHANT_ID'),
    'test_access_code'   => env('CCAVENUE_TEST_ACCESS_CODE'),
    'test_working_key'   => env('CCAVENUE_TEST_WORKING_KEY'),
    'test_redirect_url'  => env('CCAVENUE_TEST_REDIRECT_URL'),
    'test_cancel_url'    => env('CCAVENUE_TEST_CANCEL_URL'),

    // Live credentials (for future use)
    'merchant_id'        => env('CCAVENUE_MERCHANT_ID'),
    'access_code'        => env('CCAVENUE_ACCESS_CODE'),
    'working_key'        => env('CCAVENUE_WORKING_KEY'),
    'redirect_url'       => env('CCAVENUE_REDIRECT_URL'),
    'cancel_url'         => env('CCAVENUE_CANCEL_URL'),

    // API URLs
    'urls' => [
        'test' => [
            'transaction' => 'https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction',
        ],
        'live' => [
            'transaction' => 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction',
        ]
    ],

    // Currency
    'currency' => 'INR',
    
    /*
    |--------------------------------------------------------------------------
    | SSL Verification
    |--------------------------------------------------------------------------
    */
    'curl_options' => [
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => true,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    */
    'logging' => [
        'enabled' => true,
        'channel' => env('CCAVENUE_LOG_CHANNEL', 'daily'),
    ],
];