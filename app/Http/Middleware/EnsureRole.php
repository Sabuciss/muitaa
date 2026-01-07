<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    /**
     * Handle an incoming request.
     * Accepts roles as pipe-separated list: role:admin|inspector
     */
    public function handle(Request $request, Closure $next, $roles = null)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        if (! $roles) {
            return $next($request);
        }

        $allowed = explode('|', $roles);
        if (in_array($user->role, $allowed, true)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
