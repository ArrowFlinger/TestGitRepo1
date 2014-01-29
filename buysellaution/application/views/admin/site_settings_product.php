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
        <form method="POST" class="admin_form" action="<?php echo URL_BASE;?>settings/site_settings_product/" >
                        <table class="0" cellpadding="7" cellspacing="1" width="100%">
                                <tr>
                                        <td valign="top"><label><?php echo __('gig_alt_label',array(':param'=>$product_settings[0]['alternate_name']));?></label><span class="star">*</span></td>   
                                        <td><input type="text" name="alternate_name" maxlength="" id="alternate_name" class="alternate_name"  maxlength="25" value="<?php echo isset($site_settings_product) &&  (!array_key_exists('alternate_name',$errors))? $site_settings_product[0]['alternate_name']:$validator['alternate_name'];?>"><span class="info_label"><?php echo __('product_alt_content',array(':param'=>$product_settings[0]['alternate_name']));?></span>
                                        <span class="error"><?php echo isset($errors['alternate_name'])?ucfirst($errors['alternate_name']):''; ?></span></td>

                                </tr>
                                <tr>
                                        <td valign="top"><label><?php echo __('min_title_label',array(':param'=>$product_settings[0]['alternate_name']));?></label><span class="star">*</span></td>   
                                        <td><input type="text" name="min_title_length" id="min_title_length" class="min_title_length"  maxlength="2" value="<?php echo isset($site_settings_product) &&  (!array_key_exists('min_title_length',$errors))? $site_settings_product[0]['min_title_length']:$validator['min_title_length'];?>"><span class="info_label"><?php echo __('min_title_label',array(':param'=>$product_settings[0]['alternate_name']));?></span>
                                         <span class="error"><?php echo isset($errors['min_title_length'])?ucfirst($errors['min_title_length']):''; ?></span></td>
                                </tr>
                                <tr>
                                        <td valign="top"><label><?php echo __('max_title_label',array(':param'=>$product_settings[0]['alternate_name']));?></label><span class="star">*</span></td>   
                                        <td><input type="text" name="max_title_length" id="max_title_length" class="max_title_length"  maxlength="5" value="<?php echo isset($site_settings_product) &&  (!array_key_exists('max_title_length',$errors))? $site_settings_product[0]['max_title_length']:$validator['max_title_length'];?>"><span class="info_label">
                                        <?php echo __('max_title_content',array(':param'=>$product_settings[0]['alternate_name']));?></span>
                                         <span class="error"><?php echo isset($errors['max_title_length'])?ucfirst($errors['max_title_length']):''; ?></span></td>
                                </tr>
                                 <tr>
                                        <td valign="top"><label><?php echo __('max_desc_label',array(':param'=>$product_settings[0]['alternate_name']));?></label><span class="star">*</span></td>   
                                        <td><input type="text" name="max_desc_length" id="max_desc_length" class="max_desc_length"  maxlength="5" value="<?php echo isset($site_settings_product) &&  (!array_key_exists('max_desc_length',$errors))? $site_settings_product[0]['max_desc_length']:$validator['max_desc_length'];?>"><span class="info_label"><?php echo __('max_desc_content',array(':param'=>$product_settings[0]['alternate_name']));?></span>
                                        <span class="error"><?php echo isset($errors['max_desc_length'])?ucfirst($errors['max_desc_length']):''; ?></span></td>
                                        </td>
                                </tr>                                
		                <!--Min Bidpackages--> 
		                 <tr>
                                        <td valign="top"><label><?php echo __('min_bidpackage_label');?></label><span class="star">*</span></td>   
                                        <td><input type="text" name="min_bidpackages" id="min_bidpackages" class="min_bidpackages"  maxlength="6" value="<?php echo isset($site_settings_product) &&  (!array_key_exists('min_bidpackages',$errors))? $site_settings_product[0]['min_bidpackages']:$validator['min_bidpackages'];?>">
                                        <span class="error"><?php echo isset($errors['min_bidpackages'])?ucfirst($errors['min_bidpackages']):''; ?></span></td>
                                </tr>
                                <tr>
                                        <td valign="top"><label><?php echo __('max_bidpackage_label');?></label><span class="star">*</span></td>   
                                        <td><input type="text" name="max_bidpackages" id="max_bidpackages" class="max_bidpackages"  maxlength="10" value="<?php echo isset($site_settings_product) &&  (!array_key_exists('max_bidpackages',$errors))? $site_settings_product[0]['max_bidpackages']:$validator['max_bidpackages'];?>">
                                        <span class="error"><?php echo isset($errors['max_bidpackages'])?ucfirst($errors['max_bidpackages']):''; ?></span></td>
                                   </tr>
										  
	  <tr><td valign="top"> <label><?php echo __('sms_each_bid');?></label></td>
			 <td>
					<input type="checkbox" name="sms_eachbid" value="Y" <?php echo ((isset($site_settings_product[0]['sms_eachbid']) && $site_settings_product[0]['sms_eachbid']=="Y"))?"checked='true'":"";?>>
			 </td>
	  </tr>
	  <tr>
			 <td valign="top" width="20%"><label><?php echo __('sms_eachbid_template'); ?></label><span class="star">*</span></td>
			 <td>
			 <textarea name="sms_eachbid_template" id="sms_eachbid_template" class="resizetextarea"  value="" value="" onkeyup="return limitlength(this, 140,'product_info_label')"><?php echo isset($site_settings_product[0]['sms_eachbid_template']) || !array_key_exists('sms_eachbid_template',$errors)?$site_settings_product[0]['sms_eachbid_template']:$validator['sms_eachbid_template']; ?></textarea>
			 <span class="error">
			 <?php echo isset($errors['sms_eachbid_template'])?ucfirst($errors['sms_eachbid_template']):""; ?>
			 </span>
			 <span class="info_label" id="info_label"></span>
			 <span class="info_label" id="info_label"><?php echo __('info_product_name');?>:<?php echo "140";?>
			 </span>
			 </td>
	  </tr>
	  <tr><td valign="top"> <label><?php echo __('sms_winning_bid');?></label></td>
			 <td>
					<input type="checkbox" name="sms_winningbid" value="Y" <?php echo ((isset($site_settings_product[0]['sms_winningbid']) && $site_settings_product[0]['sms_winningbid']=="Y"))?"checked='true'":"";?>>
			 </td>
	  </tr>
	  <tr>
			 <td valign="top" width="20%"><label><?php echo __('sms_winningbid_template'); ?></label><span class="star">*</span></td>
			 <td>
			 <textarea name="sms_winningbid_template" id="sms_winningbid_template" class="resizetextarea"  value="" value="" onkeyup="return limitlength(this, 140,'product_info_label')"><?php echo isset($site_settings_product[0]['sms_winningbid_template']) || !array_key_exists('sms_winningbid_template',$errors)?$site_settings_product[0]['sms_winningbid_template']:$validator['sms_winningbid_template']; ?></textarea>
			 <span class="error">
			 <?php echo isset($errors['sms_winningbid_template'])?ucfirst($errors['sms_winningbid_template']):""; ?>
			 </span>
			 <span class="info_label" id="info_label"></span>
			 <span class="info_label" id="info_label"><?php echo __('info_product_name');?>:<?php echo "140";?>
			 </span>
			 </td>
	  </tr>
										  
										  
                                   <!--Min Bidpackages--> 
                                   <tr>
					   <td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
		                 </tr>  
		                 		                          
                                <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <input type="reset" name="productsettings_reset" title="<?php echo __('button_reset');?>"value="<?php echo __('button_reset');?>">
                                        <input type="submit" name="productsettings_submit" title="<?php echo __('button_update');?>" value="<?php echo __('button_update');?>">
                                        </td>
                                </tr>
                </table>

                </form>
                <br/><br/>
              
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>

</div>
<script type="text/javascript">
	  
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
	  
$(document).ready(function(){
      toggle(8);
});
</script>
