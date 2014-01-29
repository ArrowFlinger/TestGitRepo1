<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Scratch Controller
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 *
 * @Package: Nauction Platinum Version 1.0
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 * @Created on October 24, 2012
 * @Updated on October 24, 2012
 */
class Controller_Site_Scratch extends Controller_Website {	
	
	public $site_currency = "";
	public function __construct(Request $request, Response $response)
	{		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		$this->scratchauction_model = Model::factory('scratch');

		if(preg_match('/site\/scratch\/scratchlist/i',Request::detect_uri()))
		{
			//Override the template variable decalred in website controller  
                        $this->template=THEME_FOLDER."template_user_sidebar";
        }
            
        $check_scratch = $this->scratchauction_model->check_scratch_present();
		if(count($check_scratch) <= 0){
				Message::error(__('direct_access'));
				$this->request->redirect("/");
		}
	}
	
    public function action_index()
    {
		echo "Page not Found";exit;
    }
	
	public function action_bid()
	{		
		//Get values from the ajax fetch
		$callback = Arr::get($_GET,'callback');
		$get=Arr::extract($_GET,array('pid','timestamp'));
		$id =$get['pid'];		
		$userid="";	
		
		if(is_array($get['pid']))
		{
			$product_ids = array();
			foreach($id as $pid)
			{
				if($pid !='undefined')
				{
					$product_ids = $pid;
				}
			}
		
			/*
			* Autobid
			*/
			$ex="";
			$auto_bidexists=1;
			foreach($product_ids as $ids):
			$id=$ids['pid'];
			$userid=$ids['uid'];
			$astart = $ids['astart'];
			//Select product results with particular id
			$product_results=$this->scratchauction_model->select_products_user_forbid($id);							
			$used="";
			//Session user id
			$ses_user=($userid!="")?$userid:$this->auction_userid;
			$select_bid_history_count=$this->auctions->select_bid_history_count($ses_user,$id);
			//Selects users based on session userid
			$user_results=$this->auctions->select_users($ses_user);
			//Get the autobid amount set 
			$auto_bid_amt=$this->auctions->get_autobid_amt($userid,$id);			
			if($product_results && count($auto_bid_amt)> 0)
			{			
				foreach($product_results as $product_result)
				{	
					if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['enddate'] >=$this->getCurrentTimeStamp && $astart <=$product_result['current_price'])//if item not in closed
					{	
											
						$c_price=$product_result['current_price'];
						$astartamt = isset($auto_bid_amt[0]['autobid_start_amount']) && $auto_bid_amt[0]['autobid_start_amount']!=""?$auto_bid_amt[0]['autobid_start_amount']:0;
						$usercredits = $auto_bid_amt[0]['bid_amount']- $product_result['bidamount'];	
						 
						if($userid=="" || $auto_bidexists==0){	
							if($product_result['dedicated_auction']==ENABLE)
							{
								$bid_count=$user_results[0]['user_bonus']-$product_result['bids'];
								$used="Bonus";
							}
							if($product_result['dedicated_auction']!=ENABLE)
							{
								$bid_count=$user_results[0]['user_bid_account']-$product_result['bids'];
								$used="Main";
							}
						}
						else
						{   
							//Get the autobid amount set 
							$auto_bid_amt=$this->auctions->get_autobid_amt($userid,$id);
							$auto_bid_amt=$auto_bid_amt[0]['bid_amount'];
							//Subtract the amount from the current price
							$bid_count=$auto_bid_amt-($c_price+$product_result['bids']);						
						}
						
					
						if($usercredits>=0)
						{
							if($ses_user!=$product_result['lastbidder_userid'])
							{
								//collecting all values in variable
								$current_price=$product_result['current_price'];
								$bid_incremental_price=$product_result['bidamount'];
								$item_max_time=$product_result['max_countdown'];
								$bidtime=$product_result['bidding_countdown'];
								$p_time=$product_result['increment_timestamp'];
								// Adding the current auction price and Bid incremental price
								
								$now_price=$current_price - $bid_incremental_price;
								//Calculating difference from the product time (unix timestamp)	with current(unix timestamp)
								$time_diff=$p_time-time();
								$cal=$time_diff+$bidtime;
	
								//Checking current countdown with max time set in product.
								if($cal < $item_max_time && $time_diff > 0)
								{	
									 $time=$cal+time();
								}
								else if($time_diff <= 0 && $time_diff > -CHECKING_TIME )
								{
									 $time=time()+$bidtime; 
								}								
								else
								{
									 $time=$item_max_time+time(); 
								}
								
								//reduce the bid count for the user 
								$update=$this->scratchauction_model->update_autobid($ses_user,$id,$usercredits);
								//Update Time stamp for product
								$arr=array('increment_timestamp'=>$time,'current_price'=>$now_price,'lastbidder_userid'=>$ses_user);
								
								$update=$this->auctions->update_product_time(SCRATCHAUCTION,$arr,$id);
	
								//Check condition of lastbidder in product auction and insert into bid historytable								
								$this->commonmodel->insert(SCRATCHBIDHISTORY,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_type'=>'AB','bids'=>$product_result['bids'],'date'=>$this->getCurrentTimeStamp));															
							}							
						}
						else
						{
							$amt=$this->auctions->get_autobid_amt($ses_user,$id);							
							if($userid!=""){						
								if($product_result['dedicated_auction']!=ENABLE){
									
									//get user balance and add the amount
									$amts= Commonfunction::get_user_balance($userid) + $amt[0]['bid_amount'];
									
									//Update the amount into the user balance field
									$update=$this->users->update_user_bid($amts,$userid,0);
									
								}
								else
								{
									//get user bonus and add the amount
									$amt=(Commonfunction::get_user_bonus($userid)+$amt);									
									$update=$this->users->update_user_bid($amt,$userid,1);
									
								}			
							}			
							$this->action_deleteautobid($ses_user,$id);
						}
					}
							
				}
			}
			endforeach;
		}
		else
		{
			/*
			* Single bid
			*/
			$view=View::factory(THEME_FOLDER."auctions/bid")
					->bind('product_results',$product_results)
					->bind('callback',$callback )
					->bind('error',$error_msg)
					->bind('user_bid_count',$usercredits);
			//Select product results with particular id
			$product_results=$this->scratchauction_model->select_products($id);
					
			$used="";
			//Session user id
			$ses_user=$this->auction_userid;
			$select_bid_history_count=$this->auctions->select_bid_history_count($ses_user,$id);
                        
			//Selects users based on session userid
			$user_results=$this->auctions->select_users($ses_user);
			$auto_bidexists=0;
			
			$usercredits = 0;
			if($product_results)
			{
				foreach($product_results as $product_result)
				{	
                                        //End date validation hide					
                                        /*if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['auction_process']!=HOLD  && $product_result['enddate'] >=$this->getCurrentTimeStamp && $get['timestamp'] > -CHECKING_TIME)//if item not in closed */

if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['auction_process']!=HOLD  &&  $get['timestamp'] > -CHECKING_TIME)//if item not in closed
					{	 
						$c_price=$product_result['current_price'];
					
						$usercredits = $user_results[0]['user_bid_account'] - $product_result['bidamount'];	
						if($userid=="" || $auto_bidexists==0){		
							//checks if it has bonus enabled				
							if($product_result['dedicated_auction']==ENABLE)
							{
								//$bid_count=$user_results[0]['user_bonus']-($c_price+$product_result['bidamount']);
                                                                $bid_count=$user_results[0]['user_bonus']-$product_result['bids'];
								 
								
								//add this text on error message for bonus bidding	
								$used="Bonus";
							}
							//checks if it has bonus is disabled	
							if($product_result['dedicated_auction']!=ENABLE)
							{
								//$bid_count=$user_results[0]['user_bid_account']-($c_price+$product_result['bidamount']);		
                                                        $bid_count=$user_results[0]['user_bid_account']-$product_result['bids'];		
                                                        
								//add this text on error message for main bidding	
								$used="Main";
							}
						}
						else
						{
							//Get the autobid amount set 
							$auto_bid_amt=$this->auctions->get_autobid_amt($userid,$id);
							
							//Subtract the amount from the current price
							$bid_count=$auto_bid_amt[0]['bid_amount']-$product_result['current_price'];
							//filter out the E in the result number
						}
					 
						
						if($bid_count>0)
						{
							 
                                 if($product_result['product_stock']!=0)
							     { 
								//collecting all values in variable
                                $timetobuy=$product_result['timetobuy'];
								$current_price=$product_result['current_price'];
								$bid_incremental_price=$product_result['bidamount'];
								$item_max_time=$product_result['max_countdown'];
								$bidtime=$product_result['bidding_countdown'];
								$p_time=$product_result['increment_timestamp'];
								// Adding the current auction price and Bid incremental price
								
									if($current_price < $bid_incremental_price){
											$now_price =0.00;
									}else{
									$now_price=$current_price - $bid_incremental_price;
									}
								//Calculating difference from the product time (unix timestamp)	with current(unix timestamp)
								$time_diff=$p_time-time();
								$cal=$time_diff+$bidtime;
								//Checking current countdown with max time set in product.
								if($cal < $item_max_time && $time_diff > 0)
								{	
									 $time=$cal+time();
								}
								else if($time_diff <= 0 && $time_diff > -CHECKING_TIME )
								{
									 $time=time()+$bidtime; 
								}
								else
								{
									 $time=$item_max_time+time(); 
								}
								
								//reduce the bid count for the user 
								//If user account in amount change -1 to $current_price
								if($userid=="" || $auto_bidexists==0)
								{	
									if($product_result['dedicated_auction']==ENABLE)
									{
										 $user_bid_count=$user_results[0]['user_bonus']>0?$bid_count:0;
										 
										//Update the user_bid_account
										if($user_bid_count>0){
											$this->users->update_user_bid($user_bid_count,$ses_user);
										}
									}
									else
									{
										$user_bid_count=$user_results[0]['user_bid_account']>0?$bid_count:0;
										
										if($user_bid_count>0){
											//Where 0 param is update user_bid_account field
											$this->users->update_user_bid($user_bid_count,$ses_user,0);
										}
									}
								}
								else
								{
									if($product_result['autobid']==ENABLE)
									{
										$this->action_updateautobid($ses_user,$id,$usercredits);
									}
								}						
							
								//Update Time stamp for product
                                                                //Stack update
                                                                $productstack=$product_result['product_stock']-1;
                                                                
								$arr=array('increment_timestamp'=>$time,'current_price'=>$now_price,'lastbidder_userid'=>$ses_user,'user_bid_active'=>1,'product_stock'=>$productstack);
								$this->auctions->update_product_time(SCRATCHAUCTION,$arr,$id);
	
								//Check condition of lastbidder in product auction and insert into bid historytable
								if($userid!="")
								{
									$nowprice=Commonfunction::numberformat($now_price);
									$this->commonmodel->insert(SCRATCHBIDHISTORY,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$nowprice,'bid_type'=>'AB','bids'=>$product_result['bids'],'date'=>$this->getCurrentTimeStamp));
								}
								else
								{
									$nowprice=Commonfunction::numberformat($now_price);
									$this->commonmodel->insert(SCRATCHBIDHISTORY,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$nowprice,'bid_type'=>'SB','timetobuy'=>$timetobuy,'user_bid_active'=>1,'product_stock'=>$product_result['product_stock'],'bids'=>$product_result['bids'],'date'=>$this->getCurrentTimeStamp));   
								}			
                                                                                                                							//last bidder validation hide 
                                                      }
							else
							{							
                                $error_msg=__('scratch_bidder');
							}
						
                                                       
						}
						else
						{
														
							
							$amt=$this->auctions->get_autobid_amt($ses_user,$id);
							
							if($userid!=""){						
								if($product_result['dedicated_auction']!=ENABLE){
									
									//get user balance and add the amount
									$amt=(Commonfunction::get_user_balance($userid)+$amt);
									
									//Update the amount into the user balance field
									$this->users->update_user_bid($amt,$userid,0);
								}
								else
								{
									//get user bonus and add the amount
									$amt=(Commonfunction::get_user_bonus($userid)+$amt);
									$this->users->update_user_bid($amt,$userid,1);
								}			
							}			
							$this->action_deleteautobid($ses_user,$id);
							if($userid==""){
								//Changing this label for language also need to change in website controller
								$error_msg=__('your_balance_low',array(":param"=>$used));
							}							
							
						}
						
					 }
					else
					{
						$error_msg=__('no_bids_to_be_added');
					}
				}
			}
			echo $view;//Prints the view
		}
		exit;
	}
	
	
	public function action_updateproduct()
	{
		$date= $this->getCurrentTimeStamp;
		$datas=arr::extract($_GET,array('status','pid'));
		$status =$datas['status'];
		$pid=isset($datas['pid'])?(int)substr(strstr($datas['pid'],"_"),1):1;
		$result=$this->scratchauction_model->select_products_to_update($status,$pid,$date);
		if(count($result)>0){
			foreach($result as $product_result)
			{	
				
				$now=$this->create_timestamp($date);
				$db_date=$this->create_timestamp($product_result['startdate']);
				$db_end_date=$this->create_timestamp($product_result['enddate']);
				if($status!=3)
				{
					
					$timestamp=time()+$product_result['max_countdown'];
					$this->scratchauction_model->update(SCRATCHAUCTION, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$product_result['product_id']);
					$this->scratchauction_model->update(PRODUCTS, array('in_auction' => 1),'product_id',$product_result['product_id']);
				}
				else
				{					
					
					$this->scratchauction_model->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' => $product_result['lastbidder_userid'],'current_price' => $product_result['current_price']),'product_id',$product_result['product_id']);
					
					$users=$this->scratchauction_model->getusersab($product_result['product_id']);
					
					foreach($users as $value)
					{
						$userid=$value['userid'];
						$abamnt=$value['bid_amount'];
						if($product_result['dedicated_auction']!=ENABLE)
						{
							//get user balance and add the amount
							$amts= Commonfunction::get_user_balance($userid) + $abamnt;
							//Update the amount into the user balance field
							$update=$this->users->update_user_bid($amts,$userid,0);
							$this->auctions->delete_autobid($userid,$product_result['product_id']);
						}
						else
						{
							//get user bonus and add the amount
							$amt=(Commonfunction::get_user_bonus($userid)+$abamnt);
							$update=$this->users->update_user_bid($amt,$userid,1);
							$this->auctions->delete_autobid($userid,$product_result['product_id']);
						}
					}
				}       
				
			}
		}
		exit;
		
	}
	
	public function action_deleteautobid($uid,$pid)
	{
		return $this->auctions->delete_autobid($uid,$pid);
		
	}
	
	public function action_updateautobid($uid,$pid,$amt=50)
	{
		return $update=$this->auctions->update_autobid($uid,$pid,$amt);
		
	}


        /**
	* Action for Bid history
	* Ajax page
	**/
	public function action_bid_history()
	{
		$view=View::factory('scratch/'.THEME_FOLDER.'auctions/bid_history')
					->bind('bid_histories',$bid_history)
					->bind('user',$this->auction_userid)
					->bind('count',$count);		
		
		//Get the current param id as like get method
		$id=$this->request->param('id');

		$bid_history=$this->scratchauction_model->select_bid_history($id);
		$count=count($bid_history);
		echo $view;
		exit;
	}

        //Scratch  
        public function action_timetobuy_update()
	{
                
                $this->auto_render=false;        
                $id=$_GET['pid'];
                $product_timetobuy=$this->scratchauction_model->select_product_timetobuy($id);
                
		$timetobuyupdate=$this->scratchauction_model->timetobuy($id);
                $timetobuyupdate_product=$this->scratchauction_model->timetobuy_update_product($id);//Scratch table update
              

                $timetobuyupdate_product=$this->scratchauction_model->timetobuy_update_product_stock($id);//Scratch table update
		echo $product_timetobuy;
	}


        //Buy Now auction
	public function action_addtocart_list()
	{ 
	        $this->is_login();
		$this->selected_page_title= __('buynow_list');
		
		$view=View::factory('scratch/'.THEME_FOLDER.'auctions/buyproductlist')
				->bind('transactions',$transactions)
				->bind('count_transaction',$count_transactions)
				->bind('useramount',$amt)
				->bind('totalamount',$totalamount)
				->bind('pagination',$pagination);
		$userid=$this->auction_userid;		
		$amt=Commonfunction::get_user_balance($userid);
		
                $product_id=$this->request->param('id');
                $productdetails = $this->scratchauction_model->getproductdetails($product_id);
              // print_r($productdetails );exit;
               
                $amt=(Commonfunction::get_user_balance($this->session->get('auction_userid')));
                //Product Cost and shipping fee
                $productcost = $productdetails[0]['current_price'];			
                $total_amount=$amt-$productcost;
                //insert order status
                $buyer_name =$this->auction_userid;
                $buyer_desc = $buyer_name ." "." bought ".$productdetails[0]['product_name'] ." for ".$productcost;                
                $addtocart_details= array(
                'userid' =>  $this->session->get('auction_userid'),                      
                'productid' => $productdetails[0]['product_id'],
                'product_name' => $productdetails[0]['product_name'],
                'product_image' => $productdetails[0]['product_image'],
                'amount' => $productcost,//login user a/c      
                'shipping_fee' => $productdetails[0]['shipping_fee']                  
                ); 
                $this->scratchauction_model->buynow_details($addtocart_details);
				$this->scratchauction_model->buynow_product_closed($addtocart_details); //scratch auction table
                $this->scratchauction_model->buynow_product_closed_product($addtocart_details); //scratch auction table
	
		$date= $this->getCurrentTimeStamp;
		$status =3;
		$pid=$productdetails[0]['product_id'];
		$result=$this->scratchauction_model->select_products_to_update($status,$pid,$date);
		
		if(count($result)>0){
			foreach($result as $product_result)
			{					
				$now=$this->create_timestamp($date);
				$db_date=$this->create_timestamp($product_result['startdate']);
				$db_end_date=$this->create_timestamp($product_result['enddate']);
				if($status!=3)
				{				
					
				}
				else
				{
					/*Add by selvam,on April 25,2013*/
					$check_buyerseller  = $this->checkbuyerseller->getauctiontypes();					
					if(count($check_buyerseller) > 0){					
					
						if($product_result['lastbidder_userid']!=0)
						{	
							if($product_result['admin_commission_per_product']=='' || $product_result['admin_commission_per_product']<= 0)
							{
								$admin_commission=0.00;
								$seller_amount=$product_result['current_price'];
							}else{
								$admin_commission=$product_result['current_price']*($product_result['admin_commission_per_product']/100);
								$seller_amount=$product_result['current_price']-$admin_commission;
								
							}
							
						$shipping_fee=($product_result['shipping_fee']!='')?$product_result['shipping_fee']:0.00;
						$bid_count=$this->scratchauction_model->get_total_bid_count($product_result['product_id'],$product_result['lastbidder_userid']);
						
						$this->scratchauction_model->insert(WON_PRODUCT, array('userid' => $product_result['lastbidder_userid'],
													 'productid' => $product_result['product_id'],
													 'totalprice' => $product_result['current_price'],
													 'admin_commission' => $admin_commission,
														  'total_bids_spend' =>$bid_count,
													 'shipping_fee' => $shipping_fee,
													 'seller_amount' => $seller_amount));
					
						}
					}/**Ends here****/	
				}       
				
			}
		}
		$this->request->redirect("site/scratch/scratchlist");
		
		$this->template->content = $view;
	    $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}


        public function action_wonproducts()
		{ 
		
		$payment_gateway=$this->packages->select_paymentgateways();
		$this->is_login();   
		$wonauctions_results = array();
		$countwon = array();
		foreach($this->reserve_model->getproductswon() as $wonauction)
		{
		       $getbids = Reserve::get_mybids($wonauction['product_id']);
		       
		       if(isset($getbids[0]['uid']) && $getbids[0]['uid'] == $this->auction_userid)
		       {
			       $countwon[] = array('product_id' => $wonauction['product_id']);
		       }
		} 
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 			 
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => count($countwon),  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => 'pagination/punbb_userside',  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));
		foreach($this->reserve_model->getproductswon() as $wonauction)
		 {
			$getbids = Reserve::get_mybids($wonauction['product_id']);
			 
			
			if(isset($getbids[0]['uid']) && $getbids[0]['uid'] == $this->auction_userid)
			{
				$wonauctions_results[] = array('product_id' => $wonauction['product_id'],
							       'product_image' => $wonauction['product_image'],
							       'product_url' => $wonauction['product_url'],   
							       'product_info' => $wonauction['product_info'],
							       'product_name' => $wonauction['product_name'],
							       'order_status' => $this->reserve_model->getAuctionOrders($wonauction['product_id'],$this->auction_userid),
							       'enddate' => $wonauction['enddate'],
							       'product_cost' => $wonauction['current_price'],
							       'current_price' => $wonauction['current_price'],
							       'lastbidder_userid' => $getbids[0]['uid'],
							       'amountpay' =>isset($getbids[0]['total'])?$getbids[0]['total']:0,	
							       );
			}
		 }
		 
		 $view=View::factory('reserve/'.THEME_FOLDER.'auctions/wonproducts')
				->bind('users',$users) 
				->bind('count_user_wonauctions',$countwon)
				->bind('wonauctions_results',$wonauctions_results)
				->bind('payment_gateway',$payment_gateway)
				->bind('pagination',$pagination);
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}


        public function action_scratchlist()
	{
		$this->selected_page_title= __("auction_scratch_won");
		$this->is_login();
		
                $view=View::factory('scratch/'.THEME_FOLDER.'auctions/scratch_product')
					->bind('count_user_watchlist',$count_user_product)
					->bind('product_results',$product_results)
					->bind('pagination',$pagination)
                    ->bind('scratch_results',$scratch_results)
					->bind('balance',$balance)
					->bind('checks',$checks);
		$id=$this->request->param('id');	
		
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 			$count_user_product = $this->scratchauction_model->select_scratch_product(NULL,REC_PER_PAGE,$this->auction_userid,TRUE);
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_user_product,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => 'pagination/punbb_userside',  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        )); 
                        $product_results=$this->scratchauction_model->select_scratch_product($offset,REC_PER_PAGE,$this->auction_userid);
                        $scratch_results=array();
                        foreach($product_results as $res)
                        {
							$won_completed=$this->users->getAuction_all_Orders($res['productid'],$this->auction_userid);
							$scratch_results[]=array('order_status'=>$won_completed,'product_url'=>$res['product_url'],'productid'=>$res['productid'],'product_name'=>$res['product_name'],'product_image'=>$res['product_image'],'amount'=>$res['amount'],'total_amt'=>$res['total_amt'],'shipping_fee'=>$res['shipping_fee'],'enddate'=>$res['add_date'],'userid'=>$res['userid']);
                        }

		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;		
		$this->template->meta_keywords=$this->metakeywords;
		
		
	}

} // End SCRATCHAUCTION
