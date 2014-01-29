<?php defined('SYSPATH') OR die("No direct access allowed."); 


 /* Status Box Checked */	
 if(isset($add_bonus['bonus_status'])	&& $add_bonus['bonus_status']=="A")
 { $status_checked="checked='checked'"; }
 else if(isset($add_bonus['bonus_status'])	&& $add_bonus['bonus_status']=="I")
 { $status_checked=""; }
 else
 { $status_checked="checked='checked'"; }
?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frm_bonus" id="frm_bonus" action ="<?php echo URL_BASE;?>adminauction/<?php echo $action;?>">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("bonus_type_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="bonus_type" id="bonus_type" maxlength="128" value="<?php echo isset($add_bonus['bonus_type']) && !array_key_exists('bonus_type',$errors) ? trim($add_bonus['bonus_type']) : $validator['bonus_type']; ?>" readonly="readonly" />
                                    <span style="padding-left: 5px;" class="error">
						<?php echo $bonus_type_exists;?>
						<?php echo isset($errors['bonus_type'])?ucfirst($errors['bonus_type']):""; ?>
                                    </span>
                                </td>
                        </tr>  
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("bonus_amount_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="bonus_amount" id="bonus_amount" maxlength="128" value="<?php echo isset($add_bonus['bonus_amount']) && !array_key_exists('bonus_amount',$errors) ? trim($add_bonus['bonus_amount']) : $validator['bonus_amount']; ?>" />
                                    <span style="padding-left: 5px;" class="error">
					<?php echo $bonus_type_exists; ?>
					<?php echo isset($errors['bonus_amount'])?ucfirst($errors['bonus_amount']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>
                         <tr>
                                <td valign="top"><label><?php echo __("status_label"); ?></label></td>                               
                                <td colspan="2" valign="middle">
                                    <input type="checkbox" name="bonus_status[]" value="A" <?php echo $status_checked; ?> />                                
                                </td>
                        </tr>
                         <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>
                        <!--End bonus type else part-->    
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  <input type="button" title="<?php echo __('button_back'); ?>"value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>adminauction/manage_bonus'" />
                                  <input type="reset" title="<?php echo __('button_reset'); ?>" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" title="<?php echo __('button_add'); ?>"value="<?php echo ($action == 'add_bonus' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'add_bonus' )?'addbonus_submit':'editbonus_submit';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr>
                 </table>
                </form>
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>

