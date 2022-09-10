<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class HelperController extends Controller
{


    static function getAdminDetailsExceptLoggedIn()
    {
        return DB::table("admin_details")
            ->select("admin_details.*", DB::raw("(SELECT admin_name FROM admin_details as t WHERE admin_details.admin_created_by = t.admin_id) as created_name"))
            ->where([['admin_id', '!=', Session::get('admin_id')], ['admin_name', '!=', 'root']])
            ->get();
    }

    static function getAdminDetails($id = '')
    {
        $admin = DB::table('admin_details');
        if ($id != '')  $admin->where('admin_id', $id);
        return $admin->get();
    }

    static function getUsers($id = '')
    {
        $data =  DB::table("user_details");
        if ($id != '') $data->where('user_id', $id);
        return $data->orderBy('user_id', 'desc')->get();
    }

    static function getProductDetails($id = '')
    {
        $data = DB::table("products");
        if ($id != '') $data->where('product_id', $id);
        return $data->orderBy('product_id', 'desc')->get();
    }

    static function getDefaultExist($productfor, $id = '')
    {
        $data = DB::table("products")->where([['product_default', 1], ['product_for', $productfor]]);
        if ($id != '') $data->where('product_id', '!=',$id);
        return $data->get();
    }

    static function isAdminExist($name)
    {
        $admin = DB::table("admin_details")->where('admin_name', $name)->count();
        if ($admin) return true;
        return false;
    }

    static function getAllusers($id = '')
    {
        $data = DB::table("user_details");
        if ($id != '') $data->where('user_id', $id);
        return $data->orderBy('user_id', 'desc')->get();
    }

    static function getAllOrders($id = '')
    {
        $data = DB::table("order_details");
        if ($id != '') $data->where('order_id', $id);
        return $data->orderBy('order_id', 'desc')->get();
    }

    static function getOrderProducts($id = '')
    {
        $data = DB::table("order_details_products");
        if ($id != '') $data->where('order_id', $id);
        return $data->orderBy('order_id', 'desc')->get();
    }

    static function getAllDelivery($id = '')
    {
        $data = DB::table("deliveryinfo");
        if ($id != '') $data->where('deliveryinfo_id', $id);
        return $data->orderBy('deliveryinfo_id', 'asc')->get();
    }

    static function getDeliveryProduct($id)
    {
        return DB::table("deliveryinfo_products")->where('deliveryinfo_id', $id)->orderBy('deliveryinfo_id', 'desc')->get();
    }
}
