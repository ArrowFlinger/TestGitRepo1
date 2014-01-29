<?php defined("SYSPATH") or die("No direct script access."); ?>

<div class="dash_heads" id="blog_details_page">
        <ul>
          <li><a href="#" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
          <li><a href="#"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
          <li class="active"><a href="#" title="News"><?php echo __('blog');?></a></li>
        </ul>
      </div>
    <?php include("auctions/left.php");?> 
<div class="my_message_right" id="blog_inner_page">
<div class="message_common_border">
<h1 title="<?php echo __('view_blog');?>"><?php echo __('view_blog');?></h1>
<p>&nbsp;</p>
</div>
<div class="message_common">
     <div class="uptors"><a title="<?php echo ucfirst($get_blog_auctions['blog_title']);?>"href="#"><?php echo ucfirst($get_blog_auctions['blog_title']);?></a>
              <p><?php echo "Posted on ".date('F d Y',strtotime($get_blog_auctions['created_date']))." Admin";?></p>
            </div>
  <div class="news">
              <p><?php echo ucfirst($get_blog_auctions['blog_description']);?></p>
            </div>

 
 <?php $count=$get_blog_auctions['comments_count']; ?>
  <?php 
		if($get_blog_comments){ 
		?>
    	<div class="">    
    		<b class="blog_sub_title fl clr" title="<?php echo $count.' '.__('responses');?>"><?php echo $count.' '.__('responses');?></b>
			<?php
            foreach($get_blog_comments as $get_blog_comments):  ?>
            <div id="managetable" class="blog_reply_content fl clr">
                <ul class="fl clr">
                    <li class="fl clr  mt5">
                        <b class="blog_reply_title fl clr"><?php echo ucfirst($get_blog_comments['username_blog']). "   ".__('says');?></b>
                        <div class="blog_reply_content fl clr">
                                <label class="fr blog_post_time mr10 mt5">
                            <?php echo date('F d Y ',strtotime($get_blog_comments['created_date_blog']))."at ".date('h:i A',strtotime($get_blog_comments['created_date_blog']));?>
                            </label>
                        </div>
                        
                        <div class="blog_reply_content fl mt5">
							<?php if(($get_blog_comments['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH.$get_blog_comments['photo']))
                            { 
                            $product_img_path=URL_BASE.USER_IMGPATH.$get_blog_comments['photo'];
                            }
                            else
                            {
                            $product_img_path=IMGPATH.NO_IMAGE;
                            }
                            ?>
                            <div class="user_name_common">
                            <div class="blog_reply_content_left fl">
                                <img src="<?php echo $product_img_path;?>" class="fl" title="<?php echo ucfirst($get_blog_comments['username_blog']);?>" alt="<?php echo $get_blog_comments['username_blog'];?>"/>
                            </div>
                            <div style="float:right;">
                                    <p class=""><?php echo ucfirst($get_blog_comments['comment']);?></p>
                                    
                                    <span class=""><a href="<?php echo $get_blog_comments['website'];?>" class="website_url" title="<?php echo $get_blog_comments['website'];?>"><?php echo $get_blog_comments['website'];?></a></span>
                            </div>
                            </div>
                     	</div>       
                    </li>
                </ul>
            </div>	    
            <?php endforeach; 
            } 
            ?>
			<?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
			<input type="hidden" value="<?php echo $get_blog_auctions['blog_id']; ?>"  name="blog_id" />
			<?php echo Form::hidden('blog_id', $get_blog_auctions['blog_id']);?>
			<div class="login_middle_common_profil">
			<div class="user_name_common">
				<?php $label=isset($auction_userid)?__('username_label'):__('name_label'); ?>
			<p><?php echo $label;?><span class="red"> *</span>:</p>
			<div class="text_feeld">
			<h2><?php if(isset($auction_userid)):?>
			
			<?php echo Form::input('username', $auction_username,array("id"=>"username","Maxlength"=>"30","readonly"=>"readonly","style"=>"height:19px;")) ?>
			<?php endif; ?>               
			<?php if(!isset($auction_userid)):?><?php echo Form::input('username', $form_values['username'],array("id"=>"username","Maxlength"=>"30")) ?>
			<?php endif; ?></h2>
			<?php if(isset($errors['username'])){?>
			<label class="errore_msg fl">
			<span class="red"><?php echo isset($errors["username"])?$errors["username"]:"";?></span>
			</label>  <?php } ?>
			</div>
			</div>

			<div class="user_name_common">
			<p><?php echo __('email_label');?><span class="red"> *</span>:</p>
			<div class="text_feeld">
			<h2><?php if(isset($auction_userid)):?>
			<?php echo Form::input('useremail',isset($auction_userid)?$auction_email:$validate['useremail'],array("id"=>"useremail","Maxlength"=>"50","readonly"=>"readonly","style"=>"height:19px;")) ?>
			<?php endif;?>               

			<?php if(!isset($auction_userid)):?><?php echo Form::input('useremail', $validate['useremail'],array("id"=>"useremail","Maxlength"=>"30")) ?>
			<?php endif;?></h2>
			<?php if(isset($errors['useremail'])){?>
			<label class="errore_msg fl">
			<span class="red"><?php echo isset($errors["useremail"])?$errors["useremail"]:"";?></span>
			</label>  <?php } ?>
			</div>
			</div>

			<div class="user_name_common">
			<p><?php echo __('website_label');?> :</p>
			<div class="text_feeld">
			<h2><?php echo Form::input('website', $validate['website'],array("id"=>"website","Maxlength"=>"64")) ?></h2>
			<?php if(isset($errors['website'])){?>
			<label class="errore_msg fl">
			<span class="red"><?php echo isset($errors["website"])?$errors["website"]:"";?></span>
			</label>    <?php } ?>
			</div>
			</div>


			<div class="user_name_common">
			<p><?php echo __('comment_label');?> <span class="red">*</span>:</p>
			<div class="text_feeld">
			<h2> <?php echo Form::textarea('comment',trim($form_values['comment']),array("id"=>"comment","maxlength"=>"510","onkeyup"=>"return limitlength(this, 510);")) ?></h2>
			<?php if(isset($errors['comment'])){?>
			<label class="errore_msg fl">
			<span class="red"><?php echo isset($errors['comment'])?$errors["comment"]:"";?></span> </label>   <?php } ?>

			<h3 id="info_label"><?php echo __('max_label');?> 256 </h3>
			</div>
			</div>

		<div class="user_name_common">

		<div class=" buton_green">

		<div class="profil_butoon">
		<div class="save_left"></div>
		<div class="save_mid"><?php echo Form::submit('blog_comment',__('button_submit'),array('title' =>__('button_submit')));?></div>
		<div class="save_right"></div>
		</div>
		<?php echo Form::close();?>
		</div>
		</div>
		</div>

</div>

</div>
</div>
		<script language="javascript" type="text/javascript">

        function limitlength(obj, maxlength){
                if (obj.value.length>maxlength){
                        obj.value=obj.value.substring(0, maxlength);
                      
                        document.getElementById("info_label").innerHTML="<?php echo __('entered_max_text');?>"+maxlength;
                }else{
                        var charleft = maxlength - obj.value.length;
                        
                        document.getElementById("info_label").innerHTML= charleft+"<?php echo __('entered_char_left_text');?>";
                }     
        } 

$(document).ready(function(){
	//For Field Focus
	//===============
	field_focus('name');

}); 
</script> 
