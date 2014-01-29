<?php defined('SYSPATH') or die('No direct script access.');

/*

* Contains Master(Email Templates,Payment Gateways) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Master extends Model
{

	/**
	 * ****__construct()****
	 * setting up session variables
	 */
	public function __construct()
	{	
		$this->session = Session::instance();	
		$this->username = $this->session->get("username");
		$this->user_id = $this->session->get("id");

	}
 
        /**
        * ****edit_email_template_form()****
        *
        * @param $arr validation array
        * @return array validation fields
        */
	public function edit_email_template_form($arr)
        {
                $arr['email_from'] = trim($arr['email_from']);
                $arr['email_subject'] = trim($arr['email_subject']);
                $arr['email_content'] = trim($arr['email_content']);
                return Validation::factory($arr)       
	                ->rule('email_from', 'not_empty')
	                ->rule('email_subject','not_empty')
	                ->rule('email_content','not_empty');
        }   
 
 
        /**
        * ****get_all_template_details()****
        * return all fields in email template table
        */ 
        public function get_all_template_details()
 	{
                $result= DB::select()->from(EMAIL_TEMPLATE)
                        ->execute()	
                        ->as_array(); 

                return $result;
 	} 
 
        /**
        * ****get_template_details()****
        * template id param int 
        * return all fields in email template table
        */ 	
	public function get_template_details($template_id)
 	{

                $result= DB::select()->from(EMAIL_TEMPLATE)
                        ->where("id","=",$template_id)
                        ->execute()	
                        ->as_array(); 

                return $result;

 	} 
 
        /**
        * ****edit_email_template()****
        * $template_details $_POST array values param array 
        * return update all fields
        */ 		
 	public function edit_email_template($template_details)
        {
		/*$content=$this->get_template_details(20);
		
		$template_details['email_content']=$content[0]['email_content'];*/
		//print_r($template_details['email_content']);exit;
		
                $sql_query = array('email_from' => $template_details['email_from'],'email_to' => $template_details['email_to'],'email_subject' => $template_details['email_subject'],
                'email_content' => $template_details['email_content']);

                $result =  DB::update(EMAIL_TEMPLATE)
                        ->set($sql_query)
                        ->where("id","=",$template_details['template_id'])
                        ->execute(); 

                if(count($result) == SUCESS)	{		
                return $result;	
                }					  

        } 
 
        /**
        * ****get_payment_details()****
        * function for getting payment details with pagination
        * 
        */ 		
        public function get_payment_details($offset, $val)
        {
                $query = "select * from ". PAYMENT_GATEWAYS . " limit $offset,$val";  
                        $result = Db::query(Database::SELECT, $query)
                        ->execute()
                        ->as_array();

                return $result;		

        } 
 		
        /**
        * ****get_payment_details()****
        * function for getting current payment details in edit page 
        */ 		
        public function get_payment_detail_list($payment_gateways_id)
        {
                $result= DB::select()->from(PAYMENT_GATEWAYS)
                        ->where("id","=",$payment_gateways_id)
                        ->execute()	
                        ->as_array(); 

                return $result; 		

        } 

        /**
        * ****get_all_payment_details()****
        * function for getting current payment details count for pagination
        */  	
        public function get_all_payment_details()
        {
                $result= DB::select()->from(PAYMENT_GATEWAYS)
                        ->execute()	
                        ->as_array(); 

                return count($result); 		

        } 
 		
         /**
        * ****edit_payment_gateway_form()***
        *@param $arr validation array
        *@validation check
        */
        public function edit_payment_gateway_form($arr)
        {
                $arr['payment_gatway'] = trim($arr['payment_gatway']);
                $arr['paypal_api_username'] = trim($arr['paypal_api_username']);
                $arr['description'] = trim($arr['description']); 
                $arr['paypal_api_password'] = trim($arr['paypal_api_password']); 
                $arr['paypal_api_signature'] = trim($arr['paypal_api_signature']);  
                return Validation::factory($arr)       
                        ->rule('payment_gatway','not_empty')
                        ->rule('payment_gatway','alpha_space')
                        ->rule('description','not_empty')
                        ->rule('description','alpha_space')
                        ->rule('description', 'min_length', array(':value', '20'))
                        ->rule('description', 'max_length', array(':value', '500'))			    
                        ->rule('paypal_api_username','not_empty')
                        ->rule('paypal_api_username', 'max_length', array(':value', '255'))	    
                        ->rule('paypal_api_password','not_empty')
                        ->rule('paypal_api_signature','not_empty');            
        }  
		  
        /**
        * ****edit_authorize_payment_gateway_form()***
        *@param $arr validation array
        *@validation check
        */
        public function edit_authorize_payment_gateway_form($arr)
        {
                $arr['payment_gatway'] = trim($arr['payment_gatway']);
                $arr['authorize_api_username'] = trim($arr['authorize_api_username']);
                $arr['description'] = trim($arr['description']); 
                $arr['authorize_api_password'] = trim($arr['authorize_api_password']); 
                return Validation::factory($arr)       
                        ->rule('payment_gatway','not_empty')
                        ->rule('payment_gatway','alpha_space')
                        ->rule('description','not_empty')
                        ->rule('description','alpha_space')
                        ->rule('description', 'min_length', array(':value', '20'))
                        ->rule('description', 'max_length', array(':value', '500'))			    
                        ->rule('authorize_api_username','not_empty')
                        ->rule('authorize_api_username', 'max_length', array(':value', '255'))	    
                        ->rule('authorize_api_password','not_empty');
        }
		  
		  
		  
        /**
        * ****edit_Ccavenue_payment_gateway_form()***
        *@param $arr validation array
        *@validation check
        */
        public function edit_Ccavenue_payment_gateway_form($arr)
        {
                $arr['payment_gatway'] = trim($arr['payment_gatway']);
                $arr['Ccavenue_api_username'] = trim($arr['Ccavenue_api_username']);
                $arr['description'] = trim($arr['description']); 
                $arr['Ccavenue_api_password'] = trim($arr['Ccavenue_api_password']); 
                return Validation::factory($arr)       
                        ->rule('payment_gatway','not_empty')
                        ->rule('payment_gatway','alpha_space')
                        ->rule('description','not_empty')
                        ->rule('description','alpha_space')
                        ->rule('description', 'min_length', array(':value', '20'))
                        ->rule('description', 'max_length', array(':value', '500'))			    
                        ->rule('Ccavenue_api_username','not_empty')
                        ->rule('Ccavenue_api_username', 'max_length', array(':value', '255'))	    
                        ->rule('Ccavenue_api_password','not_empty');
                        
        }
		  
        /**
        * ****edit_mercado_payment_gateway_form()***
        *@param $arr validation array
        *@validation check
        */
        public function edit_mercado_payment_gateway_form($arr)
        {
                $arr['payment_gatway'] = trim($arr['payment_gatway']);
                $arr['mercado_api_username'] = trim($arr['mercado_api_username']);
                $arr['description'] = trim($arr['description']); 
                $arr['mercado_api_password'] = trim($arr['mercado_api_password']); 
                
                return Validation::factory($arr)       
                ->rule('payment_gatway','not_empty')
                ->rule('payment_gatway','alpha_space')
                ->rule('description','not_empty')
                ->rule('description','alpha_space')
                ->rule('description', 'min_length', array(':value', '20'))
                ->rule('description', 'max_length', array(':value', '500'))			    
                ->rule('mercado_api_username','not_empty')
                ->rule('mercado_api_username', 'max_length', array(':value', '255'))	    
                ->rule('mercado_api_password','not_empty');
               // ->rule('paypal_api_signature','not_empty');
        }
		  
		  

        /**
        * ****edit_payment_gateway()***
        *@param $payment_id int $payment_details array
        *@validation check
        */	
	public function edit_payment_gateway($payment_id,$payment_details)
        {
		
		$status = isset($payment_details['status'])?"A":"I";
		$query = array('payment_gatway' => $payment_details['payment_gatway'],
                'description' => $payment_details['description'], 'payment_method' => $payment_details['payment_method'],
                'currency_code' => $payment_details['currency_code'],'paypal_api_username' => $payment_details['paypal_api_username'],
                'paypal_api_password'=> $payment_details['paypal_api_password'],
                'paypal_api_signature'=> $payment_details['paypal_api_signature'],
					 'status'=> $status);  
		
		$result =  DB::update(PAYMENT_GATEWAYS)->set($query)
						->where('id', '=' ,$payment_id)
						->execute();	   	
		return $result;
	}
	
	
        /**
        * ****get_all_sms_details()****
        * function for getting current sms details count for pagination
        */  	
        public function get_all_sms_details()
        {
                $result= DB::select()->from(SMS_GATEWAYS)
                ->execute()	
                ->as_array(); 
                return count($result); 		
        } 	
	
	
        /**
        * ****get_sms_details()****
        * function for getting sms details with pagination
        * 
        */ 		
        public function get_sms_details($offset, $val)
        {
                $query = "select * from ". SMS_GATEWAYS . " limit $offset,$val";  
                $result = Db::query(Database::SELECT, $query)
                ->execute()
                ->as_array();
                return $result;		
        } 
	
        /**
        * ****get_SMS_details()****
        * function for getting current sms details in edit page 
        */ 		
        public function get_sms_detail_list($sms_gateways_id)
        {
                $result= DB::select()->from(SMS_GATEWAYS)
                ->where("id","=",$sms_gateways_id)
                ->execute()	
                ->as_array(); 
                return $result; 		
        } 
	
	
        /**
        * ****edit_sms_gateway_form()***
        *@param $arr validation array
        *@validation check
        */
        public function edit_sms_gateway_form($arr)
        {
                $arr['sms_gatway'] = trim($arr['sms_gatway']);
                $arr['sms_description'] = trim($arr['sms_description']); 
                $arr['sms_api_url'] = trim($arr['sms_api_url']); 
                $arr['sms_api_username'] = trim($arr['sms_api_username']);
                $arr['sms_api_password'] = trim($arr['sms_api_password']); 
                $arr['sms_api_senderid'] = trim($arr['sms_api_senderid']);

                return Validation::factory($arr)       
                ->rule('sms_gatway','not_empty')
                ->rule('sms_gatway','alpha_space')
                ->rule('sms_description','not_empty')
                ->rule('sms_description','alpha_space')
                ->rule('sms_description', 'min_length', array(':value', '20'))
                ->rule('sms_description', 'max_length', array(':value', '500'))			    
                ->rule('sms_api_url','not_empty')
                ->rule('sms_api_username','not_empty')
                ->rule('sms_api_username','email')
                ->rule('sms_api_username','email_domain')
                ->rule('sms_api_username', 'max_length', array(':value', '255'))	    
                ->rule('sms_api_password','not_empty')
                ->rule('sms_api_senderid','not_empty');            
        }
	 /**
        * ****edit_sms_gateway()***
        *@param $payment_id int $sms_details array
        *@validation check
        */	
	public function edit_sms_gateway($sms_id,$sms_details)
        {
                $status = isset($_POST['status'])?"A":"I";

                switch ($sms_id) {
                        case 1:
                        $query = array('sms_gatway' => $sms_details['sms_gatway'],
                        'sms_description' => $sms_details['sms_description'],
                        'sms_api_url'=> $sms_details['sms_api_url'],
                        'sms_api_username' => $sms_details['sms_api_username'],
                        'sms_api_password'=> $sms_details['sms_api_password'],
                        'sms_api_senderid'=> $sms_details['sms_api_senderid'],
                        'status'=> $status
                        );
                         break;
                case 2:
                $query = array('sms_gatway' => $sms_details['sms_gatway'],
                        'sms_description' => $sms_details['sms_description'],
                        'sms_api_url'=> $sms_details['sms_api_url'],
                        'sms_api_username' => $sms_details['sms_api_username'],
                        'sms_api_password'=> $sms_details['sms_api_password'],
                        'sms_api_senderid'=> $sms_details['sms_api_senderid'],
                        'status'=> $sms_details['status']);
                        break;
                }

                $result =  DB::update(SMS_GATEWAYS)->set($query)
                ->where('id', '=' ,$sms_id)
                ->execute();	   	
                return $result;
	}

}//End
