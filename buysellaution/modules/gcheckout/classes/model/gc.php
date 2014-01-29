<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains package Model database queries

* @Created on Feb, 2012

* @Updated on Feb, 2012

* @Package: Auction  v1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Gc extends Model {

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
	
	public function insertGCresponse($datas)
	{
		 $insert = DB::insert(GC_TRANSACTIONS, array_keys($datas))
							->values(array_values($datas))
							->execute();
		return $insert ? true: false;
	}
	
	public function insertmultipleGCresponse($datas)
	{
		
		$insert = DB::insert(GC_TRANSACTIONS, array_keys($datas))
							->values(array_values($datas))
							->execute();
		return $insert ? true: false;
	}
	
	
	
	
	
	
	public function selectGCTransaction($id)
	{
		 $query = DB::select()->from(GC_TRANSACTIONS)
						->where('gc_orderno','=',$id)
						->execute()	
						->current();
		return $query;
	}
	
	
	/* To Insert Transaction Details for specific Package id only -Dec18,2012 */
	public function authTransactionDetails($data){
		$data['transaction_date']=$this->getCurrentTimeStamp;
		$result= DB::insert(TRANSACTION_DETAILS, array_keys($data))
							->values(array_values($data))
							->execute();
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	/* To Insert package orders -Dec18,2012 */
	public function authOrderDetails($data){
		$data['order_date']=$this->getCurrentTimeStamp;
		$result= DB::insert(PACKAGE_ORDERS, array_keys($data))
							->values(array_values($data))
							->execute();
		if($result){
			return true;
		}else{
			return false;
		}
	}

	public function packageordercount($orderno)
	{
		$result =DB::select('order_no')->from(PACKAGE_ORDERS)->where('order_no','=',$orderno)			     
							->execute()	
							->count();
		return $result;
	}
	
	//Select User Amount 
	public function get_user_account($userid)
	{
		$query=$this->commonmodel->select_with_onecondition(USERS,'id='.$userid);
		return $query[0]['user_bid_account'];		
	}
	
	/**** Added By Venkatraja ****/
	
	
		//Select Shipping Amount
	public function get_shipping_amount($productid)
	{
		$query=$this->commonmodel->select_with_onecondition(PRODUCTS,'product_id='.$productid);
		
		return ($query[0]['shipping_fee']!='')?$query[0]['shipping_fee']:0;		
	}
	
	
	public function selectMultipleGCTransaction($id)
	{
		$query = DB::select()->from(GC_TRANSACTIONS)
						->where('gc_orderno','=',$id)			     
						->execute()	
						->as_array();
		return $query;
	}
	
	
		/* To Insert package orders -Dec18,2012 */
	public function WonOrderDetails($data){
		$data['order_date']=$this->getCurrentTimeStamp;
		$result= DB::insert(PACKAGE_ORDERS, array_keys($data))
							->values(array_values($data))
							->execute();
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	
	
	// Add Transaction Log Details
	public function addbuynowtransactionlog_details($data)
        {	
		
		$data['transaction_date']=$this->getCurrentTimeStamp;
		$result= DB::insert(BUYNOW_TRANSACTION_DETAILS, array_keys($data))
							->values(array_values($data))
							->execute();
		if($result){
			return true;
		}else{
			return false;
		}
		

        }
	


        
        //Add Transaction Log Details
        public function addbuynowtransaction_details($data)
        {	
		$data['TIMESTAMP']=$this->getCurrentTimeStamp;
		$result= DB::insert(PAYPAL_BUYNOW_DETAILS, array_keys($data))
							->values(array_values($data))
							->execute();
		if($result){
			return true;
		}else{
			return false;
		}
		
        }
	
	
	
	public static function get_last_transaction_id()
	{
		 $sql = "SELECT MAX(ID) AS 'MAXID' FROM ".PAYPAL_BUYNOW_DETAILS;   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
			
		
			
		return (count($result)>0)?$result[0]['MAXID']:'';	
			
        }
	
	  // Select user name 
	public function get_username($userid)
        {
                $result= DB::select('username')->from(USERS)
		             ->where('id','=', $userid)
			     ->execute()	
			     ->as_array();
		return $result[0]['username'];      
        }
	
	
	
        //Add Order Details
        public function addbuynoworder_details($data)
        {
	
		$data['order_date']=$this->getCurrentTimeStamp;
		$result= DB::insert(BUY_PRODUCTS, array_keys($data))
							->values(array_values($data))
							->execute();	
		return $result;   
                
        }
	
	
		//User Message 
	//Insert to user message table 
	public function user_message_packages($select_email,$from,$subject,$message,$sent_date)
	{
			$result   = DB::insert(USER_MESSAGE,array('usermessage_to', 'usermessage_from', 'usermessage_subject','usermessage_message','sent_date'))
				->values(array($select_email,$from,$subject,$message,$sent_date))
				->execute();
				return $result;
			
	}
	
	//Delete 
	public function order_delete($productid,$uid)
	{	
		$result   = DB::delete(BUYNOW_ADDTOCART)					
			->where('productid', '=', $productid)
			->and_where('userid', '=', $uid)
			->execute();
		
	}
	


	
	
	
	
	/*** Added By Venkatraja ***/
	
	
	
	
	// Update User account 
	public function update_useraccount($userid,$amount)
	{
		return $this->commonmodel->update(USERS,array('user_bid_account'=>$amount),'id',$userid);
	}
	
	public function auctionOrderDetails($data)
	{
		$data['order_date']=$this->getCurrentTimeStamp;
		$result= DB::insert(AUCTION_ORDERS, array_keys($data))
							->values(array_values($data))
							->execute();
		return $result;
	}
	
	public function getProductName($pid)
	{
		$result =DB::select('product_name')->from(PRODUCTS)->where('product_id','=',$pid)			     
							->execute()	
							->get('product_name');
		return $result;
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
	
	/**** added By venkatraja in 15-Mar-2013****/
	
	public function gettransactionlogdetails($invoiceno)
	{
		 $rs = DB::select()->from(GC_TRANSACTIONS)
					->where('gc_orderno','=',$invoiceno)
				        ->execute()
				        ->as_array();
		return $rs;			
		
		
	}
	
	
	/**** Added End By Venkatraja in 15-Mar-2013 *****/
	
	
}
?>
