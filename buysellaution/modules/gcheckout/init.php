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
DEFINE('GC_TRANSACTIONS',TABLE_PREFIX."gc_transactions"); 