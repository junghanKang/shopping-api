<?php

return [
    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'read' => [
                'host' => env('SLAVE_DB_HOST'),
                'port' => env('SLAVE_DB_PORT'),
            ],
            'write' => [
                'host' => env('MASTER_DB_HOST'),
                'port' => env('MASTER_DB_PORT'),
            ],
            'driver' => 'mysql',
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'prefix' => '',
            'strict' => true,
        ],
        // 'mysql_readonly' => [
        //     'read' => [
        //         'host' => env('SLAVE_DB_HOST'),
        //         'port' => env('SLAVE_DB_PORT'),
        //     ],
        //     'write' => [
        //         'host' => env('MASTER_DB_HOST'),
        //         'port' => env('MASTER_DB_PORT'),
        //     ],
        //     'driver' => 'mysql',
        //     // 'port' => env('SLAVE_DB_PORT'),
        //     'database' => env('DB_DATABASE'),
        //     'username' => env('DB_USERNAME'),
        //     'password' => env('DB_PASSWORD'),
        //     'prefix' => '',
        //     'strict' => true,
        // ],

        // 'mysql' => [
        //     'driver' => 'mysql',
        //     'host' => env('MASTER_DB_HOST', '127.0.0.1'),
        //     'port' => env('DB_PORT', '3306'),
        //     'database' => env('DB_DATABASE', 'forge'),
        //     'username' => env('DB_USERNAME', 'forge'),
        //     'password' => env('DB_PASSWORD', ''),
        //     'unix_socket' => env('DB_SOCKET', ''),
        //     'charset' => 'utf8mb4',
        //     'collation' => 'utf8mb4_unicode_ci',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        //     'strict' => true,
        // ],
    ],

];
