<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('frontend.home');});

Route::prefix(ADMINURL)->group(function () {
    Route::get('/', function () { return view('admin.login'); })->middleware('adminloginvalidate');
    Route::post('/login', [AdminController::class, 'AdminLogin'])->middleware('adminloginvalidate');

    Route::middleware(['adminauth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'Dashboard']);
        Route::get('/change_password', [AdminController::class, 'ChangePassword']);
        Route::post('/change_password', [AdminController::class, 'UpdatePassword']);

        Route::get('/viewadmin', [AdminController::class, 'ViewAdmin']);
        Route::get('/manageadmin', [AdminController::class, 'ManageAdmin']);
        Route::get('/actionadmin/{option}/{id}', [AdminController::class, 'ActionAdmin']);
        Route::post('/saveadmindetails', [AdminController::class, 'SaveAdminDetails']);

        Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('logout');
    });
});
