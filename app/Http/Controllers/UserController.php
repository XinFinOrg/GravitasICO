<?php

namespace App\Http\Controllers;

use App\model\Balance;
use App\model\Cms;
use App\model\Country;
use App\model\Enquiry;
use App\model\Faq;
use App\model\ico_bonus;
use App\model\ICO_bonus_stats;
use App\model\OTP;
use App\model\Pair;
use App\model\Profit;
use App\model\SiteSettings;
use App\model\Tokenusers;
use App\model\Trade;
use App\model\Transaction;
use App\model\UserBalance;
use App\model\Users;
use App\model\Verification;
use App\model\ICOTrade;
use Cache;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use PragmaRX\Google2FA\Google2FA;
use Session;
use Validator;

class UserController extends Controller
{

    public function __construct()
    {
        //cons;
        $ip = \Request::ip();
        blockip_list($ip);
        return view('errors.404');

    }

    function test()
    {
        $result = create_address('ETH', 'http://ico.foodcode.io/cron/eth_deposit_process');
        return $result;
    }

    //Register
    function register(Request $request)
    {
        try{
        // Session::flash('error','New Registrations have been closed');
        // return redirect('login');
        if ($request->isMethod('post')) {
            //  echo "okay"; exit;

            $this->validate($request, [
                'first_name' => 'required',
                'last_name' => 'required',

                //'username' => 'required',
                'email_id' => 'required|email',
                'password' => 'required|min:6',
            ], [
                    'first_name.required' => 'First name is required',
                    'last_name.required' => 'Last name is required',
                    'email_id.required' => 'Email id is required',
                    'email_id.email' => 'Enter valid email id',
                    'password.required' => 'Password is required',

                ]
            );

            $ip = \Request::ip();

            $first_name = $request['first_name'];
            $last_name = $request['last_name'];

            $email = strtolower($request['email_id']);
            $splemail = explode("@", $email);
            $end_user1 = encrypt($splemail[0]);
            $end_user2 = encrypt($splemail[1]);

            $res = $this->checking($splemail[0], $splemail[1]);
            if (count($res) > 0) {
                Session::flash('error', 'The email address already exsits');
                return redirect()->back();
            }
            $pass_code = bcrypt($request['password']);
            $activation_code = mt_rand(0000, 9999) . time();
            $forgot_code = mt_rand(111111, 999999) . time();
            $verify_status = 2;
            $status = 2;
            $created_at = date('Y-m-d H:i:s');
            $document_status = 0;
//            $check=$this->checkphone($mobile_no);
//            if(count($check)>0)
//            {
//              Session::flash('error', 'The Phone Number Already Exsits.');
//              return redirect()->back();
//            }
            $mob_isd = $request['isdcode'];
            $mobile_status = 0;

            $ins = ['ip' => $ip, 'enjoyer_name' => $first_name, 'first_name' => $first_name, 'last_name' => $last_name, 'end_user1' => $end_user1, 'end_user2' => $end_user2, 'pass_code' => $pass_code, 'activation_code' => $activation_code, 'forgot_code' => $forgot_code, 'verify_status' => $verify_status, 'status' => $status, 'created_at' => $created_at, 'document_status' => $document_status, 'mobile_status' => $mobile_status, 'profile_image' => 'noimage.png', 'mob_isd' => $mob_isd];

            $insert = Users::insertGetId($ins);
            //$lastid=$insert->id;

            $bal = ['user_id' => $insert, 'ETH' => 0, 'GIFT' => 0];
            Balance::insert($bal);

            //log
            last_activity($email, 'Registration', 0);

            $inst = new Tokenusers;
            $inst->user_id = $insert;
            $inst->email = ownencrypt($email);
            $inst->passcode = ownencrypt($request['password']);
            $inst->created_at = $created_at;
            $inst->save();

            $to = $email;
            $subject = get_template('4', 'subject');
            $message = get_template('4', 'template');
            $mailarr = array(
                '###USERNAME###' => $first_name,
                '###LINK###' => url('userverification/' . $activation_code),
                '###SITENAME###' => get_config('site_name'),
            );
            $message = strtr($message, $mailarr);
            $subject = strtr($subject, $mailarr);
            sendmail($to, $subject, ['content' => $message]);
            Session::flash('success', 'Please check your email address and verified your email address to activate your account');


            return view('front.login');

        }

   
        return view('front.register');
    }catch(\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return view('errors.404');
        
    }
    }


    //Checking mail id 
    function checking($end_user1, $end_user2)
    {
        try{
            $items = Users::all()->filter(function ($record) use ($end_user1, $end_user2) {
                if (decrypt($record->end_user1) == $end_user1 && decrypt($record->end_user2) == $end_user2) {
                    return $record;
                } else {
                    \Log::info(['user',decrypt($record->end_user1),decrypt($record->end_user2),$end_user1,$end_user2]);
                    return false;
                }
            });

            return $items;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }

    }


