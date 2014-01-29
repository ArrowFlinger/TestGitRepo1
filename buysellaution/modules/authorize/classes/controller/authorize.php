<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains package controller actions
 *
 * @Package: Nauction Platinum Version 1.0
 * @Created on Dec 17, 2012
 * @Updated on Dec 17, 2012
 * @author     Ndot Team
 * @copyright  (c) 2008-2011 Ndot Team
 * @license    http://ndot.in/license 
 */

class Controller_Authorize extends Controller_Website {	 
	 
	protected $post = array();
	protected $code = "authorize";
		 
	public function __construct(Request $request, Response $response)
	{
		$this->_authorize = new Authorize;
		parent::__construct($request,$response);
		$this->email= $this->session->get('auction_email'); 
		$this->authorize=Model::factory('authorize');
		
		//Override the template variable decalred in website controller
		$this->template="themes/template";
		/**To get selected theme template**/
		if(file_exists(VIEW_PATH.'template.php'))
		{
			$this->template=SELECTED_THEME_FOLDER.'template';
		}  
		 
		if(isset($_POST['form']) && count($_POST)>0)
		{
			$this->session->set('authorizepost',$_POST['form']);
			$this->post = $_POST['form'];
		}
		else
		{
			$this->post = $this->session->get('authorizepost');
		} 
	}
	
        /**** Added By venkatraja 15-Mar-2013 ****/
	public function action_transactionlogs(){
		
		$invoicenumber=isset($_REQUEST['invoicenumber'])?$_REQUEST['invoicenumber']:'';
		
		$transactiondetails=$this->authorize->gettransactionlogdetails($invoicenumber);
		
		
		$view = View::factory('admin/transactionlog')
                                ->bind('transactiondetails',$transactiondetails);
		$this->template= $view;
		
		
		}	
	
	/*** Added End By Venkatraja ***/
	
	/*  Authorize Payment Gateway Process & Form validation -Dec18,2012 */
	public function action_authorize_payment(){
		
		$this->is_login();
		$post = $this->post;
		if(!isset($post))
		{
			$this->request->redirect('packages/');   
		}
                $userid = $this->session->get('auction_userid');
		$validator=array();
		$error=array();
		$buynowauthorizesubmit=arr::get($_REQUEST,'pay_order');
		$authorizepaysubmit=arr::get($_REQUEST,'authorize_pay_submit');
		
		if(isset($post) && count($post)>0)
		{
			if(!$buynowauthorizesubmit && !$authorizepaysubmit)
			{
				 
				$package_id=isset($post['id'])?$post['id'][0]:""; 
				$pack_price=isset($post['unitprice'])?$post['unitprice'][0]:"";
				$pack_name=isset($post['name'])?$post['name'][0]:"";
			}
			else if($buynowauthorizesubmit)
			{
				$pack_price=arr::get($_REQUEST,'amount');
				$package_id=arr::get($_REQUEST,'product_id');
				$pack_name='';
			}
			else if($authorizepaysubmit)
			{
				$pack_price=arr::get($_REQUEST,'amount');
				$package_id=arr::get($_REQUEST,'pack_id');
				$pack_name=''; 
				$this->post = $this->session->set('authorizepost',array_merge($this->post,$_POST));
				$auth_values=Arr::extract($_POST,array('creditCardNumber','cvv2Number'));
				
				$validator=$this->authorize->authorize_validation($auth_values);
				if($validator->check()){
					 
					$this->request->redirect('authorize/process');        
				}else{
					$error=$validator->errors('errors');
				}
			}
		}
		 
		  
		$paymentgateway_details=$this->authorize->getpaymentgatewayDetails('authorize');
		$currency_code=$paymentgateway_details['currency_code'];
		
		if(!isset($package_id) || !isset($currency_code)){
			Message::error(__('Direct_Access_Dined'));
			$this->request->redirect('/');   
		}
		
		$username= $this->session->get('auction_username');
		$email= $this->session->get('auction_email');
		$view=View::factory('authorize/'.THEME_FOLDER.'authorize_payment')
							->bind('pack_name',$pack_name)
							->bind('amount',$pack_price)
							->bind('user',$username)
							->bind('currency',$currency_code)
							->bind('email',$email)
							->bind('package_id',$package_id)     // Paymentgatewayid here
							->bind('validator',$validator)
							->bind('error',$error);
		$this->template->content=$view;
		$this->template->title=__('authorize_title');
		$this->template->meta_description=__('authorize_desc');
		$this->template->meta_keywords=__('authorize_key');
	}
	
