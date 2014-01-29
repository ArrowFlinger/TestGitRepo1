<?php defined('SYSPATH') OR die("No direct access allowed.");?>
	
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                <form method="post" class="admin_form" name="frmdeposits_package" id="frmdeposits_package" action ="">
                <table border="0" width="100%" align="left" cellpadding="10" cellspacing="0">
                        <tr>
                                <td valign="top" width="20%"><label><?php echo __("username_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                <input type="text" name="username" id="username" class="username" value="<?php echo ucfirst ($add_deposits['username']);?>" readonly>
                                </td>
                        </tr>    
                         <tr>
                                <td valign="top" width="20%"><label><?php echo __("add_deposit_label"); ?></label><span class="star">*</span></td>                                
                                <td valign="middle">
                                <input type="text" name="user_bid_account" id="user_bid_account" maxlength="15" value="<?php echo isset($add_deposits['user_bid_account']) && !array_key_exists('user_bid_account',$errors) ? $add_deposits['user_bid_account'] : $validator['user_bid_account']; ?>" />
                                    <span style="padding-left: 5px;" class="error">
				<?php echo isset($errors['user_bid_account'])?ucfirst($errors['user_bid_account']):""; ?>
                                    </span>
                                </td>
                        </tr> 
                <!--User Deposits Amount Add--> 
                <div id="adddeposits" name="<?php  echo url::base();?>manageusers/get_amount">                                                                                 
                <input type="hidden" name="old_amount" id="user_deposits">
                </div>
                <!--User Deposits Amount End--> 
                         <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr> 
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  <input type="button" title="<?php echo __('button_back'); ?>"value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/deposits'" />
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
});	
</script>
