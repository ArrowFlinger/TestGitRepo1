<?php defined('SYSPATH') OR die("No direct access allowed."); 
echo html::script('public/ckeditor/ckeditor.js');
?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post"  class="admin_form" name="winners_reply_form" action ="<?php echo URL_BASE;?>adminauction/winners_reply/?userid=<?php echo $req_id;?>&pid=<?php echo $product_id;?>">
                 <table border="0" cellpadding="5" cellspacing="0" width="100%">
                        <input type="hidden"  name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden"  name="username" value="<?php echo $user_winners_reply['username']; ?>">
                        <tr>
                                <td valign="top"><label><?php echo __('mail_receiver'); ?></label></td>
                                <td><input type="text"  style= "border-color: #FFFFFF;" name="email" id="email" readonly="readonly" value="<?php echo isset($user_winners_reply['email'])? $user_winners_reply['email']:$validator['email']; ?>"/>
                                 </td>
                        </tr>
                        <tr>
                                 <td valign="top"><label><?php echo __('mail_subject'); ?></label><span class="star">*</span></td>
                               	<td><input type="text" name="subject" id="subject" maxlength="128" value="<?php echo isset($user_winners_reply['subject']) ? $user_winners_reply['subject']:$validator['subject'];?>"/>
                                     <span class="error">
                                        <?php echo isset($errors['subject'])?ucfirst($errors['subject']):""; ?>
                                     </span>
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" valign="top"><label><?php echo __('mail_content'); ?></label><span class="star">*</span></td>
                                <td>
                                
				<textarea class="ckeditor" name="message" id="message_auto_reply"  onkeyup="return limitlength(this, 255)"><?php echo isset($user_winners_reply['message']) ? trim($user_winners_reply['message']):trim($validator['message']);?></textarea>
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
                               <input type="button" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>adminauction/won'" />
							  <input type="submit" value="<?php echo __('button_send');?>" name="winners_reply" title="<?php echo __('button_send');?>" /> 
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
                document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }     
} 

$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('subject');

}); 
 

$(document).ready(function(){
      toggle(3);
});
</script>
