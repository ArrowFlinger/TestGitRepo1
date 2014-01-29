<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contains social network Model queries
 
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Socialnetwork extends Model 
{
	/**
	 * ****__construct()****
	 *
	 * setting up session variables
	 */
        public function __construct()
        {
                $this->session = Session::instance();
                $this->username = $this->session->get("username");
                $this->admin_session_id = $this->session->get("id");
        }
        
        //Facebook Account 
        public function check_fb_account($fb_userid)
	{
		$query=DB::select()->from(SOCIAL_ACCOUNT)->where('account_user_id','=',$fb_userid)->execute();
		return count($query)>0?FALSE:TRUE;	
	
	}
	
	//Twitter Account
	
	public function check_tw_account($tw_userid)
	{
	
		$query=DB::select()->from(SOCIAL_ACCOUNT)->where('account_user_id','=',$tw_userid)->execute();
		return count($query)>0?FALSE:TRUE;	
	
	}

        //Select facebook account 
	public function select_fb_account($type=1,$need_count=FALSE)
	{
		$query=DB::select()->from(SOCIAL_ACCOUNT)->where('type','=',$type)->execute();
		return $need_count?count($query):$query;	
	
	}

        //Total Social Account 
	public function check_totalsocial_account()
	{
		$query=DB::select()->from(SOCIAL_ACCOUNT)->execute();
		return count($query)>=1?FALSE:TRUE;	
	
	}
	
	//Delete facebook account
	public function delete_fb_account($fb_userid)
	{
		$query=DB::delete(SOCIAL_ACCOUNT)->where('id','=',$fb_userid)->execute();
		return $query;	
	
	}

        // Social Share user 
	public function check_social_users($userid,$social_type)
	{
		$query=DB::select()->from(SOCIAL_SHARE)
				->where('userid','=',$userid)
				->and_where('social_type','=',$social_type)
				->execute();
		return $query;
	}

	/**
	* Check Email exists or not for server side validation
	* @return TRUE or FALSE
	*/	
	public static function unique_email($email)
    	{
		return ! DB::select(array(DB::expr('COUNT(email)'), 'total'))
		    			->from(USERS)
		    			->where('email', '=', $email)
					->and_where('status','=',DELETED_STATUS)
		    			->execute()
		    			->get('total');
    	}
		
	/**
	* Validation rule for fields in forgot password
	*/
	public function validate_email($arr)
	{
		return Validation::factory($arr)
					->rule('email','not_empty')
					->rule('email','max_length',array(':value','50'))
					->rule('email', 'Model_Users::check_label_not_empty',array(":value",__('enter_email')))
					->rule('email','email_domain')
					->rule('email','Model_Users::unique_email');
	}
        
}       
