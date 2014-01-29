<?php defined("SYSPATH") or die("No direct script access.");

class Controller_Offline extends Controller_Website {
	public function __construct(Request $request,Response $response)
	{
              
		parent::__construct($request,$response);
		
			/** redirect maintainance mode page start **/

		if( ($this->site_settings[0]['maintenance_mode'] != ACTIVE) ){

			//Check logged user as admin 
			if((preg_match('/offline\/index/i',Request::detect_uri()))){

				$this->request->redirect("/");
			}
		}


		$this->template="themes/template";
		
		

		 
		/**To get selected theme template**/
		if(file_exists(VIEW_PATH.'template.php'))
		{
			$this->template=SELECTED_THEME_FOLDER.'template';
		}  
                        
					
	}				
   
	/**
	* Action for Offline mode
	**/
	public function action_index()
	{
	 
	    $view=View::factory(THEME_FOLDER."offline");
	    
	    $this->template->content=$view;	
		
		$this->template->title=__('offline_mode');
		$this->template->meta_description=__('offline_mode');
		$this->template->meta_keywords=__('offline_mode');
		
	}

}
?>
