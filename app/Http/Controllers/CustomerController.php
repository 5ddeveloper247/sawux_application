<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SidebarMenu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class CustomerController extends Controller
{
    //
    public function index(){
        
        return view('SuperAdmin.Customer.index'); 
    }
    
    public function listAll(Request $request)
    {

        if ($request->ajax()) {

            // Define the search term if any
            $searchTerm = $request->get('search')['value']; // The search term sent by DataTables
            $start = $request->get('start'); // Starting record index
            $length = $request->get('length'); // Number of records to fetch
            
            // Calculate the current page
            $page = ($start / $length) + 1;
            
            // Get data with pagination and filtering
          
            $data = Customer::with('creator')
            ->where('name', 'like', '%' . $searchTerm . '%')
                        ->latest()
                        ->paginate($length, ['*'], 'page', $page);
                       
            
            // Format data for DataTables response
            $formattedData = $data->items(); // Get current page items
            $formattedData = collect($formattedData)->map(function ($row, $index) use ($start) {
                return [
                    'DT_RowIndex' => $start + $index + 1, // Adjust index for pagination
                    'name' => $row->name,
                    'company_name' => $row->company_name,
                    'email' => $row->email,
                    'phone_number' => $row->phone_number,
                    'address' => $row->address,
                    'date' => $row->date,
                    'establish_date' => $row->establish_date,
                    'status' => '<div class="form-check form-switch pt-1">
                                 <input class="form-check-input pointer" type="checkbox" role="switch" 
                                 id="'.$row->id.'" 
                                ' . (isset($row->status) && $row->status == 1 ? 'checked' : '') . '>
                                </div>',
                    'created_by' => $row->creator ? $row->creator->name : 'N/A',
                    'action' => '<button  class="btn btn-sm btn-primary edit-btn" data-id="'.$row->id.' m-2">Edit</button>'
                ];
            });
            
            // Return the response in DataTables format
            return response()->json([
                'draw' => intval($request->get('draw')),
                'recordsTotal' => $data->total(),  // Total records before filtering
                'recordsFiltered' => $data->total(),  // Total records after filtering
                'data' => $formattedData
            ]);
            
        }
 
    }

    public function create(Request $request){

        $id = $request->id;
        
        // Validation rules
        $rules = [
            'name' => 'required',
            'company_name' => 'required',
            'email' => 'required|email|unique:customers,email' . ($id ? ",$id" : ''),
            'phone_number' =>  'required', 
            'address' =>  'required', 
            'date' =>  'required', 
            'establish_date' =>  'required', 
        ];
        
        // Validate request
        $validator = Validator::make($request->all(), $rules);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        
        // Handle create or update logic
        if ($id == '') {
            // Create new user
            $customer = new Customer;
            $customer->name = $request->name;
            $customer->company_name = $request->company_name;
            $customer->email = $request->email;
            $customer->phone_number = $request->phone_number;
            $customer->address = $request->address;
            $customer->date = $request->date;
            $customer->establish_date = $request->establish_date;
            $customer->created_by = Auth::user()->id;
            $customer->save();
        
            return response()->json([
                'status' => 200,
                'message' => 'User created successfully',
            ], 200);
        } else {
            // Update existing user
            $customer = Customer::find($id);
            if ($customer) {
                $customer->name = $request->name;
                $customer->company_name = $request->company_name;
                $customer->email = $request->email;
                $customer->phone_number = $request->phone_number;
                $customer->address = $request->address;
                $customer->date = $request->date;
                $customer->establish_date = $request->establish_date;
                $customer->created_by = Auth::user()->id;
        
                $customer->save();
        
                return response()->json([
                    'status' => 200,
                    'message' => 'User updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                ], 404);
            }
        }
        
    
    }
    public function edit(Request $request){
        $id = $request->id;
        $records =array();
        $customer = Customer::where('id',$id)->first();

        return response()->json([
            'status' => 200,
            'data' => $customer,
        ], 200);
    }

    public function delete(Request $request) {
        $id = $request->id;

        // Find the record by ID
        $record = Customer::find($id);
    
        // Check if the record exists
        if ($record) {
            // Delete the record
            $record->delete();
    
            // Return a success message
            return response()->json([
                'status' => 200,
            ], 200);
        } else {
            // Return an error message if record not found
            return response()->json([
                'status' => 404,
            ], 200);
        }
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $data = Customer::find($id);
        
        if($data){
            $data->status = $status;
            $data->save();
            return response()->json([
                'status' => 200,
            ], 200);
        } else {
            // Return an error message if record not found
            return response()->json([
                'status' => 404,
            ], 200);
        }
    }
}
