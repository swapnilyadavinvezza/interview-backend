<?php

declare(strict_types=1);

namespace App\GraphQL\Types;
use GraphQL\Type\Definition\Type;
use App\Models\Booklet;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class BookletType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Booklet',
        'description' => 'A type',
        'model' => Booklet::class

    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'ID of booklet'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Name of booklet'
            ],
            'level' => [
                'type' => Type::string(),
                'description' => 'Level of booklet'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Description of booklet'
            ],
            'status' => [
                'type' => Type::string(),
                'description' => 'Status of booklet'
            ],
            'total_weightage' => [
                'type' => Type::int(),
                'description' => 'Total weightage of booklet'
            ],
            'created_by' => [
                'type' => Type::string(),
                'description' => 'Created by'
            ],
            'duration' => [
                'type' => Type::int(),
                'description' => 'Duration of booklet'
            ],
            'duration' => [
                'type' => Type::int(),
                'description' => 'Duration of booklet'
            ],
            'questions' => [
                'type' => Type::listOf(GraphQL::type('BookletQuestion')),
                'description' => 'The questions in the booklet',
                'resolve' => function ($root) {
                    return $root->questions()->with('answer')->get()->map(function ($question) {

                        $answer = $question->answer;

                        $answerData = $answer ? $answer->answer : null;
                        return [
                            'id' => $question->id,
                            'question' => $question->question,
                            'answer' => $answerData,
                        ];
                    });
                },
            ],
        ];
    }
}
