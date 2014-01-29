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

class Controller_Process extends Controller_Website {

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
	public function __construct(Request $request,Response $response)
	{ 
		
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		if((preg_match('/\/process\/gateway/i',Request::detect_uri())))
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
		
		if(isset($_POST['form']) && count($_POST)>0)
		{
			$this->session->set('postvalues',$_POST['form']);
			$this->post = $_POST['form'];
		}
		else
		{
			$this->post = $this->session->get('postvalues');
			
		} 		
	}
	/****  Venkatraja  Added for 4-Mar-2013 for payment gateway added   ****/
	public function action_gateway()
	{  
		/**Check Whether the user is logged in**/
		
				$this->is_login();                
                $this->selected_page_title= __('payment_process'); 
                $payment_gateway=$this->packages->select_paymentgateways();
				$postvalues=$this->post;	
		
		if(isset($postvalues))
               {
		if(empty($postvalues)){
		Message::success(__('invalid_url'));	
                $this->request->redirect('/');
			
		}
	       }else{
		
                Message::success(__('invalid_url'));	
                $this->request->redirect('/');
               }		
                //view
                $view=View::factory(THEME_FOLDER.'process')
                                ->bind('payment_gateway',$payment_gateway)
								->bind('postvalues',$postvalues);

                $this->template->content=$view; 
                $this->template->title="Bid Packages";
		$this->template->meta_description="Packages";
		$this->template->meta_keywords="Auctions Bid packages"; 
	}
/** venkatraja added end **/
}//End of users controller class
?>
