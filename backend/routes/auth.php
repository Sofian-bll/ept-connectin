<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Public auth routes with rate limiting
Route::middleware([ 'throttle:5,1' ])->group(function () {
    Route::post('/register', [ RegisteredUserController::class, 'store' ]);
    Route::post('/login', [ LoginController::class, 'store' ]);
});

// Logout (protected)
Route::middleware([ 'auth:sanctum' ])->group(function () {
    Route::post('/logout', [ LoginController::class, 'destroy' ]);
});
