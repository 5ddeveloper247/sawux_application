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
                        ->where('role','=',1)
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
                    'action' => '<button  class="btn btn-sm btn-primary edit-btn" data-id="'.$row->id.'">Edit</button>
                                 <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>'
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
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required',
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $selectedMenus = json_decode($request->selectedMenus);
      
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 1;
        $user->save();
        foreach($selectedMenus as $MenuId)
        {
            $user->sidebarMenus()->attach($MenuId);
        }
        return response()->json([
            'status' => 200,
        ], 200);
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
}
