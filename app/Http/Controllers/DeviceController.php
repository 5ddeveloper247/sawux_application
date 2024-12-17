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

class DeviceController extends Controller
{
    public function index(){

        return view('device');

    }
    public function updateType(Request $request)
    {
        // Define validation rules
        $type_id = $request->type_id;
        
        $rules = [
            'title' => 'required|string',
        ];
        
        // Make type_id validation conditional
        if ($type_id) { // If type_id is provided, validate it
            $rules['type_id'] = 'required|integer';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
       
        if ($type_id == '') {

            $type = new Type;
            $type->title = $request->input('title');
            $type->customer_id = Auth::user()->customer_id;
            $type->save();
            return response()->json([
                'success' => true,
                'message' => 'Type Add successfully'
            ], 200);

        }else{

            $type = Type::find($request->type_id);
            $type->title = $request->input('title');
            $type->save();

            return response()->json([
                'success' => true,
                'message' => 'Type Updated successfully'
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
    public function updateSubType(Request $request)
    {

        $sub_type_id = $request->sub_type_id;

        $rules = [
            'title' => 'required|string',
        ];
        
        // Check if sub_type_id is provided and apply the conditional validation
        if ($sub_type_id) {
            // If sub_type_id is provided, validate it
            $rules['sub_type_id'] = 'required|integer';
        } else {
            // If sub_type_id is not provided, validate type_id instead
            $rules['type_id'] = 'required|integer';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

    

        try {
            if ($sub_type_id == '') {

                $SubType = new SubType;
                $SubType->title = $request->input('title');
                $SubType->type_id = $request->type_id;
                $SubType->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Type Add successfully'
                ], 200);
    
            }else{
            $SubType = SubType::find($request->sub_type_id);
            $SubType->title = $request->input('title');
            $SubType->save();

            return response()->json([
                'success' => true,
                'message' => 'Sub Type Updated successfully'
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
    public function getDevices(Request $request){
        $customer_id = Auth::user()->customer_id;
        $types = Type::where('customer_id','=',$customer_id)->get(); 
        return response()->json([
            'success' => true,
            'message' => 'The SubType record was successfully retrieved',
            'data' => $types,
        ], 200);
        
    }
    public function getSubTpes(Request $request){
      $typeId = $request->id;  
      $type = Type::find($typeId); // Replace $typeId with the specific type ID you're looking for
      if($type){
        $subTypes = $type->subTypes; // This will retrieve the subtypes where 'status' is 1

        return response()->json([
                'success' => true,
                'message' => 'The SubType record was successfully retrieved',
                'data' => $subTypes,
            ], 200);
        }else{
            return response()->json([
                'status' => 402,
                'message' => 'Record not found',
            ], 200);

        }
    }
    
    public function updateParameter(Request $request)
    {

        $parameter_id = $request->parameter_id;

        $rules = [
            'pre_title' => 'required|string',
            'post_title' => 'required|string',
        ];
        
        // Check if sub_type_id is provided and apply the conditional validation
        if ($parameter_id) {
            // If sub_type_id is provided, validate it
            $rules['parameter_id'] = 'required|integer';
        } else {
            // If sub_type_id is not provided, validate type_id instead
            $rules['sub_type_id'] = 'required|integer';
            $rules['type_id'] = 'required|integer';
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            if ($parameter_id == '') {

                $DynamicParameter = new DynamicParameter;
                $DynamicParameter->type_id = $request->type_id;
                $DynamicParameter->sub_type_id = $request->sub_type_id;
                $DynamicParameter->pre_title = $request->input('pre_title');
                $DynamicParameter->post_title = $request->input('post_title');
                $DynamicParameter->is_switch = $request->parameter_is_switch;
                $DynamicParameter->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Parameter Add successfully'
                ], 200);
    
            }else{
                $DynamicParameter = DynamicParameter::find($request->parameter_id);
                $DynamicParameter->pre_title = $request->input('pre_title');
                $DynamicParameter->post_title = $request->input('post_title');
                $DynamicParameter->is_switch = $request->parameter_is_switch;
                $DynamicParameter->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Parameter Updated successfully'
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
}
