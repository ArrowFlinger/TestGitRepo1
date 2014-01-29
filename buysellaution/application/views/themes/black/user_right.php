<?php defined("SYSPATH") or die("No direct script access."); ?> 
   <!-- User Panel STRAT-->
<div class="sidebar_content fr">
    <div class="sidebar_user_panel fl clr">
    	<div class="sidebar_title fl clr"><h4 class="fl clr" title="<?php echo __('menu_user_panel');?>"><?php echo __('menu_user_panel');?></h4></div>
        <div class="sidebar_user_panel_in fl clr">
        	<div class="user_panel_list fl clr">
            	<ul class="fl clr">
			<li class="fl clr "><a href="<?php echo URL_BASE;?>users/" title="<?php echo __('menu_dashboard');?>" class="fl" id="dashboard_active"><?php echo __('menu_dashboard');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>users/user_settings" title="<?php echo __('edit_profile_link');?>" class="fl" id="edit_profile_active"><?php echo __('edit_profile_link');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>users/my_message" title="<?php echo __('menu_my_message');?>" class="fl" id="my_message_active"><?php echo __('menu_my_message');?> <?php echo ($count_msg)>0?"(".$count_msg.")":"";?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>users/change_password" title="<?php echo __('menu_change_password');?>" class="fl" id="change_password_active"><?php echo __('menu_change_password');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>packages/" title="<?php echo __('buy_packages');?>" class="fl" id="menu_purchas_active"><?php echo __('buy_packages');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>users/watchlist" title="<?php echo __('my_watchlist');?>" class="fl" id="my_watchlist_active"><?php echo __('my_watchlist');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>users/mytestimonials_details" title="<?php echo __('my_testimonials');?>" class="fl" id="my_testimonials_active"><?php echo __('my_testimonials');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>users/myaddresses" title="<?php echo __('my_addresses');?>" class="fl" id="my_addresses_active"><?php echo __('my_addresses');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>users/mybids" title="<?php echo __('my_bids');?>" class="fl" id="my_bids_active"><?php echo __('my_bids');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>users/mytransactions" title="<?php echo __('my_transactions');?>" class="fl" id="my_transactions_active"><?php echo __('my_transactions');?></a></li>
			<li class="fl clr"  id="won_menu"><a href="<?php echo URL_BASE;?>users/won_auctions" title="<?php echo __('won_auctions');?>" class="fl" id="won_auctions_active"><?php echo __('won_auctions');?></a></li>
			<li class="fl clr" ><a href="<?php echo URL_BASE;?>auctions/setautobid" title="<?php echo __('auto_bid_lable');?>" class="fl"  id="autobid_active"><?php echo __('auto_bid_lable');?></a></li>
			<li class="fl clr" ><a href="<?php echo URL_BASE;?>users/friends_invite" title="<?php echo __('invite');?>" class="fl"  id="my_pending_active"><?php echo __('invite');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>site/buynow/products_transactions" title="<?php echo __('menu_buynow_transaction');?>" id="products_transactions_active"><?php echo __('menu_buynow_transaction');?></a></li>
			<li class="fl clr"><a href="<?php echo URL_BASE;?>site/buynow/cart_list" title="<?php echo __('menu_addtocart_list');?>" id="addtocart_list_active"><?php echo __('menu_addtocart_list');?></a></li>
                        
	          
                </ul>
            </div>
        </div>
    </div>
    <!--User Panel END-->
    <!--Payment Methods STRAT-->
    <div class="sidebar_user_panel fl clr mt15">
    	<div class="sidebar_title fl clr"><h4 class="fl clr" title="<?php echo __('secure_payments');?>"><?php echo __('secure_payments');?></h4></div>
        <div class="sidebar_user_panel_in fl clr">
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
                        	<img src="<?php echo IMGPATH;?>master_card.png" alt="Master Card" title="Master Card" class="fl" border="0" />
                    </li>
                    <li class="fl">
                        	<img src="<?php echo IMGPATH;?>descover_card.png" alt="Descover Card" title="Descover Card" class="fl" border="0" />
                    </li>
                    <li class="fl">
                        	<img src="<?php echo IMGPATH;?>pink_method_card.png" alt="Pink Method Card" title="Pink Method Card" class="fl clr" border="0" />
                    </li>
                    <li class="fl">
                        	<img src="<?php echo IMGPATH;?>hdfc_bank.png" alt="HDFC" title="HDFC" class="fl clr" border="0" />
                      
                    </li>
                    <li class="fl">
                        	<img src="<?php echo IMGPATH;?>kotak_bank.png" alt="Kotak" title="Kotak" class="fl" border="0" />
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--Payment Methods END-->
</div>

</div>
