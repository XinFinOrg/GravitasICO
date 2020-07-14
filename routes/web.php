<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
	return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => ['web']], function () {

	Route::get('/', 'SiteadminController@index');
	Route::post('/', 'SiteadminController@index');
	Route::get('/logout', 'SiteadminController@logout');
	Route::get('/home', 'SiteadminController@home');
	Route::get('/profile', 'SiteadminController@profile');
	Route::post('/profile', 'SiteadminController@profile');
	Route::get('/site_settings', 'SiteadminController@site_settings');
	Route::post('/site_settings', 'SiteadminController@site_settings');
	Route::get('/test', 'SiteadminController@test');
	Route::post('/checkpattern', 'SiteadminController@checkpattern');
	Route::get('/change_pattern', 'SiteadminController@change_pattern');
	Route::post('/set_pattern', 'SiteadminController@set_pattern');
	Route::get('/cms', 'SiteadminController@cms');
	Route::get('/updatecms/{id}', 'SiteadminController@updatecms');
	Route::post('/updatecms/{id}', 'SiteadminController@updatecms');
	Route::get('/users', 'SiteadminController@users');
	Route::get('/userbalance', 'SiteadminController@userbalance');
    Route::get('/users_opening_balance', 'SiteadminController@users_opening_balance');
    Route::get('/users_closing_balance', 'SiteadminController@users_closing_balance');
    Route::post('/update_user_balance', 'SiteadminController@update_userbal');
	Route::get('/mail_template', 'SiteadminController@mail_template');
	Route::get('/contact_query', 'SiteadminController@contact_query');
	Route::get('/view_enquiry/{id}', 'SiteadminController@view_enquiry');
	Route::post('/view_enquiry/{id}', 'SiteadminController@view_enquiry');
	Route::get('/update_template/{id}', 'SiteadminController@update_template');
	Route::post('/update_template/{id}', 'SiteadminController@update_template');
	Route::get('/transactions', 'SiteadminController@transactions');
	Route::get('/profit', 'SiteadminController@profit');
	Route::get('/kyc_users', 'SiteadminController@kyc_users');
	Route::get('/status_users/{id}', 'SiteadminController@status_users');
	Route::get('/view_users/{id}', 'SiteadminController@view_users');
	Route::get('/view_kyc/{id}', 'SiteadminController@view_kyc');
	Route::post('/view_kyc/{id}', 'SiteadminController@view_kyc');
	Route::get('/forgot', 'SiteadminController@forgot');
	Route::post('/forgot', 'SiteadminController@forgot');
	Route::get('/trade_history', 'SiteadminController@trade_history');
    Route::get('/swap_history', 'SiteadminController@swap_history');
    Route::get('/create_ripple_tag', 'SiteadminController@create_riple_xrp_tag');

    Route::get('/cancel_trade/{id}', 'SiteadminController@cancel_trade');
    Route::get('/delete_transaction/{id}', 'SiteadminController@delete_trans');
    Route::get('/pending_history', 'SiteadminController@pending_history');
	Route::get('/deposit_history', 'SiteadminController@deposit_history');
	Route::get('/withdraw_history', 'SiteadminController@withdraw_history');
    Route::get('/updated_history', 'SiteadminController@updated_history');
	Route::get('/market_price', 'SiteadminController@market_price');
	Route::post('/market_price', 'SiteadminController@market_price');
	Route::get('/allprice', 'SiteadminController@all_price');
	Route::get('/meta_content', 'SiteadminController@meta_content');
	Route::get('/update_meta/{id}', 'SiteadminController@update_meta');
	Route::post('/update_meta/{id}', 'SiteadminController@update_meta');
	Route::get('/trading_fee/{currency?}', 'SiteadminController@trading_fee');
	Route::post('/trading_fee/{currency?}', 'SiteadminController@trading_fee');
	Route::get('/fee_config', 'SiteadminController@fee_config');
	Route::post('/fee_config', 'SiteadminController@fee_config');
	Route::get('/user_activity', 'SiteadminController@user_activity');
	Route::get('/whitelists', 'SiteadminController@whitelists');
	Route::post('/whitelists', 'SiteadminController@whitelists');
	Route::get('/delete_whitelist/{id}', 'SiteadminController@delete_whitelist');
	Route::get('/confirm_transfer/{id}', 'SiteadminController@confirm_transfer');
	Route::post('/generate_otp', 'SiteadminController@generate_otp');
	Route::post('/confirm_transfer/{id}', 'SiteadminController@confirm_transfer');
	Route::get('/view_transactions/{trans_id}', 'SiteadminController@view_transactions');
    Route::get('/tradeadmin', 'SiteadminController@tradeadmin');
    Route::get('/total_userbalance', 'SiteadminController@getTotal_Usersbalance');
	Route::get('/testmail', 'SiteadminController@testmail');
    Route::get('/valid_balance', 'SiteadminController@validate_XDC_bal');
    Route::get('/users_balance_validation', 'SiteadminController@users_balance_validation');
    Route::get('/validate_eth_block', 'SiteadminController@validate_eth_block');
    Route::get('/trade_details/{id}', 'SiteadminController@user_XDC_Sell');
    Route::get('/explorer_xdc', 'SiteadminController@users_explorer_validation');
    Route::get('/generate_eth/{id}', 'SiteadminController@generate_eth');
    Route::get('/xrp_withdraw/{id}', 'SiteadminController@xrp_withdraw');
    Route::get('/xrp_create', 'SiteadminController@adminxrpaddress');
    Route::get('/create_email_verification/{id}', 'SiteadminController@create_email_verification');
    Route::get('/user_transaction_details', 'SiteadminController@user_transaction_details');
    Route::get('/ftp', 'SiteadminController@ftp_test');
    Route::get('/ico_history', 'SiteadminController@ico_history');
    Route::get('/cancel_pending_ico_order/{id}', 'SiteadminController@Cancel_pending_ico_order');

    Route::get('/set_trade_cancel', 'SiteadminController@set_trade_cancel');
    Route::POST('/update_ico_price', 'SiteadminController@update_ico_price');

    Route::get('/create_bch_all', 'SiteadminController@create_bch_all');
    Route::get('/confirmation','SiteadminController@confirm');
    Route::get('/cancel_multiple/{id}','SiteadminController@cancel_multiple');

});

