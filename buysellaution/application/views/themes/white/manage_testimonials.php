<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right" id="manage_testimonials_page">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('my_testimonials'));?>"><?php echo strtoupper(__('my_testimonials'));?></h1>
		<p>&nbsp;</p>
	</div>
	<?php if($count_mytestimonials_auctions>0)
	 { ?>
	<div class="message_common">
		<div class="forms_common">
		<div class="title_cont_watchilist">
                      <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                          <thead>
                              <tr>
				<th width="100" align="center">
					<b><?php echo __('image');?></b>
				</th>
				<th width="100" align="center">
					<b><?php echo __('title');?></b>
			</th>
			<th width="100" align="center">
					<b><?php echo __('description_lable');?></b>
				</th>
				<th width="100" align="center">
					<b><?php echo __('status_lable');?></b>
				</th>
				<th width="100" align="center">
					<b><?php echo __('action_lable');?></b>
				</th>
                      </tr>
	</thead>
		<?php 
					$count=$count_mytestimonials_auctions;
					$i=0;
					foreach($mytestimonials_results as $mytestimonials_results):
					$bg_none=($i==$count-1)?"bg_none":"";?>
			
			
			<tr>
                            <td width="100" align="center">
				<h3><?php if ($mytestimonials_results['images'])
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
						<a><img src="<?php echo $testimonials_img_path;?>" width="100" height="100" title="<?php echo ucfirst($mytestimonials_results['title']);?>"/></a>
						<?php 
						} 
						else
						{
							if($mytestimonials_results['thumb_url']) 
								{?>
									<a href="javascript:;" onclick="showhide('<?php echo $mytestimonials_results['testimonials_id']; ?>')" >
									<img src="<?php echo $mytestimonials_results['thumb_url'];?>" width="82" height="83" title="<?php echo ucfirst($mytestimonials_results['title']);?>"/>
									<div class="" style=""></div></a>
									<div class="video<?php echo $mytestimonials_results['testimonials_id']; ?> videos" onmouseover="show('<?php echo $mytestimonials_results['testimonials_id']; ?>')"  style="display:none;position:absolute;width:450px;padding:10px; background:#FFF;border:#ccc 1px solid;z-index:999;-moz-box-shadow:5px 5px 10px #333;-webkit-box-shadow:5px 5px 10px #333;box-shadow:5px 5px 10px #333;"><a href="javascript:;" onclick="hide('<?php echo $mytestimonials_results['testimonials_id']; ?>');" class="close<?php echo $mytestimonials_results['testimonials_id']; ?> fr clr"><?php echo __('close_video');?></a><br clear="right"/><?php echo $mytestimonials_results['embed_code']; ?></div>
								<?php
								} 
						}
							if($mytestimonials_results['images']=="" && $mytestimonials_results['thumb_url']=="")
							{?>
									<img src="<?php echo IMGPATH.NO_IMAGE; ?>" width="100" height="100" title="<?php echo ucfirst($mytestimonials_results['title']);?>"/>
							<?php
							}?>

				</h3>
                            </td>
		   
			
			
			<td width="100" align="center">
				<a  title="<?php echo ucfirst($mytestimonials_results['title']);?>" ><?php echo ucfirst($mytestimonials_results['title']);?></a>
			</td>
			
			<td width="100" align="center">
				<h2><?php echo strip_tags(Text::limit_chars(ucfirst($mytestimonials_results['description']),20));?></h2>
			</td>
			
			<td width="100" align="center">
				<h2>
					<span><?php echo ($mytestimonials_results['testimonials_status'] == 'A')?'Active':'Inactive'; ?></span>
				</h2>
			   </td>
			<td width="100" align="center">
				<h2>
					<a href="<?php echo URL_BASE;?>users/edit_testimonials/<?php echo $mytestimonials_results['testimonials_id'];?>" title="<?php echo __('Edit');?>"><img src="<?php echo IMGPATH; ?>edit.png" alt="Edit"/></a>
					<a  href="<?php echo URL_BASE;?>users/testimonials_delete/<?php echo $mytestimonials_results['testimonials_id'];?>" title="<?php echo __('button_delete');?>"><img src="<?php echo IMGPATH; ?>delet.png" alt="Delete"/></a>
				</h2>
			</td>


		<?php $i++;endforeach; ?>
			
		<?php }
			else
			{
			?><div class="message_common">
			<h4 class=""><?php echo __("no_testmonials_at_the_moment");?></h4>
			</div> 
			
			<?php 
			}?>
                </tr>
                </table>
			
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>		
	 
	<span>
		<div class="buton_green">
			<div class="profil_butoon">
				<div class="res_left"></div>
					<div class="res_mid"><a title="<?php echo __('add_your_testimonials'); ?>"><input type="button" name="submit_user" value="<?php echo __('add_your_testimonials'); ?>" onclick="location.href='<?php echo URL_BASE;?>users/testimonials'" /></a>
				</div>
			<div class="res_right"></div>
		</div>
	</span>
	</div>	
	</div>	
	
	<?php if($count_mytestimonials_auctions > 0): ?>
	<div class="nauction_pagination">
			<p><?php echo $pagination->render(); ?></p>
			</div>
		  <?php endif;?>  
		
	
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

<script type="text/javascript">
$(document).ready(function () {$("#my_testimonials_active").addClass("act_class");});
</script>
