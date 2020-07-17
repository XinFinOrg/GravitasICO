<?php

use App\model\Admin;
use App\model\Balance;
use App\model\Country;
use App\model\Marketprice;
use App\model\Metacontent;
use App\model\SiteSettings;
use App\model\Trade;
use App\model\Transaction;
use App\model\Useractivity;
use App\model\Users;
use App\model\Verification;

//use Mail;

function get_adminprofile($key)
{
    try{
    $id = Session::get('alpha_id');
    $result = Admin::where('id', $id)->first();
    return $result->$key;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}
}

function get_superadmin($key)
{
    try{
    $result = Admin::where('id', 1)->first();
    return $result->$key;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}
}

function get_config($key)
{
    try{
    $result = SiteSettings::where('id', 1)->first();
    return $result->$key;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}
}

function admin_class($key = "")
{
    $uri = Request::segment(2);
    if ($uri == $key) {
        return "active";
    } else {
        return "";
    }
}

function get_icotokenid_details($id)
{
    try {

        return 1;
    } catch (\Exception $exception) {
        return 0;
    }
}


function sendmail($emails, $subject, $data = "")
{
    try{
    Mail::send(['html' => 'emails.template'], $data, function ($message) use ($emails, $subject) {
        $message->to($emails)->from(get_config('contact_mail'), get_config('site_name'))->subject($subject);
        $message->replyTo('noreply@gravitas.io');
    });
    return true;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}
}


function get_usd_price($currency)
{
    try {
        $get_usd = Marketprice::where('currency', $currency)->first();
        $usd_price = $get_usd->USD;
        return $usd_price;
    } catch (\Exception $exception) {
        return 0;
    }
}


function get_template($id, $key)
{
    try{
    $result = DB::table('email_template')->where('id', $id)->first();
    return $result->$key;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}
}

function get_usermail($user_id)
{
    try{
    $result = Users::where('id', $user_id)->first();
    return decrypt($result->end_user1) . '@' . decrypt($result->end_user2);
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}
}

function get_user_verified($user_id)
{
    try{
    $result = Users::where('id', $user_id)->first();
    $user_verified = $result->user_verified;

    if ($user_verified == 1) {
        return 'Verified';
    } else {
        return 'Unverified';
    }
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return 'Unverified';
}
}

function get_userbalance($user_id, $key)
{
    try {
        $result = DB::table('userbalance')->where('user_id', $user_id)->first();
        return $result->$key;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return 0;
    }
}

function get_cointype($id = "")
{
    if ($id == 1) {
        return "BTC";
    } elseif ($id == 2) {
        return "ETH";
    } elseif ($id == 3) {
        return "XRP";
    } elseif ($id == 4) {
        return "XDC";
    }
}

function dashboard_usercount()
{
    try{
    return Users::count();
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return 0;
}
}

function dashboard_totaltrans()
{
    try{
    return Trade::count();
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return 0;
}
}

function dashbard_totalbtcprofit()
{
    try{
    $sum = DB::table('coin_theft')->where('theftCurrency', 'BTC')->sum('theftAmount');
    return $sum;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return 0;
}
}

function dashbard_totalkyc()
{
    try{
    return Verification::count();
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return 0;
}
}

function dasboard_chart_btc($currency)
{
    try{
        /*$result=DB::table('coin_theft')->select('updated_at','theftAmount')->where('theftCurrency',$currency)->get();*/
        $daily = "SELECT DATE(date) as dateval, SUM(theftAmount) as total FROM XDC_coin_theft where theftCurrency='$currency' GROUP BY YEAR(date), MONTH(date), DATE(date)";
        $result = DB::select(DB::raw($daily));
        $arr = "";
        if ($result) {
            foreach ($result as $val) {
                $millsec = strtotime($val->dateval) * 1000;
                $arr .= "[" . $millsec . "," . $val->total . "]";
                $arr .= ",";
            }
            echo $arr;
        }  
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    } 
}

function getBrowser()
{
try{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = "Unknown Browser";

    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser',
    );

    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }

    }

    return $browser;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}

}

function getOS()
{
try{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $os_platform = "Unknown OS Platform";

    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
    );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }

    }

    return $os_platform;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}

}

