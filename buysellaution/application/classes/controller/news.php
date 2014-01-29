<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains User controller actions
 *
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_News extends Controller_Website {

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
	public function __construct(Request $request,Response $response)
	{
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		if(!(preg_match('/users\/login/i',Request::detect_uri()) || preg_match('/users\/signup/i',Request::detect_uri()) || preg_match('/users\/testimonials_details/i',Request::detect_uri()) || preg_match('/news\/news_details/i',Request::detect_uri()) || preg_match('/users\/forgot_password/i',Request::detect_uri())  ))
		{
			//Override the template variable decalred in website controller
                        $this->template=THEME_FOLDER."template_user_sidebar";
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
	
	// Display all Auction News 
	public function action_news_details()
	{
		$this->selected_page_title = __('menu_news');
		$view=View::factory(THEME_FOLDER."news_details")
				->bind('news_results',$news_results)
				->bind('pagination',$pagination);
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 			$count_news_auctions =$this->news->count_news();
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_news_auctions,  //total items available
                        'items_per_page'  => ADM_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        )); 
		$news_results=$this->news->get_news($offset,ADM_PER_PAGE);
		
		//****pagination ends here***//
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
}//End of users controller class
?>
