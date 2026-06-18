<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user || !in_array($user->role, $roles)) {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden (Role not allowed)'
            ], 403);
        }

        return $next($request);
    }
}