<?php defined('SYSPATH') or die('No direct script access.');
/**
* Contains socialnetwork module actions

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Socialnetwork extends Controller_Website
{


	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->url=Request::current();
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		$this->socialnetworkmodel=Model::factory('socialnetwork');	
		$this->commonmodel=Model::factory('commonfunctions');
		$this->twitter=Auth::instance();
		$this->facebook=FB::instance();
		
		//Create a twitter object
		$this->twitter->logged_in();
	}
	
	
	/** CURL GET AND POST**/
	public function curl_function($req_url = "" , $type = "", $arguments =  array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $req_url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		if($type == "POST"){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arguments);
		}
		
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
	
	/*
	*Auto Post Add
	*Add User Details
	*/
	public function action_addfacebook()
	{	      
	
		if($this->socialnetworkmodel->check_totalsocial_account())
		{
			$arr=$this->facebook->get_details_for_social_account();
			if(is_array($arr) && count($arr)>0)
			{
				if($this->socialnetworkmodel->check_fb_account($arr['id']))
				{
					$insert_fb=$this->commonmodel->insert(SOCIAL_ACCOUNT,array('first_name'=>$arr['first_name'],
												'last_name'=>$arr['last_name'],
												//'email_id' =>$arr['email'],
												'image_url'=>$arr['picture'],
												'account_user_id'=>$arr['id'],
												'access_token'=>$arr['access_token'],
												'userid'=>$this->session->get('id'),'type'=>'1','cdate'=>$this->getCurrentTimeStamp));	
					Message::success(__('fb_account_added_success'));
					$this->url->redirect('settings/social_media_account');
				}
				else
				{
					Message::error(__('fb_account_already_exists'));
					$this->url->redirect('settings/social_media_account');
				}			
			}
			else
			{
				$this->facebook->auth();
			}
		}
		else
		{
			$this->url->redirect('settings/social_media_account');
		}
	}
	
	
	
	/*
	*Auto Post User Details
	*Remove Details
	*/
	public function action_deletefacebook()
	{
		$get=Arr::get($_GET,'acc_id');
		$get=isset($get)?$get:1;
		$delete=$this->socialnetworkmodel->delete_fb_account($get);
		if($delete)
		{
			Message::success(__('fb_account_delete_success'));
			$this->url->redirect('settings/social_media_account');
		}
	}
	
	/**
	* Facebook share
	**/
	public function action_facebookshare()
	{
		$this->is_login();
		if($this->auction_userid)
		{
			$share=$this->facebook->publish_fb_share(NULL,array('name' => $this->site_name,
								'message'=>'Test Message',
								'caption' =>$this->title,
								'link' =>URL_BASE,
								'description' =>$this->metadescription,
								'picture' =>IMGPATH.'auction-logo.png',
								'site_name'=>$this->site_name,
								'site_link'=>URL_BASE));
			if($share)
			{
				$check_fbs_users=$this->socialnetworkmodel->check_social_users($this->auction_userid,FACEBOOK);	
				if(count($check_fbs_users)==0)
				{
					$this->commonmodel->insert(SOCIAL_SHARE,array('userid' =>$this->auction_userid,'ip'=>Request::$client_ip,'social_type' =>FACEBOOK,'valid_upto' =>date("Y-m-d H:i:s",time()+86400),'shared_date' =>$this->getCurrentTimeStamp));
					if(Commonfunction::get_bonus_amount(FACEBOOK_SHARE) >0)
					{
						$this->commonmodel->insert(USER_BONUS,array('bonus_type'=>FACEBOOK_SHARE,'bonus_amount'=>Commonfunction::get_bonus_amount(FACEBOOK_SHARE),'userid'=>$this->auction_userid));

						//update on user table
						$old_balance=Commonfunction::get_user_bonus($this->auction_userid);
			
						$c_balance=$old_balance+Commonfunction::get_bonus_amount(FACEBOOK_SHARE);
						$this->commonmodel->update(USERS,array('user_bonus'=>$c_balance),'id',$this->auction_userid);			

						Commonfunction::custom_user_bonus_message(array('custom_msg'=>__('facebook_share_msg',array(":param"=>$this->site_currency." ".Commonfunction::get_bonus_amount(FACEBOOK_SHARE))),'subject'=>__('fshare_message_subject')));
					}
				}			
				Message::success(__('site_facebook_is_shared'));
				$this->url->redirect('users/dashboard');
			}
			else
			{
				Message::error(__('sorry_not_shared'));
				$this->url->redirect('users/dashboard');
			}
			
		}
		exit;
	}

	/**
	* Facebook share

	**/
	public function action_twittershare()
	{
		$this->is_login();
		if($this->auction_userid)
		{
			
			$check_social_users=$this->socialnetworkmodel->check_social_users($this->auction_userid,TWITTER);	
				if(count($check_social_users)==0)
				{
					$this->commonmodel->insert(SOCIAL_SHARE,array('userid' =>$this->auction_userid,'ip'=>Request::$client_ip,'social_type' =>TWITTER,'valid_upto' =>date("Y-m-d H:i:s",time()+86400),'shared_date' =>$this->getCurrentTimeStamp));
					if(Commonfunction::get_bonus_amount(FACEBOOK_SHARE) >0)
					{
						$this->commonmodel->insert(USER_BONUS,array('bonus_type'=>FACEBOOK_SHARE,'bonus_amount'=>Commonfunction::get_bonus_amount(FACEBOOK_SHARE),'userid'=>$this->auction_userid));

						//update on user table
						$old_balance=Commonfunction::get_user_bonus($this->auction_userid);
			
						$c_balance=$old_balance+Commonfunction::get_bonus_amount(FACEBOOK_SHARE);
						$this->commonmodel->update(USERS,array('user_bonus'=>$c_balance),'id',$this->auction_userid);			

						Commonfunction::custom_user_bonus_message(array('custom_msg'=>__('twitter_share_msg',array(":param"=>$this->site_currency." ".Commonfunction::get_bonus_amount(FACEBOOK_SHARE))),'subject'=>__('twitter_message_subject')));
					}
				}	
						
				Message::success(__('site_twitter_is_shared'));
				$url=urlencode(URL_BASE);
				$message_text="Nothing to tweet";
				$this->url->redirect('http://twitter.com/share?url='.$url.'&amp;text='.$message_text);					
		}
		exit;
	}

	/*** TWITTER LOGIN *****/
	public function action_twitterlogin()
	{
		if($this->auction_userid)
		{
			$this->url->redirect('users/');
		}
		else
		{
			try
			{	
				$this->url->redirect($this->twitter->get_auth_link(URL_BASE.'socialnetwork/twitter?method=connect'));
				 
			}
			catch  (Exception $error){ 
				Message::error(__('twitter_error_failed_to_connect'));
				$this->url->redirect('/');
			}
		}
		
	}
	
	public function action_twitter()
	{		
		//Get tokens from the url oauth_token 
		$twit_tokens=arr::extract($_GET,array('oauth_token','oauth_verifier','denied'));
		if(isset($twit_tokens['denied']))
		{
			$this->url->redirect("users/login");	
		}
		else
		{	
			try{
				/* Session set for oauth_token and oauth_token_secret will expire at redirecting then it again get new token and set the token
				to the sessions */
				$this->twitter->force_login($twit_tokens['oauth_token']);
				$method=Arr::extract($_GET,array('method'));
				switch($method['method'])
				{
				case "connect":
				$this->url->redirect('socialnetwork/twitter_confirm?oauth_token='.$twit_tokens['oauth_token'].'&oauth_verifier='.$twit_tokens['oauth_verifier']);
				break;
				default:
						break;
				}
			}
			catch (Exception $error)
			{
				//throw new Exception("Twitter Error - Failed to connect");
				Message::error(__('twitter_error_failed_to_connect'));
				$this->url->redirect('/');
			}
		}
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	/* Twitter Image save from the URL */
	public function url_image_save($img_url="",$file_loc)
	{		
		//Get the Image from the URL
		$img_file=file_get_contents($img_url);	
		
		//Creates the file with the name		
		$file_handler=fopen($file_loc,'w');
		
		//Then write the image to that file and save to the path
		if(fwrite($file_handler,$img_file)==false){
			//something be done here
		}

		//Close the file handler
		fclose($file_handler);
	}

	public function action_twitter_confirm()
	{			
		$twit_tokens=arr::extract($_GET,array('oauth_token','oauth_verifier','denied'));		
		if(isset($twit_tokens['oauth_token']) && isset($twit_tokens['oauth_verifier']))	 
		{			
			$this->user = $this->twitter->get_user();
			$name=$this->user['name'];
			$result=DB::select()->from(USERS)
				->where('username', '=', $this->user['screen_name'])
				->where('status', '=', ACTIVE)
				->execute()
				->as_array();
			if(count($result)==0)
			{
				//Twitter profile image save
				$img_name=uniqid();
				$names=explode(".",basename($this->user['profile_image_url_https']));
				$ext= end($names);
				$img_name=(count($names)>0)?$img_name.$names[0]:$img_name;	
				$file_loc=DOCROOT.USER_IMGPATH.$img_name.".".$ext;	
				$file_loc2=DOCROOT.USER_IMGPATH_THUMB.$img_name.".".$ext;
				$this->url_image_save($this->user['profile_image_url_https'],$file_loc);
				$this->url_image_save($this->user['profile_image_url_https'],$file_loc2);
				//End of twitter save
				$user_details=array('username' => $this->user['screen_name'],'firstname' =>$name,'avatar'=>$img_name.".".$ext);
				$this->session->set('twitter_details',array('username'=>$user_details['username'],
									'firstname' =>$user_details['firstname'],'profileimage'=>$user_details['avatar']));
				$this->url->redirect("socialnetwork/twittersignin");
			}
			else
			{
					$this->commonmodel->insert(USER_LOGIN_DETAILS,array('userid'=>$result[0]['id'],'login_ip' =>Request::$client_ip,'user_agent'=>Request::$user_agent,'last_login' =>$this->getCurrentTimeStamp));
					$this->session->set('auction_userid',$result[0]['id']);
					$this->session->set('auction_username',$this->user['screen_name']);
					$this->session->set('auction_email',$result[0]['email']);
					Message::success(__("logged_in_successfully"));
					$this->session->delete('oauth_token','oauth_token_secret');
					$this->url->redirect("users/");
			}
		}  
		else 	
		{ 
	     		$this->url->redirect("users/login");	
		}		
		exit;
	}

        /*
        *Twitter user Signin
        *Add Key 
        */
	public function action_twittersignin()
	{
		$user_details=$this->session->get('twitter_details');
		if(empty($user_details))
		{
			$this->url->redirect("/");
		}
		$view=View::factory(THEME_FOLDER.'twitter_emailstep')
						->bind('errors',$errors);
		$email=arr::extract($_POST,array('email'));
		
		$validate=$this->socialnetworkmodel->validate_email($email);
		
		$submit=$this->request->post('signin');
		if(isset($submit)){
			
			if($validate->check())
			{
				$password = Commonfunction::randomkey_generator();
				//print_r($user_details);exit;
				if(isset($user_details))
				{
				       		$insert=$this->commonmodel->insert(USERS,array('username'=>$user_details['username'],
										'firstname' =>$user_details['firstname'],
										'email' =>$email['email'],
										'photo' =>Html::chars($user_details['profileimage']),
										'password' => md5($password),
										'login_type' =>"T",
										'referral_id' =>Text::random(),
										'status' => ACTIVE,
										'created_date' =>$this->getCurrentTimeStamp));
					if($insert)
					{
						$this->session->set('auction_userid',$insert[0]);
						$this->session->set('auction_username',$user_details['username']);
						$this->session->set('auction_email',$email['email']);
						$this->session->delete('twitter_details');
						$this->username = array(TO_MAIL => $email['email'], USERNAME => $user_details['username'], PASSWORD =>$password);
						$this->replace_variable = array_merge($this->replace_variables,$this->username);
						//send mail to user by defining common function variables from here
						$mail = Commonfunction::get_email_template_details(TWITTER_SIGNUP,$this->replace_variable,SEND_MAIL_TRUE);
						if($mail == MAIL_SUCCESS)
			   			{
			   				Message::success(__('registration_success_via_social',array(':param'=>'Via Twitter',':param1'=>__('check your mail'))));
							$this->session->delete('oauth_token','oauth_token_secret');
							$this->request->redirect('users/');		
			   			}
			   			else
			   			{	
							Message::success(__('registration_success_via_social',array(':param'=>'Via Twitter',':param1'=>'')));		
							$this->session->delete('oauth_token','oauth_token_secret');
							$this->url->redirect("users/");
						}
					}
				}
				else
				{
					Message::error(__('error_in_registration_via_social',array(':param'=>'Via Twitter')));
					$this->url->redirect("users/signup");
				}
			}
			else
			{
				
				$errors=$validate->errors('errors');
			}
		}
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
		
	//Auto Post
        public function action_twitter_add_autopost_confirm()
        {			
                $twit_tokens=arr::extract($_GET,array('oauth_token','oauth_verifier','denied'));		
                if(isset($twit_tokens['oauth_token']) && isset($twit_tokens['oauth_verifier']))	 
                {			
                $this->user = $this->twitter->get_user();
                //print_r($this->user );exit;
                $name=$this->user['name'];
                $result=$this->commonmodel->select_with_onecondition(USERS,"username='".$this->user['screen_name']."'");
                if(count($result)==0)
                {
                //Twitter profile image save
                $img_name=uniqid();
                $names=explode(".",basename($this->user['profile_image_url_https']));
                $ext= end($names);
                $img_name=(count($names)>0)?$img_name.$names[0]:$img_name;	
                $file_loc=DOCROOT.USER_IMGPATH.$img_name.".".$ext;	
                $file_loc2=DOCROOT.USER_IMGPATH_THUMB.$img_name.".".$ext;
                $this->url_image_save($this->user['profile_image_url_https'],$file_loc);
                $this->url_image_save($this->user['profile_image_url_https'],$file_loc2);
                //End of twitter save
                $user_details=array('username' => $this->user['screen_name'],'firstname' =>$name,'avatar'=>$img_name.".".$ext);
                $this->session->set('twitter_details',array('username'=>$user_details['username'],
			                'firstname' =>$user_details['firstname'],'profileimage'=>$user_details['avatar']));
                $this->url->redirect("socialnetwork/action_autopost_detailstwitter");
                }
                else
                {
                $this->commonmodel->insert(USER_LOGIN_DETAILS,array('userid'=>$result[0]['id'],'login_ip' =>Request::$client_ip,'user_agent'=>Request::$user_agent,'last_login' =>$this->getCurrentTimeStamp));
                $this->session->set('auction_userid',$result[0]['id']);
                $this->session->set('auction_username',$this->user['screen_name']);
                $this->session->set('auction_email',$result[0]['email']);
                Message::success(__("logged_in_successfully"));
                $this->session->delete('oauth_token','oauth_token_secret');
                $this->url->redirect("users/");
                }
                }  
                else 	
                { 
                $this->url->redirect("users/login");	
                }	
                $this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;	
                exit;
        }
	
	public function action_addtwitter()
	{	
		        //$this->twitter->logged_in();
			try{
				$this->url->redirect($this->twitter->get_auth_link(URL_BASE.'socialnetwork/twitter?method=autopost'));
			}
			catch  (Exception $error){
				Message::error(__('twitter_error_failed_to_connect'));
				$this->url->redirect('/');
			}
		
	}
	
	//Auto Post Insert
	public function action_autopost_detailstwitter()
	{
		$user_details=$this->session->get('twitter_details');
		if(empty($user_details))
		{
			$this->url->redirect("/");
		}
		$view=View::factory(THEME_FOLDER.'twitter_emailstep')
						->bind('errors',$errors);
		$email=arr::extract($_POST,array('email'));
		$validate=$this->socialnetworkmodel->validate_email($email);
		$submit=$this->request->post('signin');
		if(isset($submit)){
			if($validate->check())
			{
				$password = Commonfunction::randomkey_generator();
				//print_r($user_details);exit;
				if(isset($user_details))
				{
				
				        //echo $user_details['firstname'];exit;
					$insert=$this->commonmodel->insert(USERS,array('username'=>$user_details['username'],
										'firstname' =>$user_details['firstname'],
										'email' =>$email['email'],
										'photo' =>Html::chars($user_details['profileimage']),
										'password' => md5($password),
										'login_type' =>"T",
										'referral_id' =>Text::random(),
										'status' => ACTIVE,
										'created_date' =>$this->getCurrentTimeStamp));
					if($insert)
					{
						$this->session->set('auction_userid',$insert[0]);
						$this->session->set('auction_username',$user_details['username']);
						$this->session->set('auction_email',$email['email']);
						$this->session->delete('twitter_details');
						$this->username = array(TO_MAIL => $email['email'], USERNAME => $user_details['username'], PASSWORD =>$password);
						$this->replace_variable = array_merge($this->replace_variables,$this->username);
				   		//send mail to user by defining common function variables from here
						$mail = Commonfunction::get_email_template_details(TWITTER_SIGNUP,$this->replace_variable,SEND_MAIL_TRUE);
						if($mail == MAIL_SUCCESS)
			   			{
			   				Message::success(__('registration_success_via_social',array(':param'=>'Via Twitter',':param1'=>__('check your mail'))));
							$this->session->delete('oauth_token','oauth_token_secret');
							$this->request->redirect('users/');		
			   			}else{	
							Message::success(__('registration_success_via_social',array(':param'=>'Via Twitter',':param1'=>'')));		
							$this->session->delete('oauth_token','oauth_token_secret');
							$this->url->redirect("users/");
						}
					}
				}
				else
				{
					Message::error(__('error_in_registration_via_social',array(':param'=>'Via Twitter')));
					$this->url->redirect("users/signup");
				}
			}
			else
			{
				
				$errors=$validate->errors('errors');
			}
		}
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
}	
