<?php defined('SYSPATH') OR die("No direct access allowed."); 
echo html::script('public/ckeditor/ckeditor.js');
?>


<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post"  class="admin_form" name="auto_reply_form" action ="<?php echo URL_BASE;?>manageusers/<?php echo $action;?>">
                 <table border="0" cellpadding="5" cellspacing="0" width="100%">

                        <tr>
                                <td valign="top"><label><?php echo __('mail_receiver'); ?></label></td>
                                <td><input type="text"  style= "border-color: #FFFFFF;" name="email" id="email" readonly="readonly" value="<?php echo isset($contact_request_reply['email']) &&!array_key_exists('email',$errors)? $contact_request_reply['email']:$validator['email']; ?>"/>
                                        <span class="error">
								 			
                                 		</span>                                               
                                </td>
                        </tr>
                        <tr>
                                <td valign="top"><label><?php echo __('mail_subject'); ?></label><span class="star">*</span></td>
                               	<td><input type="text" name="subject" id="subject" maxlength = "128" value="<?php echo isset($contact_request_reply['subject']) &&!array_key_exists('subject',$errors)? __('Re : ').$contact_request_reply['subject']:__('').$validator['subject']; ?>"/>
                                     <span class="error">
                                        <?php echo isset($errors['subject'])?ucfirst($errors['subject']):""; ?>
                                     </span>
                                </td>
                        </tr> 
                         <tr>
                                <td width="15%" valign="top"><label><?php echo __('mail_content'); ?></label><span class="star">*</span></td>
                                <td><textarea  class="ckeditor" name="message" id="message_auto_reply" onkeyup="return limitlength(this, 255)" value=""  ><?php echo isset($contact_request_reply['message']) &&!array_key_exists('message',$errors)? trim($contact_request_reply['message']):trim($validator['message']); ?></textarea>  
                                    <span class="error">
                                        <?php echo isset($errors['message'])?ucfirst($errors['message']):""; ?>
                                    </span>
                                     <span class="info_label" id="info_label"><?php echo __('max_length').":  500";?></span> 
                                </td>
                        </tr>
                         <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>  
                        <tr>

                            <td colspan="3" style="padding-left:150px;">
                              <br />
                               <input type="button" value="<?php echo __("button_back"); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/contact_requests'" />
							  <input type="submit" value="<?php echo __('button_send');?>" name="contact_auto_reply" title="<?php echo __('button_send');?>" /> 
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
	field_focus('subject');

}); 
 

</script>




	
