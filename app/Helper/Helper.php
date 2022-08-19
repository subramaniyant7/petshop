<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

function admintype(){
    return array('Root Admin','Super Admin','Sub Admin');
}


function getImeiByTypeId($id=''){
    return DB::table("unlock_imeilist")->where('service_type_id',$id)->get();
}
function getAllNewsletters($id=''){
    $user = DB::connection('mysql2')->table('newsletter');
    if($id!='')  $user->where('newsletter_id', $id);
    return $user->orderBy('newsletter_id','desc')->get();
}

function unlockImeiList(){
    return array('gsm_father'=>'GSM Father','gsm_genisis'=>'GSM Genisis','blc_technology'=>'BL Technology');
}
// function getAllActiveNewsletters(){
//     return DB::connection('mysql2')->table('newsletter')->where('status', 1)->orderBy('newsletter_id','desc')->get();
// }

function getAllActiveNewsletters(){
    return DB::connection('mysql2')->table('newsletter')->where('status', 1)->groupBy('newsletter_category')->orderBy('newsletter_id','desc')->get();
}


function imeiLockStatus(){
    return array('0'=>'New', '1'=>'InProcess','3'=>'Reject(Refund)','4'=>'Available(Success)');
}

function getConfig(){
    return DB::table('unlock_config')->where('config_id', 2)->get();
}

function unlockConfig(){
    return array('GSM Father','Easy Unlock');
}

function productAttribute(){
    return array('UOM');
}

function importtype(){
    return array('Admin','Menu','Category','Sub-Category','Location','Users','Products','Currency Symbols');
}

function userGender(){
    return array('Male','Female','Others');
}

function producttype(){
    return array('Simple Product','Configurabole Product');
}

function statustype(){
    return array('Active','De-Active');
}

function verifiedStatus(){
    return array('Activate','De-Activate');
}

function getActiveRecord($table){
    return DB::table($table)->where('status', 1)->get();
}

function getRecordData($table,$condition){
    return DB::table($table)->where($condition)->get();
}

function validEmail($str) {
    return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
}

function validMobile($number){
    return (!preg_match("/^[0-9][0-9]{9}$/", $number)) ?  false : true;
}

function validNumeric($number){
    return (!is_numeric($number)) ? false : true;
}

function getPaymentMethods($id=''){
    $data =  DB::table("payment_methods");
    if($id!='') $data->where('payment_id',$id);
    return $data->orderBy('payment_id','desc')->get();
}

function getShippingMethods($id=''){
    $data =  DB::table("shipping_methods");
    if($id!='') $data->where('shipping_id',$id);
    return $data->orderBy('shipping_id','desc')->get();
}

function isInvoiceExist($orderId){
    return DB::table("invoice_history")->where('invoice_order_id',$orderId)->get();
}

function orderStatus(){
    return ['Pending','Paid','Accepted','Ready for Shipping','Shipped','Delivered','Cancelled'];
}

function encryption($string,$root=''){
    if($root!='' && Session::get('admin_name') == 'root') return $string;
    return Crypt::encryptString($string);
}

function decryption($string,$root=''){
    if($root!='' && Session::get('admin_name') == 'root') return $string;
    return Crypt::decryptString($string);
}

function insertQuery($table,$data){
    $data['status'] = 1;
    $data['created_at'] = date('Y-m-d h:i:s', time());
    $data['updated_at'] = date('Y-m-d h:i:s', time());
    try{
        return DB::table($table)->insert($data);
    }catch(Exception $e){
        print_r($e->getMessage());
        exit;
        return false;
    }
}

function insertQueryId($table,$data){
    $data['status'] = 1;
    $data['created_at'] = date('Y-m-d h:i:s', time());
    $data['updated_at'] = date('Y-m-d h:i:s', time());
    try{
        return DB::table($table)->insertGetId($data);
    }catch(Exception $e){
        print_r($e->getMessage());
        exit;
        return false;
    }
}

function updateQuery($table,$match,$id,$data){
    try{
        $data['updated_at'] =  date('Y-m-d h:i:s', time());;
        $update = DB::table($table)->where($match, $id)->update($data);
        return true;
    }catch(Exception $e){
        print_r($e->getMessage());
        exit;
        return false;
    }
}

function deleteQuery($id,$table,$field){
    return  DB::table($table)->where($field, $id)->delete();
}

function notification($type= false){
    if($type){
        return ['type'=>'success','msg'=>'Data Saved Succesfully'];
    }
    return ['type'=>'error','msg'=>'Something went wrong... please try again'];
}

