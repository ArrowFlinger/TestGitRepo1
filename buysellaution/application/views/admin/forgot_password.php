<?php defined('SYSPATH') OR die('No direct access allowed.'); 
?>
<title><?php echo __('page_login_title'); ?></title>
	<div class="login_inner">
		<div class="login_container">
		<?php 
								//For Notice Messages
								
								//echo $message->message;exit;
								$sucessful_message=Message::display();

								if($sucessful_message) { ?>

									<div id="messagedisplay" class="padding_150">
										 <div class="notice_message">
											<?php echo $sucessful_message; ?>
										 </div>
									</div>
								<?php } ?> 
                <div class="login_form">
                <h1><?php echo __('forgot_password');?></h1>
				  <?php if(isset($error_login)){ ?><span class="login_error"><?php echo $error_login; ?></span><?php } ?>
                   <div class="form" style="padding:0 0 35px;">                  
					<form method="post" name="frmlogin" id="frmlogin">
                             <div class="login_row1 fl clr mt20">
                            	 <div class="colm1_width fl">
                                        <p class="colorB5BCC4" style="line-height:30px; width:45px; margin:0px;font-weight:bold;"><?php echo  __('email_label'); ?></p>
                                </div>
                                   <div class="colm2_width fl">
                                     <div>
                                      <div class="left"></div>
                                      <div class="center">
                                        <input type="text" name="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }?>" class="login_txt " maxlength="50" />                                    	
                                      	
                                     </div>
                                      </div>
                                <label class="errore_msg fl clr"> <?php if(isset($errors['email'])){ ?><span class="error" style="text-align: left; margin:5px 0 0 0;"><?php echo ucfirst($errors['email']); ?></span><?php } ?><?php if(isset($email_error)){ ?><span class="error" style="text-align: left; margin:5px 0 0 0;"><?php echo ucfirst($email_error); ?></span><?php } ?></label>
                                </div>
                             </div>
                            
                           <div class="login_row1 fl clr mt10">
                            	<div class="colm1_width fl"><p class="fl" style="width:42px;">&nbsp;</p></div>
                               <div class="colm2_width fl">
                            		<div class="submit_text_left" ></div><div class="submit_text_mid"><input type="submit" class="submit_text" value="<?php echo __('button_send');?>"  name="submit_forgot_password_admin" title="<?php echo __('button_send');?>" /></div><div class="submit_text_right"></div>
                            	</div>
                            </div>
                       
                    </form>
                     
                     </div>
                    	<div class="login_vertical"></div>
                 </div>
            
    </div>
    </div>
           	

