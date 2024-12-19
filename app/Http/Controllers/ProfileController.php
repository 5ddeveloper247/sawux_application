<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile(){
        $id = Auth::user()->id;
        $data = User::where('id',$id)->first();
        return view('profile',compact('data'));
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
