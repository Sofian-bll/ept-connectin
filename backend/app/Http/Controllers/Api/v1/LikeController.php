<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Toggle like/unlike on a post
     */
    public function toggle(Request $request, Post $post): JsonResponse
    {
        $like = Like::where('user_id', $request->user()->id)
            ->where('post_id', $post->id)
            ->first();

        if ($like) {
            $like->delete();

            return response()->json([
                'liked'       => false,
                'likes_count' => $post->likes()->count(),
            ], 200);
        }

        Like::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
        ]);

        return response()->json([
            'liked'       => true,
            'likes_count' => $post->likes()->count(),
        ], 201);
    }
}
