<?php 
defined('SYSPATH') OR die("No direct access allowed.");
echo html::script('public/ckeditor/ckeditor.js');

//For currency code drop down value set
//===================================
$code = isset($data['currency_code']) ? $data['currency_code'] :'';

 /* payment method radio button Checked */
//----------------------------------------
$payment_method_live_checked =$payment_method_test_checked="";
 if(isset($payment_gateway_details['payment_method'])	&& $payment_gateway_details['payment_method']==LIVE_MODE)
 { 
$payment_method_live_checked="checked='checked'"; }

 if(isset($payment_gateway_details['payment_method'])	&& $payment_gateway_details['payment_method']==TEST_MODE)
 { $payment_method_test_checked="checked='checked'"; }
 
 if(isset($payment_gateway_details)){
		  $payment_gateway_details['pagseguro_api_username']=$payment_gateway_details['paypal_api_username'];
		  $payment_gateway_details['pagseguro_api_password']=$payment_gateway_details['paypal_api_password'];
 }
 
 ?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
		  
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frmpayment" id="frmpayment" action ="<?php echo URL_BASE;?>master/<?php echo $action;?>">
                <table border="0"   cellpadding="10" cellspacing="0" width="100%">
                        <tr>
                                <td valign = "top" width="20%"><label><?php echo __('payment_gatway_name'); ?></label><span class="star">*</span></td>
                                <td>
                                		<input type="text" name="payment_gatway" maxlength="256" id="payment_gatway" readonly ="readonly" value="<?php echo isset($payment_gateway_details['payment_gatway']) && !array_key_exists('payment_gatway',$errors)? trim($payment_gateway_details['payment_gatway']):$validator['payment_gatway'];?>"/>
                                   <span class="error">
                                        <?php echo isset($errors['payment_gatway'])?ucfirst($errors['payment_gatway']):""; ?>
                                    </span>
                                </td>
                        </tr>

                         <tr>
                                <td valign="top" width="20%"><label><?php echo __('payment_description'); ?></label><span class="star">*</span></td>
                                <td>
                                <textarea name="description" id="description" class="resizetextarea"  value="" value="" onkeyup="return limitlength(this, <?php echo $product_settings[0]['max_desc_length'];?>,'product_info_label')"><?php echo isset($payment_gateway_details['description']) && !array_key_exists('product_info',$errors)? $payment_gateway_details['description']:$validator['description']; ?></textarea>
                          
                               		<span class="error">
										<?php echo isset($errors['description'])?ucfirst($errors['description']):""; ?>
									</span>
									<span class="info_label" id="info_label"></span>
				<span class="info_label" id="info_label"><?php echo __('info_product_name');?>:<?php echo $product_settings[0]['max_desc_length'];?></span>
				
                                </td>
                        </tr>
                         
                                        <tr>      
                                        <td class="big_text"><?php echo __('pagseguro_settings_label');?></td>
                                        </tr>
                                        <tr>
                                        <td valign="top"> <label><?php echo __('pagseguro_account_type');?></label></td>
                                        <td>
                                        <input type="radio" name="payment_method" value="L" <?php echo $payment_method_live_checked;?> /> <?php echo __('live_account_label');?>
                                        <input type="radio" name="payment_method" value="T" <?php echo $payment_method_test_checked;?> /> <?php echo __('sandbox account_label');?>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td valign="top"> <label><?php echo __('pagseguro_currency_code');?></label></td>
                                        <td> 
                                        <select name="currency_code">
                                        <?php
                                        // Code to display all currency  format

                                        $selected_currency_code="";

                                        foreach($all_currency_code as $currency_key) 
                                        {                                        
                                        if(isset($payment_gateway_details['currency_code'])){?>
                                        <option  value="<?php echo $currency_key; ?>"
                                        <?php echo ($payment_gateway_details['currency_code'] == $currency_key)?"selected='selected'":"";?> ><?php echo $currency_key;?></option>

                                        <?php  } }?> 												
                                        </select>  

                                        </td>
                                        </tr>
								  <tr>
									      <td valign="top"><label><?php echo __('pagseguro_api_username_label');?></label><span class="star">*</span></td>
									      <td>
						<input type="text" class="required"  name="pagseguro_api_username" maxlength='50' id="pagseguro_api_username"  value="<?php echo isset($payment_gateway_details['pagseguro_api_username']) && !array_key_exists('pagseguro_api_username',$errors)? trim($payment_gateway_details['pagseguro_api_username']):$validator['pagseguro_api_username'];?>" maxlength="500"/> 
                                   <span class="error">
                                        <?php echo isset($errors["pagseguro_api_username"])? ucfirst($errors["pagseguro_api_username"]):""; ?>
                                   </span> 									
											</td>
								  </tr>
                                <!--<tr>								
                                        <td valign="top"> <label><?php echo __('pagseguro api password_label');?></label><span class="star">*</span></td>
                                        <td>
                                        <input type="text" class="required" maxlength='50'  name="pagseguro_api_password" maxlength="256" id="pagseguro_api_password" value="<?php echo isset($payment_gateway_details['pagseguro_api_password']) && !array_key_exists('pagseguro_api_password',$errors)? trim($payment_gateway_details['pagseguro_api_password']):$validator['pagseguro_api_password'];?>" /> 
                                        <span class="error">
                                        <?php echo isset($errors["pagseguro_api_password"])? ucfirst($errors["pagseguro_api_password"]):""; ?>
                                        </span> 									
                                        </td>
                                </tr>-->
                           
                              
                                <tr>
	<td valign="top"><label><?php echo __('pagseguro_status');?></label></td>
		<td><input type="checkbox" name="status" value="A" <?php echo ((isset($payment_gateway_details['status']) && $payment_gateway_details['status']=="A"))?"checked='true'":"";?>>
		</td>
</tr>
                         <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>  	                        

                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  <input type="button" title="<?php echo __('button_back'); ?>"value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>master/payment_gatways'" />
                                  <input type="reset" title="<?php echo __('button_reset'); ?>"value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" title="<?php echo __('button_update'); ?>" value="<?php echo ($action == 'edit_payment_gateways' )?''.__('button_update').'':''.__('button_update').'';?>" name="<?php echo ($action == 'edit_payment_gateways' )?'edit_gateway':'edit_gateway';?>" />
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
                
                document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
               
                //inner html
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }
}

$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('payment_gatway');

}); 

</script>

<script type="text/javascript">

$(document).ready(function(){
      toggle(6);
});
</script>
