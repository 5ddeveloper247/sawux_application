<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

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
