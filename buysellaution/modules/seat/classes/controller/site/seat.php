<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Beginner Controller
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
class Controller_Site_Seat extends Controller_Website {	
	
	public $site_currency = "";
	protected $logo_image_path;
	public function __construct(Request $request, Response $response)
	{		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();	
		$this->site_currency =SITECURRENCY;
		$this->seat_model = Model::factory('seat'); 
		$site_name=Commonfunction::get_site_settings();
		$this->logo_image_path=URL_BASE.'public/admin/images/logo.png';
if(((isset($site_name)) && $site_name[0]['site_logo']) && (file_exists(DOCROOT.LOGO_IMGPATH.$site_name[0]['site_logo']))){
		$this->logo_image_path = URL_BASE.LOGO_IMGPATH.$site_name[0]['site_logo'];}		
		$check_seat = $this->seat_model->check_seat_present();
		if(count($check_seat) <= 0){
				Message::error(__('direct_access'));
				$this->request->redirect("/");
		}
	}
	
    	public function action_index()
    	{ 
    		$this->auto_render=false;
		$this->is_login();
		$json=array();
		$data=arr::extract($_POST,array('productid'));
		$sesuser=$this->auction_userid;
		$productid = $data['productid']; 
		$seat_details = $this->seat_model->select_seat_details($productid); 
		$seat_amt = $seat_details['seat_cost'];
		$seat_settings = $this->seat_model->get_seat_site_settings_user(); 
			 
		if(isset($data)) 
		{ 
			$bid="";
			$seat_booking = $this->seat_model->select_seat_booking_exisits($productid,$this->auction_userid);
				
			if(count($seat_booking)>0) 
			{
			
				$json['error'] = (__('you_already_bought',array(':param'=>URL_BASE.'packages')));
			}
			else
			{
				$this->seat_model->insert(SEAT_BOOKING,array('user_id'=>$this->auction_userid,'product_id'=>$productid,'seat_amount' =>$seat_amt));
			
				if($seat_settings['email_verification_reg'] == 'Y') 
				{				
					$mail_status = $this->custom_send_mail($this->auction_userid,$productid,$seat_details['product_name'],$seat_amt,$seat_details['product_url']); 
				}
				
				$product_results=$this->seat_model->select_products_user_forbid($productid);	
				foreach($product_results as $val) {
		
				$abamnt=$val['seat_cost'];
		
				//get user balance and add the amount
				$amts= Commonfunction::get_user_balance($sesuser) - $abamnt;
				//Update the amount into the user balance field
				$update=$this->users->update_user_bid($amts,$sesuser,0);
				}
			
			}  
		} 
		$seat_booking = $this->seat_model->select_seat_booking($productid);
		$buy_seats = count($seat_booking); 
		$json['buy_seats'] = $buy_seats; 
		
		echo json_encode($json);
		
    	}
    	
