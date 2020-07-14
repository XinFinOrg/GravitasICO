<?php

/**
 * This controller includes trade mapping functions .
 * @developer Balakumaran
 * @ver 1.00 03/11/2017
 * @company Osiz technologies
 * @platform laravel 5.4
 **/

namespace App\Http\Controllers;

use App\model\Balance;
use App\model\CurrencyTradeLimit;
use App\model\ico_bonus;
use App\model\ICO_bonus_stats;
use App\model\ICORate;
use App\model\ICOTrade;
use App\model\Pair;
use App\model\Profit;
use App\model\Trade;
use App\model\Tradingfee;
use App\model\Transaction;
use App\model\UserBalance;
use App\model\Users;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Session;

class ICOController extends Controller
{
    //
    public function __construct()
    {
        //cons;
        $ip = \Request::ip();
        blockip_list($ip);
    }

    function index(Request $request)
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                // Session::flash('success','Token sale has been closed');
                // return redirect('wallets');
                if ($request->isMethod('post')) {
                    $second_currency = $request['sell_currency'];

                } else {

                    $second_currency = 'ETH';
                }

                $userid = Session::get('alphauserid');
                $document_status = get_user_details($userid, 'document_status');

                if ($document_status != 1) {
                    Session::flash('error', 'Your kyc is not completed.');
                    return redirect('/kyc');
                } else {
                    // check_live_address($userid);

                    $btc_usd = get_usd_price('BTC');
                    $eth_usd = get_usd_price('ETH');
                    $usdt_usd= get_usd_price('USDT');
                    $icotoken_usd = get_usd_price('GIFT');

                    $minETH = number_format(100 / $eth_usd, 4, '.', '');
                    $minBTC = number_format(1000 / $btc_usd, 6, '.', '');
                    $minUSDT= number_format(1000 / $usdt_usd, 4, '.', '' );

                    $icotoken_total = ICOTrade::where('Status', 'Completed')->sum('Total');
                    $icotoken_reward = ICOTrade::where('Status', 'Completed')->sum('Discount');


                    $bonus = ico_bonus::where('status', 1)->first();
                    $bonus_percent = $bonus->bonus_rate * 100;

                    $btc_icotoken = $btc_usd / $icotoken_usd;

                    $eth_icotoken = $eth_usd / $icotoken_usd;

                    $usdt_icotoken = $usdt_usd / $icotoken_usd;

                    $eth = get_userbalance($userid,'ETH');
                    $btc = get_userbalance($userid,'BTC');
                    $usdt = get_userbalance($userid,'USDT');

                    $data = [
                        'minETH' => $minETH,
                        'minBTC' => $minBTC,
                        'minUSDT'=> $minUSDT,
                        'ETH'=>$eth,
                        'BTC'=>$btc,
                        'USDT'=>$usdt,
                        'aid' => $userid,
                        'GIFT' => number_format($icotoken_total, 2, '.', ''),
                        'GIFT_Reward' => number_format($icotoken_reward, 2, '.', ''),
                        'BTC_icotoken' => $btc_icotoken,
                        'ETH_icotoken' => $eth_icotoken,
                        'USDT_icotoken' => $usdt_icotoken,
                        'Bonus' => $bonus_percent,
                    ];


                    return view('front.ico', ['data' => $data]);
                }

            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }


    function ico_buy(Request $request)
    {
        try {

            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                $userid = Session::get('alphauserid');
                $document_status = get_user_details($userid, 'document_status');


                if ($request->isMethod('post') && $document_status == 1) {


                    $FirstCurrency = $request['first_currency'];
                    $SecondCurrency = $request['second_currency'];
                    $firstCurrency_price = $request['first_currency_price'];
                    $secondCurrency_price = $request['second_currency_price'];
                    $icotoken_id = $request['icotoken_id'];
                    $validate_icotoken = jiocash_validate($icotoken_id);
                    if ($validate_icotoken == 0) {
                        Session::flash('error', 'Invalid gravitas ID.');
                        return redirect()->back();
                    }
                    $user_enjoyer = Users::where('id', $userid)->first();
                    $user_enjoyer->ICOtoken_id = $icotoken_id;
                    $user_enjoyer->save();
                    $second_currency_bal = get_userbalance($userid, $SecondCurrency);
                    if ($second_currency_bal < 0) {
                        Session::flash('error', 'You already have a pending order please complete it.');
                        return redirect('/ico');
                    } else {
                        $updated_secondcurrency_bal = $second_currency_bal - $secondCurrency_price;


                        $get_second_currency_usd = get_usd_price($SecondCurrency);

                        $get_icotoken_usd = get_usd_price($FirstCurrency);

                        $total = $secondCurrency_price * $get_second_currency_usd;

                        $icotoken = $total / $get_icotoken_usd;

                        if ($icotoken > 25000) {
                            $bonus_level = ico_bonus::where('status', 1)->first();
                            $bonus_level_id = $bonus_level->id;
                            $bonus_level_percentage = $bonus_level->bonus_rate;

                            $icotoken_bonus = $icotoken * $bonus_level_percentage;
                            $total_icotoken = number_format($icotoken_bonus + $icotoken, 2, '.', '');
                        } else {
                            $icotoken_bonus = 0;
                            $total_icotoken = number_format($icotoken, 2, '.', '');
                        }


                        $icotoken_trimmed = number_format($icotoken, 2, '.', '');
                        $icotoken_bonus_trimmed = number_format($icotoken_bonus, 2, '.', '');

                        $First_currency_bal = get_userbalance($userid, $FirstCurrency);
                        $updated_first_currency_bal = $First_currency_bal + $total_icotoken;

                        if ($secondCurrency_price > $second_currency_bal) {
                            $status = 'Pending';
                        } else {
                            $status = 'Completed';
                        }

                        $transid = 'TXD' . $userid . time();
                        $ip = \Request::ip();
                        //buy trade record
                        $ico_trade = new ICOTrade();
                        $ico_trade->Type = 'ICO';
                        $ico_trade->transaction_id = $transid;
                        $ico_trade->user_id = $userid;
                        $ico_trade->ip = $ip;
                        $ico_trade->icotoken_id = $icotoken_id;
                        $ico_trade->FirstCurrency = $FirstCurrency;
                        $ico_trade->SecondCurrency = $SecondCurrency;
                        $ico_trade->Price = $total;
                        $ico_trade->firstAmount = $icotoken_trimmed;
                        $ico_trade->Amount = $secondCurrency_price;
                        $ico_trade->Fee = 0;
                        $ico_trade->Discount = $icotoken_bonus_trimmed;
                        $ico_trade->Total = $total_icotoken;
                        $ico_trade->Status = $status;
                        $ico_trade->Previous_Bal = $First_currency_bal;
                        $ico_trade->After_Bal = $updated_first_currency_bal;
                        $ico_trade->Previous_currency = $second_currency_bal;
                        $ico_trade->After_currency = $updated_secondcurrency_bal;

                        if ($ico_trade->save()) {
                            if ($status == 'Completed') {
                                $lobjUserBal = UserBalance::where('user_id', $userid)->first();
                                $lobjUserBal->$SecondCurrency = $updated_secondcurrency_bal;
                                $lobjUserBal->$FirstCurrency = $updated_first_currency_bal;
                                $lobjUserBal->save();

                                //bonus status
                                if ($icotoken_bonus > 0) {
                                    $bonus_status = new ICO_bonus_stats();

                                    $bonus_status->user_id = $userid;
                                    $bonus_status->bonusLeveL = $bonus_level_id;
                                    $bonus_status->ico_id = $ico_trade->id;
                                    $bonus_status->ico_purchased = $icotoken_trimmed;
                                    $bonus_status->ico_profit = $icotoken_bonus_trimmed;
                                    $bonus_status->save();

                                }
                                $bonus_level = ico_bonus::where('status', 1)->first();
                                $bonus_level->cap_level = $bonus_level->cap_level + $icotoken_trimmed;
                                $max = $bonus_level->maximum_range;
                                $bonus_id = $bonus_level->id;
                                $bonus_level_status = $bonus_level->status;
                                if (($bonus_level->cap_level + $icotoken_trimmed) > $max) {
                                    $bonus_level->status = 0;
                                    $bonus_level_status = 0;
                                }
                                $bonus_level->save();
                                if ($bonus_level_status == 0) {
                                    $id = $bonus_id + 1;
                                    $nextbonus_level = ico_bonus::where('id', $id)->first();
                                    if ($nextbonus_level != null) {
                                        $nextbonus_level->status = 1;
                                        $nextbonus_level->save();
                                    }
                                }

                                Session::flash('success', 'The Amount have been credited.');
                                return redirect('/dashboard');
                            } else {
                                $lobjUserBal = UserBalance::where('user_id', $userid)->first();
                                $lobjUserBal->$SecondCurrency = $updated_secondcurrency_bal;
                                $lobjUserBal->save();

                                check_live_address($userid);

                                $ETh = get_user_details($userid, 'ETH_addr');
                                $BTC = get_user_details($userid, 'BTC_addr');
                                $USDT= get_user_details($userid, 'USDT_addr');
                                $ico_buy_trade = ICOTrade::where('user_id', $userid)->get();
                                $currency = 'GIFT';
                                $second_currency_bal = get_userbalance($userid, $SecondCurrency);
                                $currency_bal = get_userbalance($userid, $currency);
                                $ico = ICORate::where('FirstCurrency', $currency)->where('SecondCurrency', $SecondCurrency)->first();
                                $amount = $ico->Amount;

                                $sell_min_limit = CurrencyTradeLimit::where('currency', $SecondCurrency)->first();
                                $sell_min_limit = floatval($sell_min_limit->sell_min);


                                Session::flash('info', 'Your orders is in pending state.Please Deposit ' . $secondCurrency_price - $second_currency_bal . ' ' . $SecondCurrency);

                                return view('front.icotoken_ico', ['ico' => $SecondCurrency, 'user_id' => $userid, 'ETH' => $ETh, 'BTC' => $BTC, 'USDT' => $USDT, 'sell_limit' => $sell_min_limit, 'second_currency' => $SecondCurrency, 'second_currency_bal' => $second_currency_bal, 'currency' => $currency, 'currency_bal' => $currency_bal, 'amount' => $amount, 'Trade' => $ico_buy_trade]);
                            }
                        }


                    }


                }


            }
        } catch (\Exception $exception) {

            Session::flash('error', 'Invalid ICOtokenID.');
            return redirect()->back();
        }

    }

    function ico1(Request $request)
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                if ($request->isMethod('post')) {
                    $second_currency = $request['sell_currency'];

                } else {

                    $second_currency = 'ETH';
                }
                $userid = Session::get('alphauserid');

                $ico_buy_trade = ICOTrade::where('user_id', $userid)->orderBy('id', 'Desc')->get();
                $currency = 'XDCE';
                $second_currency_bal = get_userbalance($userid, $second_currency);
                $currency_bal = get_userbalance($userid, $currency);
                $ico = ICORate::where('FirstCurrency', $currency)->where('SecondCurrency', $second_currency)->first();
                $amount = $ico->Amount;

                $sell_min_limit = CurrencyTradeLimit::where('currency', $second_currency)->first();
                $sell_min_limit = floatval($sell_min_limit->sell_min);


                return view('front.ico1', ['user_id' => $userid, 'sell_limit' => $sell_min_limit, 'second_currency' => $second_currency, 'second_currency_bal' => $second_currency_bal, 'currency' => $currency, 'currency_bal' => $currency_bal, 'amount' => $amount, 'Trade' => $ico_buy_trade]);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }


    //for dynamic rate
    function ico_buy1(Request $request)
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                if ($request->isMethod('post')) {
                    $userid = Session::get('alphauserid');

                    $FirstCurrency = $request['first_currency'];
                    $SecondCurrency = $request['second_currency'];
                    $SecondCurrency_amount = $request['second_currency_price'];

                    $second_currency_bal = get_userbalance($userid, $SecondCurrency);
                    $First_currency_bal = get_userbalance($userid, $FirstCurrency);

                    $updated_secondcurrency_bal = $second_currency_bal - $SecondCurrency_amount;

                    $transid = 'TXD' . $userid . time();
                    $ip = \Request::ip();
                    $today = strtotime(date('Y-m-d H:i:s'));
                    if ($SecondCurrency_amount <= $second_currency_bal)
                    {
                        $updated_secondcurrency_bal = $second_currency_bal - $SecondCurrency_amount;


                        $get_second_currency_usd = get_usd_price($SecondCurrency);

                        $get_icotoken_usd = get_usd_price($FirstCurrency);

                        $total = $SecondCurrency_amount * $get_second_currency_usd;

                        $icotoken = $total / $get_icotoken_usd;

                        $bonus_level = ico_bonus::where('status', 1)->first();
                        $bonus_level_id = $bonus_level->id;
                        $bonus_level_percentage = $bonus_level->bonus_rate;

                        $icotoken_bonus = $icotoken * $bonus_level_percentage;
                        $total_icotoken = number_format($icotoken_bonus + $icotoken, 2, '.', '');

                        $icotoken_trimmed = number_format($icotoken, 2, '.', '');
                        $icotoken_bonus_trimmed = number_format($icotoken_bonus, 2, '.', '');

                        $First_currency_bal = get_userbalance($userid, $FirstCurrency);

                        $updated_first_currency_bal = $First_currency_bal + $total_icotoken;


                        //buy trade record
                        $ico_trade = new ICOTrade();
                        $ico_trade->Type = 'ICO';
                        $ico_trade->transaction_id = $transid;
                        $ico_trade->user_id = $userid;
                        $ico_trade->ip = $ip;
                        $ico_trade->FirstCurrency = $FirstCurrency;
                        $ico_trade->SecondCurrency = $SecondCurrency;
                        $ico_trade->Price = $total;
                        $ico_trade->firstAmount = $icotoken_trimmed;
                        $ico_trade->Amount = $SecondCurrency_amount;
                        $ico_trade->Fee = 0;
                        $ico_trade->Discount = $icotoken_bonus_trimmed;
                        $ico_trade->Total = $total_icotoken;
                        $ico_trade->Status = 'Completed';
                        $ico_trade->Previous_Bal = $First_currency_bal;
                        $ico_trade->After_Bal = $updated_first_currency_bal;
                        $ico_trade->Previous_currency = $second_currency_bal;
                        $ico_trade->After_currency = $updated_secondcurrency_bal;

                        if ($ico_trade->save()) {


                            $lobjUserBal = UserBalance::where('user_id', $userid)->first();
                            $lobjUserBal->$SecondCurrency = $updated_secondcurrency_bal;
                            $lobjUserBal->$FirstCurrency = $updated_first_currency_bal;
                            $lobjUserBal->save();


                            $bonus_status = new ICO_bonus_stats();

                            $bonus_status->user_id = $userid;
                            $bonus_status->bonusLeveL = $bonus_level_id;
                            $bonus_status->ico_id = $ico_trade->id;
                            $bonus_status->ico_purchased = $icotoken_trimmed;
                            $bonus_status->ico_profit = $icotoken_bonus_trimmed;
                            $bonus_status->save();



                            $bonus_level = ico_bonus::where('status', 1)->first();

                            $bonus_date = strtotime($bonus_level->created_at);
                            Session::flash('success', 'The Amount have been credited.');
                            return redirect('/transactions');


                        }
                    }
                    else
                        {
                            Session::flash('error', 'Insufficient Balance');
                            return redirect()->back();
                        }
                }


            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }


