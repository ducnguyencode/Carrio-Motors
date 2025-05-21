<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is logged in
        if (!$request->user()) {
            return redirect('/login')->with('error', 'Please login to access this page');
        }

        // Get user's role
        $userRole = $request->user()->role;

        // Process the input roles to handle both direct parameters and comma-separated strings
        $allowedRoles = [];

        // Handle roles passed as multiple parameters or a single comma-separated string
        foreach ($roles as $role) {
            if (str_contains($role, ',')) {
                // Split comma-separated roles and add each to allowed roles
                foreach (explode(',', $role) as $splitRole) {
                    $allowedRoles[] = trim($splitRole);
                }
            } else {
                $allowedRoles[] = trim($role);
            }
        }

        // Log the check for debugging purposes
        Log::debug('Role check', [
            'user_role' => $userRole,
            'allowed_roles' => $allowedRoles,
            'url' => $request->url(),
            'route_name' => $request->route() ? $request->route()->getName() : 'unknown'
        ]);

        // If user's role is in the allowed roles, allow access
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        // Instead of redirecting to dashboard which causes redirect loops
        // Return a 403 Forbidden response with an error message
        return abort(403, "Access denied. Your role '{$userRole}' does not have permission for this page.");
    }
}
