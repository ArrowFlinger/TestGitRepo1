<?php defined('SYSPATH') or die('No direct access allowed.');

/*
 * You should have all the module's models inside the module folder
 * so the module can be functional just by copying the module folder.
 *
 * It's recomended to name you Module's Models as Model_Modulename_<Model>
 * to avoid any conflics with any application model
 */

class Model_Scratch extends Model {
        
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
				PRODUCTS.'.shipping_fee',
				PRODUCTS.'.in_auction',
				PRODUCTS.'.shipping_info',				
				SCRATCHAUCTION.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.country',
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
		else if($id=="W")
		{
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','=',CLOSED)->and_where(SCRATCHAUCTION.'.lastbidder_userid','!=',0);
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="OL")
		{
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','=',LIVE)->and_where(SCRATCHAUCTION.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(SCRATCHAUCTION.'.auction_process','!=','H');
                       
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
                else if($id=="BOL")
		{
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','=',LIVE)->and_where(SCRATCHAUCTION.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(SCRATCHAUCTION.'.auction_process','!=','H')->and_where(PRODUCTS.'.buynow_status','=',ACTIVE);
                       
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="H")
		{
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','=',LIVE);
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="PD")
		{
			
			$result=$query->execute();
		
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="C")
		{
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','=',CLOSED)->and_where(SCRATCHAUCTION.'.enddate','<=',$this->getCurrentTimeStamp);
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		
		}	
		else if ($id=="F")
		{
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','=',FUTURE);
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
			$query=$query->and_where(SCRATCHAUCTION.'.product_process','!=',CLOSED);
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		}			
	
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
                        $product_cost_req = is_numeric($arr['product_cost']) && $arr['product_cost'] >ZERO;
                        $product_stock_req = is_numeric($arr['product_stock']) && $arr['product_stock'] >ZERO ?$arr['product_stock']:MIN_ONE;
                        $product_reduction = is_numeric($arr['bids']) && $arr['bids'] >ZERO ?$arr['bids']:MIN_ONE;
                        $currentprice_count = sizeof(explode(",",$arr['current_price']));
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
                       // ->rule('current_price','compare_value_greater',array(explode(",",$arr['product_cost']),explode(",",$arr['current_price']),'market price')) 
                        ->rule('current_price','compare_value_greater_equal',array(explode(",",$arr['product_cost']),explode(",",$arr['current_price']),'Market price'))
 
                        ->rule('bids','not_empty')
                        ->rule('bids','numeric')
                        ->rule('bids','range',array(':value', $product_reduction,__('greater_than_zero'),"")) 
                        ->rule('bidamount','not_empty')
                        ->rule('bidamount','numeric')
                        ->rule('bidamount','range',array(':value',$bidamount_req ,__('greater_than_zero'),"Bidamount",""))
                        ->rule('bidamount','array_count_equals',array(explode(",",$arr['product_cost']),explode(",",$arr['bidamount']),__('product_cost')))
                        ->rule('bidamount','compare_value_greater',array(explode(",",$arr['product_cost']),explode(",",$arr['bidamount']),__('product_cost')))
                        ->rule('timetobuy','not_empty')
                        ->rule('product_stock','not_empty')
                        ->rule('product_stock','numeric')
                        ->rule('product_stock','range',array(':value', $product_stock_req,__('greater_than_zero'),"")) 
                        ->rule('startdate','not_empty')
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
                        $product_stock_req = is_numeric($arr['product_stock']) && $arr['product_stock'] >ZERO ?$arr['product_stock']:MIN_ONE;
                         $product_reduction = is_numeric($arr['bids']) && $arr['bids'] >ZERO ?$arr['bids']:MIN_ONE;
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
                       // ->rule('current_price','compare_value_greater',array(explode(",",$arr['product_cost']),explode(",",$arr['current_price']),'market price'))              
                        ->rule('current_price','compare_value_greater_equal',array(explode(",",$arr['product_cost']),explode(",",$arr['current_price']),'Market price'))
                        ->rule('bids','not_empty')
                        ->rule('bids','numeric')
                        ->rule('bids','range',array(':value', $product_reduction,__('greater_than_zero'),"")) 
                        ->rule('bidamount','not_empty')
                        ->rule('bidamount','numeric')
                        ->rule('bidamount','range',array(':value',$bidamount_req ,__('greater_than_zero'),"Bidamount",""))
                        ->rule('bidamount','array_count_equals',array(explode(",",$arr['product_cost']),explode(",",$arr['bidamount']),__('product_cost')))
                        ->rule('bidamount','compare_value_greater',array(explode(",",$arr['product_cost']),explode(",",$arr['bidamount']),__('product_cost')))
                        ->rule('timetobuy','not_empty')
                        ->rule('product_stock','not_empty')
                        ->rule('product_stock','numeric')
                        ->rule('product_stock','range',array(':value', $product_stock_req,__('greater_than_zero'),""))
                        
                        ->rule('startdate','not_empty')
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

                        $datestart = $this->create_timestamp($_POST['startdate']);                       
                        $date_end = $this->create_timestamp($_POST['enddate']);
                        $difference = $date_end-$datestart;
 
			if($_POST['startdate']<$current_date)
			{
				$status=LIVE;			
				$inauction=1;
                                $timestamp=time()+$difference;
                                     
			}
			else if($_POST['startdate']>$current_date)
			{
				$status=FUTURE;
				$inauction =4;
				$timestamp=$this->create_timestamp($_POST['startdate']);
			}

                      
			//Query to Insert Product Details
			$rs   = DB::insert(SCRATCHAUCTION)
			->columns(array('product_id','startdate','product_cost','current_price','starting_current_price','max_countdown','bidamount','bids','timetobuy','product_stock','increment_timestamp','product_process'))               
			->values(array($pid,$post['startdate'],$post['product_cost'], 
			$post['current_price'],$post['current_price'],$difference,$post['bidamount'],$post['bids'],$post['timetobuy'],$post['product_stock'],$timestamp,$status))
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
					SCRATCHAUCTION.'.product_cost',
					SCRATCHAUCTION.'.current_price',
					SCRATCHAUCTION.'.bidding_countdown',
					SCRATCHAUCTION.'.bidamount',
					SCRATCHAUCTION.'.bids',
					SCRATCHAUCTION.'.timetobuy',
					SCRATCHAUCTION.'.product_stock',
					SCRATCHAUCTION.'.user_bid_active',
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
					PRODUCTS.'.auction_type',				
					SCRATCHAUCTION.'.autobid',
					USERS.'.id',
					USERS.'.username',
					USERS.'.latitude',
					USERS.'.longitude',
					USERS.'.user_bid_account',USERS.'.photo')
						->from(PRODUCTS)
						->join(SCRATCHAUCTION,'left')
						->on(PRODUCTS.'.product_id','=',SCRATCHAUCTION.'.product_id')
						->join(USERS,'left')
						->on(SCRATCHAUCTION.'.lastbidder_userid','=',USERS.'.id')->where(PRODUCTS.'.product_status','=',ACTIVE);
			if(is_array($id)){
				$query->and_where(SCRATCHAUCTION.".product_id",'IN',$id);
			}
			else
			{
				$query->and_where(SCRATCHAUCTION.".product_id",'=',$id);
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
		$query=DB::select(SCRATCHAUCTION.'.product_id',		
				SCRATCHAUCTION.'.startdate',		
				SCRATCHAUCTION.'.enddate',
				SCRATCHAUCTION.'.timetobuy',  
				SCRATCHAUCTION.'.product_stock',      
				SCRATCHAUCTION.'.dedicated_auction',
				SCRATCHAUCTION.'.lastbidder_userid',
				SCRATCHAUCTION.'.current_price',
                SCRATCHAUCTION.'.bids',                
				SCRATCHAUCTION.'.max_countdown')->from(SCRATCHAUCTION)	
					->join(PRODUCTS,'left')
					->on(PRODUCTS.'.product_id','=',SCRATCHAUCTION.'.product_id')
					->where(PRODUCTS.'.product_status','=',ACTIVE);
					
		switch($status)
		{ 
			case 0://Future
				$query->and_where(SCRATCHAUCTION.".product_process",'=',FUTURE)
					->and_where(SCRATCHAUCTION.'.lastbidder_userid','=',0);
				break;			
			case 1://Live
				$query->and_where(SCRATCHAUCTION.".product_process",'=',LIVE)
						->and_where(SCRATCHAUCTION.".startdate",'>=',$date);
						//->and_where(SCRATCHAUCTION.".enddate",'<=',$date);
				break;
			case 2://Resume
				$query->and_where(SCRATCHAUCTION.".startdate",'>=',$date)
					->and_where(SCRATCHAUCTION.'.lastbidder_userid','!=',0);
				break;
			case 3://Closed
				$query->and_where(SCRATCHAUCTION.".enddate",'>=',$date);
				break;
		} 
		$result = $query->and_where(SCRATCHAUCTION.'.product_id','=',$pid)->limit(1)->execute()->as_array();
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
				PRODUCTS.'.auction_type',				
				SCRATCHAUCTION.'.autobid')
					->from(PRODUCTS)
					->join(SCRATCHAUCTION,'left')
					->on(PRODUCTS.'.product_id','=',SCRATCHAUCTION.'.product_id')
					->where(SCRATCHAUCTION.'.product_id','=' ,$id);						
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
		$result=$auction->select_with_onecondition(SCRATCHAUCTION, 'product_id='.$productid);
		$db_startdate=$result[0]['startdate'];
		$lastbidder=$result[0]['lastbidder_userid'];
		$db_timestamp=$result[0]['increment_timestamp'];
		$timediff=$result[0]['timediff'];
                $datestart = $this->create_timestamp($_POST['startdate']);                       
                $date_end = $this->create_timestamp($_POST['enddate']);
                $difference = $date_end-$datestart;
               

