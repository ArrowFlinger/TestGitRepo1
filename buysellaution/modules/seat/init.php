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
DEFINE('SEAT',TABLE_PREFIX."seat");
DEFINE('SEAT_BOOKING',TABLE_PREFIX.'seat_booking');
DEFINE('SEAT_USERS_SETTINGS',TABLE_PREFIX.'seat_bidsettings');

// Enabling the Userguide module from my Module
//Kohana::modules(Kohana::modules() + array('beginner' => MODPATH.'beginner'));

/*
 * Define Module Specific Routes
 */
Route::set('adminseat', 'admin/seat(/<action>)')
	->defaults(array(
		'controller' => 'admin_seat',
		'action'     => 'index',
));
	
Route::set('siteseat', 'site/seat(/<action>(/<id>))')
	->defaults(array(
		'controller' => 'site_seat',
		'action'     => 'index',
));
