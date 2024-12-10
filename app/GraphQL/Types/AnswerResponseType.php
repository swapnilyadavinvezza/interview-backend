<?php

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class AnswerResponseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'AnswerResponse',
        'description' => 'Response for login mutation',
    ];

    public function fields(): array
    {
        return [
            'user_id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Status of the operation',
            ],
            'booklet_id' => [
                'type' =>  Type::nonNull(Type::string()),
            ],
            'question_id' => [
                'type' =>  Type::nonNull(Type::string()),
            ],
            'answer' => [
                'type' =>  Type::nonNull(Type::string()),
            ],
        ];
    }
}
