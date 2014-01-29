<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains package Model database queries

* @Created on Feb, 2012

* @Updated on Feb, 2012

* @Package: Auction  v1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Mercadopago extends Model {

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
	
	 /*
         * To get the job details
         */
        public function getjobdetails($packid)
        {			
                $result= DB::select()->from(BIDPACKAGES)
						->where('package_id','=', $packid)
                                                ->and_where('status','=',ACTIVE)
						->execute()	
						->as_array();
                return $result;
                
        }
        
	/*
		 *  To get config details of mercadopago
		 */
		public function getmercadopagoconfig()
        {
                $result= DB::select()->from(PAYMENT_GATEWAYS)
						->where('payment_gatway','=', "MercadoPago")
						->execute()	
						->as_array();
				return $result;     
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
						->where('id','=',$pg_id)			     
						->execute()	
						->current(); //Auction type
		
	}
	
	
	       /**To Get Current TimeStamp**/
	public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}
	
	//Select PayPal Config 
        public function getpaypalconfig()
        {
                $result= DB::select()->from(PAYMENT_GATEWAYS)
		             ->where('payment_gatway','=', "PayPal")
			     ->execute()	
			     ->as_array();
                       
		return $result;
                
        }
        
    
        // Select Setting Config values
        public function getsitesettingconfig()
        {
                $result= DB::select('site_name','site_slogan','site_language')->from(SITE)                            
			     ->execute()	
			     ->as_array();
                       
		return $result[0];      
        }

        // Get admin details
	public function getadminID($admin_usertype = "A")
        {
                $result= DB::select('id')->from(USERS)
		             ->where('usertype','=', $admin_usertype)
			     ->execute()	
			     ->as_array();
                       
		return $result[0]['id'];
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

        // Add Transaction Log Details
	public function addtransactionlog_details($transactionlog)
        {
                $transactionlogfields = array('userid','orderid','packageid','amount','amount_type','description','transaction_date');
                $transactionlogvalues = array($transactionlog['userid'],$transactionlog['order_no'],$transactionlog['packageid'],$transactionlog['amount'],
                $transactionlog['amount_type'],$transactionlog['description'],$this->getCurrentTimeStamp());
                $result = DB::insert(TRANSACTION_DETAILS, $transactionlogfields )
			->values($transactionlogvalues)
			->execute();
		return $result; 
        }
        
        //Add Transaction Log Details
        public function addtransaction_deatils(array $transactionfields)
        {
		$transactionfields['FEEAMT']=isset($transactionfields['FEEAMT'])?$transactionfields['FEEAMT']:0.00;
                $transactioncolumn = array('PAYERID','PAYERSTATUS','FIRSTNAME','LASTNAME','EMAIL','COUNTRYCODE','PACKAGEID','USERID','CORRELATIONID','ACK',
                'TRANSACTIONID','RECEIPTID','TRANSACTIONTYPE','PAYMENTTYPE','ORDERTIME','AMT','FEEAMT','CURRENCYCODE','PAYMENTSTATUS',
                'PENDINGREASON','REASONCODE','INVOICEID','LOGIN_ID','USER_AGENT','TIMESTAMP'
                );
                $transactionvalues = array($transactionfields['PAYERID'],$transactionfields['PAYERSTATUS'],$transactionfields['FIRSTNAME'],$transactionfields['LASTNAME'],$transactionfields['EMAIL'],$transactionfields['COUNTRYCODE'],$transactionfields['PACKAGEID'],$transactionfields['USERID'],$transactionfields['CORRELATIONID'],$transactionfields['ACK'],$transactionfields['TRANSACTIONID'],$transactionfields['PAYERSTATUS'],$transactionfields['TRANSACTIONTYPE'],$transactionfields['PAYMENTTYPE'],$transactionfields['ORDERTIME'],$transactionfields['AMT'],$transactionfields['FEEAMT'],$transactionfields['CURRENCYCODE'],$transactionfields['PAYMENTSTATUS'],$transactionfields['PENDINGREASON'],$transactionfields['REASONCODE'],$transactionfields['INVOICEID'],$transactionfields['LOGIN_ID'],$transactionfields['USER_AGENT'],$this->getCurrentTimeStamp());
                
                $result = DB::insert(PAYPAL_TRANSACTION_DETAILS, $transactioncolumn )
			->values($transactionvalues)
			->execute();    
		return $result;   
                
        }
        
        //Add Order Details
        public function addorder_details(array $orderfields)
        {
                $ordercolumn = array('order_no','package_id','buyer_id','seller_id','order_status','action','package_amount','package_commission_amount','order_total',
                'order_subtotal', 'order_currency_code','paid_status','maximum_date_complete','transaction_details_id','order_date'
                );
                $ordervalues = array($orderfields['order_no'],$orderfields['package_id'],$orderfields['buyer_id'],$orderfields['seller_id'],$orderfields['order_status'],$orderfields['action'],$orderfields['package_amount'],$orderfields['package_commission_amount'],$orderfields['order_total'],$orderfields['order_subtotal'],$orderfields['order_currency_code'],$orderfields['paid_status'],$orderfields['maximum_date_complete'],$orderfields['transaction_details_id'],$this->getCurrentTimeStamp());
                
                $result = DB::insert(PACKAGE_ORDERS, $ordercolumn)
			->values($ordervalues)
			->execute();
		return $result;   
                
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
	
}
?>
