<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * 
 * @package    Api
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2013 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
//function for generating random key
	//=================================

class kohana_Api{

	
	static function random_user_password_generator()
	{
		$string = Text::random('hexdec', RANDOM_KEY_LENGTH);
		return $string;
	}
	static function get_user_settings()
	{
		//creating object for model
		 
		$site_details = Model::factory('api');
		$site = $site_details->get_user_settings();
		return $site;
		  
	}
	static public function get_bonus_amount($type)
	{
		$bonus=Model::factory('api');
		$bonus_amount=$bonus->get_bonus_amount($type);
		if(count($bonus_amount)>0)
		{		
			return $bonus_amount[0]['bonus_amount'];
		}
		else
		{
			return 0;
		}
	}
	static public function custom_user_bonus_message($arr=array(),$id="")
	{
		 
		$userid=($id!="")?$id:$uid;
		if($userid)
		{	
			$users=Model::factory('commonfunction');
			$select_userdetails=$users->select_with_onecondition(USERS,'id='.$userid);	
			$select_admindetails=$users->select_with_onecondition(USERS,"usertype='".ADMIN."'");
			if(count($select_userdetails)>0 && count($select_admindetails)>0 && count($arr)>0)
			{
				$select_email=$select_userdetails[0]['email'];
				$from=$select_admindetails[0]['email'];
				$subject=$arr['subject'];
				$message=$arr['custom_msg'];
				$sent_date=self::getCurrentTimeStamp();
				$insert=$users->insert(USER_MESSAGE,array('usermessage_to'=>$select_email,'userid_to'=>$userid,'usermessage_from'=>$from,'usermessage_subject'=>$subject,'usermessage_message'=>$message,'sent_date'=>$sent_date));
				if($insert)
				{
					return 0;
				}
			}
		}
		
	}
	static public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}
	/*accessing email templates from here */
	static function get_email_template_details($templateid,$replace_variables,$send_mail=0,$html =false)
	{			
                //creating object for model
              
                $mail = Model::factory('api');
				$content = $mail->get_template_details($templateid);
                $replacedcontent = array();
                foreach($content[0] as $contentkey => $contentvalue)
                {
                        foreach($replace_variables as $key => $value)
                        {
                                //replace array values by defining $replace_variables
                            
                                $contentvalue = str_replace($key,$value,$contentvalue);
                        }
			//await repeatation at the time insert 			
                        $replacedcontent[$contentkey] = ($send_mail)?(($html)?$contentvalue:nl2br($contentvalue)):$contentvalue;
                }            
                   
		if($send_mail)
		 
		{               		
			//send mail option which is true send mail with replaced content  
			$from = $replacedcontent['email_from'];
			$to = $replacedcontent['email_to'];
			$subject = $replacedcontent['email_subject'];
			$message = $replacedcontent['email_content'];
			$check_email = Model::factory('api');
			//check from & to mailid as correct
			$validate_email=$mail->check_emailformat_to_send(array('from'=>$from,'to'=>$to));
			
			$email_valus=$mail->save_email($to,$from,$subject,$message);
			if (!$validate_email->check()) 
			{	 
				return 0;
			}
                        
                        //defining headers for mail sending
                        //=================================
                        $headers = 'MIME-Version: 1.0'. "\r\n";
                        $headers .= 'Content-type:text/html;charset=iso-8859-1' . "\r\n";
                        $headers .= 'From:'. $from . "\r\n";
                        $smtp_settings  = $mail->get_smtp_settings();
                        $smtp_config = array('driver' => 'smtp','options' => array('hostname'=>$smtp_settings[0]['smtp_host'],
		                        'username'=>$smtp_settings[0]['smtp_username'],'password' => $smtp_settings[0]['smtp_password'],
		                        'port' => $smtp_settings[0]['smtp_port'],'encryption' => 'ssl')); 
				
			 
			//mail sending option here
			try{
				if(Email::connect($smtp_config))
				{                         	                      
					if(Email::send($to,$from , $subject, $message,$html = true) == 0)
					{                                  		                
						return 0;
					}
					return 1;
				}
			}	
			catch(Exception $e)
			{						  
			 	if(mail($to, $subject,$message,$headers))
				{                               
					return 1;
			 	}

			}
			return 0;

		}
		else

				{
				//if send mail option is not true means,
				//replace content and return content only
				return $replacedcontent;
				}
	}
	/***Get beginner auction products for Live,product detail,category and search*******/
	public static function beginner_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');
	$beginner_api_res=$api->select_beginner_products_detail($pids,$status,$arrayset);
	return $beginner_api_res;
	}
	
	/***Get Penny auction products for Live,product detail,category and search*******/
	public static function penny_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');
	$penny_api_res=$api->select_penny_products_detail($pids,$status,$arrayset);
	return $penny_api_res;
	}
	
	/***Get Peak auction products for Live,product detail,category and search*******/
	public static function peak_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');	
	$peak_api_res=$api->select_peak_products_detail($pids,$status,$arrayset);		
	return $peak_api_res;
	}
	
	/***Get Lowest unique auction products for Live,product detail,category and search*******/
	public static function lowestunique_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');	
	$lowest_api_res=$api->select_lowestunique_products_detail($pids,$status,$arrayset);
	return $lowest_api_res;
	}
	
	/***Get Highest unique auction products for Live,product detail,category and search*******/
	public static function highestunique_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');	
	$highest_api_res=$api->select_highestunique_products_detail($pids,$status,$arrayset);
	return $highest_api_res;
	}
	
	/***Get Scratch auction product products for Live,product detail,category and search*******/
	public static function scratch_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');	
	$scratch_api_res=$api->select_scratch_products_detail($pids,$status,$arrayset);		
	return $scratch_api_res;
	}
	
	/***Get Reserve auction products for Live,product detail,category and search*******/
	public static function reserve_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');	
	$reserver_api_res=$api->select_reserve_products_detail($pids,$status,$arrayset);
	return $reserver_api_res;
	}
	
	/***Get cashback auction products for Live,product detail,category and search*******/
	public static function cashback_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');	
	$productsresult_api=$api->select_cashback_products_detail($pids,$status,$arrayset);
	return $productsresult_api;
	}
	
	/***Get seat auction products for Live,product detail,category and search*******/
	public static function seat_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');	
	$seat_api_res=$api->select_seat_products_detail($pids,$status,$arrayset);
	return $seat_api_res;
	}
	
	/***Get clock auction products for Live,product detail,category and search*******/
	public static function clock_product_block($pids,$status="",$arrayset=array()){
	$api = Model::factory('api');	
	$clock_api_res=$api->select_clock_products_detail($pids,$status,$arrayset);
	return $clock_api_res;
	} 

}
