<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'user' => [
            'driver' => 'local',
            'root' => storage_path('app/public/user'),
            'url' => env('APP_URL').'/storage/user',
            'visibility' => 'public',
            'throw' => false,
        ],

        'rider' => [
            'driver' => 'local',
            'root' => storage_path('app/public/rider'),
            'url' => env('APP_URL').'/storage/rider',
            'visibility' => 'public',
            'throw' => false,
        ],

        'category' => [
            'driver' => 'local',
            'root' => storage_path('app/public/category'),
            'url' => env('APP_URL').'/storage/category',
            'visibility' => 'public',
            'throw' => false,
        ],

        'restaurant' => [
            'driver' => 'local',
            'root' => storage_path('app/public/restaurant'),
            'url' => env('APP_URL').'/storage/restaurant',
            'visibility' => 'public',
            'throw' => false,
        ],

        'ad' => [
            'driver' => 'local',
            'root' => storage_path('app/public/ad'),
            'url' => env('APP_URL').'/storage/ad',
            'visibility' => 'public',
            'throw' => false,
        ],

        'exports' => [
            'driver' => 'local',
            'root' => storage_path('app/public/exports'),
            'url' => env('APP_URL').'/storage/exports',
            'visibility' => 'public',
            'throw' => false,
        ],

        'supplements' => [
            'driver' => 'local',
            'root' => storage_path('app/public/supplements'),
            'url' => env('APP_URL').'/storage/supplements',
            'visibility' => 'public',
            'throw' => false,
        ],

        'orphanages' => [
            'driver' => 'local',
            'root' => storage_path('app/public/orphanages'),
            'url' => env('APP_URL').'/storage/orphanages',
            'visibility' => 'public',
            'throw' => false,
        ]

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
