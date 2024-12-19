<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class ApiConfigurationController extends Controller
{
    //
    public function index(){
        $customer_id = Auth::user()->customer_id;
        $data['api_settings'] = ApiSetting::where('customer_id',$customer_id)->first();
        return view('api_configuration')->with($data);
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

            $customerId = Auth::user()->customer_id; // Assuming you're using Laravel authentication

            // Find the settings record for the specific user
            $ApiSetting = ApiSetting::where('customer_id', $customerId)->first();
        
            // If the record doesn't exist, create a new one
            if ($ApiSetting === null) {
                $ApiSetting = new ApiSetting();
                $ApiSetting->customer_id = $customerId; // Associate the setting with the user
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
            $apiSettingId = $ApiSetting->id;
            record_audit_trail('Api Configuration','api_settings',$apiSettingId,'Update','Update the api-configuration.');
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
}
