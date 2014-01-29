<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Beginner Controller
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 *
 * @package    Beginner Auction
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Controller_Site_Clock extends Controller_Website {	
	
	public $site_currency = "";
	public function __construct(Request $request, Response $response){		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();	
		$this->clock_model = Model::factory('clock');
		 
		$check_clock = $this->clock_model->check_clock_present();
		if(count($check_clock) <= 0){
				Message::error(__('direct_access'));
				$this->request->redirect("/");
		}
	}
	
	public function action_index(){
		echo "Page not Found";exit;
	}


	/*Clock buynow start*/
	public function action_buynow(){
		$post=Arr::extract($_POST,array('id','unitprice','qty','name','type'));
		 
		if(!$_POST)
		{
			Message::success(__('direct_access'));	
	      		$this->request->redirect('/');
		}
		else
		{
			$update_buynow_status=$this->clock_model->update_buynow_status($post['id'],PROCESS);
		}
		$getProductDetails=$this->clock_model->select_products_details($post['id']);
		$view=View::factory('clock/'.THEME_FOLDER."auctions/clock_buynow")
					->bind('product_result',$post)					
					->bind('productdetails',$getProductDetails);
		$this->is_login();		
		$balance=Commonfunction::get_user_balance($this->auction_userid);
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	/*Clock buynow end*/

	//clock buynow cancel
	public function action_buynowcancel(){
	 
	 	$post=Arr::extract($_POST,array('pid'));

		if($post!="")
		{
			$message_status = $this->clock_model->update(CLOCK,array('clock_buynow_status'=>NOTPROCESS,'clock_buynow_status_date'=>$this->getCurrentTimeStamp),'product_id',$post);
		}
		
		
	exit;
	}

	public function action_bid(){
		//Get values from the ajax fetch
		$callback = Arr::get($_GET,'callback');
		$get=Arr::extract($_GET,array('pid','timestamp'));
		$id =$get['pid'];		
		$userid="";	
		
			/*
			* Single bid
			*/
			$view=View::factory(THEME_FOLDER."auctions/bid")
					->bind('product_results',$product_results)
					->bind('callback',$callback )
					->bind('error',$error_msg)
					->bind('user_bid_count',$bid_count);
			//Select product results with particular id
			$product_results=$this->clock_model->select_products($id);
			$used="";
			//Session user id
			$ses_user=$this->auction_userid;
			$select_bid_history_count=$this->auctions->select_bid_history_count($ses_user,$id);
			//Selects users based on session userid
			$user_results=$this->auctions->select_users($ses_user);
			$auto_bidexists=0;
			
			if($product_results){
				foreach($product_results as $product_result){	
					if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['auction_process']!=HOLD  && $product_result['enddate'] >=$this->getCurrentTimeStamp && $get['timestamp'] > -CHECKING_TIME)//if item not in closed
					{	
						if($select_bid_history_count>0)	{ 
							$select_bid_history_lastamt=$this->auctions->select_bid_history_last_amt($ses_user,$id);
							$c_price=$product_result['current_price']- $select_bid_history_lastamt;
						
						}else{
							$c_price=$product_result['current_price'];
						}
						if($userid=="" || $auto_bidexists==0){		
							//checks if it has bonus enabled				
							if($product_result['dedicated_auction']==ENABLE){
								$bid_count=$user_results[0]['user_bonus']-($product_result['bidamount']*$product_result['reduction']);
								//add this text on error message for bonus bidding	
								$used="Bonus";
							}
							//checks if it has bonus is disabled	
							if($product_result['dedicated_auction']!=ENABLE){
								
								$checkval = $product_result['current_price']-$product_result['min_limit_price'];
								
								if($product_result['current_price']!=$product_result['min_limit_price'])
								{
									if($checkval > 0) {	
										if(($product_result['bidamount']*$product_result['reduction']) <= $checkval) 
											{
										
												$bid_count=$user_results[0]['user_bid_account']-($product_result['bidamount']*$product_result['reduction']);				
											$used="Main";
										
											}
											else
											{
												$bid_count=$user_results[0]['user_bid_account']-$checkval;
													
											}
										
										}
								}
								
								if($product_result['current_price']==$product_result['min_limit_price'])
								{
									
									$bid_count=$user_results[0]['user_bid_account']-($product_result['bidamount']*$product_result['reduction']);										
								}	 
							}
						}else{
							//Get the autobid amount set 
							$auto_bid_amt=$this->auctions->get_autobid_amt($userid,$id);
							//Subtract the amount from the current price
							$bid_count=$auto_bid_amt[0]['bid_amount']-$product_result['current_price'];
							//filter out the E in the result number
						}
						 
						if($bid_count>0){
						
							if($ses_user!=$product_result['lastbidder_userid']){
								//collecting all values in variable
								$current_price=$product_result['current_price'];
								$bid_incremental_price=$product_result['bidamount'];
								$item_max_time=$product_result['max_countdown'];
								$bidtime=$product_result['bidding_countdown'];
								$p_time=$product_result['increment_timestamp'];
								// Adding the current auction price and Bid incremental price
								
								$reduction=$product_result['reduction'];
								$now_price=$current_price-($bid_incremental_price*$reduction);   //clock auction : current price reduction
							 
								if($now_price < $product_result['min_limit_price']){
									$now_price=$product_result['min_limit_price'];
								}
							
								if($product_result['clock_buynow_status']==NOTPROCESS)
								{
									//Calculating difference from the product time (unix timestamp)	with current(unix timestamp)
									$time_diff=$p_time-time();
									$cal=$time_diff+$bidtime;
									//Checking current countdown with max time set in product.
									if($cal < $item_max_time && $time_diff > 0){	
										 $time=$cal+time();
									}else if($time_diff <= 0 && $time_diff > -CHECKING_TIME ){
										 $time=time()+$bidtime; 
									}else{
										 $time=$item_max_time+time(); 
									}
									//reduce the bid count for the user 
									//If user account in amount change -1 to $current_price
									if($userid=="" || $auto_bidexists==0){	
										if($product_result['dedicated_auction']==ENABLE){
											$user_bid_count=$user_results[0]['user_bonus']>0?$bid_count:0;
											//Update the user_bid_account
											if($user_bid_count>0){
												$this->users->update_user_bid($user_bid_count,$ses_user);
											}
										}else{
											$user_bid_count=$user_results[0]['user_bid_account']>0?$bid_count:0;
											if($user_bid_count>0){
												//Where 0 param is update user_bid_account field
												$this->users->update_user_bid($user_bid_count,$ses_user,0);
											}
										}
									}else{
										if($product_result['autobid']==ENABLE){
											$this->action_updateautobid($ses_user,$id,$bid_count);
										}
									}						
									//Update Time stamp for product
									$arr=array('increment_timestamp'=>$time,'current_price'=>$now_price,'lastbidder_userid'=>$ses_user);
									$this->auctions->update_product_time(CLOCK,$arr,$id);
									//Check condition of lastbidder in product auction and insert into bid historytable
									if($userid!=""){
										$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_type'=>'AB','date'=>$this->getCurrentTimeStamp));
									}else{
										$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_type'=>'SB','date'=>$this->getCurrentTimeStamp));
									}
								}else{
									$error_msg=__('min_bid_limit_label');
								}
							}else{$error_msg=__('last_bidder');}
		
						}else{
							
						$error_msg=__('seat_balance_low',array(":param"=>$used));
							
						}
					}else{
						$error_msg=__('clock_no_bids_to_be_added');
					}
				}
			}
			echo $view;//Prints the view
		
		exit;
	}
	
	
	public function action_updateproduct()
	{ 
		$date= $this->getCurrentTimeStamp;
		$datas=arr::extract($_GET,array('status','pid'));
		$status =$datas['status'];
		$pid=isset($datas['pid'])?(int)substr(strstr($datas['pid'],"_"),1):1; 
		$result=$this->clock_model->select_products_to_update($status,$pid,$date); 
		if(count($result)>0){ 
			foreach($result as $product_result)
			{	
				
				$now=$this->create_timestamp($date);
				$db_date=$this->create_timestamp($product_result['startdate']);
				$db_end_date=$this->create_timestamp($product_result['enddate']);
				if($status!=3)
				{
					
					$timestamp=time()+$product_result['max_countdown'];
					$this->clock_model->update(CLOCK, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$product_result['product_id']);
					$this->clock_model->update(PRODUCTS, array('in_auction' => 1),'product_id',$product_result['product_id']);
				}
				else
				{				
				
					$this->clock_model->update(CLOCK, array('product_process'=>CLOSED,'enddate' => $date),'product_id',$product_result['product_id']);
					$this->clock_model->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' => $product_result['lastbidder_userid'],'current_price' => $product_result['current_price']),'product_id',$product_result['product_id']);
					
					$users=$this->clock_model->getusersab($product_result['product_id']);
					
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
	public function action_bid_history()
	{
		$this->auto_render = false;
		$view=View::factory('clock/'.THEME_FOLDER.'auctions/bid_history')
					->bind('bid_histories',$bid_history)
					->bind('user',$this->auction_userid)
					->bind('count',$count);		
		
		//Get the current param id as like get method
		$id=$this->request->param('id');

		$bid_history=$this->auctions->select_bid_history($id);
		 
		 
		$count=count($bid_history);
		echo $view; 
	}
	
	
} // End clock
