<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Beginner Controller
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 *
 * @package    Nauction Platinum Version 1.0
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 * @Created on October 24, 2012
 * @Updated on October 24, 2012
 */
class Controller_Site_Peakauction extends Controller_Website {	
	
	public $site_currency = "";
	public function __construct(Request $request, Response $response)
	{		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();	
		
		$this->peakauction_model = Model::factory('peakauction');		
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
		//echo "";
		
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
			$product_results=$this->peakauction_model->select_products_user_forbid($id);							
			$used="";
			
			//Session user id
			$ses_user=($userid!="")?$userid:$this->auction_userid;
			$select_bid_history_count=$this->auctions->select_bid_history_count($ses_user,$id);
			
			//Selects users based on session userid
			$user_results=$this->auctions->select_users($ses_user);
			
			$ctime = date("H:i:s",time());
			
			//Get the autobid amount set 
			$auto_bid_amt=$this->auctions->get_autobid_amt($userid,$id);			
			if($product_results && count($auto_bid_amt)> 0)
			{			
				foreach($product_results as $product_result)
				{	
					
					if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['enddate'] >=$this->getCurrentTimeStamp && $astart <=$product_result['current_price'] && ($ctime > $product_result['auction_starttime'] && $ctime < $product_result['auction_endtime']))//if item not in closed
					{	
						if($select_bid_history_count>0)	
						{ 
						
						   $select_bid_history_lastamt=$this->auctions->select_bid_history_last_amt($ses_user,$id);
							$c_price=$product_result['current_price']- $select_bid_history_lastamt;
						}
						else
						{					
							$c_price=$product_result['current_price'];
						}
						$astartamt = isset($auto_bid_amt[0]['autobid_start_amount']) && $auto_bid_amt[0]['autobid_start_amount']!=""?$auto_bid_amt[0]['autobid_start_amount']:0;
		
						if($userid=="" || $auto_bidexists==0){	
							if($product_result['dedicated_auction']==ENABLE)
							{
								$bid_count=$user_results[0]['user_bonus']-($c_price+$product_result['bidamount']);
								$used="Bonus";
							}
							if($product_result['dedicated_auction']!=ENABLE)
							{
								$bid_count=$user_results[0]['user_bid_account']-($c_price+$product_result['bidamount']);
								$used="Main";
							}
						}
						else
						{   
							//Get the autobid amount set 
							$auto_bid_amt=$this->auctions->get_autobid_amt($userid,$id);
							
							$auto_bid_amt=$auto_bid_amt[0]['bid_amount'];
							
							//Subtract the amount from the current price
							$bid_count=$auto_bid_amt-($c_price+$product_result['bidamount']);						
						}
						
					
						if($bid_count>0)
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
								//$now_price=bcadd($current_price,$bid_incremental_price,$product_result['product_decimal_number']);
								$now_price=$current_price+$bid_incremental_price;
								
								
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
								$update=$this->peakauction_model->update_autobid($ses_user,$id,$bid_count);
								//Update Time stamp for product
								$arr=array('increment_timestamp'=>$time,'current_price'=>$now_price,'lastbidder_userid'=>$ses_user);
								
								$update=$this->auctions->update_product_time(PEAK_AUCTION,$arr,$id);
	
								//Check condition of lastbidder in product auction and insert into bid historytable								
								$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_type'=>'AB','date'=>$this->getCurrentTimeStamp));															
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
					->bind('user_bid_count',$bid_count);
			//Select product results with particular id
			$product_results=$this->peakauction_model->select_products($id);
	
						$used="";
			//Session user id
			$ses_user=$this->auction_userid;
			$select_bid_history_count=$this->auctions->select_bid_history_count($ses_user,$id);
			
			//Selects users based on session userid
			$user_results=$this->auctions->select_users($ses_user);
			$auto_bidexists=0;
			
		
			if($product_results)
			{
				foreach($product_results as $product_result)
				{
					if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['auction_process']!=HOLD  && $product_result['enddate'] >=$this->getCurrentTimeStamp && $get['timestamp'] > -CHECKING_TIME)//if item not in closed
					{					
								if($select_bid_history_count>0)	
								{ 							
									$select_bid_history_lastamt=$this->auctions->select_bid_history_last_amt($ses_user,$id);
									$c_price=$product_result['current_price']- $select_bid_history_lastamt;
								}
								else
								{							
									$c_price=$product_result['current_price'];
								}
									
								if($userid=="" || $auto_bidexists==0){		
									//checks if it has bonus enabled				
									if($product_result['dedicated_auction']==ENABLE)
									{
										$bid_count=$user_results[0]['user_bonus']-($c_price+$product_result['bidamount']);
										//add this text on error message for bonus bidding	
										$used="Bonus";
									}
									//checks if it has bonus is disabled	
									if($product_result['dedicated_auction']!=ENABLE)
									{
										
										$bid_count=$user_results[0]['user_bid_account']-($c_price+$product_result['bidamount']);				
									
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
								}

						if($product_result['userid']!=$ses_user)/* add on may 6,2013-selvam*/
							{								
								if($bid_count>0)
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
										
										$now_price=$current_price+$bid_incremental_price;
										
										
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
												$this->action_updateautobid($ses_user,$id,$bid_count);
											}
										}						
									
										//Update Time stamp for product
										$arr=array('increment_timestamp'=>$time,'current_price'=>$now_price,'lastbidder_userid'=>$ses_user);
										$this->auctions->update_product_time(PEAK_AUCTION,$arr,$id);
			
										//Check condition of lastbidder in product auction and insert into bid historytable
										if($userid!="")
										{
											$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_type'=>'AB','date'=>$this->getCurrentTimeStamp));
										}
										else
										{
											$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_type'=>'SB','date'=>$this->getCurrentTimeStamp));
										}

                                                                                /* For sending sms in last bid user
                                                                                * Dec26, 2012
                                                                                **/
                                                                                $product_settings=$this->peakauction_model->select_product_settings();
                                                                               /* if($product_settings['sms_eachbid']=='Y'){
                                                                                $lastbid_usercontactno=$this->peakauction_model->select_shipping_phno($product_result['lastbidder_userid']);
                                                                                $mobileno=$lastbid_usercontactno['phoneno'];
                                                                                $msg=$product_settings['sms_eachbid_template'];
                                                                                $msg=str_replace('##PRODUCT##',strtoupper($product_result['product_name']),$msg);
                                                                                $msg=str_replace('##USER##',strtoupper($_SESSION['auction_username']),$msg);
                                                                                sms::send_sms($mobileno,$msg);
                                                                                }	*/		
									}
									else
									{
										$error_msg=__('last_bidder');
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
						}else
							{
						
							$error_msg=__('your_own_product');
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
		$datas=arr::extract($_GET,array('status','pid','array'));
		$other = $datas['array'];
		$status =$datas['status'];
		$pid=isset($datas['pid'])?(int)substr(strstr($datas['pid'],"_"),1):1;
		$result=$this->peakauction_model->select_products_to_update($status,$pid,$date);
		if(count($result)>0){
			foreach($result as $product_result)
			{	
				
				$now=$this->create_timestamp($date);
				$db_date=$this->create_timestamp($product_result['startdate']);
				$db_end_date=$this->create_timestamp($product_result['enddate']);
				if($status!=3 && $status!=5)
				{
					
					$timestamp=time()+$product_result['max_countdown'];
					$this->peakauction_model->update(PEAK_AUCTION, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$product_result['product_id']);
					$this->peakauction_model->update(PRODUCTS, array('in_auction' => 1),'product_id',$product_result['product_id']);
				}
				else if($status==5 && $status!=3)
				{
					if($other['updatepeak']==1)
					{
						if($product_result['timediff'] > 0){
						$time=time()+$product_result['timediff'];
						$this->peakauction_model->update(PEAK_AUCTION, array('increment_timestamp'=> $time,'timediff'=> 0,'product_process'=>LIVE),'product_id',$product_result['product_id']);
						}
					}
					else {
                                                        /**
				*Winning SMS
				*DEC26,2012
				**/
				$product_settings=$this->peakauction_model->select_product_settings();				
				
					if($product_result['timediff'] == 0){
							$time=$other['now']-time();
							$incrementtimestamp = $product_result['increment_timestamp']+48600;
							$this->peakauction_model->update(PEAK_AUCTION, array('timediff'=> $time,'product_process'=>LIVE,'increment_timestamp' => $incrementtimestamp ),'product_id',$product_result['product_id']);
						}
					}
				}
				else
				{
					/** venkatraja added in 25-Feb-12 **//*selvam on april 5*/
				 
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
					$bid_count=Commonfunction::get_total_bid_count($product_result['product_id'],$product_result['lastbidder_userid']);
					
					$this->peakauction_model->insert(WON_PRODUCT, array('userid' => $product_result['lastbidder_userid'],
											     'productid' => $product_result['product_id'],
											     'totalprice' => round($product_result['current_price'],2),
											     'admin_commission' => round($admin_commission,2),
											          'total_bids_spend' =>$bid_count,
											     'shipping_fee' =>round($shipping_fee,2),
											     'seller_amount' => round($seller_amount,2)));
				
					}
					 
					/** added end by venkatraja **/
					
					$this->peakauction_model->update(PEAK_AUCTION, array('product_process'=>CLOSED,'enddate' => $date),'product_id',$product_result['product_id']);
					$this->peakauction_model->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' => $product_result['lastbidder_userid'],'current_price' => $product_result['current_price']),'product_id',$product_result['product_id']);
					
					$users=$this->peakauction_model->getusersab($product_result['product_id']);
					
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
	
	
} // End Pennyauction