    	//mail send function for add jagan feb 25
	public function custom_send_mail($userid="", $productid="", $product_name="", $product_price="",$product_url="")
	{
		if($userid!="")
		{  
		$user_details = $this->seat_model->select_user_details($userid);
		
		//Send mail notification for the winning bidders
		$messageforwinner ="Thank you for booking this auction ".$productid." - ".$product_name."<br/>";
		$messageforwinner .="This message is a confirmation that your booking has been received. There is no need to reply.<br/>";
		$messageforwinner .="<b><u>The details of your booking are included below for your reference:</u></b><br/>";

		$auctioninfo = '<p>';
		
		$auctioninfo .= '<p><b>Auction ID: </b>#'.$productid.'</p>';
		$auctioninfo .= '<p><b>Seat Cost: </b>'.SITECURRENCY.$product_price.'</p>';	
				
		$auctioninfo .= '<p><b>Booking Notification Message: </b><span style="color:green"> You have been booked in this auction and shortly you will get bid start notification message</span></p>';	
		
		$auctioninfo .= '</p>';
		$messageforwinner .=$auctioninfo;
		$this->alternatives = array('##AUCTIONID##' => $product_name,
					    '##MESSAGE##' => $messageforwinner,
					    '##LOGO##' => '<img src="'.$this->logo_image_path.'" width="180"/>',
					    '##NOTIFICATION##' => '',
					    '##SEATSUBJECT##' => 'Seat Booking Notification',
					    '##PRODUCT_URL##' =>URL_BASE.'auctions/view/'.$product_url,
						USERNAME => $user_details['username'],
						TO_MAIL=>$user_details['email']); 
		$this->buyer_replace_variable = array_merge($this->replace_variables,$this->alternatives);

		//send mail to buyer by defining common function variables from here               
		$mail = Commonfunction::get_email_template_details('seat-auction',$this->buyer_replace_variable,SEND_MAIL_TRUE,true);
	 
		}

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
		$product_results=$this->seat_model->select_products($id);
				
		$used="";
		//Session user id
		$ses_user=$this->auction_userid;
		//Selects users based on session userid
		$user_results=$this->auctions->select_users($ses_user);
		$user_seat_amount=$this->seat_model->get_user_balances($ses_user,$id); 

		$auto_bidexists=0;
		
		
		if($product_results)
		{
			foreach($product_results as $product_result)
			{	
				//select seat booked userids
				$bid_results = $this->seat_model->select_seat_useridcount($product_result['product_id'],$ses_user);
				
				 
				
					
					//check the session user equal to booked user
					if($bid_results>0) 
					{
										
				
						if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['auction_process']!=HOLD  && $product_result['enddate'] >=$this->getCurrentTimeStamp && $get['timestamp'] > -CHECKING_TIME)//if item not in closed
						{	
							//user seat amount reduced here
							$bid_count=$user_seat_amount-($product_result['bidamount']);	
					
							//add this text on error message for main bidding	
							$used="Main";	
				
							if($bid_count>=0)
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
							
									$user_bid_count=$user_seat_amount>=0?$bid_count:0;
									
									if($user_bid_count>=0)
									{
										//Where update seat_amount field
										$this->seat_model->update_user_bid($user_bid_count,$ses_user,$product_result['product_id']);
									}
							
							
									//Update Time stamp for product
									$arr=array('increment_timestamp'=>$time,'current_price'=>$now_price,'lastbidder_userid'=>$ses_user);
									$this->auctions->update_product_time(SEAT,$arr,$id);

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
				                                       /*$product_settings=$this->seat_model->select_product_settings();
				                                        if($product_settings['sms_eachbid']=='Y'){
				                                                $lastbid_usercontactno=$this->seat_model->select_shipping_phno($product_result['lastbidder_userid']);
				                                                $mobileno=$lastbid_usercontactno['phoneno'];
				                                                $msg=$product_settings['sms_eachbid_template'];
				                                                $msg=str_replace('##PRODUCT##',strtoupper($product_result['product_name']),$msg);
				                                                $msg=str_replace('##USER##',strtoupper($_SESSION['auction_username']),$msg);
				                                                sms::send_sms($mobileno,$msg);
				                                        }*/
										
								}
								else
								{
									$error_msg=__('last_bidder');
								}
								
							}
							else
							{
								if($userid=="")
								{
									//Changing this label for language also need to change in website controller
									$error_msg=__('your_seat_balance_low');
                                                                       
								}
							}
						 }
						 else
						 {
							$error_msg=__('no_Seatbids_to_be_added');
						 }
					

						 
					}
					else
					{
						$error_msg=__('you_cannot_bid_seat');
					}
			
