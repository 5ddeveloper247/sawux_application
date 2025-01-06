<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Type;
use App\Models\Location;
use App\Models\SubType;
use App\Models\ApiSetting;
use App\Models\DynamicParameter;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index(Request $request){
        Auth::logout();
        return view('login');
    }
    
    public function dashboard(Request $request){
        
        $customer_id = Auth::user()->customer_id;
        $locations = Location::where('customer_id',$customer_id)->where('status','1')->get(); 
       
        if($locations->isNotEmpty()){
            $firstLocation = $locations->first();

            if(Session::get('location_id')){
            $firstLocatinID =  Session::get('location_id');
            }else{
                $firstLocatinID =  $firstLocation->id; 
            }
        }else{
            $firstLocatinID =''; 
        }
        $api_settings = ApiSetting::where('customer_id',$customer_id)->where('location_id',$firstLocatinID)->first();
        return view('dashboard',compact('locations','api_settings'));
            
        
        
    }

    public function createStaticUser(Request $request){
        
        // $password = 'user2024';
        // If validation passes, handle the incoming request data and save it accordingly
        // $User = User::find(2);
        // $User->name = 'Admin';
        // $User->username = 'ADMIN';
        // $User->email = 'admin@5dsolutions.ae';
        // $User->password = bcrypt($password);
        // $User->role = '1';  // 1:Admin, 2:User
        // $User->status = '1';
        // $User->save();

        // $mailData = [];
        // $mailData['otp'] = $otp;
        // $mailData['username'] = $User->name;
        // $body = view('email.forget_otp_template', $mailData);
        // // sendMail($User->first_name, $User->email, 'Password Reset Request', $body);
        // sendMail($User->first_name, 'hamza@5dsolutions.ae', 'Password Reset Request', $body);

        // return 'User Created Successfully...';
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
                return redirect('login')->withErrors([
                    'username' => 'Your account is inactive. Please contact support.',
                ]);
            }
            if($user->role == 2){

                $customer_id = Auth::user()->customer_id;
                $location = Location::where('customer_id',$customer_id)->first();
                if($location){
                Session::put('location_id', $location->id);
                Session::put('location_name', $location->name);
                  }
                if($user->is_verified == 0)
                {
                    $data = User::where('id',$user->id)->first();
                    return redirect()->route('profile')->with('data', $data); 
                }else{   
                    return redirect()->intended('/dashboard');
                }
           
            }else{
                $customer_id = Auth::user()->customer_id;
                $location_id = json_decode(Auth::user()->location_id);
              if($location_id){
                $location = Location::where('id',$location_id[0])->first();
               
                Session::put('location_id', $location->id);
                Session::put('location_name', $location->name);
              }
                return redirect()->intended('/customer/dashboard'); 
            }
        }
        // Authentication failed, redirect back to the login page with error message
        return redirect('login')->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        // Log out the currently authenticated user
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the admin login page
        return redirect('login');
    }

  

    public function getDashboardPageData(Request $request)
    {
        $customer_id = Auth::user()->customer_id;
        $location_id = $request->location_id;
        $location = Location::where('id',$location_id)->first();
        Session::put('location_id', $location_id);
        Session::put('location_name', $location->name);
        $data['types_list'] = Type::with(['subTypes','subTypes.parameters'])
                              ->where('status', '1')
                              ->where('location_id', $location_id)
                              ->where('customer_id', $customer_id) // Add the condition for customer_id
                              ->get();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function saveParameterValues(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'param_id' => 'required',
            'parameter' => 'required|string',
            'parameter_id' => 'required|integer',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $DynamicParameter = DynamicParameter::find($request->param_id);
           
            $DynamicParameter->parameter = $request->input('parameter');
            $DynamicParameter->parameter_id = $request->input('parameter_id');
            $DynamicParameter->save();
            $DynamicParameterId = $DynamicParameter->id;
            record_audit_trail('Dynamic Parameter','dynamic_parameters',$DynamicParameterId,'Update','Update the dynamic parameter and its parameter ID..');
            
            return response()->json([
                'success' => true,
                'message' => 'Parameter Updated successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function changeParameterValueOnOff(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'param_id' => 'required',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $DynamicParameter = DynamicParameter::find($request->param_id);
            if($DynamicParameter->on_off_flag == '1' ){
                $DynamicParameter->on_off_flag = '0';  // OFF
            }else{
                $DynamicParameter->on_off_flag = '1';  // ON
            }
            $DynamicParameter->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Parameter Updated successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function saveDeviceKeyValue(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'type_id' => 'required',
            'device_key' => 'required|string|max:255',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $Type = Type::find($request->type_id);
           
            $Type->device_key = $request->input('device_key');
            $Type->save();
            $typeId = $Type->id;
            record_audit_trail('Device','types',$typeId,'Update','Update the Device.');

            return response()->json([
                'success' => true,
                'message' => 'Device Key Updated successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function refreshParameterValuesTypeWise(Request $request)
    {
        
        try {

            if($request->typeId != ''){
                
                $data['paramResult_list'] = $this->getSpecificParametersResult($request->typeId,$request->location_id);
                $data['type_id'] = $request->typeId;

                return response()->json([
                    'success' => true,
                    'data' => $data
                ], 200);

            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Something went wrong...",
                ], 500);
            }
            
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error storing info: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => "Oops! Network Error",
            ], 500);
        }
    }

    public function getSpecificParametersResult($typeId,$locationId){

        $customerId = Auth::user()->customer_id;
        $apiSettings = ApiSetting::where('customer_id', $customerId)
                       ->where('location_id',$locationId)
                       ->where('status', '1')->first();
        $type = Type::where('id', $typeId)->with(['subTypes','subTypes.parameters'])->first();
     
        if($type != null && $apiSettings != null){
           
            $parameterArray = [];
            $api_url = $apiSettings->api_url;

            if($type->device_key != null && $type->subTypes != null){
                
                $api_key = $type->device_key;
                
                foreach($type->subTypes as $key1=>$subtype){

                    foreach($subtype->parameters as $key2=>$param){

                        if($param->parameter != null && $param->parameter_id != null){
                            
                            $url = $api_url.''.$api_key.'&'.$param->parameter.'='.$param->parameter_id;
                          
                            $result = $this->callApi($url);

                            $tempArray['id'] = $param->id;
                            $tempArray['result'] = $result;
                            $tempArray['type_id'] = $param->type_id;
                            $tempArray['sub_type_id'] = $param->sub_type_id;
                            $tempArray['is_switch'] = $param->is_switch;

                            $parameterArray[] = $tempArray;
                        }else{
                            $result = '';
                        }

                    }
                }
            }

            return $parameterArray;
        }else{
            return array();
        }
    }

    public function updateSystemStatus(Request $request)
    {
        
           // Step 1: Get the customer ID (auth user)
    $customer_id = Auth::user()->customer_id;
    // Step 2: Get the location ID from the request
    $location_id = $request->input('location_id'); // Assuming location_id is passed in the request

    // Step 3: Find the ApiSetting (or whatever model contains the status information)
    $apiSetting = ApiSetting::where('location_id', $location_id)
                            ->where('customer_id', $customer_id)
                            ->first(); // Retrieve the first matching record

    if (!$apiSetting) {
        return response()->json([
            'success' => false,
            'message' => 'API setting not found',
        ], 404);
    }

    // Step 4: Update the status for this customer and location
    try {
        // Example: Assuming you have a 'status' field and a relationship for customer and location
        // Update status for a specific customer and location, you may need a model for that
        $apiSetting->status = $request->input('status'); // Set the new status value from the request
        $apiSetting->customer_id = $customer_id;
        $apiSetting->location_id = $location_id;
        $apiSetting->save(); // Save changes to the database

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!',
        ], 200);

    } catch (\Exception $e) {
        // In case of any errors
        return response()->json([
            'success' => false,
            'message' => 'Oops! Something went wrong.',
            'error' => $e->getMessage(),
        ], 500);
    }

    }


   

    

  

    public function callApi($url){
    
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);           // API URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string

        // Execute cURL request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode === 404) {
            return false;
        }
        // Check for errors
        if (curl_errno($ch)) {
        
            // echo 'cURL Error: ' . curl_error($ch);
            return false;
        } else {
            // Decode JSON response
            $data = json_decode($response, true); // true converts JSON to associative array
         
            // Output or process the data
            return $response;
        }

        // Close cURL session
        curl_close($ch);

    }
    public function forgetPassword(){
        
        return view('forget_password');
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
                ->whereIn('role',['2','3'])
                // ->orwhere('role','=',3)
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
                ->whereIn('role',['2','3'])
                // ->orwhere('role','=',3)
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
                ->whereIn('role',['2','3'])
                // ->orwhere('role','=',3)
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
}