Route::group(['prefix' => 'auto', 'middleware' => 'web'], function ()
{
    Route::get('/trade/{pair}', 'AutoTradeController@main');

});

Route::group(['prefix' => '','middleware' => ['web']], function () {
	Route::get('/', 'UserController@login');
	Route::get('/register', 'UserController@register');
	Route::get('/test', 'UserController@test');
	Route::post('/register', 'UserController@register');
	Route::get('/userverification/{time}', 'UserController@userverification');
	Route::get('/login', 'UserController@login');
	Route::post('/login', 'UserController@login');   
	Route::get('/forgotpass', 'UserController@forgotpass');
	Route::post('/forgotpass', 'UserController@forgotpass');
	Route::get('/resetpassword/{code}', 'UserController@resetpassword');
	Route::post('/resetpassword/{code}', 'UserController@resetpassword');
	Route::get('/dashboard', 'UserController@dashboard');
	Route::get('/distribution', 'UserController@distribution');
	Route::get('/documents', 'UserController@documents');
	Route::get('/contact_us', 'UserController@contact_us');
	Route::post('/contact_us', 'UserController@contact_us');
	Route::get('/kyc', 'UserController@kyc_details');
	Route::POST('/kyc', 'UserController@kyc_details');
	Route::post('/document_submission', 'UserController@document_submission');
	Route::get('/wallet', 'UserController@wallet');
    Route::get('/wallets', 'UserController@wallets');
	Route::get('/ico', 'ICOController@index');
	Route::POST('/ico', 'ICOController@index');
	Route::get('/sessionlogout', 'UserController@sessionlogout');
	Route::get('/logout', 'UserController@logout');
	Route::get('/transactions', 'UserController@ico_history');

	
	//may be optional
	Route::get('/profile', 'UserController@profile');
	Route::post('/profile', 'UserController@profile');

	Route::get('/deposit/{currency?}', 'UserController@deposit');
	Route::get('/transfercrypto/{currency?}', 'UserController@transfercrypto');
	Route::post('/transferverify/{currency}', 'UserController@transferverify');
	Route::get('/deposit_history', 'UserController@deposit_history');
	Route::get('/wallet_history/{currency?}', 'UserController@wallet_history');

	Route::get('/getotp', 'UserController@getotp');
    Route::get('/api', 'TickerController@getapi');
    Route::get('/checkuser', 'UserController@decryptnumber');
    Route::get('/decryptaddress', 'UserController@decryptAddress');
    Route::get('/owndecryptaddress', 'UserController@owndecryptAddress');
    Route::get('/encrypting', 'UserController@encryptdetails');
    Route::get('/datetime', 'UserController@currentDateTime');
    Route::get('/ico_history', 'TradeController@ico_history');
    
    
    Route::get('/bounty', 'UserController@bounty');
    Route::POST('/buyico', 'ICOController@ico_buy');
    Route::get('/create_eth_address', 'UserController@create_eth_address');
 
	
    Route::POST('/ico_buy', 'ICOController@ico_buy1');

    Route::get('/sitemap.xml','UserController@sitemap');
    Route::get('/walletid/check','UserController@eth_checkdepositalready');
    
});