function getSubcategoryByCategory($categoryid){
   return DB::table("sub_category")->where('sub_category_id',$categoryid)->orderBy('sub_category_id','desc')->get();
}

function getCategory($id){
    return DB::table('category')->where('category_id',$id)->get();
}

function getBrandsByCategory($category){
    return DB::table('brands')->where('category_id',$category)->get();
}

function getBrands($id){
    return DB::table('brands')->where('brand_id',$id)->get();
}

function getSubcategoryByBrand($brandid){
    return DB::table('sub_category')->where('sub_brand_id',$brandid)->get();
}

function getSubcategory($id){
    return DB::table('sub_category')->where('subcategory_id',$id)->get();
}

function getDealsProducts(){
    return DB::table('product_details')->where('product_discount', '!=', '')->get();
}

function getAllProducts(){
    return DB::table('product_details')->where('status',1)->get();
}

function getAllProduct($id){
    return DB::table('product_details')->where('product_id',$id)->get();
}

function getProductImages($id){
    return DB::table('product_images')->where('product_id',$id)->get();
}

function getStoreProduct($productId,$userId){
    return DB::table("store_products")->where([['store_user_product_id',$productId],['store_user_id',$userId],['status',1]])->get();
}

function getUserInfo($id){
    return DB::table('user_detail')->where('user_id',$id)->get();
}

function getCartItems($userId){
    $cart = DB::table('cart_items')->where('user_id', $userId)->get();
    if(count($cart) ==0) return ['cart'=>[],'products'=>[]];
    $cartProduct = DB::table('cart_products')->where([['cart_id',$cart[0]->cart_id],['user_id', $userId]])->get();
    return ['cart'=>$cart, 'products'=>$cartProduct];
}

function getVoucherItems($userId){
    $cart = DB::table("voucher_cart")->where([['status',1],['voucher_cart_customer_id', $userId]])->get();
    $items =  DB::table("voucher_cart")
    ->join('voucher_purchase', 'voucher_cart.voucher_cart_id', '=', 'voucher_purchase.voucher_purchase_cart_id')
    ->join('vouchers', 'voucher_purchase.voucher_purchase_voucher_id', '=', 'vouchers.voucher_id')
    ->join('carriers', 'vouchers.voucher_carrier', '=', 'carriers.carrier_id')
    ->select('voucher_purchase.*', 'vouchers.voucher_carrier', 'carriers.carrier_name', 'carriers.carrier_logo')
    ->where([['voucher_purchase.status',1],['voucher_purchase.voucher_purchase_customer_id', $userId]])->get();
    return ['cart'=>$cart, 'items'=>$items];
}

function getVocherPinStatus($voucherId){
    return DB::table("voucher_item")->where([['voucher_item_voucher_id',$voucherId],['voucher_item_purchased',0],['status',1]])->get();
}


function getVoucherCount($voucher_item_carrier_id,$voucher_item_voucher_id){
    return DB::table("voucher_item")->where([['voucher_item_carrier_id',$voucher_item_carrier_id],['voucher_item_voucher_id',$voucher_item_voucher_id],
        ['voucher_item_purchased',0],['status',1]])->get();
}



function getAdminInfo($id){
    return DB::table('admin_details')->where('admin_id',$id)->get();
}

function getCarrier($id){
    return DB::table('carriers')->where('carrier_id',$id)->get();
}

function getReloadlyOperatorLogoByOperatorId($id){
    return  DB::table("reloadly_operators_logo")->where('reloadly_operators_logo_operator_id',$id)->get();
}

function getReloadlyCountry($id){
    return  DB::table("reloadly_all_countries")->where('reloadly_country_id',$id)->get();
}

function getEpinVoucherItems($userId){
    $cart = DB::table("epin_cart")->where('epin_cart_userid', $userId)->get();
    $items =  DB::table("epin_cart")
    ->join('epin_cart_items', 'epin_cart.epin_cart_id', '=', 'epin_cart_items.epin_cart_cartid')
    ->join('reloadly_country_operators', 'epin_cart_items.epin_cart_operatorid', '=', 'reloadly_country_operators.reloadly_country_operators_id')
    ->select('epin_cart_items.*', 'reloadly_country_operators.reloadly_country_name', 'reloadly_country_operators.reloadly_country_customamount')
    ->where('epin_cart.epin_cart_userid', $userId)->get();
    return ['cart'=>$cart,'items'=>$items];
}

function GetReloadlyUrl(){
    $url = RELOADLY_BASE;
    if(RELOADLY_TEST_MODE){
        $url = RELOADLY_TEST_AUDIENCE;
    }
    return $url;
}

