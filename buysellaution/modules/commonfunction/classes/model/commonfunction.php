<?php defined('SYSPATH') or die('No direct access allowed.');

/*
 * You should have all the module's models inside the module folder
 * so the module can be functional just by copying the module folder.
 *
 * It's recomended to name you Module's Models as Model_Modulename_<Model>
 * to avoid any conflics with any application model
 */

class Model_Commonfunction extends Model {
        
        /**
	* To Get All Active Products Categories 
	* @param $sidebar_cat_limit
	* @return array
	**/
	public function get_productcategory($sidebar_cat_limit)
	{
		$result=  DB::select('category_name',array('id','category_id'))->from(PRODUCT_CATEGORY)
			     ->where('status', '=', "A")
			     ->order_by('id','DESC')
			     ->limit($sidebar_cat_limit)
			     ->execute()	
			     ->as_array();
				
		return $result;
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
	
	/**
	* get_ads_details *
	**/
	public function get_ads_details()
	{
		$query=DB::select()->from(ADS)
				->where('ads_status','=',ACTIVE)
				->order_by('order','ASC')
				->execute()
				->as_array();	

		return $query;
	
	}
	
	/*** Added by Venkatraja **/
	public function get_package_name($id)
	{
		$query=DB::select('name')->from(BIDPACKAGES)
				->where('package_id','=',$id)
				->execute()
				->get('name');	

		return $query;
	
	}
	
	public function get_product_name($id)
	{
		$query=DB::select('product_name')->from(PRODUCTS)
				->where('product_id','=',$id)
				->execute()
				->get('product_name');	

		return $query;
	
	}
	
	/**
	* save All Email 
	* @param $to,$from,$subject,$message
	* @return array
	**/	
	public function save_email($to,$from,$subject,$message)
	{
	      	$rs   = DB::insert(USER_MESSAGE)
				->columns(array('usermessage_to','usermessage_from','usermessage_subject','usermessage_message'))
				->values(array($to,$from,$subject,$message))
				->execute();	
		        
	}
        /**
	* To Get All meta details
	* @return array
	**/      		
	public function get_meta_details()
	{
		$result= DB::select('meta_keywords','meta_description','status')->from(META)
			     ->where('status', '=',ACTIVE)
			     ->execute()	
			     ->as_array();	
		return $result;  		
	}

	/**
	* To Get All site settings
	* @return array
	**/ 
     	public function get_site_settings()
        {
                $result = DB::select()
                              ->from(SITE)
                              ->execute()
                              ->as_array();
                return $result;
        }

	/**
	* To Get All user settings
	* @return array
	**/ 
     	public function get_user_settings()
        {
                $result = DB::select()
                              ->from(USERS_SETTINGS)
                              ->execute()
                              ->as_array();
                return $result;
        }

	/**
	* To Get All user settings
	* @return array
	**/ 
     	public function get_facebook_settings()
        {
                $result = DB::select()
                              ->from(SOCIALNETWORK_SETTINGS)
                              ->execute()
                              ->as_array();
                return $result;
        }
	 
	/**
	* To Get All static page contents
	* @return array
	**/
	public function get_staticpage_footer_content()
	{
		
		$query= "SELECT id,page_title,page_url,status FROM ".CMS." WHERE status='".ACTIVE."' AND (id!=6)";
		
		$result=Db::query(Database::SELECT, $query)
				->execute()
				->as_array();
		return $result;
	} 

	

	/**
	* To Get All static page contents
	* @return array
	**/
	public function get_staticpage_header_content()
	{
		$query= "SELECT id,page_title,page_url,status FROM ".CMS." WHERE status='".ACTIVE."' AND (id = 3 or id=9 or id=10 or id=8)";
		$result=Db::query(Database::SELECT, $query)
				->execute()
				->as_array();
		return $result;
	} 

	/**
	* To Get All static page contents
	* @return array
	**/
	public function get_staticpage_content()
	{
		$query= "SELECT id,page_title,page_url,status FROM ".CMS." WHERE status='".ACTIVE."' AND id!=6";
		$result=Db::query(Database::SELECT, $query)
				->execute()
				->as_array();
		return $result;

	} 
	
	/**
	* Select balance in usertable
	* @param $userid 
	* @return when count occur return count else return query result array
	*/
	public function get_user_balances($userid)
	{
		$query=DB::select('id','user_bid_account','user_bonus')->from(USERS)
					->where('id','=',$userid)
					->execute()
					->as_array();	
		return $query;
	}

	/**
	* Select users status in useronline
	* @param $userid 
	* @return when count occur return count else return query result array
	*/
	public function user_status($sessionid)
	{
		$query=DB::select()->from(USERS_ONLINE)
					->where('session','=',$sessionid)
					->execute()
					->as_array();	
		return $query;
	}
	public function insert($table,$arr)
	{
		$result=  DB::insert($table,array_keys($arr))->values(array_values($arr))
			     ->execute();
		return $result;
	}
	public function update($table,$arr,$cond1,$cond2)
	{
		$query=DB::update($table)->set($arr)->where($cond1,'=',$cond2)->execute();
		return $query;
	}

	public function delete_useronline($table,$cond1,$cond2)
	{
		$query=DB::delete($table)->where($cond1,'<',$cond2)->execute();
		return $query;
	}
	/**
	* get all country 
	*/
	public function get_country()
	{
		$query=DB::select('country_id','name','iso_code_2','iso_code_3')->from(COUNTRY)
					->where('status','=',1)
					->execute()
					->as_array();	
		return $query;
	}
	
	/**
	* get bonus amount 
	*/
	public function get_bonus_amount($type_id)
	{
		$query=DB::select('bonus_type_id','bonus_amount','bonus_status')->from(BONUS)
					->where('bonus_type_id','=',$type_id)
					->and_where('bonus_status','=',ACTIVE)
					->execute()
					->as_array();	
		return $query;
	}

	/**
	* get bonus amount 
	*/
	public function get_currentbonus_amount($id)
	{
		$query=DB::select()->from(USER_BONUS)
					->where('userid','=',$id)
					->execute()
					->as_array();	
		return $query;
	}
	/**
	* get user message 
	*/
	public function get_usermessage($email)
	{
		$morning=date("Y-m-d")." 00:00:00";		
		$night=date("Y-m-d")." 23:59:59";
		$query=DB::select()->from(USER_MESSAGE)					
					->where('usermessage_to','=',$email)				
					->and_where('msg_type','!=',READ)
					->and_where('status','=',0)
					->and_where('sent_date','>=',$morning)
					->and_where('sent_date','<=',$night)						
					->order_by('usermessage_id','DESC')
					->limit(1)
					->execute()
					->as_array();	
		return $query;
	}

	public function select_facebook_network()
	{
		$query=DB::select()->from(SOCIALNETWORK_SETTINGS)					
					->limit(1)
					->execute()
					->as_array();	
		return $query;
	}


	/** 
	* Select a rows with particular one condition
	* @param $table=tablename, $cond=condition for where query
	* @returns array
	**/
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

	/**
	* Count category list
	* @return array
	**/
	public function count_category_list($category_id)
	{
		$query = "SELECT ".PRODUCTS.".product_id as productid,".PRODUCTS.".product_category,".PRODUCT_CATEGORY.".id as category_id,".PRODUCT_CATEGORY.".category_name FROM ".PRODUCTS." LEFT JOIN ".PRODUCT_CATEGORY." ON ".PRODUCT_CATEGORY.".id= ".PRODUCTS.".product_category WHERE ".PRODUCT_CATEGORY.".status='".ACTIVE."' AND ".PRODUCT_CATEGORY." .id='$category_id' "; 

		$result=Db::query(Database::SELECT, $query)
		->execute()
		->as_array();

		return count($result);
	}   

	/**
	* Get admin details
	* @return array
	**/
	public function get_admindetails()
	{
		$result= DB::select('id','email')->from(USERS)
			     ->where('usertype','=',ADMIN_USER_TYPE)
			     ->execute()	
			     ->as_array(); 
		return $result;
	}
	
	
	
	/**
	* Get Product settings
	* @return array
	**/
	public function get_product_settings()
	{
		//Query for product listings with Pagination 
		$query  = " SELECT max_title_length,
					  min_title_length,max_desc_length,					
					  alternate_name,										 
		 	 		  min_bidpackages,
		 	 		  max_bidpackages		 	 		
					  FROM ".PRODUCT_SETTINGS." AS JS
			 		 ";  
		$result = Db::query(Database::SELECT, $query)
			    ->execute()
			    ->as_array();
		return $result;

	}      
	
	/**
	* Check the email format is proper or not
	* @return array
	**/
	public function check_emailformat_to_send($arr)
	{
		return Validation::factory($arr)
				->rule('from','email_domain')
				->rule('to','email_domain');
	}
	
        //get smtp settings
        //=================
        public function get_smtp_settings()
        {
                $result = DB::select()
                        ->from(SMTP_SETTINGS)
                        ->execute()
                        ->as_array();
                return $result;
        }
        
        public function user_status_reports($userid)
	{
		$query=DB::select()->from(USERS_ONLINE)
					->where('userid','=',$userid)
					->execute()
					->as_array();	
		return $query;
	}
	
	public function getUserdetails($uid)
	{
		$result =DB::select('u.email','u.id','u.username')->from(array(USERS,'u')) 
							->where('u.id','=',$uid)			     
							->execute()	
							->current();
		$shipping =DB::select('sa.*')->from(array(SHIPPING_ADDRESS,'sa'))
							->where('sa.userid','=',$uid)			     
							->execute()	
							->current();
		$billing =DB::select('ba.*')->from(array(BILLING_ADDRESS,'ba')) 
							->where('ba.userid','=',$uid)			     
							->execute()	
							->current();
		return array('userdetails' => $result,'shippinginfo' => $shipping,'billinginfo' => $billing);
	}
	
	public function getAuctiondetails($pid)
	{
		$auctiontable =DB::select('a.typename')->from(array(PRODUCTS,'p'))
							->join(array(AUCTIONTYPE,'a'),'left')
							->on('p.auction_type','=','a.typeid')->where('p.product_id','=',$pid)
							->execute()->get('typename');
		$query = DB::select('p.product_id','p.product_name','p.product_url','p.product_info','ct.current_price','ct.product_cost')->from(array(PRODUCTS,'p'))
					->join(array(TABLE_PREFIX.$auctiontable,'ct'),'left')
					->on('ct.product_id','=','p.product_id')
					->where('p.product_id','=',$pid)
					->execute()->current();
		return array('productdetails' => $query,'auctiontype' => $auctiontable);
	}
	
	public function get_auction_bid_name($pid)
	{
		return DB::select('a.typename')->from(array(PRODUCTS,'p'))
							->join(array(AUCTIONTYPE,'a'),'left')
							->on('p.auction_type','=','a.typeid')->where('p.product_id','=',$pid)
							->execute()->get('typename');
		
	}
	/**
	*Get user details
	**/
	public function get_userdetails($id){
		$query=DB::select()->from(USERS)
					->where('id','=',$id)
					->execute()
					->current();
		return $query;
	}

        public function get_percent($userid)
	{
		
		$result=DB::select(array('SUM("AMT")','total'))->from(PAYPAL_TRANSACTION_DETAILS)->where(PAYPAL_TRANSACTION_DETAILS.'.USERID','=',$userid)->and_where(PAYPAL_TRANSACTION_DETAILS.'.PAYMENT_METHOD', '=', 'W')
				->execute()
				->get('total');
		return $result;
	}

        public function get_amtproduct($userid)
	{
		
		$result=DB::select(array('SUM("AMT")','total'))->from(PAYPAL_BUYNOW_DETAILS)->where(PAYPAL_BUYNOW_DETAILS.'.USERID','=',$userid)->and_where(PAYPAL_BUYNOW_DETAILS.'.PAYMENT_METHOD', '=', 'W')
				->execute()
				->get('total');
		return $result;
	}
	
	/**** Venkatraja added in 19-Mar-2013 ****/
	public function check_gateway_plugin($module_id)
	{
		
		switch($module_id)
		{
			
			
		case 'paypal':
			
			return 1;
		
		case 'gc':
			
			$query1=DB::select()->from(AUCTIONTYPE)
				      ->where('typename','=','gcheckout')
				      ->and_where('status','=',ACTIVE)
				      ->execute()
				      ->as_array();
						
			if(count($query1)>0)
			{
				return 1;
			}else{
				return 0;
			}
		default :
		
		       $query=DB::select()->from(AUCTIONTYPE)
					->where('typename','=',$module_id)
					->and_where('status','=',ACTIVE)
					->execute()
					->as_array();
			if(count($query)>0)
			{
				return 1;
			}else{
				return 0;
			}
			
			
		}
		
	}
	/****selvam/april4*/
	public function get_total_bid_count($productid,$uid)
	{
		$select="select count(".BID_HISTORIES.".product_id),max(".BID_HISTORIES.".price) as bid_count,".PRODUCTS.".product_name,".PRODUCTS.".product_url,".PRODUCTS.".product_image,
".PRODUCTS.".product_process,".PRODUCTS.".enddate,".PRODUCTS.".product_image,".PRODUCTS.".in_auction FROM ".BID_HISTORIES." LEFT JOIN ".PRODUCTS." on ".PRODUCTS.".product_id = ".BID_HISTORIES.".product_id where ".BID_HISTORIES.".product_id=".PRODUCTS.".product_id and ".BID_HISTORIES.".user_id = ".$uid." and ".PRODUCTS.".product_id = ".$productid." and ".PRODUCTS.".product_status='".ACTIVE."'  group by ".BID_HISTORIES.".product_id,".BID_HISTORIES.".user_id order by ".BID_HISTORIES.".id desc";
		
			$query=DB::query(Database::SELECT,$select)
				->execute()
				->as_array();
			return $query[0]['count('.BID_HISTORIES.'.product_id)'];		
	}
} // End commonfunction Model
