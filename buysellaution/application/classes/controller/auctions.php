<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Contains auctions module actions
 *
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

	
	*	Closed Auction page => $page = 2
	*  	Future Auction page => $page = 3
	* 	Live Auction page => $page = 4
*/

class Controller_Auctions extends Controller_Website {

	public $today;
	public $future_results;
	public $count_future_results;
	public $closed_results;
	public $product_result;
	private $_process = array();

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
	public function __construct(Request $request,Response $response)
	{
					parent::__construct($request,$response);
		$this->module = Model::factory('module');
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		$this->checking_time=CHECKING_TIME;
		
		if(!(preg_match('/auctions\/view/i',Request::detect_uri())) && !(preg_match('/auctions\/idle/i',Request::detect_uri())) && !(preg_match('/auctions\/setautobid/i',Request::detect_uri())) && !(preg_match('/auctions\/manage_setautobid/i',Request::detect_uri()))  && !(preg_match('/auctions\/edit_setautobid/i',Request::detect_uri())))
		{
			//Override the template variable decalred in website controller
			$this->template=THEME_FOLDER."template_sidebar";
                }	
		else if((preg_match('/auctions\/setautobid/i',Request::detect_uri())))
			{
				$this->template=THEME_FOLDER."template_user_sidebar";
			}
		else if((preg_match('/auctions\/manage_setautobid/i',Request::detect_uri())))
			{
				$this->template=THEME_FOLDER."template_user_sidebar";
			}
		else if((preg_match('/auctions\/edit_setautobid/i',Request::detect_uri())))
			{
				$this->template=THEME_FOLDER."template_user_sidebar";
			}
		else
		{
			//Override the template variable decalred in website controller
                        $this->template="themes/template";
                        
                        
                        /**To get selected theme template**/
				if(file_exists(VIEW_PATH.'template.php'))
				{
					$this->template=SELECTED_THEME_FOLDER.'template';
				}  
                        
		}
		

		$types = $this->module->select_types();
		$this->auction_types=array();
		foreach($types as $type)
		{
			
			$controller = 'Kohana_'.ucfirst($type['typename']);
			if(class_exists($controller))
			{				
				
				$this->{$type['typename']} = new $controller($request,$response);	
				if(method_exists($this->{$type['typename']},'process'))
				{
					$this->auction_types[$type['typeid']] = $type['typename'];
				}
					
			}			
			
		}
		View::bind_global('auction_types',$this->auction_types);
		
		//stores today night timestamp value
		$this->today=$this->today_midnight();
	
	}
	
	
	/**
	* Action for time countdown and display in browser
	* return
	* Ajax page**/
	public function action_process()
	{
		 
		$view=View::factory(THEME_FOLDER."auctions/process")
					->bind('array',$array)->bind('data',$data);
		$data=arr::extract($_GET,array("autobid","status","pid","arrayset","callback"));
		$product_set = array();
		$this->_process['status'] = $data['status'];
		$this->_process['pid'] = $data['pid'];
		$this->_process['arrayset'] = $data['arrayset'];
		$array=array();
		$abid=array();
		$array['auctions'] =array();
	
		$this->product_result = $this->add_process($data['status'],$data['pid'],$data['arrayset']);	
		
		foreach($this->auction_types as $typeid =>  $types){
			if(isset($this->product_result[$typeid]) && array_key_exists($typeid,$this->product_result))
			{
				if(method_exists($this->{$types},'process'))
				{
					$result =  $this->{$types}->process($this->product_result[$typeid],$data['status'],$data['arrayset']);
					if(count($result)>0)
					{
						$array['auctions']= array_merge($array['auctions'],$result);
					}
				}	
			}
		}
		$array['autobids']=$this->autobid();
		
		echo $view;
		exit;
	}
	
	//auction types	
	public function add_process($status,$pid="",$arrayset=array())
	{	
		$product_results=$this->auctions->select_products($status,$pid,$arrayset);		
		$product_set = array();
		foreach($product_results as $products)
		{
			foreach($this->auction_types as $typeid => $type)
			{
				if($products['auction_type'] == $typeid)
				{
					
					$product_set[$typeid][]=$products['product_id'];
				}
			}
		}
		return $product_set;
	}
		
	//auto bid
	public function autobid()
	{
		$select_autobids=$this->auctions->select_abid();
		return $select_autobids;		
	}
	
	public function action_updateAuction()
	{
		$date=date("Y-m-d H:i:s");
		$datas=arr::extract($_GET,array('status','pid'));
		$pid=isset($datas['pid'])?(int)substr(strstr($datas['pid'],"_"),1):1;
		$result=$this->auctions->select_products_to_update($pid,$date);
		if(count($result)>0){
			foreach($result as $product_result)
			{	
				if(isset($product_result['auction_type']) && array_key_exists($product_result['auction_type'],$this->auction_types)){
					$type=$this->auction_types[$product_result['auction_type']];
			 		$this->{$type}->update_product($datas['status'],$pid);
				}
				
			}
		}		
		exit;
	}
	
	
	
