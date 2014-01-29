<?php defined("SYSPATH") or die("No direct script access.");
/**
* Contains Api controller actions

* @Created on October 15, 2013

* @Updated on October 15, 2013

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/
class Model_api extends Model{

/*
 * 
 * name: unknown
 * @param
 * @return
 * 
 */
	public function __construct(){	 
		$this->getCurrentTimeStamp=Api::getCurrentTimeStamp();		
	}
	/******Validate Sign up Form*********/	
	public function signup_validation($arr)
	{
		$validation = Validation::factory($arr)			
				->rule('username','not_empty')
				->rule('email', 'not_empty')
				->rule('password', 'not_empty')
				->rule('firstname', 'not_empty');
		
		return $validation;
	}
	public function get_user_settings()
	{
			$result = DB::select()
					->from(USERS_SETTINGS)
					->execute()
					->as_array();
			return $result;
	}
	public function select_with_onecondition($table,$cond="",$need_count=FALSE)
	{
	        $cond = ($cond !="")?$cond:"1=1 ";
		$query=DB::query(Database::SELECT,"select * from ".$table." where ".$cond)->execute();
		if($need_count)
		{
			return count($query);
		}
		else
		{
			return $query;
		}
		
	}
	public function insert($table,$arr)
	{
		$result=  DB::insert($table,array_keys($arr))->values(array_values($arr))
			     ->execute();
		return $result;
	}
	public function get_bonus_amount($type_id)
	{
		$query=DB::select('bonus_type_id','bonus_amount','bonus_status')->from(BONUS)
					->where('bonus_type_id','=',$type_id)
					->and_where('bonus_status','=',ACTIVE)
					->execute()
					->as_array();	
		return $query;
	}
	public function random_user_password_generator()
	{
		$string = Text::random('hexdec', RANDOM_KEY_LENGTH);
		return $string;
	}
	public static function check_label_not_empty($fieldname,$value)
	{
		return ($fieldname == $value)?FALSE:TRUE;
	}
	public static function unique_username($username)
	{
		return ! DB::select(array(DB::expr('COUNT(username)'), 'total'))
					->from(USERS)
					->where('username', '=', $username)
					->and_where('status', '!=','D')
					->execute()
					->get('total');
	}
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
	public static function check_country_not_null($country,$value)
	{
		return ($country ==$value)?FALSE:TRUE;
	}
	public static function unique_email($email)
    	{
		return ! DB::select(array(DB::expr('COUNT(email)'), 'total'))
		    			->from(USERS)
		    			->where('email', '=', $email)
					->and_where('status','!=','D')
		    			->execute()
		    			->get('total');
    	}
  /**
	* To Get All Email templates
	* @param $templateid
	* @return array
	**/
	public function get_template_details($templateid)
	{
		$result=  DB::select('email_from','email_to','email_subject','email_content')->from(EMAIL_TEMPLATE)
				      ->where('id','=',$templateid)
				      ->or_where('template_code','=',$templateid)
				      ->execute()	
				      ->as_array();
		return $result;		
		
	}
	public function check_emailformat_to_send($arr)
	{	 
		return Validation::factory($arr)
				->rule('from','email_domain')
				->rule('to','email_domain');
	}
	public function save_email($to,$from,$subject,$message)
	{
	      	$rs   = DB::insert(USER_MESSAGE)
				->columns(array('usermessage_to','usermessage_from','usermessage_subject','usermessage_message'))
				->values(array($to,$from,$subject,$message))
				->execute();	
		        
	}
	public function get_smtp_settings()
	{
					$result = DB::select()
									->from(SMTP_SETTINGS)
									->execute()
									->as_array();
					return $result;
	}
		public function login_validation($arr)
	{
		return Validation::factory($arr)
					->rule('username', 'not_empty')
					->rule('password', 'not_empty');
	}
	/** 
	* Login function common
	* @param $table=tablename
	* @param $arr="field name and values for where in associative array"
	* @param $rem ="1" ,Default is NULL
	* @returns TRUE or FALSE when query count>0
	**/
	public function login($table,$arr,$rem="")
	{
		$value= $this->split_for_where($arr,"AND");
		$query=DB::query(Database::SELECT, "select id,username,usertype,status from ".$table." where ".$value." AND status!='".DELETED_STATUS."'")->execute();
		if(count($query)>0)
		{
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/** 
	* Select rows with where in query
	* @param $table=tablename
	* @param $arr="field name and values for where in associative array"
	* @param $condition ="AND or OR" (Either one will be used)
	* @param $need_count ="TRUE or FALSE"
	* @returns array when need_count = false
	* @return count values when need_count=true
	**/
	public function selectwhere($table,$arr,$condition="AND",$need_count=FALSE)
	{
		$value= $this->split_for_where($arr,$condition);
		$query=DB::query(Database::SELECT,"select * from ".$table." where ".$value)->execute();
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
	* Update function common
	* @param $table=tablename
	* @param $arr="field name and values for where in associative array"
	* @param $cond1, $cond2 for where
	* @returns array
	**/
	public function update($table,$arr,$cond1,$cond2)
	{
		$query=DB::update($table)->set($arr)->where($cond1,'=',$cond2)->execute();
		return $query;
	}
	/** 
	* Create where condition for query, based on parameter $condition
	* Eg: $arr = array(username=>'smith',password='123456')
	* returns  username = 'smith' AND password = '123456'
	**/
	public function split_for_where($arr,$condition="AND")
	{
		//Fetch Keys in array			
		$keys= array_keys($arr);
	
		//Fetch Values in array
		$values=array_values($arr);

		$output="";
		for($i=0; $i< count($keys);$i++)
		{
			// Prints for e.g: Keys = 'values' ,
			$output.= $keys[$i]."="."'".$values[$i]."',";
		}
		return str_replace(","," ".$condition." ",substr($output, 0, -1));
	}
		/**
	* Validation rule for fields in forgot password
	*/
	public function validate_forgotpwd($arr)
	{
		return Validation::factory($arr)
					->rule('email','not_empty');					 					
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
	* Validating Change Password Details
	*/
	public function validate_changepwd($arr) 
	{		
		return Validation::factory($arr)       
					->rule('old_password', 'not_empty')
					->rule('new_password', 'not_empty')
					->rule('confirm_password', 'not_empty');
	}
		public static function check_email($email)
		{
		$count_result=count(DB::select('email')
			->from(USERS)
			->where('email','=',$email)
			->execute());
		return ($count_result > 0)? true:false;
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
		$result=$this->update(USERS,$arr,'id',$userid);
		return 1;

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
	* Select product category table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
		public function select_product_cat($id,$need_count=FALSE)
		{
			$query=DB::select()->from(PRODUCT_CATEGORY)
						->where('id','=',$id)
						->execute();
			return ($need_count)?count($query):$query;
		}


	public function select_category_count($category_id,$need_count=false)	
	{ 
		$i=0;
		  $sql="select typename from ".AUCTIONTYPE." where pack_type='M' and status='A'";
					
					$query1 = Db::query(Database::SELECT, $sql)
					->execute()->as_array();		
					$arr=array();
					
		foreach($query1 as $results){
					
		$tablename=TABLE_PREFIX.$results['typename'];
		
		
		if($category_id!=''){
			
		$query2=DB::select(PRODUCTS.'.product_id',PRODUCTS.'.auction_type',array($tablename.'.product_id','table_product_id'))
			->from($tablename)
			->join(PRODUCTS,'left')
			->on($tablename.'.product_id','=',PRODUCTS.'.product_id')
			
			->join(PRODUCT_CATEGORY,'left')
			->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
			->where(PRODUCTS.'.product_category','=',$category_id)
			
			->execute()->as_array();
			
		}else{
			
			$query2=DB::select(PRODUCTS.'.product_id',PRODUCTS.'.auction_type',array($tablename.'.product_id','table_product_id'))
			->from($tablename)
			->join(PRODUCTS,'left')
			->on($tablename.'.product_id','=',PRODUCTS.'.product_id')
			
			->join(PRODUCT_CATEGORY,'left')
			->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
			
			->execute()->as_array();
			
			
			
			}	
			

			$arr=array_merge($arr,$query2);
					
		}
				
		if($need_count)
		{
			 
			return count($arr);
		}
		else
		{
			
		return	array_slice($arr,0);
			
			
		}			
				
		
		
	}
		public function select_types($module_id="",$packtype="",$active = true)
	{ 
		$query = DB::select()->from(AUCTIONTYPE);
		
		if($active)
		{
		   $query->where(AUCTIONTYPE.'.status','=',ACTIVE);
		}
		
		if($module_id!="")
		{
			$query ->and_where(AUCTIONTYPE.'.typeid','=',$module_id);
			if($packtype!="")
			{
				$query ->and_where(AUCTIONTYPE.'.pack_type','=',$packtype)
								->execute()->current();
			}
			else {	$result = $query ->execute()->current();}
		}
		else
		{ 
			if($packtype!="")
			{
			$result =	$query ->and_where(AUCTIONTYPE.'.pack_type','=',$packtype)
								->execute()->as_array();
			}
			else {	$result = $query ->execute()->as_array();}
		}
		 
								
		return $result;
	}
	public function select_types_for_autobid($module_id="",$packtype="",$active = true)
	{ 
		$query = DB::select()->from(AUCTIONTYPE);		
		
		if($active)
		{
		   $query->where(AUCTIONTYPE.'.status','=',ACTIVE);
		}
		
		if($module_id!="")
		{
			$query ->and_where(AUCTIONTYPE.'.typeid','=',$module_id);
				 
			if($packtype!="")
			{
				$query ->and_where(AUCTIONTYPE.'.pack_type','=',$packtype)
						->and_where(AUCTIONTYPE.'.typename','!=','lowestunique')
						->and_where(AUCTIONTYPE.'.typename','!=','highestunique')
						->and_where(AUCTIONTYPE.'.typename','!=','buyerseller')
								->execute()->current();
			}
			else {	$result = $query ->execute()->current();}
		}
		else
		{ 
			if($packtype!="")
			{
			$result =	$query ->and_where(AUCTIONTYPE.'.pack_type','=',$packtype)
								->and_where(AUCTIONTYPE.'.typename','!=','lowestunique')								 
								->and_where(AUCTIONTYPE.'.typename','!=','highestunique')								 
								->and_where(AUCTIONTYPE.'.typename','!=','buyerseller')								 
								->execute()->as_array();
			}
			else {	$result = $query ->execute()->as_array();}
		}
		 
								
		return $result;
	}

	  public function select_beginner_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{			
		switch($status)
		{						
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;	
			
			case 7:
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;			
      
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				BEGINNER.'.product_cost',
				BEGINNER.'.current_price',
				BEGINNER.'.bidding_countdown',
				BEGINNER.'.bidamount',
				PRODUCTS.'.product_status',
				PRODUCTS.'.in_auction',
				BEGINNER.'.product_process',
				BEGINNER.'.auction_process',
				BEGINNER.'.lastbidder_userid',
				BEGINNER.'.startdate',
				BEGINNER.'.enddate',
				BEGINNER.'.increment_timestamp',
				BEGINNER.'.max_countdown',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				BEGINNER.'.starting_current_price',
				PRODUCTS.'.auction_type',
				AUCTIONTYPE.'.typename',
				//PRODUCTS.'.shipping_fee',
				//PRODUCTS.'.shipping_info',				
				BEGINNER.'.autobid',
				PRODUCTS.'.autobid',
				USERS.'.id',
				USERS.'.username',				
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(BEGINNER,'left')
					->on(PRODUCTS.'.product_id','=',BEGINNER.'.product_id')
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					->join(USERS,'left')
					->on(BEGINNER.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{
		     if($array['category_id']!='')
		    {
		     $query ->join(PRODUCT_CATEGORY,'left')
				    ->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
				    ->where(PRODUCTS.'.product_category','=',$array['category_id']);
				
		     }
			
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}
		else if($id=="PD")
		{
			
			$result=$query->execute()->as_array();
			
			return ($need_count)?count($result):$result;
		
		}		
		else if($id=="OL")
		{
			$query=$query->and_where(BEGINNER.'.product_process','=',LIVE)->and_where(BEGINNER.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(BEGINNER.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(BEGINNER.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
			
		}
		else
		{
			$query=$query->and_where(BEGINNER.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}
	  public function select_penny_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{		

		switch($status)
		{						
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;		
			case 7:				
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;
			
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PENNYAUCTION.'.product_cost',
				PENNYAUCTION.'.current_price',
				PENNYAUCTION.'.bidding_countdown',
				PENNYAUCTION.'.bidamount',
				PRODUCTS.'.product_status',
				PENNYAUCTION.'.product_process',
				PENNYAUCTION.'.auction_process',
				PENNYAUCTION.'.lastbidder_userid',
				PENNYAUCTION.'.startdate',
				PENNYAUCTION.'.enddate',
				PENNYAUCTION.'.increment_timestamp',
				PENNYAUCTION.'.max_countdown',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				PENNYAUCTION.'.starting_current_price',
				PRODUCTS.'.auction_type',
				AUCTIONTYPE.'.typename',
				//PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				//PRODUCTS.'.shipping_info',				
				PENNYAUCTION.'.autobid',
				PRODUCTS.'.autobid',
				USERS.'.id',
				USERS.'.username',		
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(PENNYAUCTION,'left')
					->on(PRODUCTS.'.product_id','=',PENNYAUCTION.'.product_id')
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					->join(USERS,'left')
					->on(PENNYAUCTION.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
					
						
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
				
			}

		if($id=="CT" && !empty($array))
		{
		   
		    if($array['category_id']!=''){
		
		 
		     $query ->join(PRODUCT_CATEGORY,'left')
				    ->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
				    ->where(PRODUCTS.'.product_category','=',$array['category_id']);
				
		    }	
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}		
		else if($id=="OL")
		{
			
			$query=$query->and_where(PENNYAUCTION.'.product_process','=',LIVE)->and_where(PENNYAUCTION.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(PENNYAUCTION.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(PENNYAUCTION.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}
		else if($id=="PD")
		{
			//$query=$query->and_where(PENNYAUCTION.".product_id",'=',$ids);
			$result=$query->execute()->as_array();
		
			return ($need_count)?count($result):$result;
		
		}	       
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;			
		}
		else
		{
			$query=$query->and_where(PENNYAUCTION.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}
	 public function select_peak_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{	
		switch($status)
		{
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;	
			case 7:
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;			
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PEAK_AUCTION.'.product_cost',
				PEAK_AUCTION.'.current_price',
				PEAK_AUCTION.'.bidding_countdown',
				PEAK_AUCTION.'.bidamount',
				PRODUCTS.'.product_status',
				PEAK_AUCTION.'.product_process',
				PRODUCTS.'.in_auction',
				PEAK_AUCTION.'.auction_process',
				PEAK_AUCTION.'.lastbidder_userid',
				PEAK_AUCTION.'.startdate',
				PEAK_AUCTION.'.enddate',
				PEAK_AUCTION.'.increment_timestamp',
				PEAK_AUCTION.'.timediff',
				PEAK_AUCTION.'.max_countdown',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				PEAK_AUCTION.'.starting_current_price',
				PEAK_AUCTION.'.auction_starttime',
				PEAK_AUCTION.'.auction_endtime',
				PRODUCTS.'.auction_type',
				AUCTIONTYPE.'.typename',
				//PRODUCTS.'.shipping_fee',
				//PRODUCTS.'.shipping_info',				
				PEAK_AUCTION.'.autobid',
				PRODUCTS.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(PEAK_AUCTION,'left')
					->on(PRODUCTS.'.product_id','=',PEAK_AUCTION.'.product_id')
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					->join(USERS,'left')
					->on(PEAK_AUCTION.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{
				if($array['category_id']!='')
				{
						$query ->join(PRODUCT_CATEGORY,'left')
									->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
									->where(PRODUCTS.'.product_category','=',$array['category_id']);
				}
					
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="OL")
		{
			$query=$query->and_where(PEAK_AUCTION.'.product_process','=',LIVE)->and_where(PEAK_AUCTION.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(PEAK_AUCTION.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(PEAK_AUCTION.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}
		else if($id=="PD")
		{
			//$query=$query->and_where(PEAK_AUCTION.".product_id",'=',$ids);
			$result=$query->execute()->as_array();
			
			return ($need_count)?count($result):$result;
		
		}	
                
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
			
		}
		else
		{
			$query=$query->and_where(PEAK_AUCTION.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}

	 public function select_lowestunique_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
    {
			
		switch($status)
		{			
			
			case 4:
				//Only live
				$id="OL";
				break;
			case 7:
				//Category
				$id="CT";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;	
			case 8:
				//Search
				$id="S";
				break;
			
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				LOWESTUNIQUE.'.product_cost',
				LOWESTUNIQUE.'.current_price',				
				PRODUCTS.'.product_status',
				LOWESTUNIQUE.'.product_process',
				LOWESTUNIQUE.'.auction_process',
				LOWESTUNIQUE.'.lastbidder_userid',
				LOWESTUNIQUE.'.startdate',
				LOWESTUNIQUE.'.enddate',
				LOWESTUNIQUE.'.increment_timestamp',
				LOWESTUNIQUE.'.max_countdown',
				LOWESTUNIQUE.'.bidamount',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				LOWESTUNIQUE.'.starting_current_price',
				PRODUCTS.'.auction_type',
				AUCTIONTYPE.'.typename',
				//PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				//PRODUCTS.'.shipping_info',				
				LOWESTUNIQUE.'.autobid',
				PRODUCTS.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(LOWESTUNIQUE,'left')
					->on(PRODUCTS.'.product_id','=',LOWESTUNIQUE.'.product_id')
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					->join(USERS,'left')
					->on(LOWESTUNIQUE.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{
		    
		    if($array['category_id']!='')
		    {
			
		     $query ->join(PRODUCT_CATEGORY,'left')
				    ->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
				    ->where(PRODUCTS.'.product_category','=',$array['category_id']);
				 
			 }
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}			
		else if($id=="OL")
		{
			$query=$query->and_where(LOWESTUNIQUE.'.product_process','=',LIVE)->and_where(LOWESTUNIQUE.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(LOWESTUNIQUE.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(LOWESTUNIQUE.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}
		else if($id=="PD")
		{
			//$query=$query->and_where(LOWESTUNIQUE.".product_id",'=',$ids);
			$result=$query->execute()->as_array();
		
			return ($need_count)?count($result):$result;
		
		}  
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		}
		else
		{
			$query=$query->and_where(LOWESTUNIQUE.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}
		public function select_highestunique_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{
			
		switch($status)
		{			
			
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;
			case 7:
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;
							
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				HIGHESTUNIQUE.'.product_cost',
				HIGHESTUNIQUE.'.current_price',				
				PRODUCTS.'.product_status',
				HIGHESTUNIQUE.'.product_process',
				HIGHESTUNIQUE.'.auction_process',
				HIGHESTUNIQUE.'.lastbidder_userid',
				HIGHESTUNIQUE.'.startdate',
				HIGHESTUNIQUE.'.enddate',
				HIGHESTUNIQUE.'.increment_timestamp',
				HIGHESTUNIQUE.'.max_countdown',
				HIGHESTUNIQUE.'.bidamount',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				HIGHESTUNIQUE.'.starting_current_price',
				PRODUCTS.'.auction_type',
				AUCTIONTYPE.'.typename',
				//PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				//PRODUCTS.'.shipping_info',				
				HIGHESTUNIQUE.'.autobid',
				PRODUCTS.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(HIGHESTUNIQUE,'left')
					->on(PRODUCTS.'.product_id','=',HIGHESTUNIQUE.'.product_id')
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					->join(USERS,'left')
					->on(HIGHESTUNIQUE.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{
		    
		    if($array['category_id']!='')
		    {
			
		     $query ->join(PRODUCT_CATEGORY,'left')
				    ->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
				    ->where(PRODUCTS.'.product_category','=',$array['category_id']);
				 
			 }
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		
		else if($id=="OL")
		{
			$query=$query->and_where(HIGHESTUNIQUE.'.product_process','=',LIVE)->and_where(HIGHESTUNIQUE.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(HIGHESTUNIQUE.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(HIGHESTUNIQUE.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}
		 else if($id=="PD")
		{
			//$query=$query->and_where(HIGHESTUNIQUE.".product_id",'=',$ids);
			$result=$query->execute()->as_array();
		
			return ($need_count)?count($result):$result;
		
		}
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
			
		}
		else
		{
			$query=$query->and_where(HIGHESTUNIQUE.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}

	public function select_reserve_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{
			
		switch($status)
		{			
			
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;
			case 7:
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;
			
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				RESERVE.'.product_cost',
				RESERVE.'.current_price',
				PRODUCTS.'.product_status',
				RESERVE.'.product_process',
				RESERVE.'.auction_process',
				RESERVE.'.lastbidder_userid',
				RESERVE.'.startdate',
				RESERVE.'.enddate',
				RESERVE.'.increment_timestamp',
				RESERVE.'.max_countdown',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				RESERVE.'.starting_current_price',
				PRODUCTS.'.auction_type',
				AUCTIONTYPE.'.typename',
				//PRODUCTS.'.shipping_fee',
				//PRODUCTS.'.in_auction',
				PRODUCTS.'.shipping_info',				
				RESERVE.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(RESERVE,'left')
					->on(PRODUCTS.'.product_id','=',RESERVE.'.product_id')
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					
					->join(USERS,'left')
					->on(RESERVE.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{
			if($array['category_id']!='')
			{
			
		     $query ->join(PRODUCT_CATEGORY,'left')
				    ->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
				    ->where(PRODUCTS.'.product_category','=',$array['category_id']);
				 
			 }
					
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}else if($id=="OL")
		{
			$query=$query->and_where(RESERVE.'.product_process','=',LIVE)->and_where(RESERVE.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(RESERVE.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(RESERVE.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}
			else if($id=="PD")
		{
			//$query=$query->and_where(RESERVE.".product_id",'=',$ids);
			$result=$query->execute()->as_array();
		
			return ($need_count)?count($result):$result;
		
		}	
					
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
			
		}
		else
		{
			$query=$query->and_where(RESERVE.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}

	 public function select_scratch_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
    {
			
		switch($status)
		{			
			
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;
			case 7:
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;
			
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				SCRATCHAUCTION.'.product_cost',
				SCRATCHAUCTION.'.current_price',
				SCRATCHAUCTION.'.bidding_countdown',
				SCRATCHAUCTION.'.bidamount',
                                SCRATCHAUCTION.'.bids',
                                SCRATCHAUCTION.'.timetobuy',
                                SCRATCHAUCTION.'.product_stock',
				PRODUCTS.'.product_status',
				SCRATCHAUCTION.'.product_process',
				SCRATCHAUCTION.'.auction_process',
				SCRATCHAUCTION.'.lastbidder_userid',
				SCRATCHAUCTION.'.startdate',
				SCRATCHAUCTION.'.enddate',
				SCRATCHAUCTION.'.increment_timestamp',
				SCRATCHAUCTION.'.max_countdown',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				SCRATCHAUCTION.'.starting_current_price',
				PRODUCTS.'.auction_type',
				AUCTIONTYPE.'.typename',
				//PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				//PRODUCTS.'.shipping_info',				
				SCRATCHAUCTION.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(SCRATCHAUCTION,'left')
					->on(PRODUCTS.'.product_id','=',SCRATCHAUCTION.'.product_id')
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					
					->join(USERS,'left')
					->on(SCRATCHAUCTION.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{ 
			$query ->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->where(PRODUCTS.'.product_category','=',$array['category_id']);
					//->limit($array['limit'])
					//->offset($array['offset']);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		
		else if($id=="OL")
		{
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','=',LIVE)->and_where(SCRATCHAUCTION.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(SCRATCHAUCTION.'.auction_process','!=','H');
                       
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	else if($id=="PD")
		{
			
			$result=$query->execute()->as_array();
		
			return ($need_count)?count($result):$result;
		
		}	
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
			
		}
		else
		{
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}	
	public function select_seat_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{
			
		switch($status)
		{			
			
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;
			case 7:
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;
			
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.userid',
				SEAT.'.product_cost',
				SEAT.'.current_price',
				SEAT.'.bidding_countdown',
				SEAT.'.bidamount',
				SEAT.'.seat_cost',
				SEAT.'.min_seat_limit',
				SEAT.'.max_seat_limit',
				SEAT.'.seat_enddate',
				PRODUCTS.'.product_status',
				SEAT.'.product_process',
				SEAT.'.auction_process',
				SEAT.'.lastbidder_userid',
				SEAT.'.startdate',
				SEAT.'.auction_started',
				SEAT.'.enddate',
				SEAT.'.increment_timestamp',
				SEAT.'.max_countdown',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				SEAT.'.starting_current_price',
				PRODUCTS.'.auction_type',
				AUCTIONTYPE.'.typename',
				//PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				//PRODUCTS.'.shipping_info',				
				SEAT.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(SEAT,'left')
					->on(PRODUCTS.'.product_id','=',SEAT.'.product_id')
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					
					->join(USERS,'left')
					->on(SEAT.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{
			if($array['category_id']!='')
			{
			
		     $query ->join(PRODUCT_CATEGORY,'left')
				    ->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
				    ->where(PRODUCTS.'.product_category','=',$array['category_id']);
				 
			 }
					
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		
		else if($id=="OL")
		{
			$query=$query->and_where(SEAT.'.product_process','=',LIVE)->and_where(SEAT.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(SEAT.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(SEAT.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}else if($id=="PD")
		{
			//$query=$query->and_where(SEAT.".product_id",'=',$ids);
			$result=$query->execute()->as_array();
		
			return ($need_count)?count($result):$result;
		
		}	 
  
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
			
		}
		else
		{
			$query=$query->and_where(SEAT.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}
	
	public function select_cashback_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{	
		switch($status)
		{			
			
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;
			case 7:
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;
			
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				CASHBACK.'.product_cost',
				CASHBACK.'.current_price',
				CASHBACK.'.bidding_countdown',
				CASHBACK.'.bidamount',
				PRODUCTS.'.product_status',
				CASHBACK.'.product_process',
				CASHBACK.'.auction_process',
				CASHBACK.'.lastbidder_userid',
				CASHBACK.'.startdate',
				CASHBACK.'.enddate',
				CASHBACK.'.increment_timestamp',
				CASHBACK.'.max_countdown',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				CASHBACK.'.starting_current_price',
				PRODUCTS.'.auction_type',
				//PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				//PRODUCTS.'.shipping_info',				
				CASHBACK.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(CASHBACK,'left')
					->on(PRODUCTS.'.product_id','=',CASHBACK.'.product_id')
					->join(USERS,'left')
					->on(CASHBACK.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
						
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{
			$query ->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->where(PRODUCTS.'.product_category','=',$array['category_id']);
					//->limit($array['limit'])->offset($array['offset']);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}		
		else if($id=="OL")
		{
			$query=$query->and_where(CASHBACK.'.product_process','=',LIVE)->and_where(CASHBACK.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(CASHBACK.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(CASHBACK.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}else if($id=="PD")
		{
			//$query=$query->and_where(CASHBACK.".product_id",'=',$ids);
			$result=$query->execute()->as_array();
		
			return ($need_count)?count($result):$result;
		
		}	   
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
			
		}
		else
		{
			$query=$query->and_where(CASHBACK.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}

	 public function select_clock_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{
			
		switch($status)
		{			
			
			case 4:
				//Only live
				$id="OL";
				break;
			case 6:
				//Product Detail
				$id="PD";
				break;
			case 7:
				//Category
				$id="CT";
				break;
			case 8:
				//Search
				$id="S";
				break;
			
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				CLOCK.'.product_cost',
				CLOCK.'.current_price',
				CLOCK.'.bidding_countdown',
				CLOCK.'.bidamount',
				CLOCK.'.reduction',
				PRODUCTS.'.product_status',
				CLOCK.'.product_process',
				CLOCK.'.auction_process',
				CLOCK.'.lastbidder_userid',
				CLOCK.'.startdate',
				CLOCK.'.enddate',
				CLOCK.'.increment_timestamp',
				CLOCK.'.max_countdown',
				CLOCK.'.clock_buynow_status',
				CLOCK.'.clock_buynow_status_date',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',
				CLOCK.'.starting_current_price',
				PRODUCTS.'.auction_type',
				//PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				//PRODUCTS.'.shipping_info',				
				CLOCK.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(CLOCK,'left')
					->on(PRODUCTS.'.product_id','=',CLOCK.'.product_id')
					->join(USERS,'left')
					->on(CLOCK.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.'.product_status','=',ACTIVE);
					
					
					
			if(is_array($ids))
			{
				$query->where(PRODUCTS.".product_id",'IN',$ids);
			}
			else
			{
				$query->where(PRODUCTS.".product_id",'=',$ids);
			}

		if($id=="CT" && !empty($array))
		{
			$query ->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->where(PRODUCTS.'.product_category','=',$array['category_id']);
					//->limit($array['limit'])->offset($array['offset']);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		
		else if($id=="OL")
		{
			$query=$query->and_where(CLOCK.'.product_process','=',LIVE)->and_where(CLOCK.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(CLOCK.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(CLOCK.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="PD")
		{
			//$query=$query->and_where(CLOCK.".product_id",'=',$ids);
			$result=$query->execute()->as_array();
		
			return ($need_count)?count($result):$result;
		
		}	
		else if ($id=="S")
		{
			$query=$query->join(PRODUCT_CATEGORY,'left')
						->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
						->where_open()
						->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCTS.'.product_id','=',$array['search'])
						->or_where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
						->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
						->where_close();
			$result=$query->execute();
			return ($need_count)?count($result):$result;
			
		}
		else
		{
			$query=$query->and_where(CLOCK.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
	}

	public function select_products($status="",$pid="",$array=array())
	{
		
		$query=DB::select(PRODUCTS.'.product_id',PRODUCTS.'.auction_type')
					->from(PRODUCTS)
					->join(AUCTIONTYPE,'left')
					->on(PRODUCTS.'.auction_type','=',AUCTIONTYPE.'.typeid')
					->where(PRODUCTS.'.product_status','=',ACTIVE)
					->where(AUCTIONTYPE.'.status','=',ACTIVE);
				
		if($status!=""){
			switch($status)
			{
				case 4:
					$query -> and_where(PRODUCTS.'.startdate','<=',$this->getCurrentTimeStamp)->and_where(PRODUCTS.'.enddate','>=',$this->getCurrentTimeStamp)->and_where(PRODUCTS.'.in_auction','=',1);
				break;
				case 6:
					$query -> and_where(PRODUCTS.'.product_id','=',$pid);
				break;
				case 7:
					if($array['category_id']!=''){
					$query ->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->where(PRODUCTS.'.product_category','=',$array['category_id'])
					-> and_where(PRODUCTS.'.enddate','>=',$this->getCurrentTimeStamp)->and_where(PRODUCTS.'.in_auction','=',1);
					}else{
						$query ->where(PRODUCTS.'.enddate','>=',$this->getCurrentTimeStamp)->and_where(PRODUCTS.'.in_auction','=',1);	
						
					}
					
				break;
				case 3:
					$query -> and_where(PRODUCTS.'.startdate','>=',$this->getCurrentTimeStamp)->and_where(PRODUCTS.'.in_auction','!=',3)->and_where(PRODUCTS.'.in_auction','=',4);
				break;
				case 5:
					$query ->or_where(PRODUCTS.'.in_auction','=',3)->and_where(PRODUCTS.'.in_auction','=',1);
				break;
				case 9:
					$query ->and_where(PRODUCTS.'.in_auction','=',2)->
					and_where(PRODUCTS.'.enddate','<=',$this->getCurrentTimeStamp)
					->and_where(PRODUCTS.'.enddate','!=',0);
					if(isset($array['offset']) && isset($array['limit']))
					{
						$query ->offset($array['offset'])->limit($array['limit']);
					}
					$query->order_by(PRODUCTS.'.enddate','DESC');
					
					
				break;
				case 8:
					$query->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->where_open()
					->where(PRODUCTS.'.product_name','LIKE',"%".$array['search']."%")
					->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$array['search']."%")
					->where_close();
				break;
			}
		}
		
		
		$result = $query->execute()->as_array();
		return $result;
	}
	       // search product details 
	public function get_searchresults($value)
	{
		$query = DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.current_price',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',	
				PRODUCTS.'.enddate',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->where_open()
					->where(PRODUCTS.'.product_name','LIKE',"%".$value."%")
					->or_where(PRODUCTS.'.product_id','=',$value)
					->or_where(PRODUCTS.'.product_name','LIKE',"%".$value."%")
					->or_where(PRODUCT_CATEGORY.'.category_name','LIKE',"%".$value."%")
					->where_close()
					->execute();
			return $query;
	}
		/** 
	* Select products and users table with left join 
	* @param $id, records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_products_detail($id,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.current_price',
				PRODUCTS.'.starting_current_price',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.product_category',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.auction_type',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',	
				PRODUCTS.'.product_featured',
				PRODUCTS.'.in_auction',
				PRODUCTS.'.dedicated_auction',	
				//PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',	
				PRODUCT_CATEGORY.'.id',
				PRODUCT_CATEGORY.'.status')->from(PRODUCTS)
					->where(PRODUCTS.".product_id",'=',$id)
					 ->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCT_CATEGORY.'.status','=',ACTIVE)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->execute();					
		return ($need_count)?count($query):$query;
	}

	/** 
	* Select bid_history and joined users,products table with left join 
	* @param id, records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_bid_history($id,$need_count=FALSE)
	{
		$query=DB::select()->from(BID_HISTORIES)
					->join(USERS,'left')
					->on(BID_HISTORIES.'.user_id','=',USERS.'.id')
					->where(BID_HISTORIES.'.product_id','=',$id)
					->order_by(BID_HISTORIES.'.id','DESC')
					->limit(10)
					->execute();
		return ($need_count)?count($query):$query;
	}
	
	/**
	 * Check an email address for correct format.
	 *
	 * @link  http://www.iamcal.com/publish/articles/php/parsing_email/
	 * @link  http://www.w3.org/Protocols/rfc822/
	 *
	 * @param   string   email address
	 * @param   boolean  strict RFC compatibility
	 * @return  boolean
	 */
	public static function email_format_check($email, $strict = FALSE)
	{
		if (UTF8::strlen($email) > 254)
		{
			return FALSE;
		}

		if ($strict === TRUE)
		{
			$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
			$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
			$atom  = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
			$pair  = '\\x5c[\\x00-\\x7f]';

			$domain_literal = "\\x5b($dtext|$pair)*\\x5d";
			$quoted_string  = "\\x22($qtext|$pair)*\\x22";
			$sub_domain     = "($atom|$domain_literal)";
			$word           = "($atom|$quoted_string)";
			$domain         = "$sub_domain(\\x2e$sub_domain)*";
			$local_part     = "$word(\\x2e$word)*";

			$expression     = "/^$local_part\\x40$domain$/D";
		}
		else
		{
			$expression = '/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})$/iD';
		}

		return (bool) preg_match($expression, (string) $email);
	}
	/**
	 * Checks whether a string consists of alphabetical characters, numbers, underscores and dashes only.
	 *
	 * @param   string   input string
	 * @param   boolean  trigger UTF-8 compatibility
	 * @return  boolean
	 */
	public function alpha_dash_checks($str, $utf8 = FALSE)
	{
		if ($utf8 === TRUE)
		{
			$regex = '/^[-\pL\pN_]++$/uD';
		}
		else
		{
			$regex = '/^[-a-z0-9_]++$/iD';
		}

		return (bool) preg_match($regex, $str);
	}
	/**
	 * Checks if a field matches the value of another field.
	 *
	 * @param   array    array of values
	 * @param   string   field name
	 * @param   string   field name to match
	 * @return  boolean
	 */
	public function password_matches( $field, $match)
	{
		if($field == $match){
			return 1;			
		}else{
			return 2;
		}
	}
	
	  /**
        * ****all_category_list()****
        *@param $offset int, $val int
        *@return allproduct category count of array 
        */	 
	public function all_category_list()
	{
	 	$rs  = DB::select('category_name','id')->from(PRODUCT_CATEGORY)
                                ->where('status', '=', ACTIVE)
                                ->order_by('id', 'ASC')
                                ->execute()	
                                ->as_array();
		return $rs;

	}
	//To Get Current TimeStamp
	//===================================
	public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}	
}
