<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

/**
 * @tags Auth
 */
#[Group('Auth', weight: 0)]
class RegisteredUserController extends Controller
{
    #[Endpoint(title: 'Register')]
    public function store(Request $request)
    {
        $request->validate([
            'name'     => [ 'required', 'string', 'max:255' ],
            'email'    => [ 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:users' ],
            'password' => [ 'required', 'confirmed', Password::defaults() ]
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->string('password'),
        ]);

        $token = $user->createToken('auth-token');

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token->plainTextToken,
        ], 201);
    }
}
