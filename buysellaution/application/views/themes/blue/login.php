<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="container_inner fl clr">
    <div class="title-left title_temp1">
    <div class="title-right">
    <div class="title-mid">
  	 <h2 class="fl clr" title="<?php echo __('menu_login');?>"><?php echo __('menu_login');?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
	<div class="action_deal_list clearfix">
        <div class="login_form fl clr mt10 ml5">
        <div class="login_form_left fl">
        <?php echo Form::open(NULL,array('method'=>'post'));?>
            <div class="login_row1 fl clr">
            	<div class="colm1_width fl">
	                <p for="username" class="fl"><?php echo __("username_label");?> <span class="red">*</span>: </p>
                </div>
                <div class="colm2_width fl">
            	<div class="inputbox_out fl">
				<?php echo Form::input('username',isset($values['username'])?$values['username']:__("enter_username"),array('maxlength'=>'20','class'=>'textbox','id'=>'username','onfocus'=>'label_onfocus("username","'.__('enter_username').'")','onblur'=>'label_onblur("username","'.__("enter_username").'")'));?>
            	</div>
            	        <label class="errore_msg fl clr"><span class="red"><?php if($errors){echo (array_key_exists('username',$errors))? ucfirst($errors['username']):"";}?></span></label>
                </div>
            </div>
            <div class="login_row1 fl clr mt20">
            	<div class="colm1_width fl"><p for="password" class="fl"><?php echo __("password_label");?> <span class="red">*</span>: </p></div>
            	<div class="colm2_width fl"><div class="inputbox_out fl">
		<?php echo Form::password('password',isset($values['password'])?$values['password']:__('enter_password'),array('maxlength'=>'20','class'=>'textbox','id'=>'password','onfocus'=>'label_onfocus("password","'.__('enter_password').'")','onblur'=>'label_onblur("password","'.__('enter_password').'")'));?>
                </div>
                <label class="errore_msg fl clr"><span class="red"><?php if($errors){echo (array_key_exists('password',$errors))? ucfirst($errors['password']):"";}?></span></label>
                </div>
            </div>
    
            <!--Remember me-->
            <div class="login_row1 fl clr mt20">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="colm2_width fl">
                <div class="remember_me fl">
                	<?php echo Form::checkbox('remember','1',FALSE);?><span class="fl"><?php echo __('remember_me');?></span> 
                </div>
                </div>
            </div>    
            <!--End of remember me-->
                <div class="login_row1 fl clr mt20">
                        <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                        <div class="colm2_width fl">
                                <div class="login_submit_btn fl">
                                <span class="login_submit_btn_left fl">&nbsp;</span>
                                <span class="login_submit_btn_middle fl"><?php echo Form::submit('login',__('button_signin'));?></span>
                                <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                                </div>
                        </div>
                </div>
                        <div class="login_row1 fl clr mt15">
                        <b class="fl">&nbsp;</b>
                        <a href="<?php echo url::base();?>users/forgot_password" class="forgot_pass_link fl" targer="_self" title="<?php echo __('forgot_password');?>"><?php echo __('forgot_password');?>?</a>
                        </div>
                </div>       
                <?php echo Form::close();?>
                <div class="login_form_right fl" style="margin:10px 0 0 0;">
                <!--Facebook connect-->
                <?php $fb_settings=Commonfunction::get_facebook_settings();
                if($fb_settings[0]['facebook_login']==YES)
                {?>
                        <div class="login_fbook fl clr">
                                <a href="<?php echo URL_BASE;?>users/facebook" title="<?php echo __('login_with_facebook');?>" class="pt10 fbook_login">
                                <?php echo __('login_with');?> <img src="<?php echo IMGPATH.'f_connect.png';?>" alt="<?php echo __('login_with_facebook');?>" align="top" title="<?php echo __('login_with_facebook');?>" border="0"  class="" />
                                </a>
                        <?php if($fb_settings[0]['twitter_login']==YES)
                        {?>
                                <a href="<?php echo URL_BASE;?>socialnetwork/twitterlogin" class="pt10  fbook_login" alt="<?php echo __('login_with_twitter');?>" title="<?php echo __('login_with_twitter');?>"><img src="<?php echo IMGPATH.'tweet.png';?>"/></a>
                        <?php 
                        } ?>
                        </div>
                <?php 
                } ?>
		<?php /*
                if($fb_settings[0]['linkedin_login']==YES)
                {?>
                         <?php if(!$auction_userid):?>
                        <a href="<?php echo URL_BASE;?>users/auth/linkedin" title="Linkedin" class="f_connect_link fl fbook_login"><img src="<?php echo IMGPATH.'link-icon.png';?>"/></a>
			<?php endif;?>
			
                <?php 
                } */?>
		<!--Twitter connect-->
                <?php if($fb_settings[0]['twitter_login']==YES || $fb_settings[0]['facebook_login']==YES)
                {?><p class="or_text mt15 fl clr"><?php echo __('or');?></p><?php } ?>
                <div class="signup_link fl clr mt10">
        	<h4 style="text-align:left;"><?php echo __('dont_have_an_account');?>?</h4>
                <p><?php echo __('register_now_bid_buy');?>?</p>
                <p><?php echo __('if_you_want_to_singin');?></p>
                <p><?php echo __('registration_free');?></p>
                <div class="login_submit_btn fl">
                    <span class="bidme_link_left register-left fl">&nbsp;</span>
                    <span class="bidme_link_middle register-middle fl">  <a href="<?php echo url::base();?>users/signup" title="<?php echo __('menu_register');?>"><?php echo __('menu_register');?></a></span>
                    <span class="bidme_link_left bidme_link_right register-right fl">&nbsp;</span>
                    </div>
        	</div>
        </div>
    </div>
    </div>
    </div>
      <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
<script type="text/javascript">
$(document).ready(function () {$("#login_menu").addClass("fl active");});
</script>
