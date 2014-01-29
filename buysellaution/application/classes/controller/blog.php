<?php defined('SYSPATH') or die('No direct script access.');

/* Contains Blog Settings() details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/
class Controller_Blog extends Controller_Welcome 
{
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
	}
	
	// Add Blog Category
	public function action_add_blog_category()
        {
              
                $msg = "";
                 $this->selected_page_title = __("menu_add_blog_category");
                $action = $this->request->action();                
                $this->selected_page_title = __("menu_add_blog_category");
                $this->selected_controller_title =__('menu_blog_settings');
                $this->page_title = __("menu_add_blog_category");
                $category_post=arr::get($_REQUEST,'addcat_submit');
                $errors = array();
                if(isset($category_post)){
                        $validator = $this->blog->validate_add_blog_category(arr::extract($_POST,array('category_name')));
                        if ($validator->check()) 
                        {
                                $status = $this->blog->add_blog_category($_POST,$validator);
                                if($status == 1){
                                        //Flash message 
                                        Message::success(__('add_blog_category_flash'));	
                                        $this->request->redirect("blog/blog_category");
                                }
                                else if($status == 0){
                                        $category_exists = __("category_exists");
                                }
                        }
                        else{
                        $errors = $validator->errors('errors');
                        }
                }
              
                $this->selected_page_title = __("menu_add_blog_category");
                $this->selected_controller_title =__('menu_blog_settings');
                $view = View::factory('admin/blog_category_details')
                        ->bind('title',$title)
                        ->bind('errors',$errors)
                        ->bind('validator', $validator)
                        ->bind('category_exists',$category_exists)
                        ->bind('action',$action);
                $this->template->content = $view;
        }
        
        // Manage Blog category 
        public function action_blog_category()
        {
                $this->page_title = __('menu_manage_blog_category');
                $this->selected_page_title = __('menu_manage_blog_category');
                $this->selected_controller_title =__('menu_blog_settings');
                $view= View::factory('admin/blog_category')
                ->bind('validator', $validator)
                ->bind('errors', $errors)
                ->bind('blog_categories', $blog_category)
                ->bind('blog_categories_count', $blog_category_coumt)
                ->bind('pag_data',$pag_data)
                ->bind('offset',$offset);
                                $count_blog_cat = $this->blog->count_blog_category();
                                //pagination loads here
                                $page_no= isset($_GET['id'])?$_GET['id']:0;
                                if($page_no==0 || $page_no=='index')
                                $page_no = 1;
                                $offset=ADM_PER_PAGE*($page_no-1);
                                $pag_data = Pagination::factory(array (
                                'current_page'   => array('source' => 'query_string','key' => 'id'),
                                'items_per_page'  => ADM_PER_PAGE,
                                'total_items'    => $count_blog_cat,
                                'view' => 'pagination/punbb',			  
                                ));
                $blog_category = $this->blog->get_blog_category($offset, ADM_PER_PAGE);
                $this->template->content = $view;
        }

        // Edit Blog category
        public function action_edit_blog_category()
        {
                $msg = "";
                $cat_id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$cat_id;
                $blog_category_post=arr::get($_REQUEST,'editcat_submit');
                $errors = array();
                if(isset($blog_category_post)){

                        $validator = $this->blog->validate_add_blog_category(arr::extract($_POST,array('category_name')));
                        if ($validator->check()) 
                        {
                                $status = $this->blog->edit_blog_category($cat_id,$_POST);
                                if($status == 1)
                                {
                                        //Flash message 
                                        Message::success(__('update_blog_category_flash'));
                                        $this->request->redirect("blog/blog_category");
                                }elseif($status == 2){
                                $msg = __('category_exists');
                                }
                                $validator = null;
                        }
                        else{
                        $errors = $validator->errors('errors');

                        }
                }
                $blog_categories = $this->blog->blog_category($cat_id);
                $this->selected_page_title = __("menu_edit_blog_category");
                $this->selected_controller_title =__('menu_blog_settings');
                $this->page_title = __("menu_edit_blog_category");
                $view = View::factory('admin/blog_category_details')
                        ->bind('current_uri',$cat_id)
                        ->bind('action',$action)
                        ->bind('blog_categories',$blog_categories[0])
                        ->bind('errors',$errors)
                        ->bind('validator',$validator)
                        ->bind('category_exists',$category_exists);
                $this->template->content = $view;
        }

        // Blog category delete
        public function action_blog_delete_category()
        {      
                $category_id = $this->request->param('id');
                //For Single & Multiple Selection Delete
                $category_delete_chk=($category_id) ? array($category_id) :  $_POST['category_chk'];
                $status = $this->blog->blog_delete_category($category_delete_chk);
                //Flash message 
                Message::success(__('delete_blog_category_flash'));
                $this->request->redirect("blog/blog_category");
        }
	
	
	/*
	*Manage Blog Settings
	*@Manage View Lists
	*With Pagenation  
	*/
	public function action_index()
	{
	          $this->page_title=__("manage_blog_settings");
	          $this->selected_page_title=__("manage_blog_settings");
	          $this->selected_controller_title =__('menu_blog_settings');
	          $view= View::factory('admin/manage_blog')
                                        ->bind('validator', $validator)
                                        ->bind('errors', $errors)
                                        ->bind('blog_data', $blog_data)
                                        ->bind('blog_data_count', $blog_data_coumt)
                                        ->bind('pag_data',$pag_data)
                                        ->bind('offset',$offset);
                                $count_blog_data = $this->blog->count_blog_data();
                                //pagination loads here
                                $page_no= isset($_GET['id'])?$_GET['id']:0;
                                if($page_no==0 || $page_no=='index')
                                $page_no = 1;
                                $offset=ADM_PER_PAGE*($page_no-1);
                                $pag_data = Pagination::factory(array (
                                'current_page'   => array('source' => 'query_string','key' => 'id'),
                                'items_per_page'  => ADM_PER_PAGE,
                                'total_items'    => $count_blog_data,
                                'view' => 'pagination/punbb',			  
                                ));
                $blog_data = $this->blog->get_blog_data($offset, ADM_PER_PAGE);
                
                $this->template->content = $view;
	}
	
	/*
	*Add Blog Settings
	*@Post Blog 
	*/
	public function action_add_blog()
        {
            
                $this->page_title=__("menu_add_blog");
                $this->selected_page_title=__("menu_add_blog");
                $this->selected_controller_title =__('menu_blog_settings');
                $action = $this->request->action();
                //getting request for form submit
                $add_blog =arr::get($_REQUEST,'addblog_submit');              
                //validation starts here
                                
                if(isset($add_blog) && Validation::factory($_POST))
                {
			    
                        $validator = $this->blog->validate_add_blog_form(arr::extract($_POST,array('blog_title','blog_description','category')));
                          //validation check
                        if ($validator->check()) 
                        { 
                              /*Products add process starts here**/                      
                                        $status = $this->blog->add_blog($validator,$_POST);
                                         if($status == 1){
                                        //Flash message for sucess product add                                             
                                        Message::success(__('add_blog_success'));
                                        /*Blog Listings Page Redirection*/                                           
                                        $this->request->redirect("blog/index");
                                        }
                                else if($status == 0){
                                        $blog_exists = __("blog_exists");
                                }
                        }
                        else{
                       
                        //validation error msg hits here
                        $errors = $validator->errors('validation');
                        }
                       
		}	
		 		
                $blog_category_list = $this->blog->blog_category_list();
                $view=View::factory("admin/add_blog")
                        ->bind('title',$title)
                         ->bind('blog_category_list', $blog_category_list)
                        ->bind('validator', $validator)
                        ->bind('messages', $messages)
                        ->bind('blog_exists',$blog_exists)
                        ->bind('errors',$errors)
                        ->bind('action',$action);
	          $this->template->content=$view;
	}
	
	//Edit & update Blog 
	 public function action_edit_blog()
        {
                $msg = "";
                $blog_id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$blog_id;
                $edit_blog=arr::get($_REQUEST,'editblog_submit');
                $errors = array();
                if(isset($edit_blog)){
                        $validator = $this->blog->validate_edit_blog_form(arr::extract($_POST,array('blog_title','blog_description','category')));
                        if ($validator->check()) 
                        {
                                $status = $this->blog->edit_blog($blog_id,$_POST);
                                
                                        //Flash message 
                                        Message::success(__('update_blog_flash'));
                                        $this->request->redirect("blog/index");
                               
                                $validator = null;
                        }
                        else{
                        $errors = $validator->errors('errors');

                        }
                }
                $blog_category_list = $this->blog->blog_category_list();
                $blog_data = $this->blog->blog_data($blog_id);
                $this->selected_page_title = __("menu_edit_blog");
                $this->selected_controller_title =__('menu_blog_settings');
                $this->page_title = __("menu_edit_blog");
                $view = View::factory('admin/add_blog')
                        ->bind('current_uri',$blog_id)
                        ->bind('action',$action)
                         ->bind('blog_category_list', $blog_category_list)
                        ->bind('blog_data',$blog_data[0])
                        ->bind('errors',$errors)
                        ->bind('validator',$validator);
                $this->template->content = $view;
        }
        
        //Delete Blog 
        public function action_delete_blog()
        {      
                $blog_id = $this->request->param('id');
                //For Single & Multiple Selection Delete
                $delete_blog_chk=($blog_id) ? array($blog_id) :  $_POST['blog_chk'];
                $status = $this->blog->delete_blog($delete_blog_chk);
                //Flash message 
                Message::success(__('delete_blog_flash'));
                $this->request->redirect("blog/index");
        }
        
        /*
	*Manage Blog Comments Settings
	*@Manage View Lists
	*With Pagenation  
	*/
	public function action_manage_comments()
	{
	          $this->page_title=__("menu_manage_comments");
	          $this->selected_page_title=__("menu_manage_comments");
	          $this->selected_controller_title =__('menu_blog_settings');
	          $view= View::factory('admin/manage_comment')
                                        ->bind('validator', $validator)
                                        ->bind('errors', $errors)
                                        ->bind('comments_data', $comments_data)
                                        ->bind('blog_data_count', $blog_data_coumt)
                                        ->bind('pag_data',$pag_data)
                                        ->bind('offset',$offset);
                                $count_blog_comments = $this->blog->count_blog_comments();
                               //pagination loads here
                                $page_no= isset($_GET['id'])?$_GET['id']:0;
                                if($page_no==0 || $page_no=='index')
                                $page_no = 1;
                                $offset=ADM_PER_PAGE*($page_no-1);
                                $pag_data = Pagination::factory(array (
                                'current_page'   => array('source' => 'query_string','key' => 'id'),
                                'items_per_page'  => ADM_PER_PAGE,
                                'total_items'    => $count_blog_comments,
                                'view' => 'pagination/punbb',			  
                                ));
                $comments_data = $this->blog->get_blog_comments($offset, ADM_PER_PAGE);
                $this->template->content = $view;
	}
	
	//Delete Blog Comments 
	public function action_delete_comment()
        {      
                $comment_id = arr::get($_REQUEST,'commentid');
		$blog_id = arr::get($_REQUEST,'blodig');
		$status = $this->blog->delete_comments($comment_id,$blog_id);
                //Flash message 
                Message::success(__('delete_blog_comments_flash'));
                $this->request->redirect("blog/manage_comments");
        }
        
        // Comments details view 
	public function action_comment_details()
	{
		//set page title
		$this->page_title =  __('menu_comment_details');
		$this->selected_page_title = __('menu_comment_details');
		$this->selected_controller_title =__('menu_blog_settings');
		$commentid = $this->request->param('id');
		$message_results=$this->blog->select_comment_details($commentid);
		$update_message_details=$this->blog->update_message_details($commentid);
		$view = View::factory('admin/comment_details')
				->bind('message_results',$message_results);
		echo $view;
		exit;
	}
        
	
}
//End blog controller	
