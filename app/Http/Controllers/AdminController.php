<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Type;
use App\Models\SubType;
use App\Models\ApiSetting;
use App\Models\DynamicParameter;


class AdminController extends Controller
{
    public function index(Request $request){
        Auth::logout();
        return view('login');
    }
    
    public function dashboard(Request $request){
        
        $user = Auth::user();
        if($user->role == 1){
            $data['api_settings'] = ApiSetting::find(1);
            return view('dashboard')->with($data);
        }else{
            $data['api_settings'] = ApiSetting::find(1);
            return view('dashboard_user')->with($data);
        }
        
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
        
        // return 'User Created Successfully...';
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication passed
            $user = Auth::user();
            return redirect()->intended('/dashboard');
        }
        // Authentication failed, redirect back to the login page with error message
        return redirect('login')->withErrors([
            'email' => 'The provided credentials do not match our records.',
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

    public function saveApiSettings(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'api_url' => 'required|url',
            'system_api_url' => 'required|url',
            'api_refresh_time' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,gif|max:5120', // max 5MB
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $ApiSetting = ApiSetting::find(1);
            if($ApiSetting == null){
                $ApiSetting = new ApiSetting();
            }
            $ApiSetting->api_url = $request->input('api_url');
            $ApiSetting->system_api_url = $request->input('system_api_url');
            $ApiSetting->api_refresh_time = $request->input('api_refresh_time');
            // $ApiSetting->api_key = $request->input('api_key');
            $ApiSetting->status = '1';
            $ApiSetting->save();

            // Handle the image upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);
                
                $filePath = 'uploads/' . $fileName;
                $ApiSetting->image = $filePath;
                $ApiSetting->save();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Configurations Saved successfully'
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

    public function getDashboardPageData(Request $request)
    {
        $data['types_list'] = Type::with(['subTypes','subTypes.parameters'])->where('status', '1')->get();
        
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
                
                $data['paramResult_list'] = $this->getSpecificParametersResult($request->typeId);
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

    public function getSpecificParametersResult($typeId){

        $apiSettings = ApiSetting::where('id', '1')->where('status', '1')->first();
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
        try {

            $ApiSetting = ApiSetting::find(1);
           
            if($ApiSetting->system_api_url != null){

                if($ApiSetting->system_status == '0'){
                    $ApiSetting->system_status = '1';
                    $url = $ApiSetting->system_api_url.'1';//AkAaU4Dauwwa_-age9G9sUcORDnT0Az6&v18=
                }else{
                    $ApiSetting->system_status = '0';
                    $url = $ApiSetting->system_api_url.'0';//AkAaU4Dauwwa_-age9G9sUcORDnT0Az6&v18=
                }
                
                $apiResponse = $this->callApi($url);
                // dd($apiResponse);
                if($apiResponse == '' || $apiResponse != false){
    
                    $ApiSetting->save();
    
                    return response()->json([
                        'success' => true,
                        'message' => 'System Status Updated successfully.'
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong...'
                    ], 200);
                }
            }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Something went wrong...'
                    ], 200);
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


    public function updateType(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|integer',
            'title' => 'required|string',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $type = Type::find($request->type_id);
            $type->title = $request->input('title');
            $type->save();

            return response()->json([
                'success' => true,
                'message' => 'Type Updated successfully'
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

    public function updateSubType(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'sub_type_id' => 'required|integer',
            'title' => 'required|string',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $SubType = SubType::find($request->sub_type_id);
            $SubType->title = $request->input('title');
            $SubType->save();

            return response()->json([
                'success' => true,
                'message' => 'Sub Type Updated successfully'
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

    public function updateParameter(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'parameter_id' => 'required|integer',
            'pre_title' => 'required|string',
            'post_title' => 'required|string',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {

            $DynamicParameter = DynamicParameter::find($request->parameter_id);
            $DynamicParameter->pre_title = $request->input('pre_title');
            $DynamicParameter->post_title = $request->input('post_title');
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

    public function callApi($url){

        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);           // API URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string

        // Execute cURL request
        $response = curl_exec($ch);

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
}
