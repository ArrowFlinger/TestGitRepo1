<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains Dashboard(User Deatails,Product Details) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Dashboard extends Controller_Welcome 
{

	/**
	 * ****action_index()****
	 * @return user listings  view with pagination
	 */
	 
	public function action_index()
	{
		//set page title
		$this->page_title =  __('menu_dashboard');
		$this->selected_page_title = __('menu_dashboard');
		//auth login check
		$this->is_login();
		$the_date=array();
		for ($i = 0; $i < 30; $i++)
		{
			$timestamp = time();
			$tm = 86400 * $i; // 60 * 60 * 24 = 86400 = 1 day in seconds
			$tm = $timestamp - $tm;
			$the_date[] = date("M/d", $tm);
		}
		$last_30days_transaction =  $this->dashboard->get_last_30days_transaction();
		
		$a=array();
		foreach($last_30days_transaction as $transaction)
		{
			$create_date=$transaction['transaction_dates'];
			//echo $create_date;exit;
			$a[$create_date]=$transaction['totaltrans'];
		}
		foreach($the_date as $dates)
		{
			if(!isset($a[$dates]))
			{
				$a[$dates]=0;
			}
		}
		/*
		for last 12 months user count
		*/
		$last_12months_userscount =  $this->dashboard->get_last_12months_users_count();					
		
		for ($i = 0; $i <= 11; $i++) 
		{			
			$month = strtotime("-$i months");		
			$months_user[] = date("M/Y", $month);
		}		
		$b_user=array();				
		foreach($last_12months_userscount as $mon)
		{
			$create_month=$mon['monthname'];
	
			$b_user[$create_month]=$mon['totaluser'];
		} 
		foreach($months_user as $mo)
		{
			if(!isset($b_user[$mo]))
			{
				$b_user[$mo]=0;
			}
		}
		$gettodays_users_count =  $this->dashboard->get_todays_users_count();
		foreach($gettodays_users_count as $keyy=>$vall)
		{$todays_users_count=$vall;}
		
		$get_7days_users_count =  $this->dashboard->get_last_7days_users_count();
		foreach($get_7days_users_count as $keyy=>$vall)
		{$get7days_users_count=$vall;}
		
		$get_30days_users_count =  $this->dashboard->get_last_30days_users_count();
		foreach($get_30days_users_count as $keyy=>$vall)
		{$get30days_users_count=$vall;}
		
		$get_1year_users_count =  $this->dashboard->get_last_1year_users_count();
		foreach($get_1year_users_count as $keyy=>$vall)
		{$get1year_users_count=$vall;}
		
		$get_10years_users_count =  $this->dashboard->get_last_10years_users_count();
		foreach($get_10years_users_count as $keyy=>$vall)
		{$get10years_users_count=$vall;}

		$get_web_customers_count =  $this->dashboard->total_normal_users();
		foreach($get_web_customers_count[0] as $keyy=>$vall){$get_total_web_customers_count=$vall;}
					
		$total_facebook_users =  $this->dashboard->total_facebook_users();
		foreach($total_facebook_users as $total_fb_users)
		{$tfb[0]=$total_fb_users['total'];}
		$total_fb_users=$tfb[0];				
		$total_twitter_users =  $this->dashboard->total_twitter_users();
		foreach($total_twitter_users as $total_tw_users)
		{$ttw[0]=$total_tw_users['total'];}
		$total_tw_users=$ttw[0];

		$view = View::factory('admin/dashboard')
									->bind('title',$title)
									->bind('last_30_days',$the_date)											
									->bind('last_30_days_values',$a)										
									//->bind('last_12_months',$months)
									->bind('last_12_months_user',$months_user)
									->bind('last_12_months_values_user',$b_user)
									->bind('last_12_months_values',$b)
									->bind('total_facebook_users',$total_fb_users)
									->bind('total_twitter_users',$total_tw_users)
									->bind('todays_users_count',$todays_users_count)
									->bind('get7days_users_count',$get7days_users_count)
									->bind('get30days_users_count',$get30days_users_count)
									->bind('get1year_users_count',$get1year_users_count)
									->bind('get10years_users_count',$get10years_users_count)
									->bind('get_total_web_customers_count',$get_total_web_customers_count);
								
		$this->template->content = $view;

	}
	
	//function for getting all facebook,twitter,openid,all user count
	public function getUserCount($user_type,$login_status)
	{	
	        foreach($user_type as $value){		       
			        $$value=0;
			}
                if(count($login_status) > 0){
                        foreach($login_status as $today_value){
                                        if(in_array($today_value['login_type'],$user_type)){
                                                $$today_value['login_type'] = $today_value['usercount'];
                                        }                                  
                        }
                }
                $final_type = array();
                $all_count = 0;
                 foreach($user_type as $usr_value){                		       
				       $final_type[$usr_value] =  $$usr_value;
				       $all_count +=$$usr_value;		       
		}
		$final_type[ALL_USER] = $all_count; 
		return $final_type;
	}
	
	/*
	*User Message 
	*Auto Reply Count
	*/
	public function getAutoReplyStatusCount($pending_reply,$reply_log)
	{
	        foreach($pending_reply as $value){		       
			        $$value=0;
			} 
                if(count($reply_log) > 0){
                        foreach($reply_log as $today_value){
                                        if(in_array($today_value['contact_request_reply'],$pending_reply)){
                                                $$today_value['contact_request_reply'] = $today_value['total'];
                                        }                                   
                        }
                }
                $final_type = array();
                $all_count = 0;
                 foreach($pending_reply as $usr_value){                		       
				       $final_type[$usr_value] =  $$usr_value;
				       $all_count +=$$usr_value;		       
		}
		$final_type[ALL_REPLY_STATUS] = $all_count; 
		return $final_type;			
		
	}	

} // End Welcome

