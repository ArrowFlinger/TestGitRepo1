<?php defined("SYSPATH") or die("No direct script access."); ?>
<link type="text/css" href="<?php echo CSSPATH;?>ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>jquery-ui-1.8.16.custom.min.js"></script>
<div class="my_message_right">
	<div class="message_common_border">
		<h1 title="<?php echo __('mydashboard');?>"><?php echo __('mydashboard');?></h1>
		<p>&nbsp;</p>
		</div>
	<div class="message_common">
		<div class="dasbord_common">
		<div class="das_inner">
			<div class="das_inner_text">
				<h3><?php echo __('Things_to_do');?> :</h3>
			</div>
		<div class="roled_images">
			<div class="inner_rol_img">
			<div class="box_top"></div>
			<div class="box_mid">
				<div class="bot_img">
					<div class="bot_com">&nbsp;</div>
						<a href="<?php echo URL_BASE.'packages';?>" title="<?php echo __('buy_some_packages');?>" ><h4><?php echo __('buy_some_packages');?></h4></a>
					</div>
				</div>
			<div class="box_bot"></div>
			</div>
			<div class="inner_rol_img">
				<div class="box_top"></div>
				<div class="box_mid">
					<div class="bot_img">
						<div class="bot_com1">&nbsp;</div>
							<a href="<?php echo URL_BASE.'users/won_auctions';?>" title="<?php echo __('view_your_won_auctions');?>" ><h4><?php echo __('view_your_won_auctions');?></h4></a>
						</div>
					</div>
				<div class="box_bot"></div>
				</div>

			<div class="inner_rol_img">
				<div class="box_top"></div>
				<div class="box_mid">
					<div class="bot_img">
						<div class="bot_com2">&nbsp;</div>
							<a href="<?php echo URL_BASE.'users/watchlist';?>" title="<?php echo __('view_my_watchlist');?>" ><h4><?php echo __('view_my_watchlist');?></h4></a>
						</div>
					</div>
				<div class="box_bot"></div>
				</div>

			<div class="inner_rol_img">
				<div class="box_top"></div>
				<div class="box_mid">
					<div class="bot_img">
						<div class="bot_com3">&nbsp;</div>
							<a href="javascript:;" title="<?php echo __('earn_bonus');?>"  id="dialog_link"><h4><?php echo __('earn_bonus');?></h4></a>
						</div>
					</div>
				<div class="box_bot"></div>
				</div>
			<div class="common_bounce">
				<div class="common_bounce_text">
					<h2 title="<?php echo __('my_dashboard');?>"><?php echo __('my_dashboard');?></h2>
					<p><?php echo __('you_currently_have');?><span class="red_col"> <?php echo $site_currency." ".Commonfunction::numberformat($balance);?> </span><?php echo __('in_your_account');?>.</p>
					<h3><?php echo __('your_bonus_is');?> <span  class="red_col"><?php echo $site_currency." ".$user_current_bonus;?></span></h3>
				</div>
			</div>

			</div>
		</div>
		</div>

	</div>
</div>
</div>
<!--Modal Window-->
<div id="dialog" title="<?php echo __('earn_bonus');?>" style="display:none;">
	<div class="fl fb_share"><a href="<?php echo URL_BASE;?>socialnetwork/facebookshare" title="<?php echo __('facebook_share');?>"><img src="<?php echo IMGPATH;?>facebook_shareicon.png" alt="<?php echo __('facebook_share');?>" title="<?php echo __('facebook_share');?>"/></a></div>
<div class="fl tw_share" ><a href="<?php echo URL_BASE;?>socialnetwork/twittershare" title="<?php echo __('twitter_share');?>"><img src="<?php echo IMGPATH;?>twitter_shareicon.png" alt="<?php echo __('twitter_share');?>"/></a></div>
	<p class="clr"><?php //echo __('facebookandtwitter_share_msg');?></p>	
</div>
 
<script type="text/javascript">
// Dialog			
 
				$('#dialog').dialog({
					autoOpen: false,
					width: 300,
					modal: true
				});
				$('#dialog_link').click(function(){
				 
				         
					$('#dialog').dialog('open');
					return false;
				});
				
				if(window.location.hash=="#_=_")
				{
					window.location.hash="dashboard";
				}
//});

</script>
<script type="text/javascript">
$(document).ready(function () {$("#dashboard_active").addClass("act_class");});
</script>

