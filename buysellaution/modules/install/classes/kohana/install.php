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
	class Kohana_Install {
	
	 /**
	 * @var array configuration settings
	 */
	 protected $_config = array();
	
	 /**
	  * Class Main Constructor Method
	  * This method is executed every time your module class is instantiated.
	  */
	 public function __construct() {
	 
		/**To get selected theme**/
		$selected_theme='pink';
	 
		/**To Define path for selected theme**/
		DEFINE("PATH",'public/'.$selected_theme.'/css/');

	
	
	 }

	
}
