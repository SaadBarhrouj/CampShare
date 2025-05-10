<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClientMiddleware;
use App\Http\Middleware\PartnerMiddleware;
use App\Http\Middleware\AuthenticatedMiddleware;
use App\Http\Middleware\ActiveAccountMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Global middlewares
        $middleware->append(ActiveAccountMiddleware::class);
        
        // Alias middlewares
        $middleware->alias([
            'auth' => AuthenticatedMiddleware::class,
            'admin' => AdminMiddleware::class,
            'client' => ClientMiddleware::class,
            'partner' => PartnerMiddleware::class,
            'active.account' => ActiveAccountMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
