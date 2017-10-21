<?php

return [
    'db' => [
        'sqlite' => [
                'driver' => 'Pdo_Sqlite',
                'database' => 'beers.db',
        ],
        'mysql' => [
            'driver' => 'Pdo_Mysql',
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => 'root',
            'database' => 'beers',
        ],
    ]
];