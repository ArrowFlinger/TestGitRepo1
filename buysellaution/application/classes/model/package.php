<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains package Model database queries

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Package extends Model {

	/**
	* ****__construct()****
	*
	* setting up commonfunction model
	*/	
	public function __construct()
	{
		//calling communfunction model in this constructor
		$this->commonmodel=Model::factory('commonfunctions');
		$this->auctions=Model::factory('auction');
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
	}
	
	// Packages with pagination
	public function select_amount_packages($offset, $val,$need_count=FALSE)
	{
		$query=DB::select()->from(BIDPACKAGES)
		                ->where('status','=',ACTIVE)
				->order_by('price','DESC');
				
		if($need_count)
		{
			$result=$query	->execute()
					->as_array();
			return count($result);
		}
		else
		{
			$result=$query 	->limit($val)
					->offset($offset)
					->execute()
					->as_array();
			return $result;
		}
		
	}

        // Received Package Amount
	public function get_received_packageamount($package_id)
	{
		$query= DB::select()->from(BIDPACKAGES)
			     ->where('package_id','=',$package_id)
			     ->execute()	
			     ->as_array(); 

		return $query;
	}

        public function select_paymentgateways(){
		$query= DB::select()->from(PAYMENT_GATEWAYS)
					->where('status','=','A')
			     ->execute()	
			     ->as_array(); 
		return $query;
	}
}
?>
