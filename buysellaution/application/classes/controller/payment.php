<?php defined('SYSPATH') or die('No direct script access.');
/*
* Contains Paypal Payment Module details
* 
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Payment extends Controller_Website {
       
        public function __construct(Request $request, Response $response)
	{
	        
		parent::__construct($request, $response);
		$this->paypal_db = Model::factory('paypal');	
		$this->paypalconfig = $this->paypal_db->getpaypalconfig(); 
		$this->paypaldbconfig = count($this->paypalconfig) > 0?array("username"=>$this->paypalconfig[0]['paypal_api_username'],
		 "password"=>$this->paypalconfig[0]['paypal_api_password'], "signature"=>$this->paypalconfig[0]['paypal_api_signature'], 
		 "environment"=>($this->paypalconfig[0]['payment_method'] =="L")?"live":"sandbox"):"";
		
		// Load default configuration
		$this->paypalconfigfile = Kohana::$config->load('paypal');		
		$this->paypal_account = count($this->paypalconfig) > 0?$this->paypalconfig[0]['paypal_api_username']:$this->paypalconfigfile->username;
		$this->paypal_currencycode = count($this->paypalconfig) > 0?$this->paypalconfig[0]['currency_code']:'USD';
		$this->sitesetting_config = $this->paypal_db->getsitesettingconfig();
                $this->adminId = $this->paypal_db->getadminID(ADMIN_USER_TYPE);//get admin id
                $this->session = Session::instance();
                $this->isadminlogin = (strlen($this->session->get('userid')) > 0 && $this->session->get('userid') == $this->adminId)?1:0;
                $this->siteurl = URL::base('http', TRUE);
                $this->userlogin = ($this->isadminlogin || $this->auction_userid)?1:0;
		$this->email= $this->session->get('auction_email');
	}
	
	public function action_index()
	{	
	       //no direct access allow,redirect to home page   
		Message::error($this->session->get('paypal_error'));     
	       $this->request->redirect('/');
	}
	
	/*
	*Paypal Package order
	*/
	public function action_pay()
	{
	        //if not post redirect to home page
       		if(isset($_POST["pay_order"]) && $this->userlogin )
		{                
		        $package_id = Arr::get($_POST,'package_id');
		        $packagedetails = $this->paypal_db->getpackagedetails($package_id); 
				
			if(count($packagedetails) < 1)
			{
				
				 $this->request->redirect('/');
			}                
		        $amount = number_format($packagedetails[0]['price'], 2, '.', '');
		        $currency_code = $this->paypal_currencycode;  
		       	$product_name=$packagedetails[0]['name'];
		        $produc_title_replacevariable = array("##PACKAGE_TITLE##"=>Html::chars($packagedetails[0]['name']),"##AMOUNT##"=>$amount);

		        $product_title = commonfunction::get_replaced_content(PAYMENT_PACKAGE_TITLE,$produc_title_replacevariable);
		        $sellerid = $packagedetails[0]['package_id'];

                }
		else
		{
                        //show msg as do not call direct payment url
                        //redirect to home here
			Message::error($this->session->get('paypal_error'));
                        $this->request->redirect('/');
                }
                //set production =0 for sandbox testing 1=>live paypal
                $production = 0;
                $notifyurl =  URL_BASE."/payment/notify";                
                $this->payment_success_url = URL_BASE.'cmspage/page/payment-success';
                $returnurl = URL_BASE.'payment/checkout';               
                $cancelurl = URL_BASE.'payment/cancelled';
               	$email = $this->email;
                $payment_gateway = "ExpressCheckout";                
                if($payment_gateway == "Paypal")
                {
                        $paypal = new Paypal;
                        //send control to paypal url usinf process single function
                        $paypal->item_name($product_name)
                        ->amount($amount)
                        ->notify_url($notifyurl)
                        ->return_url($returnurl) //your thank you page, where paypal will be redirected after the transaction
                        ->cancel_return($cancelurl)
                        ->custom("custom info")
                        ->currency_code($currency_code)
                        ->production($production)
                        ->process_single();                        
                }
		else
		{
			
			$invoceno = commonfunction::randomkey_generator();
			$paypal = Paypal::instance('ExpressCheckout',$this->paypaldbconfig);

			//Deleted values in array
			$data = array(
				'AMT' => $amount, 
				'CURRENCYCODE' => $this->paypal_currencycode, 
				'RETURNURL' => $returnurl, 
				'CANCELURL' => $cancelurl , 
				'PAYMENTACTION' =>'Sale',
				'DESC'=>$product_title,
				'EMAIL'=>$email,
				'NOSHIPPING'=>1,
				'L_NAME0'=>$product_name,
				'L_NUMBER0'=>$package_id,
				'L_QTY0'=>1,
				'L_TAXAMT0'=>0.00,
				'L_AMT0'=>$amount,
				'ITEMAMT'=>$amount,
				'INVNUM'=>$invoceno,
				'PACKAGEID'=>$package_id);
			$payment = $paypal->set($data);

			if (Arr::get($payment, 'ACK') === 'Success')
			{ 
				// Store token in SESSION
				$this->session->set('paypal_token_' . $payment['TOKEN'], $amount);
				$this->session->set('paypal_sellerid_' . $payment['TOKEN'], $sellerid);
				$this->session->set('paypal_invoiceno_' . $payment['TOKEN'], $invoceno);
				$this->session->set('paypal_producttitle_' . $payment['TOKEN'], $product_title);


				// We now send the user to the Paypal site for them to provide their details
				$params = $data;
				$params['token'] = $payment['TOKEN'];
				unset($params['PAYMENTACTION']);

				$url = $paypal->redirect_url('express-checkout', $params);
				$this->request->redirect($url);
			}
			else
			{
				Message::error($this->session->get('paypal_error'));
				$this->request->redirect('/');
			}
                }
	}
	
	public function action_checkout()
	{
	  	// Check token is valid so you can load details
	        $token = Arr::get($_GET, 'token');              

                // Load the Paypal object
                $paypal = Paypal::instance('ExpressCheckout',$this->paypaldbconfig);

                // Get the customers details from Paypal
                $customer = $paypal->GetExpressCheckoutDetails(array('TOKEN'=>$token));                

                if (Arr::get($customer, 'ACK') === 'Success')
		{

                        // Perform any calculations to determine the final charging price
                        $params = array(
                        'TOKEN'     => $token,
                        'PAYERID'   => Arr::get($customer, 'PAYERID'),
                        'AMT'       => $this->session->get('paypal_token_'.$token),
			'CURRENCYCODE' => $this->paypal_currencycode, 
                        );
                        // Process the payment
                        $paymentresponse = $paypal->DoExpressCheckoutPayment($params);
                       
                        if (Arr::get($paymentresponse, 'ACK') === 'Success') {
                        
                        //
                        $transactionfield = array(
                        'PAYERID' => Arr::get($customer, 'PAYERID'),
                        'PAYERSTATUS' => Arr::get($customer, 'PAYERSTATUS'),
                        'FIRSTNAME' => Arr::get($customer, 'FIRSTNAME'),
                        'LASTNAME' => Arr::get($customer, 'LASTNAME'),
                        'EMAIL' => Arr::get($customer, 'EMAIL'),
                        'COUNTRYCODE' => Arr::get($customer, 'COUNTRYCODE'),
                        'PACKAGEID' => Arr::get($customer, 'L_NUMBER0'),
                        'USERID' => $this->session->get('auction_userid'),                       
                        'INVOICEID' => $this->session->get('paypal_invoiceno_' .$token),
                        'LOGIN_ID' => Request::$client_ip,
                        'USER_AGENT' => Request::$user_agent
                        );
                        $transactionfield = $transactionfield + $paymentresponse;
                        //insert transaction status
                        $transaction_detail=$this->paypal_db->addtransaction_deatils($transactionfield);
                        $last_transaction_insert_id = $transaction_detail[0];
                        $max_date_complete_db_format = "";
                        $orderfields = array(
                        'order_no' => $this->session->get('paypal_invoiceno_' .$token),
                        'package_id' => Arr::get($customer, 'L_NUMBER0'),
                        'buyer_id' => $this->session->get('auction_userid'),
                        'seller_id' => $this->session->get('paypal_sellerid_'.$token),
                        'order_status' => SUCCESS_PAYMENT_ORDER_STATUS,
                        'action' => SUCCESS_PAYMENT_ORDER_ACTION,
                        'package_amount' =>  $this->session->get('paypal_token_'.$token),
                        'package_commission_amount' => "",
                        'order_total' => $this->session->get('paypal_token_'.$token),
                        'order_subtotal' => 0.00,
                        'order_currency_code' => Arr::get($paymentresponse, 'CURRENCYCODE'),
                        'paid_status' => PAID_PENDING, 
                        'maximum_date_complete' => $max_date_complete_db_format,
                        'transaction_details_id' => $last_transaction_insert_id  
                        );
                        
                        //add transaction id in orderfields
                       
                        //insert order status
                        $order_db_response =$this->paypal_db->addorder_details($orderfields);    
                        
                        $buyer_name =$this->paypal_db->get_username($this->session->get('auction_userid'));
                        
                        $buyer_replace_variables = array('##BUYERNAME##'=>$buyer_name, '##PACKAGE_NAME##'=>$this->session->get('paypal_producttitle_' .$token),
                         '##AMOUNT##'=>Arr::get($paymentresponse, 'AMT'),'##ORDER_NO##'=>$this->session->get('paypal_invoiceno_' .$token)); 
                        
                        $buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PACKAGE_DESC,$buyer_replace_variables);
                        
                        $transactionlog_details_buyer = array(
                        'userid' =>  $this->session->get('auction_userid'),
                        'order_no' => $this->session->get('paypal_invoiceno_' .$token),
                        'packageid' => Arr::get($customer, 'L_NUMBER0'),
                        'amount' => Arr::get($paymentresponse, 'AMT'),
                        'amount_type' => DEBIT,                                      //login user a/c 
                        'description' => $buyer_desc,
                        
                        );
                        
                        $this->paypal_db->addtransactionlog_details($transactionlog_details_buyer);
                      
                        //its good idea to destroy assign after data insert
                        $this->session->delete('paypal_paypal_token_'.$token);
                        $this->session->delete('paypal_sellerid_'.$token);
                        $this->session->delete('paypal_invoiceno_' .$token);
                        $this->session->delete('paypal_producttitle_' .$token);
                        //redirect to thankyou page   
			$user_current_amount=$this->paypal_db->get_user_account($this->session->get('auction_userid'));
			$return_amount=Arr::get($paymentresponse, 'AMT');
			$total_amount=$user_current_amount+$return_amount;
                        $credit_account_touser=$this->paypal_db->update_useraccount($this->session->get('auction_userid'),$total_amount);
			$this->request->redirect('cmspage/page/payment-success');
                        }
			else
			{
                                //redirect to api error page
				Message::error($this->session->get('paypal_error'));
                                $this->request->redirect("/");
                        }			
			//redirect to api error page
			Message::error($this->session->get('paypal_error'));
                        $this->request->redirect("/");
                }

	}
	
	public function action_cancelled()
	{ 
			//set cancel message
			$this->request->redirect('/');
			//create cancel page and call 
	}
	
	public function action_apierror(){ 
			//change order status 
			//
			//create cancel page and call 
			
	}
	
	
	
}//End of payment controller
?> 
