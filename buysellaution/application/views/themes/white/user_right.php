<?php defined("SYSPATH") or die("No direct script access."); ?> 


      <div class="dash_heads">
        <ul>
          <li><a href="" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
          <li><img src="<?php echo IMGPATH; ?>arr_bg.png" width="13" height="11" alt="arrow_bg" /></li>
          <li class="active"><a href="" title="<?php echo $selected_page_title; ?>"><?php echo $selected_page_title; ?></a></li>
        </ul>
      </div>
	<div class="banner_left">
        <div class="dash_tops"><?php echo __('menu_user_panel');?></div>
        <div class="dash_lsd user_panel_list">
          <ul>
            <li class=""   id="dashboard_active"><a href="<?php echo URL_BASE;?>users/" title="<?php echo __('menu_dashboard');?>"><?php echo __('menu_dashboard');?></a></li>
			<li class=""  id="edit_profile_active"><a href="<?php echo URL_BASE;?>users/user_settings" title="<?php echo __('edit_profile_link');?>"><?php echo __('edit_profile_link');?></a></li>
			<li class=""  id="my_message_active"><a href="<?php echo URL_BASE;?>users/my_message" title="<?php echo __('menu_my_message');?>" ><?php echo __('menu_my_message');?> <?php echo ($count_msg)>0?"(".$count_msg.")":"";?></a></li>
			<li class="fl clr" id="change_password_active"><a href="<?php echo URL_BASE;?>users/change_password" title="<?php echo __('menu_change_password');?>" ><?php echo __('menu_change_password');?></a></li>

			<li class="fl clr"  id="menu_purchas_active"><a href="<?php echo URL_BASE;?>packages/" title="<?php echo __('buy_packages');?>" ><?php echo __('buy_packages');?></a></li>
			 
			 
			<li class="fl clr"  id="my_watchlist_active"><a href="<?php echo URL_BASE;?>users/watchlist" title="<?php echo __('my_watchlist');?>"><?php echo __('my_watchlist');?></a></li>
			<li class="fl clr" id="my_testimonials_active"><a href="<?php echo URL_BASE;?>users/mytestimonials_details" title="<?php echo __('my_testimonials');?>"  ><?php echo __('my_testimonials');?></a></li>
			<li class="fl clr"   id="my_addresses_active"><a href="<?php echo URL_BASE;?>users/myaddresses" title="<?php echo __('my_addresses');?>"><?php echo __('my_addresses');?></a></li>
			<li class="fl clr"   id="my_bids_active"><a href="<?php echo URL_BASE;?>users/mybids" title="<?php echo __('my_bids');?>"><?php echo __('my_bids');?></a></li>

			<li class="fl clr" id="my_transactions_active"><a href="<?php echo URL_BASE;?>users/mytransactions" title="<?php echo __('my_transactions');?>" ><?php echo __('my_transactions');?></a></li>
			<li  id="autobid_active" class="fl clr" ><a href="<?php echo URL_BASE;?>auctions/setautobid" title="<?php echo __('auto_bid_lable');?>" class="fl" ><?php echo __('auto_bid_lable');?></a></li>

			<li class="fl clr"  id="won_menu"><a href="<?php echo URL_BASE;?>users/won_auctions" title="<?php echo __('won_auctions');?>"  id="won_auctions_active"><?php echo __('won_auctions');?></a></li>
			<li class="fl clr"  id="my_pending_active"><a href="<?php echo URL_BASE;?>users/friends_invite" title="<?php echo __('invite');?>" ><?php echo __('invite');?></a></li>
			
			
	<li class="fl clr" id="products_transactions_active"><a href="<?php echo URL_BASE;?>site/buynow/products_transactions" title="<?php echo __('menu_buynow_transaction');?>" ><?php echo __('menu_buynow_transaction');?></a></li>
			<li class="fl clr" id="addtocart_list_active"><a href="<?php echo URL_BASE;?>site/buynow/cart_list" title="<?php echo __('menu_addtocart_list');?>" ><?php echo __('menu_addtocart_list');?></a></li>
                        
          </ul>
        </div>
      </div>
