<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return redirect('/')->with('error', 'Authentication required!');
        }

        // Split roles by comma if multiple roles are provided
        $allowedRoles = explode(',', $roles);

        if (!in_array($user->role, $allowedRoles)) {
            return redirect('/')->with('error', 'You do not have permission to access this function!');
        }

        return $next($request);
    }
}
