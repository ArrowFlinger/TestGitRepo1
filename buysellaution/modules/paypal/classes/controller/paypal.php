<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains package controller actions
 *
 * @Package: Nauction Platinum Version 1.0
 * @Created on Dec 24, 2012
 * @Updated on Dec 24, 2012
 * @author     Ndot Team
 * @copyright  (c) 2008-2012 Ndot Team
 * @license    http://ndot.in/license 
 */

class Controller_Paypal extends Controller_Website {	

	/**
	* ****__construct()****
	* setting up future and closed result query (For righthand side view)
	*/
	
	protected $post = array();
	protected $code = "paypal";
	public function __construct(Request $request, Response $response)
        { 
		parent::__construct($request,$response); 
                $this->paypal_db= Model::factory('paypal');
		
		/*** venkatraja added in 7-Mar-13 ***/
		
		$this->paypal_product_db=Model::factory('buynowproductpaypal');
		
		
		/*** venkatraja added end in 7-Mar-13 ***/
		
                
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
		
		if(!(preg_match('/users\/login/i',Request::detect_uri()) || preg_match('/users\/signup/i',Request::detect_uri()) || preg_match('/buynow\/buynow_offline/i',Request::detect_uri()) || preg_match('/buynow\/buynow_addcart/i',Request::detect_uri()) || preg_match('/buynow\/buynow_auction/i',Request::detect_uri())  )){
			//Override the template variable decalred in website controller  
			// $this->template=THEME_FOLDER."template_user_sidebar";
		}else{
			//Override the template variable decalred in website controller
		$this->template="themes/template";
		} 
		 
		if(isset($_POST['form']) && count($_POST)>0)
		{
			$this->session->set('paypalpost',$_POST['form']);
			$this->post = $_POST['form'];
		}
		else
		{
			$this->post = $this->session->get('paypalpost');
		} 
	}
	/**** Added By venkatraja 15-Mar-2013 ****/
	public function action_transactionlogs(){
		
		
		
		$invoicenumber=isset($_REQUEST['invoicenumber'])?$_REQUEST['invoicenumber']:'';
		
		
		//$transactiondetails=$this->paypal_product_db->gettransactionlogdetails($invoicenumber);
		
		$page_data=$this->paypal_product_db->show_payment_log_content($invoicenumber);
		//print_r($page_data);exit;
		
		//splitting created_date to display proper format
		                foreach($page_data as $payment_log)
		                {
			                $page_data['TIMESTAMP'] = $this->DisplayDateTimeFormat($payment_log["TIMESTAMP"]);
			                $page_data['created_date'] = $this->DisplayDateTimeFormat($payment_log["created_date"]);
			                $page_data['ID'] = $payment_log["ID"];
			                $page_data['REASONCODE'] = $payment_log["REASONCODE"];
			                $page_data['PAYERSTATUS'] = $payment_log["PAYERSTATUS"];
			                $page_data['PAYMENTSTATUS'] = $payment_log["PAYMENTSTATUS"];
			                $page_data['FEEAMT'] = $payment_log["FEEAMT"];
			                $page_data['AMT'] = $payment_log["AMT"];
			                $page_data['shipping_fee'] = $payment_log["shipping_fee"];			                
			                $page_data['EMAIL'] = $payment_log["EMAIL"];
			                $page_data['TRANSACTIONID']	= 	$payment_log["TRANSACTIONID"];	
			                $page_data['LOGIN_ID']	= 	$payment_log["LOGIN_ID"];	
			                $page_data['PAYERID']	= 	$payment_log["PAYERID"];	
			                $page_data['username']	= 	$payment_log["username"];	
			                $page_data['COUNTRYCODE'] = $payment_log["COUNTRYCODE"];
			                $page_data['RECEIVER_EMAIL']	= 	$payment_log["RECEIVER_EMAIL"];	
			                $page_data['CORRELATIONID']	= 	$payment_log["CORRELATIONID"];	
			                $page_data['ACK']	= 	$payment_log["ACK"];	
			                $page_data['REASONCODE']	= 	$payment_log["REASONCODE"];
			                $page_data['TRANSACTIONTYPE'] = $payment_log["TRANSACTIONTYPE"];
			                $page_data['RECEIPTID']	= 	$payment_log["RECEIPTID"];	
			                $page_data['ORDERTIME']	= 	$this->DisplayDateTimeFormat($payment_log["ORDERTIME"]);	
			                $page_data['CURRENCYCODE']	= 	$payment_log["CURRENCYCODE"];		
			                $page_data['PENDINGREASON'] = $payment_log["PENDINGREASON"];											
			                $page_data['INVOICEID']	= 	$payment_log["INVOICEID"];	
			                $page_data['PAYMENTTYPE']	= 	$payment_log["PAYMENTTYPE"];
		                }  
		
		
		
		$view = View::factory('admin/paypaltransactionlog')
                                ->bind('page_data',$page_data);
		$this->template= $view;
		
		
		}	
	
	/*** Added End By Venkatraja ***/
	
	 
	
	public function action_process()
	{ 
		$this->auto_render =false; 
		$response = $this->post;
		 
		//if not post redirect to home page
		
		$type = isset($this->post['type'])?$this->post['type']:"";
		
	
		switch($type)
		{ 
			case "package";
				$this->totalorder($response);
				break;
			case "reserveauction":
				$this->totalorder($response);
				break;
			case "product":
				$this->productorder($response);
				break;
			case "wonauction":
				$this->wonorder($response);
				break; 
			case "clockauction":
				$this->clockorder($response);
				break;
			
			default:
			    break;
		}
		
		
	}
	
	/*** venkatraja added start in 7-March-13 ***/
	
	
	
