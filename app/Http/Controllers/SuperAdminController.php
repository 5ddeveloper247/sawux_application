<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class SuperAdminController extends Controller
{
    //
    public function index(Request $request){
        Auth::logout();
        return view('SuperAdmin.login');
    }
    public function logout(Request $request)
    {
        // Log out the currently authenticated user
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the admin login page
        return redirect('/admin');
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
        return redirect('admin')->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    public function dashboard(){
        return view ('SuperAdmin.dashboard');
    }

    public function forgetPassword(){
        
        return view('SuperAdmin.forget_password');
    }

    public function emailverified(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $email = $request->email;
        $data = User::where('email','=', $email)
                ->where('role','=',0)
                ->orwhere('role','=',1)
                ->first();



        if($data){
                $otp = rand(100000, 999999);
                    // Save OTP in the database
                $data->otp = $otp;
                $data->save();
                $mailData['otp'] = $otp;
                $mailData['username'] = $data->name;
                 $body = view('email.forget_otp_template', $mailData);
                sendMail($data->name, $data->email, 'Password Reset Request', $body);

                return response()->json([
                                    'status' => 200,
                                    'data' => $data
                                ], 200);
            }
               
        return response()->json([
                    'status' => 402,
                    'message' => 'This is not authentic user',
                ], 200);
            

    }
    public function otpverified(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'otp' => 'required|exists:users,otp',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $email = $request->email;
        $otp = $request->otp;
        $data = User::where('email','=', $email)
                ->where('role','=',0)
                ->orwhere('role','=',1)
                ->where('otp','=',$otp)
                ->first();

        if($data){

                return response()->json([
                                    'status' => 200,
                                    'data' => $data
                                ], 200);
            }
               
        return response()->json([
                    'status' => 402,
                    'message' => 'This is not authentic user',
                ], 200);
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'otp' => 'required|exists:users,otp',
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/',
                'confirmed',
            ],
        ], [
            'password.regex' => 'The new password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $email = $request->email;
        $otp = $request->otp;
        $data = User::where('email','=', $email)
                ->where('role','=',0)
                ->orwhere('role','=',1)
                ->where('otp','=',$otp)
                ->first();
        if($data){
                $password = hash::make($request->password);
                $data->password = $password;
                $data->save();
                return response()->json([
                                    'status' => 200,
                                    'data' => $data
                                ], 200);
        }

    }
    public function profile(){
        $id = Auth::user()->id;
        $data = User::where('id',$id)->first();
        return view('SuperAdmin.Profile.index',compact('data'));
    }

    public function updateProfile(Request $request){
         // Define validation rules
    $rules = [
        'currentpassword' => 'required',
        'password' => 'required|min:8|confirmed',
    ];

    // Custom validation messages
    $messages = [
        'currentpassword.required' => 'The current password field is required.',
        'password.required' => 'The new password field is required.',
        'password.min' => 'The new password must be at least 8 characters long.',
        'password.confirmed' => 'The password confirmation does not match.',
    ];

    // Validate request
    $validator = Validator::make($request->all(), $rules, $messages);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    // Check if the current password is correct
    if (!Hash::check($request->currentpassword, auth()->user()->password)) {
        return response()->json([
            'success' => false,
            'errors' => ['currentpassword' => ['The current password is incorrect.']],
        ], 422);
    }

    // Update password
    $user = auth()->user();
    $user->password = Hash::make($request->password);
    $user->is_verified = 1;
    $user->save();

    return response()->json([
        'status' => 200,
        'message' => 'Password update successfully.',
    ], 200);

  }
}
