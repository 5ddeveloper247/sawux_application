<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->role === 0 || Auth::user()->role === 1)) {
            return $next($request);
        }

        // Redirect to a specific page if the user is not a Super Admin
        return redirect()->route('superadmin.login')->with('error', 'Unauthorized access');
    }
}
