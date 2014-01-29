<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains package Model database queries

* @Created on Feb, 2012

* @Updated on Feb, 2012

* @Package: Auction  v1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Buynow extends Model {

	/**
	* ****__construct()****
	*
	* setting up commonfunction model
	*/	
	public function __construct()
	{
		//calling communfunction model in this constructor
		$this->commonmodel=Model::factory('commonfunctions');
		$this->auctions=Model::factory('auction');
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
	}
	
	

        // Received Package Amount
	public function get_received_buyamount($product_id)
	{
			$query= DB::select('auction_type')->from(PRODUCTS)
			     ->where('product_id','=',$product_id)			     
			     ->execute()	
			     ->as_array(); //Auction type
			 
			$query2= DB::select()->from(AUCTIONTYPE)
			     ->where('typeid','=',$query[0]['auction_type'])			     
			     ->execute()	
			     ->as_array(); //Type Name
			     
			     $tablename=TABLE_PREFIX.$query2[0]['typename'];
			     
			     
			  	$query= DB::select($tablename.'.product_id',$tablename.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.shipping_fee')->from($tablename)
				     ->where($tablename.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on($tablename.'.product_id','=',PRODUCTS.'.product_id')
				    ->execute()	
				     ->as_array(); 
			             return $query;
				
				
				
			     
			     
			     
			     
			     
			     /*
			     
			
			if($query2[0]['typename']=='pennyauction'){
	
				$query= DB::select(PENNYAUCTION.'.product_id',PENNYAUCTION.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.shipping_fee')->from(PENNYAUCTION)
				     ->where(PENNYAUCTION.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on(PENNYAUCTION.'.product_id','=',PRODUCTS.'.product_id')
				     ->execute()	
				     ->as_array(); 
			             return $query;

			}else if($query2[0]['typename']=='beginner'){

				$query= DB::select(BEGINNER.'.product_id',BEGINNER.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.shipping_fee')->from(BEGINNER)
				     ->where(BEGINNER.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on(BEGINNER.'.product_id','=',PRODUCTS.'.product_id')
				     ->execute()	
				     ->as_array(); 
				     return $query;
			}else{
				$query= DB::select(PEAK_AUCTION.'.product_id',PEAK_AUCTION.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.shipping_fee')->from(PEAK_AUCTION)
				     ->where(PEAK_AUCTION.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on(PEAK_AUCTION.'.product_id','=',PRODUCTS.'.product_id')
				     ->execute()	
				     ->as_array(); 
				     return $query;
			}
			     */
	}

	//Buy Now transaction details
	/**
	* Select all fields in transaction details table
	* @param $offset, $val(for limit), $userid , $need_count
	* @return when count occur return count else return query result array
	*/
	public function select_buynow_transactions_history($offset,$val,$userid,$need_count=FALSE)
	{
		$query=DB::select(BUYNOW_TRANSACTION_DETAILS.'.userid',
				BUYNOW_TRANSACTION_DETAILS.'.productid',
				BUYNOW_TRANSACTION_DETAILS.'.amount',
				BUYNOW_TRANSACTION_DETAILS.'.shippingamount',
				BUYNOW_TRANSACTION_DETAILS.'.quantity',
				BUYNOW_TRANSACTION_DETAILS.'.amount_type',
				BUYNOW_TRANSACTION_DETAILS.'.payment_type',
				BUYNOW_TRANSACTION_DETAILS.'.description',
				BUYNOW_TRANSACTION_DETAILS.'.transaction_date',
				PRODUCTS.'.product_name',PRODUCTS.'.product_id')->from(BUYNOW_TRANSACTION_DETAILS)
					->join(PRODUCTS,'left')
					->on(BUYNOW_TRANSACTION_DETAILS.'.productid','=',PRODUCTS.'.product_id')
					->where(BUYNOW_TRANSACTION_DETAILS.'.userid','=',$userid);
					
				
						
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
	
	
	/*** Added By Venkatraja 14-Mar-2013 ****/
	
	public function getAuctiondetails($pid)
	{
		$auctiontable =DB::select('a.typename')->from(array(PRODUCTS,'p'))
							->join(array(AUCTIONTYPE,'a'),'left')
							->on('p.auction_type','=','a.typeid')->where('p.product_id','=',$pid)
							->execute()->get('typename');
		if($auctiontable=='')
		{
			DB::select('a.typename')->from(array(PRODUCTS,'p'))
							->join(array(AUCTIONTYPE,'a'),'left')
							->on('p.auction_type','=','a.typeid')->where('p.product_id','=',$pid);
							
		}
		$query = DB::select('p.product_id','p.product_name','p.product_url','p.product_info','ct.current_price','ct.product_cost')->from(array(PRODUCTS,'p'))
					->join(array(TABLE_PREFIX.$auctiontable,'ct'),'left')
					->on('ct.product_id','=','p.product_id')
					->where('p.product_id','=',$pid)
					->execute()->current();
		return array('productdetails' => $query,'auctiontype' => $auctiontable);
	}
	
	public function getUserdetails($uid)
	{
		$result =DB::select('u.email','u.id','u.username')->from(array(USERS,'u')) 
							->where('u.id','=',$uid)			     
							->execute()	
							->current();
		$shipping =DB::select('sa.*')->from(array(SHIPPING_ADDRESS,'sa'))
							->where('sa.id','=',$uid)			     
							->execute()	
							->current();
		$billing =DB::select('ba.*')->from(array(BILLING_ADDRESS,'ba')) 
							->where('ba.id','=',$uid)			     
							->execute()	
							->current();
		return array('userdetails' => $result,'shippinginfo' => $shipping,'billinginfo' => $billing);
	}
	
	/*** Added End By Venkatraja 14-Mar-2013 ***/
	
	
	//Add to cart List
	public function addtocart_list($offset,$val,$userid,$need_count=FALSE)
	{
		$query=DB::select(BUYNOW_ADDTOCART.'.userid',
				BUYNOW_ADDTOCART.'.productid',
				BUYNOW_ADDTOCART.'.id',
				BUYNOW_ADDTOCART.'.product_cost',
				BUYNOW_ADDTOCART.'.shipping_fee',
				BUYNOW_ADDTOCART.'.quantity',
				BUYNOW_ADDTOCART.'.amount',
				BUYNOW_ADDTOCART.'.total_amt',
				BUYNOW_ADDTOCART.'.product_image',
				PRODUCTS.'.product_info',
					BUYNOW_ADDTOCART.'.product_name',
					BUYNOW_ADDTOCART.'.add_date',PRODUCTS.'.product_name',PRODUCTS.'.product_id')->from(BUYNOW_ADDTOCART)
					->join(PRODUCTS,'left')
					->on(BUYNOW_ADDTOCART.'.productid','=',PRODUCTS.'.product_id')
					->where(BUYNOW_ADDTOCART.'.userid','=',$userid);
						
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

	//Update Add to cart count
	public function updatecart($id,$quantity,$amount)
	{
			$userid=$_SESSION['auction_userid'];
			$result = DB::update(BUYNOW_ADDTOCART)->set(array('amount'=>$amount,'total_amt'=>$amount,'quantity'=>$quantity,'add_date'=>$this->getCurrentTimeStamp))->where('productid', '=',$id)->and_where('userid', '=',$userid)
			->execute(); 
	}
	
	//Add to cart List
	public function all_addtocart_list($userid,$need_count=FALSE)
	{
		
		$query=DB::select(BUYNOW_ADDTOCART.'.userid',
				BUYNOW_ADDTOCART.'.productid',
				BUYNOW_ADDTOCART.'.id',
				BUYNOW_ADDTOCART.'.quantity',
				PRODUCTS.'.product_url',
				PRODUCTS.'.dedicated_auction',
				BUYNOW_ADDTOCART.'.product_cost',
				BUYNOW_ADDTOCART.'.amount',
				PRODUCTS.'.shipping_fee',
				BUYNOW_ADDTOCART.'.total_amt',
				BUYNOW_ADDTOCART.'.product_image',					
					BUYNOW_ADDTOCART.'.product_name',
					BUYNOW_ADDTOCART.'.add_date',PRODUCTS.'.product_name',PRODUCTS.'.product_id')->from(BUYNOW_ADDTOCART)
					->join(PRODUCTS,'left')
					->on(BUYNOW_ADDTOCART.'.productid','=',PRODUCTS.'.product_id')
					->where(BUYNOW_ADDTOCART.'.userid','=',$userid);
						
		if($need_count)
		{
			$result=$query	->order_by('id','DESC')
					->execute()
					->as_array();
			return count($result);
		}	
		else
		{
			$result=$query			
					->order_by('id','DESC')
					->execute()
					->as_array();
			return $result;
		}		
	}
	

	//Remove addto cart
	public function remove_addtocart($uid,$id)
	{
		$query=DB::delete(BUYNOW_ADDTOCART)
			->where('id','=',$id)
			->and_where('userid','=',$uid)			
			->execute();
		return $query;
	}

	 /**
        * ****show_payment_log_content()****
        *@return show normal payment transaction log
        */	
	public function show_payment_log_content($page_id)
	{
		//query to display all payment transactions list 
		$query = " SELECT U.username AS username,
						PTD.ID,PTD.PAYERID,
						PTD.COUNTRYCODE,PTD.EMAIL,
						PTD.RECEIVER_EMAIL,
						PTD.TIMESTAMP,
						PTD.CORRELATIONID,
						PTD.ACK,
						PTD.TRANSACTIONID,
						PTD.REASONCODE,
						PTD.PAYERSTATUS,
						PTD.TRANSACTIONTYPE,
						PTD.FEEAMT,
						PTD.AMT,
						PTD.SHIPPINGAMT,
						PTD.RECEIPTID,
						U.created_date,
						PTD.PAYMENTTYPE,
						PTD.ORDERTIME,
						PTD.CURRENCYCODE,
						PTD.PRODUCTID,
						PTD.PAYMENTSTATUS,
						PTD.PENDINGREASON,
						PTD.REASONCODE,
						PTD.INVOICEID,
						PTD.LOGIN_ID
						FROM ".PAYPAL_BUYNOW_DETAILS." AS PTD
						LEFT JOIN ".USERS." AS U ON ( U.id = PTD.USERID )						
						WHERE PTD.PRODUCTID = '$page_id' ";
		$result = Db::query(Database::SELECT, $query)
		    	  ->execute()
		    	  ->as_array();
		
		return $result;	  
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
				->rule('zipcode','Model_Users::check_label_not_empty',array(":value",__('zipcode_label')))
				->rule('zipcode', 'not_empty')				
				->rule('zipcode', 'numeric')
				->rule('zipcode', 'min_length', array(':value', '4'))
				->rule('zipcode', 'max_length', array(':value', '10'))
				->rule('phone', 'regex', array(':value', '/^[0-9()+_-]++$/i'));
		
		if(isset($arr['town']) && $arr['town']!=__('enter_town'))
		{
			$validation->rule('town', 'alpha');
		}
		return $validation;
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

	 // Received Package Amount
	public function get_received_buyamount_offline($product_id)
	{ 
			$query= DB::select('auction_type')->from(PRODUCTS)
			     ->where('product_id','=',$product_id)			     
			     ->execute()	
			     ->as_array(); //Auction type
			// print_r($query);exit;
			$query2= DB::select()->from(AUCTIONTYPE)
			     ->where('typeid','=',$query[0]['auction_type'])			     
			     ->execute()	
			     ->as_array(); //Type Name			
			
			if($query2[0]['typename']=='pennyauction'){
	
				$query= DB::select(PENNYAUCTION.'.product_id',PENNYAUCTION.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.shipping_fee')->from(PENNYAUCTION)
				     ->where(PENNYAUCTION.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on(PENNYAUCTION.'.product_id','=',PRODUCTS.'.product_id')
				     ->execute()	
				     ->as_array(); 
			             return $query;

			}else if($query2[0]['typename']=='beginner'){

				$query= DB::select(BEGINNER.'.product_id',BEGINNER.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.shipping_fee')->from(BEGINNER)
				     ->where(BEGINNER.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on(BEGINNER.'.product_id','=',PRODUCTS.'.product_id')
				     ->execute()	
				     ->as_array(); 
				     return $query;
			}else{
				$query= DB::select(PEAK_AUCTION.'.product_id',PEAK_AUCTION.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.shipping_fee')->from(PEAK_AUCTION)
				     ->where(PEAK_AUCTION.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on(PEAK_AUCTION.'.product_id','=',PRODUCTS.'.product_id')
				     ->execute()	
				     ->as_array(); 
				     return $query;
			}
	}

}
?>
