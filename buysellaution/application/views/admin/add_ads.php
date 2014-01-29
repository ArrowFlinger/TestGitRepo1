<?php defined('SYSPATH') OR die("No direct access allowed."); 
 /* Status Box Checked */
//------------------------
 if(isset($ads_data['ads_status'])	&& $ads_data['ads_status']=="A")
 { $status_checked="checked='checked'"; }
 else if(isset($ads_data['ads_status'])	&& $ads_data['ads_status']=="I")
 { $status_checked=""; }
 else
 { $status_checked=""; }
 
 
?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
		 <form method="post" enctype="multipart/form-data" class="admin_form" name="frmuser" id="frmuser" action ="<?php echo URL_BASE;?>settings/<?php echo $action;?>">
                <table border="0" cellpadding="5" cellspacing="0" width="80%">


                              
                        
                        <tr>
                                <td width="20%"><label><?php echo __('title_ads'); ?></label><span class="star">*</span></td>
                                <td>
                                		<input type="text" name="title" maxlength="32" id="title" value="<?php echo isset($ads_data['title']) ? trim($ads_data['title']):$validator['title']; ?>"/>
                                   <span class="error">
					<?php echo $ads_exists; ?>
                                        <?php echo isset($errors['title'])?ucfirst($errors['title']):""; ?>
                                    </span>
                                </td>
                         
                        </tr>
                        <tr>
                         <td valign="top"><label><?php echo __('photo_ads'); ?></label><span class="star">*</span></td>
                      	<td>

				     <?php
						//code to remove or delete photo link
						$ads_image_path=ADMINIMGPATH.NO_IMAGE;
						$light_box_class=$delete_link=$atag_start=$atag_end="";
						$image_title=__('no_photo');
						//check if file exists or not
						if(((isset($ads_data)) && $ads_data['ads_image']) && (file_exists(DOCROOT.ADS_IMGPATH.$ads_data['ads_image'])))
				        {
				           $ads_image_path = URL_BASE.ADS_IMGPATH.$ads_data['ads_image'];
				                   $image_title=$ads_data['title'];
						  
						   $delete_title = __('delete');
						   $delete_link="<a onclick='frmdel_photo(".$ads_data['ads_id'].");' class='deleteicon' title='$delete_title' id='photo_delete'></a>";
						   $atag_start='<a href='.$ads_image_path.' title='.$image_title.'>';
						   $atag_end='</a>';
						 }

						?>

                                        <?php echo $delete_link; ?>
                                        <span style="margin-right:30px;" id="gallery">
										<?php echo $atag_start; ?>
                                        <img src="<?php echo $ads_image_path; ?>" title="<?php echo $image_title; ?>" class="fl" width="<?php echo ADS_SMALL_IMAGE_WIDTH;?>" height="<?php echo ADS_SMALL_IMAGE_HEIGHT;?>" >
										<?php echo $atag_end; ?>
                                        </span>

						    <div style="width:300px;float:left;">
						          <span class="text_bg4 fl" style="margin:0 0 0 5px;">
						               <p class="fl clr" style="width:120px;text-align:center;font-weight:bold;font-size:11px;"><?php echo __('profile_image_content_product');?> </p>
						          </span>
						        <div class="order_button fl clr" style="width:auto;margin:0 0 0 5px;">
						            <!-- <div class="order_but_left fl"></div> -->
						           <div class="orderr_but_mid fl clr">
						              <input name="ads_image" type="file" style="height:30px;width:auto; font:bold 12px Arial, Helvetica, sans-serif;color:#333;"/>
						            </div>

						         </div>
                                  	
						        </div>
								<span class="error">
                                        <?php echo isset($errors['ads_image'])?ucfirst($errors['ads_image']):""; ?>
                                    </span>	

                             </td>

                        </tr>
	   <tr>
                                <td width="20%"><label><?php echo __('website_label'); ?></label><span class="star">*</span></td>
                                <td>
                                	<input type="text" name="website" maxlength="100" id="website" value="<?php echo isset($ads_data['website'])  ? trim($ads_data['website']) : $validator['website']; ?>" />
                               		<span class="error">
					<?php echo isset($errors['website'])?ucfirst($errors['website']):""; ?>
					</span>
                                </td>
                        </tr>
                   
                        <tr>
                                <td valign="top"><label><?php echo __("status_label"); ?></label></td>                               
                                <td colspan="2" valign="middle">
                                    <input type="checkbox" name="ads_status[]" value="A" <?php echo $status_checked; ?> />                                
                                </td>
                               
                        </tr> 
                        
                        <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  	
                                  	<input type="button" value="<?php echo __('button_back'); ?>" title="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>settings/manage_ads'" />
                                  	<input type="reset" value="<?php echo __('button_reset'); ?>" title="<?php echo __('button_reset'); ?>" />
                                  	<input type="submit" value="<?php echo ($action == 'add_ads' )?''.__('button_add').'':''.__('button_update').'';?>" name="<?php echo ($action == 'add_ads' )?'admin_add':'admin_edit';?>" title="<?php echo ($action == 'add' )?''.__('button_add').'':''.__('button_update').'';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr>

                </table>
        </form>
    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>

<script type="text/javascript">
//code for checking message field maxlength


//For Delete the users photo
//=====================
function frmdel_photo(userid)
{
    var answer = confirm("<?php echo __('delete_alert_ads_image');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>/settings/delete_ads_image/"+userid;
    }

    return false;
}
$(document).ready(function(){
      toggle(1);
}); 

</script>
