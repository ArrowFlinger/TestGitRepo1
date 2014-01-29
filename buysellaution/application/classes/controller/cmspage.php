<?php defined('SYSPATH') OR die('No Direct Script Access');
/**
 * Contains User controller actions
 *
* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

Class Controller_Cmspage extends Controller_Website {

	/**
	* ****__construct()****
	*
	* setting up future and closed result query (For righthand side view)
	*/
	public function __construct(Request $request,Response $response)
	{
		parent::__construct($request,$response);
		$this->session=Session::instance();
		$this->commonmodel=Model::factory('commonfunctions');
		if(preg_match('/cmspage\/page/i',Request::detect_uri())   )
		{
			//Override the template variable decalred in website controller
                        $this->template=THEME_FOLDER."template_sidebar";
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
		
	}

	/**To get CMS  Page **/	
	public function action_page()
	{
                $cmsid = $this->request->param('id');
                $this->selected_page_title=ucfirst($cmsid);
		$view= View::factory(THEME_FOLDER.'showpage')
				->bind('all_cmspage',$all_cmspage);
		
		//For facebook invite bonus add
		$get=Arr::extract($_GET,array('source','uid','type'));
		if($get['source']=="facebookinvite")
		{
			FB::instance()->auth();
	 		$friend_id=FB::instance()->me();
			if(count($get)>0)
			{
				$userid=$this->cms->get_user_id($get['uid']);
				if(count($userid)>0){
					if($this->cms->check_bonus_type($userid[0]['id'],$get['type'],$friend_id)==1)
					{
						$bonus_amt=Commonfunction::get_current_bonus($userid[0]['id']) + Commonfunction::get_bonus_amount(FACEBOOK_INVITE);
						if(Commonfunction::get_bonus_amount(FACEBOOK_INVITE) >0)
						{
							$this->commonmodel->insert(USER_BONUS,array('bonus_type'=>$get['type'],'bonus_amount' =>$bonus_amt,'userid'=>$userid[0]['id'],'friend_ids'=>$friend_id['id'].","));
			
							//update on user table
							$old_balance=Commonfunction::get_user_bonus($userid[0]['id']);
							$c_balance=$old_balance+Commonfunction::get_bonus_amount(FACEBOOK_INVITE);
							$this->commonmodel->update(USERS,array('user_bonus'=>$c_balance),'id',$userid[0]['id']);
						}
					
					}
					else if($this->cms->check_bonus_type($userid[0]['id'],$get['type'],$friend_id)==2)
					{
						$bonus_amt=Commonfunction::get_current_bonus($userid[0]['id']) + Commonfunction::get_bonus_amount(FACEBOOK_INVITE);
						$bonus=$this->cms->get_bonus_type_id($get['type']);
						$friends=$this->cms->get_from_bonus_tables($userid[0]['id'],$get['type']);
						$f_ids=($friend_id['id']!="")?$friend_id['id'].",":"";
						$fid=$friends[0]['friend_ids'];		
						if(Commonfunction::get_bonus_amount(FACEBOOK_INVITE) >0)
						{			
							$this->commonmodel->update(USER_BONUS,array('bonus_type'=>$get['type'],'bonus_amount' =>$bonus_amt,'userid'=>$userid[0]['id'],'friend_ids'=>$fid.$f_ids),'userid',$userid[0]['id']);

							//update on user table
							$old_balance=Commonfunction::get_user_bonus($userid[0]['id']);
							$c_balance=$old_balance+Commonfunction::get_bonus_amount(FACEBOOK_INVITE);
							$this->commonmodel->update(USERS,array('user_bonus'=>$c_balance),'id',$userid[0]['id']);
						}
					}
				}
			}
			$this->session->set("referral_id",$get['uid']);
		}
		
		$this->template->content = $view;
  	        //$this->replace_variable = array_merge($this->mail_details_seller,$this->replace_variables);
		$all_cmspage=$this->cms->get_cmspage($cmsid);
		         $this->template->title=$this->title."- My CMS";
		$this->template->meta_description=$this->metadescription;
		$this->template->meta_keywords=$this->metakeywords;		
	}
        
      	

}
