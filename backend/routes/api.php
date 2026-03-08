<?php

use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\v1\LikeController;
use App\Http\Controllers\Api\v1\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;

Route::prefix('v1')->group(function () {

    // Auth Routes [Public]
    require __DIR__ . '/auth.php';

    // Protected Routes
    Route::middleware([ 'auth:sanctum' ])->group(function () {

        // User
        Route::get('/user', [ UserController::class, 'me' ]);
        Route::put('/user', [ UserController::class, 'update' ]);
        Route::put('/user/password', [ UserController::class, 'updatePassword' ]);
        Route::get('/users/{user}', [ UserController::class, 'show' ]);
        Route::delete('user', [ UserController::class, 'destroy' ]);

        // User Ressources
        Route::get('user/posts', [ PostController::class, 'indexUser' ])->name('user.posts');
        Route::get('users/{user}/posts', [ PostController::class, 'indexByUser' ])->name('users.posts');
        Route::get('users/{user}/liked-posts', [ PostController::class, 'indexLikedByUser' ])->name('users.liked-posts');

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
