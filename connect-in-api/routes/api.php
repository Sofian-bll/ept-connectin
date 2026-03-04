<?php

use App\Http\Controllers\Api\v1\PostController;
use App\Http\Controllers\Auth\LoginController;
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

        Route::apiResource('/posts', PostController::class);
    });
});

// Auth Routes [Public]
require __DIR__ . '/auth.php';
