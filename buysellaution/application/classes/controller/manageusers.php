<?php defined('SYSPATH') or die('No direct script access.');

/* Contains Users Management (User ,Admin ,Edit /Delete/Block Mangement) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Manageusers extends Controller_Welcome
{

	public function __construct(Request $request, Response $response)
	{
			parent::__construct($request, $response);
			$this->getCurrentTimeStamp=commonfunction::getCurrentTimeStamp();
			//auth login check
	     		$this->is_login();
	     		$this->paypal_db = Model::factory('paypal');	
		        $this->paypalconfig = $this->paypal_db->getpaypalconfig(); 
			$this->paypal_currencycode = count($this->paypalconfig) > 0?$this->paypalconfig[0]['currency_code']:'USD';
	}
	
        /**
        * ****action_index()****
        * @return user listings  view with pagination
        */
	public function action_index()
	{
		//set page title
		$this->page_title =  __('menu_all_user_list');
		$this->selected_page_title = __('menu_all_user_list');
		$this->selected_controller_title =__('menu_users');
		//import model
		//$admin = Model::factory('admin');
		$UserList = $this->admin->user_list();
		$count_user_list = $this->admin->count_user_list();
                //pagination loads here
		//-------------------------
		$page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_user_list,
                'view' => 'pagination/punbb',
                ));
		$all_user_list = $this->admin->all_user_list($offset, ADM_PER_PAGE);
					
		//****pagination ends here***//

		//send data to view file
		$view = View::factory('admin/admin_user_list')
				->bind('title',$title)
				->bind('all_user_list',$all_user_list)
			         ->bind('pag_data',$pag_data)
				->bind('UserList',$UserList)
				->bind('srch',$_POST)
            			->bind('Offset',$offset);
		$this->template->content = $view;

	}

	public function action_add()
	{
	    //set page title
		$this->page_title =  __('add_user');
		$this->selected_page_title = __('menu_user_add');
		$this->selected_controller_title =__('menu_users');
		//get current page segment id
		$userid = $this->request->param('id');
		//check current action
		$action = $this->request->action();
		$action .= "/".$userid;
		//check current action
		$action = $this->request->action();
		//getting request for form submit
		$admin_add =arr::get($_REQUEST,'admin_add');
 		$activation_key = Commonfunction::admin_random_user_password_generator();
 		//validation starts here	
		if(isset($admin_add) && (Validation::factory($_POST,$_FILES))){
			
		$files=Arr::extract($_FILES,array('photo'));
		$post=Arr::extract($_POST, array('firstname','lastname','email', 'username','status','country','address','lat','lng'));
		$values=Arr::merge($files,$post);                   
		$validator = $this->admin->validate_user_form($values);
		$email_exist = $this->admin->check_email($_POST['email']);
 		$name_exist = $this->admin->unique_username($_POST['username']);

		    //validation check
			if ($validator->check()) 
			{
			        if($email_exist > 0)			
						{	
							$email_exists=__('email_exists');
						}
						else
						{
							if($name_exist > 0)			
							{	
								$user_exists=__('username_exists');
							}
							else
							{
										
								  $image_name = uniqid().$_FILES['photo']['name']; 
	                                $filename =Upload::save($_FILES['photo'],$image_name,DOCROOT.USER_IMGPATH, '0777');
                              	
                               

                                $status = $this->admin->add_users($validator,$_POST,$image_name,$activation_key);

				if($status)
				{
				
				$link = "<a href= ".$this->url.USERPROFILE.$activation_key.">SITE_NAME</a>";

				$this->username = array(USERNAME => $_POST['username'],USEDTOLOGIN => $_POST['username'],
				TO_MAIL => $_POST['email'],ACTIVATION_URL => $link,PASSWORD => $activation_key);
					$this->replace_variable = array_merge($this->replace_variables,$this->username);
				//send mail to user by defining common function variables from here               
				$mail = Commonfunction::get_email_template_details(ADMIN_USER_ADD, 
					$this->replace_variable,SEND_MAIL_TRUE);
					//showing msg for mail sent or not in flash
					if($mail == MAIL_SUCCESS)
					{
					Message::success(__('email_succesfull_msg'));		
					}else{
					Message::success(__('email_unsuccesfull_msg'));		

					}
				//Flash message 
				Message::success(__('user_add_flash'));
				
				/*Dashboard Page Redirection*/
				$this->request->redirect("manageusers/index");

                                }else if($status == 0){
	                               $email_exists = __("email_exists");
                                }
                            $validator = null;
                            }
                           }
                }
                else{
                        //validation error msg hits here
                        $errors = $validator->errors('errors');
                }
			}
		$check_buyerseller=$this->admin->getauctiontypes();			
		 $user_data = $this->admin->get_users_data($userid);
		//send data to view file 
		$view = View::factory('admin/user_profile')
				->bind('title',$title)
				->bind('validator', $validator)
				->bind('user_data',$user_data[0])
				->bind('messages', $messages)
				->bind('errors',$errors)
				->bind('email_exists', $email_exists)
				->bind('user_exists', $user_exists)
				->bind('action',$action)
				->bind('check_buyerseller',$check_buyerseller);
		
		$this->template->content = $view;
	
	}

        /**
	 * ****action_edit()****
	 * @return user listings array
	 */
	public function action_edit()
	{
 		//set page title
		$this->page_title = __('edit_user');
		$this->selected_page_title = __('menu_user_edit');
                $this->selected_controller_title =__('menu_users');
		//get current page segment id
		$userid = $this->request->param('id');
		//check current action
		$action = $this->request->action();
		$action .= "/".$userid;
		//getting request for form submit
		$admin_edit =arr::get($_REQUEST,'admin_edit');
		$errors = array();
	        $img_exist=$this->admin->check_userphoto($userid);
	        $user_deteils= $this->admin->get_users_data($userid);
	        
		//validation starts here
		if(isset($admin_edit) && (Validation::factory($_POST,$_FILES)))
		{ 
		
		if($user_deteils[0]['status']==DELETED_STATUS)
	        {
	        
	         Message::error(__('user_allready_deleted_so_no_change_update'));
	         $this->request->redirect("manageusers/index");
	        }
	        else
	        {    
                $files=Arr::extract($_FILES,array('photo'));
		$post=Arr::extract($_POST, array('firstname','lastname','email','username','status','country','address','lat','lng'));
		//print_r($post);exit;
		$values=Arr::merge($files,$post);
		//print_r($post);exit;
		$validator = $this->admin->validate_user_form($values);
			$name_exist = $this->admin->unique_username_update($_POST['username'],$userid);
			
			$email_exist = $this->admin->check_email_update($_POST['email'],$userid);
			
			//$email_exist = $this->admin->check_email($_POST['email']);
            		if($name_exist > 0)
			{

				$user_exists= __("username_exists");
			}
			else
			{
				if($email_exist > 0)
				{
					$email_exists= __("email_exists");
				}
				else
				{
		                        //validation check
		                        if ($validator->check())
		                        {
			                        $filename =Upload::save($_FILES['photo'],NULL,DOCROOT.USER_IMGPATH, '0777');
			                        $image_name = explode("/",$filename);
			                        $image_name= end($image_name);

									if($img_exist != '' && $image_name!= '')
									{
										if(file_exists(DOCROOT.USER_IMGPATH.$img_exist))
										{
											unlink(DOCROOT.USER_IMGPATH. $img_exist);
										}
								          }

			                      $status = $this->admin->edit_users($userid,$_POST,$image_name);
				if($status)
				{
				//if status inactive means mail will go to inactive user
				$this->username = array(TO_MAIL => $_POST['email'], USERNAME => $_POST['username']);
				$this->replace_variable = array_merge($this->replace_variables,$this->username);
				//$mail_user="";
				if($status[0]['status'] == ACTIVE)
				{
				//send mail to user by defining common function variables from here
				$mail_user= Commonfunction::get_email_template_details(ADMIN_USER_ACTIVE,
				$this->replace_variable,SEND_MAIL_TRUE);
				}else if($status[0]['status'] == IN_ACTIVE)
				{
				//send mail to user by defining common function variables from here
				$mail_user= Commonfunction::get_email_template_details(ADMIN_USER_DEACTIVATE,
				$this->replace_variable,SEND_MAIL_TRUE);
				}
				//showing msg for mail sent or not in flash
					
					if($mail_user == MAIL_SUCCESS)
					{
					Message::success(__('email_succesfull_msg'));		
					}else{
					Message::success(__('email_unsuccesfull_msg'));		

					}
				}
				                        //Flash message
				                        Message::success(__('user_update_flash'));
				                        //page redirection after success
				                        $this->request->redirect("manageusers/index");
		                        }
		                   else{
									    //validation error msg hits here
										$errors = $validator->errors('errors');
           	                 }
           	             }
		           }
		           }
		         }

                        //send data to view file
                        $user_data = $this->admin->get_users_data($userid);
                        $check_buyerseller=$this->admin->getauctiontypes();	
                        $view = View::factory('admin/user_profile')
                                ->bind('current_uri',$userid)
                                ->bind('upload_errors',$upload_errors)
                                ->bind('user_data',$user_data[0])
                                ->bind('errors',$errors)
                                ->bind('validator',$validator)
                                ->bind('emailid_exist', $email_exists)
                                ->bind('name_exist', $user_exists)
                                ->bind('action',$action)
                                ->bind('check_buyerseller',$check_buyerseller);
                        $this->template->content = $view;
	}

	//My Info
	public function action_myinfo()
	{
	
 		//set page title
		$this->page_title = __('edit_myinfo');
		$this->selected_page_title = __('menu_myinfo');
		//get current page segment id
		$userid = $this->request->param('id');
		
		//check current action
		$action = $this->request->action();
		$action .= "/".$userid;
		//getting request for form submit
		$admin_edit =arr::get($_REQUEST,'admin_edit');
		$errors = array();
	        $img_exist=$this->admin->check_userphoto($userid);
		//validation starts here
		//validation starts here	
		
		if(isset($admin_edit) && (Validation::factory($_POST,$_FILES)))
		{
		$files=Arr::extract($_FILES,array('photo'));
		$post=Arr::extract($_POST, array('firstname','lastname','email','username','status','country','lat','lng'));
		$values=Arr::merge($files,$post);                   
		$validator = $this->admin->validate_user_form($values);
				
			$name_exist = $this->admin->unique_username_update($_POST['username'],$userid);
			$email_exist = $this->admin->check_email_update($_POST['email'],$userid);
            		if($name_exist > 0)
			{
				$user_exists= __("username_exists");
			}
			else
			{
				if($email_exist > 0)
				{
					$email_exists= __("email_exists");
				}
				else
				{
		                        //validation check
		                        if ($validator->check())
		                        {
			                        $filename =Upload::save($_FILES['photo'],NULL,DOCROOT.USER_IMGPATH, '0777');
			                        $image_name = explode("/",$filename);
			                        $image_name= end($image_name);
								if($img_exist != '' && $image_name!= '')
								{
									if(file_exists(DOCROOT.USER_IMGPATH.$img_exist))
									{
										unlink(DOCROOT.USER_IMGPATH. $img_exist);
									}
							         }
			                                $status = $this->admin->edit_users($userid,$_POST,$image_name);
				                        //Flash message
				                        Message::success(__('admin_update_flash'));
				                        //page redirection after success
				                        $this->request->redirect("manageusers/myinfo/".$userid);
			                        $validator = null;
		                        }
		                        else
		                        {
                                        //validation error msg hits here
                                        $errors = $validator->errors('errors');
				print_r( $errors);exit;
           	                        }
           	                 }
		         }
		 }
                //send data to view file
                $user_data = $this->admin->get_users_data($userid);
                $check_buyerseller=$this->admin->getauctiontypes();	
				$view = View::factory('admin/user_profile')
					->bind('current_uri',$userid)
					->bind('upload_errors',$upload_errors)
					->bind('user_data',$user_data[0])
					->bind('errors',$errors)
					->bind('validator',$validator)
					->bind('emailid_exist', $email_exists)
					->bind('name_exist', $user_exists)
					 ->bind('check_buyerseller',$check_buyerseller)
					->bind('action',$action);
		$this->template->content = $view;
	}

	 //Admin Change Password
	 public function action_change_password()
	 {
		$errors = array();
	        $msg = "";
                $id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$id;
                $submit_change_pass =arr::get($_REQUEST,'submit_change_pass');
                $change_pass =arr::get($_REQUEST,'change_pass');
                if(isset($change_pass))
                {
                        $this->request->redirect("manageusers/change_password");
                }
		$userid =$this->session->get('id');
			if ($submit_change_pass && Validation::factory($_POST) )
			{
				$userid =$this->session->get('id');
				$validator_changepass = $this->admin->validate_changepwd(arr::extract($_POST,array('old_password','new_password','confirm_password')));
					if ($validator_changepass->check())
					{
	      					$oldpass_check= $this->admin->check_pass($_POST['old_password'],$userid);
						if($oldpass_check == 1)
						{
						$result=$this->admin->change_password($validator_changepass,$_POST,$userid);
							if($result)
							{
							//get username,password,email to send change paassword mail
							$this->username = array(TO_MAIL => $result[0]['email'], USERNAME => $result[0]['username'], PASSWORD => $_POST['new_password']);
                                                        $this->replace_variable = array_merge($this->replace_variables,$this->username);
                                                        //send mail to user by defining common function variables from here
                                                        $mail = Commonfunction::get_email_template_details(ADMIN_CHANGE_PASSWORD,$this->replace_variable,SEND_MAIL_TRUE);
								//showing msg for mail sent or not in flash
								if($mail == MAIL_SUCCESS)
								{
									Message::success(__('email_succesfull_msg'));
									}else{
									Message::success(__('email_unsuccesfull_msg'));

								}
							 //success message
							 Message::success(__('change_password_flash'));
							 $this->request->redirect("manageusers/index");
							}
							else
							{
							//error message
							        Message::success(__('password_mismatch'));
							}
					$validator_changepass = null;
					$email_exists="";
					$user_exists="";
						}
						else
						{
							$pass_mismatch=__('oldpassword_error');
						}
					}
					else
					{
					//validation failed, get errors
					$errors = $validator_changepass->errors('errors');
					}
			}

                $this->selected_page_title = __("menu_change_password");
                $this->page_title = __('menu_change_password');
                $view = View::factory('admin/change_password')
	                ->bind('current_uri',$id)
	                ->bind('errors',$errors)
			->bind('pass_mismatch',$pass_mismatch)
			->bind('validator', $validator)
			->bind('validator_changepass', $validator_changepass)
			->bind('oldpass_error',$oldpass_error);
                $this->template->content = $view;
        }

	public function action_delete()
	{
                //get current page segment id
                $userid = $this->request->param('id');
                //user image delete and unlink that image
                $user_delete= $this->admin->check_userphoto($userid);
               
                        if(file_exists(DOCROOT.USER_IMGPATH.$user_delete) && $user_delete != '')
                        {
                                 unlink(DOCROOT.USER_IMGPATH.$user_delete);
                        }
                        //perform delete action
                        $status = $this->admin->delete_users($userid);
                        
                              if($status)
                                {
                                        
                                        $this->username = array(USERNAME => $status[0]['username'],TO_MAIL => $status[0]['email']);
                                        $this->replace_variable = array_merge($this->replace_variables,$this->username);
                                        //send mail to user by defining common function variables from here
                                        $mail = Commonfunction::get_email_template_details(ADMIN_USER_DELETE, $this->replace_variable,SEND_MAIL_TRUE);
                                        //showing msg for mail sent or not in flash
                                        if($mail == MAIL_SUCCESS)
                                        {
                                                Message::success(__('email_succesfull_msg'));
                                                }else{
                                                         Message::success(__('email_unsuccesfull_msg'));
                                        }
                                        
                                       $oldmail=$status[0]['email'];
                                       //$username=$status[0]['username'].$random_no1 = Commonfunction::randomkey_generator(4); 
                                        $useremail=$status[0]['email'].$random_no1 = Commonfunction::randomkey_generator(4);
                                       // $status = $this->admin->delete_users_update($userid,$username,$useremail);
                                       
                                        $statusvalue = $this->admin->user_message_update($oldmail);
                                                                               
                                }
                                $status = $this->admin->delete_users_update($userid);
                               
                        //Flash message
                        Message::success(__('user_delete_flash'));
                        //redirects to index page after deletion
                        $this->request->redirect("manageusers/index");
	}

	public function action_userlogin_delete()
	{
                //get current page segment id
                $userid = $this->request->param('id');
                //For Single & Multiple Selection Delete		
                $user_login_chk=($userid) ? array($userid) :  $_POST['user_login_chk'];
                $status = $this->admin->delete_users_login($user_login_chk);
                //Flash message
                Message::success(__('userlogin_delete_flash'));
                //redirects to index page after deletion
                $this->request->redirect("manageusers/loginlistings");
	}

	/**
	 * ****action_export()****
	 * @param
	 * @return functionality for csv export
	 */
	public function action_export()
	{

		//export csv data retrieved here
		$UserList = $this->admin->user_list();
		$list = $this->admin->export_data($_REQUEST['keyword'],$_REQUEST['type'],$_REQUEST['status']);
		//set data to view file
		$view = View::factory('admin/admin_user_list')
				->bind('UserList',$UserList);
		$this->template->content = $view;
	}

	/**
	 * ****action_search()****
	 * @param
	 * @return search user listings
	 */
	public function action_search()
	{
		//Page Title
		$this->page_title =  __('menu_user');
		$this->selected_page_title = __('menu_user');

		$this->selected_controller_title =__('menu_users');
		//default empty list and offset
		$search_list = '';
		$offset = '';
		//Find page action in view
		$action = $this->request->action();
		//Getting count for users listings
		$count_user_list = $this->admin->count_user_list();
		//get form submit request
		$search_post = arr::get($_REQUEST,'search_user');
		
		        //Post results for search
                	if(isset($search_post) && $_POST){
			        $all_user_list = $this->admin->get_all_search_list(trim(Html::chars($_POST['keyword'])),trim(Html::chars($_POST['user_type'])),trim(Html::chars($_POST['status'])));
		        }
		//set data to view file
    		$view = View::factory('admin/admin_user_list')
				->bind('title',$title)
				->bind('Offset',$offset)
				->bind('action',$action)
				->bind('srch',$_POST)
				->bind('all_user_list',$all_user_list);
		$this->template->content = $view;
	}

	/**
	 * ****action_sendemail()****
	 * @param 
	 * @send email to users
	 */	
	public function action_sendemail()
	{
		//import admin model
		$admin = Model::factory('admin');
		//get form request for submit
		$admin_email =arr::get($_REQUEST,'admin_email');
		//validation starts here
		if (isset($admin_email)) 
		{
			if(!isset($_POST['to_user'])){
			        $_POST['to_user']="";        
			}
			$validator = $admin->get_sendemail_validation($_POST,array('user_status','to_user','subject','message'));
			
			$from = $this->site_settings[0]['common_email_from'];
			$mail = Model::factory('commonfunction');
                        $smtp_settings  = $mail->get_smtp_settings(); 
                        $smtp_config = array('driver' => 'smtp','options' => array('hostname'=>$smtp_settings[0]['smtp_host'],
		                        'username'=>$smtp_settings[0]['smtp_username'],'password' => $smtp_settings[0]['smtp_password'],
		                        'port' => $smtp_settings[0]['smtp_port'],'encryption' => 'ssl')); 
			//validation check 
			if ($validator->check()) 
			{
					   
				$status = $admin->sendemail($_POST,$this->url,$this->replace_variables,$from,$smtp_config);

				Message::success(__('mail_sent'));
                                $this->request->redirect("manageusers/index");
				$validator = null;
		     }else{
				//validation error message hits here
				$errors = $validator->errors('errors');
                   }
                } 
	
		//set data to view file
		$view = View::factory('admin/sendemail')
				->bind('validator', $validator)
				->bind('errors',$errors);
                $this->page_title =  __('menu_user_send_email');
                $this->selected_page_title = __('menu_user_send_email');   
                $this->selected_controller_title =__('menu_users');     
		$this->template->content = $view;
	}

	
	
	/**
	 * ****action_builduser()****
	 * @return
	 */
	public function action_builduser()
	{
		//get user list dd for corresponding status
		if($_POST['status'])
		{
			  $validator = json_decode($_POST['validator'], true);
			  $errors = json_decode($_POST['error'], true);
			  $id = $_POST['status'];
			  $builduser_list = $this->admin->get_user_type_list($_POST['status'],$validator,$errors);
		}
	}


	/**
	 * ****action_loginlistings()****

	 * @return user listings  view with pagination
	 */
	public function action_loginlistings()
	{
		//import model admin
		$admin = Model::factory('admin');
		//$UserList = $admin->user_list();
		$count_user_login_list = $admin->count_user_login_list();
                //pagination loads here
		//-------------------------
		$page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
	        $page_no = PAGE_NO;
	        $offset = ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_user_login_list,
                'view' => 'pagination/punbb',	
                ));
		$all_user_login_list = $admin->all_user_login_list($offset,ADM_PER_PAGE);
		//splitting last login time to display proper format
		$all_user_login_lists = array();
		$i=0;
		foreach($all_user_login_list as $login_list)
		{
			
			$all_user_login_lists[$i]['last_login'] = $this->DisplayDateTimeFormat($login_list["last_login"]);
			$all_user_login_lists[$i]['login_ip'] = $login_list["login_ip"];
			$all_user_login_lists[$i]['ban_ip'] = $login_list["ban_ip"];
			$all_user_login_lists[$i]['user_agent'] = $login_list["user_agent"];
			$all_user_login_lists[$i]['id'] = $login_list["id"];
			$all_user_login_lists[$i]['username'] = $login_list["username"];
			$i++;
		}

		$this->page_title =  __('menu_user_login');
		$this->selected_page_title = __('menu_user_login');
		$this->selected_controller_title =__('menu_users');
		$view = View::factory('admin/user_login_listings')
                                        ->bind('title',$title)
                                        ->bind('all_user_login_list',$all_user_login_lists)
                                        ->bind('all_user_list',$all_user_list)
                                        ->bind('pag_data',$pag_data)
                                        ->bind('srch',$_POST)
                                        ->bind('Offset',$offset);
                $this->template->content = $view;
		
	}

	/**
	 * ****action_order_search()****
	 * @param 
	 * @return search loginip
	 */	
	public function action_user_loginip_search()
	{

		//auth login check
		$this->is_login(); 
	
		//default empty list and offset
		$all_user_list = '';
		$offset = '';
		//Find page action in view
		$action = $this->request->action();
		//get form submit request
		$search_post = arr::get($_REQUEST,'search_loginip');
		$count_user_login_list = $this->admin->count_user_login_list();
		//get form submit request
		$search_value = (isset($_POST['search_username']))? trim(Html::chars($_POST['search_username'])) : "";

		//Post results for search 
                if(isset($search_post)){
		$all_user_login_list = $this->admin->get_all_user_login_search_list($search_value);
		
		//splitting last login time to display proper format
		$all_user_login_lists= array();
		$i=0;
		        foreach($all_user_login_list as $login_list)
		        {
	
			        $all_user_login_lists[$i]['last_login'] = $this->DisplayDateTimeFormat($login_list["last_login"]);
			        $all_user_login_lists[$i]['login_ip'] = $login_list["login_ip"];
			        $all_user_login_lists[$i]['ban_ip'] = $login_list["ban_ip"];
			        $all_user_login_lists[$i]['user_agent'] = $login_list["user_agent"];
			        $all_user_login_lists[$i]['id'] = $login_list["id"];
			        $all_user_login_lists[$i]['username'] = $login_list["username"];
			
			        $i++;
			
		        }
                }
		$this->page_title =  __('menu_user_login');
		$this->selected_page_title = __('menu_user_login');
		$this->selected_controller_title =__('menu_users');
		$view = View::factory('admin/user_login_listings')
                                ->bind('title',$title)
                                ->bind('all_user_login_list',$all_user_login_lists)
                                ->bind('all_user_list',$all_user_list)
                                ->bind('action',$action)
                                ->bind('srch',$_POST)
                                ->bind('Offset',$offset);
		$this->template->content = $view;
	}	
		
	public function action_delete_userphoto()
	{
		        //get current page segment id
		        $userid = $this->request->param('id');
		        $user_delete= $this->admin->check_userphoto($userid);
                        if(file_exists(DOCROOT.USER_IMGPATH.$user_delete) && $user_delete != '')
                        {
                            unlink(DOCROOT.USER_IMGPATH.$user_delete);
                        }
		//send data to view file
    	         $user_data = $this->admin->get_users_data($userid);
		//Flash message
		Message::success(__('delete_userphoto_flash'));
		$this->request->redirect("manageusers/edit/".$userid);
	}

	public function action_user_messages()
	{
                //set page title
                $this->page_title = __('menu_user_messages');
                $this->selected_page_title = __('menu_user_messages');
                $this->selected_controller_title =__('menu_users');
                $count_user_messages = $this->admin->count_user_messages_list();
                //pagination loads here
                $page_no= isset($_GET['page'])?$_GET['page']:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                        $pag_data = Pagination::factory(array (
                        'current_page'   => array('source' => 'query_string','key' => 'page'),
                        'items_per_page' => ADM_PER_PAGE,
                        'total_items'    => $count_user_messages,
                        'view' => 'pagination/punbb',
                        ));

		$all_user_messages_list = $this->admin->all_user_messages_list($offset, ADM_PER_PAGE);
		//*pagination ends here
		//get all sender list in drop down
		$all_sender_list = $this->admin->all_msg_sender_list();
		//get all receiver list in drop down
		$all_receiver_list = $this->admin->all_msg_receiver_list();
		//get all job list in drop down
		$all_job_list = $this->admin->all_job_list();
		//splitting created_date to display proper format
	/*	$i=0;
		foreach($all_user_messages_list as $msg_list)
		{

			$all_user_messages_list[$i]['sent_date'] = $this->DisplayDateTimeFormat($msg_list["sent_date"]);
			$all_user_messages_list[$i]['order_no'] = $msg_list["order_no"];
			$all_user_messages_list[$i]['sendername'] = $msg_list["sendername"];
			$all_user_messages_list[$i]['receivername'] = $msg_list["receivername"];
			$all_user_messages_list[$i]['job_title'] = $msg_list["job_title"];
			$all_user_messages_list[$i]['job_url'] = $msg_list["job_url"];
			$all_user_messages_list[$i]['subject'] =$msg_list["subject"];
			$all_user_messages_list[$i]['random_number'] = $msg_list["random_number"];
			$all_user_messages_list[$i]['id']	= 	$msg_list["id"];
			$all_user_messages_list[$i]['usrid']	= 	$msg_list["usrid"];
			$all_user_messages_list[$i]['sendertype']	= 	$msg_list["sendertype"];
			$all_user_messages_list[$i]['senderstatus']	= 	$msg_list["senderstatus"];
			$i++;
		}
                   */
		//send data to view file
		$view = View::factory('admin/user_messages_details')
						->bind('title',$title)
						->bind('all_user_messages_list',$all_user_messages_list)
						->bind('all_sender_list',$all_sender_list)
						->bind('all_receiver_list',$all_receiver_list)
						->bind('all_job_list',$all_job_list)
						->bind('all_job_order',$all_job_order)
						->bind('srch',$_POST)
					        ->bind('pag_data',$pag_data)
                                                ->bind('offset',$offset);
		$this->template->content = $view;
	}

	/**
	 * ****action_user_messages_search()****
	 * @param
	 * @return search user messages
	 */
	public function action_user_messages_search()
	{

		//set page title
		$this->page_title = __('menu_user_messages');
		$this->selected_page_title = __('menu_user_messages');
		$this->selected_controller_title =__('menu_users');
		//default empty list and offset
		$search_list = '';
		$offset = '';
		//Find page action in view
		$action = $this->request->action();
		//get form submit request
		$search_post = arr::get($_REQUEST,'search_user_msg');
		//Post results for search
               if(isset($search_post)){
			$all_user_messages_list = $this->admin->get_all_user_messages_search_list($_POST['sender_search'],
                        $_POST['receiver_search'],trim(Html::chars($_POST['order_search'])),$_POST['job_search']);
		//splitting created_date to display proper format
		        $i=0;
		        foreach($all_user_messages_list as $msg_list)
		        {
			        $all_user_messages_list[$i]['sent_date'] = $this->DisplayDateTimeFormat($msg_list["sent_date"]);
			        $all_user_messages_list[$i]['order_no'] = $msg_list["order_no"];
			        $all_user_messages_list[$i]['sendername'] = $msg_list["sendername"];
			        $all_user_messages_list[$i]['receivername'] = $msg_list["receivername"];
			        $all_user_messages_list[$i]['product_name'] = $msg_list["product_name"];
			        $all_user_messages_list[$i]['product_url'] = $msg_list["product_url"];
			        $all_user_messages_list[$i]['subject'] = $msg_list["subject"];
			        $all_user_messages_list[$i]['random_number'] = $msg_list["random_number"];
			        $all_user_messages_list[$i]['id']	= 	$msg_list["id"];
			        $all_user_messages_list[$i]['usrid']	= 	$msg_list["usrid"];
			        //$all_user_messages_list[$i]['usrid']	= 	$msg_list["usrid"];
			        $all_user_messages_list[$i]['sendertype']	= 	$msg_list["sendertype"];
			        $all_user_messages_list[$i]['senderstatus']	= 	$msg_list["senderstatus"];
			        $i++;
		        }
		}
		//get all sender list in drop down
		$all_sender_list = $this->admin->all_msg_sender_list();
		//get all receiver list in drop down
		$all_receiver_list = $this->admin->all_msg_receiver_list();
		//send data to view file
		$view = View::factory('admin/user_messages_details')
                                        ->bind('title',$title)
                                        ->bind('all_user_messages_list',$all_user_messages_list)
                                        ->bind('all_sender_list',$all_sender_list)
                                        ->bind('all_receiver_list',$all_receiver_list)
                                        ->bind('all_job_list',$all_job_list)
                                        ->bind('all_job_order',$all_job_order)
                                        ->bind('srch',$_POST)
                                        ->bind('offset',$offset);
		$this->template->content = $view;
	}

	/**
	 * ****action_update_flag_status()****
	 * @return update flag status
	 */
	public function action_update_flag_status()
	{
                                //get current page segment id
                                $msg_id = arr::get($_REQUEST,'id');
                                //get params value posting by query string

                                $flag_status=arr::get($_REQUEST,'flagstatus');
                                //perform suggestion update
                                $flag_status_update = $this->admin->update_flag_status($msg_id,$flag_status);

				switch($flag_status){
					case INACT:
					//success message for flag active
					Message::success(__('flag_active_msg_flash'));
					break;
					case ACT:
					//success message for flag in active
					Message::success(__('flag_inactive_msg_flash'));
					break;
				}
			//redirects to index page after flash
			$this->request->redirect("manageusers/user_messages");
		}

        /**
        * ****action_update sender status()****
        * @return update flag status
        */
	public function action_update_sender_status()
	{
                //get current page segment id
                $id = arr::get($_REQUEST,'id');
                //get params value posting by query string
                $sender_status=arr::get($_REQUEST,'senderstatus');
                //perform suggestion update
                $sender_status_update = $this->admin->update_sender_status($id,$sender_status);
                switch($sender_status){
                        case 1:
                        //success message for status active
                        Message::success(__('user_status_inactive_msg_flash'));
                        break;
                        case 0:
                        //success message for status in active
                        Message::success(__('user_status_active_msg_flash'));
                        break;
                }

                //redirects to index page after flash
                $this->request->redirect("manageusers/user_messages");
        }

	/**
	 * ****action_more_job_action()****
	 * @param Action type = delete, flag, unflag
	 * @return more action
	 */
	public function action_more_job_action()
	{
		//get current page segment id
		$type = $this->request->param('id');
		$more_user_action = $this->admin->more_user_action($type,$_POST['msg_chk']);
		
		if($more_user_action==0){Message::success(__('admin_status_not_change_msg_flash'));}

		//flash message for more action
		
		switch ($type) {

			case DELETE_ACTION:
				Message::success(__('msg_delete_flash'));
				break;
			case FLAG:
				Message::success(__('flag_active_msg_flash'));
				break;
			case UNFLAG:
				Message::success(__('flag_inactive_msg_flash'));
				break;
			case INACTIVE_ACTION:
				Message::success(__('user_status_inactive_msg_flash'));
				break;
			case ACTIVE:
				Message::success(__('user_status_active_msg_flash'));
				break;
		}
		//redirects to index page after flash
		$this->request->redirect("manageusers/user_messages");
	}

        /**
        * ****action_contact_requests()****
        * @return contact requests listings with pagination
        */
	public function action_contact_requests()
	{
                //set page title
                $this->page_title = __('menu_contact_requests');
                $this->selected_page_title = __('menu_contact_requests');
                $this->selected_controller_title =__('menu_users');
                //pagination loads here
                $count_contact_requests = $this->admin->count_contact_requests_list();
                $page_no= isset($_GET['page'])?$_GET['page']:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                        $pag_data = Pagination::factory(array (
                        'current_page'   => array('source' => 'query_string','key' => 'page'),
                        'items_per_page' => ADM_PER_PAGE,
                        'total_items'    => $count_contact_requests,
                        'view' => 'pagination/punbb',
                        ));
                $all_contact_requests_list = $this->admin->all_contact_requests_list($offset, ADM_PER_PAGE);
                //pagination ends here
		//splitting created_date to display proper format
		 $i=0;
		foreach($all_contact_requests_list as $contact_requests)
		{

			$all_contact_requests_list[$i]['request_date'] = $this->DisplayDateTimeFormat($contact_requests["request_date"]);
			$all_contact_requests_list[$i]['email'] = $contact_requests["email"];
			$all_contact_requests_list[$i]['name'] = $contact_requests["name"];
			$all_contact_requests_list[$i]['subject'] = $contact_requests["subject"];
			$all_contact_requests_list[$i]['subject1'] = $contact_requests["subject1"];
			$all_contact_requests_list[$i]['message'] = trim($contact_requests["message"]);
			$all_contact_requests_list[$i]['telephone'] = $contact_requests["telephone"];
			$all_contact_requests_list[$i]['ip'] = $contact_requests["ip"];
			$all_contact_requests_list[$i]['id']	= 	$contact_requests["id"];
			$i++;
		} 
		//send data to view file
		$view = View::factory('admin/contact_request_details')
					 ->bind('title',$title)
					 ->bind('all_contact_requests_list',$all_contact_requests_list)
				         ->bind('pag_data',$pag_data)
                                         ->bind('offset',$offset);
		$this->template->content = $view;
	}

	/**
	 * ****action_contact_request_delete()****
	 * delete contact_request items
	 */
	public function action_contact_request_delete()
	{
                //For Single & Multiple Selection Delete
                $deleteids = strlen($this->request->param('id'))>0?$this->request->param('id'):$_POST['contact_chk'];
                //perform contact_request delete action
                $status = $this->admin->delete_contact_request($deleteids);
                //Flash message for Delete
                Message::success(__('contact_request_delete_flash'));
                $this->request->redirect("manageusers/contact_requests");
	}

	/**
	 * ****action_auto_reply_contact_request()****
	 *reply for  contact_request items
	 */
	public function action_auto_reply_contact_request()
	{
 		//set page title
		$this->page_title = __('menu_contact_us_reply');
		$this->selected_page_title = __('menu_contact_us_reply');
		$this->selected_controller_title =__('menu_users');
		//get current page segment id
		$req_id = $this->request->param('id');
		
		//check current action
		$action = $this->request->action();
		$action .= "/".$req_id;
		//getting request for form submit
		$auto_reply =arr::get($_REQUEST,'contact_auto_reply');
		$errors = array();
		//validation starts here
		if(isset($auto_reply) && Validation::factory($_POST))
		{
			 $validator = $this->admin->validate_auto_reply_contact_form(arr::extract($_POST,array('subject','message')));
		                        //validation check
		                        if ($validator->check())
		                        {
		                        
                                                       $reply_status = $this->admin->update_auto_reply_status($req_id);

			                                $this->username = array(TO_MAIL => $_POST['email'],
			                                SUBJECT => str_replace("RE:", "",$_POST['subject']),MESSAGE => $_POST['message']);
			                                $this->replace_variable = array_merge($this->replace_variables,$this->username);
			                                 //send mail to user by defining common function variables from here
			                                 $mail = Commonfunction::get_email_template_details(CONTACT_AUTO_REPLY,
			                                 $this->replace_variable,SEND_MAIL_TRUE);
									//showing msg for mail sent or not in flash
									if($mail == MAIL_SUCCESS)
									{
										Message::success(__('email_succesfull_msg'));
										}else{
										Message::success(__('email_unsuccesfull_msg'));
									}
						        $status = $this->admin->status_reply($req_id);
				                        //Flash message
				                        Message::success(__('auto_reply_send_flash'));
				                        //page redirection after success
				                        $this->request->redirect("manageusers/contact_requests");
		                        }
		                   else{
						      //validation error msg hits here
							$errors = $validator->errors('errors');
           	                 }

		         }

                        //send data to view file
                        $contact_request_reply = $this->admin->get_contact_request_details($req_id);
                        $view = View::factory('admin/contactus_auto_reply')
                                ->bind('contact_request_reply',$contact_request_reply[0])
                                ->bind('errors',$errors)
                                ->bind('validator',$validator)
                                ->bind('action',$action);
                        $this->template->content = $view;
	}

	/**
	 * ****action_update_banip_status()****

	 * @return update login ban ip status
	 */
	public function action_update_banIP_status()
	{
		//get current page segment id
		$id = arr::get($_REQUEST,'id');
		//get params value posting by query string
		$status=arr::get($_REQUEST,'status');
		//get admin email address
		$admin_email = $this->session->get('email');
		//perform block/unblock ip status update
	        $ban_ip_status = $this->admin->update_banIP_status($id,$status);
		// mail subject, content, receipient, message
		$this->usr_details = array(USERNAME => $ban_ip_status[0]['username'], TO_MAIL => $ban_ip_status[0]['email'],SUGESSTION_NAME => $ban_ip_status[0]['login_ip']);
	        $this->replace_variable = array_merge($this->replace_variables,$this->usr_details);

		/*if($status == SUG_DISAPPROVE){
			//mail content for disapprove suggestion
			$msg = __('email_message_disapprove');
		   //send mail to user by defining value from here
		   //third param for checking whether mail option is true or not
		   $mail = Commonfunction::get_email_template_details(ADMIN_JOB_DISAPPROVE,$this->replace_variable,SEND_MAIL_TRUE);


		}else{
			//mail content for approve suggestion
			$msg = __('email_message_approve');
			//third param for checking whether mail option is true or not
		   $mail = Commonfunction::get_email_template_details(ADMIN_JOB_APPROVE,$this->replace_variable,SEND_MAIL_TRUE);
		}

		   //showing msg for mail sent or not in flash
		   //==========================================
		   if($mail == MAIL_SUCCESS)
		   {
		   	Message::success(__('email_succesfull_msg'));
		   	}else{
		   	Message::success(__('email_unsuccesfull_msg'));

		   }*/

		//sending mail seperately for block ip,unblock ip
		//==============================================
		switch($status){
			case BLOCK:
			//success message for unblock ip
			//===============================
			Message::success(__('block_login_ip_flash'));
			break;
			case UNBLOCK:
			//success message for block ip
			//==========================================
			Message::success(__('unblock_login_ip_flash'));
			break;
		}


		//redirects to index page after deletion
		$this->request->redirect("manageusers/loginlistings");
		}
		
	
        /**
	* Action for View Testimonials List
	*/
	public function action_testimonials()
	{
		        //set page title
		$this->page_title = __('menu_testimonials');
		$this->selected_page_title = __('menu_testimonials');
		$this->selected_controller_title =__('menu_users');
		//pagination loads here
		$testimonialsid=arr::get($_REQUEST,'id'); 
		
			$page_no= isset($_GET['page'])?$_GET['page']:0;
 			$count_testimonials_auctions = $this->admin->count_testimonials_auctions();
 			
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_testimonials_auctions,  //total items available
                        'items_per_page'  => ADM_PER_PAGE,  //total items per page
                        'view' => 'pagination/punbb',  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
			
		$user_results=$this->admin->select_user_testimonials($offset,ADM_PER_PAGE);
		//pagination ends here
		 	  
		//send data to view file
		$view = View::factory('admin/testimonials')
				->bind('user_results',$user_results)
				->bind('Offset',$offset)
				->bind('pagination',$pagination);
		$this->template->content = $view;				
	}
	
	 /**
        * ****Image resize ****
        * @return Image listings 
        */        
        public function imageresize($image_factory,$width,$height,$path,$image_name,$quality=90)
        {
                if ($image_factory->height < $height || $image_factory->width < $width )
                {
                      $image = $image_factory->save($path.$image_name,90);
                      return  $image; 
                }
                else
                {
                        $image_factory->resize($width, $height, Image::INVERSE);
                        $image_factory->crop($width, $height);                    
                        $image= $image_factory->save($path.$image_name,90);
                 return  $image;
                }
        }
        
        
        /**
	 * ****testimonials_edit()****
	 * @return user listings array
	 */
	public function action_manage_testimonials()
	{
 		//set page title
		$this->page_title = __('manage_testimonials');
		$this->selected_page_title = __('menu_manage_testimonials');
		$this->selected_controller_title =__('menu_users');
		//get current page segment id
		$testimonialsid = $this->request->param('id');
		//check current action
		$action = $this->request->action();
		//getting request for form submit
		$admin_edit =arr::get($_REQUEST,'admin_edit');
		$errors = array();
	        $IMG_EXIST=$this->admin->check_testimonialsphoto($testimonialsid);
	        $files=Arr::extract($_FILES,array('photo'));
		$post=Arr::extract($_POST, array('username_id','title','description','video'));
		$values=Arr::merge($files,$post);    
                $validator = $this->admin->testimonials_validation($values);
		//validation starts here
	        if(isset($admin_edit) && (Validation::factory($_POST,$_FILES)))
	        {
                $testimonials_data = $this->admin->get_testimonials_data($testimonialsid);
                //validation check
                if ($validator->check())
                {   
                        if($testimonials_data[0]['images'] && $_POST["video"])
                        {
                                 Message::success(__('viedo_or_image_delete_image'));
                        }
                        else
                        {
                                  $image_name=$_FILES['photo']['name'];
	                        if($_POST["video"] && $image_name )
                                {
                                        Message::success(__('viedo_or_image'));
                                }
                                else
                                {
                                $url=$_POST["video"]; 

		                 $check_url = explode('?',$url);
	                                if($check_url[0] != 'http://www.youtube.com/watch' && $url != '' && !isset($check_url[1])) 
	                                { 
	                                	Message::success(__('invalid_video_url'));
		                        }
		                        else
		                        {
                                                //after image validation it will be stored in root folder//
	                                       $image_name = "";
	                                       if($_FILES['photo']['name'] !=""){
	                                        $image_type=explode('.',$_FILES['photo']['name']);
		                                $image_type=end($image_type);
	                                        $image_name = uniqid().'.'.$image_type;
		                                $filename =Upload::save($_FILES['photo'],$image_name,DOCROOT.TESTIMONIALS_IMGPATH, '0777');							
		                                //To check Uploaded Image name is not null and product image is exist in db  //
	                                        $image = Image::factory($filename);			               
                                                $path=DOCROOT.TESTIMONIALS_IMGPATH;
	                                        $this->imageresize($image,250,250,$path,$image_name,90);
	                                        }
                                                if($IMG_EXIST != '' && $image_name!= '')
                                                {
                                                        if(file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$IMG_EXIST))
                                                        {
                                                        unlink(DOCROOT.TESTIMONIALS_IMGPATH.$IMG_EXIST);
                                                        }
                                                }
                                                $status = $this->admin->add_video($testimonialsid,$_POST,$image_name);
                                                if($status == 0){
                                                        Message::error(__('Your_system_youtube_block'));
                                                }

                                                else
                                                {
                                                //Flash message
                                                Message::success(__('testimonials_update_flash'));
                                                //page redirection after success
                                                $this->request->redirect("manageusers/testimonials");
                                                }
                                        }
                                }
                        }
                }
                
                else{
                //validation error msg hits here
                $errors = $validator->errors('errors');
                }
                
         }
    	        //send data to view file
    	        $testimonials_data = $this->admin->get_testimonials_data($testimonialsid);
    	      
		$view = View::factory('admin/manage_testimonials')
				 ->bind('testimonials_data',$testimonials_data[0])
				 ->bind('errors',$errors)
				 ->bind('validator',$validator)				
                 		 ->bind('action',$action);
		$this->template->content = $view;
	}
	

        /**
        * ****Testimonials****
        * Auction Active (or) Inactive listing items
        */
	public function action_resumes()
	{           
		//get current page segment id
		$testimonialsid=arr::get($_REQUEST,'id'); 
		//get params value posting by query string
		$sus_status=arr::get($_REQUEST,'susstatus');		
		//perform suspend action 
	        $status = $this->admin->auction_active($testimonialsid,$sus_status);				
				switch($sus_status){
					case 0:							
					//success message for inactive Testimonials
					
					Message::success(__('auction_inactive_flash'));			
					break;
					case 1:
					//success message for active Testimonials
					Message::success(__('auction_active_flash'));
					break;
				}
		//redirects to index page after deletion
		$this->request->redirect("/manageusers/testimonials");
	}

        /**
        * ****Testimonials****
        * Auction Delete for Testimonials
        */
        public function action_testimonials_delete()
	{
		//get current page segment id
		$testimonials_id = $this->request->param('id');		
		          
                $testimonials_delete= $this->admin->check_testimonialsphoto($testimonials_id);
		if(file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_delete) && $testimonials_delete != '')
	            {
			  unlink(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_delete);
	            }

		//perform delete action
	        $status = $this->admin->delete_testimonials($testimonials_id);
	   	//Flash message
		Message::success(__('testimonials_delete_flash'));
		//redirects to index page after deletion		
		$this->request->redirect("/manageusers/testimonials");

	}

        public function action_delete_testimonialsphoto()
	{

		//get current page segment id
		$testimonials_id = $this->request->param('id');		
		        
                $testimonials_delete= $this->admin->check_testimonialsphoto($testimonials_id);
                $testimonials_image= $this->admin->delete_testimonialsimage($testimonials_id);
                
		if(file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_delete) && $testimonials_delete != '')
	            {
			 unlink(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_delete);
	            }
		//send data to view file
    	         $testimonials_data = $this->admin->get_testimonials_data($testimonials_id);

		//Flash message
		Message::success(__('delete_testimonialsphoto_flash'));

		$this->request->redirect("manageusers/manage_testimonials/".$testimonials_id);

	}
	
        /*
        * Admin Add user deposits 
        *@without paypal account
        */
        public function action_get_amount()
        {
           $id = $this->request->post('value'); 
           $deposits = $this->admin->adduser_deposits($id); 
           $useramount =  $deposits[0]['user_bid_account'];
           echo  $useramount;exit;
        }
        
         /*
        * Admin Add user deposits 
        *@without paypal account
        */
        public function action_allpackage_list()
        {
        
           $package_id =  $this->request->post('values');
           $packages = $this->admin->ajaxall_package_list($package_id); 
		if(count($packages)>0){ 
           $packageid =  $packages[0]['package_id'];
           echo  $packageid;exit;
		}	
		else
		{exit;}
        }
        
        /*
        * Admin Add user deposits 
        *@without paypal account
        */
        public function action_deposits()
        {
              //set page title
                $this->page_title = __('menu_add_deposits');
                $this->selected_page_title = __('menu_add_deposits');
                $this->selected_controller_title =__('menu_users');
                $msg = "";
                $userdepositid = $this->request->post('username'); 
                          
                $action = $this->request->action();   
                $action .= "/".$userdepositid;                         
                $deposits_post=arr::get($_REQUEST,'editdeposits_submit');           
                $errors = array();
                if(isset($deposits_post)&& Validation::factory($_POST))
                {                
                    $validator = $this->admin->validate_update_deposits(arr::extract($_POST,array('username','user_bid_account')));
                    if ($validator->check()) 
                    {
                        $user_amuont=$this->admin->select_user_amount($_POST['username']);
                        $packages_amount=$this->request->post('user_bid_account');
                        $user_amount= $user_amuont[0]['user_bid_account'];
                        //Deposits add amount
                        $deposits_amount=$user_amount+$this->request->post('user_bid_account');
                        $status = $this->admin->update_deposits($userdepositid,$deposits_amount);	                      
                        //insert package order status
                        $order_db_response =$this->admin->addorder_details(); 
                        $trans_db_response =$this->admin->addtransactionlog_details(); 
                        if(count($user_amuont)>0)
	                {
		                $select_email=$user_amuont[0]['email'];
		                $from=FROM_MAIL;
		                $subject="Packages Amount Added";
		                $message="Packages Amount of <b>".$this->site_currency." ".$packages_amount." </b>is awarded for you. You can spent this packages amount to the biding auctions.";
		                $sent_date=$this->getCurrentTimeStamp;
		                $user_amuont=$this->admin->user_message_packages($select_email,$from,$subject,$message,$sent_date);
		                $details_amuont=$this->admin->paypal_transactionlog_details($select_email,$from,$this->paypal_currencycode);
	                }
                        if($status == 1)
                        {
                                //Flash message 
                                Message::success(__('add_deposits_flash'));	
                                $this->request->redirect("manageusers/manage_deposits");
                        }
                     }
                     else
                     {
                          $errors = $validator->errors('errors');
                     }
                }
                //User get List	               
                $all_username_list = $this->admin->all_username_list(); 
                //Package get List
                $all_package_list = $this->admin->all_package_list (); 
                $add_deposits = $this->admin->adduser_deposits($userdepositid);                      
                $view = View::factory('admin/deposits')
                                                ->bind('current_uri',$userdepositid)
                                                ->bind('title',$title)

                                                ->bind('errors',$errors)
                                                ->bind('add_deposits',$add_deposits[0])                                              
                                                ->bind('all_username_list',$all_username_list)
                                                ->bind('all_package_list',$all_package_list)
                                                ->bind('validator', $validator)
                                                ->bind('action',$action);
                $this->template->content = $view;	
        }
        
        /**
        * ****action_index()****
        * @return user listings  view with pagination
        */
	public function action_manage_deposits()
	{
		//set page title
		$this->page_title =  __('menu_userdeposits');
		$this->selected_page_title = __('menu_userdeposits');
		$this->selected_controller_title =__('menu_users');
		$count_deposits_list = $this->admin->count_deposits_list();
		
	    	//pagination loads here
		//-------------------------
		$page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_deposits_list,
                'view' => 'pagination/punbb',
                ));
		$all_user_list_deposits = $this->admin->all_user_list_deposits($offset, ADM_PER_PAGE);
		//pagination ends here
		//send data to view file
		$view = View::factory('admin/manage_deposits')
				->bind('title',$title)
				->bind('all_user_list_deposits',$all_user_list_deposits)
			        ->bind('pag_data',$pag_data)
            			->bind('Offset',$offset);
		$this->template->content = $view;
	}
        
        /**
        * ****action_edit()****
        * @return user listings array
        */
	public function action_edit_deposits()
	{
 	        //set page title
                $this->page_title = __('menu_add_deposits');
                $this->selected_page_title = __('menu_add_deposits');
                $this->selected_controller_title =__('menu_users');
                $msg = "";
                $userdepositid = $this->request->param('id');                
                $action = $this->request->action();   
                $action .= "/".$userdepositid;                         
                $deposits_post=arr::get($_REQUEST,'editdeposits_submit');           
                $errors = array();
                if(isset($deposits_post)&& Validation::factory($_POST))
                {    
                    $validator = $this->admin->validate_update_deposits(arr::extract($_POST,array('username','user_bid_account')));
                    if ($validator->check()) 
                    {
                        //Deposits add amount
                        $deposits_amount=$this->request->post('old_amount')+$this->request->post('user_bid_account');
                        $status = $this->admin->update_deposits($userdepositid,$deposits_amount);	              
                        if($status == 1)
                        {
                                //Flash message 
                                Message::success(__('add_deposits_flash'));	
                                $this->request->redirect("manageusers/manage_deposits");
                        }
                    }
                    else
                    {
                        $errors = $validator->errors('errors');
                    }
                }
                //Users get List	               
                $all_username_list = $this->admin->all_username_list(); 
                //Package get List
                $all_package_list = $this->admin->all_package_list (); 
                $add_deposits = $this->admin->adduser_deposits($userdepositid);                      
                $view = View::factory('admin/edit_deposit')
                                                ->bind('current_uri',$userdepositid)
                                                ->bind('title',$title)
                                                ->bind('errors',$errors)
                                                ->bind('add_deposits',$add_deposits[0])                                              
                                                ->bind('all_username_list',$all_username_list)
                                                ->bind('all_package_list',$all_package_list)
                                                ->bind('validator', $validator)
                                                ->bind('action',$action);
                $this->template->content = $view;	
	}
	
        public function action_delete_deposits()
	{
                //get current page segment id
                $userid = $this->request->param('id');
                //perform delete action
                $status = $this->admin->delete_deposits($userid);
                if($status)
                {
                    Message::success(__('email_succesfull_msg'));
                }

		//Flash message
		Message::success(__('user_delete_deposits_flash'));
		//redirects to index page after deletion
		$this->request->redirect("manageusers/manage_deposits");
	}
	
        /**
        * ****Testimonials****
        * Bonus Active (or) Inactive listing items
        */
	public function action_testimonials_amount()
	{   
	       //get params value posting by query string
		$testimonialsid=arr::get($_REQUEST,'testimonialsid'); 
		$userid=arr::get($_REQUEST,'id');
	        $sus_status=arr::get($_REQUEST,'susstatus');
	        if($sus_status==0)
	        {
	                  Message::success(__('user_tetimonials_bonus_already'));
	        }
	        else
	        {
	                $select_testimonials=$this->admin->select_tetimonials_status($testimonialsid);
	                if($select_testimonials[0]['testimonials_status']==IN_ACTIVE)
	                {
	                        Message::success(__('user_tetimonials_active_first'));
	                }
	                else
	                {
	                        
	                        $bonus_amuont_status=$this->admin->select_tetimonials_bonus_status();
				$tesbonus=count($bonus_amuont_status);
			
				if($tesbonus==0)
				{
					 Message::success(__('add_bonus_first'));
				}
	                        else if($bonus_amuont_status[0]['bonus_status']==IN_ACTIVE)
	                        {
	                      		 Message::success(__('bonus_tetimonials_active_first'));
	                        }
	                        else
	                        {
	                        $bonus_amuont=$this->admin->select_tetimonials_bonus();
	                        $select_admindetails=$this->admin->select_admin_email();
		                $user_amuont=$this->admin->select_user_amount($userid);
	                        $total_amount=$user_amuont[0]['user_bonus']+$bonus_amuont[0]['bonus_amount'];
		                //perform suspend action 
		                $testimonials_amount = $this->admin->testimonials_amount($bonus_amuont[0]['bonus_type_id'],$bonus_amuont[0]['bonus_amount'],$userid);
	                        $status = $this->admin->update_user_tetimonials_bonus($total_amount,$userid);				
		                $status = $this->admin->bonus_active($testimonialsid,$sus_status);				
		
				                if(count($select_admindetails)>0)
				                {

					                $select_email=$user_amuont[0]['email'];
					                $from=$select_admindetails[0]['email'];
					                $subject="Testimonials Bonus amount";
					                $message="Bonus Amount of <b>".$this->site_currency." ".$bonus_amuont[0]['bonus_amount']." </b>is awarded for you. You can spent this bonus amount to the dedicated auctions only.";
					                $sent_date=$this->getCurrentTimeStamp;
					                $user_amuont=$this->admin->user_message_tetimonials($select_email,$from,$subject,$message,$sent_date);								
				                }
				
		                switch($sus_status){
		                  case 0:							
		                        //success message for bonus already added
		                        Message::success(__('user_tetimonials_bonus_already'));			
		                  break;
		                  case 1:
		                        //success message for bonus success
		                        Message::success(__('user_tetimonials_bonus_success'));
		                  break;
	                        }
	                     }
		        }		
		}		
		//redirects to index page after deletion
		$this->request->redirect("/manageusers/testimonials");
	}
	
	/**
	 * ****action_index()****
	 * @return user listings  view with pagination
	 */
	public function action_message_reports()
	{
		//set page title
		$this->page_title =  __('menu_message_reports');
		$this->selected_page_title = __('menu_message_reports');
		$this->selected_controller_title =__('menu_users');
		$count_user_message = $this->admin->count_user_message();
		
	    	//pagination loads here
		//-------------------------
		$page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_user_message,
                'view' => 'pagination/punbb',
                ));
		$all_user_message = $this->admin->all_user_message($offset, ADM_PER_PAGE);
		//pagination ends here
		//send data to view file
		$view = View::factory('admin/message_reports')
				->bind('title',$title)
				->bind('all_user_message',$all_user_message)
			        ->bind('pag_data',$pag_data)
            			->bind('Offset',$offset);
		$this->template->content = $view;
	}
	
	// Message reports details view 
	public function action_reports_details()
	{
		//set page title
		$this->page_title =  __('menu_reports_details');
		$this->selected_page_title = __('menu_reports_details');
		$this->selected_controller_title =__('menu_users');
		$messageid = $this->request->param('id');
		
		$message_results=$this->admin->select_user_message_details($messageid);
		$update_message_details=$this->admin->update_message_details($messageid);
	        $view = View::factory('admin/message_details')
				->bind('message_results',$message_results);
		echo $view;
		exit;
	}
        

	
        
} // End Welcome
