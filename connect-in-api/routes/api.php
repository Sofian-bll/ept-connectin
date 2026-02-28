<?php

use App\Http\Controllers\Api\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Sanctum protected routes [Auth]
Route::middleware([ 'auth:sanctum' ])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

//    Route::prefix('v1')->group(function () {
    Route::apiResource('/posts', PostController::class);
//    });
});

// Auth Routes [Public] -> to de-comment when routes
// require __DIR__.'/auth.php';