    //UserVerification
    function userverification($time)
    {
        try{
            $check = Users::where('activation_code', $time)->first();
            if ($check) {
                $activation_code = mt_rand(0000, 9999) . time();
                $check->activation_code = $activation_code;
                $check->verify_status = 1;
                $check->status = 1;
                $check->save();
                Session::flash('success', 'Your account is activated, Now you can login with your credentials');
                return redirect('/login');
            } else {
                Session::flash('error', 'Invalid Link');
                return redirect('/login');
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Login
    function login(Request $request)
    {
        try{
            if (Session::get('alphauserid') != "") {


                $user_id = Session::get('alphauserid');
    //            check_live_address($user_id)
                $document_status = get_user_details($user_id, 'document_status');

                if ($document_status != 1) {
                    Session::flash('error', 'Your kyc is not completed.');
                    return redirect('/kyc');
                } else {
                    return redirect('/dashboard');
                }
            } else {
                if ($request->isMethod('post')) {
                    $validator = Validator::make($request->all(), [
                        'login_mail' => 'required|email',
                        'password' => 'required',
                        'captcha' => 'required|captcha',
                    ], [
                        'login_mail.required' => 'Email id is required',
                        'login_mail.email' => 'Enter valid email id',
                        'password.required' => 'Password is required',
                        'captcha.required' => 'Captcha is required',
                        'captcha.captcha' => 'Captcha is wrong',
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator);
                    }
                    $email = strtolower($request['login_mail']);
                    $password = $request['password'];
                    \Log::info(['email',$email,$password]);
                    $ip = \Request::ip();
                    $res = $this->user_login_check($email, $password);
                    \Log::info(['res',$res]);
                    switch ($res) {
                        case '1':

                            //send login status mail
                            $to = $email;
                            $subject = get_template('17', 'subject');
                            $message = get_template('17', 'template');
                            $mailarr = array(
                                '###EMAIL###' => $email,
                                '###OS###' => getOS(),
                                '###BROWSER###' => getBrowser(),
                                '###IP###' => $ip,
                                '###TIME###' => date('Y-m-d H:i:s'),
                            );
                            $message = strtr($message, $mailarr);
                            $subject = strtr($subject, $mailarr);
                            sendmail($to, $subject, ['content' => $message]);
                            return redirect('front.dashboard');
                            break;
                        case '5':
                            return view('front.tfacode');
                            break;
                        case '2':
                            Session::flash('error', 'Email or password is wrong');
                            return redirect()->back();
                            break;
                        case '3':
                            Session::flash('error', 'Your account is deactive');
                            return redirect()->back();
                            break;
                        case '4':
                            Session::flash('error', 'Email or password is wrong / User doesnot exist');
                            return redirect()->back();
                            break;
                        case '6':
                            Session::flash('error', 'Please Verify your email address to Login');
                            return redirect()->back();
                            break;
                        case '7':
                            Session::flash('error', 'Please Complete your KYC');
                            return redirect('/kyc');
                            break;

                        case '8':
                            Session::flash('error', 'Please Verify your Mobile Number to Login');
                            return redirect()->back();
                            break;

                        case '9':
                            Session::flash('info', 'Your kyc is under process');
                            return redirect('/kyc');
                            break;

                        case '10':
                            Session::flash('info', 'Welcome to GRAVITAS');
                            return redirect('/dashboard');
                            break;

                        case '11':
                            Session::flash('error', 'Your KYC is Rejected');
                            return redirect('/kyc');
                            break;


                        default:
                            Session::flash('error', 'Email Id Does Not exist');
                            return redirect()->back();
                            break;
                    }

                }

                return view('front.login', ['user_id' => 0]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }

    }


    //User Login Check  
    function user_login_check($email, $password)
    {
        try{
        $spl = explode("@", $email);
        $user1 = $spl[0];
        $user2 = $spl[1];
        $res = $this->checking($user1, $user2);


        if ($res) {
            foreach ($res as $val) {
                $recordid = $val->id;
                $recordpass = $val->pass_code;
                if (Hash::check($password, $recordpass)) {
                    if ($val->status == '1' && ($val->tfa_status == 'disable' || $val->tfa_status == '')) {
                        //log
                        last_activity(get_usermail($recordid), 'Login', $recordid);
                        $sess = array('alphauserid' => $recordid, 'alphausername' => $val->enjoyer_name, 'xinfinpass' => $password);
                        Session::put($sess);
                        if ($val->document_status == '0') {
                            return "7";
                        } else if ($val->document_status == '3') {
                            return '9';
                        } elseif ($val->document_status == '1') {
                            return '10';
                        } elseif ($val->document_status == '2') {
                            return '11';
                        }

                    } elseif ($val->status == '1' && $val->tfa_status == 'enable') {
                        //log
                        last_activity(get_usermail($recordid), 'Login', $recordid);
                        Session::put('tfa_key', ownencrypt($recordid));
                        return "5";
                    } elseif ($val->verify_status == '2') {
                        return "6";
                    }

// elseif ($val->mobile_status == '0') {
//                        return "7";
//                    }
                    else {
                        return "3";
                    }

                } else {
                    return "2";
                }

            }
        } else {
            return "4";
        }
    }catch(\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return view('errors.404');
        
    }
    }


    //Forgot Password
    function forgotpass(Request $request)
    {
        try{
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'forgot_mail' => 'required|email',
                ], [
                    'forgot_mail.required' => 'Email id is required',
                    'forgot_mail.email' => 'Enter valid email id',
                ]);
                $email = strtolower($request['forgot_mail']);
                $spl = explode("@", $email);
                $user1 = $spl[0];
                $user2 = $spl[1];
                $res = $this->checking($user1, $user2);

                if (count($res) > 0) {
                    foreach ($res as $val) {
                        $to = $email;
                        $subject = get_template('5', 'subject');
                        $message = get_template('5', 'template');
                        $mailarr = array(
                            '###USERNAME###' => $val->enjoyer_name,
                            '###LINK###' => url('resetpassword/' . $val->forgot_code),
                            '###SITENAME###' => get_config('site_name'),
                            '###SITELINK###' => url('http://ico.foodcode.io'),
                        );
                        $message = strtr($message, $mailarr);
                        $subject = strtr($subject, $mailarr);
                        sendmail($to, $subject, ['content' => $message]);

                        Session::flash('success', 'Check your mail we have sent password reset link');
                        return redirect('/forgotpass');
                    }
                } else {
                    Session::flash('error', 'This email ID is not exist in our database.');
                    return redirect('/forgotpass');
                }

            }
            return view('front.forgotpass');
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Reset Password
    function resetpassword(Request $request, $code)
    {
        try{
            if ($code) {
                $check = Users::where('forgot_code', $code)->first();
                if ($check) {

                    if ($request->isMethod('post')) {
                        $this->validate($request, [
                            'password' => 'required|confirmed|min:6',
                            'password_confirmation' => 'required|min:6',
                        ]);

                        $forgot_code = mt_rand(111111, 999999) . time();
                        $check->forgot_code = $forgot_code;
                        $check->pass_code = bcrypt($request['password']);
                        $check->save();
                        //log
                        last_activity(get_usermail($check->id), 'Reset Password', $check->id);
                        Session::flash('success', 'Successfully password is reset');
                        return redirect('/login');
                    }

                    return view('front.newpass', ['code' => $code]);

                } else {
                    Session::flash('error', 'Invalid Link');
                    return redirect('/forgotpass');
                }
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Dashboard
    function dashboard()
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {


                $user_id = Session::get('alphauserid');
    //            check_live_address($user_id)
                $document_status = get_user_details($user_id, 'document_status');

                if ($document_status != 1) {
                    Session::flash('error', 'Your kyc is not completed.');
                    return redirect('/kyc');
                } else {
                    return view('front.dashboard', ['data' => '']);
                }

            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Distribution
    function distribution()
    {
        try {

            if (Session::get('alphauserid') == "") {
                return redirect('/');
            } else {
                // Session::flash('success','Token sale has been closed');
                // return redirect('wallets');
                $icotoken_total = ICOTrade::where('Status', 'Completed')->sum('Total');
                return view('front.distribution', ['total' => $icotoken_total]);
            }
        } catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Documents
    function documents()
    {
        return view('front.document');
    }


    //Contact Us
    function contact_us(Request $request)
    {
        try{
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'enquiry_name' => 'required',
                    'enquiry_email' => 'required|email',
                    'telephone' => 'required',
                    'enquiry_message' => 'required',

                ]);

                $ins = new Enquiry;
                $enquiry_name = $request['enquiry_name'];
                $enquiry_email = $request['enquiry_email'];
                $enquiry_subject = $request['enquiry_subject'];
                $telephone = $request['telephone'];
                $enquiry_message = $request['enquiry_message'];

                $message = get_template('18', 'template');
                $subject = get_template('18', 'subject');
                $mailarr = array(
                    '###NAME###' => $enquiry_name,
                    '###MOBILE###' => $telephone,
                    '###EMAIL###' => $enquiry_email,
                    '###MESSAGE###' => $enquiry_message,
                    '###SITENAME###' => get_config('site_name'),
                );
                //email body
                $to = 'support@gravitas.io';
                $username = $enquiry_name;
                $message = strtr($message, $mailarr);
                $subject = strtr($subject, $mailarr);
                if (sendmail($to, $subject, ['content' => $message])) {
                    Session::flash('success', 'Your Message Successfully sent to Administrator');
                };

                return redirect('contact_us');

            }
            return view('front.support');
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


   
    //KYC
    function kyc_details(Request $request)
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                if ($request->isMethod('post')) {
                    $user_id = Session::get('alphauserid');
                    $verification = Verification::where('user_id', $user_id)->first();
                    if ($verification == null) {
                        $verification = new Verification();
                    }

                    $verification->user_id = $user_id;
                    $verification->proof1_status = 0;
                    $verification->proof2_status = 0;
                    $verification->proof3_status = 0;
                    $verification->first_name = $request['first_name'];
                    $verification->last_name = $request['last_name'];
                    $verification->country_code = $request['country_id'];
                    $verification->gender = $request['gender'];
                    $verification->mob_isd = $request['isdcode'];
                    $verification->mobile_no = $request['phone_no'];

                    $verification->status = 'Pending';
                    if ($request['f_side']) {
                        $info = pathinfo($_FILES['f_side']['name']);
                        $ext = $info['extension'];
                        $file_name = $user_id . '_' . 'f_side.' . $ext;

                        $target = $_SERVER['DOCUMENT_ROOT'] . '/uploads/users/documents/' . $file_name;
                        move_uploaded_file($_FILES['f_side']['tmp_name'], $target);
                        $verification->proof1 = $file_name;
                    }
                    if ($request['b_side']) {
                        $info = pathinfo($_FILES['b_side']['name']);
                        $ext = $info['extension'];
                        $file_name = $user_id . '_' . 'b_side.' . $ext;

                        $target = $_SERVER['DOCUMENT_ROOT'] . '/uploads/users/documents/' . $file_name;
                        move_uploaded_file($_FILES['b_side']['tmp_name'], $target);
                        $verification->proof2 = $file_name;
                    }
                    if ($request['h_side']) {
                        $info = pathinfo($_FILES['h_side']['name']);
                        $ext = $info['extension'];
                        $file_name = $user_id . '_' . 'h_side.' . $ext;

                        $target = $_SERVER['DOCUMENT_ROOT'] . '/uploads/users/documents/' . $file_name;
                        move_uploaded_file($_FILES['h_side']['tmp_name'], $target);
                        $verification->proof3 = $file_name;
                    }

                    if ($verification->save()) {
                        $user = Users::where('id', $user_id)->first();
                        $user->document_status = 3;
                        $user->country = $request['country_id'];
                        $user->save();
                        Session::flash('success', 'Your Kyc Verification request is placed.');
                        return view('front.kyc_done', ['document_status' => 3]);
                    }
                } else {
                    $user_id = Session::get('alphauserid');
                    $document = get_user_details($user_id, 'document_status');

                    if ($document == 0) {
                        $country = Country::orderBy('name', 'asc')->get();
                        return view('front.kyc', ["country" => $country]);
                    } else if ($document == 2) {

                        $country = Country::orderBy('name', 'asc')->get();
                        Session::flash('error', 'Your Kyc Verification request is rejected.');
                        return view('front.kyc', ["country" => $country]);

                    } else if ($document == 3) {
                        Session::flash('error', 'Your Kyc Verification request is under process.');
                        return view('front.kyc_done', ['document_status' => $document]);
                    } else {
                        Session::flash('success', 'Your Kyc Verification is completed.');
                        return view('front.kyc_done', ['document_status' => $document]);
                    }

                }
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Doc Submission
    function document_submission(Request $request)
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                $userid = Session::get('alphauserid');
                if ($request->isMethod('post')) {
                    $this->validate($request, [
                        'proof1' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                        'proof2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                        'proof3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    ], [
                        'proof1.image' => 'Pan card upload image format',
                        'proof2.image' => 'Adhaar card upload image format',
                        'proof3.image' => 'Address proof upload image format',
                    ]);

                    $ins = Verification::firstOrCreate(['user_id' => $userid]);
                    if ($request->hasFile('proof1')) {
                        $proof1 = 'PAN' . time() . '.' . $request->proof1->getClientOriginalExtension();
                        $request->proof1->move(public_path('uploads/users/documents'), $proof1);
                        $ins->proof1 = $proof1;
                        $ins->proof1_status = '0';
                    }

                    if ($request->hasFile('proof2')) {
                        $proof2 = 'ADHAAR' . time() . '.' . $request->proof2->getClientOriginalExtension();
                        $request->proof2->move(public_path('uploads/users/documents'), $proof2);
                        $ins->proof2 = $proof2;
                        $ins->proof2_status = '0';
                    }

                    if ($request->hasFile('proof3')) {
                        $proof3 = 'AD' . time() . '.' . $request->proof3->getClientOriginalExtension();
                        $request->proof3->move(public_path('uploads/users/documents'), $proof3);
                        $ins->proof3 = $proof3;
                        $ins->proof3_status = '0';
                    }
                    $ins->user_id = $userid;
                    $ins->save();

                    $upt = Users::where('id', $userid)->first();
                    $upt->document_status = '0';
                    $upt->save();

                    Session::flash('success', 'Successfully KYC documents submited.');
                }
                return redirect('profile#kycdocuments');

            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Wallets
    function wallets()
    {
        try {
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {

                $userid = Session::get('alphauserid');

                $document_status = get_user_details($userid, 'document_status');

                if ($document_status != 1) {
                    Session::flash('error', 'Your kyc is not completed.');
                    return redirect('/kyc');
                }

                // check_live_address($userid);
                // $btc_address = get_user_details($userid, 'BTC_addr');
                $eth_address = get_user_details($userid, 'ETH_addr');
                // $usdt_address = get_user_details($userid, 'USDT_addr');
                $icotoken_address = get_user_details($userid, 'icotoken_addr');

                $get_user_bal = UserBalance::where('user_id', $userid)->first();
                // $btc_bal = $get_user_bal->BTC;
                $eth_bal = $get_user_bal->ETH;
                // $usdt_bal = $get_user_bal->USDT;
                $icotoken = $get_user_bal->GIFT;
                $bal = array('ETH' => $eth_bal, 'GIFT' => $icotoken);
                $eth_usd =
                // $address_history = array('BTC' => $btc_address, 'ETH' => $eth_address, 'USDT' => $usdt_address, 'GIFT' => $icotoken_address);
                $address_history = array('ETH' => $eth_address, 'GIFT' => $icotoken_address);
                return view('front.wallets', ['address' => $address_history, 'Bal' => $bal]);
            }
        } catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //ICO Page
    function index()
    {
        try{
            if (Session::get('alphauserid') == "") {

            //    $icotoken_total = ICOTrade::where('Status', 'Completed')->sum('Total');
                $icotoken_total = 0;
                $bonus = ico_bonus::where('status', 1)->first();
                $bonus_name = $bonus->bonusLevel;
                $url = "http://gravitas.io/";
                return $url;
            } else {
                $number = ownencrypt('');
                $user_id = Session::get('alphauserid');
            //    check_live_address($user_id)
                $document_status = get_user_details($user_id, 'document_status');

                if ($document_status != 1) {
                    Session::flash('error', 'Your kyc is not completed.');
                    return redirect('/kyc');
                } else {
                    return redirect('/dashboard');
                }

            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }

    }


    //Transactions
    function ico_history()
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {

                $userid = Session::get('alphauserid');

                $document_status = get_user_details($userid, 'document_status');

                if ($document_status != 1) {
                    Session::flash('error', 'Your kyc is not completed.');
                    return redirect('/kyc');
                }
                $trade_history = ICOTrade::where('user_id', $userid)->orderBy('id', 'desc')->get();
                return view('front.transactions', ['results' => $trade_history]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Get OTP

    function getotp()
    {
        echo owndecrypt('DAY9JjHYcFlfDpn8zqSCTyXSzLQepRP1nVIP7f8Vqgg=');

    }


    //Check OTP code
    function checkotpcode($code, $type)
    {
        try{
            $userid = Session::get('alphauserid');
            $mobile = get_user_details($userid, 'mobile_no');
            $check = OTP::where('mobile_no', $mobile)->where('otp', ownencrypt($code))->where('activity', $type)->orderBy('id', 'desc')->limit(1)->first();
            if (count($check) > 0) {

                try {
                    OTP::where('mobile_no', $mobile)->where('otp', ownencrypt($code))->where('activity', $type)->orderBy('id', 'desc')->delete();
                } catch (\Exception $e) {
                    echo $e;
                }

                return true;
            } else {
                return false;
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }


    //Logout Session
    function sessionlogout()
    {
        try{
            Session::flush();
            Cache::flush();
            if (Session::get('alphauserid') == "") {
                sleep(1);
                return redirect('login');
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
    }


    //Logout
    function logout()
    {
        try{
            Session::flush();
            Cache::flush();
            if (Session::get('alphauserid') == "") {
                return redirect('sessionlogout');
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }


    function checkphone($mobile_no)
    {
        try{
            $numbers = Users::all()->filter(function ($record) use ($mobile_no) {
                if (owndecrypt($record->mobile_no) == $mobile_no) {
                    return $record;
                } else {
                    return false;
                }
            });
            return $numbers;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }

    //owndecrypt
    function owndecryptAddress(Request $request)
    {
        try{
            // echo $_SERVER["DOCUMENT_ROOT"];
            $bitcoin_username = owndecrypt(get_wallet_keydetail('BTC', 'XDC_username'));
            $bitcoin_password = owndecrypt(get_wallet_keydetail('BTC', 'XDC_password'));
            $bitcoin_portnumber = owndecrypt(get_wallet_keydetail('BTC', 'portnumber'));
            $bitcoin_host = owndecrypt(get_wallet_keydetail('BTC', 'host'));

            return json_encode(array('Username' => $bitcoin_username, 'Password' => $bitcoin_password, 'Port' => $bitcoin_portnumber, 'Host' => $bitcoin_host));
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }


    function deposit()
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {

                $bitcoin_ip = ownencrypt('78.129.229.96');
                $bitcoin_user = ownencrypt('icobitcoin');
                $bitcoin_password = ownencrypt('ICOExCash@2018%');
                $bitcoin_port = ownencrypt('9555');
                $userid = Session::get('alphauserid');
                check_live_address($userid);
                if (get_user_details($userid, 'document_status') != '1') {
                    // Session::flash('error','Please Complete your KYC process');
                    //  return redirect('profile');
                }
                $id = encrypt('rhfzdZgZPTSqGVW41cwdfG4uudEhMwnd22');
                $sec = encrypt('snLgURciFLKyZZmW21zN1UyRCa2mC');
                $result = Users::where('id', $userid)->first();
                $xrpResult = SiteSettings::all()->first();
                return view('front.deposit', ['result' => $result, 'Xrpresult' => $xrpResult]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }

    function wallet()
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                $userid = Session::get('alphauserid');
                if (get_user_details($userid, 'document_status') != '1') {
                    //Session::flash('error','Please Complete your KYC process');
                    //return redirect('profile');
                }
                return view('front.wallet', ['userid' => $userid]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }

    function transfercrypto($currency = "")
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {

                Session::flash('error', 'Withdrawal will be active after ico');
                return redirect()->back();
                $userid = Session::get('alphauserid');
                if ($currency == "") {
                    $currency = 'ETH';
                }

                if ($currency != "") {
                    $userid = Session::get('alphauserid');

                    if (get_user_details($userid, 'document_status') != '1') {
                        //Session::flash('error','Please Complete your KYC process');
                        // return redirect('profile');
                    }

                    $currency = strtoupper($currency);

                    $data = ['urlcurrency' => ownencrypt($currency), 'currency' => $currency, 'userid' => $userid];
                    return view('front.transfer', $data);
                } else {
                    return redirect('logout');
                }
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }

    function transferverify(Request $request, $currency)
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                if ($request->isMethod('post')) {

                    $userid = Session::get('alphauserid');
                    $this->validate($request, [
                        'to_addr' => 'required',
                        'to_amount' => 'required',
                        'total_amount' => 'required',
                        'otp_code' => 'required',
                    ]);
                    if ($request['total_amount'] == 0) {
                        Session::flash('error', 'Wrong amount entered');
                        return redirect()->back();
                    }
                    if (strtolower($request['to_addr']) == get_user_details($userid, $currency . '_addr')) {
                        Session::flash('error', 'To address as same as your address check it');
                        return redirect()->back();
                    }
                    if ($request['total_amount'] > get_userbalance($userid, $currency)) {
                        Session::flash('error', 'Insuffient Balance');
                        return redirect()->back();
                    }
                    if (!$this->checkotpcode($request['otp_code'], 'Withdraw Request')) {
                        Session::flash('error', 'OTP Code is wrong');
                        return redirect()->back();
                    }
                    if ($currency = owndecrypt($request['key'])) {
                        $to_addr = $request['to_addr'];
                        $amount = $request['to_amount'];
                        $paid_amount = $request['total_amount'];
                        $fee = $amount - $paid_amount;

                        if ($currency == 'XRP') {
                            $xrp_desttag = $request['xrp_desttag'];
                        } else {
                            $xrp_desttag = "";
                        }

                        $transid = 'TXW' . $userid . time();
                        $today = date('Y-m-d H:i:s');
                        $ip = \Request::ip();
                        $ins = new Transaction;
                        $ins->user_id = $userid;
                        $ins->payment_method = 'Cryptocurrency Account';
                        $ins->transaction_id = $transid;
                        $ins->currency_name = $currency;
                        $ins->type = 'Withdraw';
                        $ins->transaction_type = '2';
                        $ins->amount = $amount;
                        $ins->updated_at = $today;
                        $ins->crypto_address = $to_addr;
                        $ins->transfer_amount = '0';
                        $ins->fee = $fee;
                        $ins->tax = '0';
                        $ins->verifycode = '1';
                        $ins->order_id = '0';
                        $ins->status = 'Pending';
                        $ins->cointype = '2';
                        $ins->payment_status = 'Not Paid';
                        $ins->paid_amount = $paid_amount;
                        $ins->wallet_txid = '';
                        $ins->ip_address = $ip;
                        $ins->verify = '1';
                        $ins->blocknumber = '';
                        $ins->xrp_desttag = $xrp_desttag;
                        $ins->ledgerversion = '';
                        if ($ins->save()) {
                            $fetchbalance = get_userbalance($userid, $currency);
                            $uptamt = $fetchbalance - $amount;
                            $upt = Balance::where('user_id', $userid)->first();
                            $upt->$currency = $uptamt;
                            $upt->save();
                            Session::flash('success', 'Withdraw request Successfully transfered to Admin');
                            return redirect('/dashboard');

                        }
                    }
                }
                return redirect()->back();
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }


    function deposit_history()
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                $userid = Session::get('alphauserid');

                if (get_user_details($userid, 'document_status') != '1') {
                    //Session::flash('error','Please Complete your KYC process');
                    // return redirect('profile');
                }

                $result = Transaction::where(['type' => 'Deposit', 'user_id' => $userid])->orderBy('created_at', 'desc')->paginate(10);
                return view('front.history', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }

    function transfer_history()
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                $userid = Session::get('alphauserid');

                if (get_user_details($userid, 'document_status') != '1') {
                    //Session::flash('error','Please Complete your KYC process');
                    //return redirect('profile');
                }
                $result = Transaction::where(['type' => 'Withdraw', 'user_id' => $userid])->orderBy('created_at', 'desc')->paginate(10);
                return view('front.transfer_history', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }


    function exchange_mail($userid, $fircur, $sec_cur, $type, $status, $amt)
    {
        try{

            $to = get_usermail($userid);
            $subject = get_template('8', 'subject');
            $message = get_template('8', 'template');
            $mailarr = array(
                '###USERNAME###' => get_user_details($userid, 'enjoyer_name'),
                '###LINK###' => url('/'),
                '###TYPE###' => $type,
                '###FCURRENCY###' => $fircur,
                '###STATUS###' => $status,
                '###SITENAME###' => get_config('site_name'),
                '###AMT###' => $amt,
            );
            $message = strtr($message, $mailarr);
            $subject = strtr($subject, $mailarr);
            sendmail($to, $subject, ['content' => $message]);
            return true;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }

    function update_profit($userid, $fee, $curr, $type)
    {
        try{
            $ins = new profit;
            $ins->userId = $userid;
            $ins->theftAmount = $fee;
            $ins->theftCurrency = $curr;
            $ins->type = $type;
            $ins->date = date('Y-m-d');
            $ins->time = date('H:i:s');
            $ins->save();
            return true;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }

    function exchange_history($pair = "")
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                $userid = Session::get('alphauserid');

                if (get_user_details($userid, 'document_status') != '1') {
                    // Session::flash('error','Please Complete your KYC process');
                    //  return redirect('profile');
                }
                if ($pair == 'all' || $pair == "") {
                    $pair = ['XDC-ETH', 'XDC-BTC', 'XDC-XRP'];
                } else {
                    $pair = $pair ? $pair : 'XDC-ETH';
                    $checkpair = Pair::where(['type' => 'exchange', 'pair' => $pair])->count();
                    if ($checkpair == 0) {
                        abort(404);
                    }
                    $pair = [$pair];
                }

                $result = Transaction::where(['user_id' => $userid])->whereIn('pair', $pair)->orderBy('created_at', 'desc')->paginate(10);
                return view('front.ex_history', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }


    function wallet_history($currency = "")
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                $userid = Session::get('alphauserid');

                if (get_user_details($userid, 'document_status') != '1') {
                    //Session::flash('error','Please Complete your KYC process');
                    // return redirect('profile');
                }
                $currency = $currency ? $currency : 'XDC';
                $result = Transaction::where(['type' => 'Deposit', 'currency_name' => $currency, 'user_id' => $userid])->orderBy('created_at', 'desc')->paginate(10);

                $withresult = Transaction::where(['type' => 'Withdraw', 'currency_name' => $currency, 'user_id' => $userid])->orderBy('created_at', 'desc')->paginate(10);
                return view('front.wallethistory', ['result' => $result, 'withresult' => $withresult, 'currency' => $currency]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }


    // end class

    function decryptnumber(Request $request)
    {
        try{
            $user_emailid = $request['emailid'];
            $mobile_no = ($request['mobile']);
            //        $spl = explode("@", $user_emailid);
            //        $user1 = $spl[0];
            //        $user2 = $spl[1];
            //        $enUser1 = encrypt($user1);
            //        $enUser2 = encrypt($user2);
            //        $decryptedValue = owndecrypt("37T5+m695WeP0DACf4gsPicoUVS3VH+P+Nfkjt+RsVw=");
            //        $encryt = ownencrypt("9472729405");
            $data = array();
            $numbers = Users::all()->filter(function ($record) use ($mobile_no) {
                if (owndecrypt($record->mobile_no) == $mobile_no) {
                    return $record;
                }
            });
            //        $items = Users::all()->filter(function ($record) use ($user1, $user2) {
            //            if (decrypt($record->end_user1) == $user1 && decrypt($record->end_user2) == $user2) {
            //                return $record;
            //            } else {
            //                return false;
            //            }
            //        });

            if ($numbers) {
                foreach ($numbers as $result) {
                    $data['status'] = 'success';
                    $data['userName'] = $result->getAttributeValue('enjoyer_name');
                    $data['first_name'] = $result->getAttributeValue('first_name');
                    $data['last_name'] = $result->getAttributeValue('last_name');
                    $data['userid'] = $result->getAttributeValue('id');
                    $data['mobile_number'] = owndecrypt($result->getAttributeValue('mobile_no'));
                    $data['mobile_status'] = $result->getAttributeValue('mobile_status');
                    $data['mob_isd'] = $result->getAttributeValue('mob_isd');
                }

            } else {
                $data['status'] = 'success';
                $data['last_ETH_price'] = 0.0000;
                $data['last_XRP_price'] = 0.0000;
                $data['last_BTC_price'] = 0.0000;
            }
            die(json_encode($data));
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
    }

    //decrypt
    function decryptAddress(Request $request)
    {
        echo decrypt($request['add']);
    }

    //decrypt
    function encryptdetails(Request $request)
    {

        $email = strtolower($request['email']);
        $splemail = explode("@", $email);
        $end_user1 = encrypt($splemail[0]);
        $end_user2 = encrypt($splemail[1]);
        $pass = ownencrypt($request['pass']);

        $arra = array('e1' => $end_user1, 'e2' => $end_user2, 'pass' => $pass, 'mob' => ownencrypt($request['mobile']));
        echo json_encode($arra);

    }

    function currentDateTime()
    {
        $dateTime = date('Y-m-d H:i:s');
        $json_array = array('date' => $dateTime);
        echo json_encode($json_array);
    }



    //Create ETH address
    function create_eth_address()
    {
        try{
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://37.58.56.226/testeth.php",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Cache-Control: no-cache",
                        "Content-Type: application/json",
                        "Postman-Token: 488c788f-4576-c48c-3605-1999db4f013a"
                    ),
                ));

                $response = curl_exec($curl);
                if (curl_errno($curl))
                    echo 'Curl error: ' . curl_error($curl);

                if ($response) {
                    $result = json_decode($response);
                    curl_close($curl);
                    return $result->result;
                } else {
                    curl_close($curl);
                    return '';
                }
            }catch(\Exception $e) {
                \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
                return view('errors.404');
                
                }
    }


    //Create BTC address
    function create_btc_address()
    {
        try{
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://37.58.56.226/testeth.php",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Cache-Control: no-cache",
                        "Content-Type: application/json",
                        "Postman-Token: 488c788f-4576-c48c-3605-1999db4f013a"
                    ),
                ));

                $response = curl_exec($curl);
                if (curl_errno($curl))
                    echo 'Curl error: ' . curl_error($curl);

                if ($response) {
                    $result = json_decode($response);
                    curl_close($curl);
                    return $result->result;
                } else {
                    curl_close($curl);
                    return '';
                }
            }catch(\Exception $e) {
                \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
                return view('errors.404');
                
            }

    }

    //Create USDT address
    function create_usdt_address()
    {
        try{
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://37.58.56.226/testeth.php",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json",
                    "Postman-Token: 488c788f-4576-c48c-3605-1999db4f013a"
                ),
            ));

            $response = curl_exec($curl);
            if (curl_errno($curl))
                echo 'Curl error: ' . curl_error($curl);

            if ($response) {
                $result = json_decode($response);
                curl_close($curl);
                return $result->result;
            } else {
                curl_close($curl);
                return '';
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }

    }

    //Create GIFT(ICOTOKEN) address
    function create_icotoken_address()
    {
        try{
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache",
                    "Content-Type: application/json",
                    "Postman-Token: 488c788f-4576-c48c-3605-1999db4f013a"
                ),
            ));

            $response = curl_exec($curl);
            if (curl_errno($curl))
                echo 'Curl error: ' . curl_error($curl);

            if ($response) {
                $result = json_decode($response);
                curl_close($curl);
                return $result->result;
            } else {
                curl_close($curl);
                return '';
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }

    }


    function node(Request $request)
    {
        try{
            $ip = \Request::ip();
            if ($ip == '103.43.160.227' || $ip == '1.22.228.8') {


                $bitcoin_portnumber = owndecrypt(get_wallet_keydetail('BTC', 'portnumber'));
                $bitcoin_host = owndecrypt(get_wallet_keydetail('BTC', 'host'));

                $btc = array('Port_Number' => $bitcoin_portnumber,
                    'BitcoinIP' => $bitcoin_host);

                return json_encode($btc);

            } else {
                return ('ip' . $ip);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }

    }


}