<?php defined('SYSPATH') OR die('No direct access allowed.');

$email_template_info = str_replace(" ","_",strtolower($email_data['template_name']))."_info";

$email_template_title = str_replace(" ","_",strtolower($email_data['template_name']))."_template";
 
?>
<script type="text/javascript">




  
$(document).ready(function(){
	tinyMCE.init({
		mode : "exact",
		elements : "email_content",
		theme : "advanced",
		theme_advanced_resizing : true,
		 plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		 theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|formatselect,fontselect,fontsizeselect",
       theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,code,|,forecolor,backcolor"

	});
      toggle(6);
     
      
});

</script>
<div class="clr">&nbsp;</div>
<h2><?php echo __($email_template_title)?></h2>
<div class="info_details">
	<?php echo __($email_template_info);?>
</div>	
		<div id="tabcontainer">
		    <div id="gc1" class="tabcontent" style="display: block;">
		     <p>
				 <table border="0"  cellpadding="4" cellspacing="0" width="105%">
	               <tr>
	                       <td valign="top" width="20%" ><label><?php echo __('email_from_label'); ?></label><span class="star">*</span></td>
	                       <td>
	                      
	                       		<input type="text" name="email_from" maxlength="128" id="email_from" value="<?php echo (isset($email_data['email_from'])  )? $email_data['email_from']:"";?>"/>

	                          <span class="error_email_template">
	                               
	                           </span>
	                       </td>
	               </tr>
	               <tr>
	                       <td valign="top" width="20%"><label><?php echo __('email_to_label'); ?></label></td>                               
	                       <td>
	                       	<input type="text" name="email_to" maxlength="128" value="<?php echo isset($email_data['email_to']) ? $email_data['email_to']:''; ?>" />

	                       </td>
	               </tr> 
	                <tr>
	                       <td valign="top"><label><?php echo __('email_subject_label'); ?></label><span class="star">*</span></td>
	                       <td>
	                       	 <input type="text" name="email_subject" maxlength="256" value="<?php echo (isset($email_data['email_subject'])  )? $email_data['email_subject']:""; ?>" />
	                            <span class="error_email_template">
	                              
	                            </span>                          
	                       </td>
	               </tr> 
	                <tr>
	                       <td width="20%" valign="top" ><label><?php echo __('email_content_label'); ?></label><span class="star">*</span></td>
	                       <td>
				
	                       <textarea  style="resize:none" name="email_content" id="email_content"  ><?php echo (isset($email_data['email_content'])  )? $email_data['email_content']:""; ?></textarea>  
	                          <span class="error_email_template fl clr p0">
	 												  
	                          </span> 
		                         <span class="email_variable_info">
													<?php echo $show_template_variable;
													?>
		                          </span> 
	                       </td>
	               </tr> 
	               
	              
	               <tr>
	               	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
	               </tr>                         
	               <tr>
	                       <td colspan="3" style="padding-left:161px;">
	                         <br />
	                         	<input type="reset" title="<?php echo __('button_reset'); ?>" value="<?php echo __('button_reset'); ?>" />
						  	    <input type="submit" title="<?php echo __('button_update'); ?>" value="<?php echo ($action == 'email_template' )?''.__('button_update').'':''.__('button_update').'';?>" name="<?php echo ($action == 'email_template' )?'email_template_update':'email_template_update';?>" />
	                           <input type="hidden" value="<?php echo $email_data['id'];?>" name="template_id" />
	                         <div class="clr">&nbsp;</div>
	                       </td>
	               </tr>
		        </table>
		     </p>
		   </div>		    
	  </div>

