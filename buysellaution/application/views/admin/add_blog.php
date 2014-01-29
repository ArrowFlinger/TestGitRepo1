<?php defined('SYSPATH') OR die("No direct access allowed."); 
//Editor Included
echo html::script('public/ckeditor/ckeditor.js');
/* Status Box Checked */
//------------------------
 if(isset($blog_data['status'])	&& $blog_data['status']=="A")
 { $status_checked="checked='checked'"; }
 else if(isset($blog_data['status'])	&& $blog_data['status']=="I")
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
                                <td valign="top" width="20%"><label><?php echo __("blog_title_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="blog_title" id="blog_title" maxlength="128" value="<?php echo isset($blog_data['blog_title']) && !array_key_exists('blog_title',$errors) ? trim($blog_data['blog_title']) : $validator['blog_title']; ?>" />
                                    <span style="padding-left: 5px;" class="error">
                                    <?php echo isset($blog_exists)?ucfirst($blog_exists):""; ?>
					<?php echo isset($errors['blog_title'])?ucfirst($errors['blog_title']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("blog_category_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                               
                                     <select name="category" id="category">
					<option value=""><?php echo __('select_label'); ?></option>
                                        <?php 
                                        //code to display username drop down
                                        foreach($blog_category_list as $blog_category)
                                        { 
                                        if (!isset($blog_data)){ 
                                        $selected_blog_category="";  	
                                        $selected_blog_category=($blog_category['id']==$blog_category_list) ? " selected='selected' " : ""; 
                                        ?>
                                        <option value="<?php echo $blog_category['id']; ?>"  <?php echo $selected_blog_category; ?>><?php echo $blog_category['category_name'];?></option><?php }else{?>
                                        <option value="<?php echo $blog_category['id']; ?>"  <?php echo ($blog_data['category'] == $blog_category['id'])?"selected='selected'":"";?>><?php echo $blog_category['category_name'];?></option>
                                        <?php } }?>
                        </select>
                             <span style="padding-left: 5px;" class="error">
				<?php echo isset($errors['category'])?ucfirst($errors['category']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>    
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("blog_description_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                <textarea class="ckeditor" name="blog_description" id="blog_description" ><?php echo isset($blog_data['blog_description']) && !array_key_exists('blog_description',$errors) ? trim($blog_data['blog_description']) : $validator['blog_description']; ?></textarea>
                                    
                                    <span style="padding-left: 5px;" class="error">
					<?php echo isset($errors['blog_description'])?ucfirst($errors['blog_description']):""; ?>
					<br></span><br><div>
					<?php echo __('max_length').":  500";?>
                                    </div>
                                    
                                    
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
                                  <input type="button" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>blog/index'" />
                                  <input type="reset" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" value="<?php echo ($action == 'add_blog' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'add_blog' )?'addblog_submit':'editblog_submit';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr> 
                 </table>
                </form> 
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
