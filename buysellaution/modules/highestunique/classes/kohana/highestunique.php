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
class Kohana_Highestunique extends Controller_Site_Highestunique {
	
	/**
	* @var array configuration settings
	*/
	protected $_config = array();
	protected $_highestunique ;

	/**
	* Class Main Constructor Method
	* This method is executed every time your module class is instantiated.
	*/
	public function __construct() 
	{	
		
		$this->session=Session::instance();
		$this->highestunique_model = Model::factory('highestunique');	
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
		
		$result=$this->highestunique_model->selectall_autobid_closed();
		
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
			$this->highestunique_model->update(USERS,array('user_bid_account'=>$amts),'id',$products['userid']);
			$this->highestunique_model->delete_autobid($products['userid'],$products['product_id']);
		}
		return;
	}
	
	public function process($pid,$status=1,$array=array())
	{				
	
		$product_results = $this->highestunique_model->select_products_detail($pid,$status,$array);	
		
		$array=array();	
		foreach($product_results  as $product_result)
		{
			if($this->getCurrentTimeStamp<=$product_result['enddate'])
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
				if((double)$product_result['product_cost']>(double)$product_result['current_price'])
				{
					$savings=(double)$product_result['product_cost']-(double)$product_result['current_price'];
					$savings=$this->site_currency." ".Commonfunction::numberformat($savings);
					
				}else{
					$savings=$this->site_currency." "."0.00";
				}
				$array[]= array("Product"=> array("id"=>$product_result['product_id'],
											"currency"=>$this->site_currency,
											"current_price"=>$this->site_currency." ".Commonfunction::numberformat($product_result['current_price']),
											"price" =>Commonfunction::numberformat($product_result['current_price']),
										        "bidamount" =>Commonfunction::numberformat($product_result['bidamount']),
											"current_status" =>$current_status,
											"extras"=>array('product_cost'=> $product_result['product_cost'],'savings'=>$savings),
											"status"=>$status,
											"auction_type" => $product_result['auction_type'],
											"resume_time" =>$resume_time,
											"db_timestamp" => $product_result['increment_timestamp'],
											"element" =>"auction_".$product_result['product_id'],
											"lastbidder"=>$product_result['lastbidder_userid'],
											"user_img" =>$user_img_path,
											"autobid" =>$product_result['autobid'],
											"time_diff" => $this->timediff($product_result['increment_timestamp']),
											"unix_timestamp" =>$this->create_timestamp($this->getCurrentTimeStamp),
											"element"=>"auction_".$product_result['product_id'],								
											"checking_time" =>$this->checking_time),
											"settingIncrement" => array("countdown"=>time()+$product_result['max_countdown'],
																		//'time_left'=>$time,
																		'timestamp' =>$time_stamp),
											"Users"=>array("username"=>ucfirst($product_result['username']),
															"lat"=>$product_result['latitude'],
															"lng"=>$product_result['longitude']));	
			}
		}
		return $array;
		
	}
	
		
	public static function product_block($pids,$status="",$arrayset=array())
	{
		$highestunique = Model::factory('highestunique');		
		$productsresult = $highestunique->select_products_detail($pids,$status,$arrayset);	
		 
		switch($status)
		{
			case 3:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/future')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 6:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/product_detail')
							->set('productsresult', $productsresult)
							->set('status',$status);							
							break;
			case 2:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/closed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 10:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/winner')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			case 8:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/closedunclosed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
			//venkatraja added by category products			
			case 7:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/closedunclosed')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;			
			
			case 17:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/highest_unique_bidhistory')
							->set('productsresult', $productsresult)
							->set('status',$status);	
							break;	
                        case 11:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/buynow')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;								
			default:
			$view = View::factory('highestunique/'.THEME_FOLDER.'auctions/live')
							->set('productsresult', $productsresult)
							->set('status',$status);
							break;
		}					
		return $view->render();
	}
}
