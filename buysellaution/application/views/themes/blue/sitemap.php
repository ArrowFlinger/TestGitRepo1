<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="container_inner fl clr">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
                <h2 class="fl clr pl10" title="<?php echo __('menu_site_map');?>"><?php echo __('menu_site_map');?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
        <div class="action_deal_list clearfix">
        <div class="deal_list  clearfix">
        <div class="footer_content">
        <div class="footer-section1">
        <h6><?php echo __('menu_registration');?></h6>
                <ul class="footer-list1">
                        <li> <a title="<?php echo __('menu_register');?>" target="_self" href="<?php echo URL_BASE;?>users/signup"><?php echo __('menu_register');?> </a> </li>
                        <li><a href="<?php echo url::base();?>users/forgot_password"  target="_self" title="<?php echo __('forgot_password');?>"><?php echo __('forgot_password');?></a></li></ul>
                       
                
        </div>
        
        <div class="footer-section2">
                <h6><?php echo __('menu_auction');?></h6>
                <ul class="footer-list1">
                        <li><a href="<?php echo URL_BASE;?>auctions/live" title="<?php echo __('menu_live_auction');?>" id="edit_profile_active"><?php echo __('menu_live_auction');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>auctions/future" title="<?php echo __('menu_future');?>" id="edit_profile_active"><?php echo __('menu_future');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>auctions/closed" title="<?php echo __('menu_closed');?>" id="edit_profile_active"><?php echo __('menu_closed');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>auctions/winners" title="<?php echo __('menu_winners');?>" id="edit_profile_active"><?php echo __('menu_winners');?></a></li>
                </ul>
        </div>
        
        <div class="footer-section2">
                <h6><?php echo __('menu_account');?></h6>
                <ul class="footer-list1">
                        <li><a href="<?php echo URL_BASE;?>users/user_settings" title="<?php echo __('edit_profile_link');?>" id="edit_profile_active"><?php echo __('edit_profile_link');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>users/change_password" title="<?php echo __('menu_change_password');?>" id="change_password_active"><?php echo __('menu_change_password');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>users/myaddresses" title="<?php echo __('my_addresses');?>"  id="my_addresses_active"><?php echo __('my_addresses');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>users/my_message" title="<?php echo __('menu_my_message');?>"  id="my_message_active"><?php echo __('menu_my_message');?> <?php echo ($count_msg)>0?"(".$count_msg.")":"";?></a></li>
                        <li><a href="<?php echo URL_BASE;?>users/watchlist" title="<?php echo __('my_listings');?>" id="my_watchlist_active"><?php echo __('my_listings');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>users/mybids" title="<?php echo __('my_bids');?>"  id="my_bids_active"><?php echo __('my_bids');?></a></li>
                        <li  id="won_menu"><a href="<?php echo URL_BASE;?>users/won_auctions" title="<?php echo __('won_auctions');?>"  id="won_auctions_active"><?php echo __('won_auctions');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>users/mytransactions" title="<?php echo __('my_transactions');?>" id="my_transactions_active"><?php echo __('my_transactions');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>users/mytestimonials_details" title="<?php echo __('my_testimonials');?>"  id="my_testimonials_active"><?php echo __('my_testimonials');?></a></li>
                </ul>
        </div>
        
        <div class="footer-section2">
                <h6><?php echo __('menu_cms_pages');?></h6>
                <ul class="footer-list1">
                <?php $static=Commonfunction::get_staticpage_content();
                foreach($static as $sta):?>
                        <li><a href="<?php echo URL_BASE;?>cmspage/page/<?php echo $sta['page_url'];?>" title="<?php echo $sta['page_title'];?>"><?php echo $sta['page_title'];?></a><?php endforeach;?> </li>    
                        <li><a href="<?php echo URL_BASE;?>userblog/blog_details" title="<?php echo __('blog');?>" ><?php echo __('blog');?></a></li>
                        <li><a href="<?php echo URL_BASE;?>news/news_details" title="<?php echo __('menu_news');?>"><?php echo __('menu_news');?></a></a></li>       
                </ul>
        </div>
        
        <div class="footer-section2">
                <h6><?php echo __('menu_linked_site');?></h6>
                <ul class="footer-list1">
                        <li ><a target="_blank" title="Facebook" href="http://www.facebook.com/pages/NDOT/125148634186302"><?php echo __('Facebook');?></a></li>
                        <li ><a target="_blank" title="Follow Us in Twitter" href="http://twitter.com/#!/Ndotauction"><?php echo __('Twitter');?></a></li>
                        <li><a title="Linkedin" href="http://www.linkedin.com/companies/269461"><?php echo __('Linkedin');?></a></li>
                </ul>
        </div>
 </div>
</div>
</div>
</div>
    <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
</div>
