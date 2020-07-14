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
use App\model\Pair;
use App\model\Profit;
use App\model\Trade;
use App\model\Tradingfee;
use App\model\ICOTrade;
use App\model\Transaction;
use DB;
use Illuminate\Http\Request;
use Session;

class TradeController extends Controller {
	//
	public function __construct() {
		//cons;
		$ip = \Request::ip();
		blockip_list($ip);
	}

    function index($pair = "") {
		
			if (Session::get('alphauserid') == "") {
				return redirect('logout');
			} else {




				$userid = Session::get('alphauserid');
				if (get_user_details($userid, 'document_status') != '1')
				{
					// Session::flash('error','Please Complete your KYC process');
					// return redirect('profile');
				}
				$transid = 'TXD' . $userid . time();

				$xdcaddr = get_user_details($userid, 'XDC_addr');
				$xdceaddr = get_user_details($userid,'XDCE_addr');
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
						if ($res->status == 'SUCCESS')
						{
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
						}
					}catch (\Exception $e)
					{

					}

				}



				$pair = $pair ? $pair : 'XDC-ETH';

				$checkpair = Pair::where(['type' => 'trade', 'pair' => $pair])->count();
				if ($checkpair == 0) {
					abort(404);
				}


				$cur = explode("-", $pair);
				$first_currency = $cur[0];
				$second_currency = $cur[1];



				$first_cur_balance = get_userbalance($userid, $first_currency);
				$second_cur_balance = get_userbalance($userid, $second_currency);

				if($second_currency == 'XDCE')
				{
					$buy_rate = 1;
					$sell_rate = 1;
					$trading_fee = 0;

					$active_orders = Trade::where(['user_id' => $userid, 'pair' => $pair])->where(function ($query) {
						$query->where('status', 'completed');
					})->orderBy('id', 'desc')->get();

				}
				else
				{
					$buy_rate = get_buy_market_rate($first_currency, $second_currency);
					$sell_rate = get_sell_market_rate($first_currency, $second_currency);
					$volume = get_trading_volume($first_currency, $second_currency, $userid);
					$trading_fee = $this->get_trading_fee(round($volume), $second_currency);

					$active_orders = Trade::where(['user_id' => $userid, 'pair' => $pair])->where(function ($query) {
						$query->where('status', 'active')->Orwhere('status', 'partially');
					})->orderBy('id', 'desc')->get();
				}


				$buy_order_list = Trade::select(DB::raw('Price,SUM(Amount) as Amount'))->where(['pair' => $pair, 'Type' => 'Sell'])->where(function ($query) {
					$query->where('status', 'active')->Orwhere('status', 'partially');
				})->groupBy('Price')->orderBy('Price', 'asc')->limit(5)->get();

				/*$buy_order_list = DB::select(DB::raw("SELECT * FROM `XDC_trade_order` WHERE pair='$pair' AND Type='Sell' AND (status='active' or status='partially') ORDER BY id DESC"));*/

				$sell_order_list = Trade::select(DB::raw('Price,SUM(Amount) as Amount'))->where(['pair' => $pair, 'Type' => 'Buy'])->where(function ($query) {
					$query->where('status', 'active')->Orwhere('status', 'partially');
				})->groupBy('Price')->orderBy('Price', 'desc')->limit(5)->get();

				/*$sell_order_list = DB::select(DB::raw("SELECT * FROM `XDC_trade_order` WHERE pair='$pair' AND Type='Buy' AND (status='active' or status='partially') ORDER BY id DESC"));*/


				/*	$active_orders = DB::select(DB::raw("SELECT * FROM `XDC_trade_order` WHERE user_id='$userid' and pair='$pair' AND (status='active' or status='partially')"));*/

				$stop_orders = Trade::where(['pair' => $pair, 'user_id' => $userid, 'status' => 'stop'])->orderBy('id', 'desc')->get();
				$trade_history = Trade::where(['pair' => $pair, 'status' => 'completed', 'Type' => 'Buy'])->orderBy('updated_at', 'desc')->limit(5)->get();

				$data = ['pair' => $pair, 'first_currency' => $first_currency, 'second_currency' => $second_currency, 'first_cur_balance' => $first_cur_balance, 'second_cur_balance' => $second_cur_balance, 'buy_rate' => (float) $buy_rate, 'sell_rate' => (float) $sell_rate, 'trading_fee' => $trading_fee, 'buy_order_list' => $buy_order_list, 'sell_order_list' => $sell_order_list, 'active_orders' => $active_orders, 'stop_orders' => $stop_orders, 'trade_history' => $trade_history];

				return view('front.trade', $data);

