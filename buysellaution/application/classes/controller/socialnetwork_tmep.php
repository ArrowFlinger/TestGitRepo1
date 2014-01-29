<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains auctions module actions
 *
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Socialnetwork extends Controller_Website {
		
	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
	public function __construct(Request $request,Response $response)
	{
		$this->url=Request::current();
		$this->socialnetworkmodel=Model::factory('socialnetwork');	
		 //For facebook connect	
		DEFINE("FB_APP_ID",'276940609021930');
		DEFINE("FB_APP_SECRET",'077a8a5768953d2d7bde2182c064cb6f');
	}
	
	
	public function get_details_for_social_account()
	{		
		FB::instance()->auth();
		$user_details = FB::instance()->me();
		$add['picture']="https://graph.facebook.com/".$user_details['id']."/picture";
		return Arr::merge($user_details,$add);
		
	}
    	public function action_addfacebook()
	{
		$arr=$this->get_details_for_social_account();
		if(is_array($arr) && count($arr)>0)
		{
			if($this->socialnetworkmodel->check_fb_account($arr['id']))
			{
				$insert_fb=$this->commonmodel->insert(SOCIAL_ACCOUNT,array('first_name'=>$arr['first_name'],
											'last_name'=>$arr['last_name'],
											'image_url'=>$arr['picture'],
											'account_user_id'=>$arr['id'],
											'access_token'=>"",
											'userid'=>$this->session->get('userid'),'type'=>'1'));	
				Message::success(__('fb_account_added_success'));
			}
			else
			{
				Message::error(__('fb_account_already_exists'));
			}			
		}
		else
		{
			FB::instance()->auth();
		}	
	}
}
?>
