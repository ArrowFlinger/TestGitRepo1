<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--footer start-->
<div id="footer">
  <div class="footer_inner">
 
    <div class="sadow"></div>
    <div class="footer_inner_left"> <strong>
     <?php
if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?>
    <?php if($site_settings[0]['site_logo']==0) { ?>
                    
                	<a href="<?php echo URL_BASE;?>" title="<?php echo $site_name;?>" class="fl">
                    	<img src="<?php echo IMGPATH.'action-logo.png';?>" alt="<?php echo $site_name;?>" title="<?php echo $site_name;?>" border="0"  width="221" height="46" /> 
                    	 </a>
                <?php } else {?>
            
            	<a href="<?php echo URL_BASE;?>" title="<?php echo $site_name;?>" class="fl">
                    	<img src="<?php echo URL_BASE.LOGO_IMGPATH.$site_settings[0]['site_logo'];?>" alt="<?php echo $site_name;?>" title="<?php echo $site_name;?>" border="0" width="221" height="46" />
                    	 </a>
               <?php }} ?>
    </strong>
     <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
    <p><?php echo $site_settings[0]['site_description'];?></p>
      <div class="pay">
        <p><?php echo __('secure_payments');?></p>
        <ul>
          <li><img src="<?php echo IMGPATH;?>footer_visa.png" width="35" height="22" alt="img" title="Visa method" border="0"/></li>
          <li><img src="<?php echo IMGPATH;?>footer_visa1.png" width="35" height="22" alt="img" title="Visa Method" border="0"/></li>
          <li><img src="<?php echo IMGPATH;?>footer_discover.png" width="35" height="22" alt="img" title="Discover Card" border="0"/></li>
          <li><img src="<?php echo IMGPATH;?>footer_pay.png" width="35" height="22" alt="img" title="Mastro Card" border="0"/></li>
          <li><img src="<?php echo IMGPATH;?>paypal.png" width="35" height="22" alt="img" title="Paypal" border="0"/></li>
        </ul>
        <?php }?>
      </div>
       <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
      <div class="follow">
        <p><?php echo __('follow_us_on');?></p>
        <ul>
          <li><a title="<?php echo __('email');?>" href="mailto:<?php echo ADMIN_EMAIL;?>"><img src="<?php echo IMGPATH;?>footer-icon-1.png"  width="14" height="13" alt="img" border="0"/></a></li>
          <li><a title="Twitter" href="<?php echo $facebook_app[0]['twitter_share'];?>"><img src="<?php echo IMGPATH;?>footer-icon-2.png"  width="14" height="13" alt="img" border="0"/></a></li>
          <li><a title="Facebook" href="<?php echo $facebook_app[0]['facebook_share'];?>"><img src="<?php echo IMGPATH;?>footer-icon-3.png"  width="14" height="13" alt="img" border="0"/></a></li>          
        </ul>
      </div>
    </div>
    <div class="footer_inner_right">     
            <p><?php echo __('signup_newsletter');?></p>        
      <div class="Sign">
     <form action="" method="POST">      
         <?php echo Form::input('email',isset($form_values['email'])?$form_values['email']:__('enter_email'),array('maxlength'=>'50','class'=>'textbox','id'=>'email','onfocus'=>'label_onfocus("email","'.__('enter_email').'")','onblur'=>'label_onblur("email","'.__('enter_email').'")'));?>
        <div class="singbutton">
          <div class="sign_left"></div>
          <div class="sign_mid"><input type="submit" value="<?php echo __('signup_email_elerts');?>" name="subscriber" title="<?php echo __('signup_email_elerts');?>"></div>
          <div class="sign_right"></div>
		  
		 
        </div>
        <?php }?> 
      </div>
     
			<?php if($subscriber_errors){?>
			 <span>
			<p style="color:skyblue;margin-top:5px;"id="er">
			<?php 
			echo (array_key_exists('email',$subscriber_errors))? $subscriber_errors['email']:"";			
			?>
			</p></span>
		    <?php }
			?>
		</form>	
      <div class="footer_inner_right_left">
       <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
        <label><?php echo ucfirst(__('categories'));?></label>
       
			<ul class="footer-list">
				<?php foreach($category_list_footer as $category):?>  
								<li><a href="<?php echo URL_BASE;?>auctions/category/<?php echo $category['id'];?>" title="<?php echo ucfirst($category['category_name']);?>" ><?php echo ucfirst($category['category_name']);?></a></li>
				<?php endforeach;?>
			</ul>
			<?php }?>
      </div>
      <div class="footer_inner_right_mid">
       <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
        <label><?php echo __('my_account');?></label>
        <ul>
          <!--<li><a href="<?php echo URL_BASE;?>users/signup" title="<?php echo __('menu_register');?>"><?php echo __('register_now');?></a></li>-->         
          <li><a href="<?php echo URL_BASE;?>users/" title="<?php echo __('my_page');?>"><?php echo __('my_page');?></a></li>
          <strong><?php echo __('customer_service');?></strong>
          <li><a href="<?php echo URL_BASE;?>contactus/contact" title="<?php echo __('contact_title');?> "><?php echo __('contact_title');?> </a></li>
                   
        </ul>
        <?php }?> 
      </div>
      <div class="footer_inner_right_right">
       <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
        <label><?php echo ucfirst(__('about'));?></label>
        <ul>
          <?php $static=Commonfunction::get_staticpage_content("footer");
                                foreach($static as $sta):?>
                                <li><a href="<?php echo URL_BASE;?>cmspage/page/<?php echo $sta['page_url'];?>" title="<?php echo $sta['page_title'];?>"><?php echo $sta['page_title'];?></a>
                                </li>
                                <?php endforeach;?>
                        <li><a href="<?php echo URL_BASE;?>userblog/blog_details" title="<?php echo __('blog');?>" ><?php echo __('blog');?></a></li>
                        
                        <li><a href="<?php echo URL_BASE;?>users/testimonials_details" title="<?php echo __('testimonials');?>" ><?php echo __('testimonials');?></a></li>
                        
        </ul>
        <?php }?>
      </div>
    </div>
  </div>
</div>

<div class="footer_down">
  <div class="footer_down_inner">
   <p class="copyright"><?php echo __('footer_label',array(':param'=> "<a href=
".URL_BASE." target = '_blank' class='footer_link' style='color:#666666' title=' ".$site_name." '>".$site_name."</a>",':param1'=>$site_settings[0]['site_version']));?> .</p>
  </div>
</div>
<!-- footer end-->
</div>
<script type="text/JavaScript">
var e=document.getElementById("er");
if(e)
{
location.href ="<?php echo URL_BASE."#footer"?>";
window.event.returnValue = false;
}
</script>
