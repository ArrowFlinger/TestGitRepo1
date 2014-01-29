<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Exception extends Kohana_Kohana_Exception
{
	
    public static function handler(Exception $e)
    {
		
        // Throw errors when in development mode
        if (Kohana::$environment === Kohana::DEVELOPMENT)
        {
            parent::handler($e);
        }
        else
        {
					Kohana::$log->add(Log::ERROR, Kohana_Exception::text($e));
					 
					$attributes = array(
						'action'    => 500,
						'origuri'   => rawurlencode(Arr::get($_SERVER, 'REQUEST_URI')),
						'message'   => rawurlencode($e->getMessage())
					);
					 if ($e instanceof ReflectionException)
					{
						// Reflection will throw exceptions for missing classes or actions
						$this->status = 404;
					}
					else if ($e instanceof Http_Exception)
					{
						$attributes['action'] = $e->getCode();
					}
					// Get the error uri
					$uri = Route::get('error')->uri($attributes);
					// Error sub-request.
					echo Request::factory($uri )
								->execute()
								->send_headers()
								->body();     
			  
        }
    }
}
?>
