<?php
return [

    'schemas' => [
        'default' => [
            'query' => [
                'booklets' => \App\GraphQL\Queries\BookletsQuery::class,
            ],
            'mutation' => [
                'login' => App\GraphQL\Mutations\LoginMutation::class,
                'createAnswer' => App\GraphQL\Mutations\CreateAnswerMutation::class
            ],
        ],
    ],

    'types' => [
        'Booklet' => \App\GraphQL\Types\BookletType::class,
        'LoginResponse' => App\GraphQL\Types\LoginResponseType::class,
        'BookletQuestion'=>\App\GraphQL\Types\BookletQuestionType::class,
        'BookletAnswer'=>\App\GraphQL\Types\BookletAnswerType::class,
        'AnswerResponse'=>\App\GraphQL\Types\AnswerResponseType::class

    ],

];
