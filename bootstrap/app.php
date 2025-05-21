<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // API routes
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Apply Sanctum middleware to web routes for SPA authentication
        $middleware->web(append: EnsureFrontendRequestsAreStateful::class);

        // Register auth:sanctum middleware for API routes to protect endpoints
        $middleware->api(append: 'auth:sanctum');

        // Register custom middleware aliases for your app
       $middleware->alias(['isAdmin' => 'App\Http\Middleware\IsAdmin']);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
