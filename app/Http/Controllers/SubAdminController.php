<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SidebarMenu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class SubAdminController extends Controller
{
    //
    public function index(){
        
        $sidebarMenus = SidebarMenu::all(); // Fetch all sidebar menu items
        return view('SuperAdmin.SubAdmin.index', compact('sidebarMenus')); // Pass the sidebar menus to the view
        

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
            $data = User::where('name', 'like', '%' . $searchTerm . '%')
                        ->where('role','=','1')
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
                        <a class="dropdown-item text-danger del delete-btn" data-id="'.$row->id.'" type="button" >Remove</a>
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
        $selectedMenus = json_decode($request->selectedMenus);
        
        // Validation rules
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:users,username' . ($id ? ",$id" : ''),
            'email' => 'required|email|unique:users,email' . ($id ? ",$id" : ''),
            'password' => $id ? 'nullable|min:6' : 'required|min:6', // Password is required for new user but optional for update
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
            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 1;
            $user->save();
        
            // Attach selected menus
            foreach ($selectedMenus as $MenuId) {
                $user->sidebarMenus()->attach($MenuId);
            }
            $userId = $user->id;
            record_audit_trail('SubAdmin','users',$userId,'ADD','Create a new sub-admin.'); 
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
        
                // Update password only if provided
                if (!empty($request->password)) {
                    $user->password = Hash::make($request->password);
                }
        
                $user->save();
        
                // Sync selected menus
                $user->sidebarMenus()->sync($selectedMenus);
                record_audit_trail('SubAdmin','users',$id,'Update','Update sub-admin.'); 

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

     $pivotData = DB::table('user_sidebar_menu')
        ->select('sidebar_menu_id')
        ->where('user_id', $id)
        ->get();
        
        $records['user'] = $user;
        $records['pivotData'] = $pivotData;

        return response()->json([
            'status' => 200,
            'data' => $records,
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
            record_audit_trail('SubAdmin','users',$id,'Delete','Delete sub-admin.'); 
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
            record_audit_trail('SubAdmin','users',$id,'Status','Change the status of the sub-admin.');
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
        $totalUser = User::where('role','=','1')->count();
        $activeUser = User::where('status','=','1')->where('role','=','1')->count();
        $inActiceUser = User::where('status','=','0')->where('role','=','1')->count();

        $records['total_customer'] = $totalUser;
        $records['active_customer'] = $activeUser;
        $records['inactive_customer'] = $inActiceUser;

        return response()->json([
            'status' => 200,
            'data' =>$records
        ], 200);
    }
}
