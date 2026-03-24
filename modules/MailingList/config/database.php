<?php

declare(strict_types=1);

return [
    'connection' => 'maria-mailinglist',
    'connections' => [
        'maria-mailinglist' => [
            'driver' => env('DB_MAILINGLIST_DRIVER', 'mariadb'),
            'host' => env('DB_MAILINGLIST_HOST', '127.0.0.1'),
            'port' => env('DB_MAILINGLIST_PORT', '3306'),
            'database' => env('DB_MAILINGLIST_DATABASE', 'mailinglist'),
            'username' => env('DB_MAILINGLIST_USERNAME', 'root'),
            'password' => env('DB_MAILINGLIST_PASSWORD', ''),
            'unix_socket' => env('DB_MAILINGLIST_SOCKET', ''),
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
