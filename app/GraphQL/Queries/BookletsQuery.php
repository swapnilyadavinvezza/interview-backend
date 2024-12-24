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
            $data = Booklet::with(['examEnrollment', 'questions.answer' => function ($query) {
                $query->select(['id', 'booklet_id', 'created_at']);
            }])->whereHas('examEnrollment', function ($query) use ($args) {
                    $query->where('user_id', $args['user_id']);
                })->get()
                ->map(function ($booklet) {
                    $totalTime = $booklet->questions->sum(function ($question) {

                        return $question->answer ? Carbon::parse($question->answer->created_at)->diffInSeconds(now()) : 0;
                    });
                    $booklet->remaining_time = $totalTime;

                    return $booklet;
                });
    
            return $data;
        }
        return Booklet::all();
    }
}
