<?php defined("SYSPATH") or die("No direct script access.");
/**
* Contains User controller actions

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Userblog extends Controller_Website {

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
	public function __construct(Request $request,Response $response)
	{
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		if(!(preg_match('/users\/login/i',Request::detect_uri()) || preg_match('/users\/signup/i',Request::detect_uri()) || preg_match('/users\/testimonials_details/i',Request::detect_uri()) || preg_match('/news\/news_details/i',Request::detect_uri()) || preg_match('/blog\/blog_details/i',Request::detect_uri()) || preg_match('/blog\/blog_inner/i',Request::detect_uri()) || preg_match('/users\/forgot_password/i',Request::detect_uri())  ))
		{
			//Override the template variable decalred in website controller
                        $this->template="themes/template_user_sidebar";
                }	
		else
		{
			//Override the template variable decalred in website controller
                        $this->template="themes/template";
                        
                        /**To get selected theme template**/
				if(file_exists(VIEW_PATH.'template.php'))
				{
					$this->template=SELECTED_THEME_FOLDER.'template';
				}  
                        
                        
		}
		
		if(preg_match('/users\/invite/i',Request::detect_uri()))
		{
			FB::instance()->auth();
		}
	}
	
	// Display all Auction blog 
	public function action_blog_details()
	{
		$view=View::factory(THEME_FOLDER."blog_details")
				->bind('blog_results',$blog_results)
				->bind('pagination',$pagination);
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 			$count_blog_auctions =$this->userblog->count_blog();
 			
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_blog_auctions,  //total items available
                        'items_per_page'  => ADM_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
			
		$blog_results=$this->userblog->get_blog($offset,ADM_PER_PAGE);
		//print_r($blog_results); exit;
		//****pagination ends here***//
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	// Display blog details
	
	public function action_blog_inner()
	{
	        $blogid=$this->request->param('id');
	        $get_blog_auctions =$this->userblog->get_blog_value($blogid);
	        $get_blog_comments =$this->userblog->get_blog_comments($blogid);
		$view=View::factory(THEME_FOLDER."blog_inner")
				->bind('get_blog_auctions',$get_blog_auctions[0])
				->bind('form_values',$form_values)
				->bind('get_blog_comments',$get_blog_comments)
				->bind('validate',$validate)
				->bind('errors',$errors);
	        $form_values=arr::extract($_POST, array('blog_id','username','useremail','comment','website'));
		$validate=$this->userblog->command_validation($form_values);
		$submit=$this->request->post('blog_comment');
		if(isset($submit))
		{
			if($validate->check())
			{
			        $result=$this->userblog->add_commant($_POST,$this->auction_userid);
				//Session set for success msg
				Message::success(__('comment_successfully'));
				$this->request->redirect("userblog/blog_details/");
				$form_values=NULL;
			}
			else
			{
				//Fetch the error message and store in $errors array
				$errors=$validate->errors('errors');
			}
		}
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
			
}//End of users controller class
?>
