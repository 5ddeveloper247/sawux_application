<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CustomerUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && ((Auth::user()->role === 3) && Auth::user()->customer_id !== null)) {
            return $next($request);
        }

        // Redirect to a specific page if the user is not a Super Admin
        return redirect()->route('login')->with('error', 'Unauthorized access');

    }
}
