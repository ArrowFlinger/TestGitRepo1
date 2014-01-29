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
class Controller_Site_Lowestunique extends Controller_Website {	
	
	public $site_currency = "";
	public function __construct(Request $request, Response $response)
	{		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();	
		
		$this->lowestunique_model = Model::factory('lowestunique');
		if(preg_match('/site\/lowestunique\/lowest_mybids/i',Request::detect_uri()))
		{
			//Override the template variable decalred in website controller  
                        $this->template=THEME_FOLDER."template_user_sidebar";
                }	
		$check_lowest = $this->lowestunique_model->check_lowestunique_present();
		if(count($check_lowest) <= 0){
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
		$get=Arr::extract($_GET,array('pid','timestamp','formvalues'));
		
		$formvalues=array();
		
		foreach ($get['formvalues'] as $values){
		$formvalues[$values['name']]=$values['value'];
		}
		 
		
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
			$product_results=$this->lowestunique_model->select_products_user_forbid($id);			
							
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
								//$bidtime=$product_result['bidding_countdown'];
								$p_time=$product_result['increment_timestamp'];
	
								
								$now_price=$current_price+$bid_incremental_price;
								
								//$now_price=$bid_incremental_price;
								
								
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
								$update=$this->lowestunique_model->update_autobid($ses_user,$id,$bid_count);
								//Update Time stamp for product
								$arr=array('increment_timestamp'=>$time,'current_price'=>$now_price,'lastbidder_userid'=>$ses_user);
								
								$update=$this->auctions->update_product_time(LOWESTUNIQUE,$arr,$id);
	
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
			$product_results=$this->lowestunique_model->select_products($id);
			
					
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
					if($product_result['startdate']<=$this->getCurrentTimeStamp && $product_result['auction_process']!=HOLD  && $product_result['enddate'] >=$this->getCurrentTimeStamp && $get['timestamp'] > -CHECKING_TIME && trim($formvalues['totalbidamount'])!='' && trim($formvalues['range1'])!='')//if item not in closed
					{
						if (preg_match('#^\d+(?:\.\d{1,2})?$#', $formvalues['range1'], $match)){						
						 
					if(( $formvalues['range1']>0) && $formvalues['range1']<=200)
					{					
						 
						if($select_bid_history_count>0)	
						{ 
							$select_bid_history_lastamt=$this->auctions->select_bid_history_last_amt($ses_user,$id);
							
							$c_price=$product_result['current_price'];
						}
						else
						{
						
							$c_price=$product_result['current_price'];
						}
							
						if($userid=="" || $auto_bidexists==0){   
							//checks if it has bonus enabled				
							if($product_result['dedicated_auction']==ENABLE)
							{ 
								//Highest Unique Oct -09
								//$bid_count=$user_results[0]['user_bonus']-($c_price+$formvalues['totalbidamount']);
								$bid_count=$user_results[0]['user_bonus']-($formvalues['totalbidamount']);
						                
								//add this text on error message for bonus bidding	
								$used="Bonus";
							}
							//checks if it has bonus is disabled	
							if($product_result['dedicated_auction']!=ENABLE)
							{
								//Highest Unique Oct -09
								$bid_count=$user_results[0]['user_bid_account']-($formvalues['totalbidamount']);				
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
						                                                  
							if($ses_user!=$product_result['lastbidder_userid'] )
							{   
							    									
								//collecting all values in variable
								$current_price=$product_result['current_price'];
								//Highest Unique Oct -09
								
								$item_max_time=$product_result['max_countdown'];
								//$bidtime=$product_result['bidding_countdown'];
								$p_time=$product_result['increment_timestamp'];				
								
								// Adding the current auction price and Bid incremental price
								if($formvalues['single']=='5'){

								$now_price=$current_price+$formvalues['totalbidamount']+$formvalues['range1'];
								$now_price_present=$current_price+$formvalues['totalbidamount'];
								}else{
								$now_price_present=$current_price+$formvalues['totalbidamount'];

								}
								//Calculating difference from the product time (unix timestamp)	with current(unix timestamp)
								$time_diff=$p_time-time();
								
							        $cal=$time_diff;
	
								//Checking current countdown with max time set in product.
								if($cal < $item_max_time && $time_diff > 0)
								{	
									 $time=$cal+time();
								}
								else if($time_diff <= 0 && $time_diff > -CHECKING_TIME )
								{
									 
									   $time=time(); 	
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
								$arr=array('increment_timestamp'=>$time,'current_price'=>$now_price_present,'lastbidder_userid'=>$ses_user);
								$this->auctions->update_product_time(LOWESTUNIQUE,$arr,$id);
	
								//Check condition of lastbidder in product auction and insert into bid historytable
								if($userid!="")
								{
							
									$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$bid_incremental_price,'bid_type'=>'AB','date'=>$this->getCurrentTimeStamp));
								}
								else
								{
			
								$i=1;
								for($i=1;$i<=$formvalues['length'];$i++){
								$bid_incremental_price= $formvalues['range'.$i];		
								
																		
									$this->commonmodel->insert(BID_HISTORIES,array('user_id' => $ses_user,'product_id'=>$product_result['product_id'],'price'=>$bid_incremental_price,'bid_type'=>'SB','date'=>$this->getCurrentTimeStamp));
									}
				
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
						 
						$error_msg=__('bids_amount_greaterthan_zero_and_lessthan_zero');
					}
						
			}else
			{
				//echo $formvalues['range1'] . ' is NOT valid!';
				$error_msg=__('Enter only numeric value');
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
		$result=$this->lowestunique_model->select_products_to_update($status,$pid,$date);
		if(count($result)>0){
			foreach($result as $product_result)
			{	
				
				$now=$this->create_timestamp($date);
				$db_date=$this->create_timestamp($product_result['startdate']);
				$db_end_date=$this->create_timestamp($product_result['enddate']);
				if($status!=3)
				{
					
					$timestamp=time()+$product_result['max_countdown'];
					$this->lowestunique_model->update(LOWESTUNIQUE, array('increment_timestamp'=>$timestamp,'product_process'=>LIVE),'product_id',$product_result['product_id']);
					$this->lowestunique_model->update(PRODUCTS, array('in_auction' => 1),'product_id',$product_result['product_id']);
				}
				else
				{					
									
					$this->lowestunique_model->update(LOWESTUNIQUE, array('product_process'=>CLOSED,'enddate' => $date),'product_id',$product_result['product_id']);
					$this->lowestunique_model->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' => $product_result['lastbidder_userid'],'current_price' => $product_result['current_price']),'product_id',$product_result['product_id']);
					
					$users=$this->lowestunique_model->getusersab($product_result['product_id']);
					
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
		
		$view = View::factory('lowestunique/'.THEME_FOLDER.'auctions/bid_history')
					->bind('bid_histories',$bid_history)					
					->bind('user',$this->auction_userid)
					->bind('pagination',$pagination)
					->bind('bid_unique',$bid_unique)
					->bind('bid_not_unique',$bid_not_unique)
					->bind('bid_history_all',$bid_history_all)						
					->bind('count',$count);	
		$id=$this->request->param('id');
		
		$bid_unique=$this->lowestunique_model->select_bid_unique($id);
		
		$bid_not_unique=$this->lowestunique_model->select_bid_not_unique($id);
		//Session uesr
		$bid_history=$this->lowestunique_model->select_bid_history($id,$this->auction_userid);
		//All usesrs
		$bid_history_all=$this->lowestunique_model->select_bid_history_all($id);	
	        //Last insert id
		$last_insertid=$this->lowestunique_model->last_insertid($id);	
				
		$count=count($bid_history);	
		echo $view;
		exit;		
	}


        /**
	* Action for Bid history

	* Ajax page
	**/
	public function action_bid_history_all()
	{
		
		$view = View::factory('lowestunique/'.THEME_FOLDER.'auctions/allusersbidhistory')
					->bind('bid_histories',$bid_history)					
					->bind('user',$this->auction_userid)
					->bind('pagination',$pagination)
					->bind('bid_unique',$bid_unique)
					->bind('bid_not_unique',$bid_not_unique)
					->bind('bid_history_all',$bid_history_all)						
					->bind('count',$count);	
		$id=$this->request->param('id');
		
		$bid_unique=$this->lowestunique_model->select_bid_unique($id);
		
		$bid_not_unique=$this->lowestunique_model->select_bid_not_unique($id);
		//Session uesr
		$bid_history=$this->lowestunique_model->select_bid_history_all_users($id,$this->auction_userid);
		//All usesrs
		$bid_history_all=$this->lowestunique_model->select_bid_history_all($id);	
	        //Last insert id
		$last_insertid=$this->lowestunique_model->last_insertid($id);	
				
		$count=count($bid_history);	
		echo $view;
		exit;		
	}


	/**
	* Action for users won auctions Lowest unique bid
	*/
	public function action_unique_auctions()
	{
		
		$this->is_login();
		//$users=Model::factory('users');
		$view=View::factory('lowestunique/'.THEME_FOLDER.'auctions/unique_won_auctions')
				->bind('users',$users)
				->bind('count_user_wonauctions',$count_user_wonauctions)
				->bind('wonauctions_results',$wonauctions_results)
				->bind('usersid',$this->auction_userid)
				->bind('pagination',$pagination);				
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;			
 			$count_user_wonauctions=$this->lowestunique_model->count_unique_lowest_bidder($this->auction_userid);
		
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_user_wonauctions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => 'pagination/punbb_userside',  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));  		
		
		$wonauctions_results=$this->lowestunique_model->unique_lowest_bidder($offset,REC_PER_PAGE,$this->auction_userid);
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	/*My Bids
        *Bid History
         */
	public function action_lowest_mybids()
	{
		$this->selected_page_title= __("placed_unique_bid_product");
		$this->is_login();
		$view=View::factory('lowestunique/'.THEME_FOLDER.'auctions/lowest_mybids')
				->bind('bidhistories',$bidhistory)
				->bind('count_bidhistory',$count_bidhistory)
				->bind('total_count',$total_count)
				->bind('pagination',$pagination);
		
		$count_bidhistory=$this->lowestunique_model->select_bids_for_users_lowest_unique(NULL,REC_PER_PAGE,$this->auction_userid,TRUE);
		//pagination loads here
			$page=Arr::get($_GET,'page');
			if($page<0)
			{
				$this->url->redirect('users/lowest_mybids');
			}
			$page_no= isset($page)?$page:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_bidhistory,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
		$bidhistory=$this->lowestunique_model->select_bids_for_users_lowest_unique($offset,REC_PER_PAGE,$this->auction_userid);	
		$this->template->content = $view;
	        $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
} // End lowestunique
