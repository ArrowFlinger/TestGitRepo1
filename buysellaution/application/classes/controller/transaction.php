<?php defined('SYSPATH') OR die('No Direct Script Access');

/*

* Contains Transaction module details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_transaction extends Controller_Welcome 
{

        /**
        * ****action_index()****
        * @return transaction details view with pagination
        */
	public function action_index()
	{

		//auth login check
		$this->is_login(); 
		//set page title
		$this->page_title =   __('page_title_transaction');
		$this->selected_page_title = __('page_title_transaction');
		$this->selected_controller_title =__('page_title_transaction');
		$count_transaction_list = $this->transaction->count_transaction_list();
		
	        //pagination loads here	
		$page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_transaction_list,
                'view' => 'pagination/punbb',			  
                )); 
		$all_transaction_list = $this->transaction->all_transaction_list($offset, ADM_PER_PAGE);
		
		$all_username_list = $this->transaction->all_transaction_username_list();


	if(isset($_POST['search_transaction'])){
	//set page title
		$this->page_title = __('page_title_transaction');
		$this->selected_page_title = __('page_title_transaction');
		$this->selected_controller_title =__('page_title_transaction');
		$search_list = '';
		$offset = '';
		//Find page action in view
		$action = $this->request->action();		
		//get form submit request
		$search_post = arr::get($_REQUEST,'search_transaction');   
		//Post results for search 
                if(isset($search_post)){          
                $all_transaction_list = $this->transaction->get_all_transaction_search_list($_POST['username_search'],					trim(Html::chars($_POST['order_search'])),$_POST['fromdate'],$_POST['todate']);
			//splitting created_date to display proper format
			
			$i=0;
			foreach($all_transaction_list as $transaction_list)
			{
				$all_transaction_list[$i]['transaction_date'] = $this->DisplayDateTimeFormat($transaction_list["transaction_date"]);
				$all_transaction_list[$i]['description'] = $transaction_list["description"];
				$all_transaction_list[$i]['username'] = $transaction_list["username"];
				$all_transaction_list[$i]['amount'] = $transaction_list["amount"];
				$all_transaction_list[$i]['order_no'] = $transaction_list["order_no"];			
				$all_transaction_list[$i]['amount_type'] = $transaction_list["amount_type"];	
                                $all_transaction_list[$i]['shippingamount'] = $transaction_list["shippingamount"];
                                $all_transaction_list[$i]['transaction_type'] = $transaction_list["transaction_type"];
				$all_transaction_list[$i]['transid']=$transaction_list["transid"];	
				$all_transaction_list[$i]['photo']= $transaction_list["photo"];			
				$i++;
			}
		}
		//get all username list in drop down
		$all_username_list = $this->transaction->all_transaction_username_list();	


	}
		/*
		Transaction details for graph
		starts here
		*/
		$the_date=array();
		for ($i = 0; $i < 30; $i++)
		{
			$timestamp = time();
			$tm = 86400 * $i; // 60 * 60 * 24 = 86400 = 1 day in seconds
			$tm = $timestamp - $tm;
			$the_date[] = date("M/d", $tm);
		}
		
		$month = time();
		for ($i = 1; $i <= 12; $i++) 
		{
			$month = strtotime('last month', $month);
			$months_user[] = date("M/Y", $month);
		}

		//get products for last 30 days
		$last_30days_products =  $this->admin_product->get_last_30days_products();
		//get products count for last 30 days
		$last_1month_products=$this->admin_product->getcount_last_1month_products();
		
		//get products count for last 1 year
		$last_1year_products=$this->admin_product->getcount_last_1year_products();
		//get soldproducts today
		$soldproduct_today = $this->admin_product->sold_products_details_today(''.ACTIVE.'');
		$sum_of_todayprod=$count_of_todayprod=0;
		foreach($soldproduct_today as $today_sp)
		{
			$sum_of_todayprod +=$today_sp['price'];
			$count_of_todayprod +=$today_sp['product_count'];
		}
		
		//get soldproducts for last 7 days
		$soldproduct_last7days = $this->admin_product->sold_products_details_last7days(''.ACTIVE.'');
		$sum_of_last7days=$count_of_last7days=0;
		foreach($soldproduct_last7days as $last7_sp)
		{
			$sum_of_last7days +=$last7_sp['price'];
			$count_of_last7days +=$last7_sp['product_count'];
		}

		//get soldproducts for last 1 month
		$soldproduct_last1month = $this->admin_product->sold_products_details_last1month(''.ACTIVE.'');
		$sum_of_last30days=$count_of_last30days=0;
		foreach($soldproduct_last1month as $last30_sp)
		{
			$sum_of_last30days +=$last30_sp['price'];
			$count_of_last30days +=$last30_sp['product_count'];
		}				
		//get soldproducts for last 1 year
		$soldproduct_last1year= $this->admin_product->sold_products_details_last1year(''.ACTIVE.'');					
		$sum_of_last1year=$count_of_last1year=0;
		foreach($soldproduct_last1year as $last1year_sp)
		{
			$sum_of_last1year +=$last1year_sp['price'];
			$count_of_last1year +=$last1year_sp['product_count'];
		}							
		//get soldproducts for last 10 year
		$soldproduct_last10year= $this->admin_product->sold_products_details_last10year(''.ACTIVE.'');
		$sum_of_last10year=$count_of_last10year=0;
		foreach($soldproduct_last10year as $last10year_sp)
		{
			$sum_of_last10year +=$last10year_sp['price'];
			$count_of_last10year +=$last10year_sp['product_count'];
		}					
		//get all soldproducts
		$soldproduct_all= $this->admin_product->sold_products_details_all(''.ACTIVE.'');
		$sum_of_allproducts=$count_of_allproducts=0;
		foreach($soldproduct_all as $all_sp)
		{
			$sum_of_allproducts +=$all_sp['price'];
			$count_of_allproducts +=$all_sp['product_count'];
		}
		//get count for today products
		$today_products=$this->admin_product->getcount_today_products();				
		$a=array();
		foreach($soldproduct_last1month as $product)
		{
			$create_date=$product['create_date'];
			$a[$create_date]=$product['product_count'];
			$pric_1month[]=$product['price'];		
		}

		foreach($the_date as $dates)
		{
			if(!isset($a[$dates]))
			{
				$a[$dates]=0;
			}
		}              
		//$last_12months_products =  $this->admin_product->get_last_12months_products();					
		$month = time();
		for ($i = 0; $i <= 11; $i++) {
			$month = strtotime("-$i months");
			//$month = strtotime('last month', $month);
			$months[] = date("M/Y", $month);
		}
		
		$b=array();
		foreach($soldproduct_last1year as $mon)
		{
			$create_month=$mon['create_month'];
			$b[$create_month]=$mon['product_count'];	
		}				

		foreach($months as $mo)
		{
			if(!isset($b[$mo]))
			{
				$b[$mo]=0;
			}
		}
		$year_ten = time();
		for ($i = 1; $i <= 10; $i++) 
		{
			$year_ten = strtotime('last year', $year_ten);
			$years_ten[] = date("Y", $year_ten)+1;
		}

		 
		$y=array();
		foreach($soldproduct_last10year as $yea)
		{
			$create_year=$yea['create_year'];
			$y[$create_year]=$yea['product_count'];
		}

		foreach($years_ten as $ye)
		{
			if(!isset($y[$ye]))
			{
				$y[$ye]=0;
			}
		}

		//For Active Product count
		$total_active_products =  $this->admin_product->select_active_product();
		//For InActive Product count
		$total_inactive_products =  $this->admin_product->select_inactive_product();  
		//For Active and Inactive Product count                 
		$total_products=$total_active_products+$total_inactive_products;
		//For today sold products

		/*
		Transaction details for graph
		ends here
		*/		
		$view = View::factory('admin/transaction_details')
                                ->bind('title',$title)
                                ->bind('all_transaction_list',$all_transaction_list)
                                ->bind('all_username',$all_username_list)
                                ->bind('srch',$_POST)
                                ->bind('pag_data',$pag_data)
                                ->bind('offset',$offset)                              
                                ->bind('total_active_products',$total_active_products)
                                ->bind('total_inactive_products',$total_inactive_products)
								->bind('total_live_products',$total_live_products)
								->bind('last_30days_transaction',$last_30days_transaction)	
								->bind('today_products',$today_products)
								->bind('last_7days_products',$last_7days_products) 
								->bind('last_1month_products',$last_1month_products)
								->bind('last_1year_products',$last_1year_products)
								->bind('total_products',$total_products)
								->bind('soldproduct_today',$soldproduct_today)
								->bind('soldproduct_last7days',$soldproduct_last7days)
								->bind('soldproduct_last1month',$soldproduct_last1month)
								->bind('soldproduct_last1year',$soldproduct_last1year)
								->bind('total_soldproducts',$total_soldproducts)
								->bind('soldproduct_all',$soldproduct_all)
								->bind('last_10_years',$years)
								->bind('last_10_years_products',$years_ten)
								->bind('last_10_years_values',$y)											
								->bind('last_30_days',$the_date)
								->bind('last_30_days_values',$a)											
								->bind('last_12_months',$months)
								->bind('last_12_months_user',$months_user)
								->bind('last_12_months_values_user',$b_user)
								->bind('last_12_months_values',$b)
								->bind('total_active_products_details',$total_active_products)
								->bind('total_products_details',$total_products)
								->bind('total_inactive_products_details',$total_inactive_products)
								->bind('sum_of_todayprod',$sum_of_todayprod)
								->bind('count_of_todayprod',$count_of_todayprod)
								->bind('sum_of_last7days',$sum_of_last7days)
								->bind('count_of_last7days',$count_of_last7days)
								->bind('sum_of_last30days',$sum_of_last30days)
								->bind('count_of_last30days',$count_of_last30days)
								->bind('sum_of_last1year',$sum_of_last1year)
								->bind('count_of_last1year',$count_of_last1year)
								->bind('sum_of_last10year',$sum_of_last10year)
								->bind('count_of_last10year',$count_of_last10year)
								->bind('sum_of_allproducts',$sum_of_allproducts)
								->bind('count_of_allproducts',$count_of_allproducts)
								/*******************/
								->bind('all_transaction_list',$all_transaction_list)
                                        ->bind('all_username',$all_username_list)
                                        ->bind('srch',$_POST)
                                        ->bind('offset',$offset);							

		$this->template->content = $view;
	}
	
	/**
	 * ****action_transaction_search()****
	 * @param 
	 * @return search transaction list
	 */	
	/*public function action_transaction_search()
	{
                //auth login check
                $this->is_login(); 
		//set page title
		$this->page_title = __('page_title_transaction');
		$this->selected_page_title = __('page_title_transaction');
		$this->selected_controller_title =__('page_title_transaction');
		//default empty list and offset
		$search_list = '';
		$offset = '';
		//Find page action in view
		$action = $this->request->action();		
		//get form submit request
		$search_post = arr::get($_REQUEST,'search_transaction');   
		//Post results for search 
                if(isset($search_post)){          
                $all_transaction_list = $this->transaction->get_all_transaction_search_list($_POST['username_search'],																				trim(Html::chars($_POST['order_search'])),$_POST['fromdate'],$_POST['todate']);
			//splitting created_date to display proper format
			
			$i=0;
			foreach($all_transaction_list as $transaction_list)
			{
				$all_transaction_list[$i]['transaction_date'] = $this->DisplayDateTimeFormat($transaction_list["transaction_date"]);
				$all_transaction_list[$i]['description'] = $transaction_list["description"];
				$all_transaction_list[$i]['username'] = $transaction_list["username"];
				$all_transaction_list[$i]['amount'] = $transaction_list["amount"];
				$all_transaction_list[$i]['order_no'] = $transaction_list["order_no"];			
				$all_transaction_list[$i]['amount_type'] = $transaction_list["amount_type"];	
				$all_transaction_list[$i]['transid']=$transaction_list["transid"];	
				$all_transaction_list[$i]['photo']= $transaction_list["photo"];			
				$i++;
			}
		}
		//get all username list in drop down
		$all_username_list = $this->transaction->all_transaction_username_list();	
		//send data to view file 
		$view = View::factory('admin/transaction_details')
                                        ->bind('all_transaction_list',$all_transaction_list)
                                        ->bind('all_username',$all_username_list)
                                        ->bind('srch',$_POST)
                                        ->bind('offset',$offset);
		$this->template->content = $view;	
	}*/

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
		$this->selected_controller_title =__('page_title_transaction_buynow');
		$count_transaction_list_buynow = $this->transaction->count_buynow_transaction_list();
		
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
		$buynow_transaction_list = $this->transaction->buynow_transaction_list($offset, ADM_PER_PAGE);
		$all_username_list = $this->transaction->all_transaction_username_list();
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
		$this->selected_controller_title =__('page_title_transaction_buynow');
		//default empty list and offset
		$search_list = '';
		$offset = '';
		//Find page action in view
		$action = $this->request->action();		
		//get form submit request
		$search_post = arr::get($_REQUEST,'search_transaction');   
		//Post results for search 
                if(isset($search_post)){          
                $buynow_transaction_list = $this->transaction->get_buynow_transaction_search_list($_POST['username_search'],																				trim(Html::chars($_POST['order_search'])),$_POST['fromdate'],$_POST['todate']);
			//splitting created_date to display proper format
			
			$i=0;
			foreach($buynow_transaction_list as $transaction_list)
			{
				$all_transaction_list[$i]['transaction_date'] = $this->DisplayDateTimeFormat($transaction_list["transaction_date"]);
				$all_transaction_list[$i]['description'] = $transaction_list["description"];
				$all_transaction_list[$i]['username'] = $transaction_list["username"];
				$all_transaction_list[$i]['amount'] = $transaction_list["amount"];
				$all_transaction_list[$i]['order_no'] = $transaction_list["order_no"];			
				$all_transaction_list[$i]['amount_type'] = $transaction_list["amount_type"];	
				$all_transaction_list[$i]['transid']=$transaction_list["transid"];	
				$all_transaction_list[$i]['photo']= $transaction_list["photo"];			
				$i++;
			}
		}
		//get all username list in drop down
		$all_username_list = $this->payment_log->all_transaction_username_list();	
		//send data to view file 
		$view = View::factory('admin/buynow_transaction_details')
                                        ->bind('buynow_transaction_list',$buynow_transaction_list)
                                        ->bind('all_username',$all_username_list)
                                        ->bind('srch',$_POST)
                                        ->bind('offset',$offset);
		$this->template->content = $view;	
	}
	
	/**** Venkatraja added in 14-March-2013 ***/
	
		public function action_orderhistory()
	{
		//auth login check
		$this->is_login();
		$this->admin_auction = Model::factory('adminauction');
		//set page title
		$this->page_title =   __('auction_order_history');
		$this->selected_page_title = __('auction_order_history');
		$this->selected_controller_title =__('auction_order_history');
		$count_transaction_list = count($this->transaction->all_orderhistory());
		//$this->template->welcomescript = Arr::merge($this->template->welcomescript,array(EDITORPATH.'tiny_mce.js'));
		$oid = $this->request->param('id');
		$orderstatus = Arr::get($_GET,'orderstatus');
		
		if(isset($orderstatus))
		{
			$getauctionid=$this->transaction->all_orderhistory($oid);
			//print_r($getauctionid);exit;
			$update = $this->transaction->orderupdate_paymentstatus($orderstatus,$getauctionid[0]['auction_id']);
			
			$update = $this->transaction->orderupdate($orderstatus,$oid);
			if($update)
				Message::success('Order status updated successfully');
				$this->request->redirect('transaction/orderhistory/'.$oid."#orderhistory");
		}
	        //pagination loads here	
		$page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_transaction_list,
                'view' => 'pagination/punbb',			  
                ));
		if($oid!="")
		{
			$view = 'admin/orderhistory';
		}
		else
		{
			$view = 'admin/orderhistory_list';
		}
		$sendmail = $this->request->post('sendmail');
		
		if(isset($sendmail))
		{
			
			if($_POST['subject'] &&  $_POST['message'])
			{
				$oid = $this->request->param('id');
				$all_transaction_list = $this->transaction->all_orderhistory($oid,'','');
				$this->username = array(TO_MAIL => trim($_POST['email']),
							'##PRODUCTNAME##' => $all_transaction_list[0]['product_name'],
							'##PRODUCTCOST##'=>$this->site_currency.Commonfunction::numberformat($all_transaction_list[0]['shippingamount']+$all_transaction_list[0]['total']),
							'##CURRENTPRICE##'=>'','##SAVEAMOUNT##'=>'',
							SUBJECT => str_replace("", "",$_POST['subject']),USERNAME=>$_POST['username'],MESSAGE => $_POST['message']);
				$this->replace_variable = array_merge($this->replace_variables,$this->username);
				//send mail to user by defining common function variables from here
				$mail = Commonfunction::get_email_template_details(WINNERS_REPLY,
				$this->replace_variable,SEND_MAIL_TRUE);
					//showing msg for mail sent or not in flash
				
					Message::success(__('mail_sent'));
					
			}
			else
			{
				Message::error(__('need_fill_required_fields'));
			}
			$this->request->redirect('transaction/orderhistory/'.$oid);
		}
			
		$all_transaction_list= array();				
		$all_transaction_list = $this->transaction->all_orderhistory($oid,$offset, ADM_PER_PAGE);
		$billingaddress=array();		
		$shippingaddress=array();		
		if($oid!=''){
			
			$billingaddress = $this->admin_auction->get_billing_address($all_transaction_list[0]['buyer_id']);
			$shippingaddress =$this->admin_auction->get_shipping_address($all_transaction_list[0]['buyer_id']); 			
		}		
		$search_post = arr::get($_REQUEST,'search_transaction');
		if($search_post)
		{			
			$all_transaction_list = $this->transaction->get_all_order_transaction_search_list($_POST['username_search'],trim(Html::chars($_POST['order_search'])),$_POST['fromdate'],$_POST['todate'],$_POST['filter_type'],$_POST['filter_order']);
			
		}				
		$auction_type = $this->module->select_types();   
		$all_username_list = $this->transaction->all_transaction_username_list();	
		//*pagination ends here
		//send data to view file 
		$view = View::factory($view)
                                ->bind('title',$title)
                                ->bind('all_transaction_list',$all_transaction_list)
                                ->bind('all_username',$all_username_list)
								->bind('auction_type', $auction_type)
								->bind('billing',$billingaddress)
								->bind('shipping',$shippingaddress)
                                ->bind('srch',$_POST)
                                ->bind('pag_data',$pag_data)
                                ->bind('offset',$offset);
		$this->template->content = $view;
	}	
	/*** Venkatraja added end in 14-March-2013 ***/	
}