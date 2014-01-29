<?php defined('SYSPATH') OR die("No direct access allowed.");
echo html::script('public/ckeditor/ckeditor.js');
 /* Status Box Checked */
//------------------------
$status_checked ="";
 if(isset($page_data['status'])	&& $page_data['status']=="A")
 { $status_checked="checked='checked'"; }
 ?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frmpages" id="frmpages" action ="<?php echo URL_BASE;?>cms/<?php echo $action;?>">
                <table border="0"  align="left" cellpadding="10" cellspacing="0" width="100%">
                        <tr>
                                <td valign = "top" width="20%"><label><?php echo __('page_title'); ?></label><span class="star">*</span></td>
                                <td>
                                		<input type="text" name="page_title" id="page_title" maxlength="50" value="<?php echo isset($page_data['page_title']) && !array_key_exists('page_title',$errors)? trim($page_data['page_title']):$validator['page_title'];?>"/>
                                   <span class="error">
                                        <?php echo isset($errors['page_title'])?ucfirst($errors['page_title']):""; ?>
                                    </span>
                                </td>
                        </tr>
                        <tr>
                                <td valign = "top" width="20%"><label><?php echo __('meta_title_label'); ?></label><span class="star">*</span></td>                               
                                <td>
                                	<input type="text" name="meta_title" id="meta_title" maxlength="50"  value="<?php echo isset($page_data['meta_title']) && !array_key_exists('meta_title',$errors)? trim($page_data['meta_title']):$validator['meta_title'];?>" />
                               		<span class="error">
										<?php echo isset($errors['meta_title'])?ucfirst($errors['meta_title']):""; ?>
									</span>
                                </td>
                        </tr> 
                        <tr>
                                <td valign = "top" width="20%"><label><?php echo __('meta_key_label'); ?></label><span class="star">*</span></td>                               
                                <td>
                                	<input type="text" name="meta_keyword" id="meta_keyword" maxlength="50"  value="<?php echo isset($page_data['meta_keyword']) && !array_key_exists('meta_keyword',$errors)? trim($page_data['meta_keyword']):$validator['meta_keyword'];?>" />
                               		<span class="error">
										<?php echo isset($errors['meta_keyword'])?ucfirst($errors['meta_keyword']):""; ?>
									</span>
									<span class="info_label"><?php echo __('info_meta_keywords');?></span>
                                </td>
                        </tr> 
                  		<!-- Code for enter suggestion-->
                         <tr>
                                <td valign="top" width="20%"><label><?php echo __('page_description'); ?></label><span class="star">*</span></td>
                                <td>
                                	<textarea  class="ckeditor" name="page_description" id="page_description"  value=""><?php echo isset($page_data['page_description']) && !array_key_exists('page_description',$errors)? trim($page_data['page_description']):$validator['page_description'];?></textarea>
                                   <span class="error">
                                        <?php echo isset($errors["page_description"])? ucfirst($errors["page_description"]):""; ?>
                                   </span>
                                   <span class="info_label" id="page_info_label">
                                   <?php echo __('info_product_name');?>:<?php echo 5000;?>
                                  </span>    
                                </td>
                        </tr>
                  		<!-- **ends here** -->                      
                        <tr>
                                <td valign = "top"><label><?php echo __('status_label'); ?></label></td>
                                <td>
                                	<input type="checkbox" name="status[]" value="A" <?php echo $status_checked; ?> /> 

                                    <span style="padding-left: 5px;" class="label_error">
                                        <?php echo isset($errors['status'])?ucfirst($errors['status']):""; ?>
                                    </span> 
                                </td>
                        </tr> 
                         <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr> 
                        <tr>
                                <td colspan="3" style="padding-left:160px;">
                                  <br />
                                  <input type="button" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>cms/manage_static_pages'" />
                                  <input type="reset" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" value="<?php echo ($action == 'edit' )?''.__('button_update').'':''.__('button_update').'';?>" name="<?php echo ($action == 'edit' )?'edit_pages_submit':'edit_pages_submit';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr> 
                 </table>
                </form> 
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>	
</div>
<script type="text/javascript">
$(document).ready(function(){
      toggle(8);
});
</script>

