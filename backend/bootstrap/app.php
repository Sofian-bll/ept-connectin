<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // 404 Not Found
        $exceptions->render(function (NotFoundHttpException $e) {
            return response()->json([ 'message' => 'Not found' ], 404);
        });

        // 403 Forbidden
        $exceptions->render(function (AuthorizationException $e) {
            return response()->json([ 'message' => 'Forbidden' ], 403);
        });

        // 422 Validation Error
        $exceptions->render(function (ValidationException $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'errors'  => $e->errors()
            ], 422);
        });

        // 429 Too many requests - Throttle
        $exceptions->render(function (ThrottleRequestsException $e) {
            return response()->json([ 'message' => 'Too many requests' ], 429);
        });

        // 500 Server error = WildCard -> veut dire toute autre exceptions non catch
        $exceptions->render(function (\Throwable $e) {
            if (app()->isProduction()) {
                return response()->json([ 'message' => 'Server error.' ], 500);
            }
        });
        
    })->create();
