<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--Right side-->
<div class="sidebar_content fr">
  
  
    
<div class="sidebar_register_content fl clr">
    	<div class="sidebar_register_in fl clr">
    	<!--<p class="fl clr"><?php echo __('register_now_label');?></p>
            <span class="fl clr"><?php echo __('free_label');?></span>-->
        	<?php if(!$auction_userid):?>
        	<p class="fl clr"><?php echo __('register_now_label');?></p>
        	<span class="fl clr"><?php echo __('free_label');?></span>
        	<?php else:?>
        	<p class="fl clr"><?php echo __('user_menu');?></p>
        	<span class="fl clr"><?php echo __('free_label');?></span>
        	<?php endif; ?>
            <div class="register_button_out fl clr mt20">
            	<div class="signup_button fl">
		<?php if($auction_userid):?>
                	<div class="signup_btn_left fl"></div>	
                    <div class="signup_btn_middle fl">
                    	<a href="<?php echo URL_BASE;?>users/" title="<?php echo __('menu_users');?>" class="fl"><?php echo __('menu_users');?></a>
                     </div>
		
                    <div class="signup_btn_left signup_btn_right fl"></div>
		
                </div>
                <div class="login_button fl ml10">
                	<div class="login_btn_left fl"></div>
                    <div class="login_btn_middle fl">
                    	<a href="<?php echo URL_BASE;?>users/logout" title="<?php echo __('menu_logout');?>" class="fl"><?php echo __('menu_logout');?></a>
                     </div>
                    <div class="login_btn_left login_btn_right fl"></div>
		<?php else:?>
			<div class="signup_btn_left fl"></div>	
                    <div class="signup_btn_middle fl">
                    	<a href="<?php echo URL_BASE;?>users/login" title="<?php echo __('menu_signin');?>" class="fl"><?php echo __('menu_signin');?></a>
                     </div>
		
                    <div class="signup_btn_left signup_btn_right fl"></div>
		
                </div>
                <div class="login_button fl ml10">
                	<div class="login_btn_left fl"></div>
                    <div class="login_btn_middle fl">
                    	<a href="<?php echo URL_BASE;?>users/signup" title="<?php echo __('menu_register');?>" class="fl"><?php echo __('menu_register');?></a>
                     </div>
                    <div class="login_btn_left login_btn_right fl"></div>
		<?php endif;?>
                </div>
            </div>
        </div>
    </div>
    
    <!--Sidebar Action Timer START-->
	<div class="sidebar_action_time_cnt fl clr mt15">
		<div class="action_server_time fl clr">
        	<div class="action_time_detail fl clr">
            	<span class="fl clr"><?php echo __('auction_timing_label');?></span>
                <p class="fl clr mt5"><?php echo __('timing_label');?></p>
            </div>
            <div class="server_time_detail fl clr">
            	<span class="fl clr"><?php echo __('server_time_label');?></span>
                <p class="fl clr mt5 server_time"><?php echo date(SERVER_TIME_FORMAT,time());?></p>
            </div>
        </div>	    
	</div>
    <!--Sidebar Action Timer END-->

    <!-- Refere Friend Start-->
    <div class="sidebar_refere_friend fl clr mt15">
    	<div class="refere_friend_cnt fl clr">
        	<p class="fl"><?php echo __('tell_a_friend_label');?></p>
	<?php 
	if($auction_userid){
		$url=URL_BASE."users/friends_invite";
	}
	else
	{	
		
		$url=URL_BASE."users/login";
	}?>
		
            <a href="<?php echo $url;?>" title="and earn Bonus" class="fr earn_bonus mt20"><?php echo __('and_earn_bonus_label');?></a>
        </div>
    </div>
    <!--Refere Friend END-->
        <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($userid) && ($user_type == ADMIN) ) ){?>
	<!--Future-->
	<?php if($count_future_result_index>0){?>
	<div class="sidebar_action fl clr mt15">
		<div class="sidebar_title fl clr"><h4 class="fl clr" title="<?php echo __('future_auction_label');?>"><?php echo __('future_auction_label');?></h4></div>
		<div class="sidebar_future_action fl clr">
			<?php 
			foreach($future_results as $future_result):?>
			<div class="future_auction fl clr">
			<div class="future_auction_left fl">
                <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $future_result['product_url'];?>" title="<?php echo $future_result['product_name'];?>"> 
                     <?php 
				
				if(($future_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$future_result['product_image']))
	       			{ 
					
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$future_result['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
				}
			?>
	                <img src="<?php echo $product_img_path;?>" width="50" height="50" align="middle" title="<?php echo ucfirst($future_result['product_name']);?>" alt="<?php echo $future_result['product_name'];?>"/>
                </a>
            </div>
			<div class="future_auction_right fl ml10">
				<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $future_result['product_url'];?>" class="fl clr future_auction_name" title="<?php echo $future_result['product_name'];?>">
					<?php echo ucfirst($future_result['product_name']);?>
                </a>
                <div class="future_auction_detail fl clr mt5">
                  
                    <p class="fl clr"><?php echo $status=($today>$future_result['increment_timestamp'])?__("start_on_label")." ".substr($auction->date_to_string($future_result['startdate']),7,20):__("start_on_label")." ".$auction->date_to_string($future_result['startdate']);?></p>
                </div>	
                </div>
			</div>
			<?php endforeach; ?>
			<?php if($count_future_result_index >3){?>
			<div class="view_detail fl clr pt10 pb10"><a  title="<?php echo __('more_link_label');?>"  href="<?php echo URL_BASE;?>auctions/future" class="fr"><?php echo __('more_link_label');?></a></div><?php } ?>
		</div>
		
	</div>
<?php }  ?><?php if($count_closed_result_index >0){?>
	<!-- Recently closed-->
	<div class="sidebar_action fl clr mt15">
		<div class="sidebar_title fl clr"><h4 class="fl clr" title="<?php echo __('recently_closed_auctions');?>"><?php echo __("recently_closed_auctions");?></h4></div>
		<div class="sidebar_future_action fl clr">
			<?php 
			foreach($closed_results as $closed_result):?>
			<div class="future_auction fl clr">
			<div class="future_auction_left fl">
                <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $closed_result['product_url'];?>"  title="<?php echo $closed_result['product_name'];?>">
                     <?php 
				
				if(($closed_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$closed_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$closed_result['product_image'];
				}
				else
				{	
					$product_img_path=IMGPATH.NO_IMAGE;					
				}
			?>
	                <img src="<?php echo $product_img_path;?>" width="50" height="50" align="middle" title="<?php echo ucfirst($closed_result['product_name']);?>"/>
                </a>
            </div>
			<div class="future_auction_right fl ml10">
				<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $closed_result['product_url'];?>" class="fl clr future_auction_name" title="<?php echo $closed_result['product_name'];?>">
					<?php echo ucfirst($closed_result['product_name']);?>
                </a>
                <div class="future_auction_detail fl clr mt5">
                    <p class="fl clr"><?php echo __('auction_price_label')?>:<span style="display:block; color:#FF8C00;"> <?php echo $site_currency;?> <b><?php echo $closed_result['current_price'];?></b></span></p>
                    <?php if ($closed_result['lastbidder_userid']!=0) { ?>
                    <p class="fl clr">
                        <?php echo ($closed_result['lastbidder_userid']!=0)?__('winner_label').":  <b>".ucfirst($closed_result['username'])."</b>":__('winner_label').": <b>-</b>";?>
                    </p>
                    <?php }?>
                    <p class="fl clr"><?php echo $status=__("ended_on_label").": ".$auction->date_to_string($closed_result['enddate']);?></p>
                </div>
			</div>
            </div>
			<?php endforeach; ?>
			<?php if($count_closed_result_index >3){?>
			<div class="view_detail fl clr pt10 pb10"><a title="<?php echo __('more_link_label');?>" href="<?php echo URL_BASE;?>auctions/closed" class="fr"><?php echo __('more_link_label');?></a></div><?php } ?>
		</div>
		
	</div>
<?php }?>
<?php }?>
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
                        	<img src="<?php echo IMGPATH;?>pink_method_card.png" alt="Pink Method Card" title="Pink Method Card" class="fl" border="0" />
                    </li>
                    <li class="fl">
                        	<img src="<?php echo IMGPATH;?>hdfc_bank.png" alt="HDFC" title="HDFC" class="fl" border="0" />
                      
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