// Ajax
Route::group(['prefix' => 'ajax', 'middleware' => 'web'], function () {

	Route::get('/', 'AjaxController@index');
    Route::get('/get_sold_amount', 'AjaxController@get_sold_amount');
	Route::post('/checkemail', 'AjaxController@checkemail');
	Route::post('/registerotp', 'AjaxController@registerotp');
	Route::post('/verify_otp', 'AjaxController@verify_otp');
	Route::post('/checkphone', 'AjaxController@checkphone');
	Route::post('/refresh_capcha', 'AjaxController@refresh_capcha');
	Route::post('/checkoldpass', 'AjaxController@checkoldpass');
	Route::post('/verifyotp', 'AjaxController@verifyotp');
	Route::post('/limit_balance', 'AjaxController@limit_balance');
	Route::post('/generate_otp', 'AjaxController@generate_otp');
    Route::post('/generate_email_otp', 'AjaxController@generate_email_otp');
	Route::post('/address_validation', 'AjaxController@address_validation');
	Route::get('/exchange_chart/{pair?}', 'AjaxController@exchange_chart');
	Route::get('/get_instant_buy_form/{pair?}', 'AjaxController@get_instant_buy_form');
	Route::get('/get_instant_sell_form/{pair?}', 'AjaxController@get_instant_sell_form');
	Route::get('/get_limit_buy_form/{pair?}', 'AjaxController@get_limit_buy_form');
	Route::get('/get_limit_sell_form/{pair?}', 'AjaxController@get_limit_sell_form');
	Route::get('/get_stop_buy_form/{pair?}', 'AjaxController@get_stop_buy_form');
	Route::get('/get_stop_sell_form/{pair?}', 'AjaxController@get_stop_sell_form');
	Route::get('/get_buy_tradeorders/{pair?}', 'AjaxController@get_buy_tradeorders');
	Route::get('/get_sell_tradeorders/{pair?}', 'AjaxController@get_sell_tradeorders');
	Route::get('/get_estimatme_usdbalance', 'AjaxController@get_estimatme_usdbalance');
    Route::get('/otp_test', 'AjaxController@otp_test');
    Route::get('/otp_call/{id}', 'AjaxController@otp_call');

    Route::get('/user_verification/{id}', 'AjaxController@user_verification');
    Route::get('/get_usd_price', 'AjaxController@get_ico_usd_price');
    Route::get('/XDCdeposit/{id}','AjaxController@XDCdeposit');
    Route::get('/btc_deposit_process_user/{user_addr}','AjaxController@btc_deposit_process_user');

	Route::post('/get_currency_address', 'AjaxController@get_currency_address');
});

