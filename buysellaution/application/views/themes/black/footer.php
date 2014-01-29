</div></div></div>
<div class="footer_outer fl clr">
	<div class="footer_content">
		<div class="footer_in fl clr">
        	<div class="footer_top fl clr">
        	 <?php

if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?> 
            	<a  title="<?php echo __('follow_us_on');?>"><?php echo __('follow_us_on');?></a><a href="<?php echo $facebook_app[0]['facebook_share'];?>" title="Facebook"><img src="<?php echo IMGPATH;?>facebook_icon.png" width="32" height="32" alt="Facebook" title="Facebook" /></a><a href="<?php echo $facebook_app[0]['twitter_share'];?>" title="Twitter"><img src="<?php echo IMGPATH;?>twitter_icon.png" width="32" height="32" alt="Twitter" title="Twitter" /></a><a href="<?php echo $facebook_app[0]['linkedin_share'];?>" title="Linkedin"><img src="<?php echo IMGPATH;?>linked_in_icon.png" width="32" height="32" alt="Linkedin" title="Linkedin" /></a>
            	<?php }?>
            </div>
            <div class="footer_middle fl clr">
             <?php

if(($site_settings[0]['maintenance_mode'] != ACTIVE) || (isset($auction_userid) && $user_type == ADMIN)){ ?> 
		<?php $static=Commonfunction::get_staticpage_content("footer");
	foreach($static as $sta):?>
	<a href="<?php echo URL_BASE;?>cmspage/page/<?php echo $sta['page_url'];?>" title="<?php echo $sta['page_title'];?>"><?php echo $sta['page_title'];?></a><span>|</span><?php endforeach;?>
            	<a href="<?php echo URL_BASE;?>contactus/contact" title="<?php echo __('contact_title');?> "><?php echo __('contact_title');?> </a><span>|</span>

<a href="<?php echo URL_BASE;?>users/testimonials_details" title="<?php echo __('view_testimonials');?>" ><?php echo __('view_testimonials');?></a><span>|</span>
<a href="<?php echo URL_BASE;?>userblog/blog_details" title="<?php echo __('blog');?>" ><?php echo __('blog');?></a>
<span>|</span>
<a href="<?php echo URL_BASE;?>news/news_details" title="<?php echo __('view_news');?>" ><?php echo __('view_news');?></a>
<?php }?>
            </div>
        	<div class="footer_middle fl clr">
        		<p><?php echo __('footer_label',array(':param'=> "<a href=
".URL_BASE." target = '_blank' class='footer_link' title=' ".$site_name." '>".$site_name."</a>",':param1'=>$site_settings[0]['site_version']));?> .</p>
        		
       	    </div>
       	</div>
</div>    	    
</div>

