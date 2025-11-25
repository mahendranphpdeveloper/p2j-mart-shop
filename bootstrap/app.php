<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([ 'auth.seller' => \App\Http\Middleware\sellerAuth::class,        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Your existing middleware configs here...

        // Exclude CSRF for payment callbacks (add this block)
        $middleware->validateCsrfTokens(except: [
            'payment/response',
            'payment/cancel',
            // Add 'payment/*' if you have more gateway routes
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
