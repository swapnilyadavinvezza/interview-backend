<?php

namespace App\GraphQL\Types;

use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class LoginResponseType extends GraphQLType
{
    protected $attributes = [
        'name' => 'LoginResponse',
        'description' => 'Response for login mutation',
    ];

    public function fields(): array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Status of the operation',
            ],
            'token' => [
                'type' => Type::string(),
                'description' => 'The OAuth token',
            ],
            'username' => [
                'type' => Type::string(),
                'description' => 'The OAuth token',
            ],
            'expires_in' => [
                'type' => Type::string(),
                'description' => 'The OAuth token',
            ],
        ];
    }
}
