<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Commonfunction Controler
 *
 * Is recomended to include all the specific module's controlers
 * in the module directory for easy transport of your code.
 * @package    Commonfunction
 * @category   Base
 * @author     Myself Team
 * @copyright  (c) 2012 Myself Team
 * @license    http://kohanaphp.com/license.html
 */
class Controller_Install extends Controller {


    public function action_index()
    {
        
        // Instanciating the Module Class
        $Install = new Install;

    }
    

	public function action_installation()
	{
		//To checking table is exist
		self::check_database_exist();
	
		if (file_exists(DOCROOT.'/application/config/database.php'))
		{		       
			// Load default database configuration
			$config = Kohana::$config->load('database');
		        $prefix=$config['default']['table_prefix'];
			$host=$config['default']['connection']['hostname'];
			$user=$config['default']['connection']['username'];
			$pass=$config['default']['connection']['password'];
			$db=$config['default']['connection']['database'];
			$link = @mysql_connect($host, $user, $pass) or die('Could not connect: ' . mysql_error() . '<br> <br> Please delete the "database.php" file in project_path/application/config/ path and Try again Or check the config values in "database.php" file.  ' );
			$tables = @mysql_list_tables($db);
			$num_tables = @mysql_numrows($tables);
			if ($num_tables==0 || !isset($config)) 
			{
				$this->request->redirect('/install/process/');
			}
			
		}
		else
		{
			self::preinstall();exit;
		} 
	}
	public function preinstall()
	{
		//To checking table is exist
		self::check_database_exist();
		DEFINE("INSTALL_CSS_PATH","/modules/install/views/style.css");
		return $view= View::factory('preinstall')
                          ->render();exit;
	}
	public function action_process()
	{
		//To checking table is exist
		self::check_database_exist();
		//To display error message if query execution is failed at installtion time
		$this->session = Session::instance();
		$install_fail_curl= $this->session->get("install_failed_enable_curl");
		if(isset($install_fail_curl))
		{
			echo '<font color="red">'.$install_fail_curl.'</font><br/>';
			$this->session->delete('install_failed_enable_curl');
			exit;
		}
		if (!file_exists(DOCROOT.'/application/config/database.php') )
		{
			$this->request->redirect('/install/installation/');exit;
		}
		if($_POST)
		{
			ini_set('memory_limit','64M');
			set_time_limit(1600);
			$adminname = $_POST['name'];
			$adminpassword = $_POST['password'];
			$adminemail = $_POST['email'];
			$adminpassword_md5=md5($adminpassword);
			$sitename= $_POST['title'];
			$api_code= $_POST['apikey'];
			$current_date=date('Y-m-d H:i:s', time());
			$install_model = Model::factory('install');
		    $validator_msg= $install_model->validate_admindatas(arr::extract($_POST,array('name','password','email','title','apikey')));
		    /** Loading module configuration file data **/
		   /**If validation success without error **/
			if ($validator_msg->check() && $_POST)
			{
				$errors_msg=array();
				// Load default database configuration
				$config = Kohana::$config->load('database');
				//Setting table prefix in session to get it in process
				$prefix= $this->session->get('table_prefix');
				$this->session->delete('table_prefix');				
				$host=$config['default']['connection']['hostname'];	
				$user=$config['default']['connection']['username'];
				$pass=$config['default']['connection']['password'];
				$db=$config['default']['connection']['database'];
				/* data base connection */
				$link = mysql_connect($host, $user, $pass) or die('Could not connect: ' . mysql_error());
				/* db select */
				$select = mysql_select_db($db) or die('Query failed: ' . mysql_error());
                                $_SESSION["Enable_curl"]='';
				//Getting api key
				if(isset($_SERVER['SERVER_NAME']))
				{
				$site_url = 'http://'.$_SERVER['SERVER_NAME'];
				}else{
				$site_url = ''; }
	
				echo $url = "http://www.ndot.in/ndot/api/?key=".$api_code."&url=".$site_url."&pid=14";
			        
					if(function_exists('curl_init')) 
					{
						$XPost ="";
						$ch = curl_init();    // initialize curl handle
						curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
						curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
						curl_setopt($ch, CURLOPT_TIMEOUT, 60); // times out after 4s
						curl_setopt($ch, CURLOPT_POSTFIELDS, $XPost); // add POST fields
			
						$result = trim(curl_exec($ch)); // run the whole process
						try{
						        $xml = new SimpleXmlElement($result);
						}
						catch(Exception $error)
						{
						        $message = $error;
						}
			
						if($xml)
						{
						   $msg='';
						}else{
						   $msg = "<br />"."There is a internet connection bandwidth problem. Try by clicking the refresh key!";
						   echo $msg;
						   exit;
						}
						
							function decrypt_string($input)
							{
								  $input_count = strlen($input);
								  $dec = explode(".", $input);// splits up the string to any array
								  $x = count($dec);
								  $y = $x-1;// To get the key of the last bit in the array
								  $calc = $dec[$y]-50;
								  $randkey = chr($calc);// works out the randkey number
								  $i = 0;
								  $real='';
								   while ($i < $y)
								  {
								    $array[$i] = $dec[$i]+$randkey; // Works out the ascii characters actual numbers
								    $real .= chr($array[$i]); //The actual decryption
								    $i++;
								  };
								  $input = $real;
							    return $input;
							 }
			
							if($xml->response == "success")
							{
							
								    for($i=0;$i<=57;$i++)
								    {
								       $row1 = $xml->line[$i];
								       $row1 = decrypt_string($row1);
								       $row1 = str_replace("YOURPREFIXHERE_",$prefix,$row1);
								       mysql_query($row1);
								       if(mysql_error())
									{
									  echo mysql_error();
								          echo "<br />There was a unknow problem occured, While installing your application. Try to follow the instructions and install again!";
									  echo "<br />1. Before reinstalling DROP the existing tables in your dadabase.";
									  echo "<br />2. Delete the file database.php in /application/config folder, If it exists.";
									  echo "<br />3. Delete the file table_config.php in application/classes/table_config, If it exists.";
						  		                									  exit;
									}
								    }
								    //exit; 
							}
							else{
									echo $xml->response;
									exit;
							}

						 $result_query= $install_model->execute_query($prefix,$adminname,$adminemail,$adminpassword,$sitename);

							//If installation success
							if($result_query > 0)
							{
							        $this->session = Session::instance();
							        $this->session->set("install_success","NDOT Auction Script Premium Version 1.1 Installed Successfully");
								$this->request->redirect('/');exit;
							}
							//Installation fails
							else
							{
								$this->session->set("install_failed","Database Error!. Please Delete the existing tables and try again!.");
								$this->request->redirect('/install/install/');		
								exit;
							}
						/*Installation Ends Here*/
					}
					else{
						$this->session->set("install_failed_enable_curl","Installation failed!. Please Enable Curl and try again!.");	
						$this->request->redirect('/install/process/');exit;;
					    }
			}
			else 	
			{
			
					$error_types = array("validate.alpha_dash"=>'should not contain illegal characters',"validate.alpha_space"=>'should not contain illegal characters',"validate.not_empty"=>"must not be empty","validate.max_length"=>"must not exceed :param2 characters long","validate.valid_password"=>"may contains special characters and should not contains space");
			$errors_msg = $validator_msg->errors('errors');
				foreach($errors_msg as $key=>$value){ 
				$error_type = str_ireplace($key,"",$value);
				        if(array_key_exists(trim($error_type),$error_types)){
					        $errors_msg[$key]= ucfirst($key)." ".$error_types[trim($error_type)];
				        }
				}
			}	
		}
		return $view= View::factory('process')
				->bind('errors_msg',$errors_msg)
				->bind('validator_msg',$validator_msg)
	                          ->render();exit;

	}
	public function action_readme()
	{
		//To checking table is exist
		self::check_database_exist();
		return $view= View::factory('readme')
                          ->render();exit;	
	}
	public function action_install()
	{
		//To checking table is exist
		self::check_database_exist();

		//To display error message if query execution is failed at installtion time
		$this->session = Session::instance();	
		$install_fail= $this->session->get("install_failed");
		if(isset($install_fail))
		{
			echo '<font color="red">'.$install_fail.'</font><br/>';
			$this->session->delete('install_failed');
			exit;
		}
		//to display error message if no.of tables inserted is less than total no. of existing tables  
		$install_table_fail= $this->session->get("table_not_installed");
		if(isset($install_table_fail))
		{
			echo '<font color="red">'.$install_table_fail.'</font><br/>';
			$this->session->delete('table_not_installed');
			exit;
		}
	
		//Validation messgae array for displaying permission errors and validation errors at installation
		$validation_msg = array(
"1"=>"The given information is not correct please re-enter!",
"2"=>"The database details are not correct please re-enter!",
"3"=>"The /application/logs folder does not have write permission please set \"777\" permission!",
"4"=>"The /application/cache folder does not have write permission please set \"777\" permission!",
"5"=>"The /application/config folder does not have write permission please set \"777\" permission!",
"6"=>"The /public/uploaded_files/site_logo folder does not have write permission please set \"777\" permission!",
"7"=>"The /public/uploaded_files/products folder does not have write permission please set \"777\" permission!",
"8"=>"The /public/uploaded_files/products/thumb folder does not have write permission please set \"777\" permission!",
"9"=>"The /public/uploaded_files/products/thumb1 folder does not have write permission please set \"777\" permission!",
"10"=>"The /public/uploaded_files folder and sub-folder does not have write permission please set \"777\" permission!",
"11"=>"The /public/uploaded_files/users folder does not have write permission please set \"777\" permission!",
"12"=>"The /public/uploaded_files/users/full_50x50 folder does not have write permission please set \"777\" permission!",	
"13"=>"The /public/uploaded_files/users/thumb_10x10 folder does not have write permission please set \"777\" permission!",
"16"=>"The /application/classes folder does not have write permission please set \"777\" permission!",
"17"=>"The /public/uploaded_files/banner folder does not have write permission please set \"777\" permission!",
"18"=>"The /public/uploaded_files/testimonials folder does not have write permission please set \"777\" permission!",
"19"=>"The /public/uploaded_files/products/thumb150x150 folder does not have write permission please set \"777\" permission!",
"20"=>"The /public/uploaded_files/products/thumb150x150/thumb100X100 folder does not have write permission please set \"777\" permission!",
"21"=>"The /public/uploaded_files/products/thumb150x150/thumb370x280 folder does not have write permission please set \"777\" permission!");

		
		$error_codes = array();
		$error_code='';
		if(file_exists(DOCROOT.'application/config/database.php'))
		{
			// Load default database configuration
			if(!isset($config))
			{
			// Load default database configuration
			$config = Kohana::$config->load('database');	
			}
			$prefix=$config['default']['table_prefix'];
			$host=$config['default']['connection']['hostname'];
			$user=$config['default']['connection']['username'];
			$pass=$config['default']['connection']['password'];
			$db=$config['default']['connection']['database']; 
			$link = @mysql_connect($host, $user, $pass) or die('Could not connect: ' . mysql_error() . '<br> <br> Please delete the "database.php" file in project_path/application/config/ path and Try again Or check the config values in "database.php" file.  ' );
			$tables = @mysql_list_tables($db);
			$num_tables = @mysql_numrows($tables);
		} 
                $install_model = Model::factory('install');
		/**If validation success without error **/
		$errors_msg=array();

	//Second Request Start Here
	if(isset($_POST['step2']))
	{
		$validator_msg= $install_model->validate_dbdatas(arr::extract($_POST,array('hostname','database','username','password','prefix')));
		if (!$validator_msg->check())
		{
			$error_types = array("validate.alpha_dash"=>'should not contain illegal characters',"validate.not_empty"=>"must not be empty","validate.max_length"=>"must not exceed :param2 characters long","validate.valid_password"=>"may contains special characters and should not contains space");
			$errors_msg = $validator_msg->errors('errors');// print_r($errors_msg);exit;
				foreach($errors_msg as $key=>$value){ 
				$error_type = str_ireplace($key,"",$value);
				        if(array_key_exists(trim($error_type),$error_types)){
					        $errors_msg[$key]= ucfirst($key)." ".$error_types[trim($error_type)];
				        }
					
				}
		}
		/*Database Information*/
		$host  = trim($_POST['hostname']);
		$db  = trim($_POST['database']);
		$user   = trim($_POST['username']);
		$pass = trim($_POST['password']);
		$prefix  = trim($_POST['prefix']);
		//Avoid empty prfix
		if(strlen($prefix) > 1 ){
		        $prefix = substr($prefix,-1)=="_"?$prefix:$prefix."_";
		}	
		$this->session = Session::instance();	
		$this->session->set("table_prefix",$prefix);
		/* data base connection */
		$link = @mysql_connect($host, $user, $pass);
		if($link)
		{
			$url="";
		}
		else
		{
			$url = $_SERVER['REQUEST_URI'];
			$error_code = '1';
			array_push($error_codes,'1');
		} 
	if($error_code!='1')		
	{
		/* db select */
		$select = mysql_select_db($db);
		if($select)
		{
			$url='';
		}
		else
		{   
			$url = $_SERVER['REQUEST_URI'];
			$error_code='2';
			array_push($error_codes,'2');
	        }
	}
	//Checking 0777 permission for necessary files
	$perm = substr(sprintf('%o', @fileperms(DOCROOT.'application/logs')), -4);
	$perm1 = substr(sprintf('%o', @fileperms(DOCROOT.'application/cache')), -4);
	$perm2 = substr(sprintf('%o', @fileperms(DOCROOT.'application/config')), -4);
	$perm3 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/site_logo')), -4);
	$perm4 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/products')), -4);
	$perm5 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/products/thumb1')), -4);
	$perm6 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/products/thumb')), -4);
	$perm8 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/users')), -4);
	$perm9 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/users/full_50x50')), -4);
	$perm10 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/users/thumb_10x10')), -4);
	//$perm11 = substr(sprintf('%o', @fileperms(DOCROOT.'public/admin/images')), -4);
        //$perm12 = substr(sprintf('%o', @fileperms(DOCROOT.'public/pink/images')), -4);exit;
	$perm13 = substr(sprintf('%o', @fileperms(DOCROOT.'application/classes')), -4); 
	$perm14 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/banner')), -4);
	$perm15 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/testimonials')), -4);
	$perm16 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/products/thumb150x150')), -4);
	$perm17 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/products/thumb150x150/thumb100X100')), -4);
	$perm18 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files/products/thumb150x150/thumb370x280')), -4);
	$perm19 = substr(sprintf('%o', @fileperms(DOCROOT.'public/uploaded_files')), -4);
		//$perm11,$perm12,
	$permission_check = array($perm,$perm1,$perm2,$perm3,$perm4,$perm5,$perm6,$perm8,$perm9,$perm10,$perm13,$perm14,$perm15,$perm16,$perm17,$perm18);
	$permission_error = 0;
		
	//checking permission array if all necessary files having 0777 permission
	foreach($permission_check as $permission_check_val){
		if($permission_check_val !="0777"){
			$permission_error = 1;
			break;
		}
	}
	
	//If permission error or validation error or wrong db connect details
	if( $permission_error == 1 || $error_code == "2"|| $error_code=="1")
	{
	       if($perm!="0777"){
	           $error_code=3;
		        array_push($error_codes,'3'); }
	       if($perm1!="0777"){
 			array_push($error_codes,'4'); }
	       if($perm2!="0777"){
 			array_push($error_codes,'5'); }
	       if($perm3!="0777"){
 			array_push($error_codes,'6'); }
	       if($perm4!="0777"){
 			array_push($error_codes,'7'); }
	       if($perm5!="0777"){
 			array_push($error_codes,'9'); }
	       if($perm6!="0777"){
 			array_push($error_codes,'8'); }
 		if($perm8!="0777"){
 			array_push($error_codes,'11'); }
 		if($perm9!="0777"){
 			array_push($error_codes,'12'); }
 		if($perm10!="0777"){
 			array_push($error_codes,'13'); }
 		/*if($perm11!="0777"){
 			array_push($error_codes,'14'); }
 		if($perm12!="0777"){
 			array_push($error_codes,'15'); } */
 		if($perm13!="0777"){
 			array_push($error_codes,'16'); }
 	        if($perm14!="0777"){
 			array_push($error_codes,'17'); }
 		if($perm15!="0777"){
 			array_push($error_codes,'18'); }
 		if($perm16!="0777"){
 			array_push($error_codes,'19'); }
 		if($perm17!="0777"){
 			array_push($error_codes,'20'); }
 		if($perm18!="0777"){
 			array_push($error_codes,'21');
		 }
		if($perm19!="0777"){
 			array_push($error_codes,'10');
		 }
 		
 	}
	else
	{  
		$str=implode("",file(DOCROOT.'/application/config/database-sample.php'));
		/*Config File Writing Starts here*/
		$str=str_replace('yourhostname',$host,$str);
		$str=str_replace('yourdbname',$db,$str);
		$str=str_replace('yourmysqlusername',$user,$str);
		$str=str_replace('yourmysqlpassword',$pass,$str);
		$str=str_replace('yourtableprefix','',$str);
		//Writing database file with entered datas 
		$fp=fopen(DOCROOT.'application/config/database.php','w');
		fwrite($fp,$str,strlen($str));
		fclose($fp);
                $table=implode("",file(DOCROOT.'/application/classes/table_config_sample.php'));
		/*Config File Writing Starts here*/
		$table=str_replace('yourtableprefix',$prefix,$table);
		$table=str_replace('table1','users',$table);
		$table=str_replace('table2','bulkemail',$table);
		$table=str_replace('table3','products',$table);
		$table=str_replace('table4','watchlist',$table);
		$table=str_replace('table5','site',$table);
		$table=str_replace('table6','bidpackages',$table);
		$table=str_replace('table7','user_bonus',$table);
		$table=str_replace('table8','social_account',$table);
		$table=str_replace('table9','bonus',$table);
		$table=str_replace('table-a2','bonus_settings',$table);
		$table=str_replace('table-a3','socialnetwork_settings',$table);
		$table=str_replace('table-a4','meta',$table);
		$table=str_replace('table-a5','cms',$table);
		$table=str_replace('table-a6','product_settings',$table);
		$table=str_replace('table-a7','smtp_settings',$table);
		$table=str_replace('table-a8','users_settings',$table);
		$table=str_replace('table-a9','users_online',$table);
		$table=str_replace('table-b1','product_views',$table);
		$table=str_replace('table-b2','products_won',$table);
		$table=str_replace('table-b3','product_category',$table);
		$table=str_replace('table-b4','blog_category',$table);
		$table=str_replace('table-b5','blog',$table);
		$table=str_replace('table-b6','bid_history',$table);
		$table=str_replace('table-b7','userlogin_details',$table);
		$table=str_replace('table-b8','user_email',$table);
		$table=str_replace('table-b9','contact_request',$table);
		$table=str_replace('table-c1','contact_subject',$table);
		$table=str_replace('table-c2','email_template',$table);
		$table=str_replace('table-c3','payment_gateways',$table);
		$table=str_replace('table-c4','transaction_details',$table);
		$table=str_replace('table-c5','paypal_transaction_details',$table);
		$table=str_replace('table-c6','package_orders',$table);
		$table=str_replace('table-c7','testimonials',$table);
		$table=str_replace('table-c8','shippingaddresses',$table);
		$table=str_replace('table-c9','billingaddresses',$table);
		$table=str_replace('table-d1','banner',$table);
		$table=str_replace('table-d2','flike_users',$table);
		$table=str_replace('table-d3','social_share',$table);
		$table=str_replace('table-d4','facebook_invite_list',$table);
		$table=str_replace('table-d5','news',$table);
		$table=str_replace('table-d6','country',$table);
		$table=str_replace('table-d7','news_latter',$table);
		$table=str_replace('table-d8','usermessage',$table);
		$table=str_replace('table-d9','comments',$table);

		//Writing table config file with entered prefix 		
		$fpost=fopen(DOCROOT.'application/classes/table_config.php','w');
		fwrite($fpost,$table,strlen($table));
		fclose($fpost);
	       $this->request->redirect('/install/process/');exit;
	}
	/*Installation Step:1 Ends Here*/

	}/*First Request Process Ends here*/		
	
		return $view= View::factory('install')
				->bind('validation_msg',$validation_msg)
				->bind('error_codes',$error_codes)
				->bind('validator_msg',$validator_msg)
				->bind('errors_msg',$errors_msg)
				->bind('error_types',$error_types)
                                ->render();exit;
		
	}

	public function check_database_exist()
	{
		if (file_exists(DOCROOT.'/application/config/database.php') )
		{	
			// Load default database configuration
			$config = Kohana::$config->load('database');
			$prefix=$config['default']['table_prefix'];
			$host=$config['default']['connection']['hostname'];
			$user=$config['default']['connection']['username'];
			$pass=$config['default']['connection']['password'];
			$db=$config['default']['connection']['database'];
			$this->install_model = Model::factory('install'); 

			$total_tables=count($this->install_model->list_tables());
			if($total_tables >= 43)
			{
			        $this->session = Session::instance();
			        $this->session->set("install_success","NDOT Auction Script Premium Version 1.1 Installed Successfully");
				$this->request->redirect('/');
				
				exit;
			}
		}
	}
} // End Welcome
