<?php defined('SYSPATH') or die('No direct script access.');

/* Contains CMS Page(Mange Static pages) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Cms extends Controller_Welcome 
{

	public function __construct(Request $request, Response $response)
	{

		parent::__construct($request, $response);
		$this->cms = Model::factory('Cms');
	}
	
        /**
        * ****manage_static_pages()****
        * manage static pages
        */	 
         public function action_manage_static_pages()
        {
        
                        //page and menu title
                        //====================
                        $this->selected_page_title = __("page_title_static");
                        $this->page_title = __('page_title_static');
                        $this->selected_controller_title =__('menu_general_settings');

                        //auth login check
                        $this->is_login();

                        //creating object for model	
                        $cms_static_pages = Model::factory('cms');		        

                        $count_pages_list = $cms_static_pages->count_pages_list();

                        //pagination loads here
                        //-------------------------
                        $page_no= isset($_GET['page'])?$_GET['page']:0;

			if($page_no==0 || $page_no=='index')
			$page_no = PAGE_NO;
			$offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                        $pag_data = Pagination::factory(array (
                        'current_page'   => array('source' => 'query_string','key' => 'page'),
                        'items_per_page' => ADM_PER_PAGE,
                        'total_items'    => $count_pages_list,
                        'view' => 'pagination/punbb',			  
			));
	   
                        $all_pages_list = $cms_static_pages->all_pages_list($offset, ADM_PER_PAGE);
                        //****pagination ends here***//
                        //send data to view file 
                        $view = View::factory('admin/site_static_pages_details')
					   ->bind('current_uri',$id)
					   ->bind('action',$action)
					   ->bind('offset',$offset)
					   ->bind('pag_data',$pag_data)
					   ->bind('all_pages_list',$all_pages_list)
			   		   ->bind('validator',$validator)	           
					   ->bind('errors',$errors);
		    $this->template->content = $view;

 		}
 

		/**
		 * ****edit_static_pages()****
		 * edit static pages
		 */	
        public function action_edit_static_pages()
        {
		//page title
		//============
		$this->selected_page_title = __("page_title_static");
		$this->page_title = __('page_title_static');     
		$this->selected_controller_title =__('menu_general_settings');
		
		//get current page segment id 
		$page_id = $this->request->param('id');

		//check current action
		$action = $this->request->action();
		$action .= "/".$page_id ;			
		
		//creating object for model	
                $cms_static_pages = Model::factory('cms');			

		//getting request for form submit
		$page_edit = arr::get($_REQUEST,'edit_pages_submit');

		$errors = array();


		//validation starts here	
		if(isset($page_edit) && Validation::factory($_POST))
		{
	
                        //****send validation fields into model for checking rules***//

                        $validator = $cms_static_pages->edit_static_page_form(arr::extract($_POST,array('page_title','page_url','page_description',
                        'meta_title','meta_keyword')));	

                        //validation starts here			 		
                        if ($validator->check()) 
                        { 

                        //*********page edit process starts here*************//

                        $status = $cms_static_pages->edit_page_data($page_id,$_POST);
                        //Flash message 
                        Message::success(__('static_page_update_flash'));
                        //page redirection after success
                        $this->request->redirect("cms/manage_static_pages");
                        }else{
                        //validation failed, get errors
                        $errors = $validator->errors('errors'); 
                        }
		 }
			
                //send data to view file 
                $page_data = $cms_static_pages->get_all_static_page_details($page_id);
                //send data to view file 
                $view = View::factory('admin/site_manage_static_pages')
                        ->bind('current_uri',$id)
                        ->bind('action',$action)
                        ->bind('page_data',$page_data[0])
                        ->bind('validator',$validator)	           
                        ->bind('errors',$errors);	
                $this->template->content = $view;
	}


	/**
	 * ****show_static_pages()****
	 * show static pages
	 */	
	public function action_show_static_pages()
	{
		//page title
                //============
                $this->selected_page_title = __("page_title_static");
                $this->page_title = __('page_title_static'); 
                $this->selected_controller_title =__('menu_general_settings');
                //get current page segment id 
                $page_id = $this->request->param('id');
                //creating object for model	
                $cms_static_pages = Model::factory('cms');	
                //send data to view file 
                $page_data = $cms_static_pages->show_static_page_content($page_id);
                $view = View::factory('admin/show_static_pages')
                        ->bind('current_uri',$id)
                        ->bind('action',$action)
                        ->bind('page_data',$page_data[0]);
                $this->template->content = $view;	

	}
} // End cms
