<?php defined('SYSPATH') OR die("No direct access allowed."); 
//For Notice Messages
//===================

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
       
                <form method="POST" class="admin_form" action="<?php echo URL_BASE;?>settings/site_settings_meta/" >
                        <table class="0" cellpadding="7" cellspacing="0" width="100%">
                                <tr>
                                        <td valign="top"><label><?php echo __('meta_key_label');?> </label><span class="star">*</span></td>   
                                        <td><input type="text" name="meta_keywords" id="meta_keywords" class="meta_keywords" title="Enter your meta_keywords" maxlength="126" value="<?php echo isset($site_meta) &&  (!array_key_exists('meta_keywords',$errors))? trim($site_meta[0]['meta_keywords']):$validator['meta_keywords'];?>"><span class="info_label"><?php echo __('you_can_make_changes_in_meta_keywords.'); ?></span>
                                         <span class="error"><?php echo isset($errors['meta_keywords'])?ucfirst($errors['meta_keywords']):''; ?></span></td>
                                </tr>
                                 <tr>
                                        <td width="17%" valign="top"><label><?php echo __('meta_desc_label');?> </label><span class="star">*</span></td>   
                                        <td><textarea class="resizetextarea" name="meta_description" id="meta_description"  onkeyup="return limitlength(this, <?php echo $product_settings[0]['max_desc_length'];?>)" class="meta_description"   cols="10" rows="7" ><?php echo isset($site_meta) &&  (!array_key_exists('meta_description',$errors))? trim($site_meta[0]['meta_description']):$validator['meta_description'];?></textarea><span class="info_label"><?php echo __('you_can_make_changes_in_meta_description.'); ?></span>
                                         <span class="error fl clr p0 width100"><?php echo isset($errors['meta_description'])?ucfirst($errors['meta_description']):''; ?></span>
                                          <span class="info_label" id="info_label"></span> 
                                   <span class="info_label" id="info_label">
                                  
                                   <?php echo __('info_product_name');?>:<?php echo $product_settings[0]['max_desc_length'];?>
                                  </span>         
                                         
                                         </td>
                                </tr>                               
                      <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>                        
                                <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                         <input type="reset" name="metasettings_reset" value="<?php echo __('button_reset');?>" title="<?php echo __('button_reset');?>">
                                        <input type="submit" name="metasettings_submit" title="<?php echo __('button_update');?>" value="<?php echo __('button_update');?>" >
					                  
                                        </td>
                                </tr>
                                
                                </table>
                           
                </form>
                <br/><br/>
              
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>

</div>
<script type="text/javascript" language="javascript">

//code for checking message field maxlength
//============================
function limitlength(obj, maxlength){
        //var maxlength=length
        if (obj.value.length>maxlength){
                obj.value=obj.value.substring(0, maxlength);
                // max reach
              
                document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
                //alert(charleft);
                //inner html
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }     
} 

$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('meta_keywords');

}); 

$(document).ready(function(){
      toggle(8);
});
</script>