function getOperatorsInfo($operatorId){
    return DB::table("reloadly_country_operators")->where('reloadly_country_operators_id',$operatorId)->get();
}

function getOperatorsInfoByISO($iso){
    return DB::table("reloadly_country_operators")->where('reloadly_country_countryIso',$iso)->get();
}

function GetDingConnectCountry($id){
  return DB::table("ding_connect_country")->where('dcountry_id',$id)->get();
}

function GetDingConnectProviderProductById($id){
    return DB::table("ding_connect_provider_products")->where('dproduct_id',$id)->get();
}

function GetDingConnectProviderById($id){
    return DB::table("ding_connect_provider")->where('dprovider_id',$id)->get();
}

function PinConfig(){
    return array('EPIN(Reloadly)','DPIN(Dingconnect)');
}


function userOrders(){
    return DB::table('order_history')->where('user_id',session()->get('frontenduserid'))->orderBy('order_id','desc')->get(); 
}

function userImeiOrders(){
    return DB::table("gsmimei_history")->where('gsm_lock_service_userid',session()->get('frontenduserid'))->orderBy('gsm_history_id','desc')->get();
}

function userInfo(){
    return DB::table("user_detail")->where('user_id',session()->get('frontenduserid'))->get();
}

function getSearchActiveNewsletters($key){
    return DB::connection('mysql2')->table('newsletter')->where([['status', 1],['newsletter_title', 'like', '%'.$key.'%'],['newsletter_category',$categoryId]])
    ->orWhere('newsletter_content', 'like', '%'.$key.'%')->orderBy('newsletter_id','desc')->get();
}

function GetFlashNewsContent(){
    $data =  DB::table("flashnews");
    return $data->orderBy('flashnews_id','desc')->get();
}

function GetUnlockCategory($id){
    return DB::table("unlock_category")->where('unlock_category_id',$id)->get();
}



// BLStore
function GetBLUserCart($userId){
    $cart = DB::table('blcart')->where('blcart_userid', $userId)->get();
    if(count($cart) ==0) return ['cart'=>[],'products'=>[]];
    $cartProduct = DB::table('blcart_products')->where('blcart_id',$cart[0]->blcart_id)->get();
    return ['cart'=>$cart, 'products'=>$cartProduct];
}

function GetBLStoreProducts($id){
    return DB::table("blproducts")->where('blproduct_id',$id)->get();
}

function isBLInvoiceExist($orderId){
    return DB::table("blinvoice_history")->where('blinvoice_order_id',$orderId)->get();
}

function BLInvoiceInfo($orderId){
    return DB::table("blpayment_history")->where('blpayment_order_id',$orderId)->get();
}


function insertQuery2($table,$data){
    $data['status'] = 1;
    $data['created_at'] = date('Y-m-d h:i:s', time());
    $data['updated_at'] = date('Y-m-d h:i:s', time());
    try{
        return DB::connection('mysql2')->table($table)->insert($data);
    }catch(Exception $e){
        print_r($e->getMessage());
        exit;
        return false;
    }
}

function insertQueryId2($table,$data){
    $data['status'] = 1;
    $data['created_at'] = date('Y-m-d h:i:s', time());
    $data['updated_at'] = date('Y-m-d h:i:s', time());
    try{
        return DB::connection('mysql2')->table($table)->insertGetId($data);
    }catch(Exception $e){
        print_r($e->getMessage());
        exit;
        return false;
    }
}

function updateQuery2($table,$match,$id,$data){
    try{
        $data['updated_at'] =  date('Y-m-d h:i:s', time());;
        $update = DB::connection('mysql2')->table($table)->where($match, $id)->update($data);
        return true;
    }catch(Exception $e){
        print_r($e->getMessage());
        exit;
        return false;
    }
}

function deleteQuery2($id,$table,$field){
    return  DB::connection('mysql2')->table($table)->where($field, $id)->delete();
}


// Blogs Catgory
function getBlogCategory($id=''){
    $user = DB::connection('mysql2')->table('blogs_category');
    if($id!='')  $user->where('blog_categoryId', $id);
    return $user->orderBy('blog_categoryId','desc')->get();
}

function getBlogByCategoryId($categoryId){
    return DB::connection('mysql2')->table('newsletter')->where([['status', 1],['newsletter_category',$categoryId]])->orderBy('newsletter_id','desc')->get();
}

function getActiveRecord2($table){
    return DB::connection('mysql2')->table($table)->where('status', 1)->get();
}

function GetBLShippingMethod($id){
    return DB::table("blshipping_methods")->where('blshipping_id',$id)->get();
}

?>
