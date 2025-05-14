<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'Authentication required!');
        }

        // Đường dẫn hiện tại
        $currentUrl = $request->path();

        // Allow content role to access specific management routes
        if ($user->role === 'content' && (strpos($currentUrl, 'admin/models') === 0 ||
                                          strpos($currentUrl, 'admin/makes') === 0 ||
                                          strpos($currentUrl, 'admin/engines') === 0 ||
                                          strpos($currentUrl, 'admin/car_colors') === 0 ||
                                          strpos($currentUrl, 'admin/banners') === 0 ||
                                          strpos($currentUrl, 'admin/car_details') === 0 ||
                                          strpos($currentUrl, 'admin/cars') === 0)) {
            return $next($request);
        }

        // Allow saler role to access invoices management routes
        if ($user->role === 'saler' && strpos($currentUrl, 'admin/invoices') === 0) {
            return $next($request);
        }

        // Process allowed roles - trim whitespace and ensure proper formatting
        $allowedRoles = [];
        foreach (explode(',', $roles) as $role) {
            $allowedRoles[] = trim($role);
        }

        // Add debug information to session for troubleshooting
        session(['debug_user_role' => $user->role]);
        session(['debug_allowed_roles' => $allowedRoles]);
        session(['debug_current_url' => $request->url()]);

        // Debug log
        Log::debug("RoleMiddleware check", [
            'user_role' => $user->role,
            'allowed_roles' => $allowedRoles,
            'route' => $request->route()->getName(),
            'url' => $request->url()
        ]);

        // Check if user has the required role
        if (in_array($user->role, $allowedRoles)) {
            return $next($request);
        }

        // Prevent redirect loops - check if we're already on a dashboard page
        if ($currentUrl === 'admin/dashboard' || $currentUrl === 'dashboard') {
            // We're already on a dashboard, just display an error message
            abort(403, "Access denied. Your role '{$user->role}' does not have permission for this page. Required roles: " . implode(', ', $allowedRoles));
        }

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard')->with('error', "Access denied. Your role '{$user->role}' does not have permission for this page. Required roles: " . implode(', ', $allowedRoles));
        } else if ($user->role === 'content' || $user->role === 'saler') {
            // Non-admin roles should be redirected to regular dashboard
            return redirect('/dashboard')->with('error', "Access denied. Your role '{$user->role}' does not have permission for this page. Required roles: " . implode(', ', $allowedRoles));
        }

        // Regular users redirect to user dashboard
        return redirect('/dashboard')->with('error', "Access denied. Your role '{$user->role}' does not have permission for this page. Required roles: " . implode(', ', $allowedRoles));
    }
}
