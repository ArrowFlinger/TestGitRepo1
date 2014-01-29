<?php defined('SYSPATH') or die('No direct script access.');

/* Contains Admin Products(Add Product,Manage Manageproduct) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Manageproduct extends Controller_Welcome 
{
        public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		$this->socialnetworkmodel=Model::factory('socialnetwork');
		$this->module=Model::factory('module');
		$product_settings =  commonfunction::get_settings_for_products();
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		$this->selected_controller_title = $product_settings[0]['alternate_name'];

	}
	/**
        * ****action_index()****
        * @return product listings view with pagination
        */
        public function action_index()
        {
				$this->page_title = __('manage_product_index');
				$this->selected_page_title = __('manage_product_index');
                $ProductList = $this->admin_product->product_list();              
                $count_product_list = $this->admin_product->count_product_list();
                $auction_type = $this->module->select_types();
				//pagination loads here
				$page_no= isset($_GET['page'])?$_GET['page']:0;
				if($page_no==0 || $page_no=='index')
				$page_no = PAGE_NO;
				$offset = ADM_PER_PAGE*($page_no-PAGE_NO);
				$pag_data = Pagination::factory(array (
				'current_page'   => array('source' => 'query_string','key' => 'page'),
				'items_per_page' => ADM_PER_PAGE,
				'total_items'    => $count_product_list,
				'view' => 'pagination/punbb',			  
				));              
					$all_product_list = $this->admin_product->all_product_list($offset, ADM_PER_PAGE);                  
					//splitting created_date to display proper format
					$i=0;

				foreach($all_product_list as $product_list)
				{
					$all_product_list[$i]['created_date'] = $product_list["created_date"];//$this->DisplayDateTimeFormat($product_list["created_date"]);
					$all_product_list[$i]['startdate']=$product_list['startdate'];
					$all_product_list[$i]['product_image'] = $product_list["product_image"];               
					$all_product_list[$i]['product_name'] = $product_list["product_name"];               
					$all_product_list[$i]['product_url'] = $product_list["product_url"];               
					$all_product_list[$i]['category_name'] = $product_list["category_name"];               
					$all_product_list[$i]['username'] = $product_list["username"];                
					//  $all_product_list[$i]['enddate'] = $this->DisplayDateTimeFormat($product_list["enddate"]);
					//$all_product_list[$i]['product_cost'] = $product_list["product_cost"];
					$all_product_list[$i]['product_status'] = $product_list["product_status"];
					//$all_product_list[$i]['product_process'] = $product_list["product_process"];
					$all_product_list[$i]['usrid'] = $product_list["usrid"];
					$i++;
				}
			//get category list in drop down              
			$all_category_list = $this->admin_product->all_category_list();
			//get all active product Count             
			$all_active_product_list_count = $this->admin_product->all_active_product_list_count();
			//get all sold product Count             
			$all_sold_product_list_count = $this->admin_product->all_sold_product_list_count();  
			//get all unsold product Count             
			$all_unsold_product_list_count = $this->admin_product->all_unsold_product_list_count();
			//get all future product Count             
			$all_future_product_list_count = $this->admin_product->all_future_product_list_count();
			//get all username list in drop down              
			$all_username_list = $this->admin_product->all_username_list();             
			//get inactive product list count           
			$all_inactive_product_list_count = $this->admin_product->inactive_product_list_count();
			//get all deleted Product Count			
			$deleted_product_list = $this->admin_product->count_product_deleted_list();
	/********search********/
	if(isset($_POST['search_product']))
	{
		//set page title
		$this->page_title = __('menu_product_search');
		$this->selected_page_title = __('menu_product_search');
		$search_list = '';
                $offset = '';
				//For Active Product count
				$total_active_products =  $this->admin_product->select_active_product();
				//For InActive Product count
				$total_inactive_products =  $this->admin_product->select_inactive_product();  
				//For Active and Inactive Product count                 
				$total_products=$total_active_products+$total_inactive_products;                
                //Find page action in view                
                $action = $this->request->action();
                //get form submit request              
                $search_post = arr::get($_REQUEST,'search_product');   
		                   
                //Post results for search                
                if(isset($search_post))
				{                 
					$all_product_list = $this->admin_product->get_all_search_list(trim(Html::chars($_POST['keyword_search'])) ,$_POST['username_search'],$_POST['category_search'],$_POST['sort_by'],$_POST['sort_auction']);
					//splitting created_date to display proper format
					$i=0;
					foreach($all_product_list as $product_list)
					{
						$all_product_list[$i]['created_date'] = $product_list["created_date"];//$this->DisplayDateTimeFormat($product_list["created_date"]);
						$all_product_list[$i]['startdate']=$product_list['startdate'];
						$all_product_list[$i]['product_image'] = $product_list["product_image"];
						$all_product_list[$i]['product_name'] = $product_list["product_name"];
						$all_product_list[$i]['product_url'] = $product_list["product_url"];
						$all_product_list[$i]['usrid'] = $product_list["usrid"];			
						$all_product_list[$i]['category_name'] = $product_list["category_name"];
						$all_product_list[$i]['username'] = $product_list["username"];
						$all_product_list[$i]['enddate'] = $product_list["enddate"];
						$all_product_list[$i]['product_cost'] = $product_list["product_cost"];
						$all_product_list[$i]['product_status'] = $product_list["product_status"];	
						$all_product_list[$i]['auction_process'] = $product_list["auction_process"];
						$all_product_list[$i]['auction_type']=$product_list["auction_type"];		
						$i++;
					}
				}
				//get all Product Count			
                $count_product_list = $this->admin_product->count_product_list();		
                //get all deleted Product Count			
                $deleted_product_list = $this->admin_product->count_product_deleted_list();	
                //get category list in drop down	
                $all_category_list = $this->admin_product->all_category_list();		
                //get all active product Count	
                $all_active_product_list_count = $this->admin_product->all_active_product_list_count();
                //get all username list in drop down		
                $all_username_list = $this->admin_product->all_username_list();
                //get inactive product list count		
                $all_inactive_product_list_count = $this->admin_product->inactive_product_list_count();
                //get all sold product Count             
                $all_sold_product_list_count = $this->admin_product->all_sold_product_list_count();                        
                //get all unsold product Count             
                $all_unsold_product_list_count = $this->admin_product->all_unsold_product_list_count();
                //get all future product Count             
                $all_future_product_list_count = $this->admin_product->all_future_product_list_count();
				//set data to view file	
	}
        
    //----------For products dashboard------------
                
	$the_date=array();
	for ($i = 0; $i < 30; $i++)
	{
		$timestamp = time();
		$tm = 86400 * $i; // 60 * 60 * 24 = 86400 = 1 day in seconds
		$tm = $timestamp - $tm;
		$the_date[] = date("M/d", $tm);
	}

	//$last_12months_userscount =  $this->admin_product->get_last_12months_users_count();					
	//$month = time();
	for ($i = 0; $i <= 11; $i++) 
	{
		$month = strtotime("-$i months");
		$months_user[] = date("M/Y", $month);
	}  

	//get products for last 30 days
	$last_30days_products =  $this->admin_product->get_last_30days_products();	//print_r($last_30days_products);exit;
	//get products count for last 30 days
	$last_1month_products=$this->admin_product->getcount_last_1month_products();
	//get products count for last 1 year
	$last_1year_products=$this->admin_product->getcount_last_1year_products();
	//get soldproducts today
	$soldproduct_today = $this->admin_product->sold_products_details_today(''.ACTIVE.'');
	$sum_of_todayprod=$count_of_todayprod=0;
	foreach($soldproduct_today as $today_sp)
	{
		$sum_of_todayprod +=$today_sp['price'];
		$count_of_todayprod +=$today_sp['product_count'];
	}					 
	//get soldproducts for last 7 days
	$soldproduct_last7days = $this->admin_product->sold_products_details_last7days(''.ACTIVE.'');
	$sum_of_last7days=$count_of_last7days=0;
	foreach($soldproduct_last7days as $last7_sp)
	{
		$sum_of_last7days +=$last7_sp['price'];
		$count_of_last7days +=$last7_sp['product_count'];
	}

	//get soldproducts for last 1 month
	$soldproduct_last1month = $this->admin_product->sold_products_details_last1month(''.ACTIVE.'');
	$sum_of_last30days=$count_of_last30days=0;
	foreach($soldproduct_last1month as $last30_sp)
	{
		$sum_of_last30days +=$last30_sp['price'];
		$count_of_last30days +=$last30_sp['product_count'];
	}

	$soldproduct_last1year= $this->admin_product->sold_products_details_last1year(''.ACTIVE.'');
	//print_r($soldproduct_last1year);exit;
	$sum_of_last1year=$count_of_last1year=0;
	foreach($soldproduct_last1year as $last1year_sp)
	{
		$sum_of_last1year +=$last1year_sp['price'];
		$count_of_last1year +=$last1year_sp['product_count'];
	}		

	$soldproduct_last10year= $this->admin_product->sold_products_details_last10year(''.ACTIVE.'');
	$sum_of_last10year=$count_of_last10year=0;
	foreach($soldproduct_last10year as $last10year_sp)
	{
		$sum_of_last10year +=$last10year_sp['price'];
		$count_of_last10year +=$last10year_sp['product_count'];
	}					

	$soldproduct_all= $this->admin_product->sold_products_details_all(''.ACTIVE.'');
	$sum_of_allproducts=$count_of_allproducts=0;
	foreach($soldproduct_all as $all_sp)
	{
		$sum_of_allproducts +=$all_sp['price'];
		$count_of_allproducts +=$all_sp['product_count'];
	}
	//get count for today products
	$today_products=$this->admin_product->getcount_today_products();				

	$a=array();
	foreach($soldproduct_last1month as $product)
	{
		$create_date=$product['create_date'];
		$a[$create_date]=$product['product_count'];						
	}

	foreach($the_date as $dates)
	{
		if(!isset($a[$dates]))
		{
			$a[$dates]=0;
		}
	}              
					
	//$month = time();
	for ($i = 0; $i <= 11; $i++) {
		$month = strtotime("-$i months");
		$months[] = date("M/Y", $month);
	}
	//print_r($months);exit;
	$b=array();
	//					print_r($soldproduct_last1year);exit;
	foreach($soldproduct_last1year as $mon)
	{
		$create_month=$mon['create_month'];
		$b[$create_month]=$mon['product_count'];	
	}				

	foreach($months as $mo)
	{
		if(!isset($b[$mo]))
		{
			$b[$mo]=0;
		}
	}
	$year_ten = time();
	for ($i = 1; $i <= 10; $i++) 
	{
		$year_ten = strtotime('last year', $year_ten);
		$years_ten[] = date("Y", $year_ten)+1;
	}

	 
	$y=array();
	foreach($soldproduct_last10year as $yea)
	{
		$create_year=$yea['create_year'];
		$y[$create_year]=$yea['product_count'];
	}

	foreach($years_ten as $ye)
	{
		if(!isset($y[$ye]))
		{
			$y[$ye]=0;
		}
	}

	//For Active Product count
	$total_active_products =  $this->admin_product->select_active_product();
	//For InActive Product count
	$total_inactive_products =  $this->admin_product->select_inactive_product();  
	//For Active and Inactive Product count                 
	$total_products=$total_active_products+$total_inactive_products;
	//For today sold products
	$soldproduct_today = $this->admin_product->sold_products_details_today(''.ACTIVE.'');
	
	//send data to view file 
	$view = View::factory('admin/admin_product_list')		 
							->bind('title',$title)
							->bind('all_product_list',$all_product_list)               
							->bind('sales_count',$all_job_sales_count)               
							->bind('all_category',$all_category_list)              
							->bind('auction_type',$auction_type)              
							->bind('all_username',$all_username_list)                
							->bind('count_product_list',$count_product_list)
							->bind('deleted_product_list',$deleted_product_list)
							->bind('all_active_product_list_count',$all_active_product_list_count)
							->bind('all_sold_product_list_count',$all_sold_product_list_count)                     
							->bind('all_unsold_product_list_count',$all_unsold_product_list_count) 
							->bind('all_future_product_list_count',$all_future_product_list_count)   
							->bind('all_inactive_product_list_count',$all_inactive_product_list_count)		
							->bind('pag_data',$pag_data)              
							->bind('srch',$_POST)
							->bind('ProductList',$ProductList)               
							->bind('offset',$offset)  											
							->bind('total_active_products',$total_active_products)
							->bind('total_inactive_products',$total_inactive_products)
							->bind('total_live_products',$total_live_products)
							->bind('last_30days_transaction',$last_30days_transaction)	
							->bind('today_products',$today_products)
							->bind('last_7days_products',$last_7days_products) 
							->bind('last_1month_products',$last_1month_products)
							->bind('last_1year_products',$last_1year_products)
							->bind('total_products',$total_products)
							->bind('soldproduct_today',$soldproduct_today)
							->bind('soldproduct_last7days',$soldproduct_last7days)
							->bind('soldproduct_last1month',$soldproduct_last1month)
							->bind('soldproduct_last1year',$soldproduct_last1year)
							->bind('soldproduct_last10year',$soldproduct_last10year)
							->bind('total_soldproducts',$total_soldproducts)
							->bind('soldproduct_all',$soldproduct_all)
							->bind('last_10_years',$years)
							->bind('last_10_years_products',$years_ten)
							->bind('last_10_years_values',$y)											
							->bind('last_30_days',$the_date)
							->bind('last_30_days_values',$a)											
							->bind('last_12_months',$months)										
							->bind('last_12_months_values',$b)
							->bind('total_active_products_details',$total_active_products)
							->bind('total_products_details',$total_products)
							->bind('total_inactive_products_details',$total_inactive_products)
							->bind('sum_of_todayprod',$sum_of_todayprod)
							->bind('count_of_todayprod',$count_of_todayprod)
							->bind('sum_of_last7days',$sum_of_last7days)
							->bind('count_of_last7days',$count_of_last7days)
							->bind('sum_of_last30days',$sum_of_last30days)
							->bind('count_of_last30days',$count_of_last30days)
							->bind('sum_of_last1year',$sum_of_last1year)
							->bind('count_of_last1year',$count_of_last1year)
							->bind('sum_of_last10year',$sum_of_last10year)
							->bind('count_of_last10year',$count_of_last10year)
							->bind('sum_of_allproducts',$sum_of_allproducts)
							->bind('count_of_allproducts',$count_of_allproducts)
							/*********For search*************/
							->bind('title',$title)
							->bind('offset',$offset)
							->bind('action',$action)				
							->bind('all_active_product_list_count',$all_active_product_list_count)
							->bind('all_inactive_product_list_count',$all_inactive_product_list_count)
							->bind('all_sold_product_list_count',$all_sold_product_list_count)    
							->bind('deleted_product_list',$deleted_product_list)                 
							->bind('all_unsold_product_list_count',$all_unsold_product_list_count) 
							->bind('all_future_product_list_count',$all_future_product_list_count)   
							->bind('all_category',$all_category_list)
							->bind('count_product_list',$count_product_list)
							->bind('srch',$_POST)
							->bind('all_username',$all_username_list)
							->bind('total_products_details',$total_products)
							//->bind('auction_types',$auction_type)
							->bind('all_product_list',$all_product_list)
							->bind('title',$title);										

	 $this->template->content = $view;
	}              
                                
                       //send data to view file 
                              
             

	/** CURL GET AND POST**/
	public function curl_function($req_url = "" , $type = "", $arguments =  array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $req_url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		if($type == "POST"){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arguments);
		}
		
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
	
	/** POST STATUS UPDATE **/
	public function facebook_status_update($Status_Message = "",$image)
	{
		//get the facebook userid and token id
		$get_facebook_info = $this->socialnetworkmodel->select_fb_account();
		$count_facebook_info = $this->socialnetworkmodel->select_fb_account(1,TRUE);
		$fb_user_id = '';
		$fb_access_token = '';
		if($count_facebook_info > 0)
		{
				$fb_user_id = $get_facebook_info[0]["account_user_id"];
				$fb_access_token = $get_facebook_info[0]["access_token"];
		}
		$Status_Message =  __('new_facebook_auction_posted').$Status_Message;
		
		if($fb_access_token && $fb_user_id)
		{
			$Post_url = "https://graph.facebook.com/feed";	
			$post_arg = array("access_token" => $fb_access_token, "message" => $Status_Message,"id" => $fb_user_id,"method" => "post" );
			$status = $this->curl_function($Post_url, "POST", $post_arg);
			return $status;
		}
		return;
	}
	
	//Date function
     
	
        /**
        * ****action_add()****
        * @return product listings array 
        */        
	public function action_add()
	{
		$productid = $this->request->param('product_id'); 
		$this->page_title = __('menu_product_add');                
		$this->selected_page_title = __('menu_product_add');               
		//check current action
		$errors=array();
		$action = $this->request->action();               
		$admin_id = $this->session->get('userid');                
		$admin_name = $this->session->get("username");  
		$auction_type = $this->module->select_types();              
		//getting request for form submit
		$product_add =arr::get($_REQUEST,'admin_product_add');              
		//validation starts here
                if(isset($product_add))
                {
					
			$files=Arr::extract($_FILES,array('product_image'));

			$multiple_files=Arr::extract($_FILES,array('product_gallery'));
			$post=Arr::extract($_POST, array('product_name','product_info','product_cost','tags','product_category','auction_type','shipping_fee'));
			  
			$values=Arr::merge($files,$post);			
			$imagefile=1;                  
			$validator = $this->admin_product->add_product_form($values,$this->product_settings,$imagefile);
			$filters=$this->admin_product->filter_images($multiple_files);
                          //validation check
                        if ($validator->check() && $this->admin_product->image_validate($filters) && $this->admin_product->image_sizevalidate($filters,"2MiB")) 
                        {

                                //arrays of images to resize with size and their path
				$settings=array(array("size"=>array("height"=>100,"width"=>100),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb100X100/"),array("size"=>array("height"=>64,"width"=>73),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb73x64/"),array("size"=>array("height"=>284,"width"=>370),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb370x280/"),array("size"=>array("height"=>54,"width"=>81),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb81x54/"),array("size"=>array("height"=>239,"width"=>336),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb254x239/"));
				
				$imgnames=$this->multiupload($multiple_files,DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."/",'product_gallery',$settings);
				//$imgnames=$this->multiupload($multiple_files,DOCROOT.PRODUCTS_IMGPATH_THUMB81x54."/",'product_gallery',$settings);
				$multiimgnames=implode(",",$imgnames);
				$image_name="";
                                if(isset($files['product_image']) )
                                {
								
					$filename = Upload::save($files['product_image'],NULL,DOCROOT.PRODUCTS_IMGPATH, 0777);	
					$image_name = explode("/",$filename);//To split string
					$image_name= end($image_name);//To get image name from array
					//To check Uploaded Image name is not null and product image is exist in db  //
					$image = Image::factory($filename);
					$image2 = Image::factory($filename);
					$image3 = Image::factory($filename);
					$image4 = Image::factory($filename);
					$image5 = Image::factory($filename);
					$image6 = Image::factory($filename);
					$image7 = Image::factory($filename);
					
					$path=DOCROOT.PRODUCTS_IMGPATH_THUMB1;
					$this->imageresize($image,50,50,$path,$image_name,90);
					
					$path2=DOCROOT.PRODUCTS_IMGPATH_THUMB;
					$this->imageresize($image2,148,100,$path2,$image_name,90);				
					
					$path3=DOCROOT.PRODUCTS_IMGPATH_THUMB2;
					$this->imageresize($image3,370,284,$path3,$image_name,90);
					
					$path4=DOCROOT.PRODUCTS_IMGPATH_THUMB3;
					$this->imageresize($image4,200,200,$path4,$image_name,90);
					
					$path5=DOCROOT.PRODUCTS_IMGPATH_THUMB4;
					$this->imageresize($image5,81,54,$path5,$image_name,90);
					
					$path6=DOCROOT.PRODUCTS_IMGPATH_THUMB5;
					$this->imageresize($image6,336,239,$path6,$image_name,90);
					
					$path7=DOCROOT.PRODUCTS_IMGPATH_THUMB6;
					$this->imageresize($image7,73,64,$path7,$image_name,90);
                                }	
				/**To form URL from product name**/
				$product_url=url::title($_POST['product_name']);
				/**To check url already exists or not,if exists return 1**/
				$url_exist = $this->admin_product->unique_producturl($product_url);
				/**To generate random key**/
				$random_key = text::random($type = 'alnum', $length = 5);			
				$producturl=($url_exist>0)?$product_url.$random_key:$product_url;
				/*Products add process starts here**/                      
				$status = $this->admin_product->add_product($validator,$_POST,$image_name,$multiimgnames,$producturl);
					if($status){
						if(isset($post['auction_type']))
						{
							$auction_type_name  = $this->module->select_types($post['auction_type']);
							//Flash message for sucess product add
							Message::success(__('product_add_success'));
							$this->request->redirect("admin/".$auction_type_name['typename']."/add?pid=".$status[0]);
							
						}
						else
						{
							//Flash message for sucess product add
							Message::success(__('product_add_success_not_included_in_auction'));
							//Facebook wall post	
							$this->facebook_status_update(URL_BASE."auctions/view/".$product_url,$image_name);
							/*Products Listings Page Redirection*/      
							$this->request->redirect("manageproduct/index");
						}                                	
					}
                        }
                        else
                        {
                        //validation error msg hits here
                        $errors = $validator->errors('errors');
				if(isset($_FILES['product_gallery']))
				{
					//Error to display in form itself. Merge this array into your error array to get validation on single array and bind that to viewfactory
					$mulimg['product_gallery']=$this->session->get("mulimg"); 
					//$errors=array_merge($errors,$mulimg);
					$errors=$errors+$mulimg;				
				}
			
                       }
		}		
                $all_category_list = $this->admin_product->all_category_list();              
                $all_username_list = $this->admin_product->all_available_active_admin_list();                
                $view = View::factory('admin/manage_product')
                        ->bind('title',$title)
                        ->bind('srch',$_POST)
                        ->bind('validator', $validator)
                        ->bind('messages', $messages)
                        ->bind('auction_type', $auction_type)
                        ->bind('errors',$errors)
                        ->bind('admin_id',$admin_id)
                        ->bind('admin_name',$admin_name)
                        ->bind('all_username',$all_username_list)
                        ->bind('all_category',$all_category_list)
                        ->bind('product_data',$product_data[0])
                        ->bind('action',$action)                       
                        ->bind('chk_action',$chk_action)
                        ->bind('get_act_type',$get_act_type);
                $this->template->content = $view;
	}

        /**
        * ****Image resize ****
        * @return Image listings 
        */        
        public function imageresize($image_factory,$width,$height,$path,$image_name,$quality=90)
        {
		//$height="null";
                if ($image_factory->height < $height || $image_factory->width < $width )
                {
                      $image = $image_factory->save($path.$image_name,90);
                      return  $image; 
                }
                else
                {
                        $image_factory->resize($width, $height, Image::NONE);
                        $image_factory->crop($width, $height);                    
                        $image= $image_factory->save($path.$image_name,90);
                 return  $image;
                }
        }
        
        /*
        *Edit Product
        */
	public function action_edit()
	{
  		//set page title
		$this->page_title = __('menu_product_edit');
		$this->selected_page_title = __('menu_product_edit');
		//get current page product segment id 
		$productid = $this->request->param('id');
		//sending admin session id to view file ans settings default user  as "admin" drop down	
		$admin_id = $this->session->get('user_id');
		$admin_name = $this->session->get("username");		
		//check current action
		$action = $this->request->action();
		$chk_action=$this->request->action();
		$auction_type = $this->module->select_types();              
		$action .= "/".$productid;
		$IMG_EXIST = $this->admin_product->check_productimage($productid); 		
		//getting request for form submit
		$MORE_EXIST = $this->admin_product->check_more_productimage($productid);
		$product_edit =arr::get($_REQUEST,'admin_product_edit');		
		$errors = array();
		$prducts_deteils= $this->admin_product->get_all_product_details_list($productid);
		$select_prducts_deteils= $this->admin_product->get_select_product_details_list($productid);
		if(isset($select_prducts_deteils[0]['lastbidder_userid']))
		{
		$lastbidder_product=$select_prducts_deteils[0]['lastbidder_userid'];
		}
		else
		{
		$lastbidder_product=0;
		}
		//validation starts here	
		if(isset($product_edit))
		{

		            
                if($prducts_deteils[0]['product_status']==DELETED_STATUS)
                {
                        Message::error(__('product_allready_deleted_so_no_change_update'));
                        $this->request->redirect("manageproduct/index");
                }
                else
                {
		        
                        $multiple_files=Arr::extract($_FILES,array('product_gallery'));
                        $files=Arr::extract($_FILES,array('product_image'));
                        $post=Arr::extract($_POST,array('product_name','product_info','product_category','startdate','enddate','product_cost','current_price','max_countdown','bidding_countdown','bidamount','tags','shipping_fee'));
                       
                        $values=Arr::merge($files,$post); 
                        //send validation fields into model for checking rules			
                        $validator = $this->admin_product->edit_product_form($values,$this->product_settings,$_FILES);	 
                      $filters=$this->admin_product->filter_images($multiple_files);
						 
			if ($validator->check() && $this->admin_product->image_validate($filters) && $this->admin_product->image_sizevalidate($filters,"2MiB")) 
			{  
                        //Multiple Image Upload Start
                  $settings=array(array("size"=>array("height"=>100,"width"=>100),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb100X100/"),array("size"=>array("height"=>64,"width"=>73),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb73x64/"),array("size"=>array("height"=>284,"width"=>370),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb370x280/"),array("size"=>array("height"=>54,"width"=>81),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb81x54/"),array("size"=>array("height"=>254,"width"=>239),"path"=>DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."thumb254x239/"));
                        
                        $imgnames=$this->multiupload($multiple_files,DOCROOT.PRODUCTS_IMGPATH_THUMB150x150."/",'product_gallery',$settings);
				//print_r($settings);exit;  

                                $multiimgnames=implode(",",$imgnames);
				if($MORE_EXIST != '' && $_FILES!= '')
	                        {
                                        $deleteimage=explode(",",$MORE_EXIST);
                                        $multiimgnames=array_merge($imgnames,$deleteimage);
                                        $multiimgnames=implode(",",$multiimgnames);
                                }
					//after image validation it will be stored in root folder//
			        $image_name = "";
			        if(isset($files['product_image']['name']))
			        {
			                if($files['product_image']['name'] !="")
			                {
			                        $image_type=explode('.',$files['product_image']['name']);
				                $image_type=end($image_type);
			                        $image_name = uniqid().'.'.$image_type;
				                $filename =Upload::save($files['product_image'],$image_name,DOCROOT.PRODUCTS_IMGPATH, 0777);							
				                //To check Uploaded Image name is not null and product image is exist in db  //
			                        $image = Image::factory($filename);
			                        $image2 = Image::factory($filename);
			                        $image3 = Image::factory($filename);
			                        $image4 = Image::factory($filename);
			                        $image5 = Image::factory($filename);
			                        $image6 = Image::factory($filename);
			                        $image7 = Image::factory($filename);
			                                                          			                        
			                        $path2=DOCROOT.PRODUCTS_IMGPATH_THUMB;
			                        $this->imageresize($image2,148,100,$path2,$image_name,90);	
			                        
									$path=DOCROOT.PRODUCTS_IMGPATH_THUMB1;
			                        $this->imageresize($image,50,50,$path,$image_name,90);
			                        
			                        $path3=DOCROOT.PRODUCTS_IMGPATH_THUMB2;
									$this->imageresize($image3,370,284,$path3,$image_name,90);
									
									$path4=DOCROOT.PRODUCTS_IMGPATH_THUMB3;
									$this->imageresize($image4,200,200,$path4,$image_name,90);
									
									$path5=DOCROOT.PRODUCTS_IMGPATH_THUMB4;
									$this->imageresize($image5,81,54,$path5,$image_name,90);
									
									$path6=DOCROOT.PRODUCTS_IMGPATH_THUMB5;
									$this->imageresize($image6,254,239,$path6,$image_name,90);
									
									$path7=DOCROOT.PRODUCTS_IMGPATH_THUMB6;
									$this->imageresize($image7,73,64,$path7,$image_name,90);
					    	}
                     }
			                        if($IMG_EXIST != '' && $image_name!= '')
			                        {
	                                               /**If image exists unlink the image from that location**/
                                                        if(file_exists(DOCROOT.PRODUCTS_IMGPATH.$IMG_EXIST))
                                                        {
                                                         	unlink(DOCROOT.PRODUCTS_IMGPATH.$IMG_EXIST);
                                                        }
                                                        if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$IMG_EXIST))
                                                        {
                                                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB.$IMG_EXIST);
                                                        }
                                                        if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$IMG_EXIST))
                                                        {
                                                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$IMG_EXIST);
                                                        }
		                                }
		                //product edit process starts here              
				$status = $this->admin_product->edit_product($productid,$_POST,$image_name,$multiimgnames);		
				if($status == SUCESS)
				{
	                     	        //Flash message 
	                   	 	Message::success(__('product_update_flash'));
                        	        //page redirection after success
                			$this->request->redirect("manageproduct/index");
                                }				
				$validator = null;
			}
			else
			{
				//validation failed, get errors
				$errors = $validator->errors('errors'); 
				if(isset($_FILES['product_gallery']))
				{
				//Error to display in form itself. Merge this array into your error array to get validation on single array and bind that to viewfactory
					$mulimg['product_gallery']=$this->session->get("mulimg");				
					$errors=$errors+$mulimg;
				}
			}
		    }
	        }
		//get category list in drop down		
		$all_category_list = $this->admin_product->all_category_list();		
		//get all active username list in drop down		
		$all_username_list = $this->admin_product->all_available_active_admin_list();
            	//send data to view file 
            	//Get Value
            	$product_data = $this->admin_product->get_all_product_details_list($productid);
            	$get_act_type = $this->admin_product->getauction_edit($productid);
				 
		$view = View::factory('admin/manage_product')
					 ->bind('current_uri',$userid)
					 ->bind('srch',$_POST)
					 ->bind('lastbidder',$lastbidder_product)
					 ->bind('upload_errors',$upload_errors)
					 ->bind('all_username',$all_username_list)
					 ->bind('all_category',$all_category_list)
					 ->bind('auction_type', $auction_type)
					 ->bind('admin_id',$admin_id)
					 ->bind('admin_name',$admin_name)
				 	 ->bind('product_data',$product_data[0])				 
					 ->bind('errors',$errors)
					 ->bind('validator',$validator)
		             ->bind('action',$action)		             
		             ->bind('chk_action',$chk_action)
		             ->bind('get_act_type',$get_act_type);
		             
		$this->template->content = $view;
	}

        /**
        * ****action_delete()****
        * delete Products listings items
        */ 
	public function action_delete()
	{
	              
	
		//get current page segment id 
		$productid = $this->request->param('id');	
		$product_data = $this->admin_product->get_all_product_details_list($productid);
		if($product_data[0]['product_status'] == 'D')
                {
                        Message::success(__('already_delete_product'));
                }
                else
                {	
		        //perform delete action 
	                $status = $this->admin_product->delete_product($productid);		
		        //Flash message for Delete		
		        Message::success(__('adminproduct_delete_flash'));
		}		
		//redirects to index page after deletion
		$this->request->redirect("manageproduct/index");
	}

        /**
        * ****action_delete()****


        * delete Products productimage items
        */
	public function action_delete_productimage()
	{
                //auth login check
                $this->is_login(); 
                //get current page segment id 
                $productid = $this->request->param('id');
                $product_image_delete= $this->admin_product->check_productimage($productid); 
                              if(file_exists(DOCROOT.PRODUCTS_IMGPATH.$product_image_delete) && $product_image_delete != '')
                               {				
                                unlink(DOCROOT.PRODUCTS_IMGPATH.$product_image_delete);
                               }
                              if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_image_delete) && $product_image_delete != '')
                               {				
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_image_delete);
                               }
                              if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$product_image_delete) && $product_image_delete != '')
                               {				
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$product_image_delete);
                               }	
                               if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB2.$product_image_delete) && $product_image_delete != '')
                               {				
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB2.$product_image_delete);
                               }
                               if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB3.$product_image_delete) && $product_image_delete != '')
                               {				
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB3.$product_image_delete);
                               }
                               if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB4.$product_image_delete) && $product_image_delete != '')
                               {				
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB4.$product_image_delete);
                               }
                               if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB5.$product_image_delete) && $product_image_delete != '')
                               {				
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB5.$product_image_delete);
                               }
                               if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB6.$product_image_delete) && $product_image_delete != '')
                               {				
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB6.$product_image_delete);
                               }
                $status = $this->admin_product->update_product_image($productid);
                //send data to view file 
                $product_data = $this->admin_product->get_product_data($productid);
                //Flash message 
                Message::success(__('delete_productimage_flash'));	
                $this->request->redirect("manageproduct/edit/".$productid);
	}
	
        /**
        * ****action_delete()****
        * delete  Products more productimage items
        */
	public function action_delete_more_productimage()
	{
                //auth login check
                $this->is_login(); 
                //get current page segment id 
                $product_id = arr::get($_REQUEST,'priductid');
		$image_id = arr::get($_REQUEST,'imageid');
		$product_more_image_delete= $this->admin_product->check_more_productimage($product_id); 
		$test=explode(",",$product_more_image_delete);
                $productname=$test[$image_id];
                unset($test[$image_id]);
                $multiimgnames=implode(",",$test);
                if(is_array($productname))
                { 
                        foreach ($test as $delete)
                        {
                                if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.$delete) && $delete != '')
                                {     	 	
                                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.$delete);
                                }
                                if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb100X100/'.$delete) && $delete != '')
                                {     	 	
                                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb100X100/'.$delete);
                                }
                                if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb370x280/'.$delete) && $delete != '')
                                {     	 	
                                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb370x280/'.$delete);
                                }
                                if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb73x64/'.$delete) && $delete != '')
                                {     	 	
                                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb73x64/'.$delete);
                                }
                                if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb81x54/'.$delete) && $delete != '')
                                {     	 	
                                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb81x54/'.$delete);
                                }
                                if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb254x239/'.$delete) && $delete != '')
                                {     	 	
                                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb254x239/'.$delete);
                                }
                        }
                        
                        $status = $this->admin_product->update_product_more_image($product_id);
                }
                else 
                {
                        if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.$productname) && $productname != '')
                        {     	 	
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.$productname);
                        }
                        if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb100X100/'.$productname) && $productname != '')
                        {     	 	
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb100X100/'.$productname);
                        }
                        if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb370x280/'.$productname) && $productname != '')
                        {     	 	
                                unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb370x280/'.$productname);
                        }
                        
                        $status = $this->admin_product->update_product_more_images($product_id, $multiimgnames);
                }
                //send data to view file 
                $product_data = $this->admin_product->get_product_more_data($product_id);
                //Flash message 
                Message::success(__('delete_productimage_flash'));	
                $this->request->redirect("manageproduct/edit/".$product_id);
	}
	
        /**
        * ****action_delete()****
        * delete  Products more productimage items
        */
	public function action_delete_more_totle_productimage()
	{
                //auth login check
                $this->is_login(); 
                //get current page segment id 
                $productid = $this->request->param('id');
                $product_more_image_delete= $this->admin_product->check_more_productimage($productid); 
                $test=explode(",",$product_more_image_delete);
                foreach ($test as $delete)
                {
                       if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.$delete) && $delete != '')
                        {     	 	
                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.$delete);
                        }
                        if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb100X100/'.$delete) && $delete != '')
                        {     	 	
                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb100X100/'.$delete);
                        }
                          if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb370x280/'.$delete) && $delete != '')
                        {     	 	
                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb370x280/'.$delete);
                        }
                         if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb73x64/'.$delete) && $delete != '')
                        {     	 	
                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb73x64/'.$delete);
                        }
                         if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb81x54/'.$delete) && $delete != '')
                        {     	 	
                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb81x54/'.$delete);
                        }
                         if(file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb254x239/'.$delete) && $delete != '')
                        {     	 	
                        unlink(DOCROOT.PRODUCTS_IMGPATH_THUMB150x150.'thumb254x239/'.$delete);
                        }
                }
                $status = $this->admin_product->update_product_more_image($productid);
                //send data to view file 
                $product_data = $this->admin_product->get_product_more_data($productid);
                //Flash message 
                Message::success(__('delete_product_more_image_flash'));	
                $this->request->redirect("manageproduct/edit/".$productid);
	}
	
	
        /**
        * ****action_search()****
        * @param 
        * @return search products listings
        */	
	/*public function action_search()
	{
		
	//set page title
	$this->page_title = __('menu_product_search');
	$this->selected_page_title = __('menu_product_search');
	//default empty list and offset

	//For 'graph' starts
	$the_date=array();
	for ($i = 0; $i < 30; $i++)
	{
		$timestamp = time();
		$tm = 86400 * $i; // 60 * 60 * 24 = 86400 = 1 day in seconds
		$tm = $timestamp - $tm;
		$the_date[] = date("M/d", $tm);
	}

	//$last_12months_userscount =  $this->admin_product->get_last_12months_users_count();					
	//$month = time();
	for ($i = 0; $i <= 11; $i++) 
	{
		$month = strtotime("-$i months");
		$months_user[] = date("M/Y", $month);
	}  

	//get products for last 30 days
	$last_30days_products =  $this->admin_product->get_last_30days_products();	//print_r($last_30days_products);exit;
	//get products count for last 30 days
	$last_1month_products=$this->admin_product->getcount_last_1month_products();
	//get products count for last 1 year
	$last_1year_products=$this->admin_product->getcount_last_1year_products();
	//get soldproducts today
	$soldproduct_today = $this->admin_product->sold_products_details_today(''.ACTIVE.'');
	$sum_of_todayprod=$count__of_todayprod=0;
	foreach($soldproduct_today as $today_sp)
	{
		$sum_of_todayprod +=$today_sp['price'];
		$count_of_todayprod +=$today_sp['product_count'];
	}					 
	//get soldproducts for last 7 days
	$soldproduct_last7days = $this->admin_product->sold_products_details_last7days(''.ACTIVE.'');
	$sum_of_last7days=$count_of_last7days=0;
	foreach($soldproduct_last7days as $last7_sp)
	{
		$sum_of_last7days +=$last7_sp['price'];
		$count_of_last7days +=$last7_sp['product_count'];
	}

	//get soldproducts for last 1 month
	$soldproduct_last1month = $this->admin_product->sold_products_details_last1month(''.ACTIVE.'');
	$sum_of_last30days=$count_of_last30days=0;
	foreach($soldproduct_last1month as $last30_sp)
	{
		$sum_of_last30days +=$last30_sp['price'];
		$count_of_last30days +=$last30_sp['product_count'];
	}

	$soldproduct_last1year= $this->admin_product->sold_products_details_last1year(''.ACTIVE.'');
	//print_r($soldproduct_last1year);exit;
	$sum_of_last1year=$count_of_last1year=0;
	foreach($soldproduct_last1year as $last1year_sp)
	{
		$sum_of_last1year +=$last1year_sp['price'];
		$count_of_last1year +=$last1year_sp['product_count'];
	}		

	$soldproduct_last10year= $this->admin_product->sold_products_details_last10year(''.ACTIVE.'');
	$sum_of_last10year=$count_of_last10year=0;
	foreach($soldproduct_last10year as $last10year_sp)
	{
		$sum_of_last10year +=$last10year_sp['price'];
		$count_of_last10year +=$last10year_sp['product_count'];
	}					

	$soldproduct_all= $this->admin_product->sold_products_details_all(''.ACTIVE.'');
	$sum_of_allproducts=$count_of_allproducts=0;
	foreach($soldproduct_all as $all_sp)
	{
		$sum_of_allproducts +=$all_sp['price'];
		$count_of_allproducts +=$all_sp['product_count'];
	}
	//get count for today products
	$today_products=$this->admin_product->getcount_today_products();				

	$a=array();
	foreach($soldproduct_last1month as $product)
	{
		$create_date=$product['create_date'];
		$a[$create_date]=$product['product_count'];						
	}

	foreach($the_date as $dates)
	{
		if(!isset($a[$dates]))
		{
			$a[$dates]=0;
		}
	}              
					
	//$month = time();
	for ($i = 0; $i <= 11; $i++) {
		$month = strtotime("-$i months");
		$months[] = date("M/Y", $month);
	}
	//print_r($months);exit;
	$b=array();
	//					print_r($soldproduct_last1year);exit;
	foreach($soldproduct_last1year as $mon)
	{
		$create_month=$mon['create_month'];
		$b[$create_month]=$mon['product_count'];	
	}				

	foreach($months as $mo)
	{
		if(!isset($b[$mo]))
		{
			$b[$mo]=0;
		}
	}
	$year_ten = time();
	for ($i = 1; $i <= 10; $i++) 
	{
		$year_ten = strtotime('last year', $year_ten);
		$years_ten[] = date("Y", $year_ten)+1;
	}

	 
	$y=array();
	foreach($soldproduct_last10year as $yea)
	{
		$create_year=$yea['create_year'];
		$y[$create_year]=$yea['product_count'];
	}

	foreach($years_ten as $ye)
	{
		if(!isset($y[$ye]))
		{
			$y[$ye]=0;
		}
	}

	//For 'graph' Ends

                          
                $search_list = '';
                $offset = '';
				//For Active Product count
				$total_active_products =  $this->admin_product->select_active_product();
				//For InActive Product count
				$total_inactive_products =  $this->admin_product->select_inactive_product();  
				//For Active and Inactive Product count                 
				$total_products=$total_active_products+$total_inactive_products;                
                //Find page action in view                
                $action = $this->request->action();
                //get form submit request              
                $search_post = arr::get($_REQUEST,'search_product');   
		                   
                //Post results for search                
                if(isset($search_post))
				{                 
					$all_product_list = $this->admin_product->get_all_search_list(trim(Html::chars($_POST['keyword_search'])) ,$_POST['username_search'],$_POST['category_search'],$_POST['sort_by'],$_POST['sort_auction']);
					//splitting created_date to display proper format
					$i=0;
					foreach($all_product_list as $product_list)
					{
						$all_product_list[$i]['created_date'] = $product_list["created_date"];//$this->DisplayDateTimeFormat($product_list["created_date"]);
						$all_product_list[$i]['startdate']=$product_list['startdate'];
						$all_product_list[$i]['product_image'] = $product_list["product_image"];
						$all_product_list[$i]['product_name'] = $product_list["product_name"];
						$all_product_list[$i]['product_url'] = $product_list["product_url"];
						$all_product_list[$i]['usrid'] = $product_list["usrid"];			
						$all_product_list[$i]['category_name'] = $product_list["category_name"];
						$all_product_list[$i]['username'] = $product_list["username"];
						$all_product_list[$i]['enddate'] = $product_list["enddate"];
						$all_product_list[$i]['product_cost'] = $product_list["product_cost"];
						$all_product_list[$i]['product_status'] = $product_list["product_status"];	
						$all_product_list[$i]['auction_process'] = $product_list["auction_process"];
						$all_product_list[$i]['auction_type']=$product_list["auction_type"];		
						$i++;
					}
				}
				//get all Product Count			
                $count_product_list = $this->admin_product->count_product_list();		
                //get all deleted Product Count			
                $deleted_product_list = $this->admin_product->count_product_deleted_list();	
                //get category list in drop down	
                $all_category_list = $this->admin_product->all_category_list();		
                //get all active product Count	
                $all_active_product_list_count = $this->admin_product->all_active_product_list_count();
                //get all username list in drop down		
                $all_username_list = $this->admin_product->all_username_list();
                //get inactive product list count		
                $all_inactive_product_list_count = $this->admin_product->inactive_product_list_count();
                //get all sold product Count             
                $all_sold_product_list_count = $this->admin_product->all_sold_product_list_count();                        
                //get all unsold product Count             
                $all_unsold_product_list_count = $this->admin_product->all_unsold_product_list_count();
                //get all future product Count             
                $all_future_product_list_count = $this->admin_product->all_future_product_list_count();
				//set data to view file	
    	        $view = View::factory('admin/admin_product_list')
                                ->bind('title',$title)
                                ->bind('offset',$offset)
                                ->bind('action',$action)				
                                ->bind('all_active_product_list_count',$all_active_product_list_count)
                                ->bind('all_inactive_product_list_count',$all_inactive_product_list_count)
                                ->bind('all_sold_product_list_count',$all_sold_product_list_count)    
                                ->bind('deleted_product_list',$deleted_product_list)                 
                                ->bind('all_unsold_product_list_count',$all_unsold_product_list_count) 
                                ->bind('all_future_product_list_count',$all_future_product_list_count)   
                                ->bind('all_category',$all_category_list)
                                ->bind('count_product_list',$count_product_list)
                                ->bind('srch',$_POST)
                                ->bind('all_username',$all_username_list)
                                ->bind('total_products_details',$total_products)
								//->bind('auction_types',$auction_type)
                                ->bind('all_product_list',$all_product_list)
                                ->bind('title',$title)
                            //For graph   
							->bind('all_product_list',$all_product_list)               
							->bind('sales_count',$all_job_sales_count)               
							->bind('all_category',$all_category_list)              
							->bind('auction_type',$auction_type)              
							->bind('all_username',$all_username_list)                
							->bind('count_product_list',$count_product_list)
							->bind('deleted_product_list',$deleted_product_list)
							->bind('all_active_product_list_count',$all_active_product_list_count)
							->bind('all_sold_product_list_count',$all_sold_product_list_count)                     
							->bind('all_unsold_product_list_count',$all_unsold_product_list_count) 
							->bind('all_future_product_list_count',$all_future_product_list_count)   
							->bind('all_inactive_product_list_count',$all_inactive_product_list_count)		
							->bind('pag_data',$pag_data)              
							->bind('srch',$_POST)
							->bind('ProductList',$ProductList)               
							->bind('offset',$offset)  											
							->bind('total_active_products',$total_active_products)
							->bind('total_inactive_products',$total_inactive_products)
							->bind('total_live_products',$total_live_products)
							->bind('last_30days_transaction',$last_30days_transaction)	
							->bind('today_products',$today_products)
							->bind('last_7days_products',$last_7days_products) 
							->bind('last_1month_products',$last_1month_products)
							->bind('last_1year_products',$last_1year_products)
							->bind('total_products',$total_products)
							->bind('soldproduct_today',$soldproduct_today)
							->bind('soldproduct_last7days',$soldproduct_last7days)
							->bind('soldproduct_last1month',$soldproduct_last1month)
							->bind('soldproduct_last1year',$soldproduct_last1year)
							->bind('soldproduct_last10year',$soldproduct_last10year)
							->bind('total_soldproducts',$total_soldproducts)
							->bind('soldproduct_all',$soldproduct_all)
							->bind('last_10_years',$years)
							->bind('last_10_years_products',$years_ten)
							->bind('last_10_years_values',$y)											
							->bind('last_30_days',$the_date)
							->bind('last_30_days_values',$a)											
							->bind('last_12_months',$months)										
							->bind('last_12_months_values',$b)
							->bind('total_active_products_details',$total_active_products)
							->bind('total_products_details',$total_products)
							->bind('total_inactive_products_details',$total_inactive_products)
							->bind('sum_of_todayprod',$sum_of_todayprod)
							->bind('count_of_todayprod',$count_of_todayprod)
							->bind('sum_of_last7days',$sum_of_last7days)
							->bind('count_of_last7days',$count_of_last7days)
							->bind('sum_of_last30days',$sum_of_last30days)
							->bind('count_of_last30days',$count_of_last30days)
							->bind('sum_of_last1year',$sum_of_last1year)
							->bind('count_of_last1year',$count_of_last1year)
							->bind('sum_of_last10year',$sum_of_last10year)
							->bind('count_of_last10year',$count_of_last10year)
							->bind('sum_of_allproducts',$sum_of_allproducts)
							->bind('count_of_allproducts',$count_of_allproducts);
		$this->template->content = $view;
	}
*/
        /**
        * ****action_more_product_action()****
        * @param Action type = delete,  active, Inactive etc....
        * @return more product action
        */	 	
	public function action_more_product_action()
	{
		//get current page segment id 
		$type = $this->request->param('id');
		$userid = $_SESSION['id'];	
		//for more action (delete, active, etc....)		
		$product_action = $this->admin_product->more_product_action($type,$userid,$_POST['job_chk']);
		//flash message for more action
		switch ($product_action) {
			case DELETE_ACTION:
				Message::success(__('adminproduct_delete_flash'));
				break;			
			case ACTIVE_ACTION:
				Message::success(__('adminproduct_active_flash'));
				break;			
			case INACTIVE_ACTION:
				Message::success(__('adminproduct_inactive_flash'));
				break;
		}
		//redirects to index page after deletion
		$this->request->redirect("manageproduct/index");
	}

        /**
        * ****action_process()****
        * Auction Resumes listing items
        */
	public function action_resumes()
	{
		//get current page segment id
		$productid=arr::get($_REQUEST,'id'); 
		$commonmodel=Model::factory('commonfunctions');
		$result=$commonmodel->select_with_onecondition(PRODUCTS,"product_id=".$productid);
		$timestamp=$result[0]['increment_timestamp'];
		$timediff=$result[0]['timediff'];
                $userid = $_SESSION['id'];
                //get params value posting by query string
                $sus_status=arr::get($_REQUEST,'susstatus');
                $prducts_deteils= $this->admin_product->get_all_product_details_list($productid);
                if($prducts_deteils[0]['product_status']==DELETED_STATUS)
	        {
	         Message::error(__('product_allready_deleted_so_no_change'));
	         $this->request->redirect("manageproduct/index");
	        }
	        else
	        {
                //perform suspend action 
                $status = $this->admin_product->auction_resumes($productid, $userid, $sus_status,$timestamp,$timediff);
		//Flash message for Resumes
		Message::success(__('auction_resumes_flash'));
				switch($sus_status){
					case 0:							
					//success message for resumes product			
					Message::success(__('auction_resumes_flash'));			
					break;
					case 1:
					//success message for hold auction
					Message::success(__('auction_hold_flash'));
					break;
				}		
		//redirects to index page after deletion
		$this->request->redirect("manageproduct/index");
		}
	}
		
	//Multi upload function 
	public function multiupload(array $formvalues,$orginal_imagepath,$filefield="image",$settings=array())
	{
		if(is_array($formvalues))
		{
		       
		       
			$multiimgnames=array();
			for($i=0;$i<count(array_filter($formvalues[$filefield]['name']));$i++)
			{
			        
				$var=array($filefield=>array('name'=>$formvalues[$filefield]['name'][$i],'type'=>$formvalues[$filefield]['type'][$i],
				'tmp_name'=>$formvalues[$filefield]['tmp_name'][$i],'error'=>$formvalues[$filefield]['error'][$i],'size' =>$formvalues[$filefield]['size'][$i]));
				
				// multiple image validation 								
			
			/*	$validator = $this->admin_product->multi_image__product_form(array_merge($var));					
				if(!$validator->check())
				{
				Message::error(__('more_image_validation'));
				//$this->request->redirect("manageproduct/index");
				}
				else
				{
				// end to muliple image validation 		*/					
											
					try{
					        //image name for thumbs and original images
						$image_name=$multiimgnames[]=uniqid().$var[$filefield]['name'];

						$filename =Upload::save($var[$filefield],$image_name,$orginal_imagepath, 0777);	
					
						$this->multiresize($filename,$settings,$image_name);
					}
					catch(Exception $e)
					{
						Message::error("fields will not be empty and the image format will be .jpg,.gif,.png ");
						//$this->request->redirect("manageproduct/index");
					}
				//}
					
			}
			
		}
		else
		{
			die("files will be in array");
		}
//print_r($multiimgnames);exit;
		return $multiimgnames;
	}
	
	//Multi upload file resize function 
	public function multiresize($uploaded_file,$settings=array(),$image_name=NULL,$default_width="100",$default_height="100")
	{		
		
		$imagename=basename($uploaded_file);
		$image_name=($image_name===NULL)?uniqid().$imagename:$image_name;
		if(is_array($settings))
		{
			foreach($settings as $setting => $value)
			{
			
				if(array_key_exists("size",$value))
				{
						$width=$value['size']['width'];
						$height=$value['size']['height'];
						$path=$value['path'];
						$images=Image::factory($uploaded_file);
						$this->imageresize($images,$width,$height,$path,$image_name,$quality=90);								
				}
				else
				{
						$width=$default_width;//Default thumbsize width
						$height=$default_height;//Default thumbsize height
						$path=$value['path'];
						$images=Image::factory($uploaded_file);
						$this->imageresize($images,$width,$height,$path,$image_name,$quality=90);
				}
			}
		}
		else
		{
			Message::error("No path and thumb size is defined");
		}
	}
	
	 /**
        * ****action_delete()****
        * delete Products productimage items
        */
	public function action_inactive_product()
	{
                //auth login check
                $this->is_login(); 
                //get current page segment id 
                $productid = $this->request->param('id');
                $product_results=$this->admin_product->select_product($productid);
                
                foreach($product_results as $product_result)
		{
                $insert=$this->commonmodel->insert(PRODUCTS_WON,array('product_id'=>$product_result['product_id'],'product_name'=>$product_result['product_name'],'product_url'=>$product_result['product_url'],'product_category'=>$product_result['product_category'],'product_image'=>$product_result['product_image'],'product_gallery'=>$product_result['product_gallery'],'product_info'=>$product_result['product_info'],'startdate'=>$product_result['startdate'],'enddate'=>$this->getCurrentTimeStamp,'product_cost'=>$product_result['product_cost'],'current_price'=>$product_result['current_price'],'starting_current_price'=>$product_result['current_price'],'bidamount'=>$product_result['bidamount'],'max_countdown'=>$product_result['max_countdown'],'bidding_countdown'=>$product_result['bidding_countdown'],'product_status'=>$product_result['product_status'],'lastbidder_userid'=>$product_result['lastbidder_userid'],'auction_process'=>$product_result['auction_process'],'product_featured'=>$product_result['product_featured'],'dedicated_auction'=>$product_result['dedicated_auction'],'userid'=>$product_result['userid'],'reply_status'=>$product_result['reply_status'],'product_process'=>CLOSED));
                }
                $status = $this->admin_product->update_product_inactive($productid);
                //Flash message 
                Message::success(__('product_inactive_successfully'));	
                $this->request->redirect("manageproduct/index");
	}
	
	
	
	

	
} // End Welcome
