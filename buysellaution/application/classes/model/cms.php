<?php defined('SYSPATH') OR die('No Direct Script Access');

/*

* Contains CMS page module details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

Class Model_Cms extends Model
{
	public function __construct()
	{	
		$this->session = Session::instance();	
		$this->username = $this->session->get("user_name");
	}

	/**To Get Current TimeStamp**/
	public function getCurrentTimeStamp()
	{
		return date('Y-m-d H:i:s', time());
	}        
     
	/** Get Cms data dynamic**/    
	public function get_cmspage($cmsid)
	{
		$result= DB::select()->from(CMS)
		             ->where('status','=', "A")    
		             ->where('page_url','=', $cmsid)                  
			     ->execute()	
			     ->as_array();			     
		return $result;	
	 }
	 
        /**
        * ****count_pages_list()****
        * @return static pages list count for pagination
        */
	public function count_pages_list()
	{
	
	 $rs = DB::select()
                        ->from(CMS)
			->execute()
			->as_array();	

	 return count($rs);
	}
	
        /**
        * ****all_pages_list()****
        *@param $offset int, $val int
        *@return static pages list  
        */	
	public function all_pages_list($offset, $val)
	{

		//Query for pages listings with Pagination 
		$query  ="SELECT  page_title,
				  id,
				  page_description,
				  status
				  FROM ".CMS." ORDER BY page_title ASC LIMIT $offset,$val ";

	    $result = Db::query(Database::SELECT, $query)
			    ->execute()
			    ->as_array();


	 return $result;
	}
	
        /**
        * ****edit_static_page_form()****
        *@param $arr validation array
        *@validation check
        */
	public function edit_static_page_form($arr) 
	{
		$arr['page_title'] = trim($arr['page_title']);
		$arr['page_description'] = trim($arr['page_description']);
		$arr['meta_title'] = trim($arr['meta_title']);
		$arr['meta_keyword'] = trim($arr['meta_keyword']);
		return Validation::factory($arr)       
			->rule('page_title', 'not_empty')
			->rule('page_title','alpha_space')
			->rule('page_title', 'min_length', array(':value', '3'))
			->rule('page_title', 'max_length', array(':value', '50'))
			->rule('page_description','not_empty')
			->rule('page_description', 'max_length', array(':value', '8000'))
			->rule('meta_title','not_empty')
			->rule('meta_title', 'min_length', array(':value', '5'))
			->rule('meta_title', 'max_length', array(':value', '50'))			
			->rule('meta_keyword','not_empty')
			->rule('meta_keyword','regex',array(':value','/^[A-Za-z0-9]+([A-Za-z0-9]+)+(,[A-Za-z0-9]+)*$/i'))
			->rule('meta_keyword', 'min_length', array(':value', '5'))
			->rule('meta_keyword', 'max_length', array(':value', '50'));
	}
	
	

        /**
        * ****edit_page_data()****
        *@return edit static pages 
        */	
	public function edit_page_data($page_id,$data)
	{

                /**To get whether suggestion is approved or not ***/
                //====================================================
                $status_data = isset($data['status'])?ACTIVE:IN_ACTIVE;
                //echo $status_data;exit;
                $page_url=url::title($data['page_title']);
                //"Set" sql query to update details
                //==================================					
                $sql_query = array('page_title' => $data['page_title'] ,'page_url' => $page_url , 'status' => $status_data,'page_description' => $data['page_description'],'meta_title' => $data['meta_title'], 'meta_keyword' => $data['meta_keyword']);


                //update suggestion details  in database
                //=======================================
		$result =  DB::update(CMS)->set($sql_query)
					->where('id', '=' ,$page_id)
					->execute();
		
		return $result;
	
	}	
	
        /**
        * ****get_all_static_page_details()****
        *@return static pages details array
        */
        public function get_all_static_page_details($page_id)
	{

		$result= DB::select()->from(CMS)
			     ->where('id', '=', $page_id)
			     ->order_by('id','ASC')
			     ->execute()	
			     ->as_array();

		return $result;
	}
	
        /**
        * ****show_static_page_content()****
        *@return show_static_page_content
        */	
	public function show_static_page_content($page_id)
	{
		$result= DB::select('page_description','page_title')->from(CMS)
			     ->where('id', '=', $page_id)
			     ->execute()	
			     ->as_array();	
		return $result;    
	}
	
	/**********FOR FACEBOOK BONUS ADD***************/

	public function get_user_id($r_id)
	{
		$result= DB::select('id')->from(USERS)
			     ->where('referral_id', '=', $r_id)
			     ->execute()	
			     ->as_array();	
		return $result; 
	}
	
	public function get_bonus_type_id($type)
	{
		$result= DB::select('bonus_type_id','bonus_amount')->from(BONUS)
			     ->where('bonus_type_id', '=', $type)
			     ->execute()	
			     ->as_array();	
		return $result; 
	}

	public function get_from_bonus_tables($userid,$type)
	{
		$result= DB::select()->from(USER_BONUS)
			     ->where('bonus_type', '=', $type)				
			     ->and_where('userid', '=', $userid)
			     ->execute()	
			     ->as_array();	
		return $result;
	}

	public function check_bonus_type($userid,$type,$friend_id)
	{
		$result= DB::select()->from(USER_BONUS)
			     ->where('bonus_type', '=', $type)				
			     ->and_where('userid', '=', $userid)
			     ->execute()	
			     ->as_array();
		//print_r($result);exit;
		if(count($result)>0)
		{	
			$db_ids=array_filter(explode(",",$result[0]['friend_ids']));
			if(count($db_ids>0))
			{
				if(is_array($friend_id) && in_array($friend_id['id'],$db_ids))
				{ 
					return 0;
				}
				else
				{
					return 2;
				}
			}
			else
			{ return 1;}			
		}
		else
		{
			return 1;
		}
	}
		
        /**********END OF FACEBOOK BONUS ADD***************/
	
}
