<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Modulename — My own custom module.
 *
 * @package    Commonfunction
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Kohana_Paypal {
	
	/**
	* @var array configuration settings
	*/
	protected $_config = array();

	/**
	* Class Main Constructor Method
	* This method is executed every time your module class is instantiated.
	*/
	public function __construct() 
	{	
		$this->session=Session::instance();
		 
	}
	
	public function structure()
	{	
		//$beginner -> action_process();
		//echo "asdasd";exit;
	}
		

	
}
