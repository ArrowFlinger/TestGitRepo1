<?php defined('SYSPATH') or die('No direct script access.');

/* Contains Settings(Site Settings,Product Settings,Meta Settings,User Settings) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/


class Controller_Settings extends Controller_Welcome 
{

	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->settings = Model::factory('Settings');
	}
	
        
        /**
        *@ Manage Site Settings
        *Site Settings View   
        **/
        public function action_manage_site()
        {
                $this->page_title = __("site_settings");
                $this->selected_page_title = __("site_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $errors = array();
                $view= View::factory('admin/add_settings_site')
                        ->bind('validator', $validator)
                        ->bind('errors', $errors)
                        ->bind('site_settings', $site_settings);
                $id = $this->request->param('id');
                $site_settings = $this->settings->site_settings($id);
                $this->template->content = $view;
        }
        
        /**
        * ****Image resize ****
        * @return Image listings  */      
        public function imageresize($image_factory,$width,$height,$path,$image_name,$quality=90)
        {
                if ($image_factory->height < $height || $image_factory->width < $width )
                {
                      $image = $image_factory->save($path.$image_name,90);
                      return  $image; 
                }
                else
                {
                        $image_factory->resize($width, $height, Image::INVERSE);
                        $image_factory->crop($width, $height);                    
                        $image= $image_factory->save($path.$image_name,90);
                 return  $image;
                }
        
        }
        
        /**
        *@Manage Site Settings overall  
        *Manage Theme
        **/
        public function action_site_settings()
        {
                $msg = "";
                $id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$id;
                $settings_post=arr::get($_REQUEST,'editsettings_submit');
                $errors = array();
                $img_exist=$this->settings->check_logo_exist();
               
                if(isset($settings_post) && (Validation::factory($_POST,$_FILES))){
                
  		 $validator = $this->settings->validate_edit_settings_site(array_merge($_POST,array('site_name','site_slogan','site_description','site_version','site_language',
   'site_paypal_currency_code','site_paypal_currency','contact_email','comman_email_from','comman_email_to',
   'date_format_display','time_format_display','date_time_format_display','date_format_tooltip',
   'time_format_tooltip','date_time_tooltip','date_time_highlight_tooltip','site_tracker','site_logo','country_time_zone','theme')),$_FILES);

                    if ($validator->check()) 
                    {
                   
                                          $image_name ="";
                    			   if($_FILES['site_logo']['name']!='')
                    			   {
	                    				$image_name = uniqid().str_replace(" ","_",$_FILES['site_logo']['name']);
	 			                        $filename =Upload::save($_FILES['site_logo'],$image_name,DOCROOT.LOGO_IMGPATH, '0777');                    	
                                                //Image Resize
                                                 $image = Image::factory($filename);
                                                 $path=DOCROOT.LOGO_IMGPATH;
                                                 $this->imageresize($image,300,109,$path,$image_name,90);
                                                 }
			 						if($img_exist != '' && $image_name!= '')
									{
										if(file_exists(DOCROOT.LOGO_IMGPATH.$img_exist))
										{
											 	unlink(DOCROOT.LOGO_IMGPATH.$img_exist);
										}
							
									}
                        $status = $this->settings->edit_site_settings($validator,$_POST,$image_name);
                        //Flash message 
                        Message::success(__('update_settings_flash'));
                       // $this->request->redirect("settings/site_settings");
                               // $validator = null;
                            }
                    else{
                        $errors = $validator->errors('errors');
                    }
                }	
                $site_settings = $this->settings->site_settings($id);
                $this->selected_page_title = __("Manage site");
                $this->selected_controller_title =__('menu_general_settings');
                $this->page_title = __('site_settings');
                $view = View::factory('admin/add_settings_site')            
                        ->bind('current_uri',$id)
                        ->bind('action',$action)
                        ->bind('site_settings',$site_settings)
                        ->bind('errors',$errors)
		        ->bind('validator',$validator);
                $this->template->content = $view;
        }
        
       
        /*
        *@Delete site Settings Logo image
        *Unlink Logo image path folder
        */
        public function action_delete_site_logo()
        {
                //get current page segment id 
                $id = $this->request->param('id');
                $logo_delete = $this->settings->check_logo_exist($id);
                        if(file_exists(DOCROOT.LOGO_IMGPATH.$logo_delete) && $logo_delete != '')
                        {				
                             unlink(DOCROOT.LOGO_IMGPATH.$logo_delete);
                        }
                $status = $this->settings->update_logo_image($id);
                //send data to view file 
                $site_settings = $this->settings->site_settings($id);
                //Flash message 
                Message::success(__('delete_site_logo_flash'));	
                $this->request->redirect("settings/site_settings/");
        }
     
        /** Meta Site Settings**/
        public function action_site_settings_meta()
        {
		$msg = "";
                $id = $this->request->param('meta_id');
                $action = $this->request->action();
                $action .= "/".$id;
                $settings_post=arr::get($_REQUEST,'metasettings_submit');
		$errors = array();		
		if(isset($settings_post)){		
                        $validator = $this->settings->validate_site_settings_meta(arr::extract($_POST,array('meta_keywords','meta_description')));

                        if ($validator->check()) 
                        {                    
                                $status = $this->settings->edit_site_settings_meta($id,$_POST);
                                        //Flash message 
                                        Message::success(__('update_metasettings_flash'));
                                $validator = null;
                        }
                        else{                    
                                $errors = $validator->errors('errors');
                        }
               }
               
                $site_meta = $this->settings->get_site_settings_meta();
                $this->selected_page_title = __("menu_meta_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $this->page_title = __('menu_meta_settings');
                $view = View::factory('admin/site_settings_meta')
                                ->bind('current_uri',$id)
                                ->bind('action',$action)
                                ->bind('site_meta',$site_meta)
                                ->bind('errors',$errors)
		                ->bind('validator',$validator);
				
                $this->template->content = $view;

        }
         
         /** Manage Site Settings Meta **/
        public function action_manage_site_meta()
        {
         
                $this->page_title = __("menu_master");
                $this->selected_page_title = __("Manage Site Settings Meta");
                $this->selected_controller_title =__('menu_general_settings');
                $errors = array();
                $id = $this->request->param('meta_id');
                $site_meta = $this->settings->get_site_settings_meta(); 
                $view= View::factory('admin/site_settings_meta')
                                ->bind('validator', $validator)
                                ->bind('errors', $errors)
                                ->bind('site_meta ', $site_meta );
                $this->template->content = $view;
                
        }
        
        /** Site Settings Users**/
        public function action_site_settings_user()
        {          
                    
                $msg = "";
                $error = array();
                $user_settings_post=arr::get($_POST,'usersettings_submit');                 
                if(isset($user_settings_post)){   
                        
                        $validator = $this->settings->validate_site_settings_user(arr::extract($_POST,array('inactive_users')));

                        if ($validator->check()) 
                        {                        
                                $status = $this->settings->edit_site_settings_user($_POST);
                                
                                if($status == 1){
                                
                                        //Flash message 
                                        Message::success(__('update_usersettings_flash'));
                                       
                                }else{
                                        $msg = __('meta not exists');
                                }
                                
                                $validator = null;
                        }
                        else{                               
                                $errors = $validator->errors('errors');
                                                              
                        }
                }             
                $this->selected_page_title = __("menu_user_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $this->page_title = __('menu_user_settings');
                $view = View::factory('admin/site_settings_user')
                                ->bind('user_setting_data',$site_settings_user)
                                ->bind('errors',$errors)                                        
                                ->bind('validator',$validator);
                $site_settings_user = $this->settings->get_site_settings_user();	       			
                $this->template->content = $view;               
        }
        
       /** Site Settings Products**/  // Dec26,2012
        public function action_site_settings_product()
        {        
                $this->selected_page_title = __("menu_products_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $this->page_title = __('menu_products_settings');             
                $msg = "";
                $id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$id;
                $settings_post=arr::get($_REQUEST,'productsettings_submit');               
                $errors = array();
                if(isset($settings_post)){
                $validator = $this->settings->validate_site_settings_product(arr::extract($_POST,
                                        array('alternate_name',
                                        'min_title_length','max_title_length','max_desc_length','min_bidpackages','max_bidpackages','sms_eachbid_template','sms_winningbid_template')));
                                               
                                                if ($validator->check()) 
                                                {       
                                                $status = $this->settings->edit_site_settings_product($_POST);
                                                        //Flash message 
	                                                        Message::success(__('update_gigsettings_flash'));
                                                        //$validator = null;
                                                }                                              
                                                        else{

                                                        $errors = $validator->errors('errors');
                                                }
                }
					 $site_settings_product = $this->settings->get_site_settings_product();
					 $view = View::factory('admin/site_settings_product')
                                ->bind('current_uri',$id)
                                ->bind('action',$action)
                                ->bind('site_settings_product',$site_settings_product)
                                ->bind('commission_errors',$commission_errors)
                                ->bind('errors',$errors)
                                ->bind('validator',$validator);
                $this->template->content = $view;
        }

        /**
        * **** Manage Banner  ****
        */  
        public function action_manage_banner()
	{
		//set page title
		$this->page_title =  __('menu_banner');
		$this->selected_page_title = __('menu_banner');
		$this->selected_controller_title =__('menu_general_settings');
                $count_banner = $this->settings->count_banner();
	    	//pagination loads here
		$page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_banner,
                'view' => 'pagination/punbb',
                ));
		$get_banner = $this->settings->get_banner($offset, ADM_PER_PAGE);
		//pagination ends here
		//send data to view file
		$view = View::factory('admin/manage_banner')
		                ->bind('get_banner',$get_banner)
		                ->bind('pag_data',$pag_data)
				->bind('title',$title)
				 ->bind('offset',$offset);     
		$this->template->content = $view;

	}
	
	/**
        * **** Add Banner  ****
        */
	public function action_add_banner()
	{
	
		//set page title
		$this->page_title =  __('menu_banner');
		$this->selected_page_title = __('menu_banner');
		$this->selected_controller_title =__('menu_general_settings');
		//check current action
		$action = $this->request->action();
				
		//getting request for form submit
		$add =arr::get($_REQUEST,'admin_add');
 		
		//validation starts here	
		if(isset($add) && (Validation::factory($_POST,$_FILES))){

		        $files=Arr::extract($_FILES,array('banner_image'));
			$post=Arr::extract($_POST, array('title','order'));
			$values=Arr::merge($files,$post);                   
                        $validator = $this->settings->validate_banner_form($values);
		        //validation check
			if ($validator->check()) 
			{							
			       //after image validation it will be stored in root folder//
	                       $image_name = "";
	                       if($_FILES['banner_image']['name'] !=""){
	                        $image_type=explode('.',$_FILES['banner_image']['name']);
		                $image_type=end($image_type);
	                        $image_name = uniqid().'.'.$image_type;
		                $filename =Upload::save($_FILES['banner_image'],$image_name,DOCROOT.BANNER_IMGPATH, '0777');							
		                //To check Uploaded Image name is not null and product image is exist in db  //
	                        $image = Image::factory($filename);			               
                                $path=DOCROOT.BANNER_IMGPATH;
	                        $this->imageresize($image,BANNER_RESIZE_IMAGE_WIDTH,BANNER_RESIZE_IMAGE_HEIGHT,$path,$image_name,90);
	                        }
                                $status = $this->settings->add_banner($validator,$_POST,$image_name);
                            $validator = null;
                            Message::success(__('add_banner_flash'));
                           $this->request->redirect("settings/manage_banner");
                          }
                        else{
                        //validation error msg hits here
                        $errors = $validator->errors('errors');
                           }
	                }
		//send data to view file
		$view = View::factory('admin/add_banner')
		                ->bind('validator',$validator)
		                ->bind('errors',$errors)
		                ->bind('action',$action)
				->bind('title',$title);
		$this->template->content = $view;
	}
	
	/**
        *@Edit Banner*
        */
	public function action_edit_banner()
	{
		//set page title
		$this->page_title =  __('edit_banner');
		$this->selected_page_title = __('edit_banner');
		$this->selected_controller_title =__('menu_general_settings');
		//check current action
		$action = $this->request->action();			
		//get current page segment id
		$bannerid = $this->request->param('id');			
                $action .= "/".$bannerid;
		//getting request for form submit
		$add =arr::get($_REQUEST,'admin_edit');
 		$img_exist=$this->settings->check_bannerphoto($bannerid);
		//validation starts here	
		if(isset($add) && (Validation::factory($_POST,$_FILES))){
		 
                        $files=Arr::extract($_FILES,array('banner_image'));
                        $post=Arr::extract($_POST, array('title','order'));
                        $values=Arr::merge($files,$post);                   
                        $validator = $this->settings->validate_banner_edit($values);	 
                       //validation check
			 if ($validator->check())
                        {		 		 					
			       //after image validation it will be stored in root folder//
	                       $image_name = "";
                                if($_FILES['banner_image']['name'] !=""){
                                $image_type=explode('.',$_FILES['banner_image']['name']);
                                $image_type=end($image_type);
                                $image_name = uniqid().'.'.$image_type;

                                $filename =Upload::save($_FILES['banner_image'],$image_name,DOCROOT.BANNER_IMGPATH, '0777');							
                                //To check Uploaded Image name is not null and product image is exist in db  //
                                $image = Image::factory($filename);			               
                                $path=DOCROOT.BANNER_IMGPATH;
                                $this->imageresize($image,BANNER_RESIZE_IMAGE_WIDTH,BANNER_RESIZE_IMAGE_HEIGHT,$path,$image_name,90);
                                }
                                        // Banner image delete
                                        if($img_exist != '' && $image_name!= '')
                                        {
                                                if(file_exists(DOCROOT.BANNER_IMGPATH.$img_exist))
                                                {
                                                unlink(DOCROOT.BANNER_IMGPATH. $img_exist);
                                                }
                                        }
                            $status = $this->settings->update_banner($_POST,$image_name,$bannerid);
                            $validator = null;
                            Message::success(__('update_banner_flash'));
                            $this->request->redirect("settings/manage_banner");
                     }
                     else{
                       
                                //validation error msg hits here  
                                $errors = $validator->errors('errors');
                                }
	                }				
                $banner_data = $this->settings->get_banner_data($bannerid);
              	$view = View::factory('admin/add_banner')
		                ->bind('validator',$validator)
		                ->bind('banner_data',$banner_data[0])
		                ->bind('bannerid',$bannerid)
		                ->bind('errors',$errors)
		                ->bind('action',$action)
				->bind('title',$title);				
		$this->template->content = $view;
	}
	
	 /**
	 * ****Delete Banner****
	 * banner unlink listing items
	 */
	 public function action_delete_banner()
         {                  
                $banner_id = $this->request->param('id');
                // Banner image delete
                $img_exist=$this->settings->check_bannerphoto($banner_id);
                        if(file_exists(DOCROOT.BANNER_IMGPATH.$img_exist) && $img_exist != '')
                        {
                        unlink(DOCROOT.BANNER_IMGPATH.$img_exist);
                        }
                // Banner Details delete
                $status = $this->settings->delete_banner($banner_id);
                //Flash message 
                Message::success(__('delete_banner_flash'));
                $this->request->redirect("settings/manage_banner");
         }
         
         /**
	 * ****Delete Banner****
	 * banner unlink listing items
	 */
	 public function action_delete_banner_image()
         {                  
                $banner_id = $this->request->param('id');
                // Banner image delete
                $img_exist=$this->settings->check_bannerphoto($banner_id);
                        if(file_exists(DOCROOT.BANNER_IMGPATH.$img_exist) && $img_exist != '')
                        {
                        unlink(DOCROOT.BANNER_IMGPATH.$img_exist);
                        }
                $banner_data = $this->settings->get_banner_data($banner_id);
                //Flash message 
                Message::success(__('delete_banner_flash'));
                $this->request->redirect("settings/edit_banner/".$banner_id);
         }
        
        /**
        * ****Banner****
        * banner Active (or) Inactive listing items
        */
	public function action_active()
	{           
                //get current page segment id
                $bannerid=arr::get($_REQUEST,'id'); 		
                //get params value posting by query string
                $sus_status=arr::get($_REQUEST,'susstatus');		
                //perform suspend action 
                $status = $this->settings->banner_resumes($bannerid,$sus_status);				
				switch($sus_status){
					case 0:							
					//success message for inactive banner
					Message::success(__('banner_inactive_flash'));			
					break;
					case 1:
					//success message for active banner
					Message::success(__('banner_active_flash'));
					break;
				}						
		//redirects to index page after deletion
		$this->request->redirect("settings/manage_banner");
	}
	
	
	 /** Site Settings Products**/
        public function action_site_bonus_settings()
        {  
                $this->selected_page_title = __("menu_site_bonus_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $this->page_title = __('menu_site_bonus_settings');             
                $msg = "";
                $error = array();
                $bonus_settings_post=arr::get($_POST,'bonussettings_submit');
                if(isset($bonus_settings_post)){
                        $validator = $this->settings->validate_site_settings_bonus(arr::extract($_POST,array('facebook_verification')));
                        if ($validator->check()) 
                        {                        
                                $status = $this->settings->edit_site_settings_bonus($_POST);
                                if($status == 1){
                                        //Flash message 
                                        Message::success(__('update_facebooksettings_flash'));
                                }else{
                                        $msg = __('facebook bonus not exists');
                                }
                                $validator = null;
                        }
                        else{                               
                                $errors = $validator->errors('errors');
                        }
                } 
                $view = View::factory('admin/site_bonus_settings')
                                ->bind('bonus_setting_data',$bonus_setting_data)
                                ->bind('errors',$errors)                                        
                                ->bind('validator',$validator);
                $bonus_setting_data = $this->settings->get_site_settings_bonus();	       			
                $this->template->content = $view;          
        }
        
        
          /** Site Settings social_network **/
        public function action_social_network()
        {
		$msg = "";
                $id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$id;
                $settings = Model::factory('Settings');
                $settings_post=arr::get($_REQUEST,'socialnetwork_submit');
		$errors = array();
		if (isset($settings_post)){	
               $validator = $settings->validate_site_socialnetwork(arr::extract($_POST,array('facebook_api','facebook_access_token','facebook_secret_key','facebook_userid','facebook_application_id','facebook_invite_text','facebook_page_id','facebook_share','tiwtter_consumer_key','twitter_consumer_secret','twitter_share','linkedin_login',
		  'linkedin_apikey','linkedin_secret_key','linkedin_usertoken_key','linkedin_usertokensecret_key','linkedin_share')));

                        if ($validator->check()) 
                        {
                                $status = $settings->edit_site_socialnetwork($_POST);
                                if($status == 1){
                                        //Flash message 
                                        Message::success(__('update_socialsettings_flash'));
                                        }
                                $validator = null;
                                }
                        else{
                        $errors = $validator->errors('errors'); 
                        }
                }
                        $site_socialnetwork = $settings->get_site_socialnetwork();
			
                        $this->selected_page_title = __("menu_social_network_settings");
                        $this->selected_controller_title =__('menu_general_settings');
                        $this->page_title = __('menu_social_network_settings');
                        $view = View::factory('admin/social_network')
                                       ->bind('action',$action)
                                       ->bind('site_socialnetwork',$site_socialnetwork)
                                       ->bind('errors',$errors)
	                               ->bind('validator',$validator);			
                        $this->template->content = $view;
        }
        
        /**
        * ****action_news_latter()****
        *reply for  news_latter items
        */
	public function action_news_letter()
	{ 
 		//set page title
		$this->page_title = __('menu_news_letter');
		$this->selected_page_title = __('menu_news_letter');
		$this->selected_controller_title =__('menu_general_settings');
		//check current action
		$action = $this->request->action();
		$action .= "/";
		//getting request for form submit
		$auto_reply =arr::get($_REQUEST,'news_latter');
		$non_user_email =arr::get($_REQUEST,'non_user_email');
	
		$news_latterupdate =arr::get($_REQUEST,'news_latterupdate');
		$values=arr::extract($_POST,array('subject','message'));
		
		if(isset($values['subject']) && isset($news_latterupdate) ){

				
		        $validator = $this->settings->validate_news_latter($values);
		        $errors = array();
		        if ($validator->check())
		        {
		                if(isset($news_latterupdate))
		                {
		                $update_newslatter = $this->settings->update_newslatter($_POST);
		                Message::success(__('news_latter_update_flash'));
		                }
		        }
                        else
                        {
                        //validation error msg hits here
                        $errors = $validator->errors('errors');
                        }
		}
		
		//validation starts here
		if (isset($auto_reply)) 
		{
			if(!isset($_POST['to_user'])){
			        $_POST['to_user']="";        
			}

					
			$validator = $this->settings->get_sendemail_validation($_POST,array('user_status','to_user','subject','message'));
			
			$from = $this->site_settings[0]['common_email_from'];
			$mail = Model::factory('commonfunction');
                        $smtp_settings  = $mail->get_smtp_settings();
                        
                        $smtp_config = array('driver' => 'smtp','options' => array('hostname'=>$smtp_settings[0]['smtp_host'],
		                        'username'=>$smtp_settings[0]['smtp_username'],'password' => $smtp_settings[0]['smtp_password'],
		                        'port' => $smtp_settings[0]['smtp_port'],'encryption' => 'ssl')); 

			//validation check 
			if ($validator->check()) 
			{
					   
				$status = $this->settings->sendemail($_POST,$this->url,$this->replace_variables,$from,$smtp_config);
				if(isset($non_user_email)){
				$this->settings->sendemail_nl($_POST,$this->url,$this->replace_variables,$from,$smtp_config);
			}
				Message::success(__('news_latter_send_flash'));
				$this->request->redirect("settings/news_letter");

				$validator = null;
		     }else{
				//validation error message hits here
				$errors = $validator->errors('errors');
                    }
                } 
		        //send data to view file
                        $all_username_list = $this->settings->all_username_list();

                        $select_newslatter = $this->settings->select_newslatter();
						//print_r($select_newslatter);exit;
                        $select_newslatter_nonuser=$this->settings->select_newslatter_nonuser();
						//print_r($select_newslatter_nonuser);exit;
                        // $select_nonuser_newslatter =                       
                        $view = View::factory('admin/news_latter')
                                ->bind('all_username',$all_username_list)
                                ->bind('select_newslatter',$select_newslatter[0])
                                ->bind('select_newslatter_nonuser',$select_newslatter_nonuser)
                                ->bind('errors',$errors)
                                ->bind('validator',$validator)
                                ->bind('action',$action);
                        $this->template->content = $view;
	}
	
	
	
	/**
	 * ****action_builduser()****
	 * @return
	 */
	public function action_builduser()
	{
		//get user list dd for corresponding status
		if($_POST['status'])
		{

			  $validator = json_decode($_POST['validator'], true);
			  $errors = json_decode($_POST['error'], true);
			  $id = $_POST['status'];
			  $builduser_list = $this->settings->get_user_type_list($_POST['status'],$validator,$errors);exit;
		}
		
	}
	

        /*
        *@Social Network Settings
        *Updated Product in Facebook
        */
        public function action_social_media_account()
        {
                $this->page_title=__('menu_social_network');
                $this->selected_page_title=__('menu_social_network');
                $this->selected_controller_title =__('menu_general_settings');
                $social_media_facebook = $this->settings->get_social_media_account(1); 
                $social_media_twitter = $this->settings->get_social_media_account(2); 
                $view=View::factory('admin/social_media_account')
                                ->bind('social_media_facebook',$social_media_facebook)
                                ->bind('social_media',$social_media)
                                ->bind('errors',$errors)
                                ->bind('validator',$validator);
                $this->template->content=$view;
        }
        
          /** Manage Smtp Settings **/
        public function action_mail_settings()
        {
                $mail_settings = Model::factory('Settings');
                $errors = array();
                $this->selected_page_title = __("mail_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $view= View::factory('admin/manage_mail_settings')
                ->bind('validator', $validator)
                ->bind('errors', $errors)
                ->bind('mail_settings', $mail_settings);
                $id = $this->request->param('id');
                $mail_settings = $mail_settings->mail_settings($id);
                $this->page_title = __("mail_settings");
                $this->template->content = $view;
        }

        /** Site Settings**/
        public function action_manage_mail_settings()
        {
 		$msg = "";
                $id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$id;
                $settings = Model::factory('Settings');
                $settings_post=arr::get($_REQUEST,'editmailsettings_submit');
		$errors = array();
                if(isset($settings_post) && Validation::factory($_POST)){
  		$validator = $settings->validate_edit_mail_settings(arr::extract($_POST,array('smtp_host','smtp_port','smtp_username','smtp_password')));

                    if ($validator->check()) 
                    {
                                 $status = $settings->edit_mail_settings($_POST);
                           		//Flash message 
						        Message::success(__('update_mail_settings_flash'));
						        $this->request->redirect("settings/mail_settings");
                             }
                    else{
                        $errors = $validator->errors('errors');
                    }
                }
                $mail_settings = $settings->mail_settings($id);
                $this->selected_page_title = __("mail_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $this->page_title = __('mail_settings');
                $view = View::factory('admin/manage_mail_settings')
                        ->bind('current_uri',$id)
                        ->bind('action',$action)
                        ->bind('mail_settings',$mail_settings)
                        ->bind('errors',$errors)
                        ->bind('validator',$validator);
                $this->template->content = $view;
        }
        
        /**
	* **** Manage Ads  ****
	*/  
	public function action_manage_ads()
	{
			//set page title
			$this->page_title =  __('menu_ads');
			$this->selected_page_title = __('menu_ads');
			$this->selected_controller_title =__('menu_general_settings');
			$count_ads = $this->settings->count_ads();
			//pagination loads here
			$page_no= isset($_GET['page'])?$_GET['page']:0;
			if($page_no==0 || $page_no=='index')
			$page_no = PAGE_NO;
			$offset = ADM_PER_PAGE*($page_no-1);
			$pag_data = Pagination::factory(array (
					'current_page'   => array('source' => 'query_string','key' => 'page'),
					'items_per_page' => ADM_PER_PAGE,
					'total_items'    => $count_ads,
					'view' => 'pagination/punbb',
					));
			$get_ads = $this->settings->get_ads($offset, ADM_PER_PAGE);
			//pagination ends here
			//send data to view file
			$view = View::factory('admin/manage_ads')
							->bind('get_ads',$get_ads)
							->bind('pag_data',$pag_data)
							->bind('title',$title)
							->bind('offset',$offset);     
			$this->template->content = $view;
	}
	/**
	* **** Add Ads  ****
	*/
	public function action_add_ads()
	{	
		//set page title
		$this->page_title =  __('menu_ads');
		$this->selected_page_title = __('menu_ads');
		$this->selected_controller_title =__('menu_general_settings');
		//check current action
		$action = $this->request->action();
		//getting request for form submit
		$add =arr::get($_REQUEST,'admin_add');
		//validation starts here	
		if(isset($add) && (Validation::factory($_POST,$_FILES)))
		{
			$files=Arr::extract($_FILES,array('ads_image'));
			$post=Arr::extract($_POST, array('title','website','order'));
			$values=Arr::merge($files,$post);                   
			$validator = $this->settings->validate_ads_form($values);
			//validation check
			if ($validator->check()) 
			{							
						//after image validation it will be stored in root folder//
						$image_name = "";
						if($_FILES['ads_image']['name'] !="")
						{
								$image_type=explode('.',$_FILES['ads_image']['name']);
								$image_type=end($image_type);
								$image_name = uniqid().'.'.$image_type;
								$filename =Upload::save($_FILES['ads_image'],$image_name,DOCROOT.ADS_IMGPATH, '0777');							
								//To check Uploaded Image name is not null and product image is exist in db  //
								$image = Image::factory($filename);			               
								$path=DOCROOT.ADS_IMGPATH;
								$this->imageresize($image,ADS_RESIZE_IMAGE_WIDTH,ADS_RESIZE_IMAGE_HEIGHT,$path,$image_name,90);
						}

						$status = $this->settings->add_ads($validator,$_POST,$image_name);
						if($status == 1)
						{
							Message::success(__('add_ads_flash'));
							$this->request->redirect("settings/manage_ads");
						}else{
							$ads_exists = __("ads_exists");
						}
						//   $validator = null;

			}
				else{
				//validation error msg hits here
				$errors = $validator->errors('errors');
					}
	}
	//send data to view file
	$view = View::factory('admin/add_ads')
					->bind('validator',$validator)
					->bind('errors',$errors)
					->bind('action',$action)
					->bind('ads_exists',$ads_exists)
					->bind('title',$title);
	$this->template->content = $view;
	}
	/**
	*@Edit Ads*
	*/
	public function action_edit_ads()
	{
		//set page title
		$this->page_title =  __('edit_ads');
		$this->selected_page_title = __('edit_ads');
		$this->selected_controller_title =__('menu_general_settings');
		//check current action
		$action = $this->request->action();			
		//get current page segment id
		$adsid = $this->request->param('id');			
		$action .= "/".$adsid;
		//getting request for form submit
		$add =arr::get($_REQUEST,'admin_edit');
		$img_exist=$this->settings->check_adsphoto($adsid);
		//validation starts here	
		if(isset($add) && (Validation::factory($_POST,$_FILES)))
		{ 
				$files=Arr::extract($_FILES,array('ads_image'));
				$post=Arr::extract($_POST, array('title','website','order'));
				$values=Arr::merge($files,$post);                   
				$validator = $this->settings->validate_ads_edit($values);	 
				//validation check
				if ($validator->check())
				{	
						//after image validation it will be stored in root folder//
						$image_name = "";
						if($_FILES['ads_image']['name'] !="")
						{
								$image_type=explode('.',$_FILES['ads_image']['name']);
								$image_type=end($image_type);
								$image_name = uniqid().'.'.$image_type;
								$filename =Upload::save($_FILES['ads_image'],$image_name,DOCROOT.ADS_IMGPATH, '0777');							
								//To check Uploaded Image name is not null and product image is exist in db  //
								$image = Image::factory($filename);			               
								$path=DOCROOT.ADS_IMGPATH;
								$this->imageresize($image,ADS_RESIZE_IMAGE_WIDTH,ADS_RESIZE_IMAGE_HEIGHT,$path,$image_name,90);
						}
						// Ads image delete
						if($img_exist != '' && $image_name!= '')
						{
								if(file_exists(DOCROOT.ADS_IMGPATH.$img_exist))
								{
									unlink(DOCROOT.ADS_IMGPATH. $img_exist);
								}
						}
						$status = $this->settings->update_ads($_POST,$image_name,$adsid);
						$validator = null;
						Message::success(__('update_ads_flash'));
						$this->request->redirect("settings/manage_ads");
				}
				else{			  
						  //validation error msg hits here  
						  $errors = $validator->errors('errors');
						  }
	}				
	$ads_data = $this->settings->get_ads_data($adsid);
	$ads_exists = '';
	$view = View::factory('admin/add_ads')
					->bind('validator',$validator)
					->bind('ads_data',$ads_data[0])
					->bind('adsid',$adsid)
					->bind('ads_exists',$ads_exists)
					->bind('errors',$errors)
					->bind('action',$action)
					->bind('title',$title);				
	$this->template->content = $view;
	}
	/**
	* ****Delete Ads****
	* ads unlink listing items
	*/
	public function action_delete_ads()
	{                  
			$ads_id = $this->request->param('id');
			// Ads image delete
			$img_exist=$this->settings->check_adsphoto($ads_id);
			if(file_exists(DOCROOT.ADS_IMGPATH.$img_exist) && $img_exist != '')
			{
				unlink(DOCROOT.ADS_IMGPATH.$img_exist);
			}
			// Ads Details delete
			$status = $this->settings->delete_ads($ads_id);
			//Flash message 
			Message::success(__('delete_ads_flash'));
			$this->request->redirect("settings/manage_ads");
	}

	/**
	* ****Delete Ads****
	* ads unlink listing items
	*/
	public function action_delete_ads_image()
	{                  
			$ads_id = $this->request->param('id');
			// Ads image delete
			$img_exist=$this->settings->check_adsphoto($ads_id);
			if(file_exists(DOCROOT.ADS_IMGPATH.$img_exist) && $img_exist != '')
			{
					unlink(DOCROOT.ADS_IMGPATH.$img_exist);
			}
			$ads_data = $this->settings->get_ads_data($ads_id);
			//Flash message 
			Message::success(__('delete_ads_flash'));
			$this->request->redirect("settings/edit_ads/".$ads_id);
	}
        
} // End Settings
