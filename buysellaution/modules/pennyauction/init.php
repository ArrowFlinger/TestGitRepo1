<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */

// Define some Module constant

//Table Name
define('PENNYAUCTION','auction_pennyauction');

// Enabling the Userguide module from my Module
//Kohana::modules(Kohana::modules() + array('beginner' => MODPATH.'beginner'));

/*
 * Define Module Specific Routes
 */
Route::set('adminpennyauction', 'admin/pennyauction(/<action>)')
	->defaults(array(
		'controller' => 'admin_pennyauction',
		'action'     => 'index',
));
	
Route::set('sitepennyauction', 'site/pennyauction(/<action>)')
	->defaults(array(
		'controller' => 'site_pennyauction',
		'action'     => 'index',
));
