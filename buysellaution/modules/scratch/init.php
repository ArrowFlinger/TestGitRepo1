<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */

// Define some Module constant

// Define some Module constant
if(!defined('TABLE_PREFIX'))
{
   require_once Kohana::find_file('classes','table_config');  
} 

//Table Name
define('SCRATCHAUCTION',TABLE_PREFIX.'scratch');
define('SCRATCHBIDHISTORY',TABLE_PREFIX.'scratch_bidhistory');
define('SCRATCH_PRODUCT',TABLE_PREFIX."scratch_products");
define('SCRATCH_USERS_SETTINGS',TABLE_PREFIX.'scratch_bidsettings');
// Enabling the Userguide module from my Module
/*
 * Define Module Specific Routes
 */
Route::set('adminscratch', 'admin/scratch(/<action>)')
	->defaults(array(
		'controller' => 'admin_scratch',
		'action'     => 'index',
));
	

Route::set('sitescratch', 'site/scratch(/<action>(/<id>))')
	->defaults(array(
		'controller' => 'site_scratch',
		'action'     => 'index',
));
