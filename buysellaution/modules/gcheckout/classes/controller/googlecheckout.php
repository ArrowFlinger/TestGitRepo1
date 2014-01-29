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

class Controller_Googlecheckout extends Controller_Website {	

	protected $reponsedata = array();
	protected $transactiontable = "";
	protected $code = "gc";
	protected $gcart;
	protected $gatewayname = "";
	protected $packtype;
	 
	public function __construct(Request $request, Response $response)
        { 
		parent::__construct($request,$response);
		$this->gc = Model::factory('gc');
		$this->gcart = new Gc('sandbox'); 
		$paymentgateways = $this->packages->select_paymentgateways();
		$this->email= $this->session->get('auction_email'); 
		foreach($paymentgateways as $gateway)
		{
			if($gateway['paygate_code'] == $this->code)
			{
				$this->gatewayname = $gateway['payment_gatway'];
				//$this->transactiontable = $gateway['paypal_api_username']; 
			}
		}
	}
	
	public function action_index()
	{
		$this->auto_render =false;
		$orderresponse = array('order_id' => '23323','product_id' => 169,'currency' => '$','user_id' => 169);
		Commonfunction::AuctionOrdermail($orderresponse);
	}
	/**** Added By venkatraja 15-Mar-2013 ****/
	public function action_transactionlogs(){
		
		$invoicenumber=isset($_REQUEST['invoicenumber'])?$_REQUEST['invoicenumber']:'';
		
		$transactiondetails=$this->gc->gettransactionlogdetails($invoicenumber);
		
		
		$view = View::factory('admin/gcheckouttransactionlog')
                                ->bind('transactiondetails',$transactiondetails);
		$this->template= $view;
		
		}	
	
	/*** Added End By Venkatraja ***/
	
	public function action_payment()
	{
		
		if(isset($_POST) && count($_POST)>0)
		{
			$this->session->set('gcpost',$_POST['form']);
			$post = $_POST['form'];
		}
		else
		{
			$post = $this->session->get('gcpost');
		} 
		$pid = implode("_",$post['id']);
		
		//Creating a array which suits for google cart array
		$items = Gc::gcartitems($post);
		
		//Pass the custom datas
		$additional = serialize(array('pids' => $post['id'],'type'=> $post['type'],'userid' => $this->session->get('auction_userid')));
		
		//print_r($post);exit;
		
		//Getting tax and shipping rate
		$shipping  = isset($post['shipping_cost']) ? $post['shipping_cost']:0;
		//$shipping  =0;
		$tax = isset($post['tax']) ? $post['tax']:0;
		
		//Creating the object for google cart
		$this->gcart->standard($items['cartitems'],URL_BASE,$additional,$shipping,$tax);
		
		//Creating a button with the above created cart object
		$button = $this->gcart->renderbutton(1);
		
		
		/*$view = view::factory(THEME_FOLDER.'submitform');*/
		
		$view = view::factory(THEME_FOLDER.'payment')
					->bind('post',$post)
					->bind('total',$items['total'])
					->bind('button',$button);
					
		$this->template->content = $view;    $this->template->title=__('gc_title');
		$this->template->meta_description=__('gc_desc');
		$this->template->meta_keywords=__('gc_key');
		
	}
	protected function mailtest($msg="")
	{
		$smtp_config = array('driver' => 'smtp','options' => array('hostname'=>'smtp.gmail.com',
						'username'=>'shyam.mtp@gmail.com','password' =>'pradeep2012',
						'port' => '465','encryption' => 'ssl')); 
					if(Email::connect($smtp_config))
					{                         	                      
						Email::send('pradeepshyam@ndot.in','shyam.mtp@gmail.com' ,'googlecheckout', $msg,$html = true);
						
					}
	} 
	
	
	public function action_response()
	{
		$this->auto_render =false; 
		$this->responsedata = $_REQUEST;
		 $gc = $this->gc->selectGCTransaction($this->responsedata['google-order-number']); 
		$additional=($gc!="")?(($gc['custom_data']!='')?unserialize($gc['custom_data']):unserialize($this->responsedata['shopping-cart_merchant-private-data'])):unserialize($this->responsedata['shopping-cart_merchant-private-data']);
		$type = isset($additional['type'])?$additional['type']:"";
		
	
		switch($type)
		{
			case "package";
				$this->processpackageorder($this->responsedata);
				break;
			
			/** added by venkatraja for 7-Mar-13**/
			case "wonauction";
				$this->processwonauctionorder($this->responsedata);
				break;
			
			case "product";
				$this->processbuynoworder($this->responsedata);
				break;
			
			/*** Venkatraja added end ***/
			case "reserveauction":
				$this->processreserveauctionorder($this->responsedata);
				break; 
			
			case "clockauction":
				$this->processclockauctionorder($this->responsedata);
				break; 
				
			default:
				break;
		}
		
	}
	
	/***  Added By Venkatraja in 7-Mar-2013  ***/
	
	
	//for Wonauction
	
