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












    static function getClientGalleryAssets($galleryId)
    {
        $data['images'] = DB::table("clients_gallery_images")->where('clients_gallery_images_galleryid', $galleryId)->get();
        $data['videos'] = DB::table("clients_gallery_videos")->where('clients_gallery_videos_galleryid', $galleryId)->get();
        return $data;
    }

    static function getClientsCategory()
    {
        DB::statement("SET SQL_MODE=''");
        $data =  DB::table("category_details")
            ->join('client_details', 'category_details.category_id', '=', 'client_details.client_category')
            ->join('clients_gallery', 'category_details.category_id', '=', 'clients_gallery.clients_gallery_category')
            ->select('category_details.*', 'client_details.*', 'clients_gallery.*')
            ->where([['category_details.status', 1], ['client_details.status', 1], ['clients_gallery.status', 1]]);
        return $data->groupBy(['category_details.category_id'])->get();
    }

    static function getClients()
    {
        $data =  DB::table("client_details")
            ->join('clients_gallery', 'client_details.client_id', '=', 'clients_gallery.clients_gallery_client')
            ->join('category_details', 'client_details.client_category', '=', 'category_details.category_id')
            ->select('client_details.*')
            ->where([['client_details.status', 1], ['clients_gallery.status', 1], ['category_details.status', 1]]);
        return $data->get();
    }

    static function getRelatedClients($id)
    {
        $data =  DB::table("client_details")
            ->join('clients_gallery', 'client_details.client_id', '=', 'clients_gallery.clients_gallery_client')
            ->select('client_details.*')
            ->where('client_details.client_id', '!=', $id);
        return $data->inRandomOrder()->take(2)->get();
    }

    static function getDocCategory()
    {
        DB::statement("SET SQL_MODE=''");
        $data =  DB::table("doc_category")
            ->join('documents', 'doc_category.doc_category_id', '=', 'documents.document_category')
            ->select('doc_category.*')
            ->where('doc_category.status', 1);
        return $data->groupBy('doc_category.doc_category_id')->get();
    }

    static function getCategoryDocument($categoryId)
    {
        return DB::table("documents")->where('document_category', $categoryId)->get();
    }
}
