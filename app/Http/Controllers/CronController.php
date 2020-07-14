<?php

namespace App\Http\Controllers;

use App\model\Admin;
use App\model\Balance;
use App\model\ico_bonus;
use App\model\ICO_bonus_stats;
use App\model\ICOTrade;
use App\model\Node;
use App\model\ClosingBalance;
use App\model\Marketprice;
use App\model\OpeningBalance;
use App\model\SiteSettings;
use App\model\Trade;
use App\model\Transaction;
use App\model\UserBalance;
use App\model\Users;
use App\model\Wallettrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Exception\ErrorException;

class CronController extends Controller
{
    //

    function index()
    {
        abort('404');
    }

    function update_prices()
    {
        try{
        //BTC
        $btc_usd = $this->get_live_estusd_price('tBTCUSD');
        echo "BTC-USD  : " . $btc_usd;
        echo "<br>";


        $lobjMarket = Marketprice::where('id', '1')->first();
        $lobjMarket->USD = $btc_usd;
        $lobjMarket->save();
        echo "<br>";

        //ETH
        $eth_usd = $this->get_live_estusd_price('tETHUSD');
        echo "ETH-USD  : " . $eth_usd;
        echo "<br>";


        $lobjMarket = Marketprice::where('id', '2')->first();
        $lobjMarket->USD = $eth_usd;
        $lobjMarket->save();
        echo "<br>";

        //USDT
        $usdt_usd = $this->get_live_estusd_price('tUSTUSD');
        echo "USDT-USD  : " . $usdt_usd;
        echo "<br>";


        $lobjMarket = Marketprice::where('id', '4')->first();
        $lobjMarket->USD = $usdt_usd;
        $lobjMarket->save();
        echo "<br>";
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }


    }

