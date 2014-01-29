<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */

DEFINE('BUYNOWAUCTION','auction_buynowauction');
DEFINE('BUYNOW_TRANSACTION_DETAILS','auction_buynow_transaction_details');
DEFINE('PAYPAL_BUYNOW_DETAILS','auction_paypal_buynow_details');
DEFINE('BUY_PRODUCTS','auction_buy_products');	
DEFINE('BUYNOW_ADDTOCART','auction_buynow_addtocart');
DEFINE("PAYMENT_PRODUCT_TITLE","##PRODUCT_TITLE##");
DEFINE("TRANS_LOG_BUYER_PRODUCT_DESC","##BUYERNAME## bought ##PRODUCT_NAME## for ##AMOUNT##, order# ##ORDER_NO##");

// Define some Module constant
//define('MOD_CONSTANTS', 'I am constanting improving...');
// Enabling the Userguide module from my Module
//Kohana::modules(Kohana::modules() + array('buynow' => MODPATH.'buynow'));
/*
 * Define Module Specific Routes
 */
Route::set('adminbuynow', 'admin/buynow(/<action>(/<id>))')
	->defaults(array(
		'controller' => 'admin_buynow',
		'action'     => 'index',
));
	
	
Route::set('sitebuynow', 'site/buynow(/<action>(/<id>))',array('id' => '.*'))
	->defaults(array(
		'controller' => 'site_buynow',
		'action'     => 'index',
));

Route::set('sitebuynowpayment', 'site/buynowpayment(/<action>(/<id>))')
	->defaults(array(
		'controller' => 'site_buynowpayment',
		'action'     => 'index',
));
