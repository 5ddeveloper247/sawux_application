<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Location;
use App\Models\Type;
use App\Models\SubType;
use App\Models\ApiSetting;
use App\Models\DynamicParameter;

class DeviceController extends Controller
{
    public function index(){
        $customer_id = Auth::user()->customer_id;
        $locations = Location::where('customer_id',$customer_id)->where('status','1')->get();
        return view('device',compact('locations'));

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
            $type->location_id = $request->location_id;
            $type->save();
            
            $typeId = $type->id;
            record_audit_trail('Device','types',$typeId,'ADD','Create a new Device.');
            
            return response()->json([
                'success' => true,
                'message' => 'Type Add successfully'
            ], 200);

        }else{

            $type = Type::find($request->type_id);
            $type->title = $request->input('title');
            $type->save();

            $typeId = $type->id;
            record_audit_trail('Device','types',$typeId,'Update','Update the Device.');
            
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
        $messages = [
            'type_id.required' => 'The Device field is required.',
            'type_id.integer' => 'The Device field must be selected.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

    

        try {
            if ($sub_type_id == '') {

                $SubType = new SubType;
                $SubType->title = $request->input('title');
                $SubType->type_id = $request->type_id;
                $SubType->save();

                $typeId = $SubType->id;
                record_audit_trail('Sub Type','sub_types',$typeId,'ADD','Create a new Sub Type.');

                return response()->json([
                    'success' => true,
                    'message' => 'Type Add successfully'
                ], 200);
    
            }else{
            $SubType = SubType::find($request->sub_type_id);
            $SubType->title = $request->input('title');
            $SubType->save();

            $typeId = $SubType->id;
            record_audit_trail('Sub Type','sub_types',$typeId,'Update','Update the Sub Type.');

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
        $location_id = $request->location_id;
        $types = Type::where('customer_id','=',$customer_id)->where('location_id',$location_id)->get(); 
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
        $messages = [
            'type_id.required' => 'The Device field is required.',
            'type_id.integer' => 'The Device field must be selected.',
            'sub_type_id.required' => 'The SubType field is required.',
            'sub_type_id.integer' => 'The SubType field must be selected.',
        ];
        $validator = Validator::make($request->all(), $rules,$messages);
        
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

                $typeId = $DynamicParameter->id;
                record_audit_trail('Dynamic Parameter','dynamic_parameters',$typeId,'ADD','Create a new dynamic parameter.');

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

                $typeId = $DynamicParameter->id;
                record_audit_trail('Dynamic Parameter','dynamic_parameters',$typeId,'Update','Update the dynamic parameter.');

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
    public function deleteType(Request $request)
    {
        $id = $request->id;
        $data = SubType::where('type_id', $id)->count();
        if($data==0)
        {
            $record = Type::find($id);
            if($record)
            {
                $record->delete();

               
                record_audit_trail('Device','types',$id,'Delete','Delete the Device.');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Type Delete Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 402,
                    'message' => 'Record not found'
                ], 200);
            }
        }else{
            return response()->json([
                'status' => 402,
                'message' => 'First, delete the child items before deleting the parent item'
            ], 200);
        }
    }
    public function deleteSubType(Request $request){
        $id = $request->id;
        $data = DynamicParameter::where('sub_type_id', $id)->count();
        if($data==0)
        {
            $record = SubType::find($id);
            if($record)
            {
                $record->delete();

                
                record_audit_trail('Sub Type','sub_types',$id,'Delete','Delete the SubType.');
                
                return response()->json([
                    'success' => true,
                    'message' => 'SubType Delete Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 402,
                    'message' => 'Record not found'
                ], 200);
            }
        }else{
            return response()->json([
                'status' => 402,
                'message' => 'First, delete the child items before deleting the parent item'
            ], 200);
        }
    }
    public function deleteParameter(Request $request){
        $id = $request->id;
        $data = DynamicParameter::find($id);
        if($data)
        {
            $data->delete();
            record_audit_trail('Dynamic Parameter','dynamic_parameters',$id,'Delete','Delete the Dynamic Parameters.');

            return response()->json([
                'success' => true,
                'message' => 'Parameter Delete Successfully'
            ], 200);
        }else{
            return response()->json([
                'status' => 402,
                'message' => 'Record not found'
            ], 200);
        }
    }
}
