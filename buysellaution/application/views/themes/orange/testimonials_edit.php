<?php defined("SYSPATH") or die("No direct script access.");?>
<style type="text/css">
.row_colm1 p
{
width:150px;
}
.row_colm1 b {
    width: 160px;
}
</style>
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('menu_edit_testimonials');?>"><?php echo __('menu_edit_testimonials');?></h2>
        </div>
        </div>
        </div>
                 <div class="deal-left clearfix">
     <div class="action_deal_list  action_deal_list1 clearfix">	
<div class="edit_content fl clr mt20 ml15 pb20">
	<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
	        <input type="hidden" name="imagename" maxlength="32" id="title" value="<?php echo $mytestimonials_values[0]['images'];  ?>"/>				
		<!--Testimonials Title-->
                <div class="row_colm1 fl clr mt10">
        	<div class="colm1_width fl"><p><?php echo __('title_label');?><span class="red">*</span>:</p>
                <div class="colm2_width fl">
                <div class="inputbox_out fl">
                <?php  echo Form::input('title', isset($mytestimonials_values['title'])?$mytestimonials_values['title']:$mytestimonials_values[0]['title'],array("id"=>"title","Maxlength"=>"20",'title'=>__('title_label'))) ?>
                </div>    
                <?php if($errors && array_key_exists('title',$errors)){?><label class="errore_msg fl clr"><span class="red"><?php  echo (array_key_exists('title',$errors))? $errors['title']:"";?></span></label><?php }?>
                </div>
                </div>
                </div>
		<!--Testimonials Description-->
                <div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('description_label');?><span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                <div class="inputbox_out textarea_out fl">
                <?php echo Form::textarea('description',isset($mytestimonials_values['description'])?$mytestimonials_values['description']:$mytestimonials_values[0]['description'],array( 'onkeyup'=>"return limitlength(this, 500)", 'maxlength'=>'500','class'=>'textarea','cols'=>'28','style'=>'resize:none;', 'rows' => '8'));?>
                </div>
                <?php if($errors && array_key_exists('description',$errors)){?><label class="errore_msg fl clr"><span class="red">
					<?php echo (array_key_exists('description',$errors))? $errors['description']:"";?></span>
		</label><?php }?>
                <br clear="left"><div class="info_label" id="info_label" ></div>
        <div class="info_label" id="info_label" ><?php echo __('max_label');?>: 500 </div>
           	</div>
		</div>
		<!--Testimonials Image-->
        	<div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('image_label');?><span class="red"></span>:</p></div>
           	<div class="colm2_width fl">
                <div>
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
	                <img src="<?php echo $testimonials_img_path;?>" width="150" height="150" title="<?php echo $mytestimonials_values[0]['title'];?>" />
	       
                </div> <?php  echo $delete_link; ?> 
                 <div class="fl clr mt10">
                <input name="photo" type="file" style="height:30px;width:auto; font:bold 12px Arial, Helvetica, sans-serif;color:#333;"/>
                </div>
                <?php echo isset($errors['file'])?$errors['file']:""; ?>
                <?php if($errors && array_key_exists('photo',$errors)){?> <label class="errore_msg fl clr"><span class="red">
                <?php echo (array_key_exists('photo',$errors))? $errors['photo']:"";?></span>
                </label><?php }?>
		</div>
		</div>
		
		<div  style="margin:15px 0 0 250px; color:#eee;float:left;">
             	<?php  echo __('Or');?>
                </div>
                
		<!--Testimonials Video-->
		<?php $content_video_exist=(!empty($mytestimonials_values[0]['video_url']))?YOUTUBE_VIDEO_URL:''; ?>
        	<div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><p><?php echo __('video_label');?>:</p></div>
           	<div class="colm2_width fl">
               
                <?php echo $mytestimonials_values[0]['embed_code']; ?>
                 <div class="inputbox_out fl" style="margin:5px 0 0 0;"><?php echo Form::input('video',isset($mytestimonials_values['video_url'])?$mytestimonials_values['video_url']:$content_video_exist.$mytestimonials_values[0]['video_url'],array('class'=>'textbox'));?>
                </div>
                <?php if($errors && array_key_exists('video',$errors)){?>  <label class="errore_msg fl clr"><span class="red">
		<?php echo (array_key_exists('video',$errors))? $errors['video']:"";}?></span></label>
		<?php if($video_error){?>  <label class="errore_msg fl clr"><span class="red">
		<?php echo $video_error; ?> 
		</span></label><?php } ?>
                <br clear="left">
		<div style="color:#333"><?php echo __('youtube_label');?>  </div>
           	</div>
		</div>

		<!--Submit button-->
		<div class="row_colm1 fl clr mt20">
		<div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
		<div class="colm2_width fl">
                <div class="login_submit_btn fl">
                <span class="login_submit_btn_left fl">&nbsp;</span>
                <span class="login_submit_btn_middle fl">
                <?php echo Form::submit('edit_testimonials',__('button_update'),array('title' =>__('button_update')));?>
                </span>
                <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
		</div>
		</div>
		
	        <?php echo Form::close();?>
</div> 
</div>

        <div class="auction-bl" style="width:660px;">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div></div>

<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
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
