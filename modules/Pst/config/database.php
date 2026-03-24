<?php

declare(strict_types=1);

return [
    'connection' => 'maria-pst',
    'connections' => [
        'maria-pst' => [
            'driver' => env('DB_PST_DRIVER', 'mariadb'),
            'host' => env('DB_PST_HOST', '127.0.0.1'),
            'port' => env('DB_PST_PORT', '3306'),
            'database' => env('DB_PST_DATABASE', 'finance'),
            'username' => env('DB_PST_USERNAME', 'root'),
            'password' => env('DB_PST_PASSWORD', ''),
            'unix_socket' => env('DB_PST_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
    ],
];
