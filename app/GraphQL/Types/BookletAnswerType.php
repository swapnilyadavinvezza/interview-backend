<?php

declare(strict_types=1);

namespace App\GraphQL\Types;
use App\Models\BookletAnswer;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BookletAnswerType extends GraphQLType
{
    protected $attributes = [
        'name' => 'BookletAnswer',
        'description' => 'A answers in a booklet',
        'model' => BookletAnswer::class, 
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID of booklet'
            ],
            'question_id' => [
                'type' => Type::string(),
                'description' => 'Name of booklet'
            ],
            'answer' => [
                'type' => Type::string(),
                'description' => 'Marks of booklet'
            ]
        ];
    }
}
