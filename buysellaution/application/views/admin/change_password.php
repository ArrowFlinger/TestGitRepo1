<?php defined('SYSPATH') OR die("No direct access allowed."); 

 /* Status Box Checked */
//------------------------
 

$sucessful_message=Message::display();

if($sucessful_message) { ?>
    <div id="messagedisplay" class="padding_150">
         <div class="notice_message">
            <?php echo $sucessful_message; ?>
         </div>
    </div>
<?php }

 ?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frmjob_cat" id="frmjob_cat" action ="<?php echo URL_BASE;?>manageusers/change_password">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                        <tr>
                                <td valign="middle" width="20%"><label><?php echo __("oldpassword_label"); ?></label></td>                                
                                <td valign="middle">
                                    <input type="password" name="old_password" id="old_password" maxlength="16" value="" />
                                    <span style="padding-left: 5px;" class="error">
									<?php echo isset($pass_mismatch)?$pass_mismatch:''; echo array_key_exists('old_password',$errors)?ucfirst($errors['old_password']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>     
                        <tr>
                                <td valign="middle" width="20%"><label><?php echo __("newpassword_label"); ?></label></td>                                
                                <td valign="middle">
                                    <input type="password" name="new_password" id="new_password" maxlength="16" value="" />
                                    <span style="padding-left: 5px;" class="error">
									<?php echo isset($errors['new_password'])?ucfirst($errors['new_password']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>                 
                        <tr>
                                <td valign="middle" width="20%"><label><?php echo __("confirm_password_label"); ?></label></td>                                
                                <td valign="middle">
                                    <input type="password" name="confirm_password" equalTo="#newpassword" id="confirm_password" maxlength="16" size="30" />
                                    <span style="padding-left: 5px;" class="error">
									<?php echo isset($errors['confirm_password'])?ucfirst($errors['confirm_password']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>                 
                                          
                       
                         <tr>
                        	<td colspan="2" class="star"><?php echo __('all_required_label'); ?></td>
                        </tr> 
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                              <input type="button" value="<?php echo __('button_back');?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/myinfo/<?php echo $admin_session_id; ?>'" />
                                  <input type="submit" value="<?php echo __('button_reset'); ?>" name="change_pass"/>
                                  <input type="submit" value="<?php echo ($action == 'password_submit' )?''.__('button_add').'':''.__('button_update').'';?>" name="submit_change_pass" />
                                  
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr> 
                 </table>
                </form> 
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>

