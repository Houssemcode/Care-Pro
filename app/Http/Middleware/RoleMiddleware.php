<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Ensure the user is actually logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // 2. Check the requested role against the user's relationships
        if ($role === 'admin' && $user->admin) {
            return $next($request);
        }

        if ($role === 'employee' && $user->employee) {
            // Optional: Block suspended employees from accessing their dashboard
            if ($user->employee->status === 'suspended') {
                Auth::logout();
                return redirect('/login')->withErrors('Your account has been suspended. Please contact support.');
            }
            return $next($request);
        }

        if ($role === 'family' && $user->family) {
            return $next($request);
        }

        // 3. If they don't match, throw a 403 Forbidden error
        abort(403, 'Unauthorized action. You do not have permission to access this page.');
    }
}