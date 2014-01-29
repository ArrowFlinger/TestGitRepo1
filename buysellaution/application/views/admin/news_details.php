<?php defined('SYSPATH') OR die("No direct access allowed."); 
echo html::script('public/ckeditor/ckeditor.js');
 /* Status Box Checked */
//------------------------
 if(isset($auction_news['status'])&& $auction_news['status']=="A")
 { $status_checked="checked='checked'"; }
 else if(isset($auction_news['status'])	&& $auction_news['status']=="I")
 { $status_checked=""; }
 else
 { $status_checked=""; }
?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="news" id="news" action ="<?php echo URL_BASE;?>adminnews/<?php echo $action;?>">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                
                        <!-- News Title -->
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("news_title"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="news_title" id="news_title" maxlength="64" value="<?php echo isset($auction_news['news_title']) && !array_key_exists('news_title',$errors) ? trim($auction_news['news_title']) : $validator['news_title']; ?>" />
                                    <span style="padding-left: 5px;" class="error">
									<?php echo $news_exists; ?><?php echo isset($errors['news_title'])?ucfirst($errors['news_title']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>
                        
                        <!-- News Description -->
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("news_description"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                               
                                
                                    <textarea name="news_description" id="news_description" style="width=400px;" rows="10" cols="20" value="" class="resizetextarea" onkeyup="return limitlength(this, <?php echo $product_settings[0]['max_desc_length'];?>,'product_info_label')"><?php echo isset($auction_news['news_description']) && !array_key_exists('product_info',$errors)? $auction_news['news_description']:$validator['news_description']; ?></textarea>
                                    <span style="padding-left: 5px;" class="error">
									<?php echo isset($errors['news_description'])?ucfirst($errors['news_description']):""; ?>
                                    </span>
                                    <span class="info_label" id="info_label"></span>
                                    <span class="info_label" id="info_label">
                                    <?php echo __('info_product_name');?>:<?php echo $product_settings[0]['max_desc_length'];?>
                                    </span>
                                
                                </td>
                        </tr>
                           
                        <!-- Status -->               
                        <tr>
                                <td valign="top"><label><?php echo __("status_label"); ?></label></td>                               
                                <td colspan="2" valign="middle">
                                  <input type="checkbox" name="status[]" value="A" <?php echo $status_checked; ?> />                                
                                </td>
                               
                        </tr> 
                        
                        <!-- Required -->
                         <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr> 
                        
                        <!-- Button for ( Back , Reset & Submit ) -->
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  <input type="button" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>adminnews/manage_news'" />
                                  <input type="reset" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" value="<?php echo ($action == 'add_news' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'add_news' )?'addnews_submit':'editnews_submit';?>" />
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

$(document).ready(function() {
	//For Field Focus
	//===============
	field_focus('news_name');
});


//code for checking message field maxlength
//============================
function limitlength(obj, maxlength){
        //var maxlength=length
        if (obj.value.length>maxlength){
                obj.value=obj.value.substring(0, maxlength);
                // max reach
                //$("span.info_label").html("<?php echo __('ddfdsfdsf');?>");
                document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
                //alert(charleft);
                //inner html
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }
}
</script>