	public function action_process()
	{
		$this->auto_render =false;   
		$type = isset($this->post['type'])?$this->post['type']:"";
		 
		$finalpost = array_merge($this->post,$_POST);
		switch($type)
		{
			case "package";
				$this->processpackageorder($finalpost);
				break;
			case "product":
				$this->processproductorder($finalpost);
				break;
			case "wonauction":
				$this->processwonorder($finalpost);
				break; 
			case "reserveauction":
				$this->processreserveauctionorder($finalpost);
				break; 
			case "clockauction":
				$this->processclockauctionorder($finalpost);
				break; 
			default:
				break;
		}
		
	}
	
	/*** added by venkatraja 8-Mar-2013 ***/
	
	
	
	public function processproductorder($post)
	{		
		$this->is_login(); 
                $userid = $this->session->get('auction_userid');
		require_once MODPATH.'authorize/authorize-sdk/AuthorizeNet.php'; 
		$sale = new AuthorizeNetAIM;
		$url='authorize_data';
		$auth_data=$this->session->get('authorizepost');
		
		//
		if(!$auth_data){
			Message::error(__('direct_access'));
			$this->request->redirect('/');   
		}
		
		$paymentgateway_details= $this->authorize->getpaymentgatewayDetails('authorize');  // Here Payment Gateway Id 2 is Authorize Payment Gateway
		if($paymentgateway_details['payment_method']=='T'){
			DEFINE("AUTHORIZENET_SANDBOX", true);
		}else{
			DEFINE("AUTHORIZENET_SANDBOX", false);
		}
		 
		DEFINE("CURRENCY",$paymentgateway_details['currency_code']);
		DEFINE("AUTHORIZENET_API_LOGIN_ID", $paymentgateway_details['paypal_api_username']);
		DEFINE("AUTHORIZENET_TRANSACTION_KEY", $paymentgateway_details['paypal_api_password']);
		
		
		
		$i=0;
		$amount=0;
		$shippingfee=isset($auth_data['shipping_cost'])?(($auth_data['shipping_cost']!='')?$auth_data['shipping_cost']:0):0;

		foreach($auth_data['id'] as $id){
		$amount=$amount+($auth_data['unitprice'][$i]*$auth_data['quantity'][$i])+$shippingfee;
		$product_id[]=$auth_data['id'][$i];
		$i++;
		}
		
		$md5_setting=AUTHORIZENET_API_LOGIN_ID;
		$sale = new AuthorizeNetAIM;		
		$sale->amount = $amount;
		$sale->card_num =$auth_data['creditCardNumber'];
		$sale->card_code = $auth_data['cvv2Number'];
		$sale->exp_date = $auth_data['expDateMonth'].'/'.$auth_data['expDateYear']; 
		$sale->email = $auth_data['mail'];
		$sale->invoice_num = substr(time(), 0, 6); 
		$response = $sale->authorizeOnly();
		$responseheader = array('response_code'=>$response->response_code,
					'response'=>$response->response_reason_text,
					'Invoice No'=>$response->invoice_number,
					'Authorization Code'=>$response->authorization_code,
					'Credit card'=>$response->card_type); 
		 
		if($responseheader['response_code']>1)
		{
			Message::error($responseheader['response']);
			$this->request->redirect('/');  
		}
		 
		if($responseheader['response_code']==1)
		{
			Message::success(__('payment_success'));
			
			//Entry to Transaction Details Table
			
			
			$i=0;
			$amount=0;
			$sfee=0;
			$auctionproductdetails=array();
				foreach($auth_data['id'] as $id){
					
				$getproductdetails=$this->authorize->getproductdetails($id);
				$shippingfee=$getproductdetails[0]['shipping_fee'];	
					
					
				$shippingfee=($shippingfee!='')?$shippingfee:0;	
					
						$transactionfield['PAYERID'] =$responseheader['Authorization Code'];
						$transactionfield['PAYERSTATUS'] = 'C';
						$transactionfield['PRODUCTID'] = $id;
						$transactionfield['USERID'] = $this->session->get('auction_userid');
						$transactionfields['TRANSACTIONID']=$responseheader['Authorization Code'];
						$transactionfields['TRANSACTIONTYPE']='Authorize';
						$transactionfields['PAYMENTTYPE']=$this->code;
						$transactionfield['AMT']= $auth_data['unitprice'][$i];
						$transactionfield['SHIPPINGAMT']=$shippingfee;
						$transactionfields['CURRENCYCODE']=$auth_data['currency'];
						$transactionfield['LOGIN_ID'] = Request::$client_ip;
						$transactionfield['USER_AGENT'] = Request::$user_agent;
						
						 $this->authorize->addbuynowtransaction_details($transactionfield);
				 
						$last_transaction_insert_id = $this->authorize->get_last_transaction_id();
						$max_date_complete_db_format = "";			
						$orderfields = array(
						'order_no' => $responseheader['Authorization Code'],                       
						'product_id' => $id,
						'buyer_id' => $this->session->get('auction_userid'),
					  
						'order_status' => SUCCESS_PAYMENT_ORDER_STATUS,
						'action' => SUCCESS_PAYMENT_ORDER_ACTION,
						'product_cost' => $auth_data['unitprice'][$i],
						'quantity' => $auth_data['quantity'][$i],
						'shippingfee' => $shippingfee,
						'product_commission_amount' => "",
						'order_total' => ($auth_data['unitprice'][$i]*$auth_data['quantity'][$i])+$shippingfee,
						'order_subtotal' => 0.00,
						'order_currency_code' => $auth_data['currency'],
						
						'paid_status' => PAID_PENDING, 
						'maximum_date_complete' => $max_date_complete_db_format,
						'transaction_details_id' => $last_transaction_insert_id  
						);
				 
						$this->authorize->addbuynoworder_details($orderfields);
			
			
						$quantity=$auth_data['quantity'][$i];
						$productcost=$auth_data['unitprice'][$i];
						$productid=$id;
						
						
						$totalamount=($productcost*$quantity)+$shippingfee;
			
			
						$total_amount=$this->site_currency." ".Commonfunction::numberformat($totalamount);
						$shipping_fee=$this->site_currency." ".Commonfunction::numberformat($shippingfee);
						$product_cost=$this->site_currency." ".Commonfunction::numberformat($productcost);
						$order_no=$responseheader['Authorization Code'];
				$buyer_name =$this->authorize->get_username($this->session->get('auction_userid'));
				
				$product_name=$auth_data['name'][$i];
				
			
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
			
		      // $transactionlog_details_buyer['site_currency'] =  $auth_data['currency'];
                        $transactionlog_details_buyer['userid'] =  $this->session->get('auction_userid');
                        $transactionlog_details_buyer['orderid'] = $responseheader['Authorization Code'];
                        $transactionlog_details_buyer['productid'] = $id;
                     
			$transactionlog_details_buyer['amount']= $auth_data['unitprice'][$i];
                        $transactionlog_details_buyer['amount_type'] = DEBIT;
			$transactionlog_details_buyer['quantity'] = $quantity;
			$transactionlog_details_buyer['payment_type'] ='Authorize';
			$transactionlog_details_buyer['shippingamount'] =$shippingfee;
			$transactionlog_details_buyer['description']=$buyer_desc;
			
			
			$this->authorize->addbuynowtransactionlog_details($transactionlog_details_buyer);
			$this->authorize->order_delete($id,$this->session->get('auction_userid'));
			$fieldvalues['id']=$id;
			$fieldvalues['unitprice']=$auth_data['unitprice'][$i];
			$fieldvalues['quantity']=$quantity;			
			$sfee+=$shippingfee;
			$auctionproductdetails[]=$fieldvalues;
			$i++;
			
			}
					
				
			$orderresponse = array('order_id' => $responseheader['Authorization Code'],'shipping'=>$sfee,'user_id' => $userid,'currency'=>$auth_data['currency'],'product_unique_details' => $auctionproductdetails,'price' =>$amount );
			Buynow::BuynowOrdermail($orderresponse);  		
					
			$this->request->redirect('site/buynow/products_transactions');
			Message::success(__('authorize_payment_success'));			
					
		}
			
			
			  
	}

	
	
	
	public function processwonorder($post)
	{		
		$this->is_login(); 
                $userid = $this->session->get('auction_userid');
		require_once MODPATH.'authorize/authorize-sdk/AuthorizeNet.php'; 
		$sale = new AuthorizeNetAIM;
		$url='authorize_data';
		$auth_data=$this->session->get('authorizepost');
		
		//
		if(!$auth_data){
			Message::error(__('direct_access'));
			$this->request->redirect('/');   
		}
		
		$paymentgateway_details= $this->authorize->getpaymentgatewayDetails('authorize');  // Here Payment Gateway Id 2 is Authorize Payment Gateway
		if($paymentgateway_details['payment_method']=='T'){
			DEFINE("AUTHORIZENET_SANDBOX", true);
		}else{
			DEFINE("AUTHORIZENET_SANDBOX", false);
		}
		 
		DEFINE("CURRENCY",$paymentgateway_details['currency_code']);
		DEFINE("AUTHORIZENET_API_LOGIN_ID", $paymentgateway_details['paypal_api_username']);
		DEFINE("AUTHORIZENET_TRANSACTION_KEY", $paymentgateway_details['paypal_api_password']);
		$shippingfee=isset($auth_data['shipping_cost'])?(($auth_data['shipping_cost']!='')?$auth_data['shipping_cost']:0):0;
		$amount=($auth_data['unitprice'][0]*$auth_data['quantity'][0])+$shippingfee;
		$product_id=$auth_data['id'][0];
		$md5_setting=AUTHORIZENET_API_LOGIN_ID;
		$sale = new AuthorizeNetAIM;		
		$sale->amount = $amount;
		$sale->card_num =$auth_data['creditCardNumber'];
	//$sale->card_num ='4111';
		$sale->card_code = $auth_data['cvv2Number'];
		$sale->exp_date = $auth_data['expDateMonth'].'/'.$auth_data['expDateYear']; 
		$sale->email = $auth_data['mail'];
		$sale->invoice_num = substr(time(), 0, 6); 
		$response = $sale->authorizeOnly();
		$responseheader = array('response_code'=>$response->response_code,
					'response'=>$response->response_reason_text,
					'Invoice No'=>$response->invoice_number,
					'Authorization Code'=>$response->authorization_code,
					'Credit card'=>$response->card_type); 
		
		if($responseheader['response_code']>1)
		{
			Message::error($responseheader['response']);
			$this->request->redirect('/');  
		}
		 
		if($responseheader['response_code']==1)
		{
			
			//print_r($responseheader);exit;
			
			Message::success(__('payment_success'));
			
			//Entry to Transaction Details Table
			
			$shippingfee=isset($auth_data['shipping_cost'])?(($auth_data['shipping_cost']!='')?$auth_data['shipping_cost']:0):0;
			
			
			
			$buyer_name =$this->authorize->get_username($this->session->get('auction_userid'));
		      
		$quantity=$auth_data['quantity'][0];
		$productcost=$auth_data['unitprice'][0];
		$productid=$product_id;
		
		$totalamount=($productcost*$quantity)+$shippingfee;
				
			$product_name=Commonfunction::get_name('PR',$product_id);
			$total_amount=$this->site_currency." ".Commonfunction::numberformat($totalamount);
			$shipping_fee=$this->site_currency." ".Commonfunction::numberformat($shippingfee);
			$product_cost=$this->site_currency." ".Commonfunction::numberformat($productcost);
			$order_no=$responseheader['Authorization Code'];
			
			
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
			
			$trans_details=array('userid'=>$userid,
						'orderid'=>$responseheader['Authorization Code'],
						'packageid'=>$product_id,
						'transaction_type'=>"Authorize",
						'type'=>'PR',
						'description'=>$buyer_desc,
						'amount'=>$auth_data['unitprice'][0],
						'shippingamount'=>$shippingfee,
						'amount_type'=>'C');
			
			$addTransactionDetails=$this->authorize->authTransactionDetails($trans_details);
			
			//Entry to Paypal Transaction Details Table
			$paypal_trans_details=array('PAYERID'=>$responseheader['Authorization Code'],
							'PAYERSTATUS'=>'Verified',
							'FIRSTNAME'=>$auth_data['user'],
							'EMAIL'=>$auth_data['mail'],
							'RECEIVER_EMAIL'=>'ndotauction@gmail.com',
							'PACKAGEID'=>$product_id,
							'ACK'=>'Success',
							'INVOICEID'=>$responseheader['Authorization Code'],
							'RECEIPTID'=>'Verified',
							'CURRENCYCODE'=>$auth_data['currency'],
							'AMT'=>$auth_data['unitprice'][0],
							'SHIPPINGAMT'=>$shippingfee,
							'LOGIN_ID' => Request::$client_ip,
							'USER_AGENT' => Request::$user_agent,
							'PAYMENTSTATUS'=>'Success',
							'PAYMENTTYPE'=>'authorize',
							'USERID'=>$userid);
			
			$addPaypalTransactionDetails=$this->authorize->authPaypalTransactionDetails($paypal_trans_details);
			
		
			
			
			
			$packorder = array('res_order' => $responseheader['Authorization Code'],
								'payment_type' => $this->code,
								
								'auction_id'=> $product_id,
								'buyer_id' => $userid, 
								'order_status' => 'S',
								'bidmethod' => Commonfunction::get_auction_bid_name($product_id),
								'total' => $auth_data['unitprice'][0],
								'shippingamount'=>$shippingfee,
								'currency_code' => $auth_data['currency']); 
			$insertpackgageorder = $this->authorize->auctionOrderDetails($packorder);
			
			$orderresponse = array('order_id' => $responseheader['Authorization Code'],'shipping'=>$shippingfee,'user_id' => $userid,'currency'=>$auth_data['currency'],'product_id' => $product_id,'price' =>$amount );
			Commonfunction::AuctionOrdermail($orderresponse);  
			
		}
		else
		{
			Message::error($responseheader['response']);
		} 
		$this->session->delete('authorizepost');
		$this->request->redirect('users/won_auctions');  
	}

	
	
