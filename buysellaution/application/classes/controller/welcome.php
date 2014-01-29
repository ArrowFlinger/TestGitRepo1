<?php defined('SYSPATH') or die('No direct script access.');

/**
* Abstract class for whole script

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

abstract class Controller_Welcome extends Controller_Template {

        public $template = "admin/template"; 
        //language variables
        public $alllanguage;
        public $welcomestyle;
        public $curr_lang;
        public $action;
        public $page_title;
        public $selected_page_title;
        public $selected_controller_title;
        public $username;
        public $status;
        public $filter;
        public $session_id;
        public $input_date_time;
        public $currency_symbol;
        public $themes;
        public $site_currency;
        public $admin_session_id;

        /**
        * ****__construct()****
        *
        * Request $request Response $response
        * @return  static language(whether en, es, fr) 
        */
        public function __construct(Request $request, Response $response)
        {
		//Logout Back 
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0'); // Proxies.		
		
		
		
                $controller = $request->controller();
                $action = $request->action();
                $this->session = Session::instance();
                 //Comman & Table confic
                require Kohana::find_file('classes','common_config');
                
                //Check if install.php available in classes for installation
			if(file_exists(DOCROOT.'application/classes/install.php'))
			{
				require Kohana::find_file('classes','install');
			}
			if(file_exists(DOCROOT.'application/classes/table_config.php'))
			{
				require_once Kohana::find_file('classes','table_config');
			}
			
                // Assign the request to the controller
                $this->request = $request;
                // Assign a response to the controller
                $this->response = $response;
                //Check logged user as admin                 
                if(!(preg_match('/admin\/login/i',Request::detect_uri()) || preg_match('/admin\/forgot_password/i',Request::detect_uri()) ||  preg_match('/modules\/getAuctiontypes_ajax/i',Request::detect_uri()) )){ 
                        $this->is_login();
                }
                
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
                
		//Get site settings
		$this->site_settings = Commonfunction::get_site_settings();
		
		//site settings(common config)		
		$this->site_currency = "<font class='WebRupee'>".$this->site_settings[0]['site_paypal_currency']."</font>";
		if($this->site_settings[0]['site_paypal_currency']=='Rs.')
		{
		$this->site_currency = "<font class='WebRupee'>".$this->site_settings[0]['site_paypal_currency']."</font>";
		}else{
		$this->site_currency = "<font class=''>".$this->site_settings[0]['site_paypal_currency']."</font>";
		}	
		
		$this->facebook_app=Commonfunction::select_facebook_network();
		$this->twitter_app=Commonfunction::select_facebook_network();

		//For facebook connect	
		DEFINE("FB_APP_ID",$this->facebook_app[0]['facebook_api']);
		DEFINE("FB_APP_SECRET",$this->facebook_app[0]['facebook_secret_key']);
		DEFINE("TWITTER_CONSUMER_KEY",$this->twitter_app[0]['tiwtter_consumer_key']);
		DEFINE("TWITTER_SECRET_KEY",$this->twitter_app[0]['twitter_consumer_secret']);
		
               //Check cookie
		Cookie::$salt='id';
		$cookie=Cookie::get('id');
		if($cookie)
		{
			$this->session->set('auction_userid',$cookie);
			$fetch_username=$this->commonmodel->select_with_onecondition(USERS,'id='.$cookie);
			$this->session->set('username',$fetch_username[0]['username']);
			$this->session->set('email',$fetch_username[0]['email']);
		}

                //creating object for admin model
                $this->admin = Model::factory('admin');
                //creating object for dashboard model
                $this->dashboard = Model::factory('dashboard');
                
                 //creating object for adminproduct model	
                $this->admin_product = Model::factory('adminproduct');
                
                 //creating object for admin auction model
                $this->admin_auction = Model::factory('adminauction');
                  //creating object for admin auction model
                $this->commonmodel = Model::factory('commonfunctions');
                
                 //creating object for category model
                $this->category = Model::factory('category');
                
                //creating object for transaction model	
                $this->transaction = Model::factory('transaction');
                
                //creating object for payment log model
                $this->payment_log = Model::factory('paymentlog');
                
                //creating object for news model
                $this->news = Model::factory('adminnews');                
				 
             
                //creating object for category model
                $this->blog = Model::factory('blog');
                //For Language Defining        
                $lan_req =arr::get($_REQUEST,'admin_language');
                $this->alllanguage=array("en"=>"English","fr"=>"French","es"=>"Spanish");
                $lang=(array_key_exists($lan_req,$this->alllanguage))? $lan_req : "en" ;
                //For Filter Defining
                $this->allfilter=array("A"=>"Admin","N"=>"User");    

                //get language updated in database
                $this->get_db_lang = $this->admin->get_db_language();
                //Setting languages
                                if($_POST && isset($lan_req))
                                {
                                I18n::lang($lang);//set anguage
                                $this->session->set("admin_language",$lang);
                                }else{

                                //check session set ,if not set default lang
                                $sess_lang = strlen($this->session->get("admin_language"))>0?$this->session->get("admin_language"):$this->get_db_lang[0]['site_language'];
                                I18n::lang($sess_lang);//set anguage
                }
                $this->curr_lang = I18n::lang();//to check current lang

                //Css & Script include
                 /**To Define path for selected theme**/
                 DEFINE("ADMINIMGPATH",URL_BASE.'public/admin/images/');
                DEFINE("CSSADMIN",URL_BASE.'public/admin/');
                DEFINE('ADMINCSSPATH',CSSADMIN.'/css/');
            
                /**To Define path for selected theme**/
                DEFINE("IMGPATH",URL_BASE.'public/admin/images/');
		 
		
		
		
                $welcomestyle =Html::style('public/admin/css/admin_style.css');
                $welcomestyle .=Html::style('public/admin/css/jquery-ui-1.8.11.custom.css');
//$welcomescript=array();
                $welcomescript = array(SCRIPTPATH.'jquery-1.5.1.min.js',SCRIPTPATH.'jquery-ui-1.8.11.custom.min.js',SCRIPTPATH.'jquery-ui-timepicker-addon.js',SCRIPTPATH.'jquery.validate.js',SCRIPTPATH.'script.js');
		
		//Edited by pradeep shyam feb8 2013
		 $auction_types=array();
                if(class_exists('Controller_Modules'))
                {
					 $this->module = Model::factory('module');
					 $auction_types_list = $this->module->select_types("","M");
					 foreach($auction_types_list as $types)
					 {
						$settings = unserialize($types['settings']);
						$auction_types[$types['typeid']] = $types['typename'];
						if(is_array($settings) && array_key_exists('adminjs',$settings) && $settings['adminjs'])  
							$welcomescript =array_merge($welcomescript,array(SCRIPTPATH.'auction/'.$types['typename'].'.js?v='.time()));
						 
					 }
				}
		
		
		$custom = array('baseurl' => URL_BASE);
		$this->javascript_language=json_encode(I18n::load($this->curr_lang)+$custom);
		View::bind_global('language',$this->javascript_language);
		
		View::bind_global('auction_types',$auction_types);		 
		//End of pradeepshyam edit
			
			
			
                // Make $page_title available to all views
                View::bind_global('alllang', $this->alllanguage);
                View::bind_global('welcomestyle', $welcomestyle);
                View::bind_global('curr_lan', $this->curr_lang );

                View::bind_global('action', $action );
                View::bind_global('controller', $controller);

                // Make $page_title available to all views

                View::bind_global('page_title', $this->page_title);
                View::bind_global('selected_page_title', $this->selected_page_title);
                View::bind_global('selected_controller_title', $this->selected_controller_title);


                //status to all views
                View::bind_global('status', $this->allstatus);
                //status to all views
                View::bind_global('userstatus', $this->userstatus);
            
                //Filter type
                View::bind_global('filter', $this->allfilter);

                //Get site settings
                $this->site_settings = Commonfunction::get_site_settings();
                //For status Defining
                $this->allstatus=array("A"=>"Active","I"=>"InActive","D"=>"Delete");
                $this->userstatus=array("A"=>"Active","I"=>"InActive");
                //email url,header defining starts here//

                $ssl = ($_SERVER['SERVER_PORT'] == PORT)?HOST_HTTPS:HOST_HTTP;
                $this->url = $ssl.$_SERVER['HTTP_HOST']; 
                //common config variables and values in array
				$sitename =$this->site_settings[0]['site_name'];			
                $this->replace_variables = array(SITE_NAME => $sitename,SITE_URL => URL_BASE, SITE_LINK => URL_BASE,
                CONTACT_MAIL => $this->url, FROM_EMAIL => $this->site_settings[0]['common_email_from']); 

                DEFINE("FROM_MAIL",$this->site_settings[0]['common_email_from']);
                DEFINE("TO_ADMIN_MAIL",$this->site_settings[0]['common_email_to']);
                DEFINE("ADMIN_EMAIL",$this->site_settings[0]['contact_email']);

                //For defining paypal currency code

                $this->all_paypal_currency_code = array("AUD" => "AUD","CAD" => "CAD","CHF" => "CHF","CZK" => "CZK","DKK" => "DKK",
                "EUR" => "EUR","GBP" => "GBP","HKD" => "HKD","HUF"=>"HUF","JPY"=>"JPY","NOK"=>"NOK",
                "NZD"=>"NZD","PLN"=>"PLN","SEK"=>"SEK","SGD"=>"SGD","USD"=>"USD","MXN"=>"MXN");     

                //currency formats
                $this->currency_symbol = array( "$" => "$","€" => "€", "¥" => "¥" ,"₦" => "₦","Rs." => "Rs.");

                //Sorting Product Array
                $this->all_product_sort = array("A"=>"Active","I"=>"InActive","L"=>"Live","C"=>"Closed",'F'=>'Future','S'=>'Sold','Z'=>'Unsold',"D"=>"Delete");

                //sort products

                View::bind_global('sort_product_by',$this->all_product_sort);             
                //CURRENCY CODE 
                View::bind_global('currency_symbol',$this->currency_symbol);
                //Themes
                View::bind_global('all_themes',$this->all_themes);

                // product common settings get from here for changing page title if admin give altername

                $this->product_settings =  commonfunction::get_settings_for_products();

                //binding product common setting variable to view file

                View::bind_global('product_settings',$this->product_settings);	

                //meta keyword,description settings
                $this->meta_settings = commonfunction::get_meta_data();
                View::bind_global('meta_settings',$this->meta_settings);

                //site settings(common config)
                $this->site_settings = Commonfunction::get_site_settings();    

                //binding  common site  setting variable to view file
                View::bind_global('site_settings',$this->site_settings); 
                  //CURRENCY SYMBOLE
                View::bind_global('site_currency', $this->site_currency);
                
                //CURRENCY CODE DETAILS
                View::bind_global('all_currency_code',$this->all_paypal_currency_code);

                View::bind_global('welcomescript', $welcomescript);
                $admin = Model::factory('admin'); 
                $username = $this->session->get("username");
                //User & Admin session id get
               $session_id = $this->session->get('id');
               $admin_session_id = $this->session->get('id');
               $country=Commonfunction::countries(); 
               foreach($country as $cn)
		{
			$a[]=$cn['iso_code_2'];
			$b[]=$cn['name'];				
		}
		
		//Array of all countries
		$this->all_countries = array_combine($a,$b);
		View::bind_global('allcountries', $this->all_countries);
                View::bind_global('username', $username);	
                View::bind_global('admin_session_id', $admin_session_id);	
                View::bind_global('userid', $user_id);
                                                
                                                
                        //to show common variables in view file							
                        $this->common_email_variables = array(FROM_EMAIL,TO_MAIL,SITE_NAME,USERNAME);
                        //defining variables to corresponding email template
                        $this->all_template_variable = array(WELCOME_EMAIL=>array(CONTACT_MAIL,SITE_URL),
                        FORGOT_PASSWORD=>array(NEW_PASSWORD,SITE_LINK),
                        NEW_USER_JOIN=>array(SITE_LINK),
                        CONTACT_AUTO_REPLY => array(SUBJECT,MESSAGE,SITE_URL),
                        ADMIN_USER_DELETE => array(SITE_URL),
                        ADMIN_USER_ADD => array(USEDTOLOGIN,PASSWORD),
                        CONTACT_US_AUTO_REPLY => array(SUBJECT,FIRST_NAME,LAST_NAME,CONTACT_URL,POST_DATE,IP,MESSAGE,SITE_URL),
                        CONTACT_US => array(FIRST_NAME,LAST_NAME,CONTACT_MAIL,SUBJECT,MESSAGE,TELEPHONE,IP),
                        ADMIN_USER_ACTIVE => array(SITE_LINK),
                        ADMIN_USER_DEACTIVATE => array(SITE_LINK),
                        ACTIVATION_REQUEST => array(ACTIVATION_URL), 
                        ADMIN_CHANGE_PASSWORD=>array(PASSWORD,SITE_LINK),
                        USER_CHANGE_PASSWORD=>array(PASSWORD,SITE_LINK),
                        WINNERS_REPLY => array(SUBJECT,MESSAGE,PRODUCTNAME,PRODUCTCOST,CURRENTPRICE,SAVEAMOUNT,SITE_URL),
                        NEWS_LATTERMANAGE=>array(SUBJECT,MESSAGE,SITE_URL),
                        FACEBOOK_PASSWORD=>array(PASSWORD,SITE_LINK),
                        );
                }
                
        /**
        *is_login()*
        *
        * @param 
        * @param 
        * @return  auth session login
        */
        public function is_login()
        { 
                        $session = Session::instance();
                        if(!(isset($this->session) && $this->session->get('id') && $this->session->get('user_type')== "A"))		
                        {
                                echo __("login_access");
                                $this->request->redirect("/admin/login");
                        }	

                return 1;
        }

        /**
        * ****DisplayDateTimeFormat()****
        *
        * @param $input_date_time string
        * @param 
        * @return  time format
        */
        public function DisplayDateTimeFormat($input_date_time)
        {
                //getting input data from last login db field
                $input_date_split = explode("-",$input_date_time);
                //splitting year and time in two arrays
                $input_date_explode = explode(' ',$input_date_split[2]);
                $input_date_explode1 = explode(':',$input_date_explode[1]);
                //getting to display datetime format
                $display_datetime_format = date('j M Y h:i:s A',mktime($input_date_explode1[0], $input_date_explode1[1], $input_date_explode1[2], 
                $input_date_split[1], $input_date_explode[0], $input_date_split[0]));
                return $display_datetime_format;
        }
            
           
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
	
	
} // End Welcome
