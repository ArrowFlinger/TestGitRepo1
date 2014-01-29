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
class Kohana_Commonfunction  {
	
	/**
	* @var array configuration settings
	*/
	protected $_config = array();

	/**
	* Class Main Constructor Method
	* This method is executed every time your module class is instantiated.
	*/
	public function __construct() 
	{	
		$this->session=Session::instance();
	  // Loading module configuration file data
	  
		
	 }

	//To Get Current TimeStamp
	//===================================
	static public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}

	
	
	static function check_users_online_status($userid)
	{
		$time=time();
		$time_check=time()-600;
		$session_id=Session::instance()->id();
		$users=Model::factory('commonfunction');
		if(isset($userid)){
		$user_status_reports=$users->user_status_reports($userid);
			if(count($users->user_status_reports($userid))==0)
			{
				$users->insert(USERS_ONLINE,array('session'=>$session_id,'time'=>time(),'userid'=>$userid));
			}
			else
			{
				$users->update(USERS_ONLINE,array('session'=>$session_id,'time'=>time()),'session',$session_id);
			}
			$users->delete_useronline(USERS_ONLINE,'time',$time_check);
		}
	}
	//To include facebook authentication
	//===================================
	static function include_facebook($locale="en_US")
	{
		$fb_root='<div id="fb-root"></div>';
		$script=HTML::script('http://connect.facebook.net/'.$locale.'/all.js', NULL, TRUE);		
		$include_script="<script type='text/javascript'>
			window.fbAsyncInit = function() {
			FB.init({
			appId  : '".FB_APP_ID."',
			status : true,
			cookie : true,
			xfbml  : true
				});
  			};  			 
       		 </script>";
		return $fb_root.$script.$include_script;
	}

        
	public static function getDays($date)
	{
		$now = time(); // or your date as well
		$your_date = strtotime($date);
		$datediff = $now - $your_date;
		return floor($datediff/(60*60*24));
	}
	
	//Number format
	//===================================	
	 static public function numberformat($number,$curr="INR")
	{
	if($number >0)
			{ //print_r($number);exit;
				switch ($curr){
			  		case "EUR":	
						$return = number_format($number,NUMBER_FORMAT_LIMIT, ",", ".");			
						$num=explode(",",$return);	
						if(array_key_exists(1,$num))
						{
							$final=$num[0].",".substr($num[1],0,2)."<span style='font-size:10px;letter-spacing:0.5px;padding-left:1px;'>".substr($num[1],2)."</span>";
						}
						else
						{
							$final=$num[0];
						}
				
			  			
			  		break;
			  		case "US":
			  			$final = number_format($number,NUMBER_FORMAT_LIMIT, ".", ",");
						break;
					case "INR";
						$final = number_format($number,NUMBER_FORMAT_LIMIT,".",",");
			  		break;
					case "NORMAL";
						$final = $number;
			  		break;
		  		}
			}
			else
			{
				$final=$number;
			}
		
		
		
		return $final;
		//return Num::format($number,NUMBER_FORMAT_LIMIT);
	} 

	/**
	* Send msg to user my messages
	* @param $arr=array(), Keys => subject,custom_msg
	**/
	static public function custom_user_bonus_message($arr=array(),$id="")
	{
		$uid=Session::instance()->get('auction_userid');
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
	
	public static function date_to_string($date)
	{
		return date("M d, h:i A",strtotime($date));
	}

	 //To Get Ads image in front end
        static function get_ads_details()
	{
	
		$ads=Model::factory('commonfunction');
		return $ads->get_ads_details();
	}

	static public function select_facebook_network()
	{
		$facebook=Model::factory('commonfunction');
		$fb=$facebook->select_facebook_network();
		if(count($fb)>0)
		{
			return $fb;
		}
		else
		{
			$fb[]=array('facebook_api'=>'276940609021930',
				'facebook_secret_key'=>'077a8a5768953d2d7bde2182c064cb6f');
		}
	}

	//Get user balance
	//===================================	
	static public function get_user_balance($userid)
	{
		$users=Model::factory('commonfunction');
		$user_balance=$users->get_user_balances($userid);
		if(count($user_balance)>0)
		{
			return $user_balance[0]['user_bid_account'];
		}

	}

	static public function get_user_bonus($userid)
	{
		$users=Model::factory('commonfunction');
		$user_balance=$users->get_user_balances($userid);
		if(count($user_balance)>0)
		{
			return $user_balance[0]['user_bonus'];
		}

	}

	static public function user_message($email)
	{
		$u_message=Model::factory('commonfunction');
		$usermessage=$u_message->get_usermessage($email);
		if(count($usermessage)>0)
		{
			return $usermessage;
		}		
	}

	//Get user balance
	//===================================	
	static public function get_bonus_amount($type)
	{
		$bonus=Model::factory('commonfunction');
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

	static public function get_current_bonus($id)
	{
		$bonus=Model::factory('commonfunction');
		$bonus_amount=$bonus->get_currentbonus_amount($id);
		if(count($bonus_amount)>0)
		{
			return $bonus_amount[0]['bonus_amount'];
		}
		else
		{
			return 0;
		}
	}

	//Get country
	//===================================	
	static public function countries()
	{
		$country_model=Model::factory('commonfunction');
		$country=$country_model->get_country();
		return $country;
	}
	
	
	static public function get_name($type,$id)
	{
		$get_model=Model::factory('commonfunction');
		if($type=='PG')
		{
		return $get_model->get_package_name($id);	
		}else if($type=='PR')
		{
		return $get_model->get_product_name($id);	
	
		}else{
			return '';
		}
		
	}

	//function for generating random key
	//=================================	 
	static function admin_random_user_password_generator()
	{
		$string = Text::random('hexdec', RANDOM_KEY_LENGTH);
		return $string;
	}

	//function for generating random key
	//=================================	 
	static function randomkey_generator($length=0)
	{
		$length = ($length ==0)?RANDOM_KEY_LENGTH:$length;
		$string = Text::random('hexdec',$length);
		return $string;
	}
	
	//function for generating random key
	//=================================	 
	static function randomkey_generatornumber($length=0)
	{
		$length = ($length ==0)?RANDOM_KEY_LENGTH:$length;
		$string = Text::random('1587963',$length);
		return $string;
	}
	 	
	//function for show category with backend limit settings	
	static function show_category($catid="",$sidebar_cat_limit = "")
	{
		$category_product = Model::factory('commonfunction');
		$product_categories = $category_product->get_productcategory($sidebar_cat_limit);
		$css = Html::style('public/css/style.css');
		return $view= View::factory('sidebar_category')
				  ->bind('css_script',$css)
				  ->bind('product_categories',$product_categories)
				  ->bind('cat_id',$catid)
				  ->render();
	}

	static function get_meta_data($meta_details="")
	{
		//creating object for  settings model
		
		$settings = Model::factory('commonfunction');

		//getting meta keywords,title,description
			
		$meta_details = $settings->get_meta_details();
		return $meta_details;
	}

	//Nauth Time Change      
	static function change_time($time="") 
	{
		$time = strtotime($time).'<br />';
		//echo date("Y-m-d h:i:s", time()).'<br/>';
		$c_time = time() - $time;
		if ($c_time < 60) {
		  	return '0 minute ago';
		} else if ($c_time < 120) {
		  	return '1 minute ago';
		} else if ($c_time < (45 * 60)) {
		  	return floor($c_time / 60) . ' minutes ago';
		} else if ($c_time < (90 * 60)) {
		  	return '1 hour ago.';
		} else if ($c_time < (24 * 60 * 60)) {
		  	return floor($c_time / 3600) . ' hours ago';
		} else if ($c_time < (48 * 60 * 60)) {
		  	return '1 day ago.';
		} else {
		  	return floor($c_time / 86400) . ' days ago';
		}
	}
	        
	static function get_settings_for_products()
	{
		//creating object for model
		//=========================      
		$product_details = Model::factory('commonfunction');
		$products = $product_details->get_product_settings();
		return $products;
		  
	}
	  
	static function get_site_settings()
	{
		//creating object for model
		 
		$site_details = Model::factory('commonfunction');
		$site = $site_details->get_site_settings();
		return $site;

		  
	}

        
	static function get_user_settings()
	{
		//creating object for model
		 
		$site_details = Model::factory('commonfunction');
		$site = $site_details->get_user_settings();
		return $site;
		  
	}

	static function get_facebook_settings()
	{
		//creating object for model
		 
		$site_details = Model::factory('commonfunction');
		$site = $site_details->get_facebook_settings();
		return $site;
		  
	}	   
	  
	/*accessing email templates from here */
	static function get_email_template_details($templateid,$replace_variables,$send_mail=0,$html =false)
	{			
                //creating object for model
              
                $mail = Model::factory('commonfunction');
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
			$check_email = Model::factory('commonfunction');
			//check from & to mailid as correct
			$validate_email=$mail->check_emailformat_to_send(array('from'=>$from,'to'=>$to));			 
			$email_valus=$mail->save_email($to,$from,$subject,$message);
			if (!$validate_email->check()) 
			{	 
				return 0;
			}
                        
                        //defining headers for mail sending
                        //=================================
                        $headers = __('email_header_text'). "\r\n";
                        $headers .= __('email_content_type') . "\r\n";
                        $headers .= __('email_from'). $from . "\r\n";
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
	 
	 static function check_testing_emails($to,$subject,$message )
	{
	    $mail = Model::factory('commonfunction');
	 	//send mail option which is true send mail with replaced content  
			$from ="ndotauction@gmail.com";
			$to = $to;
			$subject = $subject;
			$message = $message;
			$check_email = Model::factory('commonfunction');
			//check from & to mailid as correct
			$validate_email=$mail->check_emailformat_to_send(array('from'=>$from,'to'=>$to));
			$email_valus=$mail->save_email($to,$from,$subject,$message);
			if (!$validate_email->check()) 
			{	
				return 0;
			}
                        
                        //defining headers for mail sending
                        //=================================
                        $headers = __('email_header_text'). "\r\n";
                        $headers .= __('email_content_type') . "\r\n";
                        $headers .= __('email_from'). $from . "\r\n";
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
	 
	
	 

	//To Get The Substring values
	
	static function GetSubString($substrval,$strstart)
	{
		$val_len=strlen($substrval);
		if($val_len>$strstart) 
		{
			$substrval=substr($substrval,0,$strstart)."...";
		}
		return $substrval;
	}

   	
	
	//change date format (for transaction) to db format
	static function DateFormatToDb($input_date="")
	{
		$input_date = date('Y-m-d', strtotime($input_date));
		return $input_date;
	}
        
	//for upper case
	//==============
	static function string_to_upper($input_val="")
	{
		return strtoupper($input_val);
	}
      
	/*function for insert mail sent details in user_email table
	static function add_email_template_details($templateid,$replace_variables,$send_mail=0,$action="")
	{
		//creating object for model
		//=========================      
		$email_details = Model::factory('commonfunction');
		$email_subject = $email_details->add_email_template_details($templateid,$replace_variables,$send_mail=0,$action);
		print_r($email_subject);exit;
	} */
      	
	static function get_replaced_content($content ,array $replace_key_values)
	{
		foreach($replace_key_values as $key=>$value)
		{
		        $content = str_replace($key,$value,$content);
		}
		return $content;
	}
      	
	
	static function get_date_bydayincrement($days=0)
	{	        
	        $date = date ( 'j-M-Y');
                $newdate = strtotime ( '+'.$days.' days' , strtotime ( $date ) ) ;
                $newdate = date ( 'j-M-Y' , $newdate );                 
                return $newdate;
         }

	//To get static page contents in footer
	static function get_staticpage_content($page="")
	{
		//creating object for model
         
         	$static_page_content = Model::factory('commonfunction');
		if($page=="footer")
		{
			$content=$static_page_content->get_staticpage_footer_content();
			
			
		}	
		else if($page=="header")
		{
			$content=$static_page_content->get_staticpage_header_content();
		}
		else 
		{
			$content=$static_page_content->get_staticpage_content();
		}
		
		
		return $content;
	}

	
	//To get Job Category count
	static function get_category_count($cat_id='')
	{
		//creating object for model
         	  
         	$category_count = Model::factory('commonfunction');
		$content=$category_count->count_category_list($cat_id);
		return $content;
	}
	
	/*** venkatraja added in 13-Mar-2013 ****/
	//To get Job Category count
	static function get_auction_bid_name($pid)
	{
		//creating object for model
         	  
         	$bid_type = Model::factory('commonfunction');
		$content=$bid_type->get_auction_bid_name($pid);
		return $content;
	}
	static function get_daysbyincreement_dbformat($days = 0)
	{
		$date = date ( 'Y-m-d h:i:s');
		$newdate = strtotime ( '+ '.$days.' days' , strtotime ( $date ) ) ;
		$newdate = date ( 'Y-m-d h:i:s' , $newdate );
		return $newdate;
	}


	//function for show job prices with backend limit settings	
	static function get_admindetails()
	{
		$admindetail = Model::factory('commonfunction');
		$admin_dateil = $admindetail->get_admindetails();
		return $admin_dateil;
	}

	static function get_socialsettings()
	{
		$query = DB::select()->from(SOCIALNETWORK_SETTINGS)
				->execute()->current();
		return $query;
	}
	
	/*** Added By Venkatraja ***/
	
	
	static function AuctionOrdermail($response=array(),$replace =array())
	{
		/*
		 * @response array lists
		 * 
		 * order_id - manditory
		 * user_id - manditory
		 * currency -manditory
		 * price - optional (price will be applicable only for single product)
		 * order_date - optional
		 * billinginfo -optional
		 * shippinginfo - optional
		 * notification -optional (Add you custom message to notify the customer)
		 * products - optional - array format is Eg: array(array('name'=>'','quantity' =>'','price' =>''),array('name'=>'','quantity' =>'','price' =>''))
		 * product_id - optional if above products index not given means this will be manditory
		 * type -optional (bidding type name)
		 */
		$model = Model::factory('commonfunction');
		
		$site_name=Commonfunction::get_site_settings();
		$sitename =$site_name[0]['site_name'];	
		$replace_variables = array(SITE_NAME => $sitename ,SITE_URL => URL_BASE, SITE_LINK => URL_BASE,
			  	CONTACT_MAIL => $site_name[0]['common_email_from'],FROM_EMAIL => $site_name[0]['common_email_from']);
		$udetails = $model->getUserdetails($response['user_id']);
		$userdetails = $udetails['userdetails'];
		$orderdate = isset($response['orderdate'])?$response['orderdate']:self::getCurrentTimeStamp();
		if(isset($response['shippinginfo']))
		{
			$shippinginfo = $response['shippinginfo'];
		}
		else
		{
			$billinginfo = $udetails['shippinginfo'];
			$shippinginfo=$billinginfo['name']."<br/>".$billinginfo['address']."<br/>".$billinginfo['city']."<br>".$billinginfo['town']."-".$billinginfo['zipcode']."<br/>".$billinginfo['country']."<br/>Phone Number :".$billinginfo['phoneno'];

		}
		if(isset($response['billinginfo']))
		{
			$billinginfo = $response['billinginfo'];
		}
		else
		{
			$billinginfo = $udetails['billinginfo'];
			
			$billinginfo=$billinginfo['name']."<br/>".$billinginfo['address']."<br/>".$billinginfo['city']."<br>".$billinginfo['town']."-".$billinginfo['zipcode']."<br/>".$billinginfo['country']."<br/>Phone Number :".$billinginfo['phoneno'];
			
		} 
		if(!isset($response['products']))
		{
			$product_details = $model->getAuctiondetails($response['product_id']);
			$product_result[] = array('name' => $product_details['productdetails']['product_name'],
						'quantity' => 1,
						'price' => $product_details['productdetails']['current_price']);
			$auctiontype = ucfirst($product_details['auctiontype']);
		}
		else
		{
			$product_result = $response['products'];
			$auctiontype = isset($response['type'])?ucfirst($response['type']):"";
		}
		
		$auction_detail ='<table border="0" width="99%" cellpadding="4">
		    <thead style="background:#ccc">
			<tr><td>Product Name</td>
			<td>Quantity</td>
			<td>Price</td>
			<td>Sub total</td> 
			</tr>
		    </thead>
		    <tbody>';
			$subtot = 0;
			$shipping = isset($response['shipping'])?$response['shipping']:0;
			$tax = isset($response['tax'])?$response['tax']:0;
			foreach($product_result as $result):
			$result['price'] = isset($response['price'])?$response['price']:$result['price'];
				$subtot += $result['price'] * $result['quantity'];
						$auction_detail .='	<tr>
				    <td style="line-height:20px;"> '.$result['name'].' </td>
				    <td style="line-height:20px;"> '.$result['quantity'].' </td>
				    <td style="line-height:20px;"> '.$response['currency'].Commonfunction::numberformat($result['price']).' </td>
				    <td style="line-height:20px;"> '.$response['currency'].Commonfunction::numberformat(($result['price'] * $result['quantity'])).' </td> 
				</tr>';
			endforeach;			
			$auction_detail .='<tr>
			    <td colspan="2" style="line-height:20px;">
				
			    </td>
			    <td>Subtotal: </td>
			     <td>'.$response['currency'].Commonfunction::numberformat($subtot).' </td>
			</tr>';
			$auction_detail .='<tr>
			    <td colspan="2"></td>
			    <td>Shipping Rate: </td>
			     <td>'.$response['currency']. Commonfunction::numberformat($shipping).' </td>
			</tr>';
			$auction_detail .='<tr>
			    <td colspan="2"></td>
			    <td>Tax: </td>
			    <td>'.$response['currency']. Commonfunction::numberformat($tax).' </td>
			</tr>';
			 
			$auction_detail .='<tr>
			    <td colspan="2"></td>
			    <td>Total: </td>
			     <td>'.$response['currency']. Commonfunction::numberformat(($shipping+$tax+$subtot)).' </td>
			</tr>';
			
		       $auction_detail .='</tbody>  
                </table>';
		 
	$logo_image_path=IMGPATH.SITE_LOGO_IMAGE;
if(((isset($site_name)) && $site_name[0]['site_logo']) && (file_exists(DOCROOT.LOGO_IMGPATH.$site_name[0]['site_logo']))){
	$logo_image_path = URL_BASE.LOGO_IMGPATH.$site_name[0]['site_logo'];}
	
		$alternatives = array_merge(array('##AUCTIONTYPE##' => $auctiontype,
						'##NOTIFICATION##' => isset($response['notification'])?$response['notification']:'',
						USERNAME => $userdetails['username'],
						TO_MAIL=>$userdetails['email'],
						'##AUCTIONDETAIL##'=>$auction_detail,
						'##SHIPPING_INFO##' =>($shippinginfo!="")?$shippinginfo:"-",
						'##BILLING_INFO##' =>($billinginfo!="")?$billinginfo:"-",
						'##LOGO##'=>'<img src="'.$logo_image_path.'" border="0"  />',
						'##ORDER_ID##' =>$response['order_id'],
						'##ORDER_ID##' =>$response['order_id'],
						'##ORDER_DATE##' => $orderdate),$replace);
		

		$buyer_replace_variable = array_merge($replace_variables,$alternatives);
		 
		//send mail to buyer by defining common function variables from here
		
		
		return self::get_email_template_details('auction_order',$buyer_replace_variable,SEND_MAIL_TRUE,true); 
		
	}
	
	
	/***venkatraja added in 4-Mar-12 for showlable ***/
	public static function showlinkdata($formdatas= array() , $currency ="USD",$inc=1,$url)
	{
		$render="";
		
		$render ="<form action='$url' name='paymentsubmit{$inc}' id='paymentsubmit{$inc}' method='post'>";
		
			foreach($formdatas as $value)
			{
			    foreach($value as $key => $val)
			    {
				
				if(is_array($val))
				{
					
					foreach($val as $fieldname=>$fieldvalue)
					{
					
						$render .= "<input type='hidden' name='".$fieldname."' value='".$fieldvalue."'/>";
					
					}
					
				}else{
					$render .= "<input type='hidden' name='".$key."' value='".$val."'/>";

					
				}
				
			    }
			}
			
		$render .= "<a href='javascript:;'  onclick='$(\"#paymentsubmit{$inc}\").submit();'>".__('buynow_lable')."</a>";
		
		
		$render .="</form>";
		
		echo $render;
	}
	
	
	public static function showlinkmultipledata($formdatas= array() , $currency ="USD",$inc=1,$url)
	{
		$render="";
		
		$render ="<form action='$url' name='paymentsubmit{$inc}' id='paymentsubmit{$inc}' method='post'>";
			foreach($formdatas as $value)
			{
			    foreach($value as $key => $val)
			    {
				foreach($val as $fieldname=>$fieldvalue)
				{
					
					$render .= "<input type='hidden' name='".$fieldname."' value='".$fieldvalue."'/>";
					
				}
				
				
			    }
			}
			
		$render .= "<a href='javascript:;'  onclick='$(\"#paymentsubmit{$inc}\").submit();'>".__('buynow_lable')."</a>";
		
		
		$render .="</form>";
		
		echo $render;
	}
	
	
	
	/*** end for venkatraja added in 4-Mar-12 **/
	//Get user details
	static function get_userdetails($id){
		$pdetail = Model::factory('commonfunction');
		$pdateils = $pdetail->get_userdetails($id);
		return $pdateils;
	}
	

        static public function get_percent($userid)
			{
				$internal=Model::factory('commonfunction');
				$user_balance=$internal->get_percent($userid);
				if(count($user_balance)>0)
				{
					return $user_balance;
				}

			}

        static public function get_amtproduct($userid)
			{
				$internal=Model::factory('commonfunction');
				$user_balance=$internal->get_amtproduct($userid);
				if(count($user_balance)>0)
				{
					return $user_balance;
				}

			}
			
			
	/*** Added By venkatraja 15-Mar-2013 ***/
	
	
	 static  public function getdateFormat($input_date_time)
        {
                //getting input data from last login db field
                $input_date_split = explode("-",$input_date_time);
                //splitting year and time in two arrays
                $input_date_explode = explode(' ',$input_date_split[2]);
                $input_date_explode1 = explode(':',$input_date_explode[1]);
                //getting to display datetime format
                $display_datetime_format = date('j M Y h:i:s A',mktime($input_date_explode1[0], $input_date_explode1[1], $input_date_explode1[2], 
                $input_date_split[1], $input_date_explode[0], $input_date_split[0]));
                return $display_datetime_format;
        }
            
	
	
	/*** Added End By venkatraja 15-Mar-2013 ***/
	
	/**** Venkatraja added in 19-Mar-2013 ****/
	
	static  public function check_gateway_plugin($module_id)
	{
		
		$gateway_plugin=Model::factory('commonfunction');
		return $gateway_plugin->check_gateway_plugin($module_id);		
	}
	
	/*** Added End By venkatraja in 19-Mar-2013 ***/
		//function for show job prices with backend limit settings	
	static function get_total_bid_count($productid,$userid)
	{
		$admindetail = Model::factory('commonfunction');
		$admin_dateil = $admindetail->get_total_bid_count($productid,$userid);
		return $admin_dateil;
	}
	
	
			
	
}
