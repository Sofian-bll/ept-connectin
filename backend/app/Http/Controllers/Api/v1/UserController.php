<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @tags Users
 */
#[Group('Users', weight: 1)]
class UserController extends Controller
{
    #[Endpoint(title: 'Get My Profile')]
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    #[Endpoint(title: 'Get User')]
    public function show(User $user)
    {
        return new UserResource($user);
    }

    #[Endpoint(title: 'Update Profile')]
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->storeAs(
                'avatars',
                $user->id . '.' . $request->file('avatar')->extension(),
                'public'
            );
        }

        $user->update($data);

        return new UserResource($user);
    }

    #[Endpoint(title: 'Update Password')]
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();
        $user->update([ 'password' => $request->validated()['password'] ]);

        return response()->json([ 'message' => 'Password updated successfully' ]);
    }

    #[Endpoint(title: 'Delete Account')]
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
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->update([
                'name'     => 'Deleted User',
                'email'    => 'deleted_' . $user->id . '_' . time() . '@deleted.invalid',
                'password' => Str::random(32),
                'avatar'   => null,
            ]);
        } else {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            foreach ($user->posts()->whereNotNull('media_url')->get() as $post) {
                Storage::disk('public')->delete($post->media_url);
            }
            $user->tokens()->delete();
            $user->delete();
        }

        return response()->noContent();
    }
}
