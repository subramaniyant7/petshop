<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class HelperController extends Controller
{
    
    static function getUnlockConfig($id=''){
        $config = DB::table('unlock_config');
        if($id!='')  $config->where('config_id', $id);
        return $config->orderBy('config_id','desc')->get();
    }
    
    static function getAdminDetailsExceptLoggedIn(){
        return DB::table("admin_details")
          ->select("admin_details.*", DB::raw("(SELECT admin_name FROM admin_details as t WHERE admin_details.admin_created_by = t.admin_id) as created_name"))
          ->where([['admin_id', '!=' , Session::get('admin_id')],['admin_name','!=','root']])
          ->get();
    }

    static function getAllCarriers($id=''){
        $carrier = DB::table('carriers');
        if($id!='')  $carrier->where('carrier_id', $id);
        return $carrier->orderBy('carrier_id','desc')->get();
    }

    static function getAllVouchersItem($id=''){
        $voucher =  DB::table("voucher_item")
                ->join('vouchers', 'voucher_item.voucher_item_voucher_id', '=', 'vouchers.voucher_id')
                ->join('carriers', 'vouchers.voucher_carrier', '=', 'carriers.carrier_id')
                ->select('voucher_item.*', 'carriers.carrier_logo', 'carriers.carrier_name','vouchers.voucher_mrp','vouchers.voucher_selling_price');
        if($id!='')  $voucher->where('voucher_item.voucher_item_id', $id);
        return $voucher->orderBy('voucher_item.voucher_item_id','desc')->get();
    }


    static function getAllVouchers($id=''){
        $voucher = DB::table('vouchers');
        if($id!='')  $voucher->where('voucher_id', $id);
        return $voucher->orderBy('voucher_id','desc')->get();
    }

    static function getAdminDetails($id=''){
        $admin = DB::table('admin_details');
        if($id!='')  $admin->where('admin_id', $id);
        return $admin->get();
    }

    static function getUsers($id=''){
        $data =  DB::table("user_detail")
                ->select("user_detail.*", DB::raw("(SELECT admin_name FROM admin_details WHERE user_created_by = admin_details.admin_id) as created_name"));
        if($id!='') $data->where('user_id',$id);
        return $data->orderBy('user_id','desc')->get();
    }

    static function getAllOrders($filter){
         $orders = DB::table('order_history');
        if(count($filter)){
            $orders->whereBetween('created_at',[$filter['from'],$filter['to']]);
        }
        return $orders->orderBy('order_id','desc')->get();
       
    }

    static function getBrands($id=''){
        $data =  DB::table("brands")
                ->select("brands.*", DB::raw("(SELECT admin_name FROM admin_details WHERE brand_created_by = admin_details.admin_id) as created_name"),
                DB::raw("(SELECT category_name FROM category WHERE brands.category_id = category.category_id) as category_name"));
        if($id!='') $data->where('brand_id',$id);
        return $data->orderBy('brand_id','desc')->get();
    }

    static function getProducts($id=''){
        $data =  DB::table("product_details")
                ->select("product_details.*", DB::raw("(SELECT admin_name FROM admin_details WHERE product_created_by = admin_details.admin_id) as created_name"),
                DB::raw("(SELECT category_name FROM category WHERE product_category = category.category_id) as category_name"),
                DB::raw("(SELECT subcategory_name FROM sub_category WHERE product_subcategory = sub_category.subcategory_id) as subcategory_name"));
        if($id!='') $data->where('product_id',$id);
        return $data->orderBy('product_id','desc')->get();
    }

    static function getPriceSymbols($id=''){
        $data =  DB::table("price_symbols")->select("price_symbols.*",
                DB::raw("(SELECT admin_name FROM admin_details WHERE symbol_created_by = admin_details.admin_id) as created_name"));
        if($id!='') $data->where('symbol_id',$id);
        return $data->orderBy('symbol_id','desc')->get();
    }

    static function getShippingMethod($id=''){
        $data =  DB::table("shipping_methods")->select("shipping_methods.*",
            DB::raw("(SELECT admin_name FROM admin_details WHERE shipping_created_by = admin_details.admin_id) as created_name"));
        if($id!='') $data->where('shipping_id',$id);
        return $data->orderBy('shipping_id','desc')->get();
    }

    static function getPaymentMethod($id=''){
        $data =  DB::table("payment_methods")->select("payment_methods.*",
            DB::raw("(SELECT admin_name FROM admin_details WHERE payment_method_created_by = admin_details.admin_id) as created_name"));
        if($id!='') $data->where('payment_id',$id);
        return $data->orderBy('payment_id','desc')->get();
    }

    static function isAdminExist($name){
        $admin = DB::table("admin_details")->where('admin_name',$name)->count();
        if($admin) return true;
        return false;
    }

    static function getCategoryByName($name){
        return DB::table("category")->where('category_name',$name)->get();
    }

    static function getSubCategoryByName($name){
        return DB::table("sub_category")->where('subcategory_name',$name)->get();
    }

    static function getCountryByName($name){
        return DB::table("country")->where('country_name',$name)->get();
    }

    static function getStateByName($country,$name){
        return DB::table("state")->where([['country_id',$country],['state_name',$name]])->get();
    }

    static function getCityByName($country,$state,$name){
        return DB::table("city")->where([['country_id',$country],['state_id',$state],['city_name',$name]])->get();
    }

    static function getCurrencyName($name){
        return DB::table("price_symbols")->where('symbol_name',$name)->get();
    }

    static function getUserAddress($id=''){
        return DB::table('user_address_detail')->where('user_id', $id)->get();
    }

    static function getAddress($id){
        return DB::table('user_address_detail')->where('address_id', $id)->get();
    }

    static function isEmailExist($email){
        return DB::table('user_detail')->where('user_email', $email)->count();
    }

    static function isPhoneExist($number){
        return DB::table('user_detail')->where('user_phone', $number)->count();
    }

    static function imageExist($id,$row){
        return DB::table('product_images')->where([['product_id',$id],['row',$row]])->count();
    }

    static function getMoreImages($id){
        return DB::table('product_images')->where('product_id',$id)->get();
    }

    static function getCategories($id=''){
        $data =  DB::table("category")
                ->select("category.*", DB::raw("(SELECT admin_name FROM admin_details WHERE category_created_by = admin_details.admin_id) as created_name"),
                );
        if($id!='') $data->where('category_id',$id);
        return $data->orderBy('category_id','desc')->get();
    }

    static function getSubCategories($id=''){
        $data =  DB::table("sub_category")
                ->select("sub_category.*", DB::raw("(SELECT admin_name FROM admin_details WHERE subcategory_created_by = admin_details.admin_id) as created_name"),
                DB::raw("(SELECT category_name FROM category WHERE sub_category_id = category.category_id) as category_name"),
                DB::raw("(SELECT brand_name FROM brands WHERE sub_brand_id = brands.brand_id) as brand_name"));
        if($id!='') $data->where('subcategory_id',$id);
        return $data->orderBy('subcategory_id','desc')->get();
    }

    static function getCountry($id=''){
        $data =  DB::table("country")
                ->select("country.*", DB::raw("(SELECT admin_name FROM admin_details WHERE country_created_by = admin_details.admin_id) as created_name"));
        if($id!='') $data->where('country_id',$id);
        return $data->orderBy('country_id','desc')->get();
    }

    static function getState($id=''){
        $data =  DB::table("state")
                ->select("state.*", DB::raw("(SELECT admin_name FROM admin_details WHERE state_created_by = admin_details.admin_id) as created_name"),
                DB::raw("(SELECT country_name FROM country WHERE country_id = state.country_id) as country_name"));
        if($id!='') $data->where('state_id',$id);
        return $data->orderBy('state_id','desc')->get();
    }

    static function getCity($id=''){
        $data =  DB::table("city")
                ->select("city.*", DB::raw("(SELECT admin_name FROM admin_details WHERE city_created_by = admin_details.admin_id) as created_name"),
                DB::raw("(SELECT state_name FROM state WHERE state_id = city.state_id) as state_name"),
                DB::raw("(SELECT country_name FROM country WHERE country_id = city.country_id) as country_name"));
        if($id!='') $data->where('city_id',$id);
        return $data->orderBy('city_id','desc')->get();
    }

    static function getAllUOM($id=''){
        $data =  DB::table("uom_details")
                ->select("uom_details.*", DB::raw("(SELECT admin_name FROM admin_details WHERE uom_created_by = admin_details.admin_id) as created_name"));
        if($id!='') $data->where('uom_id',$id);
        return $data->orderBy('uom_id','desc')->get();
    }

    static function getStateList(Request $req){
        $data =  DB::table("state")->where([['country_id',$req->input('country_id')],['status',1]])->get();
        return response()->json(['data'=>$data]);
    }

    static function getCityList(Request $req){
        $data =  DB::table("city")->where([['country_id',$req->input('country_id')],['state_id',$req->input('state_id')],['status',1]])->get();
        return response()->json(['data'=>$data]);
    }

    static function getSubCategory(Request $req){
        $data =  DB::table("sub_category")->where([['sub_category_id',$req->input('category_id')],['sub_brand_id',$req->input('brand_id')],['status',1]])->get();
        return response()->json(['data'=>$data]);
    }

    static function getBrandList(Request $req){
        $data =  DB::table("brands")->where([['category_id',$req->input('category_id')],['status',1]])->get();
        return response()->json(['data'=>$data]);
    }
   static function voucherCarrierExist($carrier){
        return DB::table("vouchers")->where([['voucher_carrier',$carrier],['status',1]])->get();
    }
    
    
    static function getVouchersList(Request $req){
        $data =  DB::table("vouchers")->where([['voucher_carrier',$req->input('carrierId')],['status',1]])->get();
        return response()->json(['data'=>$data]);
    }
    
     static function DeleteUserProduct(Request $req){
        $data =  DB::table("store_products")->where([['store_user_product_id',$req->input('product_id')],['store_user_id',$req->input('user_id')]])->delete();
        return response()->json(['data'=>$data]);
    }
    
     static function getStoreProduct($userId,$prodId){
       return DB::table("store_products")->where([['store_user_id',$userId],['store_user_product_id',$prodId]])->get();
    }
    
     static function getUserStoreProduct($userId){
        return DB::table("store_products")->where('store_user_id',$userId)->get();
     }
     
     static function UpdateLockCode($order_item_id,$product_unlock_code){
       return DB::table("order_history_items")->where('order_item_id',$order_item_id)->update(['product_unlock_code'=>$product_unlock_code]);
    }

    static function getOrderHistoryItem($id){
        return DB::table("order_history_items")->where('order_item_id',$id)->get();
    }

    static function getOrderInfoById($id){
        return DB::table("order_history")->where('order_id',$id)->get();
    }

    static function getOrderInfoByIncId($id){
        return DB::table("order_history")->where('order_inc_id',$id)->get();
    }


    static function voucherExist($voucherplan,$carrier){
        return DB::table("vouchers")->where([['voucher_mrp',$voucherplan],['voucher_carrier',$carrier],['status',1]])->get();
    }
    
     static function getCreditsHistory(){
        $credits = DB::select('select voucher_history.voucher_inc_id,voucher_history.date,voucher_history.time, voucher_history.total, user_detail.user_email from credits_history inner join
            voucher_history on credits_history.voucher_history_id = voucher_history.voucher_history_id inner join user_detail on
            credits_history.voucher_customer_id = user_detail.user_id order By voucher_history.voucher_inc_id desc');
        return $credits;
    }
    
    static function VoucherAvailable($voucherplan,$carrier,$sellingPrice){
        return DB::table("vouchers")->where([['voucher_mrp',$voucherplan],['voucher_carrier',$carrier],['voucher_selling_price',$sellingPrice]])->get();
    }
    


    static function voucherCarrierPinExist($voucher){
        return DB::table("voucher_item")->where([['voucher_item_voucher_id',$voucher],['status',1]])->get();
    }

    static function voucherPinExist($carrierId,$voucherId,$pin){
        return DB::table("voucher_item")->where([['voucher_item_carrier_id',$carrierId],['voucher_item_voucher_id',$voucherId],
            ['voucher_item_pin_number',$pin]])->get();
    }


    static function getVoucherReport($from,$to,$user){
        // echo 'from'.$from.'to'.$to;
        $voucher =  DB::table("voucher_history")
        ->join('voucher_history_items', 'voucher_history.voucher_history_id', '=', 'voucher_history_items.voucher_history_id')
        ->join('voucher_item', 'voucher_history_items.voucher_item_id', '=', 'voucher_item.voucher_item_id')
        ->join('vouchers', 'voucher_history_items.voucher_id', '=', 'vouchers.voucher_id')
        ->join('carriers', 'vouchers.voucher_carrier', '=', 'carriers.carrier_id')
        ->join('user_detail', 'voucher_history.user_id', '=', 'user_detail.user_id')
        // ->select('voucher_history.voucher_inc_id','carriers.carrier_name','user_detail.user_email','voucher_history_items.voucher_qty','voucher_history_items.voucher_total',
        //         'voucher_item.voucher_item_pin_number','voucher_history_items.created_at','voucher_history.transaction_key');
        ->select('voucher_history.voucher_inc_id','carriers.carrier_name','user_detail.user_email','voucher_history_items.voucher_total',DB::raw('COUNT(`voucher_history_items`.`voucher_qty`) as total_count'),DB::raw('SUM(voucher_history_items.voucher_total) AS total'),
        'voucher_history_items.created_at');
         if($user !=''){
            $voucher->where('voucher_history.user_id',$user);
        }
        return $voucher->whereBetween('voucher_history.created_at',[$from,$to])->groupBy('voucher_history_items.voucher_history_id','voucher_history_items.voucher_total')->orderBy('voucher_history.created_at')->get();
        
        // return $voucher->whereBetween('voucher_history.created_at',[$from,$to])->get();
     
    }
    
    
    static function getReloadlyAllDiscounts($id =''){
        $data =  DB::table("reloadly_discounts");
        if($id!='') $data->where('reloadly_discount_id',$id);
        return $data->orderBy('reloadly_discount_id','desc')->get();
    }
    
    static function getReloadlyAllCountry($id =''){
        $data =  DB::table("reloadly_all_countries");
        if($id!='') $data->where('reloadly_country_id',$id);
        return $data->orderBy('reloadly_country_id','desc')->get();
    }
    
    
    static function getReloadlyAllCountryOperatorsList(){
        $data =  DB::table("reloadly_country_operators")
        ->join('reloadly_all_countries', 'reloadly_country_operators.reloadly_country_countryId', '=', 'reloadly_all_countries.reloadly_country_id')
        ->select('reloadly_country_operators.*', 'reloadly_all_countries.reloadly_name', 'reloadly_all_countries.reloadly_iso_name');
        return $data->where('reloadly_country_operators.reloadly_country_pin',1)->orderBy('reloadly_country_operators.reloadly_country_operators_id','desc')->get();
    }
    
    
     static function getReloadlyAllCountryOperators($id =''){
        $data =  DB::table("reloadly_country_operators");
        if($id!='') $data->where('reloadly_country_operators_id',$id);
        return $data->orderBy('reloadly_country_operators_id','desc')->get();
    }
    
    static function getEpinVoucherReport($from,$to,$operator,$user){
        $voucher =  DB::table("epin_voucher_history")
        // ->join('reloadly_country_operators', 'epin_voucher_history.epin_voucher_history_operatorid', '=', 'reloadly_country_operators.reloadly_country_operatorId')
        ->join('user_detail', 'epin_voucher_history.epin_voucher_history_userid', '=', 'user_detail.user_id')
        ->select('epin_voucher_history.epin_voucher_history_orderid','epin_voucher_history.epin_voucher_history_type','epin_voucher_history.epin_voucher_history_operatorid','user_detail.user_email','epin_voucher_history.epin_voucher_history_amount',
        'epin_voucher_history.created_at');
        if($operator !=''){
            $voucher->where('epin_voucher_history.epin_voucher_history_operatorid',$operator);
        }
        if($user !=''){
            $voucher->where('epin_voucher_history.epin_voucher_history_userid',$user);
        }
        return $voucher->whereBetween('epin_voucher_history.created_at',[$from,$to])->orderBy('epin_voucher_history.created_at')->get();     
    }
    
     static function getReloadlyAllCountryOperatorsByIds($countryId,$operatorId){
        return DB::table("reloadly_country_operators")->where([['reloadly_country_countryId',$countryId],['reloadly_country_operatorId',$operatorId]])->get();
    }
    
    static function getReloadlyOperatorPriceExist($operatorId,$price){
        return DB::table("reloadly_operators_prices")->where([['reloadly_operators_prices_operatorId',$operatorId],['reloadly_operators_prices_price',$price]])->get();
    }
    
    static function getReloadlyOperatorLogoExist($operatorId,$logo){
        return DB::table("reloadly_operators_logo")->where([['reloadly_operators_logo_operator_id',$operatorId],['reloadly_operators_logo_url',$logo]])->get();
    }
    
     static function getReloadlyCountryByIsoName($isoName){
        return DB::table("reloadly_all_countries")->where('reloadly_iso_name',$isoName)->get();
    }
    
     static function getAllInternationalHistory($id =''){
        $data =  DB::table("epin_internationalvoucher_history")
        ->join('user_detail', 'epin_internationalvoucher_history.epin_voucher_history_userid', '=', 'user_detail.user_id')
        ->select('epin_internationalvoucher_history.*','user_detail.user_email');
        if($id!='') $data->where('epin_internationalvoucher_history.epin_voucher_id',$id);
        return $data->orderBy('epin_internationalvoucher_history.epin_voucher_id','desc')->get();
    }

    static function getAllInternationalHistoryByType($type){
        $data =  DB::table("epin_internationalvoucher_history")
        ->join('user_detail', 'epin_internationalvoucher_history.epin_voucher_history_userid', '=', 'user_detail.user_id')
        ->select('epin_internationalvoucher_history.*','user_detail.user_email');
        $data->where('epin_internationalvoucher_history.epin_voucher_history_type',$type);
        return $data->orderBy('epin_internationalvoucher_history.epin_voucher_id','desc')->get();
    }
    
    
    
    static function getAllInternationalHistoryReport($from,$to,$user,$type){
        $data =  DB::table("epin_internationalvoucher_history")
        ->join('user_detail', 'epin_internationalvoucher_history.epin_voucher_history_userid', '=', 'user_detail.user_id')
        ->select('epin_internationalvoucher_history.epin_voucher_history_orderid',
        'epin_internationalvoucher_history.epin_voucher_history_operatorid',
        'epin_internationalvoucher_history.epin_voucher_history_recipientphone',
        'epin_internationalvoucher_history.epin_voucher_history_type',
        'user_detail.user_email',
        'epin_internationalvoucher_history.epin_voucher_history_amount',
        'epin_internationalvoucher_history.created_at'
        );
        if($type!=''){
            $data->where('epin_internationalvoucher_history.epin_voucher_history_type',$type);
        }
         if($user !=''){
            $data->where('epin_internationalvoucher_history.epin_voucher_history_userid',$user);
        }
        return $data->whereBetween('epin_internationalvoucher_history.created_at',[$from,$to])->orderBy('epin_internationalvoucher_history.created_at')->get();

     
    }
    
    static function getDingConnectProviders($id =''){
        $data =  DB::table("dingconnect_providers");
        if($id!='') $data->where('dingconnect_provider_id',$id);
        return $data->orderBy('dingconnect_provider_id','desc')->get();
    }


    static function GetFlashNewsContent($id=""){
        $data =  DB::table("flashnews");
        if($id!='') $data->where('flashnews_id',$id);
        return $data->orderBy('flashnews_id','desc')->get();
    }

    static function GetUnlockCategory($id=""){
        $data =  DB::table("unlock_category");
        if($id!='') $data->where('unlock_category_id',$id);
        return $data->orderBy('unlock_category_id','desc')->get();
    }
    
    
     // Blogs Cateogory
    static function GetBlogsCategory($id=""){
        $data =  DB::connection('mysql2')->table("blogs_category");
        if($id!='') $data->where('blog_categoryId',$id);
        return $data->orderBy('blog_categoryId','desc')->get();
    }
    
    static function getBLShippingMethod($id=''){
        $data =  DB::table("blshipping_methods")->select("blshipping_methods.*",
            DB::raw("(SELECT admin_name FROM admin_details WHERE blshipping_created_by = admin_details.admin_id) as created_name"));
        if($id!='') $data->where('blshipping_id',$id);
        return $data->orderBy('blshipping_id','desc')->get();
    }

}
