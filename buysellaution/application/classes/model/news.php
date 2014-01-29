<?php defined("SYSPATH") or die("No direct script access.");
/**
* Contains users Model database queries

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_news extends Model {

	/**
	* ****__construct()****
	*
	* setting up commonfunction model
	*/	
	public function __construct()
	{
		//calling communfunction model in this constructor
		$this->commonmodel=Model::factory('commonfunctions');
		$this->session=Session::instance();
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
	}

        //Select News values
        public function get_news($offset, $val) 
        {
                
                
               return $query = DB::select()
			->from(NEWS)
			->where('status', '=',ACTIVE)
			->order_by('created_date','DESC')
			->limit($val)
			->offset($offset)
			->execute()
			->as_array();
	  
              
        }
        
        // Count For Total News Values
        public function count_news()
        {
        
                $rs = DB::select()->from(NEWS)
				->where(NEWS.'.status', '=', ACTIVE)
				->execute()
				->as_array();	
	        return count($rs);
	        
                                     
        } 
	
}//End of users model
?>
