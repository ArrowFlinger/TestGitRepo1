</div></div></div>
<div class="footer_outer fl clr">
	<div class="footer_content">
	
			<div class="footer-wrapper-inner clearfix">
                <div class="footer-section1">
                <?php if( ($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
                <h6><?php echo __('quick_links');?></h6>
                        <ul class="footer-list">
                                <li><a title=" <?php echo __('menu_register');?>" href="<?php echo URL_BASE;?>users/signup"> <?php echo __('register_now');?></a> </li>
                               
                                <li><a title="<?php echo __('menu_live_auction');?>" href="<?php echo URL_BASE;?>auctions/live">  <?php echo __('menu_live_auction');?></a></li>
                                <li><a title="<?php echo __('view_testimonials');?>"  href="<?php echo URL_BASE;?>users/testimonials_details"><?php echo __('view_testimonials');?></a></li>
				 <li><a href="<?php echo URL_BASE;?>contactus/contact" title="<?php echo __('contact_title');?> "><?php echo __('contact_title');?> </a></li>
                                <li><a href="<?php echo URL_BASE;?>userblog/blog_details" title="<?php echo __('blog');?>" ><?php echo __('blog');?></a></li>	
                                <li><a title="<?php echo __('menu_site_map');?>"  href="<?php echo URL_BASE;?>users/sitemap"><?php echo __('menu_site_map');?></a></li>
                        </ul>
                        <?php }?>
                </div>
                <div class="footer-section2">
                <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($userid) && ($user_type == ADMIN) ) ){?>
                <h6><?php echo __('support');?></h6>
                        <ul class="footer-list">
                                <?php $static=Commonfunction::get_staticpage_content("footer");
                                foreach($static as $sta):?>
                                <li><a href="<?php echo URL_BASE;?>cmspage/page/<?php echo $sta['page_url'];?>" title="<?php echo $sta['page_title'];?>"><?php echo $sta['page_title'];?></a><?php endforeach;?>
                                </li>
                               
                        </ul>
                        <?php }?>
                </div>
                <div class="footer-section3">
                <?php if( ($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
                <h6><?php echo __('follow_us_on');?> </h6>
                        <ul class="footer-list">
                                <li class="face"><a target="_blank" title="Facebook" href="<?php echo $facebook_app[0]['facebook_share'];?>"><?php echo __('Facebook');?></a></li>
                                <li class="tweet"><a target="_blank" title="Follow Us in Twitter" href="<?php echo $facebook_app[0]['twitter_share'];?>"><?php echo __('Twitter');?></a></li>
                                <li class="link"><a title="Linkedin" href="<?php echo $facebook_app[0]['linkedin_share'];?>"><?php echo __('Linkedin');?></a></li>
                        </ul>
                        <?php }?>
                </div>
     <div class="footer-section4">
        <div class="sidebar_user_panel fl clr">
        <?php if( ($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
                <h6 class="clr" title="<?php echo __('secure_payments');?>"><?php echo __('secure_payments');?></h6>
	                <div class="payment_method_list fl clr">
                    	<ul class="fl">
                                <li class="fl clr">
                                <img src="<?php echo IMGPATH;?>visa_card.png" alt="VISA METHOD" title="VISA METHOD" class="fl" border="0" />                       
                                </li>
                                <li class="fl">
                                <img src="<?php echo IMGPATH;?>visa_method.png" alt="VISA METHOD" title="Visa Method" class="fl" border="0" />
                                </li>
                                <li class="fl">
                                <img src="<?php echo IMGPATH;?>mastro_card.png" alt="Mastro Card" title="Mastro Card" class="fl" border="0" />
                                </li>
                                <li class="fl">
                                <img src="<?php echo IMGPATH;?>descover_card.png" alt="Descover Card" title="Descover Card" class="fl" border="0" />
                                </li>
                                <li class="fl">
                                <img src="<?php echo IMGPATH;?>paypal.png" alt="paypal" title="paypal" class="fl" border="0" />
                                </li>
                        </ul>
                        </div>
                    <h6 class="clr" title="<?php echo __('site_description_label');?>"><?php echo __('site_description_label');?></h6>
                <p><?php echo $site_settings[0]['site_description'];?></p>
                   <?php } ?>  
           </div>
        </div>
    </div>
 
        </div>
    <div class="copyright">
<p class="copyright1"><?php echo __('footer_label',array(':param'=> "<a href=
".URL_BASE." target = '_blank' class='footer_link' title=' ".$site_name." '>".$site_name."</a>",':param1'=>$site_settings[0]['site_version']));?> .</p>
</div> 
 	    
</div>

