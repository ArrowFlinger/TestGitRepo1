<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Scratch Controller
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
class Controller_Admin_Scratch extends Controller_Welcome {	
	
	protected $_scratchauction;	
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request,$response);
		$this->scratchauction_model = Model::factory('scratch');
	}	
	
        public function action_index()
        {
                echo "Page Not Found";die();
        }	
    
	public function action_add()
	{	
		$productid = arr::get($_GET,'pid'); 
		$this->page_title = __('add_scratch_auction');                
		$this->selected_page_title = __('add_scratch_auction');               
		//check current action
		$action = $this->request->action();               
		$admin_id = $this->session->get('userid');                
		$admin_name = $this->session->get("username");                
		//getting request for form submit
		$auction_add =arr::get($_REQUEST,'start_auction'); 
		//validation starts here	
		if(isset($auction_add) && Validation::factory($_POST,$this->product_settings,$_FILES))
		{		
                        $post=Arr::extract($_POST, array('startdate','enddate','product_cost','current_price','bidamount','bids','timetobuy','product_stock'));
			$validator =$this->scratchauction_model->add_product_form($post,$this->product_settings);
				  //validation check
				if ($validator->check()) 
				{	
						$status = $this->scratchauction_model->add_product($post,$productid);
						if($status==0)
						{
							//Flash message for sucess product add
							 Message::success(__('scratch_auction_added_successfully'));						
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
                $this->buynowcount=array("5"=>"5","10"=>"10","15"=>"15","20"=>"20","25"=>"25","30"=>"30"); 		
                // Make $page_title available to all views
               	              
		$view = View::factory('admin/scratch_auction_add')
				->bind('title',$title)
				->bind('srch',$_POST)
				->bind('validator', $validator)
				->bind('messages', $messages)
                                ->bind('timetobuycount',$this->buynowcount)
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
		$this->page_title = __('edit_scratch_auction');
		$this->selected_page_title = __('edit_scratch_auction');		
		//get current page product segment id 
		$productid = $this->request->param('id');		
		//sending admin session id to view file ans settings default user  as "admin" drop down	
		$admin_id = $this->session->get('user_id');
		$admin_name = $this->session->get("username");				
		//check current action
		$prducts_deteils = $this->scratchauction_model->select_products_foradmin($pid);
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
				$post=Arr::extract($_POST, array('startdate','enddate','product_cost','current_price','bidding_countdown','bidamount','bids','timetobuy','product_stock'));
				$validator = $this->scratchauction_model->edit_product_form($post,$this->product_settings);	 
				
				//validation starts here			 		
				if ($validator->check()) 
				{     
					//product edit process starts here              
					$status = $this->scratchauction_model->edit_product($pid,$post);		
					if($status == SUCESS)
					{
						//Flash message 
						Message::success(__('scratch_auction_edit_flash'));
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
                         $this->buynowcount=array("5"=>"5","10"=>"10","15"=>"15","20"=>"20","25"=>"25","30"=>"30"); 
                        $view = View::factory('admin/scratch_auction_add')
					 ->bind('current_uri',$userid)
					 ->bind('srch',$_POST)
					 ->bind('lastbidder',$lastbidder_product)
					 ->bind('upload_errors',$upload_errors)
                                         ->bind('timetobuycount',$this->buynowcount)
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
        public function action_scratch_settings()
        {          
                    
                $msg = "";
                $error = array();
                $user_settings_post=arr::get($_POST,'usersettings_submit');                 
                if(isset($user_settings_post)){   
                        
                                             
                                $status = $this->scratchauction_model->edit_site_settings_user($_POST);
                                
                                if($status == 1){
                                
                                        //Flash message 
                                        Message::success(__('update_scratch_usersettings_flash'));
                                       
                                }else{
                                        $msg = __('meta not exists');
                                }
                        
                }             
                $this->selected_page_title = __("menu_scratch_user_settings");
                $this->selected_controller_title =__('menu_general_settings');
                $this->page_title = __('menu_scratch_user_settings');
                $view = View::factory('admin/scratch_user_settings')
                                ->bind('user_setting_data',$site_settings_user);
                $site_settings_user = $this->scratchauction_model->get_scratch_site_settings_user();	       			
                $this->template->content = $view;               
        }
    
} // End Welcome
