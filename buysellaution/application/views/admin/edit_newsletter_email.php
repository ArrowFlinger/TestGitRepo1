<?php defined('SYSPATH') OR die("No direct access allowed."); 

 /* Status Box Checked */
//------------------------
 if(isset($edit_newsletter_list['status'])	&& $edit_newsletter_list['status']=="A")
 { $status_checked="checked='checked'"; }
 else if(isset($edit_newsletter_list['status'])	&& $edit_newsletter_list['status']=="I")
 { $status_checked=""; }
 else
 { $status_checked=""; }
?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frmjob_cat" id="frmjob_cat">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("email_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="newsletter_email" readonly="readonly" id="newsletter_email" maxlength="25" value="<?php echo $edit_newsletter_list['email'];?>" />
                                    <span style="padding-left: 5px;" class="error">
					
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
                                  <input type="button" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>master/manage_email_newsletter'" />
                                  <input type="reset" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" value="<?php echo ($action == 'add_category' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'add_category' )?'addcat_submit':'editcat_submit';?>" />
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
	field_focus('category_name');
});
$(document).ready(function(){
      toggle(6);
});
</script>
