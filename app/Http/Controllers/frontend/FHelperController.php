<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FHelperController extends Controller
{
    static function getUserDetails($id = '')
    {
        $data = DB::table("user_details");
        if ($id != '') $data->where('user_id', $id);
        return $data->orderBy('user_id', 'desc')->get();
    }

    static function getUserByEmail($id)
    {
        return DB::table("user_details")->where('user_email', $id)->get();
    }

    static function getUserOTPByEmail($id)
    {
        return DB::table("user_otp")->where('user_email', $id)->get();
    }

    static function getUserOTPVerifyByEmail($email, $otp)
    {
        return DB::table("user_otp")->where([['user_email', $email], ['user_otp', $otp]])->get();
    }

    static function getUserValidate($email,$password)
    {
        return DB::table("user_details")->where([['user_email', $email], ['user_password', $password]])->get();
    }

    static function getUserAddressDetails($id)
    {
        return DB::table("user_address")->where('user_id', $id)->get();
    }

    static function getUserAddressDetailsById($id)
    {
        return DB::table("user_address")->where('user_address_id', $id)->get();
    }

    static function isPasswordExist($id,$password)
    {
        return DB::table("user_details")->where([['user_id',$id],['user_password', $password]])->get();
    }

    static function GetBreeds($breedType){
        return DB::table("breeds_info")->where([['breed_type', $breedType], ['status', 1]])->get();
    }

    static function getPetsMaster($id){
        return DB::table("pets_master_details")->where([['pets_master_id', $id], ['status', 1]])->get();
    }

    static function getPetsOrderTemp($id){
        return DB::table("order_details_temp")->where('order_id', $id)->get();
    }

    static function getPetsOrderProductsTemp($id){
        return DB::table("order_details_products_temp")->where('order_id', $id)->get();
    }

    static function getProducts($id = '')
    {
        $data = DB::table("products");
        if ($id != '') $data->where('product_id', $id);
        return $data->orderBy('product_id', 'desc')->get();
    }

    static function getPetsOrder($id=''){
        $data = DB::table("order_details");
        if ($id != '') $data->where('order_id', $id);
        return $data->orderBy('order_id', 'desc')->get();
    }

    static function getMyOrders($userid){
        return DB::table("order_details")->where('user_id', $userid)->orderBy('order_id', 'desc')->get();
    }

    static function getMyOrderProducts($orderId){
        return DB::table("order_details_products")->where('order_id', $orderId)->orderBy('order_product_id', 'desc')->get();
    }

    static function getMyOrderProductsAsc($orderId){
        return DB::table("order_details_products")->where('order_id', $orderId)->get();
    }

    static function getMyDelivery($userid){
        return DB::table("deliveryinfo")->where('user_id', $userid)->get();
    }

    static function getMyDeliveryProduct($id){
        return DB::table("deliveryinfo_products")->where('deliveryinfo_id', $id)->get();
    }

    static function getUserSubscription($id){
        return DB::table("subscription")->where('user_id', $id)->get();
    }

    static function getUserSubscriptionById($id){
        return DB::table("subscription")->where('subscription_id', $id)->get();
    }

    static function getUpcomingDue($userId){
        $fetchData = DB::table("order_details")
        ->join('subscription', 'order_details.order_id', '=', 'subscription.order_id')
        ->select('order_details.*','subscription.user_id');
        return $fetchData->where([['order_details.user_id',$userId],['order_details.orderProcessType',1],['subscription.user_id', $userId],['subscription.status',1]])->orderBy('order_details.order_id','desc')->get();

    }

    static function getOverDueByUser($userid){
        return DB::table("order_due")->where('user_id', $userid)->get();
    }




}
