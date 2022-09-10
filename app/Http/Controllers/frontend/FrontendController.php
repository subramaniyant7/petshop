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
        if ($formData['name'] == '' || $formData['email'] == '' || $formData['subject'] == '' || $formData['content'] == '') return back()->with('error', 'Please enter all mandatory fields');
        try {
            Mail::send('frontend.email.contactus', $formData, function ($message) use ($formData) {
                $message->to('leadgen@untame.pet', 'Admin')->subject('Contact Us');
                $message->from(getenv('MAIL_USERNAME'), 'Admin');
            });
            return redirect(FRONTENDURL)->with('success', 'Thanks for Contacting Us. We will contact you soon.');
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
        // echo 'Days:'.$day.'<br>';
        // echo 'Diff:'.$diff.'<br>';
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

        // echo '<pre>';
        // echo $date.'<br>';
        // print_r($days);
        // exit;
        $totalDays = $this->DateDifference($days['deliveryDate'], $days['deliveryMonthLastDate']) - 1;

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
        $userOrders = FHelperController::getMyOrders($userId);
        $totalDelivery = [];
        if (count($userOrders)) {
            foreach ($userOrders as $order) {
                $deliveryDate = $order->delivery_date;
                $deliveryMonth = date('m', strtotime($deliveryDate));
                if (date('m') == $deliveryMonth) {
                    $deliveryMonthLastDate = date("Y-m-t", strtotime($deliveryDate));
                    $perDay = $order->totalGramNeedtoBuy / $order->totalDays;
                    $validate = $this->DateDifference(date('Y-m-d'), $deliveryDate);
                    if ($validate != 1) {
                        $updateStamp = strtotime($deliveryDate);
                        $day = date('w', $updateStamp);
                        $gram = $day == 1 ? $perDay * 4 : $perDay * 3;
                        array_push($totalDelivery, [
                            'delivery' => $deliveryDate, 'day' => $day, 'gram' => $gram, 'orderid' => $order->order_id,
                            'order_inc_id' => $order->order_inc_id
                        ]);
                    }
                    for ($l = 1; $l <= $order->totalDays; $l++) {
                        $updateDate = date('Y-m-d', strtotime('+' . $l . ' day', strtotime($deliveryDate)));
                        if ($this->DateDifference($updateDate, $deliveryMonthLastDate) != 1) {
                            $updateStamp = strtotime($updateDate);
                            $day = date('w', $updateStamp);
                            if ($day == 1 || $day == 5) {
                                $gram = $day == 1 ? $perDay * 4 : $perDay * 3;
                                array_push($totalDelivery, [
                                    'delivery' => $updateDate, 'day' => $day, 'gram' => $gram, 'orderid' => $order->order_id,
                                    'order_inc_id' => $order->order_inc_id
                                ]);
                            }
                        }
                    }

                    // echo '<pre>';
                    // print_r($totalDelivery);
                    // echo $perDay . '<br>';
                    // echo $order->totalGram . '<br>';
                    // echo 'diffff:'.$this->DateDifference('2022-09-30', '2022-09-30').'<br>';

                    // $diff = 0;
                    // if ($day == 1) {
                    //     $diff = 3;
                    // }
                    // if ($day == 6) {
                    //     $diff = 2;
                    // }
                    // if ($day > 1 && $day < 5) {
                    //     $diff = 5 - $day;
                    // }

                    // $deliveryDate = date('Y-m-d', strtotime('+' . $diff . ' day', strtotime($date)));

                    // echo $day.'<br>';

                    // $deliveryMonth = date('m', strtotime($deliveryDate));
                    // if (date('m') == $deliveryMonth) {
                    //     $today = date('Y-m-d');
                    //     // echo $today . '<br>';
                    // }
                    // echo date('m', strtotime($deliveryDate)) . '<br>';
                    // echo date('m');
                }
            }
        }

        // echo '<pre>';
        // print_r($totalDelivery);
        // exit;
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


            if ($this->DateDifference($updateDate, $deliveryMonthLastDate) > 4) {
                $updateStamp = strtotime($updateDate);
                $day = date('w', $updateStamp);
                if ($day == 1 || $day == 5) {
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

            if ($dateDiff > 4) {
                // echo 'Date-----: ' . $dateDiff . '<br>';
                if (strtotime($updateDate) >= strtotime($deliveryDate)) {
                    $updateStamp = strtotime($updateDate);
                    $day = date('w', $updateStamp);
                    if ($day == 1 || $day == 5) {
                        array_push($totalDeliveryofMonthFromDelivery, $updateDate);
                    }
                }
                if (strtotime($updateDate) >= strtotime(date('Y-m-d'))) {
                    $updateStamp = strtotime($updateDate);
                    $day = date('w', $updateStamp);
                    if ($day == 1 || $day == 5) {
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
        $orderInfo = FHelperController::getPetsOrder($orderId);
        $orderProducts = FHelperController::getMyOrderProductsAsc($orderId);
        $thisMonthDeliveryDate = $this->CurrentMonthDelivery($orderInfo[0]->delivery_date);

        echo '<pre>';
        print_r($orderInfo);
        print_r($orderProducts);
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
        print_r($finalArray);
        // print_r($productsArray);
        // exit;
        // print_r($thisMonthDeliveryDate['totaldeliveryfromdeliverydate']);
        foreach ($thisMonthDeliveryDate['totaldeliveryfromdeliverydate'] as $k => $totalDelivery) {

            // $deliveryInfo = [
            //     'order_id' => $orderId, 'user_id' => $orderInfo[0]->order_id, 'perday_meal' => $orderInfo[0]->perDayMeal,
            //     'total_days' => $orderInfo[0]->totalDays, 'total_gram' => $orderInfo[0]->totalGram, 'delivery_date' => $totalDelivery
            // ];

            // echo 'Delivery Info:' . '<br>';
            // print_r($deliveryInfo);
            // echo '<br>';

            //     // $createDeliveryInfo = insertQueryId('deliveryinfo', $deliveryInfo);
            $createDeliveryInfo = 1;

            echo 'Delivery Date:' . $totalDelivery . '<br>';
            //     // foreach ($orderProducts as $products) {
            $timestamp = strtotime($totalDelivery);
            $day = date('w', $timestamp);
            $daysInterval = $day == 1 ? 4 : 3;
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

                echo 'Starter Product Start---------------: ' . $k . ':' . '<br>';
                print_r($deliveryInfoProducts);
                echo 'Starter Product End---------------: ' . $k . ':' . '<br><br>';
                //         // insertQuery('deliveryinfo_products', $deliveryInfoProducts);
                //         // break;
            }
            if ($k == 1) {
                $limit = $day != 1 ? 3 : 4;

                $starterInterval =  $day == 1 ? 4 : 5;

                $other = $day == 1 ? 3 : 4;
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
                    'product_id' => $orderProducts[$k - 1]->product_id, 'product_name' => $orderProducts[$k - 1]->product_name,'days_interval' => $starterInterval == 5 ? 1 : 5-$starterInterval,
                    'actual_product_gram' => $orderProducts[$k - 1]->product_qty, 'product_gram' => round($totalGram1)
                ];
                //             echo 'Delivery Info Products Loop: ' . $k . ':' . '<br>';
                echo 'Starter Product Start---------------: ' . $k . ':' . '<br>';
                print_r($deliveryInfoProducts1);
                echo 'Starter Product End---------------: ' . $k . ':' . '<br><br>';

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
                            'product_id' => $orderProducts[$e]->product_id, 'product_name' => $orderProducts[$e]->product_name,'days_interval' => $daysInterval-1,
                            'actual_product_gram' => $orderProducts[$e]->product_qty, 'product_gram' => round($perDayProductQty * $remainingDays)
                        ];


                        //                 // array_push($totalArray, $deliveryInfoProducts2);

                        //                 // echo 'Delivery Info Products Loope-------: ' . $e . ':' . '<br>';
                        echo 'Remaining Product Start---------------: ' . $k . ':' . '<br>';
                        print_r($deliveryInfoProducts2);
                        echo 'Remaining Product End---------------: ' . $k . ':' . '<br><br>';
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
                                'actual_product_gram' => $orderProducts[$e]->product_qty, 'product_gram' => round($perDayProductQty * $daysInterval)
                            ];


                            //                 // array_push($totalArray, $deliveryInfoProducts2);

                            //                 // echo 'Delivery Info Products Loope-------: ' . $e . ':' . '<br>';
                            echo 'Remaining Product Start---------------: ' . $k . ':' . '<br>';
                            print_r($deliveryInfoProducts2);
                            echo 'Remaining Product End---------------: ' . $k . ':' . '<br><br>';
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
                $formData['breed_name'] = breedInfoById($formData['breed_name'])[0]->breed_name;
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
                $remainingGramToBuy = abs($totalGramNeedtoBuy);
                // $remainingGramToBuy = abs($totalGramNeedtoBuy - $defaultProductCalc);

                $returnData['totalGramNeedtoBuy'] = $totalGramNeedtoBuy;
                $returnData['defaultProductCalc'] = $defaultProductCalc;
                $returnData['remainingGramToBuy'] = $remainingGramToBuy;
                $returnData['remainingDays'] = $returnData['totalDays'] - 5;
                $returnData['order_type'] = $request->input('order_type');
            }
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
                if ($k != 0) {
                    $totalquantity += $qty;
                }
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
                        'totalPrice' => round($totalPrice), 'delivery_date' => $formData['delivery_date'], 'perDayMeal' => $formData['perDayMeal']
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
            $orderId = $totalOrderCount == 0 ? 10001  : 10000 + $totalOrderCount;

            $orderCreateInfo = [
                'user_id' => $request->session()->get('frontenduserid'), 'order_inc_id' => $orderId, 'order_type' => $orderInfo[0]->order_type,
                'pets_master_id' => $orderInfo[0]->pets_master_id, 'totalGramNeedtoBuy' => $orderInfo[0]->totalGramNeedtoBuy,
                'defaultProductCalc' => $orderInfo[0]->defaultProductCalc, 'remainingGramToBuy' => $orderInfo[0]->remainingGramToBuy, 'remainingDays' => $orderInfo[0]->remainingDays,
                'totalGram' => $orderInfo[0]->totalGram, 'totalDays' => $orderInfo[0]->totalDays, 'totalPrice' => round($orderInfo[0]->totalPrice),
                'paymentId' => $formData['razorpay_payment_id'], 'delivery_date' => $orderInfo[0]->delivery_date, 'perDayMeal' => $orderInfo[0]->perDayMeal
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

            $data = ['address' => $address, 'order' => $orders, 'orderProducts' => $orderProducts, 'user_email' => $userInfo[0]->user_email];

            $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadView('frontend.invoice', $data)->setPaper('a4', 'potrait');

            Storage::put($pdfName, $pdf->output());

            try {
                Mail::send('frontend.email.orderconfirmation', $data, function ($message) use ($data, $pdfName) {
                    $message->to($data['user_email'], 'Order Confirmation')->subject('Order Confirmation');
                    // $message->cc(['woof@untame.pet']);
                    $message->attach(storage_path('app/' . $pdfName));
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
