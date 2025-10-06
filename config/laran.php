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
    ]
];
