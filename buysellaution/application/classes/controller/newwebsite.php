<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Abstract class for whole script
 * @Created on October 24, 2012
 * @Updated on October 24, 2012
 * @package    @Package: Nauction Platinum Version 1.0
 * @author     Ndot Team
 * @copyright  (c) 2012 Ndot Team
 * @license    http://ndot.in/license
 */

abstract class Controller_Website extends Controller_Template {
	
	public $template="themes/template";//Default
	public $users;
	public $success_msg;	
	public $curr_lang;
	public $alllanguage;
	public $failure_msg;
	public $month;
	public $url;
	public $today;
	public $auction_userid;
	public $auction_username;
	public $all_countries;
	public $email_driver="native";
	public $smtp_config="";	
	public $site_settings;
	public $site_currency;	
	public $packages;
	public $user_type;
	public $replace_variables;
	
	public function __construct(Request $request, Response $response)
	{
	        
		//Session instance
		$this->session = Session::instance();
		//Include defined Constants files
		require Kohana::find_file('classes','table_config');
		require Kohana::find_file('classes','common_config');
		// Assigning model for global access
		$this->users = Model::factory('users'); 
		$this->news = Model::factory('news');
		$this->userblog = Model::factory('userblog');
		$this->commonmodel=Model::factory('Commonfunctions');		
		$this->auctions=Model::factory('auction');
		$this->packages=Model::factory('package');
		$this->cms=Model::factory('cms');
	   	$this->settings_user = Model::factory('settings');
	   	
	        //Current Timestamp from commonfunction module
	        $this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();

		//import contact_us model
		//========================
		$this->contact_us = Model::factory('contactus');
		
		// Array for month in word
		$this->month=Date::months(Date::MONTHS_SHORT);
	
		//Get site settings
		$this->site_settings = Commonfunction::get_site_settings();
		
		//for site maintanence purpose
		//=============================
		if( ($this->site_settings[0]['maintenance_mode'] == ACTIVE && $this->user_type != ADMIN) ){
		        //Check logged user as admin 
		        if(!(preg_match('/users\/login/i',Request::detect_uri()) || preg_match('/users\/signup/i',Request::detect_uri()) || preg_match('/users\/testimonials_details/i',Request::detect_uri()) || preg_match('/users\/forgot_password/i',Request::detect_uri())  ))
				
		        {
			        //Override the template variable decalred in website controller
                               $this->template="themes/template";
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
		//site settings(common config)		
		$this->site_currency = "<font class='WebRupee'>".$this->site_settings[0]['site_paypal_currency']."</font>";
		if($this->site_settings[0]['site_paypal_currency']=='Rs.')
		{
		$this->site_currency = "<font class='WebRupee'>".$this->site_settings[0]['site_paypal_currency']."</font>";
		}else{
		$this->site_currency = "<font class=''>".$this->site_settings[0]['site_paypal_currency']."</font>";
		}	
		
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
		$this->replace_variables = array(SITE_NAME => AUCTION_SCRIPT ,SITE_URL => $this->url, SITE_LINK => $this->url,
			  	CONTACT_MAIL => $this->url,FROM_EMAIL => $this->site_settings[0]['common_email_from']);
                
		DEFINE("FROM_MAIL",$this->site_settings[0]['common_email_from']);
		DEFINE("TO_ADMIN_MAIL",$this->site_settings[0]['common_email_to']);
		DEFINE("ADMIN_EMAIL",$this->site_settings[0]['contact_email']);
	        
	        //Define theme name 
	        DEFINE("THEME_NAME",$this->site_settings[0]['theme']);
	        
		$this->facebook_app=Commonfunction::select_facebook_network();
		
		$this->twitter_app=Commonfunction::select_facebook_network();

		//For facebook connect	
		DEFINE("FB_APP_ID",$this->facebook_app[0]['facebook_api']);
		DEFINE("FB_APP_SECRET",$this->facebook_app[0]['facebook_secret_key']);
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

		$url_theme=arr::get($_REQUEST,'theme');
		$theme_array=array("black","blue","orange","pink");

		if(isset($url_theme) && in_array($url_theme,$theme_array))
		{
		$selected_theme=$url_theme;

		}
		else
		{
		/**To get selected theme**/
		$selected_theme=$this->site_settings[0]['theme'];
		}


                //Current Theme Select
               // $selected_theme=$this->site_settings[0]['theme'];
				
		//For bonus types
		DEFINE("FACEBOOK_LIKE",12);
		DEFINE("FACEBOOK_INVITE",3);
		DEFINE("FACEBOOK_SHARE",9);

                /**To get selected theme in view**/
		DEFINE("THEME",$selected_theme);
		DEFINE("THEME_FOLDER","themes/".THEME."/");               

                /**To Define path for selected theme**/
                DEFINE("CSSPATH",URL_BASE.'public/'.THEME.'/css/');

                /**To Define path for selected theme**/
                DEFINE("IMGPATH",URL_BASE.'public/'.THEME.'/images/'); 
		DEFINE("SOLD_IMAGE",'sold.png');
		DEFINE("PRODUCTSOLD_IMAGE",'product-sold.png');			              
        	DEFINE("FEATURED_IMAGE",'star_featured.png');
		DEFINE("BONUS_ENABLED",'bonus_enabled.jpg');

		// Assigning scripts and style
		// Define defaults	
		$lang_css=CSSPATH.$this->curr_lang.'_style.css';				
		$styles = array($lang_css =>'screen',URL_BASE.LIGHTBOX_CSSPATH=>'screen',CSSPATH.'global.css' =>'screen',CSSPATH.'skin.css' =>'screen',CSSPATH.'jquery.scroll.css' => 'screen');
		$scripts = array(SCRIPTPATH.'jquery-1.5.1.min.js',
				SCRIPTPATH.'auctionscript.js',
				//SCRIPTPATH.'json2.js',
				SCRIPTPATH.'slides.min.jquery.js',
				SCRIPTPATH.'jquery.jcarousel.js',
				LIGHTBOX_SCRIPTPATH,);
		  
		//Meta tags and keywords
		$meta_datas=Commonfunction::get_meta_data();
		$this->site_name=$site_name[0]['site_name'];
		$this->metadescription= $site_name[0]['site_name'].$meta_datas[0]['meta_description'];
		$this->metakeywords=  $site_name[0]['site_name'].$meta_datas[0]['meta_keywords'];
		$this->title= SITE_TITLE_CAPTION.$site_name[0]['site_name'];  
		
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
		View::bind_global('site_name', $site_name[0]['site_name']);
		View::bind_global('month', $this->month);
		View::bind_global('styles', $styles);
		View::bind_global('scripts', $scripts);
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
		$jquery_custom_array=array(__('last_bidder'),__('your_balance_low'),__('added_in_your_watchlist'),__('already_in_your_watchlist'),__('login_access'),__('bid_me_label'),__('login_labels'),__('no_bids_to_be_added'),__('are_you_sure_delete'));
		$jquery_custom_msg="<div id='forlanguage' style='display:none;'>".implode(",",$jquery_custom_array)."</div>";
		View::bind_global('jquery_custom_msg',$jquery_custom_msg);

		//Perform this method whatever page loads
		//To split up live and future auctions 
		$date=date("Y-m-d H:i:s");
		$result=$this->auctions->select_live_auctions($date);
		foreach($result as $product_result)
		{	
		
			$now=$this->create_timestamp($date);
			$db_date=$this->create_timestamp($product_result['startdate']);
			$db_end_date=$this->create_timestamp($product_result['enddate']);
			
			//Check if current date timestamp equals to db date timestamp
			if($now==$db_date)
			{
				$timestamp=time()+$product_result['max_countdown'];
				$this->commonmodel->update(PRODUCTS, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$product_result['product_id']);
			}
	
			//Check if current date timestamp is greater than item end date timestamp
			if($now>$db_end_date)
			{
				$this->commonmodel->update(PRODUCTS, array('product_process'=>CLOSED),'product_id',$product_result['product_id']);
			}
		}

		//To transfer future to live
		$future_result=$this->auctions->select_transfer_future_live_auctions($date);
		foreach($future_result as $future_product_result)
		{			
			$now=$this->create_timestamp($date);
			$db_date=$this->create_timestamp($future_product_result['startdate']);
			$db_end_date=$this->create_timestamp($future_product_result['enddate']);
			
			//Check if current date timestamp equals to db date timestamp
			if($now==$db_date)
			{
				$timestamp=time()+$future_product_result['max_countdown'];
				$this->commonmodel->update(PRODUCTS, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$future_product_result['product_id']);
			}
	
			//Check if current date timestamp is greater than item end date timestamp
			if($now>$db_end_date)
			{
				$this->commonmodel->update(PRODUCTS, array('product_process'=>CLOSED),'product_id',$future_product_result['product_id']);
			}
		}

		//Fetch category list
		$category=$this->commonmodel->select_with_onecondition(PRODUCT_CATEGORY,"status='A'");
		View::bind_global('category_list',$category);
		
		/*date_default_timezone_set($this->site_settings[0]['country_time_zone']);
		Fetch user balance*/
		if($this->auction_userid!="")
		{
			$user_account_balance=$this->commonmodel->select_with_onecondition(USERS,"id=".$this->auction_userid)->as_array();
			if(count($user_account_balance)>0)
			{
			$balance=Commonfunction::numberformat($user_account_balance[0]['user_bid_account']);
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
		
		
		// Assign the request to the controller
		$this->request = $request;

		// Assign a response to the controller
		$this->response = $response;	
		
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
			Message::error( __('login_access'));
			$this->request->redirect("/users/login/");
		}
		
		return;
	}
	
} // End Welcome
