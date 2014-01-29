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

class Controller_Ccavenue extends Controller_Website {	

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
		
	//protected $_buynow;	
	public function __construct(Request $request, Response $response)
	{
		//$this->_ccavenue = new Ccavenue;
		parent::__construct($request,$response);

		$this->ccavenue=Model::factory('ccavenue');
		
		
		
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
	
	/*  ccavenue Payment Gateway Process & Form validation -Dec21,2012 */
	public function action_ccavenue_payment(){
		$this->is_login(); 
		$userid = $this->session->get('auction_userid');
		$validator=array();
		$error=array();
		$package_id=$this->request->param('id');
		$package_details= $this->ccavenue->getpackageDetails($package_id);
		$pack_price=$package_details[0]['price'];
		$pack_name=$package_details[0]['name'];
		
		
		
		/*Payment GateWay Details*/
		//$pgid=$this->request->param('pgid');
		$pgid=4;  //Here Payment Gateway Id
		$paymentgateway_details=$this->ccavenue->getpaymentgatewayDetails($pgid);
		$currency_code=$paymentgateway_details['currency_code'];
		
		$Merchant_Id = "M_mypocket_13956" ;//This id(also User Id)  available at "Generate Working Key" of "Settings & Options"
		$Redirect_Url = URL_BASE."ccavenue/ccavenue_payment_result" ;//your redirect URL where your customer will be redirected after authorisation from CCAvenue
		$Order_Id = $_SESSION['auction_userid'].'-'.date('Ymdhis') ;//your script should substitute the order description in the quotes provided here
		$WorkingKey = "c0aemnfjcifqimarvd"  ;//put in the 32 bit alphanumeric key in the quotes provided here.Please note that get this key ,login to your CCAvenue merchant acc
		$delivery_cust_notes="SUB-MERCHANT TEST";
		$paymentType = "ccavenue";
		$Checksum = rand(1000000,9999999);
		$user_details= $this->ccavenue->getuserDetails($this->session->get('auction_userid'));
		$billing_cust_name=$this->session->get('auction_username');
		//echo "<pre>";		print_r($_SESSION);		print_r($user_details); echo "</pre>";exit;
		$billing_cust_address = $user_details["address"];
		$billing_cust_state = '';
		$billing_cust_country = $user_details["country"];
		$billing_cust_tel=$user_details['phoneno'];
		$billing_cust_email = $this->session->get('auction_email');
		$delivery_cust_name = $this->session->get('auction_username');
		$delivery_cust_address= $user_details["address"];
		$delivery_cust_state = '';
		$delivery_cust_country = $user_details["country"];
		$delivery_cust_tel =$user_details['phoneno'];
		$pay_mod_id = 4;
		$REFERRAL_AMOUNT = "";
		$Merchant_Param = '';	
		$billing_city = $user_details["city"];
		$billing_zip = $user_details["zipcode"];
		$delivery_city = $user_details["city"];
		$delivery_zip = $user_details["zipcode"];
		$lastName = '';
		
		$view=View::factory('ccavenue/'.THEME_FOLDER.'ccavenue_payment')
							->bind('Merchant_Id',$Merchant_Id)
							->bind('Amount',$pack_price)
							->bind('Order_Id',$Order_Id)
							->bind('Redirect_Url',$Redirect_Url)
							->bind('Checksum',$Checksum)
							->bind('billing_cust_name',$billing_cust_name)
							->bind('billing_cust_address',$billing_cust_address)
							->bind('billing_cust_country',$billing_cust_country)
							->bind('billing_cust_state',$billing_cust_state)
							->bind('billing_zip',$billing_zip)
							->bind('billing_cust_tel',$billing_cust_tel)
							->bind('billing_cust_email',$billing_cust_email)
							->bind('delivery_cust_name',$delivery_cust_name)
							->bind('delivery_cust_address',$delivery_cust_address)
							->bind('delivery_cust_country',$delivery_cust_country)
							->bind('delivery_cust_state',$delivery_cust_state)
							->bind('delivery_cust_tel',$delivery_cust_tel)
							->bind('delivery_cust_notes',$delivery_cust_notes)
							->bind('Merchant_Param',$Merchant_Param)
							->bind('billing_city',$billing_city)
							->bind('delivery_city',$delivery_city)
							->bind('delivery_zip',$delivery_city)
							->bind('validator',$validator)
							->bind('error',$error);
		$this->template->content=$view;
		$this->template->title=__('ccavenue_title');
		$this->template->meta_description=__('ccavenue_desc');
		$this->template->meta_keywords=__('ccavenue_key');
	}
	
	/*  CCavenue Payment Final Status result */ 
	public function action_ccavenue_payment_result(){
		
		echo "dfdf"; exit;
		
		
		
		
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
			//$product_id = Arr::get($_GET,'id');
			if(!isset($product_id)){                                 
			$this->request->redirect('/');                             
                	}
			//print_r($product_id);exit;
			/**To get product amount for the received product id**/
			//$product_amount= $this->buynow->get_received_buyamount_offline($product_id);
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

	//check out page
	/*public function action_myaddresses()
	{
		$this->is_login();
		$request=$this->request->param('id');
		$request2=$this->request->param('method');
		$userid=!$this->auction_userid;	
		$transactions=$this->buynow->all_addtocart_list($this->auction_userid);
		
		$amt=Commonfunction::get_user_balance($this->auction_userid);
		$select_address=$this->commonmodel->select_with_onecondition(SHIPPING_ADDRESS,"userid=".$this->auction_userid,TRUE);
		$select_billingaddress=$this->commonmodel->select_with_onecondition(BILLING_ADDRESS,"userid=".$this->auction_userid,TRUE);
		switch($request)
		{
			//When shipping
			case "shipping":				
				switch($request2)
				{
					
					case "add":
					
						if($select_address>0){$this->url->redirect("site/buynow/myaddresses/shipping/edit");}
						$view=View::factory('buynow/'.THEME_FOLDER.'addshippingaddress')	
									->bind('db_values_shipping',$form_values)
									
									->bind('errors',$error);
						$form_values=Arr::extract($_POST,array('name','address1','address2','town','city','country','zipcode','phone'));
						$validate=$this->buynow->shipping_validation($form_values);
						$submit=$this->request->post('addaddress');
						if(isset($submit))
						{
							if($validate->check())
							{

								$address=($form_values['address2']!=__('enter_address2'))?$form_values['address1']." + ".$form_values['address2']:$form_values['address1'];

								$town=($form_values['town']!=__('enter_town'))?$form_values['town']:"";
								$phone=($form_values['phone']!=__('enter_phone'))?$form_values['phone']:"";
								//update query from commonfunction in model folder
								$insert=$this->commonmodel->insert(SHIPPING_ADDRESS,array('userid' => $this->auction_userid,
										'name' =>$form_values['name'],
										'address' => Html::chars($address),
										'city' => $form_values['city'],
										'country' => $form_values['country'],
										'town' => $town,
										'zipcode' => $form_values['zipcode'],
										'phoneno' => $phone,
										'createddate' => $this->getCurrentTimeStamp));
								if($insert)
								{
									$form_values=NULL;
									Message::success(__('shipping_added_successfully'));	
									$this->url->redirect("site/buynow/myaddresses");
								}
							}
							else
							{
								$error=$validate->errors('errors');
							}
						}				
						break;

					//When edit
					case "edit";
						if($select_address<=0){$this->url->redirect("site/buynow/myaddresses/shipping/add");}
						$view=View::factory('buynow/'.THEME_FOLDER.'editshippingaddress')	
									->bind('db_values_shipping',$form_values)
									->bind('errors',$error)
									->bind('transactions',$transactions)
									->bind('db_values',$db_values);
						$form_values=Arr::extract($_POST,array('name','address1','address2','town','city','country','zipcode','phone'));
						$validate=$this->buynow->shipping_validation($form_values);
						$submit=$this->request->post('editaddress');
						$db_values=$this->commonmodel->select_with_onecondition(SHIPPING_ADDRESS,"userid=".$this->auction_userid)->as_array();
			
						if(isset($submit))
						{
							if($validate->check())
							{
								$address=($form_values['address2']!=__('enter_address2'))?$form_values['address1']." + ".$form_values['address2']:$form_values['address1'];

								$town=($form_values['town']!=__('enter_town'))?$form_values['town']:"";
								$phone=($form_values['phone']!=__('enter_phone'))?$form_values['phone']:"";
							

								//update query from commonfunction in model folder
								$insert=$this->commonmodel->update(SHIPPING_ADDRESS,array('userid' => $this->auction_userid,
												'name' =>$form_values['name'],
												'address' => Html::chars($address),
												'city' => $form_values['city'],
												'country' => $form_values['country'],
												'town' => $town,
												'zipcode' => $form_values['zipcode'],
												'phoneno' => $phone,
												'updatedate' => $this->getCurrentTimeStamp),'userid',$this->auction_userid);
								if($insert)
								{
									$form_values=NULL;
									Message::success(__('shipping_edit_successfully'));
									$this->url->redirect("site/buynow/myaddresses");
								}
							}
							else
							{
								$error=$validate->errors('errors');
							}
						}
						break;

					//Default view to be myaddresses
					default:
						$view=View::factory('buynow/'.THEME_FOLDER.'addresses')
								->bind('select_shipping_address',$select_shipping_address)
								->bind('count_shipping',$count_shipping)
								->bind('select_billing_address',$select_billing_address)
							  ->bind('transactions',$transactions)
								->bind('count_billing',$count_billing);
						$userid=$this->auction_userid;
						$select_shipping_address=$this->buynow->select_shipping_address($userid);
						$count_shipping=$this->buynow->select_shipping_address($userid,TRUE);
						$select_billing_address=$this->buynow->select_billing_address($userid);
						$count_billing=$this->buynow->select_billing_address($userid,TRUE);
						break;
				}
				break;

			//When billing
			case "billing":
				switch($request2)
				{
					case "add":
						if($select_billingaddress>0){$this->url->redirect("site/buynow/myaddresses/billing/edit");}
						$view=View::factory('buynow/'.THEME_FOLDER.'addbillingaddress')	
									->bind('form_values',$form_values)	
->bind('transactions',$transactions)			
									->bind('errors',$error);
						$form_values=Arr::extract($_POST,array('name','address1','address2','town','city','country','zipcode','phone'));
						$validate=$this->buynow->shipping_validation($form_values);
						$submit=$this->request->post('addaddress');
						if(isset($submit))
						{
							if($validate->check())
							{
								$address=($form_values['address2']!=__('enter_address2'))?$form_values['address1']." + ".$form_values['address2']:$form_values['address1'];

								$town=($form_values['town']!=__('enter_town'))?$form_values['town']:"";
								$phone=($form_values['phone']!=__('enter_phone'))?$form_values['phone']:"";
								//update query from commonfunction in model folder
								$insert=$this->commonmodel->insert(BILLING_ADDRESS,array('userid' => $this->auction_userid,
										'name' =>$form_values['name'],
										'address' => Html::chars($address),
										'city' => $form_values['city'],
										'country' => $form_values['country'],
										'town' => $town,
										'zipcode' => $form_values['zipcode'],
										'phoneno' => $phone,
										'createddate' => $this->getCurrentTimeStamp));
								if($insert)
								{
									$form_values=NULL;
									Message::success(__('billing_added_successfully'));
									$this->url->redirect("site/buynow/myaddresses");
								}
							}
							else
							{
								$error=$validate->errors('errors');
							}
						}				
						break;

					//When edit
					case "edit";
						if($select_billingaddress<=0){$this->url->redirect("site/buynow/myaddresses/billing/add");}
						$view=View::factory('buynow/'.THEME_FOLDER.'editbillingaddress')	
									->bind('form_values',$form_values)
									->bind('errors',$error)
									->bind('transactions',$transactions)
									->bind('db_values',$db_values);
						$form_values=Arr::extract($_POST,array('name','address1','address2','town','city','country','zipcode','phone'));
						$validate=$this->buynow->shipping_validation($form_values);
						$submit=$this->request->post('editaddress');
						$db_values=$this->commonmodel->select_with_onecondition(BILLING_ADDRESS,"userid=".$this->auction_userid)->as_array();
			
						if(isset($submit))
						{
							if($validate->check())
							{
								$address=($form_values['address2']!=__('enter_address2'))?$form_values['address1']." + ".$form_values['address2']:$form_values['address1'];

								$town=($form_values['town']!=__('enter_town'))?$form_values['town']:"";
								$phone=($form_values['phone']!=__('enter_phone'))?$form_values['phone']:"";

								//update query from commonfunction in model folder
								$insert=$this->commonmodel->update(BILLING_ADDRESS,array('userid' => $this->auction_userid,
												'name' =>$form_values['name'],
												'address' =>Html::chars($address),
												'city' => $form_values['city'],
												'country' => $form_values['country'],
												'town' => $town,
												'zipcode' => $form_values['zipcode'],
												'phoneno' => $phone,
												'updatedate' => $this->getCurrentTimeStamp),'userid',$this->auction_userid);
								if($insert)
								{
									$form_values=NULL;
									Message::success(__('billing_edit_successfully'));
									$this->url->redirect("site/buynow/myaddresses");
								}
							}
							else
							{
								$error=$validate->errors('errors');
							}
						}
						break;

					//Default view to be myaddresses
					default:
						$view=View::factory('buynow/'.THEME_FOLDER.'addresses')
								->bind('select_shipping_address',$select_shipping_address)
								->bind('count_shipping',$count_shipping)
								->bind('select_billing_address',$select_billing_address)
								->bind('transactions',$transactions)
								->bind('errors',$error)	
							     ->bind('db_values_shipping',$form_values)	
								->bind('count_billing',$count_billing);
						$userid=$this->auction_userid;
						$select_shipping_address=$this->buynow->select_shipping_address($userid);
						$count_shipping=$this->buynow->select_shipping_address($userid,TRUE);
						$select_billing_address=$this->buynow->select_billing_address($userid);
						$count_billing=$this->buynow->select_billing_address($userid,TRUE);	
						break;
				}
				break;

			//Default view to be myaddresses
			default:
				$view=View::factory('buynow/'.THEME_FOLDER.'addresses')
								->bind('select_shipping_address',$select_shipping_address)
								->bind('count_shipping',$count_shipping)
								->bind('select_billing_address',$select_billing_address)
								->bind('transactions',$transactions)
								->bind('useramount',$amt)
								->bind('errors',$error)
								->bind('db_values',$db_values)
								->bind('db_values_shipping',$form_values)
								->bind('form_values',$form_values)
								->bind('count_billing',$count_billing);
						$userid=$this->auction_userid;
						$select_shipping_address=$this->buynow->select_shipping_address($userid);
						$count_shipping=$this->buynow->select_shipping_address($userid,TRUE);	
						$select_billing_address=$this->buynow->select_billing_address($userid);
						$count_billing=$this->buynow->select_billing_address($userid,TRUE);	
				break;
			
		}
		
		$this->template->content = $view;
                $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}*/

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
					//print_r($db_values_shipping);exit;	
					//print_r($db_values);exit;	
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
