<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Ensure2FAIsVerified
{
public function handle(Request $request, Closure $next)
{
    $user = $request->user();

    if (!$user->google2fa_secret) {
        return redirect()->route('2fa.setup');
    }

    if (!Session::get('2fa_verified')) {
        return redirect()->route('2fa.form');
    }

    return $next($request);
}
}
