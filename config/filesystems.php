<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Файловый диск по умолчанию
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете указать диск файловой системы по умолчанию,
    | который должен использоваться. (Массив disks)
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Файловые диски
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете настроить столько "дисков" файловой системы, сколько необходимо.
    |
    | root - путь до директории хранения.
    | url - путь получения, при запросе.
    |
    */

    'disks' => [
        'local' => [
            'root' => storage_path('app'),
        ],

        'public' => [
            'root' => storage_path('public'),
            'url' => '/storage',
        ],
    ],
];
