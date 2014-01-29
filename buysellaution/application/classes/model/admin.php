<?php defined('SYSPATH') or die('No direct script access.');

/* Contains Admin (User Management ,Edit/Delete/Count/Block) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Model_Admin extends Model
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
        
        /*
        * Get Db Language
        */
        public function get_db_language()
        {
                $lanuage_updated = DB::select('site_language')->from(SITE)
                ->execute()
                ->as_array();
                return $lanuage_updated;
        }

        /**To Get Current TimeStamp**/
        public function getCurrentTimeStamp()
        {
                 return date('Y-m-d H:i:s', time());
        }

        /**
        * ****count_user_list()****
        *
        * @return user list count of array 
        */
	public function count_user_list()
	{
	
	 $rs = DB::select()->from(USERS)
	 			->where('status','=',ACTIVE)
	 			->or_where('status','=',IN_ACTIVE)
				->execute()
				->as_array();	

	 return count($rs);
	}
        /**
        * ****admin_login()****
        * @param $email varchar, $password varchar
        * @return int one or zero
        */
	public function admin_login($email = "", $password = "")
	{
                $password = md5($_POST['password']);
                $resultset = DB::select()->from(USERS)
                ->where('email', '=', $email)
                ->where('password', '=', $password)
                ->where('usertype', '=','A')
                ->where('status','=','A')
                ->execute()
                ->as_array();
		if(count($resultset) == 1)
		{
			$this->session->set("email",$resultset[0]["email"]);
			$this->session->set("username",$resultset[0]["username"]);
			$this->session->set("id", $resultset[0]["id"]);
			$this->session->set("user_type", $resultset[0]["usertype"]);
			//Front end login
			$this->session->set("auction_username",$resultset["0"]["username"]);
			$this->session->set("auction_userid",$resultset["0"]["id"]);
			$this->session->set("user_type",$resultset["0"]["usertype"]);
			$this->session->set("auction_email",$resultset["0"]["email"]);
			return 1;
	 	}
		else{
                        $email = DB::select()->from(USERS)
                                ->where('email', '=', $email)
                                ->execute()
                                ->as_array();
                        if(count($email) == 0){
                        return 2;
			}return 0;
		}

	}
	
	// Replay status for contact request 
	public function status_reply($current_uri)
	{
			
			$query = array('status'=>ACTIVE);
			$resule   = DB::update(CONTACT_REQUEST)
					 ->set($query)
					 ->where('id', '=', $current_uri)
					 ->execute();
			
	}

        /**
        * ****user_list()****
        * @return user list array
        */
	public function user_list()
	{
                $rs = DB::select()->from(USERS)
                        ->order_by('firstname','ASC')
                        ->execute()
                        ->as_array();
                return $rs;
	}

        /**
        * ****count_deposits_list()****
        * @return deposits list count of array
        */
	public function count_deposits_list()
	{
                $rs = DB::select()
                        ->from(PACKAGE_ORDERS)
                        ->join(USERS,'left')
			->on(USERS.'.id','=',PACKAGE_ORDERS.'.buyer_id')
			->where(USERS.'.status','=',ACTIVE)
			->and_where(USERS.'.usertype','!=',ADMIN)		
                        ->execute()
                        ->as_array();
                return count($rs);
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
			$name_where  = " firstname";
			$name_where .= " lastname ";
			$name_where .= " username ";
                        $query = "select * from ". USERS . " order by firstname ASC limit $offset,$val";
                        $result = Db::query(Database::SELECT, $query)
                        ->execute()
                        ->as_array();
                return $result;
	}

        /** 
        * Select winners and deposits users
        * @return array list of all deposits, users 
        * all wih pagination
        */	
	public function all_user_list_deposits($offset, $val)
	{
		return $query = DB::select()
			->from(PACKAGE_ORDERS)
                        ->join(USERS,'left')
			->on(USERS.'.id','=',PACKAGE_ORDERS.'.buyer_id')
			->where(USERS.'.status','=',ACTIVE)
			->and_where(USERS.'.usertype','!=',ADMIN)			
			->limit($val)
			->offset($offset)
			->order_by(PACKAGE_ORDERS.'.order_date','desc')
			->execute()
			->as_array();
	}

        /**
        * ****edit_users()****
        *@param $current_uri int,$_POST array
        *@return alluser list count of array
        */
        public function edit_users($current_uri, $_POST,$image_name)
        {
                $random_key = Commonfunction::admin_random_user_password_generator();
		//$abt_me = isset($_POST['aboutme'])?$_POST['aboutme']:"";
		$status = isset($_POST['status'])? ACTIVE : IN_ACTIVE;
		
	        if($_POST['lat']=="")
		{
		$query = array('firstname' => $_POST['firstname'],
			'lastname' => $_POST['lastname'], 'email' => $_POST['email'], 'username' => $_POST['username'],
			'status' => $status,'activation_code' => $random_key,'country'=>$_POST['country'],'address'=>$_POST['address']);
		}
		else
		{
		$query = array('firstname' => $_POST['firstname'],
			'lastname' => $_POST['lastname'], 'email' => $_POST['email'], 'username' => $_POST['username'],
			'status' => $status,'activation_code' => $random_key,'country'=>$_POST['country'],'address'=>$_POST['address'],'latitude'=>$_POST['lat'],'longitude'=>$_POST['lng']);
	        }

		if($image_name != "")  $query[ 'photo' ]=$image_name ;
		$result =  DB::update(USERS)->set($query)
						->where('id', '=' ,$current_uri)
						->execute();
		if(count($result) > 0){
			$sql = "SELECT status FROM ".USERS." WHERE id ='$current_uri' ";   
			$result=Db::query(Database::SELECT, $sql)
				->execute()
				->as_array();
			return $result;
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

        public function user_bid_added($userid,$free_bid_amount)
	{		
			$query = array('user_bid_account'=>$free_bid_amount);
			$resule   = DB::update(USERS)
					 ->set($query)
					 ->where('id', '=', $userid)
					 ->execute();
		        return $resule;
	}
	/*
	*To Check User Name is Already Available or Not
	*/
	
	public static function unique_username($name)
	{
	   $sql = "SELECT username FROM ".USERS." WHERE username='$name' AND status!='D' ";   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();

			if(count($result) > 0)
			{
				return 1;
			}
			else
			{
				return 0;		
			}
        }

	/*
	*To Check UserName is Already Available while Edit User Details
	*/
	public static function unique_username_update($name,$id)
	{
			$sql = "SELECT username FROM ".USERS." WHERE username='$name' AND id !='$id' AND status!='D' ";   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();

			if(count($result) > 0)
			{
				return 1;
			}
			else
			{
				return 0;		
			}
	}

	/*
	*Check Whether Email is Already Exist or Not
	*/
	public function check_email($email="")
	{
		$result=DB::select('email')->from(USERS)
                        ->where('email', '=', $email)
                        ->and_where('status', '!=',DELETED_STATUS)
			->execute()
			->as_array();
			if(count($result) > 0)
			{

				return 1;
			}
			else
			{
				return 0;
			}
	}
	
	//Check user email
	public function check_email_update($email="",$id="")
	{
	$sql = "SELECT email FROM ".USERS." WHERE email='$email' AND id !='$id' AND status!='D'";   
	$result=Db::query(Database::SELECT, $sql)
		->execute()
		->as_array();
              
		if(count($result) > 0)
		{ 
			return 1;
		}
		else
		{
			return 0;		
		}
	}
	
	//Check user email forget password
	public function check_adminemail_update($email="",$id="")
	{
	
		$sql = "SELECT email FROM ".USERS." WHERE email='$email' AND id !='$id' AND status!='D' AND usertype ='A'";   
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
			if(count($result) > 0)
			{ 
				return 1;
			}
			else
			{
				return 0;		
			}
	}
	

	/**Reset User Password if User Forgot Password**/

	public function forgot_password($array_data,$_POST,$random_key)
	{
		$mdate = $this->getCurrentTimeStamp();
		$pass= md5($random_key);
		// Create a new user record in the database
		$result = DB::update(USERS)->set(array('password' => $pass,'updated_date' => $mdate ))->where('email', '=', $array_data['email'])
			->execute();
		if($result){
		$rs = DB::select('username','email')->from(USERS)
	 			->where('email','=', $_POST['email'])
				//->and_where('usertype','=',ADMIN)
	 			->and_where('status','=',ACTIVE)
				->execute()
				->as_array();
			 return $rs;
		}else{
			return 0;
			}
	}

	

        /**
        * ****add_users()****
        *@return insert user values in database
        */
	public function add_users($validator,$_POST,$image_name,$activation_key)
	{	 
	    $randomkey = Commonfunction::admin_random_user_password_generator();
		 
	    $email = $_POST['email'];
	    $status = isset($_POST['status'])?"A":"I";
	    
		$rs   = DB::insert(USERS)
				->columns(array('firstname', 'lastname', 'email','username','photo','status','password','activation_code','country','address','latitude','longitude'))
				->values(array($_POST['firstname'],$_POST['lastname'], 
				$_POST['email'], $_POST['username'],$image_name,$status,md5($activation_key),$randomkey,$_POST['country'],$_POST['address'],$_POST['lat'],$_POST['lng']))
				->execute();
				
		if($rs){
			$email = DB::select()->from(USERS)
				           ->where('email', '=', $email)
						    ->execute()
			               ->as_array(); 
			return $email;
			}
		else{
			if(count($email) == 0){
				return 2;
			}
				return 0;
		}
	}

	//function for auto login while clicking activation_link
	public function auto_user_login($activation_code)
	{
	              
			$rs = DB::select('username','id')->from(USERS)
							 ->where('activation_code', '=' ,$activation_code)
							 ->execute()
							 ->as_array();	
			if(count($rs) == 1){
				$this->session->set("UserName",$rs[0]["username"]);
				$this->session->set("UserId",$rs[0]["id"]);
				return 1;
			}
	}
	
        /**
        * ****delete_users()****
        *@param $current_uri int
        *@delete user items
        */
	public function delete_users($current_uri)
	{
			//get username and email for sending mail to users
			$username = DB::select('username','email','status','login_type')->from(USERS)
				 ->where('id', '=', $current_uri)
				 ->execute()
				 ->as_array();
			if($username)
			{
			 $query = array('status'=>DELETED_STATUS);
			 $resule   = DB::update(USERS)
					 ->set($query)
					 ->where('id', '=', $current_uri)
					 ->execute();
			}
		        return $username;
	}
	
	
	/**
        * ****delete_users_update()****
        *@param $current_uri int
        *@delete user items
        */
	public function delete_users_update($current_uri)
	{		
			
			$query = array('status'=>DELETED_STATUS);
			$resule   = DB::update(USERS)
					 ->set($query)
					 ->where('id', '=', $current_uri)
					 ->execute();
		        return $query;
	}

        public function user_message_update($oldmail)
	{	
			$queryvalue = array('user_status'=>DELETED_STATUS);
			$resule_value   = DB::update(USER_MESSAGE)
					 ->set($queryvalue)
					 ->where('usermessage_to', '=', $oldmail)
					 ->execute();				 
			
		        return $resule_value;
	}


        /**
        * ****delete_users_login()****
        *@param $current_uri int
        *@delete user login ip & browser details
        */
	public function delete_users_login($user_login_chk)
        {
		$query = DB::delete(USER_LOGIN_DETAILS)
				->where('id', 'IN', $user_login_chk)
			    	->execute();
			return 1;
	}

        /**
        * ****export_data()****
        *@export user listings
        */
	public function export_data($keyword ="",$user_type ="",$status="")
	{
		$keyword = str_replace("%","!%",$keyword);
			$keyword = str_replace("_","!_",$keyword);

		$xls_output = "<table border='1' cellspacing='0' cellpadding='5'>";
		$xls_output .= "<th>"."First Name"."</th>";
		$xls_output .= "<th>"."Last Name"."</th>";
		$xls_output .= "<th>"."E-mail"."</th>";
		$xls_output .= "<th>"."User Name"."</th>";
		$xls_output .= "<th>"."User Type"."</th>";
		$xls_output .= "<th>"."Status"."</th>";
		$file = 'Export';

		//condition for Usertype
		//====================== 
		$usertype_where= ($user_type) ? " AND usertype = '$user_type'" : "";

		
		//condition for status
		//====================== 

		$staus_where= ($status) ? " AND status = '".ACTIVE."' or status ='".IN_ACTIVE."' " : "";
	
		//search result export
                //=====================
		$name_where="";	

		if($keyword){
			$name_where  = " AND(firstname LIKE  '%$keyword%' ";
			$name_where .= " or lastname LIKE  '%$keyword%' ";
			$name_where .= " or username LIKE '%$keyword%' escape '!') ";
        }

			$query = " select distinct firstname,lastname,username,email,usertype,status from " . USERS . " where 1=1 AND status != '".DELETED_STATUS."' $usertype_where $staus_where $name_where order by firstname ASC";
			
	 		$results = Db::query(Database::SELECT, $query)
			   			 ->execute()
						 ->as_array();


		foreach($results as $result)
		{
			$status = ($result['status'] == "A") ? "Active" : "Inactive";
			$type   = ($result['usertype']== "A") ? "Admin" : "User";
			$xls_output .= "<tr>"; 
			$xls_output .= "<td>".mb_convert_encoding($result['firstname'],'utf-16','utf-8')."</td>"; 
			$xls_output .= "<td>".mb_convert_encoding($result['lastname'],'utf-16','utf-8')."</td>"; 
			$xls_output .= "<td>".$result['email']."</td>"; 
			$xls_output .= "<td>".mb_convert_encoding($result['username'],'utf-16','utf-8')."</td>"; 
			$xls_output .= "<td>".$type."</td>"; 
			$xls_output .= "<td>".$status."</td>"; 
			$xls_output .= "</tr>"; 
		}
		$xls_output .= "</table>";
		$filename = $file."_".date("Y-m-d_H-i",time());
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Length: " . strlen($xls_output));
		header("Content-type: application/vnd.ms-excel");
		header("Content-type: application/octet-stream, charset=UTF-8; encoding=UTF-8");
		header("Content-Disposition: attachment; filename=".$filename.".xls");
		echo $xls_output; 
		exit;
	}

        /**
        * ****get_user_status()****
        *@return user status
        */
	public function get_user_status()
	{
	 	$rs   = DB::select('status')->from(USERS)
				->group_by('status')
			    	->execute()
				->as_array();
		return $rs;
	}

        /**
        * ****add_user_form()****
        *@param $arr validation array
        *@validation check
        */
	public function validate_user_form($arr)
	{
					$arr['firstname'] = trim($arr['firstname']);
					$arr['email'] = trim($arr['email']);
					//updated for trim of username while posting and not proper validation
					
					$arr['username'] = trim($arr['username']);
					
		return Validation::factory($arr)
					->rule('firstname','not_empty')
					->rule('lastname', 'min_length', array(':value', '1'))
					->rule('firstname', 'min_length', array(':value', '4'))
					->rule('firstname', 'max_length', array(':value', '32'))
					->rule('photo','Upload::type',array(':value',array('jpg', 'png', 'gif')))
					->rule('photo','Upload::size',array(':value', '2M'))
					->rule('photo','Upload::type',array(':value',array('jpg', 'png', 'gif')))
					->rule('photo','Upload::size',array(':value', '2M'))
					->rule('email','not_empty')
					->rule('email','email_domain')
					->rule('username', 'not_empty')
					->rule('username', 'alpha_space')
					->rule('username', 'min_length', array(':value', '4'))					
					->rule('country','Model_Users::check_country_not_null',array(":value","-1"))
					->rule('username', 'max_length', array(':value', '30'));
					
	}
        /**
        * ****validate_login()****
        *@param $arr validation array
        *@validation check
        */
	public function validate_login($arr)
	{
		$arr['email'] = trim($arr['email']);
		return Validation::factory($arr)
		->rule('email','not_empty')
		->rule('email','email')
		//->rule('password','valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
		->rule('password', 'not_empty');
	}

        /**
        * ****get_all_search_list()****
        *@param $keyword string, $user_type char, $status char
        *@return search result string
        */
	public function get_all_search_list($keyword = "", $user_type = "", $status = "")
	{
	        $keyword = str_replace("%","!%",$keyword);
		$keyword = str_replace("_","!_",$keyword);
		//condition for status
		$usertype_where= ($user_type) ? " AND usertype = '$user_type'" : "";
		//condition for status
		$staus_where= ($status) ? " AND status = '$status'" : "";
		$name_where="";
	                if($keyword)
	                {
		                $name_where  = " AND(firstname LIKE  '%$keyword%' ";
		                $name_where .= " or lastname LIKE  '%$keyword%' ";
		                $name_where .= " or username LIKE '%$keyword%') ";
	                }
		$query = "select distinct id,firstname,lastname,username,email,usertype,status from " . USERS . " where 1=1 ".$usertype_where."  ".$staus_where."  ".$name_where." order by created_date desc ";
	 		$results = Db::query(Database::SELECT, $query)
			   			 ->execute()
						 ->as_array();
				return $results;

         }


        /**
        * ****get_sendemail_validation()****
        *@param $arr validation array
        *@validation check
        */
	public function get_sendemail_validation($arr)
	{
		$arr['subject'] = trim($arr['subject']);
		$arr['message'] = trim($arr['message']);
		return Validation::factory($arr)       
			->rule('user_status','not_empty')
			->rule('to_user','not_empty')
			->rule('subject','not_empty')
			->rule('subject','alpha_space')
			->rule('subject', 'min_length', array(':value', '10'))
			->rule('subject', 'max_length', array(':value', '128'))			
			->rule('subject','alpha_space')
			->rule('message','not_empty')
			->rule('message', 'min_length', array(':value', '20'))
			->rule('message', 'max_length', array(':value', '500'));
    	}

        //Upload Image validation
	public function image_upload($_FILES)
	{
		return Validation::factory($_FILES)
			->rule('photo','Upload::not_empty')
		        ->rule('photo','Upload::valid')
			->rule('photo','Upload::type',array('Upload::type',array('jpg','png','gif')));
	}

        /**
        * ****sendemail()****
        *@email send to too many (bulk) users
        */
	public function sendemail($details,$headers,$variables,$from,$smtp_settings) 
	{

		//mail sending option to all users and insert userid in database
 		$user_id = "";
		$user_id = count($_POST['to_user']);
		for ($i=0; $i<$user_id;$i++) {
 	 	    $to    = DB::select('email','username','status')
	 	                        ->from(USERS)
				        ->where('id','=',$_POST['to_user'][$i])
			                ->execute()
					->as_array(); 
			$subject = $details['subject']; 
			$message = $details['message'];		   
		   
		         //send bulk mail to users
		        //======================= 
                        $headers = __('email_header_text'). "\r\n";
                        $headers .= __('email_content_type') . "\r\n";
                        $headers .= __('email_from'). $from . "\r\n";

                                        try{
                                                if(Email::connect($smtp_settings))
                                                {                         	

                                                        if(Email::send($to[0]['email'],$from, $subject, $message,$html = true) == 0)                                      {                                  		                

                                                        }

                                                }	 
                                        }catch(Exception $e){

                                                if(mail($to[0]['email'], $subject, $message, $headers))
                                                {   
                                                     
                                                }
                                        }
			$result = DB::insert(BULKEMAIL)
						  ->columns(array('user_id','user_status'))
						  ->values(array($_POST['to_user'][$i],$to[0]['status']))
						  ->execute();
	                $usermessage   = DB::insert(USER_MESSAGE,array('usermessage_to', 'usermessage_from', 'usermessage_subject','usermessage_message'))
				                  ->values(array($to[0]['email'],$from,$subject,$message))
				                  ->execute();
				
		}
	}
	
        /**
        * **** get_user_type_list()****
        *@param $email varchar
        *@email send to users
        */
	public function get_user_type_list($status_val,$validator,$error)
	{
		$users_validator = array();
		if(count($validator) > 0 ){
		        $users_validator = explode(",",$validator['validator'][0]['to_user']);
		}
		$status = ($status_val['status'] == 'A')?ACTIVE:IN_ACTIVE;
	 	$rs     = DB::select('id','username')->from(USERS)
						->where('status', '=',$status)
						->order_by('username','ASC')
				   	 	->execute()
				   	 	->as_array();
		$build_dd="<select name='to_user[]' multiple='multiple' id='users'>";
		foreach($rs as $result)
		{
			$selected=(in_array($result['id'],$users_validator)) ? "selected='selected' " :'';
			$name = ucfirst($result['username']);
			$build_dd .= "<option value='".$result['id']."' $selected >".$name."</option>";
		}
       		echo $build_dd .= "</select>";
	       if(count($error['errors']) > 0){
		       $build_dd = "<span class='error'>";
		       $build_dd .=$error['errors'][0]['to_user'];
		       $build_dd .="</span>";
		       echo $build_dd;
	       }
		   exit;

	}

        /**
        * ****all_user_login_list()****
        *@param $offset int, $val int
        *@return alluser list count of array
        */
	public function all_user_login_list($offset, $val)
	{
		//Query for listing login listings
		$query  = "select ".USER_LOGIN_DETAILS.'.last_login'.','.USER_LOGIN_DETAILS.
				'.login_ip'.','.USER_LOGIN_DETAILS.'.user_agent'.','.USER_LOGIN_DETAILS.'.ban_ip'.',
				'.USER_LOGIN_DETAILS.'.id'.','.USERS.'.username'." from ". USER_LOGIN_DETAILS .
				" left join ".USERS. " on ". 	USERS.'.id' .'='. USER_LOGIN_DETAILS.'.userid'." order by last_login DESC limit $offset, $val ";

		$results = Db::query(Database::SELECT, $query)
				->execute()
				->as_array();
	 	return $results;

	}

        /**
        * ****get_all_user_login_search_list()***
        *@param $keyword string, $user_type char, $status char
        *@return search result string
        */
	public function get_all_user_login_search_list($keyword = "")
	{

			$keyword = str_replace("%","!%",$keyword);
			$keyword = str_replace("_","!_",$keyword);

		$name_where = "";
		if($keyword)
		{
		        $name_where  = " WHERE 1=1 AND(username LIKE  '%$keyword%' escape '!' ";
		        $name_where .= " OR ".USER_LOGIN_DETAILS.".login_ip LIKE  '%$keyword%' escape '!' ) ";
		}
		
		//Query for listing login listings   
		$query  = "select ".USER_LOGIN_DETAILS.'.last_login'.','.USER_LOGIN_DETAILS.
				'.login_ip'.','.USER_LOGIN_DETAILS.'.user_agent'.','.USER_LOGIN_DETAILS.'.ban_ip'.',
				'.USER_LOGIN_DETAILS.'.id'.','.USERS.'.username'." from ". USER_LOGIN_DETAILS .
				" left join ".USERS. " on ". 	USERS.'.id' .'='. USER_LOGIN_DETAILS.'.userid'.$name_where." order by last_login DESC ";
	 
		$results = Db::query(Database::SELECT, $query)
				->execute()
				->as_array();

	 	return $results;

        }		

	/**Check Image Exist or Not while Updating Users Details**/
	public function check_userphoto($userid="")
	{
		$sql = "SELECT photo FROM ".USERS." WHERE id ='$userid'";
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
			if(count($result) > 0)
			{
				return $result[0]['photo'];
			}
	}
		
	//update site logo null
	public function update_logo_image($id)
	{
		$sql_query = array('site_logo' => "");
		$result =  DB::update(SITE)->set($sql_query)
			->where('id', '=' ,$id)
			->execute();
		return 1;
	}

        //Change Password validation
	public function change_password_validation($arr)
	{
		return Validation::factory($arr)
			->rule('old_password','valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
			->rule('old_password', 'not_empty')
			->rule('old_password', 'min_length', array(':value', '4'))
			->rule('old_password', 'max_length', array(':value', '16'))
			->rule('new_password', 'not_empty')
			->rule('new_password','valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
			->rule('confirm_password', 'not_empty')
			->rule('confirm_password','valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
			->rule('confirm_password', 'min_length', array(':value', '4'))
			->rule('confirm_password',  'matches', array(':validation', 'old_password', 'confirm_password'))
			->rule('confirm_password', 'max_length', array(':value', '16'));
        }
        
       /**User Change Password**/
	public function change_password($array,$_POST,$userid="")
	{
		$pass=md5($array['confirm_password']);
		// Create a new user record in the database
		$result = DB::update(USERS)
			->set(array('password' => $pass ))
			->where('id', '=', $userid)
			->execute();
		if(count($result) == SUCESS)
		{
			$rs = DB::select('username','password','email')
				->from(USERS)

				->where('id', '=', $userid)
				->execute()
				->as_array();
			return $rs;
		}
	}

	/**Validating Change Password Details**/

	public function validate_changepwd($arr)
	{
		return Validation::factory($arr)
			->rule('old_password', 'not_empty')
			->rule('old_password', 'valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
			->rule('old_password', 'max_length', array(':value', '16'))
			->rule('new_password', 'not_empty')
			->rule('new_password', 'valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
			->rule('new_password', 'max_length', array(':value', '16'))
			->rule('confirm_password', 'not_empty')
			->rule('confirm_password','valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
			->rule('confirm_password',  'matches', array(':validation', 'new_password', 'confirm_password'))
			->rule('confirm_password', 'max_length', array(':value', '16'));
	}

	/**Validating Reset Password Details **/
	public function validate_resetpwd($arr)
	{
		return Validation::factory($arr)
			->rule('new_password', 'not_empty')
			->rule('new_password', 'valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
			->rule('new_password', 'max_length', array(':value', '16'))
			->rule('conf_password', 'not_empty')
			->rule('conf_password', 'valid_password',array(':value','/^[A-Za-z0-9@#$%!^&*(){}?-_<>=+|~`\'".,:;[]+]*$/u'))
			->rule('conf_password', 'max_length', array(':value', '16'));
	}

	/**Check Whether the Eneterd Password is Correct While User Change Password**/

	public function check_pass($pass="",$userid="")
	{
		$result = DB::select()->from(USERS)
			->where('id', '=', $userid)
			->execute()
			->as_array();
		$pass=md5($pass);
		$password=$result["0"]["password"];
			if($password == $pass)
			{
				return 1;
			}
			else
			{
				return 0;
			}
	}

	/**User Reset Password**/
	public function reset_password($array,$_POST,$id)
	{
		$pass=md5($array['conf_password']);
		// Create a new user record in the database
		$result = DB::update(USERS)
			->set(array('password' => $pass ))
			->where('id', '=', $id)
			->execute();
		echo "ok";
		return 1;
	}

        /**
        * ****count_user_messages_list()****
        * @return user messages count
        */
	public function count_user_messages_list()
	{
	         $rs = DB::select()->from(USER_EMAIL)
				        ->execute()
				        ->as_array();
	         return count($rs);
	}

	
        /**
        * ****all_msg_sender_list****
        *@return all buyers(who order job) list
        */
	public function all_msg_sender_list()
	{
		$query =  " SELECT  DISTINCT U1.username AS buyername,U1.id AS userid1
						FROM ".USER_EMAIL." AS UEB
						LEFT JOIN ".USERS." AS U1 ON ( U1.id = UEB.sender_id )
						LEFT JOIN ".PRODUCTS." AS P ON ( P.product_id = UEB.product_id )
						ORDER BY U1.username ASC ";
		$result = Db::query(Database::SELECT, $query)
			    	  ->execute()
			    	  ->as_array();
		return $result;
		 }

        /**
        * ****all_msg_receiver_list****
        *@return all seller(who doing product) list
        */
	public function all_msg_receiver_list()
	{
		$query =  " SELECT  DISTINCT U.username AS sellername,U.id AS userid
						FROM ".USER_EMAIL." AS UEB
						LEFT JOIN ".USERS." AS U ON ( U.id = UEB.receiver_id )
						LEFT JOIN ".PRODUCTS." AS P ON ( P.product_id = UEB.product_id )
						ORDER BY U.username ASC ";
		$result = Db::query(Database::SELECT, $query)
			    	  ->execute()
			    	  ->as_array();
		return $result;

		}



        /**
        * ****get_all_user_messages_search_list()***
        *@param $keyword string, $user_type char, $status char
        *@return search result string
        */
        public function get_all_user_messages_search_list($sender_search = "", $receiver_search = "", $order_search = "", $job_search ="")
        {
	        //condition for product search
	        $job_where= ($job_search) ? " AND UE.product_id = '$job_search'" : "";
	        //condition for sender name
	        $sender_where= ($sender_search) ? " AND  UE.sender_id = '$sender_search'" : "";
	        //condition for receiver name
	        $receiver_where= ($receiver_search) ? " AND  UE.receiver_id = '$receiver_search'" : "";
	        //condition for job order search
	
	        $job_order_where= ($order_search) ? " AND  UE.order_no LIKE '%$order_search%'" : "";
	        $query = "SELECT UE.order_no,UE.subject,
				                U.username AS sendername,
				                U1.username AS receivername,
						          U.id AS usrid,
						          U.status as senderstatus,
						          U.usertype as sendertype,
						          UE.random_number,
						          P.product_name,
						          P.product_url,
						          UE.sent_date,
						          UE.id,
						          UE.flag_status
					          FROM ".USER_EMAIL." AS UE
	               		                  LEFT JOIN ".PRODUCTS." AS P ON (P.product_id = UE.product_id)
			         		  LEFT JOIN ".USERS." AS U ON(U.id = UE.sender_id)
			         		  LEFT JOIN ".USERS." AS U1 ON(U1.id = UE.receiver_id)
					          WHERE 1=1 $job_where $sender_where $receiver_where $job_order_where order by UE.sent_date DESC ";
         		$results = Db::query(Database::SELECT, $query)
		           			 ->execute()
					         ->as_array();
		        return $results;
   	}

	

        /**
        * ****update_flag_status()****
        *@return update flag status in database
        */
	public function update_flag_status($msg_id, $flag_status)
	{
		$db_set ="";
		switch ($flag_status)
		{
			case ACT:
			        // if status is ACTIVE means
				$db_set = " flag_status = '".IN_ACTIVE."' ";
			break;
			case INACT:
				// if status is IN_ACTIVE means
				$db_set = " flag_status = '".ACTIVE."' ";
			break;
		}

		   $query = " UPDATE ". USER_EMAIL ." SET $db_set WHERE 1=1 AND id = '$msg_id' ";
	           $result = Db::query(Database::UPDATE, $query)
			    ->execute();
			return $result;

	}


        /**
        * ****update_sender_status()****
        *@return update flag status in database
        */
	public function update_sender_status($sender_id,$sender_status)
	{
		$db_set ="";
		switch ($sender_status){
			case 1:
			        // if status is ACTIVE means
				$db_set = " status = '".IN_ACTIVE."' ";
			break;
			case 0:
				// if status is IN_ACTIVE means
				$db_set = " status = '".ACTIVE."' ";
			break;
		}

		   $query = " UPDATE ". USERS ." SET $db_set WHERE 1=1 AND id = '$sender_id' ";
	           $result = Db::query(Database::UPDATE, $query)
			    ->execute();
			return $result;
	}

        /**
        * ****more_user_action()****
        *@return delete,flag,unflag etc.....
        */
	public function more_user_action($type,$msg_id)
	{
		//if action delete means
		if($type == "del"){
			$query = DB::delete(USER_EMAIL)
					 ->where('id', 'IN', $msg_id)
					 ->execute();
			return $type;
		}
		$db_set = "";
		
		//checking for more action to do using $type
		        switch($type)
		        {
			        //if action "INACTIVE_ACTION" selected means
			        case "inactive":
                                        // if inactive is selected set value is "I"
				        $db_set = "status = '".IN_ACTIVE."' ";
				        break;
			        //if action "ACTIVE" selected means


		                case "active":
			                // if ACTIVE is selected set value is "A"
			                $db_set = "status = '".ACTIVE."' ";
		           	break;
		        }
			//update database with $msg_id and all other details(delete, flag, unflag)
			
		$query = " UPDATE ". USERS ." SET $db_set WHERE 1=1 AND usertype!='".ADMIN."' AND id IN ('" . implode(',',$msg_id) . "') ";
		
		$update_result = Db::query(Database::UPDATE, $query)
					  		 ->execute();
			if(count($update_result) > 0){return $update_result;}else{return 0;}

		//checking for more action to do using $type
		switch($type)
		{
			//if action "flag" selected means
			case "flag":
			        // if flag is selected set value is "A"
				$db_set = " flag_status = '".ACTIVE."' ";
				break;
			//if action "unflag" selected means
			case "unflag":
			        // if unflag is selected set value is "I"
				$db_set = " flag_status = '".IN_ACTIVE."' ";
		   		break;
		}
		//update database with $msg_id and all other details(delete, flag, unflag)
		$query = " UPDATE ". USER_EMAIL ." SET $db_set WHERE 1=1 AND id IN ('" . implode("','",$msg_id) . "') ";
		$update_result = Db::query(Database::UPDATE, $query)
				  		 ->execute();
		return $update_result;
	}

        /**
        * ****count_contact_requests_list()****
        *
        * @return contact_details count of array
        */
	public function count_contact_requests_list()
	{
	         $rs = DB::select()->from(CONTACT_REQUEST)
				        ->execute()
				        ->as_array();
	         return count($rs);
	}

        /**
        * ****all_contact_requests_list()****
        **param offset int,$val int
        *@return all contact_request list
        */
	public function all_contact_requests_list($offset,$val)
	{
		//query to display all contact_request listings
		$query = " SELECT U.username AS username,CR.name AS name,
						CR.subject,CR.message,CS.subject AS subject1,
						CR.email,CR.telephone,CR.id,CR.status,
						CR.ip,CR.request_date
						FROM ".CONTACT_REQUEST." AS CR
						LEFT JOIN ".USERS." AS U ON ( U.id = CR.user_id )
						LEFT JOIN ".CONTACT_SUBJECT." AS CS ON(CS.id = CR.contact_subjectid)
						ORDER BY CR.request_date DESC LIMIT $offset,$val ";
		$result = Db::query(Database::SELECT, $query)
		    	  ->execute()
		    	  ->as_array();
		return $result;

		 }

        /**
        * ****delete_contact_request()****
        **param $deleteids array
        *@return all delete_contact_request list
        */
	public function delete_contact_request($deleteids)
	{
		//check whether id is exist in checkbox or single delete_contact_request
	        $deleteids = is_array($deleteids)?implode(",",$deleteids):$deleteids;
		$arr_chk = " id in ( $deleteids ) ";
		$query = " Delete from ". CONTACT_REQUEST . " where $arr_chk ";
		$result = Db::query(Database::DELETE, $query)
		    	  ->execute();
		return count($result);
	}


        /**
        * ****get_contact_request_details()****
        *@param $id int
        *@return all contact request lists
        */
	public function get_contact_request_details($id)
	{
		//query to display all contact_request listings
		$query = " SELECT CR.email,CR.subject,CR.message,CS.subject
				FROM ".CONTACT_REQUEST." AS CR
				LEFT JOIN ".CONTACT_SUBJECT." AS CS ON (CS.id = CR.contact_subjectid)
				WHERE CR.id = $id ";
		$result = Db::query(Database::SELECT, $query)
		    	  ->execute()
		    	  ->as_array();
		return $result;
	}

        //Auto Replay validation 
	public function validate_auto_reply_contact_form($arr)
	{
		$arr['subject'] = trim($arr['subject']);
		$arr['message'] = trim($arr['message']);
		return Validation::factory($arr)
			->rule('subject', 'not_empty')
			->rule('subject', 'min_length', array(':value', '5'))
			->rule('message','not_empty')	
			->rule('message', 'min_length', array(':value', '5'))
			->rule('message', 'max_length', array(':value', '500'));
		}

        /**
        *****update_auto_reply_status()****
        *@return update auto_reply_status in database
        */
	 public function update_auto_reply_status($reply_id)
	 {
		$result =  DB::update(CONTACT_REQUEST)->set(array('contact_request_reply' => SUCESS))
						->where('id', '=' ,$reply_id)
						->execute();
		return $result;

	 }

        /**
        *****update_banIP_status****
        *@return update BAN IP status in database
        */
	public function update_banIP_status($id, $status)
	{
		$db_set ="";
		switch ($status){
			case 0:
			        // if status is 0 means set block
			        $db_set = " ban_ip = '".BLOCK."' ";
			break;
		        case 1:
			        // if status is 1 means set unblock
				$db_set = " ban_ip = '".UNBLOCK."' ";
			break;
		}
                $query = " UPDATE ". USER_LOGIN_DETAILS ." SET $db_set WHERE 1=1 AND id = '$id' ";
                $result = Db::query(Database::UPDATE, $query)
                                         ->execute();
                if($result){
                //get selected ip blocked/unblocked means get user email address

                $query_email = "select email,username,".USER_LOGIN_DETAILS.".login_ip,".USER_LOGIN_DETAILS.
	                       ".ban_ip from ".USER_LOGIN_DETAILS." left join ".USERS. " on ".USERS.'.id' .'='.USER_LOGIN_DETAILS.'.userid'.
	                 		    " where ".USER_LOGIN_DETAILS.'.id'." = '$id' ";

                $email_result = Db::query(Database::SELECT, $query_email)
		                  ->execute()
		                  ->as_array();
			return $email_result;
		 }
	}

	/**Validating Forgot Password Details**/
	public function validate_forgotpwd($arr)
	{
		return Validation::factory($arr)
			->rule('email', 'email_domain')
			->rule('email', 'max_length', array(':value', '50'))
			->rule('email', 'not_empty');
	}

	/**Check Whether Email is Already Exist or Not**/

	public function check_email_admin($email="")
	{
		$result=DB::select()
		        ->from(USERS)
 			->where('email','=', $email)
 			->and_where('usertype','!=',ACTIVE)
			->execute()
			->as_array();
			if(count($result) > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
	}
	
	/**To count of view Testimonials **/		 
	public function count_testimonials_auctions()
	{
	    $user_testimonials_count = DB::select()

				->from(TESTIMONIALS)
				->join(USERS,'left')
				->on(USERS.'.id','=',TESTIMONIALS.'.user_id')
				->order_by('user_id','DESC')
				->execute();
	        return count($user_testimonials_count);
	}
	
	/** 
	* Select Testimonials and users table with left join 	
	* @param $offset,$val will be for pagination
	*/
	public function select_user_testimonials($offset, $val)
	{
			$query=DB::select()
				->from(TESTIMONIALS)
				->join(USERS,'left')
				->on(USERS.'.id','=',TESTIMONIALS.'.user_id')
				->order_by('testimonials_id','DESC')
				->limit($val)
				->offset($offset)
				->execute()
				->as_array();
			return $query;
	}

        /**
	* Validation rule for fields in user  testimonials form
	*/
	public function testimonials_validation($arr)
	{
	                $arr['title'] = trim($arr['title']);
		        $arr['description'] = trim($arr['description']);
		return Validation::factory($arr)


					->rule('username_id', 'not_empty')
					->rule('password','alpha_dash')
					->rule('title', 'not_empty')
					->rule('title', 'alpha_space')
					->rule('title', 'min_length', array(':value', '4'))
					->rule('title', 'max_length', array(':value', '30'))
					->rule('photo','Upload::type',array(':value',array('jpg', 'png', 'gif')))
					->rule('photo','Upload::size',array(':value', '2M'))
					->rule('description','not_empty')
					->rule('video','max_length', array(':value', '600'))
					->rule('description', 'min_length', array(':value', '10'));
	}

       /**Check Image Exist or Not while Updating testimonials Details**/
	public function check_testimonialsphoto($testimonialsid="")
	{
		$sql = "SELECT images FROM ".TESTIMONIALS." WHERE testimonials_id ='$testimonialsid'";
		$result=Db::query(Database::SELECT, $sql)
			->execute()
			->as_array();
			if(count($result) > 0)
			{
				return $result[0]['images'];
			}
			
	      
	}
	
	// Testimonials image delete
	public function delete_testimonialsimage($testimonialsid="")
	{
	                $query = array('images'=>"");
			$resule   = DB::update(TESTIMONIALS)
					 ->set($query)
					 ->where('testimonials_id', '=', $testimonialsid)
					 ->execute();
        }
        
        /** Testimonials**/
	public function add_video($testimonialsid,$add_testimonials,$photo="") 	
	{
	
		$url=$add_testimonials['video'];		
		if($url!='')
		{
			$title = $desc = $emb_code = $thumb_url= "";
			$video_url = explode('=',$url);	
			$video_url = explode('&',$video_url[1]);	
			$video_url = $video_url[0];  
			//Video html doc file
			  include Kohana::find_file('views','admin/simple_html_dom');

			$my_video = file_get_html($url); 
		if(!is_object($my_video))
		{
			$msg ="failed to open video stream: HTTP request failed!";
			//Flash message 
			Message::success($msg);
			return 0;
		}
		$t =  array();
		foreach($my_video->find('meta') as $title)
		{
			$t[]=$title->content ."<br>";
		}
		$title = $t[0];
		if(isset($t[2]))
		{
		$description = $t[2];  
		$tags =  '';

		foreach($my_video->find('div#watch-tags div a') as $tag) 
		{
			if($tags=="")
			{
				$tags =  $tag->innertext; 
			}
			else
			{
				$tags = $tags.",".$tag->innertext;                 
			}

		}  
		$embcode = "<object width='150' height='150' wmode='opaque' ><param name='movie' value='http://www.youtube.com/v/#videourl#'></param><param name='allowFullScreen' value='true'></param><param name='allowscriptaccess' value='always'></param><embed src='http://www.youtube.com/v/#videourl#' type='application/x-shockwave-flash' allowscriptaccess='always' allowfullscreen='true' width='".TESTIMONIALS_VIDEO_WIDTH."' height='".TESTIMONIALS_VIDEO_HEIGHT."' wmode='transparent'></embed></object>";
		$embedcode = str_replace('#videourl#', $video_url, $embcode);
		$embedcode = str_replace('#videourl#', $video_url, $embcode);
		$thumb_url = "http://i2.ytimg.com/vi/#videourl#/default.jpg" ; 

		$thumb_url = str_replace('#videourl#', $video_url, $thumb_url);        
		$title = strip_tags(HTML::chars($title));
		$desc = strip_tags(HTML::chars($description)); 
		$thumb_url =strip_tags(HTML::chars($thumb_url));
		$embedcode =Text::reduce_slashes($embedcode);
		}
		else 
		{
		return 0;
		}
		}
		else
		{
			$embedcode=$video_url=$thumb_url="";
		}
		if(isset($photo))
		{
			$photo=$photo;
		}     
                $query = array('user_id' =>$add_testimonials['username_id'],'title'=>$add_testimonials['title'],'description'=>$add_testimonials['description'],'embed_code'=>$embedcode,'video_url'=>$video_url,'thumb_url'=>$thumb_url);

		if($photo != "")  $query['images']=$photo ;

		$result =  DB::update(TESTIMONIALS)->set($query)
				->where('testimonials_id', '=',$add_testimonials['testimonials_id'])
				->execute();
				return 1;
	}

        /**
        * ****delete_testimonials()****
        *@param $current_uri int
        *@delete user items
        */
	public function delete_testimonials($current_uri)
	{	
			//delete user details from database
			$rs   = DB::delete(TESTIMONIALS)
					 ->where('testimonials_id', '=', $current_uri)
					 ->execute();
	}
	
        /**
        * ****Resumes_auction()****
        *@param $productid int
        *@suspend selected products 
        */
	public function auction_active($testimonialsid,$sus_status)
        { 
		$db_set ="";
		switch ($sus_status){
                          case "0":
                                        // if status is 0 means  
                                        $db_set = " testimonials_status = '".IN_ACTIVE."'";	
                           break;	
                           case "1":
                                        // if status is 1 means
                                        $db_set = " testimonials_status = '".ACTIVE."'";
                           break;				
		}
	      $query = " UPDATE ". TESTIMONIALS ." SET $db_set WHERE 1=1 AND testimonials_id = '$testimonialsid' ";	
	      $result = Db::query(Database::UPDATE, $query)
			    ->execute();			 		    
			return $result;
	}
	
        /**
        * ****get_testimonials_data()****
        *@param $current_uri int
        *@return alluser lists
        */
	public function get_testimonials_data($current_uri = '')
	{
                $rs   = DB::select()->from(TESTIMONIALS)
                        ->where('testimonials_id', '=', $current_uri)
                        ->execute()
                        ->as_array();
                return $rs;
	}

        /*
        *Validate  User Deposits
        *@Return view User Deposits
        */     
	 public function validate_update_deposits($arr) 
	{	 
		$arr['username'] = trim($arr['username']);
                return Validation::factory($arr)            
                                ->rule('username', 'not_empty')
                                ->rule('user_bid_account','not_empty')
                                ->rule('user_bid_account','numeric');
         }
        
        /*
        *Edit  list of  add deposits
        *@Return view user add deposits
        */   
        public function update_deposits($userdepositid ,$deposits_amount) 
        {
               $mdate = $this->getCurrentTimeStamp(); 
	        $query = DB::update(USERS)
	                                ->set(array('user_bid_account' =>$deposits_amount,
                          'updated_date'=>$mdate))
                                        ->where('id', '=',$userdepositid)
                                        ->execute();             
                if(count($query) > 0)
                {
                        return 1;
                        }else{
                        return 2;
                }
        }
        
        /**
        * ****all_username_list()****
        *@param $offset int, $val int
        *@return transaction  username count of array 
        */
	public function all_username_list()
	{

                $rs   = DB::select('username','id')->distinct(TRUE)
                                ->from(USERS)
                                ->where(USERS.'.status', '=', ACTIVE)
                                ->where(USERS.'.username', '!=', " ")
                                ->and_where(USERS.'.usertype', '!=',ADMIN)
                                ->order_by('username','ASC')
                                ->execute()	
                                ->as_array();
                return $rs;
	}
	
        /**
        * ****all_username_list()****
        *@param $offset int, $val int
        *@return transaction  username count of array 
        */
	public function all_package_list()
	{
                $rs   = DB::select()
                        ->from(BIDPACKAGES)
                        ->where(BIDPACKAGES.'.status', '=', ACTIVE)
                        ->execute()	
                        ->as_array();
                return $rs;
	}

        //Package List selected
	public function ajaxall_package_list($value)
	{
                $rs   = DB::select()
                        ->from(BIDPACKAGES)
                        ->where(BIDPACKAGES.'.status', '=', ACTIVE)
                        ->and_where(BIDPACKAGES.'.price', '=', $value)
                        ->execute()	
                        ->as_array();
                return $rs;
	}
	
	
        /*
        *Select deposits 
        *@Return view pages
        */      
 	public function adduser_deposits($userdepositid)
	{
		$result= DB::select('username','package_amount')
		                ->from(PACKAGE_ORDERS)
                                ->join(USERS,'left')
			        ->on(USERS.'.id','=',PACKAGE_ORDERS.'.buyer_id')
		                ->where(USERS.'.status', '=', ACTIVE)
		                ->where(USERS.'.id', '=', $userdepositid)
			        ->execute()	
			        ->as_array();		
               return $result;
	}
	
        /**
        * ****edit_users()****
        *@param $current_uri int,$_POST array
        *@return alluser list count of array
        */
        public function edit_deposits($current_uri, $_POST)
        {
		$query = array('firstname' => $_POST['firstname'],
			'lastname' => $_POST['lastname'], 'email' => $_POST['email'], 'username' => $_POST['username'],
			'status' => $status,'activation_code' => $random_key,'country'=>$_POST['country'],'address'=>$_POST['address']);
		$result =  DB::update(USERS)->set($query)
						->where('id', '=' ,$current_uri)
						->execute();
		if(count($result) > 0){
		
			$sql = "SELECT status FROM ".USERS." WHERE id ='$current_uri' ";   
			$result=Db::query(Database::SELECT, $sql)
				->execute()
				->as_array();
			return $result;
		}
         }
                    
        /**
        * ****delete_users_deposits()****
        *@param $current_uri int
        *@delete user items
        */
	public function delete_deposits($current_uri)
	{
		//get username and email for sending mail to users
			$user_deposits = DB::select('user_bid_account')->from(USERS)
				 ->where('id', '=', $current_uri)
				 ->execute()
				 ->as_array();

			if($user_deposits)
			{
			//delete user details from database
			$rs   = DB::delete(USERS)
					 ->where('id', '=', $current_uri)
					 ->execute();
			}
		return $user_deposits;
	}
	
	
	//select Testimonials Type id & amount 	
	public function select_tetimonials_bonus_status()

	{
	                   $result= DB::select()
	                            ->from(BONUS)
		                    ->where(BONUS.'.bonus_type_id', '=',2)
		                    ->execute()	
			            ->as_array();
                           return $result;  
	} 
		
	//select Testimonials Type id & amount 	
	public function select_tetimonials_bonus()
	{
	        $result= DB::select('bonus_amount','bonus_type_id')
	                            ->from(BONUS)
		                    ->where(BONUS.'.bonus_type_id', '=',2)
		                    ->and_where(BONUS.'.bonus_status', '=',ACTIVE)
		                    ->execute()	
			            ->as_array();
                       return $result;  

	} 
	
	//select User Email & bonus amount 
	public function select_user_amount($userid)
	{
	        $result= DB::select('user_bonus','email','user_bid_account')->from(USERS)
		                    ->where(USERS.'.id', '=',$userid)
		                    ->and_where(USERS.'.status', '=',ACTIVE)
		                    ->execute()	
			            ->as_array();
                       return $result;  
	} 
	
	//select Testimonials Status 
	public function select_tetimonials_status($testimonialsid)
	{
               $result= DB::select('testimonials_status')->from(TESTIMONIALS)
		                    ->where(TESTIMONIALS.'.testimonials_id', '=',$testimonialsid)
		                    ->execute()	
			            ->as_array();
                       return $result;  
	} 
	
	//select Admin Email 
	public function select_admin_email()
	{
	        $result= DB::select('email')->from(USERS)
		                    ->where(USERS.'.usertype', '=',ADMIN)
		                    ->and_where(USERS.'.status', '=',ACTIVE)
		                    ->execute()	
			            ->as_array();
                       return $result;  
	} 
	
	//select Testimonials users id  
	public function select_user_tetimonials()
	{
	        $result= DB::select('user_id')
	                             ->from(TESTIMONIALS)
			            ->execute()	
			            ->as_array();
                       return $result;  
	}
	
	//Update Testimonials Bonus Amount using users table 
	public function update_user_tetimonials_bonus($bonus_amount,$userid='')
	{
	  $result = DB::update(USERS)
	                ->set(array('user_bonus' => $bonus_amount))
	                ->where('id', '=', $userid)
			->execute();
	        
                       return $result;  
	}
	
	/**
        * ****Bonus_auction()****
        */
	public function bonus_active($testimonialsid,$sus_status)
        { 
		$db_set ="";
		switch ($sus_status)
		{
                          case "0":
                                        // if status is 0 means  
                                        $db_set = " testimonials_bonus = '".IN_ACTIVE."'";	
                           break;	
                           case "1":
                                        // if status is 1 means
                                        $db_set = " testimonials_bonus = '".ACTIVE."'";
                           break;				
		}
	      $query = " UPDATE ". TESTIMONIALS ." SET $db_set WHERE 1=1 AND testimonials_id = '$testimonialsid' ";	
	      $result = Db::query(Database::UPDATE, $query)
			    ->execute();			 		    
			return $result;
	}
	
	//Update Testimonials amount
	public function testimonials_amount($bonus_type,$bonus_amount,$userid='')
	{
			$result   = DB::insert(USER_BONUS,array('bonus_type', 'bonus_amount', 'userid'))
				->values(array($bonus_type,$bonus_amount,$userid))
				->execute();
				return $result;
			
	}
	
	//Insert from Testimonials messages  to user message table 
	public function user_message_tetimonials($select_email,$from,$subject,$message,$sent_date)
	{
			$result   = DB::insert(USER_MESSAGE,array('usermessage_to', 'usermessage_from', 'usermessage_subject','usermessage_message','sent_date'))
				->values(array($select_email,$from,$subject,$message,$sent_date))
				->execute();
				return $result;
	}
	
	//Order details Insert 
	public function addorder_details()
        {
                $ordercolumn = array('buyer_id','package_id','package_amount','order_date');
                $ordervalues = array($_POST['username'],$_POST['package_id'],$_POST['user_bid_account'],$this->getCurrentTimeStamp());
                $result = DB::insert(PACKAGE_ORDERS, $ordercolumn)
			->values($ordervalues)
			->execute();
		return $result;  
        } 
        
        //Add Transactionlog Details 
        public function addtransactionlog_details()
        {
                $transactionlogfields = array('userid','packageid','amount','transaction_date','amount_type');
                $transactionlogvalues = array($_POST['username'],$_POST['package_id'],$_POST['user_bid_account']
                ,$this->getCurrentTimeStamp(),CREDIT);
                $result = DB::insert(TRANSACTION_DETAILS, $transactionlogfields )
			->values($transactionlogvalues)
			->execute();
		return $result; 
        }
        
        //Paypal Transactionlog  Details
        public function paypal_transactionlog_details($user_mail,$admin_mail,$currency_code)
        {
                $transactionlogfields = array('USERID','PACKAGEID','AMT','TIMESTAMP','LOGIN_ID','PAYMENTSTATUS','RECEIVER_EMAIL','EMAIL','PAYMENTTYPE','CURRENCYCODE');
                $transactionlogvalues = array($_POST['username'],$_POST['package_id'],$_POST['user_bid_account']
                ,$this->getCurrentTimeStamp(),Request::$client_ip,SUCCESS,$admin_mail,$user_mail,OFFLINE,$currency_code);
                $result = DB::insert(PAYPAL_TRANSACTION_DETAILS, $transactionlogfields )
			->values($transactionlogvalues)
			->execute();
		return $result; 
        }
        
        /**
        * ****count_user_message()****
        * @return user list count of array
        */
	public function count_user_message()
	{
                $rs = DB::select()
                        ->from(USER_MESSAGE)
                        ->execute()
                        ->as_array();
                return count($rs);
	}
	
	//Select user messages
	public function all_user_message($offset, $val)
	{
		return $query = DB::select()
			->from(USER_MESSAGE)
                        ->limit($val)
			->offset($offset)
			->order_by(USER_MESSAGE.'.sent_date','desc')
			->execute()
			->as_array();
	}
	
	/** 
	* Select users mail 	
	*/
	public function select_user_message_details($messageid)
	{
		$query=DB::select(USER_MESSAGE.'.usermessage_to',
				USER_MESSAGE.'.usermessage_from',
				USER_MESSAGE.'.usermessage_subject',
				USER_MESSAGE.'.usermessage_message',
				USER_MESSAGE.'.msg_type',
				USER_MESSAGE.'.sent_date',
				USER_MESSAGE.'.status',
				USERS.'.username',
				USERS.'.email',USERS.'.photo')
			->from(USER_MESSAGE)
			->join(USERS,'left')
			->on(USER_MESSAGE.'.usermessage_to','=',USERS.'.email')
			->where(USER_MESSAGE.'.usermessage_id','=',$messageid)				
			->execute()
			->as_array();
	
		return $query;		
	}
		
        //Update read or unread status
	public function update_message_details($messageid)
	{
	$result = DB::update(USER_MESSAGE)->set(array('admin_msg_type'=>READ))->where('usermessage_id', '=', $messageid)
			->execute();
					    
			return $result;
        }
        
        //Insert to user message table 
	public function user_message_packages($select_email,$from,$subject,$message,$sent_date)
	{
			$result   = DB::insert(USER_MESSAGE,array('usermessage_to', 'usermessage_from', 'usermessage_subject','usermessage_message','sent_date'))
				->values(array($select_email,$from,$subject,$message,$sent_date))
				->execute();
				return $result;
			
	}
	public function delete_newslatter_nonuser($id="")
	{
				$rs   = DB::delete(NEWSLETTER_SUBSCRIBER)
							->where('id', '=', $id)
							->execute();
				if($rs){ return 0; };
	}
	public function delete_newslatter_all_nonuser()
	{
				$rs   = DB::delete(NEWSLETTER_SUBSCRIBER)
							->execute();
				if($rs){ return 0; };
	}
	public function edit_newslatter_all_nonuser($id='')
	{
				$rs   = DB::select('email','status')
							->where('id', '=',$id)
							->from(NEWSLETTER_SUBSCRIBER)
							->execute()
							->current();
				return $rs;
	}
	public function update_newslatter_nonuser($id,$st)
	
	{
		          	 $query = DB::update(NEWSLETTER_SUBSCRIBER)
                                ->set(array('status' => $st))
                                ->where('id', '=',$id)
                                ->execute();               
                        return 1; 
    }
    public function delete_newsletter_list($news_chk)
        {
		$query = DB::delete(NEWSLETTER_SUBSCRIBER)
				->where('id', 'IN', $news_chk)
			    	->execute();
			return 1;
	}
		public function getauctiontypes()
	{
		$res=DB::select('typename')
		->from(AUCTIONTYPE)
		->where('typename','=','buyerseller')
		->and_where('status','=',ACTIVE)
		->execute()
		->as_array();
		return $res;
	}
	
}
?>
