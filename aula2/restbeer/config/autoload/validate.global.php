<?php

return [
    'validate' => [
        [
            'uri' => '/beer',
            'method' => ['POST', 'PUT'],
            'class' => App\Model\Beer::class,
        ],
    ],
];
