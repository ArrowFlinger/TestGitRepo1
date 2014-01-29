<?php defined('SYSPATH') or die('No direct script access.');

/*
* Contains Dashboard(User Deatails,Product Details) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Dashboard extends Model
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
                        $this->admin_session_id = $this->session->get("id");
                }


					public function get_todays_users_count()
					{				

					$query="SELECT COUNT(username) as totaluser FROM ".USERS." WHERE date(`created_date`) = date(curdate())";
					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result[0];
					}

					public function get_last_7days_users_count()
					{				

					$query="SELECT COUNT(username) as totaluser FROM ".USERS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() ";
					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result[0];
					}

					public function get_last_30days_users_count()
					{				

					$query="SELECT COUNT(username) as totaluser FROM ".USERS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 1 MONTH) AND NOW() ";
					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result[0];
					}

					public function get_last_1year_users_count()
					{				

					$query="SELECT COUNT(username) as totaluser FROM ".USERS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 12 MONTH) AND NOW() ";
					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result[0];
					}

					public function get_last_10years_users_count()
					{				

					$query="SELECT COUNT(username) as totaluser FROM ".USERS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 10 YEAR) AND NOW() ";
					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result[0];
					}

					public function get_last_12months_users_count()
					{				

					$query="SELECT COUNT(username) as totaluser,DATE_FORMAT(`created_date`,'%b/%Y') as monthname FROM ".USERS." WHERE `created_date` BETWEEN DATE_SUB(NOW(), INTERVAL 12 MONTH) AND NOW() GROUP BY DATE_FORMAT(`created_date`,'%c-%Y') ORDER BY DATE_FORMAT(`created_date`,'%c-%Y') ASC";
					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result;
					}

					
					/* 
					* name: get_last_30days_transaction()
					* @param
					* @return transaction list count per 30 days
					*/
					
					public function get_last_30days_transaction()
					{
					$query="SELECT COUNT(userid) as totaltrans,DATE_FORMAT(`transaction_date`,'%b/%d') as transaction_dates FROM ".TRANSACTION_DETAILS." WHERE `transaction_date` BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() GROUP BY DATE_FORMAT(`transaction_date`,'%d-%c-%Y') ORDER BY DATE_FORMAT(`transaction_date`,'%d-%c-%Y') ASC";

					$result = Db::query(Database::SELECT, $query)
					->execute()
					->as_array();
					return $result;					

					}
					//
					

 
                /**
                * ****signups_details()****
                *
                * @return user list count 
                */
                public function signups_details($datewise="",$login_type="",$status="")
                {

                        if($datewise=="Today_Users")
                        {
                                $search_column="created_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(created_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";

                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(created_date) = YEAR(CURDATE()) AND MONTH(created_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT id FROM ". USERS . "  
                        WHERE login_type='".$login_type."' AND 
                        status= '$status' AND 
                        ".$search_column." ".$condtional_operator." ".$search_by." ";

                        $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();

                        return count($result);
                }
	
	        /**
                * ****signups_details()****
                *

                * @return user list count 
                */
                public function delete_details($datewise="",$status="")
                {

                        if($datewise=="Today_Users")
                        {
                                $search_column="created_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(created_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";

                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(created_date) = YEAR(CURDATE()) AND MONTH(created_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT id FROM ". USERS . "  

                        WHERE status= '$status' AND 
                        ".$search_column." ".$condtional_operator." ".$search_by." ";

                        $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();

                        return count($result);
                }
                
                /**
                * ****User_Inactive_details()****
                *
                * @return user list Inactive count 
                */
                public function signups_inactive_details($datewise="",$login_type="",$status="")
                {
                        if($datewise=="Today_Users")
                        {
                                $search_column="created_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(created_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";
                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(created_date) = YEAR(CURDATE()) AND MONTH(created_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT id FROM ". USERS . "  
                        WHERE login_type='".$login_type."' AND 
                        status='$status' AND 
                        ".$search_column." ".$condtional_operator." ".$search_by." ";
                      
                        $result = Db::query(Database::SELECT, $query)
                                        ->execute()
                                        ->as_array();
                        return count($result);
                }

	
                /**
                * ****Contact request_details()****
                *Get User Contact Request Details
                * @return count  
                */
                public function contact_request_count($datewise="")
                {
                        if($datewise=="Today_Requests")
                        {
                                $search_column="CR.request_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(CR.request_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";
                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(CR.request_date) = YEAR(CURDATE()) AND MONTH(CR.request_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT CR.id FROM ". CONTACT_REQUEST . "  AS CR WHERE ".$search_column." ".$condtional_operator." ".$search_by." ";
                        $result = Db::query(Database::SELECT, $query)
                                        ->execute()
                                        ->as_array();
                        return count($result);
                }

                /**
                * ****login_details()****
                *Get User Login Details
                * @return count  
                */
                public function login_details($datewise="")
                {
                         if($datewise=="Today_Users")
                        {
                                $search_column="ULD.created_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(ULD.created_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";
                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(ULD.created_date) = YEAR(CURDATE()) AND MONTH(ULD.created_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT count(ULD.id) as usercount , ULD.login_type  FROM ". USERS . " AS ULD 
                        
                        WHERE ".$search_column." ".$condtional_operator." ".$search_by." group by ULD.login_type";
                        $result = Db::query(Database::SELECT, $query)
                        
                        ->execute()
                        ->as_array();
                       
                return $result;
                }
	
	
		//For Select Active Users 
                public function total_active_users()
                {
                    $query = "SELECT count(U.id) as total FROM ". USERS . " AS U WHERE status = '".ACTIVE."' AND login_type = '".NORMAL."' ";    $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                            
                        return $result;
                }
                
                //For Select Inactive Users 
                 public function total_inactive_users()
                {
                        $query = "SELECT count(U.id) as total FROM ". USERS . " AS U WHERE status = '".IN_ACTIVE."' ";   
                         $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                        return $result;
                }
                
                //For Users Online Total count
                public function total_online_users()
                {		 
                        $result   = DB::select()
                                ->from(USERS_ONLINE)
                                ->execute()	
                                ->as_array();
                        return count($result);
                }
                
                 //For Select Normal Users 
                public function total_normal_users()
                {
                        //$query = "SELECT DISTINCT count(ULD.id) as total FROM ". USERS . " AS ULD ";
                        $query = "SELECT count(U.id) as total FROM ". USERS . " AS U WHERE  login_type = '".NORMAL."' ";    
                        $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                        return $result;
                }

                //For Select Facebook Users 
                public function total_facebook_users()
                {
                    $query = "SELECT count(U.id) as total FROM ". USERS . " AS U WHERE login_type = '".FACEBOOK."' ";    
                    $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                            
                        return $result;
                }
                
                //For Select Twitter Users 
                public function total_twitter_users()
                {
                    $query = "SELECT count(U.id) as total FROM ". USERS . " AS U WHERE login_type = '".TWITTER."' ";    
                    $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                            
                        return $result;
                }
                
                //For Select Delete Users 
                public function total_delete_users()
                {
                        $query = "SELECT count(U.id) as total FROM ". USERS . " AS U WHERE status = '".DELETED_STATUS."' ";   
                         $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                        return $result;
                }
                //Total Active Product list
                public function total_active_product()
                {
                        $result =DB::select()->from(PRODUCTS)
                                        ->where('product_status','=',ACTIVE)
                                        ->execute()
                                        ->as_array();
                        return count($result);
                }
                
                //Total Contact request
                public function total_contact_req()
                {
                        $query = "SELECT count(CR.id) as total  FROM ". CONTACT_REQUEST . " AS CR  ";
                        $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                        return $result;
                }
 
                /**
                * ****count_user_list()****
                * @return user list count of array 
                */
                public function count_user_list()
                {
                        $rs = DB::select()->from(USERS)
                                ->execute()
                                ->as_array();
                        return count($rs);
                }

                //Total All product list
                public function total_all_product()
                {
                        $query = "SELECT count(P.id) as total FROM ". PRODUCTS . " AS P ";
                        $result = Db::query(Database::SELECT, $query)
                                        ->execute()
                                        ->as_array();
                                        
                        return $result;
                }

                /**
                * ****count_user_login_list()****
                *
                * @return user list count of array 
                */
                public function count_user_login_list()
                {
                        $rs = DB::select()->from(USER_LOGIN_DETAILS)
                                ->execute()
                                ->as_array();	
                        return count($rs);
                }

                /**
                * ****all_user_list()****
                *@param $offset int, $val int
                *@return alluser list count of array 
                */
                public function all_user_list($offset, $val)
                {
                        $query = "select * from ". USERS . " limit $offset,$val";  
                        $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                        return $result;
                }

                /**
                * ****edit_users()****
                *@param $current_uri int,$_POST array
                *@return alluser list count of array 
                */  
                public function edit_users($current_uri, $_POST,$image_name) 
                {
                        $random_key = Commonfunction::admin_random_user_password_generator();
                        $status = isset($_POST['status'])? ACTIVE : IN_ACTIVE;
                        $query = array('firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'], 'email' => $_POST['email'], 'username' => $_POST['username'],
                        'aboutme' => $_POST['aboutme'],
                        'status' => $status,'activation_code' => $random_key);
                        if($image_name != "")  $query[ 'photo' ]=$image_name ;
                        $result =  DB::update(USERS)->set($query)
                        ->where('id', '=' ,$current_uri)
                        ->execute();
                        if(count($result) == SUCESS)	{		
                        return $status;	
                        }
                }

                /**
                * ****get_users_data()****
                *@param $current_uri int
                *@return alluser lists
                */ 
                public function get_users_data($current_uri = '')
                {		 
                        $rs   = DB::select()->from(USERS)
                                ->where('id', '=', $current_uri)
                                ->execute()	
                                ->as_array();
                        return $rs;
                }
                
                /** 
                * Select active product from products table
                * @param records count needed or not
                * @return array when param is false
                * @return count when param is true
                */
                public function select_active_product()
                {
                         $query=DB::select()->from(PRODUCTS)
		                                ->where("product_status",'=',ACTIVE)
		                                ->execute()
		                                ->as_array();
		                   return count( $query);
                }
                
                /** 
                * Select inactive product from products table
                * @param records count needed or not
                * @return array when param is false
                * @return count when param is true
                */
                public function select_inactive_product()
                {
                        $query=DB::select()->from(PRODUCTS)
			                        ->where("product_status",'=',IN_ACTIVE)
			                        ->execute()
			                        ->as_array();
			           return count( $query);
                }

                /**
                * ****all_sold_product_list_count()****
                *@return all sold product list count 
                */
                public function all_sold_product_list_count()
                {
                        $rs = DB::select()->from(PRODUCTS)
                                        ->where('product_status','=',ACTIVE)
		                        ->where(PRODUCTS.'.lastbidder_userid', '!=','0')
		                        ->execute()
		                        ->as_array();	
                        return count($rs);
                }
                
                /**
                * ****all_unsold_product_list_count()****
                *@return all sold product list count 
                */
                public function all_unsold_product_list_count()
                {
                        $rs = DB::select()->from(PRODUCTS)
                                        ->where('product_status','=',ACTIVE)
		                        ->where(PRODUCTS.'.lastbidder_userid', '=','0')
		                        ->execute()
		                        ->as_array();	
                        return count($rs);
                }
                
                /**
                * ****all_delete_product_counts()****
                *@return all delete product list count 
                */
                public function all_delete_product_count()
                {
                        $rs = DB::select()->from(PRODUCTS)
                                        ->where('product_status','=',DELETED_STATUS)
		                        ->execute()
		                        ->as_array();	
                        return count($rs);
                }
                
                /**
                * ****all_live_product_list_count()****
                *@return all sold product list count 
                */
                public function all_live_product_list_count()
                {
                        $result = DB::select()->from(PRODUCTS)
                                         ->where("product_process",'=',LIVE)
                                         ->and_where('product_status','=',ACTIVE)
		                        ->execute()
		                        ->as_array();	
                        return count($result);
                }
                
                 /**
                * ****all_future_product_list_count()****
                *@return all future product list count 
                */
                public function all_future_product_count()
                {
                        $result = DB::select()->from(PRODUCTS)
                                         ->where("product_process",'=',FUTURE)
		                        ->execute()
		                        ->as_array();	
                        return count($result);
                }
                
                /**
                * ****all_closed_product_list_count()****
                *@return all future product list count 
                */
                public function all_closed_product_count()
                {
                        $result = DB::select()->from(PRODUCTS)
                                         ->where("product_process",'=',CLOSED)
                                         ->and_where('product_status','=',ACTIVE)
		                        ->execute()
		                        ->as_array();	
                        return count($result);
                }
                
                 /** 
                * Select  active product  category from category table
                * @param records count needed or not
                * @return array when param is false
                * @return count when param is true
                */
                public function total_active_category()
                {
                        $query=DB::select()->from(PRODUCT_CATEGORY)
			                        ->where("status",'=',ACTIVE)
			                        ->execute()
			                        ->as_array();
			           return count( $query);
                }
                
                //Select Product Date 
                public function select_product_date()
                {
                           $result=DB::select('created_date')->from(PRODUCTS)
                           ->execute();
                           return $result;
                }

                //Active Product Details 
                public function active_products_details($datewise="",$product_status="")
                {

                if($datewise=="Today_Products")
                {
                        $search_column="created_date";
                        $search_by="current_date";
                        $condtional_operator=">=";
                }
                else if($datewise=="Current_Week")
                {
                        $search_column="YEARweek(created_date)";
                        $search_by="YEARweek(current_date)";
                        $condtional_operator="=";
                }
                else if($datewise=="Current_Month")
                {
                        $search_column="YEAR(created_date) = YEAR(CURDATE()) AND MONTH(created_date) = MONTH(CURDATE())";
                        $condtional_operator=$search_by="";
                }
                $active_status_where = $inactive_status_where  ="";

                        switch($product_status)
                        {
                        case ACTIVE:
                                $active_status_where = " AND P.product_status= '$product_status' AND ";
                        break;
                        case IN_ACTIVE:
                                $inactive_status_where = " AND P.product_status= '$product_status' AND ";
                        break;
                        case DELETED_STATUS:
                                $inactive_status_where = " AND P.product_status= '$product_status' AND ";
                        break;
                        }

                $query = "SELECT count(P.product_id) as total FROM ". PRODUCTS . " AS P

                WHERE 1=1 $active_status_where  $inactive_status_where  ".$search_column." ".$condtional_operator." ".$search_by." "; 

                $result = Db::query(Database::SELECT, $query)
                        ->execute()
                        ->as_array();

                return $result;
                }
                   
                /**
                * ****Live Products ****
                *
                * @return Live Products list count 
                */
                public function live_products_details($datewise="",$product_status="",$live="")
                {
             
                        if($datewise=="Today_Products")
                        {
                                $search_column="created_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(created_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";
                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(created_date) = YEAR(CURDATE()) AND MONTH(created_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT product_id FROM ". PRODUCTS . "  
                        WHERE product_status='".$product_status."' AND 
                        product_process='$live' AND 
                        ".$search_column." ".$condtional_operator." ".$search_by." ";
                        $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                        return count($result);
                }
                
                                
                /**
                * ****sold Products ****
                *
                * @return sold Products list count 
                */
                public function sold_products_details($datewise="",$product_status="",$sold)
                {
               
                        if($datewise=="Today_Products")
                        {
                                $search_column="created_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(created_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";
                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(created_date) = YEAR(CURDATE()) AND MONTH(created_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT product_id FROM ". PRODUCTS . "  
                        WHERE product_status='".$product_status."' AND 
                        lastbidder_userid !='$sold' AND 
                        ".$search_column." ".$condtional_operator." ".$search_by." ";
                        
                        $result = Db::query(Database::SELECT, $query)
                                     ->execute()
                                     ->as_array();
                        return count($result);
                }
                
                /**
                * ****unsold Products ****
                *
                * @return unsold Products list count 
                */
                public function unsold_products_details($datewise="",$product_status="",$sold)
                {
               
                        if($datewise=="Today_Products")
                        {
                                $search_column="created_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(created_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";
                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(created_date) = YEAR(CURDATE()) AND MONTH(created_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT product_id FROM ". PRODUCTS . "  
                        WHERE product_status='".$product_status."' AND 
                        lastbidder_userid ='$sold' AND 
                        ".$search_column." ".$condtional_operator." ".$search_by." ";
                        
                        $result = Db::query(Database::SELECT, $query)
                                     ->execute()
                                     ->as_array();
                        return count($result);
                }
                
               /**
                * ****Live Products Category ****
                *
                * @return Live Products category list count 
                */
                public function product_category($datewise="",$status="")
                {
                        if($datewise=="Today_Category")
                        {
                                $search_column="created_date";
                                $search_by="current_date";
                                $condtional_operator=">=";
                        }
                        else if($datewise=="Current_Week")
                        {
                                $search_column="YEARweek(created_date)";
                                $search_by="YEARweek(current_date)";
                                $condtional_operator="=";
                        }
                        else if($datewise=="Current_Month")
                        {
                                $search_column="YEAR(created_date) = YEAR(CURDATE()) AND MONTH(created_date) = MONTH(CURDATE())";
                                $condtional_operator=$search_by="";
                        }
                        $query = "SELECT id FROM ". PRODUCT_CATEGORY . "  
                        WHERE status='".$status."' AND 
                       status='".ACTIVE."' AND 
                        ".$search_column." ".$condtional_operator." ".$search_by." ";
                        $result = Db::query(Database::SELECT, $query)
                                ->execute()
                                ->as_array();
                               
                        return count($result);
                }
 }
?>