	/*
	*BuyNow option using Product  order Offline
	*User Balance low mean using pay pal
	*/
	public function wonorder($response)
	{ 
		
		//if not post redirect to home page
       		if((count($response)>0) && $this->userlogin )
		{
			
			$product_id =$response['id'][0];
			$quantity=$response['quantity'][0];
			$product_name = $response['name'][0];
			$productcost = $response['unitprice'][0];
			if(isset($response['shipping_cost']))
			{
			$shippingfee=($response['shipping_cost']>0)?$response['shipping_cost']:0;	
				
			}else{
				
			$shippingfee=0;	
				
			}
			$userid = $this->session->get('auction_userid');
		        $amount = number_format($productcost, 2, '.', '');
			
		        $currency_code = $this->paypal_currencycode;  
		      
		        $produc_title_replacevariable = array("##PRODUCT_TITLE##"=>Html::chars($product_name),"##AMOUNT##"=>$amount);

		        $product_title = commonfunction::get_replaced_content(PAYMENT_PRODUCT_TITLE,$produc_title_replacevariable);
		        $sellerid =$product_id;
                }   
		else
		{
			
                        //show msg as do not call direct payment url
                        //redirect to home here
                        $this->request->redirect('/');
			Message::error(__('Your Details something worng'));
                }
		
                //set production =0 for sandbox testing 1=>live paypal
                $production = 0;
                $notifyurl =  URL_BASE."paypal/notify";              
                $this->payment_success_url = URL_BASE.'site/buynow/products_transactions';
	       
		//Flash message 
                //Message::success(__('paypal_success'));
		$returnurl = URL_BASE.'paypal/woncheckout';
		 $cancelurl = URL_BASE.'paypal/cancelled';
		
		
		
		
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
			$n = 0;
			$amount_tot=0;
			$orderamt=$productcost*$quantity;
			$sorderamt=0;
			$data = array();
			$sfee=0;
		 
			
				$data['method'] = 'SetExpressCheckout';
				$data['PAYMENTREQUEST_0_PAYMENTACTION']='Sale';
				$data['RETURNURL'] = $returnurl; 
				$data['CANCELURL'] = $cancelurl ;
				$data['L_PAYMENTREQUEST_0_NAME0']=$product_name;
				$data['L_PAYMENTREQUEST_0_NUMBER0']=$product_id;
				$data['L_PAYMENTREQUEST_0_DESC0']=$product_name;
				$data['L_PAYMENTREQUEST_0_AMT0']=Commonfunction::numberformat($productcost);
				$data['L_PAYMENTREQUEST_0_QTY0']=$quantity;				
				$data['PAYMENTREQUEST_0_ITEMAMT']=Commonfunction::numberformat($orderamt);
				$data['PAYMENTREQUEST_0_TAXAMT']=0.00;
				$data['PAYMENTREQUEST_0_SHIPPINGAMT']=Commonfunction::numberformat($shippingfee);
				$data['SHIPPINGAMT']=Commonfunction::numberformat($shippingfee); 
				$data['PAYMENTREQUEST_0_HANDLINGAMT']=0.00;    
				$data['PAYMENTREQUEST_0_SHIPDISCAMT']=0.00;  
				$data['PAYMENTREQUEST_0_INSURANCEAMT']=0.00;  
				$data['TOTALQTY']=$n; 
				$data['PAYMENTREQUEST_0_AMT']=($orderamt+$shippingfee);  
				$data['INVNUM']=$invoceno;
				
				$data['PAYMENTREQUEST_0_CURRENCYCODE']=$this->paypal_currencycode;
				$data['ALLOWNOTE']=1;						
			
		
			$data['AMT'] = ($orderamt+$shippingfee);
			
	
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
	
	public function action_woncheckout()
	{   		

		
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
				$quantity=Arr::get($customer,'L_QTY0');
				$productcost=Arr::get($customer,'L_AMT0');
				$productid=Arr::get($customer, 'L_NUMBER0');
				$getproductdetails=$this->paypal_product_db->getproductdetails($productid);
				
				$shippingfee=Arr::get($customer,'SHIPPINGAMT');
				$totalamount=($productcost*$quantity)+$shippingfee;
                       
				$transactionfield['PAYERID'] = Arr::get($customer, 'PAYERID');
				$transactionfield['PAYERSTATUS'] = Arr::get($customer, 'PAYERSTATUS');
				$transactionfield['FIRSTNAME'] = Arr::get($customer, 'FIRSTNAME');
				$transactionfield['LASTNAME'] = Arr::get($customer, 'LASTNAME');
				$transactionfield['EMAIL'] = Arr::get($customer, 'EMAIL');
				$transactionfield['L_PAYMENTREQUEST_0_AMT0']= Arr::get($customer,'L_AMT0');
				$transactionfield['SHIPPINGAMT0']=Arr::get($customer,'SHIPPINGAMT'); 
				$transactionfield['COUNTRYCODE'] = Arr::get($customer, 'COUNTRYCODE');
				$transactionfield['PRODUCTID'][0] = Arr::get($customer, 'L_NUMBER0');
				$transactionfield['USERID'] = $this->session->get('auction_userid');                      
				$transactionfield['INVOICEID'] = $this->session->get('paypal_invoiceno_' .$token);
				$transactionfield['LOGIN_ID'] = Request::$client_ip;
				$transactionfield['USER_AGENT'] = Request::$user_agent;   			                  
			
			
                        $transactionfield = $transactionfield + $paymentresponse;					
                        //insert transaction status
                        $transaction_detail=$this->paypal_product_db->addwontransaction_deatils($transactionfield);
			
			
		//redirect to thankyou page   
		$packorder = array('res_order' => $this->session->get('paypal_invoiceno_' .$token),
					'payment_type' => $this->code,
					'auction_id'=> Arr::get($customer, 'L_NUMBER0'),
					'buyer_id' => $this->session->get('auction_userid'), 
					'order_status' => 'S',
					'bidmethod' => Commonfunction::get_auction_bid_name($productid),
					'total' => $productcost,
					'shippingamount'=>$shippingfee,
					'currency_code' => Arr::get($paymentresponse, 'CURRENCYCODE')); 
		$insertpackgageorder = $this->paypal_product_db->addwonorder_details($packorder);
		$buyer_name =$this->paypal_product_db->get_username($this->session->get('auction_userid'));
		      
		$quantity=Arr::get($customer,'L_QTY0');
		$productcost=Arr::get($customer,'L_AMT0');
		$productid=Arr::get($customer, 'L_NUMBER0');
		
		$shippingfee=Arr::get($customer,'SHIPPINGAMT');
		$shippingfee=($shippingfee!='')?$shippingfee:0;
		$totalamount=($productcost*$quantity)+$shippingfee;
				
			
			
			$product_name=$this->session->get('paypal_producttitle_' .$token);
			$total_amount=$this->site_currency." ".Commonfunction::numberformat($totalamount);
			$shipping_fee=$this->site_currency." ".Commonfunction::numberformat($shippingfee);
			$product_cost=$this->site_currency." ".Commonfunction::numberformat($productcost);
			$order_no=$this->session->get('paypal_invoiceno_' .$token);
			
			
			if($shippingfee>0){
				$buyer_desc =__('buynow_product_desc_orderno',array(':param'=>$buyer_name,':param1'=>$product_name,
										    ':param2'=>$product_cost,':param3'=>$quantity,
										    ':param4'=>$shipping_fee,
										    ':param5'=>$total_amount,':param6'=>$order_no));
	
			}else{
				
				$buyer_desc =__('buynow_product_desc_without_shipping_orderno',array(':param'=>$buyer_name,':param1'=>$product_name,
												     ':param2'=>$product_cost,':param3'=>$quantity,
												     ':param4'=>$total_amount,':param6'=>$order_no));

			}
				
		       $transactionlog_details_buyer['site_currency'] =  $this->site_currency;
                        $transactionlog_details_buyer['userid'] =  $this->session->get('auction_userid');
                        $transactionlog_details_buyer['order_no'] = $this->session->get('paypal_invoiceno_' .$token);
                        $transactionlog_details_buyer['productid'][0] = Arr::get($customer, 'L_NUMBER0');
                       // $transactionlog_details_buyer['amount'] = Arr::get($paymentresponse, 'AMT');
			$transactionlog_details_buyer['amount0']= Arr::get($customer,'L_AMT0');
                        $transactionlog_details_buyer['amount_type'] = DEBIT;
			$transactionlog_details_buyer['quantity'][0] = $quantity;
			$transactionlog_details_buyer['shippingamount'][0] =$shippingfee;
			$transactionlog_details_buyer['description'][0] =$buyer_desc; 
			//login user a/c 
                        $transactionlog_details_buyer['product_name'][0] = $this->session->get('paypal_producttitle_' .$token);                        
                        
                        $this->paypal_product_db->addwontransactionlog_details($transactionlog_details_buyer);
			
			$orderresponse = array('order_id' => $this->session->get('paypal_invoiceno_' .$token),'shipping' => $shippingfee,'user_id' => $this->session->get('auction_userid'),'currency'=>Arr::get($paymentresponse, 'CURRENCYCODE'),'product_id' => Arr::get($customer, 'L_NUMBER0'),'price' =>Arr::get($paymentresponse, 'AMT') );
			Commonfunction::AuctionOrdermail($orderresponse);
                        //its good idea to destroy assign after data insert
                        $this->session->delete('paypal_paypal_token_'.$token);
                        $this->session->delete('paypal_sellerid_'.$token);
                        $this->session->delete('paypal_invoiceno_' .$token);
                        $this->session->delete('paypal_producttitle_' .$token);
                        
	
			
			//End			
			
			$this->request->redirect('users/mytransactions');
                        
                        
			Message::success(__('paypal_success'));	
                        }
			else
			{       //redirect to api error page
                                $this->request->redirect("/");
				Message::error($this->session->get('paypal_error'));
                        }			
			//redirect to api error page
                        $this->request->redirect("/");
			Message::error($this->session->get('paypal_error'));
                }
	}

	
	/*
	*BuyNow option using Product  order Offline
	*User Balance low mean using pay pal
	*/
	public function productorder($response)
	{
		
		//if not post redirect to home page
       		if((count($response)>0) && $this->userlogin )
		{  
			    
			$userid = $this->session->get('auction_userid');      
		        $product_id = Arr::get($_POST,'product_id');
		        $productdetails = $this->paypal_product_db->all_addtocart_list($userid);
			
			$productcost = $productdetails[0]['amount'];		
		        $amount = number_format($productcost, 2, '.', '');
			
		        $currency_code = $this->paypal_currencycode;  
		       	$product_name=$productdetails[0]['product_name'];
		        $produc_title_replacevariable = array("##PRODUCT_TITLE##"=>Html::chars($product_name),"##AMOUNT##"=>$amount);

		        $product_title = commonfunction::get_replaced_content(PAYMENT_PRODUCT_TITLE,$produc_title_replacevariable);
		        $sellerid = $productdetails[0]['product_id'];
                }   
		else
		{
			
                        //show msg as do not call direct payment url
                        //redirect to home here
                        $this->request->redirect('/');
			Message::error(__('Your Details something worng'));
                }
		
                //set production =0 for sandbox testing 1=>live paypal
                $production = 0;
                $notifyurl =  URL_BASE."paypal/notify";              
                $this->payment_success_url = URL_BASE.'site/buynow/products_transactions';
	       
		//Flash message 
                //Message::success(__('paypal_success'));
		$returnurl = URL_BASE.'paypal/productcheckout';
		 $cancelurl = URL_BASE.'paypal/cancelled';
		
		
		
		
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
			$n = 0;
			$amount_tot=0;
			$orderamt=0;
			$sorderamt=0;
			$data = array();
			$sfee=0;
		 
			
				$data['method'] = 'SetExpressCheckout';
				$data['PAYMENTREQUEST_0_PAYMENTACTION']='Sale';
				$data['RETURNURL'] = $returnurl; 
				$data['CANCELURL'] = $cancelurl ;
				
				foreach ($productdetails as $product) {
			$shippingfee=($product['shipping_fee']!='')?$product['shipping_fee']:0;
		
			$amt1=($product['product_cost']) * $product['quantity'];
			$amount_tot+= $amt1;
			$orderamt+=$amt1;
			$sfee+=$shippingfee;
		 	
			//$sorderamt+=$shippingorderamt;
				
				
				$data['L_PAYMENTREQUEST_0_NAME'.$n]=$product['product_name'];
				$data['L_PAYMENTREQUEST_0_NUMBER'.$n]=$product['productid'];
				$data['L_PAYMENTREQUEST_0_DESC'.$n]=$product['product_name'];
				$data['L_PAYMENTREQUEST_0_AMT'.$n]=Commonfunction::numberformat($product['product_cost']);
				
				$data['L_PAYMENTREQUEST_0_QTY'.$n]=$product['quantity'];				
				
			
					 ++$n;				
				$amount_tot="";
			}
				$data['PAYMENTREQUEST_0_ITEMAMT']=Commonfunction::numberformat($orderamt);
				$data['PAYMENTREQUEST_0_TAXAMT']=0.00;
				$data['PAYMENTREQUEST_0_SHIPPINGAMT']=Commonfunction::numberformat($sfee);
				$data['SHIPPINGAMT']=10.00; 
				$data['PAYMENTREQUEST_0_HANDLINGAMT']=0.00;    
				$data['PAYMENTREQUEST_0_SHIPDISCAMT']=0.00;  
				$data['PAYMENTREQUEST_0_INSURANCEAMT']=0.00;  
				$data['TOTALQTY']=$n; 
				$data['PAYMENTREQUEST_0_AMT']=($orderamt+$sfee);  
				$data['INVNUM']=$invoceno;
				
				$data['PAYMENTREQUEST_0_CURRENCYCODE']=$this->paypal_currencycode;
				$data['ALLOWNOTE']=1;						
			
		
			$data['AMT'] = ($orderamt+$sfee);
			
		
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
	
	public function action_productcheckout()
	{
		
	  	// Check token is valid so you can load details
	        $token = Arr::get($_GET, 'token');
                // Load the Paypal object
                $paypal = Paypal::instance('ExpressCheckout',$this->paypaldbconfig);
                // Get the customers details from Paypal
                $customer = $paypal->GetExpressCheckoutDetails(array('TOKEN'=>$token));                
		$producttotalcoutid = count($this->paypal_product_db->all_addtocart_list($this->session->get('auction_userid')))-1;		
		
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
			for($i=0;$i<=$producttotalcoutid;$i++){
				$quantity=Arr::get($customer,'L_QTY'.$i);
				$productcost=Arr::get($customer,'L_AMT'.$i);
				$productid=Arr::get($customer, 'L_NUMBER'.$i);
				$getproductdetails=$this->paypal_product_db->getproductdetails($productid);
				$shippingfee=$getproductdetails[0]['shipping_fee'];
				$shippingfee=($shippingfee!='')?$shippingfee:0;
				$totalamount=($productcost*$quantity)+$shippingfee;
                       
				$transactionfield['PAYERID'] = Arr::get($customer, 'PAYERID');
				$transactionfield['PAYERSTATUS'] = Arr::get($customer, 'PAYERSTATUS');
				$transactionfield['FIRSTNAME'] = Arr::get($customer, 'FIRSTNAME');
				$transactionfield['LASTNAME'] = Arr::get($customer, 'LASTNAME');
				$transactionfield['EMAIL'] = Arr::get($customer, 'EMAIL');
				$transactionfield['L_PAYMENTREQUEST_0_AMT'.$i]= $totalamount;
				$transactionfields['TRANSACTIONTYPE']='Paypal';
				$transactionfield['SHIPPINGAMT'.$i]=Arr::get($customer,'SHIPPINGAMT'.$i); 
				$transactionfield['COUNTRYCODE'] = Arr::get($customer, 'COUNTRYCODE');
				$transactionfield['PRODUCTID'][$i] = Arr::get($customer, 'L_NUMBER'.$i);
				$transactionfield['USERID'] = $this->session->get('auction_userid');                      
				$transactionfield['INVOICEID'] = $this->session->get('paypal_invoiceno_' .$token);
				$transactionfield['LOGIN_ID'] = Request::$client_ip;
				$transactionfield['USER_AGENT'] = Request::$user_agent;   			                  
			}
			
                        $transactionfield = $transactionfield + $paymentresponse;					
                        //insert transaction status
                        $transaction_detail=$this->paypal_product_db->addtransaction_deatils($transactionfield,$producttotalcoutid);
			
			
			$last_transaction_insert_id = $this->paypal_product_db->get_last_transaction_id();
			
                        $max_date_complete_db_format = "";			
                        $orderfields = array(
                        'order_no' => $this->session->get('paypal_invoiceno_' .$token),
                        'product_id' => Arr::get($customer, 'L_NUMBER0'),
                        'buyer_id' => $this->session->get('auction_userid'),
                        'seller_id' => $this->session->get('paypal_sellerid_'.$token),
                        'order_status' => SUCCESS_PAYMENT_ORDER_STATUS,
                        'action' => SUCCESS_PAYMENT_ORDER_ACTION,
                        'product_cost' =>  $this->session->get('paypal_token_'.$token),
                        'product_commission_amount' => "",
                        'order_total' => $this->session->get('paypal_token_'.$token),
                        'order_subtotal' => 0.00,
                        'order_currency_code' => Arr::get($paymentresponse, 'CURRENCYCODE'),
                        'paid_status' => PAID_PENDING, 
                        'maximum_date_complete' => $max_date_complete_db_format,
                        'transaction_details_id' => $last_transaction_insert_id  
                        );
                    
                        //add transaction id in orderfields                       
                        //insert order status			
                        $order_db_response =$this->paypal_product_db->addorder_details($orderfields); 
                        $buyer_name =$this->paypal_product_db->get_username($this->session->get('auction_userid'));
			
			
                       $auctionproductdetails=array();
                        for($i=0;$i<=$producttotalcoutid;$i++){
				$quantity=Arr::get($customer,'L_QTY'.$i);
				$productcost=Arr::get($customer,'L_AMT'.$i);
				$productid=Arr::get($customer, 'L_NUMBER'.$i);
				$getproductdetails=$this->paypal_product_db->getproductdetails($productid);
				$shippingfee=$getproductdetails[0]['shipping_fee'];
				$shippingfee=($shippingfee!='')?$shippingfee:0;
				$totalamount=($productcost*$quantity)+$shippingfee;
				
				$fieldvalues['id']=$productid;
				$fieldvalues['unitprice']=$productcost;
				$fieldvalues['quantity']=$quantity;			
				$auctionproductdetails[]=$fieldvalues;
			
			
			$product_name=$this->session->get('paypal_producttitle_' .$token);
			$total_amount=$this->site_currency." ".Commonfunction::numberformat($totalamount);
			$shipping_fee=$this->site_currency." ".Commonfunction::numberformat($shippingfee);
			$product_cost=$this->site_currency." ".Commonfunction::numberformat($productcost);
			$order_no=$this->session->get('paypal_invoiceno_' .$token);
			
			
			if($shippingfee>0){
				$buyer_desc =__('buynow_product_desc_orderno',array(':param'=>$buyer_name,':param1'=>$product_name,
										    ':param2'=>$product_cost,':param3'=>$quantity,
										    ':param4'=>$shipping_fee,
										    ':param5'=>$total_amount,':param6'=>$order_no));
	
			}else{
				
				$buyer_desc =__('buynow_product_desc_without_shipping_orderno',array(':param'=>$buyer_name,':param1'=>$product_name,
												     ':param2'=>$product_cost,':param3'=>$quantity,
												     ':param4'=>$total_amount,':param6'=>$order_no));

			}
				
				
                       // $transactionlog_details_buyer = array(
		       $transactionlog_details_buyer['site_currency'] =  $this->site_currency;
                        $transactionlog_details_buyer['userid'] =  $this->session->get('auction_userid');
                        $transactionlog_details_buyer['order_no'] = $this->session->get('paypal_invoiceno_' .$token);
                        $transactionlog_details_buyer['productid'][$i] = Arr::get($customer, 'L_NUMBER'.$i);
                       // $transactionlog_details_buyer['amount'] = Arr::get($paymentresponse, 'AMT');
			$transactionlog_details_buyer['amount'.$i]= Arr::get($customer,'L_AMT'.$i);
                        $transactionlog_details_buyer['amount_type'] = DEBIT;
			$transactionlog_details_buyer['quantity'][$i] = $quantity;
			$transactionlog_details_buyer['shippingamount'][$i] =$shippingfee;
			$transactionlog_details_buyer['description'][$i] =$buyer_desc; 
			//login user a/c 
                        $transactionlog_details_buyer['product_name'][$i] = $this->session->get('paypal_producttitle_' .$token);                        
                        //);
                        }
                        $this->paypal_product_db->addtransactionlog_details($transactionlog_details_buyer,$producttotalcoutid);
			
			
			$orderresponse = array('order_id' => $this->session->get('paypal_invoiceno_' .$token),'shipping' => $shippingfee,'user_id' => $this->session->get('auction_userid'),'currency'=>Arr::get($paymentresponse, 'CURRENCYCODE'),'product_unique_details' => $auctionproductdetails,'price' =>Arr::get($paymentresponse, 'AMT') );
			Buynow::BuynowOrdermail($orderresponse);
	
			
                        //its good idea to destroy assign after data insert
                        $this->session->delete('paypal_paypal_token_'.$token);
                        $this->session->delete('paypal_sellerid_'.$token);
                        $this->session->delete('paypal_invoiceno_' .$token);
                        $this->session->delete('paypal_producttitle_' .$token);
                    		
			$this->paypal_product_db->order_delete($transactionlog_details_buyer,$producttotalcoutid,$this->session->get('auction_userid'));
			$this->request->redirect('site/buynow/products_transactions');
			Message::success(__('paypal_success'));	
                        }
			else
			{       //redirect to api error page
                                $this->request->redirect("/");
				Message::error($this->session->get('paypal_error'));
                        }			
			//redirect to api error page
                        $this->request->redirect("/");
			Message::error($this->session->get('paypal_error'));
                }
	}

	/*** venkatraja added end***/
	
	
	public function totalorder($response)
	{
		
		
		if(count($response['id'])>0)
		{
			if(count($response['id'])>1)
			{
				
				$sub_amount_arr=array();
				
				for($n=0;$n<count($response['id']);$n++)
				{
				    
				    $sub_amount_arr[]=$response['unitprice'][$n]*$response['quantity'][$n];
				  
				}
				
				$package_id=implode(",",$response['id']);
				  
				$amount = number_format(array_sum($sub_amount_arr), 2, '.', '');
				$product_name=implode(",",$response['name']);
				
				
				
			}else{
		
			
			$package_id = $response['id'][0];
			$amount = number_format($response['unitprice'][0], 2, '.', '');
			
			$product_name=$response['name'][0];
			
			
			
			}
			$currency_code = $this->paypal_currencycode;  
			$sellerid = 0;
			
			$produc_title_replacevariable = array("##PACKAGE_TITLE##"=>Html::chars($product_name),"##AMOUNT##"=>$amount);
			$product_title = commonfunction::get_replaced_content(PAYMENT_PACKAGE_TITLE,$produc_title_replacevariable);
			$sellerid = 0;
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
		
		
		$notifyurl =  URL_BASE."paypal/notify"; 
		$this->payment_success_url = URL_BASE.'paypal/cmspage/page/package-payment-success'; 
		$returnurl = URL_BASE.'paypal/checkout'; 
		$cancelurl = URL_BASE.'paypal/cancelled';  
		
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
			
			if (Arr::get($payment, 'ACK') === 'Success'){ 
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
			}else{
				Message::error($this->session->get('paypal_error'));
				$this->request->redirect('/');
			}
		}
	}
	
	
	public function clockorder($response)
	{
		 
		
		if(count($response['id'])>0) 
		{ 
			if(count($response['id'])>1)
			{  
				
				$sub_amount_arr=array();
				
				for($n=0;$n<count($response['id']);$n++)
				{
				    
				    $sub_amount_arr[]=$response['unitprice'][$n]*$response['quantity'][$n];
				  
				}
				
				$package_id=implode(",",$response['id']);
				  
				$amount = number_format(array_sum($sub_amount_arr), 2, '.', '');
				$product_name=implode(",",$response['name']);
				
				
				
			}else{  
		
			
			$package_id = $response['id'][0];
			$amount = number_format($response['unitprice'][0], 2, '.', '');
			
			$product_name=$response['name'][0];
			
			
			
			}
			$currency_code = $this->paypal_currencycode;  
			$sellerid = 0;
			
			$produc_title_replacevariable = array("##PACKAGE_TITLE##"=>Html::chars($product_name),"##AMOUNT##"=>$amount);
			$product_title = commonfunction::get_replaced_content(PAYMENT_PACKAGE_TITLE,$produc_title_replacevariable);
			$sellerid = 0;
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
		
		
		$notifyurl =  URL_BASE."paypal/notify"; 
		$this->payment_success_url = URL_BASE.'paypal/cmspage/page/package-payment-success'; 
		$returnurl = URL_BASE.'paypal/checkout'; 
		$cancelurl = URL_BASE.'paypal/cancelled';  
		
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
			 
			
			if (Arr::get($payment, 'ACK') === 'Success'){ 
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
			}else{
				Message::error($this->session->get('paypal_error'));
				$this->request->redirect('/');
			}
		}
	}
	 
	public function action_paypal_payment(){ 
		 
		/**Check Whether the user is logged in**/
		$this->is_login();
		 
		$userid = $this->session->get('auction_userid');
		if(!$this->post)
		{
		      $this->request->redirect('/');
		}
		 
		$view=View::factory('paypal/'.THEME_FOLDER.'paypal_payment')
				->bind('post',$this->post);
				
		$this->template->content=$view; 
		$this->template->title="Bid Packages";
		$this->template->meta_description="Packages";
		$this->template->meta_keywords="Auctions Bid packages"; 
	} 
	
	/*
	*Paypal Package order
	*/
	public function action_pay(){
	  
		//if not post redirect to home page
	if(isset($_POST["pay_order"]) && $this->userlogin ){
			
			$package_id = Arr::get($_POST,'package_id');
			$packagedetails = $this->paypal_db->getpackagedetails($package_id);
			
			if(count($packagedetails) < 1){
				$this->request->redirect('/');
			}                
			$amount = number_format($packagedetails[0]['price'], 2, '.', '');
			$currency_code = $this->paypal_currencycode;  
			$product_name=$packagedetails[0]['name'];
			$produc_title_replacevariable = array("##PACKAGE_TITLE##"=>Html::chars($packagedetails[0]['name']),"##AMOUNT##"=>$amount);
			$product_title = commonfunction::get_replaced_content(PAYMENT_PACKAGE_TITLE,$produc_title_replacevariable);
			$sellerid = $packagedetails[0]['package_id'];
		}else{
			//show msg as do not call direct payment url
			//redirect to home here
			Message::error($this->session->get('paypal_error'));
         $this->request->redirect('/');
		}
		//set production =0 for sandbox testing 1=>live paypal
		$production = 0;
		
		$notifyurl =  URL_BASE."paypal/notify";
		
		 $this->payment_success_url = URL_BASE.'paypal/cmspage/page/payment-success';
		echo "<br>";
		 $returnurl = URL_BASE.'paypal/checkout';
		echo "<br>";
		 $cancelurl = URL_BASE.'paypal/cancelled';
		echo "<br>";
		
		
		
		$email = $this->email;
		$payment_gateway = "ExpressCheckout";                
		if($payment_gateway == "Paypal"){
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
		}else{
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
			
			
			if (Arr::get($payment, 'ACK') === 'Success'){ 
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
			}else{
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
                if (Arr::get($customer, 'ACK') === 'Success'){
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
			
			$type = isset($this->post['type'])?$this->post['type']:"";
			switch($type)
			{
				case "package"; 
					$this->processpackageorder($customer,$paymentresponse,$token);
					break;
				case "reserveauction": 
					$this->processreserveauctionorder($customer,$paymentresponse,$token);
					break;
				case "beginner": 
					$this->process_all_auctionorder($customer,$paymentresponse,$token);
					break;
				case "pennyauction": 
					$this->process_all_auctionorder($customer,$paymentresponse,$token);
					break;
				case "peakauction": 
					$this->process_all_auctionorder($customer,$paymentresponse,$token);
					break;
				case "lowestunique": 
					$this->process_all_auctionorder($customer,$paymentresponse,$token);
					break; 	
				case "clockauction": 
					$this->processclockauctionorder($customer,$paymentresponse,$token);
					break;			
				default:
					break;
			}
			
                       
                }else{
                        //redirect to api error page
                        Message::error($this->session->get('paypal_error'));
                        $this->request->redirect("/");
                }			
                        //redirect to api error page
                        Message::error($this->session->get('paypal_error'));
                        $this->request->redirect("/");
                }
	}
	
	protected function processpackageorder($customer,$paymentresponse, $token)
	{
		
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
                $buyer_replace_variables = array(
                '##BUYERNAME##'=>$buyer_name,
                '##PACKAGE_NAME##'=>$this->session->get('paypal_producttitle_' .$token),
                '##AMOUNT##'=>Arr::get($paymentresponse, 'AMT'),
                '##ORDER_NO##'=>$this->session->get('paypal_invoiceno_' .$token)
                ); 
                $buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PACKAGE_DESC,$buyer_replace_variables);
                $transactionlog_details_buyer = array(
                'userid' =>  $this->session->get('auction_userid'),
                'order_no' => $this->session->get('paypal_invoiceno_' .$token),
                'packageid' => Arr::get($customer, 'L_NUMBER0'),
                'amount' => Arr::get($paymentresponse, 'AMT'),
                'amount_type' => DEBIT,
		'transaction_type' => 'paypal',//login user a/c 
                'description' => $buyer_desc,
                );
                $this->paypal_db->addtransactionlog_details($transactionlog_details_buyer);
		//its good idea to destroy assign after data insert
		$this->session->delete('paypal_paypal_token_'.$token);
		$this->session->delete('paypal_sellerid_'.$token);
		$this->session->delete('paypal_invoiceno_' .$token);
		$this->session->delete('paypal_producttitle_' .$token);  
		$this->session->delete('paypalpost');
		
		//redirect to thankyou page   
		$user_current_amount=$this->paypal_db->get_user_account($this->session->get('auction_userid'));
		$return_amount=Arr::get($paymentresponse, 'AMT');
		$total_amount=$user_current_amount+$return_amount;
		$credit_account_touser=$this->paypal_db->update_useraccount($this->session->get('auction_userid'),$total_amount);
		Message::success('Payment success');
		$this->request->redirect('paypal/cmspage/page/payment-success');
	}
	
	protected function processreserveauctionorder($customer,$paymentresponse, $token)
	{
		
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
                $buyer_replace_variables = array(
                '##BUYERNAME##'=>$buyer_name,
                '##PACKAGE_NAME##'=>$this->session->get('paypal_producttitle_' .$token),
                '##AMOUNT##'=>Arr::get($paymentresponse, 'AMT'),
                '##ORDER_NO##'=>$this->session->get('paypal_invoiceno_' .$token)
                ); 
                $buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PACKAGE_DESC,$buyer_replace_variables); 
		 
		
                $transactionlog_details_buyer = array(
                'userid' =>  $this->session->get('auction_userid'),
                'order_no' => $this->session->get('paypal_invoiceno_' .$token),
                'packageid' => Arr::get($customer, 'L_NUMBER0'),
                'amount' => Arr::get($paymentresponse, 'AMT'),
                'amount_type' => DEBIT,
		'transaction_type' => 'paypal',//login user a/c 
                'description' => __('transaction_description',array(':param1' => $this->paypal_db->getProductName(Arr::get($customer, 'L_NUMBER0')),'param2' => 'Reserve','param3' => Arr::get($paymentresponse, 'CURRENCYCODE').Arr::get($paymentresponse, 'AMT'))),
                );
                $this->paypal_db->addtransactionlog_details($transactionlog_details_buyer);
		
		
		//redirect to thankyou page   
		$packorder = array('res_order' => $this->session->get('paypal_invoiceno_' .$token),
						'payment_type' => $this->code,
						'auction_id'=> Arr::get($customer, 'L_NUMBER0'),
						'buyer_id' => $this->session->get('auction_userid'), 
						'order_status' => 'C',
						'bidmethod' => 'reserve',
						'total' => Arr::get($paymentresponse, 'AMT'),
						'currency_code' => Arr::get($paymentresponse, 'CURRENCYCODE')); 
		$insertpackgageorder = $this->paypal_db->auctionOrderDetails($packorder);
		$orderresponse = array('order_id' => $this->session->get('paypal_invoiceno_' .$token),'user_id' => $this->session->get('auction_userid'),'currency'=>Arr::get($paymentresponse, 'CURRENCYCODE'),'product_id' => Arr::get($customer, 'L_NUMBER0'),'price' =>Arr::get($paymentresponse, 'AMT') );
		Commonfunction::AuctionOrdermail($orderresponse);
		//its good idea to destroy assign after data insert
		$this->session->delete('paypal_paypal_token_'.$token);
		$this->session->delete('paypal_sellerid_'.$token);
		$this->session->delete('paypal_invoiceno_' .$token);
		$this->session->delete('paypal_producttitle_' .$token);  
		$this->session->delete('paypalpost');
		Message::success(__('payment_success'));
		$this->request->redirect('paypal/cmspage/page/payment-success');
	}
	
	
	protected function processclockauctionorder($customer,$paymentresponse, $token)
	{
		
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
                $buyer_replace_variables = array(
                '##BUYERNAME##'=>$buyer_name,
                '##PACKAGE_NAME##'=>$this->session->get('paypal_producttitle_' .$token),
                '##AMOUNT##'=>Arr::get($paymentresponse, 'AMT'),
                '##ORDER_NO##'=>$this->session->get('paypal_invoiceno_' .$token)
                ); 
                $buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PACKAGE_DESC,$buyer_replace_variables); 
		 
		
                $transactionlog_details_buyer = array(
                'userid' =>  $this->session->get('auction_userid'),
                'order_no' => $this->session->get('paypal_invoiceno_' .$token),
                'packageid' => Arr::get($customer, 'L_NUMBER0'),
                'amount' => Arr::get($paymentresponse, 'AMT'),
                'amount_type' => DEBIT,
		'transaction_type' => 'paypal',//login user a/c 
                'description' => __('transaction_description',array(':param1' => $this->paypal_db->getProductName(Arr::get($customer, 'L_NUMBER0')),'param2' => 'Clock','param3' => Arr::get($paymentresponse, 'CURRENCYCODE').Arr::get($paymentresponse, 'AMT'))),
                );
                $this->paypal_db->addtransactionlog_details($transactionlog_details_buyer);
		
		
		//redirect to thankyou page   
		$packorder = array('res_order' => $this->session->get('paypal_invoiceno_' .$token),
						'payment_type' => $this->code,
						'auction_id'=> Arr::get($customer, 'L_NUMBER0'),
						'buyer_id' => $this->session->get('auction_userid'), 
						'order_status' => 'C',
						'bidmethod' => 'clock',
						'total' => Arr::get($paymentresponse, 'AMT'),
						'currency_code' => Arr::get($paymentresponse, 'CURRENCYCODE')); 
		$insertpackgageorder = $this->paypal_db->auctionOrderDetails($packorder);
		$orderresponse = array('order_id' => $this->session->get('paypal_invoiceno_' .$token),'user_id' => $this->session->get('auction_userid'),'currency'=>Arr::get($paymentresponse, 'CURRENCYCODE'),'product_id' => Arr::get($customer, 'L_NUMBER0'),'price' =>Arr::get($paymentresponse, 'AMT') );
		
		Clock::auction_order_status(Arr::get($customer, 'L_NUMBER0'));
		Commonfunction::AuctionOrdermail($orderresponse);
		//its good idea to destroy assign after data insert
		$this->session->delete('paypal_paypal_token_'.$token);
		$this->session->delete('paypal_sellerid_'.$token);
		$this->session->delete('paypal_invoiceno_' .$token);
		$this->session->delete('paypal_producttitle_' .$token);  
		$this->session->delete('paypalpost');
		Message::success(__('payment_success'));
		$this->request->redirect('paypal/cmspage/page/payment-success');
	}
	
	protected function process_all_auctionorder($customer,$paymentresponse, $token)
	{
			$type=$this->post;			
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
                $buyer_replace_variables = array(
                '##BUYERNAME##'=>$buyer_name,
                '##PACKAGE_NAME##'=>$this->session->get('paypal_producttitle_' .$token),
                '##AMOUNT##'=>Arr::get($paymentresponse, 'AMT'),
                '##ORDER_NO##'=>$this->session->get('paypal_invoiceno_' .$token)
                ); 
                $buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PACKAGE_DESC,$buyer_replace_variables); 
		 
		
                $transactionlog_details_buyer = array(
                'userid' =>  $this->session->get('auction_userid'),
                'order_no' => $this->session->get('paypal_invoiceno_' .$token),
                'packageid' => Arr::get($customer, 'L_NUMBER0'),
                'amount' => Arr::get($paymentresponse, 'AMT'),
                'amount_type' => DEBIT,
		'transaction_type' => 'paypal',//login user a/c 
                'description' => __('transaction_description',array(':param1' => $this->paypal_db->getProductName(Arr::get($customer, 'L_NUMBER0')),'param2' => $type['type'],'param3' => Arr::get($paymentresponse, 'CURRENCYCODE').Arr::get($paymentresponse, 'AMT'))),
                );
                $this->paypal_db->addtransactionlog_details($transactionlog_details_buyer);
		
		
		//redirect to thankyou page   
		$packorder = array('res_order' => $this->session->get('paypal_invoiceno_' .$token),
						'payment_type' => $this->code,
						'auction_id'=> Arr::get($customer, 'L_NUMBER0'),
						'buyer_id' => $this->session->get('auction_userid'), 
						'order_status' => 'C',
						'bidmethod' => $type['type'],
						'total' => Arr::get($paymentresponse, 'AMT'),
						'currency_code' => Arr::get($paymentresponse, 'CURRENCYCODE')); 
		$insertpackgageorder = $this->paypal_db->auctionOrderDetails($packorder);
		$orderresponse = array('order_id' => $this->session->get('paypal_invoiceno_' .$token),'user_id' => $this->session->get('auction_userid'),'currency'=>Arr::get($paymentresponse, 'CURRENCYCODE'),'product_id' => Arr::get($customer, 'L_NUMBER0'),'price' =>Arr::get($paymentresponse, 'AMT') );
		Commonfunction::AuctionOrdermail($orderresponse);
		//its good idea to destroy assign after data insert
		$this->session->delete('paypal_paypal_token_'.$token);
		$this->session->delete('paypal_sellerid_'.$token);
		$this->session->delete('paypal_invoiceno_' .$token);
		$this->session->delete('paypal_producttitle_' .$token);  
		$this->session->delete('paypalpost');
		Message::success(__('payment_success'));
		$this->request->redirect('paypal/cmspage/page/payment-success');
	}
	
	public function action_cancelled()
        { 
		//set cancel message
		$this->request->redirect('/');
		//create cancel page and call 
	}
	
	
	
	//Paypal buynow
	public function action_buynow_auction()
	{
		
		/**Check Whether the user is logged in**/
		$this->is_login(); 
                $userid = $this->session->get('auction_userid');

                //direct access restrict  
		$product_id=$this->request->param('id');   
         
                //$product_id = Arr::get($_GET,'id');
                if(!isset($product_id)){                                 
                     $this->request->redirect('/');   
                }

		/**To get product amount for the received product id**/
		//$product_amount= $this->buynow->get_received_buyamount($product_id);
		 $product_amount= $this->buynow->all_addtocart_list($userid);
                //view
                $view=View::factory('buynow/'.THEME_FOLDER.'buy_product')
				->bind('product_amount',$product_amount)
                		->bind('product_id',$product_id);

                $this->template->content=$view; 
                $this->template->title="Buy Product";
		$this->template->meta_description="Buy Product";
		$this->template->meta_keywords="Auctions Buy Product"; 
	}
	
	public function action_payment_order_success()
	{
		$this->is_login(); 
		$view=View::factory('buynow/'.THEME_FOLDER.'buynow_order_success_temp');
                $this->template->content=$view; 
                $this->template->title="Buy Product- Payment Success";
		$this->template->meta_description="Payment success";
		$this->template->meta_keywords="Auctions Buy Now Products - payment success"; 
	}

	//Offline auction buy now
	public function action_buynow_offline()
	{
		
			/**Check Whether the user is logged in**/
			$this->is_login(); 
			$userid = $this->session->get('auction_userid');
			//direct access restrict  
			$product_id=$this->request->param('id');  
			
			if(!isset($product_id)){                                 
			$this->request->redirect('/');                             
                	}
			
		$product_amount= $this->buynow->all_addtocart_list($userid);		
                //view
                $view=View::factory('buynow/'.THEME_FOLDER.'buy_product_offline')
				->bind('product_amount',$product_amount)
                		->bind('product_id',$product_id);
                $this->template->content=$view; 
                $this->template->title="Buy Product";
		$this->template->meta_description="Buy Product";
		$this->template->meta_keywords="Auctions Buy Product"; 
	}

	//Offline auction buy now
	public function action_buynow_addcart()
	{
		/**Check Whether the user is logged in**/
		$this->is_login(); 
                $userid = $this->session->get('auction_userid');
                //direct access restrict  
		$product_id=$this->request->param('id');               
                if(!isset($product_id)){                                 
                     $this->request->redirect('/');   
                }
			
		/**To get product amount for the received product id**/
		$product_amount= $this->buynow->get_received_buyamount($product_id);				
                //view
                $view=View::factory('buynow/'.THEME_FOLDER.'buy_product_addcart')
				->bind('product_amount',$product_amount)
                		->bind('product_id',$product_id);
                $this->template->content=$view; 
                $this->template->title="Buy Product";
		$this->template->meta_description="Buy Product";
		$this->template->meta_keywords="Auctions Buy Product"; 
	}


	//Buy Now auction
	public function action_products_transactions()
	{
		$this->is_login();
		$view=View::factory('buynow/'.THEME_FOLDER.'buy_products_transaction')
				->bind('transactions',$transactions)
				->bind('count_transaction',$count_transactions)
				->bind('pagination',$pagination);
		$count_transactions=$this->buynow->select_buynow_transactions_history(NULL,REC_PER_PAGE,$this->auction_userid,TRUE);
		//pagination loads here
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_transactions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => 'pagination/punbb_userside',  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
		$transactions=$this->buynow->select_buynow_transactions_history($offset,REC_PER_PAGE,$this->auction_userid);
		$this->template->content = $view;
	        $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}


	//Buy Now auction
	public function action_addtocart_list()
	{ 
		$this->is_login();
		if(isset($_POST['update'])){
			$count=count($_POST['quantity']);
			if($count!=0){

				for($k=0;$k<$count;$k++){
					$quantity=$_POST['quantity'][$k];
					$amount=$quantity*$_POST['amount'][$k];
					$id=$_POST['id'][$k];
					$result=$this->buynow->updatecart($id,$quantity,$amount);
				}
			Message::success(__('Update_cart_successfully'));
			}
		}
		$view=View::factory('buynow/'.THEME_FOLDER.'addtocartlist')
				->bind('transactions',$transactions)
				->bind('count_transaction',$count_transactions)
				->bind('useramount',$amt)
				->bind('totalamount',$totalamount)
				->bind('pagination',$pagination);
		$userid=$this->auction_userid;		
		$amt=Commonfunction::get_user_balance($userid);
		$count_transactions=$this->buynow->addtocart_list(NULL,REC_PER_PAGE,$this->auction_userid,TRUE);
		//pagination loads here
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_transactions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => 'pagination/punbb_userside',  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
		$transactions=$this->buynow->addtocart_list($offset,REC_PER_PAGE,$this->auction_userid);
		
		$this->template->content = $view;
	        $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	public function action_myaddresses()
	{
		$this->is_login();
		$request=$this->request->param('id');
		$request2=$this->request->param('method');
		$userid=!$this->auction_userid;	
		$transactions=$this->buynow->all_addtocart_list($this->auction_userid);
		$db_values=$this->commonmodel->select_with_onecondition(BILLING_ADDRESS,"userid=".$this->auction_userid)->as_array();
		$db_values_shipping=$this->commonmodel->select_with_onecondition(SHIPPING_ADDRESS,"userid=".$this->auction_userid)->as_array();
		$amt=Commonfunction::get_user_balance($this->auction_userid);
		$view=View::factory('buynow/'.THEME_FOLDER.'addresses')
								->bind('select_shipping_address',$select_shipping_address)
								->bind('count_shipping',$count_shipping)
								->bind('select_billing_address',$select_billing_address)
								->bind('transactions',$transactions)
								->bind('useramount',$amt)
								->bind('errors',$error)
								->bind('db_values',$db_values)
								->bind('db_values_shipping',$db_values_shipping)
								->bind('form_values',$form_values)
								->bind('count_billing',$count_billing);	
				
						$userid=$this->auction_userid;
						$select_shipping_address=$this->buynow->select_shipping_address($userid);
						$count_shipping=$this->buynow->select_shipping_address($userid,TRUE);	
						$select_billing_address=$this->buynow->select_billing_address($userid);
						$count_billing=$this->buynow->select_billing_address($userid,TRUE);
		$this->template->content = $view;
                $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;	
	}
	
	//Remove add to cart
	public function action_buynow_remove()
	{
		/**Check Whether the user is logged in**/
		$this->is_login(); 
		$userid = $this->session->get('auction_userid');
		//direct access restrict  
		$id=$this->request->param('id');                 
		/**To get product amount for the received product id**/
		$product_remove= $this->buynow->remove_addtocart($userid,$id); 
		Message::success(__('addtocart_product_delete_flash'));
		$this->request->redirect("site/buynow/addtocart_list");              
	}

	
		
	/**
	* ****show_payment_log()****
	* show payment log
	*/	
	public function action_show_payment_log()
	{
                //page title
                $this->selected_page_title = __('page_payment_log');
                $this->page_title = __('page_payment_log'); 
                $this->selected_controller_title =__('page_title_transaction');
                //get current page segment id 
                $page_id = $this->request->param('id');               
                //send data to view file 
                $page_data = $this->buynow->show_payment_log_content($page_id);		
                //splitting created_date to display proper format
		                foreach($page_data as $payment_log)
		                {
			                $page_data['TIMESTAMP'] = $this->DisplayDateTimeFormat($payment_log["TIMESTAMP"]);
			                $page_data['created_date'] = $this->DisplayDateTimeFormat($payment_log["created_date"]);
			                $page_data['ID'] = $payment_log["ID"];
			                $page_data['REASONCODE'] = $payment_log["REASONCODE"];
			                $page_data['PAYERSTATUS'] = $payment_log["PAYERSTATUS"];
			                $page_data['PAYMENTSTATUS'] = $payment_log["PAYMENTSTATUS"];
			                $page_data['FEEAMT'] = $payment_log["FEEAMT"];
			                $page_data['AMT'] = $payment_log["AMT"];
			                $page_data['EMAIL'] = $payment_log["EMAIL"];
			                $page_data['TRANSACTIONID']	= 	$payment_log["TRANSACTIONID"];	
			                $page_data['LOGIN_ID']	= 	$payment_log["LOGIN_ID"];	
			                $page_data['PAYERID']	= 	$payment_log["PAYERID"];	
			                $page_data['username']	= 	$payment_log["username"];	
			                $page_data['COUNTRYCODE'] = $payment_log["COUNTRYCODE"];
			                $page_data['RECEIVER_EMAIL']	= $payment_log["RECEIVER_EMAIL"];	
			                $page_data['CORRELATIONID']	= $payment_log["CORRELATIONID"];	
			                $page_data['ACK']	= 	$payment_log["ACK"];	
			                $page_data['REASONCODE']	= 	$payment_log["REASONCODE"];
			                $page_data['TRANSACTIONTYPE'] = $payment_log["TRANSACTIONTYPE"];
			                $page_data['RECEIPTID']	= 	$payment_log["RECEIPTID"];	
			                $page_data['ORDERTIME']	= 	$this->DisplayDateTimeFormat($payment_log["ORDERTIME"]);	
			                $page_data['CURRENCYCODE']	= $payment_log["CURRENCYCODE"];		
			                $page_data['PENDINGREASON'] = $payment_log["PENDINGREASON"];												
			                $page_data['INVOICEID']	= $payment_log["INVOICEID"];	
			                $page_data['PAYMENTTYPE']	= $payment_log["PAYMENTTYPE"];
	                }    	
                        $view = View::factory('buynow/'.THEME_FOLDER.'show_normal_payment_transaction')
                                ->bind('action',$action)
                                ->bind('page_data',$page_data);
				$this->template->content = $view;
				$this->template->title=$this->title;
				$this->template->meta_description=$this->metadescription;
				$this->template->meta_keywords=$this->metakeywords;
	}

	 /**
        * ****DisplayDateTimeFormat()****
        *
        * @param $input_date_time string
        * @param 
        * @return  time format
        */
        public function DisplayDateTimeFormat($input_date_time)
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
	
}//End of users controller class
?>
