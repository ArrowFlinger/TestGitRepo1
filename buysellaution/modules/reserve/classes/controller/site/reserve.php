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
class Controller_Site_Reserve extends Controller_Website {	
	
	public $site_currency = "";
	protected $logo_image_path;
	public function __construct(Request $request, Response $response)
	{		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();	
		
		$this->reserve_model = Model::factory('reserve');
		$this->increment_amount = $this->reserve_model->increments(); 
		if(preg_match('/site\/reserve\/wonproducts/i',Request::detect_uri()))
		{
			$this->template=THEME_FOLDER."template_user_sidebar";
		}
		 $site_name=Commonfunction::get_site_settings();
		$this->logo_image_path=URL_BASE.'public/admin/images/logo.png';
		if(((isset($site_name)) && $site_name[0]['site_logo']) && (file_exists(DOCROOT.LOGO_IMGPATH.$site_name[0]['site_logo']))){
		$this->logo_image_path = URL_BASE.LOGO_IMGPATH.$site_name[0]['site_logo'];}
		 
		$check_reserve = $this->reserve_model->check_reserve_present();
		if(count($check_reserve) <= 0){
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
		$this->is_login();
		$this->auto_render =false;
		//Get values from the ajax fetch
		$callback = Arr::get($_GET,'callback');
		$get=Arr::extract($_GET,array('pid','timestamp','formvalues'));
		
		$id =$get['pid'];		
		$userid=$error_msg="";
		$formarray =array(); 
		foreach($get['formvalues'] as $gets)
		{
			$formarray[$gets['name']] = $gets['value'];	
		}
		/*
		* Single bid
		*/
		$view=View::factory('reserve/'.THEME_FOLDER.'auctions/bid')
				->bind('product_results',$product_results)
				->bind('callback',$callback )
				->bind('error',$error_msg)
				->bind('success',$success_msg)
				->bind('user_bid_count',$bid_count);
		//Select product results with particular id
		$product_results=$this->reserve_model->select_products($id);
		$product_limits=$product_currentprice="";
		$additional_amount=0; 
		$additional=0;
		foreach($product_results as $presults)
		{
			$product_limits = $presults['product_cost'];
			$product_currentprice = $presults['current_price'];
			$user=$presults['userid'];			
		}
		$username="";
		//for random name show bid history
		$namess = $this->auction_username; 
		$usrname = $this->create_randname($namess);
				
		$used="";
		
		//Session user id
		$ses_user=$this->auction_userid;
		$select_bid_history_count=$this->auctions->select_bid_history_count($ses_user,$id);
		
		//Selects users based on session userid
		$user_results=$this->auctions->select_users($ses_user);	 
		$textbox_amount = isset($formarray['bidamount'])?$formarray['bidamount']:"";

		if($textbox_amount!="")
		{ 
			//check whether the enter amount is greater than the current price
			if($textbox_amount>$product_currentprice)
			{
				//defined in website  for incremant range
				$static = $this->increment_amount;

				foreach($static as $key=>$defined)
				{
					$keys=explode('-',$key); 

					//checking the array key exists 
					$arr=array_key_exists(1,$keys); 
					if($arr) 
					{
						if($keys[1]!=0)
						{
							if(($textbox_amount>=$keys[0]) && ($textbox_amount<=$keys[1]))
							{ 
							$additional = $defined; break;
							}
						}
						else
						{
							$additional = $defined; break;
						}

					}
					else
					{ 
						if($textbox_amount>=$keys[0])
						{
							$additional = $defined;break;
						} 
					} 
				}

				//select bid history amounts
				//$bid_history_amts = $this->auctions->select_bid_history_max_amt($id); 
				$bid_history_amt = reserve::get_mybids($id); 
				$bid_amts=0;
				$bid_userid=0;

				//find the reserve bid
				$reserve = 0;

				foreach($bid_history_amt as $bid_history_amts ) 
				{
					$bid_amts = $bid_history_amts['total'];
					$bid_userid = $bid_history_amts['uid']; 
				}
				$success_msg="";
				
				//find the reserve bid condition
				if($textbox_amount > $bid_amts)
				{
					$reserve = 1;
				}

				//entered amount is less than the last highest bid amount
				if($textbox_amount < $bid_amts)
				{ 
					$additional_amount = $additional+$textbox_amount;
					$success_msg=__('your_bid_recorded_not_winner');
				}
				
				//entered amount is equal to highest bid amount
				else if($textbox_amount == $bid_amts)
				{ 
				//same user bid same amount again and again
				if($ses_user == $bid_userid) 
				{ 
					$additional_amount = $additional+$bid_amts;
					$success_msg=__('your_bid_recorded_winner');
				}
				else
				{ 
					$additional_amount = $additional+$bid_amts;
					$success_msg=__('your_bid_recorded_not_winner');
				}

				}
				
				//highest bid amount less than the current price
				else if($product_currentprice>$bid_amts) 
				{ 
					$additional_amount = $additional+$product_currentprice;
					$success_msg=__('your_bid_recorded_winner');
				}
				
				//entered amount greaterthan last highest bid amount
				else
				{
					$additional_amount = $additional+$bid_amts;
					$success_msg=__('your_bid_recorded_winner');
				}
				
				//first time bid message shows
				if($bid_amts=="")
				{
					$success_msg=__('your_bid_recorded_winner');
				}
				else
				{	
					$success_msg=$success_msg; 
				}

				if($product_results)
				{ 
					foreach($product_results as $product_result)
					{	
						if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['auction_process']!=HOLD)
						//if item not in closed
						{	 

							//collecting all values in variable
							$current_price=$product_result['current_price'];

							/*$bid_incremental_price=$product_result['bidamount']; */

							//pass the textbox amount
							$now_price=$additional_amount;

							$item_max_time=$product_result['max_countdown'];

							//Update Time stamp for product
							$arr=array( /*'increment_timestamp'=>$time,*/ 'current_price'=>$now_price,'lastbidder_userid'=>$this->auction_userid);

							//select mail verification for reserve bid
							$mail_active = $this->reserve_model->get_reserve_site_settings_user();
							
							if($mail_active['email_verification_reg']=='Y') 
							{ 
								
								if(($ses_user != $bid_userid) && ($textbox_amount> $bid_amts)) {

								//Send mail notification for the winning bidders
								$messageforwinner ="Thank you for bidding in auction ".$product_result['product_id']." - ".$product_result['product_name']."\r\n";
								$messageforwinner .="This message is a confirmation that your bid has been received. There is no need to reply.\r\n\r\n";
								$messageforwinner .="<b><u>The details of your bid are included below for your reference:</u></b>";

								$auctioninfo = '<p>';
								$auctioninfo .= '<p><b>Auction Description: </b>'.Text::limit_chars($product_result['product_info'],150).'</p>';
								$auctioninfo .= '<p><b>Auction ID: </b>#'.$product_result['product_id'].'</p>';
								$auctioninfo .= '<p><b>Current Bid: </b>'.$this->site_currency." ".$product_result['current_price'].'</p>';				
								$auctioninfo .= '<p><b>Your Bid: </b>'.$this->site_currency." ".$textbox_amount.'</p>';
								$auctioninfo .= '<p><b>Bid Notification Message: </b><span style="color:green"> Your are current winner of this auction</span></p>';				
								$auctioninfo .= '<p><b>Auction EndDate: </b>'.$product_result['enddate'].'</p>';
								$auctioninfo .= '</p>';
								$messageforwinner .=$auctioninfo;
								$this->alternatives = array('##AUCTIONID##' => $product_result['product_name'], '##LOGO##' => '<img src="'.$this->logo_image_path.'" width="180"/>','##NOTIFICATION##' => '','##PRODUCT_URL##' =>URL_BASE.'auctions/view/'.$product_result['product_url'],'##MESSAGE##' => $messageforwinner,
								USERNAME => $user_results[0]['username'],TO_MAIL=>$user_results[0]['email']);

								$this->buyer_replace_variable = array_merge($this->replace_variables,$this->alternatives);

								//send mail to buyer by defining common function variables from here               
								$mail = Commonfunction::get_email_template_details('reserve-notification',$this->buyer_replace_variable,SEND_MAIL_TRUE,true); 
								if($bid_userid!="") { 
								//Send mail notification for the outbid bidders
								$messageforoutbid ="Notification for the auction ".$product_result['product_id']." - ".$product_result['product_name']."\r\n";
								$messageforoutbid .="This message is to notify the current status of the auction.\r\n\r\n";
								$messageforoutbid .="<b><u>The details of auction are included below for your reference:</u></b>";

								$auctioninfo = '<p>';
								$auctioninfo .= '<p><b>Auction Description: </b>'.Text::limit_chars($product_result['product_info'],150).'</p>';
								$auctioninfo .= '<p><b>Auction ID: </b>#'.$product_result['product_id'].'</p>';
								$auctioninfo .= '<p><b>Current Bid: </b>'.$this->site_currency." ".$additional_amount.'</p>';				
								//$auctioninfo .= '<p><b>Your Bid: </b>'.$textbox_amount.'</p>';
								$auctioninfo .= '<p><b>Bid Notification Message: </b><span style="color:red">Your are outbid of the auction</span></p>';				
								$auctioninfo .= '<p><b>Auction EndDate: </b>'.$product_result['enddate'].'</p>';
								$auctioninfo .= '</p>';
								$messageforoutbid .=$auctioninfo;
								$user_results_previous=$this->auctions->select_users($bid_userid); 
								$this->alternatives = array('##AUCTIONID##' => $product_result['product_name'], '##LOGO##' => '<img src="'.$this->logo_image_path.'" width="180"/>','##NOTIFICATION##' => '','##PRODUCT_URL##' =>URL_BASE.'auctions/view/'.$product_result['product_url'],'##MESSAGE##' => $messageforoutbid,
								USERNAME => $user_results_previous[0]['username'],TO_MAIL=>$user_results_previous[0]['email']);

								$this->buyer_replace_variable = array_merge($this->replace_variables,$this->alternatives);

								//send mail to buyer by defining common function variables from here               
								$mail = Commonfunction::get_email_template_details('reserve-notification',$this->buyer_replace_variable,SEND_MAIL_TRUE,true);
								}
								}
							}
							

							$update = $this->auctions->update_product_time(RESERVE,$arr,$id); 
							if($update)
							{
								//Check condition of lastbidder in product auction and insert into bid historytable
								$insertee=$this->commonmodel->insert(RESERVE_BIDHISTORY,array('user_id' => $this->auction_userid,'product_id'=>$product_result['product_id'],'price'=>$now_price,'bid_amount'=>$textbox_amount,'reservestatus'=>$reserve,'bidder_name'=>$usrname,'date'=>$this->getCurrentTimeStamp));
							}



						}
						else
						{
							$error_msg=__('no_bids_to_be_added');
						}
					}
				}
			}
		    else
		    {
		    	$error_msg=__('enter_amount_is_lessthan');
		    }
		}
		else
		{
			$error_msg=__('enter_amount');
		}

		echo $view;//Prints the view
	}
	
