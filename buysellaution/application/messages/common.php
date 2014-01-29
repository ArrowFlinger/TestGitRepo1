<?php defined('SYSPATH') OR die('No direct access allowed.'); 
class common{
	public function __construct()
	{
		parent::__construct();
		$this->session = Session::instance();
	}
	
	/** SET STATUS MESSAGE **/
	
	public function message($type = "", $message = "")
	{
		if($type == 1){
			$this->session->set("Success", $message);
		}
		elseif($type == -1){
			$this->session->set("Error",$message);
		}
	}
	
	/** SEND EMAIL **/
	
	public function sentmail($to = "", $from = "", $subject = "", $message = "")
	{
		if($from == ""){
			$from = $this->message = Kohana::config('settings.admin_email');
		}
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:'.$from.'' . "\r\n";
		mail($to, $subject, $message, $headers); 
	}
	
}
?>
