<?php defined('SYSPATH') OR die("No direct access allowed."); 
//For Notice Messages
$sucessful_message=Message::display();
if($sucessful_message) { ?>
    <div id="messagedisplay" class="padding_150">
         <div class="notice_message">
            <?php echo $sucessful_message; ?>
         </div>
    </div>
<?php }
  
 ?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle" >       
                <form method="POST" class="admin_form" action="<?php echo URL_BASE;?>settings/social_network/" >
                 <!--- Start of facebook-->
                        <table class="list_table1 fl clr">
                        <th><span class="blue_head"><?php echo __('facebook_heading');?></span></th>
                        <tr>
                                <td></td>   
                                <td>
                                <input type="checkbox" name="facebook_login"  value="Y" <?php echo( $site_socialnetwork[0]['facebook_login']=="Y")?"checked='checked'":""; ?> ><label><?php echo __('fb_login_label');?></label>
                                <p><?php echo __('fb_login_content');?></p>
                                </td>                           
                        </tr>
                                <tr>
                                        <td><label><?php echo __('fb_apikey_label');?> :</label></td>   
                                        <td><input type="text" name="facebook_api" id="facebook_api" class="facebook_api" title="Enter your facebook api" maxlength="250" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('facebook_api',$errors))? $site_socialnetwork[0]['facebook_api']:$validator['facebook_api'];?>">
                                         <span class="error"><?php echo isset($errors['facebook_api'])?ucfirst($errors['facebook_api']):''; ?></span></td>
                                </tr>
                                        <td><label><?php echo __('fb_secret_key_label');?> :</label></td>   
                                        <td><input type="password" name="facebook_secret_key" id="facebook_secret_key" class="facebook_secret_key" title="Enter your facebook secret key" maxlength="250" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('facebook_secret_key',$errors))? $site_socialnetwork[0]['facebook_secret_key']:$validator['facebook_secret_key'];?>">
                                          <span class="error"><?php echo isset($errors['facebook_secret_key'])?ucfirst($errors['facebook_secret_key']):''; ?></span></td>
                                </tr>
                              <tr>
                                        <td><label><?php echo __('fb_application_label');?> :</label></td>   
                                        <td><input type="text" name="facebook_application_id" id="facebook_application_id" class="facebook_application_id" title="Enter your facebook applicatin id" maxlength="25" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('facebook_application_id',$errors))? $site_socialnetwork[0]['facebook_application_id']:$validator['facebook_application_id'];?>"> <span class="info_label"><?php echo __('fb_application_label');?></span>
                                          <span class="error"><?php echo isset($errors['facebook_application_id'])?ucfirst($errors['facebook_application_id']):''; ?></span></td>
                                </tr>
                                  <tr>
                                        <td><label><?php echo __('fb_invite_text');?> :</label></td>   
                                        <td><textarea name="facebook_invite_text" id="facebook_invite_text" class="facebook_invite_text" title="Enter your Facebook text"  ><?php echo isset($site_socialnetwork) &&  (!array_key_exists('facebook_invite_text',$errors))? $site_socialnetwork[0]['facebook_invite_text']:$validator['facebook_invite_text'];?></textarea> <span class="info_label"><?php echo __('fb_application_label');?></span>
                                          <span class="error"><?php echo isset($errors['facebook_invite_text'])?ucfirst($errors['facebook_invite_text']):''; ?></span></td>
                                </tr>
                                 <tr>
                                        <td><label><?php echo __('fb_share');?> :</label></td>   
                                        <td><textarea name="facebook_share" id="facebook_share" class="facebook_share" ><?php echo isset($site_socialnetwork) &&  (!array_key_exists('facebook_share',$errors))? $site_socialnetwork[0]['facebook_share']:$validator['facebook_share'];?></textarea> 
                                          <span class="error"><?php echo isset($errors['facebook_share'])?ucfirst($errors['facebook_share']):''; ?></span></td>
                                </tr>
                                <!--- End of facebook-->
                                <!--- Start of twitter-->
                                
                             <th><span class="blue_head"><?php echo __('twitter_heading');?></span></th>
                              <tr>
                                        <td></td>   
                                        <td>
                                        <input type="checkbox" name="twitter_login"  value="Y" <?php echo( $site_socialnetwork[0]['twitter_login']=="Y")?"checked='checked'":""; ?>> <label><?php echo __('twitter_login_label');?></label>
                                       <p ><?php echo __('twitter_login_content');?></span>
                                        </td>                           
                                </tr>
                              <tr>
                                        <td><label><?php echo __('twitter_consumerkey_label');?> :</label></td>   
                                        <td><input type="text" name="tiwtter_consumer_key" id="tiwtter_consumer_key" class="tiwtter_consumer_key" title="Enter your consumer key" maxlength="250" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('tiwtter_consumer_key',$errors))? $site_socialnetwork[0]['tiwtter_consumer_key']:$validator['tiwtter_consumer_key'];?>"><span class="info_label"><?php echo __('twitter_consumerkey_content');?></span> 
                                         <span class="error"><?php echo isset($errors['tiwtter_consumer_key'])?ucfirst($errors['tiwtter_consumer_key']):''; ?></span></td>
                                       
                                </tr>
                                <tr>
                                        <td><label><?php echo __('twitter_secret_label');?>:</label></td>   
                                        <td><input type="text" name="twitter_consumer_secret" id="twitter_consumer_secret" class="twitter_consumer_secret" title="Enter your consumer secret key" maxlength="250" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('twitter_consumer_secret',$errors))? $site_socialnetwork[0]['twitter_consumer_secret']:$validator['twitter_consumer_secret'];?>"><span class="info_label"><?php echo __('twitter_secret_content');?></span>
                                        <span class="error"><?php echo isset($errors['twitter_consumer_secret'])?ucfirst($errors['twitter_consumer_secret']):''; ?></span></td>
                                </tr>
                                <tr>
                                        <td><label><?php echo __('tw_share');?> :</label></td>   
                                        <td><textarea name="twitter_share" id="twitter_share" class="twitter_share" ><?php echo isset($site_socialnetwork) &&  (!array_key_exists('twitter_share',$errors))? $site_socialnetwork[0]['twitter_share']:$validator['twitter_share'];?></textarea> 
                                          <span class="error"><?php echo isset($errors['twitter_share'])?ucfirst($errors['twitter_share']):''; ?></span></td>
                                </tr>

                                <tr>
                                        <td><label><?php echo __('linkedin_share');?> :</label></td>   
                                        <td><textarea name="linkedin_share" id="linkedin_share" class="linkedin_share" ><?php echo isset($site_socialnetwork) &&  (!array_key_exists('linkedin_share',$errors))? $site_socialnetwork[0]['linkedin_share']:$validator['linkedin_share'];?></textarea> 
                                          <span class="error"><?php echo isset($errors['linkedin_share'])?ucfirst($errors['linkedin_share']):''; ?></span></td>
                                </tr>
                               
                               <!--- End of twitter-->
				<!--Start Linkedin---->
				 </tr>
                                <th style="display:none;"><span class="blue_head"><?php echo __('linkedin_heading');?></span></th>
                                
                                <tr style="display:none;">
                                        <td></td>   
                                        <td>
                                        <input type="checkbox" name="linkedin_login"  value="Y" <?php echo( $site_socialnetwork[0]['linkedin_login']=="Y")?"checked='checked'":""; ?>> <label><?php echo __('linkedin_login_label');?></label>
                                       <p ><?php echo __('linkedin_login_content');?></span>
                                        </td>                           
                                </tr>
                              <tr style="display:none;">
                                        <td><label><?php echo __('linkedin_apikey');?> :</label></td>   
                                        <td><input type="text" name="linkedin_apikey" id="linkedin_apikey" class="linkedin_apikey" title="Enter linkedin Api Key" maxlength="250" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('linkedin_apikey',$errors))? $site_socialnetwork[0]['linkedin_apikey']:$validator['linkedin_apikey'];?>"><span class="info_label"><?php echo __('linkedin_apikey_content');?></span> 
                                        <span class="error"><?php echo isset($errors['linkedin_apikey'])?ucfirst($errors['linkedin_apikey']):''; ?></span></td>                                       
                                </tr>
                                <tr style="display:none;">
                                        <td><label><?php echo __('linkedin_secret_label');?>:</label></td>   
                                        <td><input type="text" name="linkedin_secret_key" id="linkedin_secret_key" class="linkedin_secret_key" title="Enter your secret key" maxlength="250" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('linkedin_secret_key',$errors))? $site_socialnetwork[0]['linkedin_secret_key']:$validator['linkedin_secret_key'];?>"><span class="info_label"><?php echo __('linkedin_secret_key_content');?></span>
                                        <span class="error"><?php echo isset($errors['linkedin_secret_key'])?ucfirst($errors['linkedin_secret_key']):''; ?></span></td>
                                </tr>
                                 <tr style="display:none;">
                                        <td><label><?php echo __('linkedin_usertoken_label');?>:</label></td>   
                                        <td><input type="text" name="linkedin_usertoken_key" id="linkedin_usertoken_key" class="linkedin_usertoken_key" title="Enter your Oauth user token" maxlength="250" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('linkedin_usertoken_key',$errors))? $site_socialnetwork[0]['linkedin_usertoken_key']:$validator['linkedin_usertoken_key'];?>"><span class="info_label"><?php echo __('linkedin_usertoken_key_content');?></span>
                                        <span class="error"><?php echo isset($errors['linkedin_usertoken_key'])?ucfirst($errors['linkedin_usertoken_key']):''; ?></span></td>
                                </tr>
                                 <tr style="display:none;">
                                        <td><label><?php echo __('linkedin_usertokensecret_label');?>:</label></td>   
                                        <td><input type="text" name="linkedin_usertokensecret_key" id="linkedin_usertokensecret_key" class="linkedin_usertokensecret_key" title="Enter your Oauth user secret key" maxlength="250" value="<?php echo isset($site_socialnetwork) &&  (!array_key_exists('linkedin_usertokensecret_key',$errors))? $site_socialnetwork[0]['linkedin_usertokensecret_key']:$validator['linkedin_usertokensecret_key'];?>"><span class="info_label"><?php echo __('linkedin_usertokensecret_key_content');?></span>
                                        <span class="error"><?php echo isset($errors['linkedin_usertokensecret_key'])?ucfirst($errors['linkedin_usertokensecret_key']):''; ?></span></td>
                                </tr>
				<!---End--->
				 <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                        <input type="reset" name="socialnetwork_reset" value="<?php echo __('button_reset');?>">
                                        <input type="submit" name="socialnetwork_submit" value="<?php echo __('button_update');?>">                       	   
                                        </td>
                                </tr>
                                </table>
                </form>
                <br/><br/>
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
      toggle(8);
});
</script>
