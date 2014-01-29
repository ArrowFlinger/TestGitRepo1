<?php defined('SYSPATH') OR die("No direct access allowed.");?>
	
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frmdeposits_package" id="frmdeposits_package" action ="">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                        <tr>
                        <!--Users List-->
                                <td valign="top" width="20%"><label><?php echo __("username_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                     <select name="username" id="username" class="username">
							<option value=""><?php echo __('select_label'); ?></option>
				            <?php 
							//code to display username drop down
								foreach($all_username_list as $userlist) { 
								$selected_username="";  	
								$selected_username=($userlist['id']==trim($userlist['username'])) ? " selected='selected' " : "";
								array_filter($userlist); 
							 ?>
                                <option value="<?php echo $userlist['id']; ?>"  <?php echo $selected_username; ?>><?php echo ucfirst($userlist['username']);?></option>
							
							<?php } ?>
                        </select>
                             <span style="padding-left: 5px;" class="error">
				<?php echo isset($errors['username'])?ucfirst($errors['username']):""; ?>
                                    </span>
                                
                                </td>
                                <!--End User List-->
                        </tr> 
                        <!--Add Package Type-->
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("package_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                     <select name="user_bid_account" id="user_bid_account" >
							<option value=""><?php echo __('select_label'); ?></option>
							
				                        <?php 
							        //code to display packages name drop down
								foreach($all_package_list as $packagelist) { 
								$selected_package="";  	
								$selected_package=($packagelist['price']==trim($packagelist['name'])) ? " selected='selected' " : "";
								array_filter($packagelist); 
							 ?>
							 
                                <option value="<?php echo $packagelist['price']; ?>"  <?php echo $selected_package; ?>><?php echo ucfirst($packagelist['name']);?></option>
							<?php } ?>
                        </select>
                             <span style="padding-left: 5px;" class="error">
				<?php echo isset($errors['user_bid_account'])?ucfirst($errors['user_bid_account']):""; ?>
                                    </span>
                                </td>
                        </tr>    
                        <!--End Package List-->   
                        <!--User Deposits Amount Add--> 
                        <div id="package" name="<?php  echo URL_BASE;?>manageusers/allpackage_list">
                            

                        <input type="hidden" name="package_id" id="packageid">
                        </div>
                        <!--User Deposits Amount End--> 
                        
                <!--Package id Add--> 
                <div id="adddeposits" name="<?php  echo URL_BASE;?>manageusers/get_amount">                                                                                 
                <input type="hidden" name="old_amount" id="user_deposits">
                </div>
                <!--User Deposits Amount End--> 
                         <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr> 
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  <input type="button" title="<?php echo __('button_back'); ?>"value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/manage_deposits'" />
                                  <input type="reset" title="<?php echo __('button_reset'); ?>" value="<?php echo __('button_reset'); ?>" />
                                  <input type="submit" title="<?php echo __('button_add'); ?>"value="<?php echo ($action == 'deposits' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'deposits' )?'editdeposits_submit':'editdeposits_submit';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr> 
                 </table>
                </form> 
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	//For Field Focus
	//===============
	field_focus('name');
//Default Bid history page load
$('.username').change(function(){
var value=$(this).val();
var url =$('#adddeposits').attr('name');

$.ajax({
			url:url,
			type:'post',
			data:"value="+value,
			complete:function(data){
				$("#user_deposits").val(data.responseText);
			}
		});
});
//Default Bid history page load
$('#user_bid_account').change(function(){
var value=$("#user_bid_account option:selected").val();
var url =$('#package').attr('name');

$.ajax({

			url:url,
			type:'post',
			data:"values="+value,
			complete:function(data){				
				$("#packageid").val(data.responseText);
			}
		});
        });
});

$(document).ready(function(){
      toggle(6);
});	
</script>
