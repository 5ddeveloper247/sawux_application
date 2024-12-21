<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
class ParameterController extends Controller
{
    //
    public function index(){

        $customer_id = Auth::user()->customer_id;
        $locations = Location::where('customer_id',$customer_id)->where('status','1')->get();
        return view('parameter',compact('locations'));
    
    }
}
