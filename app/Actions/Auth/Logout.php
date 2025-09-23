<?php

declare(strict_types = 1);

namespace App\Actions\Auth;

use App\Events\Auth\UserLoggedOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout
{
    public function execute(Request $request): void
    {
        event(new UserLoggedOut(request()->user()));

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
