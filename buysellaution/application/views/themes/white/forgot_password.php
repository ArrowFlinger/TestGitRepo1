<?php defined("SYSPATH") or die("No direct script access."); ?>

<div class="banner_inner">
	<div class="login_head">
		<ul>
			<li><a href="" title="<?php echo strtoupper(__('menu_home')); ?>"><?php echo __('menu_home');?></a></li>
			<li><a href="" title="arr_bg"><img src="<?php echo IMGPATH; ?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
			<li class="active"><a  title="<?php echo strtoupper(__('menu_signin'));?>"><?php echo __('menu_signin');?></a></li>
		</ul>
	</div>
	 <?php echo Form::open(NULL,array('method'=>'post'));?>
	<div class="login-part"><h2 title="<?php echo __('menu_forgot_password');?>"><?php echo __('menu_forgot_password');?></h2></div>
	<div class="login_middle">
		<div class="login_lft">
			<div class="login_form">
				<div class="log_fields">
					<p><?php echo __('signup_email_label');?> <span class="red">*</span>:</p>
					<?php echo Form::input('email',isset($validator['email'])?$validator['email']:__('enter_email'),array('maxlength'=>'30','class'=>'textbox','id'=>'email','onfocus'=>'label_onfocus("email","'.__('enter_email').'")','onblur'=>'label_onblur("email","'.__('enter_email').'")'));?>
				</div>
				<span class="red"><?php if($errors){echo (array_key_exists('email',$errors))? $errors['email']:"";}?></span>
			</div>
		
		<div class="login_button">
			<div class="login_button_lft"></div>
			<div class="login_button_midd"><?php echo Form::submit('submit_forgot_password',__('button_send'),array('title'=>__('button_send')));?></div>
			<div class="login_button_rgt"></div>
		</div>

		</div>
	  <?php echo Form::close();?>
	</div>
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
</div>
