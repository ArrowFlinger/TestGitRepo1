<?php defined('SYSPATH') OR die("No direct access allowed."); 
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
       
                <form method="POST" class="admin_form" action="<?php echo URL_BASE;?>settings/manage_mail_settings" >
                        <table class="0" cellpadding="5" cellspacing="0" width="99%">
                        		<tr>
                        		<td></td>
                        		<td><?php echo __('mail_settings_label');?></td>
                        		</tr>
                                <tr>
                                        <td valign="top"><label><?php echo __('smtp_host_label');?> </label><span class="star">*</span></td>   
                                        <td><input type="text" name="smtp_host" id="smtp_host" class="site_name" title="Enter your host name" maxlength="150" value="<?php echo isset($mail_settings) &&  (!array_key_exists('smtp_host',$errors))? $mail_settings[0]['smtp_host']:$validator['smtp_host'];?>">
                                         <span class="error"><?php echo isset($errors['smtp_host'])?$errors['smtp_host']:''; ?></span></td>
                                </tr>
                                
                              
                                 <tr>
                                        <td width="30%" valign="top"><label><?php echo __('smtp_port_label');?> </label><span class="star">*</span></td>   
                                        <td><input type="text" name="smtp_port" id="smtp_port" class="site_slogan" title="Enter your port number" maxlength="4" value="<?php echo isset($mail_settings) &&  (!array_key_exists('smtp_port',$errors))? $mail_settings[0]['smtp_port']:$validator['smtp_port'];?>">
                                         <span class="error"><?php echo isset($errors['smtp_port'])?$errors['smtp_port']:''; ?></span></td>
                                </tr>
                               
                                 <tr>
                                        <td valign="top"><label><?php echo __('smtp_username_label');?> </label><span class="star">*</span></td>   
                                        <td><input type="text" name="smtp_username" id="smtp_username" class="site_version" title="Enter your username" maxlength="256" value="<?php echo isset($mail_settings) &&  (!array_key_exists('smtp_username',$errors))? $mail_settings[0]['smtp_username']:$validator['smtp_username'];?>">
                                         <span class="error"><?php echo isset($errors['smtp_username'])?$errors['smtp_username']:''; ?></span></td>
                                </tr>
                                <tr>
                                        <td valign="top"><label><?php echo __('smtp_password_label');?> </label><span class="star">*</span></td>   
                                        <td><input type="password" name="smtp_password" id="smtp_password" class="contact_email" title="Enter your password" maxlength="128" value="<?php echo isset($mail_settings) &&  (!array_key_exists('smtp_password',$errors))? $mail_settings[0]['smtp_password']:$validator['smtp_password'];?>">
                                         <span class="error"><?php echo isset($errors['smtp_password'])?$errors['smtp_password']:''; ?></span></td>
                                </tr>
 
						                  <tr>
						                     <td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
						                 </tr>                                
                                <tr>
                                        <td valign="top">&nbsp;</td>
                                        <td>
                                        <input type="reset" name="editmailsettings_reset" title="<?php echo __('button_reset');?>" value="<?php echo __('button_reset');?>">
                                        <input type="submit" name="editmailsettings_submit" title ="<?php echo __('button_update');?>" value="<?php echo __('button_update');?>">
						              
				</td></tr>
                                </table>
                           
                </form>
                <br/><br/>
              
        </div>

        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt" ></div></div>
</div>

</div>
<script type="text/javascript" language="javascript">
$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('smtp_host');

}); 


$(document).ready(function(){
      toggle(8);
});
</script>
