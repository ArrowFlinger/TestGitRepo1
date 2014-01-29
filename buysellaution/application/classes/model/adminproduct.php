<?php defined('SYSPATH') or die('No direct script access.');

/*
* Contains Admin Products(Add Product,Manage Product) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Adminproduct extends Model
{

	/**
        * ****__construct()****
        * setting up session variables
        */
	public function __construct()
	{	
		$this->session = Session::instance();	
		$this->username = $this->session->get("username");
		$this->user_id = $this->session->get("id");
		$this->socialnetworkmodel=Model::factory('socialnetwork');

	}
    
        /**To Get Current TimeStamp**/
	public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}
	
	//For products dashboard starts here
	//----------------------------------------------------------
	public function get_last_30days_products()
	{
					
					$query = "SELECT COUNT(product_id) as products,DATE_FORMAT(`created_date`,'%b/%d') as create_date FROM ".PRODUCTS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() GROUP BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ORDER BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result;
					}


					/**
					* ****getcount_last_1month_products()****
					*
					* get last one month products added
					*/
					public function getcount_last_1month_products()
					{

						$query = "SELECT product_id as products FROM ".PRODUCTS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()";
						$result = Db::query(Database::SELECT, $query)
								->execute()
								->as_array();

							return count($result);                      
					}

					/**
					* ****getcount_last_1year_products()****
					*
					* get last one year products added
					*/
					public function getcount_last_1year_products()
					{	

					$query = "SELECT product_id as products FROM ".PRODUCTS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 1 YEAR) AND NOW()";
						$result = Db::query(Database::SELECT, $query)
								->execute()
								->as_array();
	
					return count($result);                      
					}
					/**
					* ****getcount_today_products()****
					*
					* get today products added
					*/
					public function getcount_today_products()
					{	

					$query = "SELECT product_id as products FROM ".PRODUCTS." WHERE  date(`created_date`) = date(curdate())";
					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();
					//print_r($result);exit;   
					return count($result);                      
					}
					/**
					* ****get_last_12months_products()****
					*
					* get last 12 month products added
					*/
					public function get_last_12months_products()
					{
					//$total_days=implode($days,",");
					$query = "SELECT COUNT(product_id) as products,DATE_FORMAT(`created_date`,'%b/%Y') as create_month FROM ".PRODUCTS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 1 YEAR) AND NOW() GROUP BY DATE_FORMAT(`created_date`,'%c-%Y') ORDER BY DATE_FORMAT(`created_date`,'%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();
					//                                print_r($result);exit;
					return $result;
					}
					/**
					* ****get_last_10_years_products()****
					*
					* get last 10 years products added
					*/
					public function get_last_10_years_products()
					{
					//$total_days=implode($days,",");
					$query = "SELECT COUNT(product_id) as products,DATE_FORMAT(`created_date`,'%Y') as create_year FROM ".PRODUCTS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 10 YEAR) AND NOW() GROUP BY DATE_FORMAT(`created_date`,'%Y') ORDER BY DATE_FORMAT(`created_date`,'%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();
					return $result;
					}

					/**
					* ****sold_products_details_today()****
					*
					* get count of today sold products
					*/
					public function sold_products_details_today($product_status="")
					{					
						$query = "SELECT count(product_id) as product_count,DATE_FORMAT(`created_date`,'%b/%d') as create_date,sum(current_price) as price FROM ". PRODUCTS . "  
					WHERE product_status='".$product_status."' AND 
					lastbidder_userid !=0 AND 
					date(`created_date`) = date(curdate()) GROUP BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ORDER BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();
					return $result;
					/*$query = "SELECT count(product_id) as product_count,DATE_FORMAT(`created_date`,'%b/%d') as create_date,sum(current_price) as price FROM ". PRODUCTS . "  
					WHERE product_status='".$product_status."' AND 
					lastbidder_userid !=0 AND 
					`created_date` = curdate() GROUP BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ORDER BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();
	
					return $result;*/
					}
					/**
					* ****sold_products_details_last7days()****
					*
					* get count of last 7 days sold products
					*/
					public function sold_products_details_last7days($product_status="")
					{
					$query = "SELECT count(product_id) as product_count,DATE_FORMAT(`created_date`,'%b/%d') as create_date,sum(current_price) as price FROM ". PRODUCTS . "  
					WHERE product_status='".$product_status."' AND 
					lastbidder_userid !=0 AND 
					`created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() GROUP BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ORDER BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();
					return $result;
					}
					/**
					* ****sold_products_details_last1month()****
					*
					* get count of last 1 month sold products
					*/
					/*public function sold_products_details_last1month($product_status="")
					{
					$query = "SELECT product_id as product_count,current_price as price FROM ". PRODUCTS . "  
					WHERE product_status='".$product_status."' AND 
					lastbidder_userid !=0 AND 
					`created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW()";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();

					return $result[0];
					}*/
					
				
					public function sold_products_details_last1month($product_status="")
					{
					$query = "SELECT count(product_id) as product_count,DATE_FORMAT(`created_date`,'%b/%d') as create_date,sum(current_price) as price FROM ". PRODUCTS . "  
					WHERE product_status='".$product_status."' AND 
					lastbidder_userid !=0 AND 
					`created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() GROUP BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ORDER BY DATE_FORMAT(`created_date`,'%d-%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();

					return $result;
					}
					
					/**
					* ****sold_products_details_last1year()****
					*
					* get count of last 1 year sold products
					*/

					public function sold_products_details_last1year($product_status="")
					{
					$query = "SELECT count(product_id) as product_count,DATE_FORMAT(`created_date`,'%b/%Y') as create_month,sum(current_price) as price FROM ". PRODUCTS . "  
					WHERE product_status='".$product_status."' AND 
					lastbidder_userid !=0 AND 
					`created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 12 MONTH) AND NOW() GROUP BY DATE_FORMAT(`created_date`,'%c-%Y') ORDER BY DATE_FORMAT(`created_date`,'%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();

					return $result;
					}
					/**
					* ****sold_products_details_last10year()****
					*
					* get count of last 1 year sold products
					*/

					public function sold_products_details_last10year($product_status="")
					{
					$query = "SELECT count(product_id) as product_count,DATE_FORMAT(`created_date`,'%Y') as create_year,sum(current_price) as price FROM ". PRODUCTS . "  
					WHERE product_status='".$product_status."' AND 
					lastbidder_userid !=0 AND 
					`created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 10 YEAR) AND NOW() GROUP BY DATE_FORMAT(`created_date`,'%Y') ORDER BY DATE_FORMAT(`created_date`,'%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();
					return $result;
					}
					
					/**
					* ****sold_products_details_all()****
					*
					* get count of all sold products
					*/

					public function sold_products_details_all($product_status="")
					{
					$query = "SELECT count(product_id) as product_count,DATE_FORMAT(`created_date`,'%Y') as create_year,sum(current_price) as price FROM ". PRODUCTS . "  
					WHERE product_status='".$product_status."' AND 
					lastbidder_userid !=0 GROUP BY DATE_FORMAT(`created_date`,'%Y') ORDER BY DATE_FORMAT(`created_date`,'%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
							->execute()
							->as_array();
					return $result;
					}
					/* 
					* name: get_last_30days_transaction()
					* @param
					* @return transaction list count per 30 days
					*/
					
					public function get_last_30days_transaction()
					{
					$query="SELECT COUNT(userid) as totaltrans,DATE_FORMAT(`transaction_date`,'%b/%d') as transaction_dates FROM auction_transaction_details WHERE `transaction_date` BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() GROUP BY DATE_FORMAT(`transaction_date`,'%d-%c-%Y') ORDER BY DATE_FORMAT(`transaction_date`,'%d-%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result;					

					}

					/** 
                * Select active product from products table
                * @param records count needed or not
                * @return array when param is false
                * @return count when param is true
                */
					public function select_active_product()
                {
                         $query=DB::select()->from(PRODUCTS)
		                                ->where("product_status",'=',ACTIVE)
		                                ->execute()
		                                ->as_array();
		                   return count( $query);
                }
                /** 
                * Select inactive product from products table
                * @param records count needed or not
                * @return array when param is false
                * @return count when param is true
                */
                public function select_inactive_product()
                {
                        $query=DB::select()->from(PRODUCTS)
			                        ->where("product_status",'=',IN_ACTIVE)
			                        ->execute()
			                        ->as_array();
			           return count( $query);
                }
	//----------------------------------------------------------
	//Dashboard Ends here

        /**
        * ****product_list()****
        * @return product list array 
        */
	public function product_list()
	{
                $rs = DB::select()->from(PRODUCTS)
                                ->execute()
                                ->as_array();
                return $rs;
	}

        /**
        * ****count_product_list()****
        * @return product list count of array 
        */ 
	public function count_product_list()
	{
                $rs = DB::select()->from(PRODUCTS)
                                ->execute()
                                ->as_array();
                return count($rs);
	}

        /**
        * ****count_product_list()****
        * @return product list count of array 
        */ 
	public function count_product_deleted_list()
	{
                $rs = DB::select()->from(PRODUCTS)
                                ->where('product_status','=',DELETED_STATUS)
                                ->execute()
                                ->as_array();
                return count($rs);
	}
        
        /**
        * ****all_product_list()****
        *@param $offset int, $val int
        *@return allproduct list count of array 
        */
	public function all_product_list($offset, $val)
	{
		$query  ="SELECT P.created_date,
				  U.username,U.id as usrid,
				  P.product_name,
				  P.enddate,
				  P.startdate,
				  P.product_id,
				  JC.category_name,
		 		  P.product_status,
		 		  P.auction_type,
		 	          P.product_process,
		 	          P.auction_process,
				  P.product_image,
				  P.product_cost,						
				  P.product_url						
				  FROM ".PRODUCTS." AS P
       		                  LEFT JOIN ".PRODUCT_CATEGORY." AS JC ON (JC.id =P.product_category)       		  
		 		  LEFT JOIN ".USERS." AS U ON(U.id = P.userid)
		 		  ORDER BY P.product_id DESC LIMIT $offset,$val";
	      $result = Db::query(Database::SELECT, $query)
			         ->execute()
			         ->as_array();
	      return $result;
	 }
			
        /**
        * ****all_active_product_list_count()****
        *@return all active product list count 
        */
	public function all_active_product_list_count()
	{
		$rs = DB::select()->from(PRODUCTS)
				->where(PRODUCTS.'.product_status', '=', ACTIVE)
				->execute()
				->as_array();	
	        return count($rs);
	}

        /**
        * ****all_sold_product_list_count()****
        *@return all sold product list count 
        */
	public function all_sold_product_list_count()
	{
		$rs = DB::select()->from(PRODUCTS)
				->where(PRODUCTS.'.lastbidder_userid', '!=',ZERO)
				->and_where('product_status','=',ACTIVE)
				->execute()
				->as_array();	
	        return count($rs);
	}
	
        /**
        * ****all_unsold_product_list_count()****
        *@return all unsold product list count 
        */
	public function all_unsold_product_list_count()
	{
		$rs = DB::select()->from(PRODUCTS)
				->where(PRODUCTS.'.lastbidder_userid', '=',ZERO)
				->and_where('product_status','=',ACTIVE)
				->execute()
				->as_array();
	        return count($rs);
	}
        
        /**
        * ****all_unsold_product_list_count()****
        *@return all unsold product list count 
        */
	public function all_future_product_list_count()
	{
		$rs = DB::select()->from(PRODUCTS)
				->where(PRODUCTS.'.product_process', '=',FUTURE )
				->execute()
				->as_array();	
	        return count($rs);
	}
        
        /**
        * ****inactive_product_list_count()****
        *@return all in active product list count 
        */	 
	public function inactive_product_list_count()
	{

		$rs = DB::select()->from(PRODUCTS)
				->where(PRODUCTS.'.product_status', '=', IN_ACTIVE)
				->execute()
				->as_array();	
	    return count($rs);
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
                                ->order_by('category_name', 'ASC')
                                ->execute()	
                                ->as_array();
		return $rs;

	}

        /**
        * ****all_username_list()****
        *@param $offset int, $val int
        *@return allproduct added username count of array 
        */
	public function all_username_list()
	{
	 	$rs   = DB::select('username','userid')->distinct(TRUE)
                                ->from(PRODUCTS)->join(USERS,'LEFT')->on(USERS.'.id', '=', PRODUCTS.'.userid')
                                ->where(PRODUCTS.'.product_status', '=', ACTIVE)
                                ->where(USERS.'.username', '!=', " ")
                                ->order_by('username', 'ASC')
                                ->execute()	
                                ->as_array();
		return $rs;
	}
	
	/**
        *****all_available_active_username_list()****
        *@return all active username from users table
        */	 
	public function all_available_active_username_list()
	{
                $rs   = DB::select('username','id')->distinct(TRUE)
                        ->from(USERS)
                        ->where(USERS.'.status', '=', ACTIVE)
                        ->where(USERS.'.usertype','=', USER)
                        ->where(USERS.'.username', '!=', " ")
                        ->order_by('username', 'ASC')
                        ->execute()	
                        ->as_array();
                return $rs;
	}
        
        
        /**
        *****all_available_active_username_list()****
        *@return all active username from users table
        */	 
	public function all_available_active_admin_list()
	{
                $rs   = DB::select('username','id')->distinct(TRUE)
                        ->from(USERS)
                        ->where(USERS.'.status', '=', ACTIVE)
                        ->where(USERS.'.usertype','=', ADMIN)
                        ->where(USERS.'.username', '!=', " ")
                        ->order_by('username', 'ASC')
                        ->execute()	
                        ->as_array();
                return $rs;
	}
        
        /**To Check product  url is Already Available or Not**/
	public function unique_producturl($producturl)
	{
		// Check if the product url already exists in the database
		$sql = "SELECT product_url FROM ".PRODUCTS." WHERE product_url='$producturl'";   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();

			if(count($result) > 0)
			{
				return 1;
			}
			else
			{
				return 0;		
			}
	}	
        
        /**
        * Check productname exists or not for server side validation
        * @return TRUE or FALSE
        */
	public static function unique_product_name($product_name)
    	{
		return ! DB::select(array(DB::expr('COUNT(product_name)'), 'total'))
		    			->from(PRODUCTS)
		    			->where('product_name', '=', $product_name)
		    			->execute()
		    			->get('total');
    	}

       	/*
	Enddate Validate
	*/
	public static function datevalidate($startdate,$enddate)
    	{
		if($startdate <= $enddate )
		{
		  return true;
		}
		else {
		 return false;
		}
    	}

        /*
        Enddate Validate
        */
	public static function start_datevalidate($startdate)
    	{
		if($startdate >= TODAY_START )
		{
		  return true;
		}
		else {
		 return false;
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
	public function add_product_form($arr,$settings,$imagefile) 
	{
                $arr['product_name'] = trim($arr['product_name']);   
                $arr['shipping_fee'] = trim($arr['shipping_fee']);    
                $start= Validation::factory($arr,$settings)    
                ->rule('product_name', 'not_empty')
                ->rule('product_name','alpha_space')
                ->rule('product_name','not_numbers')                
                ->rule('product_name', 'min_length',array(':value',$settings[0]['min_title_length']))
                ->rule('product_name', 'max_length', array(':value', $settings[0]['max_title_length'])) 
                ->rule('product_category','not_empty')         
                ->rule('product_info','not_empty')
                ->rule('product_info', 'min_length', array(':value', '10'))
                ->rule('tags','not_empty')              
                ->rule('shipping_fee', 'regex', array(':value', '/^[0-9]++$/i'))			
                ->rule('tags', 'max_length', array(':value', '100'))  
                ->rule('tags','regex',array(':value','/^[A-Za-z0-9]+(,[A-Za-z0-9]+)*$/i'))
                ->rule('product_image','Upload::type', array(":value", array('jpg','jpeg', 'png', 'gif')))
                ->rule('product_image','Upload::size', array(":value",'2M'))                
				->rule('auction_type','not_empty');				          
                if($imagefile==1)
                {
                        $start->rule('product_image','Upload::not_empty',array(":value"));
                }           
                return $start;
        }

	/**
        * ****Create unix timestamp****
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
	
	//DEcimal limite validation 
	public static function product_decimal_check($current_price)
    	{
    	  $product_len =strlen(substr(strstr($current_price,'.'),1));
    	  
		if($product_len > NUMBER_FORMAT_LIMIT )
		{
		  return false;
		}
		else 
		{
		  return true;
		
		}
    	}
	
        /**
        * ****add_products()****
        *@return insert products values in database
        */ 	 
	public function add_product($validator,$_POST,$image_name,$multiimgnames,$product_url)
	{		
		//for checking status checkbox is checked or not
		$product_status = isset($_POST['product_status'])?ACTIVE:IN_ACTIVE;   
		//for checking status checkbox is checked or not
		$dedicated_auction = isset($_POST['dedicated_auction'])?ENABLE:DISABLE;   
		$auto_bid= isset($_POST['autobid'])?ENABLE:DISABLE;
		//Buy now
		$buynow_status= isset($_POST['buynow_status'])?ACTIVE:IN_ACTIVE;   
		//for checking status checkbox is checked or not
		$auction_process = RESUMES;
		/**To add i will and price if not entered **/
		$product_name=$_POST['product_name'];
		
		$ship_fee=isset($_POST['shipping_fee'])?$_POST['shipping_fee']:0;
		$ship_info=isset($_POST['shipping_info'])?$_POST['shipping_info']:'';
		//Query to Insert Product Details
		$rs   = DB::insert(PRODUCTS)
		->columns(array('product_name','product_url','product_image','product_gallery','product_info','product_status','auction_process','product_category','tags','product_featured','dedicated_auction','autobid','buynow_status','shipping_fee','shipping_info','created_date','auction_type'))               
		->values(array($_POST['product_name'],$product_url,$image_name,$multiimgnames,$_POST['product_info'], 
		$product_status,$auction_process,$_POST['product_category'],$_POST['tags'],$_POST['product_featured'],$dedicated_auction,$auto_bid,$buynow_status,$ship_fee,$ship_info,$this->getCurrentTimeStamp(),$_POST['auction_type']))
		->execute();
		return $rs;						
	} 

        /***edit_product_form()**** *
        *@param $arr validation array 
        * @validation check 
        */
	public function edit_product_form($arr,$settings,$_FILES) 
	{
            
                $arr['product_name'] = trim($arr['product_name']); 
                $arr['shipping_fee'] = trim($arr['shipping_fee']);               
                $start = Validation::factory($arr,$_FILES)    
                        ->rule('product_name', 'not_empty')
                        ->rule('product_name','alpha_space')
                        ->rule('product_name','not_numbers')                
                        ->rule('product_name', 'min_length',array(':value',$settings[0]['min_title_length']))
                        ->rule('product_name', 'max_length', array(':value', $settings[0]['max_title_length'])) 
                        ->rule('product_category','not_empty')         
                        ->rule('product_info','not_empty')
                        ->rule('product_info', 'min_length', array(':value', '10'))                        
                        ->rule('tags','not_empty')
                        ->rule('shipping_fee', 'regex', array(':value', '/^[0-9]++$/i'))
                        ->rule('tags', 'min_length', array(':value', '3'))
                        ->rule('tags', 'max_length', array(':value', '100')) 
                        ->rule('product_image','Upload::type', array(":value", array('jpg','jpeg', 'png', 'gif')))
                        ->rule('product_image','Upload::size', array(":value",'2M'));
						
						return $start;
        }
                
        /***multi_image__product_form()**** *
        *@param $arr validation array 
        * @validation check 
        */
	public function multi_image__product_form($_FILES) 
	{
	        $start = Validation::factory($_FILES) 
	        ->rule('product_gallery','Upload::type', array(":value", array('jpg','jpeg', 'png', 'gif')))
	        ->rule('product_gallery','Upload::size', array(":value",'2M'));
	        return $start;
        }
	
        /**
        * ****edit_product()****
        *@param $current_uri int,$_POST array
        *@return alluser list count of array 
        */  	 
        public function edit_product($productid,$_POST,$image_name,$multiimgnames) 
        {
		//Multiple image uploads 
		$product_name=$_POST['product_name'];		
		//for checking status checkbox is checked or not
		$status = isset($_POST['product_status'])?ACTIVE:IN_ACTIVE;
		//product dedicated auctions
		$dedicated_auction = isset($_POST['dedicated_auction'])?ENABLE:DISABLE;
		$auto_bid = isset($_POST['autobid'])?ENABLE:DISABLE;
		$buynow_status= isset($_POST['buynow_status'])?ACTIVE:IN_ACTIVE;   
		$mdate = $this->getCurrentTimeStamp(); 
		$auction=Model::factory('commonfunctions');
		$result=$auction->select_with_onecondition(PRODUCTS, 'product_id='.$productid);
		
		$ship_fee=isset($_POST['shipping_fee'])?$_POST['shipping_fee']:0;
		$ship_info=isset($_POST['shipping_info'])?$_POST['shipping_info']:'';
			/***Ends here for check clock auction***/
			/**To form URL from product name**/
			$product_url=url::title($_POST['product_name']);
			$sql_query = array('product_name' => $product_name,'product_category'=>$_POST['product_category'],'product_info'=> $_POST['product_info'],'product_status' => $status,'updated_date' => $mdate,'product_featured'=>$_POST['product_featured'],'dedicated_auction'=>$dedicated_auction,'buynow_status'=>$buynow_status,'autobid'=>$auto_bid,'tags'=>$_POST['tags'],'shipping_fee'=>$ship_fee,'shipping_info'=>$ship_info);

			/**Add Image details is product image is uploaded**/
			if($image_name != "")  $sql_query['product_image']=$image_name;
			/**Add Image details is product image is uploaded**/
			if($multiimgnames != "")  $sql_query['product_gallery']=$multiimgnames;
			$result =  DB::update(PRODUCTS)->set($sql_query)
				->where('product_id', '=' ,$productid)
				->execute();
		return ($result)?SUCESS:FAIL;
         }

             
        // Get product images   
	public function get_product_images($productid)
	{
		$rs   = DB::select('product_gallery')->from(PRODUCTS)
				 ->where('product_id', '=' ,$productid)
				 ->execute()
				 ->as_array();
		return $rs;
	}
	
	 /**
        *****update_product_image()****
        *@update product details image as null
        */	
	public function update_product_more_images($product_id,$multiimgnames)
	{
		$sql_query = array('product_gallery' => $multiimgnames);
		$result =  DB::update(PRODUCTS)->set($sql_query)
				->where('product_id', '=' ,$product_id)
				->execute();
		return ($result);
		
	}
         /**Check Image Exist or Not while Updating Product Details**/
	public function check_more_productimage($productid="")
	{
		$sql = "SELECT product_gallery FROM ".PRODUCTS." WHERE product_id ='$productid'";   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
			if(count($result) > 0)
			{ 
				return $result[0]['product_gallery'];
			}
	}
	
        /**
        * ****get_product_added_user_email()****
        *@send mail to product added users
        */ 	 
	public function get_job_added_user_email($userid)
	{
		//get email,username from user db 
		$rs   = DB::select('email','username')->from(USERS)
				 ->where('id', '=', $userid)
				 ->execute()
				 ->as_array();

		return $rs;
	}
	
        /**
        * ****delete_product()****
        *@param $current_uri int
        *@delete product items
        */
	public function delete_product($current_uri)
	{
		$query = array('product_status'=>DELETED_STATUS);
				
			$resule   = DB::update(PRODUCTS)
					 ->set($query)
					 ->where('product_id', '=', $current_uri)
					 ->execute();
	}

        /*** ****validate_login()****

        *@param $arr validation array 
        *@validation check 
        */	
	public function validate_login($arr)
	{
                return Validation::factory($arr)       
                        ->rule('email','not_empty')
                        ->rule('email','email')
                        ->rule('password', 'not_empty');

	}

        /**
        * ****get_all_search_list()****
        *@param $keyword string, $user_type char, $status char
        *@return search result string
        */
	public function get_all_search_list($keyword_search = "", $username_search = "", $category_search = "", $sort_product ="", $sort_auction ="")
	{
	        $keyword_search = str_replace("%","!%",$keyword_search);
		$keyword_search = str_replace("_","!_",$keyword_search);
		//condition for category		
		$category_where= ($category_search) ? " AND P.product_category = '$category_search'" : "";
		//condition for username		
		$username_where= ($username_search) ? " AND  P.userid = '$username_search'" : "";	
		$auction_where=($sort_auction)? " AND P.auction_type = '$sort_auction'" : "";
		//search result Keyword     
		$name_where="";	
		if($keyword_search){
			$name_where  = " AND P.product_name LIKE  '%$keyword_search%' ";
        	}     
                //sort product results    
        	$sort_product_where = "";
        	switch($sort_product)
        	{
        		//if active product active sort means
        		case ACTIVE:
        		        $sort_product_where  = " AND P.product_status = '".ACTIVE."' ";
        		break;
        		//if active product inactive sort means
        		case IN_ACTIVE:
        		        $sort_product_where  = " AND P.product_status = '".IN_ACTIVE."' ";
        		break;
        		//if active product live sort means
        		case LIVE:
				$sort_product_where =" AND P.startdate<=CURDATE() AND P.enddate>=CURDATE()";
        		break;
        		//if active product closed sort means
        		case CLOSED:
        		        $sort_product_where  = " AND P.enddate<CURDATE() AND P.product_status = '".ACTIVE."'";
        		break;
        		//if active product Future sort means
        		case FUTURE:
        		        $sort_product_where  = " AND P.enddate>CURDATE() AND P.product_status = '".ACTIVE."'";
        		break;
        		//if  product lastbidder userid !0 sort means
        		case SOLD:
        		        $sort_product_where  = " AND P.lastbidder_userid != '".ZERO."' AND P.product_status = '".ACTIVE."' ";
        		
        		break;
        		//if  product lastbidder 0 sort means
        		case UNSOLD:
        		        $sort_product_where  = " AND P.lastbidder_userid = '".ZERO."' AND P.product_status = '".ACTIVE."' ";
        		break;
        		//if active product active sort means
        		case DELETED_STATUS:
        		        $sort_product_where  = " AND P.product_status = '".DELETED_STATUS."' ";
        		break;
         	}
         			$query = "SELECT  P.created_date,
						  U.username,U.id as usrid,
						  P.product_name,
						  P.startdate,
						  P.enddate,
						  P.product_id,
						  P.auction_type,	
						  PC.category_name,
				 		  P.product_status,
				 	          P.auction_process,
				 		  P.product_process,
						  P.product_image,
						  P.product_cost,
						  P.lastbidder_userid,						
						  P.product_url			 	 	
						  FROM ".PRODUCTS." AS P  
		       		                  LEFT JOIN ".PRODUCT_CATEGORY." AS PC ON (PC.id =P.product_category)
				 		  LEFT JOIN ".USERS." AS U ON(U.id = P.userid)
						  WHERE 1=1  $category_where $username_where $name_where $sort_product_where $auction_where
						  ORDER BY P.created_date DESC ";
			$results = Db::query(Database::SELECT, $query)
			   			 ->execute()
						 ->as_array();
			return $results;
        }

        /**
        * ****get_all_Product_details_list()****
        *@return Product details array
        */
	public function get_all_product_details_list($productid)
	{
		$result= DB::select()->from(PRODUCTS)
			     ->where('product_id', '=', $productid)
			     ->order_by('product_id','DESC')
			     ->execute()	
			     ->as_array();
		return $result;
	}
	
	/**
        * ****get_all_Product_details_list()****
        *@return Product details array
        */
	public function get_select_product_details_list($productid)
	{
		$result= DB::select()->from(PRODUCTS)
			     ->where('product_id', '=', $productid)
			     ->order_by('product_id','DESC')
			     ->where('product_status', '=', ACTIVE)
			     ->execute()	
			     ->as_array();
		return $result;
	}
	
	/**Check Image Exist or Not while Updating Product Details**/
	public function check_productimage($productid="")
	{
		$sql = "SELECT product_image FROM ".PRODUCTS." WHERE product_id ='$productid'";   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
			if(count($result) > 0)
			{ 
				return $result[0]['product_image'];
			}
	}

        /**
        *****update_product_image()****
        *@update product details image as null
        */	
	public function update_product_image($productid)
	{
		$sql_query = array('product_image' => "");
		$result =  DB::update(PRODUCTS)->set($sql_query)
					->where('product_id', '=' ,$productid)
					->execute();
		return SUCESS;
	}

        /**
        *****update_product_image()****
        *@update product details image as null
        */	
	public function update_product_more_image($productid)
	{
		$sql_query = array('product_gallery' => "");
		$result =  DB::update(PRODUCTS)->set($sql_query)
					->where('product_id', '=' ,$productid)
					->execute();
		return SUCESS;
	}

        //Get date
	/**
        * ****get_product_data_more_image_data ()****
        *@param $current_uri int
        *@return allproduct lists
        */ 	 
	public function get_product_more_data($current_uri = '')
	{		 
	 	$rs   = DB::select()->from(PRODUCTS)
				 ->where('product_id', '=', $current_uri)
			     ->execute()	
			     ->as_array();
		return $rs;
	}

        /**
        * ****get_product_data()****
        *@param $current_uri int
        *@return allproduct lists
        */ 	 
	public function get_product_data($current_uri = '')
	{		 
	 	$rs   = DB::select()->from(PRODUCTS)
				 ->where('product_id', '=', $current_uri)
			     ->execute()	
			     ->as_array();
		return $rs;
	}

        /**
        * ****more_product_action()****
        *@return delete,active,etc.....
        */
	public function more_product_action($type,$userid,$productid)
	{	
                //if action delete means

                if($type == "del"){	
                        $query = DB::delete(PRODUCTS)
                        ->where('product_id', 'IN', $productid)   
                        ->execute();
                        return $type;		 
                }
                $db_set = $and_where = "";
                //checking for more action to do using $type
                switch($type)
                {
                        case "active":
                                //if action "active" selected means
                                $db_set = " product_status = '".ACTIVE."' ";
                                $and_where = " AND product_status = '".IN_ACTIVE."' ";
                        break;	
                        case "inactive":
                                //if action "inactive" selected means
                                $db_set = " product_status = '".IN_ACTIVE."' ";
                                $and_where = " AND product_status = '".ACTIVE."' ";	
                        break;
                }
                $query = " UPDATE ". PRODUCTS ." SET $db_set WHERE 1=1 AND product_id IN ('" . implode("','",$productid) . "') $and_where ";

                $result = Db::query(Database::UPDATE, $query)
                ->execute();

                return  $type;		
	}
      
        /**
        * ****Resumes_auction()****
        *@param $productid int
        *@suspend selected products 
        */
	public function auction_resumes($product_id,$userid,$status,$timestamp,$timediff)
        { 	
		$db_set ="";		
		switch ($status){
                                case "0":
                                        // if status is 0 means  
                                        $time=time()+$timediff;
                                        $db_set = " auction_process = '".RESUMES."',increment_timestamp='".$time."',timediff=0";	
                                break;	
                                        case "1":
                                        // if status is 1 means
                                        $time=$timestamp-time();
                                        $db_set = " auction_process = '".HOLD."',timediff='".$time."'";
                                        break;	
                                      
                                     
		}
		
		 $sql="select typename from ".AUCTIONTYPE." where typeid=(select auction_type from ".PRODUCTS." where product_id=$product_id)";
		 $res=Db::query(Database::SELECT,$sql)
			->execute()
			->get('typename');
		$tablename=TABLE_PREFIX.$res;
		
		$query1="UPDATE $tablename SET $db_set WHERE product_id=$product_id";
		$result1 = Db::query(Database::UPDATE, $query1)
			    ->execute();	
		
		
	        $query = " UPDATE ". PRODUCTS ." SET  $db_set WHERE 1=1 AND product_id = '$product_id' ";	

	        $result = Db::query(Database::UPDATE, $query)
			    ->execute();	
		 	 
			return $result;
	}

	//function for displaying product in drop down
	public function all_active_product_list()
	{
	 	$rs   = DB::select('product_name','product_url','product_id')->distinct('product_name',TRUE)
                        ->from(PRODUCTS)
                        ->where(PRODUCTS.'.product_status', '=', ACTIVE)
                        ->order_by('product_name','ASC')
                        ->execute()	
                        ->as_array();
                 
	        return $rs;		
		
		}
		
		
	public function update_product_inactive($productid)
	{
		$sql_query = array('product_status' => IN_ACTIVE, 'product_process' => CLOSED);
		$result =  DB::update(PRODUCTS)->set($sql_query)
					->where('product_id', '=' ,$productid)
					->execute();
		return SUCESS;
	}
	
	public function select_product($current_uri)
	{
                $result = DB::select()->from(PRODUCTS)
                                ->where('product_id', '=', $current_uri)
                                ->execute()
                                ->as_array();
                return $result;
	}

    public function image_validate($imgarr)
    {

        //Get of all the images arrays
	if(empty($imgarr))
	{
		return true;
	}
        foreach($imgarr as $key => $img)
        {
            //Assign the type of image format needed in array into the imagetype function
            $arr=$this->imagetype(array('jpg', 'png', 'gif','jpeg'),$img);

            if($arr==1)
            {
                //If the type doesnot meet the format a msg store in session to show invalid image format
                $this->session->set("mulimg","Not a valid image format");
                
                //Once it return mismatch means it return false and break the loop
                return false;
                break;
            }
            else
            {
                return true;
            }
        }
    }
    
    
    //Check the image type from the image names
    public function imagetype(array $type,array $file)
    {            
        //get all the image names from the name index of an image array
        foreach($file['name'] as $f)
        {
            // Get the basename form the image name if there any url provided
            $filecheck=basename($f);    

            //Split up the after . from the image name (eg: image.jpg to jpg)
            $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
            
            //Check the parameter is array and has values in it or else assign a default array of image types
            $imgtype=(is_array($type) && count($type)>0)?$type:array('jpg', 'png', 'gif','jpeg');
            
            if(in_array($ext,$imgtype))
            {
                //if true
                $res= 0;    
            }
            else
            {
                //if false
                $res= 1;
                break;
            }        
            
        }
        return $res;
    }
    
    //Image size validation function
    public function image_sizevalidate($imgarr,$size="2MiB")
    {
	if(empty($imgarr))
{
	return true;
}
        //Get of all the images arrays
        foreach($imgarr as $key => $img)
        {
            //Assign the type of size length into the imagesize function
            $arr=$this->imagesize($size,$img);
            if($arr==1)
            {
                $this->session->set("mulimg","Size will not be greater than ".$size);
                return false;
                break;
            }
            else
            {
                return true;
            }
        }
    }
    
    //Image size check function
    public function imagesize($size,array $file)
    {        
        //Kohana static function to convert given format into byte units (eg: 200K -> 200000bytes) Refer system file num.php
        $sizen_bytes=Num::bytes($size);
        
        //Get each size from the file
        foreach($file['size'] as $f)
        {                    
            if($f<=$sizen_bytes)
            {
                //if true
                $res= 0;    
            }
            else
            {
                //if false
                $res= 1;
                break;
            }        
            
        }
        return $res;
    }
    
    //Filter the empty fileds in image array
    public function filter_images($images)
    {
        $ima=array();
        foreach ($images as $key =>$arr)
        {
            foreach(array_filter($arr['name']) as $image)
            {
                $ima[$key]['name'][]=$image;
            }
        }
        foreach ($images as $key =>$arr)
        {
            foreach(array_filter($arr['type']) as $type)
            {
                $ima[$key]['type'][]=$type;
            }
        }
        foreach ($images as $key =>$arr)
        {
            foreach(array_filter($arr['size']) as $size)
            {
                $ima[$key]['size'][]=$size;
            }
        }
        foreach ($images as $key =>$arr)
        {
            foreach(array_filter($arr['name']) as $s => $error)
            {            
                $ima[$key]['error'][]=$arr['error'][$s];
            }
        }
        foreach ($images as $key =>$arr)
        {
            foreach(array_filter($arr['tmp_name']) as  $tmp_name)
            {            
                $ima[$key]['tmp_name'][]=$tmp_name;
            }
        }
        return $ima;
    }

   
	        public function getauction_edit($id)
        {
			$result=DB::select(PRODUCTS.'.product_id',PRODUCTS.'.auction_type',AUCTIONTYPE.'.typename')
					->from(PRODUCTS)
					->join(AUCTIONTYPE,'left')
					->on(AUCTIONTYPE.'.typeid','=',PRODUCTS.'.auction_type')					
					->and_where(PRODUCTS.'.product_id','=',$id)
					->execute()
					->as_array();
		return $result;

		}
}
?>
