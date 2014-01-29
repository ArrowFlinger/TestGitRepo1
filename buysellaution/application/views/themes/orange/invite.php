<?php defined("SYSPATH") or die("No direct script access."); ?>
<style type="text/css">.fb_ltr{width:678px !important;}</style>
<div class="content_left_out fl">
<div class="action_content_left fl">
	<div class="title_temp1 fl clr pt10">
    	<h2 class="fl clr pl10" title="<?php echo __('friend_invite');?>"><?php echo __('friend_invite');?></h2>
    </div>
    	<?php 	$ids=isset($exclude_ids)?substr($exclude_ids,0,-1):0;
		$friendly_msg="Welcome to".$site_name." !!!";
		$link_to_show_in_invitation="<a href='".URL_BASE."users/dashboard/'>".URL_BASE."</a>";
		$accept_redirect_url=URL_BASE."cmspage/page/how-it-works?source=facebookinvite&uid=".$referrer_id[0]['referral_id']."&type=".FACEBOOK_INVITE;
		$form_action=URL_BASE."users/invite/facebookinvitesucess";

		$mess=htmlspecialchars($friendly_msg.$link_to_show_in_invitation."<fb:req-choice url='".$accept_redirect_url."' label='".URL_BASE."'",ENT_QUOTES);?>
	
	<?php echo $include_facebook;?>
	<!--Iframe invitation facebook-->
	<fb:serverFbml style="width:670px;">
        <script type="text/fbml" width="670px">
                    
                            <fb:request-form  content='<?php echo $mess;?>' type="Auction" invite="true" method="POST" action="<?php echo $form_action;?>">
                                <fb:multi-friend-selector showborder="false" cols="4" rows="5"  email_invite='0' import_external_friends='0' exclude_ids='<?php echo $ids;?>' actiontext="<?php echo $site_name;?> Invitation."/>
                            </fb:request-form>
                       
       	 </script>
   	 </fb:serverFbml>
	<!--Iframe invitation facebook-->
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_pending_active").addClass("user_link_active");});
</script>