// Cron update

Route::group(['prefix' => 'cron', 'middleware' => 'web'], function () {

	Route::get('/', 'CronController@index');
	Route::get('/update_prices', 'CronController@update_prices');
	Route::get('/eth_deposit_process', 'CronController@eth_deposit_process');
	Route::post('/eth_deposit_process', 'CronController@eth_deposit_process');
    Route::get('/eth_deposit_process_user/{id}', 'CronController@eth_deposit_process_user');
    Route::get('/xdce_deposit_process_user/{id}', 'CronController@xdce_deposit_process_user');
    Route::get('/xdce_deposit_process', 'CronController@xdce_deposit_process');

    Route::get('/pending_ico_order', 'ICOController@pending_ico_order');
    Route::get('/old_pending_cancel', 'ICOController@old_pending_cancel');

    Route::get('/pending_ico_order', 'ICOController@pending_ico_order');
    Route::get('/bch_deposit_process', 'CronController@bch_deposit_process');
    Route::get('/eth_deposit_console_user', 'CronController@eth_deposit_console_user');
	Route::post('/btc_deposit_process', 'CronController@btc_deposit_process');
	Route::post('/usdt_deposit_process', 'CronController@btc_deposit_process');
	Route::get('/ripple_deposit_process', 'CronController@ripple_deposit_process');
    Route::get('/xdc_deposit_process', 'CronController@xdc_deposit_process');
	Route::get('/xrp_deposit_process', 'CronController@xrp_deposit_process');
	Route::get('/opening_balance','CronController@opening_balance');
	Route::get('/closing_balance','CronController@closing_balance');
    Route::get('/duplicate_record','CronController@duplicate_record');
    Route::get('/btc_records','CronController@btc_records');
    Route::get('/blocksync','CronController@last_mined_block_difference');
    Route::get('/koinok','CronController@koinok');



});

// Admin wallet

Route::group(['prefix' => 'walletjey', 'middleware' => 'web'], function () {

	Route::get('/', 'AdminwalletController@index');
	Route::post('/', 'AdminwalletController@index');
	Route::post('/checkpattern', 'AdminwalletController@checkpattern');
	Route::get('/home', 'AdminwalletController@home');
	Route::get('/logout', 'AdminwalletController@logout');
	Route::get('/walletdeposit/{currency?}', 'AdminwalletController@walletdeposit');
	Route::get('/walletwithdraw/{currency?}', 'AdminwalletController@walletwithdraw');
	Route::post('/walletwithdraw/{currency?}', 'AdminwalletController@walletwithdraw');
	Route::post('/generate_otp', 'AdminwalletController@generate_otp');
	Route::post('/profile', 'AdminwalletController@profile');
	Route::get('/profile', 'AdminwalletController@profile');
	Route::get('/change_pattern', 'AdminwalletController@change_pattern');
	Route::post('/set_pattern', 'AdminwalletController@set_pattern');
	Route::get('/profit', 'AdminwalletController@profit');

});

//ticker

Route::group(['prefix' => 'ticker', 'middleware' => 'web'], function () {

	Route::get('/', 'TickerController@index');
	Route::get('/getxmlres/{str}', 'TickerController@getxmlres');
	Route::get('/info/{pair?}', 'TickerController@info');
    Route::get('/xdcprice', 'TickerController@XDCprice');
    Route::get('/history/{pair?}', 'TickerController@history');
    Route::get('/exchanges', 'TickerController@externalapis');
});


