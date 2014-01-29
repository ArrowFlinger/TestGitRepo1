<?php defined('SYSPATH') or die('No direct script access.');

if( !class_exists('Linkedin') )
{
	require_once Kohana::find_file('vendor','linkedin/oauth');
	require_once Kohana::find_file('vendor','linkedin/linkedin.class');
}

/**
 *
 * @package    Kohana_Linkedin
 * @copyright  Ndot.in
 *
 * Copyright (c) 2011 FamilyLink.com
 * 
 * Permission to use, copy, modify, and/or distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 **/
abstract class Kohana_Linkedin {
	
	/**
	 * @var  Kohana_Linkedin  Singleton static instance
	 */
	protected static $_instance;
	
	/**
	 * @var  Facebook  Instance
	 */
	protected $_facebook;

	
	/**
	 * @var  array  User information
	 */
	protected $_me;
	
	/**
	 * @var  array  What fields to query about the user
	 */
	protected $_fields = array();
	
	/**
	 * @var  boolean  Whether user has been authed
	 */
	protected $_authed = FALSE;
	
	/**
	 * @var  string  The class name to use for the facebook sdk. Can be used with a wrapper
	 */
	protected $_class;
	
	/**
	 * Authorizes the user
	 *
	 * @return  self
	 */
	public function auth($class = 'linkedin_core')
	{
		$this->loadconfig =Kohana::$config->load('linkedin');
		if( !$this->_class )
		{
			$this->_class = $class;
		}

		if( !$this->_authed && $this->_class )
		{
			// Auth method has been called
			$this->_authed = TRUE;
			
			// Instantiate new Facebook object
			$this->_linkedin = new $this->_class();
		
			// Attempt to query information about the user
			try 
			{
				$this->connect();
				$this->_me = $this->get_auth($this->loadconfig);
			}

			// If failed attempt, redirect to login page (Auth)
			catch(Exception $error) 
			{
				echo $error;exit;
			}				
			
		}
		
		return $this;
	}
	
	/**
	 * Gets users data from Facebook
	 *
	 * @return  array
	 */
	protected function connect()
	{
		return $this->_linkedin->init();
	}
	
	protected function XMLconvertToArray($xmlobj)
	{
		return json_decode( json_encode($xmlobj),1);
	}


	public function get_auth($verifier="")
	{
		$this->loadconfig =Kohana::$config->load('linkedin');
		$this->_linkedin = new linkedin_core();
		$session = Session::instance();
		if(!isset($_SESSION['laccess']))
		{
			$this->_linkedin->get_access_token($verifier);
		}
		$this->_linkedin->get_logged_in_users_profile($this->loadconfig);
		$details =array();
		$datas=array('firstname'=>$this->XMLconvertToArray($this->_linkedin->get_firstname()),
				'id' => $this->XMLconvertToArray($this->_linkedin->get_member_token()),
				'lastname' =>$this->XMLconvertToArray($this->_linkedin->get_lastname()),
				'picture' =>$this->XMLconvertToArray($this->_linkedin->get_picture_url()),  
				'public_url' =>$this->XMLconvertToArray($this->_linkedin->get_public_profile_url()),
				'current_status' =>$this->XMLconvertToArray($this->_linkedin->get_current_status()), 
				'location' =>$this->XMLconvertToArray($this->_linkedin->get_location_name()),     
				'country_code' =>$this->XMLconvertToArray($this->_linkedin->get_location_country_code()),  
				'distance' =>$this->XMLconvertToArray($this->_linkedin->get_distance()),  
				'industry' =>$this->XMLconvertToArray($this->_linkedin->get_industry()),
				'summary' =>$this->XMLconvertToArray($this->_linkedin->get_summary()),
				);
		foreach($datas as $key => $data){
			if(is_array($data) && array_key_exists(0,$data))
			{
				$details[$key] = $data[0];
			}else {$details[$key] = "";}
		}
		return $details;
	}
	/**
	 * Returns information about current user
	 *
	 * @returns  array  User information
	*/
	public function me()
	{
		if(!$this->_authed)
		{
			return $this->_me;
		}
	
	}
	

	/**
	 * Returns instance of Kohana_Linkedin
	 *
	 * @returns  object  Kohana_Linkedin
	*/
	public static function instance()
	{
		if(!isset(self::$_instance))
		{
			self::$_instance = new Linkedin();
		}
		
		return self::$_instance;
	}
	
	

}
