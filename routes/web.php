<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerUserController;
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
        Route::get('/admin/customer-users', [CustomerUserController::class, 'index'])->name('superadmin.customer.users');

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
Route::post('/admin/customer-users/listAll', [CustomerUserController::class, 'listAll'])->name('superadmin.customer.users.listAll');
Route::post('/admin/customer-users/creat', [CustomerUserController::class, 'create'])->name('superadmin.customer.users.create');
Route::post('/admin/customer-users/edit', [CustomerUserController::class, 'edit'])->name('superadmin.customer.users.edit');
Route::post('/admin/customer-users/delete', [CustomerUserController::class, 'delete'])->name('superadmin.customer.users.delete');


});


Route::group(['middleware' => ['AdminAuth']], function () {

    /************** PAGE ROUTES ******************/
    Route::get('/createStaticUser', [AdminController::class, 'createStaticUser'])->name('createStaticUser');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/saveApiSettings', [AdminController::class, 'saveApiSettings'])->name('saveApiSettings');
    Route::post('/getDashboardPageData', [AdminController::class, 'getDashboardPageData'])->name('getDashboardPageData');
    Route::post('/saveParameterValues', [AdminController::class, 'saveParameterValues'])->name('getDsaveParameterValuesashboardPageData');
    Route::post('/changeParameterValueOnOff', [AdminController::class, 'changeParameterValueOnOff'])->name('changeParameterValueOnOff');
    Route::post('/saveDeviceKeyValue', [AdminController::class, 'saveDeviceKeyValue'])->name('saveDeviceKeyValue');
    Route::post('/refreshParameterValuesTypeWise', [AdminController::class, 'refreshParameterValuesTypeWise'])->name('refreshParameterValuesTypeWise');
    Route::post('/updateSystemStatus', [AdminController::class, 'updateSystemStatus'])->name('updateSystemStatus');
    
    Route::post('/updateType', [AdminController::class, 'updateType'])->name('updateType');
    Route::post('/updateSubType', [AdminController::class, 'updateSubType'])->name('updateSubType');
    Route::post('/updateParameter', [AdminController::class, 'updateParameter'])->name('updateParameter');
    
    
});

// Route::get('/', function () {
//     return view('welcome');
// });
