<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    //
    public function index(Request $request){
        Auth::logout();
        return view('SuperAdmin.login');
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            return redirect()->intended('/admin/dashboard');
        }
        // Authentication failed, redirect back to the login page with error message
        return redirect('login')->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    public function dashboard(){
        return 'sdf';
    }
}
