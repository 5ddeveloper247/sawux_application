<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SubAdminController;
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
// forget password
Route::get('/forget-password', [SuperAdminController::class, 'forgetPassword'])->name('superadmin.forgetpassword');
Route::post('/email-verified', [SuperAdminController::class, 'emailverified'])->name('superadmin.email.verified');
Route::post('/otp-verified', [SuperAdminController::class, 'otpverified'])->name('superadmin.otp.verified');
Route::post('/update-password', [SuperAdminController::class, 'updatePassword'])->name('superadmin.updatePassword');



Route::group(['middleware' => ['SuperAdminAuth']], function () {
Route::get('/admin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

// sub admin
Route::get('/admin/sub-admin', [SubAdminController::class, 'index'])->name('superadmin.subAdmin');
Route::post('/admin/sub-admin/listAll', [SubAdminController::class, 'listAll'])->name('superadmin.subAdmin.listAll');
Route::post('/admin/sub-admin/creat', [SubAdminController::class, 'create'])->name('superadmin.subAdmin.create');
Route::post('/admin/sub-admin/edit', [SubAdminController::class, 'edit'])->name('superadmin.subAdmin.edit');
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
