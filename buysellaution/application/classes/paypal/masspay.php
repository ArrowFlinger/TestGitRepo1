<?php defined('SYSPATH') or die('No direct script access.');
/**
 * PayPal ExpressCheckout integration.
 *
 * @see  https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_ECGettingStarted
 *
 * @Package: Nauction Platinum Version 1.0
 * @Created on October 24, 2012
 * @Updated on October 24, 2012
 * @Author: NDOT Team
 * @copyright  (c) 2009 Kohana Team
 * @license    http://kohanaphp.com/license.html 
 */
class PayPal_MassPay extends PayPal {

	// Default parameters
	protected $_default = array(
		'RECEIVERTYPE' => 'EmailAddress',
	);

   
        public function DoMassPayPayment(array $params , array $emailids)
        {
               
                $required = array('RECEIVERTYPE','CURRENCYCODE');
                $emailcount = 0;
                
                
                foreach($emailids as $key)
                {
                        array_push($required,'L_AMT'.$emailcount);
                        array_push($required,'L_EMAIL'.$emailcount);
                        array_push($required,'L_UNIQUEID'.$emailcount);
                        $emailcount ++;
                        if((count($emailids)/$emailcount) == 3){
                                break;
                        }
                }
                
                $params += $emailids;
                $params += $this->_default;
                //print_r($params);exit;
                foreach ($required as $key) {
                    if ( ! isset($params[$key])) {
                        throw new Kohana_Exception('You must provide a :param parameter for :method',
                            array(':param' => $key, ':method' => 'MassPay'));
                    }
                }
        
                return $this->_post('MassPay', $params);
                
        }
	
} // End PayPal_ExpressCheckout
