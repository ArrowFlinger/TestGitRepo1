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
define('CLOCK',TABLE_PREFIX.'clock');
DEFINE('PROCESS',"P");
DEFINE('NOTPROCESS',"NP");
// Enabling the Userguide module from my Module
//Kohana::modules(Kohana::modules() + array('beginner' => MODPATH.'beginner'));

/*
 * Define Module Specific Routes
 */
Route::set('adminclock', 'admin/clock(/<action>)')
	->defaults(array(
		'controller' => 'admin_clock',
		'action'     => 'index',
));
	
Route::set('siteclock', 'site/clock(/<action>(/<id>))')
	->defaults(array(
		'controller' => 'site_clock',
		'action'     => 'index',
));
