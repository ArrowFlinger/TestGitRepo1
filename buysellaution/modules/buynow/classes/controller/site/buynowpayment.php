<?php defined('SYSPATH') or die('No direct script access.');
 
/**
 * Contains Paypal Payment Module details
 * @Created on October 24, 2012
 * @Updated on October 24, 2012
 * @package    Nauction Platinum Version 1.0
 * @author     Ndot Team
 * @copyright  (c) 2008-2011 Ndot Team
 * @license    http://ndot.in/license 
 */

class Controller_Site_Buynowpayment extends Controller_Website {
       
        public function __construct(Request $request, Response $response)
	{
	     
		parent::__construct($request, $response);
		$this->paypal_db = Model::factory('buynowpaypal');	
		$this->paypalconfig = $this->paypal_db->getpaypalconfig(); 
		$this->paypaldbconfig = count($this->paypalconfig) > 0?array("username"=>$this->paypalconfig[0]['paypal_api_username'],
		 "password"=>$this->paypalconfig[0]['paypal_api_password'], "signature"=>$this->paypalconfig[0]['paypal_api_signature'], 
		 "environment"=>($this->paypalconfig[0]['payment_method'] =="L")?"live":"sandbox"):"";
		$this->getCurrentTimeStamp=commonfunction::getCurrentTimeStamp();
		
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
	       $this->request->redirect('/');
	}
	
