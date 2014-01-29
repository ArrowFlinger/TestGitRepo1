<?php defined("SYSPATH") or die("No direct script access."); ?>

	<div class="login_head">
		<ul>
			<li><a href="" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
			<li><a><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
			<li class="active"><a href="" title="<?php echo __('menu_login');?>"><?php echo $selected_page_title; ?></a></li>
		</ul>
	</div>
	<div class="login-part"><h2 title="<?php echo strtoupper(__('menu_login'));?>"><?php echo __('menu_login');?></h2></div>
	<div class="login_middle">
			<div class="login_lft">
					<?php echo Form::open(NULL,array('method'=>'post'));?>
					<div class="login_form">
						<div class="log_fields">
								<p><?php echo __("username_label");?> <span class="red">*</span>:</p>
								<?php echo Form::input('username',isset($values['username'])?$values['username']:__("enter_username"),array('maxlength'=>'20','class'=>'textbox','id'=>'username','onfocus'=>'label_onfocus("username","'.__('enter_username').'")','onblur'=>'label_onblur("username","'.__("enter_username").'")'));?>
						</div>
								<span class="red fl"><?php if($errors){echo (array_key_exists('username',$errors))? ucfirst($errors['username']):"";}?></span>
								
						<div class="log_fields">
								<p><?php echo __("password_label");?> <span class="red">*</span>:</p>
								<?php echo Form::password('password',isset($values['password'])?$values['password']:__('enter_password'),array('maxlength'=>'20','class'=>'textbox','id'=>'password','onfocus'=>'label_onfocus("password","'.__('enter_password').'")','onblur'=>'label_onblur("password","'.__('enter_password').'")'));?>    
						</div>
												
					 </div>		<span class="red fl"><?php if($errors){echo (array_key_exists('password',$errors))? ucfirst($errors['password'	]):"";}?></span>
					<div class="login_check">
							<?php echo Form::checkbox('remember','1',FALSE);?>
							<p class="remeber"><?php echo __('remember_me');?></p>
							<label><a href="<?php echo url::base();?>users/forgot_password" title="<?php echo __('forgot_password');?>"><?php echo __('forgot_password');?>?</a></label>
					</div>
					<div class="login_button fl clr">
							<div class="login_button_lft"></div>
							<div class="login_button_midd"><input type="submit" name="login" value="<?php echo __('button_signin'); ?>" title="<?php echo strtoupper(__('button_signin')); ?>"></div>
							<div class="login_button_rgt"></div>
					</div>

			</div>
			<?php echo Form::close();?>
			<div class="login_rgt">
			<?php $fb_settings=Commonfunction::get_facebook_settings();
							if($fb_settings[0]['facebook_login']==YES)
							{?>
				<div class="login-social"><p><?php echo __('login_with')?></p>
				</div>
			<div class="login_net">
					<ul>
						<li><a href="<?php echo URL_BASE;?>users/facebook" title="<?php echo __('login_with_facebook');?>"><img src="<?php echo IMGPATH;?>f_connect.png"  alt="<?php echo __('login_with_facebook');?>" /></a></li>
						<?php if($fb_settings[0]['twitter_login']==YES)
							{?>
						<li><a href="<?php echo URL_BASE;?>socialnetwork/twitterlogin" title="Twitt-connect"><img src="<?php echo IMGPATH;?>twitt_connect.png"  alt="Twitt-connect" /></a>
					</li>
					 <?php 	}?>
					</ul>
			</div>
			<?php 
						}?>

						<?php if($fb_settings[0]['twitter_login']==YES || $fb_settings[0]['facebook_login']==YES)
					{?>
			<span class="other"><label><?php echo __('or')?></label></span><?php } ?>
			
			<div class="login_account">
				<h2><?php echo __('dont_have_an_account');?></h2>
				<p><?php echo __('register_now_bid_buy');?></p>
				<p><?php echo __('if_you_want_to_singin');?></p>
				<p><?php echo __('registration_free');?></p>

			<div class="register">
			<div class="reg_lft"></div>
			<div class="reg_midd"><a href="<?php echo url::base();?>users/signup" title="<?php echo __('menu_register');?>"><?php echo __('menu_register');?></a></div>
			<div class="reg_rgt"></div>

			</div>
			</div>
			</div>
	</div>
</div>
 
<script type="text/javascript">
$(document).ready(function () {$("#login_menu").addClass("fl active");});
</script>
