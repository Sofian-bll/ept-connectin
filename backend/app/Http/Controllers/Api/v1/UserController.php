<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->update([ 'password' => $request->validated()['password'] ]);

        return response()->json([ 'message' => 'Password updated successfully' ]);
    }

    public function destroy(Request $request)
    {
        $strategy = $request->query('strategy');

        if (!in_array($strategy, [ 'delete', 'anonymize' ])) {
            return response()->json([ 'message' => 'Invalid strategy' ], 422);
        }

        $user = $request->user();

        if ($strategy === 'anonymize') {
            $user->likes()->delete();
            $user->tokens()->delete();
            $user->update([
                'name'     => 'Deleted User',
                'email'    => 'deleted_' . $user->id . '_' . time() . '@deleted.invalid',
                'password' => Str::random(32),
                'avatar'   => null,
            ]);
        } else {
            $user->tokens()->delete();
            $user->delete();
        }

        return response()->noContent();
    }
}
