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
        $rules = [
            'currentpassword' => 'nullable',
            'password' => 'nullable|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,gif|max:5120', // max 5MB
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
    
        $user = auth()->user();
    
        // Update password if provided
        if ($request->filled('password')) {
            if (!Hash::check($request->currentpassword, $user->password)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['currentpassword' => ['The current password is incorrect.']],
                ], 422);
            }
    
            $user->password = Hash::make($request->password);
            $user->is_verified = 1; // Optional: Set as verified if required
        }
    
        // Update profile image if provided
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
    
            $filePath = 'uploads/' . $fileName;
            $user->profile = $filePath;
        }
    
        $user->save();
    
        return response()->json([
            'status' => 200,
            'message' => 'Profile updated successfully.',
        ], 200);


  }
}
