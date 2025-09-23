<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Events\Auth\UserLoggedIn;
use App\Events\Auth\UserLoginFailed;
use App\Events\Auth\UserLoginRateLimited;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticateUserLoginRequest
{
    protected string $email;

    protected string $password;

    protected bool $remember;

    protected Request $request;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     * @throws \Exception
     */
    public function execute(Request $request): User
    {
        $this->request = $request;

        $this->validate();

        $this->email = (string) $request->string('email');
        $this->password = (string) $request->string('password');
        $this->remember = (bool) $request->boolean('remember');

        $this->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        $user->update(['last_login_at' => now()]);

        event(new UserLoggedIn($user));

        return $user;
    }

    protected function validate(): void
    {
        $this->request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ]);
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
            'is_active' => true,
        ];

        if (! Auth::attempt($credentials, $this->remember)) {
            event(new UserLoginFailed($this->email));

            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        event(new UserLoginRateLimited(
            $this->email,
            5,
            $seconds,
        ));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        /** @phpstan-ignore-next-line */
        return Str::transliterate(Str::lower($this->email . '|' . $this->request->ip()));
    }
}
