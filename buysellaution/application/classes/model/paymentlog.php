<?php defined('SYSPATH') or die('No direct script access.');

/*

* Contains Payment Log details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Paymentlog extends Model
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
		$this->admin_session_id = $this->session->get("id");
	}
	
        /**
        * ****count_all_payment_transaction_list()****
        *
        * @return count  
        */
	public function count_all_payment_transaction_list()
	{
	
	 $rs = DB::select()->from(PAYPAL_TRANSACTION_DETAILS)
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
						PTD.FEEAMT,PTD.AMT,
						PTD.EMAIL,PTD.TRANSACTIONID,
						PTD.TIMESTAMP,PTD.LOGIN_ID,
						PTD.PAYERID,PTD.SHIPPINGAMT
						FROM ".PAYPAL_TRANSACTION_DETAILS." AS PTD
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
						FROM ".PAYPAL_TRANSACTION_DETAILS." AS PTD
						LEFT JOIN ".USERS." AS U ON ( U.id = PTD.USERID )
						WHERE PTD.TIMESTAMP = '$page_id' ";	
						
  
		$result = Db::query(Database::SELECT, $query)
		    	  ->execute()
		    	  ->as_array();

		return $result;	  
	}
	
        /**
        * ****count_all_mass_payment_transaction_list()****
        *
        * @return count  
        */
	public function count_all_mass_payment_transaction_list()
	{
	
	 $rs = DB::select()->from(WITHDRAW_TRANSACTION_DETAILS)
				->execute()
				->as_array();	

	 return count($rs);
	}	
	
        /**
        * ****all_mass_payment_transaction_list()****
        **param offset int,$val int
        *@return all payment transactions list 
        */	
	public function all_mass_payment_transaction_list($offset,$val)
	{

		//query to display all mass payment transactions list 
		$query = " SELECT U.username AS username,WTD.withdraw_trans_id,
						WTD.unique_id,WTD.masscapturetime,
						WTD.login_id,WTD.currencycode, 
						WTD.payer_email,WTD.errorcode,
						WTD.amount,WD.withdraw_status,
						WTD.payment_response,WTD.ack FROM ".WITHDRAW_TRANSACTION_DETAILS." AS WTD
						LEFT JOIN ".WITHDRAW_DETAILS." AS WD ON (WD.unique_id = WTD.unique_id)
						LEFT JOIN ".USERS." AS U ON (U.id = WD.user_id)
						ORDER BY WTD.masscapturetime DESC LIMIT $offset,$val ";	
						
  
		$result = Db::query(Database::SELECT, $query)
		    	  ->execute()
		    	  ->as_array();

		return $result;			
		
		}
		
        /**
        * ****show_mass_payment_log_content()****
        *@return show mass payment transaction log
        */	
	public function show_mass_payment_log_content($page_id)
	{
		//query to display all payment transactions list 
		$query = " SELECT U.username AS username,WTD.withdraw_trans_id,
						WTD.unique_id,WTD.masscapturetime,WTD.timestamp,
						WTD.withdraw_trans_id,WTD.receiver_email,
						WTD.login_id,WTD.currencycode,
						WTD.short_message,WTD.payment_response,
						WTD.long_message,WTD.correlationid,
						WTD.version,WTD.build,WTD.severitycode,
						WTD.payer_email,WTD.errorcode,
						WTD.amount,WD.withdraw_status,
						WTD.ack FROM ".WITHDRAW_TRANSACTION_DETAILS." AS WTD
						LEFT JOIN ".WITHDRAW_DETAILS." AS WD ON (WD.unique_id = WTD.unique_id)
						LEFT JOIN ".USERS." AS U ON (U.id = WD.user_id)					
						WHERE WTD.unique_id = '$page_id' ";	
						
  
		$result = Db::query(Database::SELECT, $query)
		    	  ->execute()
		    	  ->as_array();

		return $result;	  
	}	

		
}
