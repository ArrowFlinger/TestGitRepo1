<?php defined('SYSPATH') OR die("No direct access allowed."); 

$sucessful_message=Message::display();

if($sucessful_message) { ?>
    <div id="messagedisplay" class="padding_150">
         <div class="notice_message">
            <?php echo $sucessful_message; ?>
         </div>
    </div>
<?php } ?>
 <?php 
 $status_checked = "";
 if(isset($site_settings[0]['maintenance_mode']) && $site_settings[0]['maintenance_mode']=="A")
 { $status_checked="checked='checked'"; }
 ?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle" >
       
                <form method="POST" enctype="multipart/form-data" class="admin_form" action="<?php echo URL_BASE;?>settings/<?php echo $action;?>" >
                        <table class="0 fl clr" cellpadding="5" cellspacing="0" width="100%">
                        <tr>
                        <td valign="top"><label><?php echo __('site_name_label');?> </label><span class="star">*</span></td>   
                        <td><input type="text" name="site_name" id="site_name" class="site_name" title="Enter your site name" maxlength="30" value="<?php echo isset($site_settings) &&  (!array_key_exists('site_name',$errors))? $site_settings[0]['site_name']:$validator['site_name'];?>">
                        <span class="error"><?php echo isset($errors['site_name'])?ucfirst($errors['site_name']):''; ?></span>
                        </td>
                        </tr>
                        
                        
                        <tr>
                        <td valign="top"><label><?php echo __('site_slogan_label');?> </label><span class="star">*</span></td>   
                        <td><input type="text" name="site_slogan" id="site_slogan" class="site_slogan" title="Enter your site slogan" maxlength="30" value="<?php echo isset($site_settings) &&  (!array_key_exists('site_slogan',$errors))? $site_settings[0]['site_slogan']:$validator['site_slogan'];?>">
                        <span class="error"><?php echo isset($errors['site_slogan'])?ucfirst($errors['site_slogan']):''; ?></span></td>
                        </tr>
                        
                        <tr>
                        <td valign="top"><label><?php echo __('site_description_label');?> </label><span class="star">*</span></td>   
                        <td><textarea class="resizetextarea" name="site_description" id="site_description" onkeyup="return limitlength(this, <?php echo $product_settings[0]['max_desc_length'];?>)" class="site_description" title="Enter your site Description" value=""><?php echo isset($site_settings) &&  (!array_key_exists('site_description',$errors))? $site_settings[0]['site_description']:$validator['site_description'];?></textarea>
                        <span class="error width100 fl clr p0">                                     
                        <?php echo isset($errors['site_description'])?ucfirst($errors['site_description']):''; ?>
                        </span>
                        <span class="info_label" id="info_label"></span>
                        <span class="info_label" id="info_label">
                        <?php echo __('info_product_name');?>:<?php echo $product_settings[0]['max_desc_length'];?>
                        </span>   
                        </td>
                        
                        </tr>  
                        <!--Theme Select-->                                                             
                        <tr>
                        <td valign="top"><label><?php echo __('site_theme_label');?> </label>
                        <span class="star">*</span></td>   
                        <td><select name="theme" id="theme"  >
                        <?php  
                        $themes = array();
                        $dir = DOCROOT."application/views/themes";
                        // Open a known directory, and proceed to read its contents
                        if (is_dir($dir)) { 
                        if ($dh = opendir($dir)) {
                        while (false !== ($file = readdir($dh))) {
                        if(strlen($file)>2 && !preg_match('/.php/i',$file))
                        {
                        array_push($themes,$file);
                        }
                        }
                        closedir($dh);
                        }
                        }
                        sort($themes);
                        foreach($themes as $theme){
                        ?>
                        <option value="<?php echo $theme; ?>" <?php if($site_settings[0]['theme'] == $theme) { ?> selected="selected" <?php } ?> >
                        <?php echo ucfirst($theme); ?>
                        </option>                            
                        <?php }   ?>
                        </select>
                        <span class="error">
                        <?php echo isset($errors['theme'])?ucfirst($errors['theme']):''; ?></span>
                        </td>
                        </tr>
                        <!--End-->
                        
                        <tr>
                        <td valign="top"><label><?php echo __('site_version_label');?> </label><span class="star">*</span></td>   
                        <td><input type="text" name="site_version" id="site_version" class="site_version" title="Enter your site version" maxlength="30" value="<?php echo isset($site_settings) &&  (!array_key_exists('site_version',$errors))? $site_settings[0]['site_version']:$validator['site_version'];?>">
                        <span class="error"><?php echo isset($errors['site_version'])?ucfirst($errors['site_version']):''; ?></span></td>
                        </tr>
                        <tr>
                        <td valign="top"><label><?php echo __('site_language_label');?> </label><span class="star">*</span></td>   
                        <td><select name="site_language" id="site_language"  >
                        
                        <?php 
                        foreach($alllang as $language_key => $language_val){ 
                       
                        // ?> 
                        
                        <option value="<?php echo $language_key; ?>" <?php echo ($site_settings[0]['site_language'] == $language_key)?"selected='selected'":"";?> >
                        <?php echo ucfirst($language_val); ?></option>							
                        <?php } ?> 						
                        </select>
                        <span class="error"><?php echo isset($errors['site_language'])?ucfirst($errors['site_language']):''; ?></span>
                        </td>
                        </tr>
                        
                        <tr>
                        <td valign="top"> <label><?php echo __('site_currency_code_label');?></label></td>
                        <td> 
                        <select name="site_paypal_currency_code">
                        <?php
                        // Code to display all currency  format
                        $selected_currency_code="";
                        
                        foreach($all_currency_code as $currency_key) 
                        {                                        
                        if(isset($site_settings[0]['site_paypal_currency_code'])){?>
                        <option  value="<?php echo $currency_key; ?>"
                        <?php echo ($site_settings[0]['site_paypal_currency_code'] == $currency_key)?"selected='selected'":"";?> ><?php echo $currency_key;?></option>
                        
                        <?php  } }?> 												
                        </select>  
                        
                        </td>
                        </tr>                               
                        <!--Country time zone--> 
                        <tr>
                        <td valign="top"> <label><?php echo __('site_country_time_zone_label');?></label></td>
                        <td> 
			<select name="country_time_zone">
			<?php
					$continent=0;
					$timezone_identifiers = DateTimeZone::listIdentifiers();
					foreach( $timezone_identifiers as $value ){
					if ( preg_match( '/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value ) ){
					$ex=explode("/",$value);//obtain continent,city    
					if ($continent!=$ex[0]){
					if ($continent!="") echo '</optgroup>';
					echo '<optgroup label="'.$ex[0].'">';
					}
						$city=$ex[1];
						$continent=$ex[0];
						if(isset($site_settings[0]['country_time_zone'])){ ?>
             <option value="<?php echo $value; ?>" <?php echo ($site_settings[0]['country_time_zone'] == $value)?"selected='selected'":"";?> ><?php echo $value;?></option>
                                           <?php
						}
					}
				}
			?>		
			  </optgroup>
			</select> 
                        </td>
                        </tr>                              
                        <!--End-->
                        
                        <tr>
                        <td valign="top"><label><?php echo __('site_currency_label');?> </label><span class="star">*</span></td>   
                        <td>      
                        <select name="site_paypal_currency" id="site_paypal_currency" class="site_paypal_currency">
                        <?php foreach($currency_symbol as $key => $value) { 
                        if(isset($site_settings[0]['site_paypal_currency'])){?>
                        <option value="<?php echo $key; ?>" <?php echo ($site_settings[0]['site_paypal_currency'] == $key)?"selected='selected'":"";?> ><?php echo $value;?></option>
                        <?php }} ?>
                        </select>
                        </td>
                        <span class="error"><?php echo isset($errors['site_paypal_currency'])?ucfirst($errors['site_paypal_currency']):''; ?></span></td>
                        </tr>
                        <tr>
                        <td valign="top"><label><?php echo __('contact_email_label');?> </label><span class="star">*</span></td>   
                        <td><input type="text" name="contact_email" id="contact_email" class="contact_email" title="Enter your Contact email address" maxlength="30" value="<?php echo isset($site_settings) &&  (!array_key_exists('contact_email',$errors))? $site_settings[0]['contact_email']:$validator['contact_email'];?>">
                        <span class="error"><?php echo isset($errors['contact_email'])?ucfirst($errors['contact_email']):''; ?></span>
                        </td>
                        
                        </tr>
                        <tr>
                        <td valign="top" width="27%"><label><?php echo __('common_from_email_label');?> </label><span class="star">*</span></td>   
                        <td><input type="text" name="comman_email_from" id="comman_email_from" class="comman_email_from" title="Enter your Common email From address" maxlength="30" value="<?php echo isset($site_settings) &&  (!array_key_exists('comman_email_from',$errors))? $site_settings[0]['common_email_from']:$validator['comman_email_from'];?>">
                        <span class="error"><?php echo isset($errors['comman_email_from'])?ucfirst($errors['comman_email_from']):''; ?></span></td>
                        </tr>
                        <tr>
                        <td valign="top"><label><?php echo __('common_to_email_label');?> </label><span class="star">*</span></td>   
                        <td><input type="text" name="comman_email_to" id="comman_email_to" class="comman_email_to" title="Enter your Common email To address" maxlength="30" value="<?php echo isset($site_settings) &&  (!array_key_exists('comman_email_to',$errors))? $site_settings[0]['common_email_to']:$validator['comman_email_to'];?>">
                        <span class="error"><?php echo isset($errors['comman_email_to'])?ucfirst($errors['comman_email_to']):''; ?></span></td>
                        </tr>
                        
                        <tr>
                        <td valign="top"><label><?php echo __('site_tracker_label');?> </label> <span class="star">*</span></td>  
                        <td><textarea style="resize:none"  name="site_tracker" id="site_tracker"   class="date_time_highlight_tooltip"  cols="10" rows="7"><?php echo isset($site_settings) &&  (!array_key_exists('site_tracker',$errors))? $site_settings[0]['site_tracker']:$validator['site_tracker'];?></textarea>
                        <span class="error width100 fl clr p0">
                        <?php echo isset($errors['site_tracker'])?$errors['site_tracker']:''; ?>
                        </span>
                        </td>
                        </tr>
                        <tr>
                        <td valign="top"><label><?php echo __('site_logo_label'); ?></label></td>
                        <td>										      
                        <?php 
                        //code to remove or delete photo link
                        $logo_image_path=IMGPATH.DEFAULT_LOGO_IMAGE;
                        $light_box_class=$delete_link=$atag_start=$atag_end="";
                        $image_title=__('no_photo');
                        //check if file exists or not
                        if(((isset($site_settings)) && $site_settings[0]['site_logo']) && (file_exists(DOCROOT.LOGO_IMGPATH.$site_settings[0]['site_logo'])))
                        { 
                        $logo_image_path = URL_BASE.LOGO_IMGPATH.$site_settings[0]['site_logo'];
                        $image_title=$site_settings[0]['site_name'];
                        $light_box_class="class='lightbox'";
                        $delete_title = __('delete'); 
                        $delete_link="<a onclick='frmdel_photo(".$site_settings[0]['id'].");' class='deleteicon' title='$delete_title' id='photo_delete'></a>"; 
                        $atag_start='<a href='.$logo_image_path.' title='.$image_title.'>'; 
                        $atag_end='</a>';										   
                        }
                        
                        ?>
                        
                        <?php echo $delete_link; ?>
                        <span style="margin-right;" id="gallery">
                        <?php echo $atag_start; ?>                                        
                        <img src="<?php echo $logo_image_path; ?>" title="<?php echo $image_title; ?>" class="fl" width="<?php echo LOGO_SMALL_IMAGE_WIDTH;?>" height="<?php echo LOGO_SMALL_IMAGE_HEIGHT;?>" >
                        <?php echo $atag_end; ?>
                        </span>
                        
                        <div style="">									    
                        <span class="text_bg4 fl" style="margin:0 18px 0 5px;">
                        <p class="fl clr" style="width:120px;text-align:center;font-weight:bold;font-size:11px;"><?php echo __('profile_image_content');?> </p>
                        </span>
                        <div class="order_button fl clr" style="width:auto;margin:0 0 0 5px;">
                        <!-- <div class="order_but_left fl"></div> -->
                        <div class="orderr_but_mid fl">
                        <input name="site_logo" type="file" style="height:30px;width:auto; font:bold 12px Arial, Helvetica, sans-serif;color:#333;"/>  
                        </div>			
                        </div>
                        <span class="error-userphoto" id="sitelogo">
                        <?php echo isset($errors['site_logo'])?ucfirst($errors['site_logo']):""; ?>
                        </span>		
                        </div>
                        </td>
                        </tr> 
                        <tr>
                        <td valign="top"><label><?php echo __("maintanence_mode_label"); ?></label></td>                               
                        <td colspan="2" valign="middle">
                        <input type="checkbox" name="maintenance_mode" value="A" <?php echo $status_checked; ?> />                                
                        </td>

                        </tr> 
                        <tr>
                        <td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>                                
                        <tr>
                        <td valign="top">&nbsp;</td>
                        <td>
                        <input type="reset" name="editsettings_reset" title="<?php echo __('button_reset');?>" value="<?php echo __('button_reset');?>">
                        <input type="submit" name="editsettings_submit" title ="<?php echo __('button_update');?>" value="<?php echo __('button_update');?>">
                        
                        </td></tr>
                        </table>
                </form>
                <br/><br/>
              
        </div>

        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt" ></div></div>
</div>

</div>
<script type="text/javascript" language="javascript">
//code for checking message field maxlength
//============================
function limitlength(obj, maxlength){
        //var maxlength=length
        if (obj.value.length>maxlength){
                obj.value=obj.value.substring(0, maxlength);
                // max reach
               
                document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
                //alert(charleft);
                //inner html
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }     
} 

//For Delete the logo 
//=====================
function frmdel_photo(id)
{
    var answer = confirm("<?php echo __('delete_alert__logo_image');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>settings/delete_site_logo/"+id;
    }

    return false;  
} 

$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('site_name');

}); 
$(document).ready(function(){
      toggle(8);
});
</script>
