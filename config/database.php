<?php

// Тут прописываются все что касается подключение к базе.
return [
    'default'=>'mysql',

    'connections'=>[
        'mysql' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => 'tizilim.daryn.kz',
            'port' => '3306',
            'database' => 'admin_tizilim',
            'username' => 'admin_tizilim',
            'password' => 'daryn23',
            'charset' => 'utf8mb4',
        ],
        'local' => [
            'driver' => 'mysql',
            'url' => '',
            'host' => 'localhost',
            'port' => '3306',
            'database' => 'registries',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
        ],
    ]
];