	/*
	*BuyNow option using Product  order Offline
	*User Balance low mean using pay pal
	*/
	public function action_paypal()
	{
		
		//if not post redirect to home page
       		if(isset($_POST["pay_order"]) && $this->userlogin )
		{  
			    
			$userid = $this->session->get('auction_userid');      
		        $product_id = Arr::get($_POST,'product_id');
		        $productdetails = $this->paypal_db->all_addtocart_list($userid);
			
		//print_r($productdetails);exit;
			/*foreach($productdetails as $trans): 
			$amt[]=$trans['total_amt'];
			$sipping[]=$trans['shipping_fee'];
			$quntity[]=$trans['quantity'];
			$totalamount=array_sum($amt);
			$sippingamt=array_sum($sipping);
			$productname=$trans['product_name'];
			$qty=array_sum($quntity);					
			endforeach;
			$pname=implode(",",$productname);*/
	
			//product cost & shipping fee
			//$productcost = $totalamount + $sippingamt;	
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
                $notifyurl =  URL_BASE."site/buynowpayment/notify";                
                $this->payment_success_url = URL_BASE.'site/buynow/products_transactions';
	       
		//Flash message 
                //Message::success(__('paypal_success'));
                $returnurl = URL_BASE.'site/buynowpayment/checkout';               
                $cancelurl = URL_BASE.'site/buynowpayment/cancelled';
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
			
			//print_r($data);exit;
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
		$producttotalcoutid = count($this->paypal_db->all_addtocart_list($this->session->get('auction_userid')))-1;		
		
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
				$getproductdetails=$this->paypal_db->getproductdetails($productid);
				$shippingfee=$getproductdetails[0]['shipping_fee'];
				$shippingfee=($shippingfee!='')?$shippingfee:0;
				$totalamount=($productcost*$quantity)+$shippingfee;
                       
				$transactionfield['PAYERID'] = Arr::get($customer, 'PAYERID');
				$transactionfield['PAYERSTATUS'] = Arr::get($customer, 'PAYERSTATUS');
				$transactionfield['FIRSTNAME'] = Arr::get($customer, 'FIRSTNAME');
				$transactionfield['LASTNAME'] = Arr::get($customer, 'LASTNAME');
				$transactionfield['EMAIL'] = Arr::get($customer, 'EMAIL');
				$transactionfield['L_PAYMENTREQUEST_0_AMT'.$i]= $totalamount;
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
                        $transaction_detail=$this->paypal_db->addtransaction_deatils($transactionfield,$producttotalcoutid);
			
			
			
			
			
                        $last_transaction_insert_id = $transaction_detail[0];
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
                        $order_db_response =$this->paypal_db->addorder_details($orderfields); 
                        $buyer_name =$this->paypal_db->get_username($this->session->get('auction_userid'));
			
			
                       
                        for($i=0;$i<=$producttotalcoutid;$i++){
				$quantity=Arr::get($customer,'L_QTY'.$i);
				$productcost=Arr::get($customer,'L_AMT'.$i);
				$productid=Arr::get($customer, 'L_NUMBER'.$i);
				$getproductdetails=$this->paypal_db->getproductdetails($productid);
				$shippingfee=$getproductdetails[0]['shipping_fee'];
				$shippingfee=($shippingfee!='')?$shippingfee:0;
				$totalamount=($productcost*$quantity)+$shippingfee;
				
			/* $buyer_replace_variables = array('##BUYERNAME##'=>$buyer_name, '##PRODUCT_NAME##'=>$this->session->get('paypal_producttitle_' .$token),
                         '##AMOUNT##'=>$this->site_currency." ".Commonfunction::numberformat($totalamount),
			 '##PRODUCT_COST##'=>$this->site_currency." ".Commonfunction::numberformat($productcost),
			 '##QUANTITY##'=>$quantity,
			 '##SHIPPING_AMOUNT##'=>$this->site_currency." ".Commonfunction::numberformat($shippingfee),
			 
			 '##ORDER_NO##'=>$this->session->get('paypal_invoiceno_' .$token)); 
                        
                        $buyer_desc = commonfunction::get_replaced_content(TRANS_LOG_BUYER_PRODUCT_DESC,$buyer_replace_variables);*/
			
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
                        $this->paypal_db->addtransactionlog_details($transactionlog_details_buyer,$producttotalcoutid);		                     
                        //its good idea to destroy assign after data insert
                        $this->session->delete('paypal_paypal_token_'.$token);
                        $this->session->delete('paypal_sellerid_'.$token);
                        $this->session->delete('paypal_invoiceno_' .$token);
                        $this->session->delete('paypal_producttitle_' .$token);
                        //redirect to thankyou page   
			$user_current_amount=$this->paypal_db->get_user_account($this->session->get('auction_userid'));
			$return_amount=Arr::get($paymentresponse, 'AMT');
			$total_amount=$user_current_amount+$return_amount;
			//Amount hide                       
			// User Message Email Products Success
			
			        $select_email=$this->email;
		                $from=FROM_MAIL;
		                $subject="Buy Products";
		                $message="Buy Products Amount of <b>".$this->site_currency." ".$return_amount." </b>  this is buy now option the biding auctions.";
		                $sent_date=$this->getCurrentTimeStamp;
		                $user_amuont=$this->paypal_db->user_message_packages($select_email,$from,$subject,$message,$sent_date);
			//End			
			$this->paypal_db->order_delete($transactionlog_details_buyer,$producttotalcoutid,$this->session->get('auction_userid'));
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
	
	public function action_cancelled()
	{ 
			//set cancel message
			$this->request->redirect('/');
			Message::error($this->session->get('paypal_error'));
			//create cancel page and call 
	}
	
	

	//Buy product offline
	public function action_offline()
        {
		    //if not post redirect to home page
       		if(isset($_POST["pay_order"]) && $this->userlogin )
		{  	
			$userid = $this->session->get('auction_userid');
			$product_id = Arr::get($_POST,'product_id');
			//echo $product_id;exit;
			$producttotalcoutid = count($this->paypal_db->all_addtocart_list($this->session->get('auction_userid')));	
			$productdetails = $this->paypal_db->all_addtocart_list($userid);
			
			$buyer_name =$this->paypal_db->get_username($this->session->get('auction_userid'));

			foreach($productdetails as $trans): 
			$amts[]=$trans['product_cost']*$trans['quantity'];
			$shipping_fee=($trans['shipping_fee']=='')?0:$trans['shipping_fee'];
			$sipping[]=$shipping_fee;
			$product_name[]=$trans['product_name'];
			$product_cst[]=$trans['product_cost'];
			$product_id[]=$trans['product_id'];
			$quntity[]=$trans['quantity'];
			
			if($shipping_fee>0){
				$buyer_desc =__('buynow_product_desc',array(':param'=>$buyer_name,':param1'=>$trans['product_name'],
									    ':param2'=>$this->site_currency." ".Commonfunction::numberformat($trans['product_cost']),
									    ':param3'=>$trans['quantity'],':param4'=>$this->site_currency." ".Commonfunction::numberformat($trans['shipping_fee']),
									    ':param5'=>$this->site_currency." ".Commonfunction::numberformat((($trans['product_cost']*$trans['quantity'])+$trans['shipping_fee']))));
	
			}else{
				
				$buyer_desc =__('buynow_product_desc_without_shipping',array(':param'=>$buyer_name,':param1'=>$trans['product_name'],
											     ':param2'=>$this->site_currency." ".Commonfunction::numberformat($trans['product_cost']),
											     ':param3'=>$trans['quantity'],':param4'=>$this->site_currency." ".Commonfunction::numberformat((($trans['product_cost']*$trans['quantity'])+$trans['shipping_fee']))));

			}
			
			$offline_details= array(
                        'userid' =>  $this->session->get('auction_userid'),
                        'order_no' => "",
                        'productid' => $trans['product_id'],
                        'amount' => $trans['product_cost'],
			'shipping_amount' => $shipping_fee,
			'quantity'=>$trans['quantity'],
                        'amount_type' => CREDIT,                                      //login user a/c 
                        'description' => $buyer_desc,
                        );  	
			
                        $this->paypal_db->addtransactionlog_details_offline($offline_details);
			
			$this->paypal_db->order_delete_offline($offline_details,$this->session->get('auction_userid'));
			
			endforeach;
			
			
			$totalamount=array_sum($amts);
			$sippingamt=array_sum($sipping);
			$productname=$trans['product_name'];
			$product_cost_tot = $totalamount + $sippingamt;
			
			
			$pname=implode(",",$product_name);
		        $amt=(Commonfunction::get_user_balance($this->session->get('auction_userid')));
		       // print_r($amt);exit;		         
				 $amt1=(Commonfunction::get_user_bonus($this->session->get('auction_userid')));
				
			$total_amount=$amt-$product_cost_tot;
			//insert order status
			


			
			//Detect user balance
			$credit_account_touser=$this->paypal_db->update_useraccount($this->session->get('auction_userid'),$total_amount); 
					
			//Amount hide                       
			// User Message Email Products Success			
			        $select_email=$this->email;
		                $from=FROM_MAIL;
		                $subject="Buy Products";
		                $message="Buy Products Amount of <b>".$this->site_currency." ".$product_cost_tot." </b>  this is buy now option the biding auctions.";
		                $sent_date=$this->getCurrentTimeStamp;
		                $user_amuont=$this->paypal_db->user_message_packages($select_email,$from,$subject,$message,$sent_date); 
		}
		else
		{
                        //show msg as do not call direct payment url
                        //redirect to home here
                        $this->request->redirect('/');
			Message::error(__('Your Details something worng'));
                }
		//Flash message
		
		
                Message::success(__('paypal_success_offline'));			
                $this->request->redirect('site/buynow/products_transactions');
		$this->template->title="Buy Product";
                $this->template->title="Buy Product";
		$this->template->meta_description="Buy Product";
		$this->template->meta_keywords="Auctions Buy Product"; 
	}

	//Buy Now add to cart
	//Buy product buynow_addtocart
	public function action_buynow_addtocart()
        {    
		
		//if not post redirect to home page
       		if(isset($_POST["pay_order"]) && $this->userlogin )
		{  
			$product_id = Arr::get($_POST,'product_id');
		        $productdetails = $this->paypal_db->getproductdetails($product_id);
			
		//print_r($productdetails);exit;
		        $amt=(Commonfunction::get_user_balance($this->session->get('auction_userid')));
			//Product Cost and shipping fee
			$productcost = $productdetails[0]['product_cost'];			
			$total_amount=$amt-$productcost;
			//insert order status
			$buyer_name =$this->paypal_db->get_username($this->session->get('auction_userid'));
                        $buyer_desc = $buyer_name ." "." bought ".$productdetails[0]['product_name'] ." for ".$productcost;                
                        $addtocart_details= array(
                        'userid' =>  $this->session->get('auction_userid'),                      
                        'productid' => $productdetails[0]['product_id'],
			'product_cost' => $productdetails[0]['product_cost'],
			'product_name' => $productdetails[0]['product_name'],
			'product_image' => $productdetails[0]['product_image'],
			'shipping_fee' => $productdetails[0]['shipping_fee'],
                        'amount' => $productcost//login user a/c                        
                        );                        
                        $this->paypal_db->addtocart_details($addtocart_details);		
			  
		}
		else
		{
                        //show msg as do not call direct payment url
                        //redirect to home here
                        $this->request->redirect('/');
			Message::error(__('Your Details something worng'));
                }
		//Flash message 
                Message::success(__('add_cart_success'));		
                $this->request->redirect('site/buynow/addtocart_list');
		$this->template->title="BuyNow Add to cart";
                $this->template->title="BuyNow Add to cart";
		$this->template->meta_description="BuyNow Add to cart";
		$this->template->meta_keywords="BuyNow Add to cart"; 
	}

}//End of payment controller
?> 
