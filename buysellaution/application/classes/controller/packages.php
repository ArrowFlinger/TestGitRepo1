<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains package controller actions
 *
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Packages extends Controller_Website {

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
	public function __construct(Request $request,Response $response)
	{ 
		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		if((preg_match('/\/packages\/package/i',Request::detect_uri()))||(preg_match('/\/packages\/gateway/i',Request::detect_uri()))||(preg_match('/\/packages\/payment_order_success/i',Request::detect_uri())))
		{
                	//Override the template variable decalred in website controller
                        $this->template="themes/template";
                        
                         
                        /**To get selected theme template**/
			if(file_exists(VIEW_PATH.'template.php'))
			{
				$this->template=SELECTED_THEME_FOLDER.'template';
			}  
                
                        
                }	
              	else
		{
			//Override the template variable decalred in website controller
                        $this->template=THEME_FOLDER."template_user_sidebar";
		}
		
	}
	
	public function action_index()
	{  
		//Check login
		$this->selected_page_title= __('buy_packages');
		$payment_gateway=$this->packages->select_paymentgateways();
		
		
		$this->is_login();
		$view=View::factory(THEME_FOLDER."packages")
				->bind('payment_gateway',$payment_gateway)
				->bind('package_results',$package_result)
				->bind('count_package_result',$count_package_result)
				->bind('pagination',$pagination);		
			
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 		
 			$count_package_result=$this->packages->select_amount_packages(NULL,REC_PER_PAGE,TRUE);
                        if($page_no==0 || $page_no=='index')
		                $page_no = PAGE_NO;
		                $offset = ADM_PER_PAGE*($page_no-PAGE_NO);
		                $pagination = Pagination::factory(array (
		                'current_page' => array('source' => 'query_string', 'key' => 'page'),
		                'total_items'    => $count_package_result,  //total items available
		                'items_per_page'  => ADM_PER_PAGE,  //total items per page
		                'view' => 'pagination/punbb_userside',  //pagination style
		                'auto_hide'      => TRUE,
		                'first_page_in_url' => TRUE,
                        ));   
		$package_result=$this->packages->select_amount_packages($offset,ADM_PER_PAGE);
		
		//****pagination ends here***//

		$this->template->content=$view;
		$this->template->title="Bid Packages";
		$this->template->meta_description="Packages";
		$this->template->meta_keywords="Auctions Bid packages";
	}
	
	public function action_package()
	{  
		/**Check Whether the user is logged in**/
		
		$this->is_login(); 
                $userid = $this->session->get('auction_userid');

                //direct access restrict  
		$package_id=$this->request->param('id');              
                //$package_id = Arr::get($_GET,'id');
                if(!isset($package_id)){                                 
                     $this->request->redirect('/');   
                }

		/**To get job amount for the received job id**/
		$package_amount= $this->packages->get_received_packageamount($package_id);

                //view
                $view=View::factory(THEME_FOLDER.'package_order')
				->bind('package_amount',$package_amount)
                		->bind('package_id',$package_id);

                $this->template->content=$view; 
                $this->template->title="Bid Packages";
		$this->template->meta_description="Packages";
		$this->template->meta_keywords="Auctions Bid packages"; 
	}
	
	
	public function action_payment_order_success()
	{
		$this->is_login(); 
		$view=View::factory(THEME_FOLDER.'order_success_temp');
                $this->template->content=$view; 
                $this->template->title="Bid Packages- Payment Success";
		$this->template->meta_description="Payment success";
		$this->template->meta_keywords="Auctions Bid packages - payment success"; 
	}
}//End of users controller class
?>
