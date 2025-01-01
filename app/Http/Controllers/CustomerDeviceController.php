<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\Type;
use App\Models\SubType;
use App\Models\ApiSetting;
use App\Models\DynamicParameter;

class CustomerDeviceController extends Controller
{
    //
    public function index(){
        $customers  = Customer::where('status','1')->get();
        return view('SuperAdmin.CustomerDevice.index',compact('customers'));
    }

    public function getDashboardPageData(Request $request)
    {
        $customer_id = $request->customer_id;
        $location_id = $request->location_id;
        $data['types_list'] = Type::with(['subTypes','subTypes.parameters'])
                              ->where('status', '1')
                              ->where('customer_id', $customer_id) // Add the condition for customer_id
                              ->where('location_id', $location_id) 
                              ->get();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }
    public function refreshParameterValuesTypeWise(Request $request)
    {
        
        try {

            if($request->typeId != ''){
                
                $data['paramResult_list'] = $this->getSpecificParametersResult($request->typeId,$request->location_id,$request->customer_id);
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
    public function getSpecificParametersResult($typeId,$locationId,$customerId){

     
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
}
