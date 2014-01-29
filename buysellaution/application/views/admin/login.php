<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<title><?php echo __('page_login_title'); ?></title>
	<div class="login_inner">
		<div class="login_container">
				<?php 
					//For Notice Messages
					//===================
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
		
                <h1><?php echo __('login_title'); ?></h1>
		
				  <?php if(isset($error_login)){ ?><span class="login_error"><?php echo $error_login; ?></span><?php } ?>
                   <div class="form" style="padding:0 0 15px;">
					<form method="post" name="frmlogin" id="frmlogin">
			
                       <div class="login_row1 fl clr mt20">
                    <div class="colm1_width fl">
                                        <p class="colorB5BCC4" style="line-height:30px; width:85px; margin:0px;font-weight:bold;"><?php echo  __('email_label'); ?></p>
                           </div>
                          
                                 <div class="colm2_width fl">
                                    <div>
                                      <div class="left"></div>
                                      <div class="center">
                                        <input type="text" name="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; }?>" class="login_txt" maxlength="50" />
                                      	
                                      </div>
                                      </div>
                                      
                                 <label class="errore_msg fl clr"> <?php if(isset($errors['email'])){ ?><span class="error" style="text-align: left; margin:5px 0 0 0;"><?php echo ucfirst($errors['email']); ?></span><?php } ?></label>
                                 </div>
                             
                    </div>
                    
                   <div class="login_row1 fl clr mt20">
                            	<div class="colm1_width fl">
                                    <p class="colorB5BCC4" style="line-height:30px; width:85px; margin:0px;font-weight:bold;"><?php echo __('password_label'); ?></p>
                               </div>
                       
                                <div class="colm2_width fl">
                                        <div>
                                    	<div class="left"></div>
                                        <div class="center">
                                                <input type="password" name="password" class="login_txt" maxlength="15" />                                             
					                    </div>
										</div>
										<label class="errore_msg fl clr"><?php if(isset($errors['password'])){ ?><span class="error" style="margin:5px 0 0 0;"><?php echo ucfirst($errors['password']); ?></span><?php } ?></br></label>
                                        </div>
                                </div>  
                                
                                <div class="login_row1 fl clr">
                <div class="colm1_width fl"><b class="fl" style="width:87px;">&nbsp;</b></div>
                <div class="colm2_width fl">
                <div class="remember_me fl">
                	<a href="<?php echo URL_BASE;?>admin/forgot_password" class="frgtpsd" title="<?php echo __('forgot_password');?>" alt="<?php echo __('forgot_password');?>"><?php echo __('forgot_password');?></a>
                </div>
                </div>
            </div>            
                                <div class="login_row1 fl clr mt20 mb20">
            	<div class="colm1_width fl"><b class="fl" style="width:88px;">&nbsp;</b></div>
            	<div class="colm2_width fl">
                   
                  	<input type="submit" class="login_text ml5" value=""  name="admin_login" title="<?php echo __('admin_login');?>" />
                   
                    
                   
				</div>
            </div>
                                 
									<?php /*<div style="margin-top:25px;"><?php echo __('forgot_password'); ?>?<a href="/admin/forgot_password" title="<?php echo __('get_newone');?>"> <?php echo __('get_newone');?></a></p></div> */ ?>
                                   
                       
                            	
                        
                    </form>
                     
                     </div>
                    	<div class="login_vertical"></div>
                 </div>
            
    </div>
    </div>
           	

