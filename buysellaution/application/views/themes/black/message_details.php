<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl">
	<div class="title_temp1 fl clr pt10">
    	<h2 class="fl clr pl10" title="<?php echo __('my_message_details');?>"><?php echo __('my_message_details');?></h2>
        </div>
    	<div class="user_message_list fl clr">
	        <div id="managetable" class="fl clr">
	        <?php 
		 if($message_results>0){ 
	        foreach($message_results as $message_result):
	        ?> 
			<div class="messgae_detail_title fl">
            	<span class="package_title_left fl"></span>
                <div class="title_colm1 fl messgae_title_middle">
                	<b><?php echo __('sub:');?> <?php echo $message_result['usermessage_subject'];?></b>
                </div>
                <span class="package_title_left package_title_right fl"></span>
            </div>    
            <div class="messgae_detail_content fl">
            	<table width="600" border="0" align="left" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td width="25" valign="top" align="left">
					<?php 
				
				if(($message_result['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH.$message_result['photo']))
	       			{ 
					 $user_img_path=URL_BASE.USER_IMGPATH.$message_result['photo'];
				}
				else
				{	
					 $user_img_path=IMGPATH.USER_NO_IMAGE2;					
				}
				?>
                			<img src="<?php echo $user_img_path;?>" alt="User Name"  width="40" height="40" class="fl mt3 msg_user_icon" />        
                        </td>
                        <td width="565" align="right">
                        	<table width="565" border="0" cellpadding="0" cellspacing="0">
                            	<tr>
                                	<td>
                                    	<p class="msg_from_detail fl clr"><b><?php echo $site_settings[0]['site_name']; ?></b> <?php echo $message_result['usermessage_from'];?></p>
                                        <p class="msg_from_detail fl clr mt5">to <?php echo $message_result['usermessage_to'];?></p>                            
                                    </td>
                                </tr>
                                <tr>
                                	<td>
                                    	<p class="msg_from_detail fl clr mt20">
                                        	
                                            
                                        	<?php echo $message_result['usermessage_message'];?>
                                        </p>
                                        
                                        <!--THANKS AND REGADS-->
                                        <p class="regards_detail fl clr mt20">
                                        	<span><?php //echo __('thanks_and_regards');?></span><br />
                                            <strong><?php //echo $admin_username[0]['username'];?></strong>
                                        </p>
                                    </td>
                                </tr>	
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            
	       
	       <?php break; endforeach; ?>
		<?php }
	        else
	        {
	        ?>
	        <h4 class="no_data fl clr"><?php echo __("no_my_messages_auction_at_the_moment");?></h4> 
	        <?php 
	        }?>
<!--BACK LINK START-->
    <div class="clr pt10">
    <a href="<?php echo URL_BASE;?>users/my_message" title="<?php echo __('back_link');?>" class="back_link fr"><?php echo __('back_link');?></a>
    </div>
    <!--BACK LINK END-->
	        </div>
	        <!--back button-->
	        	
                <div class="clear"></div>
	        <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	        </div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_message_active").addClass("user_link_active");});
</script>
