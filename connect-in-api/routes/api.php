<?php

use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Prefix v1 -> /v1/user
Route::prefix('v1')->group(function () {

    // Public
    Route::apiResource('/posts', PostController::class)->only([ 'index', 'show' ]); // Posts Routes

    // Protected
    Route::middleware([ 'auth:sanctum' ])->group(function () {

        // User Routes
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::get('user/posts', [ PostController::class, 'indexUser' ]);

        // Posts Routes
        Route::apiResource('/posts', PostController::class)->except([ 'index', 'show' ]);
    });
});

// Auth Routes [Public]
require __DIR__ . '/auth.php';
