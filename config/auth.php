<?php
return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],
    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],
    'keys' => [
        'private' => env('JWT_PRIVATE_KEY_PATH', 'file://' . storage_path('app/private_key.pem')),
        'public' => env('JWT_PUBLIC_KEY_PATH', 'file://' . storage_path('app/public_key.pem')),
    ],
];
