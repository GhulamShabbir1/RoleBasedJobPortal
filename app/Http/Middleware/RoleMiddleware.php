<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        // Admin override: admin must never be blocked by role checks.
        if ($user && $user->role === 'admin') {
            return $next($request);
        }

        if (!$user || !in_array($user->role, $roles)) {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden (Role not allowed)'
            ], 403);
        }

        return $next($request);
    }
}
