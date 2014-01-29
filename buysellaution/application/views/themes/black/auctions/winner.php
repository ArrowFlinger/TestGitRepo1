<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
    <div class="action_content_left fl pb20">
        <div class="title_temp1 fl clr">
            <h2 class="fl clr" title="<?php echo __('menu_winners_list');?>"><?php echo __('menu_winners_list');?></h2>
        </div>
        <div class="winner_list_out fl clr mt10">
		<?php
		if(count($products)>0){
		foreach($products as $product)
		{
		if(array_key_exists($product['auction_type'], $auction_types)){
		$typename = $auction_types[$product['auction_type']];
		$block = $typename::product_block($product['product_id'],10);	
		//$content.=$block;
		echo $block;
		}
		}
		}
		?>     	
		<!-- No Data START-->	
		<?php if(count($products)<=0):?>
		<h4 class="no_data fl clr"><?php echo __("no_winner_auction_at_the_moment");?></h4>
		<?php endif;?>
		<!-- No Data START-->
        </div> 
        <div class="pagination fl">
        <p><?php if(count($products)>0): ?><?php echo $pagination->render(); ?><?php endif;?></p> 
    </div>
 </div> 
    <!--Pagination START-->
    
    <!--Pagination END-->
</div>
<script type="text/javascript">
$(document).ready(function () {$("#winner_menu").addClass("fl active");});
</script>   