	/**** Added end by venkatraja 8-Mar-2013 ****/
	
	
	
	
	
	
	public function processpackageorder($post)
	{		
		$this->is_login(); 
                $userid = $this->session->get('auction_userid');
		require_once MODPATH.'authorize/authorize-sdk/AuthorizeNet.php'; 
		$sale = new AuthorizeNetAIM;
		$url='authorize_data';
		$auth_data=$this->session->get('authorizepost');
		
		
		
		//
		if(!$auth_data){
			Message::error(__('direct_access'));
			$this->request->redirect('/packages/');   
		}
		
		$paymentgateway_details= $this->authorize->getpaymentgatewayDetails('authorize');  // Here Payment Gateway Id 2 is Authorize Payment Gateway
		if($paymentgateway_details['payment_method']=='T'){
			DEFINE("AUTHORIZENET_SANDBOX", true);
		}else{
			DEFINE("AUTHORIZENET_SANDBOX", false);
		}
		 
		DEFINE("CURRENCY",$paymentgateway_details['currency_code']);
		DEFINE("AUTHORIZENET_API_LOGIN_ID", $paymentgateway_details['paypal_api_username']);
		DEFINE("AUTHORIZENET_TRANSACTION_KEY", $paymentgateway_details['paypal_api_password']);
		 
		$amount=$auth_data['amount'];
		$package_id=$auth_data['pack_id'];
		$md5_setting=AUTHORIZENET_API_LOGIN_ID;
		$sale = new AuthorizeNetAIM;		
		$sale->amount = $amount;
		$sale->card_num =$auth_data['creditCardNumber'];
		$sale->card_code = $auth_data['cvv2Number'];
		$sale->exp_date = $auth_data['expDateMonth'].'/'.$auth_data['expDateYear']; 
		$sale->email = $auth_data['mail'];
		$sale->invoice_num = substr(time(), 0, 6); 
		$response = $sale->authorizeOnly();
		$responseheader = array('response_code'=>$response->response_code,
					'response'=>$response->response_reason_text,
					'Invoice No'=>$response->invoice_number,
					'Authorization Code'=>$response->authorization_code,
					'Credit card'=>$response->card_type); 
		 
		if($responseheader['response_code']>1)
		{
			Message::error($responseheader['response']);
			$this->request->redirect('packages/');  
		}
		 
		if($responseheader['response_code']==1)
		{
			Message::success(__('payment_success'));
			
			//Entry to Transaction Details Table
			$trans_details=array('userid'=>$userid,
					     'transaction_type'=>"Authorize",
						'orderid'=>$responseheader['Authorization Code'],
						'packageid'=>$package_id,
						'amount'=>$amount,
						'amount_type'=>'C');
			
			$addTransactionDetails=$this->authorize->authTransactionDetails($trans_details);
			
			//Entry to Paypal Transaction Details Table
			$paypal_trans_details=array('PAYERID'=>$responseheader['Authorization Code'],
							'PAYERSTATUS'=>'Verified',
							'FIRSTNAME'=>$auth_data['user'],
							'EMAIL'=>$auth_data['mail'],
							'RECEIVER_EMAIL'=>'ndotauction@gmail.com',
							'PACKAGEID'=>$package_id,
							'ACK'=>'Success',
							'INVOICEID'=>$responseheader['Authorization Code'],
							'RECEIPTID'=>'Verified',
							'CURRENCYCODE'=>$auth_data['currency'],
							'AMT'=>$amount,
							'LOGIN_ID' => Request::$client_ip,
							'USER_AGENT' => Request::$user_agent,
							'PAYMENTSTATUS'=>'S',
							'PAYMENTTYPE'=>'auhtorize',
							'USERID'=>$userid);
			
			$addPaypalTransactionDetails=$this->authorize->authPaypalTransactionDetails($paypal_trans_details);
			
			//Entry to Package orders Table
			$order_details=array('order_no'=>$responseheader['Authorization Code'],
						'payment_method'=>'authorize',
						'package_id'=>$package_id,
						'buyer_id'=>$userid,
						'order_currency_code'=>$auth_data['currency'],
						'package_amount'=>$amount,
						'paid_status'=>'PND');
			
			$addOrderDetails=$this->authorize->authOrderDetails($order_details);
			//Entry to TRANS_LOG_BUYER_PACKAGE_DESC 
			$buyer_replace_variables = array('##BUYERNAME##'=>$auth_data['user'],
							'##PACKAGE_NAME##'=>$auth_data['packname'],
							'##AMOUNT##'=>$amount,
							'##ORDER_NO##'=>$responseheader['Authorization Code']); 
			$buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PACKAGE_DESC,$buyer_replace_variables);
			$user_current_amount=$this->authorize->get_user_account($userid);
			$total_amount=$user_current_amount+$amount;
			$credit_account_touser=$this->authorize->update_useraccount($userid,$total_amount); 
                        
		}
		else
		{
			Message::error($responseheader['response']);
		} 
		$this->session->delete('authorizepost');
		$this->request->redirect('packages/');  
	}
	
	public function processreserveauctionorder($response)
	{
		 $this->is_login(); 
                $userid = $this->session->get('auction_userid');
		require_once MODPATH.'authorize/authorize-sdk/AuthorizeNet.php'; 
		$sale = new AuthorizeNetAIM;
		$url='authorize_data';
		$auth_data=$this->session->get('authorizepost');
		//
		if(!$auth_data){
			Message::error(__('direct_access'));
			$this->request->redirect('site/reserve/wonproducts');   
		}
		
		$paymentgateway_details= $this->authorize->getpaymentgatewayDetails('authorize');  // Here Payment Gateway Id 2 is Authorize Payment Gateway
		if($paymentgateway_details['payment_method']=='T'){
			DEFINE("AUTHORIZENET_SANDBOX", true);
		}else{
			DEFINE("AUTHORIZENET_SANDBOX", false);
		}
		 
		DEFINE("CURRENCY",$paymentgateway_details['currency_code']);
		DEFINE("AUTHORIZENET_API_LOGIN_ID", $paymentgateway_details['paypal_api_username']);
		DEFINE("AUTHORIZENET_TRANSACTION_KEY", $paymentgateway_details['paypal_api_password']);
		 
		$amount=$auth_data['amount'];
		$package_id=$auth_data['pack_id'];
		$md5_setting=AUTHORIZENET_API_LOGIN_ID;
		$sale = new AuthorizeNetAIM;		
		$sale->amount = $amount;
		$sale->card_num =$auth_data['creditCardNumber'];
		$sale->card_code = $auth_data['cvv2Number'];
		$sale->exp_date = $auth_data['expDateMonth'].'/'.$auth_data['expDateYear']; 
		$sale->email = $auth_data['mail'];
		$sale->invoice_num = substr(time(), 0, 6); 
		$response = $sale->authorizeOnly();
		 
		$responseheader = array('response_code'=>$response->response_code,
					'response'=>$response->response_reason_text,
					'Invoice No'=>$response->invoice_number,
					'Authorization Code'=>$response->authorization_code,
					'Credit card'=>$response->card_type); 
		 
		if($responseheader['response_code']>1)
		{
			Message::error($responseheader['response']);
			$this->request->redirect('site/reserve/wonproducts');  
		}
		
		if($responseheader['response_code']==1)
		{
			Message::success(__('payment_success'));
			
			//Entry to Transaction Details Table
			$trans_details=array('userid'=>$userid,
						'orderid'=>$responseheader['Authorization Code'],
						'transaction_type'=>"Authorize",
						'type'=>'PR',
						'packageid'=>$package_id,
						'amount'=>$amount,
						'description' =>__('transaction_description',array(':param1' => $this->authorize->getProductName($package_id),'param2' => 'Reserve','param3' => $auth_data["currency"].$amount)),
						'transaction_type' =>'Authorize',
						'amount_type'=>'C');
			
			$addTransactionDetails=$this->authorize->authTransactionDetails($trans_details); 
			
			//Entry to Package orders Table			 
			$packorder = array('res_order' => $responseheader['Authorization Code'],
								'payment_type' => $this->code,
								'auction_id'=> $package_id,
								'buyer_id' => $userid, 
								'order_status' => 'S',
								'bidmethod' => 'reserve',
								'total' => $amount,
								'currency_code' => $auth_data['currency']); 
			$insertpackgageorder = $this->authorize->auctionOrderDetails($packorder);
			$orderresponse = array('order_id' => $responseheader['Authorization Code'],'user_id' => $userid,'currency'=>$auth_data['currency'],'product_id' => $package_id,'price' =>$amount );
			Commonfunction::AuctionOrdermail($orderresponse);  
			 
                        
		}
		else
		{
			Message::error($responseheader['response']);
		} 
		$this->session->delete('authorizepost');
		$this->request->redirect('site/reserve/wonproducts');  
	}
	
	
	public function processclockauctionorder($response)
	{
		 $this->is_login(); 
                $userid = $this->session->get('auction_userid');
		require_once MODPATH.'authorize/authorize-sdk/AuthorizeNet.php'; 
		$sale = new AuthorizeNetAIM;
		$url='authorize_data';
		$auth_data=$this->session->get('authorizepost');
		//
		if(!$auth_data){
			Message::error(__('direct_access'));
			$this->request->redirect('site/clock/wonproducts');   
		}
		
		$paymentgateway_details= $this->authorize->getpaymentgatewayDetails('authorize');  // Here Payment Gateway Id 2 is Authorize Payment Gateway
		if($paymentgateway_details['payment_method']=='T'){
			DEFINE("AUTHORIZENET_SANDBOX", true);
		}else{
			DEFINE("AUTHORIZENET_SANDBOX", false);
		}
		 
		DEFINE("CURRENCY",$paymentgateway_details['currency_code']);
		DEFINE("AUTHORIZENET_API_LOGIN_ID", $paymentgateway_details['paypal_api_username']);
		DEFINE("AUTHORIZENET_TRANSACTION_KEY", $paymentgateway_details['paypal_api_password']);
		 
		$amount=$auth_data['amount'];
		$package_id=$auth_data['pack_id'];
		$md5_setting=AUTHORIZENET_API_LOGIN_ID;
		$sale = new AuthorizeNetAIM;		
		$sale->amount = $amount;
		$sale->card_num =$auth_data['creditCardNumber'];
		$sale->card_code = $auth_data['cvv2Number'];
		$sale->exp_date = $auth_data['expDateMonth'].'/'.$auth_data['expDateYear']; 
		$sale->email = $auth_data['mail'];
		$sale->invoice_num = substr(time(), 0, 6); 
		$response = $sale->authorizeOnly();
		 
		$responseheader = array('response_code'=>$response->response_code,
					'response'=>$response->response_reason_text,
					'Invoice No'=>$response->invoice_number,
					'Authorization Code'=>$response->authorization_code,
					'Credit card'=>$response->card_type); 
		 
		if($responseheader['response_code']>1)
		{
			Message::error($responseheader['response']);
			$this->request->redirect('users/won_auctions');  
		}
		
		if($responseheader['response_code']==1)
		{
			Message::success(__('payment_success'));
			
			//Entry to Transaction Details Table
			$trans_details=array('userid'=>$userid,
						'orderid'=>$responseheader['Authorization Code'],
						'transaction_type'=>"Authorize",
						'type'=>'PR',
						'packageid'=>$package_id,
						'amount'=>$amount,
						'description' =>__('transaction_description',array(':param1' => $this->authorize->getProductName($package_id),'param2' => 'Clock','param3' => $auth_data["currency"].$amount)),
						'transaction_type' =>'Authorize',
						'amount_type'=>'C');
			
			$addTransactionDetails=$this->authorize->authTransactionDetails($trans_details); 
			
			//Entry to Package orders Table			 
			$packorder = array('res_order' => $responseheader['Authorization Code'],
								'payment_type' => $this->code,
								'auction_id'=> $package_id,
								'buyer_id' => $userid, 
								'order_status' => 'S',
								'bidmethod' => 'clock',
								'total' => $amount,
								'currency_code' => $auth_data['currency']); 
			$insertpackgageorder = $this->authorize->auctionOrderDetails($packorder);
			$orderresponse = array('order_id' => $responseheader['Authorization Code'],'user_id' => $userid,'currency'=>$auth_data['currency'],'product_id' => $package_id,'price' =>$amount );
			Commonfunction::AuctionOrdermail($orderresponse);  
			 
                        
		}
		else
		{
			Message::error($responseheader['response']);
		} 
		$this->session->delete('authorizepost');
		$this->request->redirect('users/won_auctions');  
	}
	
}//End of users controller class
?>
