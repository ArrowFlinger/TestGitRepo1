<?php defined('SYSPATH') or die('No direct script access.');

/*

* Contains Master(Email Templates,Payment Gateways) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/


class Controller_Master extends Controller_Welcome 
{

        public function action_test_template()
	{
                //send data to view file 
                $view = View::factory('admin/test_details');
                $this->template->content = $view;
	}
	
        /**
        * ****edit_template()****
        */
	public function action_email_template()
	{
		//set page title
		$this->page_title =  __('menu_email_templates');
		$this->selected_page_title = __('menu_email_templates');
		$this->selected_controller_title =__('menu_master');
		//creating object for  master model
		$admin_master = Model::factory('master');
		//getting request for form submit
		$template_edit = arr::get($_REQUEST,'email_template_update');
		$errors = array();	
                //By Default Welcome Email Template Tab Should be selected
                $template_id = WELCOME_EMAIL;
		//validation starts here	
		if(isset($template_edit) && $template_edit!='')
		{
			
		        $template_id = $_POST["template_id"];	
                
			//****send validation fields into model for checking rules***//
			
			$validator = $admin_master->edit_email_template_form($_POST,array('email_from','email_to',
						        'email_subject','email_content'));

			//validation starts here			 		
			if ($validator->check()) 
			{ 
			//*********email template edit process starts here************

			$status = $admin_master->edit_email_template($_POST);	
			//Flash message 
			Message::success(__('template_update_flash'));

			}else{
			//validation failed, get errors
			$errors = $validator->errors('errors'); 
			}
		 }
                //send data to view file 
                $email_data = $admin_master->get_all_template_details();	
                //send data to view file 
		 $view = View::factory('admin/manage_master_details')
                                ->bind('email_data',$email_data[0])
                                ->bind('all_email_data',$email_data)
                                ->bind('errors',$errors)
                                ->bind('validator',$validator)
                                ->bind('template_id',$template_id)
                                ->bind('action',$action);
		$this->template->content = $view;
	}

        /**
        * ****action_show_template_details()****
        * @method to show ajax form loading for each tab clicks
        */
        public function action_show_template_details()
        {

                //$errors = array();	
                if($_POST['template_id']){   
                //creating object for  master model
                $admin_master = Model::factory('master');
                $template_id = $_POST['template_id'];
                //to show common variables in view file	
                $show_variable = str_replace("#","",implode(",",$this->common_email_variables)).','.str_replace("#","",array_key_exists($template_id,$this->all_template_variable)?implode(",",$this->all_template_variable[$template_id]):"");
                //send data to view file 
                $email_data = $admin_master->get_template_details($template_id);
                $view = View::factory('admin/email_template_form')
                        ->bind('email_data',$email_data[0]) 
                        ->bind('action',$action)
                        ->bind('show_template_variable',$show_variable);	
                        echo $view;
                        exit;
                }

        }
        
        /**
        * ****payment_gatways()****
        */
        public function action_payment_gatways()
        {
                //set page title
                $this->page_title =  __('menu_payment_gateways');
                $this->selected_page_title = __('menu_payment_gateways');
                
		$this->selected_controller_title =__('menu_master');

                //creating object for  master model
                $payment_details = Model::factory('master');
                //pagination loads here            		
                $payment_list_count = $payment_details->get_all_payment_details();
                $page_no= isset($_GET['page'])?$_GET['page']:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = ADM_PER_PAGE*($page_no-1);

                        $pag_data = Pagination::factory(array (
                        'current_page'   => array('source' => 'query_string','key' => 'page'),
                        'items_per_page' => ADM_PER_PAGE,
                        'total_items'    => $payment_list_count,
                        'view' => 'pagination/punbb',			  
                        ));
                //pagination ends here

                $payment_gatway_details = $payment_details->get_payment_details($offset, ADM_PER_PAGE);  			

                //send data to view file 
                $view = View::factory('admin/payment_details')
                        ->bind('payment_gatway_details',$payment_gatway_details)
                        ->bind('pag_data',$pag_data)
                        ->bind('Offset',$offset);
                $this->template->content = $view;
        }

        /**
        * ****edit_payment_gateways()****
        */
        public function action_edit_payment_gateways()
        {
                //set page title
                $this->page_title = __('menu_payment_gateways_edit');
                $this->selected_page_title = __('menu_payment_gateways_edit');
                $this->selected_controller_title =__('menu_master');
                //get current payment gateway page segment id 
                $payment_gateways_id = $this->request->param('id');

                //creating object for  master model
                $payment_gateways = Model::factory('master');

                //send data to view file 
                $payment_gateway_details = $payment_gateways->get_payment_detail_list($payment_gateways_id);
		 
                if(!$payment_gateways_id || count($payment_gateway_details)==0){
                        $this->request->redirect("master/payment_gatways");
                } 
                //check current action
                $action = $this->request->action();
                $action .= "/".$payment_gateways_id ;

                //getting request for form submit
                $edit_payment_gateways =arr::get($_REQUEST,'edit_gateway');
                $errors = array();
                //validation starts here
                if(isset($edit_payment_gateways) && Validation::factory($_POST)){
			$validator = $payment_gateways->edit_payment_gateway_form(arr::extract($_POST,array('payment_gatway','description','paypal_api_username',
                        'paypal_api_password','paypal_api_signature')));	
                //send validation fields into model for checking rules
                switch ($payment_gateways_id) {
                case 1:
                        $validator = $payment_gateways->edit_payment_gateway_form(arr::extract($_POST,array('payment_gatway','description','paypal_api_username',
                        'paypal_api_password','paypal_api_signature')));	
                        break;
                        case 2:
                        $validator = $payment_gateways->edit_authorize_payment_gateway_form(arr::extract($_POST,array('payment_gatway','description','authorize_api_username',
                        'authorize_api_password')));	
                        break;
                        case 3:
                        $validator = $payment_gateways->edit_mercado_payment_gateway_form(arr::extract($_POST,array('payment_gatway','description','mercado_api_username','mercado_api_password','mercado_api_signature','status')));	
                        break;	
                   
                        case 4:
                        $validator = $payment_gateways->edit_Ccavenue_payment_gateway_form(arr::extract($_POST,array('payment_gatway','description','Ccavenue_api_username',
                        'Ccavenue_api_password')));	
                        break;
                }

                //validation starts here			 		
                if ($validator->check()) 
                { 
                        //payment gateways edit process starts here
                        $status = $payment_gateways->edit_payment_gateway($payment_gateways_id,$_POST);	

                        //Flash message 
                        Message::success(__('payment_gateway_update_flash'));
                        //page redirection after success
                        $this->request->redirect("master/payment_gatways");

                        }else{
                          //validation failed, get errors
                          $errors = $validator->errors('errors'); 
                }
        }
        // Here to use dymanic payment gateways array - Dec17,2012. By Prabakaran
        $payment_gateway_views=array(	1=>'manage_payment_gateways',
                2=>'manage_authorizepayment_gateways',
                3=>'manage_mercadopago_gateway',
                4=>'manage_Ccavenuepayment_gateways'
                );

                if(!array_key_exists($payment_gateways_id, $payment_gateway_views)){
                //$this->request->redirect("master/payment_gatways");
                }

                $view = View::factory('admin/manage_payment_gateways')
                        ->bind('payment_gateway_details',$payment_gateway_details[0])
                        ->bind('errors',$errors)
                        ->bind('data',$_POST)
                        ->bind('validator',$validator)
                        ->bind('action',$action);
                $this->template->content = $view;
        }	
	

        /**
        * ****sms_gatways()****
        */
        public function action_sms_gateways()
        {
                //set page title
                $this->page_title =  __('menu_sms_gateways');
                $this->selected_page_title = __('menu_sms_gateways');
                $this->selected_controller_title =__('menu_master');
                //creating object for  master model
                $sms_details = Model::factory('master');
                //pagination loads here            		
                $sms_list_count = $sms_details->get_all_sms_details();
                $page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $sms_list_count,
                'view' => 'pagination/punbb',			  
                ));
                //pagination ends here
                $sms_gatway_details = $sms_details->get_sms_details($offset, ADM_PER_PAGE);  			
                //send data to view file 
                $view = View::factory('admin/sms_details')
                        ->bind('sms_gatway_details',$sms_gatway_details)
                        ->bind('pag_data',$pag_data)
                        ->bind('Offset',$offset);
                        $this->template->content = $view;
        }


        /**
        * ****edit_sms_gateways()****
        */
        public function action_edit_sms_gateways()
        {
                //set page title
                $this->page_title = __('menu_sms_gateways_edit');
                $this->selected_page_title = __('menu_sms_gateways_edit');
                $this->selected_controller_title =__('menu_master');
                //get current payment gateway page segment id 
                $sms_gateways_id = $this->request->param('id');
                //creating object for  master model
                $sms_gateways = Model::factory('master');
                //send data to view file 
                $sms_gateway_details = $sms_gateways->get_sms_detail_list($sms_gateways_id);
                if(!$sms_gateways_id || count($sms_gateway_details)==0){
                 $this->request->redirect("master/sms_gateways");
                }
                //check current action
                $action = $this->request->action();
                $action .= "/".$sms_gateways_id ;
                //getting request for form submit
                $edit_sms_gateways =arr::get($_REQUEST,'edit_gateway');
                $errors = array();
                //validation starts here
                if(isset($edit_sms_gateways) && Validation::factory($_POST)){		
                //send validation fields into model for checking rules
                switch ($sms_gateways_id) {
                case 1:
                $validator = $sms_gateways->edit_sms_gateway_form(arr::extract($_POST,array('sms_gatway','sms_description','sms_api_url',
                'sms_api_username','sms_api_password','sms_api_senderid')));	
                break;
                case 2:
                $validator = $sms_gateways->edit_sms_gateway_form(arr::extract($_POST,array('sms_gatway','sms_description','sms_api_url',
                'sms_api_username','sms_api_password','sms_api_senderid')));	
                break;
                }
                //validation starts here			 		
                if ($validator->check()){ 
                        //sms gateways edit process starts here
                        $status = $sms_gateways->edit_sms_gateway($sms_gateways_id,$_POST);	
                        //Flash message 
                        Message::success(__('sms_gateway_update_flash'));
                        //page redirection after success
                        $this->request->redirect("master/sms_gateways");
                        }else{
                        //validation failed, get errors
                        $errors = $validator->errors('errors'); 
                        }
                        }
                        // Here to use dymanic sms gateways array - Dec25,2012. By Prabakaran
                        $sms_gateway_views=array(1=>'manage_sms_gateways'
                        );
                        if(!array_key_exists($sms_gateways_id, $sms_gateway_views)){
                        $this->request->redirect("master/sms_gatways");
                }

                $view = View::factory('admin/'.$sms_gateway_views[$sms_gateways_id])
                        ->bind('sms_gateway_details',$sms_gateway_details[0])
                        ->bind('errors',$errors)
                        ->bind('data',$_POST)
                        ->bind('validator',$validator)
                        ->bind('action',$action);
                        $this->template->content = $view;
        }	

		public function action_manage_email_newsletter()
		{
			$this->page_title = __('menu_email_newsletter');
            $this->selected_page_title = __('menu_email_newsletter');
			$this->selected_controller_title =__('menu_master');

			$users = Model::factory('users');
			$settings = Model::factory('settings');
			//$UserList = $admin->user_list();
			$count_user_login_list = $settings->count_subscriber($res='');
			
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
			$select_newslatter_nonuser=$settings->nonuser_subscriber($res="",$offset, ADM_PER_PAGE);
			$view= View::factory('admin/manage_email_newsletter')
						->bind('count_user_login_list',$count_user_login_list)
						//->bind('select_newslatter_nonusers',$select_newslatter_nonusers)
						->bind('select_newslatter_nonuser',$select_newslatter_nonuser)
						->bind('pag_data',$pag_data)
						->bind('offset',$offset);						
						
			$this->template->content = $view;
				

		}
		public function action_edit_email_newsletter()
		{ 
			$ids=$this->request->param('id'); //print_r($id);exit;
			$this->page_title = __('menu_edit_email_newsletter');
            $this->selected_page_title = __('menu_edit_email_newsletter');
			$this->selected_controller_title =__('menu_master');
			$edit_newsletter_list = $this->admin->edit_newslatter_all_nonuser($ids);
			
			//print_r($edit_newsletter_list);exit;
			
			$nl_post=arr::get($_REQUEST,'editcat_submit');
			//print_r($nl_post);exit;
			
			if(isset($nl_post))
			{
				$status = isset($_POST['status'])?"A":"I";
				
				$update_newsletter_list = $this->admin->update_newslatter_nonuser($ids,$status);
				if($update_newsletter_list){
				Message::success(__('email_newsletter_details_updated'));
				$this->request->redirect("master/manage_email_newsletter");
				}				
			}
						
			$view= View::factory('admin/edit_newsletter_email')
												
						->bind('edit_newsletter_list',$edit_newsletter_list);
						$this->template->content = $view;				
			
		}
		public function action_delete_newsletter_email()
    	{
			$id = $this->request->param('id');
			
			$select_newslatter_nonuser=$this->admin->delete_newslatter_nonuser($id);
			 if($select_newslatter_nonuser == '0')
	        {
	                Message::success(__('newsletter_subscriber_deleted'));
                        $this->request->redirect("master/manage_email_newsletter");
	        }					
			

		}
		/*public function action_delete_newsletter_all_email()
    	{
			$select_newslatter_nonuser=$this->admin->delete_newslatter_all_nonuser();
			if($select_newslatter_nonuser == '0')
	        {
	                Message::success(__('newsletter_subscriber_deleted'));
                        $this->request->redirect("master/manage_email_newsletter");
	        }					
			

		}*/
		public function action_delete_newsletter_list()
		{
                //get current page segment id
                echo $userid = $this->request->param('id');
                
                //For Single & Multiple Selection Delete		
                $news_chk=($userid) ? array($userid) :  $_POST['newsl_chk'];
                $status = $this->admin->delete_newsletter_list($news_chk);
                //Flash message
                Message::success(__('newsletter_subscriber_deleted'));
                //redirects to index page after deletion
                $this->request->redirect("master/manage_email_newsletter");
		}

} // End Welcome