	        //    return view('front.construction');
			}
		
    }

	function get_trading_fee($vol, $second_currency) {
		
			$result = Tradingfee::where('currency', $second_currency)->first();
			if ($result) {
				if ($vol < 20000) {
					return $result->lessthan_20000;
				} elseif ($vol < 100000) {
					return $result->lessthan_100000;
				} elseif ($vol < 200000) {
					return $result->lessthan_200000;
				} elseif ($vol < 400000) {
					return $result->lessthan_400000;
				} elseif ($vol < 600000) {
					return $result->lessthan_600000;
				} elseif ($vol < 1000000) {
					return $result->lessthan_1000000;
				} elseif ($vol < 2000000) {
					return $result->lessthan_2000000;
				} elseif ($vol < 4000000) {
					return $result->lessthan_4000000;
				} elseif ($vol < 20000000) {
					return $result->lessthan_20000000;
				} else {
					return $result->greaterthan_20000000;
				}

			}
		
	}

	function instant_order(Request $request) {
		try{
			if (Session::get('alphauserid') == "") {
				return redirect('logout');
			} else {
				$ip = \Request::ip();
				$userid = Session::get('alphauserid');
				if ($request->isMethod('post')) {
					$data = array();
					$pair = $request['pair'];
					$buy_rate = $request['buy_rate'];
					$sell_rate = $request['sell_rate'];
					$trade_fee = $request['trade_fee'];
					$type = $request['type'];
					$cur = explode("-", $pair);
					$first_currency = $cur[0];
					$second_currency = $cur[1];
					$first_cur_balance = get_userbalance($userid, $first_currency);
					$second_cur_balance = get_userbalance($userid, $second_currency);

					$volume = get_trading_volume($first_currency, $second_currency, $userid);
					$trade_fee = $this->get_trading_fee(round($volume), $second_currency);

					if ($type == 'Buy') {
						$buyamount = $request['buy_ins_' . $first_currency];
						/*$feeamount = $request['buy_fee_amount'];
						$priceamount = $request['buy_price_amount'];*/
						$bprice = $buyamount * $sell_rate;
						$feeamount = $bprice * ($trade_fee / 100);
						$priceamount = $bprice + $feeamount;
						if ($priceamount <= $second_cur_balance) {

							$ins = new Trade;
							$ins->user_id = $userid;
							$ins->ip = $ip;
							$ins->firstCurrency = $first_currency;
							$ins->secondCurrency = $second_currency;
							$ins->Amount = $buyamount;
							$ins->Price = $sell_rate;
							$ins->Type = $type;
							$ins->Process = '';
							$ins->Fee = $feeamount;
							$ins->Total = $priceamount;
							$ins->orderTime = date('H:i:s');
							$ins->datetime = date('Y-m-d');
							$ins->pair = $pair;
							$ins->status = 'active';
							$ins->fee_per = $trade_fee;
							if ($ins->save()) {
								$finalbalance = $second_cur_balance - $priceamount;
								$upt = Balance::where('user_id', $userid)->first();
								$upt->$second_currency = $finalbalance;
								$upt->save();
								last_activity(get_usermail($userid), 'Instant Buy order', $userid);
							}
							$last_orderid = $ins->id;

							$this->check_stop_orders($sell_rate, 'Buy');

							$this->trade_mapping($last_orderid, $type, $sell_rate, $pair);

							$data['status'] = '1';
							$data['message'] = 'Buy order placed';
							echo json_encode($data);die();

						} else {
							$data['status'] = '0';
							$data['message'] = 'Insufficient Balance of ' . $second_currency;
							echo json_encode($data);die();
						}
					} elseif ($type == 'Sell') {
						$sellamount = $request['sell_ins_' . $first_currency];
						/*$feeamount = $request['sell_fee_amount'];
						$priceamount = $request['sell_price_amount'];*/

						$sprice = $sellamount * $buy_rate;
						$feeamount = $sprice * ($trade_fee / 100);
						$priceamount = $sprice - $feeamount;

						if ($sellamount <= $first_cur_balance) {

							$ins = new Trade;
							$ins->user_id = $userid;
							$ins->ip = $ip;
							$ins->firstCurrency = $first_currency;
							$ins->secondCurrency = $second_currency;
							$ins->Amount = $sellamount;
							$ins->Price = $buy_rate;
							$ins->Type = $type;
							$ins->Process = '';
							$ins->Fee = $feeamount;
							$ins->Total = $priceamount;
							$ins->orderTime = date('H:i:s');
							$ins->datetime = date('Y-m-d');
							$ins->pair = $pair;
							$ins->status = 'active';
							$ins->fee_per = $trade_fee;
							if ($ins->save()) {
								$finalbalance = $first_cur_balance - $sellamount;
								$upt = Balance::where('user_id', $userid)->first();
								$upt->$first_currency = $finalbalance;
								$upt->save();
								last_activity(get_usermail($userid), 'Instant Buy order', $userid);
							}
							$last_orderid = $ins->id;

							$this->check_stop_orders($buy_rate, 'Sell');

							$this->trade_mapping($last_orderid, $type, $buy_rate, $pair);

							$data['status'] = '1';
							$data['message'] = 'Sell order placed';
							echo json_encode($data);die();

						} else {
							$data['status'] = '0';
							$data['message'] = 'Insufficient Balance of ' . $first_currency;
							echo json_encode($data);die();
						}
					}
				}
			}
		}catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
	}

	function trade_history(Request $request, $pair = "") {
		try{
			if (Session::get('alphauserid') == "") {
				return redirect('logout');
			} else {
				$userid = Session::get('alphauserid');
				$getpair = $request->get('pair');
				$getstatus = $request->get('status');
				if ($getpair == 'all' || $getpair == "") {
					$pair = ['XDC-ETH', 'XDC-BTC', 'XDC-XRP','XDC-BCH', 'XDC-XDCE'];
				} else {
					$pair = $getpair ? $getpair : 'XDC-ETH';
					$checkpair = Pair::where(['type' => 'trade', 'pair' => $pair])->count();
					if ($checkpair == 0) {
						abort(404);
					}
					$pair = [$pair];
				}

				if ($getstatus == 'all' || $getstatus == '') {
					$status = ['completed', 'cancelled', 'active', 'partially'];
				} else {
					$status = [$getstatus];
				}

				$trade_history = Trade::where(['user_id' => $userid])->whereIn('pair', $pair)->whereIn('status', $status)->orderBy('created_at', 'desc')->paginate(10);
				return view('front.trade_history', ['result' => $trade_history, 'getpair' => $getpair, 'getstatus' => $getstatus]);
			}
		}catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
	}

	function cancel_order($id) {
		try{
			if (Session::get('alphauserid') == "") {
				return redirect('logout');
			} else {
				$tradeid = base64_decode($id);
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
					Session::flash('success', 'Your order cancelled successfully');
					return redirect()->back();
				}
			}
		}catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
        }
	}

	function cancel_multiple($id)
    {
		
			if (Session::get('alphauserid') == "") {
				return redirect('logout');
			} else {
				$orders = json_decode($id);
				for($i=0;$i<count($orders);$i++)
				{
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
		
    }


	function trade_mapping($tradid, $type, $price, $pair) {
		try{
			$ftype = ($type == 'Buy') ? 'Sell' : 'Buy';
			$trade_user_id = $this->single_trade_details($tradid, 'user_id');
			if ($type == 'Buy') {

				$findorder = Trade::where('user_id', '<>', $trade_user_id)->where('Price', '<=', $price)->where(['pair' => $pair, 'Type' => $ftype])->where(function ($query) {
					$query->where('status', 'active')->Orwhere('status', 'partially');
				})->orderBy('Price', 'asc')->get();

			} else {
				$findorder = Trade::where('user_id', '<>', $trade_user_id)->where('Price', '>=', $price)->where(['pair' => $pair, 'Type' => $ftype])->where(function ($query) {
					$query->where('status', 'active')->Orwhere('status', 'partially');
				})->orderBy('Price', 'desc')->get();
			}

			if (count($findorder) > 0) {
				foreach ($findorder as $val)
				{
					$findprice = $val->Price;
					$findtradeid = $val->id;
					$finduserid = $val->user_id;
					$findfirst_currency = $val->firstCurrency;
					$findsecond_currency = $val->secondCurrency;
					$findtype = $val->Type;
					$usertype = $type;
					if ($price == $findprice) {
						// user buy trade

						if ($usertype == 'Buy') {
							$sellamount = $val->Amount;
							$userbuyamount = $this->single_trade_details($tradid, 'Amount');
							if ($userbuyamount == $sellamount) {
								$paidamount = $val->Total;
								$buyamount = $userbuyamount;
								$sell_fee = $val->Fee;
								$buy_fee = $this->single_trade_details($tradid, 'Fee');
								$this->update_trade_details($tradid, 'status', 'completed');
								$this->update_trade_details($findtradeid, 'status', 'completed');
								$this->insert_admin_profit($finduserid, $findsecond_currency, $sell_fee, 'Sell');
								$this->insert_admin_profit($trade_user_id, $findsecond_currency, $buy_fee, 'Buy');

								$this->user_balace_update($finduserid, $findsecond_currency, $paidamount);

								$this->user_balace_update($trade_user_id, $findfirst_currency, $buyamount);

								//opt price
								$this->update_trade_details($tradid, 'opt_price', $price);
								$this->update_trade_details($findtradeid, 'opt_price', $price);

								break;

							} elseif ($userbuyamount > $sellamount) {
								$part_amt = $userbuyamount - $sellamount;
								$paidamount = $val->Total;
								$sell_fee = $val->Fee;

								$part_buy_fee = $this->single_trade_details($tradid, 'fee_per');
								$part_total = $part_amt * $price;
								$upt_part_fee = $part_total * ($part_buy_fee / 100);
								$upt_total = $part_total + $upt_part_fee;

								//partially
								$this->partially_insert_order($findtradeid, 'Buy', $trade_user_id);

								$uptdata = ['Amount' => $part_amt, 'Fee' => number_format((float) $upt_part_fee, 8, '.', ''), 'Total' => number_format((float) $upt_total, 8, '.', ''), 'status' => 'partially'];
								$this->most_update_trade($tradid, $uptdata);

								//complete
								$this->update_trade_details($findtradeid, 'status', 'completed');

								$this->insert_admin_profit($finduserid, $findsecond_currency, $sell_fee, 'Sell');

								$this->user_balace_update($finduserid, $findsecond_currency, $paidamount);

								//opt price
								$this->update_trade_details($findtradeid, 'opt_price', $price);

							}
							elseif ($userbuyamount < $sellamount) {
								$find_part_amt = $sellamount - $userbuyamount;
								$paidamount = $userbuyamount;
								$buy_fee = $this->single_trade_details($tradid, 'Fee');

								$part_buy_fee = $val->fee_per;
								$part_total = $find_part_amt * $price;
								$upt_part_fee = $part_total * ($part_buy_fee / 100);
								$upt_total = $part_total - $upt_part_fee;

								//partially
								$this->partially_insert_order($tradid, 'Sell', $finduserid);

								$uptdata = ['Amount' => $find_part_amt, 'Fee' => number_format((float) $upt_part_fee, 8, '.', ''), 'Total' => number_format((float) $upt_total, 8, '.', ''), 'status' => 'partially'];

								$this->most_update_trade($findtradeid, $uptdata);

								//complete
								$this->update_trade_details($tradid, 'status', 'completed');

								$this->insert_admin_profit($trade_user_id, $findsecond_currency, $buy_fee, 'Buy');

								$this->user_balace_update($trade_user_id, $findfirst_currency, $paidamount);

								//opt price
								$this->update_trade_details($tradid, 'opt_price', $findprice);

								$this->trade_mapping($findtradeid, 'Sell', $price, $pair);
								break;

							}

						} else {

							//Sell trade function

							$buyamount = $val->Amount;
							$usersellamount = $this->single_trade_details($tradid, 'Amount');
							if ($usersellamount == $buyamount) {
								$paidamount = $this->single_trade_details($tradid, 'Total');
								$findusersell_amt = $buyamount;

								$buy_fee = $val->Fee;
								$sell_fee = $this->single_trade_details($tradid, 'Fee');

								$this->update_trade_details($tradid, 'status', 'completed');
								$this->update_trade_details($findtradeid, 'status', 'completed');

								$this->insert_admin_profit($trade_user_id, $findsecond_currency, $sell_fee, 'Sell');
								$this->insert_admin_profit($finduserid, $findsecond_currency, $buy_fee, 'Buy');

								$this->user_balace_update($finduserid, $findfirst_currency, $findusersell_amt);

								$this->user_balace_update($trade_user_id, $findsecond_currency, $paidamount);

								//opt price
								$this->update_trade_details($tradid, 'opt_price', $price);
								$this->update_trade_details($findtradeid, 'opt_price', $price);

								break;

							} elseif ($usersellamount > $buyamount) {

								$part_amt = $usersellamount - $buyamount;
								$paidamount = $buyamount;
								$buy_fee = $val->Fee;

								//partially
								$this->partially_insert_order($findtradeid, 'Sell', $trade_user_id);

								$part_buy_fee = $this->single_trade_details($tradid, 'fee_per');
								$part_total = $part_amt * $price;
								$upt_part_fee = $part_total * ($part_buy_fee / 100);
								$upt_total = $part_total - $upt_part_fee;

								$uptdata = ['Amount' => $part_amt, 'Fee' => number_format((float) $upt_part_fee, 8, '.', ''), 'Total' => number_format((float) $upt_total, 8, '.', ''), 'status' => 'partially'];
								$this->most_update_trade($tradid, $uptdata);

								//complete
								$this->update_trade_details($findtradeid, 'status', 'completed');

								$this->insert_admin_profit($finduserid, $findsecond_currency, $buy_fee, 'Buy');

								$this->user_balace_update($finduserid, $findfirst_currency, $paidamount);

								//opt price
								$this->update_trade_details($findtradeid, 'opt_price', $price);

							} elseif ($usersellamount < $buyamount) {

								$find_part_amt = $buyamount - $usersellamount;
								$paidamount = $this->single_trade_details($tradid, 'Total');
								$sell_fee = $this->single_trade_details($tradid, 'Fee');

								//partially
								$this->partially_insert_order($tradid, 'Buy', $finduserid);

								$part_buy_fee = $val->fee_per;
								$part_total = $find_part_amt * $price;
								$upt_part_fee = $part_total * ($part_buy_fee / 100);
								$upt_total = $part_total + $upt_part_fee;

								$uptdata = ['Amount' => $find_part_amt, 'Fee' => number_format((float) $upt_part_fee, 8, '.', ''), 'Total' => number_format((float) $upt_total, 8, '.', ''), 'status' => 'partially'];

								$this->most_update_trade($findtradeid, $uptdata);

								//complete
								$this->update_trade_details($tradid, 'status', 'completed');

								$this->insert_admin_profit($trade_user_id, $findsecond_currency, $sell_fee, 'Sell');

								$this->user_balace_update($trade_user_id, $findsecond_currency, $paidamount);

								//opt price
								$this->update_trade_details($tradid, 'opt_price', $price);

								$this->trade_mapping($findtradeid, 'Buy', $price, $pair);
								break;
							}

						} //Buy only trade
					}
					elseif ($price > $findprice && $type == 'Buy') {

						$sellamount = $val->Amount;
						$userbuyamount = $this->single_trade_details($tradid, 'Amount');
						$userbuytotal = $this->single_trade_details($tradid, 'Total');
						if ($userbuyamount == $sellamount) {
							$paidamount = $val->Total;
							$buyamount = $userbuyamount;
							$sell_fee = $val->Fee;
							$buy_fee = $this->single_trade_details($tradid, 'Fee');
							$this->update_trade_details($tradid, 'status', 'completed');
							$this->update_trade_details($findtradeid, 'status', 'completed');
							$this->insert_admin_profit($finduserid, $findsecond_currency, $sell_fee, 'Sell');
							// fee are same bcoz qty(amt) same
							$this->insert_admin_profit($trade_user_id, $findsecond_currency, $sell_fee, 'Buy');

							$this->user_balace_update($finduserid, $findsecond_currency, $paidamount);

							$this->user_balace_update($trade_user_id, $findfirst_currency, $buyamount);

							$calsellprice = ($sellamount * $findprice) + $sell_fee;
							$buyuserrefund = $userbuytotal - $calsellprice;
							$this->user_balace_update($trade_user_id, $findsecond_currency, $buyuserrefund);

							$this->update_trade_details($tradid, 'Price', $findprice);
							$this->update_trade_details($tradid, 'Fee', $sell_fee);
							$this->update_trade_details($tradid, 'Total', $calsellprice);

							//opt price
							$this->update_trade_details($tradid, 'opt_price', $findprice);
							$this->update_trade_details($findtradeid, 'opt_price', $price);

							break;

						} elseif ($userbuyamount > $sellamount) {

							$part_amt = $userbuyamount - $sellamount;
							$paidamount = $val->Total;
							$sell_fee = $val->Fee;

							$part_buy_fee = $this->single_trade_details($tradid, 'fee_per');
							$userbuytotal = $this->single_trade_details($tradid, 'Total');

							$part_total = $part_amt * $price;
							$upt_part_fee = $part_total * ($part_buy_fee / 100);
							$upt_total = $part_total + $upt_part_fee;

							//partially
							$this->partially_insert_order_buymethod($findtradeid, 'Buy', $trade_user_id, $findprice, $findprice);

							$uptdata = ['Amount' => $part_amt, 'Fee' => number_format((float) $upt_part_fee, 8, '.', ''), 'Total' => number_format((float) $upt_total, 8, '.', ''), 'status' => 'partially'];
							$this->most_update_trade($tradid, $uptdata);

							//complete
							$this->update_trade_details($findtradeid, 'status', 'completed');

							$this->insert_admin_profit($finduserid, $findsecond_currency, $sell_fee, 'Sell');

							$this->user_balace_update($finduserid, $findsecond_currency, $paidamount);

							// buyer refund
							$calsellprice = ($sellamount * $findprice) + $sell_fee;
							$buyuserrefund = $userbuytotal - ($calsellprice + $upt_total);
							$this->user_balace_update($trade_user_id, $findsecond_currency, $buyuserrefund);

							//opt price
							$this->update_trade_details($findtradeid, 'opt_price', $price);

						} elseif ($userbuyamount < $sellamount) {
							$find_part_amt = $sellamount - $userbuyamount;
							$paidamount = $userbuyamount;
							$buy_fee = $this->single_trade_details($tradid, 'fee_per');
							$buy_total_amt = $this->single_trade_details($tradid, 'Total');

							//buy trade calc
							$buy_total = $userbuyamount * $findprice;
							$uptbuy_fee = $buy_total * ($buy_fee / 100);
							$upt_buy_total1 = $buy_total + $uptbuy_fee;
							$upt_buy_total = $buy_total_amt - $upt_buy_total1;

							// sell partially
							$part_buy_fee = $val->fee_per;
							$part_total = $find_part_amt * $findprice;
							$upt_part_fee = $part_total * ($part_buy_fee / 100);
							$upt_total = $part_total - $upt_part_fee;

							//partially
							$this->partially_insert_order_buymethod($tradid, 'Sell', $finduserid, $findprice, $price);

							$uptdata = ['Amount' => $find_part_amt, 'Fee' => number_format((float) $upt_part_fee, 8, '.', ''), 'Total' => number_format((float) $upt_total, 8, '.', ''), 'status' => 'partially'];

							$this->most_update_trade($findtradeid, $uptdata);

							//complete
							$this->update_trade_details($tradid, 'status', 'completed');

							$this->insert_admin_profit($trade_user_id, $findsecond_currency, $uptbuy_fee, 'Buy');

							$this->user_balace_update($trade_user_id, $findfirst_currency, $paidamount);
							$this->user_balace_update($trade_user_id, $findsecond_currency, $upt_buy_total);

							//opt price
							$this->update_trade_details($tradid, 'opt_price', $findprice);

							break;

						}

					} elseif ($price < $findprice && $type == 'Sell') {
						$buyamount = $val->Amount;
						$buytotalamount = $val->Total;
						$usersellamount = $this->single_trade_details($tradid, 'Amount');
						if ($usersellamount == $buyamount) {
							$paidamount = $this->single_trade_details($tradid, 'Total');
							$findusersell_amt = $buyamount;

							$buy_fee = $val->Fee;
							$sell_fee = $this->single_trade_details($tradid, 'Fee');

							$this->update_trade_details($tradid, 'status', 'completed');
							$this->update_trade_details($findtradeid, 'status', 'completed');

							$this->insert_admin_profit($trade_user_id, $findsecond_currency, $buy_fee, 'Sell');
							$this->insert_admin_profit($finduserid, $findsecond_currency, $buy_fee, 'Buy');

							$this->user_balace_update($finduserid, $findfirst_currency, $findusersell_amt);

							$this->user_balace_update($trade_user_id, $findsecond_currency, $paidamount);

							$calbuyprice = ($buyamount * $price) + $sell_fee;
							$buyuserrefund = $buytotalamount - $calbuyprice;

							$this->user_balace_update($finduserid, $findsecond_currency, $buyuserrefund);

							//opt price
							$this->update_trade_details($tradid, 'opt_price', $findprice);
							$this->update_trade_details($findtradeid, 'opt_price', $findprice);

							break;

						} elseif ($usersellamount > $buyamount) {

							$part_amt = $usersellamount - $buyamount;
							$paidamount = $buyamount;
							$buy_fee = $val->Fee;
							$buy_feeper = $val->fee_per;
							$buy_totalamt = $val->Total;

							//partially
							$this->partially_insert_order_buymethod($findtradeid, 'Sell', $trade_user_id, $price, $findprice);

							$sell_fee = $this->single_trade_details($tradid, 'Fee');
							$sell_total = $this->single_trade_details($tradid, 'Total');
							$part_buy_fee = $this->single_trade_details($tradid, 'fee_per');
							$part_total = $part_amt * $price;
							$upt_part_fee = $part_total * ($part_buy_fee / 100);
							$upt_total = $part_total - $upt_part_fee;

							$uptdata = ['Amount' => $part_amt, 'Fee' => number_format((float) $upt_part_fee, 8, '.', ''), 'Total' => number_format((float) $upt_total, 8, '.', ''), 'status' => 'partially'];
							$this->most_update_trade($tradid, $uptdata);

							//complete
							$this->update_trade_details($findtradeid, 'status', 'completed');

							$this->user_balace_update($finduserid, $findfirst_currency, $paidamount);
							// Buyer refund

							$buysel_total = $buyamount * $price;
							$buysel_part_fee = $buysel_total * ($part_buy_fee / 100);
							$buysel_upt_total = $buysel_total + $buysel_part_fee;
							$buysel_refund = $buy_totalamt - $buysel_upt_total;

							$this->insert_admin_profit($finduserid, $findsecond_currency, $sell_fee, 'Buy');
							$this->user_balace_update($finduserid, $findsecond_currency, $buysel_refund);

							//opt price
							$this->update_trade_details($findtradeid, 'opt_price', $findprice);

						} elseif ($usersellamount < $buyamount) {

							$find_part_amt = $buyamount - $usersellamount;
							$paidamount = $this->single_trade_details($tradid, 'Total');
							$sell_fee = $this->single_trade_details($tradid, 'Fee');
							$buy_totalamt = $val->Total;
							//partially
							$this->partially_insert_order_buymethod($tradid, 'Buy', $finduserid, $price, $findprice);

							$part_buy_fee = $val->fee_per;
							$part_total = $find_part_amt * $findprice;
							$upt_part_fee = $part_total * ($part_buy_fee / 100);
							$upt_total = $part_total + $upt_part_fee;

							$uptdata = ['Amount' => $find_part_amt, 'Fee' => number_format((float) $upt_part_fee, 8, '.', ''), 'Total' => number_format((float) $upt_total, 8, '.', ''), 'status' => 'partially'];

							$this->most_update_trade($findtradeid, $uptdata);

							//complete
							$this->update_trade_details($tradid, 'status', 'completed');

							$this->insert_admin_profit($trade_user_id, $findsecond_currency, $sell_fee, 'Sell');

							$this->user_balace_update($trade_user_id, $findsecond_currency, $paidamount);

							// buyer refunder
							$buysel_total = $usersellamount * $price;
							$buysel_minus = $buysel_total + $sell_fee;
							$buysel_refund = $buy_totalamt - ($buysel_minus + $upt_total);

							$this->user_balace_update($finduserid, $findsecond_currency, $buysel_refund);

							//opt price
							$this->update_trade_details($tradid, 'opt_price', $findprice);

							break;

						}
					}
				}
			}
			return true;
		}catch(\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return view('errors.404');
            
            }
	}

	function single_trade_details($tradid, $key) {
		$result = Trade::where('id', $tradid)->first();
		return $result->$key;
	}

	function update_trade_details($tradid, $key, $value) {
		$upt = Trade::where('id', $tradid)->first();
		$upt->$key = $value;
		$upt->save();
		return true;
	}

	function user_balace_update($userid, $currency, $amount) {
		$paiduserbalance = get_userbalance($userid, $currency);
		$finbalance = $amount + $paiduserbalance;
		$upt = Balance::where('user_id', $userid)->first();
		$upt->$currency = $finbalance;
		$upt->save();
		return true;
	}

	function insert_admin_profit($user_id, $currency, $fee, $type) {
		$ins = new Profit;
		$ins->userId = $user_id;
		$ins->theftAmount = $fee;
		$ins->theftCurrency = $currency;
		$ins->type = 'Trd-' . $type;
		$ins->date = date('Y-m-d');
		$ins->time = date('H:i:s');
		$ins->save();
		return true;
	}

	function most_update_trade($tradid, $data) {
		$upt = Trade::where('id', $tradid)->update($data);
		return true;
	}

	function partially_insert_order($tradid, $type, $userid) {
		$getmatch = Trade::where('id', $tradid)->first();
		if ($type == 'Buy') {
			$amount = $getmatch->Amount;
			$fee = $getmatch->Fee;
			$total = $getmatch->Total;
			$total_price = $total + $fee;
		} else {
			$amount = $getmatch->Amount;
			$fee = $getmatch->Fee;
			$total = $getmatch->Total;
			$total_price = $total - $fee;
		}
		$ip = \Request::ip();
		$ins = new Trade;
		$ins->user_id = $userid;
		$ins->ip = $ip;
		$ins->firstCurrency = $getmatch->firstCurrency;
		$ins->secondCurrency = $getmatch->secondCurrency;
		$ins->Amount = $amount;
		$ins->Price = $getmatch->Price;
		$ins->Type = $type;
		$ins->Process = '';
		$ins->Fee = $fee;
		$ins->Total = $total_price;
		$ins->orderTime = date('H:i:s');
		$ins->datetime = date('Y-m-d');
		$ins->pair = $getmatch->pair;
		$ins->status = 'completed';
		$ins->fee_per = $getmatch->fee_per;
		$ins->save();

		if ($type == 'Buy') {
			$this->insert_admin_profit($userid, $getmatch->secondCurrency, $fee, 'Buy');
			$this->user_balace_update($userid, $getmatch->firstCurrency, $amount);
		} else {
			$this->insert_admin_profit($userid, $getmatch->secondCurrency, $fee, 'Sell');
			$this->user_balace_update($userid, $getmatch->secondCurrency, $total_price);
		}
		//opt price
		$partlast_orderid = $ins->id;
		$this->update_trade_details($partlast_orderid, 'opt_price', $getmatch->Price);

		return true;
	}

	function partially_insert_order_buymethod($tradid, $type, $userid, $findprice, $buyprice = "") {
		$getmatch = Trade::where('id', $tradid)->first();
		if ($type == 'Buy') {
			$amount = $getmatch->Amount;
			$buyprtprice = $amount * $findprice;
			$fee = $buyprtprice * ($getmatch->fee_per / 100);
			$total_price = $buyprtprice + $fee;
		} else {
			$amount = $getmatch->Amount;
			$selprtprice = $amount * $findprice;
			$fee = $selprtprice * ($getmatch->fee_per / 100);
			$total_price = $selprtprice - $fee;
		}
		$ip = \Request::ip();
		$ins = new Trade;
		$ins->user_id = $userid;
		$ins->ip = $ip;
		$ins->firstCurrency = $getmatch->firstCurrency;
		$ins->secondCurrency = $getmatch->secondCurrency;
		$ins->Amount = $amount;
		$ins->Price = $findprice;
		$ins->Type = $type;
		$ins->Process = '';
		$ins->Fee = $fee;
		$ins->Total = $total_price;
		$ins->orderTime = date('H:i:s');
		$ins->datetime = date('Y-m-d');
		$ins->pair = $getmatch->pair;
		$ins->status = 'completed';
		$ins->fee_per = $getmatch->fee_per;
		$ins->save();
		$partlast_orderid = $ins->id;

		if ($type == 'Buy') {
			$this->update_trade_details($partlast_orderid, 'opt_price', $buyprice);
			$this->insert_admin_profit($userid, $getmatch->secondCurrency, $fee, 'Buy');
			$this->user_balace_update($userid, $getmatch->firstCurrency, $amount);
		} else {
			$this->update_trade_details($partlast_orderid, 'opt_price', $findprice);
			$this->insert_admin_profit($userid, $getmatch->secondCurrency, $fee, 'Sell');
			$this->user_balace_update($userid, $getmatch->secondCurrency, $total_price);
		}
		//opt price

		return true;
	}

	function trade_chart($pair) {

		$pair = $pair ? $pair : 'XDC-ETH';
		//high value
		$high = "SELECT DATE(datetime) as dateval, SUM(Amount) as volume, MAX(Price) as total FROM XDC_trade_order where Type='Sell' AND status='completed' AND pair='$pair' AND datetime > '2017-11-15'  GROUP BY YEAR(datetime), MONTH(datetime), DATE(datetime) ORDER BY datetime ASC";

		$result = DB::select(DB::raw($high));
		$arr = "";
		if ($result) {
			$arr .= "[";
			foreach ($result as $key => $val) {
				$vdate = $val->dateval;
				$high = $val->total;
				$millsec = strtotime($vdate) * 1000;
				$open = $this->trade_open_value($vdate, $pair);
				$close = $this->trade_close_value($vdate, $pair);
				$low = $this->trade_min_value($vdate, $pair);
				$volume = $val->volume;
				$arr .= "[" . $millsec . "," . $open . "," . $high . "," . $low . "," . $close . "," . $volume . "]";
				if (count($result) != ($key + 1)) {$arr .= ",";}

			}
			$arr .= "]";
		} else {
			$vdate = date('Y-m-d');
			$millsec = strtotime($vdate) * 1000;
			$eval = 0;
			$arr .= "[[" . $millsec . "," . $eval . "," . $eval . "," . $eval . "," . $eval . "," . $eval . "]]";
		}
		echo $arr;

	}

	function trade_open_value($date, $pair) {
		$res = Trade::select('Price')->where(['datetime' => $date, 'pair' => $pair, 'status' => 'completed'])->orderBy('id', 'asc')->limit(1)->first();
		//$value = ($res->Type == 'Buy') ? $res->Price : $res->opt_price;
		//return $value;
		return $res->Price;

	}

	function trade_close_value($date, $pair) {
		$res = Trade::select('Price')->where(['datetime' => $date, 'pair' => $pair, 'status' => 'completed'])->orderBy('id', 'desc')->limit(1)->first();
		//$value = ($res->Type == 'Buy') ? $res->Price : $res->opt_price;
		//return $value;
		return $res->Price;
	}

	function trade_min_value($date, $pair)
    {

        $res = Trade::where(['datetime' => $date, 'pair' => $pair, 'status' => 'completed'])->min('Price');
		return $res;

    }

	function limit_order(Request $request)
    {
		if(Session::get('alphauserid') == "")
		{
			return redirect('logout');
		}
		else
		    {

			$ip = \Request::ip();
			$userid = Session::get('alphauserid');
			if ($request->isMethod('post'))
			{
				$data = array();
				$pair = $request['pair'];

				$trade_fee = $request['trade_fee'];
				$type = $request['type'];
				$cur = explode("-", $pair);
				$first_currency = $cur[0];
				$second_currency = $cur[1];
				$first_cur_balance = get_userbalance($userid, $first_currency);
				$second_cur_balance = get_userbalance($userid, $second_currency);

				$current_sell_rate = get_sell_market_rate($first_currency, $second_currency);

				$current_buy_rate = get_buy_market_rate($first_currency, $second_currency);

				$volume = get_trading_volume($first_currency, $second_currency, $userid);
				$trade_fee = $this->get_trading_fee(round($volume), $second_currency);

				if ($type == 'Buy') {
					$sell_rate = $request['buy_limit_price'];
					$buyamount = $request['buy_limit_' . $first_currency];
					$bprice = $buyamount * $sell_rate;
					$feeamount = $bprice * ($trade_fee / 100);
					$priceamount = $bprice + $feeamount;



					if ($priceamount <= $second_cur_balance) {

						$ins = new Trade;
						$ins->user_id = $userid;
						$ins->ip = $ip;
						$ins->firstCurrency = $first_currency;
						$ins->secondCurrency = $second_currency;
						$ins->Amount = $buyamount;
						$ins->Price = $sell_rate;
						$ins->Type = $type;
						$ins->Process = '';
						$ins->Fee = $feeamount;
						$ins->Total = $priceamount;
						$ins->orderTime = date('H:i:s');
						$ins->datetime = date('Y-m-d');
						$ins->pair = $pair;
						$ins->status = 'active';
						$ins->fee_per = $trade_fee;
						if ($ins->save())
						{
							$finalbalance = $second_cur_balance - $priceamount;
							$upt = Balance::where('user_id', $userid)->first();
							$upt->$second_currency = $finalbalance;
							$upt->save();
							last_activity(get_usermail($userid), 'Limit Buy order', $userid);
						}
						$last_orderid = $ins->id;

						$this->check_stop_orders($current_sell_rate, 'Buy');

						$this->trade_mapping($last_orderid, $type, $sell_rate, $pair);

						$data['status'] = '1';
						$data['message'] = 'Buy order placed';
						echo json_encode($data);die();

					} else {
						$data['status'] = '0';
						$data['message'] = 'Insufficient Balance of ' . $second_currency;
						echo json_encode($data);die();
					}
				}
				elseif ($type == 'Sell') {
					$buy_rate = $request['sell_limit_price'];
					$sellamount = $request['sell_limit_' . $first_currency];
					//$feeamount = $request['sell_fee_amount'];
					//$priceamount = $request['sell_price_amount'];

					$sprice = $sellamount * $buy_rate;
					$feeamount = $sprice * ($trade_fee / 100);
					$priceamount = $sprice - $feeamount;

					/*if ($this->check_market_price($current_buy_rate, $buy_rate, 'Sell') == 'ok') {
						$max_price = $current_buy_rate * (30 / 100);
						$max_price = $current_buy_rate + $max_price;
						$data['status'] = '0';
						$data['message'] = 'Maximum limit price ' . $max_price . ' ' . $second_currency;
						echo json_encode($data);die();
					}*/

					if ($sellamount <= $first_cur_balance) {

						$ins = new Trade;
						$ins->user_id = $userid;
						$ins->ip = $ip;
						$ins->firstCurrency = $first_currency;
						$ins->secondCurrency = $second_currency;
						$ins->Amount = $sellamount;
						$ins->Price = $buy_rate;
						$ins->Type = $type;
						$ins->Process = '';
						$ins->Fee = $feeamount;
						$ins->Total = $priceamount;
						$ins->orderTime = date('H:i:s');
						$ins->datetime = date('Y-m-d');
						$ins->pair = $pair;
						$ins->status = 'active';
						$ins->fee_per = $trade_fee;
						if ($ins->save()) {
							$finalbalance = $first_cur_balance - $sellamount;
							$upt = Balance::where('user_id', $userid)->first();
							$upt->$first_currency = $finalbalance;
							$upt->save();
							last_activity(get_usermail($userid), 'Limit Buy order', $userid);
						}
						$last_orderid = $ins->id;

						$this->check_stop_orders($current_buy_rate, 'Sell');

						$this->trade_mapping($last_orderid, $type, $buy_rate, $pair);

						$data['status'] = '1';
						$data['message'] = 'Sell order placed';
						echo json_encode($data);die();

					} else {
						$data['status'] = '0';
						$data['message'] = 'Insufficient Balance of ' . $first_currency;
						echo json_encode($data);die();
					}
				}
			}
		}
	}

	function stop_order(Request $request) {

		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$ip = \Request::ip();
			$userid = Session::get('alphauserid');
			if ($request->isMethod('post')) {
				$data = array();
				$pair = $request['pair'];

				$trade_fee = $request['trade_fee'];
				$type = $request['type'];
				$cur = explode("-", $pair);
				$first_currency = $cur[0];
				$second_currency = $cur[1];
				$first_cur_balance = get_userbalance($userid, $first_currency);
				$second_cur_balance = get_userbalance($userid, $second_currency);

				$current_buy_rate = get_buy_market_rate($first_currency, $second_currency);
				$current_sell_rate = get_sell_market_rate($first_currency, $second_currency);

				$volume = get_trading_volume($first_currency, $second_currency, $userid);
				$trade_fee = $this->get_trading_fee(round($volume), $second_currency);

				if ($type == 'Buy') {
					$sell_rate = $request['buy_stop_price'];
					$buyamount = $request['buy_stop_' . $first_currency];
					/*$feeamount = $request['buy_fee_amount'];
					$priceamount = $request['buy_price_amount'];*/

					$bprice = $buyamount * $sell_rate;
					$feeamount = $bprice * ($trade_fee / 100);
					$priceamount = $bprice + $feeamount;

					if ($priceamount <= $second_cur_balance) {

						$ins = new Trade;
						$ins->user_id = $userid;
						$ins->ip = $ip;
						$ins->firstCurrency = $first_currency;
						$ins->secondCurrency = $second_currency;
						$ins->Amount = $buyamount;
						$ins->Price = $sell_rate;
						$ins->Type = $type;
						$ins->Process = '';
						$ins->Fee = $feeamount;
						$ins->Total = $priceamount;
						$ins->orderTime = date('H:i:s');
						$ins->datetime = date('Y-m-d');
						$ins->pair = $pair;
						$ins->status = 'stop';
						$ins->fee_per = $trade_fee;
						if ($ins->save()) {
							$finalbalance = $second_cur_balance - $priceamount;
							$upt = Balance::where('user_id', $userid)->first();
							$upt->$second_currency = $finalbalance;
							$upt->save();
							last_activity(get_usermail($userid), 'Stop Buy order', $userid);
						}
						$last_orderid = $ins->id;

						$data['status'] = '1';
						$data['message'] = 'Stop order placed';
						echo json_encode($data);die();

					} else {
						$data['status'] = '0';
						$data['message'] = 'Insufficient Balance of ' . $second_currency;
						echo json_encode($data);die();
					}
				} elseif ($type == 'Sell') {
					$buy_rate = $request['sell_stop_price'];
					$sellamount = $request['sell_stop_' . $first_currency];
					/*$feeamount = $request['sell_fee_amount'];
					$priceamount = $request['sell_price_amount'];*/

					$sprice = $sellamount * $buy_rate;
					$feeamount = $sprice * ($trade_fee / 100);
					$priceamount = $sprice - $feeamount;

					if ($sellamount <= $first_cur_balance) {

						$ins = new Trade;
						$ins->user_id = $userid;
						$ins->ip = $ip;
						$ins->firstCurrency = $first_currency;
						$ins->secondCurrency = $second_currency;
						$ins->Amount = $sellamount;
						$ins->Price = $buy_rate;
						$ins->Type = $type;
						$ins->Process = '';
						$ins->Fee = $feeamount;
						$ins->Total = $priceamount;
						$ins->orderTime = date('H:i:s');
						$ins->datetime = date('Y-m-d');
						$ins->pair = $pair;
						$ins->status = 'stop';
						$ins->fee_per = $trade_fee;
						if ($ins->save()) {
							$finalbalance = $first_cur_balance - $sellamount;
							$upt = Balance::where('user_id', $userid)->first();
							$upt->$first_currency = $finalbalance;
							$upt->save();
							last_activity(get_usermail($userid), 'Stop Buy order', $userid);
						}
						$last_orderid = $ins->id;

						$data['status'] = '1';
						$data['message'] = 'Stop order placed';
						echo json_encode($data);die();

					} else {
						$data['status'] = '0';
						$data['message'] = 'Insufficient Balance of ' . $first_currency;
						echo json_encode($data);die();
					}
				}
			}
		}

	}

	function check_market_price($curr_price, $user_price, $type) {
		if ($type == 'Buy') {
			$min_price = $curr_price * (30 / 100);
			$min_price = $curr_price - $min_price;
			return ($min_price > $user_price) ? 'ok' : 'false';
		} else {
			$max_price = $curr_price * (30 / 100);
			$max_price = $curr_price + $max_price;
			return ($max_price < $user_price) ? 'ok' : 'false';
		}
	}

	function stop_cancel_order($id) {
		if (Session::get('alphauserid') == "") {
			return redirect('logout');
		} else {
			$tradeid = base64_decode($id);
			$result = Trade::where(['id' => $tradeid, 'status' => 'stop'])->first();
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
				Session::flash('success', 'Stop order cancelled successfully');
				return redirect()->back();
			}
		}
	}

	function check_stop_orders($price, $type) {
		$ftype = ($type == 'Buy') ? 'Sell' : 'Buy';
		$upt = Trade::where(['Type' => $ftype, 'Price' => $price, 'status' => 'stop'])->get();
		if (count($upt) > 0) {
			$uptdata = ['status' => 'active'];
			$res = Trade::where(['Type' => $ftype, 'Price' => $price, 'status' => 'stop'])->update($uptdata);
		}
		return true;

	}

	//fpr swap history
    function swap_history() {
        if (Session::get('alphauserid') == "") {
            return redirect('logout');
        } else {
            $userid = Session::get('alphauserid');




            $trade_history = Trade::where(['user_id' => $userid])->whereIn('pair', ['XDC-XDCE'])->whereIn('status', ['completed'])->orderBy('created_at', 'desc')->paginate(10);
            return view('front.trade_history', ['result' => $trade_history, 'getpair' => 'XDC-XDCE', 'getstatus' => 'completed']);
        }
    }

	// end class
    //fpr ico history
    function ico_history() {
        if (Session::get('alphauserid') == "") {
            return redirect('logout');
        } else {
            $userid = Session::get('alphauserid');




            $trade_history = ICOTrade::where('user_id',$userid)->orderBy('id','desc')->paginate(10);
            return view('front.trade_history', ['result' => $trade_history, 'getpair' => 'XDC-ICO', 'getstatus' => 'completed']);
        }
    }

}
