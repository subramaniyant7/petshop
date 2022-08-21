<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\frontend\FrontendController;

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

Route::get('/', [FrontendController::class, 'Home']);

Route::middleware(['frontenduserauthorise'])->group(function () {
    Route::get('/register', [FrontendController::class, 'Register']);
    Route::post('/register', [FrontendController::class, 'RegisterProcess']);
    Route::get('/email_otp_verify', [FrontendController::class, 'OTPVerification']);
    Route::post('/verify_otp_verify', [FrontendController::class, 'VerifyOTP']);
    Route::get('/login', [FrontendController::class, 'Login']);
    Route::post('/loginvalidate', [FrontendController::class, 'LoginValidate']);
});

Route::middleware(['frontendloggedin'])->group(function () {
    Route::get('/dashboard', [FrontendController::class, 'Dashboard']);
    Route::get('/addshippingaddress', [FrontendController::class, 'AddShippingAddress']);
    Route::get('/editshippingaddress/{id}', [FrontendController::class, 'EditShippingAddress']);
    Route::post('/saveshippingaddress', [FrontendController::class, 'SaveShippingAddress']);
    Route::get('/myorders', [FrontendController::class, 'MyOrders']);
    Route::get('/change_password', [FrontendController::class, 'ChangePassword']);
    Route::post('/save_password', [FrontendController::class, 'UpdateUserPassword']);
    Route::get('/logout', [FrontendController::class, 'UserLogout']);

});

Route::prefix(ADMINURL)->group(function () {
    Route::get('/', function () {
        return view('admin.login');
    })->middleware('adminloginvalidate');
    Route::post('/login', [AdminController::class, 'AdminLogin'])->middleware('adminloginvalidate');

    Route::middleware(['adminauth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'Dashboard']);
        Route::get('/change_password', [AdminController::class, 'ChangePassword']);
        Route::post('/change_password', [AdminController::class, 'UpdatePassword']);

        Route::get('/viewadmin', [AdminController::class, 'ViewAdmin']);
        Route::get('/manageadmin', [AdminController::class, 'ManageAdmin']);
        Route::get('/actionadmin/{option}/{id}', [AdminController::class, 'ActionAdmin']);
        Route::post('/saveadmindetails', [AdminController::class, 'SaveAdminDetails']);

        Route::get('/viewproduct', [AdminController::class, 'ViewProduct']);
        Route::get('/manageproduct', [AdminController::class, 'ManageProduct']);
        Route::get('/actionproduct/{option}/{id}', [AdminController::class, 'ActionProduct']);
        Route::post('/saveproductdetails', [AdminController::class, 'SaveProductDetails']);

        Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('logout');
    });
});
