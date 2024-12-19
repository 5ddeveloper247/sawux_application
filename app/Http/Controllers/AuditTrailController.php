<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuditTrail;
class AuditTrailController extends Controller
{
    //
    public function index(Request $request){
        return view("SuperAdmin.AuditTrail.index");
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
            $data = AuditTrail::with('user')->where('module', 'like', '%' . $searchTerm . '%')
                        ->latest()
                        ->paginate($length, ['*'], 'page', $page);
                       
            
            // Format data for DataTables response
            $formattedData = $data->items(); // Get current page items
            $formattedData = collect($formattedData)->map(function ($row, $index) use ($start) {
                $roleText = '';
                if ($row->user->role == '0') {
                    $roleText = 'Super Admin';
                } elseif ($row->user->role == '1') {
                    $roleText = 'Sub Admin';
                } elseif ($row->user->role == '2') { 
                    $roleText = 'Customer Admin';
                }else{
                    $roleText = 'Customer User';
                }
                return [
                    'DT_RowIndex' => $start + $index + 1, // Adjust index for pagination
                    'module' => $row->module,
                    'action' => $row->action,
                    'short_message' => $row->short_message,
                    'role' => $roleText,
                    'user_detail' => '<b>Name:</b> '.$row->user->name.'<br> <b>User Name:</b> '.$row->user->username.'<br><b>Email:</b> <small style="color:grey">'.$row->user->email.'</small>',
                    'created_at' => $row->created_at->format('d M Y h:i A'),
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
}
