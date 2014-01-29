<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Modulename — SMS MODULE
 *
 * @package    SMS
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Kohana_SMS {

      /**
      * @var array configuration settings
      */
      protected $_config = array();
 


      /**
      * Class Main Constructor Method
      * This method is executed every time your module class is instantiated.
      */
      public function __construct() {
	   }
	   
		static public function send_sms($receipientno,$msgtxt=''){
			$SMS=Model::factory('sms');
			$sms_details= $SMS->getsmsGatewayDetails();
			DEFINE("SMS_API_URL",$sms_details[0]['sms_api_url']);
			DEFINE("SMS_API_USERNAME",$sms_details[0]['sms_api_username']);
			DEFINE("SMS_API_PASSWORD",$sms_details[0]['sms_api_password']);
			DEFINE("SMS_API_SENDERID",$sms_details[0]['sms_api_senderid']);
			$ch = curl_init();
			$user=SMS_API_USERNAME.":".SMS_API_PASSWORD;
			$senderID=SMS_API_SENDERID;
			curl_setopt($ch,CURLOPT_URL,  SMS_API_URL);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
			curl_exec($ch);
			curl_close($ch);
      }
}
