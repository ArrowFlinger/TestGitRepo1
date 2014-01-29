<?php defined('SYSPATH') OR die('No direct access allowed.');

/* Contains Site Admin(Manege Site Admin) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Admin extends Controller_Welcome
{
        // this is TRUE only for the admin controller
        public $auth_required = FALSE;
        // Controls access for separate actions
        public $secure_actions = FALSE;
        //language variables
        public $alllanguage;
        //private $_destroy;
        
        /**
        * ****action_login()****
        *
        * @return  error message
        */
	public function action_login()
	{
	    /**To success msg from session for display success message if email has been sent **/
   	    if(isset($test)){
	       $this->test= __('succesful_logout_flash');
	       $this->session->delete('succesful_logout_flash');
	        }
		if(!$this->session->get('id')){
			$auth = Auth::instance();
			$admin = Model::factory('admin');
			$error_login = '';
			$email = '';
			$admin_submit =arr::get($_REQUEST,'admin_login');
			$this->page_title = __('page_login_title');

			if(isset($admin_submit) && ($_POST)){
				$email = $this->request->post("email");
				$password = $this->request->post("password");
				$validator = $admin->validate_login(arr::extract($_POST,array('email','password')));
					if ($validator->check())
					{
						$status = $admin->admin_login(trim($email), $password);
						  if($status == 1){
						  		//Flash message
								Message::success(__('succesful_login_flash').$this->site_settings[0]['site_name']);
								$this->request->redirect("dashboard/index");
								exit;
							}
					          else if($status == 0){
								$error_login = __('not_admin');
							}
					          else if($status == 2){
								$error_login = __('email_notexists');
							}
							else{
							 	$error_login = __('password_mismatch');
							}
							 /*else if($email){
							 	$error_login = __('password_invalid');
							}
					       else{
			                   $error_login = __('email_required');
			               }*/
							   $validator = null;
			         }
					else{
	        			$errors = $validator->errors('errors');
                        }
		     }

                $view  = View::factory('admin/login')
                        ->bind('validator', $validator)
                        ->bind('errors',$errors)
                        ->bind('error_login',$error_login);

                $this->template->content=$view;
                }else{
                $this->request->redirect('dashboard/index');
                }
        }


        /**
        * ****action_logout()****
        *
        * @return auth logout action
        */
        public function action_logout()
	{	
		if($this->admin_session_id)
		{
			$this->commonmodel->delete_useronline(USERS_ONLINE,'userid',$this->auction_userid);
		}
		$this->session->destroy();
		Cookie::delete('id');		
		$this->request->redirect("admin/login");
	}

   
	/**
	 * ****action_index()****
	 *
	 * @return login action
	 */
	public function action_index()
	{
		$this->action_login();
	}

	/**
	 * ****show_admin_dashboard()****
	 *
	 * @param
	 * @param
	 * @return  render view file for dashboard page
	 */
	public function action_show_admin_dashboard()
	{
		$this->is_login();
		$view  = View::factory('admin/home');
		$this->template->content = $view;
	}

	public function action_forgot_password()
	{

		 /**To Set Errors Null to avoid error if not set in view**/
		$errors = array();
		$view=View::factory('admin/forgot_password')
				->bind('validator', $validator)
				->bind('errors', $errors)
				->bind('success',$success)
				->bind('email_error',$email_error);
		/**To generate random key if user enter email at forgot password**/
		$random_key = text::random($type = 'alnum', $length = 7);

		 /**To get the form submit button name**/
		$forgot_pwd_submit =arr::get($_REQUEST,'submit_forgot_password_admin');

		if ($forgot_pwd_submit && Validation::factory($_POST) )
		{
			$validator = $this->admin->validate_forgotpwd(arr::extract($_POST,array('email')));
			if ($validator->check())
			{

				$email_exist = $this->admin->check_adminemail_update($_POST['email']);
				if($email_exist == 1)
				{
					$result=$this->admin->forgot_password($validator,$_POST,$random_key);
					$success = __('sucessful_forgot_password');
					$fail= __('failed_forgot_password');
						if($result)
						{

						   $this->username = array(USERNAME => $result[0]["username"],TO_MAIL => $result[0]["email"],NEW_PASSWORD => $random_key);
						   $this->replace_variable = array_merge($this->replace_variables,$this->username);

						   //send mail to user by defining common function variables from here
						   $mail = Commonfunction::get_email_template_details(FORGOT_PASSWORD, $this->replace_variable,SEND_MAIL_TRUE);
							Message::success(__('sucessful_forgot_password'));
						   //showing msg for mail sent or not in flash
						   if($mail == MAIL_SUCCESS)
						   {
						   	Message::success(__('email_succesfull_msg'));
						   	}else{
						   	Message::success(__('email_unsuccesfull_msg'));
						   }
							$this->success_msg = __('sucessful_forgot_password');
							$this->session->set('sucessful_forgot_password' , __('sucessful_forgot_password'));
							$this->request->redirect("admin/login");
						}
						else
						{
							echo $fail;
						}
				}
				else
				{
					$email_error=__("email_not_exist");
				}
			$validator = null;
			}
			else
			{
				//validation failed, get errors
				$errors = $validator->errors('errors');
			}
		}
		$this->template->content = $view;

		}

       
 }
