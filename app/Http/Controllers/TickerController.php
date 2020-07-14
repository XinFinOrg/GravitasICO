<?php

namespace App\Http\Controllers;

use App\model\Pair;
use App\model\Trade;

class TickerController extends Controller {
	//

	function index() {
		abort('404');
	}

	function info($pair = "") {
		$pair = $pair ? $pair : '';
		$checkpair = Pair::where(['type' => 'trade', 'pair' => $pair])->count();
		$data = array();

		if ($checkpair > 0) {
			$cur = explode("-", $pair);
			$first_currency = $cur[0];
			$second_currency = $cur[1];
			$data['status'] = 'success';
			$data['message'] = $pair . ' Market information';
			$data['markets'] = array();
			$data['markets'][0]['bid'] = $this->get_tick_bidprice($pair);
			$data['markets'][0]['last_price'] = $this->get_last_price($pair);
			$data['markets'][0]['volume24h'] = $this->get_volume_24h($pair, $first_currency);
			$data['markets'][0]['currency'] = $second_currency;
			$data['markets'][0]['marketname'] = $pair;
			$data['markets'][0]['ask'] = $this->get_ticket_ask($pair);
			$data['markets'][0]['low24h'] = $this->get_low_24h($pair);
			$data['markets'][0]['change24h'] = $this->get_change_24h($pair);
			$data['markets'][0]['high24h'] = $this->get_high_24h($pair);
            $data['markets'][0]['usd_price'] = $this->get_lastusdprice($pair, $second_currency);
            $data['markets'][0]['basecurrency'] = $first_currency;

		} else {
			$data['status'] = 'error';
			$data['markets'] = array();
		}
		echo(json_encode($data));

	}

	function XDCprice()
    {
        $data = array();
        $XDC_price = Trade::select('Price','pair','id')->where(['status' => 'completed', 'Type' => 'Buy'])->orderBy('id', 'DESC')->get()->unique('pair');
        if($XDC_price)
        {
            $data['status'] ='success';
            foreach ($XDC_price as $item)
            {
                $pair = $item->getAttributeValue('pair');
                if($pair=='XDC-ETH')
                {
                    $data['last_ETH_price'] = $item->getAttributeValue('Price');
                }
                elseif($pair=='XDC-XRP')
                {
                    $data['last_XRP_price']=$item->getAttributeValue('Price');
                }
                else
                    {
                        $data['last_BTC_price']=$item->getAttributeValue('Price');
                    }
            }
        }
        else
            {
                $data['status'] ='success';
                $data['last_ETH_price']= 0.0000;
                $data['last_XRP_price']= 0.0000;
                $data['last_BTC_price']= 0.0000;
            }
        die(json_encode($data));
    }

	function get_tick_bidprice($pair) {
		$data = Trade::where(['Type' => 'Buy', 'pair' => $pair])->where(function ($query) {
			$query->where('status', 'active')->Orwhere('status', 'partially');
		})->max('Price');
		return sprintf('%.8f', $data);
	}

	function get_last_price($pair) {
		$data = Trade::where(['pair' => $pair, 'status' => 'completed'])->orderBy('id', 'desc')->first();
        $data = Trade::where(['pair' => $pair, 'status' => 'completed'])->orderBy('id', 'desc')->limit(1)->first();

        if ($data) {
			$value = ($data->Type == 'Buy') ? $data->Price : $data->opt_price;
			return sprintf('%.8f', $value);
		}
		return null;
	}



	function get_volume_24h($pair, $currency) {
		$cur_time = date('Y-m-d H:i:s');
		$bef_time = date('Y-m-d H:i:s', strtotime('-24 hours', strtotime($cur_time)));
		$data = Trade::where(['status' => 'completed', 'pair' => $pair])->where(function ($query) use ($cur_time, $bef_time) {
			$query->where('updated_at', '<=', $cur_time)->where('updated_at', '>=', $bef_time);
		})->sum('Amount');
		return $data;

	}

	function get_ticket_ask($pair) {
		$data = Trade::where('pair', $pair)->where(function ($query) {
			$query->where('status', 'active')->Orwhere('status', 'partially');
		})->min('Price');
		return sprintf('%.8f', $data);
	}