	protected function processwonauctionorder($response)
	{ 
		switch($response['_type'])
		{
			case "new-order-notification":
				
				
				$cdata = unserialize($response['shopping-cart_merchant-private-data']);
				
				
					
				$n=1;
				$k=0;
				do{					
				
				$datas[$k]['buyer_email']=$response['buyer-billing-address_email'];
				$datas[$k]['buyer_name']=$response['buyer-billing-address_contact-name'];
				$datas[$k]['gc_orderno']=$response['google-order-number'];
				$datas[$k]['gc_timestamp']=$response['timestamp'];
				$datas[$k]['serial_number']=$response['serial-number'];
				$datas[$k]['billingaddress']=$this->getBuyerAddress($response);
				$datas[$k]['shippingaddress']=$this->getBuyerAddress($response);
				$datas[$k]['order_total']=$response['order-total'];
				$datas[$k]['order_currency']=$response['order-total_currency'];
				$datas[$k]['fulfillment_orderstate']=$response['fulfillment-order-state'];
				$datas[$k]['financial_orderstate']=$response['financial-order-state'];
				$datas[$k]['gc_buyerid']=$response['buyer-id'];
				$datas[$k]['item_id']=$cdata['pids'][$k];
				$datas[$k]['shipping_amount']=$this->gc->get_shipping_amount($cdata['pids'][$k]);
				$datas[$k]['item_unit-price']=$response['shopping-cart_items_item-'.$n.'_unit-price'];
				$datas[$k]['item_quantity']=$response['shopping-cart_items_item-'.$n.'_quantity'];
				$datas[$k]['item_item-name']=$response['shopping-cart_items_item-'.$n.'_item-name'];
				$datas[$k]['buyer_id']=$cdata['userid'];
				    ++$n;
				    ++$k;
				}while(isset($response['shopping-cart_items_item-'.$n.'_unit-price']));
				
				
			
				
				
				$gcdata = $this->gc->selectGCTransaction($response['google-order-number']);
				
				
			
				
				if($gcdata)
				{
					$id = $gcdata['order_id'];
				}
				else{
					
					foreach($datas as $data){
						
					$insert = $this->gc->insertGCresponse($data);	
					}
					
					
					$id = $insert[0];
				}
			//  if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="REVIEWING")

			if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="CHARGED")
			
				 {
					$cdata = unserialize($response['shopping-cart_merchant-private-data']);
					
					
					$google_checkout_details =$this->gc->selectMultipleGCTransaction($response['google-order-number']);
					
					
					
					foreach($google_checkout_details as $google_checkout_detail){
						
						$quantity=$google_checkout_detail['item_quantity'];
						$productcost=$google_checkout_detail['item_unit-price'];
						$productid=$google_checkout_detail['item_id'];
						
						$shippingfee=$google_checkout_detail['shipping_amount'];
						
						$shippingfee=($shippingfee!='')?$shippingfee:0;
						$totalamount=($productcost*$quantity)+$shippingfee;
			
			
						$product_name=$google_checkout_detail['item_item-name'];
						$total_amount=$this->site_currency." ".Commonfunction::numberformat($totalamount);
						$shipping_fee=$this->site_currency." ".Commonfunction::numberformat($shippingfee);
						$product_cost=$this->site_currency." ".Commonfunction::numberformat($productcost);
						$order_no=$google_checkout_detail['gc_orderno'];
				$buyer_name =$this->gc->get_username($google_checkout_detail['buyer_id']);
				
				
		
			
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
					
					$trans_details=array('userid'=>$google_checkout_detail['buyer_id'],
							     'orderid'=>$google_checkout_detail['gc_orderno'],
							      'packageid'=>$google_checkout_detail['item_id'],
								'amount'=>$google_checkout_detail['item_unit-price'],
								'shippingamount'=>$google_checkout_detail['shipping_amount'],
								'description'=>$buyer_desc,
								'transaction_type'=>"Google Checkout",
								'type'=>'PR',
								'amount_type'=>'C');
					
					
					
					$this->gc->authTransactionDetails($trans_details);
					
					
					
					$packorder = array('res_order' => $google_checkout_detail['gc_orderno'],
								'payment_type' => $this->code,
								'auction_id'=> $google_checkout_detail['item_id'],
								'buyer_id' => $google_checkout_detail['buyer_id'], 
								'order_status' => 'S',
								'bidmethod' => Commonfunction::get_auction_bid_name($google_checkout_detail['item_id']),
								'total' => $google_checkout_detail['item_unit-price'],
								'shippingamount'=>$google_checkout_detail['shipping_amount'],
								'currency_code' => $google_checkout_detail['order_currency']);
					
					
					
					$insertpackgageorder = $this->gc->auctionOrderDetails($packorder);
					
					
					$orderresponse = array('order_id' => $google_checkout_detail['gc_orderno'],'user_id' => $google_checkout_detail['buyer_id'],'currency'=>$google_checkout_detail['order_currency'],'product_id' => $google_checkout_detail['item_id'],'price' => $google_checkout_detail['item_unit-price'],'shipping' => $google_checkout_detail['shipping_amount']);
					Commonfunction::AuctionOrdermail($orderresponse); 
					
					}
				
				 }
				
				break;
			case "order-state-change-notification":
				$datas = array('fulfillment_orderstate' => $response['new-fulfillment-order-state'],
					       'financial_orderstate' => $response['new-financial-order-state']);
				$update = $this->commonmodel->update(GC_TRANSACTIONS,$datas,'gc_orderno',$response['google-order-number']); 
				$gc = $this->gc->selectGCTransaction($response['google-order-number']); 
				if($gc!="")
				{
					//if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="REVIEWING")
					if($datas['fulfillment_orderstate']=="NEW" && $datas['financial_orderstate']=="CHARGED")
					{
						
						$cdata = unserialize($response['shopping-cart_merchant-private-data']);
					
					
					$google_checkout_details =$this->gc->selectMultipleGCTransaction($response['google-order-number']);
					
					foreach($google_checkout_details as $google_checkout_detail){
							
						$quantity=$google_checkout_detail['item_quantity'];
						$productcost=$google_checkout_detail['item_unit-price'];
						$productid=$google_checkout_detail['item_id'];
						
						$shippingfee=$google_checkout_detail['shipping_amount'];
						
						$shippingfee=($shippingfee!='')?$shippingfee:0;
						$totalamount=($productcost*$quantity)+$shippingfee;
			
			
						$product_name=$google_checkout_detail['item_item-name'];
						$total_amount=$this->site_currency." ".Commonfunction::numberformat($totalamount);
						$shipping_fee=$this->site_currency." ".Commonfunction::numberformat($shippingfee);
						$product_cost=$this->site_currency." ".Commonfunction::numberformat($productcost);
						$order_no=$google_checkout_detail['gc_orderno'];
				$buyer_name =$this->gc->get_username($google_checkout_detail['buyer_id']);		
		
			
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
					
					$trans_details=array('userid'=>$google_checkout_detail['buyer_id'],
							     'orderid'=>$google_checkout_detail['gc_orderno'],
							      'packageid'=>$google_checkout_detail['item_id'],
								'amount'=>$google_checkout_detail['item_unit-price'],
								'shippingamount'=>$google_checkout_detail['shipping_amount'],
								'description'=>$buyer_desc,
								'transaction_type'=>"Google Checkout",
								'type'=>'PR',
								'amount_type'=>'C');
					
					
					
					$this->gc->authTransactionDetails($trans_details);
					
					
					
					$packorder = array('res_order' => $google_checkout_detail['gc_orderno'],
								'payment_type' => $this->code,
								'auction_id'=> $google_checkout_detail['item_id'],
								'buyer_id' => $google_checkout_detail['buyer_id'], 
								'order_status' => 'C',
								'bidmethod' => Commonfunction::get_auction_bid_name($google_checkout_detail['item_id']),
								'total' => $google_checkout_detail['item_unit-price'],
								'shippingamount'=>$google_checkout_detail['shipping_amount'],
								'currency_code' => $google_checkout_detail['order_currency']);
					
					
					
					$insertpackgageorder = $this->gc->auctionOrderDetails($packorder);
					
					$orderresponse = array('order_id' => $google_checkout_detail['gc_orderno'],'user_id' => $google_checkout_detail['buyer_id'],'currency'=>$google_checkout_detail['order_currency'],'product_id' => $google_checkout_detail['item_id'],'price' => $google_checkout_detail['item_unit-price'],'shipping' => $google_checkout_detail['shipping_amount']);
					Commonfunction::AuctionOrdermail($orderresponse); 
					
					}
				
					  
					}	
				}
				 
				break;
			
		}
		
	}
	
	
	
	//for buynow order
	
	
	
	protected function processbuynoworder($response)
	{
		
		
		switch($response['_type'])
		{
			case "new-order-notification":
				
				
				$cdata = unserialize($response['shopping-cart_merchant-private-data']);
				
					
				$n=1;
				$k=0;
				do{					
				
				$datas[$k]['buyer_email']=$response['buyer-billing-address_email'];
				$datas[$k]['buyer_name']=$response['buyer-billing-address_contact-name'];
				$datas[$k]['gc_orderno']=$response['google-order-number'];
				$datas[$k]['gc_timestamp']=$response['timestamp'];
				$datas[$k]['serial_number']=$response['serial-number'];
				$datas[$k]['billingaddress']=$this->getBuyerAddress($response);
				$datas[$k]['shippingaddress']=$this->getBuyerAddress($response);
				$datas[$k]['order_total']=$response['order-total'];
				$datas[$k]['order_currency']=$response['order-total_currency'];
				$datas[$k]['fulfillment_orderstate']=$response['fulfillment-order-state'];
				$datas[$k]['financial_orderstate']=$response['financial-order-state'];
				$datas[$k]['gc_buyerid']=$response['buyer-id'];
				$datas[$k]['item_id']=$cdata['pids'][$k];
				$datas[$k]['shipping_amount']=$this->gc->get_shipping_amount($cdata['pids'][$k]);
				$datas[$k]['item_unit-price']=$response['shopping-cart_items_item-'.$n.'_unit-price'];
				$datas[$k]['item_quantity']=$response['shopping-cart_items_item-'.$n.'_quantity'];
				$datas[$k]['item_item-name']=$response['shopping-cart_items_item-'.$n.'_item-name'];
				$datas[$k]['buyer_id']=$cdata['userid'];
				    ++$n;
				    ++$k;
				}while(isset($response['shopping-cart_items_item-'.$n.'_unit-price']));
			
				
				
				$gcdata = $this->gc->selectMultipleGCTransaction($response['google-order-number']);
				
				
				
				
				if(count($gcdata)>0)
				{
					$id = $gcdata[0]['order_id'];
				}
				else{
					
					foreach($datas as $data){
						
					$insert = $this->gc->insertGCresponse($data);	
					}
					
					
					$id = $insert[0];
				}
				
				 //if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="REVIEWING")

				 if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="CHARGED")
				
				 {
					$cdata = unserialize($response['shopping-cart_merchant-private-data']);
					
					
					$google_checkout_details =$this->gc->selectMultipleGCTransaction($response['google-order-number']);
					
					$auctionproductdetails=array();
					
					if(count($google_checkout_details)>0){	
					$sfee=0;
					
					foreach($google_checkout_details as $google_checkout_detail){
								
						$transactionfield['PAYERID'] =$google_checkout_detail['gc_buyerid'];
						$transactionfield['PAYERSTATUS'] = 'C';
						$transactionfield['PRODUCTID'] = $google_checkout_detail['item_id'];
						$transactionfield['USERID'] = $google_checkout_detail['buyer_id'];
						$transactionfields['TRANSACTIONID']=$google_checkout_detail['gc_orderno'];
						$transactionfields['TRANSACTIONTYPE']='Google Checkout';
						$transactionfields['PAYMENTTYPE']=$this->code;
						$transactionfield['AMT']= $google_checkout_detail['item_unit-price'];
						$transactionfield['SHIPPINGAMT']=$google_checkout_detail['shipping_amount'];
						$transactionfields['CURRENCYCODE']=$google_checkout_detail['order_currency'];
						$transactionfield['LOGIN_ID'] = Request::$client_ip;
						$transactionfield['USER_AGENT'] = Request::$user_agent;
						
						 $this->gc->addbuynowtransaction_details($transactionfield);
				 
						$last_transaction_insert_id = $this->gc->get_last_transaction_id();
						$max_date_complete_db_format = "";			
						$orderfields = array(
						'order_no' => $google_checkout_detail['gc_orderno'],                       
						'product_id' => $google_checkout_detail['item_id'],
						'buyer_id' => $google_checkout_detail['buyer_id'],
					  
						'order_status' => SUCCESS_PAYMENT_ORDER_STATUS,
						'action' => SUCCESS_PAYMENT_ORDER_ACTION,
						'product_cost' => $google_checkout_detail['item_unit-price'],
						'quantity' => $google_checkout_detail['item_quantity'],
						'shippingfee' => $google_checkout_detail['shipping_amount'],
						'product_commission_amount' => "",
						'order_total' => ($google_checkout_detail['item_unit-price']*$google_checkout_detail['item_quantity'])+$google_checkout_detail['shipping_amount'],
						'order_subtotal' => 0.00,
						'order_currency_code' => $google_checkout_detail['order_currency'],
						'paid_status' => PAID_PENDING, 
						'maximum_date_complete' => $max_date_complete_db_format,
						'transaction_details_id' => $last_transaction_insert_id  
						);
				 
						$this->gc->addbuynoworder_details($orderfields);
			
			
						$quantity=$google_checkout_detail['item_quantity'];
						$productcost=$google_checkout_detail['item_unit-price'];
						$productid=$google_checkout_detail['item_id'];
						
						$shippingfee=$google_checkout_detail['shipping_amount'];
						
						$shippingfee=($shippingfee!='')?$shippingfee:0;
						$totalamount=($productcost*$quantity)+$shippingfee;
			
			
						$product_name=$google_checkout_detail['item_item-name'];
						$total_amount=$this->site_currency." ".Commonfunction::numberformat($totalamount);
						$shipping_fee=$this->site_currency." ".Commonfunction::numberformat($shippingfee);
						$product_cost=$this->site_currency." ".Commonfunction::numberformat($productcost);
						$order_no=$google_checkout_detail['gc_orderno'];
				$buyer_name =$this->gc->get_username($google_checkout_detail['buyer_id']);		
		
			
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
			
		     //  $transactionlog_details_buyer['site_currency'] =  $google_checkout_detail['order_currency'];
                        $transactionlog_details_buyer['userid'] =  $google_checkout_detail['buyer_id'];
                        $transactionlog_details_buyer['orderid'] = $google_checkout_detail['gc_orderno'];
                        $transactionlog_details_buyer['productid'] = $google_checkout_detail['item_id'];
                     
			$transactionlog_details_buyer['amount']= $google_checkout_detail['item_unit-price'];
                        $transactionlog_details_buyer['amount_type'] = DEBIT;
			$transactionlog_details_buyer['payment_type'] ='Google checkout';
			$transactionlog_details_buyer['quantity'] = $quantity;
			
			$transactionlog_details_buyer['shippingamount'] =$shippingfee;
			$transactionlog_details_buyer['description']=$buyer_desc;
			
			$this->gc->addbuynowtransactionlog_details($transactionlog_details_buyer);
			$this->gc->order_delete($google_checkout_detail['item_id'],$google_checkout_detail['buyer_id']);
			
			$fieldvalues['id']=$productid;
			$fieldvalues['unitprice']=$productcost;
			$fieldvalues['quantity']=$quantity;			
			$sfee+=$shippingfee;
			$auctionproductdetails[]=$fieldvalues;
			
			
					}
					
					
			$orderresponse = array('order_id' => $google_checkout_detail['gc_orderno'],'user_id' => $google_checkout_detail['buyer_id'],'currency'=>$google_checkout_detail['order_currency'],'product_unique_details' => $auctionproductdetails,'price' => $google_checkout_details[0]['order_total'],'shipping' => $sfee);
			Buynow::BuynowOrdermail($orderresponse); 		
			
					
					
				}		 
				 }
				
				
				break;
			case "order-state-change-notification":
				$datas = array('fulfillment_orderstate' => $response['new-fulfillment-order-state'],
					       'financial_orderstate' => $response['new-financial-order-state']);
				$update = $this->commonmodel->update(GC_TRANSACTIONS,$datas,'gc_orderno',$response['google-order-number']); 
				$gc = $this->gc->selectMultipleGCTransaction($response['google-order-number']); 
				if(count($gc)>0)
				{
					//if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="REVIEWING")
					if($datas['fulfillment_orderstate']=="NEW" && $datas['financial_orderstate']=="CHARGED")
					{
						
			$cdata = unserialize($response['shopping-cart_merchant-private-data']);
					
					
					$google_checkout_details =$this->gc->selectMultipleGCTransaction($response['google-order-number']);
					
					$auctionproductdetails=array();
					
					if(count($google_checkout_details)>0){	
					
					$sfee=0;
					foreach($google_checkout_details as $google_checkout_detail){
								
						$transactionfield['PAYERID'] =$google_checkout_detail['gc_buyerid'];
						$transactionfield['PAYERSTATUS'] = 'C';
						$transactionfield['PRODUCTID'] = $google_checkout_detail['item_id'];
						$transactionfield['USERID'] = $google_checkout_detail['buyer_id'];
						$transactionfields['TRANSACTIONID']=$google_checkout_detail['gc_orderno'];
						$transactionfields['TRANSACTIONTYPE']='Google Checkout';
						$transactionfields['PAYMENTTYPE']=$this->code;
						$transactionfield['AMT']= $google_checkout_detail['item_unit-price'];
						$transactionfield['SHIPPINGAMT']=$google_checkout_detail['shipping_amount'];
						$transactionfields['CURRENCYCODE']=$google_checkout_detail['order_currency'];
						$transactionfield['LOGIN_ID'] = Request::$client_ip;
						$transactionfield['USER_AGENT'] = Request::$user_agent;
						
						 $this->gc->addbuynowtransaction_details($transactionfield);
				 
						$last_transaction_insert_id = $this->gc->get_last_transaction_id();
						$max_date_complete_db_format = "";			
						$orderfields = array(
						'order_no' => $google_checkout_detail['gc_orderno'],                       
						'product_id' => $google_checkout_detail['item_id'],
						'buyer_id' => $google_checkout_detail['buyer_id'],
					  
						'order_status' => SUCCESS_PAYMENT_ORDER_STATUS,
						'action' => SUCCESS_PAYMENT_ORDER_ACTION,
						'product_cost' => $google_checkout_detail['item_unit-price'],
						'quantity' => $google_checkout_detail['item_quantity'],
						'shippingfee' => $google_checkout_detail['shipping_amount'],
						'product_commission_amount' => "",
						'order_total' => ($google_checkout_detail['item_unit-price']*$google_checkout_detail['item_quantity'])+$google_checkout_detail['shipping_amount'],
						'order_subtotal' => 0.00,
						'order_currency_code' => $google_checkout_detail['order_currency'],
						'paid_status' => PAID_PENDING, 
						'maximum_date_complete' => $max_date_complete_db_format,
						'transaction_details_id' => $last_transaction_insert_id  
						);
				 
						$this->gc->addbuynoworder_details($orderfields);
			
			
						$quantity=$google_checkout_detail['item_quantity'];
						$productcost=$google_checkout_detail['item_unit-price'];
						$productid=$google_checkout_detail['item_id'];
						
						$shippingfee=$google_checkout_detail['shipping_amount'];
						
						$shippingfee=($shippingfee!='')?$shippingfee:0;
						$totalamount=($productcost*$quantity)+$shippingfee;
			
			
						$product_name=$google_checkout_detail['item_item-name'];
						$total_amount=$this->site_currency." ".Commonfunction::numberformat($totalamount);
						$shipping_fee=$this->site_currency." ".Commonfunction::numberformat($shippingfee);
						$product_cost=$this->site_currency." ".Commonfunction::numberformat($productcost);
						$order_no=$google_checkout_detail['gc_orderno'];
				$buyer_name =$this->gc->get_username($google_checkout_detail['buyer_id']);		
		
			
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
			
		     //  $transactionlog_details_buyer['site_currency'] =  $google_checkout_detail['order_currency'];
                        $transactionlog_details_buyer['userid'] =  $google_checkout_detail['buyer_id'];
                        $transactionlog_details_buyer['orderid'] = $google_checkout_detail['gc_orderno'];
                        $transactionlog_details_buyer['productid'] = $google_checkout_detail['item_id'];
                     
			$transactionlog_details_buyer['amount']= $google_checkout_detail['item_unit-price'];
                        $transactionlog_details_buyer['amount_type'] = DEBIT;
			$transactionlog_details_buyer['payment_type'] ='Google checkout';
			$transactionlog_details_buyer['quantity'] = $quantity;
			
			$transactionlog_details_buyer['shippingamount'] =$shippingfee;
			$transactionlog_details_buyer['description']=$buyer_desc;
			
			$this->gc->addbuynowtransactionlog_details($transactionlog_details_buyer);
			$this->gc->order_delete($google_checkout_detail['item_id'],$google_checkout_detail['buyer_id']);
			
			$fieldvalues['id']=$productid;
			$fieldvalues['unitprice']=$productcost;
			$fieldvalues['quantity']=$quantity;			
			$sfee+=$shippingfee;
			$auctionproductdetails[]=$fieldvalues;
			
			
					}
					
			$orderresponse = array('order_id' => $google_checkout_detail['gc_orderno'],'user_id' => $google_checkout_detail['buyer_id'],'currency'=>$google_checkout_detail['order_currency'],'product_unique_details' => $auctionproductdetails,'price' => $google_checkout_details[0]['order_total'],'shipping' => $sfee);
			Buynow::BuynowOrdermail($orderresponse); 		
					
			
			$this->request->redirect('site/buynow/products_transactions');
			Message::success(__('gcheckout_payment_success'));			
					
				}			
					  
					}	
				}
				 
				break;
			
		}
		
	}
	
	/*** Added By Venkatraja in 7-Mar-2013 ***/
	
	
	
	
	
	protected function processpackageorder($response)
	{ 
		switch($response['_type'])
		{
			case "new-order-notification": 
				$datas = array('buyer_email' => $response['buyer-billing-address_email'],
					       'buyer_name' => $response['buyer-billing-address_contact-name'],  
					       'gc_orderno' => $response['google-order-number'],
					       'gc_timestamp' => $response['timestamp'],
					       'serial_number' => $response['serial-number'],
					       'billingaddress' => $this->getBuyerAddress($response),
					       'shippingaddress' => $this->getBuyerAddress($response),
					       'order_total' => $response['order-total'],
					       'order_currency' => $response['order-total_currency'],
					       'fulfillment_orderstate' => $response['fulfillment-order-state'],
					       'financial_orderstate' => $response['financial-order-state'],
					       'gc_buyerid' => $response['buyer-id'],
					       'custom_data' => $response['shopping-cart_merchant-private-data'],  
					       );
				$gcdata = $this->gc->selectGCTransaction($response['google-order-number']);
				if( $gcdata!="")
				{
					$id = $gcdata['order_id'];
				}
				else{
					$insert = $this->gc->insertGCresponse($datas);
					$id = $insert[0];
				}
				 if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="CHARGED")
				 {
					$cdata = unserialize($response['shopping-cart_merchant-private-data']);
					$pid =0;
					if(count($cdata['pids'])>0)
					{
						$pid = $cdata['pids'][0];
					}
					$trans_details=array('userid'=>$cdata['userid'],'orderid'=>$response['google-order-number'],
										'packageid'=>$pid,'amount'=>$datas['order_total'],'amount_type'=>'C','transaction_type' =>'Google Checkout');
					       $this->gc->authTransactionDetails($trans_details);
					$packorder = array('order_no' => $response['google-order-number'],
								'payment_method' => $this->code,
								'package_id'=> $pid,
								'buyer_id' => $cdata['userid'],
								'order_status' => 'CMP',
								'order_total' => $datas['order_total'],
								'order_currency_code' => $datas['order_currency'],
								'package_amount' => $datas['order_total'],
								'paid_status' =>'PND',
								'transaction_details_id' =>$id);
						if($this->gc->packageordercount($response['google-order-number'])==0){
											$user_current_amount=$this->gc->get_user_account($cdata['userid']);
									       		$total_amount=$user_current_amount+$datas['order_total'];
											$credit_account_touser=$this->gc->update_useraccount($cdata['userid'],$total_amount);
						}
					$insertpackgageorder = $this->gc->authOrderDetails($packorder); 

						 
				 }
				
				break;
			case "order-state-change-notification":
				$datas = array('fulfillment_orderstate' => $response['new-fulfillment-order-state'],
					       'financial_orderstate' => $response['new-financial-order-state']);
				$update = $this->commonmodel->update(GC_TRANSACTIONS,$datas,'gc_orderno',$response['google-order-number']); 
				$gc = $this->gc->selectGCTransaction($response['google-order-number']); 
				if($gc!="")
				{
					if($datas['fulfillment_orderstate']=="NEW" && $datas['financial_orderstate']=="CHARGED")
					{
						
					       $cdata = unserialize($gc['custom_data']);
					       $pid =0;
					       if(count($cdata['pids'])>0)
					       {
						       $pid = $cdata['pids'][0];
					       }
					       $trans_details=array('userid'=>$cdata['userid'],'orderid'=>$response['google-order-number'],
										'packageid'=>$pid,'amount'=>$gc['order_total'],'amount_type'=>'C','transaction_type' =>'Google Checkout');
					       $this->gc->authTransactionDetails($trans_details);
					       $packorder = array('order_no' => $response['google-order-number'],
								       'payment_method' => $this->code,
								       'package_id'=> $pid,
								       'buyer_id' => $cdata['userid'],
								       'order_status' => 'CMP',
								       'order_total' => $gc['order_total'],
								       'order_currency_code' => $gc['order_currency'],
								       'package_amount' => $gc['order_total'],
								       'paid_status' =>'PND',
								       'transaction_details_id' =>$gc['order_id']); 
						if($this->gc->packageordercount($response['google-order-number'])==0){
											$user_current_amount=$this->gc->get_user_account($cdata['userid']);
									       		$total_amount=$user_current_amount+$gc['order_total'];
											$credit_account_touser=$this->gc->update_useraccount($cdata['userid'],$total_amount);
						}
						$insertpackgageorder = $this->gc->authOrderDetails($packorder); 
						$user_current_amount=$this->gc->get_user_account($cdata['userid']);
				       		$total_amount=$user_current_amount+$gc['order_total'];
						$credit_account_touser=$this->gc->update_useraccount($cdata['userid'],$total_amount);
						 
					}	
				}
				 
				break;
			
		}
		
	}
	
	protected function processreserveauctionorder($response)
	{
		//For Reserve Product order
		switch($response['_type'])
		{
			case "new-order-notification":
				
				$datas = array('buyer_email' => $response['buyer-billing-address_email'],
					       'buyer_name' => $response['buyer-billing-address_contact-name'],  
					       'gc_orderno' => $response['google-order-number'],
					       'gc_timestamp' => $response['timestamp'],
					       'serial_number' => $response['serial-number'],
					       'billingaddress' => $this->getBuyerAddress($response),
					       'shippingaddress' => $this->getBuyerAddress($response),
					       'order_total' => $response['order-total'],
					       'order_currency' => $response['order-total_currency'],
					       'fulfillment_orderstate' => $response['fulfillment-order-state'],
					       'financial_orderstate' => $response['financial-order-state'],
					       'gc_buyerid' => $response['buyer-id'],
					       'custom_data' => $response['shopping-cart_merchant-private-data'],  
					       );
				$gcdata = $this->gc->selectGCTransaction($response['google-order-number']);
				
				
				if( $gcdata!="")
				{
					$id = $gcdata['order_id'];
				}
				else{
					$insert = $this->gc->insertGCresponse($datas);
					$id = $insert[0];
				}
				 if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="CHARGED")
				 {
					
					//Process the order here
					$cdata = unserialize($response['shopping-cart_merchant-private-data']);
					$pid =0;
					if(count($cdata['pids'])>0)
					{
						$pid = $cdata['pids'][0];
					}
					$trans_details=array('userid'=>$cdata['userid'],'orderid'=>$response['google-order-number'],
										'packageid'=>$pid,'amount'=>$datas['order_total'],
										'type'=>'PR',
										'amount_type'=>'C','transaction_type' =>'Google Checkout','description' =>'You have bought '.$this->gc->getProductName($pid).' for Reserve auction of price "'.$gc["order_currency"].$gc["order_total"].'"');
					$this->gc->authTransactionDetails($trans_details);
					$packorder = array('res_order' => $response['google-order-number'],
								'payment_type' => $this->code,
								'auction_id'=> $pid,
								'buyer_id' => $cdata['userid'], 
								'order_status' => 'C',
								'bidmethod' => 'reserve',
								'total' => $datas['order_total'],
								'currency_code' => $datas['order_currency']); 
					$insertpackgageorder = $this->gc->auctionOrderDetails($packorder); 
					 $orderresponse = array('order_id' => $response['google-order-number'],'user_id' => $cdata['userid'],'currency'=>$datas['order_currency'],'product_id' => $pid,'price' => $datas['order_total']);
					Commonfunction::AuctionOrdermail($orderresponse); 
						 
				 }
				
				break;
			case "order-state-change-notification":
				
				$datas = array('fulfillment_orderstate' => $response['new-fulfillment-order-state'],
					       'financial_orderstate' => $response['new-financial-order-state']);
				$update = $this->commonmodel->update(GC_TRANSACTIONS,$datas,'gc_orderno',$response['google-order-number']); 
				$gc = $this->gc->selectGCTransaction($response['google-order-number']); 
				if($gc!="")
				{
					if($datas['fulfillment_orderstate']=="NEW" && $datas['financial_orderstate']=="PAYMENT_DECLINED")
					{
						
					       $cdata = unserialize($gc['custom_data']);
					       $pid =0;
					       if(count($cdata['pids'])>0)
					       {
						       $pid = $cdata['pids'][0];
					       }
					       $trans_details=array('userid'=>$cdata['userid'],'orderid'=>$response['google-order-number'],
										'packageid'=>$pid,'amount'=>$gc['order_total'],
										'amount_type'=>'C','transaction_type' =>'Google Checkout',
										'type'=>'PR',
										'description' =>'You have bought '.$this->gc->getProductName($pid).' of price "'.$gc["order_currency"].$gc["order_total"].'"');
					       $this->gc->authTransactionDetails($trans_details);
					       $packorder = array('res_order' => $response['google-order-number'],
								'payment_type' => $this->code,
								'auction_id'=> $pid,
								'buyer_id' => $cdata['userid'], 
								'order_status' => 'C',
								'bidmethod' => 'reserve',
								'total' => $gc['order_total'],
								'currency_code' => $gc['order_currency']); 
					       $insertpackgageorder = $this->gc->auctionOrderDetails($packorder);
					       $orderresponse = array('order_id' => $response['google-order-number'],'user_id' => $cdata['userid'],'currency'=>$gc['order_currency'],'product_id' => $pid,'price' => $gc['order_total']);
						Commonfunction::AuctionOrdermail($orderresponse); 
					}	
				}
				 
				break;
			
		}
	}
	
	
	protected function processclockauctionorder($response)
	{
		//For Clock Product order
		switch($response['_type'])
		{
			case "new-order-notification":
				
				$datas = array('buyer_email' => $response['buyer-billing-address_email'],
					       'buyer_name' => $response['buyer-billing-address_contact-name'],  
					       'gc_orderno' => $response['google-order-number'],
					       'gc_timestamp' => $response['timestamp'],
					       'serial_number' => $response['serial-number'],
					       'billingaddress' => $this->getBuyerAddress($response),
					       'shippingaddress' => $this->getBuyerAddress($response),
					       'order_total' => $response['order-total'],
					       'order_currency' => $response['order-total_currency'],
					       'fulfillment_orderstate' => $response['fulfillment-order-state'],
					       'financial_orderstate' => $response['financial-order-state'],
					       'gc_buyerid' => $response['buyer-id'],
					       'custom_data' => $response['shopping-cart_merchant-private-data'],  
					       );
				$gcdata = $this->gc->selectGCTransaction($response['google-order-number']);
				
				
				if( $gcdata!="")
				{
					$id = $gcdata['order_id'];
				}
				else{
					$insert = $this->gc->insertGCresponse($datas);
					$id = $insert[0];
				}
				 if($response['fulfillment-order-state']=="NEW" && $response['financial-order-state']=="CHARGED")
				 {
					
					//Process the order here
					$cdata = unserialize($response['shopping-cart_merchant-private-data']);
					$pid =0;
					if(count($cdata['pids'])>0)
					{
						$pid = $cdata['pids'][0];
					}
					$trans_details=array('userid'=>$cdata['userid'],'orderid'=>$response['google-order-number'],
										'packageid'=>$pid,'amount'=>$datas['order_total'],
										'type'=>'PR',
										'amount_type'=>'C','transaction_type' =>'Google Checkout','description' =>'You have bought '.$this->gc->getProductName($pid).' for Clock auction of price "'.$gc["order_currency"].$gc["order_total"].'"');
					$this->gc->authTransactionDetails($trans_details);
					$packorder = array('res_order' => $response['google-order-number'],
								'payment_type' => $this->code,
								'auction_id'=> $pid,
								'buyer_id' => $cdata['userid'], 
								'order_status' => 'C',
								'bidmethod' => 'clock',
								'total' => $datas['order_total'],
								'currency_code' => $datas['order_currency']); 
					$insertpackgageorder = $this->gc->auctionOrderDetails($packorder); 
					 $orderresponse = array('order_id' => $response['google-order-number'],'user_id' => $cdata['userid'],'currency'=>$datas['order_currency'],'product_id' => $pid,'price' => $datas['order_total']);
					Commonfunction::AuctionOrdermail($orderresponse); 
						 
				 }
				
				break;
			case "order-state-change-notification":
				
				$datas = array('fulfillment_orderstate' => $response['new-fulfillment-order-state'],
					       'financial_orderstate' => $response['new-financial-order-state']);
				$update = $this->commonmodel->update(GC_TRANSACTIONS,$datas,'gc_orderno',$response['google-order-number']); 
				$gc = $this->gc->selectGCTransaction($response['google-order-number']); 
				if($gc!="")
				{
					if($datas['fulfillment_orderstate']=="NEW" && $datas['financial_orderstate']=="PAYMENT_DECLINED")
					{
						
					       $cdata = unserialize($gc['custom_data']);
					       $pid =0;
					       if(count($cdata['pids'])>0)
					       {
						       $pid = $cdata['pids'][0];
					       }
					       $trans_details=array('userid'=>$cdata['userid'],'orderid'=>$response['google-order-number'],
										'packageid'=>$pid,'amount'=>$gc['order_total'],
										'amount_type'=>'C','transaction_type' =>'Google Checkout',
										'type'=>'PR',
										'description' =>'You have bought '.$this->gc->getProductName($pid).' of price "'.$gc["order_currency"].$gc["order_total"].'"');
					       $this->gc->authTransactionDetails($trans_details);
					       $packorder = array('res_order' => $response['google-order-number'],
								'payment_type' => $this->code,
								'auction_id'=> $pid,
								'buyer_id' => $cdata['userid'], 
								'order_status' => 'C',
								'bidmethod' => 'clock',
								'total' => $gc['order_total'],
								'currency_code' => $gc['order_currency']); 
					       $insertpackgageorder = $this->gc->auctionOrderDetails($packorder);
					       $orderresponse = array('order_id' => $response['google-order-number'],'user_id' => $cdata['userid'],'currency'=>$gc['order_currency'],'product_id' => $pid,'price' => $gc['order_total']);
					       
						Commonfunction::AuctionOrdermail($orderresponse); 
					}	
				}
				 
				break;
			
		}
	}
	
	protected function getBuyerAddress($response)
	{
		$buyeraddress= "";
		if(isset($response['buyer-billing-address_company-name']) && $response['buyer-billing-address_company-name']!="")
		{
			$buyeraddress .=$response['buyer-billing-address_address1']."\r\n";
		}
		if(isset($response['buyer-billing-address_address1']) && $response['buyer-billing-address_address1']!="")
		{
			$buyeraddress .=$response['buyer-billing-address_address1']."\r\n";
		}
		if(isset($response['buyer-billing-address_address2']) && $response['buyer-billing-address_address2']!="")
		{
			$buyeraddress .=$response['buyer-billing-address_address2']."\r\n";
		}
		if(isset($response['buyer-billing-address_region']) && $response['buyer-billing-address_region']!="")
		{
			$buyeraddress .=$response['buyer-billing-address_region'].", ";
		}
		if(isset($response['buyer-billing-address_city']) && $response['buyer-billing-address_city']!="")
		{
			$buyeraddress .=$response['buyer-billing-address_city']."\r\n";
		}
		if(isset($response['buyer-billing-address_country-code']) && $response['buyer-billing-address_country-code']!="")
		{
			$buyeraddress .=$response['buyer-billing-address_country-code']." - ";
		}
		if(isset($response['buyer-billing-address_postal-code']) && $response['buyer-billing-address_postal-code']!="")
		{
			$buyeraddress .=$response['buyer-billing-address_postal-code']."\r\n";
		}
		if(isset($response['buyer-billing-address_phone']) && $response['buyer-billing-address_phone']!="")
		{
			$buyeraddress .= "PH NO: ".$response['buyer-billing-address_phone']."\r\n";
		}
		if(isset($response['buyer-billing-address_fax']) && $response['buyer-billing-address_fax']!="")
		{
			$buyeraddress .= "Fax: ".$response['buyer-billing-address_fax'];
		}
		return $buyeraddress;
	}
}//End of users controller class
?>
