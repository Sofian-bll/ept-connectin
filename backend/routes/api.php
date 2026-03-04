<?php

use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Prefix v1 -> /v1/user
Route::prefix('v1')->group(function () {

    // Protected
    Route::middleware([ 'auth:sanctum' ])->group(function () {

        // User Routes
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('user/posts', [ PostController::class, 'indexUser' ]);

        // Posts Routes
        Route::apiResource('/posts', PostController::class);

        // Comments Routes (nested under posts)
        Route::apiResource('posts/{post}/comments', CommentController::class)
            ->except([ 'show' ]);
    });
});

// Auth Routes [Public]
require __DIR__ . '/auth.php';
