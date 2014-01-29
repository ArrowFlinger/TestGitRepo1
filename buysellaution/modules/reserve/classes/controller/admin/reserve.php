<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Beginner Controller
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 *
 * @package    Nauction Platinum Version 1.0
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 * @Created on October 24, 2012
 * @Updated on October 24, 2012

 */
class Controller_Admin_Reserve extends Controller_Welcome {	
	
	protected $_reserve;	
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request,$response);
		//$this->_reserve = new Pennyauction;
		
		$this->reserve_model = Model::factory('reserve');
	}	
	
    	public function action_index()
    	{
		echo "Page Not Found";die();
    	}	
    
		
	 /** Manage Increment Settings**/
        public function action_increment()
        {
		
                $increment_post=arr::get($_REQUEST,'increment_submit');
		$errors = array();
		$values = arr::extract($_POST,array('incrementrange'));	
		
		if(isset($increment_post)){
		
			$delete = $this->reserve_model->delete_reserve();
			
                        //$validator = $this->reserve_model->validate_increment_settings();
                        if($delete ==1) {
			foreach($values['incrementrange']['min'] as $key => $minrange)	
			{
				
				$maximum = $values['incrementrange']['max'][$key]; 
				$price = $values['incrementrange']['price'][$key];
				
				$status = $this->reserve_model->insert(RESERVE_BIDINCREMENTS,array('minrange'=>$minrange,'maxrange' =>$maximum,'price'=>$price));
			
			}
			
			if(isset($status))
			{
				Message::success(__('update_incremant_flash'));
			}
			
                        }
               }
               
                $increment_values = $this->reserve_model->get_increment_values();
                
                
                $this->selected_page_title = __("menu_increment_settings");
                $this->selected_controller_title =__('menu_auction');
                $this->page_title = __('menu_increment_settings');
                $view = View::factory('admin/manage_increment') 
                                ->bind('increment',$increment_values)
                                ->bind('errors',$errors)
		                ->bind('validator',$validator);
				
                $this->template->content = $view;

        }
	
	public function action_add()
	{	
		$productid = arr::get($_GET,'pid'); 
		$this->page_title = __('add_reserve_auction');                
		$this->selected_page_title = __('add_reserve_auction');               
		//check current action
		$action = $this->request->action();               
		$admin_id = $this->session->get('userid');                
		$admin_name = $this->session->get("username");                
		//getting request for form submit
		$auction_add =arr::get($_REQUEST,'start_auction');              
		
		//validation starts here	
		if(isset($auction_add) && Validation::factory($_POST,$this->product_settings,$_FILES))
		{		
			$post=Arr::extract($_POST, array('startdate','enddate','product_cost','current_price','max_countdown'));
			$validator =$this->reserve_model->add_product_form($post,$this->product_settings);
			   
				  //validation check
				if ($validator->check()) 
				{	
						$status = $this->reserve_model->add_product($post,$productid);
						if($status==0)
						{
							//Flash message for sucess product add
							 Message::success(__('reserve_auction_added_successfully'));						
			 				/*Products Listings Page Redirection*/      
							$this->request->redirect("manageproduct/index");
						}
				}
				else
				{
					//validation error msg hits here
					$errors = $validator->errors('errors');
				}
		}			              
		$view = View::factory('admin/reserve_auction_add')
				->bind('title',$title)
				->bind('srch',$_POST)
				->bind('validator', $validator)
				->bind('messages', $messages)
				->bind('errors',$errors)
				->bind('admin_id',$admin_id)
				->bind('admin_name',$admin_name)
				->bind('product_data',$product_data[0])
				->bind('action',$action);
		$this->template->content = $view;
	}
	
	/*
	*Edit Product
	*/
	public function action_edit()
	{
		
		$pid = arr::get($_GET,'pid'); 
  		//set page title
		$this->page_title = __('edit_reserve_auction');
		$this->selected_page_title = __('edit_reserve_auction');		
		//get current page product segment id 
		$productid = $this->request->param('id');		
		//sending admin session id to view file ans settings default user  as "admin" drop down	
		$admin_id = $this->session->get('user_id');
		$admin_name = $this->session->get("username");				
		//check current action
		$prducts_deteils = $this->reserve_model->select_products_foradmin($pid);
		$product_edit =arr::get($_REQUEST,'start_auction');		
		$errors = array();
		
		//validation starts here	
		if(isset($product_edit))
		{		            
			if($prducts_deteils['product_status']==DELETED_STATUS)
			{
					Message::error(__('product_allready_deleted_so_no_change_update'));
					$this->request->redirect("manageproduct/index");
			}
			else
			{                      
				$post=Arr::extract($_POST, array('startdate','enddate','product_cost','current_price','max_countdown'));
				$validator = $this->reserve_model->edit_product_form($post,$this->product_settings);	 
				
				//validation starts here			 		
				if ($validator->check()) 
				{     
					//product edit process starts here              
					$status = $this->reserve_model->edit_product($pid,$post);		
					if($status == SUCESS)
					{
						//Flash message 
						Message::success(__('product_update_flash'));
						//page redirection after success
						$this->request->redirect("manageproduct/index");
					}				
					$validator = null;
				}
				else
				{
					//validation failed, get errors
					$errors = $validator->errors('errors'); 
				}
			}

	    }
		//get category list in drop down		
		$all_category_list = $this->admin_product->all_category_list();		
		
		//get all active username list in drop down		
		$all_username_list = $this->admin_product->all_available_active_admin_list();
            	
        //Get Value
         $product_data = $this->admin_product->get_all_product_details_list($productid);
		$view = View::factory('admin/reserve_auction_add')
					 ->bind('current_uri',$userid)
					 ->bind('srch',$_POST)
					 ->bind('lastbidder',$lastbidder_product)
					 ->bind('upload_errors',$upload_errors)
					 ->bind('all_username',$all_username_list)
					 ->bind('all_category',$all_category_list)
					 ->bind('admin_id',$admin_id)
					 ->bind('admin_name',$admin_name)
				 	 ->bind('product_data',$prducts_deteils)				 
					 ->bind('errors',$errors)
					 ->bind('validator',$validator)
					->bind('action',$action);
		$this->template->content = $view;
	}
	
	
	 /** Site Settings reserve bid**/
        public function action_reserve_settings()
        {          
                    
                $msg = "";
                $error = array();
                $user_settings_post=arr::get($_POST,'usersettings_submit');                 
                if(isset($user_settings_post)){   
                        
                                             
                                $status = $this->reserve_model->edit_site_settings_user($_POST);
                                
                                if($status == 1){
                                
                                        //Flash message 
                                        Message::success(__('update_reserve_usersettings_flash'));
                                       
                                }else{
                                        $msg = __('meta not exists');
                                }
                        
                }             
                $this->selected_page_title = __("menu_reserve_user_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $this->page_title = __('menu_reserve_user_settings');
                $view = View::factory('admin/reserve_user_settings')
                                ->bind('user_setting_data',$site_settings_user);
                $site_settings_user = $this->reserve_model->get_reserve_site_settings_user();	       			
                $this->template->content = $view;               
        }
	
    
} // End Welcome
