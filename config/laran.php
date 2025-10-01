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
        'tempPath' => 'uploads/_temp/'
    ]
];
