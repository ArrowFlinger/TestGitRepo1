<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="action_content_left fl">
	<div class="title_temp1 fl clr pt10">
    	<h2 class="fl clr pl10" title="<?php echo __('my_bids');?>"><?php echo __('my_bids');?></h2>
    </div>    
<?php if($count_bidhistory>0):?>	
	<div class="watch_list_items fl clr">	
		<div id="managetable" class="fl clr">
		<!--List products-->
		
		<table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
		<tr>
		<th width="100" align="center"><?php echo __('image');?></th>
		<th width="100" align="center"><?php echo __('title');?></th>
		<th width="100" align="center"><?php echo __('end_time');?></th>
		<th width="100" align="center"><?php echo __('total_bids');?></th>
		<!--<th width="100" align="center"><b><?php echo __('total_amount');?></b></th>-->
		<th width="50" align="center"><?php echo __('status_label');?></th>
		
		</tr>
		<?php 
		foreach($bidhistories as $bidhistory):?>
		<tr>
		<td width="100" align="center">
            <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $bidhistory['product_url'];?>" >
		<?php if(($bidhistory['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$bidhistory['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$bidhistory['product_image'];	
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
				}
			?>
                <img src="<?php echo $product_img_path;?>" width="50" height="50" title="<?php echo ucfirst($bidhistory['product_name']);?>" align="middle"/>
           	 </a>
       		 </td>
		<td width="100" align="center"><p><?php echo Text::limit_chars(ucfirst($bidhistory['product_name']),12);?></p></td>		
		<td width="100" align="center"><p><?php echo $bidhistory['enddate'];?></p></td>
		<td width="100" align="center"><p class="watch_list_time"><?php echo  $bidhistory['count('.BID_HISTORIES.'.product_id)'];
		?></p></td>
		<!--<td align="center"><b><?php echo  $site_currency." ".Commonfunction::numberformat($bidhistory['max('.BID_HISTORIES.'.price)']);?></b></td>-->
		<td width="50" align="center">
        	 <?php echo $bidhistory['in_auction']!=2?"<a href='".URL_BASE."auctions/view/".$bidhistory['product_url']."' class='delet_link' title='".__('live_text')."'>".__('live_text')."</a>":"<p>".__('closed_text')."</p>";?>
        </td>
		
		</tr>
		<?php endforeach; 
		
		?>
		</table>
		</div>
		<div class="clear"></div>
		<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	</div>
	
<?php else:?>
	<h4 class="no_data clr" style="float:none;"><?php echo __("no_bids_detail_at_the_moment");?></h4>
<?php endif;?>
<!--Pagination-->
<div class="pagination">
 <p><?php echo $pagination->render(); ?></p>
</div>
<!--End of Pagination-->
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_bids_active").addClass("user_link_active");});
</script>
