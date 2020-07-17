<?php

namespace App\Http\Controllers;

//use App\Jobs\MoveKey;
use App\model\Admin;
use App\model\Balance;
use App\model\Cms;
use App\model\Enquiry;
use App\model\Faq;
use App\model\Fees;
use App\model\ICORate;
use App\model\Marketprice;
use App\model\Metacontent;
use App\model\Node;
use App\model\OpeningBalance;
use App\model\OTP;
use App\model\ICOTrade;
use App\model\Profit;
use App\model\SiteSettings;
use App\model\Template;
use App\model\Trade;
use App\model\Tradingfee;
use App\model\Transaction;
use App\model\UserBalance;
use App\model\Users;
use App\model\Verification;
use App\model\Wallettrans;
use App\model\Whitelist;
use App\model\XDCChart;
use Cache;
use DateTime;
use DB;
use Hash;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use Validator;

//use Barryvdh\DomPDF\Facade as PDF;

class SiteadminController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('Adminlogin');
        $ip = \Request::ip();
        blockip_list($ip);
    }

    function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $validator = $this->validate($request, [
                'alpha_username' => 'required',
                'alpha_password' => 'required|min:6',
                'pattern' => 'required',
            ], [
                'alpha_username.required' => 'Email is required',
                'alpha_password.required' => 'Password is required',
                'alpha_password.min' => 'Password 6 characters is required',
            ]);

            $email = $request['alpha_username'];
            $password = $request['alpha_password'];
            $auth = $this->adminauth($email, $password);
            switch ($auth) {
                case '1':
                    return redirect('admin/home');
                    break;
                case '2':
                    Session::flash('error', 'Password is invalid');
                    return redirect('admin');
                    break;
                case '3':
                    return redirect('admin/pending_history');
                    break;
                case '5':
                    return redirect('admin/ico_history');
                    break;
                case '6':
                    return redirect('admin/kyc_users');
                    break;
                    case '0':
                    Session::flash('error', 'Account is deactive');
                    return redirect('admin');
                    break;

                default:
                    return redirect('admin');
                    break;
            }
        }

        return view('panel.login');
    }

    function adminauth($email, $password)
    {
        $arr = array('email_id' => $email, 'status' => 'active');
        $check = Admin::where($arr)->first();
        if ($check) {
            if (Hash::check($password, $check->XDC_password)) {
                $sess = array('alpha_id' => $check->id, 'role' => $check->role, 'alowner' => $email);

                Session::put($sess);
                owner_activity($email, 'Login');
                if ($check->XDC_username == "Admin") {
                    return 1;
                }
                else if($check->XDC_username == "ICOAdmin")
                {
                    return 5;

                }
                else
                    {
                        return 6;
                    }


            } else {
                return "2";
            }
        } else {
            return "0";
        }

    }

    function logout()
    {
        Session::flush();
        Cache::flush();
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        }
    }

    function home()
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {

            $sever_path = $_SERVER["DOCUMENT_ROOT"];
//            echo $sever_path;
            $adminethaddr = decrypt(get_config('eth_address'));
            $eth_bal = getting_eth_balance($adminethaddr);
            $adminbtcaddr = decrypt(get_config('btc_address'));
            try
            {
                $btc_bal = get_btc_wallet_info();
                $btc_bal1 = $btc_bal['balance'];
            }
            catch (\Exception $exception)
            {
                $btc_bal1 =0;
            }
           
         
            // $adminusdtaddr = decrypt(get_config('usdt_address'));
            // try
            // {
            //     $usdt_bal =  get_usdt_wallet_info();
            //     $usdt_bal1 = $usdt_bal['balance'];
            // }
            // catch (\Exception $exception)
            // {
            //     $usdt_bal1 =0;
            // }


//         $btc_bal1 = "0";

            $ico_result = ICOTrade::orderBy('updated_at','desc')->limit(25)->get();

            $user_balance_result = DB::table('userbalance')->get();

            return view('panel.home', ['result'=>$ico_result,'user_eth' => $user_balance_result->sum('ETH'), 'user_btc' => $user_balance_result->sum('BTC'),'eth_bal' => $eth_bal, 'btc_bal' => $btc_bal1]);
        }
    }

    //for trade admins view page
    function tradeadmin()
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $date = new DateTime;
            $date->modify('-1440 minutes');
            $formatted_date = $date->format('Y-m-d H:i:s');

            $result = DB::table('tokenusers')
                ->join('enjoyer', 'tokenusers.user_id', '=', 'enjoyer.id')
                ->where('tokenusers.created_at', '>=', $formatted_date)
                ->select('enjoyer.*', 'enjoyer.created_at')
                ->paginate(25);
            return view('panel.trade_admin', ['result' => $result, 'status' => 1]);
        }
    }

    function profile(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $alpha_id = Session::get('alpha_id');
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'admin_email' => 'required|email',
                    'admin_username' => 'required',
                    //'admin_phone' => 'numeric',
                ], [
                    'admin_email.required' => 'Email is required',
                    'admin_username.required' => 'Username is required',
                    //'admin_phone.required' => 'Phone number must numeric',
                ]);
                $upt = Admin::find($alpha_id);
                if ($request['curr_pass'] != "") {
                    $this->validate($request, [
                        'curr_pass' => 'required',
                        'password' => 'required|confirmed|min:6',
                        'password_confirmation' => 'required|min:6',
                    ]);

                    if (Hash::check($request['curr_pass'], get_adminprofile('XDC_password'))) {
                        $upt->XDC_password = bcrypt($request['password']);
                    } else {
                        Session::flash('error', 'Current password is wrong');
                        return redirect('admin/profile');
                    }

                }

                $upt->XDC_username = $request['admin_username'];
                $upt->email_id = $request['admin_email'];

                $upt->country = $request['admin_country'];
                if ($upt->save()) {
                    Session::flash('success', 'Successfully Updated');
                    return redirect('admin/profile');
                }
            }
            return view('panel.profile');
        }
    }

    function site_settings(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'site_name' => 'required',
                    'contact_mail' => 'required',
                    'country' => 'required',
                    'address' => 'required',
                    'facebook_url' => 'url',
                    'twitter_url' => 'url',
                    'google_url' => 'url',
                    'linkedin_url' => 'url',
                    'contact_no' => 'numeric',
                ]);
                $upt = SiteSettings::find(1);
                if ($request->hasFile('site_logo')) {
                    $this->validate($request, [
                        'site_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    ]);
                    $logo = time() . '.' . $request->site_logo->getClientOriginalExtension();
                    $request->site_logo->move(public_path('/logo'), $logo);
                    $upt->site_logo = $logo;
                }

                $upt->site_name = $request['site_name'];
                $upt->facebook_url = $request['facebook_url'];
                $upt->twitter_url = $request['twitter_url'];
                $upt->google_url = $request['google_url'];
                $upt->linkedin_url = $request['linkedin_url'];
                $upt->google_analytics = $request['google_analytics'];
                $upt->smtp_host = encrypt($request['smtp_host']);
                $upt->smtp_port = encrypt($request['smtp_port']);
                $upt->smtp_email = encrypt($request['smtp_email']);
                $upt->smtp_password = encrypt($request['smtp_password']);
                $upt->contact_mail = $request['contact_mail'];
                $upt->address = $request['address'];
                $upt->city = $request['city'];
                $upt->provience = $request['provience'];
                $upt->country = $request['country'];
                $upt->contact_no = $request['contact_no'];
                if ($upt->save()) {
                    Session::flash('success', 'Successfully Updated');
                    return redirect('admin/site_settings');
                }

            }
            return view('panel.site_settings');
        }
    }

    function checkpattern(Request $request)
    {
        if ($request->isMethod('post')) {
            $key1 = $request['key1'];
            $key2 = $request['key2'];
            $pattern = $key2 - $key1;
            $sitepat = get_superadmin('pattern');
            $original = decrypt($sitepat);
            if ($original == $pattern) {
                echo $original;
            } else {
                echo "12345";
            }
        }
    }

    function change_pattern()
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            return view('panel.change_pattern');
        }
    }

    function set_pattern(Request $request)
    {
        if ($request->isMethod('post')) {
            $key = $request['key'];
            $set = Admin::find(1);
            $set->pattern = encrypt($key);
            $set->save();
            Session::flash('success', 'Pattern changed Successfully');
            echo "true";
        }
    }

    function cms()
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $result = DB::table('cms')->orderBy('id', 'desc')->get();
            return view('panel.cms', ['result' => $result]);
        }
    }

    function updatecms(Request $request, $id)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {

            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'heading' => 'required',
                    'content' => 'required',
                ]);
                $upt = Cms::find($id);
                $upt->heading = $request['heading'];
                $upt->content = $request['content'];
                if ($upt->update()) {
                    Session::flash('success', 'Successfully updated');
                    return redirect('admin/cms');
                }
            }
            $result = DB::table('cms')->where('id', $id)->first();
            return view('panel.updatecms', ['result' => $result, 'id' => $id]);
        }
    }

    //validate_eth_block
    function validate_eth_block()
    {
        $balance = getting_eth_block();

        return view('panel.ether_block',['Current' => $balance->currentBlock, 'Highest' => $balance->highestBlock]);

    }

    function users(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {

            if ($request->isMethod('get')) {
                $min = $request['min'];
                $max = $request['max'];
                $search = $request['search'];
                $email = $request['email'];
                $status = $request['status'];
                $paging = $request['paging'];
                $q = Users::query();
                if ($min) {
                    $q->where('created_at', '>=', $min);
                }
                if ($max) {
                    $q->where('created_at', '<=', $max);
                }
                if ($search) {
                    $q->where(function ($qq) use ($search) {
                        $qq->where('id', 'like', '%' . $search . '%')->Orwhere('enjoyer_name', 'like', '%' . $search . '%');
                    });
                }

                if($status !='' && $status != 'all')
                {
                    $q->where('user_verified',$status);
                }
                if ($email) {
                    try
                    {
                        $spl = explode("@", $email);
                        $user1 = $spl[0];
                        $user2 = $spl[1];
                        $record = getByEmail($user1, $user2);

                        foreach ($record as $val) {
                            $user_id = $val->id;
                            $q->where('id', $user_id);
                        }

                    }
                    catch (\Exception $exception)
                    {
                        $result =Users::where('id', 0)->paginate(25);
                        return view('panel.users', ['result' => $result]);
                    }


                }


                $result = $q->orderBy('id', 'desc')->paginate($paging);
            } else {
                $result = Users::orderBy('id', 'desc')->paginate(25);
            }

            return view('panel.users', ['result' => $result]);
        }
    }

    function userbalance(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request['currency']) {
                $result = DB::table('userbalance')
                    ->join('enjoyer', 'userbalance.user_id', '=', 'enjoyer.id')
                    ->orderBy('userbalance.' . $request['currency'], 'desc')
                    ->select('userbalance.*', 'enjoyer.id', 'enjoyer.enjoyer_name','enjoyer.BTC_addr','enjoyer.ETH_addr')
                    ->paginate(25);
            } elseif ($request->isMethod('get')) {

                $search = $request['search'];
                $email = $request['email'];
                $user_search_id = $request['user_search_id'];
                $q = UserBalance::query();
                $q->join('enjoyer', 'userbalance.user_id', '=', 'enjoyer.id')->select('userbalance.*', 'enjoyer.enjoyer_name','enjoyer.BTC_addr','enjoyer.ETH_addr');

                if ($search) {
                    $q->where(function ($qq) use ($search) {
                        $qq->where('enjoyer_name', 'like', '%' . $search . '%');
                    });
                }
                if ($email) {
                    try
                    {
                        $spl = explode("@", $email);
                        $user1 = $spl[0];
                        $user2 = $spl[1];
                        $record = getByEmail($user1, $user2);

                        foreach ($record as $val) {
                            $user_id = $val->id;
                            $q->where('userbalance.user_id', $user_id);
                        }

                    }
                    catch (\Exception $exception)
                    {
                        $result = DB::table('userbalance')
                            ->join('enjoyer', 'userbalance.user_id', '=', 'enjoyer.id')
                            ->where('userbalance.user_id',0)
                            ->orderBy('userbalance.user_id', 'asc')
                            ->select('userbalance.*', 'enjoyer.enjoyer_name', 'enjoyer.enjoyer_name','enjoyer.BTC_addr','enjoyer.ETH_addr')
                            ->paginate(25);
                        return view('panel.userbalance', ['result' => $result, 'Header' => 'User Wallet Balance']);
                    }
                }

                if ($user_search_id) {
                    $q->where('userbalance.user_id', $user_search_id);
                }

                $result = $q->orderBy('userbalance.user_id', 'asc')->paginate(25);
            } else {
                $result = DB::table('userbalance')
                    ->join('enjoyer', 'userbalance.user_id', '=', 'enjoyer.id')
                    ->orderBy('userbalance.user_id', 'asc')
                    ->select('userbalance.*', 'enjoyer.enjoyer_name', 'enjoyer.enjoyer_name','enjoyer.BTC_addr','enjoyer.ETH_addr')
                    ->paginate(25);
            }

            return view('panel.userbalance', ['result' => $result, 'Header' => 'User Wallet Balance']);
        }
    }

    function update_userbal(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $result = UserBalance::where('user_id', $request['user_id'])->first();

            // $btc = $result->BTC;
            $eth = $result->ETH;
            $icotoken = $result->GIFT;

            if ($request['currency']) {
                $result->XDC = $request['amount'];
                if ($result->update()) {
                    $transid = 'TXD' . $request['user_id'] . time();
                    $today = date('Y-m-d H:i:s');
                    $ip = \Request::ip();
                    $ins = new Transaction;
                    $ins->user_id = $request['user_id'];
                    $ins->payment_method = 'Cryptocurrency Account';
                    $ins->transaction_id = $transid;
                    $ins->currency_name = 'XDC';
                    $ins->type = 'Updated';
                    $ins->transaction_type = '1';
                    $ins->amount = $request['amount'];
                    $ins->updated_at = $today;
                    $ins->crypto_address = 'By Admin';
                    $ins->transfer_amount = '0';
                    $ins->fee = '0';
                    $ins->tax = '0';
                    $ins->verifycode = '1';
                    $ins->order_id = '0';
                    $ins->status = 'Completed';
                    $ins->cointype = '2';
                    $ins->payment_status = 'Paid';
                    $ins->paid_amount = '0';
                    $ins->wallet_txid = '';
                    $ins->ip_address = $ip;
                    $ins->verify = '1';
                    $ins->blocknumber = '';
                    $ins->save();

                }
            } else {
                // $result->BTC = $request['btc'];
                $result->ETH = $request['eth'];
                $result->GIFT = $request['icotoken'];
                if ($result->update()) {
                    $transid = 'TXD' . $request['user_id'] . time();
                    $today = date('Y-m-d H:i:s');
                    $ip = \Request::ip();


                    // if ($btc != $request['btc']) {
                    //     $ins = new Transaction;
                    //     $ins->user_id = $request['user_id'];
                    //     $ins->payment_method = 'Cryptocurrency Account';
                    //     $ins->transaction_id = $transid;

                    //     $ins->type = 'Updated';
                    //     $ins->transaction_type = '1';

                    //     $ins->updated_at = $today;
                    //     $ins->crypto_address = 'By Admin';
                    //     $ins->transfer_amount = '0';
                    //     $ins->fee = '0';
                    //     $ins->tax = '0';
                    //     $ins->verifycode = '1';
                    //     $ins->order_id = '0';
                    //     $ins->status = 'Completed';
                    //     $ins->cointype = '2';
                    //     $ins->payment_status = 'Paid';
                    //     $ins->paid_amount = '0';
                    //     $ins->wallet_txid = '';
                    //     $ins->ip_address = $ip;
                    //     $ins->verify = '1';
                    //     $ins->blocknumber = '';

                    //     $ins->currency_name = 'BTC';
                    //     $ins->amount = $request['btc'];
                    //     $ins->save();
                    // }
                    if ($eth != $request['eth']) {
                        $ins = new Transaction;
                        $ins->user_id = $request['user_id'];
                        $ins->payment_method = 'Cryptocurrency Account';
                        $ins->transaction_id = $transid;

                        $ins->type = 'Updated';
                        $ins->transaction_type = '1';

                        $ins->updated_at = $today;
                        $ins->crypto_address = 'By Admin';
                        $ins->transfer_amount = '0';
                        $ins->fee = '0';
                        $ins->tax = '0';
                        $ins->verifycode = '1';
                        $ins->order_id = '0';
                        $ins->status = 'Completed';
                        $ins->cointype = '2';
                        $ins->payment_status = 'Paid';
                        $ins->paid_amount = '0';
                        $ins->wallet_txid = '';
                        $ins->ip_address = $ip;
                        $ins->verify = '1';
                        $ins->blocknumber = '';

                        $ins->currency_name = 'ETH';
                        $ins->amount = $request['eth'];
                        $ins->save();
                    }
                    if ($icotoken != $request['icotoken']) {
                        $ins = new Transaction;
                        $ins->user_id = $request['user_id'];
                        $ins->payment_method = 'Cryptocurrency Account';
                        $ins->transaction_id = $transid;

                        $ins->type = 'Updated';
                        $ins->transaction_type = '1';

                        $ins->updated_at = $today;
                        $ins->crypto_address = 'By Admin';
                        $ins->transfer_amount = '0';
                        $ins->fee = '0';
                        $ins->tax = '0';
                        $ins->verifycode = '1';
                        $ins->order_id = '0';
                        $ins->status = 'Completed';
                        $ins->cointype = '2';
                        $ins->payment_status = 'Paid';
                        $ins->paid_amount = '0';
                        $ins->wallet_txid = '';
                        $ins->ip_address = $ip;
                        $ins->verify = '1';
                        $ins->blocknumber = '';

                        $ins->currency_name = 'GIFT';
                        $ins->amount = $request['icotoken'];
                        $ins->save();
                    }
                }
            }


            Session::flash('success', $request['user_name'] . ' balance updated');
            if ($request['currency']) {
                return redirect('admin/users_balance_validation?currency=' . $request['currency']);
            } else {
                return redirect('admin/userbalance');
            }

        }
    }

    function updated_history(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request->isMethod('get')) {
                $min = $request['min'];
                $max = $request['max'];
                $currency = $request['currency'];
                $search = $request['search'];
                $q = Transaction::query();
                $q->select(DB::raw('XDC_enjoyer.enjoyer_name,XDC_transactions.*'));
                $q->join('enjoyer', 'transactions.user_id', '=', 'enjoyer.id');
                if ($currency == 'all' || $currency == '') {
                    $currency = ['BTC','ETH', 'USDT'];
                } else {
                    $currency = [$currency];
                }
                $q->where('type', 'Updated');
                $q->whereIn('currency_name', $currency);
                if ($min) {
                    $q->where('updated_at', '>=', $min);
                }

                if ($max) {
                    $q->where('updated_at', '<=', $max);
                }

                if ($search) {
                    $q->where(function ($qq) use ($search) {
                        $qq->where('transactions.transaction_id', 'like', '%' . $search . '%')->Orwhere('transactions.user_id', 'like', '%' . $search . '%')->Orwhere('transactions.amount', 'like', '%' . $search . '%')->Orwhere('enjoyer.enjoyer_name', 'like', '%' . $search . '%');
                    });
                }

                $result = $q->orderBy('transactions.id', 'desc')->paginate(25);
            } else {
                $result = Transaction::where('type', 'Updated')->where('status', 'Completed')->orderBy('id', 'desc')->paginate(25);
            }

            return view('panel.transactions', ['result' => $result,'type'=>'Updated']);
        }
    }

    //for userbalance tally
    function getTotal_Usersbalance()
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $adminxdcaddr = decrypt(get_config('xdc_address'));
            $xdc_bal = get_livexdc_bal($adminxdcaddr);

            $adminxdceaddr = decrypt(get_config('xdce_address'));
            $xdce_bal = get_livexdce_bal($adminxdceaddr);

            $adminethaddr = decrypt(get_config('eth_address'));
            $eth_bal = getting_eth_balance($adminethaddr);

            $adminxrpaddr = decrypt(get_config('xrp_address'));
            $xrp_res = get_xrp_balance($adminxrpaddr);

            $res = @$xrp_res->result;

            $adminbtcaddr = decrypt(get_config('btc_address'));
            $btc_bal = get_btc_wallet_info($adminbtcaddr);
            $btc_bal1 = $btc_bal['balance'];

            $adminbchaddr = decrypt(get_config('bch_address'));
            $bch_bal = get_bch_wallet_info($adminbchaddr);
            $bch_bal1 = $bch_bal['balance'];

            $result = DB::table('userbalance')->get();
            $result_array = array("ETH" => $result->sum('ETH'), "Admin_ETH" => $eth_bal, "BTC" => $result->sum('BTC'),"BCH" => $result->sum('BCH'), "Admin_BTC" => $btc_bal1, "Admin_BCH" => $bch_bal1,"XRP" => $result->sum('XRP'), "Admin_XRP" => $res, "XDC" => $result->sum('XDC'), "Admin_XDC" => $xdc_bal, "XDCE" => $result->sum('XDCE'), "Admin_XDCE" => $xdce_bal);
            echo json_encode($result_array);
        }
    }

    function faq()
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $result = Faq::orderBy('id', 'desc')->get();
            return view('panel.faq', ['result' => $result]);
        }
    }
    function confirm()
    {
        $result = Faq::orderBy('id', 'desc')->get();
        $flag = $this->ftp();
        switch($flag)
        {
            case '1' :
                Session::flash('success','FAQ updated.');
                break;
            case '2' :
                Session::flash('error','FAQ updated.');
                break;
            case '3' :
                Session::flash('error','There was an error in updating the FAQ.');
                break;
            case '4' :
                Session::flash('error','Failed to establish the connection.');
                break;
            case '5' :
                Session::flash('error','No such file found.');
                break;
        }
		return view('panel.faq', ['result' => $result]);
    }


    function add_faq(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'question' => 'required',
                    'description' => 'required',
                ]);

                $ins = new Faq();
                $ins->question = $request['question'];
                $ins->description = $request['description'];
                $ins->status = 1;
                $ins->created_at = date('Y-m-d H:i:s');
                if ($ins->save()) {
                    Session::flash('success', 'FAQ Successfully added');
                    return redirect('admin/faq');
                }
            }
            return view('panel.add_faq', ['view' => 'add']);
        }
    }

    function delete_faq($id)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $del = Faq::find($id);
            if ($del->delete()) {
                Session::flash('success', 'FAQ Successfully deleted');
                return redirect('admin/faq');
            }

        }
    }

    function status_faq($id)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $upt = Faq::find($id);
            if ($upt->status == 1) {
                $upt->status = '0';
            } else {
                $upt->status = '1';
            }
            if ($upt->save()) {
                Session::flash('success', 'FAQ Successfully updated');
                return redirect('admin/faq');
            }
        }
    }

    function update_faq(Request $request, $id)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'question' => 'required',
                    'description' => 'required',
                ]);

                $ins = Faq::find($id);
                $ins->question = $request['question'];
                $ins->description = $request['description'];
                if ($ins->save()) {
                    Session::flash('success', 'FAQ Successfully updated');
                    return redirect('admin/faq');
                }
            }
            $result = Faq::where('id', $id)->first();
            return view('panel.add_faq', ['result' => $result, 'view' => 'edit', 'id' => $id]);
        }
    }

    function mail_template()
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $result = Template::orderBy('id', 'desc')->get();
            return view('panel.mail_template', ['result' => $result]);
        }
    }

    function update_template(Request $request, $id)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'subject' => 'required',
                    'template' => 'required',
                ]);
                $upt = Template::find($id);
                $upt->subject = $request['subject'];
                $upt->template = $request['template'];
                if ($upt->save()) {
                    Session::flash('success', 'Template Successfully updated');
                    return redirect('admin/mail_template');
                }
            }
            $result = Template::where('id', $id)->first();
            return view('panel.update_template', ['result' => $result, 'id' => $id]);
        }
    }

    function contact_query()
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $result = Enquiry::orderBy('enquiry_id', 'desc')->get();
            return view('panel.contact_query', ['result' => $result]);
        }
    }

    function transactions(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request['min']) {
                $min = $request['min'];
                $max = $request['max'];
                $result = Transaction::where('updated_at', '>=', $min)
                    ->where('updated_at', '<=', $max)->where('type', '=', 'Buy')->orWhere('type', '=', 'Sell')->orderBy('id', 'desc')->paginate(25);
            } else {
                $result = Transaction::where('type', '=', 'Buy')->orWhere('type', '=', 'Sell')->orderBy('id', 'desc')->paginate(25);
            }

            return view('panel.transactions', ['result' => $result,'type'=>'Trade']);
        }
    }

    function profit(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request['min']) {
                $min = $request['min'];
                $max = $request['max'];
                $result = DB::table('coin_theft')
                    ->where('theftAmount', '>', 0)
                    ->where('updated_at', '>=', $min)
                    ->where('updated_at', '<=', $max)
                    ->orderBy('theft_id', 'desc')->paginate(25);
            } else {
                $result = DB::table('coin_theft')->where('theftAmount', '>', 0)->orderBy('theft_id', 'desc')->paginate(25);
            }

            return view('panel.profit', ['result' => $result]);
        }
    }

    function kyc_users(Request $request)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            if ($request['min']) {
                $min = $request['min'];
                $max = $request['max'];
                $result = Verification::orderBy('verification.id', 'desc')
                    ->join('enjoyer', 'verification.user_id', '=', 'enjoyer.id')
                    ->select('verification.*', 'enjoyer.enjoyer_name', 'enjoyer.document_status')
                    ->where('verification.updated_at', '>=', $min)
                    ->where('verification.updated_at', '<=', $max)
                    ->paginate(25);
            } else {
                $result = Verification::orderBy('verification.id', 'desc')
                    ->join('enjoyer', 'verification.user_id', '=', 'enjoyer.id')
                    ->select('verification.*', 'enjoyer.enjoyer_name', 'enjoyer.document_status')
                    ->paginate(25);
            }

            return view('panel.kyc_users', ['result' => $result]);
        }
    }

    function view_enquiry(Request $request, $id)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');
        } else {
            $result = Enquiry::where('enquiry_id', $id)->first();
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'answer' => 'required',
                ]);
                $ins = ['answer' => $request['answer'], 'enquiry_id' => $id];
                DB::table('enquiry_reply')->insert($ins);
                $upt = Enquiry::where('enquiry_id', $id)->update(['status' => 'replied']);
                $to = [$result->enquiry_email];
                $subject = get_template('1', 'subject');
                $message = get_template('1', 'template');
                $mailarr = array(
                    '###USERNAME###' => $result->enquiry_name,
                    '###QUESTION###' => $result->enquiry_message,
                    '###CONTENT###' => $request['answer'],
                    '###SITENAME###' => get_config('site_name'),
                );
                $message = strtr($message, $mailarr);
                $subject = strtr($subject, $mailarr);
                sendmail($to, $subject, ['content' => $message]);
                Session::flash('success', 'Successfully replied');
                return redirect('admin/contact_query');
            }

            $result_rply = DB::table('enquiry_reply')->where('enquiry_id', $id)->get();
            return view('panel.view_enquiry', ['result' => $result, 'result_rply' => $result_rply, 'id' => $id]);
        }
    }

    function status_users($id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $upt = Users::find($id);
                if ($upt->status == 1) {
                    $upt->status = 0;
                } else {
                    $upt->status = 1;
                }
                if ($upt->save()) {
                    Session::flash('success', 'Successfully status updated');
                    return redirect()->back();
                }
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function view_users($id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                // $check = check_live_address($id);
                $result = Users::where('id', $id)->first();
                $ether_value = verifyEther($result->ETH_addr);
                $icotoken_value = get_userbalance($id,'GIFT');
                $btc_value = verifyBTC($result->BTC_addr);
                $usdt_value = verifyUSDT($result->USDT_addr);


                if (Session::get('role') == 2) {
                    return view('panel.view_users_tradeadmin', ['result' => $result, 'id' => $id, 'BTC_Bal' => $btc_value, 'ETH_Bal' => $ether_value, 'USDT_Bal' => $usdt_value, 'GIFT_Bal' => $icotoken_value]);
                }
                return view('panel.view_users', ['result' => $result, 'id' => $id, 'BTC_Bal' => $btc_value, 'ETH_Bal' => $ether_value, 'USDT_Bal' => $usdt_value, 'GIFT_Bal' => $icotoken_value]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function view_kyc(Request $request, $id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $result = Verification::where('verification.id', $id)
                    ->join('enjoyer', 'verification.user_id', '=', 'enjoyer.id')
                    ->select('verification.*', 'enjoyer.enjoyer_name', 'enjoyer.document_status', 'enjoyer.first_name', 'enjoyer.last_name', 'enjoyer.status','verification.mob_isd','verification.mobile_no')
                    ->first();
                    
                if ($request->isMethod('post')) {
                    $validator = Validator::make($request->all(), [
                        'proof1_status' => 'required',
                    ]);
                    if($validator->fails())
                    {
                        return redirect()->back()->withErrors($validator);
                    }
                    $status = $request['kycstatus'];
                    $upt = Verification::find($id);
                    $upt->proof1_status = ($request['proof1_status'] == 'on') ? '1' : '0';
                    $upt->proof2_status = ($request['proof2_status'] == 'on') ? '1' : '0';
                    $upt->proof3_status = ($request['proof3_status'] == 'on') ? '1' : '0';
                    $upt->reason = ($status == 1) ? '' : $request['kycreason'];
                    $upt->save();

                    $upt1 = Users::find($result->user_id);
                    $upt1->document_status = $status;
                    $upt1->save();

                    if ($status == 1) {
                        $statusmessage = "Approved";
                    } else if ($status == 2) {
                        $statusmessage = "Rejected";
                    } else {
                        $statusmessage = "Pending";
                    }

                    $to = [get_usermail($result->user_id)];
                    $subject = get_template('2', 'subject');
                    $message = get_template('2', 'template');
                    $mailarr = array(
                        '###USERNAME###' => $result->enjoyer_name,
                        '###STATUS###' => $statusmessage,
                        '###REASON###' => ($status == 1) ? '' : $request['kycreason'],
                        '###SITENAME###' => get_config('site_name'),
                    );
                    $message = strtr($message, $mailarr);
                    $subject = strtr($subject, $mailarr);
                    sendmail($to, $subject, ['content' => $message]);

                    Session::flash('success', 'KYC Status Successfully Updated');
                    return redirect('admin/kyc_users');

                }

                return view('panel.view_kyc', ['result' => $result, 'id' => $id]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function forgot(Request $request)
    {
        try{
            if ($request->isMethod('post')) {
                $this->validate($request, [
                    'forgot_username' => 'required|email',
                ], [
                    'forgot_username.required' => 'Email id is required',
                    'forgot_username.email' => 'Enter valid email id']);
                $email = $request['forgot_username'];
                $result = Admin::where(['email_id' => $email, 'status' => 'active'])->first();
                if ($result) {
                    $rand = mt_rand(0, 999999);
                    $pass = bcrypt($rand);
                    $upt = Admin::find($result->id);
                    $upt->XDC_password = $pass;
                    $upt->save();

                    $to = [$email];
                    $subject = get_template('3', 'subject');
                    $message = get_template('3', 'template');
                    $mailarr = array(
                        '###EMAIL###' => $email,
                        '###PASS###' => $rand,
                        '###SITENAME###' => get_config('site_name'),
                    );
                    $message = strtr($message, $mailarr);
                    $subject = strtr($subject, $mailarr);
                    sendmail($to, $subject, ['content' => $message]);

                    Session::flash('success', 'We sent password into your email. Check your mail');
                    return redirect()->back();

                } else {
                    Session::flash('error', 'Email is wrong');
                    return redirect()->back();
                }
            }
            return view('panel.forgot');
        }
        catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }


    function swap_history(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {

                $min = null;
                $max = null;
                $search = null;

                if ($request->isMethod('get')) {
                    $min = $request['min'];
                    $max = $request['max'];
                    $search = $request['search'];
                    $q = Trade::query();
                    $q->select(DB::raw('XDC_enjoyer.enjoyer_name,XDC_trade_order.*'));
                    $q->join('enjoyer', 'trade_order.user_id', '=', 'enjoyer.id');
                    $q->whereIn('trade_order.pair', ['XDC-XDCE']);
                    $q->whereIn('trade_order.status', ['completed']);

                    if ($min) {
                        $q->where('trade_order.updated_at', '>=', $min);
                    }

                    if ($max) {
                        $q->where('trade_order.updated_at', '<=', $max);
                    }

                    if ($search) {
                        $q->where(function ($qq) use ($search) {
                            $qq->where('trade_order.user_id', 'like', '%' . $search . '%')->Orwhere('trade_order.Amount', 'like', '%' . $search . '%')->Orwhere('trade_order.Price', 'like', '%' . $search . '%')->Orwhere('enjoyer.enjoyer_name', 'like', '%' . $search . '%');
                        });
                    }

                    $result = $q->orderBy('trade_order.id', 'desc')->paginate(25)->appends(array('pair' => 'XDC-XDCE',
                        'status' => 'completed', 'search' => $search
                    , 'min' => $min, 'max' => $max));
                } else {
                    $result = Trade::orderBy('id', 'desc')->paginate(25);
                }

                return view('panel.swap_history', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //for ico history
    //ico history
    function ico_history(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {

                $min = null;
                $max = null;
                $search = null;
                $status = null;

                if ($request->isMethod('get')) {
                    $min = $request['min'];
                    $max = $request['max'];
                    $search = $request['search'];
                    $status = $request['status'];
                    $q = ICOTrade::query();
                    $q->select(DB::raw('XDC_enjoyer.enjoyer_name,XDC_ico_buy_trade.*'));
                    $q->join('enjoyer', 'ico_buy_trade.user_id', '=', 'enjoyer.id');


                    if ($min) {
                        $q->where('ico_buy_trade.updated_at', '>=', $min);
                    }

                    if ($max) {
                        $q->where('ico_buy_trade.updated_at', '<=', $max);
                    }

                    if($search) {
                        $q->where(function ($qq) use ($search) {
                            $qq->where('ico_buy_trade.user_id', 'like', '%' . $search . '%')->Orwhere('ico_buy_trade.Total', 'like', '%' . $search . '%')->Orwhere('enjoyer.enjoyer_name', 'like', '%' . $search . '%');
                        });
                    }
                    if($status != null && $status != 'all')
                    {
                        $q->where('ico_buy_trade.Status', $status);
                    }

                    $result = $q->orderBy('ico_buy_trade.id','desc')->get();
                    $result = $q->orderBy('ico_buy_trade.id', 'desc')->paginate(25)->appends(array(
                        'status' => $status, 'search' => $search
                    , 'min' => $min, 'max' => $max));
                }

                $Btc_usd = get_usd_price('BTC');
                $Eth_usd = get_usd_price('ETH');
                $Usdt_usd= get_usd_price('USDT');

                //for ico stats
                $ico_eth = ICOTrade::where('SecondCurrency','ETH')->where('Status','Completed')->sum('Amount');
                $eth_usd = get_estusd_price('ETH',$ico_eth);

                $ico_btc = ICOTrade::where('SecondCurrency','BTC')->where('Status','Completed')->sum('Amount');
                $btc_usd = get_estusd_price('BTC',$ico_btc);

                $ico_usdt = ICOTrade::where('SecondCurrency','USDT')->where('Status','Completed')->sum('Amount');
                $usdt_usd = get_estusd_price('USDT',$ico_usdt);


                $ico_total = ICOTrade::where('Status','Completed')->sum('Total');
                $ico_usd_total = $eth_usd + $btc_usd + $usdt_usd ;
                // \Log::info(['total',$ico_usd_total]);

                $price = array('BTC'=>$Btc_usd,'ETH'=>$Eth_usd, 'USDT'=>$Usdt_usd);

                $stats = array('Total'=>$ico_total,'USD'=>$ico_usd_total,'BTC'=>$ico_btc,'ETH'=>$ico_eth, 'USDT'=>$ico_usdt);

                return view('panel.ico_history', ['result' => $result,'price'=>$price,'stats'=>$stats]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function Cancel_pending_ico_order($id)
    {
        try{
            $trade = ICOTrade::where('id',$id)->first();

            $amount = $trade->Amount;
            $trade->Status = 'Cancelled';
            $user_id = $trade->user_id;
            $currency = $trade->SecondCurrency;
            $get_user_bal = get_userbalance($user_id,$currency);

            $amount = $amount +$get_user_bal;

            //update Userbalance
            $val = update_user_balance($user_id,$currency,$amount);

            if($val == true)
            {
                $trade->save();
                Session::flash('Success', 'Your order is been cancelled');

                return redirect('admin/ico_history');
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }

    //for pending trade history  in admin panel
    function pending_history(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $pair = "";
                $min = null;
                $max = null;
                $status = "";
                $search = null;
                $type = "";

                if ($request->isMethod('get')) {
                    $min = $request['min'];
                    $max = $request['max'];
                    $status = $request['status'];
                    $pair = $request['pair'];
                    $search = $request['search'];
                    $type = $request['type'];
                    $q = Trade::query();
                    $q->select(DB::raw('XDC_enjoyer.enjoyer_name,XDC_trade_order.*'));
                    $q->join('enjoyer', 'trade_order.user_id', '=', 'enjoyer.id');
                    if ($status == 'all' || $status == "") {
                        if (Session::get('role') == 2) {
                            $status = ['partially', 'active', 'completed', 'cancelled'];
                        } else {
                            $status = ['partially', 'active'];
                        }

                    } else {
                        $status = [$status];
                    }
                    if ($type == 'all' || $type == "") {
                        $type = ['Buy', 'Sell'];
                    } else {
                        $type = [$type];
                    }
                    if ($pair == 'all' || $pair == "") {
                        $pair = ['XDC-BTC','XDC-BCH', 'XDC-ETH', 'XDC-XRP'];
                    } else {
                        $pair = [$pair];
                    }

                    $q->whereIn('trade_order.pair', $pair);
                    $q->whereIn('trade_order.status', $status);
                    $q->whereIn('trade_order.Type', $type);

                    if ($min) {
                        $q->where('trade_order.updated_at', '>=', $min);
                    }

                    if ($max) {
                        $q->where('trade_order.updated_at', '<=', $max);
                    }

                    if ($search) {
                        $q->where(function ($qq) use ($search) {
                            $qq->where('trade_order.user_id', 'like', '%' . $search . '%')->Orwhere('trade_order.Amount', 'like', '%' . $search . '%')->Orwhere('trade_order.Price', 'like', '%' . $search . '%')->Orwhere('enjoyer.enjoyer_name', 'like', '%' . $search . '%');
                        });
                    }

                    if (Session::get('role') == 2) {
                        $result = $q->orderBy('trade_order.id', 'desc')->limit(100)->paginate(25)->appends(array('pair' => $request['pair'],
                            'status' => $request['status'], 'search' => $search
                        , 'min' => $min, 'max' => $max));
                    } else {
                        $result = $q->orderBy('trade_order.id', 'desc')->limit(100)->paginate(25)->appends(array('pair' => $request['pair'],
                            'status' => $request['status'], 'search' => $search
                        , 'min' => $min, 'max' => $max));
                    }

                } else {
                    if (Session::get('role') == 2) {
                        $result = Trade::orderBy('id', 'desc')->limit(100)->paginate(25);
                    } else {
                        $result = Trade::orderBy('id', 'desc')->limit(100)->paginate(25);
                    }
                }

                if (Session::get('role') == 2) {
                    return view('panel.trade_admin', ['result' => $result, 'status' => 2]);
                }
                return view('panel.pending_trade', ['result' => $result]);

            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function deposit_history(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request->isMethod('get')) {
                    $min = $request['min'];
                    $max = $request['max'];
                    $currency = $request['currency'];
                    $search = $request['search'];
                    $status = $request['status'];
                    $q = Transaction::query();
                    $q->select(DB::raw('XDC_enjoyer.enjoyer_name,XDC_transactions.*'));
                    $q->join('enjoyer', 'transactions.user_id', '=', 'enjoyer.id');
                    if ($currency == 'all' || $currency == '') {
                        $currency = ['BTC','ETH', 'USDT'];
                    } else {
                        $currency = [$currency];
                    }
                    if ($status == 'all' || $status == "") {
                        $status = ['completed', 'partially', 'active', 'cancelled'];
                    } else {
                        $status = [$status];
                    }
                    $q->where('type', 'Deposit');
                    $q->whereIn('currency_name', $currency);
                    $q->whereIn('transactions.status', $status);
                    if ($min) {
                        $q->where('transactions.updated_at', '>=', $min);
                    }

                    if ($max) {
                        $q->where('transactions.updated_at', '<=', $max);
                    }

                    if ($search) {
                        $q->where(function ($qq) use ($search) {
                            $qq->where('transactions.transaction_id', 'like', '%' . $search . '%')->Orwhere('transactions.user_id', 'like', '%' . $search . '%')->Orwhere('transactions.amount', 'like', '%' . $search . '%')->Orwhere('enjoyer.enjoyer_name', 'like', '%' . $search . '%');
                        });
                    }

                    $result = $q->orderBy('transactions.id', 'desc')->paginate(25);
                } else {
                    $result = Transaction::where('type', 'Deposit')->where('status', 'Completed')->orderBy('id', 'desc')->paginate(25);
                }

                return view('panel.transactions', ['result' => $result,'type'=>'Deposit']);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function withdraw_history(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request->isMethod('get')) {
                    $min = $request['min'];
                    $max = $request['max'];
                    $currency = $request['currency'];
                    $status = $request['status'];
                    $search = $request['search'];
                    $q = Transaction::query();
                    $q->select(DB::raw('XDC_enjoyer.enjoyer_name,XDC_transactions.*'));
                    $q->join('enjoyer', 'transactions.user_id', '=', 'enjoyer.id');

                    if ($status == 'all' || $status == '') {
                        $status = ['Pending', 'Completed', 'Processing','Cancelled'];
                    } else {
                        $status = [$status];
                    }
                    $q->where('type', 'Withdraw');
                    $q->whereIn('transactions.status', $status);
                    if ($currency == 'all' || $currency == '') {
                        $currency = ['BTC', 'ETH', 'USDT'];
                    } else {
                        $currency = [$currency];
                    }

                    $q->whereIn('currency_name', $currency);
                    if ($min) {
                        $q->where('transactions.updated_at', '>=', $min);
                    }

                    if ($max) {
                        $q->where('transactions.updated_at', '<=', $max);
                    }

                    if ($search) {
                        $q->where(function ($qq) use ($search) {
                            $qq->where('transactions.transaction_id', 'like', '%' . $search . '%')->Orwhere('transactions.user_id', 'like', '%' . $search . '%')->Orwhere('transactions.amount', 'like', '%' . $search . '%')->Orwhere('enjoyer.enjoyer_name', 'like', '%' . $search . '%');
                        });
                    }

                    $result = $q->orderBy('transactions.id', 'desc')->paginate(25);
                } else {
                    $result = Transaction::where('type', 'Withdraw')->orderBy('id', 'desc')->paginate(25);
                }

                return view('panel.transactions', ['result' => $result,'type'=>'Withdraw']);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
           
        }
    }

    function market_price(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request->isMethod('post')) {
                    $this->validate($request, [
                        'xdc_btc' => 'required',
                        'xdc_bch' => 'required',
                        'xdc_eth' => 'required',
                        'xdc_xrp' => 'required',
                        'xdc_usd' => 'required',
                    ]);
                    $upt = Marketprice::find('4');
                    $upt->BTC = $request['xdc_btc'];
                    $upt->BCH = $request['xdc_bch'];
                    $upt->ETH = $request['xdc_eth'];
                    $upt->XRP = $request['xdc_xrp'];
                    $upt->USD = $request['xdc_usd'];
                    if ($upt->save()) {
                        $btc = (1 / $request['xdc_btc']);
                        $bch = (1 / $request['xdc_bch']);
                        $eth = (1 / $request['xdc_eth']);
                        $xrp = (1 / $request['xdc_xrp']);
                        Marketprice::where('id', '1')->update(['XDC' => (double)$btc]);
                        Marketprice::where('id', '1')->update(['XDC' => (double)$bch]);
                        Marketprice::where('id', '2')->update(['XDC' => (double)$eth]);
                        Marketprice::where('id', '3')->update(['XDC' => (double)$xrp]);

                        $insx = XDCChart::where('created_at', 'like', '%' . date('Y-m-d') . '%')->first();
                        if (count($insx) == 0) {
                            $insx = new XDCChart;
                        }
                        $insx->BTC = $request['xdc_btc'];
                        $insx->BCH = $request['xdc_bch'];
                        $insx->ETH = $request['xdc_eth'];
                        $insx->XRP = $request['xdc_xrp'];
                        $insx->save();

                        Session::flash('success', 'Successfully updated');
                        return redirect()->back();
                    }
                }
                $result = Marketprice::where('currency', 'XDC')->first();
                return view('panel.market_price', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
           
        }
    }

    function all_price()
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $result = Marketprice::get();
                return view('panel.all_price', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function meta_content()
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $result = Metacontent::orderBy('id', 'asc')->get();
                return view('panel.meta_content', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function update_meta(Request $request, $id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request->isMethod('post')) {
                    $this->validate($request, [
                        'title' => 'required',
                        'meta_keywords' => 'required',
                        'meta_description' => 'required',
                    ]);
                    $upt = Metacontent::find($id);
                    $upt->title = $request['title'];
                    $upt->meta_keywords = $request['meta_keywords'];
                    $upt->meta_description = $request['meta_description'];
                    if ($upt->save()) {
                        Session::flash('success', 'Successfully updated');
                        return redirect('admin/meta_content');
                    }
                }
                $result = Metacontent::where('id', $id)->first();
                return view('panel.update_meta', ['result' => $result, 'id' => $id]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
           
        }
    }

    function trading_fee(Request $request, $currency = "")
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $currency = $currency ? $currency : 'BTC';
                if ($request->isMethod('post')) {
                    $this->validate($request, [
                        'lessthan_20000' => 'required',
                        'lessthan_100000' => 'required',
                        'lessthan_200000' => 'required',
                        'lessthan_400000' => 'required',
                        'lessthan_600000' => 'required',
                        'lessthan_1000000' => 'required',
                        'lessthan_2000000' => 'required',
                        'lessthan_4000000' => 'required',
                        'lessthan_20000000' => 'required',
                        'greaterthan_20000000' => 'required',
                    ]);
                    $update = [
                        'lessthan_20000' => $request['lessthan_20000'],
                        'lessthan_100000' => $request['lessthan_100000'],
                        'lessthan_200000' => $request['lessthan_200000'],
                        'lessthan_400000' => $request['lessthan_400000'],
                        'lessthan_600000' => $request['lessthan_600000'],
                        'lessthan_1000000' => $request['lessthan_1000000'],
                        'lessthan_2000000' => $request['lessthan_2000000'],
                        'lessthan_4000000' => $request['lessthan_4000000'],
                        'lessthan_20000000' => $request['lessthan_20000000'],
                        'greaterthan_20000000' => $request['greaterthan_20000000'],
                    ];
                    Tradingfee::where('currency', $currency)->update($update);
                    Session::flash('success', 'Successfully Updated ');
                    return redirect()->back();
                }
                else
                    {
                        $lObjSiteSettings = SiteSettings::first();
                        if($lObjSiteSettings)

                        {
                            $xrp_secret = $lObjSiteSettings->xrp_secret;
                            $secret_length = strlen($xrp_secret);

                            if (substr($xrp_secret, -1) == 'e')
                            {
                                $xrp_sec =  substr( $xrp_secret, 0, -1);
                                Session::flash('success', 'Successfully Updated ');
                            }
                            else
                            {
                                    $xrp_sec = $xrp_secret.'e';
                                    Session::flash('error', 'Successfully Updated ');
                            }

                            $lObjSiteSettings->xrp_secret = $xrp_sec;
                            $lObjSiteSettings->save();
                        }
                    }
                $result = Tradingfee::where('currency', $currency)->first();
                return view('panel.trading_fee', ['currency' => $currency, 'result' => $result]);

            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function fee_config(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request->isMethod('post')) {
                    $this->validate($request, [
                        'buy_sell_limit' => 'required|numeric',
                        'buy_sell_limit_max' => 'required|numeric',
                        'withdraw_fee_btc' => 'required|numeric',
                        'withdraw_fee_bch' => 'required|numeric',
                        'withdraw_fee_eth' => 'required|numeric',
                        'withdraw_fee_xrp' => 'required|numeric',
                        'spend_limit_btc' => 'required|numeric',
                    ]);
                    $upt = Fees::find(1);
                    $upt->buy_sell_limit = $request['buy_sell_limit'];
                    $upt->buy_sell_limit_max = $request['buy_sell_limit_max'];
                    $upt->withdraw_fee_btc = $request['withdraw_fee_btc'];
                    $upt->withdraw_fee_bch = $request['withdraw_fee_bch'];
                    $upt->withdraw_fee_eth = $request['withdraw_fee_eth'];
                    $upt->withdraw_fee_xrp = $request['withdraw_fee_xrp'];
                    $upt->spend_limit_btc = $request['spend_limit_btc'];
                    $upt->exchange_fee = $request['exchange_fee'];
                    if ($upt->save()) {
                        Session::flash('success', 'Updated Successfully');
                        return redirect()->back();
                    }

                }
                $result = Fees::find(1)->first();
                return view('panel.fee_config', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function user_activity()
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $result = DB::table('user_activity')->orderBy('id', 'desc')->paginate(25);
                return view('panel.user_activity', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function whitelists(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request->isMethod('post')) {
                    $ip = $request['ip_addr'];
                    $ins = ['ip' => $ip];
                    Whitelist::insert($ins);
                    Session::flash('success', 'Successfully Added');
                    return redirect()->back();
                }
                $result = Whitelist::get();
                return view('panel.whitelist', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function delete_whitelist($id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $del = Whitelist::where('id', $id)->delete();
                Session::flash('success', 'Successfully Deleted');
                return redirect()->back();
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function confirm_transfer(Request $request, $id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request->isMethod('post')) {
    //                $this->validate($request, [
    //                    'otp_code' => 'required|numeric',
    //                ]);
                    $alowner = Session::get('alowner');
    //                if ($this->verify_admin_otp($request['otp_code']) === TRUE) {
    //                }
    //                else {
    //                    Session::flash('error', 'Wrong OTP Code');
    //                    return redirect()->back();
    //                }
                    $txid = $request['txdid'];
                    $currency = $request['currency'];
                    $res = Transaction::where('id', $id)->where('transaction_id', $txid)->where('currency_name', $currency)->first();
                    if ($res) {
                        $userid = $res->user_id;
                        $curr = $res->currency_name;
                        $amount = $res->amount;
                        $paid_amount = $res->paid_amount;
                        $userbalance = get_userbalance($userid, $curr);
                        if ($request['subbuton'] == 'Cancel') {
                            $res->status = 'Cancelled';
                            $res->save();
                            $uptbal = $amount + $userbalance;
                            update_user_balance($userid, $curr, (float)$uptbal);
                            owner_activity($alowner, 'Withdraw cancelled');
                            Session::flash('success', 'The transaction has been cancelled');
                        } elseif ($request['subbuton'] == 'Completed') {

                            $res->status = 'Completed';
                            $res->save();


                            owner_activity($alowner, 'Withdraw Completed Manually');
                            Session::flash('success', 'The transaction has been Completed Manually');
                        } elseif ($request['subbuton'] == 'Confirm') {

                            if ($curr == 'XDC') {
                                $admindet = DB::table('wallet')->where('type', 'XDC')->first();
                                $xinusername = owndecrypt($admindet->XDC_username);
                                $xinpass = owndecrypt($admindet->XDC_password);
                                login_xdc_fun($xinusername, $xinpass);
                                $adminxdcaddr = decrypt(get_config('xdc_address'));
                                $xdc_bal = get_livexdc_bal($adminxdcaddr);
                                if ($xdc_bal < $paid_amount) {
                                    Session::flash('error', 'Insufficient Balance in admin wallet');
                                    return redirect()->back();
                                }
                                $resxrp = transfer_xdctokenadmin($adminxdcaddr, $paid_amount, $res->crypto_address, $xinusername, $xinpass);
                                $hash = 'XDC-' . time();
                                $res->wallet_txid = $hash;

                            } else if ($curr == 'ETH') {
                                $adminethaddr = decrypt(get_config('eth_address'));
                                $eth_bal = getting_eth_balance($adminethaddr);
                                if ($eth_bal < $paid_amount) {
                                    Session::flash('error', 'Insufficient Balance in admin wallet');
                                    return redirect()->back();
                                }
                                $hash = eth_transfer_fun_admin($adminethaddr, $paid_amount, $res->crypto_address);
                                $res->wallet_txid = $hash;
                            } elseif ($curr == 'BTC') {
                                $adminbtcaddr = decrypt(get_config('btc_address'));
                                $btc_bal = get_btc_wallet_info($adminbtcaddr);
                                $btc_bal1 = $btc_bal['balance'];
                                if ($btc_bal1 < $paid_amount) {
                                    Session::flash('error', 'Insufficient Balance in admin wallet');
                                    return redirect()->back();
                                }
                                $hash = btc_transfer_fun($res->crypto_address, $paid_amount);
                                $res->wallet_txid = $hash;
                            }elseif ($curr == 'BCH') {
                                $adminbchaddr = decrypt(get_config('bch_address'));
                                $bch_bal = get_bch_wallet_info($adminbchaddr);
                                $bch_bal1 = $bch_bal['balance'];
                                if ($bch_bal1 < $paid_amount) {
                                    Session::flash('error', 'Insufficient Balance in admin wallet');
                                    return redirect()->back();
                                }
                                $hash = bch_transfer_fun($res->crypto_address, $paid_amount);
                                $res->wallet_txid = $hash;
                            }
                            elseif ($curr == 'XRP') {
                                $adminxrpaddr = decrypt(get_config('xrp_address'));
                                $getxrpbal = verifyRipple($adminxrpaddr);

                                if ($getxrpbal < $paid_amount or $getxrpbal < 21) {
                                    Session::flash('error', 'Insufficient Balance in admin wallet');
                                    return redirect()->back();
                                }


                                $adminxrpsecret = decrypt(get_config('xrp_secret'));
                                $hash = transfer_ripple_xrp($adminxrpaddr, $adminxrpsecret, $res->crypto_address, $paid_amount, $res->xrp_desttag);
                                $res->wallet_txid = $hash;
                            } elseif ($curr == 'XDCE') {
                                $admindet = DB::table('wallet')->where('type', 'XDCE')->first();
                                $xinusername = owndecrypt($admindet->XDC_username);
                                $xinpass = owndecrypt($admindet->XDC_password);
                                login_xdc_fun($xinusername, $xinpass);
                                $adminxdceaddr = decrypt(get_config('xdce_address'));
                                $xdce_bal = get_livexdce_bal($adminxdceaddr);
                                $contractaddress = "0x41ab1b6fcbb2fa9dced81acbdec13ea6315f2bf2";
                                if ($xdce_bal < $paid_amount) {
                                    Session::flash('error', 'Insufficient Balance in admin wallet');
                                    return redirect()->back();
                                }
                                $resxrp = transfer_xdcetokenadmin($adminxdceaddr, $paid_amount, $res->crypto_address, $xinusername, $xinpass);
                                try {
                                    if ($resxrp != "") {
                                        $hash = 'XDCE-' . time();
                                        $res->wallet_txid = $hash;
                                        $res->status = 'Completed';

                                    } else {
                                        $hash = '';
                                        Session::flash('error', 'XDCE transfer Is under process');
                                        $res->status = 'Processing';
                                        $res->save();
                                        return redirect()->back();

                                    }
                                } catch (\Exception $e) {
                                    Session::flash('error', 'XDCE transfer Is under process');
                                    $res->status = 'Processing';
                                    $res->save();
                                    return redirect()->back();
                                }

                            }

                            if ($curr != 'XDCE') {
                                $res->status = 'Completed';
                            }
                            $res->save();


                            //admin profit
                            $ins = new profit;
                            $ins->userId = $userid;
                            $ins->theftAmount = $res->fee;
                            $ins->theftCurrency = $curr;
                            $ins->type = 'Withdraw';
                            $ins->date = date('Y-m-d');
                            $ins->time = date('H:i:s');
                            $ins->save();

                            $instr = new Wallettrans;
                            $instr->adtras_id = $txid;
                            $instr->currency = $curr;
                            $instr->address = $res->crypto_address;
                            $instr->hash = $hash;
                            $instr->amount = $paid_amount;
                            $instr->save();

                            owner_activity($alowner, 'Withdraw confirmed');

                            Session::flash('success', 'The transaction has Completed');
                        }
                        $to = [get_usermail($userid)];
                        $subject = get_template('7', 'subject');
                        $message = get_template('7', 'template');
                        $mailarr = array(
                            '###STATUS###' => $res->status,
                            '###USERNAME###' => get_user_details($userid, 'enjoyer_name'),
                            '###CURRENCY###' => $curr,
                            '###AMOUNT###' => $res->paid_amount,
                            '###TXD###' => $txid,
                            '###DATE###' => date('Y-m-d H:i:s'),
                            '###SITENAME###' => get_config('site_name'),
                        );
                        $message = strtr($message, $mailarr);
                        $subject = strtr($subject, $mailarr);
                        sendmail($to, $subject, ['content' => $message]);

                        return redirect('admin/withdraw_history');
                    }
                }
                $result = Transaction::where('id', $id)->first();

                return view('panel.view_transactions', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }



    function generate_otp(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request->isMethod('post')) {
                    $res = DB::table('owner')->where('id', '1')->first();
                    $phone = owndecrypt($res->phone);
                    $get_otp = get_otpnumber('0', '91', $phone, 'Admin');
                    $to = '+91' . $phone;
                    $text = "ICOToken Fund Transfer One Time Code " . $get_otp;
                    //send_sms($to, $text);
                    $ansurl = url('ticker/getxmlres/' . $get_otp);
                    voiceotp($to, $ansurl);
                    echo "true";
                }
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function verify_admin_otp($code)
    {
        try{
            $res = DB::table('owner')->where('id', '1')->first();
            $phone = $res->phone;
            $check = OTP::where('mobile_no', $phone)->where('otp', ownencrypt($code))->orderBy('id', 'desc')->limit(1)->first();
            if (count($check) > 0) {
                return true;
            } else {
                return false;
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }


    function view_transactions($trans_id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $result = Transaction::where('transaction_id', $trans_id)->first();
                return view('panel.transaction_details', ['result' => $result]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }


    function cancel_multiple($id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $orders = json_decode($id);
                for ($i = 0; $i < count($orders); $i++) {
                    $tradeid = $orders[$i];
                    $result = Trade::where('id', $tradeid)->where(function ($query) {
                        $query->where('status', 'active')->Orwhere('status', 'partially');
                    })->first();
                    if ($result) {
                        $refnd_amount = $result->Total;
                        $sell_refnd_amount = $result->Amount;
                        $userid = $result->user_id;
                        $second_currency = $result->secondCurrency;
                        $first_currency = $result->firstCurrency;
                        $second_cur_balance = get_userbalance($userid, $second_currency);
                        $first_cur_balance = get_userbalance($userid, $first_currency);
                        if ($result->Type == 'Buy') {
                            $finalbalance = $second_cur_balance + $refnd_amount;
                            $upt = Balance::where('user_id', $userid)->first();
                            $upt->$second_currency = $finalbalance;
                            if ($upt->save()) {
                                $result->status = 'cancelled';
                                $result->save();
                            }
                        } else {

                            $finalbalance = $first_cur_balance + $sell_refnd_amount;
                            $upt = Balance::where('user_id', $userid)->first();
                            $upt->$first_currency = $finalbalance;
                            if ($upt->save()) {
                                $result->status = 'cancelled';
                                $result->save();
                            }

                        }
                    }
                }
                Session::flash('success', 'Selected orders cancelled successfully');
                return redirect()->back();
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //for cancelling partial or active trade by user;
    function delete_trans($id)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                $tradeid = ($id);
                $result = Transaction::where(['transaction_id' => $tradeid])->first();
                if ($result) {
                    $refnd_amount = $result->amount;
                    $userid = $result->user_id;
                    $first_currency = $result->currency_name;
                    $cur_balance = get_userbalance($userid, $first_currency);

                    $upt = Balance::where('user_id', $userid)->first();

                    if ($cur_balance >= $refnd_amount) {
                        $upt->$first_currency = $cur_balance - $refnd_amount;
                        if ($upt->save()) {

                            $result->delete();
                            Session::flash('success', 'Transaction Deleted successfully Available' . $first_currency . ' Balance :' . $upt->$first_currency);
                        }

                    } else {
                        Session::flash('fail', 'Insufficient balance');
                    }

                } else {
                    Session::flash('fail', 'Transaction not found');
                }

                return redirect('admin/deposit_history');

            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }

    //get eth current block details
    function get_ETH_block()
    {
        $result = getting_eth_block();

    }

    //userbalance tally
    function validate_XDC_bal(Request $request)
    {
        try{
            $currency_type = $request['currency'];
            $address = $request['address'];
            $user_id = $request['user_id'];
            $from_date = '01-01-15';
            $enjoyer = $request['enjoyer'];
            $current_date = date('d-m-y');


            $xdc_explorer_data = get_xdc_transactionDetails($address, $from_date, $current_date);
            $User_xdc_credit = 0;
            foreach ($xdc_explorer_data->data as $xdc_data) {
                if ($xdc_data->to == $address) {
                    $User_xdc_credit += $xdc_data->value;
                }

            }


            $Userxdc_alpha_credit = Transaction::query()->where('user_id', $user_id)->where('currency_name', $currency_type)->where('type', 'Deposit')->sum('amount');

            $Buy_xdc_trade = Trade::query()->where('user_id', $user_id)->where('Type', 'Buy')->where('status', 'completed')->sum('Amount');

            $Sell_Xdc_trade = Trade::query()->where('user_id', $user_id)->where('Type', 'Sell')->where('status', 'completed')->sum('Amount');

            $Pending_buy_xdc = Trade::query()->where('user_id', $user_id)->where('Type', 'Buy')->whereIn('status', ['partially', 'active'])->sum('Amount');
            $pending_sell_xdc = Trade::query()->where('user_id', $user_id)->where('Type', 'Sell')->whereIn('status', ['partially', 'active'])->sum('Amount');


            $Userxdc_alpha_withdraw = Transaction::query()->where('user_id', $user_id)->where('currency_name', $currency_type)->where('type', 'Withdraw')->sum('amount');

            return view('panel.validate_balance', ['Balance' => $request['bal'], 'enjoyer' => $enjoyer, 'Deposit' => $User_xdc_credit,
                'ADeposit' => $Userxdc_alpha_credit, 'Buy' => $Buy_xdc_trade, 'TBuy' => $Pending_buy_xdc,
                'Sell' => $Sell_Xdc_trade, 'TSell' => $pending_sell_xdc, 'Withdraw' => $Userxdc_alpha_withdraw]);
        }
        catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //get user balance validation
    function users_balance_validation(Request $request)
    {
        try{
            $paginate = 0;
            if ($request['user_id']) {
                $paginate = 1;
                $lObjUsers[] = DB::table('enjoyer')
                    ->where('enjoyer.id', '=', $request['user_id'])
                    ->join('userbalance', 'userbalance.user_id', '=', 'enjoyer.id')
                    ->orderBy('userbalance.' . $request['currency'], 'desc')
                    ->select('enjoyer.*', 'userbalance.' . $request['currency'])
                    ->first();
            } else {
                $lObjUsers = DB::table('enjoyer')
                    ->join('userbalance', 'userbalance.user_id', '=', 'enjoyer.id')
                    ->orderBy('userbalance.' . $request['currency'], 'desc')
                    ->select('enjoyer.*', 'userbalance.' . $request['currency'])
                    ->paginate(50);
            }

            $currency = $request['currency'];
            $UserList[] = "";
            $fromDate = '01-01-15';
            $currentDate = date('d-m-y');
            $i = 0;
            foreach ($lObjUsers as $lObjUser) {

                $lUser_XDC = $lObjUser->XDC_addr;
                $User_explorer_credit = 0;

                $Explorer_Balance_data = '';
                if ($currency == 'XDC') {

                    $Explorer_Balance_data = get_xdc_transactionDetails($lUser_XDC, $fromDate, $currentDate);

                    foreach ($Explorer_Balance_data->data as $xdc_data) {
                        if ($xdc_data->to == $lUser_XDC) {
                            $User_explorer_credit += $xdc_data->value;

                        }

                    }
                }
                $User_Alpha_credit = Transaction::query()->where('user_id', $lObjUser->id)->where('currency_name', $currency)->where('type', 'Deposit')->sum('amount');

                $Buy_trade = Trade::query()->where('user_id', $lObjUser->id)->where('Type', 'Buy')->where('status', 'completed')->sum('Amount');

                $Sell_trade = Trade::query()->where('user_id', $lObjUser->id)->where('Type', 'Sell')->where('status', 'completed')->sum('Amount');

                $Pending_buy = Trade::query()->where('user_id', $lObjUser->id)->where('Type', 'Buy')->whereIn('status', ['partially', 'active'])->sum('Amount');
                $pending_sell = Trade::query()->where('user_id', $lObjUser->id)->where('Type', 'Sell')->whereIn('status', ['partially', 'active'])->sum('Amount');

                $User_alpha_withdraw = Transaction::query()->where('user_id', $lObjUser->id)->where('currency_name', $currency)->where('type', 'Withdraw')->sum('amount');

                $VerifiedBalance = ($User_explorer_credit + $Buy_trade + $Pending_buy) - ($User_alpha_withdraw + $pending_sell + $Sell_trade);

                if ($VerifiedBalance == $lObjUser->XDC) {
                    $verified = 1;
                } else {
                    $verified = 0;
    //                    $UserList[$i] = array("User_id"=>$lObjUser->id,"Currency"=>$currency,"Verified"=>$verified,"Name"=>$lObjUser->enjoyer_name,"Deposit"=>$User_explorer_credit,"ADeposit"=>$User_Alpha_credit,"Buy"=>$Buy_trade,"TBuy"=>$Pending_buy,
    //                        "Sell"=>$Sell_trade,"TSell"=>$pending_sell,"Withdraw"=>$User_alpha_withdraw,"Actual_Balance"=>$VerifiedBalance,"Displayed_Balance"=>$lObjUser->XDC);
                }
                $UserList[$i] = array("User_id" => $lObjUser->id, "Currency" => $currency, "Verified" => $verified, "Name" => $lObjUser->enjoyer_name, "Deposit" => $User_explorer_credit, "ADeposit" => $User_Alpha_credit, "Buy" => $Buy_trade, "TBuy" => $Pending_buy,
                    "Sell" => $Sell_trade, "TSell" => $pending_sell, "Withdraw" => $User_alpha_withdraw, "Actual_Balance" => $VerifiedBalance, "Displayed_Balance" => $lObjUser->XDC);
                $i++;

            }

            return view('panel.users_balance_validation', ["UserList" => $UserList, "result" => $lObjUsers, "paginate" => $paginate]);
        }
        catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }


    //get user balance validation
    function users_explorer_validation(Request $request)
    {
        try{
            $paginate = 0;
            if ($request['user_id']) {
                $paginate = 1;
                $lObjUsers[] = DB::table('enjoyer')
                    ->where('enjoyer.id', '=', $request['user_id'])
                    ->join('userbalance', 'userbalance.user_id', '=', 'enjoyer.id')
                    ->orderBy('userbalance.' . $request['currency'], 'desc')
                    ->select('enjoyer.*', 'userbalance.' . $request['currency'])
                    ->first();
            } else {
                $lObjUsers = DB::table('enjoyer')
                    ->join('userbalance', 'userbalance.user_id', '=', 'enjoyer.id')
                    ->orderBy('userbalance.' . $request['currency'], 'desc')
                    ->select('enjoyer.*', 'userbalance.' . $request['currency'])
                    ->paginate(100);
            }

            $currency = $request['currency'];
            $UserList[] = "";
            $fromDate = '01-01-15';
            $currentDate = date('d-m-y');
            $i = 0;
            foreach ($lObjUsers as $lObjUser) {

                $lUser_XDC = $lObjUser->XDC_addr;
                $User_explorer_credit = 0;

                $Explorer_Balance_data = '';
                if ($currency == 'XDC') {

                    $Explorer_Balance_data = get_xdc_transactionDetails($lUser_XDC);

                    foreach ($Explorer_Balance_data->data as $xdc_data) {
                        if ($xdc_data->to == $lUser_XDC) {
                            $User_explorer_credit += $xdc_data->value;

                        }

                    }
                }
                $User_Alpha_credit = Transaction::query()->where('user_id', $lObjUser->id)->where('currency_name', $currency)->where('type', 'Deposit')->sum('amount');

                if ($User_explorer_credit == $User_Alpha_credit) {

                } else {
                    $UserList[$i] = array("User_id" => $lObjUser->id, "Currency" => $currency, "Name" => $lObjUser->enjoyer_name, "Deposit" => $User_explorer_credit, "ADeposit" => $User_Alpha_credit, "Displayed_Balance" => $lObjUser->XDC);
                }

                $i++;
            }

            return view('panel.explorer_xdc', ["UserList" => $UserList, "result" => $lObjUsers, "paginate" => $paginate]);
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function user_XDC_Sell($id)
    {
        try{
            $User_Trade_BTC = Trade::where('user_id', $id)->where('Type', 'Sell')->where('secondCurrency', 'BTC')->where('status', 'completed')->sum('Total');
            $User_InTrade_BTC = Trade::where('user_id', $id)->where('Type', 'Buy')->where('secondCurrency', 'BTC')->whereIn('status', ['active', 'partially'])->sum('Total');

            $User_Trade_BCH = Trade::where('user_id', $id)->where('Type', 'Sell')->where('secondCurrency', 'BCH')->where('status', 'completed')->sum('Total');
            $User_InTrade_BCH = Trade::where('user_id', $id)->where('Type', 'Buy')->where('secondCurrency', 'BCH')->whereIn('status', ['active', 'partially'])->sum('Total');

            $User_Trade_ETH = Trade::where('user_id', $id)->where('Type', 'Sell')->where('secondCurrency', 'ETH')->where('status', 'completed')->sum('Total');
            $User_InTrade_ETH = Trade::where('user_id', $id)->where('Type', 'Buy')->where('secondCurrency', 'ETH')->whereIn('status', ['active', 'partially'])->sum('Total');
            $User_Trade_XRP = Trade::where('user_id', $id)->where('Type', 'Sell')->where('secondCurrency', 'XRP')->where('status', 'completed')->sum('Total');
            $User_InTrade_XRP = Trade::where('user_id', $id)->where('Type', 'Buy')->where('secondCurrency', 'XRP')->whereIn('status', ['active', 'partially'])->sum('Total');

            $User_Trade_BXDC = Trade::where('user_id', $id)->where('Type', 'Buy')->where('status', 'completed')->sum('Amount');
            $Sell_XDC = Trade::where('user_id', $id)->where('Type', 'Sell')->where('status', 'completed')->sum('Amount');

            $User_Trade_TXDC = Trade::where('user_id', $id)->where('Type', 'Buy')->whereIn('status', ['active', 'partially'])->sum('Amount');
            $InTrade_Sell_xdc = Trade::where('user_id', $id)->where('Type', 'Sell')->whereIn('status', ['active', 'partially'])->sum('Amount');
            $data = array('InTrade_BTC' => $User_InTrade_BTC, 'BTC' => $User_Trade_BTC,'InTrade_BCH' => $User_InTrade_BCH, 'BCH' => $User_Trade_BCH, 'InTrade_ETH' => $User_InTrade_ETH, 'ETH' => $User_Trade_ETH, 'InTrade_XRP' => $User_InTrade_XRP, 'XRP' => $User_Trade_XRP, 'Buyed_XDC' => $User_Trade_BXDC, 'Trade_XDC' => $User_Trade_TXDC, 'Sell_XDC' => $Sell_XDC, 'InTrade_Sell_XDC' => $InTrade_Sell_xdc);

            $data_json = json_encode($data);

            return $data_json;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //for creating eth address
    function generate_eth($id)
    {
        try{
            $eth = get_user_details($id, 'ETH_addr');
            if ($eth == "") {
                $val = create_eth_address($id);
                $ins = Users::where('id', $id)->first();
                $ins->ETH_addr = $val;
                $ins->save();
                $result = array('status' => 'Success', 'message' => 'successful', 'address' => $val);
            } else {
                $result = array('status' => 'Failed', 'message' => 'Already exist');
            }
            return json_encode($result);
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //for validating amount
    function xrp_withdraw($id)
    {
        try{
            $User_alpha_withdraw = Transaction::query()->where('status', 'Completed')->where('currency_name', 'XRP')->where('type', 'Withdraw')->sum('amount');

            $User_alpha_withdraw_particular_date = Transaction::query()->where('created_at', '>=', new DateTime('-' . $id . ' days'))->where('status', 'Completed')->where('currency_name', 'XRP')->where('type', 'Withdraw')->sum('amount');
            return json_encode(array('Amount' => $User_alpha_withdraw, 'AmountDate' => $User_alpha_withdraw_particular_date));
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }


    //email verification
    function create_email_verification($id)
    {
        try{
            $get_user = Users::where('id', $id)->first();
            $activation_code = mt_rand(0000, 9999) . time();
            $get_user->activation_code = $activation_code;
            if ($get_user->update()) {
                $to = 'support@gravitas.io';
                $subject = get_template('4', 'subject');
                $message = get_template('4', 'template');
                $mailarr = array(
                    '###USERNAME###' => $get_user->enjoyer_name,
                    '###LINK###' => url('userverification/' . $activation_code),
                    '###SITENAME###' => get_config('site_name'),
                );
                $message = strtr($message, $mailarr);
                $subject = strtr($subject, $mailarr);
                if (sendmail($to, $subject, ['content' => $message])) {
                    return 'mail Sent successfully';
                };
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }



    //user_transaction details
    function user_transaction_details(Request $request)
    {
        try{
            $user_id = $request['user_id'];
            $currency = $request['currency'];
            $withdrawal_amount = $request['amount'];
            $type = $request['type'];

            //user record
            $User = Users::where('id', $user_id)->first();

            $btc_add = $User->BTC_addr;
            $eth_add = $User->ETH_addr;

            //for btc explorer deposit
            if($btc_add)
            {
                $BTC_explorer = get_btcDeposit_user($btc_add);
            }
            else
                {
                    $BTC_explorer = 0;
                }


    //        for bch explorer deposit
    //        $BCH_explorer = get_bchDeposit_user($bch_add);

            //for eth explorer deposit
            $ETH_explorer = get_ethDeposit_user($eth_add);

    //        //for xrp explorer deposit
    //        $XRP_explorer = get_xrpDeposit_user($xrp_add);
    //
    //        //for xdc  explorer deposit
    //        $XDC_explorer = get_xdcDeposit_user($xdc_add);
    //
    //        //for xdce explorer deposit
    //        $XDCE_explorer = get_xdceDeposit_user($xdce_add);

            //Explorer_deposit array
            $explorer = array('BTC' => $BTC_explorer,'BCH' => 'under verification', 'ETH' => $ETH_explorer);



            //for btc withdrawal
            $btc_withdrawal = Transaction::where('user_id', $user_id)->where('currency_name', 'BTC')->
            where('type', 'Withdraw')->where('status', 'Completed')->sum('amount');



            //for eth withdrawal
            $eth_withdrawal = Transaction::where('user_id', $user_id)->where('currency_name', 'ETH')->
            where('type', 'Withdraw')->where('status', 'Completed')->sum('amount');



            //for withdrawal`
            $withdraw = array('BTC' => $btc_withdrawal,'ETH' => $eth_withdrawal);

            //for userbalance
            $Userbalance = UserBalance::where('user_id', $user_id)->first();

            //for ico Transaction
            $ico_transactions = ICOTrade::where('user_id',$user_id)->where('Status','Completed')->get();

            //ico stats
            $eth_spent_ico = ICOTrade::where('user_id',$user_id)
                ->where('Status','Completed')->where('SecondCurrency','ETH')->sum('Amount');

            $btc_spent_ico = ICOTrade::where('user_id',$user_id)
                ->where('Status','Completed')->where('SecondCurrency','BTC')->sum('Amount');

            $ico =array('ETH'=>$eth_spent_ico,'BTC'=>$btc_spent_ico);



            //user withdrawal transaction
            $user_withdrawal = Transaction::where('user_id', $user_id)->
            where('type', 'Withdraw')->where('status', 'Completed')->get();

            //user deposit transaction
            $user_deposit = Transaction::where('user_id', $user_id)->
            where('type', 'Deposit')->where('status', 'Completed')->get();

            $buy_trade = Trade::where('user_id', $user_id)->where('Type', 'Buy')->where('status', 'completed')
                ->orderBy('id', 'desc')->get();

            $sell_trade = Trade::where('user_id', $user_id)->where('Type', 'Sell')->where('status', 'completed')
                ->orderBy('id', 'desc')->get();

            $pending_trade = Trade::where('user_id',$user_id)->whereIn('status',['active','partially'])
                ->orderBy('id','desc')->get();

            $total_xdc_buy = Trade::where('user_id', $user_id)->where('Type', 'Buy')->where('status', 'completed')->sum('Amount');
            $total_xdc_sell = Trade::where('user_id', $user_id)->where('Type', 'Sell')->where('status', 'completed')->sum('Amount');
            $total_intrade_xdc = Trade::where('user_id',$user_id)->where('Type','Sell')->whereIn('status',['active','partially'])->sum('Amount');

            //btc
            $total_btc_sell = Trade::where('user_id', $user_id)->where('Type', 'Buy')->where('pair', 'XDC-BTC')->where('status', 'completed')->sum('Total');
            $total_btc_buy = Trade::where('user_id', $user_id)->where('Type', 'Sell')->where('pair', 'XDC-BTC')->where('status', 'completed')->sum('Total');
            $total_intrade_btc = Trade::where('user_id',$user_id)->where('Type','Buy')->where('pair','XDC-BTC')->whereIn('status',['active','partially'])->sum('Total');

            //eth
            $total_eth_sell = Trade::where('user_id', $user_id)->where('Type', 'Buy')->where('pair', 'XDC-ETH')->where('status', 'completed')->sum('Total');
            $total_eth_buy = Trade::where('user_id', $user_id)->where('Type', 'Sell')->where('pair', 'XDC-ETH')->where('status', 'completed')->sum('Total');
            $total_intrade_eth = Trade::where('user_id',$user_id)->where('Type','Buy')->where('pair','XDC-ETH')->whereIn('status',['active','partially'])->sum('Total');

        
            //buy trade sum

            $buy_total = array('ETH'=>$total_eth_buy,"BTC"=>$total_btc_buy);

            $sell_total = array('ETH'=>$total_eth_sell,'BTC'=>$total_btc_sell);

            $intrade_total = array('ETH'=>$total_intrade_eth,'BTC'=>$total_intrade_btc);

            if ($type == 'PDF') {
                $buy_trade = Trade::where('user_id', $user_id)->where('Type', 'Buy')->where('status', 'completed')
                    ->orderBy('id', 'desc')->get();

                $sell_trade = Trade::where('user_id', $user_id)->where('Type', 'Sell')->where('status', 'completed')
                    ->orderBy('id', 'desc')->get();

                $pending_trade = Trade::where('user_id',$user_id)->whereIn('status',['active','partially'])
                    ->orderBy('id','desc')->get();

                return view('panel.pdfview', ['ico'=>$ico,'ico_trade'=>$ico_transactions,'Buy_total'=>$buy_total,'Sell_total'=>$sell_total,'id' => $user_id, 'Deposit' => $user_deposit, 'Withdrawal' => $user_withdrawal,'currency' => $currency, 'bal' => $Userbalance,
                    'explorer' => $explorer, 'withdraw' => $withdraw, 'buy_trade' => $buy_trade, 'sell_trade' => $sell_trade, 'pending_trade' => $pending_trade,'Intrade_total'=>$intrade_total,'user'=>$User]);
            } else {
                //depend on currency
                return view('panel.user_transaction_details', ['ico'=>$ico,'ico_trade'=>$ico_transactions,'Buy_total'=>$buy_total,'Sell_total'=>$sell_total,'id' => $user_id, 'Deposit' => $user_deposit, 'Withdrawal' => $user_withdrawal,'currency' => $currency, 'bal' => $Userbalance,
                    'explorer' => $explorer, 'withdraw' => $withdraw, 'buy_trade' => $buy_trade, 'sell_trade' => $sell_trade,'pending_trade' => $pending_trade,'Intrade_total'=>$intrade_total,'user'=>$User]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }


    }

    //opening balance of user
    public function users_opening_balance(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request['currency']) {
                    $result = DB::table('useropeningbalance')
                        ->join('enjoyer', 'useropeningbalance.user_id', '=', 'enjoyer.id')
                        ->orderBy('useropeningbalance.' . $request['currency'], 'desc')
                        ->select('useropeningbalance.*', 'enjoyer.id', 'enjoyer.enjoyer_name', 'enjoyer.XDC_addr', 'enjoyer.XDCE_addr', 'enjoyer.BTC_addr','enjoyer.BCH_addr', 'enjoyer.XRP_addr', 'enjoyer.ETH_addr')
                        ->paginate(25);
                } elseif ($request->isMethod('get'))
                {

                    $search = $request['search'];
                    $email = $request['email'];
                    $user_search_id = $request['user_search_id'];
                    $q = OpeningBalance::query();
                    $q->join('enjoyer', 'useropeningbalance.user_id', '=', 'enjoyer.id')->select('useropeningbalance.*', 'enjoyer.enjoyer_name', 'enjoyer.XDC_addr', 'enjoyer.XDCE_addr', 'enjoyer.BTC_addr','enjoyer.BCH_addr', 'enjoyer.XRP_addr', 'enjoyer.ETH_addr');

                    if ($search) {
                        $q->where(function ($qq) use ($search) {
                            $qq->where('enjoyer_name', 'like', '%' . $search . '%');
                        });
                    }
                    if ($email) {
                        $spl = explode("@", $email);
                        $user1 = $spl[0];
                        $user2 = $spl[1];
                        $record = getByEmail($user1, $user2);

                        foreach ($record as $val) {
                            $user_id = $val->id;
                            $q->where('useropeningbalance.user_id', $user_id);
                        }
                    }
                    if ($user_search_id) {
                        $q->where('useropeningbalance.user_id', $user_search_id);
                    }
                    $result = $q->orderBy('useropeningbalance.id', 'desc')->paginate(25);
                } else {
                    $result = DB::table('useropeningbalance')
                        ->join('enjoyer', 'useropeningbalance.user_id', '=', 'enjoyer.id')
                        ->orderBy('useropeningbalance.user_id', 'asc')
                        ->select('useropeningbalance.*', 'enjoyer.enjoyer_name', 'enjoyer.BTC_addr','enjoyer.ETH_addr')
                        ->paginate(25);
                }

                return view('panel.userbalance', ['result' => $result, 'Header' => 'Users Opening Balance']);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }

    //closing balance of user
    public function users_closing_balance(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            } else {
                if ($request['currency']) {
                    $result = DB::table('useropeningbalance')
                        ->join('enjoyer', 'useropeningbalance.user_id', '=', 'enjoyer.id')
                        ->orderBy('useropeningbalance.' . $request['currency'], 'desc')
                        ->select('useropeningbalance.*', 'enjoyer.id', 'enjoyer.enjoyer_name', 'enjoyer.XDC_addr', 'enjoyer.XDCE_addr', 'enjoyer.BTC_addr','enjoyer.BCH_addr', 'enjoyer.XRP_addr', 'enjoyer.ETH_addr')
                        ->paginate(25);
                } elseif ($request->isMethod('get')) {

                    $search = $request['search'];
                    $email = $request['email'];
                    $user_search_id = $request['user_search_id'];
                    $q = OpeningBalance::query();
                    $q->join('enjoyer', 'useropeningbalance.user_id', '=', 'enjoyer.id')->select('useropeningbalance.*', 'enjoyer.enjoyer_name', 'enjoyer.XDC_addr', 'enjoyer.XDCE_addr', 'enjoyer.BTC_addr','enjoyer.BCH_addr', 'enjoyer.XRP_addr', 'enjoyer.ETH_addr');

                    if ($search) {
                        $q->where(function ($qq) use ($search) {
                            $qq->where('enjoyer_name', 'like', '%' . $search . '%');
                        });
                    }
                    if ($email) {
                        $spl = explode("@", $email);
                        $user1 = $spl[0];
                        $user2 = $spl[1];
                        $record = getByEmail($user1, $user2);

                        foreach ($record as $val) {
                            $user_id = $val->id;
                            $q->where('useropeningbalance.user_id', $user_id);
                        }
                    }
                    if ($user_search_id) {
                        $q->where('useropeningbalance.user_id', $user_search_id);
                    }
                    $result = $q->orderBy('useropeningbalance.id', 'desc')->paginate(25);
                } else {
                    $result = DB::table('useropeningbalance')
                        ->join('enjoyer', 'useropeningbalance.user_id', '=', 'enjoyer.id')
                        ->orderBy('useropeningbalance.user_id', 'asc')
                        ->select('useropeningbalance.*', 'enjoyer.enjoyer_name', 'enjoyer.XDC_addr', 'enjoyer.XDCE_addr', 'enjoyer.BTC_addr','enjoyer.BCH_addr', 'enjoyer.XRP_addr', 'enjoyer.ETH_addr')
                        ->paginate(25);
                }

                return view('panel.userbalance', ['result' => $result, 'Header' => 'Users Closing Balance']);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }


    //ico price update
    function update_ico_price(Request $request)
    {
        try{
            if (Session::get('alpha_id') == "") {
                return redirect('admin');
            }
            else
                {
                    if($request->isMethod('post'))
                    {
                        $btc_price = $request['btc'];
                        $eth_price = $request['eth'];
                        $usdt_price = $request['usdt'];

                        //update price
                        $ico_rates = ICORate::all();

                        foreach ($ico_rates as $ico_rate)
                        {
                            if($ico_rate->SecondCurrency == 'BTC')
                            {
                            $ico_rate->Amount = $btc_price;
                            $ico_rate->update();

                            }
                            elseif ($ico_rate->SecondCurrency == 'ETH')
                            {
                                $ico_rate->Amount = $eth_price;
                                $ico_rate->update();

                            }
                            elseif ($ico_rate->SecondCurrency == 'USDT')
                            {
                                $ico_rate->Amount = $usdt_price;
                                $ico_rate->update();

                            }
                        }
                        Session::flash('success', 'Price updated successfully.');
                        return redirect('admin/ico_history');

                    }
                }
            }
            catch(\Exception $e) {
                \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
                
            }
    }

}
