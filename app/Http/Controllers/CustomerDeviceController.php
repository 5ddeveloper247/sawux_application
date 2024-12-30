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
        $customers  = Customer::all();
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
}
