<?php defined('SYSPATH') OR die("No direct access allowed."); 

//For Notice Messages
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
       
                <form method="POST" class="admin_form" action="<?php echo URL_BASE;?>settings/site_bonus_settings/" >
                        <table class="list_table1 fl clr">
                                
                                 <tr>
                                        <td></td>   
                                        <td>
                                          <input type="checkbox" name="facebook_verification" value="Y"  <?php echo ($bonus_setting_data[0]['facebook_verification']=="Y")?"checked='checked'":"";?>><label><?php echo __('facebook_verification');?></label>
                                          <p><?php echo __('facebook_verify_content');?></p>                                       
                                        </td>                           
                                </tr>
                                 <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <input type="reset" name="bonussettings_reset" title="<?php echo __('button_reset');?>"value="<?php echo __('button_reset');?>">
                                        <input type="submit" name="bonussettings_submit" title="<?php echo __('button_update');?>"value="<?php echo __('button_update');?>" >
                                       </td></tr>
                                
                                </table>
                           
                </form>
                <br/><br/>
              
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>

</div>
