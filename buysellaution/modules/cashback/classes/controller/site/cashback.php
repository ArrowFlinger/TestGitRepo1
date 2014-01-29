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
class Controller_Site_Cashback extends Controller_Website {	
	
	public $site_currency = "";
	protected $logo_image_path;
	public function __construct(Request $request, Response $response)
	{		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();	
		$this->site_currency =SITECURRENCY;
		$this->cashback_model = Model::factory('cashback');
		$this->logo_image_path=URL_BASE.'public/admin/images/logo.png';
if(((isset($site_name)) && $site_name[0]['site_logo']) && (file_exists(DOCROOT.LOGO_IMGPATH.$site_name[0]['site_logo']))){
		$this->logo_image_path = URL_BASE.LOGO_IMGPATH.$site_name[0]['site_logo'];}
		 
		$check_cashback = $this->cashback_model->check_cashback_present();
		if(count($check_cashback) <= 0){
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
		
		
		/*
		* Single bid
		*/
		$view=View::factory(THEME_FOLDER."auctions/bid")
				->bind('product_results',$product_results)
				->bind('callback',$callback )
				->bind('error',$error_msg)
				->bind('user_bid_count',$bid_count);
		//Select product results with particular id
		$product_results=$this->cashback_model->select_products($id);
				
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
						
					if($userid=="" || $auto_bidexists==0)
					{		
										
						//checks if it has bonus is disabled	
						if($product_result['dedicated_auction']!=ENABLE)
						{ 
							
							$bid_count=$user_results[0]['user_bid_account']-($c_price+$product_result['bidamount']);
											
							//add this text on error message for main bidding	
							$used="Main";
						}
						if($product_result['dedicated_auction']==ENABLE)
						{ 
							$bid_count=$user_results[0]['user_bonus']-($c_price+$product_result['bidamount']);
							$used="Bonus";
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
							$this->auctions->update_product_time(CASHBACK,$arr,$id);

							//Check condition of lastbidder in product auction and insert into bid historytable
							if($userid!="")
							{
								$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_type'=>'AB','date'=>$this->getCurrentTimeStamp));
							}
							else
							{
								$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_type'=>'SB','date'=>$this->getCurrentTimeStamp));
							}
										
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
				 }
				else
				{
					$error_msg=__('no_bids_to_be_added');
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
		$result=$this->cashback_model->select_products_to_update($status,$pid,$date); 
		print_r($result);
		if(count($result)>0){ 
			foreach($result as $product_result)
			{	
				
				$now=$this->create_timestamp($date);
				$db_date=$this->create_timestamp($product_result['startdate']);
				$db_end_date=$this->create_timestamp($product_result['enddate']);
				if($status!=3)
				{
					
					$timestamp=time()+$product_result['max_countdown'];
					$this->cashback_model->update(CASHBACK, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$product_result['product_id']);
					$this->cashback_model->update(PRODUCTS, array('in_auction' => 1),'product_id',$product_result['product_id']);
				}
				else
				{
					//for select bids details to update user amount add jagan feb 25
					$bid_results = $this->cashback_model->select_bids($product_result['product_id']);
					//end

					$this->cashback_model->update(CASHBACK, array('product_process'=>CLOSED,'enddate' => $date),'product_id',$product_result['product_id']);
					$this->cashback_model->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' => $product_result['lastbidder_userid'],'current_price' => $product_result['current_price']),'product_id',$product_result['product_id']);
					
					$users=$this->cashback_model->getusersab($product_result['product_id']);
					
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
					
					
					//added for user amount return to winners add jagan feb 25
					if(count($bid_results>0)) 
					{ 
						$array = array("1","2","4");
						foreach($bid_results as $k => $bids)	
						{ 
							$user = $bids['user_id'];
							
							$amt = $bids['price'];
							$pid = $bids['product_id'];
							$j   = $array[$k];
							$val = $amt/$array[$k];
					
							$user_amts = $this->cashback_model->select_user_amounts($user);
							$user_details = $this->cashback_model->select_user_products_details($pid);
					 		$productname= $user_details['product_name'];
					 		
							if($user_details['dedicated_auction']!='E')
							{ 
								$totals = $user_amts['user_bid_account']+$val;
								if($product_result['in_auction']!=2) { 
									$message_status = $this->cashback_model->update(USERS,array('user_bid_account'=>$totals),'id',$user);			
									try {
									$mail_status = $this->custom_send_mail($j,$user,$pid,$productname,$val,$amt,$product_result['product_url']);
									}
									catch(Exception $e){ }
								}
							}
							else
							{
								$totals = $user_amts['user_bonus']+$val;
								if($product_result['in_auction']!=2) {
									$message_status = $this->cashback_model->update(USERS,array('user_bonus'=>$totals),'id',$user);
									try {
									$mail_status = $this->custom_send_mail($j,$user,$pid,$productname,$val,$amt,$product_result['product_url']);
									}
									catch(Exception $e){ }
								}
							}
							
							
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
	
	//mail send function for add jagan feb 25
	public function custom_send_mail($j="", $userid="", $productid="", $product_name="", $product_cost="", $product_price="", $product_url="")
	{ 
		if($userid!="")
		{  
		$user_details = $this->cashback_model->select_user_details($userid);
		
		//Send mail notification for the winning bidders
		$messageforwinner ="Thank you for bidding in auction ".$productid." - ".$product_name."\r\n";
		$messageforwinner .="This message is a confirmation that your bid has been received. There is no need to reply.\r\n\r\n";
		$messageforwinner .="<b><u>The details of your bid are included below for your reference:</u></b>";

		$auctioninfo = '<p>';
		
		$auctioninfo .= '<p><b>Auction ID: </b>#'.$productid.'</p>';
		$auctioninfo .= '<p><b>Total Product Cost End: </b>'.SITECURRENCY.$product_price.'</p>';	
		if($j==1) {	
		$auctioninfo .= '<p><b>Total Product Cost Return: </b>'.SITECURRENCY.$product_cost.'</p>';			
		$auctioninfo .= '<p><b>Bid Notification Message: </b><span style="color:green"> Your are winner of this auction and you can get the amount return for '.SITECURRENCY.$product_cost.'</span></p>';	
		} else if($j==2) {
		$auctioninfo .= '<p><b>Total Product Cost Return: </b>'.SITECURRENCY.$product_cost.'</p>';	
		$auctioninfo .= '<p><b>Bid Notification Message: </b><span style="color:green"> Your are second place of this auction and you get the amount return for '.SITECURRENCY.$product_cost.'</span></p>';	
		} else if($j==4) {
		$auctioninfo .= '<p><b>Total Product Cost Return: </b>'.SITECURRENCY.$product_cost.'</p>';	
		$auctioninfo .= '<p><b>Bid Notification Message: </b><span style="color:green"> Your are third place of this auction and you get the amount return for '.SITECURRENCY.$product_cost.'</span></p>';	
		}
		$auctioninfo .= '</p>';
		$messageforwinner .=$auctioninfo;
		$this->alternatives = array('##AUCTIONID##' => $product_name,
					    '##MESSAGE##' => $messageforwinner,
					    '##LOGO##' => '<img src="'.$this->logo_image_path.'" width="180"/>',
					    '##NOTIFICATION##' => '',
					    '##CASHBACKSUBJECT##' => 'Cashback Product Notification',
					    '##PRODUCT_URL##' =>URL_BASE.'auctions/view/'.$product_url,
						USERNAME => $user_details['username'],
						TO_MAIL=>$user_details['email']); 
		$this->buyer_replace_variable = array_merge($this->replace_variables,$this->alternatives);

		//send mail to buyer by defining common function variables from here               
		$mail = Commonfunction::get_email_template_details('cashback-auction',$this->buyer_replace_variable,SEND_MAIL_TRUE,true);
	 
		}

	}
	
} // End cashback
