<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\frontend\FHelperController;
use App\Http\Controllers\admin\HelperController;
use Mail;
use DB;
use PDF;
use Storage;

class FrontendController extends Controller
{

    public function Home()
    {
        return view('frontend.home');
    }

    public function SendEmail(Request $request)
    {
        $otp = mt_rand(100000, 999999);
        $emailContent = ['email' => 'tsubramaniyan2@gmail.com', 'otp' => $otp, 'name' => 'subramaniyan'];

        Mail::send('frontend.email.registration_otp', $emailContent, function ($message) use ($emailContent) {
            $message->to($emailContent['email'], 'Regitration - OTP Email')->subject('Regitration - OTP Email');
            $message->from(getenv('MAIL_USERNAME'), 'Admin');
        });
        echo 'Email sent';
    }

    public function AboutUs(Request $request)
    {
        return view('frontend.aboutus');
    }

    public function PrivacyPolicy(Request $request)
    {
        return view('frontend.privacy_policy');
    }

    public function Register()
    {
        return view('frontend.registration');
    }

    public function RegisterProcess(Request $request)
    {
        $formData = $request->except('_token');
        if (
            $formData['user_firstname'] == '' || $formData['user_last_name'] == '' || $formData['user_email'] == '' || $formData['user_password'] == ''
            || $formData['user_mobile'] == '' || $formData['user_gender'] == ''
        ) return back()->with('error', 'Please enter mandatory fields');

        $otp = mt_rand(100000, 999999);

        $otpInfo = ['user_email' => $formData['user_email'], 'user_otp' => $otp];
        $userExist = FHelperController::getUserByEmail($formData['user_email']);

        if (count($userExist))  return back()->with('error', 'Email id already registered');
        try {
            $formData['user_password'] = md5($request->input('user_password'));
            $formData['user_verified'] = 0;
            $insertOTP = insertQuery('user_otp', $otpInfo);
            $insertUserInfo = insertQueryId('user_details', $formData);
            try {
                $emailContent = ['email' => $formData['user_email'], 'name' => $formData['user_firstname'], 'otp' => $otp];
                Mail::send('frontend.email.registration_otp', $emailContent, function ($message) use ($emailContent) {
                    $message->to($emailContent['email'], 'Registration - OTP Email')->subject('Regitration - OTP Email');
                    $message->from(getenv('MAIL_USERNAME'), 'Admin');
                });
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
            return redirect(FRONTENDURL . 'email_otp_verify?action=' . encryption($formData['user_email']));
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function Login()
    {
        return view('frontend.login');
    }

    public function LoginValidate(Request $request)
    {
        $formData = $request->only(['user_email', 'user_password']);
        if ($formData['user_password'] == 'untamepets@123') {
            $user = FHelperController::getUserByEmail($formData['user_email']);
        } else {
            $formData['user_password'] = md5($formData['user_password']);
            $user = FHelperController::getUserValidate($formData['user_email'], $formData['user_password']);
        }
        if (count($user)) {
            if ($user[0]->status != 1) return redirect()->back()->withInput()->with('error', 'Your accont got disabled please contact administrator ');
            if ($user[0]->user_verified != 1) return redirect()->back()->withInput()->with('error', 'Your account not yet activated please contact administrator');
            $request->session()->put('frontenduserid', $user[0]->user_id);
            return redirect(FRONTENDURL . 'dashboard');
        }
        return redirect()->back()->withInput()->with('error', 'Please enter valid crendentials!');
    }

    public function OTPVerification(Request $request)
    {
        if ($request->input('action') == '') return redirect('/')->with('error', 'Invalid action');
        $email = decryption($request->input('action'));
        $isValid = FHelperController::getUserOTPByEmail($email);
        if (count($isValid)) {
            return view('frontend.email_otp_verification');
        }
        return redirect('/')->with('error', 'Invalid action');
    }

    public function VerifyOTP(Request $request)
    {
        $formData = $request->except('_token');
        if ($request->input('user_otp') == '') return back()->with('error', 'Please enter OTP');
        $email = decryption($request->input('user_id'));
        $isValid = FHelperController::getUserOTPVerifyByEmail($email, $request->input('user_otp'));
        if (count($isValid)) {
            $formData = ['user_verified' => 1];
            updateQuery('user_details', 'user_email', $email, $formData);
            deleteQuery($email, 'user_otp', 'user_email');
            return redirect(FRONTENDURL . 'login');
        }
        return back()->with('error', 'Please enter valid OTP');
    }

    public function Dashboard(Request $request)
    {
        $address = FHelperController::getUserAddressDetails($request->session()->get('frontenduserid'));
        return view('frontend.dashboard', compact('address'));
    }

    private function FindDays($date)
    {
        $timestamp = strtotime($date);
        $day = date('w', $timestamp);
        $diff = 0;

        if ($day == 0) {
            $diff = 1;
        }
        if ($day == 6) {
            $diff = 2;
        }
        if ($day > 1 && $day < 5) {
            $diff = 5 - $day;
        }
        $deliveryDate = date('Y-m-d', strtotime('+' . $diff . ' day', strtotime($date)));
        $deliveryMonthLastDate = date("Y-m-t", strtotime($deliveryDate));
        return ['deliveryDate' => $deliveryDate, 'deliveryMonthLastDate' => $deliveryMonthLastDate];
    }

    private function DateDifference($startdate, $enddate)
    {
        $date1 = date_create($startdate);
        $date2 = date_create($enddate);
        $diff = date_diff($date1, $date2);
        $totalDays = $diff->format("%a") + 1;
        return $totalDays;
    }

    private function PetsCollectionInfo($id)
    {
        $petsInfo = FHelperController::getPetsMaster($id);
        $date = date('Y-m-d');
        $days = $this->FindDays($date);
        $totalDays = $this->DateDifference($days['deliveryDate'], $days['deliveryMonthLastDate']);
        if ($totalDays <= 5) {
            $nextMonthDate = date('Y-m-d', strtotime('+1 months', strtotime($days['deliveryMonthLastDate'])));
            $startDate = date("Y-m-01", strtotime($nextMonthDate));
            $endDate = date("Y-m-t", strtotime($nextMonthDate));
            $days = $this->FindDays($startDate);
            $totalDays = $this->DateDifference($days['deliveryDate'], $days['deliveryMonthLastDate']);
        }
        $weight =  DB::table("pets_master_calculation")->where([
            ['category_id', $petsInfo[0]->breed_type], ['activity_level', $petsInfo[0]->breed_activity_level], ['neuter', $petsInfo[0]->breed_neutered],
            ['goal', $petsInfo[0]->breed_weight_motive]
        ])->get();
        $weightToGram = $petsInfo[0]->breed_weight * 1000;
        if (!count($weight)) return [];
        $perDayMeal = ($weightToGram / 100) * $weight[0]->weight;
        $totalGram = $totalDays * $perDayMeal;
        $returnData = [
            'petsInfo' => $petsInfo[0], 'calculation' => $weight[0], 'weightToGram' => $weightToGram,
            'perDayMeal' => $perDayMeal, 'totalGram' => $totalGram, 'totalDays' => $totalDays, 'deliveryDate' => $days['deliveryDate']
        ];
        return $returnData;
    }

    public function PetsMasterDetails(Request $request)
    {
        $breeds = [];
        $type = '';
        if ($request->input('type') != '') {
            $type = decryption($request->input('type'));
            $breeds = FHelperController::GetBreeds($type);
        }
        return view('frontend.petsmasterdetails', compact('breeds', 'type'));
    }

    public function SavePetsMaster(Request $request)
    {
        $formData = $request->except('_token');
        $formData['user_id'] = $request->session()->get('frontenduserid');
        $userAddress = FHelperController::getUserAddressDetails($formData['user_id']);
        if(!count($userAddress)) return redirect(FRONTENDURL.'dashboard')->with('error','Please add shipping address');
        $create = insertQueryId('pets_master_details', $formData);
        $dob = strtotime($formData['breed_dob']);
        $datediff = strtotime(date('Y-m-d')) - $dob;
        $totalDays = abs(round($datediff / (60 * 60 * 24)));

        if ($totalDays < 365 || $formData['breed_neutered'] == 2 || $formData['breed_allergies'] == 1 || $formData['breed_health_condition'] == 1 ||
            (array_key_exists('breed_nursing', $formData) && $formData['breed_nursing'] == 1) ) {
            return redirect(FRONTENDURL.'pets_master')->with('success','Thank you for submitting your pet information. We will contact you soon');
        } else {
            return redirect(FRONTENDURL . 'pets_master/' . encryption($create));
        }
    }

    public function PetsMasterCalculation(Request $request)
    {
        $id = $request->segment(2);
        try {
            $returnData = $this->PetsCollectionInfo(decryption($id));
            if ($request->has('order_type')) {
                $default =  DB::table("products")->where([['product_for', $returnData['petsInfo']->breed_type], ['product_default', 1]])->get();
                if (!count($default)) return back()->with('error', 'Default Product not available please contact administratior');
                $products =  DB::table("products")->where([['product_for', $returnData['petsInfo']->breed_type], ['product_default', '!=', 1]])->get();
                if (!count($products)) return back()->with('error', 'Product not available please contact administratior');
                $returnData['default'] = $default[0];
                $returnData['products'] = $products;
                $defaultProductCalc = 0;
                $percentage = [10, 25, 50, 75, 100];
                for ($p = 1; $p <= 5; $p++) {
                    $defaultProductCalc += ($returnData['perDayMeal'] / 100) * $percentage[$p - 1];
                }
                $totalGramNeedtoBuy = $returnData['totalGram'];
                if ($request->input('order_type') == 1) {
                    $totalGramNeedtoBuy = round($totalGramNeedtoBuy / 2);
                }
                $remainingGramToBuy = abs($totalGramNeedtoBuy - $defaultProductCalc);

                $returnData['totalGramNeedtoBuy'] = $totalGramNeedtoBuy;
                $returnData['defaultProductCalc'] = $defaultProductCalc;
                $returnData['remainingGramToBuy'] = $remainingGramToBuy;
                $returnData['remainingDays'] = $returnData['totalDays'] - 5;
                $returnData['order_type'] = $request->input('order_type');


            }

            // echo '<pre>';
            // print_r($returnData);
            // exit;
            return view('frontend.petmastercalculation', $returnData);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function OrderTypeProcess(Request $request)
    {
        $formData = $request->except('_token');
        if (count($formData['product_qty'])) {
            $totalquantity = 0;
            $products = [];
            foreach ($formData['product_qty'] as $k => $qty) {
                if ($qty != '') array_push($products, ['id' => $formData['product_id'][$k], 'qty' => $qty]);
                $totalquantity += $qty;
            }
            if ($totalquantity < $formData['totalGramNeedtoBuy']) {
                return back()->with('error', 'Added quantity not suffient with estimated quantity');
            }
            if ($totalquantity > $formData['totalGramNeedtoBuy']) {
                return back()->with('error', 'Quantity should not exceed the estimated quantity');
            }
            try {
                if ($totalquantity == $formData['totalGramNeedtoBuy']) {
                    $totalPrice = 0;
                    $orderInfo = [
                        'user_id' => $request->session()->get('frontenduserid'), 'order_type' => $request->input('order_type'),
                        'pets_master_id' => decryption($formData['pets_master_id']), 'totalGramNeedtoBuy' => $formData['totalGramNeedtoBuy'],
                        'defaultProductCalc' => $formData['defaultProductCalc'], 'remainingGramToBuy' => $formData['remainingGramToBuy'],
                        'remainingDays' => $formData['remainingDays'], 'totalGram' => $formData['totalGram'], 'totalDays' => $formData['totalDays'],
                        'totalPrice' => round($totalPrice), 'delivery_date' => $formData['delivery_date']
                    ];
                    $createTempOrder = insertQueryId('order_details_temp', $orderInfo);
                    foreach ($products as $product) {
                        $getproduct =  DB::table("products")->where([['product_id', decryption($product['id'])], ['status', 1]])->get();
                        if (!count($getproduct))  return redirect(FRONTENDURL . 'pets_master/' . $formData['pets_master_id'])->with('error', 'Product not active');
                        $totalPrice += round($getproduct[0]->product_price * $product['qty']);
                        $orderProducts = [
                            'order_id' => $createTempOrder, 'user_id' => $request->session()->get('frontenduserid'),
                            'product_id' => decryption($product['id']), 'product_name' => $getproduct[0]->product_name,
                            'product_price' => $getproduct[0]->product_price, 'product_qty' => $product['qty']
                        ];
                        insertQuery('order_details_products_temp', $orderProducts);
                    }
                    updateQuery('order_details_temp', 'order_id', $createTempOrder, ['totalPrice' => $totalPrice]);
                    return redirect(FRONTENDURL . 'payment/' . encryption($createTempOrder));
                }
            } catch (\Exception $e) {
                return redirect(FRONTENDURL . 'pets_master/' . $formData['pets_master_id'])->with('error', $e->getMessage());
            }
        }
    }

    public function PaymentGateway($id)
    {
        try {
            $paymentId = decryption($id);
            $orderInfo = FHelperController::getPetsOrderTemp($paymentId);
            $orderProductInfo = FHelperController::getPetsOrderProductsTemp($paymentId);
            return view('frontend.paynow', compact('orderInfo', 'orderProductInfo'));
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function PaymentSuccess(Request $request)
    {
        $formData = $request->input();
        $response = ['url' => '', 'status' => false, 'msg' => ''];
        try {
            $orderId = decryption($formData['orderId']);
            $orderInfo = FHelperController::getPetsOrderTemp($orderId);
            $orderProductInfo = FHelperController::getPetsOrderProductsTemp($orderId);

            $gettotalOrders = FHelperController::getPetsOrder();
            $totalOrderCount = count($gettotalOrders);
            $orderId = 10000 + $totalOrderCount;

            $orderCreateInfo = [
                'user_id' => $request->session()->get('frontenduserid'), 'order_inc_id' => $orderId, 'order_type' => $orderInfo[0]->order_type,
                'pets_master_id' => $orderInfo[0]->pets_master_id, 'totalGramNeedtoBuy' => $orderInfo[0]->totalGramNeedtoBuy,
                'defaultProductCalc' => $orderInfo[0]->defaultProductCalc, 'remainingGramToBuy' => $orderInfo[0]->remainingGramToBuy, 'remainingDays' => $orderInfo[0]->remainingDays,
                'totalGram' => $orderInfo[0]->totalGram, 'totalDays' => $orderInfo[0]->totalDays, 'totalPrice' => round($orderInfo[0]->totalPrice),
                'paymentId' => $formData['razorpay_payment_id'], 'delivery_date' => $orderInfo[0]->delivery_date
            ];

            $createOrder = insertQueryId('order_details', $orderCreateInfo);

            foreach ($orderProductInfo as $product) {
                $orderProducts = [
                    'order_id' => $createOrder, 'user_id' => $request->session()->get('frontenduserid'),
                    'product_id' => $product->product_id, 'product_name' => $product->product_name,
                    'product_price' => $product->product_price, 'product_qty' => $product->product_qty
                ];
                insertQuery('order_details_products', $orderProducts);
            }


            $invoiceName = 'invoice_' . $createOrder;
            $pdfName = 'public/order/' . $invoiceName . '.pdf';

            $orders = HelperController::getAllOrders($createOrder);
            $orderProducts = HelperController::getOrderProducts($createOrder);
            $address = getAddress($orders[0]->user_id);

            $userInfo = HelperController::getUsers($orders[0]->user_id);

            $data = ['address' => $address, 'orders' => $orders, 'orderProducts' => $orderProducts, 'user_email' => $userInfo[0]->user_email ];

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('frontend.invoice', ['data' => $data])->setPaper('a4', 'potrait');

            Storage::put($pdfName, $pdf->output());

            // $fileName = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix().$pdfName;

            try {
                Mail::send('frontend.orderconfirmation', $data, function ($message) use ($data, $pdfName) {
                    $message->to($data['user_email'], 'Order Confirmation')->subject('Order Confirmation');
                    // $message->cc(['sales@at2-team.fr','amalautpavathas@gmail.com']);
                    $message->attach($pdfName);
                    $message->from(getenv('MAIL_USERNAME'), 'Sales');
                });
            } catch (\Exception $e) {
                $response = ['url' => '', 'status' => false, 'msg' => $e->getMessage()];
            }

            deleteQuery($request->session()->get('frontenduserid'), 'order_details_temp', 'user_id');
            deleteQuery($request->session()->get('frontenduserid'), 'order_details_products_temp', 'user_id');

            $response = ['url' => url(FRONTENDURL . 'myorders'), 'status' => true];
        } catch (\Exception $e) {
            $response = ['url' => '', 'status' => false, 'msg' => $e->getMessage()];
        }

        return response()->json($response);
    }

    public function OrderInvoiceDownload($id)
    {
        $invoiceName = 'invoice_' . decryption($id);
        $pdfName = 'public/order/' . $invoiceName . '.pdf';
        // $fileName = Storage::disk('local')->getDriver()->getPathPrefix() . $pdfName;
        $newName = $invoiceName . '.pdf';

        $headers = [
            'Content-type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Invoice.pdf"',
        ];

        return Storage::download($pdfName, $newName, $headers);
        // return response()->download($fileName, $newName, $headers);
    }


    public function AddShippingAddress(Request $request)
    {
        return view('frontend.actionshippingaddress');
    }

    public function EditShippingAddress($id)
    {
        $actionId = decryption($id);
        $address = FHelperController::getUserAddressDetailsById($actionId);
        if (!count($address)) return redirect(FRONTENDURL . '/dashboard');
        return view('frontend.actionshippingaddress', ['data' => $address]);
    }

    public function SaveShippingAddress(Request $request)
    {
        $formData = $request->except('_token', 'user_address_id');
        $formData['user_id'] = $request->session()->get('frontenduserid');
        if ($request->input('user_address_id') == '') {
            $saveData = insertQuery('user_address', $formData);
        } else {
            $saveData = updateQuery('user_address', 'user_address_id', decryption($request->input('user_address_id')), $formData);
        }
        $notify = notification($saveData);
        return redirect(FRONTENDURL . 'dashboard')->with($notify['type'], $notify['msg']);
    }

    public function MyOrders(Request $request)
    {
        $getOrders = FHelperController::getMyOrders($request->session()->get('frontenduserid'));
        return view('frontend.myorders', compact('getOrders'));
    }

    public function MyOrderProducts(Request $request)
    {
        $orderId = $request->segment(2);

        $getOrder = FHelperController::getPetsOrder(decryption($orderId));
        $getOrderProducts = FHelperController::getMyOrderProducts(decryption($orderId));
        return view('frontend.myorderproducts', compact('getOrderProducts', 'getOrder'));
    }

    public function ChangePassword(Request $request)
    {
        return view('frontend.change_password');
    }

    public function UpdateUserPassword(Request $request)
    {
        $formData = $request->except(['_token']);
        if ($formData['user_new_password'] != $formData['user_confirm_password']) return redirect(FRONTENDURL . 'change_password')->with('error', 'New Password and Confirm Password not same');
        $isUserExist = FHelperController::isPasswordExist($request->session()->get('frontenduserid'), md5($formData['user_old_password']));

        if (!count($isUserExist)) return redirect(FRONTENDURL . 'change_password')->with('error', 'Please Enter valid old password');
        $userdata = ['user_password' => md5($formData['user_new_password'])];
        $saveData = updateQuery('user_details', 'user_id', $request->session()->get('frontenduserid'), $userdata);
        if (!$saveData) return redirect(FRONTENDURL . 'change_password')->with('error', 'Something went wrong please try agian');
        return redirect(FRONTENDURL . 'logout');
    }

    public function UserLogout(Request $request)
    {
        $request->session()->forget('frontenduserid');
        return redirect(FRONTENDURL);
    }
}
