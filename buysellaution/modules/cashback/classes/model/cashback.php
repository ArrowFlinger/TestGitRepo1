<?php defined('SYSPATH') or die('No direct access allowed.');

/*
 * You should have all the module's models inside the module folder
 * so the module can be functional just by copying the module folder.
 *
 * It's recomended to name you Module's Models as Model_Modulename_<Model>
 * to avoid any conflics with any application model
 */

class Model_Cashback extends Model {
        
    /**To Get Current TimeStamp**/
	public function __construct()
    {	
        $this->session = Session::instance();
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
	}
	
    public function select_products_detail($ids,$status=1,$array=array(),$need_count=FALSE)
	{	
		switch($status)
		{			
			case 1:
				//All
				$id="A";
				break;
			case 2:
				//Closed
				$id="C";
				break;
			case 3:
				//Future
				$id="F";
				break;
			case 4:
				//Only live
				$id="OL";
				break;
			case 5:
				//Home page
				$id="H";
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
			case 10:
				//Winner
				$id="W";
				break;
                        case 11:
				//Buynow products
				$id="BOL";
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
				PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				PRODUCTS.'.shipping_info',				
				CASHBACK.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.country',
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
		else if($id=="W")
		{
			$query=$query->and_where(CASHBACK.'.product_process','=',CLOSED)->and_where(CASHBACK.'.lastbidder_userid','!=',0);
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="OL")
		{
			$query=$query->and_where(CASHBACK.'.product_process','=',LIVE)->and_where(CASHBACK.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(CASHBACK.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(CASHBACK.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}
                else if($id=="BOL")
		{
			$query=$query->and_where(CASHBACK.'.product_process','=',LIVE)->and_where(CASHBACK.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(CASHBACK.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(CASHBACK.'.auction_process','!=','H')->and_where(PRODUCTS.'.buynow_status','=',ACTIVE);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="H")
		{
			$query=$query->and_where(CASHBACK.'.product_process','=',LIVE);
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="PD")
		{
			//$query=$query->and_where(CASHBACK.".product_id",'=',$ids);
			$result=$query->execute();
		
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="C")
		{
			$query=$query->and_where(CASHBACK.'.product_process','=',CLOSED)->and_where(CASHBACK.'.enddate','<=',$this->getCurrentTimeStamp);
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		
		}	
		else if ($id=="F")
		{
			$query=$query->and_where(CASHBACK.'.product_process','=',FUTURE);
			$result=$query->execute();
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
	
	//To get user balance
	public function get_user_balances($userid)
	{ //echo $userid; 
		$query=DB::select('user_bid_account','user_bonus')->from(USERS)
					->where('id','=',$userid)
					->execute()
					->current();	
		return $query;
	}
	
	//Start date and end date convert seconds
	public static function maxcountdown()
	{
		$sdate = $_POST['startdate'];
		// indicate the end date here
		$edate = $_POST['enddate']; 
		$timestamp_start = strtotime($sdate);
		$timestamp_end = strtotime($edate);
		$difference = abs($timestamp_end - $timestamp_start); // that's it!
		if($difference <= $_POST['max_countdown'])
		{
			return false;
		}
		else 
		{
			return true;
		}
	}

// Check Server current time validate 
	public static function server_cuurent_time_validate($startdate)
	{ 
		if($startdate >= CURRENT_DATE)
		{
			return true;
		}
		else {
			return false;
		}
	}
    	
	
	//Add Product validation 
	public function add_product_form($arr,$settings) 
	{
	
                $currentprice_cost_req = is_numeric($arr['current_price']) && $arr['current_price'] >ZERO ?$arr['current_price']:MIN_ONE;
                $product_cost_req = is_numeric($arr['product_cost']) && $arr['product_cost'] >ZERO   ;
                $currentprice_count = sizeof(explode(",",$arr['current_price']));
                //max counddown Validate
                $max_countdown_req = is_numeric($arr['max_countdown']) ? $arr['max_countdown']:MIN_MAXCOUNTDOWN ;
                $max_countdown_count = sizeof(explode(",",$arr['max_countdown']));
                $bidding_countdown_count = sizeof(explode(",",$arr['bidding_countdown']));
                //Bidding amount validate             
                $biddingcountdown_req = is_numeric($arr['bidding_countdown']) && $arr['bidding_countdown'] >MIN_BIDCOUNTDOWN ? $arr['bidding_countdown']:MIN_BIDCOUNTDOWN ;
                
                //Bidamount
                 $bidamount_req = is_numeric($arr['bidamount']) && $arr['bidamount'] >ZERO ?$arr['bidamount']:MIN_ONE;
                 $bidamount_count = sizeof(explode(",",$arr['bidamount']));
                $start= Validation::factory($arr,$settings)           
                ->rule('product_cost','not_empty')
                ->rule('product_cost', 'numeric')
                ->rule('product_cost','range',array(':value', $product_cost_req,__('greater_than_zero'),"")) 
                ->rule('current_price','not_empty')
                ->rule('current_price', 'numeric')
                ->rule('current_price','range',array(':value',$currentprice_cost_req,__('greater_than_zero'),""))                

                ->rule('current_price','compare_value_greater',array(explode(",",$arr['product_cost']),explode(",",$arr['current_price']),'Current price'))              
                ->rule('max_countdown','not_empty')
                ->rule('max_countdown','numeric')
				->rule ('max_countdown','Model_Adminproduct::maxcountdown',array(":value"))
                ->rule('max_countdown','range',array(':value',MIN_MAXCOUNTDOWN,__('greater_than'),"Seconds"))
                ->rule('bidding_countdown','not_empty')
                ->rule('bidding_countdown','numeric')  
                ->rule('bidding_countdown','range',array(':value',MIN_BIDCOUNTDOWN,__('greater_than'),"Seconds"))         
                ->rule('bidding_countdown','array_count_equals',array(explode(",",$arr['max_countdown']),explode(",",$arr['bidding_countdown']),'Countdown'))                
                ->rule('bidding_countdown','compare_value_greater',array(explode(",",$arr['max_countdown']),explode(",",$arr['bidding_countdown']),'Countdown'))
                ->rule('bidamount','not_empty')
                ->rule('bidamount','numeric')
                ->rule('bidamount','range',array(':value',$bidamount_req ,__('greater_than_zero'),"Bidamount",""))
                ->rule('bidamount','array_count_equals',array(explode(",",$arr['product_cost']),explode(",",$arr['bidamount']),__('product_cost')))
                ->rule('bidamount','compare_value_greater',array(explode(",",$arr['product_cost']),explode(",",$arr['bidamount']),__('product_cost')))
                ->rule('startdate','not_empty')
				//->rule ('startdate','Model_Adminproduct::server_cuurent_time_validate',array(":value"))
                //->rule ('startdate','Model_Adminproduct::start_datevalidate',array(":value"))
                ->rule('enddate','not_empty')
				->rule ('enddate','Model_Adminproduct::server_cuurent_time_validate',array(":value"))
                ->rule ('enddate','Model_Adminproduct::datevalidate',array($arr['startdate'],":value"))   
                ->rule ('current_price','Model_Adminproduct::product_decimal_check',array(":value"))
                ->rule ('bidamount','Model_Adminproduct::product_decimal_check',array(":value"));            
               
           
                return $start;
        }
        
        //Add Product validation 
	public function edit_product_form($arr,$settings) 
	{
	
                $currentprice_cost_req = is_numeric($arr['current_price']) && $arr['current_price'] >ZERO ?$arr['current_price']:MIN_ONE;
                $product_cost_req = is_numeric($arr['product_cost']) && $arr['product_cost'] >ZERO   ;
                $currentprice_count = sizeof(explode(",",$arr['current_price']));
                //max counddown Validate
                $max_countdown_req = is_numeric($arr['max_countdown']) ? $arr['max_countdown']:MIN_MAXCOUNTDOWN ;
                $max_countdown_count = sizeof(explode(",",$arr['max_countdown']));
                $bidding_countdown_count = sizeof(explode(",",$arr['bidding_countdown']));
                //Bidding amount validate             
                $biddingcountdown_req = is_numeric($arr['bidding_countdown']) && $arr['bidding_countdown'] >MIN_BIDCOUNTDOWN ? $arr['bidding_countdown']:MIN_BIDCOUNTDOWN ;
                
                //Bidamount
                 $bidamount_req = is_numeric($arr['bidamount']) && $arr['bidamount'] >ZERO ?$arr['bidamount']:MIN_ONE;
                 $bidamount_count = sizeof(explode(",",$arr['bidamount']));
                $start= Validation::factory($arr,$settings)           
                ->rule('product_cost','not_empty')
                ->rule('product_cost', 'numeric')
                ->rule('product_cost','range',array(':value', $product_cost_req,__('greater_than_zero'),"")) 
                ->rule('current_price','not_empty')
                ->rule('current_price', 'numeric')
                ->rule('current_price','range',array(':value',$currentprice_cost_req,__('greater_than_zero'),""))                
                ->rule('current_price','compare_value_greater',array(explode(",",$arr['product_cost']),explode(",",$arr['current_price']),'Current price'))              
                ->rule('max_countdown','not_empty')
                ->rule('max_countdown','numeric')
				->rule ('max_countdown','Model_Adminproduct::maxcountdown',array(":value"))
                ->rule('max_countdown','range',array(':value',MIN_MAXCOUNTDOWN,__('greater_than'),"Seconds"))
                ->rule('bidding_countdown','not_empty')
                ->rule('bidding_countdown','numeric')  
                ->rule('bidding_countdown','range',array(':value',MIN_BIDCOUNTDOWN,__('greater_than'),"Seconds"))         
                ->rule('bidding_countdown','array_count_equals',array(explode(",",$arr['max_countdown']),explode(",",$arr['bidding_countdown']),'Countdown'))                
                ->rule('bidding_countdown','compare_value_greater',array(explode(",",$arr['max_countdown']),explode(",",$arr['bidding_countdown']),'Countdown'))
                ->rule('bidamount','not_empty')
                ->rule('bidamount','numeric')
                ->rule('bidamount','range',array(':value',$bidamount_req ,__('greater_than_zero'),"Bidamount",""))
                ->rule('bidamount','array_count_equals',array(explode(",",$arr['product_cost']),explode(",",$arr['bidamount']),__('product_cost')))
                ->rule('bidamount','compare_value_greater',array(explode(",",$arr['product_cost']),explode(",",$arr['bidamount']),__('product_cost')))
                ->rule('startdate','not_empty')
				//->rule ('startdate','Model_Adminproduct::server_cuurent_time_validate',array(":value"))
                //->rule ('startdate','Model_Adminproduct::start_datevalidate',array(":value"))
                ->rule('enddate','not_empty')
				->rule ('enddate','Model_Adminproduct::server_cuurent_time_validate',array(":value"))
                ->rule ('enddate','Model_Adminproduct::datevalidate',array($arr['startdate'],":value"))   
                ->rule ('current_price','Model_Adminproduct::product_decimal_check',array(":value"))
                ->rule ('bidamount','Model_Adminproduct::product_decimal_check',array(":value"));            
               
           
                return $start;
        }
        
		/* ****Create unix timestamp****
		*@param $date eg. 2011-11-16 20:15:00
		*@return unix timestamp with given date and time
		*/ 
		public function create_timestamp($date)
		{
			$split=explode(" ",$date);
			$date=explode("-",$split[0]);
			$time=explode(":",$split[1]);
			return  $mktime = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
		}
        
		public function add_product($post,$pid)
		{
			//for checking status checkbox is checked or not
			/**To add i will and price if not entered **/
			$current_date=$this->getCurrentTimeStamp;
			$inauction =1;
			if($_POST['startdate']<$current_date)
			{
				$status=LIVE;			
				$inauction=1;
				$timestamp=time()+$_POST['max_countdown'];
			}
			else if($_POST['startdate']>$current_date)
			{
				$status=FUTURE;
				$inauction =4;
				$timestamp=$this->create_timestamp($_POST['startdate']);
			}
			//Query to Insert Product Details
			$rs   = DB::insert(CASHBACK)
			->columns(array('product_id','startdate', 'enddate','product_cost','current_price','starting_current_price','max_countdown','bidding_countdown','bidamount','increment_timestamp','product_process'))               
			->values(array($pid,$post['startdate'],$post['enddate'],$post['product_cost'], 
			$post['current_price'],$post['current_price'],$post['max_countdown'],$post['bidding_countdown'],$post['bidamount'],$timestamp,$status))
			->execute();
			
			if($rs)
			{
				DB::update(PRODUCTS)->set(array('in_auction'=>1,'startdate'=>$post['startdate'],'enddate' => $post['enddate'],'in_auction' => $inauction))->where(PRODUCTS.'.product_id','=',$pid)->execute();
			}
			return 0;
				
		} 
		
		public function select_products($id,$need_count=FALSE)
		{
			
			$query=DB::select(PRODUCTS.'.product_id',
					PRODUCTS.'.product_name',
					PRODUCTS.'.product_url',
					PRODUCTS.'.product_image',
					PRODUCTS.'.product_info',
					PRODUCTS.'.userid',
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
					PRODUCTS.'.auction_type',				
					CASHBACK.'.autobid',
					USERS.'.id',
					USERS.'.username',
					USERS.'.latitude',
					USERS.'.longitude',
					USERS.'.user_bid_account',USERS.'.photo')
						->from(PRODUCTS)
						->join(CASHBACK,'left')
						->on(PRODUCTS.'.product_id','=',CASHBACK.'.product_id')
						->join(USERS,'left')
						->on(CASHBACK.'.lastbidder_userid','=',USERS.'.id')->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($id)){
				$query->and_where(CASHBACK.".product_id",'IN',$id);
			}
			else
			{
				$query->and_where(CASHBACK.".product_id",'=',$id);
			}
						
			$result = $query->execute()->as_array();
						
			return ($need_count)?count($result):$result;
		}
		
		/** 
	* Select products and users table with left join 	
	* @param $date of current date timestamp
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_products_to_update($status,$pid,$date,$need_count=FALSE)
	{
		$query=DB::select(CASHBACK.'.product_id',		
				CASHBACK.'.startdate',		
				CASHBACK.'.enddate',
				CASHBACK.'.dedicated_auction',  
				PRODUCTS.'.in_auction',
				CASHBACK.'.lastbidder_userid',
				CASHBACK.'.current_price',				
				CASHBACK.'.max_countdown',PRODUCTS.'.product_url')->from(CASHBACK)	
					->join(PRODUCTS,'left')
					->on(PRODUCTS.'.product_id','=',CASHBACK.'.product_id')
					->where(PRODUCTS.'.product_status','=',ACTIVE);
					
		switch($status)
		{
			case 0://Future
				$query->and_where(CASHBACK.".product_process",'=',FUTURE)
					->and_where(CASHBACK.'.lastbidder_userid','=',0);
				break;			
			case 1://Live
				$query->and_where(CASHBACK.".product_process",'=',LIVE)
						->and_where(CASHBACK.".startdate",'>=',$date)
						->and_where(CASHBACK.".enddate",'<=',$date);
				break;
			case 2://Resume
				$query->and_where(CASHBACK.".startdate",'>=',$date)
					->and_where(CASHBACK.'.lastbidder_userid','!=',0);
				break;
			case 3://Closed
				$query->and_where(CASHBACK.".enddate",'>',$date);
				break;
		}
		$result = $query->and_where(CASHBACK.'.product_id','=',$pid)->limit(1)->execute()->as_array();
		if($need_count)
		{
			return count($result);
		}
		else
		{
			return $result;
		}
	}
	
	public function update($table,$arr,$cond1,$cond2)
	{
		$query=DB::update($table)->set($arr)->where($cond1,'=',$cond2)->execute();
		return $query;
	}
	
	public function select_products_foradmin($id,$need_count=FALSE)
	{
		
		$query=DB::select(PRODUCTS.'.product_id',
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
				PRODUCTS.'.auction_type',				
				CASHBACK.'.autobid')
					->from(PRODUCTS)
					->join(CASHBACK,'left')
					->on(PRODUCTS.'.product_id','=',CASHBACK.'.product_id')
					->where(CASHBACK.'.product_id','=' ,$id);						
		$result = $query->execute()->current();
					
		return ($need_count)?count($result):$result;
	}
		
	 /**
	* ****edit_product()****
	*@param $current_uri int,$_POST array
	*@return alluser list count of array 
	*/  	 
	public function edit_product($productid,$post) 
	{	
		$mdate = $this->getCurrentTimeStamp; 
		$auction=Model::factory('commonfunctions');
		$result=$auction->select_with_onecondition(CASHBACK, 'product_id='.$productid);
		$db_startdate=$result[0]['startdate'];
		$lastbidder=$result[0]['lastbidder_userid'];
		$db_timestamp=$result[0]['increment_timestamp'];
		$timediff=$result[0]['timediff'];
		if($post['startdate'] > $mdate && $result[0]['max_countdown']==$post['max_countdown'])
		{
			$timestamp=$this->create_timestamp($post['startdate']);
			$increment_time=$timestamp;
			$product_process=($lastbidder==0)?FUTURE:LIVE;
			$inauction=($lastbidder==0)?4:3;
		}
		else if($result[0]['startdate']!=$post['startdate'] && $post['startdate'] < $mdate && $result[0]['max_countdown']==$post['max_countdown'])
		{
			$increment_time=time()+$post['max_countdown'];	
			$product_process=LIVE;
			$inauction=1;
		}
		else if($result[0]['startdate']==$post['startdate'] && $post['startdate'] < $mdate && $result[0]['max_countdown']==$post['max_countdown'])
		{
			$time=$db_timestamp-time();
			$increment_time=time()+$time;	
			$product_process=LIVE;			
			$inauction=1;
		}
		else if($result[0]['startdate']==$post['startdate'] && $post['startdate'] < $mdate && $result[0]['max_countdown']!=$post['max_countdown'])
		{
			$increment_time=time()+$post['max_countdown'];	
			$product_process=LIVE;			
			$inauction=1;
		}
		else
		{	
			$increment_time=$db_timestamp;
			$product_process=LIVE;				
			$inauction=1;
		}
			$sql_sel="select count(".PRODUCTS.".product_id) as count FROM ".PRODUCTS.",".CASHBACK." where ".PRODUCTS.".product_id =".CASHBACK.".product_id and ".PRODUCTS.".product_id=$productid";
			$query=DB::query(Database::SELECT,$sql_sel)
					->execute()
					->get('count');
			 $sql_query = array('startdate' => $post['startdate'] ,'enddate' =>$post['enddate'],'product_cost' => $post['product_cost'],'current_price' => $post['current_price'],'max_countdown' => $post['max_countdown'] ,'bidding_countdown' => $post['bidding_countdown'], 'bidamount'=> $post['bidamount'],'updated_date' => $mdate,'increment_timestamp' => $increment_time, 'product_process' => $product_process);
			if($query==0)
			{
				$current_date=$this->getCurrentTimeStamp;
				$inauction =1;
				if($_POST['startdate']<$current_date)
				{
					$status=LIVE;			
					$timestamp=time()+$_POST['max_countdown'];
					$inauction = 1;
				}
				else if($_POST['startdate']>$current_date)
				{
					$status=FUTURE;
					$timestamp=$this->create_timestamp($_POST['startdate']);
					$inauction =4;
				}
				$insert=DB::insert(CASHBACK)
					->columns(array('product_id','startdate','enddate','product_cost','current_price','starting_current_price','max_countdown','bidding_countdown','bidamount','increment_timestamp','product_process'))               
					->values(array($productid,$post['startdate'],$post['enddate'],$post['product_cost'], $post['current_price'],$post['current_price'],$post['max_countdown'],$post['bidding_countdown'],$post['bidamount'],$timestamp,$status))
					->execute();
					if($insert)
					{
						
						DB::update(PRODUCTS)->set(array('startdate'=>$post['startdate'],'enddate' => $post['enddate'],'in_auction' => $inauction))->where(PRODUCTS.'.product_id','=',$productid)->execute();
					}
				return ($result)?SUCESS:FAIL;
			}
			else
			{	
				$result =  DB::update(CASHBACK)->set($sql_query)
						->where('product_id', '=' ,$productid)
						->order_by('updated_date','DESC')
						->execute();
					if($result)
					{
						
						DB::update(PRODUCTS)->set(array('startdate'=>$post['startdate'],'enddate' => $post['enddate'],'in_auction' => $inauction))->where(PRODUCTS.'.product_id','=',$productid)->execute();
					}
					return ($result)?SUCESS:FAIL;
			}
   }
   
   /** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_products_user_forbid($pid,$need_count=FALSE)
	{
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
				PRODUCTS.'.shipping_fee',				
				CASHBACK.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.country',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(CASHBACK,'left')
					->on(PRODUCTS.'.product_id','=',CASHBACK.'.product_id')
					->join(USERS,'left')
					->on(CASHBACK.'.lastbidder_userid','=',USERS.'.id')			
					->where(PRODUCTS.".product_id",'=',$pid)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
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
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_products_user_bonus_forbid($pid)
	{
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
				PRODUCTS.'.shipping_fee',		
				PRODUCTS.'.autobid',				
				CASHBACK.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.country',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(CASHBACK,'left')
					->on(PRODUCTS.'.product_id','=',CASHBACK.'.product_id')
					->join(USERS,'left')
					->on(CASHBACK.'.lastbidder_userid','=',USERS.'.id')					
					->where(PRODUCTS.".product_id",'=',$pid)
					->and_where(PRODUCTS.".dedicated_auction",'=',ENABLE)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->execute()
					->as_array();
		return count($query);
		
	}
	
	public function update_autobid($uid,$pid,$amt)
	{
		$query=DB::update(AUTOBID)
			->set(array('bid_amount'=>$amt,'time'=>$this->getCurrentTimeStamp))
			->where('product_id','=',$pid)
			->and_where('userid','=',$uid)
			->execute();
		return $query;
	}
	
	public function getusersab($pid)
	{
	    $query=DB::select(AUTOBID.'.userid',AUTOBID.'.bid_amount')
		->from(AUTOBID)
		->where(AUTOBID.'.product_id','=',$pid)
		->execute()
		->as_array();
		return $query;
	}
	
	public function selectall_autobid_closed()
	{
		$query = DB::select(PRODUCTS.'.dedicated_auction',
										AUTOBID.'.userid',
										AUTOBID.'.bid_amount',
										AUTOBID.'.product_id')->from(AUTOBID)
							->join(PRODUCTS,'left')
							->on(PRODUCTS.'.product_id','=',AUTOBID.'.product_id')
							->join(CASHBACK,'left')
							->on(PRODUCTS.'.product_id','=',CASHBACK.'.product_id')
							->where(CASHBACK.'.product_process','=',CLOSED)
							->and_where(PRODUCTS.'.product_status','=',ACTIVE)
							->execute();
						//	print_r($query);
							
		return $query;
	}
	
	
	public function delete_autobid($uid,$pid)
	{
		$query=DB::delete(AUTOBID)
			->where('product_id','=',$pid)
			->and_where('userid','=',$uid)
			->execute();
		return $query;
	} 
	
	//add by jagan for bid histoy select
	public function select_bids($pid)
	{
	
		 $sub = DB::select(array(DB::expr('MAX(id)'), 'total'))
					->from(BID_HISTORIES)->group_by('user_id')
					->execute()->as_array();

		 $valarray=array();			
		 foreach($sub as $invalues)
		 {
			$valarray[] = "'".$invalues['total']."'";
		 }
				
		 $tot_arr = implode(",", $valarray);
		if(!$tot_arr){$tot_arr=0;}
		$query = "SELECT * FROM `auction_bid_history` WHERE `product_id` = $pid AND `id` IN ($tot_arr) ORDER BY `id` DESC LIMIT 3";		
		 
		 /*$query=DB::select()->from(BID_HISTORIES)
					->where('product_id','=',$pid)
					->and_where('id','IN', array($tot_arr) )
					->order_by('id','DESC')
					->limit(3)
					->execute() 
					->as_array(); print_r($query); exit;*/
			
		$result = Db::query(Database::SELECT, $query)
					->execute() 
					->as_array();
					
		return $result;
	}    
	
	public function select_user_amounts($user)
	{
		$query = DB::select('user_bid_account','user_bonus')->from(USERS)->where('id','=',$user)->execute()->current();
		
		return $query;  
	}
	
	public function select_user_products_details($pid)
	{
		$query = DB::select('dedicated_auction','auction_type','product_name')
					->from(PRODUCTS)
					->where('product_id','=',$pid)
					->execute()
					->current();
		return $query;
	
	}
	
	//select user details based on userid
	public function select_user_details($userid)
	{
		$query = DB::select('email','username')
					->from(USERS)
					->where('id','=',$userid)
					->execute()
					->current();
		return $query;
	
	}
		//april 26
	public function insert($table,$arr)
	{
	$result=  DB::insert($table,array_keys($arr))->values(array_values($arr))
			     ->execute();
			return $result;
	}
		/****selvam on 11.07.2013****/
	/***To prevent directly access the module url if it is uninstalled******/
	public function check_cashback_present()
	{
		$res=DB::select('typename')
		->from(AUCTIONTYPE)
		->where('typename','=','cashback')
		->and_where('status','=',ACTIVE)
		->execute()
		->as_array();
		return $res;
	}
	
        
} // End commonfunction Model
