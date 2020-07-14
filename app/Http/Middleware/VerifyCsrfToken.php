<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {
	/**
	 * The URIs that should be excluded from CSRF verification.
	 *
	 * @var array
	 */
	protected $except = [
		//
		'ajax/exchange_chart', 'ajax/verify_otp', 'ajax/registerotp', 'ajax/refresh_capcha', 'ajax/address_validation', 'ajax/limit_balance', 'ajax/get_instant_buy_form', 'ajax/get_instant_sell_form','ajax/get_currency_address', 'cron/eth_deposit_process',
	];
}
