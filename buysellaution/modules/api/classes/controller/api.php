<?php defined("SYSPATH") or die("No direct script access.");
/**
* Contains Api controller actions

* @Created on October 15, 2013

* @Updated on October 15, 2013

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Api extends Controller_Website{

		/*
		 * 
		 * name: __construct()
		 * @param
		 * @return
		 * 
		 */
		public function __construct(Request $request,Response $response)
		{			
			parent::__construct($request,$response);
			$this->api = Model::factory('api');			
			$this->getCurrentTimeStamp=Api::getCurrentTimeStamp();
		}
		
		/***Index()*****/		
		public function action_index()
		{ 
			echo "Page not Found";exit;
		}
		
		/*****Users Register**********/		
		public function action_signup()
		{				 
				$activation_key = $this->api->random_user_password_generator();
				$user_settings=$this->api->get_user_settings();				 
				 
				$form_values=arr::extract($_POST, array('username','email','password','repassword','firstname','lastname'));
				 
				$validate=$this->api->signup_validation($form_values);
				
				if($_POST)
				{
					if($validate->check())
					{
						$valid_username=$this->api->alpha_dash_checks($_POST['username']);						
						if($valid_username !=1){
							$response = array("response" => array("httpCode" => 401 , "Message" => "Invalid Username.!" ));
								echo json_encode($response);
								exit;						
						}
						$unique_username_check=$this->api->unique_username($_POST['username']);						
						if($unique_username_check !=1){
							$response = array("response" => array("httpCode" => 401 , "Message" => "Username already exists.!" ));
								echo json_encode($response);
								exit;						
						}						
						$validate_email=$this->api->email_format_check($_POST['email']);
						if($validate_email !=1){
							$response = array("response" => array("httpCode" => 401 , "Message" => "Invalid email format.!" ));
								echo json_encode($response);
								exit;						
						}
						$unique_email_check=$this->api->unique_email($_POST['email']);						
						if($unique_email_check !=1){
							$response = array("response" => array("httpCode" => 401 , "Message" => "Email already exists.!" ));
								echo json_encode($response);
								exit;						
						}						
						if((strlen($_POST['password']) < 4) || (strlen($_POST['repassword']) < 4)){
								$response = array("response" => array("httpCode" => 402 , "Message" => "Password values should be minimum 4 chars" ));
								echo json_encode($response);
								exit;									
						}
						$validate_password=$this->api->password_matches($_POST['password'],$_POST['repassword']);
						if($validate_password == 2){
							$response = array("response" => array("httpCode" => 401 , "Message" => "Password values should match" ));
								echo json_encode($response);
								exit;						
						}
						
						$password=($form_values['password']!=__('enter_password'))?$form_values['password']:"";						
						$lastname=($form_values['lastname']!=__('enter_lastname'))?$form_values['lastname']:"";						
						
						if(count($user_settings)>0){
							if(($user_settings[0]['admin_activation_reg']==NO && $user_settings[0]['email_verification_reg'] == YES) || ($user_settings[0]['admin_activation_reg']==YES && $user_settings[0]['email_verification_reg'] == NO) || ($user_settings[0]['admin_activation_reg']==YES && $user_settings[0]['email_verification_reg'] == YES))
							{
								$status=IN_ACTIVE;
							}
							else
							{
								$status=ACTIVE;
							}
						}
						else
						{ $status=IN_ACTIVE;}				
						//Commonfunction model for insert
						$insert=$this->api->insert(USERS,array('username'=>trim(strtolower(Html::chars($form_values['username']))),
											'email'=>$form_values['email'],
											'password' => md5($password),
											'firstname' =>trim($form_values['firstname']),
											'lastname' => trim($lastname),										
											'status' =>$status,
											'activation_code' =>$activation_key,
											'referral_id'=> Text::random(),
											'created_date'=>$this->getCurrentTimeStamp));					
							if($insert)
							{
								$signup_id=$insert[0];								
								$mail="";
								//Insert bonus when referred by any user only when user invited thro facebook
								
								$site_name = $this->site_settings[0]['site_name'];
								$activation_link = "<a href= ".URL_BASE.USERACTIVATION."?id=".$signup_id."&key=".$activation_key." >$site_name</a>";
								$this->username = array(USERNAME => $form_values["username"],USEDTOLOGIN => $_POST['username'],PASSWORD => $form_values["password"],TO_MAIL => $form_values['email'],ACTIVATION_URL => $activation_link);
								
								$this->replace_variable = array_merge($this->replace_variables,$this->username);			   								
								//checking settings for email sending option whether checked or not
								//activation request mail and welcome mail  will send only if email_verification_reg = "YES"  
							 if(($user_settings[0]['email_verification_reg'] == YES) && ($user_settings[0]['admin_activation_reg'] == NO))	
								{								 
								 //send mail to user by defining common function variables from here
								$mail = Api::get_email_template_details(ACTIVATION_REQUEST, $this->replace_variable,SEND_MAIL_TRUE);
								}
								else if(($user_settings[0]['email_verification_reg'] == YES) && ($user_settings[0]['admin_activation_reg'] == YES))
								{
									$mail = Api::get_email_template_details(ACTIVATION_REQUEST, $this->replace_variable,SEND_MAIL_TRUE);
								}

								if($user_settings[0]['welcome_mail_reg'] == YES){  
													
									$this->username = array(USERNAME => $form_values["username"],USEDTOLOGIN => $_POST['username'],PASSWORD => $form_values["password"],TO_MAIL => $form_values['email']);
										$this->replace_variable = array_merge($this->replace_variables,$this->username); 
									//send mail to user by defining common function variables from here               
										$mail = Api::get_email_template_details(NEW_USER_JOIN, $this->replace_variable,SEND_MAIL_TRUE);
										//send mail to user by defining common function variables from here               
									$mail = Api::get_email_template_details(WELCOME_EMAIL, $this->replace_variable,SEND_MAIL_TRUE);				
									}
								if($user_settings[0]['admin_notification_reg'] == YES)
								{	
									//merging all send details with common function replace variables				
									$this->admin = array(TO_MAIL => TO_ADMIN_MAIL,USERNAME => $_POST["username"],USEDTOLOGIN => $_POST['username'],PASSWORD => $form_values["password"]);
									$this->replace_variable = array_merge($this->replace_variables,$this->admin); 										
									//send mail to admin for new user registration
									$mail = Api::get_email_template_details(NEW_USER_JOIN, $this->replace_variable,SEND_MAIL_TRUE);
								}									 
								$response = array("response" => array("user_id" => $signup_id, "email" => $_POST['email'], "httpCode" => 200,"Message" => "User successfully registered"));
								echo json_encode($response);
								exit;
							
						}
					}
					else
					{	
						$response = array("response" => array("httpCode" => 400 , "Message" =>"Required Data Missing"));
						echo json_encode($response);
						exit;
					}
					
				}else{
						$response = array("response" => array("httpCode" => 400 , "Message" => "Invalid method type" ));
						echo json_encode($response);
						exit;					
				}
		}
	/**
	* Action for Users Login function
	**/
	public function action_login()
	{
		//Extract the values from the array
		$form_values=arr::extract($_POST, array('username','password','remember'));

		//Check the validation rules for the post values in array
		$validate=$this->api->login_validation($form_values);
		
		
		if(isset($_POST)){	
				
			if($validate->check()){
				
				$username = trim(Html::chars($form_values['username']));
				$password = Html::chars(md5($form_values['password']));
			
				//Login function which return true or false after checking
				$login=$this->api->login(USERS,array("username"=>$username,"password"=>$password,"usertype"=>NORMAL),$form_values['remember']);
				if($login)
				{
				
					$result=$this->api->selectwhere(USERS,array("username"=>$username,"password"=>$password));
					if($result[0]['status'] == ACTIVE)
					{
						$login_time = $this->getCurrentTimeStamp;
                		//Insert login details in user login details table	
						$result_login = $this->api->insert(USER_LOGIN_DETAILS, array('userid'=>$result["0"]["id"],'login_ip'=>Request::$client_ip,'user_agent'=>Request::$user_agent,'last_login'=>$this->getCurrentTimeStamp));
						
						$response = array("response" => array("user_id" => $result[0]['id'] ,"email" =>$result[0]['email'],"httpCode" => 200,"Message" => "Successfully logged in"));
						echo json_encode($response);
						exit;
					}
					else
					{
						 $response = array("response" => array("httpCode" => 400 , "Message" => "User blocked" ));
						echo json_encode($response);
						exit;    
					}
				}
				else
				{					
				  $response = array("response" => array("httpCode" => 400 , "Message" => "Login failed.! Invalid username or Password..!" ));
					echo json_encode($response);
					exit;    
				 
					$form_values=NULL;
				}
			}
			else
			{				
				$response = array("response" => array("httpCode" => 400 , "Message" => "Required data missing" ));
				echo json_encode($response);
				exit;
			}
		
		}else{
				$response = array("response" => array("httpCode" => 400 , "Message" => "Invalid method type" ));
				echo json_encode($response);
				exit;
		}
	}
	
	/**
	* Send email to user if user entered email exists in our database. This function 
	* generates a random key and sends to user mail for temporary login. 
	* 
	* Api module is used to send email.
	**/
	public function action_forgot_password()
	{			
		/**To Set Errors Null to avoid error if not set in view**/              
		$errors = array();	
		/*To get selected language at user side*/
		$lang_select =arr::get($_REQUEST,'language');
		/**To generate random key if user enter email at forgot password**/
		$random_key = text::random($type = 'alnum', $length = 7);
		 /**To get the form submit button name**/
		
		$forgot_pwd_submit =arr::get($_REQUEST,'submit_forgot_password'); 
		if($_POST) 
		{	
			if(isset($_POST['user_id'])){
				$userid=$_POST['user_id'];
				}else{
					$response = array("response" => array("httpCode" => 400,"Message" => "User ID not Exists.!"));
					echo json_encode($response);
					exit;						
				}
			$validator = $this->api->validate_forgotpwd(arr::extract($_POST,array('email')));
			if ($validator->check()) 
			{
				$validate_email=$this->api->email_format_check($_POST['email']);
				if($validate_email !=1){
					$response = array("response" => array("httpCode" => 401 , "Message" => "Invalid email format.!" ));
						echo json_encode($response);
						exit;						
				}	
				$valid_email_check=$this->api->check_email($_POST['email'],$userid);				
				if($valid_email_check !=1){
					$response = array("response" => array("httpCode" => 401 , "Message" => "Email Not Exists.!" ));
						echo json_encode($response);
						exit;						
				}				
				$result=$this->api->forgot_password($validator,$_POST,$random_key);
				if(isset($result))
				{ 		
					
					$this->username = array(USERNAME => $result[0]["username"],TO_MAIL => $result[0]["email"],NEW_PASSWORD => $random_key);
					
				   	$this->replace_variable = array_merge($this->replace_variables,$this->username); 
					//send mail to user by defining common function variables from here               
				   	$mail = Api::get_email_template_details(FORGOT_PASSWORD, $this->replace_variable,SEND_MAIL_TRUE);
				    			
						$response = array("response" => array("user_id" =>$result[0]["id"], "email" => $result[0]["email"], "httpCode" => 200,"Message" => "Your password changed successfully.Please check your mail"));
						echo json_encode($response);
						exit;
					 
				}	
				else
				{
					//store msg in failure_msg declared in Website controller constructor				 
					$response = array("response" => array("httpCode" => 401 , "Message" => "Error in user forgot password" ));
					echo json_encode($response);
					exit;
				}
				$validator = null;
			}
			else 
			{					
				$response = array("response" => array("httpCode" => 400 , "Message" =>"Required Data Missing"));
				echo json_encode($response);
				exit;
			}
		}else{
				$response = array("response" => array("httpCode" => 400 , "Message" => "Invalid method type" ));
				echo json_encode($response);
				exit;			
		}
	}
	
	/**
	* User profile change password
	*/
	public function action_change_password()
	{		
		
		if(isset($_POST['user_id'])){
		$userid=$_POST['user_id'];
		}else{
		$response = array("response" => array("httpCode" => 400,"Message" => "User ID not Exists.!"));
					echo json_encode($response);
					exit;	
		}		
		if($_POST) 
		{ 		
			$validator_changepass = $this->api->validate_changepwd(arr::extract($_POST,array('old_password','new_password','confirm_password')));			
			  
			if ($validator_changepass->check()) 
			{ 
				 if(strlen($_POST['new_password']) < 4){
					$response = array("response" => array("httpCode" => 400,"Message" => "New password contains atleast 4 chars"));
					echo json_encode($response);
					exit;				
				}	
				$valid_old_pass=$this->api->check_pass($_POST['old_password'],$userid);
				if($valid_old_pass !=1){
					$response = array("response" => array("httpCode" => 401 , "Message" => "Old password is Incorrect.!" ));
						echo json_encode($response);
						exit;						
				}
				$validate_password=$this->api->password_matches($_POST['new_password'],$_POST['confirm_password']);
				if($validate_password == 2){
					$response = array("response" => array("httpCode" => 401 , "Message" => "New Password Mismatch" ));
						echo json_encode($response);
						exit;						
				}
				$result = $this->api->change_password($validator_changepass,$_POST,$userid);				
				$select_user=$this->api->select_with_onecondition(USERS,'id='.$userid);
				if($result == 1)
				{	
					$this->username = array(TO_MAIL => $select_user[0]['email'], USERNAME => $select_user[0]['username'], PASSWORD => $_POST['new_password']);
					$this->replace_variable = array_merge($this->replace_variables,$this->username);
									
				   	//send mail to user by defining common function variables from here               
				   	$mail = Api::get_email_template_details(USER_CHANGE_PASSWORD,$this->replace_variable,SEND_MAIL_TRUE);
					$response = array("response" => array("httpCode" => 200,"Message" => "Password changed successfully"));	
					echo json_encode($response);
					exit;
				}	
				else
				{
					$response = array("response" => array("httpCode" => 401, "Message" => "The current password you have entered is incorrect."));
					echo json_encode($response);
					exit;	
				}
				$validator_changepass = null;				
			}					
			else 
			{
						$response = array("response" => array("httpCode" => 400 , "Message" =>"Required Data Missing"));
						echo json_encode($response);
						exit;
			}
		}else{
				$response = array("response" => array("httpCode" => 400 , "Message" => "Invalid method type" ));
				echo json_encode($response);
				exit;			
			
			}
	}
	
	/**
	* Action for Category auctions
	**/
	public function action_category()
	{		
		$auction=Model::factory('api');
		$category_name=$this->request->param('id');
		if($category_name == ""){
			$all_category=$this->api->all_category_list();			
			$response = array("response" => array("all_categories"=>$all_category,"httpCode" => 200 , "Message" => "All Categories" ));
				echo json_encode($response);
				exit;
		}		
		$auction_types=array();
		$auction_types_list =array();
		if(class_exists('Controller_Modules'))
		{			  
			 $auction_types_list = $this->api->select_types("","M");
				foreach($auction_types_list as $types)
					 {
						  $auction_types[$types['typeid']] = $types['typename'];
					 }
			 $auction_types_list_autobid = $this->api->select_types_for_autobid("","M");			
		}		 
		$result_category=$this->api->select_product_cat($category_name);		
		$products = $this->api->select_category_count($category_name);
		if(count($products) == 0){
			$response = array("response" => array("httpCode" => 200,"Message" => "No products found in this Category."));
			echo json_encode($response);
			exit;	
		}
		$block=array();
		foreach($products as $product)
		{
				if(array_key_exists($product['auction_type'], $auction_types)){
				$typename = $auction_types[$product['auction_type']];
				
				if($typename == 'beginner'){			
				$block = Api::beginner_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
				if($typename == 'pennyauction'){			
				$block = Api::penny_product_block($product['product_id'],7,array('category_id'=>$category_name));				
				}
				if($typename == 'peakauction'){			
				$block = Api::peak_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
				if($typename == 'lowestunique'){			
				$block = Api::lowestunique_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
				if($typename == 'highestunique'){			
				$block = Api::highestunique_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
				if($typename == 'scratch'){			
				$block = Api::scratch_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
				if($typename == 'reserve'){			
				$block = Api::reserve_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
				if($typename == 'cashback'){			
				$block = Api::cashback_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
				if($typename == 'seat'){			
				$block = Api::seat_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
				if($typename == 'clock'){			
				$block = Api::clock_product_block($product['product_id'],7,array('category_id'=>$category_name));
				}
			}		 
				foreach($block as $category_show){
				if(($category_show['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$category_show['product_image']))
				{ 
				$category_show['product_image']=URL_BASE.PRODUCTS_IMGPATH_THUMB.$category_show['product_image'];
				}
				else
				{
				$category_show['product_image']=IMGPATH.NO_IMAGE;
				}
				
			if(($category_show['product_gallery'])!="")
			{ 
				$product_gallery=$category_show['product_gallery'];
				if($product_gallery!=''){
					$product_images=explode(",",$product_gallery);										
					$m=array();
					foreach($product_images as $product_image)
						{	
							$m[]=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb370x280/".$product_image;
							$category_show['product_gallery'] =$m;
						}
					}
					
			}else{
				unset($category_show['product_gallery']);
			}	
				if(($category_show['photo']) && (file_exists(DOCROOT.USER_IMGPATH.$category_show['photo'])))
				{ 
					$category_show['photo'] = URL_BASE.USER_IMGPATH.$category_show['photo'];
				}else{
					$category_show['photo'] =IMGPATH.NO_IMAGE;
				}
	
		
	
	if($category_show['product_process'] == 'L'){ $category_show['product_process']=$category_show['product_process'].'-'."Live";}
	else if($category_show['product_process'] == 'F'){ $category_show['product_process']=$category_show['product_process'].'-'."Future";}
	else if($category_show['product_process'] == 'C'){ $category_show['product_process']=$category_show['product_process'].'-'."Closed";}
	
	if($category_show['auction_process'] == 'R'){ $category_show['auction_process']=$category_show['auction_process'].'-'."Resume";}
	else if($category_show['auction_process'] == 'H'){ $category_show['auction_process']=$category_show['auction_process'].'-'."Hold";}
	
	if($category_show['dedicated_auction'] == 'E'){ $category_show['dedicated_auction']=$category_show['dedicated_auction'].'-'."Enable";}
	else if($category_show['dedicated_auction'] == 'D'){ $category_show['dedicated_auction']=$category_show['dedicated_auction'].'-'."Disable";}

	if($category_show['product_featured'] == 'F'){ $category_show['product_featured']=$category_show['product_featured'].'-'."Featured";}
	else if($category_show['product_featured'] == 'H'){ $category_show['product_featured']=$category_show['product_featured'].'-'."Hot";}else if($category_show['product_featured'] == 'N'){ $category_show['product_featured']=$category_show['product_featured'].'-'."None";}			
	if($category_show['buynow_status'] == 'A'){ $category_show['buynow_status']=$category_show['buynow_status'].'-'."Active";}
	else if($category_show['buynow_status'] == 'I'){ $category_show['buynow_status']=$category_show['buynow_status'].'-'."In active";}			
	if($category_show['product_status'] == 'A'){ $category_show['product_status']=$category_show['product_status'].'-'."Active";}
	else if($category_show['product_status'] == 'I'){ $category_show['product_status']=$category_show['product_status'].'-'."In active";}
	if(isset($category_show['in_auction'])){						
		if($category_show['in_auction'] == '0'){ $category_show['in_auction']=$category_show['in_auction'].'-'."Disabled";}
		else if($category_show['in_auction'] == '1'){ $category_show['in_auction']=$category_show['in_auction'].'-'."Enabled";}
		else if($category_show['in_auction'] == '2'){ $category_show['in_auction']=$category_show['in_auction'].'-'."Closed";}
		else if($category_show['in_auction'] == '3'){ $category_show['in_auction']=$category_show['in_auction'].'-'."Hold with User Id";}
		else if($category_show['in_auction'] == '4'){ $category_show['in_auction']=$category_show['in_auction'].'-'."Future";}
	}
	
	if(isset($category_show['autobid'])){
	if($category_show['autobid'] == 'E'){ $category_show['autobid']=$category_show['autobid'].'-'."Enable";}
	else if($category_show['autobid'] == 'D'){ $category_show['autobid']=$category_show['autobid'].'-'."Disable";}	
	}			
	
	foreach($category_show as $key=>$val){ if($val==''){unset ($category_show[$key]);} }
	
	if(isset($category_show['product_cost'])){
		$category_show['product_cost']=$this->currency_code.' '.$category_show['product_cost'];		
	}			
	if(isset($category_show['starting_current_price'])){
		$category_show['starting_current_price']=$this->currency_code.' '.$category_show['starting_current_price'];		
	}	
	if(isset($category_show['current_price'])){
		$category_show['current_price']=$this->currency_code.' '.$category_show['current_price'];		
	}
						$response[] = array("response" => array("category_show" => $category_show ,"httpCode" => 200,"Message" => "All products show for this category"));
				}
								 
		}echo json_encode($response);exit;

	}
	
	/*
	 * Show Live products only
	*/
	public function action_live()
	{		
		$selected_page_title=__('menu_live_auction');
		$this->selected_page_title = __('menu_live_auction');  
		$live_products =$this->add_process(4);		
		//Select products which all are in live
		$auction_types_list =array();
		if(class_exists('Controller_Modules'))
		{			  
			 $auction_types_list = $this->api->select_types("","M");
			  foreach($auction_types_list as $types)
					 {
						  $auction_types[$types['typeid']] = $types['typename'];
					 }			 
		}		 
			if(isset($auction_types) && count($auction_types) > 0){
				$block=array();
					foreach($auction_types as $typeid => $typename){ 
						if(isset($live_products[$typeid])){ 
									
									if($typename == 'beginner'){			
									$block = Api::beginner_product_block($live_products[$typeid],4);
									}
									else if($typename == 'pennyauction'){			
									$block = Api::penny_product_block($live_products[$typeid],4);				
									}
									else if($typename == 'peakauction'){			
									$block = Api::peak_product_block($live_products[$typeid],4);
									}
									else if($typename == 'lowestunique'){			
									$block = Api::lowestunique_product_block($live_products[$typeid],4);
									}
									else if($typename == 'highestunique'){			
									$block = Api::highestunique_product_block($live_products[$typeid],4);
									}
									else if($typename == 'scratch'){			
									$block = Api::scratch_product_block($live_products[$typeid],4);									
									}
									else if($typename == 'reserve'){			
									$block = Api::reserve_product_block($live_products[$typeid],4);
									}
									else if($typename == 'cashback'){			
									$block = Api::cashback_product_block($live_products[$typeid],4);
									}
									else if($typename == 'seat'){			
									$block = Api::seat_product_block($live_products[$typeid],4);
									}
									else if($typename == 'clock'){			
									$block = Api::clock_product_block($live_products[$typeid],4);									
									}else {
									$response = array("response" => array("httpCode" => 200,"Message" => "No Live products at the moment"));
											echo json_encode($response);
											exit;	
									}
									foreach($block as $liveproducts){
									if(($liveproducts['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$liveproducts['product_image']))
									{ 
									$liveproducts['product_image']=URL_BASE.PRODUCTS_IMGPATH_THUMB.$liveproducts['product_image'];
									}
									else
									{
									$liveproducts['product_image']=IMGPATH.NO_IMAGE;
									}
													
			if(($liveproducts['product_gallery'])!="")
			{ 
				$product_gallery=$liveproducts['product_gallery'];
				if($product_gallery!=''){
					$product_images=explode(",",$product_gallery);										
					$m=array();
					foreach($product_images as $product_image)
						{	
							$m[]=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb370x280/".$product_image;
							$liveproducts['product_gallery'] =$m;
						}
					}
					
			}else{
				unset($liveproducts['product_gallery']);
			}										
									
									
									if(($liveproducts['photo']) && (file_exists(DOCROOT.USER_IMGPATH.$liveproducts['photo'])))
									{ 
										$liveproducts['photo'] = URL_BASE.USER_IMGPATH.$liveproducts['photo'];
									}else{
										$liveproducts['photo'] =IMGPATH.NO_IMAGE;
									}
	
	
	 
	if($liveproducts['product_process'] == 'L'){ $liveproducts['product_process']=$liveproducts['product_process'].'-'."Live";}
	else if($liveproducts['product_process'] == 'F'){ $liveproducts['product_process']=$liveproducts['product_process'].'-'."Future";}
	else if($liveproducts['product_process'] == 'C'){ $liveproducts['product_process']=$liveproducts['product_process'].'-'."Closed";}
	
	if($liveproducts['auction_process'] == 'R'){ $liveproducts['auction_process']=$liveproducts['auction_process'].'-'."Resume";}
	else if($liveproducts['auction_process'] == 'H'){ $liveproducts['auction_process']=$liveproducts['auction_process'].'-'."Hold";}
	
	if($liveproducts['dedicated_auction'] == 'E'){ $liveproducts['dedicated_auction']=$liveproducts['dedicated_auction'].'-'."Enable";}
	else if($liveproducts['dedicated_auction'] == 'D'){ $liveproducts['dedicated_auction']=$liveproducts['dedicated_auction'].'-'."Disable";}

	if($liveproducts['product_featured'] == 'F'){ $liveproducts['product_featured']=$liveproducts['product_featured'].'-'."Featured";}
	else if($liveproducts['product_featured'] == 'H'){ $liveproducts['product_featured']=$liveproducts['product_featured'].'-'."Hot";}else if($liveproducts['product_featured'] == 'N'){ $liveproducts['product_featured']=$liveproducts['product_featured'].'-'."None";}			
	if($liveproducts['buynow_status'] == 'A'){ $liveproducts['buynow_status']=$liveproducts['buynow_status'].'-'."Active";}
	else if($liveproducts['buynow_status'] == 'I'){ $liveproducts['buynow_status']=$liveproducts['buynow_status'].'-'."In active";}			
	if($liveproducts['product_status'] == 'A'){ $liveproducts['product_status']=$liveproducts['product_status'].'-'."Active";}
	else if($liveproducts['product_status'] == 'I'){ $liveproducts['product_status']=$liveproducts['product_status'].'-'."In active";}
	
	if(isset($liveproducts['in_auction'])){						
		if($liveproducts['in_auction'] == '0'){ $liveproducts['in_auction']=$liveproducts['in_auction'].'-'."Disabled";}
		else if($liveproducts['in_auction'] == '1'){ $liveproducts['in_auction']=$liveproducts['in_auction'].'-'."Enabled";}
		else if($liveproducts['in_auction'] == '2'){ $liveproducts['in_auction']=$liveproducts['in_auction'].'-'."Closed";}
		else if($liveproducts['in_auction'] == '3'){ $liveproducts['in_auction']=$liveproducts['in_auction'].'-'."Hold with User Id";}
		else if($liveproducts['in_auction'] == '4'){ $liveproducts['in_auction']=$liveproducts['in_auction'].'-'."Future";}
	}
	if(isset($liveproducts['autobid'])){
	if($liveproducts['autobid'] == 'E'){ $liveproducts['autobid']=$liveproducts['autobid'].'-'."Enable";}
	else if($liveproducts['autobid'] == 'D'){ $liveproducts['autobid']=$liveproducts['autobid'].'-'."Disable";}	
	}									
	foreach($liveproducts as $key=>$val){ if($val==''){unset ($liveproducts[$key]);} }									
	if(isset($liveproducts['product_cost'])){
		$liveproducts['product_cost']=$this->currency_code.' '.$liveproducts['product_cost'];		
	}
	if(isset($liveproducts['starting_current_price'])){
		$liveproducts['starting_current_price']=$this->currency_code.' '.$liveproducts['starting_current_price'];		
	}
	if(isset($liveproducts['current_price'])){
		$liveproducts['current_price']=$this->currency_code.' '.$liveproducts['current_price'];		
	}
									$response[] = array("response" => array("live_products" => $liveproducts ,"httpCode" => 200,"Message" => "Live products"));
									}
									
								}											
				}echo json_encode($response);exit;
			}else {
											$response = array("response" => array("httpCode" => 200,"Message" => "No Live products at the moment"));
											echo json_encode($response);
											exit;
									}
			$response = array("response" => array("httpCode" => 200,"Message" => "No Live products at the moment"));
	}

	//auction types	
	public function add_process($status,$pid="",$arrayset=array())
	{	
		$product_results=$this->api->select_products($status,$pid,$arrayset);		
		$product_set = array();
		 $auction_types_list = $this->api->select_types("","M");
			  foreach($auction_types_list as $types)
				{
						$auction_types[$types['typeid']] = $types['typename'];
				}
				foreach($product_results as $products)
				{
					foreach($auction_types as $typeid => $type)
					{
						if($products['auction_type'] == $typeid)
						{
							
							$product_set[$typeid][]=$products['product_id'];
						}
					}
				}
		return $product_set;
	}
	/*
	 * Search the Auction products
	*/	
	public function action_search()
	{
	  $this->selected_page_title=__('search_auctions');	         
		$searchvalue=strip_tags(arr::get($_GET,'search'));		
		if($searchvalue =='' || $searchvalue == __('search_text')){
				$response = array("response" => array("httpCode" => 200,"Message" => "your search keyword is empty...,Try different words"));
				echo json_encode($response);
				exit;
				$value="";
		}
		else
		{
			$value=trim(Html::chars($searchvalue));
		}		
		$search_results=$this->api->get_searchresults($value);
	 
		$products =$this->add_process(8,"",array('search'=>$value));		
		if(count($products) == 0){
		$response = array("response" => array("httpCode" => 200,"Message" => "your keywords '".$searchvalue."' didnot match any results...Try different words"));
				echo json_encode($response);
				exit;
		}

		$auction_types_list =array();
		if(class_exists('Controller_Modules'))
		{			  
			 $auction_types_list = $this->api->select_types("","M");
			  foreach($auction_types_list as $types)
					 {
						  $auction_types[$types['typeid']] = $types['typename'];
					 }			
		}
		
		if(isset($auction_types) && count($auction_types) > 0){
			$block=array();
					foreach($auction_types as $typeid => $typename){
								if(isset($products[$typeid])){
									
									if($typename == 'beginner'){			
									$block = Api::beginner_product_block($products[$typeid],8,array('search'=>$value));
									}
									else if($typename == 'pennyauction'){			
									$block = Api::penny_product_block($products[$typeid],8,array('search'=>$value));				
									}
									else if($typename == 'peakauction'){			
									$block = Api::peak_product_block($products[$typeid],8,array('search'=>$value));
									}
									else if($typename == 'lowestunique'){			
									$block = Api::lowestunique_product_block($products[$typeid],8,array('search'=>$value));
									}
									else if($typename == 'highestunique'){			
									$block = Api::highestunique_product_block($products[$typeid],8,array('search'=>$value));
									}
									else if($typename == 'scratch'){			
									$block = Api::scratch_product_block($products[$typeid],8,array('search'=>$value));									
									}
									else if($typename == 'reserve'){			
									$block = Api::reserve_product_block($products[$typeid],8,array('search'=>$value));
									}
									else if($typename == 'cashback'){			
									$block = Api::cashback_product_block($products[$typeid],8,array('search'=>$value));
									}
									else if($typename == 'seat'){			
									$block = Api::seat_product_block($products[$typeid],8,array('search'=>$value));
									}
									else if($typename == 'clock'){			
									$block = Api::clock_product_block($products[$typeid],8,array('search'=>$value));									
									}else {
									$response = array("response" => array("httpCode" => 200,"Message" => "No Live products at the moment"));
											echo json_encode($response);
											exit;	
									}
									
									foreach($block as $searchproducts){
									if(($searchproducts['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$searchproducts['product_image']))
									{ 
									$searchproducts['product_image']=URL_BASE.PRODUCTS_IMGPATH_THUMB.$searchproducts['product_image'];
									}
									else
									{
									$searchproducts['product_image']=IMGPATH.NO_IMAGE;
									}
			if(($searchproducts['product_gallery'])!="")
			{ 
				$product_gallery=$searchproducts['product_gallery'];
				if($product_gallery!=''){
					$product_images=explode(",",$product_gallery);										
					$m=array();
					foreach($product_images as $product_image)
						{	
							$m[]=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb370x280/".$product_image;
							$searchproducts['product_gallery'] =$m;
						}
					}
					
			}else{
				unset($searchproducts['product_gallery']);
			}			
									if(($searchproducts['photo']) && (file_exists(DOCROOT.USER_IMGPATH.$searchproducts['photo'])))
									{ 
										$searchproducts['photo'] = URL_BASE.USER_IMGPATH.$searchproducts['photo'];
									}else{
										$searchproducts['photo'] =IMGPATH.NO_IMAGE;
									}
							
	if($searchproducts['product_process'] == 'L'){ $searchproducts['product_process']=$searchproducts['product_process'].'-'."Live";}
	else if($searchproducts['product_process'] == 'F'){ $searchproducts['product_process']=$searchproducts['product_process'].'-'."Future";}
	else if($searchproducts['product_process'] == 'C'){ $searchproducts['product_process']=$searchproducts['product_process'].'-'."Closed";}
	
	if($searchproducts['auction_process'] == 'R'){ $searchproducts['auction_process']=$searchproducts['auction_process'].'-'."Resume";}
	else if($searchproducts['auction_process'] == 'H'){ $searchproducts['auction_process']=$searchproducts['auction_process'].'-'."Hold";}
	
	if($searchproducts['dedicated_auction'] == 'E'){ $searchproducts['dedicated_auction']=$searchproducts['dedicated_auction'].'-'."Enable";}
	else if($searchproducts['dedicated_auction'] == 'D'){ $searchproducts['dedicated_auction']=$searchproducts['dedicated_auction'].'-'."Disable";}

	if($searchproducts['product_featured'] == 'F'){ $searchproducts['product_featured']=$searchproducts['product_featured'].'-'."Featured";}
	else if($searchproducts['product_featured'] == 'H'){ $searchproducts['product_featured']=$searchproducts['product_featured'].'-'."Hot";}else if($searchproducts['product_featured'] == 'N'){ $searchproducts['product_featured']=$searchproducts['product_featured'].'-'."None";}			
	if($searchproducts['buynow_status'] == 'A'){ $searchproducts['buynow_status']=$searchproducts['buynow_status'].'-'."Active";}
	else if($searchproducts['buynow_status'] == 'I'){ $searchproducts['buynow_status']=$searchproducts['buynow_status'].'-'."In active";}			
	if($searchproducts['product_status'] == 'A'){ $searchproducts['product_status']=$searchproducts['product_status'].'-'."Active";}
	else if($searchproducts['product_status'] == 'I'){ $searchproducts['product_status']=$searchproducts['product_status'].'-'."In active";}			
	if(isset($searchproducts['in_auction'])){			
		if($searchproducts['in_auction'] == '0'){ $searchproducts['in_auction']=$searchproducts['in_auction'].'-'."Disabled";}
		else if($searchproducts['in_auction'] == '1'){ $searchproducts['in_auction']=$searchproducts['in_auction'].'-'."Enabled";}
		else if($searchproducts['in_auction'] == '2'){ $searchproducts['in_auction']=$searchproducts['in_auction'].'-'."Closed";}
		else if($searchproducts['in_auction'] == '3'){ $searchproducts['in_auction']=$searchproducts['in_auction'].'-'."Hold with User Id";}
		else if($searchproducts['in_auction'] == '4'){ $searchproducts['in_auction']=$searchproducts['in_auction'].'-'."Future";}
	}
	if(isset($searchproducts['autobid'])){
	if($searchproducts['autobid'] == 'E'){ $searchproducts['autobid']=$searchproducts['autobid'].'-'."Enable";}
	else if($searchproducts['autobid'] == 'D'){ $searchproducts['autobid']=$searchproducts['autobid'].'-'."Disable";}	
	}
	foreach($searchproducts as $key=>$val){ if($val==''){unset ($searchproducts[$key]);} }								
	if(isset($searchproducts['product_cost'])){
		$searchproducts['product_cost']=$this->currency_code.' '.$searchproducts['product_cost'];		
	}
	if(isset($searchproducts['starting_current_price'])){
		$searchproducts['starting_current_price']=$this->currency_code.' '.$searchproducts['starting_current_price'];		
	}
	if(isset($searchproducts['current_price'])){
		$searchproducts['current_price']=$this->currency_code.' '.$searchproducts['current_price'];		
	}
				$response[] = array("response" => array("search results" => $searchproducts ,"httpCode" => 200,"Message" => "Search results"));
									}
									
								}
					}echo json_encode($response);exit;
				}	else {
											$response = array("response" => array("httpCode" => 200,"Message" => "your search didnot match any results"));
											echo json_encode($response);
											exit;
									}
	}
	/**
	 * View Product detail
	* */
	public function action_product() 
	{		
		$c_date=$this->getCurrentTimeStamp;
		$id=$this->request->param('id');
		$product_results=$this->api->select_products_detail($id);
		
		if(count($product_results)==0)
		{
			$response = array("response" => array("httpCode" => 400,"Message" => "No Product found"));
											echo json_encode($response);
											exit;	
		}
		
		$pid=$product_results[0]['product_id'];	
		$products =$this->add_process(6,$pid); 		
		$type=$product_results[0]['auction_type'];		
		$auction_types_list =array();
		if(class_exists('Controller_Modules'))
		{			  
			 $auction_types_list = $this->api->select_types("","M");
			  foreach($auction_types_list as $types)
					 {
						  $auction_types[$types['typeid']] = $types['typename'];
					 }			 
		}		 
			if(isset($auction_types) && count($auction_types) > 0){
				$block=array();
					foreach($auction_types as $typeid => $typename){ 
						if(isset($products[$typeid])){ 
									
									if($typename == 'beginner'){			
									$block = Api::beginner_product_block($pid,6);
									}
									else if($typename == 'pennyauction'){			
									$block = Api::penny_product_block($pid,6);				
									}
									else if($typename == 'peakauction'){			
									$block = Api::peak_product_block($pid,6);
									}
									else if($typename == 'lowestunique'){			
									$block = Api::lowestunique_product_block($pid,6);
									}
									else if($typename == 'highestunique'){			
									$block = Api::highestunique_product_block($pid,6);
									}
									else if($typename == 'scratch'){			
									$block = Api::scratch_product_block($pid,6);																		
									}
									else if($typename == 'reserve'){			
									$block = Api::reserve_product_block($pid,6);
									}
									else if($typename == 'cashback'){			
									$block = Api::cashback_product_block($pid,6);
									}
									else if($typename == 'seat'){			
									$block = Api::seat_product_block($pid,6);
									}
									else if($typename == 'clock'){			
									$block = Api::clock_product_block($pid,6);									
									}else {
									$response = array("response" => array("httpCode" => 400,"Message" => "No Product found"));
											echo json_encode($response);
											exit;	
									}
			foreach($block as $detail_products){
			if(($detail_products['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB2.$detail_products['product_image']))
			{ 
				$detail_products['product_image']=URL_BASE.PRODUCTS_IMGPATH_THUMB2.$detail_products['product_image'];
			}
			else
			{
				$detail_products['product_image']=IMGPATH.NO_IMAGE;									
			}
						//echo DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb370x280/";		
			if(($detail_products['product_gallery'])!="")
			{ 
				$product_gallery=$detail_products['product_gallery'];
				if($product_gallery!=''){
					$product_images=explode(",",$product_gallery);										
					$m=array();
					foreach($product_images as $product_image)
						{	
							$m[]=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb370x280/".$product_image;
							$detail_products['product_gallery'] =$m;
						}
					}
					
			}else{
				unset($detail_products['product_gallery']);
			}				
									if(($detail_products['photo']) && (file_exists(DOCROOT.USER_IMGPATH.$detail_products['photo'])))
									{ 
										$detail_products['photo'] = URL_BASE.USER_IMGPATH.$detail_products['photo'];
									}else{
										$detail_products['photo'] =IMGPATH.NO_IMAGE;
									}
								

	
	if($detail_products['product_process'] == 'L'){ $detail_products['product_process']=$detail_products['product_process'].'-'."Live";}
	else if($detail_products['product_process'] == 'F'){ $detail_products['product_process']=$detail_products['product_process'].'-'."Future";}
	else if($detail_products['product_process'] == 'C'){ $detail_products['product_process']=$detail_products['product_process'].'-'."Closed";}
	
	if($detail_products['auction_process'] == 'R'){ $detail_products['auction_process']=$detail_products['auction_process'].'-'."Resume";}
	else if($detail_products['auction_process'] == 'H'){ $detail_products['auction_process']=$detail_products['auction_process'].'-'."Hold";}
	
	if($detail_products['dedicated_auction'] == 'E'){ $detail_products['dedicated_auction']=$detail_products['dedicated_auction'].'-'."Enable";}
	else if($detail_products['dedicated_auction'] == 'D'){ $detail_products['dedicated_auction']=$detail_products['dedicated_auction'].'-'."Disable";}

	if($detail_products['product_featured'] == 'F'){ $detail_products['product_featured']=$detail_products['product_featured'].'-'."Featured";}
	else if($detail_products['product_featured'] == 'H'){ $detail_products['product_featured']=$detail_products['product_featured'].'-'."Hot";}else if($detail_products['product_featured'] == 'N'){ $detail_products['product_featured']=$detail_products['product_featured'].'-'."None";}			
	if($detail_products['buynow_status'] == 'A'){ $detail_products['buynow_status']=$detail_products['buynow_status'].'-'."Active";}
	else if($detail_products['buynow_status'] == 'I'){ $detail_products['buynow_status']=$detail_products['buynow_status'].'-'."In active";}			
	if($detail_products['product_status'] == 'A'){ $detail_products['product_status']=$detail_products['product_status'].'-'."Active";}
	else if($detail_products['product_status'] == 'I'){ $detail_products['product_status']=$detail_products['product_status'].'-'."In active";}	
	if(isset($detail_products['in_auction'])){					
		if($detail_products['in_auction'] == '0'){ $detail_products['in_auction']=$detail_products['in_auction'].'-'."Disabled";}
		else if($detail_products['in_auction'] == '1'){ $detail_products['in_auction']=$detail_products['in_auction'].'-'."Enabled";}
		else if($detail_products['in_auction'] == '2'){ $detail_products['in_auction']=$detail_products['in_auction'].'-'."Closed";}
		else if($detail_products['in_auction'] == '3'){ $detail_products['in_auction']=$detail_products['in_auction'].'-'."Hold with User Id";}
		else if($detail_products['in_auction'] == '4'){ $detail_products['in_auction']=$detail_products['in_auction'].'-'."Future";}
	}
	if(isset($detail_products['autobid'])){
	if($detail_products['autobid'] == 'E'){ $detail_products['autobid']=$detail_products['autobid'].'-'."Enable";}
	else if($detail_products['autobid'] == 'D'){ $detail_products['autobid']=$detail_products['autobid'].'-'."Disable";}	
	}
	foreach($detail_products as $key=>$val){ if($val==''){unset ($detail_products[$key]);} }										
	if(isset($detail_products['product_cost'])){
		$detail_products['product_cost']=$this->currency_code.' '.$detail_products['product_cost'];		
	}							
	if(isset($detail_products['starting_current_price'])){
		$detail_products['starting_current_price']=$this->currency_code.' '.$detail_products['starting_current_price'];		
	}
	if(isset($detail_products['current_price'])){
		$detail_products['current_price']=$this->currency_code.' '.$detail_products['current_price'];		
	}
										
									$response[] = array("response" => array("Detail products" => $detail_products ,"httpCode" => 200,"Message" => "Product details"));
									}
									
								}											
				}echo json_encode($response);exit;
			}else {
					$response = array("response" => array("httpCode" => 400,"Message" => "No Product found"));
					echo json_encode($response);
					exit;
				  }
				 
	}

	
}