    function get_market_prices($cur1, $cur2)
    {
        try{
            $currency = $cur1 . '-' . $cur2;
            $url = "https://api.cryptonator.com/api/ticker/" . $currency;
            $result = file_get_contents($url);
            $res = json_decode($result);
            $out = $res->ticker;
            return $out->price;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function bonus_status()
    {
        try {

        } catch (\Exception $exception) {

        }
    }

    function get_live_estusd_price($cur)
    {
        try{
            $url = "https://api.bitfinex.com/v2/ticker/" . $cur;
            $result = file_get_contents($url);
            $res = json_decode($result);
            $price = $res[6];
            return $price;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function eth_deposit_process(Request $request)
    {
        try {
            // Fill these in with the information from your CoinPayments.net account.
            $cp_merchant_id = owndecrypt(get_config('coinpayment_merchant_id'));
            $cp_ipn_secret = owndecrypt(get_config('coinpayment_ipn_secret'));
            \Log::info(['details',$cp_merchant_id,$cp_ipn_secret]);

            if (!isset($request['ipn_mode']) || $request['ipn_mode'] != 'hmac') {
                errorAndDie('IPN Mode is not HMAC');
            }

            if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
                errorAndDie('No HMAC signature sent.');
            }

            $request_data = file_get_contents('php://input');
            if ($request_data === FALSE || empty($request_data)) {
                errorAndDie('Error reading POST data');
            }

            if (!isset($request['merchant']) || $request['merchant'] != trim($cp_merchant_id)) {
                errorAndDie('No or incorrect Merchant ID passed');
            }

            $hmac = hash_hmac("sha512", $request_data, trim($cp_ipn_secret));
            if (!hash_equals($hmac, $_SERVER['HTTP_HMAC'])) {
                //if ($hmac != $_SERVER['HTTP_HMAC']) { <-- Use this if you are running a version of PHP below 5.6.0 without the hash_equals function
                errorAndDie('HMAC signature does not match');
            }

            // HMAC Signature verified at this point, load some variables.
            $dep_id = $request['txn_id'];
            $to_address = $request['address'];
            $balance = floatval($request['amount']);
            $currency = $request['currency'];
            $status = intval($request['status']);
            $status_text = $request['status_text'];
            $confirms = $request['confirms'];
            $fiat_fee = $request['fiat_fee'];

            \Log::info(['POST DATA2', $dep_id, $to_address, $balance, $currency, $status, $status_text, $confirms, $fiat_fee]);
            //depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point

            // Check the original currency to make sure the buyer didn't change it.
//        if ($currency != $order_currency) {
//            errorAndDie('Original currency mismatch!');
//        }
//
//        // Check amount against order total
//        if ($amount < $order_total) {
//            errorAndDie('Amount is less than order total!');
//        }

            if ($status >= 100 || $status == 2) {
                // payment is complete or queued for nightly payout, success
                if ($currency == 'ETH') {
                    $user = Users::where('ETH_addr', '=', $to_address)->first();
                } elseif ($currency == 'BTC') {
                    $user = Users::where('BTC_addr', '=', $to_address)->first();
                } elseif ($currency == 'USDT') {
                    $user = Users::where('USDT_addr', '=', $to_address)->first();
                } else {
                    $user = '';
                }
                if ($user != null && $to_address != null) {
                    $dep_already = $this->eth_checkdepositalready($user->id, $dep_id);
                    if ($dep_already === TRUE && (float)$balance > 0) {

                        $balance = sprintf('%.10f', $balance);

                        $fetchbalance = get_userbalance($user->id, $currency);
                        $finalbalance = $fetchbalance + $balance;

                        $transid = 'TXD' . $user->id . time();

                        $upt = Balance::where('user_id', $user->id)->first();
                        $upt->$currency = $finalbalance;
                        $upt->save();

                        $today = date('Y-m-d H:i:s');
                        $ip = \Request::ip();
                        $ins = new Transaction();
                        $ins->user_id = $user->id;
                        $ins->payment_method = 'Cryptocurrency Account';
                        $ins->transaction_id = $transid;
                        $ins->currency_name = $currency;
                        $ins->type = 'Deposit';
                        $ins->transaction_type = '1';
                        $ins->amount = $balance;
                        $ins->updated_at = $today;
                        $ins->crypto_address = $to_address;
                        $ins->transfer_amount = '0';
                        $ins->fee = '0';
                        $ins->tax = '0';
                        $ins->verifycode = '1';
                        $ins->order_id = '0';
                        $ins->status = 'Completed';
                        $ins->cointype = '2';
                        $ins->payment_status = 'Paid';
                        $ins->paid_amount = '0';
                        $ins->wallet_txid = $dep_id;
                        $ins->ip_address = $ip;
                        $ins->verify = '1';
                        if ($ins->save()) {
                            $this->deposit_mail($user->id, $balance, $transid, $currency);
                        }
                    }
                }
            } else if ($status < 0) {
                //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
            } else {
                //payment is pending, you can optionally add a note to the order page
            }
        } catch (\Exception $exception) {
            \Log::error(['IPN_error', $exception->getFile(), $exception->getLine(), $exception->getMessage()]);
            return view('errors.404');
        }
    }


    function check_pending_orders($userid, $currency)
    {
        try {
            $pending_order = ICOTrade::where('user_id', $userid)->
            where('Status', 'Pending')->where('SecondCurrency', $currency)->first();

            if ($pending_order) {
                $get_user_bal = get_userbalance($userid, $currency);
                $pending_bal = $pending_order->Amount;
                $icotoken = $pending_order->firstAmount;

                if ($get_user_bal >= $pending_bal) {
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

                    //transaction update
                    $icotoken_bonus_trimmed = number_format($icotoken_bonus, 2, '.', '');
                    $pending_order->Discount = $icotoken_bonus_trimmed;
                    $pending_order->Total = $total_icotoken;
                    $pending_order->Status = 'Completed';
                    $pending_order->save();

                    $updated_secondcurrency_bal = $get_user_bal - $pending_bal;
                    $updated_first_currency_bal = $total_icotoken;
                    //profit
                    if ($icotoken_bonus > 0) {
                        $lobjUserBal = UserBalance::where('user_id', $userid)->first();
                        $lobjUserBal->$currency = $updated_secondcurrency_bal;
                        $lobjUserBal->GIFT = $updated_first_currency_bal;
                        $lobjUserBal->save();

                        //bonus status
                        if ($icotoken_bonus > 0) {
                            $bonus_status = new ICO_bonus_stats();

                            $bonus_status->user_id = $userid;
                            $bonus_status->bonusLeveL = $bonus_level_id;
                            $bonus_status->ico_id = $pending_order->id;
                            $bonus_status->ico_purchased = $icotoken;
                            $bonus_status->ico_profit = $icotoken_bonus_trimmed;
                            $bonus_status->save();

                        }

                        $bonus_level = ico_bonus::where('status', 1)->first();
                        $bonus_level->cap_level = $bonus_level->cap_level + $icotoken;
                        $max = $bonus_level->maximum_range;
                        $bonus_id = $bonus_level->id;
                        $bonus_level_status = $bonus_level->status;
                        if (($bonus_level->cap_level + $icotoken) > $max) {
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
                    }

                }
            }

        } catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function eth_deposit_process_user($id)
    {
        try{
            $verifyBal = verifyEther($id);
            $jsonresult = [];
            if ($verifyBal != '' && $verifyBal > 0) {
                $userslist[] = Users::orderBy('id', 'asc')->where('ETH_addr', $id)->first();

                if ($userslist) {
                    foreach ($userslist as $userval) {
                        $userid = $userval->id;
                        $ethaddress = $userval->ETH_addr;
                        $blocknum = Transaction::max('blocknumber');

                        if ($blocknum == "") {
                            $blocknum = "3500000";
                        }
                        $blocknum = "4500000";
                        if ($ethaddress != "") {

                            $eurl = 'https://api.etherscan.io/api?module=account&action=txlist&address=' . $ethaddress . '&startblock=' . $blocknum . '&endblock=latest';

                            $cObj = curl_init();
                            curl_setopt($cObj, CURLOPT_URL, $eurl);
                            curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
                            $output = curl_exec($cObj);
                            $curlinfos = curl_getinfo($cObj);

                            $result = json_decode($output);

                            if ($result->message == 'OK') {
                                $transaction = $result->result;
                                for ($tr = 0; $tr < count($transaction); $tr++) {

                                    $block_number = $transaction[$tr]->blockNumber;
                                    $address = $transaction[$tr]->to;
                                    $txid = $transaction[$tr]->hash;
                                    $value = $transaction[$tr]->value;

                                    $dep_id = $txid;
                                    $eth_balance = $value;
                                    $ether_balance = ($eth_balance / 1000000000000000000);

                                    $dep_already = $this->eth_checkdepositalready($userid, $dep_id);
                                    if ($dep_already === TRUE && (float)$ether_balance > 0) {
                                        if ($ethaddress == $address) {

                                            $ether_balance = sprintf('%.10f', $ether_balance);

                                            $fetchbalance = get_userbalance($userid, 'ETH');
                                            $finalbalance = $fetchbalance + $ether_balance;

                                            $adminethaddr = decrypt(get_config('eth_address'));
                                            $transid = 'TXD' . $userid . time();
                                            $hash = eth_transfer_fun($ethaddress, $ether_balance, $adminethaddr, $userid);

                                            if ($hash != '' && $hash != 'Error') {
                                                //wallet record generation
                                                $instr = new Wallettrans;
                                                $instr->adtras_id = $transid;
                                                $instr->currency = 'ETH';
                                                $instr->address = $ethaddress;
                                                $instr->hash = $hash;
                                                $instr->amount = $ether_balance;
                                                $instr->save();

                                                //update userbalance
                                                $upt = Balance::where('user_id', $userid)->first();
                                                $upt->ETH = $finalbalance;
                                                $upt->save();

                                                //generate transcation record
                                                $today = date('Y-m-d H:i:s');
                                                $ip = \Request::ip();
                                                $ins = new Transaction;
                                                $ins->user_id = $userid;
                                                $ins->payment_method = 'Cryptocurrency Account';
                                                $ins->transaction_id = $transid;
                                                $ins->currency_name = 'ETH';
                                                $ins->type = 'Deposit';
                                                $ins->transaction_type = '1';
                                                $ins->amount = $ether_balance;
                                                $ins->updated_at = $today;
                                                $ins->crypto_address = $address;
                                                $ins->transfer_amount = '0';
                                                $ins->fee = '0';
                                                $ins->tax = '0';
                                                $ins->verifycode = '1';
                                                $ins->order_id = '0';
                                                $ins->status = 'Completed';
                                                $ins->cointype = '2';
                                                $ins->payment_status = 'Paid';
                                                $ins->paid_amount = '0';
                                                $ins->wallet_txid = $dep_id;
                                                $ins->ip_address = $ip;
                                                $ins->verify = '1';
                                                $ins->blocknumber = $block_number;

                                                //sent mail to enduser
                                                if ($ins->save()) {
                                                    $this->deposit_mail($userid, $ether_balance, $transid, 'ETH');
                                                }
                                                $jsonresult[$tr] = array('status' => 'Ok', 'message' => 'Transfer Completed', 'Block_number' => $block_number, 'TransactionId' => $txid, 'Value' => $value);

                                            } //if block of ether block transaction
                                            elseif ($hash == 'Error') {
                                                $jsonresult[$tr] = array('Status' => 'Error');
                                            }

                                        }
                                    }
                                }

                            } //for internal transactions
                            else {
                                $eurl = 'https://api.etherscan.io/api?module=account&action=txlistinternal&address=' . $ethaddress . '&startblock=' . $blocknum . '&endblock=latest';

                                $cObj = curl_init();
                                curl_setopt($cObj, CURLOPT_URL, $eurl);
                                curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
                                curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
                                curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
                                $output = curl_exec($cObj);
                                $curlinfos = curl_getinfo($cObj);

                                $result = json_decode($output);

                                if ($result->message == 'OK') {
                                    $transaction = $result->result;
                                    for ($tr = 0; $tr < count($transaction); $tr++) {

                                        $block_number = $transaction[$tr]->blockNumber;
                                        $address = $transaction[$tr]->to;
                                        $txid = $transaction[$tr]->hash;
                                        $value = $transaction[$tr]->value;

                                        $dep_id = $txid;
                                        $eth_balance = $value;
                                        $ether_balance = ($eth_balance / 1000000000000000000);

                                        $dep_already = $this->eth_checkdepositalready($userid, $dep_id);
                                        if ($dep_already === TRUE && (float)$ether_balance > 0) {
                                            if ($ethaddress == $address) {

                                                $ether_balance = sprintf('%.10f', $ether_balance);

                                                $fetchbalance = get_userbalance($userid, 'ETH');
                                                $finalbalance = $fetchbalance + $ether_balance;

                                                $adminethaddr = decrypt(get_config('eth_address'));
                                                $transid = 'TXD' . $userid . time();
                                                $hash = eth_transfer_fun($ethaddress, $ether_balance, $adminethaddr, $userid);

                                                if ($hash != '' && $hash != 'Error') {
                                                    //wallet record generation
                                                    $instr = new Wallettrans;
                                                    $instr->adtras_id = $transid;
                                                    $instr->currency = 'ETH';
                                                    $instr->address = $ethaddress;
                                                    $instr->hash = $hash;
                                                    $instr->amount = $ether_balance;
                                                    $instr->save();

                                                    //update userbalance
                                                    $upt = Balance::where('user_id', $userid)->first();
                                                    $upt->ETH = $finalbalance;
                                                    $upt->save();

                                                    //generate transcation record
                                                    $today = date('Y-m-d H:i:s');
                                                    $ip = \Request::ip();
                                                    $ins = new Transaction;
                                                    $ins->user_id = $userid;
                                                    $ins->payment_method = 'Cryptocurrency Account';
                                                    $ins->transaction_id = $transid;
                                                    $ins->currency_name = 'ETH';
                                                    $ins->type = 'Deposit';
                                                    $ins->transaction_type = '1';
                                                    $ins->amount = $ether_balance;
                                                    $ins->updated_at = $today;
                                                    $ins->crypto_address = $address;
                                                    $ins->transfer_amount = '0';
                                                    $ins->fee = '0';
                                                    $ins->tax = '0';
                                                    $ins->verifycode = '1';
                                                    $ins->order_id = '0';
                                                    $ins->status = 'Completed';
                                                    $ins->cointype = '2';
                                                    $ins->payment_status = 'Paid';
                                                    $ins->paid_amount = '0';
                                                    $ins->wallet_txid = $dep_id;
                                                    $ins->ip_address = $ip;
                                                    $ins->verify = '1';
                                                    $ins->blocknumber = $block_number;

                                                    //sent mail to enduser
                                                    if ($ins->save()) {
                                                        $this->deposit_mail($userid, $ether_balance, $transid, 'ETH');
                                                    }
                                                    $jsonresult[$tr] = array('status' => 'Ok', 'message' => 'Transfer Completed', 'Block_number' => $block_number, 'TransactionId' => $txid, 'Value' => $value);

                                                } //if block of ether block transaction
                                                elseif ($hash == 'Error') {
                                                    $jsonresult[$tr] = array('Status' => 'Error');
                                                }

                                            }
                                        }
                                    }

                                }
                            }

                        }

                    }
                }

                return $jsonresult;

            } //verify balance if block
            else {
                $jsonresult[] = array('status' => 'Failed', 'message' => 'Insuffficient Balnce');
                return json_encode($jsonresult);
            } //verify blance else block
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }

    //eth deposit console
    function eth_deposit_console_user(Request $request)
    {
        try{
            $hash = $request['hash'];
            $id = $request['id'];
            $amount = $request['amount'];
            $fetchbalance = get_userbalance($id, 'ETH');
            $finalbalance = $fetchbalance + $amount;
            $transid = 'TXD' . $id . time();
            $block_number = $request['block'];
            $dep_id = $request['txid'];
            $userslist = Users::orderBy('id', 'asc')->where('id', $id)->first();

            if ($hash != '' && $hash != 'Error') {
                //wallet record generation
                $instr = new Wallettrans;
                $instr->adtras_id = $transid;
                $instr->currency = 'ETH';
                $instr->address = $userslist->ETH_addr;
                $instr->hash = $hash;
                $instr->amount = $amount;
                $instr->save();

                //update userbalance
                $upt = Balance::where('user_id', $id)->first();
                $upt->ETH = $finalbalance;
                $upt->save();

                //generate transcation record
                $today = date('Y-m-d H:i:s');
                $ip = \Request::ip();
                $ins = new Transaction;
                $ins->user_id = $id;
                $ins->payment_method = 'Cryptocurrency Account';
                $ins->transaction_id = $transid;
                $ins->currency_name = 'ETH';
                $ins->type = 'Deposit';
                $ins->transaction_type = '1';
                $ins->amount = $amount;
                $ins->updated_at = $today;
                $ins->crypto_address = $userslist->ETH_addr;
                $ins->transfer_amount = '0';
                $ins->fee = '0';
                $ins->tax = '0';
                $ins->verifycode = '1';
                $ins->order_id = '0';
                $ins->status = 'Completed';
                $ins->cointype = '2';
                $ins->payment_status = 'Paid';
                $ins->paid_amount = '0';
                $ins->wallet_txid = $dep_id;
                $ins->ip_address = $ip;
                $ins->verify = '1';
                $ins->blocknumber = $block_number;

                //sent mail to enduser
                if ($ins->save()) {
                    $this->deposit_mail($id, $amount, $transid, 'ETH');
                }
                $jsonresult = array('status' => 'Ok', 'message' => 'Transfer Completed', 'Block_number' => $block_number, 'TransactionId' => $txid, 'Value' => $value);
                return json_encode($jsonresult);
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }

    }

    function eth_checkdepositalready($user_id, $txd_id)
    {
        try{
            $check = Transaction::where('type', 'Deposit')->where('wallet_txid', $txd_id)->count();
            if ($check > 0) {
                return false;
            } else {
                return true;
            }
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function deposit_mail($userid, $amount, $txid, $currency)
    {
        try{
            $to = get_usermail($userid);
            $username = get_user_details($userid, 'enjoyer_name');
            $subject = get_template('6', 'subject');
            $message = get_template('6', 'template');
            $mailarr = array(
                '###USERNAME###' => $username,
                '###CURRENCY###' => $currency,
                '###AMOUNT###' => $amount,
                '###TXD###' => $txid,
                '###STATUS###' => 'Completed',
                '###SITENAME###' => get_config('site_name'),
            );
            $message = strtr($message, $mailarr);
            $subject = strtr($subject, $mailarr);
            sendmail($to, $subject, ['content' => $message]);
            return true;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //for latest mined node difference
    function last_mined_block_difference()
    {
        try {
            $get_currency_list = Node::all();
            if ($get_currency_list) {
                foreach ($get_currency_list as $currency) {
                    $name = $currency->currency_name;
                    $ip = ($currency->ip_address);
                    $port = ($currency->port_no);

                    $get_last_block = get_last_block($ip, $port);

                    $get_live_block = get_recent_block();

                    if ($get_live_block > $get_last_block) {
                        $diff = $get_live_block - $get_last_block;
                        if ($diff > 100) {
                            sendBlocklagMail($name, $diff);
                            $currency->save();

                        }
                    }

                }

            }

        } catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    function deposit_admin_mail($messageid, $amount, $txid, $currency)
    {
        try{
            $to = 'support@gravitas.io';
            $subject = get_template($messageid, 'subject');
            $message = get_template($messageid, 'template');
            $mailarr = array(
                '###CURRENCY###' => $currency,
                '###AMOUNT###' => $amount,
                '###TXD###' => $txid,
                '###STATUS###' => 'Completed',
                '###SITENAME###' => get_config('site_name'),
            );
            $message = strtr($message, $mailarr);
            $subject = strtr($subject, $mailarr);
            sendmail($to, $subject, ['content' => $message]);
            return true;
        }catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //btc deposit
    function btc_deposit_process()
    {
        try {
            $date = date('Y-m-d');
            $time = date('h:i:s');
            $bitcoin = get_btc_transactionlist();
            $bitcoin_isvalid = $bitcoin->listtransactions();

            if ($bitcoin_isvalid) {
                for ($i = 0; $i < count($bitcoin_isvalid); $i++) {
                    //    $account = $bitcoin_isvalid[$i]['account'];
                    $address = $bitcoin_isvalid[$i]['address'];
                    $category = $bitcoin_isvalid[$i]['category'];
                    $btctxid = $bitcoin_isvalid[$i]['txid'];
                    if ($category == 'receive') {
                        $isvalid = $bitcoin->gettransaction($btctxid);
                        $det_category = $isvalid['details'][0]['category'];
                        if ($det_category == "receive") {
                            //    $btcaccount = $isvalid['details'][0]['account'];
                            $btcaddress = $isvalid['details'][0]['address'];
                            $bitcoin_balance = $isvalid['details'][0]['amount'];
                            $btcconfirmations = $isvalid['confirmations'];
                        } else {
                            //    $btcaccount = $isvalid['details'][1]['account'];
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
                                        $pusher = new Pusher('65e7479879516d8836d9', '094793a9686a8b09bb74', '507349', array('cluster' => 'ap2'));

                                        $pusher->trigger('private-transaction_' . $userid, 'deposit-event', array('User_id' => $userid, 'Transaction_id' => $transid, 'Currency' => 'BTC', 'Amount' => $bitcoin_balance, 'Status' => 'Completed', 'Time' => $today));

                                    }
                                }
                            }

                        }
                    }
                }
            }
        } catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            
        }
    }

    //usdt deposit
    function usdt_deposit_process()
    {
        try {
            $date = date('Y-m-d');
            $time = date('h:i:s');
            $bitcoin_isvalid = get_usdt_transactionlist();

            if ($bitcoin_isvalid) {
                for ($i = 0; $i < count($bitcoin_isvalid); $i++) {
                    $propertyid = $bitcoin_isvalid[$i]['propertyid'];
                    $mine_flag = $bitcoin_isvalid[$i]['ismine'];

                    if ($propertyid == 31 && $mine_flag == true) {
                        $isvalid = $bitcoin_isvalid[$i]['txid'];
                        $checktrans = Transaction::where('type', 'Deposit')->where('wallet_txid', $isvalid)->first();
                        $reference_address = $bitcoin_isvalid[$i]['referenceaddress'];
                        $user_check = get_userid_usdtaddr($reference_address);
                        if ($user_check != 'no' && count($checktrans) == 0) {
                            $userid = $user_check;
                            $btcconfirmations = $bitcoin_isvalid[$i]['confirmations'];
                            $sendaddress = $bitcoin_isvalid[$i]['sendingaddress'];
                            $tx_valid = $bitcoin_isvalid[$i]['valid'];

                            if ($btcconfirmations >= 3 && $tx_valid == true) {
                                if (is_numeric($userid)) {
                                    $usdt_balance = $bitcoin_isvalid[$i]['amount'];
                                    $fee = $bitcoin_isvalid[$i]['fee'];
                                    $blocknumber = $bitcoin_isvalid[$i]['block'];
                                    $fetchbalance = get_userbalance($userid, 'USDT');
                                    $finalbalance = $fetchbalance + $usdt_balance;
                                    //    $upt = Balance::where('user_id', $userid)->first();
                                    //    $upt->BTC = $finalbalance;
                                    $upt = Balance::where('user_id', $userid)->first();
                                    $upt->USDT = $finalbalance;
                                    $upt->save();

                                    $transid = 'TXD' . $userid . time();
                                    $today = date('Y-m-d H:i:s');
                                    $ip = \Request::ip();
                                    $ins = new Transaction;
                                    $ins->user_id = $userid;
                                    $ins->payment_method = 'Cryptocurrency Account';
                                    $ins->transaction_id = $transid;
                                    $ins->currency_name = 'USDT';
                                    $ins->type = 'Deposit';
                                    $ins->transaction_type = '1';
                                    $ins->amount = $usdt_balance;
                                    $ins->updated_at = $today;
                                    $ins->crypto_address = $sendaddress;
                                    $ins->transfer_amount = '0';
                                    $ins->fee = $fee;
                                    $ins->tax = '0';
                                    $ins->verifycode = '1';
                                    $ins->order_id = '0';
                                    $ins->status = 'Completed';
                                    $ins->cointype = '2';
                                    $ins->payment_status = 'Paid';
                                    $ins->paid_amount = '0';
                                    $ins->wallet_txid = $isvalid;
                                    $ins->ip_address = $ip;
                                    $ins->verify = '1';
                                    $ins->blocknumber = $blocknumber;
                                    if ($ins->save()) {
                                        $this->deposit_mail($userid, $usdt_balance, $transid, 'USDT');
                                        $pusher = new Pusher('65e7479879516d8836d9', '094793a9686a8b09bb74', '507349', array('cluster' => 'ap2'));

                                        $pusher->trigger('private-transaction_' . $userid, 'deposit-event', array('User_id' => $userid, 'Transaction_id' => $transid, 'Currency' => 'USDT', 'Amount' => $usdt_balance, 'Status' => 'Completed', 'Time' => $today));

                                    }

                                    $adminusdtaddr = decrypt(get_config('usdt_address'));
                                    usdt_transfer($reference_address, $adminusdtaddr);

                                }

                            }
                        }

                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
            return view('errors.404');
        }
    }

    //bch deposit
    function bch_deposit_process()
    {
        try{
            $date = date('Y-m-d');
            $time = date('h:i:s');
            $bitcoin = get_bch_transactionlist();
            $bitcoin_isvalid = $bitcoin->listtransactions();

            if ($bitcoin_isvalid) {
                for ($i = 0; $i < count($bitcoin_isvalid); $i++) {
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
                            $userid = get_userid_bchaddr($btcaddress);
                            if (is_numeric($userid)) {
                                $checktrans = Transaction::where('type', 'Deposit')->where('wallet_txid', $btctxid)->first();
                                if (count($checktrans) == 0) {
                                    $fetchbalance = get_userbalance($userid, 'BCH');
                                    $finalbalance = $fetchbalance + $bitcoin_balance;
                                    $upt = Balance::where('user_id', $userid)->first();
                                    $upt->BCH = $finalbalance;
                                    $upt->save();

                                    $transid = 'TXD' . $userid . time();
                                    $today = date('Y-m-d H:i:s');
                                    $ip = \Request::ip();
                                    $ins = new Transaction;
                                    $ins->user_id = $userid;
                                    $ins->payment_method = 'Cryptocurrency Account';
                                    $ins->transaction_id = $transid;
                                    $ins->currency_name = 'BCH';
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
                                        $this->deposit_mail($userid, $bitcoin_balance, $transid, 'BCH');
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
        }
    }


    function xrp_deposit_process()
    {
        try{
            $ripple_address = decrypt(get_config('xrp_address'));
            $max_ledgerversion = Transaction::max('ledgerversion');
            if ($max_ledgerversion == "" || $max_ledgerversion == '0') {
                $max_ledgerversion = "3776014";
            }
            $output = array();
            $return_var = -1;
            $result = exec('cd /var/www/html/public/crypto; node ripple_transaction.js ' . trim($max_ledgerversion), $output, $return_var);
            $result = json_decode($result);
            if ($result) {
                foreach ($result as $res) {
                    $txid = $res->id;
                    $checktrans = Transaction::where('type', 'Deposit')->where('wallet_txid', $txid)->where('currency_name', 'XRP')->first();
                    if (count($checktrans) == 0) {
                        $address = $res->specification->destination->address;
                        $amount = $res->specification->destination->amount->value;
                        $ledgerversion = $res->outcome->ledgerVersion;
                        try {
                            $tag = $res->specification->destination->tag;
                        } catch (\Exception $exception) {
                            $tag = "";
                            $transid = 'TXD' . 00 . time();
                            $today = date('Y-m-d H:i:s');
                            $ip = \Request::ip();
                            $ins = new Transaction;
                            $ins->user_id = "";
                            $ins->payment_method = 'Cryptocurrency Account';
                            $ins->transaction_id = $transid;
                            $ins->currency_name = 'XRP';
                            $ins->type = 'Deposit_without_tag';
                            $ins->transaction_type = '1';
                            $ins->amount = $amount;
                            $ins->updated_at = $today;
                            $ins->crypto_address = $address;
                            $ins->transfer_amount = '0';
                            $ins->fee = '0';
                            $ins->tax = '0';
                            $ins->verifycode = '1';
                            $ins->order_id = '0';
                            $ins->status = 'Admin';
                            $ins->cointype = '2';
                            $ins->payment_status = 'Paid';
                            $ins->paid_amount = '0';
                            $ins->wallet_txid = $txid;
                            $ins->ip_address = $ip;
                            $ins->verify = '1';
                            $ins->blocknumber = '0';
                            $ins->xrp_desttag = $tag;
                            $ins->ledgerversion = $ledgerversion;
                            if ($ins->save()) {
                                $this->deposit_admin_mail('10', $amount, $txid, 'XRP');
                            }


                        }


                        if ($address == $ripple_address) {
                            if ($tag != "") {
                                $userdetails = get_dest_userid($tag);
                                if ($userdetails) {
                                    $userid = $userdetails;

                                    $fetchbalance = get_userbalance($userid, 'XRP');
                                    $finalbalance = $fetchbalance + $amount;
                                    $upt = Balance::where('user_id', $userid)->first();
                                    $upt->XRP = $finalbalance;
                                    $upt->save();

                                    $transid = 'TXD' . $userid . time();
                                    $today = date('Y-m-d H:i:s');
                                    $ip = \Request::ip();
                                    $ins = new Transaction;
                                    $ins->user_id = $userid;
                                    $ins->payment_method = 'Cryptocurrency Account';
                                    $ins->transaction_id = $transid;
                                    $ins->currency_name = 'XRP';
                                    $ins->type = 'Deposit';
                                    $ins->transaction_type = '1';
                                    $ins->amount = $amount;
                                    $ins->updated_at = $today;
                                    $ins->crypto_address = $address;
                                    $ins->transfer_amount = '0';
                                    $ins->fee = '0';
                                    $ins->tax = '0';
                                    $ins->verifycode = '1';
                                    $ins->order_id = '0';
                                    $ins->status = 'Completed';
                                    $ins->cointype = '2';
                                    $ins->payment_status = 'Paid';
                                    $ins->paid_amount = '0';
                                    $ins->wallet_txid = $txid;
                                    $ins->ip_address = $ip;
                                    $ins->verify = '1';
                                    $ins->blocknumber = '0';
                                    $ins->xrp_desttag = $tag;
                                    $ins->ledgerversion = $ledgerversion;
                                    if ($ins->save()) {
                                        $this->deposit_mail($userid, $amount, $transid, 'XRP');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
            
        }
    }

    //opening balance
    function opening_balance()
    {
        try{
            $userslist = UserBalance::orderBy('user_id', 'asc')
                ->get();

            foreach ($userslist as $user) {
                $i = 0;
                $User_id = $user->user_id;
                $XDC = $user->XDC;
                $XDCE = $user->XDCE;
                $BTC = $user->BTC;
                $ETH = $user->ETH;
                $XRP = $user->XRP;

                $opening_bal = new OpeningBalance();
                $opening_bal->user_id = $User_id;
                $opening_bal->XDC = $XDC;
                $opening_bal->BTC = $BTC;
                $opening_bal->XDCE = $XDCE;
                $opening_bal->ETH = $ETH;
                $opening_bal->XRP = $XRP;
                $opening_bal->save();
            }
        }catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
            
        }

    }

    //closing Balance
    function closing_balance()
    {
        try{
            $userslist = UserBalance::orderBy('user_id', 'asc')
                ->get();

            foreach ($userslist as $user) {
                $i = 0;
                $User_id = $user->user_id;
                $XDC = $user->XDC;
                $XDCE = $user->XDCE;
                $BTC = $user->BTC;
                $ETH = $user->ETH;
                $XRP = $user->XRP;

                $closing_bal = new ClosingBalance();
                $closing_bal->user_id = $User_id;
                $closing_bal->XDC = $XDC;
                $closing_bal->BTC = $BTC;
                $closing_bal->XDCE = $XDCE;
                $closing_bal->ETH = $ETH;
                $closing_bal->XRP = $XRP;
                $closing_bal->save();
            }
        }catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
            
        }

    }


    //xdc deposit
    function xdc_deposit_process()
    {
        try {
            $admin = SiteSettings::where('id', 1)->first();
            $last_block = $admin->xdc_block;
            $last_block = $last_block + 1;
            $latest_xdc_block_number = get_last_block('18.188.115.125', 22001);

            if ($latest_xdc_block_number > 0) {
                for ($i = $last_block; $i <= $latest_xdc_block_number; $i++) {


                    $block_number = $i;

                    $eurl = 'http://xinfin.info/api/blocknumber/' . $block_number . '_0_0';

                    $cObj = curl_init();
                    curl_setopt($cObj, CURLOPT_URL, $eurl);
                    curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
                    $output = curl_exec($cObj);
                    $curlinfos = curl_getinfo($cObj);

                    $result = json_decode($output);

                    if ($result && $result->status == 'SUCCESS') {
                        $transactionList = $result->message;

                    } else {
                        $transactionList = '';
                    }

                    //iterating transaction lists
                    foreach ($transactionList as $transaction) {
                        $to_address = $transaction->args->_to;
                        $user = Users::where('XDC_addr', '=', $to_address)->first();
                        if ($user != null && $to_address != null) {
                            $dep_id = $transaction->transactionHash;
                            $ether_balance = $transaction->args->_value;
                            $dep_already = $this->eth_checkdepositalready($user->id, $dep_id);
                            if ($dep_already === TRUE && (float)$ether_balance > 0) {


                                $email = get_usermail($user->id);
                                //$pass = Session::get('xinfinpass');
                                $pass = get_user_details($user->id, 'xinpass');
                                login_xdc_fun($email, owndecrypt($pass));


                                $adminethaddr = decrypt(get_config('xdc_address'));
                                $res = transfer_xdctoken($to_address, $ether_balance, $adminethaddr, $user->id, owndecrypt($pass));
                                $userid = $user->id;
                                if ($res->status == 'SUCCESS') {
                                    $fetchbalance = get_userbalance($userid, 'XDC');
                                    $uptbal = $fetchbalance + $ether_balance;
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
                                    $ins->amount = $ether_balance;
                                    $ins->updated_at = $today;
                                    $ins->crypto_address = $to_address;
                                    $ins->transfer_amount = '0';
                                    $ins->fee = '0';
                                    $ins->tax = '0';
                                    $ins->verifycode = '1';
                                    $ins->order_id = '0';
                                    $ins->status = 'Completed';
                                    $ins->cointype = '2';
                                    $ins->payment_status = 'Paid';
                                    $ins->paid_amount = '0';
                                    $ins->wallet_txid = $dep_id;
                                    $ins->ip_address = $ip;
                                    $ins->verify = '1';
                                    $ins->blocknumber = $transaction->blockNumber;
                                    $ins->save();
                                }
                            }
                        }


                    }
                    if ($last_block < $i) {
                        $admin->xdc_block = $i;
                        $admin->save();
                    }

                }
            }

        } catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
            return view('errors.404');
        }
    }

    //xdce deposit block wise
    function xdce_deposit_process1()
    {
        try {
            $admin = SiteSettings::where('id', 1)->first();
            $last_block = $admin->xdce_block;
            $last_block = $last_block + 1;
            $latest_xdc_block_number = get_last_block('78.129.229.18', 8545);

            if ($latest_xdc_block_number > 0) {
                for ($i = $last_block; $i <= $latest_xdc_block_number; $i++) {


                    $block_number = $i;

                    $eurl = 'http://xinfin.info/api/blocknumber/' . $block_number . '_0_0';

                    $cObj = curl_init();
                    curl_setopt($cObj, CURLOPT_URL, $eurl);
                    curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
                    $output = curl_exec($cObj);
                    $curlinfos = curl_getinfo($cObj);

                    $result = json_decode($output);

                    if ($result && $result->status == 'SUCCESS') {
                        $transactionList = $result->message;

                    } else {
                        $transactionList = '';
                    }

                    //iterating transaction lists
                    foreach ($transactionList as $transaction) {
                        $to_address = $transaction->args->_to;
                        $user = Users::where('XDC_addr', '=', $to_address)->first();
                        if ($user != null && $to_address != null) {
                            $dep_id = $transaction->transactionHash;
                            $ether_balance = $transaction->args->_value;
                            $dep_already = $this->eth_checkdepositalready($user->id, $dep_id);
                            if ($dep_already === TRUE && (float)$ether_balance > 0) {


                                $email = get_usermail($user->id);
                                //$pass = Session::get('xinfinpass');
                                $pass = get_user_details($user->id, 'xinpass');
                                login_xdc_fun($email, owndecrypt($pass));


                                $adminethaddr = decrypt(get_config('xdc_address'));
                                $res = transfer_xdctoken($to_address, $ether_balance, $adminethaddr, $user->id, owndecrypt($pass));
                                $userid = $user->id;
                                if ($res->status == 'SUCCESS') {
                                    $fetchbalance = get_userbalance($userid, 'XDC');
                                    $uptbal = $fetchbalance + $ether_balance;
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
                                    $ins->amount = $ether_balance;
                                    $ins->updated_at = $today;
                                    $ins->crypto_address = $to_address;
                                    $ins->transfer_amount = '0';
                                    $ins->fee = '0';
                                    $ins->tax = '0';
                                    $ins->verifycode = '1';
                                    $ins->order_id = '0';
                                    $ins->status = 'Completed';
                                    $ins->cointype = '2';
                                    $ins->payment_status = 'Paid';
                                    $ins->paid_amount = '0';
                                    $ins->wallet_txid = $dep_id;
                                    $ins->ip_address = $ip;
                                    $ins->verify = '1';
                                    $ins->blocknumber = $transaction->blockNumber;
                                    $ins->save();
                                }
                            }
                        }


                    }
                    if ($last_block < $i) {
                        $admin->mined_block = $i;
                        $admin->save();
                    }
                }
            }

        } catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
            return view('errors.404');
        }
    }


    //end class
    function xdce_deposit_process()
    {
        try{
            $userslist = Users::orderBy('id', 'asc')->get();

            foreach ($userslist as $user) {
                $id = $user->id;
                $xdceaddr = $user->XDCE_addr;
                if ($xdceaddr == '') {
                    $xdcebal = 0;
                } else {
                    $xdcebal = get_livexdce_bal($xdceaddr);
                }
                $xdce_blocknum = 0;

                if ($xdcebal > 1) {
                    $xdceTransactionList = get_xdce_transactions($xdceaddr, $xdce_blocknum);

                    try {
                        if ($xdceTransactionList->status == 'SUCCESS') {
                            $transaction = $xdceTransactionList->message;
                            for ($tr = 0; $tr < count($transaction); $tr++) {

                                $block_number = $transaction[$tr]->blockNumber;
                                $address = $transaction[$tr]->args->_to;
                                $txid = $transaction[$tr]->transactionHash;
                                $value = $transaction[$tr]->args->_value;

                                $dep_id = $txid;
                                $eth_balance = (float)$value;
                                $ether_balance = $eth_balance / 1000000000000000000;

                                $dep_already = xdce_checkdepositalready($id, $dep_id);
                                if ($dep_already === TRUE && (float)$ether_balance > 1) {
                                    if ($xdceaddr == $address) {

                                        $ether_balance = sprintf('%.10f', $ether_balance);

                                        //deposit transaction
                                        $transid = 'TXD' . $id . time();
                                        $today = date('Y-m-d H:i:s');
                                        $ip = \Request::ip();
                                        $ins = new Transaction;
                                        $ins->user_id = $id;
                                        $ins->payment_method = 'Cryptocurrency Account';
                                        $ins->transaction_id = $transid;
                                        $ins->currency_name = 'XDCE';
                                        $ins->type = 'Deposit';
                                        $ins->transaction_type = '1';
                                        $ins->amount = $ether_balance;
                                        $ins->updated_at = $today;
                                        $ins->crypto_address = $xdceaddr;
                                        $ins->transfer_amount = '0';
                                        $ins->fee = '0';
                                        $ins->tax = '0';
                                        $ins->verifycode = '1';
                                        $ins->order_id = '0';
                                        $ins->status = 'Completed';
                                        $ins->cointype = '2';
                                        $ins->payment_status = 'Paid';
                                        $ins->paid_amount = '0';
                                        $ins->wallet_txid = $dep_id;
                                        $ins->ip_address = $ip;
                                        $ins->verify = '1';
                                        $ins->blocknumber = '';
                                        if ($ins->save()) {
                                            //update user
                                            $fetchbalance = get_userbalance($id, 'XDCE');
                                            $finalbalance = $fetchbalance + $ether_balance;
                                            $upt = Balance::where('user_id', $id)->first();
                                            $upt->XDCE = $finalbalance;
                                            $upt->save();
                                            deposit_mail($id, $ether_balance, $transid, 'XDCE');
                                        }
                                    }
                                }
                            }

                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }

            }
        }catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
            return view('errors.404');
        }

    }


    //for each user xdce deposit
    function xdce_deposit_process_user($id)
    {
        try{
                $userslist[] = Users::orderBy('id', 'asc')->where('XDCE_addr', $id)->first();
                foreach ($userslist as $user) {
                    $id = $user->id;
                    $xdceaddr = $user->XDCE_addr;
                    $xdcebal = get_livexdce_bal($xdceaddr);
                    $xdce_blocknum = 0;

                    if ($xdcebal > 1) {
                        $xdceTransactionList = get_xdce_transactions($xdceaddr, $xdce_blocknum);

                        try {
                            if ($xdceTransactionList->status == 'SUCCESS') {
                                $transaction = $xdceTransactionList->message;
                                for ($tr = 0; $tr < count($transaction); $tr++) {

                                    $block_number = $transaction[$tr]->blockNumber;
                                    $address = $transaction[$tr]->args->_to;
                                    $txid = $transaction[$tr]->transactionHash;
                                    $value = $transaction[$tr]->args->_value;

                                    $dep_id = $txid;
                                    $eth_balance = (float)$value;
                                    $ether_balance = $eth_balance / 1000000000000000000;

                                    $dep_already = xdce_checkdepositalready($id, $dep_id);
                                    if ($dep_already === TRUE && (float)$ether_balance > 1) {
                                        if ($xdceaddr == $address) {

                                            $ether_balance = sprintf('%.10f', $ether_balance);

                                            //deposit transaction
                                            $transid = 'TXD' . $id . time();
                                            $today = date('Y-m-d H:i:s');
                                            $ip = \Request::ip();
                                            $ins = new Transaction;
                                            $ins->user_id = $id;
                                            $ins->payment_method = 'Cryptocurrency Account';
                                            $ins->transaction_id = $transid;
                                            $ins->currency_name = 'XDCE';
                                            $ins->type = 'Deposit';
                                            $ins->transaction_type = '1';
                                            $ins->amount = $ether_balance;
                                            $ins->updated_at = $today;
                                            $ins->crypto_address = $xdceaddr;
                                            $ins->transfer_amount = '0';
                                            $ins->fee = '0';
                                            $ins->tax = '0';
                                            $ins->verifycode = '1';
                                            $ins->order_id = '0';
                                            $ins->status = 'Completed';
                                            $ins->cointype = '2';
                                            $ins->payment_status = 'Paid';
                                            $ins->paid_amount = '0';
                                            $ins->wallet_txid = $dep_id;
                                            $ins->ip_address = $ip;
                                            $ins->verify = '1';
                                            $ins->blocknumber = '';
                                            if ($ins->save()) {
                                                //update user
                                                $fetchbalance = get_userbalance($id, 'XDCE');
                                                $finalbalance = $fetchbalance + $ether_balance;
                                                $upt = Balance::where('user_id', $id)->first();
                                                $upt->XDCE = $finalbalance;
                                                $upt->save();
                                                deposit_mail($id, $ether_balance, $transid, 'XDCE');
                                                echo "Deposit of " . $ether_balance . " XDCE completed for user id " . $id . ".";
                                            } else {
                                                echo "Database entry not successful";
                                            }
                                        } else {
                                            echo "Address not matching";
                                        }
                                    } else {
                                        echo "Deposit already completed or Insufficient balance.";
                                    }
                                }

                            } else {
                                echo $xdceTransactionList->status;
                            }
                        } catch (\Exception $e) {
                            echo $e->getMessage();
                            continue;
                        }
                    } else {
                        echo "No pending XDCE deposit for user id " . $id . ".";
                    }

        //            if($)

                }
            }catch (\Exception $e) {
                \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
                return view('errors.404');
            }
    }

    //for updating duplicate_record
    function duplicate_record()
    {
        try{
        $lObjTrades = DB::select("SELECT *,
COUNT(1) as CNT
FROM		xdc_trade_order
GROUP BY	updated_at,Amount,Price,Type
HAVING		COUNT(1) > 1  
ORDER BY xdc_trade_order.id ASC");

        foreach ($lObjTrades as $lObjTrade) {

            $lObjDuplicateTrade = Trade::where('id', $lObjTrade->id)->first();
            $lObjDuplicateTrade->duplicate = 1;
            $lObjDuplicateTrade->save();
        }
    }catch (\Exception $e) {
        \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
        
    }

    }


    function btc_records()
    {
        try{
            $bitcoin = get_btc_transactionlist();
            $bitcoin_isvalid = $bitcoin->listtransactions();
            echo json_encode($bitcoin_isvalid);
        }catch (\Exception $e) {
            \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
        
        }
    }


}