	function get_low_24h($pair) {
		$cur_time = date('Y-m-d H:i:s');
		$bef_time = date('Y-m-d H:i:s', strtotime('-24 hours', strtotime($cur_time)));
		$data = Trade::where(['pair' => $pair, 'status' => 'completed'])->where(function ($query) use ($cur_time, $bef_time) {
			$query->where('updated_at', '<=', $cur_time)->where('updated_at', '>=', $bef_time);
		})->min('Price');
		return sprintf('%.8f', $data);
	}

	function get_high_24h($pair) {
		$cur_time = date('Y-m-d H:i:s');
		$bef_time = date('Y-m-d H:i:s', strtotime('-24 hours', strtotime($cur_time)));
		$data = Trade::where(['pair' => $pair, 'status' => 'completed'])->where(function ($query) use ($cur_time, $bef_time) {
			$query->where('updated_at', '<=', $cur_time)->where('updated_at', '>=', $bef_time);
		})->max('Price');
		return sprintf('%.8f', $data);
	}

	function get_change_24h($pair) {
		$high = $this->get_high_24h($pair);
		$low = $this->get_low_24h($pair);
		$data = $high - $low;
		return sprintf('%.8f', $data);
	}

    function get_lastusdprice($pair, $currency) {
        $lastprice = $this->get_last_price($pair);
        if ($lastprice) {
            $cur_price = get_estusd_price($currency, '1');
            $res = $cur_price * $lastprice;
            return sprintf('%.8f', $res);
        }
        return null;
    }
    function get_open_price($pair, $datetime) {
        //$datetime = date('Y-m-d');
        $data = Trade::where(['pair' => $pair, 'status' => 'completed'])->where('updated_at', 'like', '%' . $datetime . '%')->orderBy('id', 'asc')->limit(1)->first();
        if ($data) {
            $value = ($data->Type == 'Buy') ? $data->Price : $data->opt_price;
            return sprintf('%.8f', $value);
        }
        return null;
    }
    function get_close_price($pair, $datetime) {
        //$datetime = date('Y-m-d');
        $data = Trade::where(['pair' => $pair, 'status' => 'completed'])->where('updated_at', 'like', '%' . $datetime . '%')->orderBy('id', 'desc')->limit(1)->first();
        if ($data) {
            $value = ($data->Type == 'Buy') ? $data->Price : $data->opt_price;
            return sprintf('%.8f', $value);
        }
        return null;
    }


    function getxmlres($str) {
		require_once app_path('array2xml/array2xml.php');
		$otp = "";
		$strlen = strlen($str);
		for ($i = 0; $i < $strlen; $i++) {
			$char = substr($str, $i, 1);
			$otp .= $char . ',';
		}
		$string = "alpha, exchange, verification, code, is, " . $otp . ' thank you repeat,  verification, code, is, '.$otp;
		$actual = array(
			'Speak' => $string,
		);
		$xml = new \Array2xml();
		$xml->setRootName('Response');
		header("Content-type: text/xml");
		echo $xml->convert($actual);

	}
    function history($pair = "") {
        $pair = $pair ? $pair : '';
        $checkpair = Pair::where(['type' => 'trade', 'pair' => $pair])->count();
        $data = array();
        $start_date = '2017-11-14';
        $end_date = date('Y-m-d');
        $datetime1 = new \DateTime($start_date);
        $datetime2 = new \DateTime($end_date);
        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');
        if ($checkpair > 0) {
            $data['status'] = 'success';
            $data['history'] = array();
            for ($i = 0; $i < $days; $i++) {
                $finddate = date('Y-m-d', strtotime('+' . $i . ' days', strtotime($start_date)));
                $data['history'][$i]['open'] = $this->get_open_price($pair, $finddate);
                $data['history'][$i]['close'] = $this->get_close_price($pair, $finddate);
                $data['history'][$i]['high'] = $this->get_high_date_price($pair, $finddate);
                $data['history'][$i]['low'] = $this->get_low_date_price($pair, $finddate);
                $data['history'][$i]['volume'] = $this->get_datewise_volume($pair, $finddate);
                $data['history'][$i]['date'] = $finddate;
            }
        } else {
            $data['status'] = 'error';
            $data['history'] = array();
        }
        die(json_encode($data));
    }
    function get_high_date_price($pair, $datetime) {
        $data = Trade::where(['pair' => $pair, 'status' => 'completed'])->where('updated_at', 'like', '%' . $datetime . '%')->max('Price');
        return sprintf('%.8f', $data);
    }
    function get_low_date_price($pair, $datetime) {
        $data = Trade::where(['pair' => $pair, 'status' => 'completed'])->where('updated_at', 'like', '%' . $datetime . '%')->min('Price');
        return sprintf('%.8f', $data);
    }
    function get_datewise_volume($pair, $datetime) {
        $data = Trade::where(['pair' => $pair, 'status' => 'completed'])->where('updated_at', 'like', '%' . $datetime . '%')->sum('Amount');
        return $data;
    }


