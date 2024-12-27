<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerUserController extends Controller
{
    public function index(){
        $customer_id = Auth::user()->customer_id;
        $locations = Location::where('customer_id',$customer_id)->get();
        return view('customer_user',compact('locations')); 
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
            $loginId = Auth::user()->id;
            $data = User::where('role','=',3)
                        ->where('created_by','=',$loginId)
                        ->where('name', 'like', '%' . $searchTerm . '%')
                        ->latest()
                        ->paginate($length, ['*'], 'page', $page);
                       
            
            // Format data for DataTables response
            $formattedData = $data->items(); // Get current page items
            $formattedData = collect($formattedData)->map(function ($row, $index) use ($start) {
                return [
                    'DT_RowIndex' => $start + $index + 1, // Adjust index for pagination
                    'name' => $row->name,
                    'username' => $row->username,
                    'email' => $row->email,
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
                                </div>
                                '
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
            'locations' => 'required',
            'username' => 'required|unique:users,username' . ($id ? ",$id" : ''),
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
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
        $location = json_decode($request->jsonLocations,true);
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
            $user->location_id = json_encode($location);
            $user->created_by = Auth::user()->id;
            $user->customer_id = Auth::user()->customer_id;
            $user->role = 3;
            $user->save();
            $mailData['password'] = $password;
            $mailData['username'] = $request->username;
             $body = view('email.send_user_credentials_template', $mailData);
            sendMail($request->name, $request->email, 'Your Account Credentials', $body);

            $userId = $user->id;
            record_audit_trail('Customer User','users',$userId,'ADD','Create a new customer user.');
            
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
                $user->location_id = json_encode($location);
                $user->save();
        
                record_audit_trail('Customer User','users',$id,'Update','Update the customer user.');

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
    
            record_audit_trail('Customer User','users',$id,'Delete','Delete the customer user.');

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
            
            record_audit_trail('Customer User','users',$id,'Status','Change the status of the customer-user.');

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
        $loginId = Auth::user()->id;
        $totalUser = User::where('role','=','3')->where('created_by','=',$loginId)->count();
        $activeUser = User::where('role','=','3')->where('created_by','=',$loginId)->where('status','=','1')->count();
        $inActiceUser = User::where('role','=','3')->where('created_by','=',$loginId)->where('status','=','0')->count();

        $records['total_user'] = $totalUser;
        $records['active_user'] = $activeUser;
        $records['inactive_user'] = $inActiceUser;

        return response()->json([
            'status' => 200,
            'data' =>$records
        ], 200);
    }
}