	/**
	 * ****Create unix timestamp for tonight****
	 * @return unix timestamp with given date and time
	 */ 
	public function today_midnight()
	{
		$dated=date("Y-m-d")." "."23:59:59";
		return $this->create_timestamp($dated);
	}
	
	
	// Page view actions starts
	//=========================
	/**
	* Action for index page
	**/
	public function action_index()
	{
		
		
		$view=View::factory(THEME_FOLDER."auctions/home")
				->bind('result',$live_result)
				->bind('banners',$banner)
				->bind('count_future',$count_future)
				->bind('user',$this->auction_userid)
				->bind('today',$this->today)
				->bind('liveproducts',$products)
				->bind('products',$future_products)
				->bind('count_future_result',$count_future_result)
				->bind('count_live_result',$count_live_result)
				->bind('count_me',$count_future)
				->bind('error',$error)
				->bind('include_facebook',$this->include_facebook);	
		
		
		$products =$this->add_process(5);
		$future_products =$this->add_process(3);		
		//Select banner image
		$banner=$this->auctions->select_home_banner();
		//Select products which all are in future	
		$future_result=$this->auctions->select_future_auctions_index($this->getCurrentTimeStamp);
		//Select products which all are in future	
		$closed_result=$this->auctions->select_closed_auctions_index();
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	
	/**
	* Action for Live auctions
	**/
	public function action_live()
	{
		
		$selected_page_title=__('menu_live_auction');
		$this->selected_page_title = __('menu_live_auction');
		$view=View::factory(THEME_FOLDER."auctions/live")
				->bind('result',$result)
				->bind('future_results',$this->future_results)
				->bind('count_future_results',$this->count_future_results)
				->bind('closed_results',$this->closed_results)
				->bind('today',$this->today)
				->bind('user',$this->auction_userid)
				->bind('liveproducts',$live_products)
				->bind('error',$error)
				->bind('count_live_result',$count_live_result)
				->bind('include_facebook',$this->include_facebook);
				
		$live_products =$this->add_process(4);		
		//Select products which all are in live	
		$result=array();
		$count_live_result=array();		
		$this->template->content=$view;	
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
		
	}

        /**
	* Action for buynow products
	**/
	public function action_buynow()
	{
		
		$selected_page_title=__('buynow_live_online_auctions');

		$this->selected_page_title = __('buynow_live_online_auctions');

		$view=View::factory(THEME_FOLDER."auctions/buynow")
				->bind('result',$result)
				->bind('future_results',$this->future_results)
				->bind('count_future_results',$this->count_future_results)
				->bind('closed_results',$this->closed_results)
				->bind('today',$this->today)
				->bind('user',$this->auction_userid)
				->bind('liveproducts',$live_products)
				->bind('error',$error)
				->bind('count_live_result',$count_live_result)
				->bind('include_facebook',$this->include_facebook);
				
		$live_products =$this->add_process(4);		
		//Select products which all are in live	
		$result=array();
		$count_live_result=array();
		
		$this->template->content=$view;	
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
		
	}
	
	/**
	* Action for Category auctions
	**/
	public function action_category()
	{
		$view=View::factory(THEME_FOLDER."auctions/category")
				->bind('result',$result)
				->bind('category_id',$category_name)
				->bind('offset',$offset)
				->bind('limit',$this->limit)
				->bind('pagination',$pagination)
				->bind('products',$products)
				->bind('user',$this->auction_userid)
				->bind('error',$error)
				->bind('category',$category)
				
				->bind('auction',$auction)
				->bind('include_facebook',$this->include_facebook);
		$auction=Model::factory('auction');
		$category_name=$this->request->param('id');	

		$count_cat=$this->auctions->select_product_cat($category_name,TRUE);
		
				        //pagination loads here
                        //==========================
                        $page_no= isset($_GET['page'])?$_GET['page']:0;
                     //   $count_category_auctions = $this->auctions->select_category_auctions($category_name,NULL,REC_PER_PAGE,TRUE);
		     
		     $count_category_auctions = $this->auctions->select_category_count($category_name,NULL,REC_PER_PAGE,TRUE);
		    // print_r($count_category_auctions);exit;

		     
		     
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_category_auctions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
			
		$result_category=$this->auctions->select_product_cat($category_name);		
		$products = $this->auctions->select_category_count($category_name,$offset,REC_PER_PAGE);	
		
		$category=$result_category[0]['category_name'];
		$this->selected_page_title = __('menu_category_selected')." : ".$category ;
	

		$this->template->content=$view;	
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
		
	}
	
	/**
	* Action for Live Category auctions
	**/
	public function action_home_category()
	{
		$view=View::factory(THEME_FOLDER."auctions/home")
				->bind('result',$live_result)
				->bind('banners',$banner)
				->bind('category',$category)
				->bind('count_future',$count_future)
				->bind('user',$this->auction_userid)
				->bind('today',$this->today)
				->bind('count_live_result',$count_live_result)
				->bind('count_me',$count_future)
				->bind('error',$error)
				->bind('include_facebook',$this->include_facebook);	
		$auction=Model::factory('auction');
		$category_name=$this->request->param('id');	
		$count_cat=$this->auctions->select_product_cat($category_name,TRUE);
		//Select products which all are in live		
		$live_result=$this->auctions->select_home_auctions($category_name,$this->getCurrentTimeStamp);
		$count_live_result=$this->auctions->select_home_auctions($category_name,$this->getCurrentTimeStamp,TRUE);	
		//Select banner image
		$banner=$this->auctions->select_home_banner();
		//Select products which all are in future	
		$future_result=$this->auctions->select_home_auctions_index($category_name,$this->getCurrentTimeStamp);
		$result_category=$this->auctions->select_product_cat($category_name);
		$category=$result_category[0]['category_name'];
		//Select products which all are in future	
		$closed_result=$this->auctions->select_closed_auctions_index();
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;

		       
	}
	
	/**
	* Action for Live Category auctions
	**/
	public function action_live_category()
	{
		$view=View::factory(THEME_FOLDER."auctions/live")
				->bind('result',$result)
				->bind('pagination',$pagination)
				->bind('user',$this->auction_userid)
				->bind('error',$error)
				->bind('category',$category)
				->bind('count_live_result',$count_live_result)
				->bind('count_category_auctions',$count_category_auctions)
				->bind('auction',$auction)
				->bind('include_facebook',$this->include_facebook);
		$auction=Model::factory('auction');
		$category_name=$this->request->param('id');	
		$count_cat=$this->auctions->select_product_cat($category_name,TRUE);
		        //pagination loads here
                        //==========================
                        $page_no= isset($_GET['page'])?$_GET['page']:0;
                        $count_category_auctions = $this->auctions->select_live_category_auctions($category_name,NULL,REC_PER_PAGE,TRUE);
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_category_auctions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
			
		$result=$this->auctions->select_live_category_auctions($category_name,$offset,REC_PER_PAGE);
		$result_category=$this->auctions->select_product_cat($category_name);
		$category=$result_category[0]['category_name'];
		$count_live_result=$this->auctions->select_live_category_auctions($category_name,$offset,REC_PER_PAGE,TRUE);
		$this->template->content=$view;	
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
		
	}
	
	/**
	* Action for Future Category auctions
	**/
	public function action_future_category()
	{
		$view=View::factory(THEME_FOLDER."auctions/future")
				->bind('result',$result)
				->bind('pagination',$pagination)
				->bind('user',$this->auction_userid)
				->bind('error',$error)
				->bind('category',$category)
				->bind('count_future_result',$count_future_result)
				->bind('count_category_auctions',$count_category_auctions)
				->bind('auction',$auction)
				->bind('include_facebook',$this->include_facebook);
		$auction=Model::factory('auction');
		$category_name=$this->request->param('id');	
		$count_cat=$this->auctions->select_product_cat($category_name,TRUE);
		        //pagination loads here
                        //==========================
                        $page_no= isset($_GET['page'])?$_GET['page']:0;
                        $count_category_auctions = $this->auctions->select_future_category_auctions($category_name,NULL,REC_PER_PAGE,TRUE);
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_category_auctions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
			
		$result=$this->auctions->select_future_category_auctions($category_name,$offset,REC_PER_PAGE);
		$result_category=$this->auctions->select_product_cat($category_name);
		$category=$result_category[0]['category_name'];
		$count_future_result=$this->auctions->select_future_category_auctions($category_name,$offset,REC_PER_PAGE,TRUE);
		$this->template->content=$view;	
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
		
	}
	
	/**
	* Action for Future Category auctions
	**/
	public function action_closed_category()
	{
		$view=View::factory(THEME_FOLDER."auctions/closed")
				->bind('result',$result)
				->bind('pagination',$pagination)
				->bind('user',$this->auction_userid)
				->bind('error',$error)
				->bind('category',$category)
				->bind('count_closed_results',$count_closed_results)
				->bind('product_results',$product_results)
				->bind('auction',$auction)
				->bind('include_facebook',$this->include_facebook);
		$auction=Model::factory('auction');
		$category_name=$this->request->param('id');	
		$count_cat=$this->auctions->select_product_cat($category_name,TRUE);
		        //pagination loads here
                        //==========================
                        $page_no= isset($_GET['page'])?$_GET['page']:0;
                        $count_category_auctions = $this->auctions->select_closed_category_auctions($category_name,NULL,REC_PER_PAGE,TRUE);
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_category_auctions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
			
		$product_results=$this->auctions->select_closed_category_auctions($category_name,$offset,REC_PER_PAGE);
		$result_category=$this->auctions->select_product_cat($category_name);
		$category=$result_category[0]['category_name'];
		$count_closed_results=$this->auctions->select_closed_category_auctions($category_name,$offset,REC_PER_PAGE,TRUE);

		$this->template->content=$view;	
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
		
	}
	
	
	/**
	* Action for Future auctions
	**/
	public function action_future()
	{

		$selected_page_title=__('menu_future');

	        $this->selected_page_title = __('menu_future');

		$view=View::factory(THEME_FOLDER."auctions/future")
				->bind('result',$result)
				->bind('pagination',$pagination)
				->bind('today',$this->today)
				->bind('products',$products)
				->bind('user',$this->auction_userid)
				->bind('error',$error)
				->bind('count_future_result',$count_future_result)
				->bind('include_facebook',$this->include_facebook);	
		//pagination loads here
		//==========================
			$page_no= isset($_GET['page'])?$_GET['page']:0;
 			$count_future_auctions = $this->auctions->select_future_auctions(NULL,REC_PER_PAGE,TRUE); 			
	   	 	if($page_no==0 || $page_no=='index')
			$page_no = PAGE_NO;
			$offset = REC_PER_PAGE*($page_no-PAGE_NO);
			  $pagination = Pagination::factory(array (
			  'current_page' => array('source' => 'query_string', 'key' => 'page'),
			  'total_items'    => $count_future_auctions,  //total items available
			  'items_per_page'  => REC_PER_PAGE,  //total items per page
			  'view' => PAGINATION_FOLDER,  //pagination style
			  'auto_hide'      => TRUE,
		  	  'first_page_in_url' => TRUE,
			  ));   			
			$products =$this->add_process(3);			
		$result=$this->auctions->select_future_auctions($offset,REC_PER_PAGE);
		$count_future_result=$this->auctions->select_future_auctions($offset,REC_PER_PAGE,TRUE);
		//****pagination ends here***//	
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}	

	
	/**
	* Action for Closed auctions

	**/
	public function action_closed()
	{

		$selected_page_title=__('menu_closed');

	        $this->selected_page_title = __('menu_closed');

		$view=View::factory(THEME_FOLDER."auctions/closed")
					->bind('today',$this->today)
					->bind('pagination',$pagination)
					->bind('products',$products)
					->bind('offset',$offset)
					->bind('products',$products)
					->bind('user',$this->auction_userid);
		$products_count = $this->auctions->select_products(9);
		
		//$products = $this->add_process(9);		
		//pagination loads here
		//==============================
		$page_no= isset($_GET['page'])?$_GET['page']:0;
		if($page_no==0 || $page_no=='index')
		$page_no = PAGE_NO;
		$offset = REC_PER_PAGE*($page_no-PAGE_NO);
		$pagination = Pagination::factory(array (
		'current_page' => array('source' => 'query_string', 'key' => 'page'),
		'total_items'    => count($products_count),  //total items available
		'items_per_page'  => REC_PER_PAGE,  //total items per page
		'view' => PAGINATION_FOLDER,  //pagination style
		'auto_hide'      => TRUE,
		'first_page_in_url' => TRUE,
		));  			
		$products= $this->auctions->select_products(9,"",array('offset'=>$offset,'limit' => REC_PER_PAGE));
		
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	
	/**
	* Action for winners
	**/
	public function action_winners()
	{
		

		$selected_page_title=__('menu_winners');

		$this->selected_page_title = __('menu_winners');
		
		
		$view=View::factory(THEME_FOLDER."auctions/winner")
					->bind('today',$this->today)
					->bind('pagination',$pagination)
					->bind('products',$products)
					->bind('offset',$offset)					
					->bind('user',$this->auction_userid);
		$products_count = $this->auctions->select_winners_count('','',true);
		//echo count($products_count);
		//$products = $this->add_process(9);		
		//pagination loads here
		//==============================
		$page_no= isset($_GET['page'])?$_GET['page']:0;
		if($page_no==0 || $page_no=='index')
		$page_no = PAGE_NO;
		$offset = REC_PER_PAGE*($page_no-PAGE_NO);
		$pagination = Pagination::factory(array (
		'current_page' => array('source' => 'query_string', 'key' => 'page'),
		'total_items'    => $products_count,  //total items available
		'items_per_page'  => REC_PER_PAGE,  //total items per page
		'view' => PAGINATION_FOLDER,  //pagination style
		'auto_hide'      => TRUE,
		'first_page_in_url' => TRUE,
		));		
		$products= $this->auctions->select_winners_count($offset,REC_PER_PAGE);
		
		
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	
	public function action_search()
	{
	         $this->selected_page_title=__('search_auctions');	         
		$searchvalue=strip_tags(arr::get($_GET,'search'));	
		if($searchvalue =='' || $searchvalue == __('search_text')){
			Message::error(__('search_empty'));
			$this->request->redirect('/');
			$value="";
		}
		else
		{
			$value=trim(Html::chars($searchvalue));
		}
		
		$search_results=$this->auctions->get_searchresults($value);
		$count_live_result=count($search_results);
		$view=View::factory(THEME_FOLDER."auctions/search")	
					->bind('value',$value)
					->bind('product_results',$search_results)
					->bind('user',$this->auction_userid)
					->bind('products',$products)
					->bind('include_facebook',$this->include_facebook)
					->bind('count_live_result',$count_live_result);
					
		$products =$this->add_process(8,"",array('search'=>$value));
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	/**
	* Action for Product detail
	**/
	public function action_view()
	{
		$view=View::factory(THEME_FOLDER."auctions/product_detail")
					->bind('product_results',$product_results)
					->bind('bid_histories',$bid_history)
					->bind('user',$this->auction_userid)
					->bind('endtime',$end_time)
					->bind('products',$products)
					->bind('starttime',$start_time)
					->bind('error',$error)
					->bind('pid',$pid)
					->bind('type',$type)
					->bind('c_date',$c_date)
					->bind('useramount',$amt)
					->bind('include_facebook',$this->include_facebook);			
		$error=$this->session->get('last_bidder');
		$userid=$this->auction_userid;
		$amt=Commonfunction::get_user_balance($userid);
		$c_date=$this->getCurrentTimeStamp;
		$id=$this->request->param('id');
		$product_results=$this->auctions->select_products_detail($id);
		
		if(count($product_results)==0)
		{
			Message::error(__('no_product_found'));
			$this->url->redirect("/");
		}
		
		$pid=$product_results[0]['product_id'];
	
		$products =$this->add_process(6,$pid); 
		$type=$product_results[0]['auction_type'];
		 
		if(array_key_exists($type,$this->auction_types) && method_exists($this->auction_types[$type],'loadmedia'))
		{
			$medias = call_user_func($this->auction_types[$type].'::loadmedia'); 
			if(array_key_exists('styles_'.THEME,$medias))
			{
			       $this->template->styles = array_merge($this->template->styles,$medias['styles_'.THEME]);
			}if(array_key_exists('scripts_'.THEME,$medias))
			{
			       $this->template->scripts = array_merge($this->template->scripts,$medias['scripts_'.THEME]);
			}
		} 
		$start_time=$this->date_to_string($product_results[0]['startdate']);
		$end_time=$this->date_to_string($product_results[0]['enddate']);
		$bid_history=$this->auctions->select_bid_history($pid);
		if(($product_results[0]['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_results[0]['product_image']))
		{ 
			$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_results[0]['product_image'];
			$product_full_size=URL_BASE.PRODUCTS_IMGPATH.$product_results[0]['product_image'];
		}
		else
		{
			$product_full_size=IMGPATH.NO_IMAGE;
			$product_img_path=IMGPATH.NO_IMAGE;
			
		}

		$this->template->content=$view;
		$this->template->title=$product_results[0]['product_name']."- Detail";
		$this->template->meta_description=substr($product_results[0]['product_info'],0,30);
		$this->template->meta_keywords=$product_results[0]['product_name'];
		
		$this->template->fb_title=$product_results[0]['product_name'];	
		$this->template->fb_desc=Text::limit_chars($product_results[0]['product_info'],250);	
		$this->template->fb_title=$product_results[0]['product_name'];		
		$this->template->fb_url=URL_BASE.'auctions/view/'.$product_results[0]['product_url'];
		$this->template->fb_image=$product_img_path;
	}


	public function action_view_product_history()
	{
		
		$view=View::factory(THEME_FOLDER."auctions/product_detail_bid_history")
					->bind('product_results',$product_results)
					->bind('bid_histories',$bid_history)
					->bind('user',$this->auction_userid)					
					->bind('products',$products)					
					->bind('error',$error)
					->bind('pid',$pid)
					->bind('type',$type)
					->bind('c_date',$c_date)
					->bind('useramount',$amt)
					->bind('include_facebook',$this->include_facebook);			
		$error=$this->session->get('last_bidder');
		$userid=$this->auction_userid;
		$amt=Commonfunction::get_user_balance($userid);		
		$c_date=$this->getCurrentTimeStamp;
		$id=$this->request->param('id');
		$product_results=$this->auctions->select_products_detail($id);
		
		if(count($product_results)==0)
		{
			Message::error(__('no_product_found'));
			$this->url->redirect("/");
		}
		
		$pid=$product_results[0]['product_id'];
	
		$products =$this->add_process(17,$pid);		
		$type=$product_results[0]['auction_type'];		
		
		
		$bid_history=$this->auctions->select_bid_history($pid);		
		if(($product_results[0]['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_results[0]['product_image']))
		{ 
			$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_results[0]['product_image'];
			$product_full_size=URL_BASE.PRODUCTS_IMGPATH.$product_results[0]['product_image'];
		}
		else
		{
			$product_full_size=IMGPATH.NO_IMAGE;
			$product_img_path=IMGPATH.NO_IMAGE;
			
		}

		$this->template->content=$view;
		$this->template->title=$product_results[0]['product_name']."- Detail";
		$this->template->meta_description=substr($product_results[0]['product_info'],0,30);
		$this->template->meta_keywords=$product_results[0]['product_name'];
		$this->template->fb_title=$product_results[0]['product_name'];	
		$this->template->fb_desc=Text::limit_chars($product_results[0]['product_info'],250);	
		$this->template->fb_title=$product_results[0]['product_name'];		
		//$this->template->fb_url=URL_BASE.'auctions/view/'.$product_results[0]['product_url'];
		$this->template->fb_image=$product_img_path;
	}

	

	// Functions of Auction process (Ajax loading pages)
	//==================================================
	/**
	* servertime function
	* @return time in hr mins and secs with latin phrase Anti Meridiem(AM) and Post Meridiem(PM)
	* Ajax flow 
	*/
	public function action_servertime()
	{
		echo date(SERVER_TIME_FORMAT,time());
		exit;
	}

	public function fetch_days($time)
	{
		$tDiff = $time - time();
		$days = floor($tDiff / 86400);//Calc Days
		$hours = ($tDiff / 3600) % 24;//Calc hours
		$mins = ($tDiff / 60) % 60;//Calc mins
		$secs = ($tDiff) % 60;//Calc Secs
		return $days.",".$hours.",".$mins.",".$secs;
	}
	
	
	public function action_details()
	{
		$details['language']=$this->javascript_language;
		$details['baseurl'] = URL_BASE;
		$details['autobids']=$this->auctions->select_abid();
		echo json_encode($details);	exit;
	}

	//Auto bid Manage 
	public function action_manage_setautobid()
	{		
		$this->is_login();
		 $this->selected_page_title = __('menu_autobid');	
		$uid=$this->auction_userid;		
		$view=View::factory(THEME_FOLDER."auctions/manage_setautobid")
				->bind('products',$products)
				->bind('select_autobid',$select_autobid)
				->bind('autobid_products',$autobid_products)
				->bind('errors',$errors)
				->bind('form_values',$arr);
		$autobid_products=$this->auctions->manage_autobid($uid,168);
		
		$products=$this->auctions->select_product_has_autobid();
		$select_autobid=$this->auctions->select_autobid_users($this->auction_userid);
		$submit=$this->request->post('set');
		if($submit)
		{
			$arr=Arr::extract($_POST,array('product_name','autobid_amt'));
			$validate=$this->auctions->validate_autobid($arr,$this->auction_userid);
			if($validate->check())
			{
				if($this->auction_userid)
				{
					$insert=$this->commonmodel->insert(AUTOBID,array('userid' => $this->auction_userid,
											'product_id' =>$arr['product_name'],
											'bid_amount' =>$arr['autobid_amt'],
											'time' => $this->getCurrentTimeStamp));
					if($insert)
					{
						$select_product=$this->commonmodel->select_with_onecondition(PRODUCTS,'product_id='.$arr['product_name']);
						if($select_product[0]['dedicated_auction']!=ENABLE){
						$amt=(Commonfunction::get_user_balance($this->auction_userid)-$arr['autobid_amt']);
						$this->users->update_user_bid($amt,$this->auction_userid,0);
						}
						else
						{$amt=(Commonfunction::get_user_bonus($this->auction_userid)-$arr['autobid_amt']);
						$this->users->update_user_bid($amt,$this->auction_userid,1);}
						Message::success(__('autobid_set_successfully'));
						$arr=NULL;
					}
				}
			}
			else
			{
				$errors=$validate->errors('validation');
			}
		}
		
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	//Auto bid Manage 
	public function action_edit_setautobid()
	{
		
		$this->is_login();
		$uid=$this->auction_userid;
		$product_id=$this->request->param('id');
		$products=$this->auctions->select_autobid($product_id);
		
		$select_autobid=$this->auctions->select_autobid_users($uid);		
		//Amount Get 
		$auto_biduser_amount=$this->auctions->select_autobid_users_amount($uid,$product_id);		
		$autobid_products=$this->auctions->edit_autobid($uid,$product_id);		
		if(count($autobid_products)==0)
		{
			Message::error(__('no_product_found'));
			$this->url->redirect("/");
		}
              
		
		$view=View::factory(THEME_FOLDER."auctions/edit_autobid")
				->bind('product',$products)
				->bind('autobid_products',$autobid_products)
				->bind('errors',$errors)
				->bind('form_values',$form_values);
                $form_values=Arr::extract($_POST, array('product_name','bid_amount','product_id'));
                $validate=$this->auctions->autobid_validation($form_values,$uid);  
                $submit=$this->request->post('setbid_amount');            
				if(isset($submit))
				{                    
					if($uid)
					{ 			
						if($validate->check())
						{	
										
							$select_product=$this->commonmodel->select_with_onecondition(PRODUCTS,'product_id='.$_POST['product_id']);
					        if($select_product[0]['dedicated_auction']!=ENABLE)
					        {
								$amt=$_POST['bid_amount'];	
								
                                $user_amt=(Commonfunction::get_user_balance($uid));
								$totalamt= $user_amt-$amt;
						        $this->users->update_user_bid($totalamt,$uid,0);
                                //Auto bid add amount
                                $amt_set=$auto_biduser_amount[0]['bid_amount']+$_POST['bid_amount'];
                                $insert=$this->auctions->update_bidamount($uid,$_POST, $amt_set);
                             }
                             else
							 {
								$amt=(Commonfunction::get_user_bonus($uid));
								
						        $amt=(Commonfunction::get_user_bonus($uid)-$_POST['bid_amount']);
						        $this->users->update_user_bid($amt,$uid,1);
						        $amt_set=$auto_biduser_amount[0]['bid_amount']+$_POST['bid_amount'];
						        $insert=$this->auctions->update_bidamount($uid,$_POST,$amt_set);                            
							 }
							Message::success(__('autobid_set_successfully'));
							$arr=NULL;
						}
                        else
						{
							//Fetch the error message and store in $errors array
							$errors=$validate->errors('errors');
							
						}                  
                   }
		}
			
                         
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
		
	//Auction addblack div load	
	public function action_addBlock()
	{
		$json=array();
		$datas=arr::extract($_GET,array('pids'));
		$pids=($datas['pids']!="")?$datas['pids']:array();
		$result=$this->auctions->select_product_add_block(array_unique($pids));		
		$count_live_result=count($result);
		$view=View::factory(THEME_FOLDER."auctions/addblock")
					->bind('count_live_result',$count_live_result)					
					->bind('user',$this->auction_userid)
					->bind('include_facebook',$this->include_facebook)
					->bind('result',$result);
		
		$json['output']=$view->render();
		//$json['popprd_output']=$popview->render();
		echo json_encode($json);
		exit;
	}
	
	/**
	* Action for Bid history
	* Ajax page
	**/
	public function action_bid_history()
	{
		$view=View::factory(THEME_FOLDER."auctions/bid_history")
					->bind('bid_histories',$bid_history)
					->bind('user',$this->auction_userid)
					->bind('count',$count);		
		
		//Get the current param id as like get method
		$id=$this->request->param('id');

		$bid_history=$this->auctions->select_bid_history($id);
		$count=count($bid_history);
		echo $view;
		exit;
	}
	
	/**
	* Action for checking user balance
	* Ajax page
	**/
	public function action_check_balance()
	{
		$id=$this->request->param('id');
		$user_balance=$this->auctions->select_users($id);
		$balance="";
		foreach($user_balance as $user_bal)
		{
			$balance.=$user_bal['user_bid_account'];
		}
		if($balance!=""&& $balance>0){
		echo Commonfunction::numberformat($balance);
		}
		else
		{
			echo 0;
		}		
		exit;
	}

	/**
	* Action for checking user balance
	* Ajax page
	**/
	public function action_check_bonus()
	{
		$id=$this->request->param('id');
		$user_balance=$this->auctions->select_users($id);
		$balance="";
		foreach($user_balance as $user_bal)
		{
			$balance.=$user_bal['user_bonus'];
		}
		if($balance!="" && $balance>0){
		echo Commonfunction::numberformat($balance);
		}
		else
		{
			echo 0;
		}
		exit;
	}

	/**
	* Action for add watchlist
	* Ajax page
	**/
	public function action_addwatchlist()
	{	
		$userid=$this->auction_userid;
		$pid=Arr::get($_GET, 'pid');
		if($this->auctions->check_watchlist_table($pid,$userid))
		{
			$this->commonmodel->insert(WATCHLIST,array('user_id'=>$userid,'product_id'=>$pid,'added_date'=>$this->getCurrentTimeStamp));
			echo "1";
		}
		else
		{
			echo "2";
		}
		exit;
	}

	public function timediff($time)
	{
		$tDiff = $time - time();
		$days = floor($tDiff / 86400);//Calc Days
		$hours = ($tDiff / 3600) % 24;//Calc hours
		$mins = ($tDiff / 60) % 60;//Calc mins
		$secs = ($tDiff) % 60;//Calc Secs
		return array('day' => $days , 'hr' => $hours , 'min' => $mins, 'sec' => $secs);
	}

	/**
	* Action for add flike users
	* Ajax page
	**/
	public function action_fblike()
	{	
		$userid=$this->auction_userid;
		
			
		if(isset($this->auction_userid))
		{
			if($this->auctions->check_flike_table($userid))
			{
				$this->commonmodel->insert(FLIKE_USERS,array('userid'=>$userid,'ip'=>Request::$client_ip,'valid_upto'=>date("Y-m-d H:i:s",time()+86400),'liked_date'=>$this->getCurrentTimeStamp));
				if(Commonfunction::get_bonus_amount(FACEBOOK_LIKE) >0)
				{
					$this->commonmodel->insert(USER_BONUS,array('bonus_type'=>FACEBOOK_LIKE,'bonus_amount'=>Commonfunction::get_bonus_amount(FACEBOOK_LIKE),'userid'=>$this->auction_userid));

					//update on user table
					$old_balance=Commonfunction::get_user_bonus($this->auction_userid);
			
					$c_balance=$old_balance+Commonfunction::get_bonus_amount(FACEBOOK_LIKE);
					$this->commonmodel->update(USERS,array('user_bonus'=>$c_balance),'id',$this->auction_userid);			

					Commonfunction::custom_user_bonus_message(array('custom_msg'=>__('flike_custom_message',array(":param"=>$this->site_currency." ".Commonfunction::get_bonus_amount(FACEBOOK_LIKE))),'subject'=> mb_convert_encoding(__('flike_message_subject'),'utf-16','utf-8')));
					
				}					
				echo "1";
			}
			else
			{
				echo "2";
			}
		}
		else
		{
			echo "11";
		}
		exit;
	}

	/** Function for auction process ends here **/	

	public function action_setautobid()
	{  
		$this->is_login();
		$this->selected_page_title = __('menu_setautobid');
		$view=View::factory(THEME_FOLDER."auctions/setautobid")
				->bind('products',$products)
				->bind('select_autobid',$select_autobid)
				->bind('errors',$errors)
				->bind('values',$values)
				->bind('form_values',$arr)
				->bind('action',$action)
				->bind('usererror',$usererror)
				->bind('price_err',$price_err)
				->bind('checkuser',$checkuser1);
		$action="setautobid";
		$values[0]='';
		$products=$this->auctions->select_product_has_autobid();
		$select_autobid=$this->auctions->select_autobid_users($this->auction_userid);		
		
		//get user balance
		$balance=Commonfunction::get_user_balance($this->auction_userid);
		//get Bouns balance
		$checkuser1=$this->auctions->checkuser($this->auction_userid);
		$bonus_balance=Commonfunction::get_user_bonus($this->auction_userid);		
		$submit=$this->request->post('set');		
		if(isset($submit) && Validation::factory($_POST))  
		{
			$arr=Arr::extract($_POST,array('auctionid','product_name','autobid_amt','autobid_start_amount'));
			//post null validate	
			$select_autobid_productid="";
			$select_autobid_lastbider="";
			$status="set";
			//Get product auto-bid post product id
			//$product_id=$_POST['product_name'];
                        $product_id=isset($_POST['product_name'])?$_POST['product_name']:0;
                        
			if(($arr['product_name'] ) && ($arr['autobid_amt']) && ($arr['autobid_start_amount'])){

				$select_autobid_productid=$this->auctions->check_product_current_price($product_id);
				//Bidhistory select last bidder validate amount add
				$select_autobid_lastbider=$this->auctions->select_bid_history_user($this->auction_userid,$product_id);
				//amount check compare
				$select_autobid_compare=$this->auctions->autobid_product_current_price($this->auction_userid,$product_id,$arr);
				$validate=$this->auctions->validate_autobid($arr,$this->auction_userid,$select_autobid_productid,$balance,$bonus_balance,$select_autobid_lastbider,$status);
			}else{				
			    //	Post empty validate			     	
			     $validate=$this->auctions->validate_autobid($arr,$this->auction_userid,$select_autobid_productid,$balance,$bonus_balance,$select_autobid_lastbider,$status);
 
			} 
			$usererror=array();
			$usererror['isbeginner']="";
			if($validate->check())
			{
				$checkuser=false;
				$checkauction=$this->auctions->getauctiontype($arr['auctionid']);
				
				if($checkauction=="beginner")
				{
					$checkuser=$this->auctions->checkuser($this->auction_userid);
					
					if($checkuser)
					{
						$price_err='0';
						if($select_autobid_compare[0]['current_price'] > $arr['autobid_start_amount'])
						{
							$price_err='1';
						}
						else
						{
							if($this->auction_userid)
							{
								$insert=$this->commonmodel->insert(AUTOBID,array('userid' => $this->auction_userid,
											'product_id' =>$arr['product_name'],
											'bid_amount' =>$arr['autobid_amt'],
								                        'autobid_start_amount'=>$arr['autobid_start_amount'],			
											'time' => $this->getCurrentTimeStamp));
								if($insert)	
								{
									$select_product=$this->commonmodel->select_with_onecondition(PRODUCTS,'product_id='.$arr['product_name']);
									if($select_product[0]['dedicated_auction']!=ENABLE)
									{
										$amt=(Commonfunction::get_user_balance($this->auction_userid)-$arr['autobid_amt']);
										$this->users->update_user_bid($amt,$this->auction_userid,0);
									}
									else
									{
										$amt=(Commonfunction::get_user_bonus($this->auction_userid)-$arr['autobid_amt']);
										$this->users->update_user_bid($amt,$this->auction_userid,1);
									}
									Message::success(__('autobid_set_successfully'));
									$this->url->redirect("auctions/setautobid");
									$arr=NULL;
								}
							}
						}
					}
					else
					{
						
						$usererror['isbeginner']="You are not a beginner";
					}
				}
				else
				{
					$price_err='0';
					if($select_autobid_compare[0]['current_price'] > $arr['autobid_start_amount'])
					{
					$price_err='1';
					}
					else
					{
						if($this->auction_userid)
						{
							$insert=$this->commonmodel->insert(AUTOBID,array('userid' => $this->auction_userid,
											'product_id' =>$arr['product_name'],
											'bid_amount' =>$arr['autobid_amt'],
								                        'autobid_start_amount'=>$arr['autobid_start_amount'],			
											'time' => $this->getCurrentTimeStamp));
							if($insert)	
							{
								$select_product=$this->commonmodel->select_with_onecondition(PRODUCTS,'product_id='.$arr['product_name']);
								if($select_product[0]['dedicated_auction']!=ENABLE)
								{
									$amt=(Commonfunction::get_user_balance($this->auction_userid)-$arr['autobid_amt']);
									$this->users->update_user_bid($amt,$this->auction_userid,0);
								}
								else
								{
									$amt=(Commonfunction::get_user_bonus($this->auction_userid)-$arr['autobid_amt']);
									$this->users->update_user_bid($amt,$this->auction_userid,1);
								}
								Message::success(__('autobid_set_successfully'));
								$this->url->redirect("auctions/setautobid");
								$arr=NULL;
							}
						}
					}
				}
			} // end of price validation
			else
			{

				$errors=$validate->errors('validation'); 
			}
			
		}
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	


	public function action_deleteautobid($uid,$pid)
	{
		return $this->auctions->delete_autobid($uid,$pid);
		
	}	

	//Auction type of product list
	//Select auction type ajax load
	public function action_auctiontypes()
	{

		$user=$this->auction_userid;
		$this->auto_render=FALSE;
		$get=Arr::get($_GET,'parent_id');
		$post=Arr::get($_GET,'post');
		$result="";
		if($get):
			$makes=$this->auctions->auction_types_list($get,$user);
			$result="<option value=''>Select Product</option>";
			if(count($makes)>0)
			{
				foreach($makes as $sub_cat)
				{	
					
					$result.="<option value='".$sub_cat['product_id']."'";
					$result.=(isset($post) && $post==$sub_cat['product_id'])?" selected=selected":"";
					$result.=">".ucfirst($sub_cat['product_name'])."</option>";
				}
			}
		endif;
		$autobid_amt=Arr::get($_GET,'autobid_amt');
		$product_id=Arr::get($_GET,'product_id');
		
		if($autobid_amt and $product_id):
			$res=$this->auctions->check_autobid_amt($autobid_amt,$product_id,$user);
			$result=$res['status'];
		endif;
		$autobid_start=Arr::get($_GET,'autobid_start');
		if($autobid_start and $product_id):
			$res=$this->auctions->check_autobid_start($autobid_start,$product_id);
			$result=$res['status'];	
		endif;
		echo $result;
	}
	
	public function action_idle()
	{
		$view = View::factory(THEME_FOLDER."idle");
		$this->template->content =  $view;$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	

}//End of auctions controller
?>
