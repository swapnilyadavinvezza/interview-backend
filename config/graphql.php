<?php
return [

    'schemas' => [
        'default' => [
            'query' => [
                'booklets' => \App\GraphQL\Queries\BookletsQuery::class,
            ],
            'middleware' => [],
            'method' => ['get', 'post'],
        ],
    ],

    'types' => [
        'Booklet' => \App\GraphQL\Types\BookletType::class,
    ],

];
