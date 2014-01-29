<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains News(Add News,Manage News) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/
class Model_adminnews extends Model
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


        // Validate for News 
        public function validate_add_news($arr) 
        {
                $arr['news_title'] = trim($arr['news_title']);
                return Validation::factory($arr)            
                        ->rule('news_title', 'not_empty')
                        ->rule('news_title', 'alpha_space')
                        ->rule('news_description', 'not_empty');
        }

        //Add News 
        public function add_news($post_val,$validator)
        {

                $status = isset($post_val['status'])?"A":"I";
                $news_name = DB::select()->from(NEWS)
                        ->where('news_title','=', $post_val['news_title'])
                        ->execute()
                        ->as_array(); 

                //For Duplicate Checking

                if(count($news_name) > 0)
                {
                        return 0;
                }
                else
                {
                        $insert_id = DB::insert(NEWS)
                                ->columns(array('news_title','news_description', 'status','created_date'))
                                ->values(array($post_val['news_title'],$post_val['news_description'],$status,$this->getCurrentTimeStamp))
                                ->execute(); 

                return $insert_id[1];		
                }

        } 

        // Get News Values using pagination
        public function get_news($offset, $val) 
        {

                $sql = 'SELECT news_id,
                news_title,news_description,
                if(status="A", "Active","Inactive") AS status, created_date
                FROM '.NEWS.' LIMIT  '."$offset, $val"; 

                return Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array();                     
        } 

        // Count For Total News Values using pagination
        public function count_news()
        {
                $sql = 'SELECT news_id,
                news_title,news_description,
                if(status="A", "Active","Inactive") AS status,
                DATE_FORMAT(created_date, "%d-%b-%Y") AS created_date
                FROM   '.NEWS; 

                return count( Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array());                     
        } 

        // Update For News Values
        public function edit_news($news_id , $_POST) 
        {
                $status = isset($_POST['status'])?"A":"I";
                
                $query = DB::update(NEWS)
                        ->set(array('news_title' => $_POST['news_title'],'news_description' => $_POST['news_description'],
                        'status' => $status))
                        ->where('news_id', '=',$news_id)
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

        // Delete For News Values
        public function delete_news($news_delete_chk)
        {
                $rs   = DB::delete(NEWS)
                                ->where('news_id', 'IN', $news_delete_chk) 
                                ->execute(); 
                return count($rs);
        }

        // Select For News Values
        public function auction_news($newsid="")
        {
        
                $sql = DB::select()->from(NEWS)
                        ->where('news_id','=', $newsid)
                        ->execute()
                        ->as_array(); 
                         return $sql;
        }
}
?>
