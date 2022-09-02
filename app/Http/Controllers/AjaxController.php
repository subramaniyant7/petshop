<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AjaxController extends Controller
{
    public function GetBreeds(Request $request)
    {
        $type = $request->input('breedType');
        $url = '';
        if ($type == '') return response()->json(['status' => false]);
        $data =  DB::table("breeds_info")->where([['breed_type', $type], ['status', 1]])->get();
        if (count($data)) $url = url(FRONTENDURL . 'pets_master?type=' . encryption($type));
        return response()->json(['data' => $data, 'status' => true, 'action' => $url]);
    }

    public function GetOrderProducts(Request $request)
    {
        $formData = $request->except('_token');
        $status = false;
        $html = '';
        try {
            $data =  DB::table("products")->where([['product_for', decryption($formData['breed_type'])], ['product_default', '!=', 1]])->get();
            print_r($request->input());
        } catch (\Exception $e) {
        }
        return response()->json(['data' => $html, 'status' => $status]);
    }
}
