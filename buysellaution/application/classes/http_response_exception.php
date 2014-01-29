

<?php defined('SYSPATH') or die('No direct script access.');
 
/** 
 * Custom exception handler for typical 404/500 error
 * 
 * @author Lysender
 *
 */
class HTTP_Response_Exception extends Kohana_Exception 
{
    
	public static function exception_handler(Exception $e)
	{
		if (Kohana::DEVELOPMENT === Kohana::$environment)
		{
			Kohana_Core::exception_handler($e);
		}
		else
		{
			Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
	 
			$attributes = array
			(
				'action'  => 500,
				'message' => rawurlencode($e->getMessage())
			);
	 
			if ($e instanceof HTTP_Response_Exception)
			{
				$attributes['action'] = $e->getCode();
			}
	 
			// Error sub-request.
			echo Request::factory(Route::url('error', $attributes))
				->execute()
				->send_headers()
				->response;
		}
	}
}
?>
