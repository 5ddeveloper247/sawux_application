<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiSetting;
class ApiConfigurationController extends Controller
{
    //
    public function index(){
        $data['api_settings'] = ApiSetting::find(1);
        return view('api_configuration')->with($data);
    }
}
