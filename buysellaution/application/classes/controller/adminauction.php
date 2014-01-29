<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains Adminauction(Product Winners,Bidpackages,Refunds List) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Adminauction extends Controller_Welcome 
{
        /**
        * ****action_Product Won Auction()****
        * Product Won view items
        */		 
        public function action_won()
	{
                //set page title
		$this->page_title = __('menu_product_won');
		$this->selected_page_title = __('menu_product_won');
		$product_settings =  commonfunction::get_settings_for_products();
		$this->selected_controller_title = $product_settings[0]['alternate_name'];
		$count_winners_auctions = $this->admin_auction->count_winners_auctions();      
		//pagination loads here
                $page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_winners_auctions,
                'view' => 'pagination/punbb',			  
                ));
		$site_settings=$this->site_settings;
		$winner_auction=$this->admin_auction->products_winners($offset,ADM_PER_PAGE); 
		$adminauction=Model::factory('adminauction');
		//pagination ends here
                $view = View::factory('admin/won')
                                        ->bind('title',$title)
                                        ->bind('winner_auctions',$winner_auction)
                                        ->bind('pag_data',$pag_data)
                                        ->bind('adminauction',$adminauction)
                                        ->bind('offset',$offset);                                                                
		$this->template->content = $view;
        }
        
        
        /**
        * ****action_Product Won Auction()****
        * Product Won view items
        */		 
        public function action_won_product()
	{
                //set page title
		$this->page_title = __('menu_product_won');
		$this->selected_page_title = __('menu_product_won');
		$product_settings =  commonfunction::get_settings_for_products();
		$this->selected_controller_title = $product_settings[0]['alternate_name'];
		$count_winners_auctions = $this->admin_auction->count_winners_user();  
		//pagination loads here
                $page_no= isset($_GET['page'])?$_GET['page']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = PAGE_NO;
                $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'page'),
                'items_per_page' => ADM_PER_PAGE,
                'total_items'    => $count_winners_auctions,
                'view' => 'pagination/punbb',			  
                ));
		$site_settings=$this->site_settings;
		$winner_auction=$this->admin_auction->products_winners_user($offset,ADM_PER_PAGE); 
		
		$adminauction=Model::factory('adminauction');
		//pagination ends here
                $view = View::factory('admin/won_product')
                                        ->bind('title',$title)
                                        ->bind('winner_auctions',$winner_auction)
                                        ->bind('pag_data',$pag_data)
                                        ->bind('adminauction',$adminauction)
                                        ->bind('offset',$offset);                                                                
		$this->template->content = $view;
        }
        
        /**
        * ****action_winners_reply()****
        *reply for  user winners items
        */
	public function action_winners_reply()
	{
 		//set page title
		$this->page_title = __('menu_winners_reply');
		$this->selected_page_title = __('menu_winners_reply');
		$product_settings =  commonfunction::get_settings_for_products();
		$this->selected_controller_title = $product_settings[0]['alternate_name'];
		//get current page segment id
		$req_id = arr::get($_REQUEST,'userid');
		$product_id = arr::get($_REQUEST,'pid');
		//check current action
		$action = $this->request->action();
		$action .= "/".$req_id;
		//getting request for form submit
		$auto_reply =arr::get($_REQUEST,'winners_reply');
		$errors = array();
		//validation starts here
		if(isset($auto_reply) && Validation::factory($_POST))
		{
			 $validator = $this->admin_auction->validate_winners_reply(arr::extract($_POST,array('subject','message')));
			 
		                        //validation check
		                        if ($validator->check())
		                        {
		                                if(isset($_POST['product_id']))
		                                {
		                                $userid = $_GET['userid'];
		                                $product_id=$_POST['product_id']; 
		                                $product_auction=$this->admin_auction->winners_products($product_id);   
		                                                        
                                                        $product_name= __('product_name')."  :  ".$product_auction[0]['product_name'];
		                                        $product_cost=__('productprice_label')."  :  ".$this->site_currency."".Commonfunction::numberformat($product_auction[0]['product_cost']);
		                                        $current_price=__('price_paid_user')."  :  ".$this->site_currency."".Commonfunction::numberformat($product_auction[0]['current_price']);
		                                  
                                                        $save=(round(((1-($product_auction[0]['current_price']/$product_auction[0]['product_cost']))*100),2))>0 ? round(((1-($product_auction[0]['current_price']/$product_auction[0]['product_cost']))*100),2): 0;
		                                        $save_amount=__('saving_label')."  :  ".$save."%";
		                                }
	                                        $this->username = array(TO_MAIL => $_POST['email'],
		                                SUBJECT => str_replace("", "",$_POST['subject']),USERNAME=>$_POST['username'],MESSAGE => $_POST['message'],PRODUCTNAME=>$product_name,PRODUCTCOST=>$product_cost,CURRENTPRICE=>$current_price,SAVEAMOUNT=>$save_amount);
		                                $this->replace_variable = array_merge($this->replace_variables,$this->username);
		                                //send mail to user by defining common function variables from here
		                                $mail = Commonfunction::get_email_template_details(WINNERS_REPLY,
		                                $this->replace_variable,SEND_MAIL_TRUE);
							//showing msg for mail sent or not in flash
							if($mail == MAIL_SUCCESS)
							{
								Message::success(__('email_succesfull_msg'));
								}else{
								Message::success(__('email_unsuccesfull_msg'));
							}
					         $status = $this->admin_auction->status_reply($product_id);
					         $status1 = $this->admin_auction->status_reply_status($product_id);
			                        //Flash message
			                        Message::success(__('winners_reply_send_flash'));
			                        //page redirection after success
			                        $this->request->redirect("/adminauction/won_product");
		                   }
		                   else
		                   {
						      //validation error msg hits here
							$errors = $validator->errors('errors');
           	                 }
		         }
                        //send data to view file
                        $user_winners_reply = $this->admin_auction->get_user_request_details($req_id);
                        $view = View::factory('admin/winner_reply')
                                ->bind('user_winners_reply',$user_winners_reply[0])
                                ->bind('errors',$errors)
                                ->bind('product_id',$product_id)
                                ->bind('validator',$validator)
                                ->bind('req_id',$req_id)
                                ->bind('product_id',$product_id)
                                ->bind('action',$action);
                        $this->template->content = $view;
	}
	
        /**
        * ****Mange Bidpackages Auction()
        * Bidpackages list items
        */
        public function action_manage_bidpackages()
	{
                //set page title
                $this->page_title = __('menu_add_bidpackages');
                $this->selected_page_title = __('menu_add_bidpackages');
                $this->selected_controller_title =__('menu_master');
                $msg = "";
                $action = $this->request->action();                            
                $package_post=arr::get($_REQUEST,'addbid_submit');           
                $errors = array();
                if(isset($package_post)&& Validation::factory($_POST,$this->product_settings))
                {
                    $validator = $this->admin_auction->validate_add_bidpackages(arr::extract($_POST,array('name','number_of_bids','price')),$this->product_settings);
                    if ($validator->check()) 
                    {
                        $status = $this->admin_auction->add_bidpackage($_POST,$validator);
                        if($status == 1){
                                //Flash message 
                                Message::success(__('add_packages_flash'));	
                                $this->request->redirect("adminauction/bidpackages");
                                }
                                        else if($status == 0){
                                        $bidpackage_name_exists = __("bidpackage_name_exists");
                                       }
                    }
                    else
                    {
                       
                        $errors = $validator->errors('errors');
                    }
                }	
               $view = View::factory('admin/manage_bidpackages')
                                                ->bind('title',$title)
                                                ->bind('errors',$errors)
                                                ->bind('validator', $validator)
                                                ->bind('bidpackage_name_exists',$bidpackage_name_exists)
                                                ->bind('action',$action);
                $this->template->content = $view;	
          }
        
        /*
        *@Bid packages 
        *Packages View Iteam
        *Pagination
        */
         public function action_bidpackages()
         {
                $this->page_title = __('menu_manage_bidpackages');
                $this->selected_page_title = __('menu_manage_bidpackages'); 
                $this->selected_controller_title =__('menu_master');            
                $count_package = $this->admin_auction->count_bidpackage();             
                //pagination loads here
                $page_no= isset($_GET['id'])?$_GET['id']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = 1;
                $offset=ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'id'),
                'items_per_page'  => ADM_PER_PAGE,
                'total_items'    =>  $count_package,
                'view' => 'pagination/punbb',			  
                ));
                $bid_package= $this->admin_auction->get_bidpackages($offset, ADM_PER_PAGE);                 
                $view = View::factory('admin/bidpackages')
                        ->bind('validator', $validator)
                        ->bind('errors', $errors)
                        ->bind('bid_packages',$bid_package)
                        ->bind('pag_data',$pag_data)
                        ->bind('offset',$offset);
                $this->template->content = $view;
        }
        
        /*
        @ Edit packages
        */
         public function action_edit_bidpackages()
        {
                $msg = "";
                $packageid = $this->request->param('id');          
                $action = $this->request->action();
                $action .= "/".$packageid;
                $this->page_title = __("menu_edit_packages");
                $this->selected_page_title = __("menu_edit_packages"); 
                $this->selected_controller_title =__('menu_master');           
                $packages_post=arr::get($_REQUEST,'editbid_submit');            
                $errors = array();
                if(isset($packages_post))
                {
                            $validator = $this->admin_auction->validate_edit_bidpackages(arr::extract($_POST,array('name','number_of_bids','price')),$this->product_settings);
                                            if ($validator->check()) 
                                            {
                                                 $status = $this->admin_auction->edit_bidpackages($packageid,$_POST);                       
                                                if($status == 1){
                                           		//Flash message 
			                                Message::success(__('update_bidpackages_flash'));
			                                $this->request->redirect("adminauction/bidpackages");
			                                }elseif($status == 2){
				                                $msg = __('bidpackage_name_exists');
			                                }
                                                $validator = null;
                                            }
                                    else
                                    {                     
                                        $errors = $validator->errors('errors');
                                    }
                }	
                $bid_packages = $this->admin_auction->bid_packages($packageid);
		$view = View::factory('admin/manage_bidpackages')
                        ->bind('current_uri',$packageid)
                        ->bind('action',$action)
                        ->bind('bid_packages',$bid_packages[0])
                        ->bind('errors',$errors)
                        ->bind('validator',$validator)
                        ->bind('bidpackage_name_exists',$bidpackage_name_exists);
               $this->template->content = $view;
        }

        /**
        *Delete Packages 
        **/
        public function action_delete_packages()
        {    
                $packages_id = $this->request->param('id');
                //For Single & Multiple Selection Delete
                $packages_delete_chk=($packages_id) ? array($packages_id) :$_POST['bidpackage_chk'];

                $status = $this->admin_auction->delete_packages($packages_delete_chk);
                //Flash message 
                Message::success(__('delete_packages_flash'));
                $this->request->redirect("adminauction/bidpackages");
        }
        
        /**
        *Auction Refund List 
        **/  
        public function action_refundlist()
        {
                $this->page_title = __('menu_refunds_list');
                $this->selected_page_title = __('menu_refunds_list');
                $product_settings =  commonfunction::get_settings_for_products();
		$this->selected_controller_title = $product_settings[0]['alternate_name'];
                $users=Model::factory('adminauction');
                $wonauctions_results=$this->admin_auction->select_user_wonauctions( );
                $view = View::factory('admin/refundlist')
                        ->bind('title',$title)
                        ->bind('users',$users)
                        ->bind('wonauctions_results',$wonauctions_results);
                $this->template->content = $view;	
        }
        
        /**
	 * ****action_refundlist_search()****
	 * @param 
	 * @return search refundlist
	 */	
	public function action_refundlist_search()
	{
                //auth login check
                $this->is_login(); 
                //set page title
                $this->page_title = __('menu_refunds_list');
                $this->selected_page_title = __('menu_refunds_list');
                $product_settings =  commonfunction::get_settings_for_products();
                $this->selected_controller_title = $product_settings[0]['alternate_name'];
                //default empty list and offset
                $search_list = '';
                $offset = '';
                $users=Model::factory('adminauction');	
                //get form submit request
                $search_post = arr::get($_REQUEST,'search_refundlist'); 
                //Post results for search 
                if(isset($search_post)){   
                $wonauctions_results = $this->admin_auction->get_all_refundlist_search_list(trim(Html::chars($_POST['order_search'])),$_POST['fromdate'],$_POST['todate']);
                }
                //send data to view file 
                $view = View::factory('admin/refundlist')
                        ->bind('users',$users)
                        ->bind('srch',$_POST)
                        ->bind('wonauctions_results',$wonauctions_results);
                $this->template->content = $view;
	}
	
        
        /**
        *Auction Of Day
        **/  
        public function action_today_auction()
        {
                 $this->page_title = __('menu_auction_of_day');
                 $this->selected_page_title = __('menu_auction_of_day');
                 $this->admin_auction->today_morning().'<br/>';
                 $this->admin_auction->today_midnight().'<br/>';
                 $view = View::factory('admin/today_auction')
                                      ->bind('title',$title);
                 $this->template->content = $view;	
        }
        
        /*
        *@User bonus add admin
        *Bonus Management
        */
        public function action_add_bonus()
        {
       
                $this->page_title = __('menu_add_bonus');
                $this->selected_page_title = __('menu_add_bonus');
                $msg = "";
                $bonusid = $this->request->param('id');  
                $action = $this->request->action();                            
                $bonus_post=arr::get($_REQUEST,'addbonus_submit');           
                $errors = array();
                if(isset($bonus_post)&& Validation::factory($_POST))
                {
                    $validator = $this->admin_auction->validate_add_bonus(arr::extract($_POST,array('bonus_type','bonus_amount')));
                    if ($validator->check()) 
                    {
                        $status = $this->admin_auction->add_bonus($_POST,$validator);
                        if($status == 1){
                                //Flash message 
                                Message::success(__('add_bonus_flash'));	
                                $this->request->redirect("adminauction/manage_bonus");
                                }
                                        else if($status == 0){
                                        $bonus_type_exists = __("bonus_type_exists");
                                       }
                    }
                    else
                    { 
                        $errors = $validator->errors('errors');
                    }
                }	
               $add_bonus = $this->admin_auction->user_bonustype($bonusid);
               $view = View::factory('admin/add_bonus')
                                                ->bind('title',$title)
                                                ->bind('errors',$errors)
                                                ->bind('validator', $validator)
                                                ->bind('add_bonus',$add_bonus[0])
                                                ->bind('bonus_type_exists',$bonus_type_exists)
                                                ->bind('action',$action);
                $this->template->content = $view;		
        
        }
        
         /*
        @ Edit Bonus Type
        */
         public function action_edit_bonus()
        {
                $msg = "";
                $bonusid = $this->request->param('id');  
                $flikebonusid = $this->request->param('id');          
                $action = $this->request->action();
                $action .= "/".$bonusid;
                $this->page_title = __("menu_edit_bonus_type");
                $this->selected_page_title = __("menu_edit_bonus_type");  
                $this->selected_controller_title =__('menu_master');          
                $bonus_post=arr::get($_REQUEST,'editbonus_submit');            
                $errors = array();
                if(isset($bonus_post))
                {       
                   $values=arr::extract($_POST,array('flike_from1','flike_to1','flike_bonus1','flike_from2','flike_to2','flike_bonus2','flike_from3','flike_to3','flike_bonus3','flike_from4','flike_to4','flike_bonus4','flike_from5','flike_to5','flike_bonus5','flike_from6','flike_to6','flike_bonus6','flike_from7','flike_to7','flike_bonus7','flike_from8','flike_to8','flike_bonus8','flike_from9','flike_to9','flike_bonus9','flike_from10','flike_to10','flike_bonus10'));
                            $validator = $this->admin_auction->validate_edit_bonus(arr::extract($_POST,array('bonus_type','bonus_amount')));
                                            if ($validator->check()) 
                                            {
                                                 $status = $this->admin_auction->edit_bonus($bonusid,$_POST);                       
                                                  
                                                if($status == 1){
                                           		//Flash message 
			                                Message::success(__('update_bonus_type_flash'));
			                                $this->request->redirect("adminauction/manage_bonus");
			                                }elseif($status == 2){
				                                $msg = __('bonus_type_exists');
			                                }
                                                $validator = null;
                                            }
                                    else
                                    {                     
                                        $errors = $validator->errors('errors');
                                    }
                }	
                $add_bonus = $this->admin_auction->user_bonustype($bonusid);
		$view = View::factory('admin/add_bonus')
                        ->bind('current_uri',$bonusid)
                        ->bind('action',$action)
                        ->bind('add_bonus',$add_bonus[0])
                        ->bind('errors',$errors)
                        ->bind('validator',$validator)
                        ->bind('bonus_type_exists',$bonus_type_exists);
               $this->template->content = $view;
        }

        
         /*
        *@User bonus add admin
        *Bonus Management
        */
        public function action_manage_bonus()
        {
                 $this->page_title = __('menu_manage_bonus');
                 $this->selected_page_title = __('menu_manage_bonus');
                 $this->selected_controller_title =__('menu_master');
                  $count_bonus_type = $this->admin_auction->count_bonus();             
                //pagination loads here
                $page_no= isset($_GET['id'])?$_GET['id']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = 1;
                $offset=ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'id'),
                'items_per_page'  => ADM_PER_PAGE,
                'total_items'    =>  $count_bonus_type,
                'view' => 'pagination/punbb',			  
                ));
                $bonustype= $this->admin_auction->get_bonus_type($offset, ADM_PER_PAGE);                 
                $view = View::factory('admin/manage_bonus')
                        ->bind('validator', $validator)
                        ->bind('errors', $errors)
                        ->bind('bonustype',$bonustype)
                        ->bind('pag_data',$pag_data)
                        ->bind('offset',$offset);
                $this->template->content = $view;
        }
        
        //Delete bonus
        public function action_delete_bonus()
        {      
                $bonus_id = $this->request->param('id');
                //For Single & Multiple Selection Delete
                $bonus_delete_chk=($bonus_id) ? array($bonus_id) :  $_POST['news_chk'];
                $status = $this->admin_auction->delete_bonus($bonus_delete_chk);
                //Flash message 
                Message::success(__('delete_bonus_flash'));
                $this->request->redirect("adminauction/manage_bonus");
        }
	
        
         /*
        *@User bonus Add Admin
        *Bonus Management
        */
        public function action_add_user_bonus()
        {
                $this->page_title = __('menu_add_user_bonus');
                $this->selected_page_title = __('menu_add_user_bonus');
                $this->selected_controller_title =__('menu_master');
                $msg = "";
                $action = $this->request->action();                            
                $bonus_post=arr::get($_REQUEST,'add_user_bonus_submit');           
                $errors = array();
                if(isset($bonus_post)&& Validation::factory($_POST))
                {
                    $validator = $this->admin_auction->validate_add_user_bonus(arr::extract($_POST,array('bonus_type','bonus_amount','userid')));
                    if ($validator->check()) 
                    {
                        $status = $this->admin_auction->add_user_bonus($_POST,$validator);
                     	  if($status == 1){
                                //Flash message 
                                Message::success(__('add_user_bonus_flash'));	
                                $this->request->redirect("adminauction/user_bonus");
                                }
                                      else if($status == 0){
                                        $user_bonus_exists = __("user_bonus_exists");
                                       }
                    }
                    else
                    {
                       
                        $errors = $validator->errors('errors');
                    }
                }
               $all_username_list = $this->admin->all_username_list(); 	
               $all_bonus_type=$this->admin_auction->select_bonus_type();
               $view = View::factory('admin/add_user_bonus')
                                ->bind('title',$title)
                                ->bind('errors',$errors)
                                ->bind('validator', $validator)
                                ->bind('all_username_list',$all_username_list)
                                ->bind('all_bonus_type',$all_bonus_type)
                                ->bind('user_bonus_exists',$user_bonus_exists)
                                ->bind('action',$action);
                $this->template->content = $view;
        }
        
         /*
        @ Edit Bonus Type
        *User Bonus view
        */
         public function action_edit_user_bonus()
        {
                $msg = "";
                $user_bonusid = $this->request->param('id');          
                $action = $this->request->action();
                $action .= "/".$user_bonusid;
                $this->page_title = __("menu_edit_user_bonus");
                $this->selected_page_title = __("menu_edit_user_bonus");
                $this->selected_controller_title =__('menu_master');            
                $user_bonus_post=arr::get($_REQUEST,'edit_user_bonus_submit');            
                $errors = array();
                if(isset($user_bonus_post))
                {
                            $validator = $this->admin_auction->validate_edit_user_bonus(arr::extract($_POST,array('bonus_type','bonus_amount','userid')));
                                            if ($validator->check()) 
                                            {
                                                 $status = $this->admin_auction->edit_user_bonus($user_bonusid,$_POST);                       
                                         if($status == 1){
                                           		//Flash message 
			                                Message::success(__('update_user_bonus_type_flash'));
			                                $this->request->redirect("adminauction/user_bonus");
			                                }elseif($status == 2){
				                                $msg = __('bonus_type_exists');
			                                }
                                                $validator = null;
                                            }
                                    else
                                    {                     
                                        $errors = $validator->errors('errors');
                                    }
                }
                $all_username_list = $this->admin->all_username_list(); 	
                $all_bonus_type=$this->admin_auction->select_bonus_type();	
                $add_user_bonus = $this->admin_auction->user_bonus($user_bonusid);
		$view = View::factory('admin/add_user_bonus')
                                ->bind('current_uri',$user_bonusid)
                                ->bind('action',$action)
                                ->bind('add_user_bonus',$add_user_bonus[0])
                                ->bind('errors',$errors)
                                ->bind('validator',$validator)
                                 ->bind('all_username_list',$all_username_list)
                                ->bind('all_bonus_type',$all_bonus_type)
                                ->bind('user_bonus_exists',$user_bonus_exists);
               $this->template->content = $view;
        }

        
         /*
        *@User bonus add admin
        *Bonus Management
        */
        public function action_user_bonus()
        {
                 $this->page_title = __('menu_user_bonus');
                 $this->selected_page_title = __('menu_user_bonus');
                 $this->selected_controller_title =__('menu_master');
                 $count_user_bonus = $this->admin_auction->count_user_bonus();             
                //pagination loads here
                $page_no= isset($_GET['id'])?$_GET['id']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = 1;
                $offset=ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'id'),
                'items_per_page'  => ADM_PER_PAGE,
                'total_items'    =>  $count_user_bonus,
                'view' => 'pagination/punbb',			  
                ));
                $user_bonus= $this->admin_auction->get_user_bonus($offset, ADM_PER_PAGE);                 
                $view = View::factory('admin/user_bonus')
                        ->bind('validator', $validator)
                        ->bind('errors', $errors)
                        ->bind('user_bonus',$user_bonus)
                        ->bind('pag_data',$pag_data)
                        ->bind('offset',$offset);
                $this->template->content = $view;
        }
        
        //Delete bonus
        public function action_delete_user_bonus()
        {      
                $user_bonus_id = $this->request->param('id');
                //For Single & Multiple Selection Delete
                $userbonus_delete_chk=($user_bonus_id) ? array($user_bonus_id) :  $_POST['userbonus_chk'];
                $status = $this->admin_auction->delete_userbonus($userbonus_delete_chk);
                //Flash message 
                Message::success(__('delete_userbonus_flash'));
                $this->request->redirect("adminauction/user_bonus");
        }
        
        
      /*
      *Auction Bid History
      *with Pagination
      */
      public function action_bidhistory()
     {
                $this->page_title = __('menu_bidhistory');
                $this->selected_page_title = __('menu_bidhistory');
                $product_settings =  commonfunction::get_settings_for_products();
		$this->selected_controller_title = $product_settings[0]['alternate_name'];
                $view = View::factory('admin/bidhistory') 
                        ->bind('all_bidhistory',$bidhistory)
                        ->bind('count_bidhistory',$count_bidhistory)
                        ->bind('pag_data',$pag_data)
                        ->bind('srch',$_POST)
                        ->bind('Offset',$offset)
                        ->bind('total_count',$total_count);
                $count_bidhistory=$this->admin_auction->select_bids_for_users(NULL,ADM_PER_PAGE,TRUE);
                        //pagination loads here
                        $page_no= isset($_GET['id'])?$_GET['id']:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = 1;
                        $offset=ADM_PER_PAGE*($page_no-1);
                        $pag_data = Pagination::factory(array (
                        'current_page'   => array('source' => 'query_string','key' => 'id'),
                        'items_per_page'  => ADM_PER_PAGE,
                        'total_items'    =>  $count_bidhistory,
                        'view' => 'pagination/punbb',			  
                        ));
	        $bidhistory=$this->admin_auction->select_bids_for_users($offset,ADM_PER_PAGE);
		$this->template->content = $view;
	}
	
	/*
	*Bonus Friends List
	*Show List
	*/
	public function action_bonus_friends_list()
	{
                $this->page_title = __('menu_bonus_friends_invite_list');
                $this->selected_page_title = __('menu_bonus_friends_invite_list');
                $this->selected_controller_title =__('menu_master');
                $bonus_id = $this->request->param('id');
                $user_bonus_friends_list= $this->admin_auction->get_user_bonus_friends_list($bonus_id);
                $view = View::factory('admin/bonus_friends_list') 
                        ->bind('validator', $validator)
                        ->bind('errors', $errors)
                        ->bind('user_bonus_friends_list',$user_bonus_friends_list);
		$this->template->content = $view;
	}
        
     
        
        
        
} // End Welcome
