<?php defined('SYSPATH') or die('No direct script access.');

/*
* Contains Adminauction(Product Winners,Bidpackages,Refunds List) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/


class Model_Adminauction extends Model
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
        
        /**To Get Current TimeStamp**/
	public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}

	
        /** 
	* Select winners and joined users, products
	* @return array list of all winners, users and products
	* all wih pagination
	*/	
	public function products_winners($offset, $val)
	{
		return $query = DB::select()
			->from(PRODUCTS)
			->join(USERS,'left')
			->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
			->where(PRODUCTS.'.product_process','=',CLOSED)			
			->and_where(PRODUCTS.'.lastbidder_userid','!=',0)
			->limit($val)
			->offset($offset)
			->order_by(PRODUCTS.'.increment_timestamp','DESC')
			->execute()
			->as_array();
	}
	
	 /** 
	* Select winners and joined users, products
	* @return array list of all winners, users and products
	* all wih pagination
	*/	
	public function products_winners_user($offset, $val)
	{
		 $result=DB::select()
				->from(PRODUCTS)
				->join(USERS,'left')
				->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
				//->where(PRODUCTS.'.product_process','=',CLOSED)
				->where(PRODUCTS.'.product_status','=',ACTIVE)
				->and_where(PRODUCTS.'.in_auction','=',2)			
				->and_where(PRODUCTS.'.lastbidder_userid','!=',0)
				->limit($val)
				->offset($offset)
				->order_by(PRODUCTS.'.product_id','DESC')
				->execute()
				->as_array();
				
				$i=0;
				foreach($result as $key=>$value)
				{
						
					$sql="select typename from auction_types where typeid=$value[auction_type]";
					
					$query1 = Db::query(Database::SELECT, $sql)
					->execute()
					->get('typename');
					$tablename="auction_".$query1;
					
					
					$sql1="select product_cost from $tablename where product_id=$value[product_id]";					
					$query2=Db::query(Database::SELECT,$sql1)
					->execute()->get('product_cost');
					
					
					if(array_key_exists($i,$result))
					{
						$result[$i]['product_cost']=$query2;
					}	
					
					$i++;
					
				}
			
			
			return $result;
	}
        
        
        /** 
	* Select winners and joined users, products
	* @return array list of all winners, users and products
	* all wih pagination
	*/
	public function winners_products($product_id)
	{
		 $result=DB::select()
				->from(PRODUCTS)
				->join(USERS,'left')
				->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
				->where(PRODUCTS.'.product_status','=',ACTIVE)
				->and_where(PRODUCTS.'.in_auction','=',2)			
				->and_where(PRODUCTS.'.lastbidder_userid','!=',0)
                                ->and_where(PRODUCTS.'.product_id','=',$product_id)			
				->order_by(PRODUCTS.'.product_id','DESC')
				->execute()
				->as_array();
				
				$i=0;
				foreach($result as $key=>$value)
				{
						
					$sql="select typename from auction_types where typeid=$value[auction_type]";
					
					$query1 = Db::query(Database::SELECT, $sql)
					->execute()
					->get('typename');
					$tablename="auction_".$query1;
					
					
					$sql1="select product_cost from $tablename where product_id=$value[product_id]";
					$query2=Db::query(Database::SELECT,$sql1)
					->execute()->get('product_cost');
					
					
					if(array_key_exists($i,$result))
					{
						$result[$i]['product_cost']=$query2;
					}	
					
					$i++;
					
				}
			
		
			return $result;
	}
        
        /*
        * To count of winners auction 
        */	 
	public function count_winners_auctions()
	{
	    	$product_winners_count = DB::select()
			->from(PRODUCTS)
			->join(USERS,'left')
			->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
			->where(PRODUCTS.'.product_process','=',CLOSED)			
			->and_where(PRODUCTS.'.lastbidder_userid','!=',0)	
			->execute()
			->as_array();				       
	  	return count($product_winners_count);
	}
	
	  /*
        * To count of winners auction 
        */	 
	public function count_winners_user()
	{
			$product_winners_count=DB::select()
			->from(PRODUCTS)
			->join(USERS,'left')
			->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
			//>where(PRODUCTS.'.product_process','=',CLOSED)
			->where(PRODUCTS.'.product_status','=',ACTIVE)
			->and_where(PRODUCTS.'.in_auction','=',2)	
			->and_where(PRODUCTS.'.lastbidder_userid','!=',0)

			->order_by(PRODUCTS.'.product_id','DESC')
			->execute()
			->as_array();	
			return count($product_winners_count);
	}
	
	/*
	* winners reply validation  
	*/
	public function validate_winners_reply($arr)
	{
		$arr['subject'] = trim($arr['subject']);
		$arr['message'] = trim($arr['message']);
		return Validation::factory($arr)
			->rule('subject', 'not_empty')
			->rule('subject', 'alpha_space')
			->rule('subject', 'min_length', array(':value', '5'))
			->rule('message','not_empty')
			->rule('message', 'min_length', array(':value', '5'))
			->rule('message', 'max_length', array(':value', '500'));

		}
	
        /**
        * ****get_contact_request_details()****
        *@param $id int
        *@return all contact request lists
        */
	public function get_user_request_details($id)
	{

		$result = DB::select('email','username')->from(USERS)
                                ->where('id','=', $id)
                                ->execute()
                                ->as_array();
		return $result;
	}
	
        /*
        *Validate  bid packages
        *@Return view bid packages
        */     
	 public function validate_add_bidpackages($arr,$product_settings) 
	{
		$arr['name'] = trim($arr['name']);
                return Validation::factory($arr)            
                                ->rule('name', 'not_empty')
                                ->rule('name', 'alpha_space')
                                ->rule('price','not_empty')
                                ->rule('price','numeric')
                                ->rule('price', 'range', array(':value',$product_settings[0]['min_bidpackages'],__('to'),$product_settings[0]['max_bidpackages'],__('packages')));
                             
         }
	
        /*
        *Add  bid packages
        *@Return view bid packages
        */
        public function add_bidpackage($post_val,$validator)
        {

                $status = isset($post_val['status'])?"A":"I";
                $cat_name = DB::select()->from(BIDPACKAGES)
                                ->where('name','=', $post_val['name'])
                                ->execute()
                                ->as_array(); 
                //For Duplicate Checking
                if(count($cat_name) > 0)
                {
                        return 0;
                }
                else
                {
                        $insert_id = DB::insert(BIDPACKAGES)
                        ->columns(array('name','price', 'status','created_date'))
                        ->values(array($post_val['name'],$post_val['price'],$status,$this->getCurrentTimeStamp()))
                        ->execute(); 
                        return $insert_id[1];		
                }
        } 
        
        /*
        *Get  bid packages
        *@Return view bid packages
        */
        public function get_bidpackages($offset, $val) 
        {
        
                $query=DB::select()->from(BIDPACKAGES)
				->order_by('price','DESC')
				->limit($val)
				->offset($offset)
				->execute()
				->as_array();
				return  $query;
                                   
        } 

        /*
        *Count  bid packages
        *@Return view bid packages
        */
	public function count_bidpackage()
        { 
               $query=DB::select()->from(BIDPACKAGES)
				->order_by('price','DESC')
				->execute()
				->as_array();
			return count($query);
        } 
     
       /*
        *Edit  list of  bid packages
        *@Return view bid packages
        */   
        public function edit_bidpackages($packageid ,$_POST) 
        {
                $status = isset($_POST['status'])?"A":"I";
                $mdate = $this->getCurrentTimeStamp(); 
	        $query = DB::update(BIDPACKAGES)
                ->set(array('name' => $_POST['name'],'price' => $_POST['price'],
                'status' => $status,'updated_date'=>$mdate))
                        ->where('package_id', '=',$packageid)
                        ->execute();
                if(count($query) > 0)
                {
                        return 1;
                        }else{
                        return 2;
                }
         }
        
         /*
        *Edit  list of  bid packages
        *@Return edit bid packages
        */
	public function validate_edit_bidpackages($arr,$product_settings) 
	{
		$arr['name'] = trim($arr['name']);
                return Validation::factory($arr)            
                                ->rule('name', 'not_empty')
                                ->rule('name', 'alpha_space')
                                ->rule('price','not_empty')
                                ->rule('price','numeric')
                                ->rule('price', 'range', array(':value',$product_settings[0]['min_bidpackages'],__('to'),$product_settings[0]['max_bidpackages'],__('packages')));
         }
        
        /*
        *Delete list of  bid packages
        *@Return manage bid packages
        */
        public function delete_packages($packages_delete_chk)
        {
                $result   = DB::delete(BIDPACKAGES)
				->where('package_id', 'IN', $packages_delete_chk) 
				->execute(); 
                return count($result);
        }
        
        /*
        *Select bid packages
        *@Return view pages
        */
 	public function bid_packages($productid)
	{

		$result= DB::select()->from(BIDPACKAGES)
			     ->where('package_id', '=', $productid)
			     ->order_by('package_id','DESC')
			     ->execute()	
			     ->as_array();
		return $result;
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
	
	/**
	* select the user won auction from products table
	*/
	public function select_user_wonauctions()
	{
		return $query=DB::select()
				->from(PRODUCTS)
				->join(USERS,'left')
			        ->on(PRODUCTS.'.lastbidder_userid','=',USERS.'.id')
				->and_where(PRODUCTS.'.product_process','=',CLOSED)
				->and_where(PRODUCTS.'.product_status','=',ACTIVE)
				->order_by('product_id','DESC')
				->execute();
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
        * ****Create unix timestamp for tonight****
        * @return unix timestamp with given date and time
        */ 
	public function today_morning()
	{
		$dated=date("Y-m-d")." "."00:00:01";
		return $this->create_timestamp($dated);
	}
	
        /**
        * ****get_all_transaction_search_list()***
        *@param 
        *@return search result string
        */
        public function get_all_refundlist_search_list($order_search = "",$start_date="",$end_date="")
        
        {
        
                $order_search = str_replace("%","!%",$order_search);
		$order_search = str_replace("_","!_",$order_search);
                //change start date format into db format
                if($start_date)
                {
                        $start_date =  commonfunction::DateFormatToDb($start_date);
                }
                //change end date format into db format
                if($end_date)
                {
                        $end_date = commonfunction::DateFormatToDb($end_date);
                } 
                //if start date only selected means
                $start_date_where = (($start_date) && ($end_date == "")) ? " AND P.enddate > '$start_date' ":""; 
                //if to date only selected means
                $end_date_where = (($end_date) && ($start_date == "")) ? " AND P.enddate < '$end_date' ":"";	
                //condition for both start and end date selected
                $start_time = START_TIME;
                $end_time = END_TIME; 
                $date_range_where = (($start_date) && ($end_date)) ? " AND P.enddate BETWEEN '$start_date"." "."$start_time' AND '$end_date"." "."$end_time' ":"";
                
		//condition for package order search
		$package_order_where= ($order_search) ? " AND  P.product_name LIKE '%$order_search%'" : "";
           
                               $query = "SELECT  P.created_date,
						  BH.product_id,BH.user_id,
						  BH.price,
						  U.username,U.id,
						  P.product_name,
						  P.enddate,
						  P.product_id,
				 		  P.product_status,
				 	          P.auction_process,
				 		  P.product_process,
				 		  P.current_price,
						  P.product_image,
						  P.product_cost,
						  P.created_date,
						  P.lastbidder_userid,
						  P.product_url			 	 	
						  FROM ".PRODUCTS." AS P 
		       		                  LEFT JOIN ".BID_HISTORIES." AS BH ON(BH.date = P.created_date)
				 		  LEFT JOIN ".USERS." AS U ON(U.id = P.lastbidder_userid)
				 		 
				 		  WHERE 1=1  $package_order_where $date_range_where ORDER BY P.created_date DESC ";
	 		$results = Db::query(Database::SELECT, $query)
			   			 ->execute()
						 ->as_array();
						 
			return $results;

        }
	
        /*
        *Validate User bonus type
        *@Return viewUser bonus type
        */     
	 public function validate_add_bonus($arr) 
	{
                return Validation::factory($arr)            
                        ->rule('bonus_type', 'not_empty')
                        ->rule('bonus_amount', 'not_empty');
         }
         
        /*
        *Add User Bonus type
        *@Return view Bonus Type
        */
        public function add_bonus($post_val,$validator)
        {
                $status = isset($post_val['bonus_status'])?"A":"I";
                $bonus_type = DB::select()->from(BONUS)
                                ->where('bonus_type','=', $post_val['bonus_type'])
                                ->execute()
                                ->as_array(); 
                //For Duplicate Checking
                if(count($bonus_type) > 0)
                {
                        return 0;
                }
                else
                {
                        $insert_id = DB::insert(BONUS)
                        ->columns(array('bonus_type','bonus_amount', 'bonus_status','created_date'))
                        ->values(array($post_val['bonus_type'],$post_val['bonus_amount'],$status,$this->getCurrentTimeStamp()))
                        ->execute(); 
                        return $insert_id[1];		
                }
        } 
        
        /*
        *Edit  list of  Bonus Type
        *@Return edit Bonus
        */
	 public function validate_edit_bonus($arr) 
	{
                return Validation::factory($arr)            
                                ->rule('bonus_type', 'not_empty')
                                  ->rule('bonus_amount', 'not_empty');;
         }
         
        /*
        *Edit  list of  Bonus Type
        *@Return view Bonus Type
        */   
        public function edit_bonus($bonusid ,$_POST) 
        {
                $status = isset($_POST['bonus_status'])?"A":"I";
                $mdate = $this->getCurrentTimeStamp(); 
	        $query = DB::update(BONUS)
                ->set(array('bonus_type' => $_POST['bonus_type'],'bonus_amount' => $_POST['bonus_amount'],
                'bonus_status' => $status,'updated_date'=>$mdate))
                ->where('bonus_type_id', '=',$bonusid)
                ->execute();
                if(count($query) > 0)
                {
                        return 1;
                        }else{
                        return 2;
                }
        }
        
                
        // Delete For bonus
        public function delete_bonus($bonus_delete_chk)
        {
                $rs   = DB::delete(BONUS)
                                ->where('bonus_type_id', 'IN', $bonus_delete_chk) 
                                ->execute(); 
                return count($rs);
        }
        
        
        /*
        *Count  Bonus Type
        *@Return view Bonus Type
        */
	 public function count_bonus()
        { 
                $sql = 'SELECT bonus_type_id,
                               bonus_type,
                               if(bonus_status="A", "Active","Inactive") AS bonus_status,
                               DATE_FORMAT(created_date, "%d-%b-%Y") AS created_date
                               FROM   '.BONUS; 
                return count( Db::query(Database::SELECT, $sql)
                ->execute()
                ->as_array());                     
        } 
        
        /*
        *Get  bid packages
        *@Return view bid packages
        */
         public function get_bonus_type($offset, $val) 
        {
                $sql = 'SELECT bonus_type_id,
                               bonus_type,
                               bonus_amount,created_date,
                               if(bonus_status="A", "Active","Inactive") AS bonus_status
                               FROM '.BONUS.' LIMIT  '."$offset, $val";
                return Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array();                     
        } 
        
        /*
        *Select User Bonus Type
        *@Return view Bonus pages
        */
 	public function user_bonustype($bonusid)
	{
		$result= DB::select()->from(BONUS)
			     ->where('bonus_type_id', '=', $bonusid)
			     ->order_by('bonus_type_id','DESC')
			     ->execute()	
			     ->as_array();
		return $result;
	}
	
		
	/*
        *Validate User bonus type
        *@Return viewUser bonus type
        */     
	 public function validate_add_user_bonus($arr) 
	{
                return Validation::factory($arr)
                                ->rule('bonus_amount', 'not_empty')            
                                ->rule('bonus_amount', 'numeric')
                                ->rule('bonus_type', 'not_empty')
                                ->rule('userid', 'not_empty');
         }
         
        /*
        *Add User Bonus type
        *@Return view Bonus Type
        */
        public function add_user_bonus($post_val,$validator)
        {
                 $status = isset($post_val['status'])?"A":"I";
                 $bonus_type = DB::select()->from(USER_BONUS)
                                ->where('bonus_amount','=', $post_val['bonus_amount'])
                                ->execute()
                                ->as_array(); 
                //For Duplicate Checking
                if(count($bonus_type) > 0)
                {
                        return 0;
                }
                else
                {
                        $insert_id = DB::insert(USER_BONUS)
                        ->columns(array('bonus_type','bonus_amount','userid', 'status','created_date'))
                        ->values(array($post_val['bonus_type'],$post_val['bonus_amount'],$post_val['userid'],$status,$this->getCurrentTimeStamp()))
                        ->execute(); 
                        return $insert_id[1];		
               }
        } 
        
        /*
        *Edit  list of  Bonus Type
        *@Return edit Bonus
        */
	 public function validate_edit_user_bonus($arr) 
	{
                return Validation::factory($arr)            
                        ->rule('bonus_amount', 'not_empty')
                        ->rule('bonus_amount', 'numeric')
                        ->rule('bonus_type', 'not_empty')
                        ->rule('userid', 'not_empty');
         }
         
        /*
        *Edit  list of  Bonus Type
        *@Return view Bonus Type
        */   
        public function edit_user_bonus($user_bonusid ,$_POST) 
        {
                $status = isset($_POST['status'])?"A":"I";
                $mdate = $this->getCurrentTimeStamp(); 
	        $query = DB::update(USER_BONUS)
                                ->set(array('bonus_type' => $_POST['bonus_type'],'bonus_amount' => $_POST['bonus_amount'],'userid' => $_POST['userid'],
                                'status' => $status,'updated_date'=>$mdate))
                                ->where('bonus_id', '=',$user_bonusid)
                                ->execute();
                if(count($query) > 0)
                {
                        return 1;
                        }else{
                        return 2;
                }
        }
        
         /*
        *Count  User Bonus Type
        *@Return view Bonus Type
        */
	public function count_user_bonus()
        { 
                $sql = 'SELECT bonus_id,
                               bonus_type,bonus_amount,userid,
                               if(status="A", "Active","Inactive") AS status,
                               DATE_FORMAT(created_date, "%d-%b-%Y") AS created_date
                               FROM   '.USER_BONUS; 
                return count( Db::query(Database::SELECT, $sql)
                ->execute()
                ->as_array());                     
        } 
        
        
        /**
        * ****get_user_bonus()****
        *@param $offset int, $val int
        *@return get_user_bonus list count of array 
        */
	public function get_user_bonus($offset, $val)
	{
	    //Query for user bonus listings with Pagination 
                $query  ="SELECT UB.created_date,
                U.username,U.id as usrid,
                UB.bonus_amount,
                UB.bonus_id,
                B.bonus_type
                FROM ".USER_BONUS." AS UB
                LEFT JOIN ".BONUS." AS B ON (B.bonus_type_id =UB.bonus_type)	       		  
                LEFT JOIN ".USERS." AS U ON(U.id = UB.userid)
                ORDER BY UB.created_date DESC LIMIT $offset,$val"; 
	    $result = Db::query(Database::SELECT, $query)
			    ->execute()
			    ->as_array();
	    return $result;
	}
        
        
        /**
        * ****get_user_bonus_friends_list()****
        *@param $offset int, $val int
        *@return get_user_bonus list count of array 
        */
	public function get_user_bonus_friends_list($bonus_id)
	{
	    //Query for user bonus listings with Pagination 
                $query  ="SELECT UB.created_date,
                U.username,U.id as usrid,
                UB.bonus_amount,
                UB.bonus_id,
                UB.friend_ids,
                B.bonus_type
                FROM ".USER_BONUS." AS UB
                LEFT JOIN ".BONUS." AS B ON (B.bonus_type_id =UB.bonus_type)	       		  
                LEFT JOIN ".USERS." AS U ON(U.id = UB.userid)
                WHERE UB.created_date = '$bonus_id' 
                ORDER BY UB.created_date DESC "; 
	    $result = Db::query(Database::SELECT, $query)
	                        
			    ->execute()
			    ->as_array();
	    return $result;
	}
        
        /*
        *Select User Bonus Type
        *@Return view Bonus pages
        */
 	public function user_bonus($user_bonusid)
	{

		$result= DB::select()->from(USER_BONUS)
			     ->where('bonus_id', '=', $user_bonusid)
			     ->order_by('bonus_id','DESC')
			     ->execute()	
			     ->as_array();
		return $result;
	}

        // Delete For user bonus
        public function delete_userbonus($userbonus_delete_chk)
        {
                $rs   = DB::delete(USER_BONUS)
                                ->where('bonus_id', 'IN', $userbonus_delete_chk) 
                                ->execute(); 
                return count($rs);
        }
        
        /*
        *Select Bonus type 
        */
        public function select_bonus_type()
	{
		$result= DB::select()->from(BONUS)
			     ->where('bonus_status', '=', ACTIVE)
			     ->order_by('bonus_type_id','DESC')
			     ->execute()	
			     ->as_array();
		return $result;
	}
	
        /**
        * ****all_username_list()****
        *@param $offset int, $val int
        *@return transaction  username count of array 
        */
	public function all_username_list()
	{
                $result   = DB::select('username','id')->distinct(TRUE)
                        ->from(USERS)
                        ->where(USERS.'.status', '=', ACTIVE)
                        ->where(USERS.'.username', '!=', " ")
                         ->and_where(USERS.'.usertype', '!=',ADMIN)
                        ->order_by('username','ASC')
                        ->execute()	
                        ->as_array();
                return $result;
	}
	
	
	
        /**
        * select all bid history for mybids
        * @param $pid - Product id, $uid - Users id
        * @return array
        */
	public function select_bids_for_users($offset,$val,$need_count=FALSE)
	{
		$select="select count(".BID_HISTORIES.".product_id),max(".BID_HISTORIES.".price),".PRODUCTS.".product_name,".PRODUCTS.".product_url,".PRODUCTS.".product_image,
".PRODUCTS.".product_process,
".PRODUCTS.".enddate,".PRODUCTS.".product_image,".BID_HISTORIES.".user_id,".BID_HISTORIES.".date,".USERS.".username FROM ".BID_HISTORIES." LEFT JOIN ".PRODUCTS." on ".PRODUCTS.".product_id = ".BID_HISTORIES.".product_id  LEFT JOIN ".USERS." on ".USERS.".id = ".BID_HISTORIES.".user_id where ".BID_HISTORIES.".product_id=".PRODUCTS.".product_id  and ".PRODUCTS.".product_status='".ACTIVE."' group by ".BID_HISTORIES.".product_id,".BID_HISTORIES.".user_id order by ".BID_HISTORIES.".id desc";
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
        * ****count_bidhistory_list()****
        * @return bidhistory list count of array 
        */ 
	public function count_bidhistory()
	{
                $result = DB::select()->from(BID_HISTORIES)
                                ->execute()
                                ->as_array();
                return count($result);
	}
	
	
	
	//Select Product id from bid histories
	public function select_products_with_user($need_count=FALSE)
	{
		$query=DB::select('product_id')->distinct(TRUE)->from(BID_HISTORIES)
						->execute();
		return ($need_count)?count($query):$query;
		
	}
	
	// Replay status for contact request 
	public function status_reply($current_uri)
	{	
			$query = array('reply_status'=>ACTIVE);
			$resule   = DB::update(PRODUCTS)
					 ->set($query)
					 ->where('product_id', '=', $current_uri)
					 ->execute();
	}
	//products replay
	// Replay status for contact request 
	public function status_reply_status($current_uri)
	{	
			$query = array('reply_status'=>ACTIVE);
			$resule   = DB::update(PRODUCTS_WON)
					 ->set($query)
					 ->where('product_id', '=', $current_uri)
					 ->execute();
			
	}
	   /***** Added By Venkatraja 15-March-2013 ****/
        public function get_shipping_address($userid)
	{
		$query=DB::select()->from(SHIPPING_ADDRESS)
					->where('userid','=',$userid)
					->order_by('id','DESC')
					->execute()
					->current();
		return $query;
	}
	
	public function get_billing_address($userid)
	{
		$query=DB::select()->from(BILLING_ADDRESS)
					->where('userid','=',$userid)
					->order_by('id','DESC')
					->execute()
					->current();
		return $query;
	}   
        
        /*** Added End By venkatraja ***/
        
	
}
?>
