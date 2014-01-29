<?php defined('SYSPATH') or die('No direct script access.');
/**
* Contains auctions Model database queries

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Auction extends Model {

	/**
	* ****__construct()****
	*
	* setting up session variables
	*/
        public function __construct()
        {	
        	$this->session = Session::instance();
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
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
	
	/** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_live_auctions($date,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.product_category',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',
				PRODUCT_CATEGORY.'.id',
				PRODUCT_CATEGORY.'.status',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.".product_process",'=',LIVE)
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCT_CATEGORY.'.status','=',ACTIVE)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC')	
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
	public function select_home_auctions($category_name,$date,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.product_category',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',
				PRODUCT_CATEGORY.'.id',
				PRODUCT_CATEGORY.'.status',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.".product_process",'=',LIVE)
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCTS.'.product_category','=',$category_name)
					->and_where(PRODUCT_CATEGORY.'.status','=',ACTIVE)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC')	
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
	* @param $date of current date timestamp
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_home_auctions_index($category_name,$date,$forslide=FALSE,$need_count=FALSE)
	{
		$query=DB::select()->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->and_where(PRODUCTS.".startdate",'>=',$date)
					->and_where(PRODUCTS.'.product_category','=',$category_name)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_id','DESC');
		if($need_count)
		{
			$result=$query->execute();
			return count($result);
		}
		else
		{
			if($forslide)
			{
				$result=$query  ->limit(10)
			                        ->execute()
					        ->as_array();
			}
			else
			{
				$result=$query  ->limit(3)
			                        ->execute()
					        ->as_array();
			}
			return $result;
		}
	}

	/** 
	* Select banner image from banner table
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_home_banner($need_count=FALSE)
	{
		$query=DB::select('title','banner_image','banner_status')->from(BANNER)
					->where("banner_status",'=',ACTIVE)
					->and_where("banner_image",'!=',"")	
					->order_by("order",'ASC')	
					->execute()
					->as_array();
		return ($need_count)?count($query):$query;
	}

	/** 
	* Select userbonus
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_user_bonus_in_user($need_count=FALSE)
	{
		$query=DB::select('user_bonus')->from(USERS)				
					->where("user_bonus",'>=',0)		
					->execute()
					->as_array();
		return ($need_count)?count($query):$query;
	}

	/** 
	* Select product enabled for bonus
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_product_enabled_bonus($id,$need_count=FALSE)
	{
		$query=DB::select('user_bonus')->from(PRODUCTS)					
					->where("product_id",'=',$id)			
					->and_where("product_id",'=',$id)		
					->execute()
					->as_array();
		return ($need_count)?count($query):$query;
	}

	/** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_live_only_auctions($date,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.current_price',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.product_category',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.auction_type',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',
				PRODUCT_CATEGORY.'.id',
				PRODUCT_CATEGORY.'.status',
				USERS.'.photo')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.".product_process",'=',LIVE)
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCT_CATEGORY.'.status','=',ACTIVE)
					->and_where(PRODUCTS.".startdate",'<=',$date)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC')	
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
	public function select_products_user_forbid($pid,$need_count=FALSE)
	{
		$query=DB::select()->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
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
		$query=DB::select()->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.".product_id",'=',$pid)
					->and_where(PRODUCTS.".dedicated_auction",'=',ENABLE)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->execute()
					->as_array();
		return count($query);
		
	}
	
	/** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_category_auctions($category_name,$offset, $val,$need_count=FALSE)
	{
		 $query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC'); 
					
		if($category_name!='')
		{
			
			$result=$query->where(PRODUCTS.'.product_category','=',$category_name);
		}
				
					
		if($need_count)
		{	
			$result=$query->execute();	
			return count($result);
		}
		else
		{
			$result= $query	->limit($val)
					->offset($offset)
					->execute()->as_array();
			return $result;
		}
		
	}
	
	/** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_category_auctions_forajax($category_name,$offset, $val,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.auction_type',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->where(PRODUCTS.'.product_category','=',$category_name)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC');
					
		if($need_count)
		{	
			$result=$query->execute();	
			return count($result);
		}
		else
		{
			$result= $query	->limit($val)
					->offset($offset)
					->execute()->as_array();			
			return $result;
		}
		
	}


        /** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_live_category_auctions($category_name,$offset, $val,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->where(PRODUCTS.'.product_category','=',$category_name)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->and_where(PRODUCTS.'.product_process','=',LIVE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC');
					
		if($need_count)
		{	
			$result=$query->execute();	
			return count($result);
		}
		else
		{
			$result= $query	->limit($val)
					->offset($offset)
					->execute()
					->as_array();
			return $result;
		}
		
	}
	
	 /** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_future_category_auctions($category_name,$offset, $val,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.'.product_category','=',$category_name)
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->and_where(PRODUCTS.'.product_process','=',FUTURE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC');
					
		if($need_count)
		{	
			$result=$query->execute();	
			return count($result);
		}
		else
		{
			$result= $query	->limit($val)
					->offset($offset)
					->execute()
					->as_array();
			return $result;
		}
		
	}
	
	/** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_closed_category_auctions($category_name,$offset, $val,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',
				USERS.'.user_bid_account',USERS.'.photo')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.'.product_category','=',$category_name)
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->and_where(PRODUCTS.'.enddate','<=',$this->getCurrentTimeStamp)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC');
					
		if($need_count)
		{	
			$result=$query->execute();	
			
			return count($result);
			
		}
		else
		{
			$result= $query	->limit($val)
					->offset($offset)
					->execute()->as_array();
			
			return $result;
		}
		
	}
	/** 
	* Select products and users table with left join 	
	* @param $date of current date timestamp
	* @param $offset,$val will be for pagination
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_future_auctions($offset, $val,$need_count=FALSE)
	{


		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.product_category',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.dedicated_auction',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				PRODUCT_CATEGORY.'.id',
				PRODUCT_CATEGORY.'.status',
				USERS.'.user_bid_account')->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.".product_process",'=',FUTURE)
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCT_CATEGORY.'.status','=',ACTIVE)
					->and_where(PRODUCTS.".startdate",">=",$this->getCurrentTimeStamp)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC');
					
		if($need_count)
		{
			$result=$query->execute();
			return count($result);
		}
		else
		{
			$result=$query	->limit($val)
					->offset($offset)
					->execute()
					->as_array();
			return $result;
		}
	}
	
	/** 
	* Select products and users table with left join 	
	* @param $date of current date timestamp
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_transfer_future_live_auctions($date,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',
									PRODUCTS.'.startdate',
									PRODUCTS.'.enddate',
									PRODUCTS.'.in_auction',
									PRODUCTS.'.auction_type')->from(PRODUCTS)
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
	* @param $date of current date timestamp
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_future_auctions_index($date,$forslide=FALSE,$need_count=FALSE)
	{
		$query=DB::select()->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->and_where(PRODUCTS.".startdate",'>=',$date)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_id','DESC');
		if($need_count)
		{
			$result=$query->execute();
			return count($result);
		}
		else
		{
			if($forslide)
			{
				$result=$query  ->limit(10)
			                        ->execute()
					        ->as_array();
			}
			else
			{
				$result=$query  ->limit(3)
			                        ->execute()
					        ->as_array();
			}
			return $result;
		}
	}
	
	/**
	 * ****Checking current status of the auction item****
	 * @param $sdate , $edate eg. 2011-11-16 20:15:00
	 * @return 0 1 2
	 */	
	public function currentstatus($sdate,$edate)
	{
		$currentdate=$this->getCurrentTimeStamp;
		$today=date("Y-m-d")." "."23:59:59";
		if($sdate > $currentdate)
		{
			return 0;//Coming soon
		}
		else if($sdate < $currentdate)
		{
			return 1;//live
		}
		else if($edate < $currentdate)
		{
			return 2;//closed
		}
		
	}
	
	/***  Select Category product by venkatraja    ****/	
	public function select_category_count($category_id,$offset='',$val='',$need_count=false)
	
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
			
		return	array_slice($arr,$offset,$val);
			
			
		}			
				
		
		
	}
	
	
	
	
	/*** Select Winners Products for the suations(added by Venkatraja) ***/
	public function select_winners_count($offset='',$val='',$need_count=false)
	
	{
		$i=0;
		  $sql="select typename from ".AUCTIONTYPE." where pack_type='M' and status='A' and typename !='buyerseller'";
					
					$query1 = Db::query(Database::SELECT, $sql)
					->execute()->as_array();		
					$arr=array();
					
		foreach($query1 as $results){
					
		$tablename=TABLE_PREFIX.$results['typename'];
			
		$query2=DB::select(PRODUCTS.'.product_id',PRODUCTS.'.auction_type',array($tablename.'.product_id','table_product_id'))
			->from($tablename)
			->join(PRODUCTS,'left')
			->on($tablename.'.product_id','=',PRODUCTS.'.product_id')
			->where($tablename.'.product_process','=',CLOSED)
			->where(PRODUCTS.'.in_auction','=',2)
			->where($tablename.'.lastbidder_userid','!=',0)
			->execute()->as_array();
			
			$arr=array_merge($arr,$query2);
					
		}
				
		if($need_count)
		{
			 
			return count($arr);
		}
		else
		{
			
		return	array_slice($arr,$offset,$val);
			
			
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

	
	/** 
	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_products_query($status=1,$pid="",$array=array(),$need_count=FALSE)
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
			default:
				$id="A";
				break;
		}
		$query=DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				PRODUCTS.'.increment_timestamp',
				PRODUCTS.'.max_countdown',
				PRODUCTS.'.dedicated_auction',
				PRODUCTS.'.product_featured',
				PRODUCTS.'.auction_type',				
				PRODUCTS.'.autobid',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->and_where(PRODUCTS.'.product_status','=',ACTIVE);

		if($id=="CT" && !empty($array))
		{
			
			return $this->select_category_auctions_forajax($array['category_id'],$array['offset'],$array['limit']);
			
		
		}	
		else if($id=="OL")
		{
			$query=$query->and_where(PRODUCTS.'.product_process','=',LIVE)->and_where(PRODUCTS.".startdate",'<=',$this->getCurrentTimeStamp)->and_where(PRODUCTS.".enddate",'>=',$this->getCurrentTimeStamp)->and_where(PRODUCTS.'.auction_process','!=','H');
			$result=$query->execute()->as_array();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="H")
		{
			$query=$query->and_where(PRODUCTS.'.product_process','=',LIVE);
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		
		}	
		else if($id=="PD")
		{
			$query=$query->and_where(PRODUCTS.".product_id",'=',$pid);
			$result=$query->execute();
			return ($need_count)?count($result):$result;
		
		}	
		else if ($id=="F")
		{
			$query=$query->and_where(PRODUCTS.'.product_process','=',FUTURE);
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
			$query=$query->and_where(PRODUCTS.'.in_auction','=',1);
			$result=$query->execute()->as_array();			
			return ($need_count)?count($result):$result;
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
				PRODUCTS.'.product_gallery',
				PRODUCTS.'.buynow_status',	
				PRODUCT_CATEGORY.'.id',
				PRODUCT_CATEGORY.'.status')->from(PRODUCTS)
					->where(PRODUCTS.".product_url",'=',$id)
					 ->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCT_CATEGORY.'.status','=',ACTIVE)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->execute();					
		return ($need_count)?count($query):$query;
	}


	/** 
	* Select bid_history and users table with left join 
	* @param id, records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_products_users($id,$need_count=FALSE)
	{
		$query=DB::select()->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.'.product_id','=',$id)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->execute();
		return ($need_count)?count($query):$query;
	}
	
	/** 
	* Select bid_history and users table with left join 
	* @param id
	* @return array list of all users
	*/
	public function select_users($id)
	{
		return $query=DB::select()->from(USERS)->where('id','=',$id)->execute()->as_array();
	}
	
	/** 
	* Select bid_history and users table with left join 
	* @param id
	* @return array list of all users
	*/
	public function select_users_status($id)
	{
		return $query=DB::select('status')->from(USERS)->where('id','=',$id)->execute()->as_array();
	}
		
	/** 
	* Update product complete table 
	* @param $table for tablename
	* @param $arr for array of keys and values(i.e. keys=>tableFieldName,values=>PostValues) to update
	* @param $id for where condition to update
	**/
	public function update_product_table($table,$arr,$id)
	{
		return $query=DB::update($table)->set($arr)->where('product_id','=',$id)->execute();
	}

     	/** 
	* Update product time in a table 
	* @param $table for tablename
	* @param $arr for array of keys and values(i.e. keys=>tableFieldName,values=>PostValues) to update
	* @param $id for where condition to update
	**/
	public function update_product_time($table,$arr,$id)
	{
		return $query=DB::update($table)->set($arr)->where('product_id','=',$id)->execute();
	}

	/** 
	* Select products and users table with left join 
	* @return array list of all users and products
	* all wih pagination
	**/		 
        public function select_closed_auctions($offset,$val,$need_count=FALSE) 
	{
		$query = DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.current_price',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.autobid',
				PRODUCTS.'.product_status',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				USERS.'.id',
				USERS.'.username',
				USERS.'.latitude',
				USERS.'.longitude',
				USERS.'.user_bid_account',USERS.'.photo')
					->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.'.enddate','<=',$this->getCurrentTimeStamp)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCT_CATEGORY.'.status','=',ACTIVE)
					->and_where(PRODUCTS.'.in_auction','!=',0);
			
		if($need_count)
		{
			$result=$query->execute();
			return count($result);
		}
		else
		{
			$result=$query	->limit($val)
					->offset($offset)
					->order_by(PRODUCTS.'.enddate','DESC')
					->execute()
					->as_array();
			return $result;
		}
		    
		 
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
	* Select all in bid histories table
	* @param $pid='product id',$uid='user id'
	* @return array 
	**/
	public function winner_user_amount_spent($pid,$uid)
	{
                $query = DB::select()
			->from(BID_HISTORIES)
			->where('product_id','=',$pid)
			->and_where('user_id','=',$uid)
			->execute()
			->as_array();
	        return $query;
	}

	/** 
	* Select products and users table with left join 
	* @return array list of all users and products
	**/		 
        public function select_closed_auctions_index($forslide=FALSE,$need_count=FALSE) 
	{
	      $query = DB::select(USERS.'.photo',
				USERS.'.username',
				PRODUCTS.'.product_url',				
				PRODUCTS.'.product_name',				
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.autobid',				
				PRODUCTS.'.lastbidder_userid',			
				PRODUCTS.'.current_price',PRODUCTS.'.enddate')
			->from(PRODUCTS)
			->join(USERS,'left')
			->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
			->where(PRODUCTS.'.in_auction','=',2)
			->and_where(PRODUCTS.'.product_status','=',ACTIVE);
			

		if($need_count)
		{
			$result=$query	->order_by(PRODUCTS.'.enddate','DESC')
					->execute();
			return count($result);
		}
		else
		{
			if($forslide)
			{
				$result=$query  ->limit(10)
						->order_by(PRODUCTS.'.enddate','DESC')
			                        ->execute()
					        ->as_array();
			}
			else
			{
				$result=$query  ->limit(3)
						->order_by(PRODUCTS.'.enddate','DESC')
			                        ->execute()
					        ->as_array();
			}
			return $result;			
		}
	
	}

	/** 
	* Select winners and joined users, products
	* @return array list of all winners, users and products
	* all wih pagination
	*/	
	public function select_users_products_winners($offset, $val,$need_count=FALSE)
	{
	
		$query = DB::select(PRODUCTS.'.product_id',
				PRODUCTS.'.product_name',
				PRODUCTS.'.product_url',
				PRODUCTS.'.product_image',
				PRODUCTS.'.product_info',
				PRODUCTS.'.product_cost',
				PRODUCTS.'.current_price',
				PRODUCTS.'.bidding_countdown',
				PRODUCTS.'.bidamount',
				PRODUCTS.'.product_status',
				PRODUCTS.'.product_process',
				PRODUCTS.'.auction_process',
				PRODUCTS.'.lastbidder_userid',
				PRODUCTS.'.autobid',
				PRODUCTS.'.startdate',
				PRODUCTS.'.enddate',
				USERS.'.id',
				USERS.'.username',
				USERS.'.photo',
				USERS.'.country',
				USERS.'.user_bid_account')
					->from(PRODUCTS)
					->join(USERS,'left')
					->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
					->where(PRODUCTS.'.product_process','=',CLOSED)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)			
					->and_where(PRODUCTS.'.lastbidder_userid','!=',0)
					->join(PRODUCT_CATEGORY,'left')
					->on(PRODUCTS.'.product_category','=',PRODUCT_CATEGORY.'.id')
					->and_where(PRODUCT_CATEGORY.'.status','=',ACTIVE); 
		if($need_count)
		{
			$result=$query->execute();
			return count($result);
		}
		else
		{
			$result=$query	->limit($val)
					->offset($offset)
					->order_by(PRODUCTS.'.enddate','DESC')
					->execute()
					->as_array();
			return $result;
		}
	}

	/** 
	* Check watchlist table having same product id in user id
	* @return true or false when count is greater than 0
	*/
	public function check_flike_table($uid)
	{
		$query=DB::select()->from(FLIKE_USERS)
					->and_where('userid','=',$uid)
					->execute();	
		return count($query)>0?FALSE:TRUE;
		
	}

	/** 
	* Check watchlist table having same product id in user id

	* @return true or false when count is greater than 0
	*/
	public function check_watchlist_table($pid,$uid)
	{
		$query=DB::select()->from(WATCHLIST)
					->where('product_id','=',$pid)
					->and_where('user_id','=',$uid)
					->execute();	
		return count($query)>0?FALSE:TRUE;
		
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
	* Check bid_history table having same product id in user id
	* @return true or false when count is greater than 0
	*/
	public function check_bid_history_table($pid)
	{
		$query=DB::select()->from(BID_HISTORIES)
					->where('product_id','=',$pid)
					->execute();	
		return count($query)>0?FALSE:TRUE;
		
	}
	
        // Bid History count 		
	public function select_bid_history_count($uid,$pid)
	{	
		$query=DB::select()->from(BID_HISTORIES)
					->where('product_id','=',$pid)
					->and_where('user_id','=',$uid)
					->execute();	
		return count($query)>0?1:0;
	}
	
	// Bid history last amount select 
	public function select_bid_history_last_amt($uid,$pid)
	{	
		$query=DB::select()->from(BID_HISTORIES)
					->where('product_id','=',$pid)
					->and_where('user_id','=',$uid)
					->order_by('id','DESC')
					->limit(1)
					->execute();	
		return $query[0]['price'];
	}

	/**
	* Check inline textbox label not empty for javscript on focus and on blur
	**/
	public static function check_label_not_empty($fieldname,$value)
	{
		return ($fieldname == $value)?FALSE:TRUE;
	}	

	


	public function validate_autobid($arr,$userid,$select_autobid_productid,$balance,$bonus_balance,$select_autobid_lastbider)
	{ 
	     
		$validate=Validation::factory($arr)
			->rule('auctionid','not_empty')	
			->rule('product_name','not_empty')
			->rule('autobid_amt','not_empty')
			
			->rule('autobid_amt','Model_Auction::check_label_not_empty',array(":value",__('enter_auto_bid_amount')))
                        ->rule('autobid_amt','numeric')
			->rule('autobid_start_amount','not_empty')
			
			->rule('autobid_start_amount','compare_value_greater',array(explode(",",$arr['autobid_amt']),explode(",",$arr['autobid_start_amount']),'current price'))
                        ->rule('autobid_start_amount','numeric');

		if($userid!="")
		{
			$check_bonus_product=DB::select('product_id','autobid','dedicated_auction')->from(PRODUCTS)->where('product_id','=',$arr['product_name'])
			->execute()->as_array();			
			if($arr['product_name']!="")
			{
				if($check_bonus_product[0]['dedicated_auction']==ENABLE){
				  //User bonus amount balance compare validation	
				  if($arr['autobid_amt'] >$bonus_balance) {	
				   $validate->rule('autobid_amt','Model_Auction::check_userbid_morethan',array(':value',$userid,TRUE));
				   
					
				   }
				   else
				   {
					$auction=$this->getauctiontype($arr['auctionid']);
					$tablename=TABLE_PREFIX.$auction;
					$validate->rule('autobid_start_amount','Model_Auction::ab_product_current_price',array($arr['product_name'],$tablename,':value'));
				   }
				}
				else{
	
				      //User balance compare validation	
				     if($arr['autobid_amt'] > $balance) {
				      $validate->rule('autobid_amt','Model_Auction::check_userbid_morethan',array(':value',$userid));
				      
				     }
				     else{
					$auction=$this->getauctiontype($arr['auctionid']);
					$tablename=TABLE_PREFIX.$auction;
					$validate->rule('autobid_start_amount','Model_Auction::ab_product_current_price',array($arr['product_name'],$tablename,':value'));
				   
				     }
				}
				
			}
	
			if($select_autobid_lastbider > 0)
                        {				
                            }else{
			       if($arr['product_name'])
			       {
				$validate->rule('autobid_amt','compare_value_greater',array(explode(",",$arr['autobid_amt']),explode(",",$select_autobid_productid[0]['current_price']),'Current price'));				
			       }
			  }			 
			$validate->rule('autobid_amt','Model_Auction::autobid_already_exists',array($userid,$arr['product_name']));
		}
		return $validate;
	}

	public function checkuser($userid)
	{
		$tablename=TABLE_PREFIX."users";
		$checkuser="select $tablename.username from $tablename where $tablename.id=$userid and DATEDIFF(CURDATE(),$tablename.created_date)<30";
		
			$query=Db::query(Database::SELECT,$checkuser)
					->execute()
					->get('username');
			if($query && $query!="")
			{
				$sql="select count(product_id) as count from ".PRODUCTS." where lastbidder_userid=$userid";
				//
				$query1=Db::query(Database::SELECT,$sql)
					->execute()
					->get('count');
				if($query1!=0)
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			else
			{
				return false;
			}
	}
	
	public static function getauctiontype($id)
	{
		$query2= DB::select('typename')->from(AUCTIONTYPE)
			     ->where('typeid','=',$id)			     
			     ->execute()	
			     ->get('typename'); //Type Name	
			
			return $query2;
	}
	//Select auto bid users	
	public function select_autobid_users($uid)
	{
		
		$query=DB::select()->from(AUTOBID)
					->join(USERS,'left')
					->on(AUTOBID.'.userid','=',USERS.'.id')
					->join(PRODUCTS,'left')
					->on(PRODUCTS.'.product_id','=',AUTOBID.'.product_id')
					->where(AUTOBID.'.userid','=',$uid)
					->execute();
					//->as_array();
		return $query;
	}

	/**** For autobid *******/
	public function select_product_has_autobid()
	{	
		$query=DB::select('product_id','product_name','autobid')
				->from(PRODUCTS)
				->where('autobid','=',ENABLE)
				->and_where(PRODUCTS.".product_process",'=',LIVE)
				->and_where(PRODUCTS.".startdate",'<=',$this->getCurrentTimeStamp)
				->and_where(PRODUCTS.'.product_status','=',ACTIVE)
				->execute();
		return $query;
	}

	public function select_autobid($id)
	{
		$sql="select * from auction_autobid where product_id=$id";
		$query=Db::query(Database::SELECT,$sql)
					->execute()->as_array();
		return $query;
	}
	//select array bid
	public function select_abid()
	{
		$result=array();
		$sql='SELECT  a.product_id , p.auction_type, GROUP_CONCAT( a.userid ORDER BY a.`time` ASC SEPARATOR "-") as uid,GROUP_CONCAT( a.autobid_start_amount ORDER BY a.`time` ASC SEPARATOR "-") as astart FROM '.AUTOBID.' as a LEFT JOIN '.USERS.' as u on a.userid = u.id LEFT JOIN '.PRODUCTS.' as p on a.product_id  = p.product_id  where u.status = "'.ACTIVE.'"  group by  a.product_id';		
		$query=Db::query(Database::SELECT,$sql)
			->execute()->as_array();
		
		
		foreach($query as $q)
		{
			$uid=explode("-",$q['uid']);
			$astart=explode("-",$q['astart']);
			$newuid=array();
			foreach($uid as $k => $u)
			{
				$newuid[]=$u."-".$astart[$k];
			}
			$result[]=array($q['product_id']."_".$q['auction_type']=>$newuid);
		}		
		
		return $result;
		
	}

	/** 
	* Select products and users table with left join 	
	* @param $date of current date timestamp
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_products_to_update($pid,$date,$need_count=FALSE)
	{
		$query=DB::select(PRODUCTS.'.product_id',		
				PRODUCTS.'.startdate',		
				PRODUCTS.'.auction_type',
				PRODUCTS.'.enddate',
				PRODUCTS.'.max_countdown')->from(PRODUCTS)									
					->where(PRODUCTS.'.product_status','=',ACTIVE)
					->and_where(PRODUCTS.'.in_auction','=',1);
					
		
		$result = $query->and_where(PRODUCTS.'.product_id','=',$pid)->limit(1)->execute()->as_array();
		if($need_count)
		{
			return count($result);
		}
		else
		{
			return $result;
		}
	}

	/** 

	* Select products and users table with left join 
	* @param records count needed or not
	* @return array when param is false
	* @return count when param is true
	*/
	public function select_product_add_block($pids=array(),$need_count=FALSE)
	{
		if(!empty($pids)){
		$query=DB::select(PRODUCTS.'.product_id',PRODUCTS.'.auction_type')->from(PRODUCTS)
					->where(PRODUCTS.'.product_id', 'IN' ,$pids)
					->and_where(PRODUCTS.'.product_status','=',ACTIVE)
					->order_by(PRODUCTS.'.product_featured','ASC')
					->order_by(PRODUCTS.'.product_id','DESC')	
					->execute()
					->as_array();
		}
		else{ $query=array();}
		$typesarray=array();
		foreach($query as $fields)
		{
			$typesarray[$fields['auction_type']] = $fields['product_id'];
		}
		return $typesarray;
		
	}

	//Manage auto bid
	public function manage_autobid($uid,$pid)
	{
		$result=DB::select('bid_amount','product_id','userid')->from(AUTOBID)
					->where('userid','=',$uid)
					->and_where('product_id','=',$pid)
					->execute();
		return $result;
	}

	//Auto bis user amount
	public function select_autobid_users_amount($uid,$product_id)
	{
		$query=DB::select('userid','product_id','bid_amount')->from(AUTOBID)
					->where(AUTOBID.'.userid','=',$uid)
					->and_where(AUTOBID.'.product_id','=',$product_id)
					->execute();
		return $query;
	}

	//Manage auto bid
	public function edit_autobid($uid,$pid)
	{
		$result=DB::select()->from(AUTOBID)		                        
		                        ->join(PRODUCTS,'left')
					->on(PRODUCTS.'.product_id','=',AUTOBID.'.product_id')
					->where(AUTOBID.'.userid','=',$uid)
		                        ->and_where(AUTOBID.'.product_id','=',$pid)
					->execute()
					->as_array();
		return $result;
	}

	//Auto bid amount
	public function select_auto_bid_amount($uid,$product_id)
	{
		$query=DB::select()
			->from(AUTOBID)
			->where(AUTOBID.'.product_id','=',$product_id)
			->and_where(AUTOBID.'.userid','=',$uid)
			->execute();
		return $query;
	}

	/**
	* Validation rule for fields in forgot password
	*/
	public function autobid_validation($arr,$uid)
	{
	
	
		$validate= Validation::factory($arr)
			->rule('product_name','not_empty')
			->rule('bid_amount','not_empty')
			->rule('bid_amount','Model_Auction::check_label_not_empty',array(":value",__('enter_auto_bid_amount')))
			->rule('bid_amount','regex',array(':value','/^[0-9`\'".,]*$/u'))
			->rule('bid_amount','numeric');
			if($uid!="")
			{
			
 				$check_bonus_product=DB::select('product_id','autobid','dedicated_auction')->from(PRODUCTS)->where('product_id','=',$arr['product_id'])->execute()->as_array();
			if($arr['product_id']!=""){
			
				if($check_bonus_product[0]['dedicated_auction']=="E"){

				
					$validate->rule('bid_amount','Model_Auction::check_userbid_morethan',array(':value',$uid,TRUE));

				}
				else{
				
				$validate->rule('bid_amount','Model_Auction::check_userbid_morethan',array(':value',$uid));}
			}
			//$validate->rule('bid_amt','Model_Auction::autobid_already_exists',array($uid,$arr['product_name']));
		}
		return $validate;
	}
	
	/**
	* Validation rule for fields in forgot password
	*/
	public function edit_autobid_validation($arr,$uid)
	{
		$validate= Validation::factory($arr)
			->rule('product_name','not_empty')
			->rule('bid_amount','not_empty')
			->rule('bid_amount','Model_Auction::check_label_not_empty',array(":value",__('enter_auto_bid_amount')))
			->rule('bid_amount','regex',array(':value','/^[0-9`\'".,]*$/u'))
			->rule('bid_amount','numeric');			
		if($uid!="")
		{
 
			$check_bonus_product=DB::select('product_id','autobid','dedicated_auction')->from(PRODUCTS)->where('product_id','=',$arr['product_id'])
			->execute()->as_array();
			
			if($arr['product_id']!=""){
			
				if($check_bonus_product[0]['dedicated_auction']==ENABLE){

				
				$validate->rule('bid_amount','Model_Auction::check_userbid_morethan',array(':value',$uid,TRUE));

				}
				else{
					
				$validate->rule('bid_amount','Model_Auction::check_userbid_morethan',array(':value',$uid));}
			}
			$validate->rule('bid_amount','Model_Auction::autobid_already_exists',array($uid,$arr['product_name']));
		}
		return $validate;
	}

	//Update Auto bid
	public function update_bidamount($uid,$_POST,$amt_set)
	{
	
                $query=DB::update(AUTOBID)
			->set(array('bid_amount'=>$amt_set,'time'=>$this->getCurrentTimeStamp))
			->where('product_id','=',$_POST['product_id'])
			->and_where('userid','=',$uid)
			->execute();
		return $query;
	}

	public static function check_userbid_morethan($amt,$uid,$need_bonus=FALSE)
	{	
		$need=($need_bonus)?'user_bonus':'user_bid_account';
		
		$query=DB::select('id','user_bid_account','user_bonus')->from(USERS)
				->where($need,'>=',(int)$amt)
				->and_where('id','=',$uid)
				->execute()->as_array();				
		return count($query)!=0?TRUE:FALSE;
	}

	public static function check_userbid_less($amt,$uid,$need_bonus=FALSE)
	{
	
		$need=($need_bonus)?'user_bonus':'user_bid_account';
		$query=DB::select('id','user_bid_account','user_bonus')->from(USERS)
				->where($need,'>=',$amt)
				->and_where('id','=',$uid)
				->execute()->as_array();
		return count($query)==0?FALSE:TRUE;
	}	

	public static function autobid_already_exists($uid,$pid)
	{
		
		$query=DB::select('bid_amount','product_id','userid')->from(AUTOBID)
					->where('userid','=',$uid)
					->and_where('product_id','=',$pid)
					->execute();
		if(count($query)>0)
		{ return FALSE;}
		else
		{ return TRUE;}
	}

	public function get_autobid_amt($uid,$pid)
	{
		$query=DB::select('bid_amount','product_id','userid','autobid_start_amount')->from(AUTOBID)
					->where('userid','=',$uid)
					->and_where('product_id','=',$pid)->limit(1)
					->execute()->as_array();
		if(count($query)>0)
		{ return $query;}
		else
		{ return array();}
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
	
	public function delete_autobid($uid,$pid)
	{
		$query=DB::delete(AUTOBID)
			->where('product_id','=',$pid)
			->and_where('userid','=',$uid)
			->execute();
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
							->where(PRODUCTS.'.product_process','=',CLOSED)
							->and_where(PRODUCTS.'.product_status','=',ACTIVE)
							->execute();
		return $query;
	}
	
	public function select_types()
	{
		$query = DB::select()->from(AUCTIONTYPE)
							->where(AUCTIONTYPE.'.status','=',ACTIVE)
							->execute();
		return $query;
	}
	
	//product current price check
	public static function check_product_current_price($product_id)
	{
		
		$query=DB::select('current_price')->from(PRODUCTS)
				->where('product_id','=',$product_id)
				->execute()
				->as_array();
		return $query;
		
	}
	
	public static function ab_product_current_price($product_id,$tablename,$startamt)
	{
		
		$query=DB::select('current_price')->from($tablename)
				->where('product_id','=',$product_id)
				->execute()
				->get('current_price');
		return $startamt<$query?FALSE:TRUE;
		
	}
	
	//product current price check
	public static function autobid_product_current_price($uid,$product_id,$arr)
	{

		$query=DB::select('product_id','current_price')->from(PRODUCTS)
				->where('product_id','=',$product_id)
				->execute()->as_array();
		
		return $query;
	}	
	
	// Bid History count 		
	public function select_bid_history_user($uid,$pid)
	{	
		
		$query=DB::select()->from(BID_HISTORIES)
					->where('product_id','=',$pid)
					->and_where('user_id','=',$uid)
					->execute();
		return count($query);
	}

	//Aution types

	 // Received Package Amount
	public function auction_types_list($product_id,$id)
	{
                        $query2= DB::select()->from(AUCTIONTYPE)
                                ->where('typeid','=',$product_id)			     
                                ->execute()	
                                ->as_array(); //Type Name	
                                $tablename=TABLE_PREFIX.$query2[0]['typename'];
                                $date=date("Y-m-d H:i:s");
                                $query= DB::select($tablename.'.product_id',$tablename.'.product_cost',$tablename.'.current_price',

                        PRODUCTS.'.product_name'
                        )->from($tablename)
                        ->where(PRODUCTS.'.auction_type','=',$product_id)
                        ->and_where(PRODUCTS.'.product_status','=','A')	
                        ->and_where(PRODUCTS.'.startdate','<=',$date)
                        ->and_where(PRODUCTS.'.enddate','>=',$date)
                        ->and_where(PRODUCTS.'.userid','!=',$id)//For buyer seller module concept
                        ->join(PRODUCTS,'left')

                        ->on($tablename.'.product_id','=',PRODUCTS.'.product_id')
                        ->execute()	
                        ->as_array(); 
                        return $query;
	}

	public function check_autobid_amt($autobid_amt,$product_id,$user)
	{
			$query2= DB::select()->from(PRODUCTS)
			     ->where('product_id','=',$product_id)			     
			     ->execute()	
			     ->as_array();
			$result['status']="Deny";
			$column=$query2[0]['dedicated_auction']=="D"?"user_bid_account":"user_bonus";
			$sql="select $column from auction_users where id=$user";
			$query=Db::query(Database::SELECT,$sql)
					->execute()->as_array();
			if($query[0][$column]>=$autobid_amt)
			{
				$result['status']="Allow";
				return $result;
			}
					
	}
	
	public function check_autobid_start($autobid_start,$product_id)
	{
			$result['status']="Deny";
			$query2= DB::select()->from(PRODUCTS)
			     ->where('product_id','=',$product_id)			     
			     ->execute()	
			     ->as_array();
			$auction_type=$query2[0]['auction_type'];
			$query3= DB::select()->from(AUCTIONTYPE)
			     ->where('typeid','=',$auction_type)			     
			     ->execute()	
			     ->as_array(); //Type Name	
			$tablename=TABLE_PREFIX.$query3[0]['typename'];
			$sql="select current_price from $tablename where product_id=$product_id";
			$query=Db::query(Database::SELECT,$sql)
					->execute()->as_array();
//			echo $query[0]['current_price'];exit;
			if($query[0]['current_price']<$autobid_start)
			{

				$result['status']="Allow";
				
			}
		return $result;
	}
	
}//End of auction model
?>
