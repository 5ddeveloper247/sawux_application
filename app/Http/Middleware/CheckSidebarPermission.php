<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 
class CheckSidebarPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Get the sidebar slug from the current route
            $routeName = $request->route()->getName(); // e.g., 'dashboard', 'subadmin'
             
            // Check if the user is a Super Admin (role 0) – they can access everything
            if ($user->role === 0) {
                return $next($request);
            }

            // Get the user's sidebar menus and check if the route name exists in the menu links
            $userSidebarMenus = getUserSidebarMenus();

            // Check if the user has permission for the requested route
            $sidebarSlug = $userSidebarMenus->where('link', $routeName)->first();

            if ($sidebarSlug) {
                return $next($request);
            }

            // Redirect if no permission to access the route
            abort(404, 'Unauthorized access to this section');
        }

        // Redirect if not logged in
        return redirect()->route('superadmin.login')->with('error', 'Unauthorized access');

    }
    
}
