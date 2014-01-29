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
define('CASHBACK',TABLE_PREFIX.'cashback');

// Enabling the Userguide module from my Module
//Kohana::modules(Kohana::modules() + array('beginner' => MODPATH.'beginner'));

/*
 * Define Module Specific Routes
 */
Route::set('admincashback', 'admin/cashback(/<action>)')
	->defaults(array(
		'controller' => 'admin_cashback',
		'action'     => 'index',
));
	
Route::set('sitecashback', 'site/cashback(/<action>)')
	->defaults(array(
		'controller' => 'site_cashback',
		'action'     => 'index',
));
