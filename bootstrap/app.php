<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        api: [
            'prefix' => 'api',
            'middleware' => [
                \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                'throttle:api',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ],
            'using' => __DIR__ . '/../routes/api.php',
        ],
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
