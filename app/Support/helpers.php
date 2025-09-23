<?php

declare(strict_types = 1);

use App\Models\Tenant;
use App\Services\ActivityLogService;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

if (! function_exists('getCurrentTenant')) {
    /**
     * Gets the current tenant.
     */
    function getCurrentTenant(): ?Tenant
    {
        return session()->get('tenant');
    }
}

if (! function_exists('getUserTimezone')) {
    /**
     * Gets the user's timezone.
     */
    function getUserTimezone(): string
    {
        return Auth::user()->timezone ?? config('app.default_user_timezone', 'UTC');
    }
}

if (! function_exists('getUserLocale')) {
    /**
     * Gets the user's locale.
     */
    function getUserLocale(): string
    {
        return Auth::user()->locale ?? config('app.locale', config('app.fallback_locale', 'en'));
    }
}

if (! function_exists('activity')) {
    /**
     * Creates a new activity log instance.
     */
    function activity(string $action): ActivityLogService
    {
        return new ActivityLogService($action);
    }
}

if (! function_exists('fromUserDate')) {
    /**
     * Converts a date/time string from the user's timezone to UTC.
     */
    function fromUserDate(string|CarbonInterface $date): CarbonInterface
    {
        $timezone = getUserTimezone();

        if (is_string($date)) {
            return Carbon::parse($date, $timezone)->setTimezone('UTC');
        }

        return $date->setTimezone('UTC');
    }
}

if (! function_exists('toUserDate')) {
    /**
     * Converts a date/time string from UTC to the user's timezone.
     */
    function toUserDate(string|CarbonInterface $date): CarbonInterface
    {
        $timezone = getUserTimezone();

        if (is_string($date)) {
            return Carbon::parse($date, 'UTC')->setTimezone($timezone);
        }

        return $date->setTimezone($timezone);
    }
}
