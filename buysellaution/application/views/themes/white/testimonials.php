<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right">
		<div class="message_common_border">
			<h1><?php echo __('menu_add_testimonials');?></h1>
			<p>&nbsp;</p>
		</div>
	<div class="message_common">
		<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
		<?php echo Form::hidden('username_id', $auction_userid);?>
		<div class="login_middle_common_profil">
			<div class="user_name_common">
				<p><?php echo __('title_label');?> <span class="red">*</span>:</p>
				<div class="text_feeld">
					<h2><?php echo Form::input('title',$form_values['title'],array('maxlength'=>'30','class'=>'textbox','title'=>'Title'));?></h2>
				</div><span class="red"><?php if($errors){echo (array_key_exists('title',$errors))? $errors['title']:"";}?></span>
			</div>

		<div class="user_name_common">
			<p><?php echo __('description_label');?> <span class="red">*</span>:</p>
			<div class="text_feeld">
				<h2><?php echo Form::textarea('description',$form_values['description'],array( 'onkeyup'=>"return limitlength(this, 256)", 'maxlength'=>'256','class'=>'textarea','cols'=>'28', 'rows' => '8','title'=>'Description'));?></h2>
				<h3><span class="info_label" id="info_label" ></span><br><span class="info_label" id="info_label" ><?php echo __('max_label');?> 256 </span></h3>
			</div><span class="red"><?php if($errors){echo (array_key_exists('description',$errors))? $errors['description']:"";}?></span>
		</div>

		<div class="user_name_common">
			<p><?php echo __('image_label');?>:</p>
			<div class="text_feeld">
				<input class="input" size="68" name="photo" type="file" value=""/>
			</div>			
			<div class="no_img_inner">
				<span class="red"><?php if($errors){echo (array_key_exists('photo',$errors))? $errors['photo']:"";}?></span>
			</div>
		</div>
		
	<div class="user_name_common"><?php echo __('or')?></div>

			<div class="user_name_common">
				<p><?php echo __('video_label');?>:</p>
			<div class="text_feeld">
				<?php echo Form::input('video',$form_values['video'],array('class'=>'textbox'));?>
			</div>			
			<div class="no_img_inner">			
			<span class="red"><?php if($errors){echo (array_key_exists('video',$errors))? $errors['video']:"";}?><?php if($video_error){ echo $video_error; } ?></span><br>
			<?php echo __('youtube_label');?> 
			</div>
		   </div>
			<div class=" buton_green">
				<div class="profil_butoon">
					<div class="res_left"></div>
					<div class="res_mid">
						<?php echo Form::submit('testimonials',strtoupper(__('button_add')),array('title' =>strtoupper(__('button_add'))));?>
					</div>
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
</script>

<script type="text/javascript">
$(document).ready(function () {$("#my_testimonials_active").addClass("act_class");});
</script>
