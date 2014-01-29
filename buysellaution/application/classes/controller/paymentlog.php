<?php defined('SYSPATH') or die('No direct script access.');

/*

* Contains Payment Log details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Paymentlog extends Controller_Welcome 
{


	/**
	 * ****action_payment_transaction_log()****
	 * @return payment_transaction_log with pagination
	 */
	public function action_payment_transaction_log()
	{
                        //set page title
                        $this->page_title = __('page_payment_log');
                        $this->selected_page_title = __('page_payment_log');
                        $this->selected_controller_title =__('page_title_transaction');
                        //pagination loads here
                        $count_payment_transaction_log = $this->payment_log->count_all_payment_transaction_list();
                        $page_no= isset($_GET['page'])?$_GET['page']:0;
                                if($page_no==0 || $page_no=='index')
                                $page_no = PAGE_NO;
                                $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                                $pag_data = Pagination::factory(array (
                                'current_page'   => array('source' => 'query_string','key' => 'page'),
                                'items_per_page' => ADM_PER_PAGE,
                                'total_items'    => $count_payment_transaction_log,
                                'view' => 'pagination/punbb',			  
                                ));
                                $all_payment_transaction_log = $this->payment_log->all_payment_transaction_list($offset, ADM_PER_PAGE);
                                
                                //pagination ends here
                                //splitting created_date to display proper format
                                $i=0;
                                
                                foreach($all_payment_transaction_log as $payment_transaction_log)
                                {
                                             
                                           
                                                $all_payment_transaction_log[$i]['TIMESTAMP']=$payment_transaction_log["TIMESTAMP"];     
                                                $all_payment_transaction_log[$i]['ID'] = $payment_transaction_log["ID"];
                                                $all_payment_transaction_log[$i]['REASONCODE'] = $payment_transaction_log["REASONCODE"];
                                                $all_payment_transaction_log[$i]['PAYERSTATUS'] = $payment_transaction_log["PAYERSTATUS"];
                                                $all_payment_transaction_log[$i]['PAYMENTSTATUS'] = $payment_transaction_log["PAYMENTSTATUS"];
                                                $all_payment_transaction_log[$i]['FEEAMT'] = $payment_transaction_log["FEEAMT"];
                                                $all_payment_transaction_log[$i]['AMT'] = $payment_transaction_log["AMT"];
                                                $all_payment_transaction_log[$i]['SHIPPINGAMT'] = $payment_transaction_log["SHIPPINGAMT"];
                                                $all_payment_transaction_log[$i]['EMAIL'] = $payment_transaction_log["EMAIL"];												
                                                $all_payment_transaction_log[$i]['TRANSACTIONID']	= 	$payment_transaction_log["TRANSACTIONID"];	
                                                $all_payment_transaction_log[$i]['LOGIN_ID']	= 	$payment_transaction_log["LOGIN_ID"];	
                                                $all_payment_transaction_log[$i]['PAYERID']	= 	$payment_transaction_log["PAYERID"];	
                                                $all_payment_transaction_log[$i]['username']	= 	$payment_transaction_log["username"];							
                                                $i++;
		                }
                                //send data to view file 
                                $view = View::factory('admin/payment_transaction_log')
                                        ->bind('all_payment_transaction_log',$all_payment_transaction_log)
                                        ->bind('pag_data',$pag_data)
                                        ->bind('offset',$offset);
                                $this->template->content = $view;

		}
		
	/**
	 * ****show_payment_log()****
	 * show payment log
	 */	
	public function action_show_payment_log()
	{
                //page title
                $this->selected_page_title = __('page_payment_log');
                $this->page_title = __('page_payment_log'); 
                $this->selected_controller_title =__('page_title_transaction');
                //get current page segment id 
                $page_id = $this->request->param('id');
                
                //send data to view file 
                $page_data = $this->payment_log->show_payment_log_content($page_id);
                //splitting created_date to display proper format
		                foreach($page_data as $payment_log)
		                {
			                $page_data['TIMESTAMP'] = $this->DisplayDateTimeFormat($payment_log["TIMESTAMP"]);
			                $page_data['created_date'] = $this->DisplayDateTimeFormat($payment_log["created_date"]);
			                $page_data['ID'] = $payment_log["ID"];
			                $page_data['REASONCODE'] = $payment_log["REASONCODE"];
			                $page_data['PAYERSTATUS'] = $payment_log["PAYERSTATUS"];
			                $page_data['PAYMENTSTATUS'] = $payment_log["PAYMENTSTATUS"];
			                $page_data['FEEAMT'] = $payment_log["FEEAMT"];
			                $page_data['AMT'] = $payment_log["AMT"];			               
			                $page_data['SHIPPINGAMT'] = $payment_log["SHIPPINGAMT"];
			                $page_data['EMAIL'] = $payment_log["EMAIL"];
			                $page_data['TRANSACTIONID']	= 	$payment_log["TRANSACTIONID"];	
			                $page_data['LOGIN_ID']	= 	$payment_log["LOGIN_ID"];	
			                $page_data['PAYERID']	= 	$payment_log["PAYERID"];	
			                $page_data['username']	= 	$payment_log["username"];	
			                $page_data['COUNTRYCODE'] = $payment_log["COUNTRYCODE"];
			                $page_data['RECEIVER_EMAIL']	= 	$payment_log["RECEIVER_EMAIL"];	
			                $page_data['CORRELATIONID']	= 	$payment_log["CORRELATIONID"];	
			                $page_data['ACK']	= 	$payment_log["ACK"];	
			                $page_data['REASONCODE']	= 	$payment_log["REASONCODE"];
			                $page_data['TRANSACTIONTYPE'] = $payment_log["TRANSACTIONTYPE"];
			                $page_data['RECEIPTID']	= 	$payment_log["RECEIPTID"];	
			                $page_data['ORDERTIME']	= 	$this->DisplayDateTimeFormat($payment_log["ORDERTIME"]);	
			                $page_data['CURRENCYCODE']	= 	$payment_log["CURRENCYCODE"];		
			                $page_data['PENDINGREASON'] = $payment_log["PENDINGREASON"];												
			                $page_data['INVOICEID']	= 	$payment_log["INVOICEID"];	
			                $page_data['PAYMENTTYPE']	= 	$payment_log["PAYMENTTYPE"];
		                }    	
                        $view = View::factory('admin/show_normal_payment_transaction')
                                ->bind('action',$action)
                                ->bind('page_data',$page_data);
                        $this->template->content = $view;
	}

	/**
	 * ****action_mass_payment_transaction_log()****
	 * @return payment_transaction_log with pagination
	 */
	public function action_mass_payment_transaction_log()
	{
	                //set page title
                        $this->page_title = __('page_mass_payment_log');
                        $this->selected_page_title = __('page_mass_payment_log');
                        $this->selected_controller_title =__('page_title_transaction');
                        //pagination loads here
                        $count_mass_payment_transaction_log = $this->payment_log->count_all_mass_payment_transaction_list();
                        $page_no= isset($_GET['page'])?$_GET['page']:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                        $pag_data = Pagination::factory(array (
                        'current_page'   => array('source' => 'query_string','key' => 'page'),
                        'items_per_page' => ADM_PER_PAGE,
                        'total_items'    => $count_mass_payment_transaction_log,
                        'view' => 'pagination/punbb',			  
                        ));
                        $all_payment_transaction_log = $this->payment_log->all_mass_payment_transaction_list($offset, ADM_PER_PAGE);
                        //pagination ends here
                        //splitting created_date to display proper format
                        $i=0;
                                        foreach($all_payment_transaction_log as $payment_transaction_log)
                                        {

                                                $all_payment_transaction_log[$i]['masscapturetime'] = $this->DisplayDateTimeFormat($payment_transaction_log["masscapturetime"]);
                                                $all_payment_transaction_log[$i]['withdraw_trans_id'] = $payment_transaction_log["withdraw_trans_id"];
                                                $all_payment_transaction_log[$i]['errorcode'] = $payment_transaction_log["errorcode"];
                                                $all_payment_transaction_log[$i]['currencycode'] = $payment_transaction_log["currencycode"];
                                                $all_payment_transaction_log[$i]['amount'] = $payment_transaction_log["amount"];
                                                $all_payment_transaction_log[$i]['login_id']	= 	$payment_transaction_log["login_id"];	
                                                $all_payment_transaction_log[$i]['unique_id']	= 	$payment_transaction_log["unique_id"];	
                                                $all_payment_transaction_log[$i]['username']	= 	$payment_transaction_log["username"];
                                                $all_payment_transaction_log[$i]['payer_email']	= 	$payment_transaction_log["payer_email"];
                                                $all_payment_transaction_log[$i]['withdraw_status']	= 	$payment_transaction_log["withdraw_status"];
                                                $all_payment_transaction_log[$i]['ack']	= 	$payment_transaction_log["ack"];						
                                                $i++;
                                                }
                        //send data to view file 
                        $view = View::factory('admin/mass_payment_transaction_log')
                                ->bind('all_payment_transaction_log',$all_payment_transaction_log)
                                ->bind('pag_data',$pag_data)
                                ->bind('offset',$offset);
                        $this->template->content = $view;
        }
		
	/**
	 * ****show_mass_payment_log()****
	 * show payment log
	 */	
        public function action_show_mass_payment_log()
        {
                //page title
                $this->selected_page_title = __("page_mass_payment_log");
                $this->page_title = __("page_mass_payment_log"); 
                $this->selected_controller_title =__('page_title_transaction');
                //get current page segment id 
                $page_id = $this->request->param('id');
                //send data to view file 
                $page_data = $this->payment_log->show_mass_payment_log_content($page_id);
                //splitting created_date to display proper format
                                foreach($page_data as $payment_log)
                                {
                                        $page_data['masscapturetime'] = $this->DisplayDateTimeFormat($payment_log["masscapturetime"]);
                                        $page_data['timestamp'] = $this->DisplayDateTimeFormat($payment_log["timestamp"]);
                                        $page_data['unique_id'] = $payment_log["unique_id"];
                                        $page_data['withdraw_trans_id'] = $payment_log["withdraw_trans_id"];
                                        $page_data['withdraw_status'] = $payment_log["withdraw_status"];
                                        $page_data['errorcode'] = $payment_log["errorcode"];
                                        $page_data['amount'] = $payment_log["amount"];
                                        $page_data['payer_email'] = $payment_log["payer_email"];	
                                        $page_data['short_message']	= 	$payment_log["short_message"];	
                                        $page_data['login_id']	= 	$payment_log["login_id"];	
                                        $page_data['long_message']	= 	$payment_log["long_message"];	
                                        $page_data['username']	= 	$payment_log["username"];
                                        $page_data['currencycode']	= 	$payment_log["currencycode"];
                                        $page_data['version'] = $payment_log["version"];	
                                        $page_data['receiver_email']	= 	$payment_log["receiver_email"];	
                                        $page_data['correlationid']	= 	$payment_log["correlationid"];	
                                        $page_data['ack']	= 	$payment_log["ack"];	
                                        $page_data['build']	= 	$payment_log["build"];
                                        $page_data['severitycode'] = $payment_log["severitycode"];
                                        $page_data['payment_response'] = $payment_log["payment_response"];
                                        }    	
                $view = View::factory('admin/show_mass_payment_transaction')
                        ->bind('action',$action)
                        ->bind('page_data',$page_data);
                $this->template->content = $view;	
		
	}
		
}
