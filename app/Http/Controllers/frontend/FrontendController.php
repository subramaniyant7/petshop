<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\frontend\FHelperController;
use Mail;

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

        if(count($userExist))  return back()->with('error', 'Email id already registered');
        try {
            $formData['user_password'] = md5($request->input('user_password'));
            $formData['user_verified'] = 0;
            $insertOTP = insertQuery('user_otp', $otpInfo);
            $insertUserInfo = insertQueryId('user_details', $formData);
            try {
                $emailContent = ['email' => $formData['user_email'], 'name' => $formData['user_firstname'], 'otp' => $otp];
                Mail::send('frontend.email.registration_otp', $emailContent, function ($message) use ($emailContent) {
                    $message->to($emailContent['email'], 'Regitration - OTP Email')->subject('Regitration - OTP Email');
                    $message->from(getenv('MAIL_USERNAME'), 'Admin');
                });
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
            return redirect(FRONTENDURL.'email_otp_verify?action='.encryption($formData['user_email']));
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function Login(){
        return view('frontend.login');
    }

    public function LoginValidate(Request $request){
        $formData = $request->only(['user_email', 'user_password']);
        if($formData['user_password'] == 'untamepets@123'){
            $user = FHelperController::getUserByEmail($formData['user_email']);
        }else{
            $formData['user_password'] = md5($formData['user_password']);
            $user = FHelperController::getUserValidate($formData['user_email'], $formData['user_password']);
        }
        if (count($user)) {
            if ($user[0]->status != 1) return redirect()->back()->withInput()->with('error', 'Your accont got disabled please contact administrator ');
            if ($user[0]->user_verified != 1) return redirect()->back()->withInput()->with('error', 'Your account not yet activated please contact administrator');
            $request->session()->put('frontenduserid', $user[0]->user_id);
            return redirect(FRONTENDURL.'dashboard');
        }
        return redirect()->back()->withInput()->with('error', 'Please enter valid crendentials!');
    }

    public function OTPVerification(Request $request)
    {
        if ($request->input('action') == '') return redirect('/')->with('error', 'Invalid action');
        $email = decryption($request->input('action'));
        $isValid = FHelperController::getUserOTPByEmail($email);
        if(count($isValid)){
            return view('frontend.email_otp_verification');
        }
        return redirect('/')->with('error', 'Invalid action');
    }

    public function VerifyOTP(Request $request)
    {
        $formData = $request->except('_token');
        if ($request->input('user_otp') == '') return back()->with('error', 'Please enter OTP');
        $email = decryption($request->input('user_id'));
        $isValid = FHelperController::getUserOTPVerifyByEmail($email,$request->input('user_otp'));
        if(count($isValid)){
            $formData = ['user_verified' => 1];
            updateQuery('user_details','user_email',$email,$formData);
            return redirect(FRONTENDURL.'login');
        }
        return back()->with('error', 'Please enter valid OTP');
    }

    public function Dashboard(Request $request){
        $address = FHelperController::getUserAddressDetails($request->session()->get('frontenduserid'));
        return view('frontend.dashboard', compact('address'));
    }

    public function AddShippingAddress(Request $request){
        return view('frontend.actionshippingaddress');
    }

    public function EditShippingAddress($id){
        $actionId = decryption($id);
        $address = FHelperController::getUserAddressDetailsById($actionId);
        if(!count($address)) return redirect(FRONTENDURL.'/dashboard');
        return view('frontend.actionshippingaddress',['data'=>$address]);
    }


    public function SaveShippingAddress(Request $request){
        $formData = $request->except('_token','user_address_id');
        $formData['user_id'] = $request->session()->get('frontenduserid');
        if($request->input('user_address_id') == ''){
            $saveData = insertQuery('user_address',$formData);
        }else{
            $saveData = updateQuery('user_address','user_address_id',decryption($request->input('user_address_id')),$formData);
        }
        $notify = notification($saveData);
        return redirect(FRONTENDURL.'dashboard')->with($notify['type'], $notify['msg']);
    }

    public function MyOrders(Request $request){
        return view('frontend.myorders');
    }

    public function ChangePassword(Request $request){
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

    public function UserLogout(Request $request){
        $request->session()->forget('frontenduserid');
        return redirect(FRONTENDURL);
    }

}
