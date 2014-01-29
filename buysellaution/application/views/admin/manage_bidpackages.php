<?php defined('SYSPATH') OR die("No direct access allowed."); 

 /* Status Box Checked */
//------------------------
	
 if(isset($bid_packages['status'])	&& $bid_packages['status']=="A")
 { $status_checked="checked='checked'"; }
 else if(isset($bid_packages['status'])	&& $bid_packages['status']=="I")
 { $status_checked=""; }
 else
 { $status_checked=""; }
?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frmbid_package" id="frmbid_package" action ="<?php echo URL_BASE;?>adminauction/<?php echo $action;?>">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("bid_name_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="name" id="name" maxlength="128" value="<?php echo isset($bid_packages['name']) && !array_key_exists('name',$errors) ? trim($bid_packages['name']) : $validator['name']; ?>" />
                                    <span style="padding-left: 5px;" class="error">
									<?php echo $bidpackage_name_exists; ?><?php echo isset($errors['name'])?ucfirst($errors['name']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>    
                         <tr>
                                <td valign="top" width="20%"><label><?php echo __("bid_price_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="price" id="price" maxlength="10" value="<?php echo isset($bid_packages['price']) && !array_key_exists('price',$errors) ? $bid_packages['price'] : $validator['price']; ?>" />
                                    <span style="padding-left: 5px;" class="error">
									<?php echo isset($errors['price'])?ucfirst($errors['price']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>                                                                                   
                        <tr>
                                <td valign="top"><label><?php echo __("status_label"); ?></label></td>                               
                                <td colspan="2" valign="middle">
                                    <input type="checkbox" name="status[]" value="A" <?php echo $status_checked; ?> />                                
                                </td>
                               
                        </tr> 
                         <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr> 
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  <input type="button" title="<?php echo __('button_back'); ?>"value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>adminauction/bidpackages'" />
                                  <input type="reset" title="<?php echo __('button_reset'); ?>" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" title="<?php echo __('button_add'); ?>"value="<?php echo ($action == 'manage_bidpackages' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'manage_bidpackages' )?'addbid_submit':'editbid_submit';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr> 
                 </table>
                </form> 
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	//For Field Focus
	//===============
	field_focus('name');
});
</script>
