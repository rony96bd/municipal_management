<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
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
        // Trust all proxies (Cloudflare, cPanel reverse proxies, load balancers)
        // so client IP and rate limiting reflect real users rather than shared proxy IPs.
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR |
                     Request::HEADER_X_FORWARDED_HOST |
                     Request::HEADER_X_FORWARDED_PORT |
                     Request::HEADER_X_FORWARDED_PROTO |
                     Request::HEADER_X_FORWARDED_AWS_ELB
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling logic if necessary
    })
    ->create();
