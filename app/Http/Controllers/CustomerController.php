<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SidebarMenu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('company_name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('email', 'like', '%' . $searchTerm . '%')
                      ->orWhere('phone_number', 'like', '%' . $searchTerm . '%')
                      ->orWhere('establish_date', 'like', '%' . $searchTerm . '%'); // Assuming establish_date is stored as a string or can be compared like this
            })
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
                    'establish_date' => Carbon::parse($row->establish_date)->format('d-M-Y'),
                    'status' => '<div class="checkbox-wrapper form-check form-switch pt-1 p-0">
                                    <input class="form-check-input pointer check check-box" type="checkbox" role="switch" 
                                    id="'.$row->id.'" 
                                    ' . (isset($row->status) && $row->status == 1 ? 'checked' : '') . '>
                                    <label class="check-btn" for="'.$row->id.'" 
                                    ' . (isset($row->status) && $row->status == 1 ? 'checked' : '') . '"></label>
                                </div>',
                                
                    'action' => '<div class="d-flex align-items-center gap-3 justify-content-start">
                                    <a class="edit-btn text-white" data-id="'.$row->id.'" type="button">
                                        <i class="fa-solid fa-user-pen fs-5"></i>
                                    </a>
                                </div>'
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
            'phone_number' =>  'required|numeric|digits_between:7,17', 
            'address' =>  'required',
            'establish_date' =>  'required|before:today', 
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
            $customer->establish_date = $request->establish_date;
            $customer->created_by = Auth::user()->id;
            $customer->save();
            $customerId = $customer->id;
            record_audit_trail('Customer','customers',$customerId,'ADD','Create a new customer.'); 
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
                $customer->establish_date = $request->establish_date;
                $customer->created_by = Auth::user()->id;
        
                $customer->save();
                record_audit_trail('Customer','customers',$id,'Update','Update the customer.');
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
            record_audit_trail('Customer','customers',$id,'Delete','Delete the customer.');
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
            record_audit_trail('Customer','customers',$id,'Status','Change the status of the customer.');
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
    public function card(){
        $records = array();
        $totalUser = Customer::count();
        $activeUser = Customer::where('status','=','1')->count();
        $inActiceUser = Customer::where('status','=','0')->count();

        $records['total_customer'] = $totalUser;
        $records['active_customer'] = $activeUser;
        $records['inactive_customer'] = $inActiceUser;

        return response()->json([
            'status' => 200,
            'data' =>$records
        ], 200);
    }
}
