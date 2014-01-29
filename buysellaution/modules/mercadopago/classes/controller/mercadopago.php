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

class Controller_Mercadopago extends Controller_Website {	

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
		
	//protected $_buynow;	
	public function __construct(Request $request, Response $response)
	{
		$this->_mercadopago = new Mercadopago;
		parent::__construct($request,$response);

		$this->mercadopago=Model::factory('mercadopago');
		
		
		
		   // load mercadopago 
			
			
		
		
		if(!(preg_match('/users\/login/i',Request::detect_uri()) || preg_match('/users\/signup/i',Request::detect_uri()) || preg_match('/buynow\/buynow_offline/i',Request::detect_uri()) || preg_match('/buynow\/buynow_addcart/i',Request::detect_uri()) || preg_match('/buynow\/buynow_auction/i',Request::detect_uri())  ))
		{
			//Override the template variable decalred in website controller  
                       // $this->template=THEME_FOLDER."template_user_sidebar";
		}	
		else
		{
			//Override the template variable decalred in website controller
                        $this->template="themes/template";
		}
		
		
	}
	
	/*  Authorize Payment Gateway Process & Form validation -Dec18,2012 */
	public function action_mercadopago_payment(){
		//Check Whether the user is logged in
		$this->is_login(); 
		$userid = $this->session->get('auction_userid');
		$package_id=$this->request->param('id');
		
		
		$package_details= $this->mercadopago->getpackageDetails($package_id);
		$package_amount=$package_details[0]['price'];
		$pack_name=$package_details[0]['name'];
		
		$view=View::factory('mercadopago/'.THEME_FOLDER.'mercadopago_payment')
						->bind('package_amount',$package_amount)
						->bind('package_id',$package_id);
		$this->template->content=$view; 
		$this->template->title=__('mercadopago_title');
		$this->template->meta_description=__('mercadopago_desc');
		$this->template->meta_keywords=__('mercadopago_key');
	}
	
	/* Showing Final Staus for Authorize Payment Gate Way - Dec18,2012 */
	public function action_mercadopago_result(){
		$this->is_login(); 
		$userid = $this->session->get('auction_userid');
		$postval=arr::get($_REQUEST,'pay_order');
		if($postval &&  $userid){ 
			$packid = Arr::get($_POST,'package_id');
			$packdetails = $this->mercadopago->getjobdetails($packid);
			if(count($packdetails) < 1){
				$this->request->redirect('/');
			}
			$amount = number_format($packdetails[0]['price'], 2, '.', '');
			$sellerid = $packdetails[0]['package_id'];
		}else{
			//show msg as do not call direct payment url
			//redirect to home here
			$this->request->redirect('/');
		}
		//set production=0 for sandbox testing 1=>live paypal
		$production = 0;
		$urlProtocal = $_SERVER['SERVER_PORT'];//To get the prot number
		$accessProtocol = ($urlProtocal == 443)?'https://':'http://';//To get the  protocal is https or http
		$host = $accessProtocol.$_SERVER["HTTP_HOST"];//To get the base url
		$notifyurl =  $host.URL_BASE."payment/notify";        
		$returnurl = url::site('payment/checkout', 'http');//To check out the return url            
		$cancelurl = url::site('payment/cancelled', 'http');// TO cancel the url
		$email = $this->session->get('auction_email');//To get the email ID who is login
		$paymentgateway_mercadopago = $this->mercadopago->getmercadopagoconfig();
		if($paymentgateway_mercadopago[0]['status'] == "A"){	
			$url = "https://www.mercadopago.com/mla/buybutton";
			$successurl = url::site('mercadopago/mercadopagosuccess','http');
			$processurl = url::site('mercadopago/mercadopagoprocess','http');               
			$failurl = url::site('mercadopago/mercadopagofail','http');
			//Data bind
			$invoiceno = commonfunction::randomkey_generator();
			//To override payment currency
			$this->mercadopago_currencycode='ARG';
			$postData = array("acc_id" => $paymentgateway_mercadopago[0]['paypal_api_username'],
											"url_succesfull" => $successurl,
											"url_process" => $processurl,
											"url_cancel" => $failurl,
											"item_id" => $packid,
											"currency" => $paymentgateway_mercadopago[0]['currency_code'],
											"price" => $amount,
											"enc" => $paymentgateway_mercadopago[0]['paypal_api_signature'],
											"extra_part" => $userid. "-" . $sellerid . "-" . $invoiceno . "-" . $amount, 
											"token" => $paymentgateway_mercadopago[0]['paypal_api_password'],
											"sonda_key" => $paymentgateway_mercadopago[0]['paypal_api_password'],
											"mp_op_id" => "el-número-de-operación-de-MercadoPago",
											"seller_op_id" => time(),
											"shipping_cost" =>""
											);
			$data = http_build_query($postData, NULL, '&');
			$handler = curl_init();	
			curl_setopt($handler, CURLOPT_URL, $url);					
			curl_setopt($handler, CURLOPT_POST,true);					
			curl_setopt($handler, CURLOPT_POSTFIELDS, $data);
			$response = curl_exec ($handler);					
			curl_close($handler);
			if ($response == 1) {
				$this->request->redirect($url."?".$data);
			}else{
				$this->request->redirect('/');
			}
		}else{
			$this->request->redirect('/');
		}
	}
		
