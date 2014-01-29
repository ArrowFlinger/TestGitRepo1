<?php defined('SYSPATH') or die('No direct script access.');

/*

* Contains Mange Contactus Mail  module details
 
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Contactus extends Model
{
        /**
        * ****contact_subject_list()****
        */
	public function contact_subject_list()
	{
	   $rs = DB::select('id','subject')->from(CONTACT_SUBJECT)
	   		->order_by('id','ASC')
				->execute()
				->as_array();
	   return $rs;
        }
  
      
	/**
	 * ****validate_contact_form()****
	 *@param $arr validation array
	 *@validation check
	 */      
        public function validate_contact_form($arr)
        {
  
  		$arr['subject'] = trim($arr['subject']); 	
  		$arr['name'] = trim($arr['name']);
  		$arr['message'] = trim($arr['message']);
  		
		return Validation::factory($arr) 
			->rule('captcha','Captcha::valid')  
			->rule('subject','alpha_space')
			->rule('subject', 'min_length', array(':value', '5'))
			->rule('name','not_empty')
			->rule('name', 'min_length', array(':value', '4'))
			->rule('email','not_empty')
			->rule('email','email')
			->rule('telephone', 'regex', array(':value', '/^[0-9()+_-]++$/i'))
			->rule('message','not_empty');
			
   	}
   	
        /**
        * ****add_contact_request()****
        *@return insert user values in database
        */ 
	public function add_contact_request($validator,$contact_data,$user_id)
	{
		
		$user_id  = isset($user_id)?$user_id:0;
                $subject = isset($contact_data['subject'])?$contact_data['subject']:"0";
		
		$rs   = DB::insert(CONTACT_REQUEST)
				->columns(array('subject', 'name', 'email','user_id','message','contact_subjectid','telephone','ip'))
				->values(array($subject,$contact_data['name'],$contact_data['email'],$user_id,
							     $contact_data['message'],$contact_data['contact_subjectid'],$_POST['telephone'],Request::$client_ip))
				->execute();
		if($rs){
			if($user_id != ""){
				//query for logged user details retrieve
                                                $query = " SELECT DISTINCT U.email,U.username,
                                                        U.firstname,U.lastname,
                                                        CS.subject,CR.subject as subject1,CR.request_date,
                                                        CR.message,CR.ip,CR.telephone
                                                        FROM ".CONTACT_REQUEST." AS CR
                                                        LEFT JOIN ".CONTACT_SUBJECT." AS CS ON (CS.id = CR.contact_subjectid)
                                                        LEFT JOIN ".USERS." AS U ON (U.id = CR.user_id)
                                                        WHERE U.id = $user_id ORDER BY CR.id DESC ";				
			
				        }else{
					//query for inserted user details
                                                $query = " SELECT CR.name,CR.email,CS.subject,CR.subject as subject1,CR.message,CR.request_date,CR.ip,CR.ip,CR.telephone
                                                        FROM ".CONTACT_REQUEST." AS CR 
                                                        LEFT JOIN ".CONTACT_SUBJECT." AS CS ON (CS.id = CR.contact_subjectid) ORDER BY CR.id DESC ";
					}

		 		$results = Db::query(Database::SELECT, $query)
				   			 ->execute()
							 ->as_array();		 		
				return $results;			
			
			}		
	
	}
	
}
