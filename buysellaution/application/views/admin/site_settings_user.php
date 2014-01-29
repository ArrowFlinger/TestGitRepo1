<?php defined('SYSPATH') OR die("No direct access allowed."); 
//For Notice Messages
//print_r($user_setting_data);
$sucessful_message=Message::display();

if($sucessful_message) { ?>
    <div id="messagedisplay" class="padding_150">
         <div class="notice_message">
            <?php echo $sucessful_message; ?>
         </div>
    </div>
<?php } ?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle" >
       
                <form method="POST" class="admin_form" action="<?php echo URL_BASE;?>settings/site_settings_user/" >
                        <table class="list_table1 fl clr">
                                
                                 <tr>
                                        <td></td>   
                                        <td>
                                          <input type="checkbox" name="email_verification" value="Y"  <?php echo ($user_setting_data[0]['email_verification_reg']=="Y")?"checked='checked'":"";?>><label><?php echo __('email_verify_label');?></label>
                                          <p><?php echo __('email_verify_content');?></p>                                       
                                        </td>                           
                                </tr>
                                 <tr>
                                        <td></td>   
                                        <td>
                                          <input type="checkbox" name="auto_login" value="Y" <?php echo ($user_setting_data[0]['auto_login_reg']=="Y")?"checked='checked'":"";?> ><label><?php echo __('auto_login_label');?></label>
                                       <p><?php echo __('auto_login_content');?></p>
                                        </td>                           
                                </tr>
                                 <tr>
                                        <td></td>   
                                        <td>
                                          <input type="checkbox" name="admin_notification" value="Y" <?php echo ($user_setting_data[0]['admin_notification_reg']=="Y")?"checked='checked'":"";?> ><label><?php echo __('notification_mail_label');?></label>
                                         <p><?php echo __('notification_mail_content');?></p>
                                        </td>                           
                                </tr>
                                 <tr>
                                        <td></td>   
                                        <td>
                                          <input type="checkbox" name="welcome_mail" value="Y" <?php echo ($user_setting_data[0]['welcome_mail_reg']=="Y")?"checked='checked'":"";?> ><label><?php echo __('welcome_mail_label');?></label>
                                       <p><?php echo __('welcome_mail_content');?></p>
                                        </td>                           
                                </tr>
                                 <tr>
                                        <td></td>   
                                        <td>
                                          <input type="checkbox" name="logout" value="Y" <?php echo ($user_setting_data[0]['logout_change_pass']=="Y")?"checked='checked'":"";?> ><label><?php echo __('password_change_label');?></label>
                                       <p><?php echo __('password_change_content');?></p>
                                        </td>                           
                                </tr>
                                 <tr>
                                        <td></td>   
                                        <td>
                                          <input type="checkbox" name="allow_user" value="Y" <?php echo ($user_setting_data[0]['allow_user_language']=="Y")?"checked='checked'":"";?> ><label><?php echo __('switch_language_label');?></label>
                                       <p><?php echo __('switch_language_content');?></p>
                                        </td>                           
                                </tr>
                                
                                <tr>
                                        <td></td>   
                                        <td>
                                          <input type="checkbox" name="admin_activation" value="Y" <?php echo ($user_setting_data[0]['admin_activation_reg']=="Y")?"checked='checked'":"";?> ><label><?php echo __('register_activation_label');?></label>
                                       <p><?php echo __('register_activation_content');?></p>
                                        </td>                           
                                </tr>
                                 <tr>
                                        <td><label><?php echo __('inactive_notify_label');?></label></td>   
                                        <td><input type="text" name="inactive_users" id="inactive_users" class="inactive_users" title="Enter your Notification for inactive users" maxlength="5" value="<?php echo isset($errors['inactive_users'])?$validator['inactive_users']:$user_setting_data[0]['inactive_users'];?>" >
                                         <span class="error"><?php echo isset($errors['inactive_users'])?ucfirst($errors['inactive_users']):''; ?></td>
                                </tr>
                                <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <input type="reset" name="usersettings_reset" title="<?php echo __('button_reset');?>"value="<?php echo __('button_reset');?>">
                                        <input type="submit" name="usersettings_submit" title="<?php echo __('button_update');?>"value="<?php echo __('button_update');?>" >
                                       </td></tr>
                                </table>
                           
                </form>
                <br/><br/>
              
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
      toggle(8);
});

</script>
