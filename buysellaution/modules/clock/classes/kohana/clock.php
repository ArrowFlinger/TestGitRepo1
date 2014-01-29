<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Modulename — My own custom module.
 *
 * @package    Commonfunction
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Kohana_Clock extends Controller_Site_Clock {
	
	/**
	* @var array configuration settings
	*/
	protected $_config = array();
	protected $_clock ;

	/**
	* Class Main Constructor Method
	* This method is executed every time your module class is instantiated.
	*/
	public function __construct() 
	{	
		
		$this->session=Session::instance();
		$this->clock_model = Model::factory('clock');	
		$this->checking_time=CHECKING_TIME;
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		$this->site_currency =SITECURRENCY;
		$this->update_autobid_account();
	}
	
	public function timediff($time)
	{
		$tDiff = $time - time();
		$days = floor($tDiff / 86400);//Calc Days
		$hours = ($tDiff / 3600) % 24;//Calc hours
		$mins = ($tDiff / 60) % 60;//Calc mins
		$secs = ($tDiff) % 60;//Calc Secs
		//return array('day' => $days , 'hr' => $hours , 'min' => $mins, 'sec' => $secs);
		/*        
      $tDiff = $time + time();
      $days = floor($tDiff / 86400);//Calc Days
      $hours = ($tDiff / 3600) % 24;//Calc hours
      $mins = ($tDiff / 60) % 60;//Calc mins
      $secs = ($tDiff) % 60;//Calc Secs */
		$now = strtotime ("now");
      $then = strtotime ($time);
		//echo $then; exit;
      $difference = $now - $then ;
      $num = $difference/86400;
      $days = intval($num);
      $num2 = ($num - $days)*24;
      $hours = intval($num2);
      $num3 = ($num2 - $hours)*60;
      $mins = intval($num3);
      $num4 = ($num3 - $mins)*60;
      $secs = intval($num4);
      return array('day' => $days , 'hr' => $hours , 'min' => $mins, 'sec' => $secs);
   }
	
	/**
	 * ****Checking current status of the auction item****
	 * @param $sdate , $edate eg. 2011-11-16 20:15:00
	 * @return 0 1 2
	 */	
	public function currentstatus($sdate,$edate)
	{
		$currentdate=$this->getCurrentTimeStamp;
		$today=date("Y-m-d")." "."23:59:59";
		if($sdate > $currentdate)
		{
			return 0;//Coming soon
		}
		else if($sdate < $currentdate)
		{
			return 1;//live
		}
		else if($edate < $currentdate)
		{
			return 2;//closed
		}
		
	}
	
	public function update_autobid_account()
	{
		 
		$result=$this->clock_model->selectall_autobid_closed();
		 
		foreach($result as $products)
		{
			if($products['dedicated_auction']!=ENABLE){
				//get user balance and add the amount
				$amts= Commonfunction::get_user_balance($products['userid']) + $products['bid_amount'];
			}
			else
			{
				//get user bonus and add the amount
				$amts=Commonfunction::get_user_bonus($products['userid'])+$products['bid_amount'];	

			}			
			$this->clock_model->update(USERS,array('user_bid_account'=>$amts),'id',$products['userid']);
			$this->clock_model->delete_autobid($products['userid'],$products['product_id']);
		}
		return;
	}
	
	public function process($pid,$status=1,$array=array())
	{				
		$product_results = $this->clock_model->select_products_detail($pid,$status,$array);	
		$array=array();	
		foreach($product_results  as $product_result)
		{
				if($product_result['auction_process']==RESUMES)
				{
					//Decrement the db timestamp with current timestamp (unix timestamp e.g: 1236545888)
					$time_stamp=$product_result['increment_timestamp']-time();					
				}
				else if($product_result['auction_process']==HOLD)
				{
					//increment the db timestamp when holded (unix timestamp e.g: 1236545888)
					$time_stamp=$product_result['increment_timestamp']+20;
					$current_status=3;
					$time=__('paused');
				}
				if($product_result['in_auction']==2)
				{
					$current_status=2;
				}
				$time_stamp=$product_result['increment_timestamp']-time();
				$current_status=$this->currentstatus($product_result['startdate'],$product_result['enddate']);
				$today=$this->today_midnight();
				$status=($today>$product_result['increment_timestamp'])?__("start_on_label_today")." ".substr($this->date_to_string($product_result['startdate']),7,20):__("start_on_label")." ".$this->date_to_string($product_result['startdate']);
						$resume_time=($today>$product_result['increment_timestamp'])?substr($this->date_to_string($product_result['startdate']),7,20):$this->date_to_string($product_result['startdate']);
						
				if(($product_result['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH_THUMB.$product_result['photo']))
				{ 
					$user_img_path=URL_BASE.USER_IMGPATH_THUMB.$product_result['photo'];
				}
				else
				{
					$user_img_path=IMGPATH.USER_NO_IMAGE;
				}
				$sessionuserid=$this->session->get('auction_userid');
				
				
				if($sessionuserid==$product_result['lastbidder_userid'] &&
					($product_result['clock_buynow_status'] == NOTPROCESS ||
						($product_result['clock_buynow_status']==PROCESS &&
							$sessionuserid==$product_result['lastbidder_userid'])
					)
				){
					$clock_buynow_status=true;
				}else{
					$clock_buynow_status=false;
				}
				
				
				self::auction_order_status($product_result);
				$array[]= array("Product"=> array("id"=>$product_result['product_id'],
							"currency"=>$this->site_currency,
							"current_price"=>$this->site_currency." ".Commonfunction::numberformat($product_result['current_price']),
							"price" =>$product_result['current_price'],
							"current_status" =>$current_status,
							"extras"=>array('bidamount' => $product_result['bidamount'],
							'product_cost'=> $product_result['product_cost']),
							"status"=>$status,
							"product_process" => $product_result['product_process'],
							"clock_buynow_status"=>$clock_buynow_status,
							"auction_type" => $product_result['auction_type'],
							"resume_time" =>$resume_time,
							"db_timestamp" => $product_result['increment_timestamp'],
							"element" =>"auction_".$product_result['product_id'],
							"lastbidder"=>$product_result['lastbidder_userid'],
							"user_img" =>$user_img_path,
							"autobid" =>$product_result['autobid'],
							"time_diff" => $this->timediff($product_result['startdate']),
							"unix_timestamp" =>$this->create_timestamp($this->getCurrentTimeStamp),
							"element"=>"auction_".$product_result['product_id'],	
							
							"checking_time" =>$this->checking_time),
							"settingIncrement" => array("countdown"=>time()+$product_result['max_countdown'],
							'timestamp' =>$time_stamp),
							"Users"=>array("username"=>ucfirst($product_result['username']),
											"lat"=>$product_result['latitude'],
											"lng"=>$product_result['longitude']));	
				
				
			}
		return $array;
		
	}
	
		
	public static function product_block($pids,$status="",$arrayset=array())
	{
		$clock = Model::factory('clock');		
		$productsresult = $clock->select_products_detail($pids,$status,$arrayset);
		 
		switch($status)
		{
			case 3:
			$view = View::factory('clock/'.THEME_FOLDER.'auctions/future')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 6:
			$view = View::factory('clock/'.THEME_FOLDER.'auctions/product_detail')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 2:
			$view = View::factory('clock/'.THEME_FOLDER.'auctions/closed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 10:
			$view = View::factory('clock/'.THEME_FOLDER.'auctions/winner')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 7:
			$view = View::factory('clock/'.THEME_FOLDER.'auctions/closedunclosed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;				
			case 8:
			$view = View::factory('clock/'.THEME_FOLDER.'auctions/closedunclosed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			default:
			$view = View::factory('clock/'.THEME_FOLDER.'auctions/live') 
							->set('productsresult', $productsresult)
							->set('status',$status); 
							break;
		}					
		return $view->render();
	}
	
	//Clock table buynow status date update & status also
	public static function getBuynowStatusDateUpdate($pid)
	{
		$clock = Model::factory('clock');	
		$clock_buynow = $clock->select_clock_buynowstatusdate($pid);
		$clock_buynow_date=$clock_buynow['clock_buynow_status_date'];
		/**Time diff*/
		$now = strtotime ("now");
		$then = strtotime ($clock_buynow_date);
		$difference = $now - $then ;
		$num = $difference/86400;
		$days = intval($num);
		$num2 = ($num - $days)*24;
		$hours = intval($num2);
		$num3 = ($num2 - $hours)*60;
		$mins = intval($num3);
		$num4 = ($num3 - $mins)*60;
		$secs = intval($num4);
		$timedetails=array('day' => $days , 'hr' => $hours , 'min' => $mins, 'sec' => $secs);
		/**Time diff**/
		if($mins>=15){
			$clock->update_buynow_status($pid,NOTPROCESS);
		}

		return $mins;
		
	}
	
	//End date count notification
	public static function getEnddateCount($edate)
	{
		/**Time diff*/
		$now = strtotime ("now");
		$then = strtotime ($edate);
		$difference = $now - $then ;
		$num = $difference/86400;
		$days = intval($num);
		$num2 = ($num - $days)*24;
		$hours = intval($num2);
		$num3 = ($num2 - $hours)*60;
		$mins = intval($num3);
		$num4 = ($num3 - $mins)*60;
		$secs = intval($num4);
		$timedetails=array('day' => abs($days) , 'hr' => abs($hours) , 'min' => abs($mins), 'sec' => abs($secs));
		return $timedetails;
	}
	
	//auction_order_status 
	public static function auction_order_status($product_result = array())
	{	 
		$clock = Model::factory('clock');
		if(count($product_result)>0)
		{
			$auction_order_status = $clock->auction_order_status($product_result['product_id']); 
			if($auction_order_status>0){
				$date=Commonfunction::getCurrentTimeStamp(); 
						 
			$clock->update(CLOCK, array('product_process'=>CLOSED,'enddate' => $date),'product_id',$product_result['product_id']);
			$clock->update(PRODUCTS, array('enddate' => $date,'in_auction' => 2,'lastbidder_userid' => $product_result['lastbidder_userid'],'current_price' => $product_result['current_price'],'product_process'=>CLOSED),'product_id',$product_result['product_id']);	
				 
			}
		} 
		
	}
	
	
	//for call the styles and scripts based on module
	static public function loadmedia()
	{
		$media = array(); 
		$media['styles_black'] = array(CSSPATH.'ui-lightness/jquery-ui-1.8.16.custom.css'=>'screen');
		$media['scripts_black'] = array(SCRIPTPATH.'jquery-ui-1.8.16.custom.min.js',
						URL_BASE.'public/js/jquery.jcarousel.pack.js');
		
		$media['styles_blue'] = array(URL_BASE.'public/blue/css/skin.css'=>'screen',
						URL_BASE.'public/blue/css/slidder-css/jquery.jcarousel.css'=>'screen',
						URL_BASE.'public/blue/css/slidder-css/skin.css'=>'screen');
		$media['scripts_blue'] = array(URL_BASE.'public/js/jquery.jcarousel.pack.js');
		
		$media['styles_orange'] = array(URL_BASE.'public/orange/css/skin.css'=>'screen',
						URL_BASE.'public/orange/css/slidder-css/jquery.jcarousel.css'=>'screen',
						URL_BASE.'public/orange/css/slidder-css/skin.css'=>'screen',
						CSSPATH.'ui-lightness/jquery-ui-1.8.16.custom.css'=>'screen');
		$media['scripts_orange'] = array(URL_BASE.'public/js/jquery.jcarousel.pack.js',
						SCRIPTPATH.'jquery-ui-1.8.16.custom.min.js');
		
		return $media;
	}
	
	
}
