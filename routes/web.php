<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerAdminController;
use App\Http\Controllers\ApiConfigurationController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\CustomerUserController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AdminController::class, 'index']);
Route::get('/login', [AdminController::class, 'index'])->name('login');
Route::post('/loginSubmit', [AdminController::class, 'loginSubmit'])->name('loginSubmit');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
// staff forget password
Route::get('/customer/forget-password', [AdminController::class, 'forgetPassword'])->name('forgetpassword');
Route::post('/customer/email-verified', [AdminController::class, 'emailverified'])->name('email.verified');
Route::post('/customer/otp-verified', [AdminController::class, 'otpverified'])->name('otp.verified');
Route::post('/customer/update-password', [AdminController::class, 'updatePassword'])->name('updatePassword');


//  super admin

Route::get('/admin', [SuperAdminController::class, 'index'])->name('superadmin.login');
Route::post('/adminloginSubmit', [SuperAdminController::class, 'loginSubmit'])->name('superadmin.loginSubmit');
Route::get('/admin/logout', [SuperAdminController::class, 'logout'])->name('superadmin.logout');
// forget password
Route::get('/forget-password', [SuperAdminController::class, 'forgetPassword'])->name('superadmin.forgetpassword');
Route::post('/email-verified', [SuperAdminController::class, 'emailverified'])->name('superadmin.email.verified');
Route::post('/otp-verified', [SuperAdminController::class, 'otpverified'])->name('superadmin.otp.verified');
Route::post('/update-password', [SuperAdminController::class, 'updatePassword'])->name('superadmin.updatePassword');

/************** Super Admin ******************/

Route::group(['middleware' => ['SuperAdminAuth']], function () {

    Route::group(['middleware' => ['check.sidebar.permission']], function () {
        Route::get('/admin/sub-admin', [SubAdminController::class, 'index'])->name('superadmin.subAdmin');
        Route::get('/admin/customers', [CustomerController::class, 'index'])->name('superadmin.customers');
        Route::get('/admin/customer-admin', [CustomerAdminController::class, 'index'])->name('superadmin.customer.admin');

    });

Route::get('/admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

// sub admin

Route::post('/admin/sub-admin/listAll', [SubAdminController::class, 'listAll'])->name('superadmin.subAdmin.listAll');
Route::post('/admin/sub-admin/creat', [SubAdminController::class, 'create'])->name('superadmin.subAdmin.create');
Route::post('/admin/sub-admin/edit', [SubAdminController::class, 'edit'])->name('superadmin.subAdmin.edit');
Route::post('/admin/sub-admin/delete', [SubAdminController::class, 'delete'])->name('superadmin.subAdmin.delete');
// customers

Route::post('/admin/customers/listAll', [CustomerController::class, 'listAll'])->name('superadmin.customers.listAll');
Route::post('/admin/customers/creat', [CustomerController::class, 'create'])->name('superadmin.customers.create');
Route::post('/admin/customers/edit', [CustomerController::class, 'edit'])->name('superadmin.customers.edit');
Route::post('/admin/customers/delete', [CustomerController::class, 'delete'])->name('superadmin.customers.delete');
Route::post('/admin/customers/status', [CustomerController::class, 'status'])->name('superadmin.customers.status');

// customer user
Route::post('/admin/customer-admin/listAll', [CustomerAdminController::class, 'listAll'])->name('superadmin.customer.admin.listAll');
Route::post('/admin/customer-admin/creat', [CustomerAdminController::class, 'create'])->name('superadmin.customer.admin.create');
Route::post('/admin/customer-admin/edit', [CustomerAdminController::class, 'edit'])->name('superadmin.customer.admin.edit');
Route::post('/admin/customer-admin/delete', [CustomerAdminController::class, 'delete'])->name('superadmin.customer.admin.delete');


});


Route::group(['middleware' => ['AdminAuth']], function () {

    /************** PAGE ROUTES ******************/
    Route::get('/createStaticUser', [AdminController::class, 'createStaticUser'])->name('createStaticUser');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    

    Route::post('/getDashboardPageData', [AdminController::class, 'getDashboardPageData'])->name('getDashboardPageData');
    Route::post('/saveParameterValues', [AdminController::class, 'saveParameterValues'])->name('getDsaveParameterValuesashboardPageData');
    Route::post('/changeParameterValueOnOff', [AdminController::class, 'changeParameterValueOnOff'])->name('changeParameterValueOnOff');
    Route::post('/saveDeviceKeyValue', [AdminController::class, 'saveDeviceKeyValue'])->name('saveDeviceKeyValue');
    Route::post('/refreshParameterValuesTypeWise', [AdminController::class, 'refreshParameterValuesTypeWise'])->name('refreshParameterValuesTypeWise');
    Route::post('/updateSystemStatus', [AdminController::class, 'updateSystemStatus'])->name('updateSystemStatus');
    
   
   
   
    

    Route::get('/api-configuration', [ApiConfigurationController::class, 'index'])->name('api.configuration');
    Route::post('/saveApiSettings', [ApiConfigurationController::class, 'saveApiSettings'])->name('saveApiSettings');

    Route::get('/parameters', [ParameterController::class, 'index'])->name('parameter');
    Route::get('/device', [DeviceController::class, 'index'])->name('device');
    Route::post('/updateType', [DeviceController::class, 'updateType'])->name('updateType');
    Route::post('/updateSubType', [DeviceController::class, 'updateSubType'])->name('updateSubType');

    Route::post('/getDevices', [DeviceController::class, 'getDevices'])->name('getDevices');
    
    Route::post('/getSubTpes', [DeviceController::class, 'getSubTpes'])->name('getSubTpes');
    Route::post('/updateParameter', [DeviceController::class, 'updateParameter'])->name('updateParameter');

    // customer users
    Route::get('/customer-users', [CustomerUserController::class, 'index'])->name('customer.users');
    Route::post('/customer-users/listAll', [CustomerUserController::class, 'listAll'])->name('customer.users.listAll');
    Route::post('/customer-users/creat', [CustomerUserController::class, 'create'])->name('customer.users.create');
    Route::post('/customer-users/edit', [CustomerUserController::class, 'edit'])->name('customer.users.edit');
    Route::post('/customer-users/delete', [CustomerUserController::class, 'delete'])->name('customer.users.delete');
    Route::post('/customer-users/status', [CustomerUserController::class, 'status'])->name('customer.users.status');
    
    //profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/update-profile', [ProfileController::class, 'updateProfile'])->name('update-profile');

});

// Route::get('/', function () {
//     return view('welcome');
// });
