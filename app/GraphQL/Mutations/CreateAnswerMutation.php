<?php

namespace App\GraphQL\Mutations;

use Laravel\Passport\Token;
use App\Models\BookletAnswer;
use App\Models\ExamEnrollment;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Mutation;

class CreateAnswerMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createAnswer',
    ];

    public function type(): Type
    {
        return \GraphQL::type('AnswerResponse');
    }

    public function args(): array
    {
        return [
            'user_id' => [
                'type' =>  Type::nonNull(Type::int()),
            ],
            'booklet_id' => [
                'type' =>  Type::nonNull(Type::int()),
            ],
            'question_id' => [
                'type' =>  Type::nonNull(Type::int()),
            ],
            'answer' => [
                'type' =>  Type::nonNull(Type::string()),
            ],
            'booklet_status' => [
                'type' => Type::int(),
            ]
            
        ];
    }

    public function resolve($root, $args)
    {
   
        $data = [
            'user_id' => $args['user_id'],
            'booklet_id' => $args['booklet_id'],
            'question_id' => $args['question_id'],
            'answer' => $args['answer'],
            'status' => $args['booklet_status']
        ];

        $bookletAnswer = BookletAnswer::create($data);
        if(isset($args['booklet_status'])){
            $examEnrollment = ExamEnrollment::where('booklet_id', $args['booklet_id'])->first();
            $examEnrollment->status = 'completed';
            $examEnrollment->save();
        }
        return $bookletAnswer;

    }
    
}
