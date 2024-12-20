<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function (Router $router) {
        // Define routing for front-end routes
        $router->middleware('web')->group(function () {
            require base_path('routes/front.php');
        });
        // Define routing for front-end routes
        $router->middleware('web')->group(function () {
            require base_path('routes/dashboard.php');
        });

        // Define routing for developers with 'developers' prefix
        $router->prefix('developer-doc')->middleware('web')->group(function () {
            require base_path('routes/developers.php');
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Additional middleware setup if necessary
        // Example: $middleware->add(new SomeMiddleware());
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling logic if necessary
    })
    ->create();
