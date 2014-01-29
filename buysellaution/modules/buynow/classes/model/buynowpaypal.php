<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Contains Payment Module details

* @Created on Feb, 2012

* @Updated on Feb, 2012

* @Package: Auction  v1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in
 */

class Model_Buynowpaypal extends Model
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
			     
			 /*    
			
			if($query2[0]['typename']=='pennyauction'){
	
				$query= DB::select(PENNYAUCTION.'.product_id',PENNYAUCTION.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.product_image',
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
					   PRODUCTS.'.product_image',	
					   BUYNOW_ADDTOCART.'.quantity',					   	
					   PRODUCTS.'.shipping_fee')->from(BEGINNER)
				     ->where(BEGINNER.'.product_id','=',$product_id)
				     ->join(PRODUCTS,'left')
				     ->on(BEGINNER.'.product_id','=',PRODUCTS.'.product_id')
				     ->join(BUYNOW_ADDTOCART,'left')
				     ->on(BUYNOW_ADDTOCART.'.productid','=',BEGINNER.'.product_id')	
				     ->execute()	
				     ->as_array(); 
				     return $query;

			}else{
				$query= DB::select(PEAK_AUCTION.'.product_id',PEAK_AUCTION.'.product_cost',
					   PRODUCTS.'.product_name',
					   PRODUCTS.'.product_image',	
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
			
			
                $transactionlogfields = array('userid','orderid','productid','amount','quantity','shippingamount','amount_type','description','transaction_date');
                $transactionlogvalues = array($transactionlog['userid'],$transactionlog['order_no'],$transactionlog['productid'][$i],
					      $transactionlog['amount'.$i],$transactionlog['quantity'][$i],$shippingfee,
                $transactionlog['amount_type'],$transactionlog['description'][$i],$this->getCurrentTimeStamp());

                $result = DB::insert(BUYNOW_TRANSACTION_DETAILS, $transactionlogfields )
			->values($transactionlogvalues)
			->execute();
		}
		return $result; 
        }

	 // Add Transaction Log Details
	public function addtransactionlog_details_offline($transactionlog)
        {	
                $transactionlogfields = array('userid','orderid','productid','amount','quantity','shippingamount','amount_type','description','transaction_date');
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
		
		for($i=0;$i<=$producttotalcoutid;$i++){
			if($transactionfields['PRODUCTID'][$i]!='')
			{
				
				$getproductdetails=$this->getproductdetails($transactionfields['PRODUCTID'][$i]);
				
			 	$shippingfee=$getproductdetails[0]['shipping_fee'];
			}
			$paypalpaidstatus='Completed';
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
					   $paypalpaidstatus,$transactionfields['PENDINGREASON'],$transactionfields['REASONCODE'],
					   $transactionfields['INVOICEID'],$transactionfields['LOGIN_ID'],$transactionfields['USER_AGENT'],
					   $this->getCurrentTimeStamp());
         	
                $result = DB::insert(PAYPAL_BUYNOW_DETAILS, $transactioncolumn)
			->values($transactionvalues)
			->execute(); 
              
	    }	
		return $result;   
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

}
?>
