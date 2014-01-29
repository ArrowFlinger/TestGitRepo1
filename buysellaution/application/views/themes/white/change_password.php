<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right" id="change_password_page">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('menu_change_password'));?>"><?php echo __('menu_change_password');?></h1>
		<p>&nbsp;</p>
	</div>
	<div class="message_common">
			<?php echo Form::open("/users/change_password",array('name'=>'change_password','id'=>'change_password')); ?>
			<div class="login_middle_common_profil">			
				<div class="user_name_common">									
					<div class="log_fields">
						<p><?php echo __('oldpassword_label');?> <span class="red">*</span>:</p>
						<h2><?php echo Form::password('old_password', $validator_changepass['old_password'],array("id"=>"old_password","Maxlength"=>"20",'title' =>__('oldpassword_label'))) ?></h2>
					</div>					
					<span class="red"><?php  echo isset($oldpass_error)?$oldpass_error:'';
						if($errors){ echo (array_key_exists('old_password',$errors))? $errors['old_password']:"";}?>
					</span>
				</div>
				<div class="user_name_common">					
					<div class="log_fields">
						<p><?php echo __('newpassword_label');?> <span class="red">*</span>:</p>
						<h2><?php  echo Form::password('new_password', $validator_changepass['new_password'],array("id"=>"new_password","Maxlength"=>"20",'title'=>__('newpassword_label'))) ?></h2>
					</div>
					<span class="red">
						<?php if($errors){ echo (array_key_exists('new_password',$errors))? $errors['new_password']:"";}?>
					</span>
				</div>

				<div class="user_name_common">					
					<div class="log_fields">
						<p><?php echo __('confirm_password_label');?> <span class="red">*</span>:</p>
						<h2><?php  echo Form::password('confirm_password', $validator_changepass['confirm_password'],array("id"=>"new_password","Maxlength"=>"20",'title'=>__('confirm_password_label'))) ?></h2>
					</div>
						<span class="red">
							<?php if($errors){ echo (array_key_exists('confirm_password',$errors))? $errors['confirm_password']:"";}?>
						</span>
				</div>

				<div class="user_name_common">
					<div class="no_img">
							<div class="buton_green">
								<div class="profil_butoon">
								<div class="res_left"></div>
								<div class="res_mid"><a title="<?php echo strtoupper(__('button_reset'));?>"><input type="submit" name="submit_user" value="<?php echo strtoupper(__('button_reset'));?>"/></a></div>
								<div class="res_right"></div>
							</div>
							<span>	
							</span>							
							<div class="grand_total_btn_cp">
								<div class="save_left"></div>
								<div class="save_mid"><a title="<?php echo strtoupper(__('button_save'));?>"><input type="submit" name="submit_change_pass" value="<?php echo strtoupper(__('button_save'));?>"/></a></div>
								<div class="save_right"></div>
								</div> 							
							</div>
					</div>
				</div>

			</div>
			 <?php echo Form::close() ?>
			 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
</div>
</div>
</div>
       
<script type="text/javascript">
$(document).ready(function () {$("#change_password_active").addClass("act_class");});
</script>
