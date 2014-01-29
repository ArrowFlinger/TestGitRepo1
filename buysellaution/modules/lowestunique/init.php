<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */
if(!defined('TABLE_PREFIX'))
{
   require_once Kohana::find_file('classes','table_config');  
} 

DEFINE("HASH",'##');
// Define some Module constant
define('BID_HISTORY_LIMIT','5');
//Table Name
define('LOWESTUNIQUE',TABLE_PREFIX.'lowestunique');

// Enabling the Userguide module from my Module


/*
 * Define Module Specific Routes
 */
Route::set('adminlowestunique', 'admin/lowestunique(/<action>)')
	->defaults(array(
		'controller' => 'admin_lowestunique',
		'action'     => 'index',
));
	
Route::set('sitelowestunique', 'site/lowestunique(/<action>(/<id>))')
	->defaults(array(
		'controller' => 'site_lowestunique',
		'action'     => 'index',
));
