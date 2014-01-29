<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--Right side-->
<div class="sidebar_content fr">
   <!--Sidebar Action Timer START-->
	<div class="sidebar_action_time_cnt fl clr">
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
    	<div class="refere_friend_cnt clr">
        	<p><?php echo __('tell_a_friend_label');?></p>
	<?php 
	if($auction_userid){
		$url=URL_BASE."users/friends_invite";
	}
	else
	{
		$url=URL_BASE."users/login";
	}?>
	
            <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($auction_userid) && ($user_type == ADMIN) ) ){?>
            <a href="<?php echo $url;?>" title="and earn Bonus" class="earn_bonus mt20"><?php echo __('and_earn_bonus_label');?></a>
            <?php } ?>
        </div>
    </div>
 </div>
