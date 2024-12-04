<?php

namespace App\GraphQL\Resolvers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class UserResolver extends Controller
{

    public function getUser($root, array $args, $context)
    {
        // Example logic to fetch the user by ID
        return \App\Models\User::find($args['id']);
    }
}
