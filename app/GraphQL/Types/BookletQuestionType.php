<?php

declare(strict_types=1);

namespace App\GraphQL\Types;
use App\Models\Booklet;
use App\Models\BookletQuestion;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class BookletQuestionType extends GraphQLType
{
    protected $attributes = [
        'name' => 'BookletQuestion',
        'description' => 'A question in a booklet',
        'model' => BookletQuestion::class, 
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID of booklet'
            ],
            'question_type' => [
                'type' => Type::string(),
                'description' => 'Name of booklet'
            ],
            'marks' => [
                'type' => Type::string(),
                'description' => 'Marks of booklet'
            ],
            'question' => [
                'type' => Type::string(),
                'description' => 'Question of booklet'
            ],
            'option_1' => [
                'type' => Type::string(),
                'description' => 'First option of booklet'
            ],
            'option_2' => [
                'type' => Type::string(),
                'description' => 'Second option of booklet'
            ],
            'option_3' => [
                'type' => Type::string(),
                'description' => 'Third option of booklet'
            ],
            'option_4' => [
                'type' => Type::string(),
                'description' => 'Fourth option of booklet'
            ],
            'image' => [
                'type' => Type::int(),
                'description' => 'Image of booklet'
            ],
            'answer' => [
                'type' => Type::string(),
                'description' => 'Answer of booklet'
            ]
        ];
    }
}
