<?php defined("SYSPATH") or die("No direct script access.");
/**
* Contains User controller actions

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Users extends Controller_Website {

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
	public function __construct(Request $request,Response $response)
	{
		parent::__construct($request,$response);
		$this->getCurrentTimeStamp=Commonfunction::getCurrentTimeStamp();
		//$this->listingcost=Model::factory('listingcost');
		if(!(preg_match('/users\/login/i',Request::detect_uri()) || preg_match('/users\/signup/i',Request::detect_uri()) || preg_match('/users\/testimonials_details/i',Request::detect_uri()) || preg_match('/users\/sitemap/i',Request::detect_uri()) || preg_match('/users\/forgot_password/i',Request::detect_uri())  ))
		{
			//Override the template variable decalred in website controller  
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
		
		if(preg_match('/users\/invite/i',Request::detect_uri()))
		{
			
		}
		
		
	}
	
	/**
	* Action for index Page
	*/
	public function action_dashboard()
	{
		$selected_page_title=__('my_dashboard');
		$view=View::factory(THEME_FOLDER."dashboard")
				->bind('user_result',$user_result)
				->bind('balance',$balance);
		$this->is_login();		
		$balance=Commonfunction::get_user_balance($this->auction_userid);
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	/**
	* Action for index Page
	*/
	public function action_index()
	{
	      	$this->selected_page_title= __('menu_dashboard');	
		$view=View::factory(THEME_FOLDER."dashboard")
				->bind('user_result',$user_result)
				->bind('balance',$balance);
		$this->is_login();	
		$balance=Commonfunction::get_user_balance($this->auction_userid);
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	public function action_message_list()
	{
		$select_user=$this->users->select_user_mailid($this->auction_userid);
		$message_results=$this->users->select_user_message_readunread($select_user[0]['email']);
		echo json_encode($message_results);exit;
	}
	
	/**
	* Action for users message
	*/
	public function action_my_message()
	{
		$selected_page_title=__('menu_my_message');
		$this->is_login();
			$this->selected_page_title = __('menu_my_message');
		$delete_id=$this->request->param('id');
		if(isset($delete_id)){
			$this->users->delete_user_message($delete_id);
			Message::success(__('usermessage_deleted_successfully'));
			$this->url->redirect("users/my_message");
		}
		$view=View::factory(THEME_FOLDER."my_message")
					->bind('count_user_message',$count_user_message)
					->bind('message_results',$message_results)
					->bind('pagination',$pagination);
					
		        $select_user=$this->users->select_user_mailid($this->auction_userid);
                        //pagination loads here
                        //==========================
                        $page=Arr::get($_GET,'page');
                        $page_no= isset($page)?$page:0;
			
                        $count_user_message = $this->users->select_user_message($select_user[0]['email'],NULL,REC_PER_PAGE,TRUE);
							
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_user_message,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
		
		$message_results=$this->users->select_user_message($select_user[0]['email'],$offset,REC_PER_PAGE);
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	/**
	* Action for users message details
	*/
	public function action_my_message_details()
	{
		$selected_page_title=__('my_message_details');
		$this->is_login();
		$this->selected_page_title = __('menu_my_message');
		$view=View::factory(THEME_FOLDER."message_details")
					->bind('message_results',$message_results);
					
		$messageid=$this->request->param('id');
		if($messageid)
		{
			$this->commonmodel->update(USER_MESSAGE,array('msg_type'=>READ,'status'=>1),'usermessage_id',$messageid);
		}
		else
		{
			$this->url->redirect("users/my_message");
		}
		
		$message_results=$this->users->select_user_message_details($messageid);
		 
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	/**
	* Action for users watchlist
	*/
	public function action_watchlist()
	{
		$selected_page_title=__('my_watchlist');
		$this->is_login();
			$this->selected_page_title = __('my_watchlist');
		$view=View::factory(THEME_FOLDER."watchlist")
					->bind('count_user_watchlist',$count_user_watchlist)
					->bind('watch_results',$watch_results)
					->bind('pagination',$pagination);
		$id=$this->request->param('id');
		if($id!="")
		{
			$this->users->delete_watchlist($id);
			Message::success(__('product_success_delete_from_watchlist'));
			$this->url->redirect("users/watchlist");
		}
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 			$count_user_watchlist = $this->users->select_user_watchlist($this->auction_userid,NULL,REC_PER_PAGE,TRUE);
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_user_watchlist,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
		
		$watch_results=$this->users->select_user_watchlist($this->auction_userid,$offset,REC_PER_PAGE);
		
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	/*Auction Friends Invite List*/
	public function action_friends_invite()
	{
			
		$this->is_login();
		$this->selected_page_title = __('my_referral');    
		$view=View::factory(THEME_FOLDER."referrals")
					->bind('referrals',$referrals)
					->bind('exclude_ids',$ids)
					->bind('count_referrals',$count_referrals)
					->bind('include_facebook',$include_facebook)
					->bind('referrer_id',$referrer_id)




					->bind('check_status',$check_status);
		$include_facebook=$this->include_facebook;
		$referrals=$this->users->select_fb_invites($this->auction_userid);
		$count_referrals=$this->users->select_fb_invites($this->auction_userid,TRUE);
		$check_status=$this->users->get_from_bonus_tables($this->auction_userid,FACEBOOK_INVITE);
		$referrer_id=isset($this->auction_userid)?$this->commonmodel->select_with_onecondition(USERS,'id='.$this->auction_userid):0;
		$ids="";
		if($this->auction_userid)
		{
			$excludes=$this->users->check_fb_invites($this->auction_userid);
			$ids=$excludes[0]['friends_ids'];
		}
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	/**
	* Action for users invite
	*/
	public function action_invite()
	{	
		$this->is_login();		
		if(isset($_REQUEST["ids"])) 
		{ 
					
					$bonus_point=count($_REQUEST["ids"]);
					$old_ids=$this->users->check_fb_invites($this->auction_userid);
					
					$old_idss=explode(",",$old_ids[0]['friends_ids']);
					$new_ids=implode(",",Arr::merge($_REQUEST["ids"],$old_idss));
					//$referrer_id=0;
					$referrer_id=isset($this->auction_userid)?($this->commonmodel->select_with_onecondition(USERS,'id='.$this->auction_userid)):0;
					if(count($old_ids)==0)
					{
						$this->commonmodel->insert(FB_INVITE_LIST,array('userid'=>$this->auction_userid,'friends_ids'=>$new_ids,'request_id' =>$_REQUEST["rid"],'referral_id' => $referrer_id[0]['referral_id'],'ip'=>Request::$client_ip,'invited_date'=>$this->getCurrentTimeStamp));
					}
					else
					{
						$this->commonmodel->update(FB_INVITE_LIST,array('userid'=>$this->auction_userid,'friends_ids'=>$new_ids,'request_id' =>$_REQUEST["rid"],'referral_id' => $referrer_id[0]['referral_id'],'ip'=>Request::$client_ip,'invited_date'=>$this->getCurrentTimeStamp),'userid',$this->auction_userid);
					}
				
					//For invites amount add
					$c_invites=$this->users->select_fb_invites($this->auction_userid);
					if(count($c_invites)>0){
						$ccinvites=array_filter(explode(",",$c_invites[0]['friends_ids']));
					}
					else
					{
						$ccinvites[]="";
					}
				
					//Value to check for user to add bonus
					$range=3;
					$count_invites=count($ccinvites);
					if($count_invites >= $range)
					{
						$f_count=$this->commonmodel->select_with_onecondition(FB_INVITE_LIST,'userid='.$this->auction_userid);
						if(count($f_count)>0)
						{
							if($f_count[0]['f_count']>0)
							{
							
								$count=$f_count[0]['f_count'];
								$invites=$count_invites-($count*$range);
								$loop=floor($invites / $range);
									$this->commonmodel->update(FB_INVITE_LIST,array('f_count'=>($count+$loop)),'userid',$this->auction_userid);
							}
							else
							{
								
								
								$loop=floor($count_invites / $range);
								if(count($f_count)==0)
								{
									$this->commonmodel->insert(FB_INVITE_LIST,array('f_count'=>$loop));						
								}
								else
								{
									$this->commonmodel->update(FB_INVITE_LIST,array('f_count'=>($loop)),'userid',$this->auction_userid);
								}
							}
							if($loop>0){
							$select_bonus=$this->commonmodel->select_with_onecondition(BONUS,'bonus_type_id='.FACEBOOK_INVITE);
							
							for($i=0;$i<$loop;$i++)
								{						
									$count_user_bonus=$this->users->get_from_bonus_tables($this->auction_userid,FACEBOOK_INVITE,TRUE);
									if($count_user_bonus>0)
									{
										$select_user_bonus=$this->users->get_from_bonus_tables($this->auction_userid,FACEBOOK_INVITE);
										$old_bonus=$select_user_bonus[0]['bonus_amount'];

										//Amount to be added for every invitation sent
										$new_amount=$select_bonus[0]['bonus_amount'];
										$c_bonus=$old_bonus+$new_amount;
										$update=$this->users->add_user_bonus($c_bonus,$this->auction_userid,FACEBOOK_INVITE);
										
							
									}
									else
									{
										$insert=$this->commonmodel->insert(USER_BONUS,array('bonus_type'=>FACEBOOK_INVITE,'bonus_amount'=>Commonfunction::get_bonus_amount(FACEBOOK_INVITE),'userid'=>$this->auction_userid));
			
									}
								}
							
								//update on user table
								$old_balance=Commonfunction::get_user_bonus($this->auction_userid);								
								$c_balance=$old_balance+($loop * Commonfunction::get_bonus_amount(FACEBOOK_INVITE));
								$this->commonmodel->update(USERS,array('user_bonus'=>$c_balance),'id',$this->auction_userid);			
							
						
							//User my message
							Commonfunction::custom_user_bonus_message(array('custom_msg'=>__('facebook_invite_send',array(":param"=>$this->site_currency." ".$loop * Commonfunction::get_bonus_amount(FACEBOOK_INVITE),":param1"=>$range)),'subject'=>__('facebook_invite_send_subject')));
												
							}							
						}//f_count condition ends
					}
										
				Message::success(__('invition_successfully_sent'));
			
		}		
		exit;
	}

	/**
	* Action for users won auctions
	*/
	public function action_won_auctions()
	{	 
		$payment_gateway=$this->packages->select_paymentgateways();		
		$selected_page_title=__('menu_won_auctions');
		$this->is_login();
		$this->selected_page_title = __('menu_won_auction');   
		
		$view=View::factory(THEME_FOLDER."won_auctions")
				->bind('users',$users)
				->bind('count_user_wonauctions',$count_user_wonauctions)
				->bind('payment_gateway',$payment_gateway)
				->bind('wonauctions_results',$won_all)
				//->bind('product_details',$product_details[0])
				->bind('pagination',$pagination);
		 $users=Model::factory('users');	
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 			$count_user_wonauctions=$this->users->select_user_wonauctions(NULL,REC_PER_PAGE,$this->auction_userid,TRUE);
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_user_wonauctions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
		$wonauctions_results=$this->users->select_user_wonauctions($offset,REC_PER_PAGE,$this->auction_userid);
		
		$won_all=array();
		foreach($wonauctions_results as $res)
		{
			
			$won_completed=$this->users->getAuction_all_Orders($res['product_id'],$this->auction_userid);			
			$won_all[]=array('order_status'=>$won_completed,'product_url'=>$res['product_url'],'shipping_fee'=>$res['shipping_fee'],'product_id'=>$res['product_id'],'product_name'=>$res['product_name'],'product_image'=>$res['product_image'],'current_price'=>$res['current_price'],'enddate'=>$res['enddate'],'lastbidder_userid'=>$res['lastbidder_userid'],
					 'typename'=>$res['typename'],'userid'=>$res['userid']);		

		}
	 
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	/**
	* Action for users View Testimonials
	*/
	public function action_testimonials_details()
	{
		
	        //$this->is_login();
		$view=View::factory(THEME_FOLDER."testimonials_details")
				->bind('user_results',$user_results)
				->bind('pagination',$pagination);
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 			$count_testimonials_auctions = $this->users->count_testimonials_auctions();
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_testimonials_auctions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
			
		$user_results=$this->users->select_user_testimonials($offset,REC_PER_PAGE);
		
		//****pagination ends here***//
		
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	/**
	* Action for users View MyTestimonials
	*/
	public function action_mytestimonials_details()
	{
		$selected_page_title=__('my_testimonials');
	    $this->is_login();
	        $this->selected_page_title = __('my_testimonials');    
		$view=View::factory(THEME_FOLDER."manage_testimonials")
				->bind('mytestimonials_results',$mytestimonials_results)
				->bind('count_mytestimonials_auctions',$count_mytestimonials_auctions)
				->bind('pagination',$pagination);
		//pagination loads here
		//==========================
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
 			$count_mytestimonials_auctions = $this->users->count_mytestimonials_auctions($this->auction_userid);
 			
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_mytestimonials_auctions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
			
		$mytestimonials_results=$this->users->select_user_mytestimonials($offset,REC_PER_PAGE,$this->auction_userid);
		
		//****pagination ends here***//
		
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	/**
	* Action for users Testimonials
	*/
	public function action_testimonials()
	{
		$selected_page_title=__('testimonials');
		$this->is_login();
		 $this->selected_page_title = __('my_testimonials');   
		$view=View::factory(THEME_FOLDER."testimonials")
				->bind('errors',$errors)
				->bind('validate',$validate)
				->bind('video_error',$video_error)
				->bind('form_values',$form_values);
		$form_values=Arr::extract($_POST, array('username_id','title','description','video'));
		$image=Arr::extract($_FILES, array('photo'));
		$data=Arr::merge($form_values,$image);
		$validate=$this->users->testimonials_validation($data);
		$submit=$this->request->post('testimonials');
		if(isset($submit))
		{
		    if($validate->check())
		    {
			$image_name=$_FILES['photo']['name'];
			if($_POST["video"]&&$image_name)
                        {
                                Message::error(__('viedo_or_image'));
                        }
                        else
                        {
				 $url=$_POST["video"]; 
	
				 $check_url = explode('?',$url);
			        if($check_url[0] != 'http://www.youtube.com/watch' && $url != '' && !isset($check_url[1])) 
			        { 
			        	$video_error=__('invalid_video_url');
				}
				else
				{
				 //Uploading and saving image
				 $filename =Upload::save($_FILES['photo'],NULL,DOCROOT.TESTIMONIALS_IMGPATH, '0777');			
				$IMG_NAME="";
				if($_FILES['photo']['name'] !=""){
					//to get image name from array
					$IMG_NAME= explode("/",$filename);
					$IMG_NAME= end($IMG_NAME);
					$image_factory=Image::factory($filename);
					$path=DOCROOT.TESTIMONIALS_IMGPATH;
					$this->imageresize($image_factory,TESTIMONIALS_IMAGE_WIDTH,TESTIMONIALS_IMAGE_HEIGHT,$path,$IMG_NAME);			   
				}
								
				$result=$this->users->add_video($_POST,$IMG_NAME,$this->auction_userid);
				
				if($result == 0){
                                        Message::error(__('Your_system_youtube_block'));
                                }
                                else
                                {
                                //Session set for success msg
				Message::success(__('testimonials_successfully'));
				$this->request->redirect("users/mytestimonials_details/");
				$form_values=NULL;
				}
				
				}
			}
			
	             }
                     else
                     {
	                  //Fetch the error message and store in $errors array
	                  $errors=$validate->errors('errors');
                     }
		}
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	
	/**
	* Action for users Testimonials
	*/
	public function action_edit_testimonials()
	{
		$selected_page_title=__('manage_testimonials');
		$this->is_login();
		 $this->selected_page_title = __('my_testimonials');   
		$testimonialsid=$this->request->param('id');
		$mytestimonials_values=$this->users->select_mytestimonials($testimonialsid);
		$view=View::factory(THEME_FOLDER."testimonials_edit")
				->bind('errors',$errors)
				->bind('validator',$validate)
				->bind('mytestimonials_values',$mytestimonials_values)
				->bind('video_error',$video_error)
				->bind('form_values',$form_values);
		$form_values=Arr::extract($_POST, array('title','description','video'));
		$image=Arr::extract($_FILES, array('photo'));
		$data=Arr::merge($form_values,$image);
		$IMG_EXIST=$this->users->check_testimonialsphoto($testimonialsid);	
		$validate=$this->users->testimonials_validation($data);
		$submit=$this->request->post('edit_testimonials');
		if(isset($submit))
		{
		    if($mytestimonials_values[0]['images'] && $_POST["video"])
                        {
                                 Message::error(__('viedo_or_image_delete_image'));
                        }
                        else
                        {
		            if($validate->check())
		            {
			        $image_name=$_FILES['photo']['name'];
			        if($_POST["video"] && $image_name )
                                {
                                        Message::error(__('viedo_or_image'));
                                }
                                else
                                {
				         $url=$_POST["video"]; 
	                                 $check_url = explode('?',$url);
                                        if($check_url[0] != 'http://www.youtube.com/watch' && $url != '' && !isset($check_url[1])) 
			                { 
			                	$video_error=__('invalid_video_url');
				        }
				        else
				        {
				         //Uploading and saving image
				         $filename =Upload::save($_FILES['photo'],NULL,DOCROOT.TESTIMONIALS_IMGPATH, 0777);			
				                $IMG_NAME="";
				                if($_FILES['photo']['name'] !="")
				                {
					        //to get image name from array
					        $IMG_NAME= explode("/",$filename);
					        $IMG_NAME= end($IMG_NAME);
                                                $filenames =Upload::save($_FILES['photo'],$_FILES['photo']['name'],DOCROOT.TESTIMONIALS_IMGPATH, 0777);	
					      $image_factory=Image::factory($filename);
					        $path=DOCROOT.TESTIMONIALS_IMGPATH;
                                                
                                                
                                                
					        //$this->imageresize($image_factory,TESTIMONIALS_IMAGE_WIDTH,TESTIMONIALS_IMAGE_HEIGHT,$path,$IMG_NAME);			   
				                }
				
				                if($IMG_EXIST != '' && $image_name!= '')
                                                {
                                                        if(file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$IMG_EXIST))
                                                        {
                                                        unlink(DOCROOT.TESTIMONIALS_IMGPATH.$IMG_EXIST);
                                                        }
                                                }
								
				        $result=$this->users->update_video($testimonialsid,$_POST,$IMG_NAME);
				        if($result == 0){
                                            Message::error(__('Your_system_youtube_block'));
                                        }
                                        else
                                        {
                                        //Session set for success msg
				        Message::success(__('mytestimonials_successfully'));
				        $this->request->redirect("users/mytestimonials_details/");
				        $form_values=NULL;
				        }
				        
				        }
			        }
			       
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
	
	/**
	 * ****Testimonials****
	 * Auction Delete for Testimonials
	 */
        public function action_testimonials_delete()
	{
		//get current page segment id
		$testimonials_id = $this->request->param('id');	
		              
                $testimonials_delete= $this->users->check_testimonialsphoto($testimonials_id);
		if(file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_delete) && $testimonials_delete != '')
	            {
			  unlink(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_delete);
	            }
		//perform delete action
	        $status = $this->users->delete_testimonials($testimonials_id);
	   	//Flash message
		Message::success(__('testimonials_delete_flash'));
		//redirects to index page after deletion		
		$this->request->redirect("users/mytestimonials_details/");
	}
	
	/**
	 * ****Testimonials****
	 * Auction Delete for Testimonials Images
	 */
	public function action_delete_testimonialsphoto()
	{
		//get current page segment id
		$testimonials_id = $this->request->param('id');		
		//import model admin
		$admin = Model::factory('admin');              
                $testimonials_delete= $this->users->check_testimonialsphoto($testimonials_id);
                $testimonials_image= $this->users->delete_testimonialsimage($testimonials_id);
                
		if(file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_delete) && $testimonials_delete != '')
	            {
			 unlink(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_delete);
	            }
		//send data to view file
    	         $testimonials_data = $this->users->get_testimonials_data($testimonials_id);
		//Flash message
		Message::success(__('delete_testimonialsphoto_flash'));
		$this->request->redirect("users/edit_testimonials/".$testimonials_id);
	}
	
	/**
	* Action for Sign up Page
	*/
	public function action_signup()
	{
		$selected_page_title=__('menu_sign_up');	
	       $this->selected_page_title = __('menu_register');
		if($this->auction_userid!="")$this->url->redirect("users/");
		$captcha = Captcha::instance();	
		$activation_key = Commonfunction::admin_random_user_password_generator();
		$user_settings=Commonfunction::get_user_settings();
		$view=View::factory(THEME_FOLDER."signup")
				->bind('errors',$errors)
				->bind('captcha',$captcha)
				->bind('captcha_val',$captcha_val)
				->bind('form_values',$form_values)
				->bind('referrer_userid',$referrer_userid)
				->bind('referrer_name',$referrer_name);
		// To set captcha value to one if entered value is correct and if not , set to zero
		$captcha_val = isset($_POST["captcha"])?($captcha->valid($_POST["captcha"]) == 1?1:0):1;
		//check referrer id
		$referral= $this->session->get('referral_id');
		if(isset($referral)){
			$select_username_referrer=$this->commonmodel->select_with_onecondition(USERS,"referral_id='".$referral."'");
			if(count($select_username_referrer)>0){
			$referrer_userid=$select_username_referrer[0]['id'];
			$referrer_name=$select_username_referrer[0]['username'];
			$referrer_email=$select_username_referrer[0]['email'];
			}
		}
		
		$form_values=arr::extract($_POST, array('username','email','password','repassword','firstname','lastname','country','referred_id','newsletter','agree','lat','lng'));
		
		$validate=$this->users->signup_validation($form_values);
		$submit=$this->request->post('signup');
		if(isset($submit))
		{
			if($validate->check() && $captcha_val)
			{
				$password=($form_values['password']!=__('enter_password'))?$form_values['password']:"";

				$newsletter=($this->request->post('newsletter')=="1")?YES:NO;
				$lastname=($form_values['lastname']!=__('enter_lastname'))?$form_values['lastname']:"";
				$referred_id=isset($form_values['referred_id'])?$form_values['referred_id']:"";
				
				if(count($user_settings)>0){
					if(($user_settings[0]['admin_activation_reg']==NO && $user_settings[0]['email_verification_reg'] == YES) || ($user_settings[0]['admin_activation_reg']==YES && $user_settings[0]['email_verification_reg'] == NO) || ($user_settings[0]['admin_activation_reg']==YES && $user_settings[0]['email_verification_reg'] == YES))
					{
						$status=IN_ACTIVE;
					}
					else
					{
						$status=ACTIVE;
					}
				}
				else
				{ $status=IN_ACTIVE;}				
				//Commonfunction model for insert
				$insert=$this->commonmodel->insert(USERS,array('username'=>trim(strtolower(Html::chars($form_values['username']))),
									'email'=>$form_values['email'],
									'password' => md5($password),
									'firstname' =>trim($form_values['firstname']),
									'lastname' => trim($lastname),
									'country' => $form_values['country'],
									//'address' =>trim($form_values['address']),
									'newsletter' =>$newsletter,
									'referred_by'=>$referred_id,
									'status' =>$status,
									'activation_code' =>$activation_key,
									'referral_id'=> Text::random(),
									'created_date'=>$this->getCurrentTimeStamp,
									'latitude'=>$form_values['lat'],
									'longitude'=>$form_values['lng']));
			
				if($insert)
				{
					$signup_id=$insert[0];
					if($user_settings[0]['auto_login_reg']==YES)
					{
						$this->action_autologin($signup_id);
					}
					$mail="";
					//Insert bonus when referred by any user only when user invited thro facebook
					if(isset($form_values['referred_id']))
					{
						$select_old_user_bonus=$this->commonmodel->select_with_onecondition(USERS,'id='.$referred_id);
						$bonus_amount=count($select_old_user_bonus)>0?$select_old_user_bonus[0]['user_bonus']:0;
						$select_bonus=$this->commonmodel->select_with_onecondition(BONUS,'bonus_type_id='.FACEBOOK_INVITE);
						$signupamount=Commonfunction::get_bonus_amount(FACEBOOK_INVITE);
						$amount=$bonus_amount+$signupamount;
						if(Commonfunction::get_bonus_amount(FACEBOOK_INVITE) >0)
						{
							$this->users->add_user_bonus($amount,$referred_id,FACEBOOK_INVITE);

							//update on user table
							$old_balance=Commonfunction::get_user_bonus($referred_id);
							$c_balance=$signupamount+$old_balance;
							
							$this->commonmodel->update(USERS,array('user_bonus'=>$c_balance),'id',$referred_id);
							//User my message
							Commonfunction::custom_user_bonus_message(array('custom_msg'=>__('facebook_invite_signup',array(":param"=>$this->site_currency." ".Commonfunction::get_bonus_amount(FACEBOOK_INVITE),":param2"=>$form_values['username'])),'subject'=>__('facebook_invite_send_subject')),$referred_id);

						}
					}
					$site_name = $this->site_settings[0]['site_name'];
					$activation_link = "<a href= ".URL_BASE.USERACTIVATION."?id=".$signup_id."&key=".$activation_key." >$site_name</a>";
					$this->username = array(USERNAME => $form_values["username"],USEDTOLOGIN => $_POST['username'],PASSWORD => $form_values["password"],TO_MAIL => $form_values['email'],ACTIVATION_URL => $activation_link);
					
					$this->replace_variable = array_merge($this->replace_variables,$this->username);			   								
					//checking settings for email sending option whether checked or not
					//activation request mail and welcome mail  will send only if email_verification_reg = "YES"  
					 if(($user_settings[0]['email_verification_reg'] == YES) && ($user_settings[0]['admin_activation_reg'] == NO))	
					{  
												   
					 //send mail to user by defining common function variables from here
						 
						$mail = Commonfunction::get_email_template_details(ACTIVATION_REQUEST, $this->replace_variable,SEND_MAIL_TRUE);
					}
					else if(($user_settings[0]['email_verification_reg'] == YES) && ($user_settings[0]['admin_activation_reg'] == YES))
					{
						$mail = Commonfunction::get_email_template_details(ACTIVATION_REQUEST, $this->replace_variable,SEND_MAIL_TRUE);
					}

					if($user_settings[0]['welcome_mail_reg'] == YES){  
										
						$this->username = array(USERNAME => $form_values["username"],USEDTOLOGIN => $_POST['username'],PASSWORD => $form_values["password"],TO_MAIL => $form_values['email']);
					   	$this->replace_variable = array_merge($this->replace_variables,$this->username); 
						//send mail to user by defining common function variables from here               
					   	$mail = Commonfunction::get_email_template_details(NEW_USER_JOIN, $this->replace_variable,SEND_MAIL_TRUE);
					   	//send mail to user by defining common function variables from here               
						$mail = Commonfunction::get_email_template_details(WELCOME_EMAIL, $this->replace_variable,SEND_MAIL_TRUE);				
			   		}
					if($user_settings[0]['admin_notification_reg'] == YES)
					{	
						//merging all send details with common function replace variables				
						$this->admin = array(TO_MAIL => TO_ADMIN_MAIL,USERNAME => $_POST["username"],USEDTOLOGIN => $_POST['username'],PASSWORD => $form_values["password"]);
						$this->replace_variable = array_merge($this->replace_variables,$this->admin); 										
						//send mail to admin for new user registration
						$mail = Commonfunction::get_email_template_details(NEW_USER_JOIN, $this->replace_variable,SEND_MAIL_TRUE);		
					}
					//showing msg for mail sent or not in flash
				  	if($mail == MAIL_SUCCESS)
				   	{
				   		Message::success(__('registration_success_msg'));	
				   	}
					else
					{
				   		Message::success(__('registration_success_msg'));		
			
				   	}
				$form_values=NULL;
				//Redirects to users login
				$this->url->redirect('users/login');
			}
			}
			else
			{
				//Fetch the error message and store in $errors array
				
				$errors=$validate->errors('errors');
				
				//print_r($errors);exit;
			}
		}
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	//function for sending activation email with activation url	
	public function action_activation()
	{
		$user_id = arr::get($_REQUEST,'id');
		$activation_key = arr::get($_REQUEST,'key');

		//check whether userid and activation key exist or not
		$check_details = $this->users->check_userdetails_exist($user_id,$activation_key);	
		if(count($check_details) > 0 )
		{
     			//check for second click of activation url means show already activated 
		        if($check_details[0]['activation_code_status'] == 1)
			{
		        		Message::success(__('already_activated_account'));

				 	//page redirection after success
				  	$this->url->redirect("users/login");	
		        }
			//admin side user settings value retrieved here
			$user_settings = Commonfunction::get_user_settings();
			//if user clicks activation url only user set as active
			$user_status_active = $this->users->set_user_status_active($user_id,$activation_key,$user_settings);

			//settings for admin activation enabled
			if(($user_settings[0]['email_verification_reg'] == YES) && ($user_settings[0]['admin_activation_reg'] == YES))
			{
				Message::success(__('admin_should_activate_account'));
				//page redirection after success
			  	$this->url->redirect("users/login");			
			}
	
			//settings for activted status "yes" and succesful registration			
			if(($user_status_active[0]['status'] == ACTIVE) && ($user_status_active[0]['activation_code_status'] == ACTIVATION_CODE_STATUS))
			{		
				Message::success(__('successfully_activated_account'));
			 	//page redirection after success
			  	$this->url->redirect("users/login");	
			}
		}
		else
		{
			Message::error(__('invalid_activation_request'));
		 	//page redirection after success
		  	$this->url->redirect("users/signup");
		}	
		$this->template->content="";
		$this->template->title="";
		$this->template->meta_description="";
		$this->template->meta_keywords="";	
	}

	public function action_autologin($user_id)
       {
		$result=$this->commonmodel->select_with_onecondition(USERS,'id='.$user_id);
		if(count($result)>0)
		{ 
			if($result[0]['status'] == ACTIVE)
			{
				$login_time = $this->getCurrentTimeStamp;

				//Insert login details in user login details table	
				$result_login = $this->commonmodel->insert(USER_LOGIN_DETAILS, array('userid'=>$result["0"]["id"],'login_ip'=>Request::$client_ip,'user_agent'=>Request::$user_agent,'last_login'=>$this->getCurrentTimeStamp));
				
				//Set userid into the session auction_userid
				$this->session->set('auction_userid',$result[0]['id']);
				//Set username into the session username
				$this->session->set('auction_username',$result[0]['username']);
				//Set usertype into the auction usertype
				$this->session->set('user_type',$result[0]['usertype']);
				//Set usertype into the auction email
				$this->session->set('auction_email',$result[0]['email']);
				Message::success(__("logged_in_successfully"));
				//Redirects after login is succeeded
				$this->url->redirect("users/");
			}
			else
			{
				Message::error(__("user_blocked"));
				$this->url->redirect("users/login");
			}
		}
	}
	
	/**
	* Action for Users Login function
	**/
	public function action_login()
	{

		$selected_page_title=__('menu_login');

	        $this->selected_page_title = __('menu_login');

		if($this->auction_userid!="")$this->url->redirect("users/");
		//Logout msg display
		$request=$this->request->param('id');
		if(isset($request))
		{
			Message::success(__('you_are_logged_out'));
			$this->session->destroy();
			$this->url->redirect("users/login");
		}

                        /**To get warning message from session if login failed **/
                        $status_login=$this->session->get_once('login_access');
                        /**To display success msg from session for mail deletion **/
                        if(isset($status_login)){
                        $this->failure_msg= __('login_access');
                        $this->session->delete('login_access');
                }
		$redirect = Arr::get($_GET,'redirect');
		
		$view=View::factory(THEME_FOLDER."login")
				->bind('errors',$errors)
				->bind('values',$form_values);
		//Extract the values from the array
		$form_values=arr::extract($_POST, array('username','password','remember'));

		//Check the validation rules for the post values in array
		$validate=$this->users->login_validation($form_values);
		
		$submit=$this->request->post('login');
		if(isset($submit)){	
				
			if($validate->check()){
			
			         
				$username = trim(Html::chars($form_values['username']));
				$password = Html::chars(md5($form_values['password']));
			
				//Login function which return true or false after checking
			$login=$this->commonmodel->login(USERS,array("username"=>$username,"password"=>$password,"usertype"=>NORMAL),$form_values['remember']);
				if($login)
				{
				
					$result=$this->commonmodel->selectwhere(USERS,array("username"=>$username,"password"=>$password));
					if($result[0]['status'] == ACTIVE)
					{
						if($form_values['remember']=="1")
						{						
						  $user_id=$result[0]['id'];
						  Cookie::$salt='auction_userid';
						  $cookie=Cookie::set('auction_userid',$user_id,84600);
						}
						
						$login_time = $this->getCurrentTimeStamp;

                				//Insert login details in user login details table	
						$result_login = $this->commonmodel->insert(USER_LOGIN_DETAILS, array('userid'=>$result["0"]["id"],'login_ip'=>Request::$client_ip,'user_agent'=>Request::$user_agent,'last_login'=>$this->getCurrentTimeStamp));
						
						//Set userid into the session auction_userid
						$this->session->set('auction_userid',$result[0]['id']);
						
						if($result[0]['referral_id']=="")
						{
							$this->commonmodel->update(USERS,array('referral_id'=>Text::random()),'id',$result[0]['id']);
						}
						//Set username into the session username
						$this->session->set('auction_username',$result[0]['username']);

						//Set usertype into the auction usertype
						$this->session->set('user_type',$result[0]['usertype']);

						//Set usertype into the auction email
						$this->session->set('auction_email',$result[0]['email']);

						Message::success(__("logged_in_successfully"));
						 if($redirect!="")
						{
						    $this->url->redirect(urldecode($redirect));
						}
						 $redirecturi=$this->session->get('usercurrent_uri');
						  
						 $this->session->delete('usercurrent_uri');
						 if($redirecturi!="")
						{
						  $this->url->redirect($redirecturi);
						}	
						//Redirects after login is succeeded
						$this->url->redirect("users/");
					}
					else
					{
						//store msg in success_msg declared in Website controller constructor
						Message::error(__("user_blocked"));
					}
				}
				else
				{
				       
					
					Message::error(__("credential_failed"));
					
					$form_values=NULL;
				}
			}
			else
			{
				
				//prints the error
				$errors = $validate->errors('errors');
			}
		
		}
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
		
	}

	/**
	* Send email to user if user entered email exists in our database. This function 
	* generates a random key and sends to user mail for temporary login. 
	* 
	* Common function module is used to send email.
	**/
	public function action_forgot_password()
	{
		/**To Set Errors Null to avoid error if not set in view**/              
		$errors = array();
		if($this->auction_userid!="")$this->url->redirect("users/");
		$view=View::factory(THEME_FOLDER.'forgot_password')
				->bind('validator', $validator)
				->bind('errors', $errors)
				->bind('email_error',$email_error);
		/*To get selected language at user side*/
		$lang_select =arr::get($_REQUEST,'language');
		/**To generate random key if user enter email at forgot password**/
		$random_key = text::random($type = 'alnum', $length = 7);
		 /**To get the form submit button name**/
		$forgot_pwd_submit =arr::get($_REQUEST,'submit_forgot_password'); 
		if ($forgot_pwd_submit && Validation::factory($_POST) ) 
		{
			$validator = $this->users->validate_forgotpwd(arr::extract($_POST,array('email')));
			if ($validator->check()) 
			{
				$result=$this->users->forgot_password($validator,$_POST,$random_key);
				if(isset($result))
				{ 	
					$this->username = array(USERNAME => $result[0]["username"],TO_MAIL => $result[0]["email"],NEW_PASSWORD => $random_key);
					
				   	$this->replace_variable = array_merge($this->replace_variables,$this->username); 
					//send mail to user by defining common function variables from here               
				   	$mail = Commonfunction::get_email_template_details(FORGOT_PASSWORD, $this->replace_variable,SEND_MAIL_TRUE);
				   	//showing msg for mail sent or not in flash
				  	if($mail == MAIL_SUCCESS)
				   	{
				   		Message::success(__('email_succesfull_msg'));		
				   	}
					else
					{
				   		Message::success(__('email_unsuccesfull_msg'));		
			
				   	}								
					Message::success( __('sucessful_forgot_password'));	
					$this->url->redirect("/");
				}	
				else
				{
					//store msg in failure_msg declared in Website controller constructor
					Message::error(__('failed_forgot_password'));
				}
				$validator = null;
			}
			else 
			{
				//validation failed, get errors
				$errors = $validator->errors('errors');
			}
		}
		$this->template->content = $view;
                $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	/** Logout action **/
	public function action_logout()
	{	
		if($this->auction_userid)
		{
			$this->commonmodel->delete_useronline(USERS_ONLINE,'userid',$this->auction_userid);
		}
		$this->template->title="";
		$this->session->destroy();
		Cookie::delete('auction_userid');		
		$this->url->redirect("users/login/loggedout");		
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	/** FACEBOOK CONNECT **/	
	public function action_facebook()
	{
		$fb_settings=Commonfunction::get_facebook_settings();
		if($fb_settings[0]['facebook_login']==NO)
		{
			Message::error(__('facebook_connect_is_disbled'));
			$this->url->redirect('users/signup');
		}
		$fb_access_token = $this->session->get("fb_access_token");
		$redirect_url =URL_BASE."users/facebook/";
		if(!$fb_access_token && !$this->session->get('auction_userid'))
		{
			if(strpos($_SERVER["REQUEST_URI"],"code"))
			{
                                
				if(isset($_GET["code"])){
					$CODE = $_GET["code"];
				}else{
					$this->request->redirect('users/');
				}
				
				$token_url = "https://graph.facebook.com/oauth/access_token?client_id=".FB_APP_ID."&redirect_uri=". urlencode($redirect_url)."&client_secret=".FB_APP_SECRET."&code=".$CODE.'&display=popup';
				$access_token = $this->curl_function($token_url);			
				$FBtoken = str_replace("access_token=","", $access_token);
				$FBtoken = explode("&expires=", $FBtoken);		
				if(isset($FBtoken[0]))
				{
					$profile_data_url = "https://graph.facebook.com/me?access_token=".$FBtoken[0];
					$Profile_data = json_decode($this->curl_function($profile_data_url));
					$user_name=$Profile_data->first_name;
					$username = Html::chars($user_name);	
	                                $random_no1 = Commonfunction::randomkey_generator(4);
		                        /**Checking if username minimum length is 4 , if not append 4 digit random number**/
		                        $username=(strlen($username)>4)?$username:$username.'_'.$random_no1;
		                        $userlogin_name=strtolower($username);
					
					if(isset($Profile_data->error))
					{
						echo "Problem in Facebook Connect! Try again later."; exit;
					}
					else
					{
						$password = Commonfunction::randomkey_generator();
						
						$status = $this->users->register_facebook_user($Profile_data,$password, $FBtoken[0],$userlogin_name);
						if($status==1)
						{
							$this->username = array(TO_MAIL => $Profile_data->email, USERNAME => $userlogin_name, PASSWORD => $password);
							$this->replace_variable = array_merge($this->replace_variables,$this->username);
									
					   		//send mail to user by defining common function variables from here
							$mail = Commonfunction::get_email_template_details(FACEBOOK_PASSWORD,$this->replace_variable,SEND_MAIL_TRUE);
							if($mail == MAIL_SUCCESS)
				   			{
				   				Message::success(__('fconnect_success_msg'));
								$this->request->redirect('users/');		
				   			}
							else
							{	
								Message::success(__("logged_in_successfully"));
								$this->request->redirect('users/');
							}
							
						exit;
						}
						else
						{
							
							Message::success(__("logged_in_successfully"));
							$this->request->redirect('users/');
						}
					}		
				}
				else
				{
					echo "Problem in Facebook Connect! Try again later."; exit;
				}
				?><script>window.close();</script>
			<?php 
			}
			else
			{	
				$this->request->redirect("https://www.facebook.com/dialog/oauth?client_id=".FB_APP_ID."&redirect_uri=".urlencode($redirect_url)."&scope=email,read_stream,publish_stream,offline_access&display=popup");
				die();	
			}
		}
		else
		{
			?><script>window.close();</script><?php exit;
		}
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
		exit;
	}
	
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
		
		if($type == "POST")
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $arguments);
		}
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}
	
	/**
	* Image resize function
	**/
	 public function imageresize($image_factory,$width,$height,$path,$image_name,$quality=90)
        {
		if ($image_factory->height < $height || $image_factory->width < $width ) 
		{ 
			$image = $image_factory->save($path.$image_name,90);
			return  $image;  
		} 
		else 
		{ 
			$image_factory->resize($width, $height, Image::INVERSE); 
			$image_factory->crop($width, $height);                     
			$image= $image_factory->save($path.$image_name,90); 
			return  $image; 
		}
        }
	
	/**
	* Action for user settings
	*/
	public function action_user_settings(){
		$selected_page_title=__('menu_edit_profile');
	
	       //Check Whether the user is logged in
		$this->is_login(); 
		 $this->selected_page_title = __('menu_edit_profile');
		//To get current logged user id from session
		$userid =$this->session->get('auction_userid');
		//get user details
		$user = $this->commonmodel->select_with_onecondition(USERS,'id='.$userid);		
		$view= View::factory(THEME_FOLDER.'user_settings')
					->bind('validator', $validator)
					->bind('validator_changepass', $validator_changepass)				
					->bind('errors', $errors)
					->bind('data',$form_values)
					->bind('users',$user)					
					->bind('user_exists', $user_exists);
		//To get selected language at user side
		$lang_select =arr::get($_REQUEST,'language');
		$submit_profile =arr::get($_POST,'submit_user_profile');
		$submit_user =arr::get($_REQUEST,'submit_user');
		if(isset($submit_user))
		{
			$this->request->redirect("users/user_settings/");
		}
		//To check if user photo existing in database		
		$image_name=$this->users->check_photo($userid);
	
		$_POST= Arr::map('trim', $this->request->post());
		
		if ($submit_profile) 
		{ 
			$image=Arr::extract($_FILES,array('photo'));
			$form_values=Arr::extract($_POST,array('firstname','lastname','aboutme','country','address','address1','lat','lng'));
			//print_r($form_values);exit;
			$data=Arr::merge($image,$form_values);			 
			//Send entered values to model for validation      
			$validator = $this->users->validate_user_settings($data);
			if ($validator->check()) 
			{
				//To get current logged user id from session
				$userid =$this->session->get('auction_userid');
				 //Uploading and saving image
				 $filename =Upload::save($_FILES['photo'],NULL,DOCROOT.USER_IMGPATH, '0777');
				$IMG_NAME="";
				if($_FILES['photo']['name'] !="")
				{
					//to get image name from array
					$IMG_NAME= explode("/",$filename);
					$IMG_NAME= end($IMG_NAME);
					$image_factory=Image::factory($filename);
					$path=DOCROOT.USER_IMGPATH;
					$this->imageresize($image_factory,USER_SMALL_IMAGE_WIDTH,USER_SMALL_IMAGE_HEIGHT,$path,$IMG_NAME);			   
					$image_factory2=Image::factory($filename);
					$path2=DOCROOT.USER_IMGPATH_THUMB;
					$this->imageresize($image_factory2,USER_SMALL_IMAGE_WIDTH_20x20,USER_SMALL_IMAGE_HEIGHT_20x20,$path2,$IMG_NAME);			   
				}
				//check If image exists in database and image not empty if exists unlink when update other image
				if($IMG_NAME != '' && $image_name!= '')
				{
					if(file_exists(DOCROOT.USER_IMGPATH.$image_name))
					{
				         	unlink(DOCROOT.USER_IMGPATH.$image_name);
						unlink(DOCROOT.USER_IMGPATH_THUMB.$image_name);
					}
			        }
				$result=$this->users->update_user_settings($validator, $_POST,$userid,$IMG_NAME);
				Message::success( __('sucessful_change_password'));
				$fail= __('fail_update');
				if($result == 1)
				{					
					//$this->success_msg = Message::success(__('success_update'));
					 Message::success( __('user_success_update'));
					 $this->url->redirect("users/user_settings");					
				}	
				else
				{
					echo $fail;
				}
				$validator = null;
				$validator_changepass = null;
			}
			else 
			{
			//validation failed, get errors
			$errors = $validator->errors('errors'); 
			}
		}		
		$this->template->content = $view;
                $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;

	}
	
	/**
	* To delete user photo from user profile
	*/
	public function action_delete_userphoto()
	{
		//auth login check
		$this->is_login(); 
		//get current logged user id 
		$userid =$this->session->get('auction_userid');
		//To check if user photo existing in database
		$image_name=$this->users->check_photo($userid);
		
		//If user photo exists unlink image from the folder
		if(file_exists(DOCROOT.USER_IMGPATH.$image_name) && $image_name != '')
	        {				
			unlink(DOCROOT.USER_IMGPATH.$image_name);
			unlink(DOCROOT.USER_IMGPATH_THUMB.$image_name);
	        }
		//To update user photo null after deleteing user photo
        	$status = $this->users->update_user_photo($userid);
		//To set session message for display success message
                Message::success( __('delete_userphoto_flash'));
		//Flash message 			
		$this->request->redirect("users/user_settings/");
	}
	
	/**
	* User profile change password
	*/
	public function action_change_password()
	{
		/*To set errors in array if errors not set*/
		$errors = array();
		$this->selected_page_title = __('menu_change_password');
		/*checks if user logged or not*/
		$this->is_login();
		$view=View::factory(THEME_FOLDER.'change_password')
				->bind('validator', $validator)
				->bind('validator_changepass', $validator_changepass)
				->bind('oldpass_error',$oldpass_error)
				->bind('errors', $errors)
				->bind('category',$job_category)
				->bind('email_exists', $email_exists)
				->bind('user_exists', $user_exists)
				->bind('category_selected',$category_name)
				->bind('suggestions',$suggestions)
				->bind('users', $user);
		/*To get selected language at user side*/
		$lang_select =arr::get($_REQUEST,'language');
		$submit_change_pass =arr::get($_REQUEST,'submit_change_pass');
		$submit_user =arr::get($_REQUEST,'submit_user');
		if(isset($submit_user))
		{
		$this->request->redirect("users/change_password/");
		}
		$userid =$this->session->get('auction_userid');
		if ($submit_change_pass ) 
		{
			$userid =$this->session->get('auction_userid');
			$validator_changepass = $this->users->validate_changepwd(arr::extract($_POST,array('old_password','new_password','confirm_password')));
			if ($validator_changepass->check()) 
			{
				$result = $this->users->change_password($validator_changepass,$_POST,$userid);
				$select_user=$this->commonmodel->select_with_onecondition(USERS,'id='.$userid);
				if($result == 1)
				{
					Message::success(__('sucessful_change_password'));
					$this->username = array(TO_MAIL => $select_user[0]['email'], USERNAME => $select_user[0]['username'], PASSWORD => $_POST['new_password']);
					$this->replace_variable = array_merge($this->replace_variables,$this->username);
									
				   	//send mail to user by defining common function variables from here               
				   	$mail = Commonfunction::get_email_template_details(USER_CHANGE_PASSWORD,$this->replace_variable,SEND_MAIL_TRUE);	
					if($mail == MAIL_SUCCESS)
					{
						Message::success(__('email_succesfull_msg'));		
					}
					else
					{
						Message::success(__('email_unsuccesfull_msg'));		
					}					
	
					//admin side user settings value retrieved here
				
					$result = $this->settings_user->get_all_settings_user();
					//if logout after change password option is selected means
					if($result[0]['logout_change_pass'] == YES)
					{
						//Message::success(__('sucessful_change_password'));	
						$this->session->delete('auction_userid','username','usertype');
						Cookie::delete('auction_userid');
						Message::success(__('sucessful_change_password'));
						$this->url->redirect("users/login");	
						//$this->action_logout();
						
					}
					else
					{
						Message::success(__('sucessful_change_password'));	
						$this->url->redirect("users/");
					}	
				}	
				else
				{
					echo __("fail_change_password");
				}
				$validator_changepass = null;
				$email_exists="";
				$user_exists="";
				
			}					
			else 
			{
				//validation failed, get errors
				$errors = $validator_changepass->errors('errors');
			}
		}
		//get user details
		$user = $this->commonmodel->select_with_onecondition(USERS,'id='.$userid);
		$validator=$validator[0];
		$this->template->content = $view;
                $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	public function action_message_close()
	{
		$request=$this->request->param('id');
		if(isset($request))
		{
			$this->commonmodel->update(USER_MESSAGE,array('status'=>1),'usermessage_id',$request);
		}
		exit;
	}
	
	/**
	* Action for add shipping addressess
	**/
	public function action_myaddresses()
	{
		$selected_page_title=__('menu_my_addresses');
		$this->is_login();
		$request=$this->request->param('id');
		$request2=$this->request->param('method');
		$userid=!$this->auction_userid;
		$select_address=$this->commonmodel->select_with_onecondition(SHIPPING_ADDRESS,"userid=".$this->auction_userid,TRUE);
		$select_billingaddress=$this->commonmodel->select_with_onecondition(BILLING_ADDRESS,"userid=".$this->auction_userid,TRUE);
		$this->selected_page_title = __('menu_my_addresses');	


		switch($request)
		{
			//When shipping
			case "shipping":				
				switch($request2)
				{
					case "add":
						$this->selected_page_title = __('menu_add_shipping');
						if($select_address>0){$this->url->redirect("users/myaddresses/shipping/edit");}
						$view=View::factory(THEME_FOLDER.'addshippingaddress')	
									->bind('form_values',$form_values)
									->bind('errors',$error);
						$form_values=Arr::extract($_POST,array('name','address1','address2','town','city','country','zipcode','phone'));
						$validate=$this->users->shipping_validation($form_values);
						$submit=$this->request->post('addaddress');
						if(isset($submit))
						{
							if($validate->check())
							{

								$address=($form_values['address2']!=__('enter_address2'))?$form_values['address1']." + ".$form_values['address2']:$form_values['address1'];

								$town=($form_values['town']!=__('enter_town'))?$form_values['town']:"";
								$phone=($form_values['phone']!=__('enter_phone'))?$form_values['phone']:"";
								//update query from commonfunction in model folder
								$insert=$this->commonmodel->insert(SHIPPING_ADDRESS,array('userid' => $this->auction_userid,
										'name' =>$form_values['name'],
										'address' => Html::chars($address),
										'city' => $form_values['city'],
										'country' => $form_values['country'],
										'town' => $town,
										'zipcode' => $form_values['zipcode'],
										'phoneno' => $phone,
										'createddate' => $this->getCurrentTimeStamp));
								if($insert)
								{
									$form_values=NULL;
									Message::success(__('shipping_added_successfully'));	
									$this->url->redirect("users/myaddresses");
								}
							}
							else
							{
								$error=$validate->errors('errors');
							}
						}				
						break;

					//When edit
					case "edit";
						 $this->selected_page_title = __('menu_edit_shipping');
						if($select_address<=0){$this->url->redirect("users/myaddresses/shipping/add");}
						$view=View::factory(THEME_FOLDER.'editshippingaddress')	
									->bind('form_values',$form_values)
									->bind('errors',$error)
									->bind('db_values',$db_values);
						$form_values=Arr::extract($_POST,array('name','address1','address2','town','city','country','zipcode','phone'));
						$validate=$this->users->shipping_validation($form_values);
						$submit=$this->request->post('editaddress');
						$db_values=$this->commonmodel->select_with_onecondition(SHIPPING_ADDRESS,"userid=".$this->auction_userid)->as_array();
			
						if(isset($submit))
						{
							if($validate->check())
							{
								$address=($form_values['address2']!=__('enter_address2'))?$form_values['address1']." + ".$form_values['address2']:$form_values['address1'];

								$town=($form_values['town']!=__('enter_town'))?$form_values['town']:"";
								$phone=($form_values['phone']!=__('enter_phone'))?$form_values['phone']:"";
							

								//update query from commonfunction in model folder
								$insert=$this->commonmodel->update(SHIPPING_ADDRESS,array('userid' => $this->auction_userid,
												'name' =>$form_values['name'],
												'address' => Html::chars($address),
												'city' => $form_values['city'],
												'country' => $form_values['country'],
												'town' => $town,
												'zipcode' => $form_values['zipcode'],
												'phoneno' => $phone,
												'updatedate' => $this->getCurrentTimeStamp),'userid',$this->auction_userid);
								if($insert)
								{
									$form_values=NULL;
									Message::success(__('shipping_edit_successfully'));
									$this->url->redirect("users/myaddresses");
								}
							}
							else
							{
								$error=$validate->errors('errors');
							}
						}
						break;

					//Default view to be myaddresses
					default:
						$view=View::factory(THEME_FOLDER.'addresses')
								->bind('select_shipping_address',$select_shipping_address)
								->bind('count_shipping',$count_shipping)
								->bind('select_billing_address',$select_billing_address)
								->bind('count_billing',$count_billing);
						$userid=$this->auction_userid;
						$select_shipping_address=$this->users->select_shipping_address($userid);
						$count_shipping=$this->users->select_shipping_address($userid,TRUE);
						$select_billing_address=$this->users->select_billing_address($userid);
						$count_billing=$this->users->select_billing_address($userid,TRUE);
						break;
				}
				break;

			//When billing
			case "billing":
				switch($request2)
				{
					case "add":
						 $this->selected_page_title = __('menu_add_billing');
						if($select_billingaddress>0){$this->url->redirect("users/myaddresses/billing/edit");}
						$view=View::factory(THEME_FOLDER.'addbillingaddress')	
									->bind('form_values',$form_values)
									->bind('errors',$error);
						$form_values=Arr::extract($_POST,array('name','address1','address2','town','city','country','zipcode','phone'));
						$validate=$this->users->shipping_validation($form_values);
						$submit=$this->request->post('addaddress');
						if(isset($submit))
						{
							if($validate->check())
							{
								$address=($form_values['address2']!=__('enter_address2'))?$form_values['address1']." + ".$form_values['address2']:$form_values['address1'];

								$town=($form_values['town']!=__('enter_town'))?$form_values['town']:"";
								$phone=($form_values['phone']!=__('enter_phone'))?$form_values['phone']:"";
								//update query from commonfunction in model folder
								$insert=$this->commonmodel->insert(BILLING_ADDRESS,array('userid' => $this->auction_userid,
										'name' =>$form_values['name'],
										'address' => Html::chars($address),
										'city' => $form_values['city'],
										'country' => $form_values['country'],
										'town' => $town,
										'zipcode' => $form_values['zipcode'],
										'phoneno' => $phone,
										'createddate' => $this->getCurrentTimeStamp));
								if($insert)
								{
									$form_values=NULL;
									Message::success(__('billing_added_successfully'));
									$this->url->redirect("users/myaddresses");
								}
							}
							else
							{
								$error=$validate->errors('errors');
							}
						}				
						break;

					//When edit
					case "edit";
						  $this->selected_page_title = __('menu_edit_billing');
						if($select_billingaddress<=0){$this->url->redirect("users/myaddresses/billing/add");}
						$view=View::factory(THEME_FOLDER.'editbillingaddress')	
									->bind('form_values',$form_values)
									->bind('errors',$error)
									->bind('db_values',$db_values);
						$form_values=Arr::extract($_POST,array('name','address1','address2','town','city','country','zipcode','phone'));
						$validate=$this->users->shipping_validation($form_values);
						$submit=$this->request->post('editaddress');
						$db_values=$this->commonmodel->select_with_onecondition(BILLING_ADDRESS,"userid=".$this->auction_userid)->as_array();
			
						if(isset($submit))
						{
							if($validate->check())
							{
								$address=($form_values['address2']!=__('enter_address2'))?$form_values['address1']." + ".$form_values['address2']:$form_values['address1'];

								$town=($form_values['town']!=__('enter_town'))?$form_values['town']:"";
								$phone=($form_values['phone']!=__('enter_phone'))?$form_values['phone']:"";

								//update query from commonfunction in model folder
								$insert=$this->commonmodel->update(BILLING_ADDRESS,array('userid' => $this->auction_userid,
												'name' =>$form_values['name'],
												'address' =>Html::chars($address),
												'city' => $form_values['city'],
												'country' => $form_values['country'],
												'town' => $town,
												'zipcode' => $form_values['zipcode'],
												'phoneno' => $phone,
												'updatedate' => $this->getCurrentTimeStamp),'userid',$this->auction_userid);
								if($insert)
								{
									$form_values=NULL;
									Message::success(__('billing_edit_successfully'));
									$this->url->redirect("users/myaddresses");
								}
							}
							else
							{
								$error=$validate->errors('errors');
							}
						}
						break;

					//Default view to be myaddresses
					default:
						$view=View::factory(THEME_FOLDER.'addresses')
								->bind('select_shipping_address',$select_shipping_address)
								->bind('count_shipping',$count_shipping)
								->bind('select_billing_address',$select_billing_address)
								->bind('count_billing',$count_billing);
						$userid=$this->auction_userid;
						$select_shipping_address=$this->users->select_shipping_address($userid);
						$count_shipping=$this->users->select_shipping_address($userid,TRUE);
						$select_billing_address=$this->users->select_billing_address($userid);
						$count_billing=$this->users->select_billing_address($userid,TRUE);	
						break;
				}
				break;

			//Default view to be myaddresses
			default:
				$view=View::factory(THEME_FOLDER.'addresses')
								->bind('select_shipping_address',$select_shipping_address)
								->bind('count_shipping',$count_shipping)
								->bind('select_billing_address',$select_billing_address)
								->bind('count_billing',$count_billing);
						$userid=$this->auction_userid;
						$select_shipping_address=$this->users->select_shipping_address($userid);
						$count_shipping=$this->users->select_shipping_address($userid,TRUE);	
						$select_billing_address=$this->users->select_billing_address($userid);
						$count_billing=$this->users->select_billing_address($userid,TRUE);	
				break;
			
		}
		
		$this->template->content = $view;
                $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
        /*My Bids
        *Bid History
         */
	public function action_mybids()
	{ 
		$selected_page_title=__('menu_mybids');
		$this->is_login();
		$this->selected_page_title = __('menu_mybids');
		$view=View::factory(THEME_FOLDER.'mybids')
				->bind('bidhistories',$bidhistory)
				->bind('count_bidhistory',$count_bidhistory)
				->bind('total_count',$total_count)
				->bind('pagination',$pagination);
		
		$count_bidhistory=$this->users->select_bids_for_users(NULL,REC_PER_PAGE,$this->auction_userid,TRUE);
		//pagination loads here
			$page=Arr::get($_GET,'page');
			if($page<0)
			{
				$this->url->redirect('users/mybids');
			}
			$page_no= isset($page)?$page:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_bidhistory,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
		$bidhistory=$this->users->select_bids_for_users($offset,REC_PER_PAGE,$this->auction_userid);	
		$this->template->content = $view;
	        $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	public function action_mytransactions()
	{
		$selected_page_title=__('menu_my_transactions');
		$this->is_login();
		 $this->selected_page_title = __('menu_my_transactions');
		$view=View::factory(THEME_FOLDER.'mytransactions')
				->bind('transactions',$transactions)
				->bind('count_transaction',$count_transactions)
				->bind('pagination',$pagination);
		$count_transactions=$this->users->select_transactions_history(NULL,REC_PER_PAGE,$this->auction_userid,TRUE);
		//pagination loads here
			$page=Arr::get($_GET,'page');
			$page_no= isset($page)?$page:0;
                        if($page_no==0 || $page_no=='index')
                        $page_no = PAGE_NO;
                        $offset = REC_PER_PAGE*($page_no-PAGE_NO);
                        $pagination = Pagination::factory(array (
                        'current_page' => array('source' => 'query_string', 'key' => 'page'),
                        'total_items'    => $count_transactions,  //total items available
                        'items_per_page'  => REC_PER_PAGE,  //total items per page
                        'view' => PAGINATION_FOLDER,  //pagination style
                        'auto_hide'      => TRUE,
                        'first_page_in_url' => TRUE,
                        ));   
		$transactions=$this->users->select_transactions_history($offset,REC_PER_PAGE,$this->auction_userid);
		$this->template->content = $view;
	        $this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}
	
	/**
	* Action for sitemap Page
	*/
	public function action_sitemap()
	{
		$view=View::factory(THEME_FOLDER."sitemap");
		$this->template->content=$view;
		$this->template->title=$this->title;
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;
	}

	
		
	
}//End of users controller class
?>
