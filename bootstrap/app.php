<?php

declare(strict_types = 1);

use App\Exceptions\AppException;
use App\Exceptions\Http\AccessDeniedHttpException;
use App\Exceptions\Http\BadRequestHttpException;
use App\Exceptions\Http\GatewayTimeoutHttpException;
use App\Exceptions\Http\InternalServerErrorHttpException;
use App\Exceptions\Http\MethodNotAllowedHttpException;
use App\Exceptions\Http\NotFoundHttpException;
use App\Exceptions\Http\ServiceUnavailableHttpException;
use App\Exceptions\Http\SessionExpiredHttpException;
use App\Exceptions\Http\TooManyRequestsHttpException;
use App\Exceptions\Http\UnauthorizedHttpException;
use App\Exceptions\Http\UnprocessableEntityHttpException;
use App\Exceptions\HttpException;
use App\Http\Middleware\CheckTenantPermission;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\SetTeamPermission;
use App\Http\Middleware\SetTenantByHost;
use App\Http\Middleware\System\AddContextToSentry;
use App\Http\Middleware\System\AddSecurityHeadersToResponse;
use App\Http\Middleware\System\AddTracingInformation;
use App\Http\Middleware\System\SetUserLocaleSettings;
use App\Http\Middleware\System\TerminatingMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Validation\ValidationException;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpKernel\Exception\HttpException as LaravelHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->priority([
            SetTenantByHost::class,
            SetTeamPermission::class,
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            CheckTenantPermission::class,
        ]);

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
                HandleInertiaRequests::class,
                SetTeamPermission::class,
            ],
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        Integration::handles($exceptions);

        $exceptions->render(function (LaravelHttpException $e) {
            match ($e->getStatusCode()) {
                404 => throw new NotFoundHttpException(
                    previous: $e,
                ),
                403 => throw new AccessDeniedHttpException(
                    previous: $e,
                ),
                401 => throw new UnauthorizedHttpException(
                    previous: $e,
                ),
                419 => throw new SessionExpiredHttpException(
                    previous: $e,
                ),
                500 => throw new InternalServerErrorHttpException(
                    previous: $e,
                ),
                503 => throw new ServiceUnavailableHttpException(
                    previous: $e,
                ),
                504 => throw new GatewayTimeoutHttpException(
                    previous: $e,
                ),
                400 => throw new BadRequestHttpException(
                    previous: $e,
                ),
                405 => throw new MethodNotAllowedHttpException(
                    previous: $e,
                ),
                422 => throw new UnprocessableEntityHttpException(
                    previous: $e,
                ),
                429 => throw new TooManyRequestsHttpException(
                    previous: $e,
                ),
                default => throw new HttpException(
                    statusCode: $e->getStatusCode(),
                    previous: $e,
                ),
            };
        });

        $exceptions->render(function (Throwable $e) {
            return match (true) {
                $e instanceof AuthenticationException => false,
                $e instanceof ValidationException => false,
                default => null,
            };

            if (! $e instanceof AppException) {
                throw new AppException(
                    $e->getMessage(),
                    $e->getCode(),
                    $e
                );
            }
        });
    })->create();
