<?php

use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\v1\LikeController;
use App\Http\Controllers\Api\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Resources\UserResource;

Route::prefix('v1')->group(function () {

    // Auth Routes [Public]
    require __DIR__ . '/auth.php';

    // Protected Routes
    Route::middleware([ 'auth:sanctum' ])->group(function () {

        // User
        Route::get('/user', fn(Request $request) => new UserResource($request->user()));
        Route::put('/user', [ UserController::class, 'update' ]);
        Route::put('/user/password', [ UserController::class, 'updatePassword' ]);
        Route::get('/users/{user}', [ UserController::class, 'show' ]);

        // User Ressources
        Route::get('user/posts', [ PostController::class, 'indexUser' ])->name('user.posts');

        // Posts
        Route::apiResource('posts', PostController::class);

        // Comments [nested scoped from post]
        Route::apiResource('posts.comments', CommentController::class)
            ->except([ 'show' ])
            ->scoped();

        // Likes
        Route::post('posts/{post}/like', [ LikeController::class, 'toggle' ])->name('posts.like');
    });
});
