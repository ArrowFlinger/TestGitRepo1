<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains package Model database queries

* @Created on Feb, 2012

* @Updated on Feb, 2012

* @Package: Auction  v1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Authorize extends Model {

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
	
	/* To Get Package Details for specific package id only -Dec17,2012 */
	public function getpackageDetails($package_id){
		return DB::select()->from(BIDPACKAGES)
						->where('package_id','=',$package_id)			     
						->execute()	
						->as_array(); //Auction type
				
	}
	
	/* To Get Paymentgateway Details for specific id only -Dec17,2012 */
	public function getpaymentgatewayDetails($pg_id){
		return DB::select()->from(PAYMENT_GATEWAYS)
						->where('paygate_code','=',$pg_id)			     
						->execute()	
						->current(); //Auction type
		
	}
	
	public function getProductName($pid)
	{
		$result =DB::select('product_name')->from(PRODUCTS)->where('product_id','=',$pid)			     
							->execute()	
							->get('product_name');
		return $result;
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
	
	// Select user name 
	public function get_username($userid)
        {
                $result= DB::select('username')->from(USERS)
		             ->where('id','=', $userid)
			     ->execute()	
			     ->as_array();
		return $result[0]['username'];      
        }
	
	
	
	/* To Insert Paypal Transaction Details for specific Package id only -Dec18,2012 */
	public function authPaypalTransactionDetails($data){
		$data['TIMESTAMP']=$this->getCurrentTimeStamp;
		$data['ORDERTIME']=$this->getCurrentTimeStamp;
		$result= DB::insert(PAYPAL_TRANSACTION_DETAILS, array_keys($data))
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
	
	public function auctionOrderDetails($data)
	{
		$data['order_date']=$this->getCurrentTimeStamp;
		$result= DB::insert(AUCTION_ORDERS, array_keys($data))
							->values(array_values($data))
							->execute();
		return $result;
	}
	
   /* Authorize form field Validation here  - Dec18,2012 */	
	public function authorize_validation($arr){
		$validation= Validation::factory($arr)
				/*->rule('firstName', 'not_empty')
				->rule('firstName', 'alpha_space')
				->rule('firstName', 'min_length', array(':value', '4'))
				->rule('firstName', 'max_length', array(':value', '25'))
				->rule('lastName', 'not_empty')
				->rule('lastName', 'alpha')
				->rule('address1', 'not_empty')
				->rule('address1','Model_Users::check_label_not_empty',array(":value",__('enter_address1')))
				->rule('address1', 'min_length', array(':value', '4'))
				->rule('address1', 'max_length', array(':value', '50'))
				->rule('address2', 'not_empty')
				->rule('address3','Model_Users::check_label_not_empty',array(":value",__('enter_address1')))
				->rule('address4', 'min_length', array(':value', '4'))
				->rule('address5', 'max_length', array(':value', '50'))*/
				->rule('creditCardNumber', 'not_empty')				
				->rule('creditCardNumber', 'numeric')
				->rule('creditCardNumber', 'check_cc', array(':value'))
				->rule('creditCardNumber', 'luhn_check', array(':value'))
				//->rule('creditCardNumber', 'max_length', array(':value', '20'))	
				->rule('cvv2Number', 'not_empty')				
				->rule('cvv2Number', 'numeric')
				/*->rule('city', 'not_empty')
				->rule('city','Model_Users::check_label_not_empty',array(":value",__('enter_city')))
				->rule('city', 'min_length', array(':value', '4'))
				->rule('city', 'max_length', array(':value', '20'))
				->rule('city', 'alpha')
				->rule('state', 'not_empty')
				->rule('state','Model_Users::check_label_not_empty',array(":value",__('enter_city')))
				->rule('state', 'alpha')
				->rule('state', 'max_length', array(':value', '2'))
				->rule('countrycode', 'not_empty')
				->rule('countrycode','Model_Users::check_label_not_empty',array(":value",__('enter_city')))
				->rule('countrycode', 'max_length', array(':value', '2'))
				->rule('countrycode', 'alpha')
				->rule('zip', 'not_empty')				
				->rule('zip', 'numeric')
				->rule('zip', 'min_length', array(':value', '4'))
				->rule('zip', 'max_length', array(':value', '10'));*/;
		return $validation;
		
	}
	
	//Select User Amount 
	public function get_user_account($userid)
	{
		$query=$this->commonmodel->select_with_onecondition(USERS,'id='.$userid);
		return $query[0]['user_bid_account'];		
	}
	
	// Update User account 
	public function update_useraccount($userid,$amount)
	{
		return $this->commonmodel->update(USERS,array('user_bid_account'=>$amount),'id',$userid);
	}
	
	/**** venkatraja added start ***/
	
	//Delete 
	public function order_delete($productid,$uid)
	{	
		$result   = DB::delete(BUYNOW_ADDTOCART)					
			->where('productid', '=', $productid)
			->and_where('userid', '=', $uid)
			->execute();
		
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
	
	
	
	
	 //Add Order Details
        public function addbuynoworder_details($data)
        {
	
		$data['order_date']=$this->getCurrentTimeStamp;
		$result= DB::insert(BUY_PRODUCTS, array_keys($data))
							->values(array_values($data))
							->execute();	
		return $result;   
                
        }
	
	public static function get_last_transaction_id()
	{
	   $sql = "SELECT MAX(ID) AS 'MAXID' FROM ".PAYPAL_BUYNOW_DETAILS;   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
			
		
			
	return (count($result)>0)?$result[0]['MAXID']:'';		

			
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
		//User Message 
	//Insert to user message table 
	public function user_message_packages($select_email,$from,$subject,$message,$sent_date)
	{
			$result   = DB::insert(USER_MESSAGE,array('usermessage_to', 'usermessage_from', 'usermessage_subject','usermessage_message','sent_date'))
				->values(array($select_email,$from,$subject,$message,$sent_date))
				->execute();
				return $result;
			
	}
	
	
	
	/**** venkatraja added end ***/
	/**** added By venkatraja in 15-Mar-2013****/
	
	public function gettransactionlogdetails($invoiceno)
	{
		  $rs = DB::select()->from(PAYPAL_TRANSACTION_DETAILS)
					->where('INVOICEID','=',$invoiceno)
				        ->execute()
				        ->as_array();
		 
		return $rs;			
		
		
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
			     
			       $tablename=TABLE_PREFIX.$query2[0]['typename'];
			     
			     
			     $query= DB::select($tablename.'.product_id',$tablename.'.product_cost',
					   PRODUCTS.'.product_name',   PRODUCTS.'.product_image',
					   PRODUCTS.'.shipping_fee')->from($tablename)
				     ->where($tablename.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on($tablename.'.product_id','=',PRODUCTS.'.product_id')
				    ->execute()	
				     ->as_array(); 
			             return $query;
			   
                
        }
	
	
	/**** Added End By Venkatraja in 15-Mar-2013 *****/
	
	
	
}
?>
