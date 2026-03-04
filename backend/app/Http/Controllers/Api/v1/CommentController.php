<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of comments for a post.
     */
    public function index(Post $post)
    {
        return CommentResource::collection(
            $post->comments()->orderBy('created_at', 'desc')->paginate()
        );
    }

    /**
     * Store a newly created comment.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'content'   => $request->validated()['content'],
            'author_id' => $request->user()->id,
        ]);

        return new CommentResource($comment);
    }

    /**
     * Update the specified comment.
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        abort_if(Auth::id() !== $comment->author_id, 403, 'Forbidden');

        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Request $request, Post $post, Comment $comment)
    {
        abort_if($request->user()->id !== $comment->author_id, 403, 'Forbidden');

        $comment->delete();

        return response()->noContent();
    }
}
