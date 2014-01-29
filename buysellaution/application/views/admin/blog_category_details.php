<?php defined('SYSPATH') OR die("No direct access allowed."); 

 /* Status Box Checked */
//------------------------
 if(isset($blog_categories['status'])&& $blog_categories['status']=="A")
 { $status_checked="checked='checked'"; }
 else if(isset($blog_categories['status'])&& $blog_categories['status']=="I")
 { $status_checked=""; }
 else
 { $status_checked=""; }
?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frmjob_cat" id="frmjob_cat" action ="<?php echo URL_BASE;?>blog/<?php echo $action;?>">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("category_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="category_name" id="category_name" maxlength="20" value="<?php echo isset($blog_categories['category_name']) && !array_key_exists('category_name',$errors) ? trim($blog_categories['category_name']) : $validator['category_name']; ?>" />
                                    <span style="padding-left: 5px;" class="error">
									<?php echo $category_exists; ?><?php echo isset($errors['category_name'])?ucfirst($errors['category_name']):""; ?>
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
                                  <input type="button" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>blog/blog_category'" />
                                  <input type="reset" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" value="<?php echo ($action == 'add_blog_category' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'add_blog_category' )?'addcat_submit':'editcat_submit';?>" />
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
      toggle(9);
});
</script>
