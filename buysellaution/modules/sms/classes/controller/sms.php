<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Commonfunction Controler
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 *
 * @package    Commonfunction
 * @category   Base
 * @author     Vels Team
 * @date       Dec26,2012
 * @copyright  (c) 2012 Myself Team
 * @license    nauction
 * */
class Controller_Sms extends Controller {
    public function action_index(){
        // Instanciating the Module Class
        $Commonfunction = new Commonfunction;
        // Or Call a Statis Method
        //Commonfunction::show_category();
    }
   
   /*
    public function action_send_sms(){
        /*
        DEFINE("SMS_API_URL","http://api.mVaayoo.com/mvaayooapi/MessageCompose");
        DEFINE("SMS_API_USERNAME","suresh.g@ndot.in");
        DEFINE("SMS_API_PASSWORD","ndot2012");
        DEFINE("SMS_API_SENDERID","TEST SMS");
        $receipientno="9790237418"; 
        $msgtxt="TEST SMS FOR AUCTION";
        */
       /* 
        $ch = curl_init();
        $user=SMS_API_USERNAME.":".SMS_API_PASSWORD;
        $receipientno=arr::get($_REQUEST,'phno'); 
        $msgtxt=arr::get($_REQUEST,'msg');
        $senderID=SMS_API_SENDERID;
        curl_setopt($ch,CURLOPT_URL,  SMS_API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
        $buffer = curl_exec($ch);
        if(empty ($buffer)){
            echo " Buffer is empty..... ";
        }else{
            //echo $buffer;
            echo "Message sent successfully....!";
        }
        curl_close($ch);
        exit;
    }
   */
   
    
    
} // End Welcome
