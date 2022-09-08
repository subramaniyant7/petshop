<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\admin\HelperController;
use App\Http\Controllers\frontend\FHelperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Storage;

class AdminController extends Controller
{

    public function AdminLogin(Request $req)
    {
        if ($req->admin_name != '' && $req->admin_password != '') {
            $isValidUser = DB::table('admin_details')->where([
                ['admin_name', $req->input('admin_name')],
                ['admin_password', md5(trim($req->admin_password))], ['status', 1]
            ])->get();
            if (count($isValidUser)) {
                $req->session()->put('admin_name', $isValidUser[0]->admin_name);
                $req->session()->put('admin_id', $isValidUser[0]->admin_id);
                $req->session()->put('admin_role', $isValidUser[0]->admin_role);
                return redirect(ADMINURL . '/dashboard');
            }
        }
        return back()->withInput()->with('error', 'Invalid Credentials');
    }

    public function Dashboard(Request $req)
    {
        return view('admin.dashboard');
    }

    public function ChangePassword(Request $req)
    {
        return view('admin.changepassword');
    }

    public function UpdatePassword(Request $request)
    {
        $formData = $request->except('_token');
        if ($formData['old_password'] == '' || $formData['new_password'] == '' || $formData['confirm_password'] == '') {
            return back()->with('error', 'Invalid action. Please try after some time');
        }
        if ($formData['new_password'] != $formData['confirm_password']) return back()->with('error', "New password and Confirm password doesn't matched");

        $adminId = decryption($request->admin_id);
        $adminData = HelperController::getAdminDetails($adminId);
        if (count($adminData)) {
            $admin = (array)$adminData[0];
            if ($admin['admin_password'] == md5($request->old_password)) {
                $admin['admin_password'] = md5($request->new_password);
                $update = updateQuery('admin_details', 'admin_id', $adminId, $admin);
                return redirect(ADMINURL . '/logout');
            }
            return back()->with('error', "Old password doesn't matched");
        }
        return back()->with('error', 'User not found');
    }


    public function ViewAdmin()
    {
        $adminDetails = HelperController::getAdminDetailsExceptLoggedIn();
        return view('admin.viewadmin', compact('adminDetails'));
    }

    public function ManageAdmin()
    {
        return view('admin.actionadmin');
    }

    public function ActionAdmin($option, $id)
    {
        $actionId = decryption($id);
        $adminData = HelperController::getAdminDetails($actionId);
        if (count($adminData) == 0) return redirect(ADMINURL . '/viewadmin');

        if ($option == 'delete') {
            $delete = deleteQuery($actionId, 'admin_details', 'admin_id');
            $notify = notification($delete);
            return redirect(ADMINURL . '/viewadmin')->with($notify['type'], 'Data Deleted Successfully');
        }
        return view('admin.actionadmin', ['action' => $option, 'data' => $adminData]);
    }

    public function SaveAdminDetails(Request $req)
    {
        $formData =  $req->except(['_token', 'admin_id']);
        if ($req->input('admin_id') == '') {
            $formData['admin_password'] = md5('root@123');
            $formData['admin_created_by'] =  $req->session()->get('admin_id');
            $saveData = insertQuery('admin_details', $formData);
        } else {
            $saveData = updateQuery('admin_details', 'admin_id', decryption($req->input('admin_id')), $formData);
        }
        $notify = notification($saveData);
        return redirect(ADMINURL . '/viewadmin')->with($notify['type'], $notify['msg']);
    }

    public function ViewUser()
    {
        $userDetails = HelperController::getAllusers();
        return view('admin.viewuser', compact('userDetails'));
    }

    public function ViewOrder()
    {
        $orders = HelperController::getAllOrders();
        return view('admin.vieworders', compact('orders'));
    }

    private function DateDifference($startdate, $enddate)
    {
        $date1 = date_create($startdate);
        $date2 = date_create($enddate);
        $diff = date_diff($date1, $date2);
        $totalDays = $diff->format("%a") + 1;
        return $totalDays;
    }

