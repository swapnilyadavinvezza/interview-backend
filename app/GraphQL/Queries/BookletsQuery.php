<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Carbon\Carbon;
use App\Models\Booklet;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
class BookletsQuery extends Query
{
    protected $allowedMethods = ['get', 'post'];

    protected $attributes = [
        'name' => 'booklets'
        ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Booklet'));
    }

 

    public function args(): array
    {
        return [
            'user_id' => [
                'type' => Type::int(),
                'description' => 'The ID of the user',
            ],
        ];
    }
    public function resolve($root, array $args)
    {
       
   

        if (isset($args['user_id'])) {
            $data = Booklet::with([
                'questions.answer' => function ($query) {
                    $query->select(['id', 'question_id', 'created_at']);
                }
            ])
            ->whereHas('examEnrollment', function ($query) use ($args) {
                $query->where('user_id', $args['user_id']);
            })
            ->get()
            ->map(function ($booklet) {
              
                $totalTime = $booklet->questions->sum(function ($question) {
                   

                    $createdAt = Carbon::parse($question->answer->created_at ?? null);
                    return $question->answer ? $createdAt->diffInSeconds(Carbon::now()) : 0;
                });
            
                $booklet->remaining_time = $totalTime;
            
                return $booklet;
            });
    
            return $data;
        }
        return Booklet::all();
    }
}
