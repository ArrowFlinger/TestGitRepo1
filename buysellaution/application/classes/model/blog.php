<?php defined('SYSPATH') or die('No direct script access.');
/*
* Contains Blog Settings() details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/
class Model_Blog extends Model
{
	
	/**
	 * ****__construct()****
	 *
	 * setting up session variables
	 */
        public function __construct()
        {	
        $this->session = Session::instance();	
        $this->username = $this->session->get("username");
        $this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
        }
        // Add Blog Category validation
        public function validate_add_blog_category($arr) 
        {
                $arr['category_name'] = trim($arr['category_name']);
                return Validation::factory($arr)            
                        ->rule('category_name', 'not_empty')
                        ->rule('category_name','alpha_space');
        }

        // Add Blog Category
        public function add_blog_category($post_val,$validator)
        {
                $status = isset($post_val['status'])?"A":"I";
                $cat_name = DB::select()->from(BLOG_CATEGORY)
                        ->where('category_name','=', $post_val['category_name'])
                        ->execute()
                        ->as_array();
                //For Duplicate Checking
                if(count($cat_name) > 0)
                {
                        return 0;
                }
                else
                {
                        $insert_id = DB::insert(BLOG_CATEGORY)
                                ->columns(array('category_name', 'status','created_date'))
                                ->values(array($post_val['category_name'],$status,$this->getCurrentTimeStamp))
                                ->execute(); 
                return $insert_id[1];		
                }
        } 

        // Select  Blog Category
        public function get_blog_category($offset, $val) 
        {
                $sql = 'SELECT id,
                category_name,created_date,
                if(status="A", "Active","Inactive") AS status 
             
                FROM '.BLOG_CATEGORY.' LIMIT  '."$offset, $val"; 
                return Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array();                     
        } 

        // Count Blog Category
        public function count_blog_category()
        {
                $sql = 'SELECT id,
                category_name,
                if(status="A", "Active","Inactive") AS status,
                DATE_FORMAT(created_date, "%d-%b-%Y") AS created_date
                FROM   '.BLOG_CATEGORY; 

                return count( Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array());                     
        } 

        // Update Blog Category       
        public function edit_blog_category($cat_id , $_POST) 
        {
                $status = isset($_POST['status'])?"A":"I";
                $mdate = $this->getCurrentTimeStamp; 
                $query = DB::update(BLOG_CATEGORY)
                                ->set(array('category_name' => $_POST['category_name'],
                                'status' => $status,'updated_date'=>$mdate))
                                ->where('id', '=',$cat_id)
                                ->execute();
                if(count($query) > 0)
                {
                        return 1;
                }
                else
                {
                        return 2;
                }
        }

        // Delete Blog Category
        public function blog_delete_category($category_delete_chk)
        {
                $rs   = DB::delete(BLOG_CATEGORY)
                                ->where('id', 'IN', $category_delete_chk) 
                                ->execute(); 
                return count($rs);
        }

        // Select Blog Category using id
        public function blog_category($id="")
        {
                $sql = 'SELECT * FROM '.BLOG_CATEGORY.' WHERE  id='.$id ;                      
                return Db::query(Database::SELECT, $sql)
                                ->execute()
                                ->as_array();
                             
        }
        
        // Add Blog Category
        public function blog_category_list()
        {
                $result = DB::select('id','category_name')->from(BLOG_CATEGORY)
                                ->execute()
                                ->as_array();
                return $result;
        }
        
        // Validation for Blog 
        public function validate_add_blog_form($arr) 
        {
                $arr['blog_title'] = trim($arr['blog_title']);
                return Validation::factory($arr)            
                        ->rule('blog_title', 'not_empty')
                        ->rule('blog_title','alpha_space')
                        ->rule('blog_description','not_empty')
                        ->rule('blog_description', 'min_length', array(':value', '10'))
                        ->rule('blog_description', 'max_length', array(':value', '500')) 
                        ->rule('category', 'not_empty');
        }
        
        /**
        * ****add_blog()****
        *@return insert products values in database
        */ 	 
	public function add_blog($validator,$_POST)
	{
	
	        $blog_status = isset($_POST['status'])?ACTIVE:IN_ACTIVE;  
                $cat_name = DB::select()->from(BLOG)
                        ->where('blog_title','=', $_POST['blog_title'])
                        ->execute()
                        ->as_array();
                //For Duplicate Checking
                if(count($cat_name) > 0)
                {
                        return 0;
                }
                else
                {
                        $insert_id = DB::insert(BLOG)
                                ->columns(array('blog_title','blog_description','category','status','created_date'))               
                ->values(array($_POST['blog_title'],$_POST['blog_description'], 
            $_POST['category'], $blog_status,$this->getCurrentTimeStamp))
                ->execute(); 
                return $insert_id[1];		
                }
                
           } 
	
	//Update for Blog comment
        public function edit_blog($blog_id , $_POST) 
        {
                $status = isset($_POST['status'])?"A":"I";
                $mdate = $this->getCurrentTimeStamp; 
                $query = DB::update(BLOG)
                                ->set(array('blog_title' => $_POST['blog_title'],'blog_description' => $_POST['blog_description'],'category' => $_POST['category'],
                                'status' => $status,'updated_date'=>$mdate))
                                ->where('blog_id', '=',$blog_id)
                                ->execute();
                if(count($query) > 0)
                {
                        return 1;
                }
                else
                {
                        return 2;
                }
        }
        
        // update validation for blog
        public function validate_edit_blog_form($arr) 
        {
                $arr['blog_title'] = trim($arr['blog_title']);
                return Validation::factory($arr)            
                        ->rule('blog_title', 'not_empty')
                        ->rule('blog_title','alpha_space')
                         ->rule('blog_description','not_empty')
                        ->rule('blog_description', 'min_length', array(':value', '5'))
                        ->rule('blog_description', 'max_length', array(':value', '500')) 
                        ->rule('category', 'not_empty');
        }
        
        //Count for blog comment 
        public function count_blog_data()
        {
                $sql = 'SELECT blog_id,
                blog_title,blog_description,
                if(status="A", "Active","Inactive") AS status,category,
                DATE_FORMAT(created_date, "%d-%b-%Y") AS created_date
                FROM   '.BLOG; 

                return count( Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array());                     
        } 
        

        //Select for blog comments        
        public function get_blog_data($offset, $val) 
        {
                
                
               return $query = DB::select(BLOG.'.category',BLOG.'.blog_title',BLOG.'.blog_description',BLOG.'.comments_count',BLOG.'.status',BLOG.'.created_date',BLOG.'.blog_id',BLOG_CATEGORY.'.category_name',BLOG_CATEGORY.'.id')
			->from(BLOG)
			->join(BLOG_CATEGORY,'left')
			->on(BLOG.'.category','=',BLOG_CATEGORY.'.id')
			->limit($val)
			->offset($offset)
			->order_by(BLOG.'.created_date')
			->execute()
			->as_array();
	  
              
        }
        
        //Select for Blog data using blog id
        public function blog_data($blog_id="")
        {
                $sql = 'SELECT * FROM '.BLOG.' WHERE  blog_id='.$blog_id ;                      
                return Db::query(Database::SELECT, $sql)
                                ->execute()
                                ->as_array();
                             
        } 
	
	// Delete Blog comments
	public function delete_blog($delete_blog_chk)
        {
                $rs   = DB::delete(BLOG)
                                ->where('blog_id', 'IN', $delete_blog_chk) 
                                ->execute(); 
                return count($rs);
        }
        
        // Get blog comments Values
        
        public function get_blog_comments($offset, $val)
	{
			$query=DB::select()
				->from(COMMENTS)
				->join(BLOG,'left')
				->on(BLOG.'.blog_id','=',COMMENTS.'.blog_id')
				->order_by('created_date_blog','DESC')
				->limit($val)
				->offset($offset)
				->execute()
				->as_array();
			return $query;
		
	}	
	
        // Count For Total blog comments Values
        public function count_blog_comments()
        {
                $sql = 'SELECT blog_id,id,
                comment,useremail,
                DATE_FORMAT(created_date_blog, "%d-%b-%Y") AS created_date_blog
                FROM   '.COMMENTS; 

                return count( Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array());                     
        } 
        
        //Delete for user comments
        public function delete_comments($delete_comments_id,$blog_id)
        {
        
                  $result   = DB::delete(COMMENTS)
                                ->where(COMMENTS.'.id','=', $delete_comments_id) 
                                ->execute(); 
                                
                  $query = DB::update(BLOG)
                               ->set(array('comments_count' => DB::expr('comments_count - 1')))
                               ->where('blog_id', '=', $blog_id)
                               ->execute();
                return count($result);
        }
        
        //Select for Comment details
        public function select_comment_details($blog_id="")
        {
                $sql = 'SELECT * FROM '.COMMENTS.' WHERE  id='.$blog_id ;                      
                return Db::query(Database::SELECT, $sql)

                                ->execute()
                                ->as_array();
                             
        } 
        
        //Update read or unread status
	public function update_message_details($messageid)
	{
	$result = DB::update(COMMENTS)->set(array('msg_type'=>READ))->where('id', '=', $messageid)
			->execute();
					    
			return $result;
        }
}
 //End   blog model 