    function XDCAPIinfo($pair = "") {
        $pair = $pair ? $pair : '';
        $checkpair = Pair::where(['type' => 'trade', 'pair' => $pair])->count();
        $data = array();

        if ($checkpair > 0) {
            $cur = explode("-", $pair);
            $first_currency = $cur[0];
            $second_currency = $cur[1];
            $data['status'] = 'success';
            $data['message'] = $pair . ' Market information';
            $data['markets'] = array();
            $data['markets'][0]['bid'] = $this->get_tick_bidprice($pair);
            $data['markets'][0]['last_price'] = $this->get_last_price($pair);
            $data['markets'][0]['volume24h'] = $this->get_volume_24h($pair, $first_currency);
            $data['markets'][0]['currency'] = $second_currency;
            $data['markets'][0]['marketname'] = $pair;
            $data['markets'][0]['ask'] = $this->get_ticket_ask($pair);
            $data['markets'][0]['low24h'] = $this->get_low_24h($pair);
            $data['markets'][0]['change24h'] = $this->get_change_24h($pair);
            $data['markets'][0]['high24h'] = $this->get_high_24h($pair);
            $data['markets'][0]['usd_price'] = $this->get_lastusdprice($pair, $second_currency);
            $data['markets'][0]['basecurrency'] = $first_currency;
        } else {
            $data['status'] = 'error';
            $data['markets'] = array();
        }
        echo(json_encode($data));

    }

    //xdcapi
    function apiinfo($pair = "") {
        $pair = $pair ? $pair : '';
        $checkpair = Pair::where(['type' => 'trade', 'pair' => $pair])->count();
        $data = array();

        if ($checkpair > 0) {
            $cur = explode("-", $pair);
            $first_currency = $cur[0];
            $second_currency = $cur[1];
            $data['status'] = 'success';
            $data['message'] = $pair . ' Market information';
            $data['markets'] = array();
            $data['markets'][0]['bid'] = $this->get_tick_bidprice($pair);
            $data['markets'][0]['last_price'] = $this->get_last_price($pair);
            $data['markets'][0]['volume24h'] = $this->get_volume_24h($pair, $first_currency);
            $data['markets'][0]['currency'] = $second_currency;
            $data['markets'][0]['marketname'] = $pair;
            $data['markets'][0]['ask'] = $this->get_ticket_ask($pair);
            $data['markets'][0]['low24h'] = $this->get_low_24h($pair);
            $data['markets'][0]['change24h'] = $this->get_change_24h($pair);
            $data['markets'][0]['high24h'] = $this->get_high_24h($pair);
            $data['markets'][0]['usd_price'] = $this->get_lastusdprice($pair, $second_currency);
            $data['markets'][0]['basecurrency'] = $first_currency;
        } else {
            $data['status'] = 'error';
            $data['markets'] = array();
        }
        return(json_encode($data));

    }

    //api view page
    function getapi()
    {
        $ETHData = $this->apiinfo("XDC-ETH");
        $XRPData = $this->apiinfo("XDC-XRP");
        $BTCData = $this->apiinfo("XDC-BTC");
        return view('front.api',['BTC'=>$BTCData,'ETH'=>$ETHData,'XRP'=>$XRPData]);
    }

    //vendor exchanges api combined data
        function externalapis()

    {
        //get usd rate


        //koinok value
        $koinok = koinokapi();

        //idex
        $idex = idexapi();

        //mercatox
        $mercatox = mercatoxapi();

        //etherflyer
        $etherflyer = etherflyerapi();

        //bancor
        $bancor = bancorapi();
//        echo json_encode($koinok);

        $result = array('IDEX'=>$idex,'KOINOK'=>$koinok,'MERCATOX'=>$mercatox,'ETHERFLYER'=>$etherflyer,'BANCOR'=>$bancor);
        echo json_encode($result);

    }

}
