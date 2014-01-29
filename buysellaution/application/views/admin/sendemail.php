<?php defined('SYSPATH') OR die("No direct access allowed."); 
echo html::script('public/ckeditor/ckeditor.js');

//For get the User Status
//=======================
$status_val = isset($_POST["user_status"]) ? $_POST["user_status"] :''; 

$users_validator ="";
if(isset($validator['to_user']) && $validator['to_user']!=""){
        $users_validator = implode(",",$validator['to_user']);
}



//For Notice Messages
//===================
$sucessful_message = Message::display();
$flag=0;
if($sucessful_message) 
{ $flag=1; 
?>
    <div id="messagedisplay" class="padding_150">
         <div class="notice_message">
            <?php echo $sucessful_message; ?>
         </div>
    </div>
<?php } ?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post"  class="admin_form" name="sendemail" action ="<?php echo URL_BASE;?>manageusers/sendemail">
                 <table border="0" cellpadding="5" cellspacing="0" width="100%">
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __('mail_option'); ?></label><span class="star">*</span></td>
                                <td><select name="user_status" id="user_status" onchange="return get_users(this.value);">
				                <option value=""><?php echo __('select'); ?></option>
                    			<?php foreach($userstatus AS $status_key => $allstatus) { 
			                 			$selected_status=($flag=='0' && $status_val==$status_key) ? ' selected="selected" ' : " "; ?>  
	                <option value="<?php echo $status_key; ?>"  <?php echo $selected_status; ?> ><?php echo $allstatus;?></option>  
	                    			<?php }?>
				                </select>
                                    <span class="error">
					<?php echo isset($errors['user_status'])?ucfirst($errors['user_status']):""; ?>
                                 	</span> 
                                </td>
                        </tr>
                        <tr>
                                <td valign="top"><label><?php echo __('mail_receiver'); ?></label><span class="star">*</span></td>
                                <td id="bulid_user_dd">
                                   		<select name="to_user" id="to_user" >
											<option value="">
										 <?php echo __('select_alone'); ?></option>										
										</select> 
                                        <span class="error">
								 			<?php echo isset($errors['to_user'])?ucfirst($errors['to_user']):""; ?>
                                 		</span>                                               
                                </td>
                        </tr>
                        <tr>
                                <td valign="top"><label><?php echo __('mail_subject'); ?></label><span class="star">*</span></td>
                               	<td><input type="text" name="subject" id="subject" maxlength="128" value="<?php echo isset($_POST['subject']) ? $_POST['subject']:$validator['subject'];?>"/>
                                     <span class="error">
                                        <?php echo isset($errors['subject'])?ucfirst($errors['subject']):""; ?>
                                     </span>
                                </td>
                        </tr> 
                         <tr>
                                <td valign="top"><label><?php echo __('mail_content'); ?></label><span class="star">*</span></td>
                                <td>
												<textarea class="ckeditor" name="message" id="message_auto_reply"  onkeyup="return limitlength(this, 255)"><?php echo isset($_POST['message']) ? trim($_POST['message']):trim($validator['message']);?></textarea> 
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
                              <input type="reset" value="<?php echo __("button_reset"); ?>" title="<?php echo __("button_reset"); ?>" />
							         <input type="submit" value="<?php echo __('button_send');?>" name="admin_email" title="<?php echo __('button_send');?>" /> 
                              <div class="clr">&nbsp;</div>
                            </td>

                        </tr>
                </table>
        </form>

    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>

<!-- Dependencies -->
<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>yahoo-min.js"></script>
<!-- Source file -->
<script type="text/javascript" src="<?php echo SCRIPTPATH; ?>json-min.js"></script>
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

//Based on the user status selection, user dropdown will be loaded
//=================================================================
	
function get_users(val) {

                     //array for getting validation data
					var data1 = {								
							validator: [
							{
								to_user : "<?php echo isset($validator['to_user'])?$users_validator:'';?>"
							}
				
					]};
				//array for getting error messages
					var data2 = {
				        		errors: [
						{
							to_user : "<?php echo isset($errors['to_user'])? $errors['to_user']:'';?>"
						}
					]};	

    				//alert(data1);
					data1 = YAHOO.lang.JSON.stringify(data1);
					//alert(data1);
					data2 = YAHOO.lang.JSON.stringify(data2);	
						
	var dataString = 'status='+ val+"&validator="+data1+"&error="+data2;
	
	//Loading Indicator
	//=================
	$("#bulid_user_dd").html('<img src="<?php echo IMGPATH;?>loader.gif"> loading...');

	if(val){
			$.ajax({
			type: "POST",
			url: "builduser",
			data: dataString,
				success: function(html)
				{
					$("#bulid_user_dd").html(html);
				}
			});
		}
		else{
			 $("#bulid_user_dd").html('<select name="to_user[]" id="to_user"><option value=""><?php echo __('select_alone'); ?></option></select>'); 
		 }
}



$(document).ready(function()
{
	
	//Load the Users Function, when the validation getting error
	//==========================================================
	<?php if($flag=='0') { ?>
		if($("#user_status").val()) {  get_users($("#user_status").val()); }
	<?php } ?>
	
	//For Field Focus
	//===============
	field_focus('user_status');


	
});

$(document).ready(function(){
      toggle(2);
});
</script>	