    public function ViewOrderDelivery()
    {
        $allorders = HelperController::getAllOrders();
        $totalDelivery = [];
        if (count($allorders)) {
            foreach ($allorders as $order) {
                $deliveryDate = $order->delivery_date;
                $deliveryMonth = date('m', strtotime($deliveryDate));
                if (date('m') == $deliveryMonth) {
                    $deliveryMonthLastDate = date("Y-m-t", strtotime($deliveryDate));
                    $perDay = $order->totalGramNeedtoBuy / $order->totalDays;
                    for ($l = 1; $l <= $order->totalDays; $l++) {
                        $updateDate = date('Y-m-d', strtotime('+' . $l . ' day', strtotime($deliveryDate)));
                        if ($this->DateDifference($updateDate, $deliveryMonthLastDate) != 1) {
                            $updateStamp = strtotime($updateDate);
                            $day = date('w', $updateStamp);
                            if ($day == 1 || $day == 4) {
                                $gram = $day == 1 ? $perDay * 3 : $perDay * 4;
                                array_push($totalDelivery, [
                                    'delivery' => $updateDate, 'day' => $day, 'gram' => $gram,
                                    'orderid' => $order->order_inc_id, 'user_id' => $order->user_id
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return view('admin.viewupcomingdelivery',compact('totalDelivery'));
        echo '<pre>';
        print_r($totalDelivery);

    }

    public function ViewOrderDetails($id)
    {
        $orderId = decryption($id);
        $orders = HelperController::getAllOrders($orderId);
        $orderProducts = HelperController::getOrderProducts($orderId);
        return view('admin.vieworderdetails', compact('orders', 'orderProducts'));
    }


    public function OrderSuccessEmail()
    {
        $orders = HelperController::getAllOrders(2);
        $orderProducts = HelperController::getOrderProducts(2);
        $address = getAddress($orders[0]->user_id);
        $data = ['address' => $address, 'orders' => $orders, 'orderProducts' => $orderProducts];

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('frontend.invoice', ['data' => $data])->setPaper('a4', 'landscape');

        return $pdf->stream();
    }


    public function OrderInvoiceDownload($id)
    {
        $invoiceName = 'invoice_' . decryption($id);
        $pdfName = 'public/order/' . $invoiceName . '.pdf';
        $fileName = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $pdfName;
        $newName = $invoiceName . '.pdf';

        $headers = [
            'Content-type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="test.pdf"',
        ];
        return response()->download($fileName, $newName, $headers);
    }






    public function ViewProduct()
    {
        $productDetails = HelperController::getProductDetails();
        return view('admin.viewproduct', compact('productDetails'));
    }


    public function ManageProduct()
    {
        return view('admin.actionproduct');
    }

    public function ActionProduct($option, $id)
    {
        $actionId = decryption($id);
        $productData = HelperController::getProductDetails($actionId);
        if (count($productData) == 0) return redirect(ADMINURL . '/viewproduct');

        if ($option == 'delete') {
            $delete = deleteQuery($actionId, 'products', 'product_id');
            $notify = notification($delete);
            return redirect(ADMINURL . '/viewproduct')->with($notify['type'], 'Data Deleted Successfully');
        }
        return view('admin.actionproduct', ['action' => $option, 'data' => $productData]);
    }

    public function SaveProductDetails(Request $req)
    {
        $formData =  $req->except(['_token', 'product_id', 'edit_productimage']);



        if ($req->hasFile('product_image')) {
            $file = $req->file('product_image');
            $destinationPath = public_path('uploads/products');
            $fileName = $file->getClientOriginalName();
            $fileExtension = explode('.', $fileName);
            if (
                strtolower(end($fileExtension)) != 'png' && strtolower(end($fileExtension)) != 'jpeg' &&  strtolower(end($fileExtension)) != 'jpg'
                && strtolower(end($fileExtension)) != 'webp'
            ) {
                return redirect()->back()->withInput()->with('error', 'Please upload the valid image!');
            }
            $file->move($destinationPath, $fileName);
            $formData['product_image'] = $fileName;
        } else {
            $formData['product_image'] =  $req->input('edit_productimage');
        }
        if ($req->input('product_id') == '') {
            if ($formData['product_default'] == 1) {
                $checkDefaultExist = HelperController::getDefaultExist($formData['product_for']);
                if (count($checkDefaultExist)) return back()->with('error', 'Already default option mapped with some other product');
            }
            $saveData = insertQuery('products', $formData);
        } else {
            $productId = decryption($req->input('product_id'));
            if ($formData['product_default'] == 1) {
                $checkDefaultExist = HelperController::getDefaultExist($formData['product_for'], $productId);
                if (count($checkDefaultExist)) return back()->with('error', 'Already default option mapped with some other product');
            }
            $saveData = updateQuery('products', 'product_id', $productId, $formData);
        }
        $notify = notification($saveData);
        return redirect(ADMINURL . '/viewproduct')->with($notify['type'], $notify['msg']);
    }


    public function AdminLogout(Request $req)
    {
        $req->session()->forget('admin_name');
        $req->session()->forget('admin_id');
        $req->session()->forget('admin_role');
        return redirect(ADMINURL);
    }
}
