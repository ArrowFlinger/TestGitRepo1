<?php defined('SYSPATH') or die('No direct script access.');
/*

* Contains Category(Add Category,Manage Category) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/


class Model_Category extends Model
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

        // Validation for Add Category
        public function validate_add_category($arr) 
        {
                $arr['category_name'] = trim($arr['category_name']);
                return Validation::factory($arr)            
                        ->rule('category_name', 'not_empty')
                        ->rule('category_name','alpha_space');
        }
        
        // Add Category
        public function add_category($post_val,$validator)
        {

                $status = isset($post_val['status'])?"A":"I";
                $cat_name = DB::select()->from(PRODUCT_CATEGORY)
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

                        $insert_id = DB::insert(PRODUCT_CATEGORY)
                                ->columns(array('category_name', 'status','created_date'))
                                ->values(array($post_val['category_name'],$status,$this->getCurrentTimeStamp))
                                ->execute(); 

                return $insert_id[1];		
                }

        } 


        // Select for Category
        public function get_product_category($offset, $val) 
        {

                $sql = 'SELECT id,
                category_name,
                if(status="D", "Delete",if(status="A", "Active","Inactive")) AS status, created_date
                FROM '.PRODUCT_CATEGORY.' LIMIT  '."$offset, $val"; 

                return Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array();                     
        } 

        //Count for Category
        public function count_product_category()
        {
                $sql = 'SELECT id,
                category_name,
                if(status="D", "Delete",if(status="A", "Active","Inactive")) AS status,
                DATE_FORMAT(created_date, "%d-%b-%Y") AS created_date
                FROM   '.PRODUCT_CATEGORY; 

                return count( Db::query(Database::SELECT, $sql)
                        ->execute()
                        ->as_array());                     
        } 

        /*Product Category Count*/
        public function count_category_list($category_id)
        {

                $query = "SELECT 

                        ".PRODUCTS.".product_id as productid,
                        ".PRODUCTS.".product_category,
                        ".PRODUCT_CATEGORY.".id as category_id,
                        ".PRODUCT_CATEGORY.".category_name
                        FROM ".PRODUCTS." LEFT JOIN ".PRODUCT_CATEGORY." ON ".PRODUCT_CATEGORY.".id= ".PRODUCT_DETAILS.".product_category
                        WHERE ".PRODUCT_CATEGORY.".status='".ACTIVE."' AND ".PRODUCT_CATEGORY." .id='$category_id' "; 
                $result=Db::query(Database::SELECT, $query)
                                        ->execute()
                                        ->as_array();
                                return count($result);
        }   

        //Update for Category
        public function edit_category($cat_id ,$_POST) 
        {
                $status = isset($_POST['status'])?"A":"I";
                $mdate = $this->getCurrentTimeStamp; 
		$cat_name = DB::select()->from(PRODUCT_CATEGORY)
                        ->where('category_name','=', $_POST['category_name'])
			->and_where('id','!=', $cat_id)
                        ->execute()
                        ->as_array();
                //For Duplicate Checking
                if(count($cat_name) > 0)
                {
                        return 2;
                }
                else
                {
               	 $query = DB::update(PRODUCT_CATEGORY)
                                ->set(array('category_name' => $_POST['category_name'],
                                'status' => $status,'updated_date'=>$mdate))
                                ->where('id', '=',$cat_id)
                                ->execute();               
                        return 1; 
	    }	
        }

        //Delete for category
        public function delete_category($category_delete_chk)
        {
               $query = array('status'=>DELETED_STATUS);
				
			$resule   = DB::update(PRODUCT_CATEGORY)
					 ->set($query)
					 ->where('id', 'IN', $category_delete_chk)
					 ->execute();
				return count($resule);
        }

        //Select for category using id 
        public function product_category($id="")
        {
                $sql = 'SELECT * FROM '.PRODUCT_CATEGORY.' WHERE  id='.$id ;                      
                return Db::query(Database::SELECT, $sql)
                                ->execute()
                                ->as_array();    
        }
        
        public function product_category_status($categoryid="",$category_delete="")
        {
		
        $cat_name = DB::select()->from(PRODUCTS)
                        ->where('product_category','=', $categoryid)
                        ->or_where('product_category','=', $category_delete)
                        ->and_where('product_process','=', LIVE)
                        ->execute()
                        ->as_array(); 
                        
                        if(count($cat_name) > 0)
                        {
                                return 1;
                        }
                        else
                        {
                                return 2;
                        }
                                               
        }
}
?>