//for static rate
    function ico_buy2(Request $request)
    {
        try{
            if (Session::get('alphauserid') == "") {
                return redirect('logout');
            } else {
                if ($request->isMethod('post')) {
                    $userid = Session::get('alphauserid');

                    $FirstCurrency = $request['first_currency'];
                    $SecondCurrency = $request['second_currency'];


                    $second_currency_bal = get_userbalance($userid, $SecondCurrency);
                    $First_currency_bal = get_userbalance($userid, $FirstCurrency);

                    $ico_rate = ICORate::where('FirstCurrency', $FirstCurrency)->where('SecondCurrency', $SecondCurrency)->first();

                    $ico_buy_rate = $ico_rate->Amount;
                    $ico_fee = $ico_rate->Fee;
                    $ico_discount = $ico_rate->Discount;

                    $SecondCurrency_amount = $request['second_currency_amount'];

                    $transid = 'TXD' . $userid . time();
                    $ip = \Request::ip();
                    $today = date('Y-m-d H:i:s');
                    if ($SecondCurrency_amount <= $second_currency_bal) {
                        $buy_first_currency = $SecondCurrency_amount * $ico_buy_rate;

                        $fee = $SecondCurrency_amount * ($ico_fee / 100);
                        $discount = $SecondCurrency_amount * ($ico_discount / 100);

                        $total = ($buy_first_currency + $discount) - $fee;

                        $updated_secondcurrency_bal = $second_currency_bal - $SecondCurrency_amount;

                        $updated_first_currency_bal = $First_currency_bal + $buy_first_currency;

                        //buy trade record
                        $ico_trade = new ICOTrade();
                        $ico_trade->Type = 'ICO';
                        $ico_trade->transaction_id = $transid;
                        $ico_trade->user_id = $userid;
                        $ico_trade->ip = $ip;
                        $ico_trade->FirstCurrency = $FirstCurrency;
                        $ico_trade->SecondCurrency = $SecondCurrency;
                        $ico_trade->Price = $ico_buy_rate;
                        $ico_trade->Amount = $SecondCurrency_amount;
                        $ico_trade->Fee = $fee;
                        $ico_trade->Discount = $discount;
                        $ico_trade->Total = $total;
                        $ico_trade->Status = 'Completed';
                        $ico_trade->Previous_Bal = $First_currency_bal;
                        $ico_trade->After_Bal = $updated_first_currency_bal;
                        $ico_trade->Previous_currency = $second_currency_bal;
                        $ico_trade->After_currency = $updated_secondcurrency_bal;


                        if ($ico_trade->save()) {
                            $lobjUserBal = UserBalance::where('user_id', $userid)->first();
                            $lobjUserBal->$SecondCurrency = $updated_secondcurrency_bal;
                            $lobjUserBal->$FirstCurrency = $updated_first_currency_bal;
                            $lobjUserBal->save();
                            Session::flash('Success', 'The Amount have been credited. ');
                            return redirect('/testico');
                        }

                    } else {

                        $buy_first_currency = $SecondCurrency_amount * $ico_buy_rate;

                        $fee = $SecondCurrency_amount * ($ico_fee / 100);
                        $discount = $SecondCurrency_amount * ($ico_discount / 100);

                        $total = ($buy_first_currency + $discount) - $fee;

                        $updated_secondcurrency_bal = $second_currency_bal - $SecondCurrency_amount;

                        $updated_first_currency_bal = $First_currency_bal + $buy_first_currency;

                        //buy trade record
                        $ico_trade = new ICOTrade();
                        $ico_trade->Type = 'ICO';
                        $ico_trade->transaction_id = $transid;
                        $ico_trade->user_id = $userid;
                        $ico_trade->ip = $ip;
                        $ico_trade->FirstCurrency = $FirstCurrency;
                        $ico_trade->SecondCurrency = $SecondCurrency;
                        $ico_trade->Price = $ico_buy_rate;
                        $ico_trade->Amount = $SecondCurrency_amount;
                        $ico_trade->Fee = $fee;
                        $ico_trade->Discount = $discount;
                        $ico_trade->Total = $total;
                        $ico_trade->Status = 'Pending';
                        $ico_trade->Previous_Bal = $First_currency_bal;
                        $ico_trade->After_Bal = $updated_first_currency_bal;
                        $ico_trade->Previous_currency = $second_currency_bal;
                        $ico_trade->After_currency = $updated_secondcurrency_bal;
                        $ico_trade->created_at = $today;
                        $ico_trade->updated_at = $today;

                        if ($ico_trade->save()) {
                            $lobjUserBal = UserBalance::where('user_id', $userid)->first();
                            $lobjUserBal->$SecondCurrency = $updated_secondcurrency_bal;
                            $lobjUserBal->save();
                        }
                        Session::flash('Success', 'Your order is pending will be completed once you deposit remaining amount');
                        return redirect('/testico');
                    }
                }


            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //pending request
    function pending_ico_order(Request $request)
    {
        try{
            $ico_buy_trade = ICOTrade::where('Status', 'Pending')->orderBy('id', 'Desc')->get();

            if ($ico_buy_trade) {
                foreach ($ico_buy_trade as $pending) {
                    $sell_currency = $pending->SecondCurrency;
                    $amount = $pending->Amount;
                    $total = $pending->Total;
                    $user_id = $pending->user_id;
                    $transid = $pending->transaction_id;
                    $created_at = $pending->created_at;
                    echo $created_at;
                    $after_currency = $pending->After_currency;

                    if ($pending->Previous_currency > 0) {
                        $difference_amount = $amount - $pending->Previous_currency;
                    } else {
                        $difference_amount = $amount;
                    }

                    //user current balance
                    $sell_currency_bal = get_userbalance($user_id, $sell_currency);

                    if ($sell_currency_bal > $after_currency) {
                        $user_deposits = Transaction::where('created_at', '>=', $created_at)->where('type', 'Deposit')
                            ->where('status', 'Completed')->where('currency_name', $sell_currency)->orderBy('id', 'desc')->sum('amount');
                        echo $user_deposits;
                        if ($user_deposits >= $difference_amount) {
                            $pending->Status = 'Completed';
                            $pending->save();
                            $Update_userbal = UserBalance::where('user_id', $user_id)->first();
                            $Update_userbal->XDCE = $Update_userbal->XDCE + $total;
                            if ($Update_userbal->save()) {
                                ico_mail($user_id, $amount, $transid, 'XDCE');
                            }

                        }

                    }


                }
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //cancel trade
    function Cancel_pending_order($id)
    {
        try{
            $trade = ICOTrade::where('id', $id)->first();

            $amount = $trade->Amount;
            $trade->Status = 'Cancelled';
            $user_id = $trade->user_id;
            $currency = $trade->SecondCurrency;
            $get_user_bal = get_userbalance($user_id, $currency);

            $amount = $amount + $get_user_bal;

            //update Userbalance
            $val = update_user_balance($user_id, $currency, $amount);

            if ($val == true) {
                $trade->save();
                Session::flash('Success', 'Your order is been cancelled');

                return redirect('/testico');
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }

    //cancel pending order more than one day


    function old_pending_cancel()
    {
        try{
            $ico_buy_trade = ICOTrade::where('Status', 'Pending')->orderBy('id', 'Desc')->get();

            foreach ($ico_buy_trade as $trade) {
                $date = $trade->created_at;

                $now = Carbon::now();

                $end = Carbon::parse($date);

                $length = $end->diffInDays($now);

                echo($length);
                if ($length > 2)
                    $amount = $trade->Amount;
                $trade->Status = 'Cancelled';
                $user_id = $trade->user_id;
                $currency = $trade->SecondCurrency;
                $get_user_bal = get_userbalance($user_id, $currency);

                $amount = $amount + $get_user_bal;

                //update Userbalance
                $val = update_user_balance($user_id, $currency, $amount);

                if ($val == true) {
                }


            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }


}
