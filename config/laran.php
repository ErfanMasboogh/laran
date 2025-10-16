<?php

return [
    'auth' => [
        'guards' => [
            'manager' => [
                'driver' => 'session',
                'provider' => 'managers',
            ],
        ],
        'providers' => [
            'managers' => [
                'driver' => 'eloquent',
                'model' => \ErfanMasboogh\Laran\Models\Manager::class,
            ],
        ],
    ],
    'storage' => [
        'path' => 'uploads/',
        'tempPath' => 'uploads/_temp/',
        'types' => [
            'image' => [
                'accept' => '.jpeg, .png, .jpg, .webp',
                'validation' => [
                    'image',
                    'max:5120', // Equals to 5 Mb
                    'mimes:jpeg,jpg,png,webp',
                ]
            ]
        ]
    ],
    'smsProvider' => [
        'smsProviderName' => env('SMS_PROVIDER_NAME', 'msgway'),
        'apiKey' => env('SMS_PROVIDER_API_KEY'),
    ],
    'otp' => [
        'userInfoCacheTime' => 30, // In minutes
        'tryLimit' => 5,
        'expireTime' => 120, // In seconds
        'restrictTime' => 300, // ~~
        'resendCoolDown' => 60, // ~~
        'msgway' => [
            'templateID' => env('MSGWAY_OTP_TEMPLATE_ID'),
        ],
    ],
];
