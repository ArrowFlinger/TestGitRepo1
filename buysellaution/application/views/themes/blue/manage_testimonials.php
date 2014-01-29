<?php defined("SYSPATH") or die("No direct script access."); ?>
<style type="text/css">
.watch_list_items .table-block tr{ float:left; position:relative;}
</style>
<div class="content_left_out content_left_out1 fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('my_testimonials');?>"><?php echo __('my_testimonials');?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
        <div class="action_deal_list  action_deal_list2 clearfix">
<div class="watch_list_items fl clr">
<div id="managetable" class="fl clr">
	<?php if($count_mytestimonials_auctions>0)
	{ ?>
	<!--List products-->
	<div class="table-left">
        <div class="table-right">
        <div class="table-mid">		
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top table-top1">
                <tr>
                        <th style="width:120px;" align="left" ><?php echo __('image');?></th>
                        <th style="width:120px;" align="center" style="padding:0 0 0 15px;"><b><?php echo __('title');?></b></th>
                        <th style="width:120px;" align="center"><b><?php echo __('description_lable');?></b></th>
                        <th style="width:120px;" align="center"><b><?php echo __('status_lable');?></b></th>
                        <th style="width:120px;" align="center"><b><?php echo __('actions');?></b></th>
                        <th style="width:120px;" align="center" width="53"><b class="delete"><?php echo __('delete_lable');?></b></th>		
                </tr>
        </table>
        </div>
        </div>
        </div>
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0" class="table-block">
        <?php 
		$count=$count_mytestimonials_auctions;
		$i=0;
		foreach($mytestimonials_results as $mytestimonials_results):
		$bg_none=($i==$count-1)?"bg_none":"";?>
		<tr>
                        <td align="center" style="width:100px;padding:5px 0px;" class="<?php echo $bg_none;?>">
                        <?php if ($mytestimonials_results['images'])
                        {?>
                        <?php 
		                        if(($mytestimonials_results['images'])!="" && file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$mytestimonials_results['images']))
		                        { 
			                        $testimonials_img_path=URL_BASE.TESTIMONIALS_IMGPATH.$mytestimonials_results['images'];
		                        }
		                        else
		                        {
			                        $testimonials_img_path=IMGPATH.NO_IMAGE;
		                        }
	                        ?>
                                <img src="<?php echo $testimonials_img_path;?>" width="100" height="100" title="<?php echo ucfirst($mytestimonials_results['title']);?>"/>
                        <?php 
                        } 
                        else
                        {  
                                if($mytestimonials_results['thumb_url']) 
                                {?>
                                <a href="javascript:;" onclick="showhide('<?php echo $mytestimonials_results['testimonials_id']; ?>')" >
                                <img src="<?php echo $mytestimonials_results['thumb_url'];?>" width="100" height="100" title="<?php echo ucfirst($mytestimonials_results['title']);?>"/>
                                <div class="thumb_video_list fl"></div></a>
                                <div class="video<?php echo $mytestimonials_results['testimonials_id']; ?> videos" onmouseover="show('<?php echo $mytestimonials_results['testimonials_id']; ?>')"  style="display:none;position:absolute;width:450px;padding:10px; background:#FFF;border:#ccc 1px solid;z-index:999;-moz-box-shadow:5px 5px 10px #333;-webkit-box-shadow:5px 5px 10px #333;box-shadow:5px 5px 10px #333;"><a href="javascript:;" onclick="hide('<?php echo $mytestimonials_results['testimonials_id']; ?>');" class="close<?php echo $mytestimonials_results['testimonials_id']; ?> fr clr"><?php echo __('close_video');?></a><br clear="right"/><?php echo $mytestimonials_results['embed_code']; ?></div>
                                <?php
                                } 
                        }
                        if($mytestimonials_results['images']=="" && $mytestimonials_results['thumb_url']=="")
                        {
                        ?>
                                <img src="<?php echo IMGPATH.NO_IMAGE; ?>" width="100" height="100" title="<?php echo ucfirst($mytestimonials_results['title']);?>"/>
                        <?php
                        }?>
                        </td>
                        <td align="center" style="width:120px;padding:5px 0px;" class="<?php echo $bg_none;?>"><p class="watch_list_time fl"><?php echo ucfirst($mytestimonials_results['title']);?></p></td>
                        <td align="center" style="width:120px;padding:5px 0px;" class="<?php echo $bg_none;?>"><p class="watch_list_time fl"><?php echo Text::limit_chars(ucfirst($mytestimonials_results['description']),25);?></p></td>
                        <td align="center" width="120" style="width:100px;padding:5px 0px;" class="<?php echo $bg_none;?>"><p class="watch_list_time">
                        <?php echo ($mytestimonials_results['testimonials_status'] == 'A')?'Active':'Inactive'; ?></p></td>
                        <td align="center" style="width:120px;padding:5px 0px;"><p class="watch_list_time"><a href="<?php echo URL_BASE;?>users/edit_testimonials/<?php echo $mytestimonials_results['testimonials_id'];?>" title="<?php echo __('Edit');?>" class="delet_link fr"><?php echo __('Edit');?></a></p></td>
                        <td style="width:120px;padding:5px 0px;" align="center">
                        <a href="<?php echo URL_BASE;?>users/testimonials_delete/<?php echo $mytestimonials_results['testimonials_id'];?>" onclick=" return confirmDelete('<?php echo __('are_you_sure_delete');?>');" title="<?php echo __('button_delete');?>" class="remove_link fl"><?php echo __('button_delete');?></a>
                        </td>
		</tr>
		<?php $i++;endforeach; ?>
	</table>
        <?php }
        else
        {
        ?>
        <h4 class="no_data fl clr"><?php echo __("no_testmonials_at_the_moment");?></h4> 
        <?php 
        }?>
        </div>
                <div class="clear"></div>
                <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
        </div>
                <div class="testimonial_submit_btn fl clr mt10 ml10 pb10">
                <span class="login_submit_btn_left fl">&nbsp;</span>
                <span class="login_submit_btn_middle fl">
                        <input type="button" value="<?php echo __('add_your_testimonials'); ?>" onclick="location.href='<?php echo URL_BASE;?>users/testimonials'" />
                </span>
                <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
        <!--Pagination-->
        <div class="pagination">
                <?php if($count_mytestimonials_auctions > 0): ?>
                <p><?php echo $pagination->render(); ?></p>  
                <?php endif; ?>
        </div>
        <!--End of Pagination-->
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
</script>
<script type="text/javascript">
        function showhide(id)
        {
                $(".video"+id).toggle();
                return false;
        }
        function show(id)
        {
                $(".video"+id).show();
        }
        function hide(id)
        {
                $(".video"+id).hide();
        }
</script>
