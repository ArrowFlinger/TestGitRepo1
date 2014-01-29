<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains News(Add News,Manage News) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Adminnews extends Controller_Welcome {

	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->is_login();	

	}
        
        //Add Auction News 
        public function action_add_news()
        {
                $msg = "";
                $action = $this->request->action();                
                $this->selected_page_title = __("menu_add_news");
                $this->page_title = __("menu_add_news");
                $this->selected_controller_title =__('menu_master');
                $news_post=arr::get($_REQUEST,'addnews_submit');
                $errors = array();
                if(isset($news_post)){
                        $validator = $this->news->validate_add_news(arr::extract($_POST,array('news_title','news_description')));
                        if ($validator->check()) 
                        {
                                $status = $this->news->add_news($_POST,$validator);
                                if($status == 1){
                                        //Flash message 
                                        Message::success(__('add_news_flash'));	
                                        $this->request->redirect("adminnews/manage_news");
                                }
                                else if($status == 0){
                                        $news_exists = __("news_exists");
                                }
                        }
                        else{
                        $errors = $validator->errors('errors');
                        }
                }
                $this->selected_page_title = __("menu_add_news");
                $view = View::factory('admin/news_details')
                                ->bind('title',$title)
                                ->bind('errors',$errors)
                                ->bind('validator', $validator)
                                ->bind('news_exists',$news_exists)
                                ->bind('action',$action);
                $this->template->content = $view;
        }
        
         //Manage Auction News
        public function action_manage_news()
        {   
                $this->page_title = __('menu_manage_news');
                $this->selected_page_title = __('menu_manage_news');
                $this->selected_controller_title =__('menu_master');
                $view= View::factory('admin/manage_news')
                                ->bind('validator', $validator)
                                ->bind('errors', $errors)
                                ->bind('auction_news', $auction_news)
                                ->bind('pag_data',$pag_data)
                                ->bind('offset',$offset);
                $count_news = $this->news->count_news();
                //pagination loads here
                $page_no= isset($_GET['id'])?$_GET['id']:0;
                if($page_no==0 || $page_no=='index')
                $page_no = 1;
                $offset=ADM_PER_PAGE*($page_no-1);
                $pag_data = Pagination::factory(array (
                'current_page'   => array('source' => 'query_string','key' => 'id'),
                'items_per_page'  => ADM_PER_PAGE,
                'total_items'    => $count_news,
                'view' => 'pagination/punbb_userside',			  
                ));
                $auction_news = $this->news->get_news($offset, ADM_PER_PAGE);
                $this->template->content = $view;
        }
        
         //Edit Auction News
        public function action_edit_news()
        {
                $msg = "";
                $news_id = $this->request->param('id');
                $action = $this->request->action();
                $action .= "/".$news_id;
                $news_post=arr::get($_REQUEST,'editnews_submit');
                $errors = array();
                if(isset($news_post)){

                        $validator = $this->news->validate_add_news(arr::extract($_POST,array('news_title','news_description')));
                        if ($validator->check()) 
                        {
                                $status = $this->news->edit_news($news_id,$_POST);
                                if($status == 1)
                                {
                                        //Flash message 
                                        Message::success(__('update_news_flash'));
                                        $this->request->redirect("adminnews/manage_news");
                                }elseif($status == 2){
                                $msg = __('news_exists');
                                }
                                $validator = null;
                        }
                        else{
                        $errors = $validator->errors('errors');

                        }
                }
                $auction_news = $this->news->auction_news($news_id);
                $this->selected_page_title = __("menu_edit_news");
                $this->page_title = __("menu_edit_news");
                $this->selected_controller_title =__('menu_master');
                $view = View::factory('admin/news_details')
                                ->bind('current_uri',$news_id)
                                ->bind('action',$action)
                                ->bind('auction_news',$auction_news[0])
                                ->bind('errors',$errors)
                                ->bind('validator',$validator)
                                ->bind('news_exists',$news_exists);
                $this->template->content = $view;
        }

         //Delete Auction News
        public function action_delete_news()
        {      
                $news_id = $this->request->param('id');
                //For Single & Multiple Selection Delete
                $news_delete_chk=($news_id) ? array($news_id) :  $_POST['news_chk'];
                $status = $this->news->delete_news($news_delete_chk);
                //Flash message 
                Message::success(__('delete_news_flash'));
                $this->request->redirect("adminnews/manage_news");
        }
	

} // End Welcome
