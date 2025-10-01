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
        'path' => 'public/uploads/',
        'tempPath' => 'public/uploads/temp/'
    ]
];
