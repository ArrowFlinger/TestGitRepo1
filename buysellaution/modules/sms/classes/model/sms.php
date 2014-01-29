<?php defined('SYSPATH') or die('No direct access allowed.');

/*
 * You should have all the module's models inside the module folder
 * so the module can be functional just by copying the module folder.
 *
 * It's recomended to name you Module's Models as Model_Modulename_<Model>
 * to avoid any conflics with any application model
 */

class Model_SMS extends Model {
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
       
   /* To Get Package Details for specific package id only -Dec17,2012 */
	public function getsmsGatewayDetails(){
		return DB::select()->from(SMS_GATEWAYS)
						->where('id','=','1')			     
						->execute()	
						->as_array(); //Auction type
				
	}    
       
       
       
       
       
} // End User Model
