<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Register
Route::post('/register', [ RegisteredUserController::class, 'store' ]);

// Login
Route::post('/login', [ LoginController::class, 'store' ]);

// Logout
Route::middleware([ 'auth:sanctum' ])->group(function () {
    Route::post('/logout', [ LoginController::class, 'destroy' ]);
});
