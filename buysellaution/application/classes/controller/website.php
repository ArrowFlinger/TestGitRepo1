<?php defined('SYSPATH') or die('No direct script access.');

/**
* Abstract class for whole script

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

abstract class Controller_Website extends Controller_Template {
	
	public $template;
	public $users;
	public $success_msg;	
	public $curr_lang;
	public $alllanguage;
	public $failure_msg;
	public $month;
	public $url;
	public $selected_page_title;	
	public $today;
	public $limit = 10;
	public $auction_userid;
	public $auction_username;
	public $all_countries;
	public $email_driver="native";
	public $smtp_config="";	
	public $site_settings;
	public $javascript_language;
	public $site_currency;	
	public $packages;
	public $user_type;
	public $replace_variables;
	public $scripts;
	
	public function __construct(Request $request, Response $response)
	{
	  
                //Logout Back 
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0'); // Proxies.
		//Session instance
		$this->session = Session::instance();
		//Include defined Constants files
		require Kohana::find_file('classes','common_config');
		//Check if install.php available in classes for installation
		if(file_exists(DOCROOT.'application/classes/install.php'))
		{
			require_once Kohana::find_file('classes','install');
		}
		if(file_exists(DOCROOT.'application/classes/table_config.php'))
		{
			require_once Kohana::find_file('classes','table_config');
		}
			
		$install_success= $this->session->get("install_success");
		if(isset($install_success))
		{
		Message::success($install_success); 
		$this->session->delete('install_success');
	        }
		// Assigning model for global access
		$this->users = Model::factory('users'); 
		$this->news = Model::factory('news');
		$this->userblog = Model::factory('userblog');
		$this->commonmodel=Model::factory('Commonfunctions');		
		$this->auctions=Model::factory('auction');
		$this->packages=Model::factory('package');
		$this->cms=Model::factory('cms');
	   	$this->settings_user = Model::factory('settings');
	   	$this->admin_product = Model::factory('adminproduct');
	   	// Assign the request to the controller

		 $auction_types=array();
		 $auction_types_list =array();
		if(class_exists('Controller_Modules'))
		{
			 $this->module = Model::factory('module');
			 $auction_types_list = $this->module->select_types("","M");
			  foreach($auction_types_list as $types)
					 {
						  $auction_types[$types['typeid']] = $types['typename'];
					 }
			 $auction_types_list_autobid = $this->module->select_types_for_autobid("","M");
			
		}
		View::bind_global('auction_list_type',$auction_types_list);
		View::bind_global('auction_types_list_autobid',$auction_types_list_autobid);
		View::bind_global('auction_types',$auction_types);
	                      
		$this->request = $request;

		// Assign a response to the controller
		$this->response = $response;	
		
	        //Current Timestamp from commonfunction module
	        $this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();

		//import contact_us model
		//========================
		$this->contact_us = Model::factory('contactus');
		
		// Array for month in word
		$this->month=Date::months(Date::MONTHS_SHORT);
	
		//Get site settings
		$this->site_settings = Commonfunction::get_site_settings();
		
		
	        //Define theme name
		//$this->site_settings[0]['theme']="pink";
		DEFINE("THEME_NAME",$this->site_settings[0]['theme']);
		

		//for site maintanence purpose
		//=============================
		if( ($this->site_settings[0]['maintenance_mode'] == ACTIVE && $this->user_type != ADMIN) ){
		
		        //Check logged user as admin 
		        if(!(preg_match('/users\/login/i',Request::detect_uri()) || preg_match('/users\/signup/i',Request::detect_uri()) || preg_match('/users\/testimonials_details/i',Request::detect_uri()) || preg_match('/users\/forgot_password/i',Request::detect_uri())  ))
				
		        {
			        //Override the template variable decalred in website controller
               if(THEME_NAME=='white')
	        {
	       $this->template="themes/".THEME_NAME."/template";
	        }else{
	        $this->template="themes/template";
	        
	        } 
                        }	
		        else
		        {
			        //Override the template variable decalred in website controller
                                 $this->template="themes/template_user_sidebar";
		        }
		}
		
		// For language
		$lan=arr::get($_REQUEST,'language');
		$this->alllanguage=array("en"=>"English","fr"=>"French","es"=>"Spanish");
		$lang=(array_key_exists($lan,$this->alllanguage))? $lan : $this->site_settings[0]['site_language'] ; 	
			
		// Setting languages
                if($_POST && isset($lan))
                {
                        I18n::lang($lang);//set language
                        $this->session->set("language",$lang);
                        Message::success(__("language_changed",array(":param"=>$this->alllanguage[$lang])));
                }
                else
                {
                        $sess_lang = strlen($this->session->get("language"))>0?$this->session->get("language"):$this->site_settings[0]['site_language'];
                        I18n::lang($sess_lang);//set language
                }
		//checking current lang
                $this->curr_lang = I18n::lang();
				
		//Added on Aug 9 2012
		$lang_file =array();
		$lang_file = (include APPPATH.'i18n/'.$lang.'.php');
	
		//site settings(common config)
		$this->currency_code = $this->site_settings[0]['site_paypal_currency_code'];
		/*$this->site_currency = "<font class='WebRupee'>".$this->site_settings[0]['site_paypal_currency']."</font>";*/
		 
		if($this->site_settings[0]['site_paypal_currency']=='Rs.')
		{  
		$this->site_currency = "<font class='WebRupee'>".$this->site_settings[0]['site_paypal_currency']."</font>";		
		}else{
		$this->site_currency = "<font class=''>".$this->site_settings[0]['site_paypal_currency']."</font>";		
		}	
		define("SITECURRENCY",$this->site_currency);
		
		$this->paypal_account = $this->session->get('paypal_account');
		//To get site settings from common function
		$site_name=Commonfunction::get_site_settings();
		//To get site settings from common function
		$country=Commonfunction::countries(); 
		foreach($country as $cn)
		{
			$a[]=$cn['iso_code_2'];
			$b[]=$cn['name'];				
		}
		
		//Array of all countries
		$this->all_countries = array_combine($a,$b);

		//common config variables and values in array	
		$ssl = ($_SERVER['SERVER_PORT'] == PORT)?HOST_HTTPS:HOST_HTTP;
		$this->url = $ssl.$_SERVER['HTTP_HOST'];
		$sitename =$this->site_settings[0]['site_name'];	
		$this->replace_variables = array(SITE_NAME => $sitename ,SITE_URL => URL_BASE, SITE_LINK => URL_BASE,
			  	CONTACT_MAIL => $this->site_settings[0]['common_email_from'],FROM_EMAIL => $this->site_settings[0]['common_email_from']);
                
		DEFINE("FROM_MAIL",$this->site_settings[0]['common_email_from']);
		DEFINE("TO_ADMIN_MAIL",$this->site_settings[0]['common_email_to']);
		DEFINE("ADMIN_EMAIL",$this->site_settings[0]['contact_email']);
		$this->facebook_app=Commonfunction::select_facebook_network();
       	         View::bind_global('facebook_app', $this->facebook_app);
		$this->twitter_app=Commonfunction::select_facebook_network();
                View::bind_global('twitter_app', $this->twitter_app);
		//For facebook connect	
		DEFINE("FB_APP_ID",$this->facebook_app[0]['facebook_api']);
		DEFINE("FB_APP_SECRET",$this->facebook_app[0]['facebook_secret_key']);
		DEFINE("FB_INVITE_TEXT",$this->facebook_app[0]['facebook_invite_text']);
		DEFINE("TWITTER_CONSUMER_KEY",$this->twitter_app[0]['tiwtter_consumer_key']);
		DEFINE("TWITTER_SECRET_KEY",$this->twitter_app[0]['twitter_consumer_secret']);
	
		switch($this->curr_lang)
		{
			case "fr":
				$this->include_facebook=Commonfunction::include_facebook('fr_FR');
				break;
			case "es":
				$this->include_facebook=Commonfunction::include_facebook('es_MX');
				break;
			default:
				$this->include_facebook=Commonfunction::include_facebook();
				break;
		}

		/*April-2,selvam for products add by user*/
		 $this->product_settings =  commonfunction::get_settings_for_products();

          //binding product common setting variable to view file

         View::bind_global('product_settings',$this->product_settings);
		/***/
		
		$url_theme=arr::get($_REQUEST,'theme');
		$theme_array=array("black","blue","orange","pink","white");

		if(isset($url_theme) && in_array($url_theme,$theme_array))
		{
			$selected_theme=$url_theme;

		}
		else
		{
			/**To get selected theme**/
			$selected_theme=$this->site_settings[0]['theme'];
			
		}
		//tempory
		   //Theme change in session
			if(isset($url_theme) && $url_theme!="")
			{
				
				$this->session->set('auction_themes',$url_theme);
				$selected_theme =$url_theme;
			}
			else
			{
				$selected_theme = $this->session->get('auction_themes');
				if(!$this->session->get('auction_themes'))
				{
					$selected_theme=$this->site_settings[0]['theme'];
				}
			}
                      
		/**To Define view file path for themes**/
		DEFINE('VIEW_PATH',DOCROOT.'application/views/themes/'.$selected_theme.'/');
		
		/**To get selected theme in view**/
		DEFINE("SELECTED_THEME_FOLDER",'themes/'.$selected_theme.'/');

		/**Assigning Default Template to load**/
		$this->template='themes/template';

		/**To get selected theme template**/
		if(file_exists(VIEW_PATH.'template.php'))
		{
			$this->template=SELECTED_THEME_FOLDER.'template';
		}  

        /**  This model is add for product listing cost***/
		//For bonus types
		DEFINE("FACEBOOK_LIKE",12);
		DEFINE("FACEBOOK_INVITE",3);
		DEFINE("FACEBOOK_SHARE",9);

                /**To get selected theme in view**/		
		DEFINE("THEME",$selected_theme);
		DEFINE("THEME_FOLDER","themes/".THEME."/");  
			/** PAGINATION **/
		
		if(THEME=='white')
		{		
		DEFINE('PAGINATION_FOLDER','pagination/punbb_userside_white');
		}else{
		DEFINE('PAGINATION_FOLDER','pagination/punbb_userside');		
		}  
		/**To Define path for selected theme**/
		DEFINE("CSSPATH",URL_BASE.'public/'.THEME.'/css/');
		/**To Define path for selected theme**/
		DEFINE("IMGPATH",URL_BASE.'public/'.THEME.'/images/'); 
		DEFINE("SOLD_IMAGE",'sold.png');
		DEFINE("PRODUCTSOLD_IMAGE",'product-sold.png');			              
		DEFINE("FEATURED_IMAGE",'star_featured.png');
		DEFINE("BONUS_ENABLED",'bonus_enabled.jpg');
		/*April,2 selvam*/
		$start=date("Y-m-d")." "."00:00:01";
		$current_date=date("Y-m-d H:i:s",time());
		$today = date("Y-m-d")." "."23:59:59";
		$week=date("Y-m-d H:i:s",strtotime("-1 week"));
		$month=date("Y-m-d H:i:s",strtotime("-1 month"));
		define("CURRENT_DATE",$current_date);
		define("TODAY_START",$start);
		define('TODAY',$today);     
		define('WEEK',$week); 
		define('MONTH',$month);  		
		// Assigning scripts and style
		// Define defaults	
		$lang_css=CSSPATH.$this->curr_lang.'_style.css';				
		$styles = array($lang_css =>'screen',URL_BASE.LIGHTBOX_CSSPATH=>'screen',CSSPATH.'global.css' =>'screen');
		$scripts = array(SCRIPTPATH.'jquery-1.5.1.min.js',
				SCRIPTPATH.'auction/auctionscript.js',
				SCRIPTPATH.'slides.min.jquery.js',
				LIGHTBOX_SCRIPTPATH);
				$this->scripts = $scripts;
		  
		//Meta tags and keywords
		$meta_datas=Commonfunction::get_meta_data();
		$this->site_name=$site_name[0]['site_name'];
		$this->metadescription= $site_name[0]['site_name'].$meta_datas[0]['meta_description'];
		$this->metakeywords=  $site_name[0]['site_name'].$meta_datas[0]['meta_keywords'];
		$this->title= SITE_TITLE_CAPTION.$site_name[0]['site_name']; 		
		$this->limit =REC_PER_PAGE;		
		//Check cookie
		Cookie::$salt='auction_userid';
		$cookie=Cookie::get('auction_userid');
		if($cookie)
		{
			$this->session->set('auction_userid',$cookie);
			$fetch_username=$this->commonmodel->select_with_onecondition(USERS,'id='.$cookie);
			$this->session->set('auction_username',$fetch_username[0]['username']);
			$this->session->set('auction_email',$fetch_username[0]['email']);
		}
		$auction_type=$this->auctions->select_types();
		if(count($auction_type)==0)
		{
			//$this->commonmodel->insert(AUCTIONTYPE,array('typename'=>'auctions','status'=>ACTIVE));
		}
				
		//server get
		$this->server_name=$_SERVER['HTTP_HOST'];
		$this->server_uri=$_SERVER['REQUEST_URI'];
		View::bind_global('server_name', $this->server_name);
		View::bind_global('server_uri', $this->server_uri);
		// Getting user id and username from sessions and store in variable declared in public
		$this->auction_userid=$this->session->get("auction_userid");
		$this->auction_username=$this->session->get("auction_username");
		$this->auction_email=$this->session->get("auction_email");
		$this->user_type=$this->session->get("user_type");
		
		//Facebook invite
		$fbrequest=Arr::extract($_GET,array('app_request_type','request_ids'));
		if(isset($fbrequest['app_request_type'])  || isset($fbrequest['request_ids']))
		{
			Message::success('Thanks for visting our site via facebook');
			try{
				FB::instance()->auth();
				$fbuserid = FB::instance()->me();
				$referral_id = $this->users->check_fid_exists($fbuserid['id']);
				$this->request->redirect('/cmspage/page/how-it-works?source=facebookinvite&uid='.$referral_id.'&type='.FACEBOOK_INVITE);				
			}
			catch(Exception $e)
			{
				Message::success('Error occured');
			}
			
		}	
		
                //Online status insert
		Commonfunction::check_users_online_status($this->auction_userid);

		// Failure session
		$this->failure_msg=$this->session->get("failure_msg");

		// Success session
		$this->success_msg=$this->session->get("success_msg");
		
		// Request redirect
		$this->url=Request::current();       
		
		//User message fetch
		$count_msg=$this->users->count_unread_message($this->auction_email); 
		//Admin user name get
		$admin_username=$this->users->select_admin_username();
		View::bind_global('admin_username',$admin_username);
		View::bind_global('auction', $this->auctions);
		// Binding global variables
		View::bind_global('alllang', $this->alllanguage);
		View::bind_global('count_msg', $count_msg);
		View::bind_global('allcountries', $this->all_countries);
		View::bind_global('auction_userid', $this->auction_userid);
		View::bind_global('auction_email', $this->auction_email);
		View::bind_global('auction_username', $this->auction_username);
		View::bind_global('user_type', $this->user_type);
		View::bind_global('site_currency', $this->site_currency);
		View::bind_global('currency_code', $this->currency_code);
		View::bind_global('site_name', $site_name[0]['site_name']);
		View::bind_global('month', $this->month);
		 View::bind_global('selected_page_title', $this->selected_page_title);
		View::bind_global('site_settings', $this->site_settings );
		View::bind_global('curr_lan', $this->curr_lang );
		View::bind_global('replace_variables', $this->replace_variables );
		View::bind_global('success_msg',$this->success_msg);
		View::bind_global('failure_msg',$this->failure_msg);
		
		//For right template sidebar
		View::bind_global('future_results',$this->future_results);
		View::bind_global('future_results_forslide',$this->future_results_forslide);
		View::bind_global('closed_results_forslide',$this->closed_results_forslide);
		View::bind_global('closed_results',$this->closed_results);
		View::bind_global('count_future_result_index',$this->count_future_result_index);
		View::bind_global('count_closed_result_index',$this->count_closed_result_index);
		View::bind_global('today',$this->today);

		//For template sidebar
		//Select products which all are in future	
		$this->future_results=$this->auctions->select_future_auctions_index($this->getCurrentTimeStamp);

		$this->count_future_result_index=$this->auctions->select_future_auctions_index($this->getCurrentTimeStamp,FALSE,TRUE);
		
		$this->future_results_forslide=$this->auctions->select_future_auctions_index($this->getCurrentTimeStamp,TRUE);
		
		$this->closed_results=$this->auctions->select_closed_auctions_index();
		
		$this->closed_results_forslide=$this->auctions->select_closed_auctions_index(TRUE);
		
		$this->count_closed_result_index=$this->auctions->select_closed_auctions_index(FALSE,TRUE);
		
		//pagination loads here Recently closed 
                //=====================================
                $page_no= isset($_GET['page'])?$_GET['page']:0;
                $count_closed_auctions = $this->auctions->select_closed_auctions(NULL,REC_PER_PAGE,TRUE);
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = REC_CLO_PAGE*($page_no-PAGE_NO);
                $pagination_recently = Pagination::factory(array (
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'total_items'    => $count_closed_auctions,  //total items available
                'items_per_page'  => REC_CLO_PAGE,  //total items per page
                'view' => PAGINATION_FOLDER,  //pagination style
                'auto_hide'      => TRUE,
                'first_page_in_url' => TRUE,
                ));   
                $recently_results= $this->auctions->select_closed_auctions($offset,REC_CLO_PAGE); 
                $count_closed_recently= $this->auctions->select_closed_auctions($offset,REC_CLO_PAGE,TRUE);
                View::bind_global('pagination_recently',$pagination_recently);
		View::bind_global('recently_results',$recently_results);
		View::bind_global('count_closed_recently',$count_closed_recently); 		
                //****pagination ends here***//
		//get today timestamp
		$this->today=$this->today_midnight();

		//Delete FLIKE USERS which meets today date
		$this->users->delete_flike_date_fetch();
		$this->users->delete_social_date_fetch();
		//For custom message fetch in jquery
		$jquery_custom_array=array('baseurl' => URL_BASE,'unix_timestamp' => time());		
		$this->javascript_language=json_encode(I18n::load($this->curr_lang)+$jquery_custom_array);
		View::bind_global('language',$this->javascript_language);
		//Perform this method whatever page loads
		//To split up live and future auctions 
		$date=date("Y-m-d H:i:s");
		//To transfer future to live
		$types = array();
		$auc_types=array();
		if(!$this->request->is_ajax())
		{
			$future_result=$this->auctions->select_transfer_future_live_auctions($date);
			
			foreach($auction_types_list as $type)
			{			
				$controller = 'Kohana_'.ucfirst($type['typename']);
				if(class_exists($controller))
				{		
						$types[$type['typeid']] = $type['typename'];
				}			
			}
			foreach($future_result as $future_product_result)
			{			
				if(array_key_exists($future_product_result['auction_type'], $types)){
					$now=$this->create_timestamp($date);
					$db_date=$this->create_timestamp($future_product_result['startdate']);
					$db_end_date=$this->create_timestamp($future_product_result['enddate']);	
					$tablename = TABLE_PREFIX.$types[$future_product_result['auction_type']];
					$dynamicupdate = true;
					if(array_key_exists('dynamic_update',$future_product_result) && $future_product_result['dynamic_update']==1)
					{
						$dynamicupdate = false;
					}
					
					if($dynamicupdate){
					//Check if current date timestamp equals to db date timestamp
					if($now>$db_end_date)
					{
							$this->commonmodel->update(PRODUCTS, array('in_auction'=>2),'product_id',$future_product_result['product_id']);
							
							$this->commonmodel->update($tablename, array('product_process' => CLOSED),'product_id',$future_product_result['product_id']);
					}
					else if($now>=$db_date && $future_product_result['in_auction']==4)
					{
						
							$this->commonmodel->update(PRODUCTS, array('in_auction'=>1),'product_id',$future_product_result['product_id']);
							try{
								$moduleauctions = $this->commonmodel->select_with_onecondition2($tablename,'product_id='.$future_product_result['product_id']);
								$this->commonmodel->update($tablename, array('product_process' => LIVE,'increment_timestamp' =>(time()+$moduleauctions['max_countdown'])),'product_id',$future_product_result['product_id']);
							}
							catch(Exception  $e)
							{
								$this->commonmodel->insert(TABLE_PREFIX.'logs',array('logs'=>'Product is not updated'.$future_product_result['product_id']));
							}
					}
					}
				}//Array key exists end
			
			}
			
		}
		
			
			foreach($types as $key)
			{
				
				$auc_types[]=SCRIPTPATH.'auction/'.$key.'.js';
				
			}
			$scripts=array_merge($scripts,$auc_types);
			$auccss_types = array(); 
			foreach($types as $key)
			{ 
				if(file_exists(DOCROOT.'public/'.THEME.'/auction/'.$key.'/css/'.$key.'_'.$this->curr_lang.'_style'.'.css'))
				{
					$auccss_types[URL_BASE.'public/'.THEME.'/auction/'.$key.'/css/'.$key.'_'.$this->curr_lang.'_style'.'.css']='screen';
				}
			} 
			$styles=array_merge($styles,$auccss_types); 
		
			
			
			
		//Fetch category list
		$category=$this->commonmodel->select_with_onecondition(PRODUCT_CATEGORY,"status='A'");
		
			foreach($category as $cn)
			{
				$c[]=$cn['id'];
				$d[]=$cn['category_name'];				
			}
		
		if(isset($c) && isset($d)){
		$this->categorylist = array_combine($c,$d);	
		
		}else{
			$c[]=0;
			$d[]='';
		$this->categorylist = array_combine($c,$d);	
		}
		View::bind_global('category_list_white',$this->categorylist);
		
		View::bind_global('category_list',$category);
		
		//For footer Email_subscriber
		$category_footer=$this->commonmodel->select_with_onecondition(PRODUCT_CATEGORY,"status='A'");
		View::bind_global('category_list_footer',$category_footer);
		
		//Country Time Zone
		date_default_timezone_set($this->site_settings[0]['country_time_zone']);
		/*Fetch user balance*/
		if($this->auction_userid!="")
		{
			$user_account_balance=$this->commonmodel->select_with_onecondition(USERS,"id=".$this->auction_userid)->as_array();
			if(count($user_account_balance)>0)
			{
			$balance=$user_account_balance[0]['user_bid_account']>0?Commonfunction::numberformat($user_account_balance[0]['user_bid_account']):0;
			if($user_account_balance[0]['user_bonus']!=""){
				        $bonus_balance=Commonfunction::numberformat($user_account_balance[0]['user_bonus']);
				}
				else
				{
					$bonus_balance=Commonfunction::numberformat(0);
				}
			}
			else
			{

				$balance=0;
				$bonus_balance=0;
			}
		}
		else
		{	
			$balance=Commonfunction::numberformat(0);
			$bonus_balance=Commonfunction::numberformat(0);
		}
		
		
		View::bind_global('user_current_balance',$balance);
		View::bind_global('user_current_bonus',$bonus_balance);
		View::bind_global('scripts', $scripts);
		View::bind_global('styles', $styles);
		
		$this->update_autobid_account();
		 
		/** redirect maintainance mode page start **/

		if( ($this->site_settings[0]['maintenance_mode'] == ACTIVE && $this->user_type != ADMIN) ){

			//Check logged user as admin 
			if(!(preg_match('/offline\/index/i',Request::detect_uri()))){

				$this->request->redirect("/offline/index");
			}
		}

		/** redirect maintainance mode page end **/
		$submit=$this->request->post('subscriber');		
		if(isset($submit)){
		$form_values=arr::extract($_POST, array('email'));
		$validate=$this->users->newsletter_subscriber_validation($form_values);
		if($validate->check()) {
			$subc_ip=Request::$client_ip;
			$ins=$this->users->add_newsletter_subscriber($form_values,$subc_ip);
				
				
				//$this->users->add_subscriber_ip($subc_ip);			
				$site_name = $this->site_settings[0]['site_name'];
				$this->newsletter_email = array(TO_MAIL => $form_values['email']);				
				$this->replace_variable = array_merge($this->replace_variables,$this->newsletter_email);				
				$mail = Commonfunction::get_email_template_details(SUBSCRIBER_EMAIL, $this->replace_variable,SEND_MAIL_TRUE);
				
				if($mail == MAIL_SUCCESS_SUB)
				{
					Message::success(__('newsletter_registration_success_msg'));
					$this->request->redirect("/#");
					
				}
							
			}			
			else
			{			
				$errors=$validate->errors('errors');
								
			}
		}			
		View::bind_global('subscriber_errors', $errors);	
	

		
	}//End of construct method
	
        /**
        * ****Create unix timestamp****
        * @param $date eg. 2011-11-16 20:15:00
        * @return unix timestamp with given date and time
        */ 
	public function create_timestamp($date)
	{
		$split=explode(" ",$date);
		$date=explode("-",$split[0]);
		$time=explode(":",$split[1]);
		return  $mktime = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
	}
	
        /**
        * ****Create unix timestamp for tonight****
        * @return unix timestamp with given date and time
        */ 
	public function today_midnight()
	{
		$dated=date("Y-m-d")." "."23:59:59";
		return $this->create_timestamp($dated);
	}
	
	
        /**
        * ****convert date into string format****
        * @param $date eg. 2011-11-16 20:15:00
        * @return unix timestamp with given date and time
        */	
	public function date_to_string($date)
	{
		return date("M d, h:i A",strtotime($date));
	}
	
	/** Checking User Login **/
	public function is_login()
	{ 
		$session = Session::instance();
		if( ($this->site_settings[0]['maintenance_mode'] == ACTIVE && $this->user_type != ADMIN) ){
		
		$this->request->redirect("/");
		
		}
	        // To check Whether the user is logged in or not
		if(!$this->session->get('auction_userid'))		
		{
			$uri =Request::detect_uri();
			if(substr(Request::detect_uri(),0,1)!=="/")
			{
				$uri = "/".Request::detect_uri();
			}
			 
			$this->session->set('usercurrent_uri',substr(URL_BASE,0,-1).$uri); 
			Message::error( __('login_access'));
			$this->request->redirect("/users/login/");
		}
		
		return;
	}
	
	public function update_autobid_account()
	{
		//print_r($auction_types_list);
		$result=$this->auctions->selectall_autobid_closed();
		 
		foreach($result as $products)
		{
			if($products['dedicated_auction']!=ENABLE){
				//get user balance and add the amount
				$amts= Commonfunction::get_user_balance($products['userid']) + $products['bid_amt'];
			}
			else
			{
				//get user bonus and add the amount
				$amts=Commonfunction::get_user_bonus($products['userid'])+$products['bid_amt'];	

			}			
			$this->commonmodel->update(USERS,array('user_bid_account'=>$amts),'id',$products['userid']);
			$this->auctions->delete_autobid($products['userid'],$products['product_id']);
		}
		return;
	}
	

	
	
} // End Welcome
