<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (isset($user->status) && $user->status !== 'active') {
            return response()->json(['message' => 'Forbidden: user account is inactive'], 403);
        }

        if ($user->role === 'super_admin') {
            return $next($request);
        }

        if (!in_array($user->role, $roles, true)) {
            return response()->json(['message' => 'Forbidden: insufficient role permissions'], 403);
        }

        return $next($request);
    }
}
