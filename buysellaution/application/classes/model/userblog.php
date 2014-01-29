<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains users Model database queries
 *
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_userblog extends Model {

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
	
	// Get blog Values
	public function get_blog($offset, $val) 
        {
              
                  return $query = DB::select(BLOG.'.blog_id',BLOG.'.created_date',BLOG.'.blog_title',BLOG.'.blog_description',BLOG.'.comments_count')
			->from(BLOG)
			->join(BLOG_CATEGORY,'left')
			->on(BLOG.'.category','=',BLOG_CATEGORY.'.id')
			->where(BLOG.'.status','=',ACTIVE)
			->and_where(BLOG_CATEGORY.'.status','=',ACTIVE)
			->order_by('blog_id','DESC')
			->limit($val)
			->offset($offset)
			->execute()
			->as_array();                     
        } 

        // Count For Total blog Values
        public function count_blog()
        {
                $sql = 'SELECT blog_id,
                blog_title,blog_description,
                if(status="A", "Active","Inactive") AS status,
                DATE_FORMAT(created_date, "%d-%b-%Y") AS created_date
                FROM   '.BLOG; 

                return count( Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array());                     
        } 
        
        /** 
	* get_blog_value 	
	*/
	public function get_blog_value($blogid)
	{
			$query=DB::select()
				->from(BLOG)
				->where(BLOG.'.blog_id','=',$blogid)
				->execute()
				->as_array();
			return $query;
		
	}	
	
	/** 
	* get_blog_value 	
	*/
	public function get_blog_comments($blogid)
	{
			$query=DB::select(COMMENTS.'.blog_id',COMMENTS.'.comment',COMMENTS.'.useremail',COMMENTS.'.website',COMMENTS.'.created_date_blog',COMMENTS.'.username_blog','user_id','photo')
				->from(COMMENTS)
				->join(USERS,'left')
				->on(COMMENTS.'.useremail','=',USERS.'.email')
				->where(COMMENTS.'.blog_id','=',$blogid)
				->order_by('created_date_blog','DESC')
				->execute()
				->as_array();
			return $query;
		
	}	
	
	/**
	* command_validation
	*/
	public function command_validation($arr)
	{
		$validation = Validation::factory($arr)			
				->rule('username','not_empty')
				->rule('username', 'min_length',array(':value','3'))
				->rule('username', 'max_length',array(':value','50'))
				->rule('website','url')
				->rule('website', 'min_length',array(':value','3'))
				->rule('website', 'max_length',array(':value','50'))
				->rule('useremail', 'not_empty')
				->rule('useremail', 'max_length',array(':value','50'))
				->rule('useremail', 'email_domain')
				->rule('comment', 'not_empty')
				->rule('comment', 'max_length',array(':value','510'));
		
		return $validation;
	}
	
	/** 
	* add_commant 	
	*/
	public function add_commant($_POST,$userid)
	{
	        $userid="";
	        $result = DB::insert(COMMENTS, array('blog_id','username_blog','useremail','comment','created_date_blog','user_id','website'))
		->values(array($_POST['blog_id'],$_POST['username'],$_POST['useremail'],$_POST['comment'],$this->getCurrentTimeStamp,$userid,$_POST['website']))
		->execute();   
		
		 $query = DB::update(BLOG)->set(array('comments_count' => DB::expr('comments_count + 1')))->where('blog_id', '=', $_POST['blog_id'])->execute();
   
                  return $result;  
				
	}	

}//End of users model
?>
