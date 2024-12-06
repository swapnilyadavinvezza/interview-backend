<?php

namespace App\GraphQL\Mutations;

use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'login',
    ];

    public function type(): Type
    {
        return \GraphQL::type('LoginResponse');
    }

    public function args(): array
    {
        return [
            'email' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'client_id' => [
                'type' => Type::nonNull(Type::string()),
            ],
            'client_secret' => [
                'type' => Type::nonNull(Type::string()),
            ],

            
        ];
    }

    public function resolve($root, $args)
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password'],
        ];
    
        $client = \Laravel\Passport\Client::where('id', $args['client_id'])->first();
        if (!$client || $client->secret !== $args['client_secret']) {
            throw new \Exception('Invalid client credentials');
        }
    
        if (!Auth::attempt($credentials)) {
            throw new \Exception('Invalid user credentials');
        }
    
        $user = Auth::user();
    
        // Generate token
        $personalAccessToken = $user->createToken('graphql');
        $tokenId = $personalAccessToken->token->id;
    
        // Retrieve token details from the database
        $accessToken = Token::find($tokenId);
        if (!$accessToken) {
            throw new \Exception('Token not found in database.');
        }
    
        $expiresIn = $accessToken->expires_at->diffForHumans(now());
    
        return [
            'token' => $personalAccessToken->accessToken,
            'expires_in' => $expiresIn,
            'email' => $user->email,
            'username' => $user->username,
            'userID' => $user->id

        ];
    }
    
}
