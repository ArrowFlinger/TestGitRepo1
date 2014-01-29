<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
                <h2 class="fl clr" title="<?php echo __('menu_edit_testimonials');?>"><?php echo __('menu_edit_testimonials');?></h2>
        </div>
        </div>
        </div>
         <div class="deal-left clearfix">
           <div class="action_deal_list action_deal_list2 clearfix">
    <div class="edit_content fl clr mt20 ml15 pb20">
	<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
        <!--user_id hidden type-->
	<?php echo Form::hidden('username_id', $auction_userid);?>
        <!--Testimonials Title-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('title_label');?><span class="red">*</span>:</p>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl"><?php echo Form::input('title',$form_values['title'],array('maxlength'=>'30','class'=>'textbox'));?></div>
                        <label class="errore_msg fl clr">
                        <span class="red"><?php if($errors){echo (array_key_exists('title',$errors))? ucfirst($errors['title']):"";}?></span>
                        </label>
                        </div>
                </div>
        </div>    
        <!--Testimonials Description-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('description_label');?><span class="red">*</span>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out textarea_out fl">
                        <?php echo Form::textarea('description',$form_values['description'],array( 'onkeyup'=>"return limitlength(this, 256)", 'maxlength'=>'256','class'=>'textarea','cols'=>'28', 'rows' => '8'));?>
                        </div>
                <label class="errore_msg fl clr"><span class="red">
                <?php if($errors){echo (array_key_exists('description',$errors))? ucfirst($errors['description']):"";}?></span>
                <span class="info_label" id="info_label" ></span><br><span class="info_label" id="info_label" ><?php echo __('max_label');?>: 500 </span>
                </label>
                </div>
        </div>
		
        <!--Testimonials Image-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('image_label');?><span class="red"></span>:</p></div>
                <div class="colm2_width fl">
                        <div class="fl">
                        <input name="photo" type="file"/>
                        </div>
                <label class="errore_msg fl clr"><span class="red">
                <?php if($errors){echo (array_key_exists('photo',$errors))? ucfirst($errors['photo']):"";}?></span>
                <span></span>
                </label>
                </div>
        </div>
        <div  style="margin:10px 0 0 275px; color:#5D5D5D; float:left;">
        <?php echo __('Or');?>
        </div>
                
        <!--Testimonials Video-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><p><?php echo __('video_label');?>:</p></div>
                <div class="colm2_width fl">
                        <div class="inputbox_out fl">
                        <?php echo Form::input('video',$form_values['video'],array('class'=>'textbox'));?>
                        </div>
                <label class="errore_msg fl clr"><span class="red" style="float:left; width:400px;">
                <?php if($errors){echo (array_key_exists('video',$errors))? ucfirst($errors['video']):"";}?><?php if($video_error){ echo $video_error; } ?></span>
                <span style="color:#5D5D5D"><?php echo __('youtube_label');?>  </span>
                </label>
                </div>
        </div>
		
        <!--Submit button-->
        <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="colm2_width fl">
                        <div class="login_submit_btn fl">
                        <span class="login_submit_btn_left fl">&nbsp;</span>
                        <span class="login_submit_btn_middle fl">
                        <?php echo Form::submit('testimonials',__('button_add'),array('title' =>__("add_testimonial")));?>
                        </span>
                        <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                        </div>
                </div>
        </div>
	<?php echo Form::close();?>
</div> 
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
</div>
         </div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
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
