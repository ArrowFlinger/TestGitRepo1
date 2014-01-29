<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right" id="watchlist_page">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('my_watchlist'));?>"><?php echo strtoupper(__('my_watchlist'));?></h1>
		<p>&nbsp;</p>
	</div>
	<?php if($count_user_watchlist>0){ ?>
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
				<b><?php echo __('end_time');?></b>
			</th>
			<th width="100" align="center">
				<b><?php echo __('actions');?></b>
			</th>
                    </tr>
                        </thead>
		</div>
		 <?php  foreach($watch_results as $watch_result):?>
		<tr>
		<td width="100" align="center">
			<h3><a href="<?php echo url::base();?>auctions/view/<?php echo $watch_result['product_url'];?>" title="<?php echo ucfirst($watch_result['product_name']);?>">


			<?php if(($watch_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$watch_result['product_image']))
			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$watch_result['product_image'];
			}
			else
			{
					$product_img_path=IMGPATH.NO_IMAGE;
			}
			?>

		<img src="<?php echo $product_img_path;?>"  width="65" height="65"  alt="<?php echo ucfirst($watch_result['product_name']);?>"/></a></h3>
		</td>
                    
		<td width="100" align="center">
			<a title="<?php echo ucfirst($watch_result['product_name']);?>" href="<?php echo URL_BASE;?>auctions/view/<?php echo $watch_result['product_url'];?>"><?php echo ucfirst($watch_result['product_name']);?></a>
		</td>
		<td width="100" align="center">
			<?php echo $watch_result['enddate'];?>
		</td>
		<td width="100" align="center">
		   <a href="<?php echo url::base();?>users/watchlist/<?php echo $watch_result['watch_id'];?>" title="<?php echo ucfirst(__('delete'));?>"><img src="<?php echo IMGPATH;?>delet.png" onclick=" return confirmDelete('<?php echo __('are_you_sure_delete');?>');" alt="Delete"/></a>
		</td>
                </tr>
		<?php endforeach; 
               
		}
			else
			{?>
				<div class="message_common">
					<h4 class="no_data fl clr"><?php echo __("no_watchlist_auction_at_the_moment");?></h4> 
				</div>
				<?php 
			}?>
                    </table>
                </div>

		<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	

	</div>
	</div>
		<div class="nauction_paginations">
				<?php if($count_user_watchlist > 0): ?>
					<p><?php echo $pagination->render(); ?></p>  
				<?php endif; ?>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {$("#my_watchlist_active").addClass("act_class");});
</script>

