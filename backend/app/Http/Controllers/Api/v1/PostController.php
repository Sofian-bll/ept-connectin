<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(
            Post::with('user')->withCount('likes')->orderBy('created_at', 'desc')->paginate(),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        unset($data['media']);

        if ($request->hasFile('media')) {
            $data['media_url'] = $request->file('media')->store('media', 'public');
        }

        $post = $request->user()->posts()->create($data);
        $post->load('user')->loadCount('likes');

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load('user')->loadCount('likes');

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        abort_if(Auth::id() !== $post->user_id, 403, 'Forbidden');

        $data = $request->validated();
        unset($data['media']);

        if ($request->hasFile('media')) {
            if ($post->media_url) {
                Storage::disk('public')->delete($post->media_url);
            }
            $data['media_url'] = $request->file('media')->store('media', 'public');
        }

        $post->update($data);
        $post->load('user')->loadCount('likes');

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_if(Auth::id() !== $post->user_id, 403, 'Forbidden');
        
        if ($post->media_url) {
            Storage::disk('public')->delete($post->media_url);
        }
        
        $post->delete();

        return response()->noContent();
    }

    /**
     * Display posts for the authenticated user.
     */
    public function indexUser(Request $request)
    {
        $posts = $request->user()->posts()
            ->with('user')->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->paginate();

        return PostResource::collection($posts);
    }
}


