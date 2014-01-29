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
       
                <form method="POST" class="admin_form" action="<?php echo URL_BASE;?>admin/scratch/scratch_settings/" >
                        <table class="list_table1 fl clr">
                                
                                 <tr>
                                        <td   style="padding:5px 40px;"></td>   
                                        <td>
                                          <input type="checkbox" name="email_verification" value="Y"  <?php echo ($user_setting_data['email_verification_reg']=="Y")?"checked='checked'":"";?>><label><?php echo __('scratchemail_verify_label');?></label>
                                          <p><?php echo __('scratchemail_verify_content');?></p>                                       
                                        </td>                           
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
