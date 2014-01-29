<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right">
	<div class="message_common_border">
		<h1><?php echo __('menu_edit_testimonials');?></h1>
		<p>&nbsp;</p>
	</div>
	<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
		  <input type="hidden" name="imagename" maxlength="32" id="title" value="<?php echo $mytestimonials_values[0]['images'];  ?>"/>		
	<div class="message_common" id="testimonials_edit_page">
	<div class="login_middle_common_profil">
		<div class="user_name_common">
			<p><?php echo __('title_label');?> <span class="red">*</span>:</p>
			<div class="text_feeld">
				<h2><?php  echo Form::input('title', isset($mytestimonials_values['title'])?$mytestimonials_values['title']:$mytestimonials_values[0]['title'],array("id"=>"title","Maxlength"=>"20",'title'=>__('title_label'))) ?></h2>
			</div>
				<?php if($errors && array_key_exists('title',$errors)){?><label class=""><span class="red"><?php  echo (array_key_exists('title',$errors))? $errors['title']:"";?></span></label><?php }?>
		</div>

		<div class="user_name_common">
			<p><?php echo __('description_label');?> <span class="red">*</span>:</p>
			<div class="text_feeld">
				<h2><?php echo Form::textarea('description',isset($mytestimonials_values['description'])?$mytestimonials_values['description']:$mytestimonials_values[0]['description'],array( 'onkeyup'=>"return limitlength(this, 500)", 'maxlength'=>'500','class'=>'textarea','cols'=>'28', 'rows' => '8'));?></h2>

				<?php if($errors && array_key_exists('description',$errors)){?><label class="errore_msg fl clr"><span class="red">
								<?php echo (array_key_exists('description',$errors))? $errors['description']:"";?></span>
								</label><?php }?>
			<h3><span class="info_label" id="info_label" ></span><br><span class="info_label" id="info_label" ><?php echo __('max_label');?> 256 </span></h3>
		</div>
	</div>
	<div class="user_name_common">
	<p><?php echo __('photo_label');?></p>
				<?php
				$delete_link="";
				if(($mytestimonials_values[0]['images'])!="" && file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$mytestimonials_values[0]['images']))
				{ 
					$testimonials_img_path=URL_BASE.TESTIMONIALS_IMGPATH.$mytestimonials_values[0]['images'];
					$delete_title = __('delete');
					$delete_link="<a onclick='frmdel_photo(".$mytestimonials_values[0]['testimonials_id'].");' class='deleteicon' title='$delete_title' id='photo_delete'></a>";
				}
				else
				{
					$testimonials_img_path=IMGPATH.NO_IMAGE;
				}
				?>
				<?php  echo $delete_link; ?>		

				<img src="<?php echo $testimonials_img_path;?>"  alt="no_img" width="150" height="150" title="<?php echo $mytestimonials_values[0]['title'];?>"/>

		<div class="text_feeld">
			<input class="input" size="68" type="file" name="photo" value=""/>
		</div> 				
		<?php echo isset($errors['file'])?$errors['file']:""; ?>
							<?php if($errors && array_key_exists('photo',$errors)){?> <label class="errore_msg fl clr"><span class="red">
							<?php echo (array_key_exists('photo',$errors))? $errors['photo']:"";?></span>
							</label><?php }?>
		</div>
	<div class="user_name_common"><?php echo __('or')?></div>
	<?php $content_video_exist=(!empty($mytestimonials_values[0]['video_url']))?YOUTUBE_VIDEO_URL:''; ?>
	<div class="user_name_common">
	<p><?php echo __('video_label');?>:</p>
		<div class="text_feeld">
		<?php echo $mytestimonials_values[0]['embed_code']; ?>
		<?php echo Form::input('video',isset($mytestimonials_values['video_url'])?$mytestimonials_values['video_url']:$content_video_exist.$mytestimonials_values[0]['video_url'],array('class'=>'textbox'));?>
		</div>

	<div class="no_img_inner">
	 <?php if($errors && array_key_exists('video',$errors)){?>  <label class="errore_msg fl clr"><span class="red">
					<?php echo (array_key_exists('video',$errors))? $errors['video']:"";}?></span></label>
					<?php if($video_error){?>  <label class="errore_msg fl clr"><span class="red">
					<?php echo $video_error; ?> 
					</span></label><?php } ?>
	<?php echo __('youtube_label');?>
	</div>
	<div class=" buton_green">
		<div class="profil_butoon">
			<div class="res_left"></div>
			<div class="res_mid"><?php echo Form::submit('edit_testimonials',__('button_update'),array('title' =>strtoupper(__('button_update'))));?></div>
			<div class="res_right"></div>
			</div>
	<?php echo Form::close();?>
	</div>
	</div>
	</div>
	</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_testimonials_active").addClass("user_link_active");});
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
                //inner html
                document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
        }
}
function frmdel_photo(testimonials_id)
{
    var answer = confirm("<?php echo __('delete_alert_testimonialsimage');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>users/delete_testimonialsphoto/"+testimonials_id;
    }

    return false;
}
</script>

<script type="text/javascript">
$(document).ready(function () {$("#my_testimonials_active").addClass("act_class");});
</script>
