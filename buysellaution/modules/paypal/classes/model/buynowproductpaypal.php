<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Contains Payment Module details

* @Created on Feb, 2012

* @Updated on Feb, 2012

* @Package: Auction  v1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in
 */

class Model_Buynowproductpaypal extends Model
{
	
	/**
	 * ****__construct()****
	 *
	 * setting up session variables
	 */
        public function __construct()
        {	
                $this->session = Session::instance();	
                $this->username = $this->session->get("username");
		$this->commonmodel=Model::factory('commonfunctions');
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

	//Add to cart List
	public function all_addtocart_list($userid,$need_count=FALSE)
	{
		
		$query=DB::select(BUYNOW_ADDTOCART.'.userid',
				BUYNOW_ADDTOCART.'.productid',
				BUYNOW_ADDTOCART.'.id',
				BUYNOW_ADDTOCART.'.quantity',
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
	
	
	/*** add won auction details **/
	
	    // Add Transaction Log Details
	public function addwontransactionlog_details($transactionlog)
        {
		//echo $transactionlog['description'][0];exit;
                $transactionlogfields = array('userid','orderid','packageid','amount','shippingamount','amount_type','transaction_type','description','type','transaction_date');
                $transactionlogvalues = array($transactionlog['userid'],$transactionlog['order_no'],$transactionlog['productid'][0],$transactionlog['amount0'],
               $transactionlog['shippingamount'][0],$transactionlog['amount_type'],'paypal',$transactionlog['description'][0],'PR',$this->getCurrentTimeStamp());
                $result = DB::insert(TRANSACTION_DETAILS, $transactionlogfields )
			->values($transactionlogvalues)
			->execute();
		return $result; 
        }
	
	
        //Add Transaction Log Details
        public function addwontransaction_deatils(array $transactionfields)
        {  
		$shippingfee=isset($transactionfields['SHIPPINGAMT0'])?$transactionfields['SHIPPINGAMT0']:0.00;
		$transactionfields['FEEAMT']=isset($transactionfields['FEEAMT'])?$transactionfields['FEEAMT']:0.00;
                $transactioncolumn = array('PAYERID','PAYERSTATUS','FIRSTNAME','LASTNAME','EMAIL','COUNTRYCODE','PACKAGEID','USERID','CORRELATIONID','ACK',
                'TRANSACTIONID','RECEIPTID','TRANSACTIONTYPE','PAYMENTTYPE','ORDERTIME','AMT','SHIPPINGAMT','FEEAMT','CURRENCYCODE','PAYMENTSTATUS',
                'PENDINGREASON','REASONCODE','INVOICEID','LOGIN_ID','USER_AGENT','TIMESTAMP'
                );
                $transactionvalues = array($transactionfields['PAYERID'],$transactionfields['PAYERSTATUS'],$transactionfields['FIRSTNAME'],
					   $transactionfields['LASTNAME'],$transactionfields['EMAIL'],$transactionfields['COUNTRYCODE'],
					   $transactionfields['PRODUCTID'][0],$transactionfields['USERID'],$transactionfields['CORRELATIONID'],
					   $transactionfields['ACK'],$transactionfields['TRANSACTIONID'],$transactionfields['PAYERSTATUS'],
					   $transactionfields['TRANSACTIONTYPE'],$transactionfields['PAYMENTTYPE'],$transactionfields['ORDERTIME'],
					     $transactionfields['L_PAYMENTREQUEST_0_AMT0'],$shippingfee,$transactionfields['FEEAMT'],$transactionfields['CURRENCYCODE'],
					   $transactionfields['PAYMENTSTATUS'],$transactionfields['PENDINGREASON'],$transactionfields['REASONCODE'],
					   $transactionfields['INVOICEID'],$transactionfields['LOGIN_ID'],$transactionfields['USER_AGENT'],
					   $this->getCurrentTimeStamp());
                
                $result = DB::insert(PAYPAL_TRANSACTION_DETAILS, $transactioncolumn )
			->values($transactionvalues)
			->execute();    
		return $result;   
                
        }
	
	
        //Add Order Details
        public function addwonorder_details($data)
        {

		$data['order_date']=$this->getCurrentTimeStamp();
		$result= DB::insert(AUCTION_ORDERS, array_keys($data))
							->values(array_values($data))
							->execute();
		return $result;
                
        }

	
	
	/*** end won auction details **/
	
	
	
	

        // Add Transaction Log Details
	public function addtransactionlog_details($transactionlog,$producttotalcoutid)
        {	
		for($i=0;$i<=$producttotalcoutid;$i++){
			
			$shippingfee=0;
			if($transactionlog['productid'][$i]!='')
			{
				$getproductdetails=$this->getproductdetails($transactionlog['productid'][$i]);
				$shippingfee=$getproductdetails[0]['shipping_fee'];
			}
			
			
                $transactionlogfields = array('userid','orderid','productid','amount','quantity','shippingamount','amount_type','payment_type','description','transaction_date');
                $transactionlogvalues = array($transactionlog['userid'],$transactionlog['order_no'],$transactionlog['productid'][$i],
					      $transactionlog['amount'.$i],$transactionlog['quantity'][$i],$shippingfee,
                $transactionlog['amount_type'],'Paypal',$transactionlog['description'][$i],$this->getCurrentTimeStamp());

                $result = DB::insert(BUYNOW_TRANSACTION_DETAILS, $transactionlogfields )
			->values($transactionlogvalues)
			->execute();
		}
		return $result; 
        }
	

	
	
	

	 // Add Transaction Log Details
	public function addtransactionlog_details_offline($transactionlog)
        {	
                $transactionlogfields = array('userid','orderid','productid','amount','quantity','shippingamount','amount_type',
					      'description','transaction_date');
                $transactionlogvalues = array($transactionlog['userid'],$transactionlog['order_no'],$transactionlog['productid'],
					      $transactionlog['amount'],$transactionlog['quantity'],$transactionlog['shipping_amount'],
                $transactionlog['amount_type'],$transactionlog['description'],$this->getCurrentTimeStamp());
				
                $result = DB::insert(BUYNOW_TRANSACTION_DETAILS, $transactionlogfields )
			->values($transactionlogvalues)
			->execute();
		
	
		return $result; 
        }
        
        //Add Transaction Log Details
        public function addtransaction_deatils(array $transactionfields,$producttotalcoutid)
        {
		//print_r($transactionfields['L_PAYMENTREQUEST_0_AMT0']);exit;
		for($i=0;$i<=$producttotalcoutid;$i++){
			if($transactionfields['PRODUCTID'][$i]!='')
			{
				
				$getproductdetails=$this->getproductdetails($transactionfields['PRODUCTID'][$i]);
				//print_r($getproductdetails);exit;
			 	$shippingfee=$getproductdetails[0]['shipping_fee'];
			}

		$transactionfields['FEEAMT']=isset($transactionfields['FEEAMT'])?$transactionfields['FEEAMT']:0.00;
                $transactioncolumn = array('PAYERID','PAYERSTATUS','FIRSTNAME','LASTNAME','EMAIL','COUNTRYCODE','PRODUCTID','USERID','CORRELATIONID','ACK',
                'TRANSACTIONID','RECEIPTID','TRANSACTIONTYPE','PAYMENTTYPE','ORDERTIME','AMT','SHIPPINGAMT','FEEAMT','CURRENCYCODE','PAYMENTSTATUS',
                'PENDINGREASON','REASONCODE','INVOICEID','LOGIN_ID','USER_AGENT','TIMESTAMP',
                );
                $transactionvalues = array($transactionfields['PAYERID'],$transactionfields['PAYERSTATUS'],$transactionfields['FIRSTNAME'],
					   $transactionfields['LASTNAME'],$transactionfields['EMAIL'],$transactionfields['COUNTRYCODE'],
					   $transactionfields['PRODUCTID'][$i],$transactionfields['USERID'],$transactionfields['CORRELATIONID'],
					   $transactionfields['ACK'],$transactionfields['TRANSACTIONID'],$transactionfields['PAYERSTATUS'],
					   $transactionfields['TRANSACTIONTYPE'],$transactionfields['PAYMENTTYPE'],$transactionfields['ORDERTIME'],
					   $transactionfields['L_PAYMENTREQUEST_0_AMT'.$i],$shippingfee,$transactionfields['FEEAMT'],$transactionfields['CURRENCYCODE'],
					   $transactionfields['PAYMENTSTATUS'],$transactionfields['PENDINGREASON'],$transactionfields['REASONCODE'],
					   $transactionfields['INVOICEID'],$transactionfields['LOGIN_ID'],$transactionfields['USER_AGENT'],
					   $this->getCurrentTimeStamp());
         	
                $result = DB::insert(PAYPAL_BUYNOW_DETAILS, $transactioncolumn)
			->values($transactionvalues)
			->execute(); 
              
	    }	
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
	
	
        //Add Order Details
        public function addorder_details(array $orderfields)
        {
		if($orderfields['product_id']!='')
			{
				$getproductdetails=$this->getproductdetails($orderfields['product_id']);
				$shippingfee=$getproductdetails[0]['shipping_fee'];
				//$shippingfee='';
			}
		
		
                $ordercolumn = array('order_no','product_id','buyer_id','seller_id','order_status','action','product_cost','shippingfee',
				     'product_commission_amount','order_total',
                'order_subtotal', 'order_currency_code','paid_status','maximum_date_complete','transaction_details_id','order_date'
                );
                $ordervalues = array($orderfields['order_no'],$orderfields['product_id'],$orderfields['buyer_id'],$orderfields['seller_id'],
				     $orderfields['order_status'],$orderfields['action'],$orderfields['product_cost'],$shippingfee,
				     $orderfields['product_commission_amount'],$orderfields['order_total'],$orderfields['order_subtotal'],$orderfields['order_currency_code'],$orderfields['paid_status'],$orderfields['maximum_date_complete'],$orderfields['transaction_details_id'],$this->getCurrentTimeStamp());
                
                $result = DB::insert(BUY_PRODUCTS, $ordercolumn)
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

	//User Message 
	//Insert to user message table 
	public function user_message_packages($select_email,$from,$subject,$message,$sent_date)
	{
			$result   = DB::insert(USER_MESSAGE,array('usermessage_to', 'usermessage_from', 'usermessage_subject','usermessage_message','sent_date'))
				->values(array($select_email,$from,$subject,$message,$sent_date))
				->execute();
				return $result;
			
	}

	//Add to cart details
	
	 // Add Transaction Log Details
	public function addtocart_details($addtocart_details)
        {
	//print_r($addtocart_details);exit;
		
		$result = DB::select()->from(BUYNOW_ADDTOCART)
			->where('productid', '=',$addtocart_details['productid'])
			->and_where('userid', '=',$addtocart_details['userid'])
                        ->execute()
                        ->as_array();			
		
		if(count($result)){
			 $total_amt =$result[0]['amount']+$addtocart_details['amount'];
			 $total_qty=$result[0]['quantity']+1;
			
			$result = DB::update(BUYNOW_ADDTOCART)->set(array('amount'=>$addtocart_details['amount'],
									  'shipping_fee'=>$addtocart_details['shipping_fee'],
									  'total_amt'=>$total_amt,'quantity'=>$total_qty,
									  'add_date'=>$this->getCurrentTimeStamp()))->where('productid', '=',$addtocart_details['productid'])->and_where('userid', '=',$addtocart_details['userid'])
			->execute(); 
			
		  }else{	
		$quantity =1;
                $addtocartfields = array('userid','productid','product_name','product_image','amount','shipping_fee','total_amt','quantity','add_date','product_cost');
                $addtocartvalues = array($addtocart_details['userid'],$addtocart_details['productid'],$addtocart_details['product_name'],$addtocart_details['product_image'],$addtocart_details['amount'],$addtocart_details['shipping_fee'],$addtocart_details['amount'],$quantity,$this->getCurrentTimeStamp(),$addtocart_details['product_cost']);
                $result = DB::insert(BUYNOW_ADDTOCART, $addtocartfields )
			->values($addtocartvalues)
			->execute();
		return $result; 
	       }	
        }
       
	//Delete 
	public function order_delete($transactionlog_details_buyer,$producttotalcoutid,$uid)
	{	
		//print_r($transactionlog_details_buyer);exit;	
		for($i=0;$i<=$producttotalcoutid;$i++){
	
		$result   = DB::delete(BUYNOW_ADDTOCART)					
			->where('productid', 'IN', $transactionlog_details_buyer['productid'])
			->and_where('userid', '=', $uid)
			->execute();
		}
	}
	
	//Delete 
	public function order_delete_offline($transactionlog_details_buyer,$uid)
	{	
	
		$result   = DB::delete(BUYNOW_ADDTOCART)					
			->where('productid', '=',$transactionlog_details_buyer['productid'])
			->and_where('userid', '=', $uid)
			->execute();
		
	}
	
	/**** added By venkatraja in 15-Mar-2013****/
	
	public function gettransactionlogdetails($invoiceno)
	{
		  $rs = DB::select()->from(PAYPAL_TRANSACTION_DETAILS)
					->where('INVOICEID','=',$invoiceno)
				        ->execute()
				        ->as_array();
		return $rs;			
		
		
	}
	
	
	/**
        * ****show_payment_log_content()****
        *@return show normal payment transaction log
        */	
	public function show_payment_log_content($invoiceno)
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
						PTD.RECEIPTID,
						U.created_date,
						PTD.PAYMENTTYPE,
						PTD.ORDERTIME,
						PTD.CURRENCYCODE,
						PTD.PAYMENTSTATUS,
						PTD.PENDINGREASON,
						PTD.REASONCODE,
						PTD.INVOICEID,
						PTD.LOGIN_ID,P.shipping_fee
						FROM ".PAYPAL_TRANSACTION_DETAILS." AS PTD
						LEFT JOIN ".USERS." AS U ON ( U.id = PTD.USERID )					
						LEFT JOIN ".PRODUCTS." AS P ON(P.product_id = PTD.PACKAGEID)							
						WHERE PTD.INVOICEID = '$invoiceno' ";	
						
  
		$result = Db::query(Database::SELECT, $query)
		    	  ->execute()
		    	  ->as_array();

		return $result;	  
	}
	
	
	/**** Added End By Venkatraja in 15-Mar-2013 *****/
	
	
	

}
?>
