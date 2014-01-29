<?php defined('SYSPATH') OR die('No direct access allowed.');
// product common settings get from here 
$product_settings =  commonfunction::get_settings_for_products();
?>
<div class="menu">
  <div class="menu_container">
    <div class="menu_title"><?php echo __('Admin');?></div>
    
    <ul>
     <li onclick="toggle(1)">
           <div class="menu_lft"></div>
           
		   <a href="<?php echo URL_BASE;?>dashboard/index" class="menu_rgt" title="<?php echo __('menu_dashboard');?>">
	           <span class="dashboard_management fl" class="menu_rgt"><?php echo __('menu_dashboard');?></span>
           </a>
	   </li>
	   
      <li onclick="toggle(2)">
           <div class="menu_lft"></div>
		   <a href="javascript:;" class="menu_rgt" title="<?php echo __('menu_users');?>">
			     <span class="user_management fl" class="menu_rgt"><?php echo __('menu_users');?></span>
                   <img id="left_menubutton_2"  src="<?php echo ADMINIMGPATH;?>plus_but.png" />
           </a>
          
	       <ul class="toggleul_2">
               <li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>manageusers/index" class="menu_rgt1" title="<?php echo __('menu_user');?>">
                        <span class="pl15"><?php echo __('menu_user');?></span>
                    </a>
               </li>
              <li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>manageusers/sendemail" class="menu_rgt1" title="<?php echo __('menu_user_send_email');?>">
                        <span class="pl15"><?php echo __('menu_user_send_email');?></span>
                    </a>
    		  </li>
              	<li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>manageusers/loginlistings" class="menu_rgt1" title="<?php echo __('menu_user_login');?>">
                        <span class="pl15"><?php echo __('menu_user_login');?></span>
                    </a>
    		  </li>
    		  <li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>manageusers/message_reports" class="menu_rgt1" title="<?php echo __('menu_message_reports');?>">
                        <span class="pl15"><?php echo __('menu_message_reports');?></span>
                    </a>
    		  </li>
            	
           	 <li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>manageusers/contact_requests" class="menu_rgt1" title="<?php echo __('menu_contact_requests');?>">
                        <span class="pl15"><?php echo __('menu_contact_requests');?></span>
                    </a>
    		  </li> 
    		   <li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>manageusers/testimonials" class="menu_rgt1" title="<?php echo __('menu_testimonials');?>">
                        <span class="pl15"><?php echo __('menu_testimonials');?></span>
                    </a>
    		  </li>   		      		  
           </ul>
        </li>
       <li onclick="toggle(3)">
           <div class="menu_lft" ></div>
		   <a href="javascript:;" class="menu_rgt" title="<?php echo $product_settings[0]['alternate_name'];?>">
			     <span class="job_management fl" class="menu_rgt"><?php echo $product_settings[0]['alternate_name'];?></span>
                   <img id="left_menubutton_3" src="<?php echo ADMINIMGPATH;?>plus_but.png" />
           </a>
	       <ul class="toggleul_3">
                            
                 <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>manageproduct/index" class="menu_rgt1" title="<?php echo __('menu_manage_products');?>">
                            <span class="pl15"><?php echo __('manage_products');?></span>
                        </a>
        		  </li>  
               <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>category/manage_category" class="menu_rgt1" title="<?php echo __('menu_manage_product_category');?>">
                            <span class="pl15"><?php echo __('manage_product_category');?></span>
                        </a>
        		  </li>  
               <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>adminauction/bidhistory" class="menu_rgt1" title="<?php echo __('menu_bid_history');?>">
                            <span class="pl15"><?php echo __('menu_bid_history');?></span>
                        </a>
        	      </li> 
                <li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>adminauction/won_product" class="menu_rgt1" title="<?php echo __('menu_won_auction');?>">
                        <span class="pl15"><?php echo __('menu_won_product_auction');?></span>
                    </a>
               </li> 
		
           </ul>
        </li>
        <li onclick="toggle(6)">
               <div class="menu_lft"></div>
    		   <a href="javascript:;" class="menu_rgt" title="<?php echo __('menu_master');?>">
    			     <span class="masters fl" class="menu_rgt"><?php echo __('menu_master');?></span>
                       <img id="left_menubutton_6" src="<?php echo ADMINIMGPATH;?>plus_but.png" />
               </a>
    	      <ul class="toggleul_6">
                        <li>
                            <div class="menu_lft1"></div>
                            <a href="<?php echo URL_BASE;?>adminauction/bidpackages" class="menu_rgt1" title="<?php echo __('menu_manage_bidpackages');?>">
                                <span class="pl15"><?php echo __('menu_manage_bidpackages');?></span>
                            </a>
                      </li>                         
        	       <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>adminauction/user_bonus" class="menu_rgt1" title="<?php echo __('menu_user_bonus');?>">
                            <span class="pl15"><?php echo __('menu_user_bonus');?></span>
                        </a>
        	    </li>  
        	     <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>adminauction/manage_bonus" class="menu_rgt1" title="<?php echo __('menu_bonus_settings');?>">
                            <span class="pl15"><?php echo __('menu_bonus_settings');?></span>
                        </a>
        	    </li>  
			<li>
			<div class="menu_lft1"></div>
			<a href="<?php echo URL_BASE;?>manageusers/manage_deposits" class="menu_rgt1" title="<?php echo __('menu_manage_deposits');?>">
			<span class="pl15"><?php echo __('menu_manage_deposits');?></span>
			</a>
			</li>               
        	    <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>adminnews/manage_news" class="menu_rgt1" title="<?php echo __('menu_manage_news');?>">
                            <span class="pl15"><?php echo __('menu_manage_news');?></span>
                        </a>
        	    </li>             
                     <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>master/payment_gatways" class="menu_rgt1" title="<?php echo __('menu_payment_gateways');?>">
                            <span class="pl15"><?php echo __('menu_payment_gateways');?></span>
                        </a>
        	    </li> 
                     <?php /* commented on march 19 for testing
                     <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>master/sms_gateways" class="menu_rgt1" title="<?php echo __('menu_sms_gateways');?>">
                            <span class="pl15"><?php echo __('menu_sms_gateways');?></span>
                        </a>
        	    </li>       */ ?>
        	    <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>master/email_template" class="menu_rgt1" title="<?php echo __('menu_email_template');?>">
                            <span class="pl15"><?php echo __('menu_email_template');?></span>
                        </a>
        	    </li>
        	    <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>master/manage_email_newsletter" class="menu_rgt1" title="<?php echo __('menu_email_newsletter');?>">
                            <span class="pl15"><?php echo __('menu_email_newsletter');?></span>
                        </a>
        	    </li>  
                 <li>
                       <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>modules/" class="menu_rgt1" title="<?php echo __('menu_manage_module');?>">
                            <span class="pl15"><?php echo __('menu_manage_module');?></span>
                        </a>
        	    </li> 
              </ul>
        </li>
        <li onclick="toggle(7)">
           <div class="menu_lft"></div>
		   <a href="javascript:;" class="menu_rgt" title="<?php echo __('menu_transaction');?>">
			     <span class="transaction fl" class="menu_rgt"><?php echo __('menu_transaction');?></span>
                   <img id="left_menubutton_7" src="<?php echo ADMINIMGPATH;?>plus_but.png" />
           </a>
	       <ul class="toggleul_7">


		<li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>transaction/orderhistory" class="menu_rgt1" title="<?php echo __('auction_order_history');?>">
                        <span class="pl15"><?php echo __('auction_order_history');?></span>
                    </a>
               </li>
               <li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>transaction/index" class="menu_rgt1" title="<?php echo __('menu_transaction');?>">
                        <span class="pl15"><?php echo __('menu_transaction');?></span>
                    </a>
               </li>
                <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>paymentlog/payment_transaction_log" class="menu_rgt1" title="<?php echo __('page_payment_log');?>">
                            <span class="pl15"><?php echo __('page_payment_log');?></span>
                        </a>
                   </li> 
		<!--Buy Now Auction -->
		 <li>
                    <div class="menu_lft1"></div>
                    <a href="<?php echo URL_BASE;?>admin/buynow/buynow" class="menu_rgt1" title="<?php echo __('menu_buynow_transaction');?>">
                        <span class="pl15"><?php echo __('menu_buynow_transaction');?></span>
                    </a>
               </li>
		 <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>admin/buynow/payment_transaction_log" class="menu_rgt1" title="<?php echo __('buynow_page_payment_log');?>">
                            <span class="pl15"><?php echo __('buynow_page_payment_log');?></span>
                        </a>
                   </li> 
		<!--Buy Now Auction-->	 
           </ul>
        </li>       
         <li onclick="toggle(8)">
               <div class="menu_lft"></div>
    		   <a href="javascript:;" class="menu_rgt" title="<?php echo __('menu_general_settings');?>">
    			     <span class="general_settings fl" class="menu_rgt"><?php echo __('menu_general_settings');?></span>
                       <img id="left_menubutton_8" src="<?php echo ADMINIMGPATH;?>plus_but.png" />
               </a>
    	       <ul class="toggleul_8">
                   <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>settings/site_settings" class="menu_rgt1" title="<?php echo __('menu_site_settings');?>">
                            <span class="pl15"><?php echo __('menu_site_settings');?></span>
                        </a>
                   </li>  
                   <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>settings/site_settings_meta" class="menu_rgt1" title="<?php echo __('menu_meta_settings');?>">
                            <span class="pl15"><?php echo __('menu_meta_settings');?></span>
                        </a>
                   </li> 
                       
                   <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>settings/site_settings_user" class="menu_rgt1" title="<?php echo __('menu_user_settings');?>">
                            <span class="pl15"><?php echo __('menu_user_settings');?></span>
                        </a>
                   </li>  
                        
        	    
                   <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>settings/site_settings_product" class="menu_rgt1" title="<?php echo __('menu_product_settings',array(':param'=>$product_settings[0]['alternate_name']));?>">
                            <span class="pl15">
                            <?php echo __('menu_product_settings',array(':param'=>$product_settings[0]['alternate_name']));?>                          
                           </span>
                        </a>
                   </li>
                    <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>settings/manage_banner" class="menu_rgt1" title="<?php echo __('page_site_bannar_settings');?>">
                            <span class="pl15"><?php echo __('page_site_bannar_settings');?></span>
                        </a>
                   </li> 
                   <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>settings/manage_ads" class="menu_rgt1" title="<?php echo __('page_site_ads_settings');?>">
                            <span class="pl15"><?php echo __('page_site_ads_settings');?></span>
                        </a>
                   		</li> 
                <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>settings/mail_settings" class="menu_rgt1" title="<?php echo __('menu_mail_settings');?>">
                        <span class="pl15"><?php echo __('menu_mail_settings');?></span>
                        </a>
                </li>

                   <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>cms/manage_static_pages" class="menu_rgt1" title="<?php echo __('page_title_static');?>">
                            <span class="pl15"><?php echo __('page_title_static');?></span>
                        </a>
                   </li>  
                    <li>
                        <div class="menu_lft1"></div>
                        <a href=" <?php echo URL_BASE;?>settings/social_network" class="menu_rgt1" title="<?php echo __('menu_social_network_settings');?>">
                            <span class="pl15"><?php echo __('menu_social_network_settings');?></span>
                        </a>
                   </li>   
                   <li>
                        <div class="menu_lft1"></div>
                        <a href=" <?php echo URL_BASE;?>settings/social_media_account" class="menu_rgt1" title="<?php echo __('menu_social_media_settings');?>">
                            <span class="pl15"><?php echo __('menu_social_media_settings');?></span>
                        </a>
                   </li>   
                   <li>
                        <div class="menu_lft1"></div>
                        <a href=" <?php echo URL_BASE;?>settings/news_letter" class="menu_rgt1" title="<?php echo __('menu_news_latter');?>">
                            <span class="pl15"><?php echo __('menu_news_latter');?></span>
                        </a>
                   </li>           
              </ul>
              <li onclick="toggle(9)">
           <div class="menu_lft" ></div>
		   <a href="javascript:;" class="menu_rgt" title="<?php echo __('menu_blog_settings');?>">
			     <span class="blogs_management fl" class="menu_rgt"><?php echo __('menu_blog_settings');?></span>
                   <img id="left_menubutton_9" src="<?php echo ADMINIMGPATH;?>plus_but.png" />
           </a>
	       <ul class="toggleul_9">
	        <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>blog/blog_category" class="menu_rgt1" title="<?php echo __('menu_manage_blog_category');?>">
                            <span class="pl15"><?php echo __('manage_blog_category');?></span>
                        </a>
              </li>  
              <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>blog/index" class="menu_rgt1" title="<?php echo __('manage_blog_settings');?>">
                            <span class="pl15"><?php echo __('manage_blog_settings');?></span>
                        </a>
	       </li> 
	        <li>
                        <div class="menu_lft1"></div>
                        <a href="<?php echo URL_BASE;?>blog/manage_comments" class="menu_rgt1" title="<?php echo __('menu_manage_comments');?>">
                            <span class="pl15"><?php echo __('menu_manage_comments');?></span>
                        </a>
	       </li> 
           </ul>
        </li>
    </ul>
  </div>
</div>
<script type="text/javascript">
                function toggle(ids){
                        $(".toggleul_"+ids).slideToggle();
                        var imgSrc= $("#left_menubutton_"+ids).attr("src");
                        imgSrc = imgSrc.substr(-13, 13);
                        //For Replacing the Menu Images
                        var toggle_image="<?php echo ADMINIMGPATH;?>minus_but.png";
                        if(imgSrc == "minus_but.png")
                        var toggle_image="<?php echo ADMINIMGPATH;?>plus_but.png";
                        $("#left_menubutton_"+ids).attr({src:toggle_image});
                }
</script>   
