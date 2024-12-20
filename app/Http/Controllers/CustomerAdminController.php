<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
class CustomerAdminController extends Controller
{
    //
    public function index(){
        $customers = Customer::where('status','=','1')->get();
        return view('SuperAdmin.CustomerUser.index',compact('customers')); 
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
          
            $data = User::with('customer')->where('role','=',2)
                        ->where('name', 'like', '%' . $searchTerm . '%')
                        ->latest()
                        ->paginate($length, ['*'], 'page', $page);
                       
            
            // Format data for DataTables response
            $formattedData = $data->items(); // Get current page items
            $formattedData = collect($formattedData)->map(function ($row, $index) use ($start) {
                return [
                    'DT_RowIndex' => $start + $index + 1, // Adjust index for pagination
                    'name' => $row->name,
                    'email' => $row->email,
                    'customer' => $row->customer ? '<span style="font-size:1rem !important"> <b>Name: </b> ' . $row->customer->name . '</span><br><span style="font-size:1rem !important"> <b> Company Name: </b>'. $row->customer->company_name . '</span><br><span style="font-size:1rem !important" > <b> Email: </b> '. $row->customer->email .'</span>' : '',

                    'username' => $row->username,
                    'status' => '<div class="form-check form-switch pt-1">
                    <input class="form-check-input pointer" type="checkbox" role="switch" 
                    id="'.$row->id.'" 
                   ' . (isset($row->status) && $row->status == 1 ? 'checked' : '') . '>
                   </div>',
                    'action' => '<div class="btn-reveal-trigger position-static">
                                        <button class="btn btn-sm dropdown-toggle" id="dropdown" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg class="svg-inline--fa fa-ellipsis" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                <path fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"></path>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item edit-btn" data-id="'.$row->id.'" type="button">Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger del delete_record" data-id="'.$row->id.'" type="button" >Remove</a>
                                        </div>
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
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''), 
            'username' => 'required|unique:users,username' . ($id ? ",$id" : ''),
            'customer_id' => 'required|not_in:0',
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
        $password  ='12345678';
        $hashPassword = Hash::make($password);
        // Handle create or update logic
        if ($id == '') {
            // Create new user
            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = $hashPassword;
            $user->customer_id = $request->customer_id;
            $user->role = 2;
            $user->save();

            $mailData['password'] = $password;
            $mailData['username'] = $request->username;
             $body = view('email.send_user_credentials_template', $mailData);
            sendMail($request->name, $request->email, 'Your Account Credentials', $body);

            $userId = $user->id;
            record_audit_trail('CustomerAdmin','users',$userId,'ADD','Create a new customer-admin.');
            return response()->json([
                'status' => 200,
                'message' => 'User created successfully',
            ], 200);
        } else {
            // Update existing user
            $user = User::find($id);
            if ($user) {
                $user->name = $request->name;
                $user->username = $request->username;
                $user->email = $request->email;
                $user->customer_id = $request->customer_id;
                $user->save();
                record_audit_trail('CustomerAdmin','users',$id,'Update','Update the customer-admin.');
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
        $user = User::where('id',$id)->first();

        return response()->json([
            'status' => 200,
            'data' => $user,
        ], 200);
    }

    public function delete(Request $request) {
        $id = $request->id;

        // Find the record by ID
        $record = User::find($id);
    
        // Check if the record exists
        if ($record) {
            // Delete the record
            $record->delete();
            record_audit_trail('CustomerAdmin','users',$id,'Delete','Delete the customer-admin.');
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
        $data = User::find($id);
        
        if($data){
            $data->status = $status;
            $data->save();
            record_audit_trail('CustomerAdmin','users',$id,'Status','Change the status of the customer-admin.');
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
        $totalUser = User::where('role','=','2')->count();
        $activeUser = User::where('role','=','2')->where('status','=','1')->count();
        $inActiceUser = User::where('role','=','2')->where('status','=','0')->count();

        $records['total_customer'] = $totalUser;
        $records['active_customer'] = $activeUser;
        $records['inactive_customer'] = $inActiceUser;

        return response()->json([
            'status' => 200,
            'data' =>$records
        ], 200);
    }
}
