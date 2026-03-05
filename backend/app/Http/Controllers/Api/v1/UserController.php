<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;

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
}
