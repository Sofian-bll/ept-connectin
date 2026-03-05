<?php

use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\v1\LikeController;
use App\Http\Controllers\Api\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    // Auth Routes [Public]
    require __DIR__ . '/auth.php';

    // Protected Routes
    Route::middleware([ 'auth:sanctum' ])->group(function () {

        // User
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('user/posts', [ PostController::class, 'indexUser' ])->name('user.posts');

        // Posts
        Route::apiResource('posts', PostController::class);

        // Comments (nested under posts, scoped)
        Route::apiResource('posts.comments', CommentController::class)
            ->except([ 'show' ])
            ->scoped();

        // Likes
        Route::post('posts/{post}/like', [ LikeController::class, 'toggle' ])->name('posts.like');
    });
});
