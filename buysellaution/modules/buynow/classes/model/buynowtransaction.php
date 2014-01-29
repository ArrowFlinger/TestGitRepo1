<?php defined('SYSPATH') or die('No direct script access.');

/*
* Contains Transaction module details

* @Created on March, 2012

* @Updated on March, 2012

* @Package: Auction Script v1.1

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Buynowtransaction extends Model
{

         /**To Get Current TimeStamp**/
	
	public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}

        
	
	//Buy Now Auction 
	/**
        * ****count_buynow_transaction_list()****
        * @return transaction list count of array 
        */
	public function count_buynow_transaction_list()
	{
	
	         $rs = DB::select()->from(BUYNOW_TRANSACTION_DETAILS)
				        ->execute()
				        ->as_array();	           
	         return count($rs);
	}
	
	 /**
        * ****buynow_transaction_list()****
        *@param $offset int, $val int
        *@return alltransaction list count of array 
        */
	public function buynow_transaction_list($offset, $val)
	{
            		       
	        $query  ="SELECT  TD.transaction_date,
			    TD.id as transid,
			    PO.order_no,
		            U.username,U.photo,U.id,
			    TD.description,
			    TD.amount,TD.quantity,TD.shippingamount,					
			    TD.amount_type,TD.payment_type
			    FROM ".BUYNOW_TRANSACTION_DETAILS." AS TD		       		 
	                    LEFT JOIN ".BUY_PRODUCTS." AS PO ON (PO.order_date = TD.transaction_date)
	 		    LEFT JOIN ".USERS." AS U ON(U.id = TD.userid)
			    ORDER BY transaction_date DESC LIMIT $offset,$val ";

	    $result = Db::query(Database::SELECT, $query)
			    ->execute()
			    ->as_array();
            return $result;	
	}

	/**
        * ****get_buynow_transaction_search_list()***
        *@param 
        *@return search result string
        */
        public function get_buynow_transaction_search_list($username_search = "", $order_search = "",$start_date="",$end_date="")
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
                $start_date_where = (($start_date) && ($end_date == "")) ? " AND TD.transaction_date > '$start_date' ":""; 
                //if to date only selected means
                $end_date_where = (($end_date) && ($start_date == "")) ? " AND TD.transaction_date < '$end_date' ":"";
                
                //condition for both start and end date selected
			$start_time = START_TIME;
			$end_time = END_TIME; 
			$date_range_where = (($start_date) && ($end_date)) ? " AND TD.transaction_date BETWEEN '$start_date"." "."$start_time' AND '$end_date"." "."$end_time' ":"";
				
                 //condition for username name
                $name_where= ($username_search) ? " AND  TD.userid = '$username_search'" : "";
              
		//condition for package order search
		$package_order_where= ($order_search) ? " AND  PO.order_no LIKE '%$order_search%'" : "";	
    
                $query  ="SELECT TD.transaction_date,
			    TD.id as transid,TD.payment_type,
			    PO.order_no,
		            U.username,U.photo,U.id,
			    TD.description,
			    TD.amount,TD.quantity,TD.shippingamount,					
			    TD.amount_type
			    FROM ".BUYNOW_TRANSACTION_DETAILS." AS TD		       		 
	                    LEFT JOIN ".BUY_PRODUCTS." AS PO ON (PO.order_date = TD.transaction_date)

	 		    LEFT JOIN ".USERS." AS U ON(U.id = TD.userid)
				 		    WHERE 1=1 $date_range_where $start_date_where $end_date_where $name_where $package_order_where order by TD.transaction_date DESC ";
                                                                       
	 		$results = Db::query(Database::SELECT, $query)
			   			 ->execute()
						 ->as_array();
							 
			return $results;
        }

	 /**
        * ****count_all_payment_transaction_list()****
        *
        * @return count  
        */
	public function count_all_payment_transaction_list()
	{
	
	 $rs = DB::select()->from(PAYPAL_BUYNOW_DETAILS)
				->execute()
				->as_array();
	 return count($rs);
	}

	 /**
        * ****all_payment_transaction_list()****
        **param offset int,$val int
        *@return all payment transactions list 
        */	
	public function all_payment_transaction_list($offset,$val)
	{

		//query to display all payment transactions list 
		$query = " SELECT U.username AS username,PTD.ID,
						PTD.REASONCODE,PTD.PAYERSTATUS,PTD.PAYMENTSTATUS,
						PTD.FEEAMT,PTD.AMT,PTD.PRODUCTID,
						PTD.EMAIL,PTD.TRANSACTIONID,
						PTD.TIMESTAMP,PTD.LOGIN_ID,
						PTD.PAYERID	
						FROM ".PAYPAL_BUYNOW_DETAILS." AS PTD
						LEFT JOIN ".USERS." AS U ON ( U.id = PTD.USERID )
						ORDER BY PTD.TIMESTAMP DESC LIMIT $offset,$val ";
		$result = Db::query(Database::SELECT, $query)
		    	  ->execute()
		    	  ->as_array();

		return $result;			
		
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
						PTD.PRODUCTID,
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
        * ****all_transaction_username_list()****
        *@param $offset int, $val int
        *@return transaction  username count of array 
        */
	public function all_transaction_username_list()
	{
                $rs   = DB::select('username','id')
                        ->distinct(TRUE)
                        ->from(USERS)
                        ->where(USERS.'.status', '=', ACTIVE)
                        ->where(USERS.'.username', '!=', " ")
                        ->order_by('username','ASC')
                        ->execute()	
                        ->as_array();

                return $rs;

	}
	
	
}
?>