				//check the seat user or not
			
			}
		}
		echo $view;//Prints the view
		
		exit;
	}
	
	//custom function for random name
	public function create_randname($name)
	{
               $name = str_split($name);
               $last = count($name);
               $position = array($last-1,0,2); 
               $string ="";
               foreach($name as $k => $v)
               {
                       for($i=0;$i<count($position);$i++)
                       {
                               if($k==$position[$i])
                               {
                                       $string .= $v;
                               }
                       }
                       
               } 
               $stringB="**";
               $length=strlen($string);
               $temp1=substr($string,0,$length-4);
               $temp2=substr($string,$length-4,$length);
               return $temp2.$stringB.$temp1;   
	}
	
	
	public function action_updateproduct()
	{ 
		$date= $this->getCurrentTimeStamp;
		$datas=arr::extract($_GET,array('status','pid'));
		$status =$datas['status'];
		print_r($status);
		$pid=isset($datas['pid'])?(int)substr(strstr($datas['pid'],"_"),1):1;
		$result=$this->seat_model->select_products_to_update($status,$pid,$date);
		print_r($result);
		$seat_settings = $this->seat_model->get_seat_site_settings_user(); 
	
		/* For sending sms in last bid user
		* Dec26, 2012
		**/
		
		if(count($result)>0){ echo 'asd123';
			foreach($result as $product_result)
			{ $re[]=$product_result;
				
				$now=$this->create_timestamp($date);
				$db_date=$this->create_timestamp($product_result['startdate']);
				$db_end_date=$this->create_timestamp($product_result['enddate']);
				if($status!=3)
				{
					
					$timestamp=time()+$product_result['max_countdown'];
					$this->seat_model->update(SEAT, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$product_result['product_id']);
					$this->seat_model->update(PRODUCTS, array('in_auction' => 1),'product_id',$product_result['product_id']);
				}
				else
				{ 
				
				/**
				*Winning SMS
				*DEC26,2012
				**/
					$product_settings=$this->seat_model->select_product_settings();				
					
					//for select bids details to update user amount add jagan march 2
					$bid_results = $this->seat_model->select_seat_booking($product_result['product_id']);
					//end
					
					$this->seat_model->update(SEAT, array('product_process'=>CLOSED,'enddate' => $date),'product_id',$product_result['product_id']);
					$this->seat_model->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' =>$product_result['lastbidder_userid'],'current_price' => $product_result['current_price']),'product_id',$product_result['product_id']);
					
					$users=$this->seat_model->getusersab($product_result['product_id']);

					//for winner mail add jagan march 16
					if(isset($product_result['lastbidder_userid'])) {
						if($product_result['in_auction']!=2) 
						{ 	
							if($seat_settings['email_verification_reg'] == 'Y') 
							{
								$mail_status = $this->custom_win_send_mail($product_result['lastbidder_userid'],$product_result['product_id'],$product_result['product_name'],$product_result['product_amt'],$product_result['current_price'],$product_result['product_url']);
							}
						}
	
	
					}
					
					//added for user amount return to winners add jagan march 2
					if(count($bid_results>0)) 
					{ 
						
						foreach($bid_results as $bids)	
						{ 
							$user = $bids['user_id'];
							
							$amt = $bids['seat_amount'];
							$pid = $bids['product_id'];
							
							//seat amount greater than only return amount to respected user
							if($amt > 0) 
							{ 
								$user_amts = $this->seat_model->select_user_amounts($user);
								$userdetails = $this->seat_model->select_seat_details($pid);
						 		$productname = $userdetails['product_name'];
						 		$productprice = $userdetails['pc'];
						 		$product_currentprice = $userdetails['current_price'];
						 		
								$totals = $user_amts['user_bid_account']+$amt;
								if($product_result['in_auction']!=2) 
								{ 
									$message_status = $this->seat_model->update(USERS,array('user_bid_account'=>$totals),'id',$user);			
									if($seat_settings['email_verification_reg'] == 'Y') 
									{
										$mail_status = $this->custom_closed_send_mail($user,$pid,$productname,$productprice,$product_currentprice,$amt,$userdetails['product_url']);
									}
								}
							
							
							}//end return
						} 

					  } // end
				
				}
				
			}print_r($re);
		}
		exit;
		
	}
	
	//mail send function for add jagan march 16 - winning mail
	public function custom_win_send_mail($userid="", $productid="", $product_name="", $product_cost=0, $product_price=0,$product_url="")
	{
		if($userid!="")
		{  
		$user_details = $this->seat_model->select_user_details($userid);
		
		//Send mail notification for the winning bidders
		$messageforwinner ="Thank you for participation on this auction ".$productid." - ".$product_name."<br/>";
		$messageforwinner .="This message is a confirmation that your bid has been received. There is no need to reply.<br/>";
		$messageforwinner .="<b><u>The details of your bid are included below for your reference:</u></b><br/>";

		$auctioninfo = '<p>';
		
		$auctioninfo .= '<p><b>Auction ID: </b>#'.$productid.'</p>';
		$auctioninfo .= '<p><b>Total Product Cost (Market Price): </b>'.SITECURRENCY.$product_cost.'</p>';	
		$auctioninfo .= '<p><b>Total Product Cost End: </b>'.SITECURRENCY.$product_price.'</p>';	
			
		$auctioninfo .= '<p><b>Winning Notification Message: </b><span style="color:green"> You are the winner of this auction</span></p>';	
		
		$auctioninfo .= '</p>';
		$messageforwinner .=$auctioninfo;
		$this->alternatives = array('##AUCTIONID##' => $product_name,
					    '##MESSAGE##' => $messageforwinner,
					    '##LOGO##' => '<img src="'.$this->logo_image_path.'" width="180"/>',
					    '##NOTIFICATION##' => '',
					    '##SEATSUBJECT##' => 'Winning Seat Auction Mail',
					    '##PRODUCT_URL##' =>URL_BASE.'auctions/view/'.$product_url,
						USERNAME => $user_details['username'],
						TO_MAIL=>$user_details['email']);  

		$this->buyer_replace_variable = array_merge($this->replace_variables,$this->alternatives);

		//send mail to buyer by defining common function variables from here               
		$mail = Commonfunction::get_email_template_details('seat-auction',$this->buyer_replace_variable,SEND_MAIL_TRUE,true);
	 
		}

	}
        
        //mail send function for add jagan march 2 - closed mail
	public function custom_closed_send_mail($userid="", $productid="", $product_name="", $product_cost=0, $product_price=0, $return_price=0,$product_url="")
	{
		if($userid!="")
		{  
		$user_details = $this->seat_model->select_user_details($userid);
		
		//Send mail notification for the winning bidders
		$messageforwinner ="Thank you for participation on this auction ".$productid." - ".$product_name."<br/>";
		$messageforwinner .="This message is a confirmation that your bid has been received. There is no need to reply.<br/>";
		$messageforwinner .="<b><u>The details of your bid are included below for your reference:</u></b><br/>";

		$auctioninfo = '<p>';
		
		$auctioninfo .= '<p><b>Auction ID: </b>#'.$productid.'</p>';
		$auctioninfo .= '<p><b>Total Product Cost (Market Price): </b>'.SITECURRENCY.$product_cost.'</p>';	
		$auctioninfo .= '<p><b>Total Product Current Price: </b>'.SITECURRENCY.$product_price.'</p>';	
			
		$auctioninfo .= '<p><b>Total Product Cost Return: </b>'.SITECURRENCY.$return_price.'</p>';			
		$auctioninfo .= '<p><b>Bid Notification Message: </b><span style="color:green"> Your seat balance was returned to your main account</span></p>';	
		
		$auctioninfo .= '</p>';
		$messageforwinner .=$auctioninfo;
		$this->alternatives = array('##AUCTIONID##' => $product_name,
					    '##MESSAGE##' => $messageforwinner,
					    '##LOGO##' => '<img src="'.$this->logo_image_path.'" width="180"/>',
					    '##NOTIFICATION##' => '',
					    '##SEATSUBJECT##' => 'Seat Amount Returned',
					    '##PRODUCT_URL##' =>URL_BASE.'auctions/view/'.$product_url,
						USERNAME => $user_details['username'],
						TO_MAIL=>$user_details['email']);  

		$this->buyer_replace_variable = array_merge($this->replace_variables,$this->alternatives);

		//send mail to buyer by defining common function variables from here               
		$mail = Commonfunction::get_email_template_details('seat-auction',$this->buyer_replace_variable,SEND_MAIL_TRUE,true);
	 
		}

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
		
		$this->auto_render = false;
		$view=View::factory('seat/'.THEME_FOLDER."auctions/bid_history")
					->bind('bid_histories',$bid_history)
					->bind('user',$this->auction_userid)
					->bind('count',$count);		
		
		//Get the current param id as like get method
		$id=$this->request->param('id');

		$bid_history=$this->auctions->select_bid_history($id);
		$count=count($bid_history);
		echo $view;
		
	}
	
	public function action_confirmseat()
	{
		$this->auto_render = false;
		$json = array();
		$sesuser=$this->auction_userid;
		$pid = Arr::get($_POST,'pid');
		$product_results=$this->seat_model->select_products_user_forbid($pid);	
				
		$view = View::factory('seat/'.THEME_FOLDER."auctions/confirmbid")
					->bind('product_results',$product_results);
										
		$json['popup'] = $view->render();
		echo json_encode($json);
	}
	
	public function action_startauction()
	{
		$this->auto_render = false;
		$json = array();
		$pid = Arr::get($_POST,'pid');
		$this->seat_model->startauction($pid);
		$seat_settings = $this->seat_model->get_seat_site_settings_user(); 
		
		//mail function for start seat auction
		$seat_details = $this->seat_model->select_seat_details($pid); 
		$seat_amt = $seat_details['seat_cost'];
		$productname = $seat_details['product_name'];
		$userids="";
		$seat_det = $this->seat_model->select_seat_userids($pid); 
		foreach($seat_det as $userdet) {
			$userids = $userdet['user_id'];
			if($seat_settings['email_verification_reg'] == 'Y') {
				$mail_status = $this->custom_send_mail_seat($userids,$pid,$productname,$seat_amt,$seat_details['product_url']); 	
			}
		}
		
			
	}
	
	//reduce the user seat amount for bidding
	public function get_user_seat_balance($userid,$proid)
	{ 
		$users=Model::factory('seat');
		$user_balance=$users->get_user_balances($userid,$proid);
		
			return $user_balance;
	}
	
	
	//mail send function for add jagan feb 25
	public function custom_send_mail_seat($userid="", $productid="", $product_name="", $product_price=0,$product_url="")
	{
		if($userid!="")
		{  
		$user_details = $this->seat_model->select_user_details($userid);
		
		//Send mail notification for the winning bidders
		$messageforwinner ="Thank you for booking seat on this auction ".$productid." - ".$product_name."<br/>";
		$messageforwinner .="This message is a confirmation of your Seat Auction has been started. There is no need to reply.<br/>";
		$messageforwinner .="<b><u>The details of your booking are included below for your reference:</u></b><br/>";

		$auctioninfo = '<p>';
		
		$auctioninfo .= '<p><b>Auction ID: </b>#'.$productid.'</p>';
		$auctioninfo .= '<p><b>Seat Cost: </b>'.SITECURRENCY.$product_price.'</p>';	
				
		$auctioninfo .= '<p><b>Starting Seat Auction Notification Message: </b><span style="color:green"> You have been bid in this auction now onwords. All the best....</span></p>';	
		
		$auctioninfo .= '</p>';
		$messageforwinner .=$auctioninfo;
		$this->alternatives = array('##AUCTIONID##' => $product_name,
					    '##MESSAGE##' => $messageforwinner,
					    '##LOGO##' => '<img src="'.$this->logo_image_path.'" width="180"/>',
					    '##NOTIFICATION##' => '',
					    '##SEATSUBJECT##' => 'Seat Auction Starting Notification',
					    '##PRODUCT_URL##' =>URL_BASE.'auctions/view/'.$product_url,
						USERNAME => $user_details['username'],
						TO_MAIL=>$user_details['email']);  

		$this->buyer_replace_variable = array_merge($this->replace_variables,$this->alternatives);

		//send mail to buyer by defining common function variables from here               
		$mail = Commonfunction::get_email_template_details('seat-auction',$this->buyer_replace_variable,SEND_MAIL_TRUE,true);
	 
		}

	}
	
	
	
} // End seat
