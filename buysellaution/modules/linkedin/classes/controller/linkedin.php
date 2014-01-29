<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_linkedin extends Controller {
	
	protected $me;
	
	protected $_ln_wrapper = 'Linkedin';

	public function before()
	{
		
		$this->me = Linkedin::instance()
						->auth($this->_ln_wrapper)
						->me();

		parent::before();
	}

} // End FB