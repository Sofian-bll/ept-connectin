<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @tags Comments
 */
#[Group('Comments', weight: 3)]
class CommentController extends Controller
{
    #[Endpoint(title: 'List Comments')]
    public function index(Post $post)
    {
        return CommentResource::collection(
            $post->comments()->with('user')->orderBy('created_at', 'desc')->paginate()
        );
    }

    #[Endpoint(title: 'Create Comment')]
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'content' => $request->validated()['content'],
            'user_id' => $request->user()->id,
        ]);

        $comment->load('user');

        return new CommentResource($comment);
    }

    #[Endpoint(title: 'Update Comment')]
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        abort_if(Auth::id() !== $comment->user_id, 403, 'Forbidden');

        $comment->update($request->validated());
        $comment->load('user');

        return new CommentResource($comment);
    }

    #[Endpoint(title: 'Delete Comment')]
    public function destroy(Request $request, Post $post, Comment $comment)
    {
        abort_if($request->user()->id !== $comment->user_id, 403, 'Forbidden');

        $comment->delete();

        return response()->noContent();
    }
}
