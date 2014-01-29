<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
                <h2 class="fl clr" title="<?php echo __('menu_change_password');?>"><?php echo __('menu_change_password');?></h2>
        </div>
        </div>
        </div>
        <div class="action_deal_list clearfix">
	<div class="edit_content fl clr mt20 ml15 pb20">
	<div id="pass">
        <p class="change-pass"><?php echo __('to_change_your_password');?></p>
		<!-- Change password form-->
        <div class="form_tabel">
        <?php echo Form::open("/users/change_password",array('name'=>'change_password','id'=>'change_password')); ?>
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('oldpassword_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::password('old_password', $validator_changepass['old_password'],array("id"=>"old_password","Maxlength"=>"20",'title' =>__('oldpassword_label'))) ?>
                        </div>
                <label class="errore_msg fl clr"><span class="red"><?php  echo isset($oldpass_error)?$oldpass_error:'';
                if($errors){ echo (array_key_exists('old_password',$errors))? $errors['old_password']:"";
                }
                ?></span></label>
                </div>
        </div>
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('newpassword_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php  echo Form::password('new_password', $validator_changepass['new_password'],array("id"=>"new_password","Maxlength"=>"20",'title'=>__('newpassword_label'))) ?>
                        </div>    
                <label class="errore_msg fl clr"><span class="red"><?php if($errors){ echo (array_key_exists('new_password',$errors))? $errors['new_password']:"";}?></span></label>
                </div>
        </div>
        <div class="row_colm1 fl clr mt20">      
                <div class="colm1_width fl"><p><?php echo __('confirm_password_label');?> <span class="red">*</span>:</p></div>
                <div class="colm2_width fl">	
                        <div class="inputbox_out fl">
                        <?php echo Form::password('confirm_password', $validator_changepass['confirm_password'],array("id"=>"confirm_password","Maxlength"=>"20","title" =>__('confirm_password_label'))) ?>
                        </div>
                <label class="errore_msg fl clr">
                <span class="red"><?php if($errors){ echo (array_key_exists('confirm_password',$errors))? $errors['confirm_password']:"";}?></span>
                </label>
                </div>
        </div>      
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="colm2_width fl">	
                        <div class="login_submit_btn fl">
                        <span class="login_submit_btn_left fl">&nbsp;</span>
                        <span class="login_submit_btn_middle fl">
                            <input name="submit_user" type="submit" value="<?php echo __('button_reset');?>" title="<?php echo __('button_reset');?>" class="fl"/>
                        </span>
                        <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                        </div>
                        <div class="login_submit_btn fl ml10">
                        <span class="login_submit_btn_left fl">&nbsp;</span>
                        <span class="login_submit_btn_middle fl">
                            <input name="submit_change_pass" type="submit" value="<?php echo __('button_save');?>" title="<?php echo __('button_save');?>" class="fl"/>
                        </span>
                        <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                        </div>
                </div>	    
        </div>       
        <?php echo Form::close() ?>
        </div>
        <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
        <!-- End of change password-->
        </div>
</div>
</div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
</div><script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#change_password_active").addClass("user_link_active");});
</script>
