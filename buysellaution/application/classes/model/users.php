<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains users Model database queries
 
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_users extends Model {

	/**
	* ****__construct()****
	*
	* setting up commonfunction model
	*/	
	public function __construct()
	{
		//calling communfunction model in this constructor
		$this->commonmodel=Model::factory('commonfunctions');
		$this->session=Session::instance();
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
	}
	
	/**
	* Check username exists or not for server side validation
	* @return TRUE or FALSE
	*/
	public static function unique_username($username)
    	{
		return ! DB::select(array(DB::expr('COUNT(username)'), 'total'))
		    			->from(USERS)
		    			->where('username', '=', $username)
					->and_where('status', '!=',DELETED_STATUS)
		    			->execute()
		    			->get('total');
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
					->and_where('status','!=',DELETED_STATUS)
		    			->execute()
		    			->get('total');
    	}

	/**
	* Checks email exists in database for forgot_password
	* @return TRUE or FALSE
	*/
	public static function check_email($email)
    	{
		$count_result=count(DB::select('email')
					->from(USERS)
					->where('email','=',$email)
					->execute());
		return ($count_result > 0)? true:false;
    	}
	
	/**
	* Not Empty values 
	**/
	public static function notempty($value)
	{
		if(trim($value)=="")
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	/**
	* Validation rule for fields in signup form
	*/
	public function signup_validation($arr)
	{
		$validation = Validation::factory($arr)			
				->rule('username','not_empty')	
				->rule('username', 'Model_Users::check_label_not_empty',array(":value",__('enter_username')))		
				->rule('username','alpha_dash')
				->rule('username', 'min_length',array(':value','4'))
				->rule('username', 'max_length',array(':value','50'))
				->rule('username', 'Model_Users::unique_username')
				->rule('email', 'not_empty')
				->rule('email', 'Model_Users::check_label_not_empty',array(":value",__('enter_email')))		
				->rule('email', 'max_length',array(':value','50'))
				->rule('email', 'email_domain')
				->rule('email', 'Model_Users::unique_email')
				->rule('password', 'not_empty')
				->rule('password', 'min_length', array(':value', '4'))
				->rule('password', 'Model_Users::notempty',array(":value"))		
				->rule('password', 'Model_Users::check_label_not_empty',array(":value",__('enter_password')))	
				->rule('firstname', 'not_empty')
				->rule('firstname', 'Model_Users::check_label_not_empty',array(":value",__('enter_firstname')))		
				->rule('country','Model_Users::check_country_not_null',array(":value","-1"))
				->rule('agree', 'not_empty');
		
		//Check for rule which is not in mandatory
		if(isset($arr['repassword']) && $arr['repassword']!=__('enter_repeatpassword'))
		{
			$validation->rule('repassword', 'Model_Users::check_label_not_empty',array(":value",__('enter_repeatpassword')))		
				->rule('repassword', 'matches', array(':validation','password','repassword'));
		}
		return $validation;
	}
	
	/**
	* Check inline textbox label not empty for javscript on focus and on blur
	**/
	public static function check_label_not_empty($fieldname,$value)
	{
		return ($fieldname == $value)?FALSE:TRUE;
	}

	/**
	* Check country not null
	**/
	public static function check_country_not_null($country,$value)
	{
		return ($country ==$value)?FALSE:TRUE;
	}
	
	/**
	* Reset User Password if User Forgot Password
	*/
	public function forgot_password($array_data,$_POST,$random_key)
	{
		$pass= md5($random_key);
		// Create a new user record in the database
		$result = DB::update(USERS)
					->set(array('password' => $pass))
					->where('email', '=', $array_data['email'])
					->execute();
		if($result){
			 $rs = DB::select()->from(USERS)
		 			->where('email','=', $array_data['email'])
		 			->and_where('status','=',ACTIVE)
					->execute();
			 return $rs;
		}
		else
		{
			 return 0;
		}

	}	

	/**
	* Validation rule for fields in forgot password
	*/
	public function validate_forgotpwd($arr)
	{
		return Validation::factory($arr)
					->rule('email','not_empty')
					->rule('email','max_length',array(':value','50'))
					->rule('email', 'Model_Users::check_label_not_empty',array(":value",__('enter_email')))		
					->rule('email','email_domain')
					->rule('email','Model_Users::check_email');
	}

	/**
	* Validation rule for fields in Login form
	*/
	public function login_validation($arr)
	{
		return Validation::factory($arr)
					->rule('username', 'not_empty')
					->rule('username', 'Model_Users::check_label_not_empty',array(":value",__('enter_username')))			->rule('username', 'alpha_dash')
					->rule('username', 'min_length', array(':value', '4'))
					->rule('username', 'max_length', array(':value', '30'))
					->rule('password', 'Model_Users::check_label_not_empty',array(":value",__('enter_password')))
					->rule('password', 'not_empty')
					->rule('password', 'min_length', array(':value', '4'))
					->rule('password', 'max_length', array(':value', '50'));
	}
	
	/**
	* Validation rule for fields in user  testimonials form
	*/
	public function testimonials_validation($arr)
	{
		return Validation::factory($arr)
					->rule('title', 'not_empty')
					->rule('title','alpha_space')
					->rule('title', 'min_length', array(':value', '4'))
					->rule('title', 'max_length', array(':value', '30'))
					->rule('video', 'max_length', array(':value', '600'))
					->rule('photo','Upload::type',array(':value',array('jpg', 'png', 'gif')))
					->rule('photo','Upload::size',array(':value', '2M'))
					->rule('description','not_empty')
					->rule('description', 'min_length', array(':value', '10'));
	}
	
	/**
	* Validating User Details while Updating User Details
	*/
	public function validate_user_settings($arr) 
	{		
		return Validation::factory($arr)   
					->rule('firstname', 'not_empty')
					->rule('firstname', 'min_length', array(':value', '4'))
					->rule('firstname', 'max_length', array(':value', '30'))
					 ->rule('lastname', 'max_length', array(':value', '30'))
					->rule('photo','Upload::type',array(':value',array('jpg', 'png', 'gif')))
					->rule('photo','Upload::size',array(':value', '2M'))
					->rule('country','Model_Users::check_country_not_null',array(":value","-1"))
					->rule('aboutme','not_empty')
					//->rule('address1', 'min_length', array(':value', '2'))
					->rule('aboutme', 'min_length', array(':value', '10'));						
	}	
	
	/**
	* For Facebook user signup insertion
	*/
	public function register_facebook_user($profile_data = array(),$password,$fb_access_token,$userlogin_name)
	{
		$result=DB::select()->from(USERS)
			->where('email', '=', $profile_data->email)
			->execute()
			->as_array();
		if(count($result)==0)
		{
						
			$insert_result = DB::insert(USERS, array('firstname','lastname', 'email','username', 'password','login_type','status','referral_id'))
					->values(array($profile_data->first_name,$profile_data->last_name,$profile_data->email,$userlogin_name,md5($password),'F',ACTIVE,Text::random()))
					->execute();
				
				$this->session->set("auction_userid" ,$insert_result[0]);
				$this->session->set("auction_username" ,$userlogin_name);
				$this->session->set("fb_access_token" ,$fb_access_token);
			return 1;	

		}
		else
		{
			$login_time = $this->getCurrentTimeStamp;                
			$result_login = DB::insert(USER_LOGIN_DETAILS, array('userid','login_ip','user_agent','last_login'))
						->values(array($result["0"]["id"],Request::$client_ip,Request::$user_agent,$login_time))
						->execute();				
			if(($result["0"]["usertype"] == ADMIN))
			{
			        
	                        $this->session->set("email",$result[0]["email"]);
		                $this->session->set("username",$result[0]["username"]);
		                $this->session->set("id", $result[0]["id"]);
		                $this->session->set("user_type", $result[0]["usertype"]);
								
			}
			        $this->session->set("auction_userid",$result["0"]["id"]);
			        $this->session->set("auction_username",$result[0]["username"]);
			     	
			return 0;			
		}
			
	}

        //Randomkey Generator
	public function randomkey_generator($length=0)
	{
	 	$string = Text::random('0123456789',$length);
		return $string;
	}

	/**To check if username is already exist in database**/
	public function FBusername_exist($username)
	{

		$result=DB::select()->from(USERS)
			->where('username', '=', $username)
			->execute()
			->as_array(); 

		return !empty($result)?$result:0;

	}
	
	// Select activation Code Status
	public function check_userdetails_exist($id,$key)
	{
		$result = DB::select('id','activation_code_status')->from(USERS)
			->where('id', '=', $id)
			->where('activation_code','=',$key)
			->execute()
			->as_array();		
			
			return $result;	

	}
		
	//set user status by following activation url	
	public function set_user_status_active($usr_id,$key,$settings)
	{
		if($settings[0]['admin_activation_reg'] == YES)
		{
			$sql_query = array('activation_code_status' => ACTIVATION_CODE_STATUS);
		}
		else
		{ 
			$sql_query = array('status' => ACTIVE,'activation_code_status' => ACTIVATION_CODE_STATUS);
		}
		$result =  DB::update(USERS)->set($sql_query)
					->where('id', '=' ,$usr_id)
					->and_where('activation_code', '=' ,$key)
					->and_where('status','=',IN_ACTIVE)
					->execute();
				
      		if($result)
		{
			$rs = DB::select('activation_code_status','status')->from(USERS)
						->where('id', '=', $usr_id)
						->execute()
						->as_array();						
			return $rs;     	
		}		
	}
	
	/**
	* Check Image Exist or Not while Updating User Details
	*/
	public function check_photo($userid="")
	{
		$sql = "SELECT photo FROM ".USERS." WHERE id ='$userid'";   
		$result=$this->commonmodel->select_with_onecondition(USERS,'id='.$userid);
		if(count($result) > 0)
		{ 
			return $result[0]['photo'];
		}
	}

	/**
	* update user photo null 
	*/
	public function update_user_photo($userid)
	{
		$sql_query = array('photo' => "");
		$result=$this->commonmodel->update(USERS,$sql_query,'id',$userid);
		return 1;
	}

	/**
	* update user bid account
	*/
	public function update_user_bid($bid,$userid,$bonus=1)
	{
		$sql_query =($bonus!=1)?array('user_bid_account' => $bid):array('user_bonus' => $bid);		
		return $this->commonmodel->update(USERS,$sql_query,'id',$userid);
	}
	
	/**
	* Updating User Details
	*/
	public function update_user_settings($array_data,$_POST,$userid="",$photo)
	{		 
		$mdate = $this->getCurrentTimeStamp; 
		$other = isset($_POST['other'])?$_POST['other']:0;

		// Update user records in the database
		if($array_data['lat']=="")
		{
			$sql_query = (array('firstname' =>$array_data['firstname'] ,'lastname' =>$array_data['lastname'],'aboutme' => trim(Html::chars($array_data['aboutme'])),'updated_date' => $mdate ,'country'=>$array_data['country'],'address'=>$array_data['address']));
		}
		else
		{
			$sql_query = (array('firstname' =>$array_data['firstname'] ,'lastname' =>$array_data['lastname'],'aboutme' => trim(Html::chars($array_data['aboutme'])),'updated_date' => $mdate ,'country'=>$array_data['country'],'address'=>$array_data['address'],'latitude'=>$array_data['lat'],'longitude'=>$array_data['lng']));
		}

		if($photo != "")  $sql_query[ 'photo' ]=$photo ;
		$result=$this->commonmodel->update(USERS,$sql_query,'id',$userid);		
		return ($result)?1:0;

	}

	/**
	* Validating Change Password Details
	*/
	public function validate_changepwd($arr) 
	{ 
		return Validation::factory($arr)       
					->rule('old_password', 'not_empty')
					->rule('old_password', 'max_length', array(':value', '30'))
					->rule('old_password', 'Model_users::check_pass',array(':value',$this->session->get('auction_userid')))
					->rule('new_password', 'not_empty')
					->rule('new_password', 'min_length', array(':value', '4'))
					->rule('new_password', 'max_length', array(':value', '30'))
					->rule('confirm_password', 'not_empty')
					->rule('confirm_password', 'matches', array(':validation', 'new_password', 'confirm_password'))
					->rule('confirm_password', 'max_length', array(':value', '30'));
	}
	
	/**
	* Validating shipping address Details
	*/
	public function shipping_validation($arr) 
	{ 
		$validation= Validation::factory($arr)       
				->rule('name', 'not_empty')
				->rule('name','Model_Users::check_label_not_empty',array(":value",__('enter_name')))
				->rule('name', 'alpha_space')					
				->rule('name', 'min_length', array(':value', '4'))
				->rule('name', 'max_length', array(':value', '16'))
				->rule('address1', 'not_empty')
				->rule('address1','Model_Users::check_label_not_empty',array(":value",__('enter_address1')))
				->rule('address1', 'min_length', array(':value', '4'))
				->rule('address1', 'max_length', array(':value', '50'))
				->rule('city', 'not_empty')
				->rule('city','Model_Users::check_label_not_empty',array(":value",__('enter_city')))
				->rule('city', 'min_length', array(':value', '4'))
				->rule('city', 'max_length', array(':value', '20'))
				->rule('city', 'alpha')
				->rule('country','Model_Users::check_country_not_null',array(":value","-1"))
				->rule('zipcode','Model_Users::check_label_not_empty',array(":value",__('enter_zipcode')))
				->rule('zipcode', 'not_empty')				
				->rule('zipcode', 'numeric')
				->rule('zipcode', 'min_length', array(':value', '4'))
				->rule('zipcode', 'max_length', array(':value', '10'))
				->rule('phone','Model_Users::check_label_not_empty',array(":value",__('enter_phone')))
				->rule('phone','not_empty')
				->rule('phone', 'regex', array(':value', '/^[0-9()+_-]++$/i'));
				/*->rule('phoneno','Model_Users::check_label_not_empty',array(":value",__('enter_phone')))
				->rule('phoneno','not_empty')
				->rule('phoneno', 'regex', array(':value', '/^[0-9()+_-]++$/i'));*/
		
		if(isset($arr['town']) && $arr['town']!=__('enter_town'))
		{
			$validation->rule('town', 'alpha');
		}
		return $validation;
	}
	
	/**
	* Check Whether the Entered Password is Correct While User Change Password
	*/
	public static function check_pass($pass,$userid)
	{		
		$result=DB::select('id','password')->from(USERS)->where('id','=',$userid)->execute();
		$pass=md5($pass);
		$password=$result[0]["password"];
		if($password == $pass)
		{ 
			return true;
		}
		else
		{
			return false;			
		}
	}
	
	/**
	* Update the user change password
	*/
	public function change_password($array_data,$_POST,$userid="")
	{
		$mdate = $this->getCurrentTimeStamp;
		$pass=md5($array_data['confirm_password']);
		$arr=array('password' => $pass ,'updated_date' => $mdate);

		// Create a new user record in the database
		$result=$this->commonmodel->update(USERS,$arr,'id',$userid);
		return 1;

	}	

	/**
	* select the user watchlist
	*/
	public function select_user_watchlist($uid,$offset, $val,$need_count=FALSE)
	{
		/*$query=DB::select(PRODUCTS.'.product_image',
				PRODUCTS.'.product_name',
				PRODUCTS.'.enddate',
				PRODUCTS.'.current_price',
				PRODUCTS.'.starting_current_price',
				PRODUCTS.'.product_url',
				WATCHLIST.'.watch_id')
					->from(WATCHLIST)
					->join(PRODUCTS,'left')
					->on(PRODUCTS.'.product_id','=',WATCHLIST.'.product_id')
					->where(WATCHLIST.'.user_id','=',$uid)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE);
					


					
		if($need_count)
		{
			$result=$query->order_by('watch_id','DESC')
				->execute();
			return count($result);
		}
		else
		{
			$result=$query	->limit($val)

				      	->offset($offset)
					->order_by('watch_id','DESC')
					->execute();
			return $result;
		}*/
                $query=DB::select(PRODUCTS.'.product_image',
				PRODUCTS.'.product_name',
				PRODUCTS.'.enddate',
				PRODUCTS.'.current_price',
				PRODUCTS.'.starting_current_price',
				LOWESTUNIQUE.'.current_price',
                                //BEGINNER.'.current_price',
                                // PENNYAUCTION.'.current_price',
                                // PEAK_AUCTION.'.current_price',
				PRODUCTS.'.product_url',
				WATCHLIST.'.watch_id')
					->from(WATCHLIST)
					->join(PRODUCTS,'left')
					->on(PRODUCTS.'.product_id','=',WATCHLIST.'.product_id')
					->join(LOWESTUNIQUE,'left')
					->on(LOWESTUNIQUE.'.product_id','=',WATCHLIST.'.product_id')
                                        //->join(BEGINNER,'left')
                                        //->on(BEGINNER.'.product_id','=',WATCHLIST.'.product_id')
                                        // ->join(PEAK_AUCTION,'left')
                                        //->on(PEAK_AUCTION.'.product_id','=',WATCHLIST.'.product_id')
                                        // ->join(PENNYAUCTION,'left')
                                        //->on(PENNYAUCTION.'.product_id','=',WATCHLIST.'.product_id')
					->where(WATCHLIST.'.user_id','=',$uid)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE);
		if($need_count)
		{
			$result=$query->order_by('watch_id','DESC')
				->execute();
			return count($result);
		}
		else
		{
			$result=$query	->limit($val)
				      	->offset($offset)
					->order_by('watch_id','DESC')
					->execute();
			return $result;
		}
	}	
	
	//Count for Unread messages
	public function count_unread_message($usermail)
	{
		$query=DB::select()->from(USER_MESSAGE)
				->where(USER_MESSAGE.'.usermessage_to','=',$usermail)
				->and_where(USER_MESSAGE.'.user_status','!=','D')				
				->and_where(USER_MESSAGE.'.msg_type','=',UNREAD)->execute();
			
		return count($query);
	}
	/**
	* select the user message
	*/
	public function select_user_message($usermail,$offset, $val,$need_count=FALSE)
	{
		$query=DB::select('usermessage_id','usermessage_to','usermessage_from','usermessage_subject','usermessage_message','msg_type','status')
				->from(USER_MESSAGE)
				->where(USER_MESSAGE.'.usermessage_to','=',$usermail)
				->and_where(USER_MESSAGE.'.user_status','!=',DELETED_STATUS);
				
				
		if($need_count)
		{
			$result=$query->order_by('usermessage_id','DESC')
				->execute();
			return count($result);
		}
		else
		{
			$result=$query	->limit($val)
				      	->offset($offset)
					->order_by('usermessage_id','DESC')
					->execute()->as_array();
			return $result;
		}
	}
	
	/**
	* select the user message
	*/
	public function select_user_message_readunread($usermail)
	{
		$query=DB::select('usermessage_id','msg_type')
				->from(USER_MESSAGE)
				->where(USER_MESSAGE.'.usermessage_to','=',$usermail)
				->and_where(USER_MESSAGE.'.user_status','!=',DELETED_STATUS);
				
				
		
			$result=$query->order_by('usermessage_id','DESC')
					->execute()->as_array();
			return $result;
		
	}
	
	//Delete for user messages
	public function delete_user_message($msgid)
	{
		$query= DB::delete(USER_MESSAGE)->where('usermessage_id','=',$msgid)->execute();
		return $query;
	}	
	
	/** 
	* Select users mail 	
	*/
	public function select_user_message_details($messageid)
	{
		$query=DB::select(USER_MESSAGE.'.usermessage_to',
				USER_MESSAGE.'.usermessage_from',
				USER_MESSAGE.'.usermessage_subject',
				USER_MESSAGE.'.usermessage_message',
				USER_MESSAGE.'.msg_type',
				USER_MESSAGE.'.sent_date',
				USER_MESSAGE.'.status',
				USERS.'.username',
				USERS.'.email',USERS.'.photo')
			->from(USER_MESSAGE)
			->join(USERS,'left')
			->on(USER_MESSAGE.'.usermessage_to','=',USERS.'.email')
			->where(USER_MESSAGE.'.usermessage_id','=',$messageid)				
			->execute()
			->as_array();
	
		return $query;		
	}	
	
	/**
	* select the user won auction from products table
	*/
	public function select_user_wonauctions($offset,$val,$uid,$need_count=FALSE)
	{
		
		$i=0;
		  $sql="select typename from ".AUCTIONTYPE." where pack_type='M' and status='A' and typename !='scratch' and typename !='reserve'";
					
					$query1 = Db::query(Database::SELECT, $sql)
					->execute()->as_array();		
					$arr=array();

		foreach($query1 as $results){
					
		$tablename=TABLE_PREFIX.$results['typename'];
			
		$query2=DB::select(AUCTIONTYPE.'.typename',PRODUCTS.'.product_id',PRODUCTS.'.shipping_fee',PRODUCTS.'.product_url',PRODUCTS.'.product_name',PRODUCTS.'.enddate',PRODUCTS.'.product_cost',PRODUCTS.'.product_id',PRODUCTS.'.current_price',PRODUCTS.'.product_image',$tablename.'.lastbidder_userid',PRODUCTS.'.auction_type',PRODUCTS.'.userid',array($tablename.'.product_id','table_product_id'))		
			->from($tablename)
			->join(PRODUCTS,'left')
			->on($tablename.'.product_id','=',PRODUCTS.'.product_id')
			->join(AUCTIONTYPE,'left')
			->on(AUCTIONTYPE.'.typeid','=',PRODUCTS.'.auction_type')		
			->where($tablename.'.product_process','=',CLOSED)
			->where(PRODUCTS.'.in_auction','=',2)
			->where($tablename.'.lastbidder_userid','!=',0)
			->and_where($tablename.'.lastbidder_userid','=',$uid)				
			->execute()->as_array();
		
			$arr=array_merge($arr,$query2);
			
			
			
		}
		if($need_count)
		{
			 
			return count($arr);
		}
		else
		{
			/*$result=$query	->limit($val)
					->offset($offset)
					->execute();*/
			//return $result;
			
			
			return	array_slice($arr,$offset,$val);
			
			
		}			
	}
	
	
	/** Testimonials**/
	public function add_video($add_testimonials,$photo="",$userid) 	
	{	
	
	        $url="";
		$url=$add_testimonials['video'];
				
		if($url!='')
		{
			$title = $desc = $emb_code = $thumb_url= "";
			$video_url = explode('=',$url);	
			$video_url = explode('&',$video_url[1]);	
			$video_url = $video_url[0];  
			//Video html doc file
			include Kohana::find_file('views',THEME_FOLDER.'simple_html_dom');

			$my_video = file_get_html($url); 
		        if(!is_object($my_video))
		        {
			        $msg ="failed to open video stream: HTTP request failed!";
			        //Flash message 
			        Message::success($msg);
			        return 0;
		        }
		$t =  array();
		        foreach($my_video->find('meta') as $title)
		        {
			        $t[]=$title->content ."<br>";
		        }
		        
		$title = $t[0];
		if(isset($t[2]))
		{
		$description = $t[2];  
		$tags =  '';

		        foreach($my_video->find('div#watch-tags div a') as $tag) 
		        {
			        if($tags=="")
			        {
				        $tags =  $tag->innertext; 
			        }
			        else
			        {
				        $tags = $tags.",".$tag->innertext;                 
			        }

		        } 
		       
		$embcode = "<object width='".TESTIMONIALS_VIDEO_WIDTH."' height='".TESTIMONIALS_VIDEO_HEIGHT."' wmode='opaque'><param name='movie' value='http://www.youtube.com/v/#videourl#'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/#videourl#' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='".TESTIMONIALS_VIDEO_WIDTH."' height='".TESTIMONIALS_VIDEO_HEIGHT."' wmode='transparent'></embed></object>";
		$embedcode = str_replace('#videourl#', $video_url, $embcode);
		$embedcode = str_replace('#videourl#', $video_url, $embcode);
		$thumb_url = "http://i2.ytimg.com/vi/#videourl#/default.jpg" ; 
		$thumb_url = str_replace('#videourl#', $video_url, $thumb_url);        
		$title = strip_tags(HTML::chars($title));
		$desc = strip_tags(HTML::chars($description)); 
		$thumb_url =strip_tags(HTML::chars($thumb_url));
		$embedcode =Text::reduce_slashes($embedcode);
		}
		else 
		{
		return 0;
		}
		}
		else
		{
			$embedcode=$video_url=$thumb_url="";
		}
		        if(isset($photo))
		        {
			        $photo=$photo;
		        }
		$result = DB::insert(TESTIMONIALS, array('user_id','title','description','date','embed_code','video_url','thumb_url','images'))
		->values(array($userid,$add_testimonials['title'],$add_testimonials['description'],$this->getCurrentTimeStamp,$embedcode,$video_url,$thumb_url,$photo))
		->execute();
		return 1;
					
	}
	
	 /** Testimonials**/
	public function update_video($testimonialsid,$add_testimonials,$photo="") 	
	{
	
	        $url="";
		$url=$add_testimonials['video'];		
		if($url!='')
		{
			$title = $desc = $emb_code = $thumb_url= "";
			$video_url = explode('=',$url);	
			$video_url = explode('&',$video_url[1]);	
			$video_url = $video_url[0];  
			//Video html doc file
			  include Kohana::find_file('views','admin/simple_html_dom');

			$my_video = file_get_html($url); 
		        if(!is_object($my_video))
		        {
			        $msg ="failed to open video stream: HTTP request failed!";
			        //Flash message 
			        Message::success($msg);
			        return 0;
		        }
		$t =  array();
		        foreach($my_video->find('meta') as $title)
		        {
			        $t[]=$title->content ."<br>";
		        }
		$title = $t[0];
		if(isset($t[2]))
		{
		$description = $t[2];  
		$tags =  '';

		foreach($my_video->find('div#watch-tags div a') as $tag) 
		{
			if($tags=="")
			{
				$tags =  $tag->innertext; 
			}
			else
			{
				$tags = $tags.",".$tag->innertext;                 
			}

		}  
		$embcode = "<object width='150' height='150' wmode='opaque' ><param name='movie' value='http://www.youtube.com/v/#videourl#'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/#videourl#' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='".TESTIMONIALS_VIDEO_WIDTH."' height='".TESTIMONIALS_VIDEO_HEIGHT."' wmode='transparent'></embed></object>";
		$embedcode = str_replace('#videourl#', $video_url, $embcode);
		$embedcode = str_replace('#videourl#', $video_url, $embcode);
		$thumb_url = "http://i2.ytimg.com/vi/#videourl#/default.jpg" ; 
		$thumb_url = str_replace('#videourl#', $video_url, $thumb_url);        
		$title = strip_tags(HTML::chars($title));
		$desc = strip_tags(HTML::chars($description)); 
		$thumb_url =strip_tags(HTML::chars($thumb_url));
		$embedcode =Text::reduce_slashes($embedcode);
		}
		else 
		{
		return 0;
		}
		}
		else
		{
			$embedcode=$video_url=$thumb_url="";
		}
		        if(isset($photo))
		        {
			        $photo=$photo;
		        }
				               
                $query = array('title'=>$add_testimonials['title'],'description'=>$add_testimonials['description'],'embed_code'=>$embedcode,'video_url'=>$video_url,'thumb_url'=>$thumb_url);

		if($photo != "")  $query['images']=$photo ;
		$result =  DB::update(TESTIMONIALS)->set($query)
				->where('testimonials_id', '=',$testimonialsid)
				->execute();    
              		return 1;		
	}
	
	/**To count of view Testimonials **/		 
	public function count_testimonials_auctions()
	{

	    $user_testimonials_count = DB::select(USERS.'.id',
					USERS.'.country',
					USERS.'.username',
					USERS.'.photo',
					TESTIMONIALS.'.description',					
					TESTIMONIALS.'.images',TESTIMONIALS.'.embed_code')
				->from(TESTIMONIALS)
				->join(USERS,'left')
				->on(USERS.'.id','=',TESTIMONIALS.'.user_id')
				->order_by('user_id','DESC')
				->where(TESTIMONIALS.'.testimonials_status','=',ACTIVE)
				->execute();
		 
		return count($user_testimonials_count);
	}
	
	/** 
	* Select Testimonials and users table with left join 	
	* @param $offset,$val will be for pagination
	*/
	public function select_user_testimonials($offset, $val)
	{
			$query=DB::select(USERS.'.id',
					USERS.'.country',
					USERS.'.username',
					USERS.'.photo',
					TESTIMONIALS.'.testimonials_id',
					TESTIMONIALS.'.description',
					TESTIMONIALS.'.title',	
					TESTIMONIALS.'.testimonials_status',				
					TESTIMONIALS.'.images',TESTIMONIALS.'.embed_code',TESTIMONIALS.'.thumb_url')
				->from(TESTIMONIALS)
				->join(USERS,'left')
				->on(USERS.'.id','=',TESTIMONIALS.'.user_id')
				->order_by('user_id','DESC')
				->where(TESTIMONIALS.'.testimonials_status','=',ACTIVE)
				->limit($val)
				->offset($offset)
				->execute()
				->as_array();
		
			return $query;
		
	}
	
	/**To count of view MyTestimonials **/		 
	public function count_mytestimonials_auctions($userid)
	{

	    $user_testimonials_count = DB::select(USERS.'.id',
					USERS.'.country',
					USERS.'.username',
					USERS.'.photo',
					TESTIMONIALS.'.description',					
					TESTIMONIALS.'.images',TESTIMONIALS.'.embed_code')
				->from(TESTIMONIALS)
				->join(USERS,'left')
				->on(USERS.'.id','=',TESTIMONIALS.'.user_id')
				->order_by('user_id','DESC')
				->where(USERS.'.id','=',$userid)
				->execute();
		 
		return count($user_testimonials_count);
	}
        
        
        /** 
	* Select Mytestimonials and users table with left join 	
	* @param $offset,$val will be for pagination
	*/
	public function select_user_mytestimonials($offset, $val,$userid)
	{
			$query=DB::select(USERS.'.id',
					USERS.'.country',
					USERS.'.username',
					USERS.'.photo',
					TESTIMONIALS.'.testimonials_id',
					TESTIMONIALS.'.description',
					TESTIMONIALS.'.title',	
					TESTIMONIALS.'.testimonials_status',				
					TESTIMONIALS.'.images',TESTIMONIALS.'.embed_code',TESTIMONIALS.'.thumb_url')
				->from(TESTIMONIALS)
				->join(USERS,'left')
				->on(USERS.'.id','=',TESTIMONIALS.'.user_id')
				->order_by('testimonials_id','DESC')
				->where(USERS.'.id','=',$userid)
				->limit($val)
				->offset($offset)
				->execute()
				->as_array();
		
			return $query;
		
	}
	
	/** 
	* Select Mytestimonials and users table with left join 	
	* @param $offset,$val will be for pagination
	*/
	public function select_mytestimonials($userid)
	{
			$query=DB::select()
				->from(TESTIMONIALS)
				->where(TESTIMONIALS.'.testimonials_id','=',$userid)
				
				->execute()
				->as_array();
		
			return $query;
		
	}
	/**
	* select the prices from bid history
	* @param $pid - Product id, $uid - Users id
	* @return array
	*/
	public function winner_user_amount_spent($pid,$uid)
	{
		return $query = DB::select()
			->from(BID_HISTORIES)
			->where('product_id','=',$pid)
			->and_where('user_id','=',$uid)
			->execute()
			->as_array();
	}

         /**Check Image Exist or Not while Updating testimonials Details**/
	public function check_testimonialsphoto($testimonialsid="")
	{
	
		$sql = "SELECT images FROM ".TESTIMONIALS." WHERE testimonials_id ='$testimonialsid'";
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();

			if(count($result) > 0)
			{
				return $result[0]['images'];
			}
	}
	
	//Delete Testimonials Image
	public function delete_testimonialsimage($testimonialsid="")
	{
	
	                $query = array('images'=>"");
				
			$resule   = DB::update(TESTIMONIALS)
					 ->set($query)
					 ->where('testimonials_id', '=', $testimonialsid)
					 ->execute();
        }
        
        /**
        * ****get_testimonials_data()****
        *@param $current_uri int
        *@return alluser lists
        */
	public function get_testimonials_data($current_uri = '')
	{
                $rs   = DB::select()->from(TESTIMONIALS)
                        ->where('testimonials_id', '=', $current_uri)
                        ->execute()
                        ->as_array();

                return $rs;
	}
	/**
        * ****delete_testimonials()****
        *@param $current_uri int
        *@delete user items
        */
	public function delete_testimonials($current_uri)
	{
			
			//delete user details from database
			$rs   = DB::delete(TESTIMONIALS)
					 ->where('testimonials_id', '=', $current_uri)
					 ->execute();

	}
	
	/**
	* select all bid history for mybids
	* @param $pid - Product id, $uid - Users id
	* @return array
	*/
	public function select_bids_for_users($offset,$val,$uid,$need_count=FALSE)
	{
		$select="select count(".BID_HISTORIES.".product_id),max(".BID_HISTORIES.".price),".PRODUCTS.".product_name,".PRODUCTS.".product_url,".PRODUCTS.".product_image,
".PRODUCTS.".product_process,".PRODUCTS.".enddate,".PRODUCTS.".product_image,".PRODUCTS.".in_auction FROM ".BID_HISTORIES." LEFT JOIN ".PRODUCTS." on ".PRODUCTS.".product_id = ".BID_HISTORIES.".product_id where ".BID_HISTORIES.".product_id=".PRODUCTS.".product_id and ".BID_HISTORIES.".user_id = ".$uid." and ".PRODUCTS.".product_status='".ACTIVE."'  group by ".BID_HISTORIES.".product_id,".BID_HISTORIES.".user_id order by ".BID_HISTORIES.".id desc";
		if($need_count)
		{
			$query=DB::query(Database::SELECT,$select)
				->execute()
				->as_array();
			return count($query);
		}
		else
		{

			$query=DB::query(Database::SELECT,$select." limit ".$offset.", ".$val)
				->execute()
				->as_array();
			return $query;
		}
	}
	
	/**
	* Delete the user watchlist
	*/
	public function delete_watchlist($watchid)
	{
		return $query=DB::delete(WATCHLIST)
				->where('watch_id','=',$watchid)
				->execute();
	}
	
	/**
	* Select all fields in shipping address
	* @param $userid , $need_count
	* @return when count occur return count else return query result array
	*/
	public function select_shipping_address($userid,$need_count=FALSE)
	{
		$userid=($userid!="")?$userid:"1";
		$query=DB::select()->from(SHIPPING_ADDRESS)
					->where('userid','=',$userid)
					->order_by('id','DESC')
					->execute()
					->as_array();
		if($need_count)
		{
			return count($query);
		}
		else
		{
			return $query;
		}
	}
	
	/**
	* Select balance in usertable
	* @param $userid 
	* @return when count occur return count else return query result array
	*/
	public function get_user_balances($userid)
	{
		$userid=($userid!="")?$userid:"1";
		$query=DB::select('id','user_bid_account')->from(USERS)
					->where('id','=',$userid)
					->execute()
					->as_array();	
		return $query;
	}

	/**
	* Select all fields in billing address
	* @param $userid , $need_count
	* @return when count occur return count else return query result array
	*/
	public function select_billing_address($userid,$need_count=FALSE)
	{
		$userid=($userid!="")?$userid:"1";
		$query=DB::select()->from(BILLING_ADDRESS)
					->where('userid','=',$userid)
					->order_by('id','DESC')
					->execute()
					->as_array();
		if($need_count)
		{
			return count($query);
		}
		else
		{
			return $query;
		}
	}

        //Select Product id using Bid histories table
	public function select_products_with_user($need_count=FALSE)
	{
		$query=DB::select('product_id')->distinct(TRUE)->from(BID_HISTORIES)
						->execute();
		return ($need_count)?count($query):$query;
		
	}

	/**
	* Delete the user bidhistories
	*/
	public function delete_bidhistories($watchid)
	{
		return $query=DB::delete(WATCHLIST)
				->where('watch_id','=',$watchid)
				->execute();
	}
	
	/**
	* Select all fields in transaction details table
	* @param $offset, $val(for limit), $userid , $need_count
	* @return when count occur return count else return query result array
	*/
	public function select_transactions_history($offset,$val,$userid,$need_count=FALSE)
	{
		
		/*
		
		$query=DB::select(TRANSACTION_DETAILS.'.userid',
				TRANSACTION_DETAILS.'.packageid',
				TRANSACTION_DETAILS.'.amount',
					TRANSACTION_DETAILS.'.amount_type',
					TRANSACTION_DETAILS.'.transaction_type',
					TRANSACTION_DETAILS.'.description',
					TRANSACTION_DETAILS.'.transaction_date',BIDPACKAGES.'.name',BIDPACKAGES.'.package_id')->from(TRANSACTION_DETAILS)
					->join(BIDPACKAGES,'left')
					->on(TRANSACTION_DETAILS.'.packageid','=',BIDPACKAGES.'.package_id')
					->where('userid','=',$userid);
					
		*/
		
		
		
		$query=DB::select(TRANSACTION_DETAILS.'.userid',
				TRANSACTION_DETAILS.'.packageid',
				TRANSACTION_DETAILS.'.shippingamount',
				TRANSACTION_DETAILS.'.amount',
				TRANSACTION_DETAILS.'.type',
					TRANSACTION_DETAILS.'.amount_type',
					TRANSACTION_DETAILS.'.transaction_type',
					TRANSACTION_DETAILS.'.description',
					TRANSACTION_DETAILS.'.transaction_date')->from(TRANSACTION_DETAILS)
					->where('userid','=',$userid);
		
		
						
		if($need_count)
		{
			$result=$query	->order_by('id','DESC')
					->execute()
					->as_array();
			return count($result);
		}	
		else
		{
			$result=$query	->limit($val)
					->offset($offset)						
					->order_by('id','DESC')
					->execute()
					->as_array();
			return $result;
		}
		
	}
	
	//Select facebook invites lists
	public function check_fb_invites($userid)
	{
		$query=DB::select()->from(FB_INVITE_LIST)
				->where('userid','=',$userid)
				->execute();
		return $query;
	}

        //Facebook Invites
	public function select_fb_invites($userid,$need_count=FALSE)
	{
		$query=DB::select('friends_ids')->from(FB_INVITE_LIST)
				->where('userid','=',$userid)
				->execute();
		return $need_count?count($query):$query;
	}

        // Get bonuse details
	public function get_from_bonus_tables($userid,$type,$need_count=FALSE)
	{
		$result= DB::select()->from(USER_BONUS)
			     ->where('bonus_type', '=', $type)				
			     ->and_where('userid', '=', $userid)
			     ->execute()	
			     ->as_array();	
		if($need_count)
		{
			return count($result);
		}	
		else
		{return $result;}
	}
	
	//Add User bonus 
	public function add_user_bonus($amount,$userid,$type)
	{
		$result= DB::update(USER_BONUS)
			->set(array('bonus_amount'=>$amount))
			     ->where('bonus_type', '=', $type)				
			     ->and_where('userid', '=', $userid)
			     ->execute();	
		return $result;
	}

        //Delete flike date
	public function delete_flike_date_fetch()
	{
		$result= DB::delete(FLIKE_USERS)
				->where('valid_upto','<',$this->getCurrentTimeStamp)
			     ->execute();	
		
	}
	
	//Delete social share date
	public function delete_social_date_fetch()
	{
		$result= DB::delete(SOCIAL_SHARE)
			     ->where('valid_upto','<',$this->getCurrentTimeStamp)
			     ->execute();	
		
	}
	
	/** 
	* Select users mail id 	
	*/
	public function select_user_mailid($userid)
	{
			$query=DB::select('email')
				->from(USERS)
				->where(USERS.'.id','=',$userid)
				->and_where(USERS.'.status','!=',DELETED_STATUS)
				->execute()
				->as_array();
			return $query;
	}
	
	//Site Admin name select using msg thanks & regards
	/** 
	* Select users mail id 	
	*/
	public function select_admin_username()
	{
			$query=DB::select('username')
				->from(USERS)
				->where(USERS.'.status','=',ACTIVE)
				->and_where(USERS.'.usertype','=',ADMIN)
				->execute()
				->as_array();
			return $query;
	} 
	
	public function check_fid_exists($fid)
	{
		$query=DB::select('referral_id')
				->from(FB_INVITE_LIST)
				->where(FB_INVITE_LIST.'.friends_ids','like','%'.$fid.'%')
				->limit(1)
				->execute()->get('referral_id');
		return $query;
	}
	
	public function check_user_exists($array,$bool=true)
	{
		$query =DB::select()->from(USERS);
		foreach($array as $key => $value)
		{
			switch($key)
			{
				case 'login_type':
					$query -> where('login_type','LIKE',"%".$value."%");
					break;
				case 'fbid':
					$query -> and_where('fbid','=',$value);
					break;
				case 'tid':
					$query -> and_where('tid','=',$value);
					break;
				case 'lid':
					$query -> and_where('lid','=',$value);
					break;
								
			}
		}
		$result = $query ->where('status','=',ACTIVE)->execute()->as_array();
		if($bool)
		{
			return count($result)>0?true:false;	
		}
		else{
			return $result;	
		}
			
	}

	public function check_already_existsusername($username)
	{
		$return = DB::select(array(DB::expr('COUNT(username)'), 'total'))
		    			->from(USERS)
		    			->where('username', '=', $username)
		    			->execute()
		    			->get('total');
		if($return>0)
		{
			return $username."_".Text::random('alpha',4);
		}
		else
		{
			return $username;
		}
	}

	public function insert($table,$arr)
	{
		$result=  DB::insert($table,array_keys($arr))->values(array_values($arr))
			     ->execute();
		return $result;
	}

	public function update($table,$array,$condition1,$condition2)
	{
		$query= DB::update($table)->set($array)->where($condition1,'=',$condition2)->execute();
		return $query;
	}
	
	public function validate_email_edit($arr)
	{
		return Validation::factory($arr)
				->rule('email','not_empty');
				//->rule('email','email')->rule('email',array($this,'unique_email'),array(':value'));
	}
	public static function unique_email_newsletter($email)
    	{
		return ! DB::select(array(DB::expr('COUNT(email)'), 'total'))
		    			->from(NEWSLETTER_SUBSCRIBER)
		    			->where('email', '=', $email)					
		    			->execute()
		    			->get('total');
    	}
	public function newsletter_subscriber_validation($arr)
	{
		$validation = Validation::factory($arr)
				->rule('email', 'max_length',array(':value','50'))
				->rule('email', 'Model_Users::check_label_not_empty',array(":value",__('enter_email')))		
				->rule('email', 'email_domain')
				->rule('email', 'not_empty')
				->rule('email', 'Model_Users::unique_email_newsletter');
			return $validation;
	}

	public function add_newsletter_subscriber($values,$val)
	{
			$insert_result = DB::insert(NEWSLETTER_SUBSCRIBER, array('email','signup_ip'))
					->values(array($values,$val))
					->execute();
		    //return $insert_result;
	}
	
	public function getAuction_all_Orders($auctionid,$userid)
	{
	    $query = DB::select('o.order_status')
                               ->from(array(AUCTION_ORDERS,'o'))  
                               ->where('o.buyer_id','=',$userid) 
                               ->and_where('o.auction_id','=',$auctionid)
                               ->execute()
                               ->as_array();
	    return $query;
	}
}//End of users model
?>
