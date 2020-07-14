<?php

namespace App\Http\Controllers;

use App\model\ICOTrade;
use App\model\OTP;
use App\model\Trade;
use App\model\Users;
use App\model\XDCChart;
use App\model\Balance;
use App\model\Transaction;
use App\model\ico_bonus;
use Hash;
use Illuminate\Http\Request;
use Psy\Exception\Exception;
use Session;

class AjaxController extends Controller {
	//
	function index() {
		abort(404);
	}

	function checkemail(Request $request) {

		if ($request->isMethod('post')) {
			$email = $request['email_id'];
			$spl = explode("@", $email);
			$user1 = $spl[0];
			$user2 = $spl[1];
			$res = $this->checking($user1, $user2);
			echo $res;

		}
	}


	//for ico usd rates
    function get_ico_usd_price()
    {
        try
        {
            $get_eth_usd = get_usd_price('ETH');

			$get_btc_usd = get_usd_price('BTC');
			
			$get_usdt_usd = get_usd_price('USDT');

            $icotoken_usd = get_usd_price('GIFT');


            $minETH = number_format(200/$get_eth_usd,4,'.','');
            $minBTC = number_format(200/$get_btc_usd,6,'.','');
			$minUSDT = number_format(200/$get_usdt_usd,4,'.','');

            $bonus_level = ico_bonus::where('status',1)->first();
            $cap_level = $bonus_level->cap_level;
            $bonus = $bonus_level->bonus_rate;
            $data = array('BTC'=>$get_btc_usd,'ETH'=>$get_eth_usd,'GIFT'=>$icotoken_usd,'CAP'=>$cap_level,
                'Bonus'=>$bonus,'minETH'=>$minETH,'minBTC'=>$minBTC);
			\Log::info(['get_usd_price',$data]);
            $data = array('BTC'=>$get_btc_usd,'ETH'=>$get_eth_usd,'USDT'=>$get_usdt_usd,'GIFT'=>$icotoken_usd,'CAP'=>$cap_level,
                'Bonus'=>$bonus,'minETH'=>$minETH,'minBTC'=>$minBTC,'minUSDT'=>$minUSDT);


            return json_encode($data);
        }
        catch (\Exception $e) {
			\Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
			return '0';
        }
    }
    //for get sold amount
    function get_sold_amount()
    {
        try
        {
            $icotoken_total = ICOTrade::where('Status', 'Completed')->sum('Total');
            $eth = ($icotoken_total*0.20)/470;
            $result = array('message'=>$eth);
            return json_encode($result);
        }
        catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
            return '0';
        }
    }

	//for user verification
    function user_verification($id)
    {
        if (Session::get('alpha_id') == "") {
            return redirect('admin');}
        else
        {
            $get_user = Users::where('id',$id)->first();

            if($get_user->user_verified == 0)
            {
                $get_user->user_verified = 1;
            }
            else
                {
                    $get_user->user_verified = 0;
                }


            if($get_user->save())
            {
                return 1;

            }
            else
            {
                return 0;
            }


        }

    }

	function checking($end_user1, $end_user2) {
		$items = Users::all()->filter(function ($record) use ($end_user1, $end_user2) {
			if (decrypt($record->end_user1) == $end_user1 && decrypt($record->end_user2) == $end_user2) {
				echo "false";
			} else {
				echo "true";
			}
		});

	}

	function checkphone(Request $request){
		if($request->isMethod('post')){
		$mobile_no = $request['mobile_no'];
		$user_id = $request['user_id'];
		$user = Users::where('id', '=', $user_id)->first();
		$user->mobile_no =  ownencrypt($mobile_no);
		if($user->isDirty('mobile_no'))
		{
		$numbers = Users::where('mobile_no', '=', $user->mobile_no)->first();
		if ($numbers == null) {
	 $data['message']=0;
		}
		else {




			Session::flash('error', 'The Phone Number Already Exsits.');
		}
	}
	else {
		$data['message']=0;
	}
		echo json_encode($data);
	}
}

	function registerotp(Request $request) {
		if ($request->isMethod('post')) {
			$isdcode = $request['isdcode'];
			$phone = $request['phone'];
			$email = $request['reg_email'];
			$type = $request['type'];
			$otp = get_otpnumber('0', $isdcode, $phone, $type);
			if (is_numeric($otp)) {
				$to = '+' . $isdcode . $phone;
				$text = "Gravitas verification code is " . $otp;
				//send_sms($to, $text);
				$ansurl = url('ticker/getxmlres/' . $otp);
				voiceotp($to, $ansurl);

				$to = $email;
				$subject = get_template('9', 'subject');
				$message = get_template('9', 'template');
				$mailarr = array(
					'###OTP###' => $otp,
					'###SITENAME###' => get_config('site_name'),
					'###SITELINK###' => url('/'),
				);
				$message = strtr($message, $mailarr);
				$subject = strtr($subject, $mailarr);
				//sendmail($to, $subject, ['content' => $message]);
				$res = array('status' => 1, 'sms' => 'send');
			} else {
				$res = array('status' => 0, 'sms' => 'notsend');
			}
			//echo Response::json($res);
			echo json_encode($res);
		}
	}

    function otp_call($id)
    {
        if (Session::get('alphauserid') == "") {
            return redirect('logout');
        }
        else
        {
            $mobile = get_user_details($id,'mobile_no');
            $isd_code = get_user_details($id,'mob_isd');

            $check = OTP::where('mobile_no', $mobile)->orderBy('id', 'desc')->limit(1)->first();

            $otp = owndecrypt($check->otp);
            $to  = '+'.$isd_code.owndecrypt($mobile);
            $ansurl = url('' . $otp);
           $result = voiceotp($to, $ansurl);

           if($result == true)
           {
               $res = array('status' => 1, 'sms' => 'Call Sent');
           }
           else
               {
                   $res = array('status' => 0, 'sms' => 'Call not sent contact Support to verify your issue');
               }
        }
    }

	function verify_otp(Request $request) {
		if ($request->isMethod('post')) {
			$code = $request['verify_code'];
			$mobile = $request['mobile'];
    	$user_id = $request['user_id'];
			$vcode = ownencrypt($code);
			/*$check = OTP::where('mobile_no', ownencrypt($mobile))->where('otp', ownencrypt($code))->orderBy('id', 'desc')->limit(1)->first();*/
			$check = OTP::where('mobile_no', ownencrypt($mobile))->orderBy('id', 'desc')->limit(1)->first();
			if (count($check) > 0 && $check->otp == $vcode)
			{

				$data['message'] = "Mobile verified successfully";
				$data['status'] = 1;
				$data['key'] = encrypt($mobile . '#' . $check->otp);
				$check->delete();
				if($user_id != 0)
				{
				    $user = Users::where('id',$user_id)->first();
				    if($user->mobile_status != 1)
				    {
				        $user->mobile_no = ownencrypt($mobile);
				        $user->mobile_status = 1;
				        $user->save();
                        Session::flash('success','Your Mobile verification has been completed.');
                    }
                }

			} else {
				$data['message'] = "Enter valid code";
				$data['status'] = 0;
				$data['key'] = encrypt('wrong');
			}
			echo json_encode($data);
		}
	}

	function refresh_capcha() {
		return captcha_img();
	}

	function checkoldpass(Request $request) {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			if ($request->isMethod('post')) {
				$userid = Session::get('alphauserid');
				$oldpass = $request['old_password'];
				$recordpass = get_user_details($userid, 'pass_code');
				if (Hash::check($oldpass, $recordpass)) {
					echo "true";
				} else {
					echo "false";
				}

			}
		}
	}

	function verifyotp(Request $request) {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			if ($request->isMethod('post')) {
				$userid = Session::get('alphauserid');
				$isdcode = $request['isdcode'];
				$phone = $request['phone'];
				$check = Users::where('id', $userid)->where('mobile_no', ownencrypt($phone))->count();
				if ($check > 0) {
					$res = array('status' => 0, 'sms' => 'This Current mobile number');
					echo json_encode($res);
					exit;
				}
				$otp = get_otpnumber($userid, $isdcode, $phone, 'update');
				if (is_numeric($otp)) {
					$to = '+' . $isdcode . $phone;
					$text = "Gravitas verification code is " . $otp;
					//send_sms($to, $text);
					$ansurl = url('ticker/getxmlres/' . $otp);
					voiceotp($to, $ansurl);
					$res = array('status' => 1, 'sms' => 'send');
				} else {
					$res = array('status' => 0, 'sms' => 'notsend');
				}
				//echo Response::json($res);
				echo json_encode($res);
			}
		}

	}

	function limit_balance(Request $request) {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			if ($request->isMethod('post')) {
				$userid = Session::get('alphauserid');
				$amount = $request['to_amount'];
				$curr = $request['curr'];
				$getuserbal = get_userbalance($userid, $curr);
				if ($amount <= $getuserbal) {
					echo "true";
				} else {
					echo "false";
				}

			}
		}
	}

	function generate_otp(Request $request) {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			if ($request->isMethod('post')) {
				$userid = Session::get('alphauserid');
				$type = $request['type'];
				$mob = get_user_details($userid, 'mobile_no');
				$phone = owndecrypt($mob);
				$isdcode = get_user_details($userid, 'mob_isd');
				$otp = get_otpnumber($userid, $isdcode, $phone, $type);
				$to = '+' . $isdcode . $phone;
				$text = "Gravitas OTP code is " . $otp . " Please dont share your otp";
				//send_sms($to, $text);
				$ansurl = url('/ticker/getxmlres/' . $otp);
				voiceotp($to, $ansurl);
				echo "sent";
			}
		}
	}

    function generate_email_otp(Request $request) {
        if (Session::get('alphauserid') == "") {
            return redirect('logout');
        } else {
            if ($request->isMethod('post')) {
                $userid = Session::get('alphauserid');
                $type = $request['type'];
                $isdcode = get_user_details($userid, 'mob_isd');
                $mob = get_user_details($userid, 'mobile_no');
                $phone = owndecrypt($mob);
                $email = get_usermail($userid);
                $otp = get_otpnumber($userid, $isdcode, $phone, $type);

                $to = $email;
                $subject = 'Withdrawal OTP';
                $message = get_template('9', 'template');
                $mailarr = array(

                    '###OTP###' => $otp,
                    '###SITENAME###' => get_config('site_name'),
                );
                $message = strtr($message, $mailarr);
                $subject = strtr($subject, $mailarr);
                sendmail($to, $subject, ['content' => $message]);
                Session::flash('success', 'Please check your email address for otp');

                echo "sent";
            }
        }
    }

	function otp_test(Request $request)
    {
        $to = $request['num'];
        $ans = $request['url'];
        voiceotp($to,$ans);
        echo "sent";
    }

	function exchange_chart($pair) {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$pair = $pair ? $pair : 'XDC-ETH';
			$cur = explode("-", $pair);
			$first_currency = $cur[0];
			$second_currency = $cur[1];
			$result = XDCChart::select($second_currency, 'created_at')->orderBy('id', 'desc')->limit(15)->get();
			$chart = "";
			foreach ($result as $val) {
				$date1 = date('Y-m-d', strtotime($val->created_at));
				$dat = strtotime($date1) * 1000;
				$chart .= "[" . $dat . ',' . $val->$second_currency . "],";

			}
			echo "[" . trim($chart, ",") . "]";

		}
	}

	function address_validation(Request $request) {
		if ($request->isMethod('post')) {
			$currency = $request['curr'];
			$toaddr = $request['to_addr'];
			if ($currency == 'BTC') {
				$url = "https://blockchain.info/rawaddr/" . $toaddr;

				$cObj = curl_init();
				curl_setopt($cObj, CURLOPT_URL, $url);
				curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
				$btc = json_decode(curl_exec($cObj));
				$curlinfos = curl_getinfo($cObj);
				echo (count($btc) > 0) ? 'true' : 'false';
			}else if ($currency == 'BCH') {
                $url = "https://blockchain.info/rawaddr/" . $toaddr;

                $cObj = curl_init();
                curl_setopt($cObj, CURLOPT_URL, $url);
                curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
                $bch = json_decode(curl_exec($cObj));
                $curlinfos = curl_getinfo($cObj);
                echo (count($bch) > 0) ? 'true' : 'false';
            }  else if ($currency == 'XDC') {
				//$toaddr = strtolower($toaddr);
				$res = verify_xdc_addr($toaddr);
				echo ($res->status == 'SUCCESS') ? 'true' : 'false';
			} elseif ($currency == 'XRP') {
				$url = "https://data.ripple.com/v2/accounts/" . $toaddr . "/balances?currency=XRP";

				$cObj = curl_init();
				curl_setopt($cObj, CURLOPT_URL, $url);
				curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
				$xrp = json_decode(curl_exec($cObj));
				$curlinfos = curl_getinfo($cObj);
				echo ($xrp->result == 'error' && @$xrp->message == 'invalid ripple address') ? 'false' : 'true';
			} else {
				echo "true";
			}
		}
	}

	function get_instant_buy_form($pair = "") {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$userid = Session::get('alphauserid');
			$cur = explode("-", $pair);
			$first_currency = $cur[0];
			$second_currency = $cur[1];
			$second_cur_balance = get_userbalance($userid, $second_currency);
			return view('trade.inst_buy', ['first_currency' => $first_currency, 'second_currency' => $second_currency, 'second_cur_balance' => $second_cur_balance]);
		}
	}

	function get_instant_sell_form($pair = "") {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$userid = Session::get('alphauserid');
			$cur = explode("-", $pair);
			$first_currency = $cur[0];
			$second_currency = $cur[1];
			$first_cur_balance = get_userbalance($userid, $first_currency);
			return view('trade.inst_sell', ['first_currency' => $first_currency, 'second_currency' => $second_currency, 'first_cur_balance' => $first_cur_balance]);
		}
	}

	function get_limit_buy_form($pair = "") {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$userid = Session::get('alphauserid');
			$cur = explode("-", $pair);
			$first_currency = $cur[0];
			$second_currency = $cur[1];
			$second_cur_balance = get_userbalance($userid, $second_currency);
			$first_cur_balance = get_userbalance($userid, $first_currency);

			$buy_rate = get_buy_market_rate($first_currency, $second_currency);
			$sell_rate = get_sell_market_rate($first_currency, $second_currency);

			return view('trade.limit_buy', ['first_currency' => $first_currency, 'second_currency' => $second_currency, 'second_cur_balance' => $second_cur_balance, 'first_cur_balance' => $first_cur_balance, 'buy_rate' => $buy_rate, 'sell_rate' => $sell_rate]);
		}
	}



	function get_limit_sell_form($pair = "") {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$userid = Session::get('alphauserid');
			$cur = explode("-", $pair);
			$first_currency = $cur[0];
			$second_currency = $cur[1];
			$second_cur_balance = get_userbalance($userid, $second_currency);
			$first_cur_balance = get_userbalance($userid, $first_currency);

			$buy_rate = get_buy_market_rate($first_currency, $second_currency);
			$sell_rate = get_sell_market_rate($first_currency, $second_currency);

			return view('trade.limit_sell', ['first_currency' => $first_currency, 'second_currency' => $second_currency, 'second_cur_balance' => $second_cur_balance, 'first_cur_balance' => $first_cur_balance, 'buy_rate' => $buy_rate, 'sell_rate' => $sell_rate]);
		}
	}

	function get_stop_buy_form($pair = "") {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$userid = Session::get('alphauserid');
			$cur = explode("-", $pair);
			$first_currency = $cur[0];
			$second_currency = $cur[1];
			$second_cur_balance = get_userbalance($userid, $second_currency);
			$first_cur_balance = get_userbalance($userid, $first_currency);

			$buy_rate = get_buy_market_rate($first_currency, $second_currency);
			$sell_rate = get_sell_market_rate($first_currency, $second_currency);

			return view('trade.stop_buy', ['first_currency' => $first_currency, 'second_currency' => $second_currency, 'second_cur_balance' => $second_cur_balance, 'first_cur_balance' => $first_cur_balance, 'buy_rate' => $buy_rate, 'sell_rate' => $sell_rate]);
		}
	}

	function get_stop_sell_form($pair = "") {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$userid = Session::get('alphauserid');
			$cur = explode("-", $pair);
			$first_currency = $cur[0];
			$second_currency = $cur[1];
			$second_cur_balance = get_userbalance($userid, $second_currency);
			$first_cur_balance = get_userbalance($userid, $first_currency);

			$buy_rate = get_buy_market_rate($first_currency, $second_currency);
			$sell_rate = get_sell_market_rate($first_currency, $second_currency);

			return view('trade.stop_sell', ['first_currency' => $first_currency, 'second_currency' => $second_currency, 'second_cur_balance' => $second_cur_balance, 'first_cur_balance' => $first_cur_balance, 'buy_rate' => $buy_rate, 'sell_rate' => $sell_rate]);
		}
	}

	function get_buy_tradeorders($pair = "") {

		$buy_order_list = Trade::where(['pair' => $pair, 'Type' => 'Sell'])->where(function ($query) {
			$query->where('status', 'active')->Orwhere('status', 'partially');
		})->orderBy('id', 'desc')->get();
		return view('trade.autobuyorders', ['buy_order_list' => $buy_order_list]);
	}

	function get_sell_tradeorders($pair = "") {

		$sell_order_list = Trade::where(['pair' => $pair, 'Type' => 'Buy'])->where(function ($query) {
			$query->where('status', 'active')->Orwhere('status', 'partially');
		})->orderBy('id', 'desc')->get();
		return view('trade.autosellorders', ['sell_order_list' => $sell_order_list]);
	}

	function get_estimatme_usdbalance(Request $request) {
		if ($request->isMethod('get')) {
			$currency = $request['currency'];
			//$amount = $request['amount'];
			$amount = 1;
			$price = $request['price'];
			$cur_price = get_estusd_price($currency, $amount);
			echo $cur_price * $price;
		}
	}

	function XDCdeposit($userid)
    {
        $transid = 'TXD' . $userid . time();
        $xdcaddr = get_user_details($userid, 'XDC_addr');
        $xdcbal = get_livexdc_bal($xdcaddr);
        //$xdcbal = 0;
        if ($xdcbal > 0)
        {
            $email = get_usermail($userid);
            //$pass = Session::get('xinfinpass');
            $pass = get_user_details($userid, 'xinpass');
            login_xdc_fun($email, owndecrypt($pass));
            $adminxdcaddr = decrypt(get_config('xdc_address'));
            $res = transfer_xdctoken($xdcaddr, $xdcbal, $adminxdcaddr, $userid, owndecrypt($pass));
            try
            {
                if ($res->status == 'SUCCESS') {
                    $fetchbalance = get_userbalance($userid, 'XDC');
                    $uptbal = $fetchbalance + $xdcbal;
                    $upt = Balance::where('user_id', $userid)->first();
                    $upt->XDC = $uptbal;
                    $upt->save();

                    $transid = 'TXD' . $userid . time();
                    $today = date('Y-m-d H:i:s');
                    $ip = \Request::ip();
                    $ins = new Transaction;
                    $ins->user_id = $userid;
                    $ins->payment_method = 'Cryptocurrency Account';
                    $ins->transaction_id = $transid;
                    $ins->currency_name = 'XDC';
                    $ins->type = 'Deposit';
                    $ins->transaction_type = '1';
                    $ins->amount = $xdcbal;
                    $ins->updated_at = $today;
                    $ins->crypto_address = $xdcaddr;
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
                    echo "Deposit of ".$xdcbal." XDC completed for user id ".$userid.".";
                }
                echo $res->status." ".$res->message;
            }catch (\Exception $e)
            {
                echo $e->getMessage();
            }
        }
        else{
            echo "No pending XDC deposit for user id ".$userid.".";
        }
    }

    function btc_deposit_process_user($user_addr)
    {
        $date = date('Y-m-d');
        $time = date('h:i:s');
        $bitcoin = get_btc_transactionlist();
        $bitcoin_isvalid = $bitcoin->listtransactions();

        if ($bitcoin_isvalid) {
            for ($i = 0; $i < count($bitcoin_isvalid); $i++) {
                if ($bitcoin_isvalid[$i]['address'] == $user_addr)
                    break;
            }
            $account = $bitcoin_isvalid[$i]['account'];
            $address = $bitcoin_isvalid[$i]['address'];
            $category = $bitcoin_isvalid[$i]['category'];
            $btctxid = $bitcoin_isvalid[$i]['txid'];
            if ($category == 'receive') {
                $isvalid = $bitcoin->gettransaction($btctxid);
                $det_category = $isvalid['details'][0]['category'];
                if ($det_category == "receive") {
                    $btcaccount = $isvalid['details'][0]['account'];
                    $btcaddress = $isvalid['details'][0]['address'];
                    $bitcoin_balance = $isvalid['details'][0]['amount'];
                    $btcconfirmations = $isvalid['confirmations'];
                } else {
                    $btcaccount = $isvalid['details'][1]['account'];
                    $btcaddress = $isvalid['details'][1]['address'];
                    $bitcoin_balance = $isvalid['details'][1]['amount'];
                    $btcconfirmations = $isvalid['confirmations'];
                }
                $amount = $bitcoin_balance;
                if ($btcconfirmations >= 3) {
                    $userid = get_userid_btcaddr($btcaddress);
                    if (is_numeric($userid)) {
                        $checktrans = Transaction::where('type', 'Deposit')->where('wallet_txid', $btctxid)->first();
                        if (count($checktrans) == 0) {
                            $fetchbalance = get_userbalance($userid, 'BTC');
                            $finalbalance = $fetchbalance + $bitcoin_balance;
                            $upt = Balance::where('user_id', $userid)->first();
                            $upt->BTC = $finalbalance;
                            $upt->save();

                            $transid = 'TXD' . $userid . time();
                            $today = date('Y-m-d H:i:s');
                            $ip = \Request::ip();
                            $ins = new Transaction;
                            $ins->user_id = $userid;
                            $ins->payment_method = 'Cryptocurrency Account';
                            $ins->transaction_id = $transid;
                            $ins->currency_name = 'BTC';
                            $ins->type = 'Deposit';
                            $ins->transaction_type = '1';
                            $ins->amount = $bitcoin_balance;
                            $ins->updated_at = $today;
                            $ins->crypto_address = $btcaddress;
                            $ins->transfer_amount = '0';
                            $ins->fee = '0';
                            $ins->tax = '0';
                            $ins->verifycode = '1';
                            $ins->order_id = '0';
                            $ins->status = 'Completed';
                            $ins->cointype = '2';
                            $ins->payment_status = 'Paid';
                            $ins->paid_amount = '0';
                            $ins->wallet_txid = $btctxid;
                            $ins->ip_address = $ip;
                            $ins->verify = '1';
                            $ins->blocknumber = '';
                            if ($ins->save()) {
                                $this->deposit_mail($userid, $bitcoin_balance, $transid, 'BTC');
                            }
                        }
                    }
                }
            }
        }
	}
	
	function get_currency_address(Request $request)
    {
        try {
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                if ($request->isMethod('post')) {
                    $userid = Session::get('alphauserid');
                    $oldpass = $request['currency'];
                    $recordpass = get_user_details($userid, $oldpass);
                    \Log::info(['>>>',$oldpass]);
					
                    if ($recordpass != '' && $recordpass != null && $recordpass != 'error') {
                        return $recordpass;
                    } else {
                        $oldpass = str_replace('_addr', '', $oldpass);
//                        echo "error";
                        $addr = generate_currency_address($userid, $oldpass);
                        if ($addr != '' && $addr != 'error' && $addr != null) {
                            return $addr;
                        } else {
                            return "";
                        }
                    }

                }
            }
        } catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
        
        }

    }

// end class
}
