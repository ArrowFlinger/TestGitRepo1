<?php defined("SYSPATH") or die("No direct script access.");
//print_r($errors);exit;
?>
<div class="container_inner fl clr">
	<div class="title_temp2 fl clr">
    	<h2 class="fl clr" title="<?php echo __('menu_sign_up');?>"><?php echo __('menu_sign_up');?></h2>
    </div>
    <div class="login_form fl clr ml35">
    <div class="login_form_left fl">
        <?php echo Form::open(NULL,array('method'=>'post'));?>
    
            <div class="login_row1 fl clr">
            	<div class="colm1_width fl">
	                <p for="username" class="fl"><?php echo __("email_label");?> <span class="red">*</span>: </p>
                </div>
                <div class="colm2_width fl">
            	<div class="inputbox_out fl">
				<?php echo Form::input('email',__("enter_email"),array('maxlength'=>'50','class'=>'textbox','id'=>'email','onfocus'=>'label_onfocus("email","'.__('enter_email').'")','onblur'=>'label_onblur("email","'.__("enter_email").'")'));?>
            	</div>
            	<?php if($errors && array_key_exists('email',$errors)){ ?><label class="errore_msg fl clr"><span class="red"><?php echo (array_key_exists('email',$errors))? ucfirst($errors['email']):"";?></span></label><?php }?>
                </div>
            </div>
            
    
           
            <div class="login_row1 fl clr mt15">
            	<div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
            	<div class="colm2_width fl">
                    <div class="login_submit_btn fl">
                    <span class="login_submit_btn_left fl">&nbsp;</span>
                    <span class="login_submit_btn_middle fl"><?php echo Form::submit('signin',__('button_signin'),array('title'=>__('button_signin')));?></span>
                    <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                    </div>
				</div>
            </div>
            
     </div>       
        <?php echo Form::close();?>
        
    </div>
</div>
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
<script type="text/javascript">
$(document).ready(function () {$("#login_menu").addClass("fl active");});
</script>
