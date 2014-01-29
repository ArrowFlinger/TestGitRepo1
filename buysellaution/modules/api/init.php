<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * The Module `init.php` file can perform additional environment setup, including adding routes.
 * Think of it like a mini-bootstrap for your Module :)
 */


 
 
	
Route::set('api', 'api(/<action>(/<id>))')
	->defaults(array(
		'controller' => 'api',
		'action'     => 'index',
));
