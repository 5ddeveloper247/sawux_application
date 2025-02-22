<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    //
    public function index(){
        return view('location');
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
            $customerId = Auth::user()->customer_id;
            $data = Location::where('customer_id', '=', $customerId)
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('code', 'like', '%' . $searchTerm . '%')
                      ->orWhere('postal_code', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhere('address', 'like', '%' . $searchTerm . '%');
            })
            ->latest()
            ->paginate($length, ['*'], 'page', $page);
        
                       
            
            // Format data for DataTables response
            $formattedData = $data->items(); // Get current page items
            $formattedData = collect($formattedData)->map(function ($row, $index) use ($start) {
                return [
                    'DT_RowIndex' => $start + $index + 1, // Adjust index for pagination
                    'name' => $row->name,
                    'code' => $row->code,
                    'postal_code' => $row->postal_code,
                    'description' => $row->description,
                    'address' => $row->address,
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
            'name' => 'required|max:12',
            'code' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
            'description' => 'required',
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

        if ($id == '') {
            // Create new user
            $location = new Location;
            $location->name = $request->name;
            $location->code = $request->code;
            $location->postal_code = $request->postal_code;
            $location->address = $request->address;
            $location->description = $request->description;
            $location->customer_id = Auth::user()->customer_id;
            $location->save();

            $locationId = $location->id;
            record_audit_trail('Locations','locations',$locationId,'ADD','Create a new location.');
            
            return response()->json([
                'status' => 200,
                'message' => 'Location created successfully',
            ], 200);
        } else {
            // Update existing user
            $location = Location::find($id);
            if ($location) {
                $location->name = $request->name;
                $location->code = $request->code;
                $location->address = $request->address;
                $location->description = $request->description;
                $location->customer_id = Auth::user()->customer_id;
                $location->save();
        
                record_audit_trail('Locations','locations',$id,'Update','Update the location.');

                return response()->json([
                    'status' => 200,
                    'message' => 'Location updated successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Location not found',
                ], 404);
            }
        }
        
    
    }
    public function edit(Request $request){
        $id = $request->id;
        $records =array();
        $location = Location::where('id',$id)->first();
        return response()->json([
            'status' => 200,
            'data' => $location,
        ], 200);
    }

    public function delete(Request $request) {
        $id = $request->id;

        // Find the record by ID
        $record = Location::find($id);
    
        // Check if the record exists
        if ($record) {
            // Delete the record
            $record->delete();
    
            record_audit_trail('Locations','locations',$id,'Delete','Delete the location.');

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
        $data = Location::find($id);
        
        if($data){
            $data->status = $status;
            $data->save();
            
            record_audit_trail('Locations','locations',$id,'Status','Change the status of the location.');

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
        $loginId = Auth::user()->customer_id;
        $totalUser = Location::where('customer_id',$loginId)->count();
        $activeUser = Location::where('customer_id',$loginId)->where('status','=','1')->count();
        $inActiceUser = Location::where('customer_id',$loginId)->where('status','=','0')->count();

        $records['total_user'] = $totalUser;
        $records['active_user'] = $activeUser;
        $records['inactive_user'] = $inActiceUser;

        return response()->json([
            'status' => 200,
            'data' =>$records
        ], 200);
    }
}
