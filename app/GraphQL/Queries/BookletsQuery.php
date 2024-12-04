<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

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
            return Booklet::with('examEnrollment')
                        ->whereHas('examEnrollment',function($query) use($args){
                            $query->where('user_id',$args['user_id']);
                        })->get();
        
        }
        return Booklet::all();
    }
}
