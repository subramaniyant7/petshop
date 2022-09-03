<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;

function admintype(){
    return array('Root Admin','Super Admin','Sub Admin');
}

function productFor(){
    return array('Dog','Cat');
}

function productType(){
    return array('Gram');
}

function productDefault(){
    return array('Yes','No');
}

function userGender(){
    return array('Male','Female','Others');
}

function petGender(){
    return array('Male','Female');
}

function YesNo(){
    return array('Yes','No');
}

function acheiveWeight(){
    return array('Reduce Weight','Maintain Weight','Gain Weight');
}

function dogActivity(){
    return array('Sedentary','Normal','Active');
}

function catActivity(){
    return array('Indoor Cat','Outdoor Cat');
}

function userCity(){
    return array('Chennai');
}

function userState(){
    return array('Tamilnadu');
}

function userCountry(){
    return array('India');
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


function getAdminInfo($id){
    return DB::table('admin_details')->where('admin_id',$id)->get();
}

function breedInfoById($id){
    return DB::table('breeds_info')->where('breed_id',$id)->get();
}

function getProducts($id){
    return DB::table('products')->where('product_id',$id)->get();
}

function deliveryDays(){
    return ['Monday','Friday'];
}

function getUser($id){
    return DB::table('user_details')->where('user_id',$id)->get();
}

function getAddress($id){
    return DB::table('user_address')->where('user_id',$id)->get();
}

?>
