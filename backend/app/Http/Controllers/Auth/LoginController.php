<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @tags Auth
 */
#[Group('Auth', weight: 0)]
class LoginController extends Controller
{
    #[Endpoint(title: 'Login')]
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => [ 'required', 'email' ],
            'password' => [ 'required' ],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect',
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth-token');

        return response()->json([
            'token' => $token->plainTextToken,
            'user' => new UserResource($user),
        ], 200);
    }

    #[Endpoint(title: 'Logout')]
    public function destroy(Request $request)
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token = $request->user()->currentAccessToken();
        $token?->delete();

        return response()->noContent();
    }
}
