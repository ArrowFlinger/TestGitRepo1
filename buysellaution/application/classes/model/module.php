<?php defined('SYSPATH') or die('No direct script access.');
/**
* Contains auctions Model database queries

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Module extends Model {

	/**
	* ****__construct()****
	*
	* setting up session variables
	*/
    public function __construct()
    {	
        $this->session = Session::instance();
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
	}
	
	public function select_types($module_id="",$packtype="",$active = true)
	{ 
		$query = DB::select()->from(AUCTIONTYPE);
		
		if($active)
		{
		   $query->where(AUCTIONTYPE.'.status','=',ACTIVE);
		}
		
		if($module_id!="")
		{
			$query ->and_where(AUCTIONTYPE.'.typeid','=',$module_id);
			if($packtype!="")
			{
				$query ->and_where(AUCTIONTYPE.'.pack_type','=',$packtype)
								->execute()->current();
			}
			else {	$result = $query ->execute()->current();}
		}
		else
		{ 
			if($packtype!="")
			{
			$result =	$query ->and_where(AUCTIONTYPE.'.pack_type','=',$packtype)
								->execute()->as_array();
			}
			else {	$result = $query ->execute()->as_array();}
		}
		 
								
		return $result;
	}
	public function select_types_for_autobid($module_id="",$packtype="",$active = true)
	{ 
		$query = DB::select()->from(AUCTIONTYPE);		
		
		if($active)
		{
		   $query->where(AUCTIONTYPE.'.status','=',ACTIVE);
		}
		
		if($module_id!="")
		{
			$query ->and_where(AUCTIONTYPE.'.typeid','=',$module_id);
				 
			if($packtype!="")
			{
				$query ->and_where(AUCTIONTYPE.'.pack_type','=',$packtype)
						->and_where(AUCTIONTYPE.'.typename','!=','lowestunique')
						->and_where(AUCTIONTYPE.'.typename','!=','highestunique')
						->and_where(AUCTIONTYPE.'.typename','!=','buyerseller')
								->execute()->current();
			}
			else {	$result = $query ->execute()->current();}
		}
		else
		{ 
			if($packtype!="")
			{
			$result =	$query ->and_where(AUCTIONTYPE.'.pack_type','=',$packtype)
								->and_where(AUCTIONTYPE.'.typename','!=','lowestunique')								 
								->and_where(AUCTIONTYPE.'.typename','!=','highestunique')								 
								->and_where(AUCTIONTYPE.'.typename','!=','buyerseller')								 
								->execute()->as_array();
			}
			else {	$result = $query ->execute()->as_array();}
		}
		 
								
		return $result;
	}
	
	public function select_module($modulename)
	{
	    $query = DB::select()->from(AUCTIONTYPE)->where(AUCTIONTYPE.'.typename','=',$modulename)->execute()->current();
	    return $query;
	}

	
	
}//End of auction model
?>
