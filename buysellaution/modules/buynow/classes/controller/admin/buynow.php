<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Beginner Controller
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 *
 * @package    Package: Nauction Platinum Version 1.0
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 * @Created on October 24, 2012
 * @Updated on October 24, 2012
 */
class Controller_Admin_Buynow extends Controller_Welcome {	
	
	protected $_buynow;	
	
	public function __construct(Request $request, Response $response)
	{
		$this->_buynow = new Buynow;
		parent::__construct($request,$response);
		$this->buynow_transaction=Model::factory('buynowtransaction');
	}
    
	

	//Buy Now Auction
	/**
        * ****action_index()****
        * @return transaction details view with pagination
        */
	public function action_buynow()
	{
		//auth login check
		$this->is_login(); 
		//set page title
		$this->page_title =   __('page_title_transaction_buynow');
		$this->selected_page_title = __('page_title_transaction_buynow');
		$this->selected_controller_title =__('buynow_page_title_transaction');
		$count_transaction_list_buynow = $this->buynow_transaction->count_buynow_transaction_list();		
	        //pagination loads here	
		$page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_transaction_list_buynow,
                'view' => 'pagination/punbb',			  
                )); 
		$buynow_transaction_list = $this->buynow_transaction->buynow_transaction_list($offset, ADM_PER_PAGE);
		$all_username_list = $this->buynow_transaction->all_transaction_username_list();
		//*pagination ends here
		//send data to view file 
		$view = View::factory('admin/buynow_transaction_details')
                                ->bind('title',$title)
                                ->bind('buynow_transaction_list',$buynow_transaction_list)
                                ->bind('all_username',$all_username_list)
                                ->bind('srch',$_POST)
                                ->bind('pag_data',$pag_data)
                                ->bind('offset',$offset);
		$this->template->content = $view;
	}

	/**

	 * ****action_transaction_search()****
	 * @param 
	 * @return search transaction list
	 */	
	public function action_buynow_transaction_search()
	{
                //auth login check
                $this->is_login(); 
		//set page title
		$this->page_title = __('page_title_transaction_buynow');
		$this->selected_page_title = __('page_title_transaction_buynow');
		$this->selected_controller_title =__('buynow_page_title_transaction');
		//default empty list and offset
		$search_list = '';
		$offset = '';
		//Find page action in view
		$action = $this->request->action();		
		//get form submit request
		$search_post = arr::get($_REQUEST,'search_transaction');   
		//Post results for search 
                if(isset($search_post)){          
                $buynow_transaction_list = $this->buynow_transaction->get_buynow_transaction_search_list($_POST['username_search'],																				trim(Html::chars($_POST['order_search'])),$_POST['fromdate'],$_POST['todate']);
			//splitting created_date to display proper format
			
			$i=0;
			foreach($buynow_transaction_list as $transaction_list)
			{
				$all_transaction_list[$i]['transaction_date'] = $this->DisplayDateTimeFormat($transaction_list["transaction_date"]);
				$all_transaction_list[$i]['description'] = $transaction_list["description"];
				$all_transaction_list[$i]['username'] = $transaction_list["username"];
				$all_transaction_list[$i]['amount'] = $transaction_list["amount"];
				$all_transaction_list[$i]['payment_type'] = $transaction_list["payment_type"];
				$all_transaction_list[$i]['order_no'] = $transaction_list["order_no"];			
				$all_transaction_list[$i]['amount_type'] = $transaction_list["amount_type"];	
				$all_transaction_list[$i]['transid']=$transaction_list["transid"];	
				$all_transaction_list[$i]['photo']= $transaction_list["photo"];			
				$i++;
			}
		}
		//get all username list in drop down
		$all_username_list = $this->buynow_transaction->all_transaction_username_list();	
		//send data to view file 
		$view = View::factory('admin/buynow_transaction_details')
                                        ->bind('buynow_transaction_list',$buynow_transaction_list)
                                        ->bind('all_username',$all_username_list)
                                        ->bind('srch',$_POST)
                                        ->bind('offset',$offset);
		$this->template->content = $view;	
	}
   
	/**
	 * ****action_payment_transaction_log()****
	 * @return payment_transaction_log with pagination
	 */
	public function action_payment_transaction_log()
	{
                        //set page title
                        $this->page_title = __('buynow_page_payment_log');
                        $this->selected_page_title = __('buynow_page_payment_log');
                        $this->selected_controller_title =__('buynow_page_title_transaction');
                        //pagination loads here
                      $count_payment_transaction_log = $this->buynow_transaction->count_all_payment_transaction_list();
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
                                $all_payment_transaction_log = $this->buynow_transaction->all_payment_transaction_list($offset, ADM_PER_PAGE);
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
                                                $all_payment_transaction_log[$i]['EMAIL'] = $payment_transaction_log["EMAIL"];												
                                                $all_payment_transaction_log[$i]['TRANSACTIONID']	= 	$payment_transaction_log["TRANSACTIONID"];	
                                                $all_payment_transaction_log[$i]['LOGIN_ID']	= 	$payment_transaction_log["LOGIN_ID"];	
                                                $all_payment_transaction_log[$i]['PAYERID']	= 	$payment_transaction_log["PAYERID"];	
                                                $all_payment_transaction_log[$i]['username']	= 	$payment_transaction_log["username"];							
                                                $i++;
		                }
                                //send data to view file 
                                $view = View::factory('admin/buynow_payment_transaction_log')
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
                $this->selected_page_title = __('buynow_page_payment_log');
                $this->page_title = __('buynow_page_payment_log'); 
                $this->selected_controller_title =__('buynow_page_title_transaction');
                //get current page segment id 
                $page_id = $this->request->param('id');
                
                //send data to view file 
                $page_data = $this->buynow_transaction->show_payment_log_content($page_id);
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
			                $page_data['SHIPPINGAMT'] = $payment_log["SHIPPINGAMT"];			                
		                }    	
                        $view = View::factory('admin/buynow_show_normal_payment_transaction')
                                ->bind('action',$action)
                                ->bind('page_data',$page_data);
                        $this->template->content = $view;
	}
   
    
} // End Welcome
