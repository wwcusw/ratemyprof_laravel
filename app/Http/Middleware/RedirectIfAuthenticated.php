<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.evaluations'),
                'faculty' => redirect()->route('faculty.dashboard'),
                'student' => redirect()->route('student.dashboard'),
                default => abort(403, 'Unknown role.')
            };
        }

        return $next($request);
    }
}