		/*
		 * Action for payment order
		 */
		public function action_payment_order_success()
		{
					$this->is_login(); 
					$view=View::factory('mercadopago/'.THEME_FOLDER.'order_success_temp');
					$this->template->content=$view; 
					$this->template->title=__('mercadopago_titles');
					$this->template->meta_description=__('mercadopago_descs');
					$this->template->meta_keywords=__('mercadopago_keys');
		}
		
		/*
		 * Success message
		 */
		public function action_mercadopagosuccess()
		{
					$this->request->redirect('/');
		}
		
		/*
		 * Success IPN
		 */
		public function action_mercadopagosuccessipn() 
		{		
                        $extrapart = isset($_POST['extra_part'])?$_POST['extra_part']:'';
                        if($extrapart != '') 
                        {
                        $separatepart = explode('-',$extrapart);
                        $buyerid = $separatepart[0];
                        $sellerid = $separatepart[1];
                        $invoiceno = $separatepart[2];
                        $amount=$separatepart[3];
                        }
                        $id = isset($_POST['mp_op_id'])?$_POST['mp_op_id']:'1';
                        $itemid = isset($_POST['item_id'])?$_POST['item_id']:'1';

                        if($id != "" && $itemid != "" && $buyerid != "" && $sellerid != "" && $invoiceno != "")
                        {	
                        $appId=MERCADOPAGO_CLIENTID;
                        $appSecret=MERCADOPAGO_CLIENTSECRET; 
                        $c_token = curl_init();
                        curl_setopt($c_token, CURLOPT_URL,"https://api.mercadolibre.com/oauth/token?");
                        curl_setopt($c_token, CURLOPT_POSTFIELDS,'grant_type=client_credentials&client_id=' . $appId . '&client_secret=' . $appSecret);
                        curl_setopt($c_token, CURLOPT_POST, 1);
                        curl_setopt($c_token, CURLOPT_RETURNTRANSFER,1);            

                        $token_response = curl_exec($c_token);   
                        $token_json=json_decode($token_response);            
                        $access_token=$token_json->access_token;

                        if ($id != '')
                        {
                        $url="https://api.mercadolibre.com/collections/notifications/".$id."?access_token=".$access_token; 
                        $c = curl_init();
                        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
                        curl_setopt($c, CURLOPT_URL, $url);
                        $content = curl_exec($c);
                        $json=json_decode($content); 
                        $TRANSACTIONID=$json->collection->id;
                        $TRANSACTIONTYPE=$json->collection->operation_type;
                        $CORRELATIONID=$json->collection->external_reference;
                        $status=$json->collection->status;
                        $PAYERSTATUS=$json->collection->status_detail;

                        if(isset($status)) 
                        {
                        if($status == "approved") 
                        {
                        $ack = "Success";
                        }
                        else if ($status == "pending") 
                        {
                        $ack = "Pending";
                        } 
                        else 
                        {
                        $ack = "Cancelled";
                        }
                        } 
                        else
                        {
                        $ack = "Cancel";
                        }

                        if($PAYERSTATUS=="accredited")
                        {
                        $REASONCODE=$json->collection->status_detail;
                        $PENDINGREASON="No pending";
                        }
                        else         
                        {
                        $PENDINGREASON=$REASONCODE=$json->collection->status_detail;
                        }  
                        if ($ack != "Cancelled")
                        {	

                        $trans_details=array('userid'=>$buyerid,'orderid'=>$invoiceno,
                        'packageid'=>$sellerid,'amount'=>$amount,'amount_type'=>'C');
                        //Entry to Transaction Details Table				
                        $addTransactionDetails=$this->mercadopago->authTransactionDetails($trans_details);

                        $transactionfield = array('PAYERID' => $json->collection->payer->id,
                        'PAYERSTATUS' => $PAYERSTATUS,
                        'FIRSTNAME' => $json->collection->payer->first_name,
                        'EMAIL' => $json->collection->payer->email,
                        'RECEIVER_EMAIL'=>'ndotauction@gmail.com',
                        'PACKAGEID'=>$sellerid,
                        'USERID' => $buyerid, // $this->session->get('mercadopago_buyerid'),
                        'ACK' => $ack,
                        'AMT' =>  $amount,
                        'ORDERTIME'=>Commonfunction::getCurrentTimeStamp(),
                        'REASONCODE'=>$REASONCODE,
                        'INVOICEID' => $invoiceno,//$this->session->get("mercadopago_invoiceno"),
                        'LOGIN_ID' => Request::$client_ip,
                        'USER_AGENT' => Request::$user_agent,
                        'PAYMENTSTATUS'=>'S',
                        'PAYMENTTYPE'=>'MercadoPago',
                        );
                        //insert transaction status
                        $transaction_detail=$this->mercadopago->addtransaction_deatils($transactionfield);

                        $orderfields = array('order_no' => $invoiceno,
                        'payment_method'=>'MercadoPago',
                        'package_id'=>$sellerid, 
                        'buyer_id' => $buyerid,
                        'order_currency_code' => $json->collection->currency_id,
                        'package_amount'=>$amount,
                        'paid_status'=>'PND'
                        );
                        //add transaction id in orderfields
                        $addOrderDetails=$this->mercadopago->addorder_details($order_details);

                        //Entry to TRANS_LOG_BUYER_PACKAGE_DESC 
                        $buyer_replace_variables = array('##BUYERNAME##'=>$buyerid,
                        '##PACKAGE_NAME##'=>$sellerid,
                        '##AMOUNT##'=>$amount,'##ORDER_NO##'=>$invoiceno); 
                        $buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PACKAGE_DESC,$buyer_replace_variables);

                        } 
                        else
                        {
                        $getuser =$this->mercadopago->get_name($buyerid);
                        $sitedetail = $this->mercadopago->get_db();
                        $payment_cancel_id = PAYMENT_CANCELLED;
                        $cancel_replace_variable = array("##USERNAME##"=>$buyer_name,"##FROM_EMAIL##"=>$sitedetail[0]['common_email_from'],
                        "##TO_MAIL##"=>$getuser[0]['email'], "##SITE_NAME##"=>$sitedetail[0]['site_name']);
                        $seller_templates = commonfunction::get_email_template_details($payment_cancel_id,$cancel_replace_variable,$send_mail);
                        }
                        }
                        }
                        else 
                        {
                        echo "Direct access not allowed";
                        $this->request->redirect('/');
                        }	
		}
		
		/*
		 * State change payments
		 */
		public function action_mercadopagoprocessipn()
		{
			$extrapart = isset($_POST['extra_part'])?$_POST['extra_part']:'';
			if ($extrapart != '') 
			{
				$separatepart = explode('-',$extrapart);
				$buyerid = $separatepart[0];
				$sellerid = $separatepart[1];
				$invoiceno = $separatepart[2];
				$amount = $separatepart[3];
			}		
				$id = isset($_POST['mp_op_id'])?$_POST['mp_op_id']:'';
				$itemid = isset($_POST['item_id'])?$_POST['item_id']:'';
				if ($id != "" && $itemid != "" && $buyerid != "" && $sellerid != "" && $invoiceno != "") 
				{
						$appId=MERCADOPAGO_CLIENTID;
						$appSecret=MERCADOPAGO_CLIENTSECRET;
						$c_token = curl_init();
						curl_setopt($c_token, CURLOPT_URL,"https://api.mercadolibre.com/oauth/token?");
						curl_setopt($c_token, CURLOPT_POSTFIELDS,'grant_type=client_credentials&client_id=' . $appId . '&client_secret=' . $appSecret);
						curl_setopt($c_token, CURLOPT_POST, 1);
						curl_setopt($c_token, CURLOPT_RETURNTRANSFER,1);            
						$token_response = curl_exec($c_token);     
						$token_json=json_decode($token_response);            
						$access_token=$token_json->access_token;
                      		
					if ($id != '') 
					{
						$url="https://api.mercadolibre.com/collections/notifications/".$id."?access_token=".$access_token; 
						$c = curl_init();
						curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
						curl_setopt($c, CURLOPT_URL, $url);
						$content = curl_exec($c);
						$json=json_decode($content);  
						$TRANSACTIONID=$json->collection->id;
						$TRANSACTIONTYPE=$json->collection->operation_type;
						$CORRELATIONID=$json->collection->external_reference;
						$status=$json->collection->status;
						$PAYERSTATUS=$json->collection->status_detail;

							if(isset($status)) 
							{
								if ($status == "approved")
								{
									$ack = "Success";
								} 
								else if ($status == "pending")
								{
									$ack = "Pending";
								}
								else 	
								{
									$ack = "Cancelled";
								}
							} 
							else 
							{
								$ack = "Cancel";
							}

								if($PAYERSTATUS=="accredited")
								{
									$REASONCODE=$json->collection->status_detail;
									$PENDINGREASON="No pending";
								}
								else         
								{
									$PENDINGREASON=$REASONCODE=$json->collection->status_detail;
								}  
			
									if ($ack != "Cancelled") 
									{	
														$trans_details=array('userid'=>$buyerid,'orderid'=>$invoiceno,
																		'packageid'=>$sellerid,'amount'=>$amount,'amount_type'=>'C');
														//Entry to Transaction Details Table
														$addTransactionDetails=$this->mercadopago->authTransactionDetails($trans_details);
														
														$transactionfield = array('PAYERID' => $json->collection->payer->id,
																					'PAYERSTATUS' => $PAYERSTATUS,
																					'FIRSTNAME' => $json->collection->payer->first_name,
																					'EMAIL' => $json->collection->payer->email,
																					'RECEIVER_EMAIL'=>'ndotauction@gmail.com',
																					'PACKAGEID'=>$sellerid,
																					'USERID' => $buyerid, 
																					'ACK' => $ack,
																					'AMT' =>  $amount,
																					'ORDERTIME'=>Commonfunction::getCurrentTimeStamp(),
																					'REASONCODE'=>$REASONCODE,
																					'INVOICEID' => $invoiceno,
																					'LOGIN_ID' => Request::$client_ip,
																					'USER_AGENT' => Request::$user_agent,
																					'PAYMENTSTATUS'=>'S',
																					'PAYMENTTYPE'=>'MercadoPago',
																					);	   
														//insert transaction status
														$transaction_detail=$this->mercadopago->addtransaction_deatils($transactionfield);
															
														$orderfields = array('order_no' => $invoiceno,
																					'payment_method'=>'MercadoPago',
																					'package_id'=>$sellerid, 
																					'buyer_id' => $buyerid,
																					'order_currency_code' => $json->collection->currency_id,
																					'package_amount'=>$amount,
																					'paid_status'=>'PND'
																					);
														//add transaction id in orderfields
														$addOrderDetails=$this->mercadopago->addorder_details($order_details);
														
														//Entry to TRANS_LOG_BUYER_PACKAGE_DESC 
														$buyer_replace_variables = array('##BUYERNAME##'=>$buyerid,
																						'##PACKAGE_NAME##'=>$sellerid,
																						'##AMOUNT##'=>$amount,'##ORDER_NO##'=>$invoiceno); 
														$buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PACKAGE_DESC,$buyer_replace_variables);
									}
									else 
									{
										$getuser =$this->mercadopago->get_name($buyerid);
										$sitedetail = $this->mercadopago->get_db();
										$payment_cancel_id = PAYMENT_CANCELLED;
										$cancel_replace_variable = array("##USERNAME##"=>$buyer_name,"##FROM_EMAIL##"=>$sitedetail[0]['common_email_from'],
																		"##TO_MAIL##"=>$getuser[0]['email'], "##SITE_NAME##"=>$sitedetail[0]['site_name']);
										$seller_templates = commonfunction::get_email_template_details($payment_cancel_id,$cancel_replace_variable,$send_mail);
									}
						}
					} 
					else 
					{
						echo "Direct access not allowed";
						$this->request->redirect('/');
					}
	}
	
	/*
	 *  Payment in process
	 */
	public function action_mercadopagoprocess()
	{
		$this->request->redirect('/');
	}
		
	/*
	 *  Payment cancelled
	 */
	public function action_mercadopagofail()
	{
		$this->request->redirect('cms/page/order-purchase-complete');
	}
	

	
}//End of users controller class
?>
