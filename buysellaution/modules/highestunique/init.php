<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */



if(!defined('TABLE_PREFIX'))
{
   require_once Kohana::find_file('classes','table_config');  
} 
//Table Name
define('HIGHESTUNIQUE',TABLE_PREFIX.'highestunique');

// Enabling the Userguide module from my Module


/*
 * Define Module Specific Routes
 */
Route::set('adminhighestunique', 'admin/highestunique(/<action>)')
	->defaults(array(
		'controller' => 'admin_highestunique',
		'action'     => 'index',
));
	
Route::set('sitehighestunique', 'site/highestunique(/<action>(/<id>))')
	->defaults(array(
		'controller' => 'site_highestunique',
		'action'     => 'index',
));
