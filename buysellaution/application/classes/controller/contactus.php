<?php defined('SYSPATH') or die('No direct script access.');

/* Contains Contactus(User Contact Mail templates) details

* @Created on October 24, 2012

* @Updated on October 24, 2012

* @Package: Nauction Platinum Version 1.0

* @Author: NDOT Team

* @URL : http://www.ndot.in

*/

class Controller_Contactus extends Controller_Website
{
	/**
	 * ****action_contact()****
	 * @return contact form
	 */
	public function action_contact()
	{
                /*To assign default category recent as selected*/
                $category_name=RECENT_CAT;
                $captcha = Captcha::instance();
                $this->selected_page_title = __('menu_contactus') ;
                //set page title
                //getting request for form submit
                $contact_add =arr::get($_POST,'contact_submit');
                $submit_user =arr::get($_REQUEST,'submit_user');
		if(isset($submit_user))
		{
		        $this->request->redirect("contactus/contact/");
		}	
                /**To set captcha value to one if entered value is correct and if not , set to zero**/
                $captcha_val = isset($_POST["captcha"])?($captcha->valid($_POST["captcha"]) == 1?1:0):1;
                //validation starts here	
                if(isset($contact_add)){
                $validator = $this->contact_us->validate_contact_form(arr::extract($_POST,
                array('subject','name','email','telephone','message')));
                //validation check
                if ($validator->check() && $captcha_val) 
                {
                                $status = $this->contact_us->add_contact_request($validator,$_POST,$this->auction_userid);
	
                                $phone = ($_POST['telephone'])?$_POST['telephone']:__('not_mentioned_telephone_details');
                                $sub = ($status[0]['subject'])?$status[0]['subject']:$status[0]['subject1'];
                                if($this->auction_userid){

                                $this->username = array(USERNAME => $status[0]['username'],EMAIL => $status[0]['email'],TO_MAIL => TO_ADMIN_MAIL,
                                FIRST_NAME => $status[0]['firstname'],LAST_NAME => $status[0]['lastname'],
                                MESSAGE=>$status[0]['message'],TELEPHONE => $phone,IP => $status[0]['ip'],SUBJECT => $sub);											

                                $this->replace_variable = array_merge($this->replace_variables,$this->username);

                                }else{
                                //if user not logged in means
                                $this->username = array(USERNAME => $_POST['name'],EMAIL => $_POST['email'],TO_MAIL => TO_ADMIN_MAIL,
                                FIRST_NAME => "",LAST_NAME => "",SUBJECT => $sub,
                                TELEPHONE => $phone,IP => $status[0]['ip'],MESSAGE=>$_POST['message']);
                                $this->replace_variable = array_merge($this->replace_variables,$this->username);
                                }

                                //mail will send to admin for all user contact request	
                                $mail_user= Commonfunction::get_email_template_details(CONTACT_US, $this->replace_variable,SEND_MAIL_TRUE);

                                //auto reply mail to users
                                $this->username[TO_MAIL] = $_POST['email']; 
                                $this->username[POST_DATE] = $status[0]['request_date'];	
                                $this->username[CONTACT_URL] = (!empty($_SERVER['HTTPS'])) ? 'https://'.$this->server_name.$this->server_uri: 'http://'.$this->server_name.$this->server_uri;

                                $this->replace_variable = array_merge($this->replace_variables,$this->username); 
                                //mail will send to corresponding to which user make  contact request	
                                $mail = Commonfunction::get_email_template_details(CONTACT_US_AUTO_REPLY, $this->replace_variable,SEND_MAIL_TRUE);
			
                                //showing msg for mail sent or not in flash

                                if($mail_user == MAIL_SUCCESS)
                                {
                                Message::success(__('email_succesfull_msg'));		
                                }
                                else
                                {
                                Message::success(__('email_unsuccesfull_msg'));		

                                }	
                                
                                Message::success(__('sucessful_post'));
                                /*Dashboard Page Redirection*/
                                $this->request->redirect("/");

                                }
                                else{
                                //validation error msg hits here
                                $errors = $validator->errors('errors');
                                }
                }
                $subject = $this->contact_us->contact_subject_list();
                $this->template->title=$this->title;
                $this->template->meta_description=$this->metadescription;
                $this->template->meta_keywords=$this->metakeywords;

                $view= View::factory(THEME_FOLDER.'manage_contacts')
                        ->bind('validator', $validator)
                        ->bind('errors', $errors)
                        ->bind('action',$action)
                        ->bind('srch',$_POST)
                        ->bind('category',$job_category)
                        ->bind('captcha',$captcha)
                        ->bind('subject',$subject)
                        ->bind('suggestions',$suggestions)
                        ->bind('category_selected',$category_name)
                        ->bind('captcha_val',$captcha_val);
                $this->template->content = $view;

                }


} // End Welcome
