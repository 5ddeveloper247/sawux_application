<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && ((Auth::user()->role === 2  || Auth::user()->role === 3) && Auth::user()->customer_id !== null)) {
            return $next($request);
        }

        // Redirect to a specific page if the user is not a Super Admin
        return redirect()->route('login')->with('error', 'Unauthorized access');


    }
}
