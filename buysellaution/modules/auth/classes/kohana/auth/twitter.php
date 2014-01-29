<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * TwitterAPI OAuth driver.
 *
 *
 * @package    Auth
 * @author     Kohana Team
 * @copyright  (c) 2007-2008 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
class Kohana_Auth_Twitter extends Auth {

	public $twitterObj;
	private $twit_conf;
	
	/**
	 * Constructor loads epitwitter config.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->twit_conf = Kohana::$config->load('epitwitter');
	}
	
	/**
	 * Checks tokens, create TwitterObject from EpiTwitter Library.
	 *
	 * @param   string   role name -- unused
	 * @return  boolean
	 */
	public function logged_in($role = NULL)
	{
		$status = FALSE;		

		// Get the tokens from the session
		$oauth_token = $this->session->get('oauth_token');
		$oauth_token_secret = $this->session->get('oauth_token_secret');

		if ($oauth_token and $oauth_token_secret)
		{
			// Everything is okay so far
			$status = TRUE;
			$this->twitterObj = new EpiTwitter($this->twit_conf['consumer_key'], $this->twit_conf['consumer_secret'],
				$oauth_token, $oauth_token_secret);
		}
		else
			$this->twitterObj = new EpiTwitter($this->twit_conf['consumer_key'], $this->twit_conf['consumer_secret']);
		return $status;
	}
	
	/**
	 * Get userdata from twitter account.
	 *
	 * @return  object
	 */
	public function get_user()
	{		

		$twitterInfo = $this->twitterObj->get_accountVerify_credentials();
		$twitterInfo->response;
		return $twitterInfo;
	}
	
	/**
	 * Get link to twitter oauth page
	 *
	 * @return  string
	 */
	public function get_auth_link()
	{
		return $this->twitterObj->getAuthorizationUrl();
	}

	/**
	 * Logs a user in. -- unused
	 *
	 * @param   string   username
	 * @param   string   password
	 * @param   boolean  enable auto-login
	 * @return  boolean
	 */
	public function _login($get_token, $password, $remember)
	{
		force_login($get_token);
	}

	/**
	 * Log in with token from twitter oauth page, set specified oauth tokens
	 *
	 * @param   mixed    username
	 * @return  boolean
	 */
	public function force_login($get_token)
	{
		if(isset($get_token))
		{
			$twitterObj = new EpiTwitter($this->twit_conf['consumer_key'], $this->twit_conf['consumer_secret']);
			$twitterObj->setToken($get_token);
			$token = $twitterObj->getAccessToken();
			$this->session->set('oauth_token', $token->oauth_token);
			$this->session->set('oauth_token_secret', $token->oauth_token_secret);	
			
			$_SESSION['auth_forced'] = TRUE;
			return TRUE;
			// Run the standard completion
			//$this->complete_login($user);
		}
	}

	

	/**
	 * Log a user out and remove any auto-login cookies.
	 *
	 * @param   boolean  completely destroy the session
	 * @param	boolean  remove all tokens for user
	 * @return  boolean
	 */
	public function logout($destroy = FALSE, $logout_all = FALSE)
	{
		return parent::logout($destroy);
	}

	/**
	 * Get the stored password for a username. -- unused
	 *
	 * @param   mixed   username
	 * @return  string
	 */
	public function password($user)
	{
		return FALSE;
	}


	

} // End Auth_Twitter_Driver
