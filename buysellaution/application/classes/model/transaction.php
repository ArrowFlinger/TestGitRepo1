<?php defined('SYSPATH') or die('No direct script access.');

/*
* Contains Transaction module details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Transaction extends Model
{

         /**To Get Current TimeStamp**/
	
	public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}

        /**
        * ****count_transaction_list()****
        * @return transaction list count of array 
        */
	public function count_transaction_list()
	{
	
	         $rs = DB::select()->from(TRANSACTION_DETAILS)
				        ->execute()
				        ->as_array();	           
	         return count($rs);
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
	
       /**
        * ****all_transaction_list()****
        *@param $offset int, $val int
        *@return alltransaction list count of array 
        */
	public function all_transaction_list($offset, $val)
	{
            		       
	        $query  ="SELECT  TD.transaction_date,
			    TD.id as transid,
			 
		            U.username,U.photo,U.id,
			    TD.description,
			    TD.amount,TD.shippingamount,TD.transaction_type,				
			    TD.amount_type
			    FROM ".TRANSACTION_DETAILS." AS TD		       		 
	                   
	 		    LEFT JOIN ".USERS." AS U ON(U.id = TD.userid)
			    ORDER BY transaction_date DESC LIMIT $offset,$val ";

	    $result = Db::query(Database::SELECT, $query)
			    ->execute()
			    ->as_array();
            return $result;	
	}


	

        /**
        * ****get_all_transaction_search_list()***
        *@param 
        *@return search result string
        */
        public function get_all_transaction_search_list($username_search = "", $order_search = "",$start_date="",$end_date="")
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
			    TD.id as transid,
			    PO.order_no,
				 PO.payment_method,
		            U.username,U.photo,U.id,
			    TD.description,
                            TD.shippingamount,  
                         TD.transaction_type,  
			    TD.amount,					
			    TD.amount_type
			    FROM ".TRANSACTION_DETAILS." AS TD		       		 
	                    LEFT JOIN ".PACKAGE_ORDERS." AS PO ON (PO.order_date = TD.transaction_date)
	 		    LEFT JOIN ".USERS." AS U ON(U.id = TD.userid)
				 		    WHERE 1=1 $date_range_where $start_date_where $end_date_where $name_where $package_order_where order by TD.transaction_date DESC ";
                                                                       
	 		$results = Db::query(Database::SELECT, $query)
			   			 ->execute()
						 ->as_array();
							 
			return $results;

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
			    TD.amount,					
			    TD.amount_type
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
			    TD.id as transid,
			    PO.order_no,
		            U.username,U.photo,U.id,
			    TD.description,
			    TD.amount,					
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
	
	/*** Venkatraja  added in 15-Mar-2013 ****/
	
	
	public function all_orderhistory($orderid="",$offset="", $val="")
	{
            	/*	       
		$query = DB::select('ptd.*','o.*',array('o.id','orderid'))->from(array(ORDERS,'o'))
					->join(array(PAYPAL_TRANSACTION_DETAILS,'ptd'),'left')
					->on('o.transaction_details_id','=','ptd.id');				
		*/
		$query = DB::select('user.username','user.email',
				    'gateway.payment_gatway','gateway.controller_name','product.product_name',
				    'o.res_order',
				    'o.order_id',
				    'o.bidmethod',
				    'o.payment_type',
				    'o.auction_id',
				    'o.buyer_id',
				    'o.quantity',
				    'o.shippingamount',
				    'o.shipping_status',
				    'o.total',
				    'o.currency_code',
				    'o.order_status',
				    'o.order_date','product.shipping_fee')->from(array(AUCTION_ORDERS,'o'))
				     ->join(array(USERS,'user'),'left')
				     ->on('o.buyer_id','=','user.id')
				     ->join(array(PAYMENT_GATEWAYS,'gateway'),'left')
				     ->on('o.payment_type','=','gateway.paygate_code')
				     ->join(array(PRODUCTS,'product'),'left')
				     ->on('o.auction_id','=','product.product_id');	
					
			if($orderid!="")
					$query->where('o.order_id','=',$orderid);
			if($offset!="" || $val!="")
				$query->offset($offset)->limit($val);
		$result = $query->order_by('o.order_date','DESC')->execute()->as_array();
		return $result;
	}
	
	
	
        /**
        * ****get_all_transaction_search_list()***
        *@param 
        *@return search result string
        */
        public function get_all_order_transaction_search_list($username_search = "", $order_search = "",$start_date="",$end_date="",$filter_type="",$orderfilter="")
        {
        
        $query = DB::select('user.username','user.email',
				    'gateway.payment_gatway','gateway.controller_name','product.product_name',
				    'o.res_order',
				    'o.order_id',
				    'o.bidmethod',
				    'o.payment_type',
				    'o.auction_id',
				    'o.buyer_id',
				    'o.quantity',
				    'o.shippingamount',
				    'o.shipping_status',
				    'o.total',
				    'o.currency_code',
				    'o.order_status',
				    'o.order_date')->from(array(AUCTION_ORDERS,'o'))
				     ->join(array(USERS,'user'),'left')
				     ->on('o.buyer_id','=','user.id')
				     ->join(array(PAYMENT_GATEWAYS,'gateway'),'left')
				     ->on('o.payment_type','=','gateway.paygate_code')
				     ->join(array(PRODUCTS,'product'),'left')
				     ->on('o.auction_id','=','product.product_id');
		if($order_search!="")
				$query->where('o.res_order','=',trim($order_search));
		if($filter_type!="")
				$query->where('o.bidmethod','=',$filter_type);
		if($username_search!="")
				$query->where('o.buyer_id','=',$username_search);
		if($orderfilter!="")
				$query->where('o.order_status','=',$orderfilter);
		if($start_date!="" && $end_date=="")
				$query->where('o.order_date','>=',$start_date);
		else if($start_date=="" && $end_date!="")
				$query->where('o.order_date','<=',$end_date);
		else if($start_date!="" && $end_date!="")
				$query->where('o.order_date','BETWEEN',array($start_date,$end_date));	
		$result = $query->order_by('o.order_date','DESC')->execute()->as_array();
		return $result;	
        }
	
	
	public function orderupdate($orderstatus,$orderno)
	{
		$shippingorderstatus=($orderstatus=='C')?'S':'P';
		$query = " UPDATE ". AUCTION_ORDERS ." SET order_status = '$orderstatus',shipping_status = '$shippingorderstatus'  WHERE order_id = '$orderno' ";
		 //echo $query;exit;	
		 $result = Db::query(Database::DELETE, $query)
		    	  ->execute();
		return $result;
	}
	
	public function orderupdate_paymentstatus($orderstatus,$orderno)
	{
		$st=($orderstatus=='C')?'Completed':'Pending';
		$query = " UPDATE ". PAYPAL_BUYNOW_DETAILS ." SET PAYMENTSTATUS = '$st' WHERE PRODUCTID = '$orderno' ";
		 //echo $query;exit;	
		 $result = Db::query(Database::DELETE, $query)
		    	  ->execute();
		return $result;
	}
	
	
	/*** Venkatraja added end in 15-Mar-2013 ****/
	
	
}
?>