		if($post['startdate'] > $mdate && $result[0]['max_countdown']==$difference)
		{
			$timestamp=$this->create_timestamp($post['startdate']);
			$increment_time=$timestamp;
			$product_process=($lastbidder==0)?FUTURE:LIVE;
			$inauction=($lastbidder==0)?4:3;
		}
		else if($result[0]['startdate']!=$post['startdate'] && $post['startdate'] < $mdate && $result[0]['max_countdown']==$difference)
		{
			$increment_time=time()+$difference;	
			$product_process=LIVE;
			$inauction=1;
		}
		else if($result[0]['startdate']==$post['startdate'] && $post['startdate'] < $mdate && $result[0]['max_countdown']==$difference)
		{
			$time=$db_timestamp-time();
			$increment_time=time()+$time;	
			$product_process=LIVE;			
			$inauction=1;
		}
		else if($result[0]['startdate']==$post['startdate'] && $post['startdate'] < $mdate && $result[0]['max_countdown']!=$difference)
		{
			$increment_time=time()+$difference;	
			$product_process=LIVE;			
			$inauction=1;
		}
		else
		{	
			$increment_time=$db_timestamp;
			$product_process=LIVE;				
			$inauction=1;
		}

                     
			$sql_sel="select count(".PRODUCTS.".product_id) as count FROM ".PRODUCTS.",".SCRATCHAUCTION." where ".PRODUCTS.".product_id =".SCRATCHAUCTION.".product_id and ".PRODUCTS.".product_id=$productid";
			$query=DB::query(Database::SELECT,$sql_sel)
					->execute()
					->get('count');
			 $sql_query = array('startdate' => $post['startdate'],'enddate' => $post['enddate'],'product_cost' => $post['product_cost'],'current_price' => $post['current_price'],'max_countdown' =>$difference , 'bidamount'=> $post['bidamount'],'bids'=> $post['bids'],'timetobuy'=> $post['timetobuy'],'product_stock'=> $post['product_stock'],'updated_date' => $mdate,'increment_timestamp' => $increment_time, 'product_process' => $product_process);
			if($query==0)
			{       $timestamp=$this->create_timestamp($post['startdate']);
				$current_date=$this->getCurrentTimeStamp;
				$inauction =1;
				if($_POST['startdate']<$current_date)
				{
					$status=LIVE;			
					//$timestamp=time()+$timestamp;
                                        $timestamp=time()+$difference;
					$inauction = 1;
				}
				else if($_POST['startdate']>$current_date)
				{
					$status=FUTURE;
					$timestamp=$this->create_timestamp($_POST['startdate']);
					$inauction =4;
				}
				$insert=DB::insert(SCRATCHAUCTION)
					->columns(array('product_id','startdate','product_cost','current_price','starting_current_price','max_countdown','bidamount','bids','timetobuy','increment_timestamp','product_process'))               
					->values(array($productid,$post['startdate'],$post['product_cost'], $post['current_price'],$post['current_price'],$difference,$post['bids'],$post['timetobuy'],$post['bidamount'],$timestamp,$status))
					->execute();
					if($insert)
					{
						
						DB::update(PRODUCTS)->set(array('startdate'=>$post['startdate'],'in_auction' => $inauction))->where(PRODUCTS.'.product_id','=',$productid)->execute();
					}
				return ($result)?SUCESS:FAIL;
			}
			else
			{	
				$result =  DB::update(SCRATCHAUCTION)->set($sql_query)
						->where('product_id', '=' ,$productid)
						->order_by('updated_date','DESC')
						->execute();
					if($result)
					{
						
						DB::update(PRODUCTS)->set(array('startdate'=>$post['startdate'],'in_auction' => $inauction))->where(PRODUCTS.'.product_id','=',$productid)->execute();
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
				PRODUCTS.'.shipping_fee',				
				SCRATCHAUCTION.'.autobid',
                                SCRATCHBIDHISTORY.'.bid_count_active',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.country',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(SCRATCHAUCTION,'left')
					->on(PRODUCTS.'.product_id','=',SCRATCHAUCTION.'.product_id')
					->join(USERS,'left')
					->on(SCRATCHAUCTION.'.lastbidder_userid','=',USERS.'.id')			
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
				SCRATCHAUCTION.'.product_cost',
				SCRATCHAUCTION.'.current_price',
				SCRATCHAUCTION.'.bidding_countdown',
				SCRATCHAUCTION.'.bidamount',
                                SCRATCHAUCTION.'.bids',
                                SCRATCHAUCTION.'.timetobuy',
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
				PRODUCTS.'.shipping_fee',		
				PRODUCTS.'.autobid',				
				SCRATCHAUCTION.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.country',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(SCRATCHAUCTION,'left')
					->on(PRODUCTS.'.product_id','=',SCRATCHAUCTION.'.product_id')
					->join(USERS,'left')
					->on(SCRATCHAUCTION.'.lastbidder_userid','=',USERS.'.id')					
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
                                ->join(SCRATCHAUCTION,'left')
                                ->on(PRODUCTS.'.product_id','=',SCRATCHAUCTION.'.product_id')
                                ->where(SCRATCHAUCTION.'.product_process','=',CLOSED)
                                ->and_where(PRODUCTS.'.product_status','=',ACTIVE)
                                ->execute();
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

        /** 
	* Select bid_history and joined users,products table with left join 
	* @param id, records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_bid_history($id,$need_count=FALSE)
	{
		$query=DB::select()->from(SCRATCHBIDHISTORY)
					->join(USERS,'left')
					->on(SCRATCHBIDHISTORY.'.user_id','=',USERS.'.id')
					->where(SCRATCHBIDHISTORY.'.product_id','=',$id)
					->order_by(SCRATCHBIDHISTORY.'.id','DESC')
					->limit(5)
					->execute();
		return ($need_count)?count($query):$query;
	}  


        public function select_bid_history_count_details($id)
        {
                
        $query = "SELECT MAX(timetobuy) AS timetobuy FROM ".SCRATCHBIDHISTORY." WHERE  product_id='".$id."' ";
				$result=Db::query(Database::SELECT, $query)
				->execute()
				->as_array();

                return $result;
        }

        public function select_user_bid_history_count_details($id,$user_id)
        {
                $query=DB::select('timetobuy')->from(SCRATCHBIDHISTORY)
                ->where(SCRATCHBIDHISTORY.'.product_id','=',$id)
                ->where(SCRATCHBIDHISTORY.'.user_id','=',$user_id)
                ->order_by(SCRATCHBIDHISTORY.'.id','DESC')
                ->execute()
		->as_array();
                return $query;
        }
        
        //Bidhistory user_bid_active buy now
        public function timetobuy($pid)
	{
               
		$query=DB::update(SCRATCHBIDHISTORY)
			->set(array('user_bid_active'=>0))
			->where('product_id','=',$pid)			
			->execute();
		return $query;
	}   

        //Scratch table user_bid_active buy now update 0
        public function timetobuy_update_product($pid)
	{
               
		$query=DB::update(SCRATCHAUCTION)
			->set(array('user_bid_active'=>0))
			->where('product_id','=',$pid)
			->execute();
		return $query;
	}

        //Scratch table user_bid_active buy now update 0
        public function timetobuy_update_product_stock1($pid)
	{
                 
                $query=DB::select('product_stock')->from(SCRATCHAUCTION)
                ->where(SCRATCHAUCTION.'.product_id','=',$pid)
                ->execute()
		->get('product_stock');
               
                return $query;
        }

         //Scratch table user_bid_active buy now update 0
        public function timetobuy_update_product_stock($pid)
	{
                $query=DB::select('product_stock')->from(SCRATCHAUCTION)
                ->where(SCRATCHAUCTION.'.product_id','=',$pid)
                ->execute()
		->get('product_stock');
                
                $stock = $query+1;
		$query=DB::update(SCRATCHAUCTION)
			->set(array('product_stock'=> $stock))
			->where('product_id','=',$pid)
			->execute();
		return $query;
	}   

       public function select_product_timetobuy($id)
       {
                $query=DB::select('timetobuy')->from(SCRATCHAUCTION)
                ->where(SCRATCHAUCTION.'.product_id','=',$id)
                ->execute()
		->get('timetobuy');
                return $query;
       }

         //Add to cart details
	// Add Transaction Log Details
	public function buynow_details($addtocart_details)
        {
                
                $addtocartfields = array('userid','productid','product_name','product_image','amount','total_amt','shipping_cost','add_date');
                $addtocartvalues = array($addtocart_details['userid'],$addtocart_details['productid'],$addtocart_details['product_name'],$addtocart_details['product_image'],$addtocart_details['amount'],$addtocart_details['amount'],$addtocart_details['shipping_fee'],$this->getCurrentTimeStamp);
                $result = DB::insert(SCRATCH_PRODUCT, $addtocartfields )
			->values($addtocartvalues)
			->execute();
		return $result; 
        }

         //Buynow product closed update scratch table
        public function buynow_product_closed($addtocart_details)
        {

                $result = DB::update(SCRATCHAUCTION)->set(array('product_process'=>CLOSED,'enddate'=>$this->getCurrentTimeStamp))->where('product_id', '=',$addtocart_details['productid'])
                ->execute(); 
        }

         //Buynow product closed update products table
        public function buynow_product_closed_product($addtocart_details)
        {

                $result = DB::update(PRODUCTS)->set(array('enddate' => $this->getCurrentTimeStamp,'in_auction' => 2,'lastbidder_userid' => $addtocart_details['userid'],'current_price' => $addtocart_details['amount']))->where('product_id', '=',$addtocart_details['productid'])
                ->execute(); 
        }

         // Select Package Details
        public function getproductdetails($product_id)
        {
              	
		$query= DB::select('auction_type')->from(PRODUCTS)
			     ->where('product_id','=',$product_id)			     
			     ->execute()	
			     ->as_array(); //Auction type
			 
			$query2= DB::select()->from(AUCTIONTYPE)
			     ->where('typeid','=',$query[0]['auction_type'])			     
			     ->execute()	
			     ->as_array(); //Type Name

				$query= DB::select(SCRATCHAUCTION.'.product_id',SCRATCHAUCTION.'.current_price',
					   PRODUCTS.'.product_name', PRODUCTS.'.shipping_fee',
					   PRODUCTS.'.product_image')->from(SCRATCHAUCTION)
				     ->where(SCRATCHAUCTION.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on(SCRATCHAUCTION.'.product_id','=',PRODUCTS.'.product_id')
				     ->execute()	
				     ->as_array(); 
				     return $query;
                        
        }

        public function getproductswon($offset ="", $limit ="")
	{
		 $query = DB::select('p.product_image',
                               'p.product_url',
                               'p.product_name',      
                               'p.product_info',
                               'S.enddate',
                               'S.product_cost',
                               'S.product_id',
                               'S.current_price','S.lastbidder_userid')
                               ->from(array(SCRATCHAUCTION,'S'))
			       ->join(array(PRODUCTS,'p'),'left')
			       ->on("S.product_id",'=','p.product_id')
                               ->and_where('S.product_process','=',CLOSED);
		if($offset!="" || $limit!="")
		{
			$query ->offset($offset)->limit($limit);
		}
                $result = $query->execute()
                               ->as_array();
		
               return $result; 
		
	}

        public function select_scratch_product($offset, $val,$id,$need_count=FALSE)
	{
		
		$query=DB::select(SCRATCH_PRODUCT.'.product_image',SCRATCH_PRODUCT.'.productid',SCRATCH_PRODUCT.'.add_date',
				SCRATCH_PRODUCT.'.product_name',SCRATCH_PRODUCT.'.amount',SCRATCH_PRODUCT.'.status',
				SCRATCH_PRODUCT.'.total_amt',PRODUCTS.'.product_url',PRODUCTS.'.userid',PRODUCTS.'.shipping_fee')	
					->from(SCRATCH_PRODUCT)
					->join(PRODUCTS,'left')
					->on(PRODUCTS.'.product_id','=',SCRATCH_PRODUCT.'.productid')
					->where(SCRATCH_PRODUCT.'.userid','=',$id);
										
		if($need_count)
		{
			$result=$query->order_by('productid','DESC')
				->execute();
			return count($result);
		}
		else
		{
			$result=$query	->limit($val)
				      	->offset($offset)
					->order_by('productid','DESC')                                        
					->execute()
                                        ->as_array();
			return $result;
		}
	}

        public function get_id($product_id)
	{
		$query= DB::select()->from(SCRATCH_PRODUCT)
			     ->where('productid','=',$product_id)
			     ->and_where('status','=','0')
			      ->execute()	
			     ->as_array(); 
					return count($query)?true :false;
	}

     /**Edit Reserve Settings User Data **/
        public function edit_site_settings_user($post_vals) 
	{
	        //remove last submit index and value 	
	        array_pop($post_vals);
	        
	        //Key =From field name and Value = database column name
	        $usersettingdatas = array("email_verification"=>"email_verification_reg");
	        
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
	       
	       	$result =  DB::update(SCRATCH_USERS_SETTINGS)->set($sql_query)
			->where('id', '=' ,'1')
			->execute();
		//update always success
		return 1;	  
	}
	
	 //select mail verification for reserve bid
        public function get_scratch_site_settings_user()
        {              
                 $result=DB::select()->from(SCRATCH_USERS_SETTINGS)
			     ->limit(1)
			     ->execute()	
			     ->current();
                return  $result;

        }
        	//april 25,2013 by selvam
	public function insert($table,$arr)
	{
	$result=  DB::insert($table,array_keys($arr))->values(array_values($arr))
			     ->execute();
			return $result;
	}
		/****selvam/may 9*****/
	public function get_total_bid_count($productid,$uid)
	{
		$select="select count(".SCRATCHBIDHISTORY.".product_id),max(".SCRATCHBIDHISTORY.".price) as bid_count,".PRODUCTS.".product_name,".PRODUCTS.".product_url,".PRODUCTS.".product_image,
".PRODUCTS.".product_process,".PRODUCTS.".enddate,".PRODUCTS.".product_image,".PRODUCTS.".in_auction FROM ".SCRATCHBIDHISTORY." LEFT JOIN ".PRODUCTS." on ".PRODUCTS.".product_id = ".SCRATCHBIDHISTORY.".product_id where ".SCRATCHBIDHISTORY.".product_id=".PRODUCTS.".product_id and ".SCRATCHBIDHISTORY.".user_id = ".$uid." and ".PRODUCTS.".product_id = ".$productid." and ".PRODUCTS.".product_status='".ACTIVE."'  group by ".SCRATCHBIDHISTORY.".product_id,".SCRATCHBIDHISTORY.".user_id order by ".SCRATCHBIDHISTORY.".id desc";
		
			$query=DB::query(Database::SELECT,$select)
				->execute()
				->as_array();
			return $query[0]['count('.SCRATCHBIDHISTORY.'.product_id)'];		
	}
	/****selvam on 11.07.2013****/
	/***To prevent directly access the module url if it is uninstalled******/
	public function check_scratch_present()
	{
		$res=DB::select('typename')
		->from(AUCTIONTYPE)
		->where('typename','=','scratch')
		->and_where('status','=',ACTIVE)
		->execute()
		->as_array();
		return $res;
	}
	
        
} // End commonfunction Model
