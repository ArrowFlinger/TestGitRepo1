<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */

// Define some Module constant
if(!defined('TABLE_PREFIX'))
{
   require_once Kohana::find_file('classes','table_config');  
} 
//Table Name
DEFINE('RESERVE',TABLE_PREFIX."reserve");
DEFINE('RESERVE_BIDINCREMENTS',TABLE_PREFIX."reserve_bidincrements");
define('RESERVE_BIDHISTORY',TABLE_PREFIX.'reserve_bidhistory');
define('RESERVE_BID_INCREMENTS',TABLE_PREFIX.'reserve_bidincrements');
define('RESERVE_USERS_SETTINGS',TABLE_PREFIX.'reserve_bidsettings');

// Enabling the Userguide module from my Module
//Kohana::modules(Kohana::modules() + array('beginner' => MODPATH.'beginner'));

/*
 * Define Module Specific Routes
 */
Route::set('adminreserve', 'admin/reserve(/<action>)')
	->defaults(array(
		'controller' => 'admin_reserve',
		'action'     => 'index',
));
	
Route::set('sitereserve', 'site/reserve(/<action>)')
	->defaults(array(
		'controller' => 'site_reserve',
		'action'     => 'index',
));
