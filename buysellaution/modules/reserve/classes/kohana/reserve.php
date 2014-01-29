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
class Kohana_Reserve extends Controller_Site_Reserve {
	
	/**
	* @var array configuration settings
	*/
	protected $_config = array();
	protected $_reserve ;
	protected $_userid;

	/**
	* Class Main Constructor Method
	* This method is executed every time your module class is instantiated.
	*/
	public function __construct() 
	{	
		
		$this->session=Session::instance();
		$this->reserve_model = Model::factory('reserve');	
		$this->checking_time=CHECKING_TIME;
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		$this->site_currency =SITECURRENCY;
		$this->_userid = $this->session->get('auction_userid');
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
		
		$result=$this->reserve_model->selectall_autobid_closed();
		
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
			$this->reserve_model->update(USERS,array('user_bid_account'=>$amts),'id',$products['userid']);
			$this->reserve_model->delete_autobid($products['userid'],$products['product_id']);
		}
		return;
	}
	
	public function process($pid,$status=1,$array=array())
	{				
	
		$product_results = $this->reserve_model->select_products_detail($pid,$status,$array);	
		$checkthisuser = self::get_mybids();
		$array=array();	
		foreach($product_results  as $product_result)
		{
			$highbidder= false;
			$outbid = false;
			if($this->_userid!="")
			{
				$checkthisuser = self::get_mybids($product_result['product_id'],"","",true);
				$checkthisuserforoutbid = self::get_mybids($product_result['product_id'],$this->_userid); 
				if(count($checkthisuser)>0)
				{
					if($checkthisuser[0]['uid']==$this->_userid)
					{
						$highbidder = true;
					}
					if(count($checkthisuserforoutbid)>0 && $highbidder==false)
					{
						if($checkthisuserforoutbid[0]['total'] < $checkthisuser[0]['total'] )
						{
							$outbid = true;
						}
					}
				}
			}
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
				
				$array[]= array("Product"=> array("id"=>$product_result['product_id'],
											"currency"=>$this->site_currency,
											"current_price"=>$this->site_currency." ".Commonfunction::numberformat($product_result['current_price']),
											"price" =>Commonfunction::numberformat($product_result['current_price']),
											"current_status" =>$current_status,
											"reservestatus" =>array('highbidder' => $highbidder,'outbid' =>$outbid), 
											"extras"=>array('bidamount' =>0,'product_cost'=> $product_result['product_cost']),
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
											"Users"=>array("username"=>ucfirst(Text::limit_chars($product_result['username'],12)),
															"lat"=>$product_result['latitude'],
															"lng"=>$product_result['longitude']));	
			}
		}
		return $array;
		
	}
	
		
	public static function product_block($pids,$status="",$arrayset=array())
	{
		$reserve = Model::factory('reserve');		
		$productsresult = $reserve->select_products_detail($pids,$status,$arrayset);
		$incrementvalues = $reserve->get_increment_values();
		switch($status)
		{
			case 3:
			$view = View::factory('reserve/'.THEME_FOLDER.'auctions/future')
							->set('productsresult', $productsresult)
							->set('incrementvalues',$incrementvalues)
							->set('status',$status);
							break;
			case 6:
			$view = View::factory('reserve/'.THEME_FOLDER.'auctions/product_detail')
							->set('productsresult', $productsresult)
							->set('incrementvalues',$incrementvalues)
							->set('status',$status);
							break;
			case 2:
			$view = View::factory('reserve/'.THEME_FOLDER.'auctions/closed')
							->set('productsresult', $productsresult)
							->set('incrementvalues',$incrementvalues)
							->set('status',$status);
							break;
			case 10:
			$view = View::factory('reserve/'.THEME_FOLDER.'auctions/winner')
							->set('productsresult', $productsresult)
							->set('incrementvalues',$incrementvalues)
							->set('status',$status);
							break;
							
			//venkatraja added by category products				
			case 7:
			$view = View::factory('reserve/'.THEME_FOLDER.'auctions/closedunclosed')
							->set('productsresult', $productsresult)
							->set('incrementvalues',$incrementvalues)
							->set('status',$status);
							break;		
											
			case 8:
			$view = View::factory('reserve/'.THEME_FOLDER.'auctions/closedunclosed')
							->set('productsresult', $productsresult)
							->set('incrementvalues',$incrementvalues)
							->set('status',$status);
							break;
                        case 11:
			$view = View::factory('reserve/'.THEME_FOLDER.'auctions/buynow')
							->set('productsresult', $productsresult)
							->set('incrementvalues',$incrementvalues)
							->set('status',$status);
							break;
			default:
			$view = View::factory('reserve/'.THEME_FOLDER.'auctions/live')
							->set('productsresult', $productsresult)
							->set('incrementvalues',$incrementvalues)
							->set('status',$status);
							break;
		}					
		return $view->render();
	}
	
	
	//function for find won auctions details
	static public function get_mybids($auctionid="",$userid="",$amt ="",$reservestatus=false)
	{ 
		
		$sub1 = DB::select(DB::expr('MAX(bh.bid_amount)'))->from(array(RESERVE_BIDHISTORY,'bh'));
		
               if($amt!="")
               { 
               		$sub1->and_where('bh.bid_amount','<=',$amt);
               }
               if($auctionid!="")
               {
                       $sub1->and_where('bh.product_id','=',$auctionid);
               }
               if($userid!="")
               {
                       $sub1->and_where('bh.user_id','<=',$userid);
               }
               
               $sub2 = DB::select('bh.user_id')->from(array(RESERVE_BIDHISTORY,'bh'))->where('bh.bid_amount','=',$sub1)->limit(1)->order_by('bh.historyid','ASC');
               
               if($auctionid!="")
               {
                       $sub2->and_where('bh.product_id','=',$auctionid);
               }
               
               $amount = DB::select('bh.bid_amount')->from(array(RESERVE_BIDHISTORY,'bh'))->where('bh.product_id','=',$auctionid)->and_where('bh.user_id','=',$userid)->limit(1)->order_by('bh.historyid','DESC');
               
               $query = DB::select(array(DB::expr('MAX(bh.bid_amount)'),'total'),'bh.product_id',array($sub2,'uid'),array($amount,'yourbid'))->from(array(RESERVE_BIDHISTORY,'bh')); 
                                                      
               if($userid!="")
               {
                       $query->and_where('bh.user_id','=',$userid);
               }
               if($auctionid!="")
               {
                       $query->and_where('bh.product_id','=',$auctionid);
               }
               if($reservestatus)
               {
                       $query->and_where('bh.reservestatus','=',1);
               }
                $query->group_by('bh.product_id');
                               //->execute()->as_array();

		//return $result;
		 
		
		$result = $query->execute()->as_array();
		//print_r($result);exit;
		
		return $result;
		 
		 
	}
	
	static public function loadmedia()
	{
		$media = array(); 
		$media['styles_blue'] = array(URL_BASE.'public/blue/css/skin.css' => 'screen',URL_BASE.'public/blue/css/slidder-css/jquery.jcarousel.css' => 'screen', URL_BASE.'public/blue/css/slidder-css/skin.css' => 'screen');
		$media['scripts_blue'] = array(URL_BASE.'public/js/jquery.jcarousel.pack.js');
		
		
		$media['style_black'] = array(CSSPATH.'ui-lightness/jquery-ui-1.8.16.custom.css'=>'screen');
		$media['scripts_black'] = array(SCRIPTPATH.'jquery-ui-1.8.16.custom.min.js',URL_BASE.'public/js/jquery.jcarousel.pack.js');
		
		$media['scripts_orange'] = array(URL_BASE.'public/js/jquery.jcarousel.pack.js',SCRIPTPATH.'jquery-ui-1.8.16.custom.min.js'); 
		$media['styles_orange'] = array(URL_BASE.'public/orange/css/skin.css' => 'screen',
						URL_BASE.'public/orange/css/slidder-css/jquery.jcarousel.css'=> 'screen',
						URL_BASE.'public/orange/css/slidder-css/skin.css' => 'screen',
						CSSPATH.'ui-lightness/jquery-ui-1.8.16.custom.css' => 'screen');
		
		$media['style_pink'] = array(CSSPATH.'ui-lightness/jquery-ui-1.8.16.custom.css'=>'screen');
		$media['scripts_pink'] = array(SCRIPTPATH.'jquery-ui-1.8.16.custom.min.js');
		return $media;
	}
	
}
