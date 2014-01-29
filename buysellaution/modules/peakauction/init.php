<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */

// Define some Module constant

//Table Name
define('PEAK_AUCTION','auction_peakauction');
// Enabling the Userguide module from my Module


/*
 * Define Module Specific Routes
 */
Route::set('adminpeakauction', 'admin/peakauction(/<action>)')
	->defaults(array(
		'controller' => 'admin_peakauction',
		'action'     => 'index',
));
	
Route::set('sitepeakauction', 'site/peakauction(/<action>)')
	->defaults(array(
		'controller' => 'site_peakauction',
		'action'     => 'index',
));
