<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\frontend\FrontendController;
use App\Http\Controllers\AjaxController;

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

Route::post('/paymentprocessed', [FrontendController::class, 'PaymentProcessed']);
Route::post('/paymentnotify', [FrontendController::class, 'PaymentProcessed']);

Route::get('/invoicetemplate', [FrontendController::class, 'InvoiceTemplateView']);



Route::middleware(['globalvalidate'])->group(function () {
    Route::get('/', [FrontendController::class, 'Home']);

    Route::get('/sendemail', [FrontendController::class, 'SendEmail']);
    Route::get('/about_us', [FrontendController::class, 'AboutUs']);
    Route::get('/products', [FrontendController::class, 'Products']);
    Route::get('/faq', [FrontendController::class, 'FAQ']);
    Route::post('/contactus', [FrontendController::class, 'ContactUs']);

    Route::get('/privacy_policy', [FrontendController::class, 'PrivacyPolicy']);
    Route::get('/disclaimer', [FrontendController::class, 'Disclaimer']);
    Route::get('/return_refund', function () {return view('frontend.return_refund');});
    Route::get('/shipping_policy', function () {return view('frontend.shipping_policy');});
    Route::get('/terms_conditions', function () {return view('frontend.terms_conditions');});

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

        Route::get('/upcomingdelivery_product/{id}', [FrontendController::class, 'UpcomingDeliveryProduct']);
        Route::get('/pets_master', [FrontendController::class, 'PetsMasterDetails']);
        Route::get('/pets_master/{id}', [FrontendController::class, 'PetsMasterCalculation']);
        Route::post('/orderproceed', [FrontendController::class, 'OrderTypeProcess']);
        Route::get('/payment/{id}', [FrontendController::class, 'PaymentGateway']);

        Route::post('/paymentprocess', [FrontendController::class, 'PaymentProcess']);

        Route::post('/paymentsuccess', [FrontendController::class, 'PaymentSuccess']);

        Route::post('/getbreed', [AjaxController::class, 'GetBreeds']);
        Route::post('/getorderproducts', [AjaxController::class, 'GetOrderProducts']);

        Route::post('/savepetsmaster', [FrontendController::class, 'SavePetsMaster']);

        Route::get('/ordertesting', [FrontendController::class, 'OrderTesting']);


        Route::get('/addshippingaddress', [FrontendController::class, 'AddShippingAddress']);
        Route::get('/editshippingaddress/{id}', [FrontendController::class, 'EditShippingAddress']);
        Route::post('/saveshippingaddress', [FrontendController::class, 'SaveShippingAddress']);
        Route::get('/myorders', [FrontendController::class, 'MyOrders']);
        Route::get('/orderinvoice/{id}', [FrontendController::class, 'OrderInvoiceDownload']);
        Route::get('/myorderproducts/{id}', [FrontendController::class, 'MyOrderProducts']);
        Route::get('/upcoming_delivery', [FrontendController::class, 'UpcomingDelivery']);
        Route::get('/upcoming_due', [FrontendController::class, 'UpcomingDue']);
        Route::post('/upcoming_due', [FrontendController::class, 'ProcessDue']);
        Route::get('/user_subscription', [FrontendController::class, 'UserSubscription']);
        Route::get('/update_subscription/{id}', [FrontendController::class, 'UpdateSubscription']);
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

            Route::get('/viewpdf', [AdminController::class, 'OrderSuccessEmail']);

            Route::get('/viewuser', [AdminController::class, 'ViewUser']);

            Route::get('/vieworder', [AdminController::class, 'ViewOrder']);
            Route::get('/vieworderdelivery', [AdminController::class, 'ViewOrderDelivery']);
            Route::get('/view_delivery_products/{id}', [AdminController::class, 'ViewDeliveryProductDetails']);
            Route::get('/vieworderdetails/{id}', [AdminController::class, 'ViewOrderDetails']);
            Route::get('/orderinvoice/{id}', [AdminController::class, 'OrderInvoiceDownload']);


            Route::get('/viewproduct', [AdminController::class, 'ViewProduct']);
            Route::get('/manageproduct', [AdminController::class, 'ManageProduct']);
            Route::get('/actionproduct/{option}/{id}', [AdminController::class, 'ActionProduct']);
            Route::post('/saveproductdetails', [AdminController::class, 'SaveProductDetails']);



            Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('logout');
        });
    });
});
