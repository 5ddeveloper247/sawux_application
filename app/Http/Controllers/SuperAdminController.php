<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use App\Models\SubType;
use App\Models\AuditTrail;
use App\Models\Type;
use App\Models\Location;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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
            if ($user->status !== 1) {
                // If status is not 1, log the user out and show an error message
                Auth::logout();
                return redirect('admin')->withErrors([
                    'username' => 'Your account is inactive. Please contact support.',
                ]);
            }
            return redirect()->intended('/admin/dashboard');
        }
        // Authentication failed, redirect back to the login page with error message
        return redirect('admin')->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    public function dashboard(){

        $data = array();
        $total_devices = Type::count();
        $total_customer = User:: where('role','2')->count();
        $total_customer_user = User:: where('role','3')->count();

        $sub_admin_list = User:: where('role','1')->where('status','1')->limit(4)->get();
        $customer_list = Customer::limit(4)->where('status','1')->get();
        $audit_trail_list = AuditTrail::with('user')->latest()->limit(4)->get();
        $customers = Customer::where('status','1')->get();

        $data['total_devices'] = $total_devices;
        $data['total_customer'] = $total_customer;
        $data['total_customer_user'] = $total_customer;
        $data['sub_admin_list'] = $sub_admin_list;
        $data['customer_list'] = $customer_list;
        $data['audit_trail_list'] = $audit_trail_list;
        $data['customers'] = $customers;
        
        return view ('SuperAdmin.dashboard',compact('data'));

    }

    public function getDashBoardChart(Request $request){
        $customer_id = $request->id;
        
        $deviceCounts = Location::where('locations.customer_id', $customer_id)
        ->join('types', 'locations.id', '=', 'types.location_id')
        ->where('types.customer_id', $customer_id)
        ->select('locations.name as location_name', DB::raw('COUNT(types.id) as device_count'))
        ->groupBy('locations.id', 'locations.name')
        ->get();
    
            // Prepare the data for the chart
        $locations = $deviceCounts->pluck('location_name')->toArray();
        $counts = $deviceCounts->pluck('device_count')->toArray();
        
        return response()->json([
            'status' => 200,
            'locations' => $locations,
            'device_counts' => $counts,
        ], 200);
    }
    public function getDashBoardLocation(Request $request){
            $id = $request->id;
            $data = Location::where('customer_id',$id)->get();
            if($data){
                return response()->json([
                    'status' => 200,
                    'locations' => $data,
                ], 200);
            }
            return response()->json([
                'status' => 404,
                'message' => 'location not found',
            ], 200);

    }
    public function getDashBoardDevice(Request $request){
        $id = $request->id;
        $data = Type::where('location_id',$id)->get();
        if($data){
            return response()->json([
                'status' => 200,
                'devices' => $data,
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'location not found',
        ], 200);

    }
    public function getDashBoardParameterList(Request $request){
        $id = $request->id;

            // Fetch SubType along with DynamicParameter using Eloquent
            $data = SubType::with('parameters')->where('type_id', $id)->get();

            if ($data->isNotEmpty()) {
                return response()->json([
                    'status' => 200,
                    'devices' => $data,
                ], 200);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Data not found',
            ], 200);

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
                ->whereIn('role',['0','1'])
                // ->orwhere('role','=',1)
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
                ->whereIn('role',['0','1'])
                // ->orwhere('role','=',1)
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
                ->whereIn('role',['0','1'])
                // ->orwhere('role','=',1)
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
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.size' => 'The image size must be less than 5MB.',
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