function last_activity($email, $activity, $id = 0)
{
    try{
        //$ip_address = $_SERVER['REMOTE_ADDR'];
        $ip = \Request::ip();
        $ins = [
            'user_email' => $email,
            'ip_address' => $ip,
            'activity' => $activity,
            'browser_name' => getBrowser(),
            'os_name' => getOS(),
            'user_id' => $id,
        ];
        Useractivity::insert($ins);
        return true;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function front_class($key = "")
{
    try{
        $uri = Request::segment(1);
        if ($uri == $key) {
            return "active";
        } else {
            return "";
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function second_class($key = "")
{
    try{
        $uri = Request::segment(2);
        if ($uri == $key) {
            return "active";
        } else {
            return "";
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function second_selected($key = "")
{
    try{
        $uri = Request::segment(2);
        if ($uri == $key) {
            return "selected";
        } else {
            return "";
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_otpnumber($user_id, $isd, $mobile, $activity)
{
    try{
        $rand = mt_rand(000000, 999999);
        $check = \App\model\OTP::where('user_id', $user_id)->count();
        if ($check > 0) {
            \App\model\OTP::where('user_id', $user_id)->delete();
        }
        $ins = ['user_id' => $user_id, 'isd' => $isd, 'mobile_no' => ownencrypt($mobile), 'otp' => ownencrypt($rand), 'activity' => $activity];
        DB::table('otp')->insert($ins);
        return $rand;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_user_details($id, $key)
{
    try {
        $res = Users::where('id', $id)->first();
        return $res->$key;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_fee_settings($key)
{
    try{
    $res = DB::table('fee_settings')->where('id', '1')->first();
    return $res->$key;
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

//for ico mail
function ico_mail($userid, $amount, $txid, $currency)
{
try{
    $to = get_usermail($userid);
    $username = get_user_details($userid, 'enjoyer_name');
    $subject = get_template('7', 'subject');
    $message = get_template('7', 'template');
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
}catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}
}

function send_sms($to, $text)
{
    try{
        $AUTH_ID = "MAOTZLZGI0ODGXZGM4MZ";
        $AUTH_TOKEN = "ZmE0MTI2NDU2Y2IyM2YxOTBiOGY3ZjZiZDJjMjg2";
        //$fromnum = "+919930403019";
        $fromnum = "+6588769089";

        $url = 'https://api.plivo.com/v1/Account/' . $AUTH_ID . '/Message/';
        $data = array("src" => "$fromnum", "dst" => "$to", "text" => "$text");
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        /*echo "<pre>";
            print_r(json_decode($response));*/

        return true;
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_country_name($country_id)
{   try{
        $res = Country::where('id', $country_id)->first();
        return $res->nicename;
    } catch (\Exception $e) {
        return '';
    }
}

function ownencrypt($q)
{   try{
        $cryptKey = 'xeahpla';
        $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
        return ($qEncoded);
        return $q;
    } catch (\Exception $e) {
        return '';
    }
}

function owndecrypt($q)
{
    try{
        $cryptKey = 'xeahpla';
        $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
        return ($qDecoded);
        return $q;
        } catch (\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return '';
        }
}

function get_document_status($user_id, $key)
{
    try{
        $res = Verification::where('user_id', $user_id)->first();
        if ($res) {
            return $res->$key;
        } else {
            return "";
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}

function getDataURI($image, $mime = '')
{
    try{
    return 'data: ' . (function_exists('mime_content_type') ? mime_content_type($image) : $mime) . ';base64,' . base64_encode(file_get_contents($image));
    }
    catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function checktfa_code($secret, $onecode)
{   
    try{
        include app_path() . '/Googleauthenticator.php';
        $ga = new \Googleauthenticator();
        if ($ga->verifyCode($secret, $onecode, 3)) {
            return "1";
        } else {
            return "0";
        }
    }
    catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function update_user_balance($userid, $curr, $val)
{   
    try{
        $upt = Balance::where('user_id', $userid)->first();
        $upt->$curr = $val;
        $upt->save();
        return true;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}


function get_market_price($currency, $currency1)
{
    try{
        $res = Marketprice::where('currency', $currency)->first();
        $result = $res->$currency1;
        return (float)$result;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function create_eth_address($userid)
{
    try{
        $pass = 'alphaex';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => '8545',
            CURLOPT_URL => "http://78.129.229.18:8545",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"method\":\"personal_newAccount\",\n\"params\":[\"" . $pass . "\"],\"id\":1}",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/json",
                "Postman-Token: 96e74ce3-b2ec-4235-bc0a-1435e9c13aee"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($response) {
            $response = json_decode($response);
            return $response->result;
        } else if ($err)
            return "";
        else
            return "";
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }


}


function upload()
{
    try{
        $info = pathinfo($_FILES['userFile']['name']);
        $ext = $info['extension']; // get the extension of the file
        $newname = "newname." . $ext;

        $target = 'images/' . $newname;
        move_uploaded_file($_FILES['userFile']['tmp_name'], $target);
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}


// create btc address

function create_btc_address($userid)
{
    try{
        require_once app_path('jsonRPCClient.php');
        $checkAddress = "";
        $gusermail = get_usermail($userid);
        $bitcoin_username = owndecrypt(get_wallet_keydetail('BTC', 'XDC_username'));
        $bitcoin_password = owndecrypt(get_wallet_keydetail('BTC', 'XDC_password'));
        $bitcoin_portnumber = owndecrypt(get_wallet_keydetail('BTC', 'portnumber'));
        $bitcoin_host = owndecrypt(get_wallet_keydetail('BTC', 'host'));

        $bitcoin = new jsonRPCClient("http://$bitcoin_username:$bitcoin_password@$bitcoin_host:$bitcoin_portnumber/");
        if ($bitcoin) {
            $checkAddress = $bitcoin->getaccountaddress($gusermail);
        }

        return $checkAddress;
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_userid_btcaddr($addr)
{
    try {
        $res = Users::where('BTC_addr', $addr)->first();
        return $res ? $res->id : 'no';
    }  catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_userid_usdtaddr($addr)
{
    try {
        $res = Users::where('USDT_addr', $addr)->first();
        return $res ? $res->id : 'no';
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

//get last mined block from node
function get_last_block($ip, $port)
{
    try {
        $output = array();
        $return_var = -1;
        $sever_path = $_SERVER["DOCUMENT_ROOT"];
        $result = exec('cd ' . $_SERVER["DOCUMENT_ROOT"] . '\crypto & node xdc_blockNumber.js ' . $ip . ' ' . $port, $output, $return_var);

        $out = json_decode($result);
        return $out;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

//get last mined etherscan block
function get_etherscan_block()
{
    try {

    } catch (\Exception $exception) {

    }
}


function get_userid_bchaddr($addr)
{
    try{
        $res = Users::where('BCH_addr', $addr)->first();
        return $res ? $res->id : 'no';
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}


function get_spendinglimit($userid)
{
    try{
        $today = date('Y-m-d');
        $btclimit = Transaction::where('user_id', $userid)->where('created_at', 'like', '%' . $today . '%')->where('currency_name', 'BTC')->Orwhere('second_currency', 'BTC')->sum('paid_amount');
        return $btclimit;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}


function get_recent_block()
{
    try{
            $eurl = 'https://api.etherscan.io/api?module=proxy&action=eth_blockNumber&apikey=YourApiKeyToken';

            $cObj = curl_init();
            curl_setopt($cObj, CURLOPT_URL, $eurl);
            curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
            $output = curl_exec($cObj);
            $curlinfos = curl_getinfo($cObj);

            $result = json_decode($output);

            if ($result) {
                $block = (hexdec($result->result));
            } else {
                $block = 0;
            }
            return $block;
        }catch (\Exception $e) {
            \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
            return '';
        }
}

function sendBlocklagMail($name, $difference)
{
    try {
        $emails = 'support@gravitas.io';
        foreach ($emails as $email) {
            $to = $email;
            $subject = get_template('13', 'subject');
            $message = get_template('13', 'template');
            $mailarr = array(
                '###CURRENCY###' => $name,
                '###DIFFERENCE###' => $difference,
                '###LINK###' => url('userverification/' . ''),
                '###SITENAME###' => get_config('site_name'),

            );
            $message = strtr($message, $mailarr);
            $subject = strtr($subject, $mailarr);
            sendmail($to, $subject, ['content' => $message]);
        }

    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}

function eth_transfer_fun($fromaddr, $amount, $toaddr, $userid)
{
    try {
        $output = array();
        $return_var = -1;
        $wallet_ip = "";
        $wallet_port = "";
        $password = "";

        $server_path = $_SERVER["DOCUMENT_ROOT"];

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $result = exec('cd ' . $server_path . '/crypto && node sent_eth.js ' . $wallet_ip . ' ' . $wallet_port . ' ' . $fromaddr . ' ' . $toaddr . ' ' . $amount . ' ' . $password, $output, $return_var);
        } else {
            $result = exec('cd ' . $server_path . '/public/crypto; node sent_eth.js ' . $wallet_ip . ' ' . $wallet_port . ' ' . $fromaddr . ' ' . $toaddr . ' ' . $amount . ' ' . $password, $output, $return_var);
        }

        $out = json_decode($result);
        if ($out->status == 0) {
            return 'error';
        } else {
            return $out->hash;
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

//for testing
function eth_transfer_fund($fromaddr, $amount, $toaddr, $userid)
{
    try{
        $output = array();
        $return_var = -1;
        $wallet_ip = "";
        $wallet_port = "";
        $password = "";

        $result = exec('cd ' . $_SERVER["DOCUMENT_ROOT"] . '\crypto & node sent_eth1.js ' . $wallet_ip . ' ' . $wallet_port . ' ' . $fromaddr . ' ' . $toaddr . ' ' . $amount . ' ' . $password, $output, $return_var);

        $out = json_decode($result);
    //        echo $out;
        return $out;
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}

function eth_transfer_fun_admin($fromaddr, $amount, $toaddr)
{
    try{
        $output = array();
        $return_var = -1;
        $wallet_ip = "";
        $wallet_port = "";
        $password = "";

        $result = exec('cd ' . $_SERVER["DOCUMENT_ROOT"] . '\crypto & node sent_eth_admin.js ' . $wallet_ip . ' ' . $wallet_port . ' ' . $fromaddr . ' ' . $toaddr . ' ' . $amount . ' ' . $password, $output, $return_var);

        /*echo "<pre>";
            print_r($result);
            echo "<br>";
            print_r($output);
            echo "<br>";
            print_r($return_var);
        */

        $out = json_decode($result);
        return $out->hash;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}

function blockip_list($ip)
{
    try {
        $check = DB::table('whitelist')->where('ip', $ip)->first();
        if (count($check) > 0) {
            abort(404);
            exit;
        }
        return true;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}


function deposit_mail($userid, $amount, $txid, $currency)
{
    try {
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
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

//send usdt
function usdt_transfer($sender, $admin_address)
{
    try {
        require_once app_path('jsonRPCClient.php');
        $bitcoin_username = owndecrypt(get_wallet_keydetail('USDT', 'XDC_username'));
        $bitcoin_password = owndecrypt(get_wallet_keydetail('USDT', 'XDC_password'));
        $bitcoin_portnumber = owndecrypt(get_wallet_keydetail('USDT', 'portnumber'));
        $bitcoin_host = owndecrypt(get_wallet_keydetail('USDT', 'host'));
        $bitcoin = new jsonRPCClient("http://$bitcoin_username:$bitcoin_password@$bitcoin_host:$bitcoin_portnumber/");

        if ($bitcoin) {

            \Log::error("bitcoin inside");
            $address = $bitcoin->omni_funded_sendall($sender, $admin_address, 1, $admin_address);
            \Log::error("bitcoin outside" . $address);
            return $address;
        }

    } catch (\Exception $exception) {
        \Log::error([$exception->getMessage(), $exception->getFile(), $exception->getLine()]);
        return 'error';
    }

}

// send btc

function btc_transfer_fun($toaddr, $btc_amount)
{
    try{
        require_once app_path('jsonRPCClient.php');
        $bitcoin_username = owndecrypt(get_wallet_keydetail('BTC', 'XDC_username'));
        $bitcoin_password = owndecrypt(get_wallet_keydetail('BTC', 'XDC_password'));
        $bitcoin_portnumber = owndecrypt(get_wallet_keydetail('BTC', 'portnumber'));
        $bitcoin_host = owndecrypt(get_wallet_keydetail('BTC', 'host'));

        $bitcoin = new jsonRPCClient("http://$bitcoin_username:$bitcoin_password@$bitcoin_host:$bitcoin_portnumber/");

        $isvalid = "";

        if ($bitcoin) {
            $isvalid = $bitcoin->sendtoaddress($toaddr, $btc_amount);
        }
        return $isvalid;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}

//btc wallet info
function get_btc_wallet_info()
{
    try{
        require_once app_path('jsonRPCClient.php');
        $bitcoin_username = owndecrypt(get_wallet_keydetail('BTC', 'XDC_username'));
        $bitcoin_password = owndecrypt(get_wallet_keydetail('BTC', 'XDC_password'));
        $bitcoin_portnumber = owndecrypt(get_wallet_keydetail('BTC', 'portnumber'));
        $bitcoin_host = owndecrypt(get_wallet_keydetail('BTC', 'host'));

        $bitcoin = new jsonRPCClient("http://$bitcoin_username:$bitcoin_password@$bitcoin_host:$bitcoin_portnumber/");
        if ($bitcoin) {
            $checkAddress = $bitcoin->getwalletinfo();
        }

        return $checkAddress;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return 0;
    }
}

//USDT wallet info
// function get_usdt_wallet_info() {
// 	require_once app_path('jsonRPCClient.php');
// 	$bitcoin_username = owndecrypt(get_wallet_keydetail('USDT', 'XDC_username'));
// 	$bitcoin_password = owndecrypt(get_wallet_keydetail('USDT', 'XDC_password'));
// 	$bitcoin_portnumber = owndecrypt(get_wallet_keydetail('USDT', 'portnumber'));
// 	$bitcoin_host = owndecrypt(get_wallet_keydetail('USDT', 'host'));

// 	$bitcoin = new jsonRPCClient("http://$bitcoin_username:$bitcoin_password@$bitcoin_host:$bitcoin_portnumber/");
// 	if ($bitcoin) {
// 		$checkAddress = $bitcoin->getwalletinfo();
// 	}

// 	return $checkAddress;
// }


function owner_activity($email, $activity)
{
    try{
        //$ip_address = $_SERVER['REMOTE_ADDR'];
        $ip = \Request::ip();
        $ins = [
            'user_email' => $email,
            'ip_address' => $ip,
            'activity' => $activity,
            'browser_name' => getBrowser(),
            'os_name' => getOS(),
        ];
        DB::table('owner_activity')->insert($ins);
        return true;
 } catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
    }
}

function getting_eth_balance($address)
{
    try{
        $output = array();
        $return_var = -1;
        $ip = "109.169.40.121";
        $port = "8545";
        $balance = exec('cd ' . $_SERVER["DOCUMENT_ROOT"] . '\crypto & node eth_balance.js ' . $ip . ' ' . $port . ' ' . $address, $output, $return_var);
        $bal = $balance / 1000000000000000000;
        return $bal;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return 0;
}
}

function getting_eth_block()
{
    try{
    //    $output = array();
        $return_var = -1;
        $ip = "109.169.40.121";
        $port = "8545";

        $balance = exec('cd ' . $_SERVER["DOCUMENT_ROOT"] . '\crypto & node eth_block.js ' . $ip . ' ' . $port . ' ', $return_var);
        $decode_balance = json_decode($balance);
        return $decode_balance;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_wallet_keydetail($type, $key)
{
    try{
        $result = DB::table('wallet')->where('type', $type)->first();
        return $result->$key;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
        return '';
    }
}

//get btc transactions
function get_btc_transactionlist()
{
    try {
        require_once app_path('jsonRPCClient.php');
        $bitcoin_username = owndecrypt(get_wallet_keydetail('BTC', 'XDC_username'));
        $bitcoin_password = owndecrypt(get_wallet_keydetail('BTC', 'XDC_password'));
        $bitcoin_portnumber = owndecrypt(get_wallet_keydetail('BTC', 'portnumber'));
        $bitcoin_host = owndecrypt(get_wallet_keydetail('BTC', 'host'));

        $bitcoin = new jsonRPCClient("http://$bitcoin_username:$bitcoin_password@$bitcoin_host:$bitcoin_portnumber/");

        return $bitcoin;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

//get usdt transactions
function get_usdt_transactionlist()
{
    try {
        require_once app_path('jsonRPCClient.php');
        $checkAddress = "";
        $bitcoin_username = 'USDTExNet';
        $bitcoin_password = 'USDTExNetCash@2018%';
        $bitcoin_portnumber = '9556';
        $bitcoin_host = '109.169.40.126';
        $bitcoin = new jsonRPCClient("http://$bitcoin_username:$bitcoin_password@$bitcoin_host:$bitcoin_portnumber/");
        if ($bitcoin) {
            $block_info = $bitcoin->omni_listtransactions();
            return $block_info;
        }
    } catch (\Exception $exception) {
        return '';
    }
}


// trade helpers

function get_buy_market_rate($first, $second)
{
    try{
        $check = Trade::where(['firstCurrency' => $first, 'secondCurrency' => $second, 'Type' => 'Sell'])->where(function ($query) {
            $query->where('status', 'active')->Orwhere('status', 'partially');
        })->min('Price');
        /*$query = "SELECT Price FROM `XDC_trade_order` WHERE firstCurrency='$first' AND secondCurrency='$second' AND Type='Sell' AND (status='active' OR status='partially') ORDER BY id ASC LIMIT 1";
        $check = DB::select(DB::raw($query));*/

        if ($check > 0) {
            return $check;
        } else {
            return get_market_price($first, $second);
        }
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_sell_market_rate($first, $second)
{
    try{
        $check = Trade::where(['firstCurrency' => $first, 'secondCurrency' => $second, 'Type' => 'Buy'])->where(function ($query) {
            $query->where('status', 'active')->Orwhere('status', 'partially');
        })->max('Price');
        /*$query = "SELECT Price FROM `XDC_trade_order` WHERE firstCurrency='$first' AND secondCurrency='$second' AND Type='Buy' AND (status='active' OR status='partially') ORDER BY id desc LIMIT 1";
        $check = DB::select(DB::raw($query));*/
        if ($check > 0) {
            return $check;
        } else {
            return get_market_price($first, $second);
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_trading_volume($first, $second, $userid)
{
    try{
        $fee = Trade::where(['firstCurrency' => $first, 'secondCurrency' => $second, 'user_id' => $userid])->sum('Total');
        return $fee;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}


function get_meta_title()
{
    try{
        $uri = Request::segment(1);
        $uri = $uri ? $uri : 'home';
        $check = Metacontent::where('link', $uri)->first();
        if ($check) {
            return $check->title;
        } else {
            $check1 = Metacontent::where('link', 'home')->first();
            return $check1->title;
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_meta_description()
{   
    try{
        $uri = Request::segment(1);
        $uri = $uri ? $uri : 'home';
        $check = Metacontent::where('link', $uri)->first();
        if ($check) {
            return $check->meta_description;
        } else {
            $check1 = Metacontent::where('link', 'home')->first();
            return $check1->meta_description;
        }
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function get_meta_keywords()
{   try{
        $uri = Request::segment(1);
        $uri = $uri ? $uri : 'home';
        $check = Metacontent::where('link', $uri)->first();
        if ($check) {
            return $check->meta_keywords;
        } else {
            $check1 = Metacontent::where('link', 'home')->first();
            return $check1->meta_keywords;
        }
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

function voiceotp($to, $ansurl)
{
    try{
        $AUTH_ID = "MAOTZLZGI0ODGXZGM4MZ";
        $AUTH_TOKEN = "ZmE0MTI2NDU2Y2IyM2YxOTBiOGY3ZjZiZDJjMjg2";
        $fromnum = "+6588769089";

        $url = 'https://api.plivo.com/v1/Account/' . $AUTH_ID . '/Call/';
        $data = array("from" => "$fromnum", "to" => "$to", "answer_url" => "$ansurl", "answer_method" => "GET");
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        /*echo "<pre>";
        print_r($response);*/
        return true;
}catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}

}

//verify ether amount
function verifyEther($ether_address)
{
    try{
        $url = 'https://api.etherscan.io/api?module=account&action=balance&address=' . $ether_address . '&tag=latest&apikey=56e56af3-166d-400a-a9ec5-acdfg55-789';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);

        curl_close($ch);
        if ($data) {
            $result = json_decode($data);
            $ether_value = ($result->result) / 1000000000000000000;
            return $ether_value;
        } else {
            return "Connection Timeout";
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}


//verify btc amount
function verifyBTC($btc_address)
{
    try{
        $url = 'https://blockchain.info/q/addressbalance/' . $btc_address;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $btc_bal = curl_exec($ch);
        curl_close($ch);
        return $btc_bal;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
}

}

//verify btc amount
function verifyUSDT($usdt_address)
{
    try{
        $url = 'https://blockchain.info/q/addressbalance/' . $usdt_address;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $usdt_bal = curl_exec($ch);
        curl_close($ch);
        return $usdt_bal;
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}


function get_dest_userid($xrp_desttag)
{   try{
        $res = Users::where('xrp_desttag', $xrp_desttag)->first();
        if ($res) {
            return $res->id;
        } else {
            return false;
        }
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
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
    }catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

//email finder
function getByEmail($end_user1, $end_user2)
{
    try{
    $items = Users::all()->filter(function ($record) use ($end_user1, $end_user2) {
        if (decrypt($record->end_user1) == $end_user1 && decrypt($record->end_user2) == $end_user2) {
            return $record;
        } else {
            return false;
        }
    });

    return $items;
}catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}

}

//btc deposit transaction of a user
function get_btcDeposit_user($addr)
{
    try{
        $url = 'https://blockchain.info/address/' . $addr . '?format=json';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);

        $dataresult = json_decode($data);

        curl_close($ch);
        /*echo "<pre>";
        print_r($result);*/
        return ($dataresult->total_received) / 100000000;
} catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}

}

//bch deposit transaction of a user
function get_bchDeposit_user($addr)
{
try{
    $url = 'https://blockdozer.com/insight-api/addr/' . $addr . '/balance';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);

    $dataresult = json_decode($data);

    curl_close($ch);
    /*echo "<pre>";
    print_r($result);*/
    return ($dataresult) / 100000000;
}catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}

}

//get eth block
function get_eth_block()
{
    try {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8545",
            CURLOPT_URL => "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"method\":\"eth_blockNumber\",\n\"params\":[\"\", true],\"id\":1}",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/json",
                "Postman-Token: cc769a7c-7557-41ea-bc96-cc4edb786f93"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $result = json_decode($response);
            return hexdec($result->result);
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }
}

//function get block details
function get_transaction_byBlock($block)
{
    try {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => "8545",
            CURLOPT_URL => "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"method\":\"eth_getBlockByNumber\",\n\"params\":[\"0x" . $block . "\", true],\"id\":1}",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
                "Content-Type: application/json",
                "Postman-Token: 442974d2-ea7c-442b-8c12-267c0b8f4d0e"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    } catch (\Exception $e) {
        \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
        return '';
    }

}

//get username from session
function get_user_name()
{
    try {
        if (Session::get('alphauserid') == "") {
            return 'Guest';
        } else {
            $userid = Session::get('alphauserid');
            $name = get_user_details($userid, 'enjoyer_name');
            return $name;
        }
    } catch (\Exception $exception) {
        return 'Guest';
    }
}

//eth deposit transaction details
function get_ethDeposit_user($addr)
{
    try {
        $AdminAddress = decrypt(get_config('eth_address'));
        $user_deposit = 0;
        $eurl = 'https://api.etherscan.io/api?module=account&action=txlist&address=' . $addr . '&startblock=0&endblock=latest';

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

                $Fromaddress = $transaction[$tr]->from;
                $Toaddress = $transaction[$tr]->to;
                $value = $transaction[$tr]->value;

                if ($Toaddress === $AdminAddress) {
                    $eth_balance = $value;
                    $ether_balance = ($eth_balance / 1000000000000000000);
                    $user_deposit = $user_deposit + $ether_balance;
                }


            }
        }
        $internalurl = 'https://api.etherscan.io/api?module=account&action=txlistinternal&address=' . $addr . '&startblock=0&endblock=latest';

        $cObj = curl_init();
        curl_setopt($cObj, CURLOPT_URL, $internalurl);
        curl_setopt($cObj, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($cObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($cObj);
        $curlinfos = curl_getinfo($cObj);

        $internalresult = json_decode($output);
        if ($internalresult->message == 'OK') {
            $transaction = $internalresult->result;
            for ($tr = 0; $tr < count($transaction); $tr++) {

                $Fromaddress = $transaction[$tr]->from;
                $Toaddress = $transaction[$tr]->to;
                $value = $transaction[$tr]->value;

                if ($Toaddress === $AdminAddress) {
                    $eth_balance = $value;
                    $ether_balance = ($eth_balance / 1000000000000000000);
                    $user_deposit = $user_deposit + $ether_balance;
                }


            }
        }


        return $user_deposit;
    } catch (\Exception $exception) {
        return 'Error';
    }


}


function verify_user_registeration($isdcode, $phone, $email)
{
try{
    $otp = get_otpnumber('0', $isdcode, $phone, 'Registration');
    if (is_numeric($otp)) {
        $to = '+' . $isdcode . $phone;
        $text = "Gravitas verification code is " . $otp;
        send_sms($to, $text);

        $res = array('status' => 1, 'sms' => 'send');
    } else {
        $res = array('status' => 0, 'sms' => 'notsend');
    }
    //echo Response::json($res);
    return $res;
}catch (\Exception $e) {
    \Log::error([$e->getFile(), $e->getLine(), $e->getMessage()]);
    return '';
}
}

function get_estusd_price($currency, $amt)
{
    try {
        $res = Marketprice::where('currency', $currency)->first();
        $getusd = $res->USD;
        $retres = $getusd * $amt;
        return (float)$retres;
    } catch (\Exception $e) {
        \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
        return 0;
    }
}

function create_address($currency, $url)
{

    try {

        $public_key = '115a6c7346a0c0dd55aa28641e90e6d54577ded225d4577ab98ba8891f285372';
        $private_key = '7bE16046d054451BC80D28eC2C5797e2b37c71ecb3819Ab3017913e77272Af11';
        $secret = ']MJ.Xv=G%}{4';

        // Note there are two required post fields  "cmd" and "currency" per the above referenced documentation
        // version, key and format will stay the same for all your requests.
        $req['version'] = 1;
        $req['cmd'] = "get_callback_address";
        $req['ipn_url'] = $url;
        $req['currency'] = $currency;
        $req['key'] = $public_key;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');

        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $private_key);

        // Use curl to hit the endpoint so that you can send the required headers
        $ch = curl_init('https://www.coinpayments.net/api.php');
        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: ' . $hmac, 'Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        // Execute the call and close cURL handle
        $data = curl_exec($ch);
        $err = curl_error($ch);
        \Log::info(['data' => $data, 'error', $err]);
        // dump the data returned back from coinpayments
        return $data;

    } catch (\Exception $e) {
        \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
        return view('errors.404');
    }


}

function generate_currency_address($userid, $currency)
{
    try {
        if ($currency == 'ETH') {
            $eth = get_user_details($userid, 'ETH_addr');
            if ($eth == "") {
                //coin payment code
                $val = create_address('ETH', 'http://127.0.0.1/cron/eth_deposit_process');
                $val = json_decode($val);
                \Log::info(["logs", $val->result->address]);
                $ins = Users::where('id', $userid)->first();

                $ins->ETH_addr = $val->result->address;
                $ins->save();
                $address = $ins->ETH_addr;
                return $address;

                //blockahin code
                // $val = create_eth_address();
                // $ins = Users::where('id', $userid)->first();

                // $ins->ETH_addr = $val;
                // $ins->save();
                // $count = UserCurrencyAddresses::where('user_id', $userid)->where('currency_name', 'ETH')->first();
                // if ($count != null) {
                //     $count->currency_addr = $val;
                //     $count->save();
                // } else {
                //     $addr = new UserCurrencyAddresses();
                //     $addr->user_id = $userid;
                //     $addr->currency_id = 2;
                //     $addr->currency_name = 'ETH';
                //     $addr->currency_addr = $val;
                //     $addr->save();
                // }
                // return $val;
            }
        } elseif ($currency == 'BTC') {
            $btc = get_user_details($userid, 'BTC_addr');
            if ($btc == "") {

                $val = create_address('BTC', 'http://127.0.0.1/cron/btc_deposit_process');
                $val = json_decode($val);
                $ins = Users::where('id', $userid)->first();
                $ins->BTC_addr = $val->result->address;
                $ins->save();
                $address = $ins->BTC_addr;
                return $address;
            }
        } elseif ($currency == 'USDT') {
            $usdt = get_user_details($userid, 'USDT_addr');
            if ($usdt == "") {
                $val = create_address('USDT', 'http://127.0.0.1/cron/usdt_deposit_process');
                $val = json_decode($val);
                $ins = Users::where('id', $userid)->first();
                $ins->USDT_addr = $val->result->address;
                $ins->save();
                $address = $ins->USDT_addr;
                return $address;
            }
        }
    } catch (\Exception $e) {
        \Log::error([$e->getMessage(), $e->getLine(), $e->getFile()]);
        return 0;
    }
}

function errorAndDie($error_msg)
{
    \Log::info(['errorAndDie', $error_msg]);
    $cp_debug_email = ['support@gravitas.io','support@xinfin.org','omkar@xinfin.org'];
    if (!empty($cp_debug_email)) {
        $report = 'Error: ' . $error_msg . "\n\n ";
        $report .= "POST Data\n\n";
        foreach ($_POST as $k => $v) {
            $report .= "|$k| = |$v|\n";
        }
        $subject = 'CoinPayments IPN Error';
        sendmail($cp_debug_email, $subject, ['content' => $report]);
    }
    \Log::info(["Error message", $error_msg]);
    die('IPN Error: ' . $error_msg);
}

?>
