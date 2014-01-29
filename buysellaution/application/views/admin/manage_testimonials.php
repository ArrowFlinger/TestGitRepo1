<?php defined('SYSPATH') OR die("No direct access allowed."); 
 /* Status Box Checked */
//------------------------
$status_checked ="";
 if(isset($testimonials_data['status'])	&& $testimonials_data['status']== ACTIVE)
 { $status_checked="checked='checked'"; }

 //For based on the user type, field defined
 
 $status_field=$back_button=$admin_status_field="";
 if(isset($testimonials_data['usertype']) && $testimonials_data['usertype']!=ADMIN) {

 $status_field="<tr>
                  	<td><label>".__('status_label')."</label></td>
                    <td>
                   	   	<input type='checkbox' name='status[]' value='A' ".$status_checked." />";
                         if(isset($errors['status'])) {
						 	$status_field.="<span style='padding-left: 5px;' class='label_error'>".$errors['status']."</span>";
						}
                    $status_field.="</td>
                 </tr> ";
 
}else{
	 $admin_status_field="
	<input type='hidden' name='status[]' value='A' >";
	}


 ?>
<link type="text/css" href="<?php echo LIGHTBOX_CSSPATH;?>" rel="stylesheet" media="screen" />
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
		 <form method="post" enctype="multipart/form-data" class="admin_form" name="frmuser" id="frmuser" action ="<?php echo URL_BASE;?>manageusers/manage_testimonials/<?php echo $testimonials_data['testimonials_id'];?>">
                <table border="0" cellpadding="5" cellspacing="0" width="80%">

                        <tr>
                                <td width="20%"><label></label></td>
                                <td>
                                                <input type="hidden" name="testimonials_id" maxlength="32" id="title" value="<?php echo $testimonials_data['testimonials_id']  ?>"/>
                                		<input type="hidden" name="username_id" maxlength="32" id="title" value="<?php echo $testimonials_data['user_id']  ?>"/>
                                		<input type="hidden" name="imagename" maxlength="32" id="title" value="<?php echo $testimonials_data['images']  ?>"/>
                                    </td>
                        </tr>
                        <tr>
                                <td width="20%"><label><?php echo __('title_label'); ?></label><span class="star">*</span></td>
                                <td>
                                		<input type="text" name="title" maxlength="32" id="title" value="<?php echo isset($testimonials_data['title']) &&!array_key_exists('title',$errors)? trim($testimonials_data['title']):$validator['title']; ?>"/>
                                   <span class="error">
                                        <?php echo isset($errors['title'])?ucfirst($errors['title']):""; ?>
                                    </span>
                                </td>
                        </tr>
                        
                        <tr>
                                <td width="20%"><label><?php echo __('description_label'); ?></label><span class="star">*</span></td>
                                <td>
                                <textarea name="description" id="description" class="resizetextarea"  value="" value="" onkeyup="return limitlength(this, <?php echo $product_settings[0]['max_desc_length'];?>,'product_info_label')"><?php echo isset($testimonials_data['description']) && !array_key_exists('product_info',$errors)? $testimonials_data['description']:$validator['description']; ?></textarea>
                          
                               		<span class="error">
										<?php echo isset($errors['description'])?ucfirst($errors['description']):""; ?>
									</span>
									<span class="info_label" id="info_label"></span>
				<span class="info_label" id="info_label"><?php echo __('info_product_name');?>:<?php echo $product_settings[0]['max_desc_length'];?></span>
				
                                </td>
                        </tr>

                        <tr>
                         <td valign="top"><label><?php echo __('photo_label'); ?></label></td>
                      	<td>

                                <?php
                                //code to remove or delete photo link
                                $user_image_path=ADMINIMGPATH.NO_IMAGE;
                             
                                $light_box_class=$delete_link=$atag_start=$atag_end="";
                                $image_title=__('no_photo');
                                //check if file exists or not
                                if(((isset($testimonials_data)) && $testimonials_data['images']))                  
                                {
                                $user_image_path = URL_BASE.TESTIMONIALS_IMGPATH.$testimonials_data['images'];
                               
                                $light_box_class="class='lightbox'";
                                $delete_title = __('delete');
                                $delete_link="<a onclick='frmdel_photo(".$testimonials_data['testimonials_id'].");' class='deleteicon' title='$delete_title' id='photo_delete'></a>";
                                $atag_start='<a href='.$user_image_path.' title='.$image_title.'>';
                                $atag_end='</a>';
                                }
                               
                                ?>

                                        <?php echo $delete_link; ?>
                                        <span style="margin-right:30px;" id="gallery">
										<?php echo $atag_start; ?>
										   
                                        <img src="<?php echo $user_image_path; ?>" title="<?php echo $image_title; ?>" class="fl" width="<?php echo USER_SMALL_IMAGE_WIDTH;?>" height="<?php echo USER_SMALL_IMAGE_HEIGHT;?>" >
										<?php echo $atag_end; ?>
                                        </span>

						    <div style="width:300px;float:left;">
						          <span class="text_bg4 fl" style="margin:0 0 0 5px;">
						               <p class="fl clr" style="width:120px;text-align:center;font-weight:bold;font-size:11px;"><?php echo __('profile_image_content_user');?> </p>
						          </span>
						        <div class="order_button fl clr" style="width:auto;margin:0 0 0 5px;">
						            <!-- <div class="order_but_left fl"></div> -->
						           <div class="orderr_but_mid fl">
						              <input name="photo" type="file" style="height:30px;width:auto; font:bold 12px Arial, Helvetica, sans-serif;color:#333;"/>
						            </div>

						         </div>
                                  <span class="error-userphoto" id="userphoto">
                                        <?php echo isset($errors['photo'])?ucfirst($errors['photo']):""; ?>
                                    </span>
						        </div>


                             </td>
                             </tr>
                               <tr>
                                <td width="20%"><label></label></td>
                                <td>
                                		<?php echo __('(Or)'); ?>
                                </td>
                        </tr>
                        <?php $content_video_exist=(!empty($testimonials_data['video_url']))?YOUTUBE_VIDEO_URL:''; ?>
                             <tr>
                             
                                <td width="20%"><label><?php echo __('video_label'); ?></label></td>
                                <td>
                                		<?php echo $testimonials_data['embed_code']; ?>
                                		
                                		<div class="order_button fl clr" style="width:auto;margin:0 0 0 5px;">
						            <!-- <div class="order_but_left fl"></div> -->
						           <div class="orderr_but_mid fl">
						           <input type="text" name="video"  value="<?php echo isset($testimonials_data['video_url']) &&!array_key_exists('video',$errors)? trim($content_video_exist.$testimonials_data['video_url']):$validator['video']; ?>"/>
						             <div><span ></br> <span class="search_info_label"><?php echo __('youtube_label');?></span><?php echo __('');?>  </span></div>
						            </div>
						            </div> 
                                </td>
                        </tr>

                        
                        <?php echo $status_field; ?>
                        <tr>
                        	<td colspan="2" class="star">*<?php echo __('required_label'); ?></td>
                        </tr>
                        <tr>
                                <td colspan="3" style="padding-left:110px;">
                                  <br />
                                  	<?php echo $admin_status_field;?>
                                  	<input type="button" value="<?php echo __('button_back'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/testimonials'" />
                                  	<input type="reset" value="<?php echo __("button_reset"); ?>" title="<?php echo __("button_reset"); ?>" />
								  	<input type="submit" value="<?php echo ($action == 'add' )?''.__("button_add").'':''.__("button_update").'';?>" name="<?php echo ($action == 'add' )?'admin_add':'admin_edit';?>" title="<?php echo ($action == 'add' )?''.__("button_add").'':''.__("button_update").'';?>" />
                                  <div class="clr">&nbsp;</div>
                                </td>
                        </tr>

                </table>
        </form>
    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
<script type="text/javascript" src="<?php echo LIGHTBOX_SCRIPTPATH;?>"></script>
<script type="text/javascript">
//code for checking message field maxlength
//============================
function limitlength(obj, maxlength){
        //var maxlength=length
        if (obj.value.length>maxlength){
                obj.value=obj.value.substring(0, maxlength);
                // max reach
                //$("span.info_label").html("<?php echo __('ddfdsfdsf');?>");
                document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
        }else{
                var charleft = maxlength - obj.value.length;
                //alert(charleft);
                //inner html
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }
}

//For Delete the users photo
//=====================
function frmdel_photo(testimonials_id)
{
    var answer = confirm("<?php echo __('delete_alert_testimonialsimage');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>manageusers/delete_testimonialsphoto/"+testimonials_id;
    }

    return false;
}

$(document).ready(function(){

	//For Field Focus
	//===============
	field_focus('firstname');

    //For Photo View Using Lightbox
    //=============================
    jQuery(function($) {
        $('#gallery a').lightBox();
    });
});
</script>
