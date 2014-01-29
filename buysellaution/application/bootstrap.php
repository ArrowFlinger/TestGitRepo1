<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
//date_default_timezone_set('Asia/Calcutta');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

ini_set('display_errors',1);
//setlocale(LC_ALL, 'fi_FI.UTF-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
	
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => FALSE,
	'errors'        => TRUE,
	'profile'       => (Kohana::$environment == Kohana::DEVELOPMENT),
   	'caching'       => (Kohana::$environment == Kohana::PRODUCTION)	
	
));


if (Kohana::$errors)
{
    set_exception_handler(array('Kohana_Exception', 'handler'));
}

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
		//'auth'       			=> MODPATH.'auth',       	// Basic authentication
		'cache'      			=> MODPATH.'cache',      	// Caching with multiple backends
		'codebench'  			=> MODPATH.'codebench',  	// Benchmarking tool
		'message'      			=> MODPATH.'message',
		'database'   			=> MODPATH.'database',   	// Database access
		'pagination' 			=> MODPATH.'pagination', 	// Pagination
		'image'      			=> MODPATH.'image',      	// Image manipulation
		'orm'        			=> MODPATH.'orm',        	// Object Relationship Mapping
		'email'      			=> MODPATH.'email',
		'userguide'  			=> MODPATH.'userguide',  	// User guide and API documentation
		'commonfunction'  		=> MODPATH.'commonfunction', 	// common function added as module
		'auction_beginner'  	=> MODPATH.'beginner', 		// auction function added as module
		'commonfunction'  		=> MODPATH.'commonfunction', 	// common function added as module
		'auction_beginner'  	=> MODPATH.'beginner', 		// auction function added as module	
		'auction_peakauction' 	=> MODPATH.'peakauction', 	// auction function added as module auction function added as module
		'auction_buynow'  		=> MODPATH.'buynow', 
		'captcha'      			=> MODPATH.'captcha', 		// For Captcha
		'facebook'      		=> MODPATH.'kohana-facebook', 	// For facebook
		'twitter'      			=> MODPATH.'kohana-twitter', 	// For twitter
		'twitterAuth' 			=> MODPATH.'kohana-twitter-auth',
		'linkedin'      		=> MODPATH.'linkedin',	
		'twitterAuth' 			=> MODPATH.'kohana-twitter-auth',
		'install' 				=> MODPATH.'install',		
		'ccavenue' 				=> MODPATH.'ccavenue',		//for Nauction ccavenue payment installation
		'paypal' 				=> MODPATH.'paypal',		//for Nauction paypal payment installation
		'mercadopago'        	=> MODPATH.'mercadopago',   	//for Nauction mercadopago payment installation
		'sms' 					=> MODPATH.'sms',		//for Nauction SMS gateway installation
        'logs' 					=> MODPATH.'logviewer'		//for Nauction SMS gateway installation
	));

 /* Modules Writes */ 
Kohana::modules(Kohana::modules() + array('auction_lowestunique' => MODPATH.'lowestunique')); 
Kohana::modules(Kohana::modules() + array('gcheckout' => MODPATH.'gcheckout')); 
Kohana::modules(Kohana::modules() + array('auction_clock' => MODPATH.'clock')); 
Kohana::modules(Kohana::modules() + array('auction_cashback' => MODPATH.'cashback')); 
Kohana::modules(Kohana::modules() + array('authorize' => MODPATH.'authorize')); 
Kohana::modules(Kohana::modules() + array('auction_seat' => MODPATH.'seat')); 
Kohana::modules(Kohana::modules() + array('auction_reserve' => MODPATH.'reserve')); 
Kohana::modules(Kohana::modules() + array('auction_highestunique' => MODPATH.'highestunique'));
Kohana::modules(Kohana::modules() + array('auction_scratch' => MODPATH.'scratch'));
Kohana::modules(Kohana::modules() + array('auction_pennyauction' => MODPATH.'pennyauction'));
Kohana::modules(Kohana::modules() + array('api' => MODPATH.'api'));
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */

Route::set('error', 'error/<action>(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
    ->defaults(array(
        'controller' => 'error',
        'action'     => '404',
));

Route::set('default', '(<controller>(/<action>(/<id>/<method>)))')
	->defaults(array(
		'controller' => 'auctions',
		'action'     => 'index',
		'method' => NULL,
	));

Route::set('custom', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'admin',
		'action'     => 'index',
	));	
  
