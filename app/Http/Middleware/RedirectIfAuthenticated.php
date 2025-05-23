<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin' || $role === 'content' || $role === 'saler') {
                return redirect()->route('admin.dashboard');
            }
            // Regular users will be redirected to purchase history page
            return redirect()->route('user.purchases');
        }

        return $next($request);
    }
}
