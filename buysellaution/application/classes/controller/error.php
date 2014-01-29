<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains Dashboard(User Deatails,Product Details) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Error extends Controller_Website
{
	
    /**
     * All methods should be internal only, otherwise 404
     */
    public function before()
    {
        parent::before();

        // Get the HTTP status code
        $action = $this->request->action();

        if ($this->request->is_initial())
        {
            // This controller happens to exist, but lets pretent it does not
            $this->request->action($action = 404);
        }
        else if ( ! method_exists($this, 'action_'.$action))
        {
            // Return headers only
            $this->request->action('empty');
        }

        // Set the HTTP status code
        $this->response->status($action);
    }

    public function action_empty() {}

    public function action_404()
    {
	         
		//$view=View::factory('user/')->render();
		echo new View(THEME_FOLDER."/error/404");
		exit;
		// Here we check to see if a 404 came from our website. This allows the
		// webmaster to find broken links and update them in a shorter amount of time.
		//if (Request::$initial->referrer() AND strstr(Request::$initial->referrer(), $_SERVER['SERVER_NAME']) !== FALSE)
		//{
		//  // Set a local flag so we can display different messages in our template.
		//  $this->template->local = TRUE;
		//}
    }

    public function action_503()
    {
        $this->response->body('Maintenance Mode');
    }

    public function action_500()
    {
        $this->response->body('Internal Server Error');
    }

} // End Controller_Error
