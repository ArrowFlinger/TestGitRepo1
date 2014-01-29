<?php defined('SYSPATH') OR die("No direct access allowed."); 

 /* Status Box Checked */	
 if(isset($add_user_bonus['status'])	&& $add_user_bonus['status']=="A")
 { $status_checked="checked='checked'"; }
 else if(isset($add_user_bonus['status']) && $add_user_bonus['status']=="I")
 { $status_checked=""; }
 else
 { $status_checked="checked='checked'"; }
?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frm_user_bonus" id="frm_user_bonus" action ="<?php echo URL_BASE;?>adminauction/<?php echo $action;?>">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                <tr>
                                <td valign="top" width="20%"><label><?php echo __("username_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                               
                                     <select name="userid" id="userid" class="userid">
					<option value=""><?php echo __('select_label'); ?></option>
                                        <?php 
                                        //code to display username drop down
 
                                        foreach($all_username_list as $userlist)
                                        { 
                                        if (!isset($add_user_bonus)){ 
                                        $selected_username="";  	
                                        $selected_username=($userlist['id']==$all_username_list) ? " selected='selected' " : ""; 
                                        ?>
                                        <option value="<?php echo $userlist['id']; ?>"  <?php echo $selected_username; ?>><?php echo $userlist['username'];?></option><?php }else{?>
                                        <option value="<?php echo $userlist['id']; ?>"  <?php echo ($add_user_bonus['userid'] == $userlist['id'])?"selected='selected'":"";?>><?php echo $userlist['username'];?></option>
                                        <?php } }?>			
				            
				         
                        </select>
                             <span style="padding-left: 5px;" class="error">
				<?php echo isset($errors['username'])?ucfirst($errors['username']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>    
                        <tr>
                         <tr>
                                <td valign="top" width="20%"><label><?php echo __("bonus_type"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                     <select name="bonus_type" id="bonus_type" class="bonus_type">
							<option value=""><?php echo __('select_label'); ?></option>
				            <?php 
							//code to display username drop down
								foreach($all_bonus_type as $bonuslist) { 
								if(!isset($add_user_bonus)){
								$selected_bonuslist="";  	
								$selected_bonuslist=($bonuslist['bonus_type_id']==trim($bonuslist['bonus_type'])) ? " selected='selected' " : "";
								array_filter($bonuslist); 
							 ?>
                                <option value="<?php echo $bonuslist['bonus_type_id']; ?>"  <?php echo $selected_bonuslist; ?>><?php echo $bonuslist['bonus_type'];?></option><?php }else{ ?>
						 <option value="<?php echo $bonuslist['bonus_type_id']; ?>"  <?php echo ($add_user_bonus['bonus_type'] == $bonuslist['bonus_type_id'])?"selected='selected'":"";?>><?php echo $bonuslist['bonus_type'];?></option>
                                        <?php } }?>	
                        </select>
                             <span style="padding-left: 5px;" class="error">
				<?php echo isset($errors['bonus_type'])?ucfirst($errors['bonus_type']):""; ?>
                                    </span>
                                
                                </td>
                        </tr>    
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("bonus_user_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                    <input type="text" name="bonus_amount" id="bonus_amount" maxlength="12" value="<?php echo isset($add_user_bonus['bonus_amount']) && !array_key_exists('bonus_amount',$errors) ? $add_user_bonus['bonus_amount'] : $validator['bonus_amount']; ?>" />
                                    <span style="padding-left: 5px;" class="error">
					<?php echo isset($errors['bonus_amount'])?ucfirst($errors['bonus_amount']):""; ?>
                                    </span>
                                
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
                                  <input type="button" title="<?php echo __('button_back'); ?>"value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>adminauction/user_bonus'" />
                                  <input type="reset" title="<?php echo __('button_reset'); ?>" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" title="<?php echo __('button_add'); ?>"value="<?php echo ($action == 'add_user_bonus' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'add_user_bonus' )?'add_user_bonus_submit':'edit_user_bonus_submit';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr> 
                 </table>
                </form> 
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
