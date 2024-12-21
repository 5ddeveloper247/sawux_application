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
use App\Models\SubType;
use App\Models\ApiSetting;
use App\Models\DynamicParameter;
use App\Models\Location;

class CustomerDashboardController extends Controller
{
    public function dashboard(Request $request){
        
        $user = Auth::user();
        $locationIds = json_decode($user->location_id); 

        // Fetch the locations manually from the 'locations' table using the 'location_id' values
        $locations = Location::whereIn('id', $locationIds)->where('status','1')->get();

        return view('dashboard_user',compact('locations'));
        
        
    }
    public function refreshParameterValuesTypeWise(Request $request)
    {
        
        // try {

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
            
        // } catch (\Exception $e) {
        //     // Log the error for debugging purposes
        //     Log::error('Error storing info: ' . $e->getMessage());

        //     return response()->json([
        //         'success' => false,
        //         'message' => "Oops! Network Error",
        //     ], 500);
        // }
    }
    public function getSpecificParametersResult($typeId,$locationId){
        $customerId = Auth::user()->customer_id;
        $apiSettings = ApiSetting::where('customer_id', $customerId)->where('location_id',$locationId)->where('status', '1')->first();
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
    public function getDashboardPageData(Request $request)
    {
        $customer_id = Auth::user()->customer_id;
        $location_id = $request->location_id;
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

  public function data(Request $request){
            
    $location_id = $request->location_id;
    $customer_id = Auth::user()->customer_id;
    $data = ApiSetting::where('customer_id','=',$customer_id)
    ->where('location_id','=',$location_id)->first();
    return response()->json([
        'success' => true,
        'data' => $data
    ], 200);
}
}