	public function action_bidhistories()
	{ 
		$this->auto_render = false;
		$view=View::factory('reserve/'.THEME_FOLDER.'auctions/bid_history')
					->bind('bid_histories',$bid_history)
					->bind('user',$this->auction_userid)
					->bind('count',$count);		
		
		//Get the current param id as like get method
		$id=arr::get($_GET,'pid');

		$bid_history=$this->reserve_model->select_bid_history($id);
		 
		 
		$count=count($bid_history);
		echo $view; 
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
		$pid=isset($datas['pid'])?(int)substr(strstr($datas['pid'],"_"),1):1;
		$result=$this->reserve_model->select_products_to_update($status,$pid,$date);
		
		/* For sending sms in last bid user
		* Dec26, 2012
		**/
		
		
		if(count($result)>0){
			foreach($result as $product_result)
			{	
				
				$now=$this->create_timestamp($date);
				$db_date=$this->create_timestamp($product_result['startdate']);
				$db_end_date=$this->create_timestamp($product_result['enddate']);
				if($status!=3)
				{
					
					$timestamp=time()+$product_result['max_countdown'];
					$this->reserve_model->update(RESERVE, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$product_result['product_id']);
					$this->reserve_model->update(PRODUCTS, array('in_auction' => 1),'product_id',$product_result['product_id']);
				}
				else
				{
					
				/**
				*Winning SMS
				*DEC26,2012
				**/
				$product_settings=$this->reserve_model->select_product_settings();
								
					$this->reserve_model->update(RESERVE, array('product_process'=>CLOSED,'enddate' => $date),'product_id',$product_result['product_id']);
					$this->reserve_model->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' =>$product_result['lastbidder_userid'],'current_price' => $product_result['current_price']),'product_id',$product_result['product_id']);
					
					$users=$this->reserve_model->getusersab($product_result['product_id']);
					
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
	
	
	public function action_wonproducts()
	{ 
		$this->selected_page_title= __("auction_reserve_won");
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
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));
		foreach($this->reserve_model->getproductswon($offset, REC_PER_PAGE) as $wonauction)
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
							       'userid' => $wonauction['userid'],							       
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
	
	public function action_gctest()
	{
		$this->auto_render =false;
		$cartitems = array(array('itemname'=>'Mobile9','itemdescription' =>'Mobile 9 Description','quantity' =>10,'price' =>40));
		$gc = new Gc('sandbox');
		$gc->standard($cartitems);
		echo $gc->renderbutton(1);
	}
	
	public function action_gcresponse()
	{
		$this->auto_render = false;
		DB::insert(USERS_ONLINE,array('session'))->values(array(serialize($_REQUEST)))->execute();
	}
	
	
} // End Reserve
