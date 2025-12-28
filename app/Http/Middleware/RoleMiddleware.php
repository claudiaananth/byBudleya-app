<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        // Check if user is logged in
        if (!auth()->check()) {
            abort(403);
        }

        // Convert comma-separated string to array and trim spaces
        $allowedRoles = array_map('trim', explode(',', $roles));

        // Get the current user's role value (enum)
        $userRole = auth()->user()->role->value;

        // If user role is not in allowed roles, abort
        if (!in_array($userRole, $allowedRoles)) {
            abort(403);
        }

        return $next($request);
    }

}
