<?php defined('SYSPATH') or die('No direct script access.');

/*

* Contains Settings(Manage Site settings,meta settings, user Settings,Product Settings) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Settings extends Model
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
        }

        /**To Get Current TimeStamp**/
	public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}
	
       
    
        /** Add Site Setting **/
        public function add_settings_site($post_val,$validator)
	{
					
					$insert_id = DB::insert(SITE, array('site_name','site_slogan','site_version','site_language','site_paypal_currency_code','site_paypal_currency','contact_email','common_email_from','common_email_to','date_format_display','time_format_display','date_time_format_display','date_format_tooltip','time_format_tooltip','date_time_tooltip','date_time_highlight_tooltip','site_tracker','country_time_zone','theme'))
	            			->values(array($post_val['site_name'],$post_val['site_slogan'],$post_val['site_version'],$post_val['site_language'],$post_val['site_paypal_currency_code'],$post_val['site_paypal_currency'],$post_val['contact_email'],$post_val['comman_email_from'],$post_val['comman_email_to'],$post_val['date_format_display'],$post_val['time_format_display'],$post_val['date_time_format_display'],$post_val['date_format_tooltip'],$post_val['time_format_tooltip'],$post_val['date_time_tooltip'],$post_val['date_time_highlight_tooltip'],$post_val['site_tracker'],$post_val['country_time_zone'],$post_val['theme']))
		            			->execute(); 					
					return $insert_id[1];			      
       } 
        
        /** Get Site Settings **/
        public function get_site() 
        {
                $sql = 'SELECT * FROM '.SITE.' WHERE id='.$id;                      
                return Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array();                
        } 

        /**Site Settings **/
        public function site_settings($id="")
        {
                 $result=DB::select()->from(SITE)
			     ->where('id', '!=', $id)
			     ->execute()	
			     ->as_array();
                return  $result;
        }
        
        /**Edit Site Settings  Validate**/
         public function validate_edit_settings_site($arr) 
	{
			$arr['site_name'] = trim($arr['site_name']);
			$arr['site_slogan'] = trim($arr['site_slogan']);
			$arr['site_version'] = trim($arr['site_version']);
			$arr['theme'] = trim($arr['theme']);
			$arr['site_language'] = trim($arr['site_language']);
			$arr['site_paypal_currency'] = trim($arr['site_paypal_currency']);
			$arr['site_paypal_currency_code'] = trim($arr['site_paypal_currency_code']);
			$arr['contact_email'] = trim($arr['contact_email']);
			$arr['comman_email_from'] = trim($arr['comman_email_from']);
			$arr['comman_email_to'] = trim($arr['comman_email_to']);			
			$arr['site_tracker'] = trim($arr['site_tracker']);			                   
                 return Validation::factory($arr)    
               
                        ->rule('site_name', 'not_empty')
                        ->rule('site_name', 'alpha_space')
                       	->rule('site_name', 'max_length', array(':value', '50'))
                        ->rule('site_slogan', 'not_empty')
                        ->rule('site_slogan', 'alpha_space')
                        ->rule('site_slogan', 'max_length', array(':value', '30'))
			->rule('site_logo', 'Upload::type', array($_FILES['site_logo'], array('jpg','jpeg', 'png', 'gif')))
			->rule('site_logo', 'Upload::size', array($_FILES['site_logo'],'2M'))                       
                        ->rule('site_version', 'not_empty')
                        ->rule('site_description', 'not_empty')
                        ->rule('theme', 'not_empty')
                        ->rule('site_version', 'max_length', array(':value', '30'))
                        ->rule('site_language', 'not_empty')
                        ->rule('site_language', 'max_length', array(':value', '30'))
                        ->rule('site_paypal_currency', 'not_empty')
                        ->rule('site_paypal_currency', 'min_length', array(':value', '1'))                      
                        ->rule('site_paypal_currency_code', 'not_empty')
                        ->rule('site_paypal_currency_code','alpha')
                        ->rule('site_paypal_currency_code', 'max_length', array(':value', '3'))                     
                        ->rule('contact_email', 'not_empty')
                        ->rule('contact_email', 'max_length', array(':value', '30'))
                        ->rule('contact_email','email')
                        ->rule('comman_email_from', 'not_empty')
                        ->rule('comman_email_from', 'max_length', array(':value', '30'))
                        ->rule('comman_email_from','email')
                        ->rule('comman_email_to', 'not_empty')
                        ->rule('comman_email_to', 'max_length', array(':value', '30'))
                        ->rule('comman_email_to','email')                      
                        ->rule('site_tracker', 'not_empty')
                        ->rule('country_time_zone', 'not_empty')
                        ->rule('country_time_zone', 'max_length', array(':value', '200'));
           }
    
            /**Edit Site Settings **/
            public function edit_site_settings($validator,$post_val,$image_name) 
	    {			
		        $mdate = $this->getCurrentTimeStamp(); 
		        //checking status for maintanance mode
		        $mode = isset($post_val['maintenance_mode'])?ACTIVE:IN_ACTIVE;
		        $sql_query = array('site_name'=>$post_val['site_name'],'site_slogan'=>$post_val['site_slogan'],'site_description'=>$post_val['site_description'],'site_version'=>$post_val['site_version'],'site_language'=>$post_val['site_language'],'site_paypal_currency_code'=>$post_val['site_paypal_currency_code'],'site_paypal_currency'=>$post_val['site_paypal_currency'],'contact_email'=>$post_val['contact_email'],'common_email_from'=>$post_val['comman_email_from'],'common_email_to'=>$post_val['comman_email_to'],'country_time_zone'=>$post_val['country_time_zone'],
		      
		        'site_tracker'=>strip_tags($post_val['site_tracker']),'theme'=>strip_tags($post_val['theme']),'maintenance_mode'=>$mode);
	
		        if($image_name != "") $sql_query['site_logo']=$image_name ;
		        $result =  DB::update(SITE)->set($sql_query)
			        ->where('id', '=' ,'1')
			        ->execute();
		
		        return ($result)?1:0;
		
	 }

	/**Check Image Exist or Not while Updating logo Details**/
	public function check_logo_exist()
	{
		$sql = "SELECT site_logo FROM ".SITE;   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
			if(count($result) > 0)
			{ 
				return $result[0]['site_logo'];
			}
	}

        //update site logo null 
        public function update_logo_image($id)
        {
                $sql_query = array('site_logo' => "");
                $result =  DB::update(SITE)->set($sql_query)
                        ->where('id', '=' ,$id)
                        ->execute();
                return 1;
        }

	
	 /** Add validate settings meta**/
        public function validate_site_settings_meta($arr) 
        {
                $arr['meta_keywords'] = trim($arr['meta_keywords']);
                $arr['meta_description'] = trim($arr['meta_description']);
                return Validation::factory($arr)                                
                ->rule('meta_keywords', 'not_empty')
                ->rule('meta_keywords', 'alpha_space')
                ->rule('meta_keywords', 'max_length', array(':value', '126'))
                ->rule('meta_description', 'not_empty');
                   
        }
        
        /**  Site Setting meta **/
        public function site_settings_meta($post_val,$validator)
 	{
		        $insert = DB::insert(META, array('meta_keywords','meta_description'))
            			->values(array($post_val['meta_keywords'],$post_val['meta_description']))
            			->execute(); 		
		        return $insert;		
        } 
       
        /** Add validate settings **/
        public function validate_edit_settings_meta($arr) 
	{
                return Validation::factory($arr)                                
                ->rule('meta_keywords', 'not_empty')
                ->rule('meta_keywords', 'max_length', array(':value', '50'))
                ->rule('meta_description', 'not_empty');
                 
        }
       
       /**Edit Site Settings **/
       public function edit_site_settings_meta($validator,$post_val) 
       {
		$mdate = $this->getCurrentTimeStamp(); 
		$sql_query = array('meta_keywords'=>$post_val['meta_keywords'],'meta_description'=>$post_val['meta_description']);
		$result =  DB::update(META)->set($sql_query)
			->where('meta_id', '=' ,'1')
			->execute();	
		return ($result)?1:0;
	}
	
	/**Site Settings get meta data**/
        public function get_site_settings_meta($id="")
        {
                 $result=DB::select()->from(META)
			     ->limit(1)
			     ->execute()	
			     ->as_array();
                return  $result;

        }
        
        /**Site Settings User Data get **/
        public function get_site_settings_user()
        {              
                 $result=DB::select()->from(USERS_SETTINGS)
			     ->limit(1)
			     ->execute()	
			     ->as_array();
                return  $result;

        }
        
        /**Edit Settings User Data **/
        public function edit_site_settings_user($post_vals) 
	{
	        //remove last submit index and value 	
	        array_pop($post_vals);
	        
	        //Key =From field name and Value = database column name
	        $usersettingdatas = array("email_verification"=>"email_verification_reg","auto_login"=>"auto_login_reg", "admin_notification"=>"admin_notification_reg","welcome_mail"=>"welcome_mail_reg","logout"=>"logout_change_pass", "allow_user"=>"allow_user_language","admin_activation"=>"admin_activation_reg", "inactive_users"=>"inactive_users");
	        
	        $sql_query = array();
	       
	        foreach($usersettingdatas as $key => $value )
	        {
	        
	                if(array_key_exists($key,$post_vals))
	                {
	                       $sql_query[$value] = $post_vals[$key];
	                }
	                else
	                {
	                        $sql_query[$value] = "N";
	                }
	        }
	       
	       	$result =  DB::update(USERS_SETTINGS)->set($sql_query)
			->where('id', '=' ,'1')
			->execute();
		//update always success
		return 1;	  
	}
	
	/** Validate Site User Settings **/
        public function validate_site_settings_user($arr) 
	{
                return Validation::factory($arr)                                
                ->rule('inactive_users', 'not_empty')
                ->rule('inactive_users', 'max_length', array(':value', '5'))
                ->rule('inactive_users', 'digit');               
        }
        
        /**Site Settings get Products data **/
        public function get_site_settings_product()
        {
                 $result=DB::select()->from(PRODUCT_SETTINGS)
			     ->limit(1)
			     ->execute()	
			     ->as_array();			            
                return  $result;
        }
        
        /**  validate settings  Product**/
        public function validate_site_settings_product($arr) 
	{         
                $arr['alternate_name'] = trim($arr['alternate_name']);	
                $min_length_req = is_numeric($arr['min_title_length']) && $arr['min_title_length'] > MIN_ZERO ? $arr['min_title_length']:MIN_ONE;
                $min_bidpackages = is_numeric($arr['min_bidpackages']) && $arr['min_bidpackages'] > ZERO ? $arr['min_bidpackages']:MIN_ONE;
                $max_bidpackages = is_numeric($arr['max_bidpackages'])&& $arr['max_bidpackages'] > ZERO;
                return Validation::factory($arr)  
                ->rule('min_title_length','range',array(':value',MIN_ONE,MIN_COMPLETE_RANGE,"Characters"))
                ->rule('alternate_name', 'not_empty')
                ->rule('alternate_name', 'alpha_space')
                ->rule('alternate_name', 'max_length', array(':value', '10'))                 
                ->rule('min_title_length', 'not_empty')
                ->rule('min_title_length', 'numeric')
                ->rule('min_title_length','range',array(':value',MIN_ONE,MIN_LENGTH_RANGE,"characters"))
                ->rule('max_title_length', 'not_empty')
                ->rule('max_title_length', 'numeric') 
                ->rule('max_title_length','range',array(':value',$min_length_req,MIN_LENGTH_RANGE,"characters"))   
                ->rule('max_desc_length', 'not_empty')
                ->rule('max_desc_length', 'max_length', array(':value', '5')) 
                ->rule('max_desc_length', 'digit')                
                ->rule('min_bidpackages', 'not_empty')
                ->rule('min_bidpackages', 'digit')
                ->rule('min_bidpackages','range',array(':value',MIN_ONE,__('greater_than_zero'),""))
                ->rule('max_bidpackages', 'not_empty')
                ->rule('max_bidpackages', 'digit') 
                ->rule('max_bidpackages','range',array(':value',MIN_ONE,__('greater_than_zero'),""));
       }       
         
        /**Edit Site Settings Products **/   //Dec26, 2012
        public function edit_site_settings_product($post_val) 
        {
                //exploding comma seperated values and check unique array values

                $sms_eachbid = isset($post_val['sms_eachbid'])?"Y":"N";
                $sms_winningbid= isset($post_val['sms_winningbid'])?"Y":"N";
                $sql_query = array(	                                      
                'alternate_name'=>$post_val['alternate_name'],   
                'min_title_length'=>$post_val['min_title_length'],
                'max_title_length'=>$post_val['max_title_length'],
                'max_desc_length'=>$post_val['max_desc_length'],
                'min_bidpackages'=>$post_val['min_bidpackages'],
                'max_bidpackages'=>$post_val['max_bidpackages'],
                'sms_eachbid' => $sms_eachbid,
                'sms_winningbid' => $sms_winningbid,
                'sms_eachbid_template'=>$post_val['sms_eachbid_template'],
                'sms_winningbid_template'=>$post_val['sms_winningbid_template']
                );
                $result =  DB::update(PRODUCT_SETTINGS)->set($sql_query)
                ->where('id', '=','1')
                ->execute();
                return $result;
        }

        /**
        *get_settings_admin_notification_for_register()
        */	
	public function get_all_settings_user()
	{
		$result= DB::select('email_verification_reg','admin_activation_reg','admin_notification_reg',
							'welcome_mail_reg','allow_user_language','logout_change_pass','inactive_users','auto_login_reg')->from(USERS_SETTINGS)
				     	->execute()	
				     	->as_array();	
		return $result;    
	}
	
	/**
	* Validation rule for fields in  banner form
	*/
	public function validate_banner_edit($arr)
	{
	        $arr['title'] = trim($arr['title']);
		return Validation::factory($arr)
					->rule('title', 'not_empty')
					->rule('title', 'alpha_space')
					->rule('title', 'min_length', array(':value', '4'))
			                ->rule('title', 'max_length', array(':value', '32'))
			                ->rule('banner_image','Upload::type',array(':value',array('jpg', 'png', 'gif')))
					->rule('banner_image','Upload::size',array(':value', '2M'))
					->rule('order','numeric')
					->rule('order','not_empty');
	}

		
	/**
	* Validation rule for fields in  banner form
	*/
	public function validate_banner_form($arr)
	{
	        $arr['title'] = trim($arr['title']);
		return Validation::factory($arr)
					->rule('title', 'not_empty')
					->rule('title', 'alpha_space')
					->rule('title', 'min_length', array(':value', '4'))
			                ->rule('title', 'max_length', array(':value', '32'))
			                ->rule('banner_image','Upload::not_empty')
			                ->rule('banner_image','Upload::type',array(':value',array('jpg', 'png', 'gif')))
					->rule('banner_image','Upload::size',array(':value', '2M'))
					->rule('order','numeric')
					->rule('order','not_empty');
	}

        
        /**
        * ****Add Banner()****
        */
	public function add_banner($validator,$_POST,$image_name)
	{
	        $status = isset($_POST['banner_status'])?"A":"I";
		$rs   = DB::insert(BANNER)
				->columns(array('title','banner_image','order','banner_status'))
				->values(array($_POST['title'],$image_name,$_POST['order'],$status))
				->execute();
	}
	
        /**
        * ****update_banner()****
        */
	public function update_banner($_POST,$image_name,$bannerid)
	{
	        $status = isset($_POST['banner_status'])?"A":"I";
	      $query = array('title' =>$_POST['title'],'order' =>$_POST['order'],'banner_status'=> $status);
		if($image_name != "")  $query['banner_image']=$image_name ;
		$result =  DB::update(BANNER)->set($query)
						->where('banner_id', '=',$bannerid)
						->execute(); 
        } 
        
        /**
	 * ****count_banner****
	 * @return banner list count of array
	 */
	public function count_banner()
	{
                $rs = DB::select()->from(BANNER)
                        ->execute()
                        ->as_array();
                return count($rs);
	}

        /**
        * ****select_banner()****
        */
        public function get_banner($offset, $val)
        {
                return $query = DB::select()
                ->from(BANNER)
                ->limit($val)
                ->offset($offset)
                ->order_by(BANNER.'.banner_id','DESC')
                ->execute()
                ->as_array();
        }
        
	      
        /**
        * ****get_testimonials_data()****
        *@param $current_uri int
        *@return alluser lists
        */
	public function get_banner_data($current_uri = '')
	{
                $rs   = DB::select()->from(BANNER)
                        ->where('banner_id', '=', $current_uri)
                        ->execute()
                        ->as_array();
                return $rs;
	}
       
        /**
        * ****delete_banner()****
        */
	public function delete_banner($current_uri)
	{	
			$rs   = DB::delete(BANNER)
				 ->where('banner_id', '=', $current_uri)
				 ->execute();
	}
	
        /**
        * ****Resumes_banner()****
        *@param $bannerid int
        */
	public function banner_resumes($bannerid,$sus_status)
        { 
		$db_set ="";
		switch ($sus_status){
                          case "0":
                                        // if status is 0 means  
                                        $db_set = " banner_status = '".IN_ACTIVE."'";	
                           break;	
                           case "1":
                                        // if status is 1 means
                                        $db_set = " banner_status = '".ACTIVE."'";
                           break;				
		}
	      $query = " UPDATE ". BANNER ." SET $db_set WHERE 1=1 AND banner_id = '$bannerid' ";
	      $result = Db::query(Database::UPDATE, $query)
			    ->execute();
			return $result;
    
	}
	
	/**Check Image Exist or Not while Updating **/
	public function check_bannerphoto($bannerid="")
	{
		$sql = "SELECT banner_image FROM ".BANNER." WHERE banner_id ='$bannerid'";
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
               
			if(count($result) > 0)
			{
				return $result[0]['banner_image'];
			}
	}
	
	/** Validate Site User Settings 
	**/
        public function validate_site_settings_bonus($arr) 
	{
                return Validation::factory($arr)   
                ->rule('facebook_verification', 'min_length', array(':value', '1'));   
        }
        
        /**
        *Edit Facebook bonus Settings   Data
        **/
        public function edit_site_settings_bonus($post_vals) 
	{
	      
	        //remove last submit index and value 	
	        array_pop($post_vals);
	        //Key =From field name and Value = database column name
	        $bonussettingdatas = array("facebook_verification"=>"facebook_verification");
	        $sql_query = array();
	        foreach($bonussettingdatas as $key => $value ){
	        
	                if(array_key_exists($key,$post_vals)){
	                       $sql_query[$value] = $post_vals[$key];
	                }else{
	                        $sql_query[$value] = "N";
	                }
	        }
	       	$result =  DB::update(BONUS_SETTINGS)->set($sql_query)
			->where('id', '=' ,'1')
			->execute();
		//update always success
		return 1;	  
	}
	
        /**Site Bonus  Settings get Data 
        **/
        public function get_site_settings_bonus()
        {              
                 $result=DB::select()->from(BONUS_SETTINGS)
			     ->limit(1)
			     ->execute()	
			     ->as_array();
			   
                return  $result;

        }
        
          /** Site Settings Social Networks**/
        
         public function validate_site_socialnetwork($arr) 
	{
	
                        return Validation::factory($arr)                                
                        ->rule('facebook_api', 'not_empty')
                        ->rule('facebook_api', 'max_length', array(':value', '250'))
                        ->rule('facebook_secret_key', 'not_empty')
                        ->rule('facebook_secret_key', 'max_length', array(':value', '250'))
                        ->rule('facebook_application_id', 'not_empty')
                        ->rule('facebook_invite_text', 'not_empty')
                        ->rule('facebook_invite_text', 'max_length', array(':value', '250'))
                        ->rule('facebook_application_id', 'max_length', array(':value', '25'))
                        ->rule('facebook_share', 'not_empty')
                        ->rule('tiwtter_consumer_key', 'not_empty')
                        ->rule('tiwtter_consumer_key', 'max_length', array(':value', '250'))
                        ->rule('twitter_consumer_secret', 'not_empty')
                        ->rule('twitter_consumer_secret', 'max_length', array(':value', '250'))
                        ->rule('twitter_share', 'not_empty')
			->rule('linkedin_apikey', 'not_empty')
                        ->rule('linkedin_apikey', 'max_length', array(':value', '250'))
                        ->rule('linkedin_secret_key', 'not_empty')
                        ->rule('linkedin_secret_key', 'max_length', array(':value', '250'))
                        ->rule('linkedin_usertoken_key', 'not_empty')
                        ->rule('linkedin_usertoken_key', 'max_length', array(':value', '250'))
                        ->rule('linkedin_usertokensecret_key', 'not_empty')
                        ->rule('linkedin_usertokensecret_key', 'max_length', array(':value', '250'))
                        ->rule('linkedin_share', 'not_empty');
                      
                }
                
        /**Edit Site Settings Cash Withdraw **/
        public function edit_site_socialnetwork($post_val) 
       {
       
                array_pop($post_val);
                $socialnetwork = array('facebook_login'=>'facebook_login','facebook_api'=>'facebook_api','facebook_secret_key'=>'facebook_secret_key','facebook_application_id'=>'facebook_application_id','facebook_invite_text'=>'facebook_invite_text','facebook_share'=>'facebook_share','twitter_login'=>'twitter_login','tiwtter_consumer_key'=>'tiwtter_consumer_key','twitter_consumer_secret'=>'twitter_consumer_secret','twitter_share'=>'twitter_share','linkedin_login'=>'linkedin_login','linkedin_apikey' => 'linkedin_apikey','linkedin_secret_key'=>'linkedin_secret_key','linkedin_usertoken_key' =>'linkedin_usertoken_key','linkedin_usertokensecret_key'=>'linkedin_usertokensecret_key','linkedin_share'=>'linkedin_share');
                $sql_query = array();

	        foreach($socialnetwork as $key => $value ){
	        
	                if(array_key_exists($key,$post_val)){
	                       $sql_query[$value] = $post_val[$key];
	                }else{
	                        $sql_query[$value] = "N";
	                }
	        }                   
                $result =  DB::update(SOCIALNETWORK_SETTINGS)->set($sql_query)
                ->where('id', '=' ,'1')
                ->execute();
                //update always success
		return $result;
	}
	
	/**Site Settings get cashwithdraw**/
        public function get_site_socialnetwork()
        {
                $result=DB::select()->from(SOCIALNETWORK_SETTINGS)
                ->limit(1)
                ->execute()	
                ->as_array();

                return  $result;

        }
        
        /**
        * ****all_username_list()****
        */	 
	public function all_username_list()
	{
	 	$rs   = DB::select('username','id')
	 	                ->from(USERS)
                                ->execute()	
                                ->as_array();
		return $rs;
	}
	
        /**
        * **** get_user_type_list()****
        *@param $email varchar
        *@email send to users
        */
	public function get_user_type_list($status_val,$validator,$error)
	{
		$users_validator = array();
		if(count($validator) > 0 ){
		        $users_validator = explode(",",$validator['validator'][0]['to_user']);
		}
		$status = ($status_val['status'] == 'A')?ACTIVE:IN_ACTIVE;
	 	$rs     = DB::select('id','username')->from(USERS)
						->where('status', '=',$status)
						->order_by('username','ASC')
				   	 	->execute()
				   	 	->as_array();
		$build_dd="<select name='to_user[]' multiple='multiple' id='users'>";
		foreach($rs as $result)
		{
			$selected=(in_array($result['id'],$users_validator)) ? "selected='selected' " :'';
			$name = ucfirst($result['username']);
			$build_dd .= "<option value='".$result['id']."' $selected >".$name."</option>";
		}
       		echo $build_dd .= "</select>";
	       if(count($error['errors']) > 0){
		       $build_dd = "<span class='error'>";
		       $build_dd .=$error['errors'][0]['to_user'];
		       $build_dd .="</span>";
		       echo $build_dd;
	       }
		   exit;

	}

        /**
        * ****get_sendemail_validation()****
        *@param $arr validation array
        *@validation check
        */
	public function get_sendemail_validation($arr)
	{
		$arr['subject'] = trim($arr['subject']);
		$arr['message'] = trim($arr['message']);
		return Validation::factory($arr)       
			->rule('user_status','not_empty')
			->rule('to_user','not_empty')
			->rule('subject','not_empty')
			->rule('subject','alpha_space')
			->rule('subject', 'min_length', array(':value', '10'))
			->rule('subject', 'max_length', array(':value', '128'))			
			->rule('subject','alpha_space')
			->rule('message','not_empty')
			->rule('message', 'min_length', array(':value', '10'));
    	}

        /**
        * ****sendemail()****
        *@email send to too many (bulk) users
        */
	public function sendemail($details,$headers,$variables,$from,$smtp_config) 
	{

		//mail sending option to all users and insert userid in database
 		$user_id = "";
		$user_id = count($_POST['to_user']);
		for ($i=0; $i<$user_id;$i++) {
 	 	    $to    = DB::select('email','username','status')
	 	                        ->from(USERS)
				        ->where('id','=',$_POST['to_user'][$i])
			                ->execute()
					->as_array(); 
			$subject = $details['subject']; 
			$message = $details['message'];
                        $headers = __('email_header_text'). "\r\n";
                        $headers .= __('email_content_type') . "\r\n";
                        $headers .= __('email_from'). $from . "\r\n";
		        //send bulk mail to users
                        try{
			if(Email::connect($smtp_config)){                         	

				if(Email::send($to[0]['email'],$from, $subject, $message,$html = true) == 0)                                    {                                  		                
					   
				      }
			}	 
			}catch(Exception $e){
					  
				 if(mail($to[0]['email'], $subject, $message, $headers))
				 {   
				                             
	                          }
			}
			$result = DB::insert(BULKEMAIL)
						  ->columns(array('user_id','user_status'))
						  ->values(array($_POST['to_user'][$i],$to[0]['status']))
						  ->execute();
	                $usermessage   = DB::insert(USER_MESSAGE,array('usermessage_to', 'usermessage_from', 'usermessage_subject','usermessage_message'))
				                  ->values(array($to[0]['email'],$from,$subject,$message))
				                  ->execute();
		}
	}
	
        /**
        * ****validate news latter()****
        */
	public function validate_news_latter($arr)
	{
	        $arr['subject'] = trim($arr['subject']);
		return Validation::factory($arr)
			->rule('subject', 'not_empty')
			->rule('subject', 'alpha_space')
			->rule('subject', 'min_length', array(':value', '5'))
			->rule('message','not_empty')
			->rule('message', 'min_length', array(':value', '5'));

	}
		
        /**
        * ****select_user_list()****
        */	 
	public function select_user($userid)
	{
	 	$rs   = DB::select()
	 	                ->from(USERS)
                                ->where('id', '=' ,$userid)
                                ->execute()	
                                ->as_array();
		return $rs;

	}
        /**
        * ****select_newslatter()****
        */	 
	public function select_newslatter()
	{
	 	$rs   = DB::select()
	 	                ->from(NEWS_LATTER)
                                ->execute()	
                                ->as_array();
		return $rs;

	}
	
        /**
        * ****update_newslatter()****
        */
	public function update_newslatter($_POST)
	{
	
	        $query = array('subject' =>$_POST['subject'],'message' =>$_POST['message']);
	        $result =  DB::update(NEWS_LATTER)
	                        ->set($query)
			        ->execute();
	}
	
	/*
	*Select Social Account
	*Get Facebook Details
	*/
	public function get_social_media_account($type=1)
	 {
	               $result  = DB::select()
	         	                ->from(SOCIAL_ACCOUNT)
					->where('type','=',$type)
                                        ->execute()	
                                        ->as_array();
		        return $result;
         }	
         
        /**
        * For Facebook user signup insertion
        */
	public function register_facebook_user($profile_data = array(),$fb_access_token)
	{
		
			$username = Html::chars($profile_data->first_name);	
			
			$insert_result = DB::insert(SOCIAL_ACCOUNT, array('first_name','last_name', 'image_url','email_id', 'account_user_id','access_token','userid','type'))
					->values(array($profile_data->first_name,$profile_data->last_name,$profile_data->email,$profile_data->image_url,$profile_data->email_id,$profile_data->account_user_id,$profile_data->access_token,$profile_data->userid,$profile_data->type))
					->execute();
                                $_SESSION["facebook_userid"] = $FB_user_id;
                                $_SESSION["fb_access_token"] = $access_token;
                                $_SESSION["mes"] = "Facebook account has been added";
		
		
	}
	
	/**Mail Settings **/
        public function mail_settings($id="")
        {
                 $result=DB::select()->from(SMTP_SETTINGS)
			     ->where('id', '!=', $id)
			     ->execute()	
			     ->as_array();
                return  $result;

        } 
        
        /**Edit Site mail Settings  Validate**/
        public function validate_edit_mail_settings($arr) 
        {

                $arr['smtp_host'] = trim($arr['smtp_host']);
                $arr['smtp_port'] = trim($arr['smtp_port']);
                $arr['smtp_username'] = trim($arr['smtp_username']);
                $arr['smtp_password'] = trim($arr['smtp_password']);
                return Validation::factory($arr) 
                        ->rule('smtp_host', 'not_empty')
                        ->rule('smtp_host','email_domain')
                       // ->rule('smtp_host', 'regexhost', array(':value', '/^[0-9a-zA-Z.]++$/i'))
                        ->rule('smtp_port', 'not_empty')
                        ->rule('smtp_port', 'numeric')
                        ->rule('smtp_username', 'not_empty')
                        ->rule('smtp_username', 'email')
                        ->rule('smtp_password', 'not_empty')
                        ->rule('smtp_password', 'min_length', array(':value', '4'));
        }	 

        /**Edit mail Settings **/
        public function edit_mail_settings($post_val) 
        {	

                $sql_query = array('smtp_host'=>$post_val['smtp_host'],'smtp_port'=>$post_val['smtp_port'],'smtp_username'=>$post_val['smtp_username'],'smtp_password'=>$post_val['smtp_password']);

                $result =  DB::update(SMTP_SETTINGS)->set($sql_query)
                                ->where('id', '=' ,'1')
                                ->execute();

                return ($result)?1:0;

        }
        //ads functionality start
		public function count_ads()
	{
		          $rs = DB::select()->from(ADS)
		                  ->execute()
		                  ->as_array();
		          return count($rs);
	}
	/**
	* ****select_Ads()****
	*/
	public function get_ads($offset, $val)
	{
		    return $query = DB::select()
					 ->from(ADS)
					 ->limit($val)
					 ->offset($offset)
					 ->order_by(ADS.'.ads_id','DESC')
					 ->execute()
					 ->as_array();
	}
	/**
	* ****Add Ads()****
	*/
	public function add_ads($validator,$_POST,$image_name)
	{
		$status = isset($_POST['ads_status'])?"A":"I";
		$cat_name = DB::select()->from(ADS)
				->where('title','=', $_POST['title'])
				->execute()
				->as_array(); 
		//For Duplicate Checking
		if(count($cat_name) > 0)
		{
			return 0;
		}
		else
		{
				$rs= DB::insert(ADS)
				->columns(array('title','website','order','ads_image','ads_status'))
				->values(array($_POST['title'],$_POST['website'],$_POST['order'],$image_name,$status))
				->execute();
				return 1;
		}
	}
	
	/**Check Image Exist or Not while Updating **/
	public function check_adsphoto($adsid="")
	{
		$sql = "SELECT ads_image FROM ".ADS." WHERE ads_id ='$adsid'";
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
               
			if(count($result) > 0)
			{
				return $result[0]['ads_image'];
			}
	}

	/**
	*@param $current_uri int
	*@return adds lists
	*/
	public function get_ads_data($current_uri = '')
	{
		    $rs   = DB::select()->from(ADS)
		            ->where('ads_id', '=', $current_uri)
		            ->execute()
		            ->as_array();
		    return $rs;
	}

	/**
	* ****update_ads()****
	*/
	public function update_ads($_POST,$image_name,$adsid)
	{			
			$status = isset($_POST['ads_status'])?"A":"I";
			$query = array('title' =>$_POST['title'],'ads_status'=> $status,'website'=> $_POST['website']);
			if($image_name != "")  $query['ads_image']=$image_name ;
			$result =  DB::update(ADS)->set($query)
						->where('ads_id', '=',$adsid)
						->execute(); 			
	} 
	/**
	* ****delete_ads()****
	*/
	public function delete_ads($current_uri)
	{	
			$rs   = DB::delete(ADS)
			->where('ads_id', '=', $current_uri)
			->execute();
	}
	/**
	* Validation rule for fields in  ads form
	*/
	public function validate_ads_form($arr)
	{
			$arr['title'] = trim($arr['title']);
			return Validation::factory($arr)
							->rule('title', 'not_empty')
							->rule('title', 'alpha_space')
							->rule('title', 'min_length', array(':value', '4'))
							->rule('title', 'max_length', array(':value', '32'))
							->rule('website', 'not_empty')
							->rule('website', 'url')
							->rule('order','numeric')
							->rule('order','not_empty')
							->rule('ads_image','Upload::not_empty')
							->rule('ads_image','Upload::type',array(':value',array('jpeg', 'png', 'gif')))
							->rule('ads_image','Upload::size',array(':value', '2M'));					
	}
	/**
	* Validation rule for fields in  ads form
	*/
	public function validate_ads_edit($arr)
	{ 
		$arr['title'] = trim($arr['title']);
		return Validation::factory($arr)
							->rule('title', 'not_empty')
							->rule('title', 'min_length', array(':value', '4'))
							->rule('title', 'max_length', array(':value', '32'))
							->rule('website', 'not_empty')
							->rule('website', 'url')
							->rule('order','numeric')
							//->rule('order','not_empty')
							->rule('ads_image','Upload::type',array(':value',array('jpg', 'png', 'gif')))
							->rule('ads_image','Upload::size',array(':value', '2M'));
				
	}
	public function sendemail_nl($details,$headers,$variables,$from,$smtp_config) 
	{  

		//mail sending option to all users and insert userid in database
 		$user_id = "";
		$user_id = count($_POST['non_user_email']);	
		for ($i=0; $i<$user_id;$i++) {
				$to    = DB::select('email')
				->from(NEWSLETTER_SUBSCRIBER)
				->where('id','=',$_POST['non_user_email'][$i])
				->execute()
				->as_array();

			$subject = $details['subject']; 
			$message = $details['message'];
		        //send bulk mail to users
			if(Email::connect($smtp_config)){                       	

				if(Email::send($to[0]['email'],$from, $subject, $message,$html = true) == 0)                                    {                                  		                
					   
				      }
				 
			}else{
					  
				 if(mail($to[0]['email'], $subject, $message, $headers))
				 {   
				                             
	                          }
			}
			$result = DB::insert(BULKEMAIL)
						  ->columns(array('user_id','user_status'))
						  ->values(array($_POST['non_user_email'][$i],"NU"))
						  ->execute();
	                $usermessage   = DB::insert(USER_MESSAGE,array('usermessage_to', 'usermessage_from', 'usermessage_subject','usermessage_message'))
				                  ->values(array($to[0]['email'],$from,$subject,$message))
				                  ->execute();
		}
	}
	public function select_newslatter_nonuser()
	{


		$sql = "SELECT email,id,signup_ip,status from ". NEWSLETTER_SUBSCRIBER ." where
		email Not in (select email from ".USERS.") and status !='".IN_ACTIVE."' ";
		$rs=Db::query(Database::SELECT, $sql)
								
                                ->execute()	
                                ->as_array();
		return $rs;

	}
	public function count_subscriber($val)
	{
		$sql = "SELECT * from ". NEWSLETTER_SUBSCRIBER ." ";
		$rs=Db::query(Database::SELECT, $sql)
                                ->execute()	
                                ->as_array();
		return $rs;

	}
	public function nonuser_subscriber($val)
	{
		$sql = "SELECT * from ". NEWSLETTER_SUBSCRIBER ." ";
		$rs=Db::query(Database::SELECT, $sql)
                                ->execute()	
                                ->as_array();
		return $rs;

	}
	
}
?>
