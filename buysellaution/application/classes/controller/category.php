<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains Category(Add Category,Manage Category) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Category extends Controller_Welcome {

	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->is_login();	
                $product_settings =  commonfunction::get_settings_for_products();
		$this->selected_controller_title = $product_settings[0]['alternate_name'];
	}
	 
        /*
        *Add Product Category
        */
        public function action_add_category()
        {
                $msg = "";
                $action = $this->request->action();                
                $this->selected_page_title = __("menu_add_product_category");
                $this->page_title = __("menu_add_product_category");
                $category_post=arr::get($_REQUEST,'addcat_submit');
                $errors = array();
                if(isset($category_post)){
                        $validator = $this->category->validate_add_category(arr::extract($_POST,array('category_name')));
                        if ($validator->check()) 
                        {
                                $status = $this->category->add_category($_POST,$validator);
                                if($status == 1){
                                        //Flash message 
                                        Message::success(__('add_category_flash'));	
                                        $this->request->redirect("category/manage_category");
                                }
                                else if($status == 0){
                                        $category_exists = __("category_exists");
                                }
                        }
                        else{
                        $errors = $validator->errors('errors');
                        }
                }
                $this->selected_page_title = __("menu_add_product_category");
                $view = View::factory('admin/category_details')
                        ->bind('title',$title)
                        ->bind('errors',$errors)
                        ->bind('validator', $validator)
                        ->bind('category_exists',$category_exists)
                        ->bind('action',$action);
                $this->template->content = $view;
        }
        
        /*
        *Manage Category
        *Show List
        */
        public function action_manage_category()
        {   
                $this->page_title = __('menu_manage_product_category');
                $this->selected_page_title = __('menu_manage_product_category');
                $view= View::factory('admin/manage_category')
                ->bind('validator', $validator)
                ->bind('errors', $errors)
                ->bind('product_categories', $product_category)
                ->bind('product_categories_count', $product_category_coumt)
                ->bind('pag_data',$pag_data)
                ->bind('offset',$offset);
                                $count_product_cat = $this->category->count_product_category();
                                //pagination loads here
                                $page_no= isset($_GET['id'])?$_GET['id']:0;
                                if($page_no==0 || $page_no=='index')
                                $page_no = 1;
                                $offset=ADM_PER_PAGE*($page_no-1);
                                $pag_data = Pagination::factory(array (
                                'current_page'   => array('source' => 'query_string','key' => 'id'),
                                'items_per_page'  => ADM_PER_PAGE,
                                'total_items'    => $count_product_cat,
                                'view' => 'pagination/punbb',			  
                                ));
                $product_category = $this->category->get_product_category($offset, ADM_PER_PAGE);
                $this->template->content = $view;
        }
        
        /*
        *Edit Category
        */
        public function action_edit_category()
        {
                $msg = "";
                $cat_id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$cat_id;
                $category_post=arr::get($_REQUEST,'editcat_submit');
                $select_category = $this->category->product_category($cat_id);
                $errors = array();
                if(isset($category_post))
                {
                        if($select_category[0]['status']==DELETED_STATUS)
		        {
                                Message::error(__('category_allready_deleted_so_no_change_update'));
                                $this->request->redirect("category/manage_category");
		        }
		        else
		        {
                                $validator = $this->category->validate_add_category(arr::extract($_POST,array('category_name')));
                                $select_product_category = $this->category->product_category_status($cat_id);
			
				if($select_product_category == 1)
				{
					if(isset($_POST['status']))
					{
					Message::success(__('update_category_flash'));
					$this->request->redirect("category/manage_category");
					}
					else
					{
					Message::success(__('category_products_live'));
					$this->request->redirect("category/manage_category");
					}
				}
				else
				{
                                        if ($validator->check()) 
                                        {
                                                $status = $this->category->edit_category($cat_id,$_POST);				
                                                if($status == 1)
                                                {
                                                        //Flash message 
                                                        Message::success(__('update_category_flash'));
                                                        $this->request->redirect("category/manage_category");
                                                }elseif($status == 2){
                                                $category_exists = __('category_exists');
                                                }
                                                $validator = null;
                                        }
                                        else
                                        {
                                                $errors = $validator->errors('errors');
                                        }
                                }
                        }   
                }
                $product_categories = $this->category->product_category($cat_id);
                $this->selected_page_title = __("menu_edit_product_category");
                $this->page_title = __("menu_edit_product_category");
                $view = View::factory('admin/category_details')
                        ->bind('current_uri',$cat_id)
                        ->bind('action',$action)
                        ->bind('product_categories',$product_categories[0])
                        ->bind('errors',$errors)
                        ->bind('validator',$validator)
                        ->bind('category_exists',$category_exists);
                $this->template->content = $view;
        }
        
        /*
        *Delete Category
        */
        public function action_delete_category()
        {      
                $category_id = $this->request->param('id');
                
                $category_delete_chk=($category_id) ? array($category_id) :  $_POST['category_chk'];
                //For Single & Multiple Selection Delete
                $select_category = $this->category->product_category($category_delete_chk[0]);
                if($select_category[0]['status']==DELETED_STATUS)
	        {
	                Message::error(__('category_allready_deleted'));
                        $this->request->redirect("category/manage_category");
	        }
	        else
	        {
	                        $select_product_category = $this->category->product_category_status($category_id,$category_delete_chk[0]);
	                        if($select_product_category == 1 )
                                {
                                        Message::success(__('category_products_live_delete'));
                                        $this->request->redirect("category/manage_category");
                                }
                                else
                                {
                                        $category_delete_chk=($category_id) ? array($category_id) :  $_POST['category_chk'];
                                        $status = $this->category->delete_category($category_delete_chk);
                                        Message::success(__('delete_category_flash'));
                                        $this->request->redirect("category/manage_category");
                                }
                }
        }
	

} // End Welcome
