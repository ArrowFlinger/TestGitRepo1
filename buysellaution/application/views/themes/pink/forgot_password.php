<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="container_inner fl clr">
        <div class="title-left title_temp2">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr" title="<?php echo __('menu_forgot_password');?>"><?php echo __('menu_forgot_password');?></h2>
        </div>
        </div>
        </div>
<div class="deal_list  clearfix">
<div class="fl clr mt20 ml10 pb20">
        <?php echo Form::open(NULL,array('method'=>'post'));?>
                <div class="row_colm1 fl clr mt10">
                        <div class="colm1_width fl"><p for="email"><?php echo __('signup_email_label');?> <span class="red">*</span>: </p></div>
                        <div class="colm2_width fl">
                                <div class="inputbox_out fl">
                                <?php echo Form::input('email',isset($validator['email'])?$validator['email']:__('enter_email'),array('maxlength'=>'30','class'=>'textbox','id'=>'email','onfocus'=>'label_onfocus("email","'.__('enter_email').'")','onblur'=>'label_onblur("email","'.__('enter_email').'")'));?>
                                </div>
                        <label  class="signup_errore_msg fl">
                        <span class="red"><?php if($errors){echo (array_key_exists('email',$errors))? $errors['email']:"";}?></span>
                        </label>
                        </div>    
                </div>
                <div class="row_colm1 fl clr mt20">
                        <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                        <div class="login_submit_btn fl">
                        <span class="login_submit_btn_left fl">&nbsp;</span>
                        <span class="login_submit_btn_middle fl"><?php echo Form::submit('submit_forgot_password',__('button_send'));?></span>
                        <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                        </div>
                </div>
        <?php echo Form::close();?>
</div>
</div>
<div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
    </div> <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
