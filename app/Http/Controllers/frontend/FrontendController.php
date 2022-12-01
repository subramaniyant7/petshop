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

    public function ContactUs(Request $request)
    {
        $formData = $request->except('_token');
        if ($formData['name'] == '' || $formData['email'] == '' ||  $formData['content'] == '') return back()->with('error', 'Please enter all mandatory fields');
        try {
            Mail::send('frontend.email.contactus', $formData, function ($message) use ($formData) {
                $message->to('leadgen@untame.pet', 'Admin')->subject('Website Enquiry');
                $message->from(getenv('MAIL_USERNAME'), 'Admin');
            });
            return redirect(FRONTENDURL)->with('success', "Thank you for contacting us, we'll get back to you soon!");
        } catch (\Exception $e) {
            return redirect(FRONTENDURL)->with('error', $e->getMessage());
        }
    }

    public function AboutUs(Request $request)
    {
        return view('frontend.aboutus');
    }

    public function Products(Request $request)
    {
        return view('frontend.products');
    }

    public function FAQ(Request $request)
    {
        return view('frontend.faq');
    }

    public function PrivacyPolicy(Request $request)
    {
        return view('frontend.privacy_policy');
    }

    public function Disclaimer(Request $request)
    {
        return view('frontend.disclaimer');
    }

    public function Register()
    {
        return view('frontend.registration');
    }

    public function RegisterProcess(Request $request)
    {
        $formData = $request->except('_token');
        if (
            $formData['user_firstname'] == '' || $formData['user_email'] == '' || $formData['user_password'] == ''
            || $formData['user_mobile'] == ''
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
                // Mail::send('frontend.email.registration_otp', $emailContent, function ($message) use ($emailContent) {
                Mail::send('frontend.email.otp_template', $emailContent, function ($message) use ($emailContent) {
                    $message->to($emailContent['email'], 'Registration - OTP Email')->subject('Regitration - OTP Email');
                    $message->from(getenv('MAIL_USERNAME'), 'Admin');
                });
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
            return redirect(FRONTENDURL . 'email_otp_verify?action=' . encryption($formData['user_email']))->with('success', 'We have Sent OTP to registered email.Please check and enter OTP here. Note: Please check spam and junk folder');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function Login()
    {
        return view('frontend.login');
    }

    public function ForgotPassword(){
        return view('frontend.forgot_password');
    }

    private function CreateRandomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public function HandleForgotPassword(Request $request){
        if($request->input('user_email') != ''){
            $checkUserExist = FHelperController::getUserByEmail($request->input('user_email'));
            if(count($checkUserExist)){
                $newPassword = $this->CreateRandomPassword();
                try{
                    $emailContent = ['email' => $checkUserExist[0]->user_email, 'password' => $newPassword];
                    Mail::send('frontend.email.forgot_password', $emailContent, function ($message) use ($emailContent) {
                        $message->to($emailContent['email'], 'Account - New Password')->subject('Account - New Password');
                        $message->from(getenv('MAIL_USERNAME'), 'Admin');
                    });
                }
                catch(\Exception $e){
                    return back()->with('error','Something went wrong');
                }
                updateQuery('user_details','user_id',$checkUserExist[0]->user_id,['user_password' => md5($newPassword)]);
                return redirect(FRONTENDURL.'login')->with('success','We have sent new password to your email. Please check your email and Junk/Spam folder also');
            }
            return back()->with('error', 'Invalid Email');
        }
        return back()->with('error', 'Invalid action');
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

            try {
                $emailContent = ['email' => $email];
                // Mail::send('frontend.email.registration_otp', $emailContent, function ($message) use ($emailContent) {
                Mail::send('frontend.email.accountcreation_success', $emailContent, function ($message) use ($emailContent) {
                    $message->to($emailContent['email'], 'Account Creation')->subject('Registration Success');
                    $message->from(getenv('MAIL_USERNAME'), 'Admin');
                });
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }

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
            $diff = 2;
        }
        if ($day == 6) {
            $diff = 3;
        }
        if ($day > 1 && $day < 5) {
            $diff = 5 - $day;
        }
        if($day == 1){
            $diff = 4;
        }
        if($day == 4){
            $diff = 5;
        }
        if($day == 5){
            $diff = 4;
        }
        // echo 'date'.$date.'<br>';
        // echo 'diff'.$diff.'<br>';
        // echo 'day'.$day;
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
        // $date = '2022-12-08';
        $days = $this->FindDays($date);

        $diff = $this->DateDifference($date, $days['deliveryDate']) - 1;

        // echo '<pre>';
        $monthEnd = false;
        if ($diff <= 2) {
            $deliveryData = $this->CurrentMonthAllDelivery();
            $totalDelivery = count($deliveryData);
            $nextDelivery = '';
            foreach ($deliveryData as $k => $delivery) {
                if (($delivery == $days['deliveryDate']) && ($k + 1 == $totalDelivery)) {
                    $monthEnd = true;
                }
                if (($delivery == $days['deliveryDate']) && ($k + 1 != $totalDelivery)) {
                    // echo 'Index:'.$k.'<br>';
                    $nextDelivery = $deliveryData[$k + 1];
                    break;
                }
            }

            if ($nextDelivery != '') {
                $totalDays = $this->DateDifference($nextDelivery, $days['deliveryMonthLastDate']);
                if ($totalDays <= 5) {
                    $monthEnd = true;
                }
                // echo 'totalDays:'.$totalDays.'<br>';
            }
        }



        // $totalDays = $this->DateDifference($days['deliveryDate'], $days['deliveryMonthLastDate']) - 1;
        $totalDays = $this->DateDifference($days['deliveryDate'], $days['deliveryMonthLastDate']);

        // echo '<pre>';
        // print_r($days);
        // exit;
        if ($totalDays <= 5 || $monthEnd) {


            $nextMonthDate = date('Y-m-d', strtotime('+1 months', strtotime($days['deliveryMonthLastDate'])));
            $startDate = date("Y-m-01", strtotime($nextMonthDate));
            $endDate = date("Y-m-t", strtotime($nextMonthDate));
            $days = $this->FindDays($startDate);
            $totalDays = $this->DateDifference($days['deliveryDate'], $days['deliveryMonthLastDate']);
        }

        // exit;
        $weight =  DB::table("pets_master_calculation")->where([
            ['category_id', $petsInfo[0]->breed_type], ['activity_level', $petsInfo[0]->breed_activity_level], ['neuter', $petsInfo[0]->breed_neutered],
            ['goal', $petsInfo[0]->breed_weight_motive]
        ])->get();
        $weightToGram = $petsInfo[0]->breed_weight * 1000;
        if (!count($weight)) return [];
        $perDayMeal = ($weightToGram / 100) * $weight[0]->weight;
        $totalGram = ($totalDays - 5) * $perDayMeal;
        $returnData = [
            'petsInfo' => $petsInfo[0], 'calculation' => $weight[0], 'weightToGram' => $weightToGram,
            'perDayMeal' => $perDayMeal, 'totalGram' => $totalGram, 'totalDays' => $totalDays, 'deliveryDate' => $days['deliveryDate']
        ];
        return $returnData;
    }

    public function UpcomingDelivery(Request $request)
    {
        $userId = $request->session()->get('frontenduserid');
        $totalDelivery = FHelperController::getMyDelivery($userId);
        return view('frontend.mydelivery', compact('totalDelivery'));
    }

    private function CurrentMonthAllDelivery()
    {
        $currentMonthStartDate = date('Y-m-01');
        $deliveryMonthLastDate = date("Y-m-t", strtotime($currentMonthStartDate));
        $limit = date('t');
        $totalDeliveryofMonth = [];
        for ($t = 0; $t < $limit; $t++) {
            $updateDate = date('Y-m-d', strtotime('+' . $t . ' day', strtotime($currentMonthStartDate)));


            if ($this->DateDifference($updateDate, $deliveryMonthLastDate)) {
                $updateStamp = strtotime($updateDate);
                $day = date('w', $updateStamp);
                if ($day == 2 || $day == 5) {
                    array_push($totalDeliveryofMonth, $updateDate);
                }
            }
        }
        return $totalDeliveryofMonth;
    }

    private function CurrentMonthDelivery($deliveryDate)
    {
        $currentMonthStartDate = date('Y-m-01');
        $deliveryMonthLastDate = date("Y-m-t", strtotime($currentMonthStartDate));
        $limit = date('t');
        $totalDeliveryofMonthFromDelivery = [];
        $totalDeliveryofMonth = [];
        for ($t = 0; $t < $limit; $t++) {
            $updateDate = date('Y-m-d', strtotime('+' . $t . ' day', strtotime($currentMonthStartDate)));
            $dateDiff = $this->DateDifference($updateDate, $deliveryMonthLastDate);

            if ($dateDiff > 5) {
                // echo 'Date-----: ' . $dateDiff . '<br>';
                if (strtotime($updateDate) >= strtotime($deliveryDate)) {
                    $updateStamp = strtotime($updateDate);
                    $day = date('w', $updateStamp);
                    if ($day == 2 || $day == 5) {
                        array_push($totalDeliveryofMonthFromDelivery, $updateDate);
                    }
                }
                if (strtotime($updateDate) >= strtotime(date('Y-m-d'))) {
                    $updateStamp = strtotime($updateDate);
                    $day = date('w', $updateStamp);
                    if ($day == 2 || $day == 5) {
                        array_push($totalDeliveryofMonth, $updateDate);
                    }
                }
            }
        }
        return ['totaldeliveryfromdeliverydate' => $totalDeliveryofMonthFromDelivery, 'totaldeliveryfromtoday' => $totalDeliveryofMonth];
    }

    private function TotalDelivery($startdate)
    {
        $currentMonthStartDate = date('Y-m-01', strtotime($startdate));
        $deliveryMonthLastDate = date("Y-m-t", strtotime($currentMonthStartDate));
        $limit = date('t');
        $totalDeliveryofMonthFromDelivery = [];
        $totalDeliveryofMonth = [];
        for ($t = 0; $t < $limit; $t++) {
            $updateDate = date('Y-m-d', strtotime('+' . $t . ' day', strtotime($currentMonthStartDate)));
            $dateDiff = $this->DateDifference($updateDate, $deliveryMonthLastDate);

            if ($dateDiff > 2) {
                // echo 'Date-----: ' . $dateDiff . '<br>';
                if (strtotime($updateDate) >= strtotime(date('Y-m-d'))) {
                    $updateStamp = strtotime($updateDate);
                    $day = date('w', $updateStamp);
                    if ($day == 2 || $day == 5) {
                        array_push($totalDeliveryofMonth, $updateDate);
                    }
                }
            }
        }
        return ['totaldeliveryfromdeliverydate' => $totalDeliveryofMonthFromDelivery, 'totaldeliveryfromtoday' => $totalDeliveryofMonth];
    }

    public function UpcomingDeliveryProduct($id)
    {
        $orderId = decryption($id);

        $productInfo = FHelperController::getMyDeliveryProduct($orderId);

        // echo '<pre>';
        // print_r($productInfo);
        // exit;

        return view('frontend.mydeliveryproducts', compact('productInfo'));


        $orderInfo = FHelperController::getPetsOrder($orderId);
        $orderProducts = FHelperController::getMyOrderProductsAsc($orderId);
        $thisMonthDeliveryDate = $this->CurrentMonthDelivery($orderInfo[0]->delivery_date);

        // echo '<pre>';
        // print_r($orderInfo);
        // print_r($orderProducts);
        $staterProduct = $orderProducts[0];
        $staterProductTotalQty = $staterProduct->product_qty;
        $percentage = [10, 25, 50, 75, 100];
        $finalGram = 0;
        $finalArray = [];
        for ($e = 0; $e < 5; $e++) {
            $updatedQty = $staterProductTotalQty - $finalGram;
            $actualGram = round(($updatedQty * $percentage[$e]) / 100);
            array_push($finalArray, $actualGram);
            $finalGram += $actualGram;
        }

        $productsArray = [];
        foreach ($orderProducts as $k => $products) {
            if ($k > 0) {
                array_push($productsArray, [
                    'product_id' => $products->product_id, 'actual_qty' => $products->product_qty,
                    'perday_qty' => round($products->product_qty / $orderInfo[0]->remainingDays)
                ]);
            }
        }

        // print_r($finalGram);
        // print_r($finalArray);
        // print_r($productsArray);
        // exit;
        // print_r($thisMonthDeliveryDate['totaldeliveryfromdeliverydate']);
        foreach ($thisMonthDeliveryDate['totaldeliveryfromdeliverydate'] as $k => $totalDelivery) {

            $deliveryInfo = [
                'order_id' => $orderId, 'user_id' => $orderInfo[0]->order_id, 'perday_meal' => $orderInfo[0]->perDayMeal,
                'total_days' => $orderInfo[0]->totalDays, 'total_gram' => $orderInfo[0]->totalGram, 'delivery_date' => $totalDelivery
            ];

            // echo 'Delivery Info:' . '<br>';
            // print_r($deliveryInfo);
            // echo '<br>';

            $createDeliveryInfo = insertQueryId('deliveryinfo', $deliveryInfo);
            // $createDeliveryInfo = 1;

            // echo 'Delivery Date:' . $totalDelivery . '<br>';
            //     // foreach ($orderProducts as $products) {
            $timestamp = strtotime($totalDelivery);
            $day = date('w', $timestamp);
            $daysInterval = $day == 2 ? 4 : 3;
            $startupProductProcessedDays = 0;
            // echo 'Delivery Day:' . $day . '<br>';
            if ($k == 0) {
                //         // echo 'Loop:---------<br><br>';


                $start = 1;
                $totalGram = $actualGram = 0;
                //         $percentage = [10, 25, 50, 75, 100];
                //         $totalQty = $orderProducts[$k]->product_qty;
                for ($p = 1; $p <= $daysInterval; $p++) {

                    $totalGram += $finalArray[$p - 1];
                    //             $totalQty = $p == 1 ? $totalQty : $totalQty - $totalGram;
                    //             // echo 'Qty : '.$totalQty.'<br>';
                    //             // echo 'TotalGram : '.$totalGram.'<br>';
                    //             // echo 'Diff : '.$totalQty.'<br>';
                    //             // echo 'Percentage : '.$percentage[$p - 1].'<br>';

                    //             $totalGram = ($totalQty * $percentage[$p - 1]) / 100;
                    //             $actualGram += $totalGram;
                    //             // echo 'AterGram : '.$totalGram.'<br>';
                    //             // echo 'ActualGram : '.$actualGram.'<br><br>';

                }
                $startupProductProcessedDays = $daysInterval;

                $deliveryInfoProducts = [
                    'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                    'product_id' => $orderProducts[$k]->product_id, 'product_name' => $orderProducts[$k]->product_name,
                    'days_interval' => $daysInterval, 'actual_product_gram' => $orderProducts[$k]->product_qty,
                    'product_gram' => round($totalGram)
                ];


                // echo 'Starter Product Start---------------: ' . $k . ':' . '<br>';
                // print_r($deliveryInfoProducts);
                // echo 'Starter Product End---------------: ' . $k . ':' . '<br><br>';
                insertQuery('deliveryinfo_products', $deliveryInfoProducts);
                //         // break;
            }
            if ($k == 1) {
                $limit = $day != 2 ? 3 : 4;

                $starterInterval =  $day == 2 ? 4 : 5;

                $other = $day == 2 ? 3 : 4;
                $processDays = 5 - $other + 1;
                $remainingDays =  $starterInterval - $daysInterval;
                $totalGram1 = $actualGram = 0;

                // echo '$daysInterval' . $daysInterval . '<br>';
                // echo '$processDays' . $processDays . '<br>';
                // echo '$other' . $other . '<br>';
                // echo '$limit' . $limit . '<br>';
                // echo '$remainingDays' . $remainingDays . '<br>';
                //         $percentage = [10, 25, 50, 75, 100];
                //         $totalQty = $orderProducts[$k - 1]->product_qty - $deliveryInfoProducts['product_gram'];
                for ($p = $starterInterval; $p <= 5; $p++) {
                    $totalGram1 += $finalArray[$p - 1];
                    //             echo 'Looooooooop' . $day . '<br>';
                    //             // echo 'Qty : ' . $totalQty . '<br>';
                    //             // echo 'Percentage : ' . $percentage[$other-1] . '<br>';
                    //             // echo 'Minus : ' . ($orderProducts[$k-1]->product_qty * $percentage[$other-1]) /100 . '<br>';
                    //             $totalQty =  $totalQty - $totalGram;

                    //             echo 'TotalGram : ' . $totalGram . '<br>';
                    //             echo 'Diff : ' . $totalQty . '<br>';
                    //             echo 'Percentage : ' . $percentage[$p - 1] . '<br>';

                    //             $percentageCalc = ($totalQty * $percentage[$p - 1]) / 100;

                    //             $totalGram += $percentageCalc;
                    //             //  $actualGram += $totalGram;
                    //             // if($p != 5) $actualGram += $totalGram;
                    //             // else $actualGram = $totalGram;

                    //             echo 'percentageCalc: ' . $percentageCalc . '<br>';
                    //             echo 'totalGram: ' . $totalGram . '<br>';
                    //             echo 'actualGram: ' . $actualGram . '<br><br>';


                    //             // insertQuery('deliveryinfo_products', $deliveryInfoProducts);

                }

                $deliveryInfoProducts1 = [
                    'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                    'product_id' => $orderProducts[$k - 1]->product_id, 'product_name' => $orderProducts[$k - 1]->product_name,
                    'days_interval' => $starterInterval == 5 ? 1 : 5 - $starterInterval, 'actual_product_gram' => $orderProducts[$k - 1]->product_qty,
                    'product_gram' => round($totalGram1)
                ];
                insertQuery('deliveryinfo_products', $deliveryInfoProducts1);
                //             echo 'Delivery Info Products Loop: ' . $k . ':' . '<br>';
                // echo 'Starter Product Start---------------: ' . $k . ':' . '<br>';
                // print_r($deliveryInfoProducts1);
                // echo 'Starter Product End---------------: ' . $k . ':' . '<br><br>';

                //         echo 'Calc:' . $actualGram . '<br><br>';
                //         echo 'Calc:' . $totalGram . '<br><br>';
                //         echo 'Remaining:' . $remainingDays.'<br>';

                // for($d=1;$d<=$remainingDays;$d++){


                //         $totalArray = [];
                for ($e = 0; $e < count($orderProducts); $e++) {
                    if ($e > 0) {
                        //                 $productGram = $orderProducts[$e]->product_qty;
                        //                 $productGramPerDay = round($productGram / $orderInfo[0]->remainingDays);
                        //                 $productGramDays = $remainingDays * $productGramPerDay;
                        //                 echo 'Gram:' . $productGram . '<br>';
                        //                 echo 'PerDay:' . $productGramPerDay . '<br>';
                        //                 echo 'PerDay1:' . $productGramDays . '<br>';
                        $perDayProductQty = $orderProducts[$e]->product_qty / $orderInfo[0]->remainingDays;
                        $deliveryInfoProducts2 = [
                            'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                            'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,
                            'days_interval' => $daysInterval - 1, 'actual_product_gram' => $orderProducts[$e]->product_qty,
                            'product_gram' => round($perDayProductQty * $remainingDays)
                        ];

                        insertQuery('deliveryinfo_products', $deliveryInfoProducts2);
                        //                 // array_push($totalArray, $deliveryInfoProducts2);

                        //                 // echo 'Delivery Info Products Loope-------: ' . $e . ':' . '<br>';
                        // echo 'Remaining Product Start---------------: ' . $k . ':' . '<br>';
                        // print_r($deliveryInfoProducts2);
                        // echo 'Remaining Product End---------------: ' . $k . ':' . '<br><br>';
                    }
                }

                //         // echo 'Total Array_-------------';
                //         // print_r($totalArray);
                //         // }

                //         // break;
            }

            if ($k > 1) {
                for ($e = 0; $e < count($orderProducts); $e++) {
                    if ($e > 0) {
                        //                 $productGram = $orderProducts[$e]->product_qty;
                        //                 $productGramPerDay = round($productGram / $orderInfo[0]->remainingDays);
                        //                 $productGramDays = $remainingDays * $productGramPerDay;
                        //                 echo 'Gram:' . $productGram . '<br>';
                        //                 echo 'PerDay:' . $productGramPerDay . '<br>';
                        //                 echo 'PerDay1:' . $productGramDays . '<br>';
                        $perDayProductQty = $orderProducts[$e]->product_qty / $orderInfo[0]->remainingDays;
                        $deliveryInfoProducts2 = [
                            'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                            'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,
                            'days_interval' => $daysInterval, 'actual_product_gram' => $orderProducts[$e]->product_qty,
                            'product_gram' => round($perDayProductQty * $daysInterval)
                        ];

                        insertQuery('deliveryinfo_products', $deliveryInfoProducts2);
                        //                 // array_push($totalArray, $deliveryInfoProducts2);

                        //                 // echo 'Delivery Info Products Loope-------: ' . $e . ':' . '<br>';
                        // echo 'Remaining Product Start---------------: ' . $k . ':' . '<br>';
                        // print_r($deliveryInfoProducts2);
                        // echo 'Remaining Product End---------------: ' . $k . ':' . '<br><br>';
                    }
                }
            }
            //     // }
        }


        // $deliveryDifference = count($thisMonthDeliveryDate['totaldeliveryfromdeliverydate']) - count($thisMonthDeliveryDate['totaldeliveryfromtoday']);

        // $products = [];

        // if($deliveryDifference == 0){
        //     $percentage = [10, 25, 50, 75, 100];
        //     // for ($p = 1; $p <= 5; $p++) {
        //     //     $defaultProductCalc = ($returnData['perDayMeal'] / 100) * $percentage[$p - 1];
        //     // }
        //     $products = ['product_name' => $orderProducts[0]->product_name.'(Starter Pack)'];
        // }


        // echo '<pre>';
        // // echo $orderId . '<br>';
        // print_r($thisMonthDeliveryDate);
        // print_r($orderInfo);
        // print_r($orderProducts);
    }

    public function PetsMasterDetails(Request $request)
    {

        $userAddress = FHelperController::getUserAddressDetails($request->session()->get('frontenduserid'));
        if (!count($userAddress)) return redirect(FRONTENDURL . 'dashboard')->with('error', 'Please add shipping address');
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
        if (!count($userAddress)) return redirect(FRONTENDURL . 'dashboard')->with('error', 'Please add shipping address');
        $create = insertQueryId('pets_master_details', $formData);
        $dob = strtotime($formData['breed_dob']);
        $datediff = strtotime(date('Y-m-d')) - $dob;
        $totalDays = abs(round($datediff / (60 * 60 * 24)));
        // $formData['breed_neutered'] == 2
        if (
            $totalDays < 365 ||  $formData['breed_allergies'] == 1 || $formData['breed_health_condition'] == 1 ||
            (array_key_exists('breed_nursing', $formData) && $formData['breed_nursing'] == 1)
        ) {
            try {
                $userInfo =  getUser($request->session()->get('frontenduserid'));
                $formData['breed_type'] = productFor()[$formData['breed_type'] - 1];
                $formData['breed_name'] = $formData['breed_name'] == 0 ? $formData['breed_text'] : breedInfoById($formData['breed_name'])[0]->breed_name;
                $formData['pet_name'] = $formData['pet_name'];
                $formData['breed_gender'] = petGender()[$formData['breed_gender'] - 1];
                $formData['breed_activity_level'] = $formData['breed_activity_level'] == 1 ? dogActivity()[$formData['breed_activity_level'] - 1] : catActivity()[$formData['breed_activity_level'] - 1];
                $formData['breed_freedom_level'] = isset($formData['breed_freedom_level']) ? catActivity()[$formData['breed_freedom_level'] - 1] : '';
                $formData['breed_neutered'] = YesNo()[$formData['breed_neutered'] - 1];
                $formData['breed_weight_motive'] = acheiveWeight()[$formData['breed_weight_motive'] - 1];
                $formData['breed_allergies'] = YesNo()[$formData['breed_allergies'] - 1];
                $formData['breed_allergies_info'] = isset($formData['breed_allergies_info']) ? $formData['breed_allergies_info'] : '';
                $formData['breed_health_condition'] = YesNo()[$formData['breed_health_condition'] - 1];
                $formData['breed_health_condition_info'] = isset($formData['breed_health_condition_info']) ? $formData['breed_health_condition_info'] : '';
                $formData['breed_nursing'] = isset($formData['breed_nursing']) ? YesNo()[$formData['breed_nursing'] - 1] : '';
                $formData['breed_nursing_info'] = isset($formData['breed_nursing_info']) ? $formData['breed_nursing_info'] : '';
                $formData['user_email'] = $userInfo[0]->user_email . ' / ' . $userInfo[0]->user_mobile;

                Mail::send('frontend.email.petsmastercontact', $formData, function ($message) {
                    $message->to('woof@untame.pet', 'Admin')->subject('Pet Master Contact Info');
                    $message->from(getenv('MAIL_USERNAME'), 'Admin');
                });
                return redirect(FRONTENDURL . 'pets_master')->with('success', 'Thank you for submitting your pet information. We will contact you soon');
            } catch (\Exception $e) {
                return redirect(FRONTENDURL . 'pets_master')->with('error', $e->getMessage());
            }
        } else {
            return redirect(FRONTENDURL . 'pets_master/' . encryption($create));
        }
    }

    public function UpcomingDue(Request $request)
    {
        $dateDiff = date("t") - date('d');
        $totalDays = 0;
        $userOrders = [];
        $dueOrders = [];
        if (date('d') > 25) {
            $userOrders = FHelperController::getUpcomingDue($request->session()->get('frontenduserid'));
            $nextMonthDate = date('Y-m-d', strtotime('+1 months', strtotime(date('Y-m-d'))));
            $startDate = date("Y-m-01", strtotime($nextMonthDate));
            $endDate = date("Y-m-t", strtotime($nextMonthDate));
            $totalDays = date('t', strtotime($startDate));
            $dueOrders = getOrderDueByUser($request->session()->get('frontenduserid'));
        }

        // echo '<pre>';
        // print_r($userOrders);
        // print_r($totalDays);
        // print_r($dueOrders);
        // exit;
        return view('frontend.myupcomingdue', compact('userOrders', 'totalDays', 'dueOrders'));
    }

    public function ProcessDue(Request $request)
    {
        $dueInfo = $request->except('_token');
        $orderInfo = FHelperController::getPetsOrder($dueInfo['orderId']);
        $orderProducts = FHelperController::getMyOrderProducts($dueInfo['orderId']);
        $productsInfo = array();
        $total = 0;
        $totalgram = 0;
        foreach ($orderProducts as $k => $products) {
            $productData = FHelperController::getProducts($products->product_id);
            if (count($productData) && $productData[0]->product_default != 1) {
                $qty = number_format($products->product_qty / $dueInfo['remainingDays'], 2);
                $totalGram = $qty * $dueInfo['totalDays'];
                $price = number_format(($productData[0]->product_price * $totalGram), 2);
                $total += $productData[0]->product_price * $totalGram;
                $totalgram += $totalGram;
                array_push($productsInfo, [
                    'productId' => $products->product_id, 'productQty' => $totalGram,
                    'product_price' => $price
                ]);
            }
        }
        $nextMonthDate = date('Y-m-d', strtotime('+1 months', strtotime(date('Y-m-d'))));
        $totalDelivery = $this->TotalDelivery($nextMonthDate);

        $orderInfo = [
            'user_id' => $request->session()->get('frontenduserid'), 'order_type' => 2,
            'pets_master_id' => $orderInfo[0]->pets_master_id, 'totalGramNeedtoBuy' => $totalgram,
            'defaultProductCalc' => 0, 'remainingGramToBuy' => $totalgram, 'remainingDays' => $dueInfo['totalDays'], 'totalGram' => $totalgram, 'totalDays' => $dueInfo['totalDays'],
            'totalPrice' => round($total), 'delivery_date' => $totalDelivery['totaldeliveryfromtoday'][0], 'perDayMeal' => $dueInfo['perDay'], 'orderProcessType' => 2,
            'parent_id' => $dueInfo['orderId']
        ];

        $createTempOrder = insertQueryId('order_details_temp', $orderInfo);
        foreach ($productsInfo as $product) {
            $getproduct =  DB::table("products")->where([['product_id', $product['productId']], ['status', 1]])->get();
            if (!count($getproduct))  return redirect(FRONTENDURL . 'upcoming_due')->with('error', 'Product not active');
            $orderProducts = [
                'order_id' => $createTempOrder, 'user_id' => $request->session()->get('frontenduserid'),
                'product_id' => $product['productId'], 'product_name' => $getproduct[0]->product_name,
                'product_price' => $getproduct[0]->product_price, 'product_qty' => $product['productQty']
            ];
            insertQuery('order_details_products_temp', $orderProducts);
        }
        // updateQuery('order_details_temp', 'order_id', $createTempOrder, ['totalPrice' => $totalPrice]);
        return redirect(FRONTENDURL . 'payment/' . encryption($createTempOrder));
    }

    public function PetsMasterCalculation(Request $request)
    {
        $id = $request->segment(2);
        // echo '<pre>';
        try {
            $returnData = $this->PetsCollectionInfo(decryption($id));
            // print_r($returnData);
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
                $remainingGramToBuy = abs($totalGramNeedtoBuy);
                // $remainingGramToBuy = abs($totalGramNeedtoBuy - $defaultProductCalc);

                $returnData['totalGramNeedtoBuy'] = $totalGramNeedtoBuy;
                $returnData['defaultProductCalc'] = $defaultProductCalc;
                $returnData['remainingGramToBuy'] = $remainingGramToBuy;
                $returnData['remainingDays'] = $returnData['totalDays'] - 5;
                $returnData['order_type'] = $request->input('order_type');
            }

            // echo '<pre>';
            // print_r($returnData);
            // exit;
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
                $qty = $qty;
                if ($k != 0) {
                    $qty = $qty * 1000;
                    $totalquantity += $qty;
                }
                if ($qty != '') array_push($products, ['id' => $formData['product_id'][$k], 'qty' => $qty]);
            }
            if ($totalquantity < $formData['totalGramNeedtoBuy']) {
                return back()->with('error', 'Added quantity not sufficient with estimated quantity');
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
                        'totalPrice' => round($totalPrice), 'delivery_date' => $formData['delivery_date'], 'perDayMeal' => $formData['perDayMeal'],
                        'parent_id' => 0
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

    private function getUserDetails($userId)
    {
        $userInfo = FHelperController::getUserDetails($userId);
        return array(
            "customerName" => $userInfo[0]->user_firstname,
            "customerEmail" => $userInfo[0]->user_email,
            "customerPhone" => $userInfo[0]->user_mobile
        );
    }

    private function getOrderDetails()
    {
        return array(
            "orderNote" => "Final Order",
            "orderCurrency" => "INR"
        );
    }

    private function generateSignature($postData)
    {
        $secretKey = env('PAYMENT_MODE') == 1 ? env('PAYMENT_LIVE_APP_KEY') : env('PAYMENT_TEST_APP_KEY');
        ksort($postData);
        $signatureData = "";
        foreach ($postData as $key => $value) {
            $signatureData .= $key . $value;
        }
        $signature = hash_hmac('sha256', $signatureData, $secretKey, true);
        $signature = base64_encode($signature);
        return $signature;
    }

    public function PaymentProcess(Request $request)
    {
        $orderId = $request->input('order_id');

        $orderAmount =  $request->input('total');
        $orderDetails = array();
        $userDetails = $this->getUserDetails($request->session()->get('frontenduserid'));
        $order = $this->getOrderDetails();
        $notifyUrl = FRONTENDURL . 'paymentnotify';
        $returnUrl = FRONTENDURL . 'paymentprocessed';
        $orderDetails["notifyUrl"] = $notifyUrl;
        $orderDetails["returnUrl"] = $returnUrl;
        $orderDetails["customerName"] = $userDetails["customerName"];
        $orderDetails["customerEmail"] = $userDetails["customerEmail"];
        $orderDetails["customerPhone"] = $userDetails["customerPhone"];

        $orderDetails["orderId"] = $orderId . '-' . $request->session()->get('frontenduserid') . '-' . $request->input('gst') .
            '-' . $request->input('subtotal');
        $orderDetails["orderAmount"] = $orderAmount;
        $orderDetails["orderNote"] = $order["orderNote"];
        $orderDetails["orderCurrency"] = $order["orderCurrency"];
        $orderDetails['orderTags'] = '123';
        $orderDetails["appId"] = env('PAYMENT_MODE') == 1 ? env('PAYMENT_LIVE_APP_ID') : env('PAYMENT_TEST_APP_ID');

        $orderDetails["signature"] = $this->generateSignature($orderDetails);

        $request->session()->put('frontenduserid', 1);
        $request->session()->put('gst', $request->input('gst'));
        $request->session()->put('subtotal', $request->input('subtotal'));

        return view('frontend.paymentprocess', compact('orderDetails'));
    }

    public function PaymentProcessed(Request $request)
    {
        $response = $request->input();
        $orderData = explode('-', $response['orderId']);
        // echo '<pre>';
        // print_r($orderData);
        // exit;

        $request->session()->put('frontenduserid', $orderData[1]);
        if ($response['referenceId'] == 'N/A' || $response['paymentMode'] == 'N/A' || $response['txStatus'] == 'CANCELLED' || $response['txMsg'] == 'Cancelled by user') {
            return redirect(FRONTENDURL . 'payment/' . encryption($orderData[0]))->with('error', 'Something went wrong. Please try again');
        }

        try {
            $orderId = $orderData[0];
            $orderInfo = FHelperController::getPetsOrderTemp($orderId);
            $orderProductInfo = FHelperController::getPetsOrderProductsTemp($orderId);

            $gettotalOrders = FHelperController::getPetsOrder();
            $totalOrderCount = count($gettotalOrders);
            $orderId = $totalOrderCount == 0 ? 10001  : 10001 + $totalOrderCount;

            $orderCreateInfo = [
                'user_id' => $request->session()->get('frontenduserid'), 'order_inc_id' => $orderId, 'order_type' => $orderInfo[0]->order_type,
                'pets_master_id' => $orderInfo[0]->pets_master_id, 'totalGramNeedtoBuy' => $orderInfo[0]->totalGramNeedtoBuy,
                'defaultProductCalc' => $orderInfo[0]->defaultProductCalc, 'remainingGramToBuy' => $orderInfo[0]->remainingGramToBuy, 'remainingDays' => $orderInfo[0]->remainingDays,
                'totalGram' => $orderInfo[0]->totalGram, 'totalDays' => $orderInfo[0]->totalDays, 'totalPrice' => round($orderInfo[0]->totalPrice),
                'grandTotal' => $orderData[3] + $orderData[2], 'gst' => $orderData[2],
                'paymentId' => $response['referenceId'], 'delivery_date' => $orderInfo[0]->delivery_date, 'perDayMeal' => $orderInfo[0]->perDayMeal,
                'orderProcessType' => $orderInfo[0]->orderProcessType, 'parent_id' => $orderInfo[0]->parent_id
            ];

            $createOrder = insertQueryId('order_details', $orderCreateInfo);

            $request->session()->forget('gst');
            $request->session()->forget('subtotal');
            $response['orderId'] = $createOrder;
            insertQueryId('payment_details', $response);

            foreach ($orderProductInfo as $product) {
                $orderProducts = [
                    'order_id' => $createOrder, 'user_id' => $request->session()->get('frontenduserid'),
                    'product_id' => $product->product_id, 'product_name' => $product->product_name,
                    'product_price' => $product->product_price, 'product_qty' => $product->product_qty
                ];
                insertQuery('order_details_products', $orderProducts);
            }


            $orderInfo = FHelperController::getPetsOrder($createOrder);
            $orderProducts = FHelperController::getMyOrderProductsAsc($createOrder);

            $delivery = date('m', strtotime($orderInfo[0]->delivery_date));
            if ($delivery == date('m')) {
                $thisMonthDeliveryDate = $this->CurrentMonthDelivery($orderInfo[0]->delivery_date);
                $dates = $thisMonthDeliveryDate['totaldeliveryfromdeliverydate'];
            } else {
                $thisMonthDeliveryDate = $this->TotalDelivery($orderInfo[0]->delivery_date);
                $dates = $thisMonthDeliveryDate['totaldeliveryfromtoday'];
            }


            // $thisMonthDeliveryDate = $this->CurrentMonthDelivery($orderInfo[0]->delivery_date);
            $staterProduct = $orderProducts[0];
            $staterProductTotalQty = $staterProduct->product_qty;
            $percentage = [10, 25, 50, 75, 100];
            $finalGram = 0;
            $finalArray = [];
            for ($e = 0; $e < 5; $e++) {
                $updatedQty = $staterProductTotalQty - $finalGram;
                $actualGram = round(($updatedQty * $percentage[$e]) / 100);
                array_push($finalArray, $actualGram);
                $finalGram += $actualGram;
            }
            $productsArray = [];
            foreach ($orderProducts as $k => $products) {
                if ($k > 0) {
                    array_push($productsArray, [
                        'product_id' => $products->product_id, 'actual_qty' => $products->product_qty,
                        'perday_qty' => round($products->product_qty / $orderInfo[0]->remainingDays)
                    ]);
                }
            }
            foreach ($dates as $k => $totalDelivery) {

                $deliveryInfo = [
                    'order_id' => $orderId, 'user_id' => $orderInfo[0]->user_id, 'perday_meal' => $orderInfo[0]->perDayMeal,
                    'total_days' => $orderInfo[0]->totalDays, 'total_gram' => $orderInfo[0]->totalGram, 'delivery_date' => $totalDelivery
                ];
                $createDeliveryInfo = insertQueryId('deliveryinfo', $deliveryInfo);
                $timestamp = strtotime($totalDelivery);
                $day = date('w', $timestamp);
                $daysInterval = $day == 1 ? 4 : 3;
                $startupProductProcessedDays = 0;
                if ($k == 0) {
                    $start = 1;
                    $totalGram = $actualGram = 0;
                    for ($p = 1; $p <= $daysInterval; $p++) {
                        $totalGram += $finalArray[$p - 1];
                    }
                    $startupProductProcessedDays = $daysInterval;

                    $deliveryInfoProducts = [
                        'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->user_id,
                        'product_id' => $orderProducts[$k]->product_id, 'product_name' => $orderProducts[$k]->product_name,
                        'days_interval' => $daysInterval, 'actual_product_gram' => $orderProducts[$k]->product_qty,
                        'product_gram' => round($totalGram)
                    ];
                    insertQuery('deliveryinfo_products', $deliveryInfoProducts);
                }
                if ($k == 1) {
                    $limit = $day != 1 ? 3 : 4;

                    $starterInterval =  $day == 1 ? 4 : 5;

                    $other = $day == 1 ? 3 : 4;
                    $processDays = 5 - $other + 1;
                    $remainingDays =  $starterInterval - $daysInterval;
                    $totalGram1 = $actualGram = 0;
                    for ($p = $starterInterval; $p <= 5; $p++) {
                        $totalGram1 += $finalArray[$p - 1];
                    }

                    $deliveryInfoProducts1 = [
                        'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->user_id,
                        'product_id' => $orderProducts[$k - 1]->product_id, 'product_name' => $orderProducts[$k - 1]->product_name,
                        'days_interval' => $starterInterval == 5 ? 1 : 5 - $starterInterval, 'actual_product_gram' => $orderProducts[$k - 1]->product_qty,
                        'product_gram' => round($totalGram1)
                    ];
                    insertQuery('deliveryinfo_products', $deliveryInfoProducts1);
                    for ($e = 0; $e < count($orderProducts); $e++) {
                        if ($e > 0) {
                            $perDayProductQty = $orderProducts[$e]->product_qty / $orderInfo[0]->remainingDays;
                            $deliveryInfoProducts2 = [
                                'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->user_id,
                                'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,
                                'days_interval' => $daysInterval - 1, 'actual_product_gram' => $orderProducts[$e]->product_qty,
                                'product_gram' => round($perDayProductQty * $remainingDays)
                            ];

                            insertQuery('deliveryinfo_products', $deliveryInfoProducts2);
                        }
                    }
                }

                if ($k > 1) {
                    for ($e = 0; $e < count($orderProducts); $e++) {
                        if ($e > 0) {
                            $perDayProductQty = $orderProducts[$e]->product_qty / $orderInfo[0]->remainingDays;
                            $deliveryInfoProducts2 = [
                                'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->user_id,
                                'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,
                                'days_interval' => $daysInterval, 'actual_product_gram' => $orderProducts[$e]->product_qty,
                                'product_gram' => round($perDayProductQty * $daysInterval)
                            ];
                            insertQuery('deliveryinfo_products', $deliveryInfoProducts2);
                        }
                    }
                }
            }


            $invoiceName = 'invoice_' . $createOrder;
            $pdfName = 'public/order/' . $invoiceName . '.pdf';

            $orders = HelperController::getAllOrders($createOrder);
            $orderProducts = HelperController::getOrderProducts($createOrder);
            $address = getAddress($orders[0]->user_id);

            $userInfo = HelperController::getUsers($orders[0]->user_id);

            $data = ['address' => $address, 'order' => $orders, 'orderProducts' => $orderProducts, 'user_email' => $userInfo[0]->user_email];

            // $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('frontend.invoice', $data)->setPaper('a4', 'potrait');

            // Storage::put($pdfName, $pdf->output());

            // try {
            //     Mail::send('frontend.email.orderconfirmation', $data, function ($message) use ($data, $pdfName) {
            //         $message->to($data['user_email'], 'Order Confirmation')->subject('Order Confirmation');
            //         $message->cc(['woof@untame.pet']);
            //         $message->attach(storage_path('app/' . $pdfName));
            //         $message->from(getenv('MAIL_USERNAME'), 'Sales');
            //     });
            // } catch (\Exception $e) {
            //     return redirect(FRONTENDURL . 'myorders')->with('error', $e->getMessage());
            // }

            try {
                Mail::send('frontend.email.invoice_template', $data, function ($message) use ($data, $pdfName) {
                    $message->to($data['user_email'], 'Order Confirmation')->subject('Order Confirmation');
                    $message->cc(['woof@untame.pet']);
                    $message->from(getenv('MAIL_USERNAME'), 'Sales');
                });
            } catch (\Exception $e) {
                return redirect(FRONTENDURL . 'myorders')->with('error', $e->getMessage());
            }


            // $subscription = FHelperController::getUserSubscription($request->session()->get('frontenduserid'));
            // if (!count($subscription)) {
            if ($orderInfo[0]->orderProcessType == 1) {
                insertQuery('subscription', ['user_id' => $request->session()->get('frontenduserid'), 'order_id' => $createOrder]);
            }

            if ($orderInfo[0]->orderProcessType == 2) {

                $userOverDue = FHelperController::getOverDueByUser($request->session()->get('frontenduserid'));
                $totalRecord = count($userOverDue);
                $month = $totalRecord + 1;

                $nextMonthDate = date('Y-m-d', strtotime('+' . $month . ' months', strtotime(date('Y-m-d'))));
                $startDate = date("Y-m-01", strtotime($nextMonthDate));

                $data = [
                    'user_id' => $orders[0]->user_id, 'parent_order_id' => $orders[0]->parent_id, 'order_id' => $createOrder, 'transactionMonth' => $startDate,
                    'paymentId' => $orders[0]->paymentId
                ];
                insertQuery('order_due', $data);
            }

            deleteQuery($request->session()->get('frontenduserid'), 'order_details_temp', 'user_id');
            deleteQuery($request->session()->get('frontenduserid'), 'order_details_products_temp', 'user_id');

            return redirect(FRONTENDURL . 'myorders')->with('success', 'Order Created Successfully');
        } catch (\Exception $e) {
            return redirect(FRONTENDURL . 'myorders')->with('error', $e->getMessage());
        }
    }

    public function OrderTesting()
    {
        // echo '<pre>';

        $createOrder = 1;
        $orderInfo = FHelperController::getPetsOrder($createOrder);
        $orderProducts = FHelperController::getMyOrderProductsAsc($createOrder);
        $delivery = date('m', strtotime($orderInfo[0]->delivery_date));
        if ($delivery == date('m')) {
            $thisMonthDeliveryDate = $this->CurrentMonthDelivery($orderInfo[0]->delivery_date);
            $dates = $thisMonthDeliveryDate['totaldeliveryfromdeliverydate'];
        } else {
            $thisMonthDeliveryDate = $this->TotalDelivery($orderInfo[0]->delivery_date);
            $dates = $thisMonthDeliveryDate['totaldeliveryfromtoday'];
        }
        $staterProduct = $orderProducts[0];
        $staterProductTotalQty = $staterProduct->product_qty;
        $percentage = [10, 25, 50, 75, 100];
        $finalGram = 0;
        $finalArray = [];
        for ($e = 0; $e < 5; $e++) {
            $updatedQty = $staterProductTotalQty - $finalGram;
            $actualGram = round(($updatedQty * $percentage[$e]) / 100);
            array_push($finalArray, $actualGram);
            $finalGram += $actualGram;
        }
        $productsArray = [];
        foreach ($orderProducts as $k => $products) {
            if ($k > 0) {
                array_push($productsArray, [
                    'product_id' => $products->product_id, 'actual_qty' => $products->product_qty,
                    'perday_qty' => round($products->product_qty / $orderInfo[0]->remainingDays)
                ]);
            }
        }

        $orderId = $createOrder;

        foreach ($dates as $k => $totalDelivery) {

            $deliveryInfo = [
                'order_id' => $orderId, 'user_id' => $orderInfo[0]->order_id, 'perday_meal' => $orderInfo[0]->perDayMeal,
                'total_days' => $orderInfo[0]->totalDays, 'total_gram' => $orderInfo[0]->totalGram, 'delivery_date' => $totalDelivery
            ];

            // echo 'deliveryInfo:' . '<br>';
            // print_r($deliveryInfo);
            // echo 'Delivery Date:' . $totalDelivery . '<br>';
            // echo '-------------------' . '<br>';
            $createDeliveryInfo = 1;
            // $createDeliveryInfo = insertQueryId('deliveryinfo', $deliveryInfo);
            $timestamp = strtotime($totalDelivery);
            $day = date('w', $timestamp);
            $daysInterval = $day == 1 ? 4 : 3;
            $startupProductProcessedDays = 0;
            if ($k == 0) {
                $start = 1;
                $totalGram = $actualGram = 0;
                for ($p = 1; $p <= $daysInterval; $p++) {
                    $totalGram += $finalArray[$p - 1];
                }
                $startupProductProcessedDays = $daysInterval;

                $deliveryInfoProducts = [
                    'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                    'product_id' => $orderProducts[$k]->product_id, 'product_name' => $orderProducts[$k]->product_name,
                    'days_interval' => $daysInterval, 'actual_product_gram' => $orderProducts[$k]->product_qty,
                    'product_gram' => round($totalGram)
                ];
                // echo 'deliveryInfoProducts:' . '<br>';
                // print_r($deliveryInfoProducts);
                // insertQuery('deliveryinfo_products', $deliveryInfoProducts);
            }
            if ($k == 1) {
                $limit = $day != 1 ? 3 : 4;

                $starterInterval =  $day == 1 ? 4 : 5;

                $other = $day == 1 ? 3 : 4;
                $processDays = 5 - $other + 1;
                $remainingDays =  $starterInterval - $daysInterval;
                $totalGram1 = $actualGram = 0;
                for ($p = $starterInterval; $p <= 5; $p++) {
                    $totalGram1 += $finalArray[$p - 1];
                }

                $deliveryInfoProducts1 = [
                    'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                    'product_id' => $orderProducts[$k - 1]->product_id, 'product_name' => $orderProducts[$k - 1]->product_name,
                    'days_interval' => $starterInterval == 5 ? 1 : 5 - $starterInterval, 'actual_product_gram' => $orderProducts[$k - 1]->product_qty,
                    'product_gram' => round($totalGram1)
                ];
                // echo 'deliveryInfoProducts1:' . '<br>';
                // print_r($deliveryInfoProducts1);
                // insertQuery('deliveryinfo_products', $deliveryInfoProducts1);
                for ($e = 0; $e < count($orderProducts); $e++) {
                    if ($e > 0) {
                        $perDayProductQty = $orderProducts[$e]->product_qty / $orderInfo[0]->remainingDays;
                        $deliveryInfoProducts2 = [
                            'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                            'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,
                            'days_interval' => $daysInterval - 1, 'actual_product_gram' => $orderProducts[$e]->product_qty,
                            'product_gram' => round($perDayProductQty * $remainingDays)
                        ];
                        // echo 'deliveryInfoProducts2:' . '<br>';
                        // print_r($deliveryInfoProducts2);
                        // insertQuery('deliveryinfo_products', $deliveryInfoProducts2);
                    }
                }
            }

            if ($k > 1) {
                for ($e = 0; $e < count($orderProducts); $e++) {
                    if ($e > 0) {
                        $perDayProductQty = $orderProducts[$e]->product_qty / $orderInfo[0]->remainingDays;
                        $deliveryInfoProducts2 = [
                            'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                            'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,
                            'days_interval' => $daysInterval, 'actual_product_gram' => $orderProducts[$e]->product_qty,
                            'product_gram' => round($perDayProductQty * $daysInterval)
                        ];
                        // echo 'deliveryInfoProducts2:' . '<br>';
                        // print_r($deliveryInfoProducts2);
                        // insertQuery('deliveryinfo_products', $deliveryInfoProducts2);
                    }
                }
            }
        }

        // echo '<pre>';
        // print_r($dates);
        // print_r($orderInfo);
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
            $orderId = $totalOrderCount == 0 ? 10001  : 10001 + $totalOrderCount;

            $orderCreateInfo = [
                'user_id' => $request->session()->get('frontenduserid'), 'order_inc_id' => $orderId, 'order_type' => $orderInfo[0]->order_type,
                'pets_master_id' => $orderInfo[0]->pets_master_id, 'totalGramNeedtoBuy' => $orderInfo[0]->totalGramNeedtoBuy,
                'defaultProductCalc' => $orderInfo[0]->defaultProductCalc, 'remainingGramToBuy' => $orderInfo[0]->remainingGramToBuy, 'remainingDays' => $orderInfo[0]->remainingDays,
                'totalGram' => $orderInfo[0]->totalGram, 'totalDays' => $orderInfo[0]->totalDays, 'totalPrice' => round($orderInfo[0]->totalPrice), 'grandTotal' => $formData['subtotal'] + $formData['gst'],
                'gst' => $formData['gst'], 'paymentId' => $formData['razorpay_payment_id'], 'delivery_date' => $orderInfo[0]->delivery_date, 'perDayMeal' => $orderInfo[0]->perDayMeal
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


            $orderInfo = FHelperController::getPetsOrder($createOrder);
            $orderProducts = FHelperController::getMyOrderProductsAsc($createOrder);
            $thisMonthDeliveryDate = $this->CurrentMonthDelivery($orderInfo[0]->delivery_date);
            $staterProduct = $orderProducts[0];
            $staterProductTotalQty = $staterProduct->product_qty;
            $percentage = [10, 25, 50, 75, 100];
            $finalGram = 0;
            $finalArray = [];
            for ($e = 0; $e < 5; $e++) {
                $updatedQty = $staterProductTotalQty - $finalGram;
                $actualGram = round(($updatedQty * $percentage[$e]) / 100);
                array_push($finalArray, $actualGram);
                $finalGram += $actualGram;
            }
            $productsArray = [];
            foreach ($orderProducts as $k => $products) {
                if ($k > 0) {
                    array_push($productsArray, [
                        'product_id' => $products->product_id, 'actual_qty' => $products->product_qty,
                        'perday_qty' => round($products->product_qty / $orderInfo[0]->remainingDays)
                    ]);
                }
            }
            foreach ($thisMonthDeliveryDate['totaldeliveryfromdeliverydate'] as $k => $totalDelivery) {

                $deliveryInfo = [
                    'order_id' => $orderId, 'user_id' => $orderInfo[0]->order_id, 'perday_meal' => $orderInfo[0]->perDayMeal,
                    'total_days' => $orderInfo[0]->totalDays, 'total_gram' => $orderInfo[0]->totalGram, 'delivery_date' => $totalDelivery
                ];
                $createDeliveryInfo = insertQueryId('deliveryinfo', $deliveryInfo);
                $timestamp = strtotime($totalDelivery);
                $day = date('w', $timestamp);
                $daysInterval = $day == 1 ? 4 : 3;
                $startupProductProcessedDays = 0;
                if ($k == 0) {
                    $start = 1;
                    $totalGram = $actualGram = 0;
                    for ($p = 1; $p <= $daysInterval; $p++) {
                        $totalGram += $finalArray[$p - 1];
                    }
                    $startupProductProcessedDays = $daysInterval;

                    $deliveryInfoProducts = [
                        'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                        'product_id' => $orderProducts[$k]->product_id, 'product_name' => $orderProducts[$k]->product_name,
                        'days_interval' => $daysInterval, 'actual_product_gram' => $orderProducts[$k]->product_qty,
                        'product_gram' => round($totalGram)
                    ];
                    insertQuery('deliveryinfo_products', $deliveryInfoProducts);
                }
                if ($k == 1) {
                    $limit = $day != 1 ? 3 : 4;

                    $starterInterval =  $day == 1 ? 4 : 5;

                    $other = $day == 1 ? 3 : 4;
                    $processDays = 5 - $other + 1;
                    $remainingDays =  $starterInterval - $daysInterval;
                    $totalGram1 = $actualGram = 0;
                    for ($p = $starterInterval; $p <= 5; $p++) {
                        $totalGram1 += $finalArray[$p - 1];
                    }

                    $deliveryInfoProducts1 = [
                        'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                        'product_id' => $orderProducts[$k - 1]->product_id, 'product_name' => $orderProducts[$k - 1]->product_name,
                        'days_interval' => $starterInterval == 5 ? 1 : 5 - $starterInterval, 'actual_product_gram' => $orderProducts[$k - 1]->product_qty,
                        'product_gram' => round($totalGram1)
                    ];
                    insertQuery('deliveryinfo_products', $deliveryInfoProducts1);
                    for ($e = 0; $e < count($orderProducts); $e++) {
                        if ($e > 0) {
                            $perDayProductQty = $orderProducts[$e]->product_qty / $orderInfo[0]->remainingDays;
                            $deliveryInfoProducts2 = [
                                'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                                'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,
                                'days_interval' => $daysInterval - 1, 'actual_product_gram' => $orderProducts[$e]->product_qty,
                                'product_gram' => round($perDayProductQty * $remainingDays)
                            ];

                            insertQuery('deliveryinfo_products', $deliveryInfoProducts2);
                        }
                    }
                }

                if ($k > 1) {
                    for ($e = 0; $e < count($orderProducts); $e++) {
                        if ($e > 0) {
                            $perDayProductQty = $orderProducts[$e]->product_qty / $orderInfo[0]->remainingDays;
                            $deliveryInfoProducts2 = [
                                'deliveryinfo_id' => $createDeliveryInfo, 'user_id' => $orderInfo[0]->order_id,
                                'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,
                                'days_interval' => $daysInterval, 'actual_product_gram' => $orderProducts[$e]->product_qty,
                                'product_gram' => round($perDayProductQty * $daysInterval)
                            ];
                            insertQuery('deliveryinfo_products', $deliveryInfoProducts2);
                        }
                    }
                }
            }


            $invoiceName = 'invoice_' . $createOrder;
            $pdfName = 'public/order/' . $invoiceName . '.pdf';

            $orders = HelperController::getAllOrders($createOrder);
            $orderProducts = HelperController::getOrderProducts($createOrder);
            $address = getAddress($orders[0]->user_id);

            $userInfo = HelperController::getUsers($orders[0]->user_id);

            $data = ['address' => $address, 'order' => $orders, 'orderProducts' => $orderProducts, 'user_email' => $userInfo[0]->user_email];

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('frontend.invoice', $data)->setPaper('a4', 'potrait');

            Storage::put($pdfName, $pdf->output());

            try {
                Mail::send('frontend.email.orderconfirmation', $data, function ($message) use ($data, $pdfName) {
                    $message->to($data['user_email'], 'Order Confirmation')->subject('Order Confirmation');
                    $message->cc(['woof@untame.pet']);
                    $message->attach(storage_path('app/' . $pdfName));
                    $message->from(getenv('MAIL_USERNAME'), 'Sales');
                });
            } catch (\Exception $e) {
                $response = ['url' => '', 'status' => false, 'msg' => $e->getMessage()];
            }

            $subscription = FHelperController::getUserSubscription($request->session()->get('frontenduserid'));
            if (!count($subscription)) {
                insertQuery('subscription', ['user_id' => $request->session()->get('frontenduserid')]);
            }

            deleteQuery($request->session()->get('frontenduserid'), 'order_details_temp', 'user_id');
            deleteQuery($request->session()->get('frontenduserid'), 'order_details_products_temp', 'user_id');

            $response = ['url' => url(FRONTENDURL . 'myorders'), 'status' => true];
        } catch (\Exception $e) {
            $response = ['url' => '', 'status' => false, 'msg' => $e->getMessage()];
        }

        return response()->json($response);
    }

    public function InvoiceTemplateView()
    {
        $createOrder = 1;
        $orders = HelperController::getAllOrders($createOrder);
        $orderProducts = HelperController::getOrderProducts($createOrder);
        $address = getAddress($orders[0]->user_id);

        $userInfo = HelperController::getUsers($orders[0]->user_id);

        $data = ['address' => $address, 'order' => $orders, 'orderProducts' => $orderProducts, 'user_email' => 'tsubramaniyan2@gmail.com'];


        $invoiceName = 'invoice_' . $createOrder;
        $pdfName = 'public/order/' . $invoiceName . '.pdf';

        // return view('frontend.email.invoice_template', $data);

        // $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        // ->loadView('frontend.email.invoice_template', $data)->setPaper('a4', 'potrait');

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('frontend.email.orderinvoice', $data)->setPaper('a4', 'potrait');


        return $pdf->stream();
        // Storage::put($pdfName, $pdf->output());

        // try {
        //     Mail::send('frontend.email.orderconfirmation', $data, function ($message) use ($data, $pdfName) {
        //         $message->to($data['user_email'], 'Order Confirmation')->subject('Order Confirmation');
        //         // $message->cc(['woof@untame.pet']);
        //         $message->attach(storage_path('app/' . $pdfName));
        //         $message->from(getenv('MAIL_USERNAME'), 'Sales');
        //     });
        // } catch (\Exception $e) {
        //     return redirect(FRONTENDURL . 'myorders')->with('error', $e->getMessage());
        // }

        echo 'Email sent';


        // return view('frontend.email.invoice_template',$data);
    }

    public function OrderInvoiceDownload($id)
    {
        $invoiceName = 'invoice_' . decryption($id);
        $pdfName = 'public/order/' . $invoiceName . '.pdf';
        $newName = $invoiceName . '.pdf';

        $headers = [
            'Content-type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Invoice.pdf"',
        ];

        return Storage::download($pdfName, $newName, $headers);
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

    public function MyOrdersInvoiceDownload(Request $request)
    {
        $status = false;
        $createOrder = $request->input('orderId');
        $orders = HelperController::getAllOrders($createOrder);
        $orderProducts = HelperController::getOrderProducts($createOrder);
        $address = getAddress($orders[0]->user_id);
        $html = '';
        $userInfo = HelperController::getUsers($orders[0]->user_id);

        $data = ['address' => $address, 'order' => $orders, 'orderProducts' => $orderProducts, 'user_email' => $userInfo[0]->user_email];

        if (count($orders)) {
            $status = true;
            $html = view('frontend.email.invoice_template', $data)->render();
        }

        return response()->json(['html' => $html, 'status' =>  $status]);
    }

    public function MyOrderProducts(Request $request)
    {
        $orderId = $request->segment(2);
        $getOrder = FHelperController::getPetsOrder(decryption($orderId));
        $getOrderProducts = FHelperController::getMyOrderProducts(decryption($orderId));
        return view('frontend.myorderproducts', compact('getOrderProducts', 'getOrder'));
    }

    public function UserSubscription(Request $request)
    {
        $subscription = FHelperController::getUserSubscription($request->session()->get('frontenduserid'));
        return view('frontend.mysubscription', compact('subscription'));
    }

    public function UpdateSubscription($id)
    {
        try {
            $actionId = decryption($id);
            $subscription = FHelperController::getUserSubscriptionById($actionId);
            if (!count($subscription)) back()->with('error', 'Something went wrong');
            $subscribe = $subscription[0]->status == 1 ? 2 : 1;
            if ($subscribe == 2) {
                $orderInfo = getOrderById($subscription[0]->order_id);
                $orderId = count($orderInfo) ? $orderInfo[0]->order_inc_id : '';
                $userInfo = getUser($subscription[0]->user_id);
                $email = count($userInfo) ? $userInfo[0]->user_email : '';
                $data = ['user_email' => $email,'order_id' => $orderId];
                try {
                    Mail::send('frontend.email.unsubscribe', $data, function ($message) use ($data) {
                        $message->to('woof@untame.pet', 'Order UnSubscription')->subject('Order UnSubscription');
                        // $message->cc(['woof@untame.pet']);
                        $message->from(getenv('MAIL_USERNAME'), 'Sales');
                    });
                } catch (\Exception $e) {
                    return redirect(FRONTENDURL . 'user_subscription')->with('error', $e->getMessage());
                }
            }
            updateQuery('subscription', 'subscription_id', $actionId, ['status' => $subscribe]);
            // deleteQuery($actionId, 'subscription', 'subscription_id');
            return back()->with('success', 'Unsubscribed successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong');
        }
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
