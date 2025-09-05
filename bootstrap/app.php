<?php

use App\Http\Middleware\System\AddContextToSentry;
use App\Http\Middleware\System\AddSecurityHeadersToResponse;
use App\Http\Middleware\System\AddTracingInformation;
use App\Http\Middleware\System\SetUserLocaleSettings;
use App\Http\Middleware\System\TerminatingMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append([
            TerminatingMiddleware::class,
        ]);

        $middleware->web(
            append: [
                SetUserLocaleSettings::class,
                AddTracingInformation::class,
                AddLinkHeadersForPreloadedAssets::class,
                AddContextToSentry::class,
                AddSecurityHeadersToResponse::class,
            ],
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        Integration::handles($exceptions);
    })->create();
