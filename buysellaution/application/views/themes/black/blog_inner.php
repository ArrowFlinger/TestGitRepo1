<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="container_inner fl clr">
<div class="title_temp2 fl clr">
    <h2 class="fl clr" title="<?php echo __('view_blog');?>"><?php echo __('view_blog');?></h2>
</div>
        <div id="managetable" class="blog_content_list fl clr">
            <ul class="fl">
                <li class="fl clr mt20">
                    <div class="blog_content fl">
                        <b class="blog_title fl clr"><?php echo ucfirst($get_blog_auctions['blog_title']);?></b>
                        <div class="blog_content fl clr">
                            <label class="fr blog_post_time mr10 mt5">
                                <?php echo "Posted on ".date('F d Y',strtotime($get_blog_auctions['created_date']))." Admin";?>
                            </label>
                        </div>
                        <div class="blog_content fl clr">
                            <?php echo ucfirst($get_blog_auctions['blog_description']);?>
                        </div>
                    </div>
                </li>
            </ul>
    
	
	<?php $count=$get_blog_auctions['comments_count']; ?>
	        <?php 
		if($get_blog_comments){ 
		?>
    	<div class="blog_reply_list fl clr mt15 ml10">    
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
                            <div class="blog_reply_content_left fl">
                                <img src="<?php echo $product_img_path;?>" class="fl" title="<?php echo ucfirst($get_blog_comments['username_blog']);?>" alt="<?php echo $get_blog_comments['username_blog'];?>"/>
                            </div>
                            <div class="blog_reply_content_right fr">
                                    <p class="fl clr"><?php echo ucfirst($get_blog_comments['comment']);?></p>
                                    
                                    <span class="fl clr mt5 "><a href="<?php echo $get_blog_comments['website'];?>" class="website_url" title="<?php echo $get_blog_comments['website'];?>" target="_blank"><?php echo $get_blog_comments['website'];?></a></span>
                            </div>
                     	</div>       
                    </li>
                </ul>
            </div>	    
            <?php endforeach; 
            } 
            ?>
		</div>
                
	<!-- comment section-->
	<div class="blog_reply_list fl clr mt15 ml10 pb10">    
        <b class="blog_sub_title_reply fl clr" title="<?php echo __('leave_a_reply');?>">
	        <?php echo __('leave_a_reply');?>
        </b>
        <?php echo Form::open(NULL,array('method'=>'post','enctype' => 'multipart/form-data'));?>
        <table  class="fl clr pb10">
                <tr>
                <td>
                <input type="hidden" value="<?php echo $get_blog_auctions['blog_id']; ?>"  name="blog_id" />
                <?php echo Form::hidden('blog_id', $get_blog_auctions['blog_id']);?>
                </td>
                </tr>

                <tr>
                <td>
                <!--firstname-->
                <div class="row_colm1 fl clr mt20">
                <?php $label=isset($auction_userid)?__('username_label'):__('name_label'); ?>
                <div class="colm1_width fl"><b><span class="red">*</span> <?php echo $label;?> :</b></div>
                <div class="colm2_width fl">
                <div class="inputbox_out fl">
                <?php if(isset($auction_userid)):?>
                <?php echo Form::input('username', $auction_username,array("id"=>"username","Maxlength"=>"30","readonly"=>"readonly","style"=>"height:19px;")) ?>
                <?php endif; ?>               

                <?php if(!isset($auction_userid)):?><?php echo Form::input('username', $form_values['username'],array("id"=>"username","Maxlength"=>"30")) ?>               <?php endif; ?>
                </div>
                <?php if(isset($errors['username'])){?>
                <label class="errore_msg fl">
                <span class="red"><?php echo isset($errors["username"])?ucfirst($errors["username"]):"";?></span>
                </label>  <?php } ?>
                </div>  
                </div>
                </td>
                </tr>
                
                <tr>
                <td>
                <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><b><span class="red">*</span> <?php echo __('email_label');?> :</b></div>
                <div class="colm2_width fl">
                <div class="inputbox_out fl">
                <?php if(isset($auction_userid)):?>
                <?php echo Form::input('useremail',isset($auction_userid)?$auction_email:$validate['useremail'],array("id"=>"useremail","Maxlength"=>"50","readonly"=>"readonly","style"=>"height:19px;")) ?>
                <?php endif;?>               

                <?php if(!isset($auction_userid)):?><?php echo Form::input('useremail', $validate['useremail'],array("id"=>"useremail","Maxlength"=>"30")) ?>
                <?php endif;?>
                </div>
                <?php if(isset($errors['useremail'])){?>
                <label class="errore_msg fl">
                <span class="red"><?php echo isset($errors["useremail"])?ucfirst($errors["useremail"]):"";?></span>
                </label>  <?php } ?>
                </div>  
                </div>
                </td>
                </tr>
                
                <tr>
                <td>
                <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><b><?php echo __('website_label');?> :</b></div>
                <div class="colm2_width fl">
                <div class="inputbox_out fl">
                <?php echo Form::input('website', $validate['website'],array("id"=>"website","Maxlength"=>"64")) ?>
                </div>
                <?php if(isset($errors['website'])){?>
                <label class="errore_msg fl">
                <span class="red"><?php echo isset($errors["website"])?ucfirst($errors["website"]):"";?></span>
                </label>    <?php } ?>
                </div>
                </div>
                </td>
                </tr>
                
                <tr>
                <td>
                <div class="row_colm1 fl clr mt20">
                <div class="colm1_width fl"><b><span class="red">*</span> <?php echo __('comment_label');?> :</b></div>
                <div class="colm2_width fl">
                <div class="inputbox_out fl">
                <?php echo Form::textarea('comment',trim($form_values['comment']),array("id"=>"comment","maxlength"=>"510",'style'=>'resize:none;',"onkeyup"=>"return limitlength(this, 510);")) ?>
                </div>
                <?php if(isset($errors['comment'])){?>
                <label class="errore_msg fl">
                <span class="red"><?php echo isset($errors['comment'])?ucfirst($errors["comment"]):"";?></span> </label>   <?php } ?>
                <br clear="both"/>
                <div class="info_label" id="info_label"></div>
                <div class="info_label" id="info_label"><?php echo __('max_label');?>:510</div> 
                </div>
                </div>
                </td>
                </tr>


                <tr>
                <td>
                <div class="row_colm1 fl clr  mt20">
                <div class="colm1_width fl"><b class="fl">&nbsp;</b></div>
                <div class="colm2_width fl">
                <div class="login_submit_btn fl">
                <span class="login_submit_btn_left fl">&nbsp;</span>
                <span class="login_submit_btn_middle fl">
                <?php echo Form::submit('blog_comment',__('button_submit'),array('title' =>__('button_submit')));?>
                </span>
                <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
                </div>	    
                </div>
                </td>
                </tr>
        </table>
        <?php echo Form::close();?>
    </div>
        </div>
</div>
<script language="javascript" type="text/javascript">

	function limitlength(obj, maxlength){
		//var maxlength=length
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
