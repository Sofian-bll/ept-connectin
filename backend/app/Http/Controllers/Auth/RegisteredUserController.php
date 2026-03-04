<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validation du form
        $request->validate([
            'name'     => [ 'required', 'string', 'max:255' ],
            'email'    => [ 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:users' ],
            'password' => [ 'required', 'confirmed', Password::defaults() ]
        ]);

        // Create User
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);

        // Create Token
        $token = $user->createToken('auth-token');

        // 204 No Content
        return response()->json([
            'user'  => $user,
            'token' => $token->plainTextToken
        ], 201);
    }

}
