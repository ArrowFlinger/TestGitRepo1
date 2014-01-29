<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */

// Define some Module constant

//Table Name
define('BEGINNER','auction_beginner');
// Enabling the Userguide module from my Module
//Kohana::modules(Kohana::modules() + array('beginner' => MODPATH.'beginner'));

/*
 * Define Module Specific Routes
 */
Route::set('adminbeginner', 'admin/beginner(/<action>)')
	->defaults(array(
		'controller' => 'admin_beginner',
		'action'     => 'index',
));
	
Route::set('sitebeginner', 'site/beginner(/<action>)')
	->defaults(array(
		'controller' => 'site_beginner',
		'action'     => 'index',
));
