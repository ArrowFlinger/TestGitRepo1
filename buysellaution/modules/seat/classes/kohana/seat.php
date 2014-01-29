<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Modulename — My own custom module.
 *
 * @package    Commonfunction
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Kohana_Seat extends Controller_Website {
	
	/**
	* @var array configuration settings
	*/
	protected $_config = array();
	protected $_seat ;
	protected $_userid;

	/**
	* Class Main Constructor Method
	* This method is executed every time your module class is instantiated.
	*/
	public function __construct() 
	{	
		
		$this->session=Session::instance();
		$this->seat_model = Model::factory('seat');	
		$this->checking_time=CHECKING_TIME;
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		$this->site_currency =SITECURRENCY;
		$this->update_autobid_account();
		$this->_userid=$this->session->get('auction_userid');
		$site_name=Commonfunction::get_site_settings();
		$this->logo_image_path=URL_BASE.'public/admin/images/logo.png';
if(((isset($site_name)) && $site_name[0]['site_logo']) && (file_exists(DOCROOT.LOGO_IMGPATH.$site_name[0]['site_logo']))){
		$this->logo_image_path = URL_BASE.LOGO_IMGPATH.$site_name[0]['site_logo'];}

	
	}
	
	public function timediff($time)
	{
		$tDiff = $time - time();
		$days = floor($tDiff / 86400);//Calc Days
		$hours = ($tDiff / 3600) % 24;//Calc hours
		$mins = ($tDiff / 60) % 60;//Calc mins
		$secs = ($tDiff) % 60;//Calc Secs
		return array('day' => $days , 'hr' => $hours , 'min' => $mins, 'sec' => $secs);
	}
	
	/**
	 * ****Checking current status of the auction item****
	 * @param $sdate , $edate eg. 2011-11-16 20:15:00
	 * @return 0 1 2
	 */	
	public function currentstatus($sdate,$edate)
	{
		$currentdate=$this->getCurrentTimeStamp;
		$today=date("Y-m-d")." "."23:59:59";
		if($sdate > $currentdate)
		{
			return 0;//Coming soon
		}
		else if($sdate < $currentdate)
		{
			return 1;//live
		}
		else if($edate < $currentdate)
		{
			return 2;//closed
		}
		
	}
	
	public function update_autobid_account()
	{
		
		$result=$this->seat_model->selectall_autobid_closed();
		
		foreach($result as $products)
		{
			if($products['dedicated_auction']!=ENABLE){
				//get user balance and add the amount
				$amts= Commonfunction::get_user_balance($products['userid']) + $products['bid_amount'];
			}
			else
			{
				//get user bonus and add the amount
				$amts=Commonfunction::get_user_bonus($products['userid'])+$products['bid_amount'];	

			}			
			$this->seat_model->update(USERS,array('user_bid_account'=>$amts),'id',$products['userid']);
			$this->seat_model->delete_autobid($products['userid'],$products['product_id']);
		}
		return;
	}
	
	public function process($pid,$status=1,$array=array())
	{				
	
		$product_results = $this->seat_model->select_products_detail($pid,$status,$array);
		
		$array=array();	
		foreach($product_results  as $product_result)
		{
			if($this->getCurrentTimeStamp<=$product_result['enddate'])
			{
				if($product_result['auction_process']==RESUMES)
				{
					//Decrement the db timestamp with current timestamp (unix timestamp e.g: 1236545888)
					$time_stamp=$product_result['increment_timestamp']-time();					
				}
				else if($product_result['auction_process']==HOLD)
				{
					//increment the db timestamp when holded (unix timestamp e.g: 1236545888)
					$time_stamp=$product_result['increment_timestamp']+20;
					$current_status=3;
					$time=__('paused');
				}
				$time_stamp=$product_result['increment_timestamp']-time();
				$current_status=$this->currentstatus($product_result['startdate'],$product_result['enddate']);
				$today=$this->today_midnight();
				$status=($today>$product_result['increment_timestamp'])?__("start_on_label_today")." ".substr($this->date_to_string($product_result['startdate']),7,20):__("start_on_label")." ".$this->date_to_string($product_result['startdate']);
						$resume_time=($today>$product_result['increment_timestamp'])?substr($this->date_to_string($product_result['startdate']),7,20):$this->date_to_string($product_result['startdate']);
						
				if(($product_result['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH_THUMB.$product_result['photo']))
				{ 
					$user_img_path=URL_BASE.USER_IMGPATH_THUMB.$product_result['photo'];
				}
				else
				{
					$user_img_path=IMGPATH.USER_NO_IMAGE;
				}
				
				//select seat booking
				$seat_booking = $this->seat_model->select_seat_booking($product_result['product_id']);
				$buy_seats = count($seat_booking); 
				
				//get seat booked user ids
				$booked_seat_user_ids = $this->get_buy_seat_userids($product_result['product_id']);
				
				//select user seat amounts
				$user_seat_amount=$this->seat_model->get_user_balances($this->_userid,$product_result['product_id'],$this->site_currency); 
				
				$array[]= array("Product"=> array("id"=>$product_result['product_id'],
								"buy_seats" => $buy_seats,
								"session_seat_user" => $this->_userid,
								"booked_seat_user_id" => $booked_seat_user_ids,
								"user_seat_amount" => $this->site_currency." ".$user_seat_amount,
								"user_seats_amt" => $user_seat_amount,
								"minimun_limit"=>$product_result['min_seat_limit'],
								"maximum_limit"=>$product_result['max_seat_limit'],
								'auction_started' => $product_result['auction_started'],
								"currency"=>$this->site_currency,
								"current_price"=>$this->site_currency." ".Commonfunction::numberformat($product_result['current_price']),
								"price" =>Commonfunction::numberformat($product_result['current_price']),
								"current_status" =>$current_status,
								"extras"=>array('bidamount' => $product_result['bidamount'],'product_cost'=> $product_result['product_cost']),
								"status"=>$status,
								"auction_type" => $product_result['auction_type'],
								"resume_time" =>$resume_time,
								"db_timestamp" => $product_result['increment_timestamp'],
								"element" =>"auction_".$product_result['product_id'],
								"lastbidder"=>$product_result['lastbidder_userid'],
								"user_img" =>$user_img_path,
								"autobid" =>$product_result['autobid'],
								"time_diff" => $this->timediff($product_result['increment_timestamp']),
								"unix_timestamp" =>$this->create_timestamp($this->getCurrentTimeStamp),
								"element"=>"auction_".$product_result['product_id'],								
								"checking_time" =>$this->checking_time),
								"settingIncrement" => array("countdown"=>time()+$product_result['max_countdown'],
									//'time_left'=>$time,
									'timestamp' =>$time_stamp),
								"Users"=>array("username"=>ucfirst(Text::limit_chars($product_result['username'],12)),
								"lat"=>$product_result['latitude'],
								"lng"=>$product_result['longitude']));	
}
}
return $array;
		
	}
	
		
	public static function product_block($pids,$status="",$arrayset=array())
	{ 
		$seat = Model::factory('seat');		
		$productsresult = $seat->select_products_detail($pids,$status,$arrayset);
		$seat_close = new kohana_seat();
		$seat_close_product = $seat_close->updateproduct_seat($pids);
		
		switch($status)
		{
			case 3:
			$view = View::factory('seat/'.THEME_FOLDER.'auctions/future')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 6:
			$view = View::factory('seat/'.THEME_FOLDER.'auctions/product_detail')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 2:
			$view = View::factory('seat/'.THEME_FOLDER.'auctions/closed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 10:
			$view = View::factory('seat/'.THEME_FOLDER.'auctions/winner')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
							
			//venkatraja added by category products				
			case 7:
			$view = View::factory('seat/'.THEME_FOLDER.'auctions/closedunclosed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;		
											
			case 8:
			$view = View::factory('seat/'.THEME_FOLDER.'auctions/closedunclosed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
                        case 11:
			$view = View::factory('seat/'.THEME_FOLDER.'auctions/buynow')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			default:
			$view = View::factory('seat/'.THEME_FOLDER.'auctions/live')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
		}					
		return $view->render();
	}
	
	
	public static function get_buy_seatcount($pid)
	{
		$seat = Model::factory('seat');	
		$seat_booking = $seat->select_seat_booking($pid);
		
		return count($seat_booking);
	
	}
	
	public function get_buy_seat_userids($pid)
	{
		$seat = Model::factory('seat');	
		$seat_booking = $seat->select_seat_booking($pid);
		$user_ses_id = new kohana_seat();
		$booked_ids="";
		foreach( $seat_booking as $bookings ) {
		
			$bookids = $bookings['user_id'];
			
			if($bookids == $user_ses_id->_userid) {
			
				$booked_ids = $user_ses_id->_userid;
			}
			
		}
		
		return $booked_ids;
	}
	
	// check seat close
	public function updateproduct_seat($pid)
	{
		$date= $this->getCurrentTimeStamp;
		
		$result=$this->seat_model->select_seat_array_details($pid);

	//print_r($seat_settings); 	
		/* For sending sms in last bid user
		* Dec26, 2012
		**/
		
		if(count($result)>0){
			
			foreach($result as $product_result)
			{ 
				//select seat booking
				$seat_booking = $this->seat_model->select_seat_booking($product_result['product_id']);
				$buy_seats = count($seat_booking); 
		//print_r($buy_seats);
				if(($product_result['min_seat_limit'] >= $buy_seats) && ($date > $product_result['seat_enddate']))
				{ //echo "asdfas fasf asfsfd";
					//for select bids details to update user amount add jagan march 2
					$bid_results = $this->seat_model->select_seat_booking($product_result['product_id']);
					//end
				
					$this->seat_model->update(SEAT, array('product_process'=>CLOSED,'enddate' => $date),'product_id',$product_result['product_id']);
					$this->seat_model->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' =>"786".$product_result['lastbidder_userid'],'current_price' => $product_result['current_price']),'product_id',$product_result['product_id']);

					//added for user amount return to winners add jagan march 2
					if(count($bid_results>0)) 
					{ 
					
						foreach($bid_results as $bids)	
						{ 
							$user = $bids['user_id'];
						
							$amt = $bids['seat_amount'];
							$pid = $bids['product_id'];
						
							//seat amount greater than only return amount to respected user
							if($amt > 0) {
							$user_amts = $this->seat_model->select_user_amounts($user);
							$userdetails = $this->seat_model->select_seat_details($pid);
					 		$productname = $userdetails['product_name'];
					 		$productprice = $userdetails['pc'];
					 		$product_currentprice = $userdetails['scp'];
					 		
							
							$totals = $user_amts['user_bid_account']+$amt;
							if($product_result['in_auction']!=2) 
							{ 
								$message_status = $this->seat_model->update(USERS,array('user_bid_account'=>$totals),'id',$user);			
								$user_delete = $this->seat_model->delete_seat_booking($user,$pid);
								$seat_settings = $this->seat_model->get_seat_site_settings_user();

								if($seat_settings['email_verification_reg'] == 'Y') 
								{ 
									$mail_status = $this->custom_closed_send_mail($user,$pid,$productname,$productprice,$product_currentprice,$amt,$userdetails['product_url']);
								}
							}
							
						
							}//end return
						} 

					  } // end
				
				}
			}	
			
		}

		
	}
	
	//mail send function for add jagan march 2
	public function custom_closed_send_mail($userid="", $productid="", $product_name="", $product_cost=0, $product_price=0, $return_price=0,$product_url="")
	{ 
		if($userid!="")
		{  
		$user_details = $this->seat_model->select_user_details($userid);
		
		//Send mail notification for the winning bidders
		$messageforwinner ="Thank you for bidding in auction ".$productid." - ".$product_name."<br/>";
		$messageforwinner .="This message is a confirmation that your bid has been received. There is no need to reply.\r\n\r\n";
		$messageforwinner .="<b><u>The details of your bid are included below for your reference:</u></b>";

		$auctioninfo = '<p>';
		
		$auctioninfo .= '<p><b>Auction ID: </b>#'.$productid.'</p>';
		$auctioninfo .= '<p><b>Total Product Cost (Market Price): </b>'.SITECURRENCY.$product_cost.'</p>';	
		$auctioninfo .= '<p><b>Total Product Current Price: </b>'.SITECURRENCY.$product_price.'</p>';	
			
		$auctioninfo .= '<p><b>Total Product Cost Return: </b>'.SITECURRENCY.$return_price.'</p>';			
		$auctioninfo .= '<p><b>Bid Notification Message: </b><span style="color:green"> Your seat balance was returned to your main account </span></p>';	
		
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

		//common config variables and values in array	
		//
		$ssl = ($_SERVER['SERVER_PORT'] == PORT)?HOST_HTTPS:HOST_HTTP;
		$this->url = $ssl.$_SERVER['HTTP_HOST'];
		$site_name=Commonfunction::get_site_settings();
		$sitename =$site_name[0]['site_name'];	
		$this->replace_variables = array(SITE_NAME => $sitename ,SITE_URL => $this->url, SITE_LINK => $this->url,
			  	CONTACT_MAIL => $site_name[0]['common_email_from'],FROM_EMAIL => $site_name[0]['common_email_from']);
              //
             
		$this->buyer_replace_variable = array_merge($this->replace_variables,$this->alternatives);

		//send mail to buyer by defining common function variables from here               
		$mail = Commonfunction::get_email_template_details('seat-auction',$this->buyer_replace_variable,SEND_MAIL_TRUE,true);
	 
		}

	}
	
	static public function loadmedia()
	{
		$media = array(); 
		$media['styles_blue'] = array();
		$media['scripts_blue'] = array(URL_BASE.'public/js/jquery.jcarousel.pack.js');
		
		
		//$media['style_black'] = array(CSSPATH.'ui-lightness/jquery-ui-1.8.16.custom.css'=>'screen');
		$media['scripts_black'] = array(URL_BASE.'public/js/jquery.jcarousel.pack.js');
		
		$media['scripts_orange'] = array(URL_BASE.'public/js/jquery.jcarousel.pack.js' ); 
		$media['styles_orange'] = array( );
		
		 
		return $media;
	}
}
