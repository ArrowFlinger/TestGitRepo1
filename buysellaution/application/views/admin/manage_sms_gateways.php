<?php 
defined('SYSPATH') OR die("No direct access allowed.");
echo html::script('public/ckeditor/ckeditor.js');
?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
	<div class="content_middle">
	<form method="post" class="admin_form" name="frmsms" id="frmsms" action ="<?php echo URL_BASE;?>master/<?php echo $action;?>">
		<table border="0"   cellpadding="10" cellspacing="0" width="100%">
			<tr>
				<td valign = "top" width="20%"><label><?php echo __('sms_gatway_name'); ?></label><span class="star">*</span></td>
				<td><input type="text" name="sms_gatway" maxlength="50" id="sms_gatway" readonly ="readonly"
					value="<?php echo isset($sms_gateway_details['sms_gatway']) && !array_key_exists('sms_gatway',$errors)? trim($sms_gateway_details['sms_gatway']):$validator['sms_gatway'];?>"/>
					<span class="error">
						<?php echo isset($errors['sms_gatway'])?ucfirst($errors['sms_gatway']):""; ?>
					</span>
				</td>
			</tr>
			<tr>
				<td valign="top" width="20%"><label><?php echo __('sms_description'); ?></label><span class="star">*</span></td>
				<td><textarea name="sms_description" id="sms_description" class="resizetextarea" onkeyup="return limitlength(this, <?php echo $product_settings[0]['max_desc_length'];?>,'product_info_label')"><?php echo isset($sms_gateway_details['sms_description']) && !array_key_exists('sms_description',$errors)? $sms_gateway_details['sms_description']:$validator['sms_description']; ?></textarea>
					<span class="error">
						<?php echo isset($errors['sms_description'])?ucfirst($errors['sms_description']):""; ?>
					</span>
					<span class="info_label" id="info_label"></span>
					<span class="info_label" id="info_label"><?php echo __('info_product_name');?>:<?php echo $product_settings[0]['max_desc_length'];?></span>
				</td>
			</tr>
			<tr><td class="big_text"><?php echo __('mvaayoo_settings_label');?></td></tr>
			<tr><td valign="top"> <label><?php echo __('mvaayoo_api_url_label');?></label><span class="star">*</span></td>
				<td>
					<input type="text" class="required" name="sms_api_url" maxlength="200" id="sms_api_url" value="<?php echo isset($sms_gateway_details['sms_api_url']) && !array_key_exists('sms_api_url',$errors)? trim($sms_gateway_details['sms_api_url']):$validator['sms_api_url'];?>" /> 
					<span class="error">
						<?php echo isset($errors["sms_api_url"])? ucfirst($errors["sms_api_url"]):""; ?>
					</span> 									
				</td>
			</tr>
			<tr><td valign="top"><label><?php echo __('mvaayoo_api_username_label');?></label><span class="star">*</span></td>
				<td><input type="text" class="required"  name="sms_api_username" id="sms_api_username"
					value="<?php echo isset($sms_gateway_details['sms_api_username']) && !array_key_exists('sms_api_username',$errors)? trim($sms_gateway_details['sms_api_username']):$validator['sms_api_username'];?>" maxlength="500"/> 
					<span class="error"><?php echo isset($errors["sms_api_username"])? ucfirst($errors["sms_api_username"]):""; ?></span> 									
				</td>
			</tr>
			<tr><td valign="top"> <label><?php echo __('mvaayoo_api_password_label');?></label><span class="star">*</span></td>
				<td><input type="text" class="required"  name="sms_api_password" maxlength="50" id="sms_api_password" value="<?php echo isset($sms_gateway_details['sms_api_password']) && !array_key_exists('sms_api_password',$errors)? trim($sms_gateway_details['sms_api_password']):$validator['sms_api_password'];?>" /> 
					<span class="error">
						<?php echo isset($errors["sms_api_password"])? ucfirst($errors["sms_api_password"]):""; ?>
					</span> 									
				</td>
			</tr>
			<tr><td valign="top"> <label><?php echo __('mvaayoo_api_senderid_label');?></label><span class="star">*</span></td>
				<td>
					<input type="text" class="required" name="sms_api_senderid" maxlength="50" id="sms_api_senderid" value="<?php echo isset($sms_gateway_details['sms_api_senderid']) && !array_key_exists('sms_api_senderid',$errors)? trim($sms_gateway_details['sms_api_senderid']):$validator['sms_api_senderid'];?>" /> 
					<span class="error">
						<?php echo isset($errors["sms_api_senderid"])? ucfirst($errors["sms_api_senderid"]):""; ?>
					</span> 									
				</td>
			</tr>
			<tr><td valign="top"> <label><?php echo __('payment gateway view status');?></label></td>
				<td><input type="checkbox" name="status" value="A" <?php echo ((isset($sms_gateway_details['status']) && $sms_gateway_details['status']=="A"))?"checked='true'":"";?>>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="padding-left:110px;"><br />
					<input type="button" title="<?php echo __('button_back'); ?>"value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>master/sms_gatways'" />
					<input type="reset" title="<?php echo __('button_reset'); ?>"value="<?php echo __('button_reset'); ?>" />
					<input type="submit" title="<?php echo __('button_update'); ?>" value="<?php echo ($action == 'edit_sms_gateways' )?''.__('button_update').'':''.__('button_update').'';?>" name="<?php echo ($action == 'edit_sms_gateways' )?'edit_gateway':'edit_gateway';?>" />
					<div class="clr">&nbsp;</div>
				</td>
			</tr>
		</table>
		</form> 
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

	//For Field Focus
	//===============
	field_focus('sms_gatway');

}); 

</script>




