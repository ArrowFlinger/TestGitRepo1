<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="content_left fl">
	<div class="title_temp1 fl clr">
    	<h2 class="fl" title="<?php echo __('menu_closed');?>"><?php echo __('menu_closed');?></h2>
    </div>
    <div class="action_deal_list fl clr seat_bid_content_outer">
        <div class="bidding_type">
        <div class="bidding_type_lft"></div>
        <div class="bidding_type_mid">
          <div class="bidding_inner"><span><?php echo __('bidding_type_label');?>:</span>
              <ul class="clearfix">
              <li><a title="<?php echo __('beginner_label');?>" class="beginner_icon"><?php echo __('beginner_label');?></a></li>
              <li><a title="<?php echo __('penny_label');?>" class="penny_auction_icon"><?php echo __('penny_label');?></a></li>
              <li><a title="<?php echo __('peak_label');?>" class="peak_auction"><?php echo __('peak_label');?></a></li>            
              <li><a title="<?php echo __('bonus_label');?>" class="bonus_auction_icon"><?php echo __('bonus_label');?></a></li>
              <li><a title="<?php echo __('hot_label');?>" class="hot_icon1"><?php echo __('hot_label');?></a></li>  
            </ul>
          </div>
        </div>
        <div class="bidding_type_rft"></div>
    </div>
    <?php 
    	foreach($products as $product)
    	{
			if(array_key_exists($product['auction_type'], $auction_types)){
				$typename = $auction_types[$product['auction_type']];
				$block = $typename::product_block($product['product_id'],2);	
				//$content.=$block;
				echo $block;
			}
		}
		?>    	
    
		<?php if(count($products)<=0):?>
		<h4 class="no_data fl clr"><?php echo __("no_closed_auction_at_the_moment");?></h4>
		<?php endif;?>
		<div class="user" style="display:none;" ><?php echo $user;?></div>
		<div class="pagination"> 				
		<?php if(count($products)>0): ?>				
		<p class="fl"><?php echo $pagination->render(); ?></p>  
		<?php endif; ?>
	</div></div>
 
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#closed_menu").addClass("fl active");});
</script>
