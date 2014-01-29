<?php defined("SYSPATH") or die("No direct script access."); ?>
 <div class="banner_rgt" id="feature_page">
    <!--feature part start-->
    <div class="today_headss">
      <h2 style="width:auto;padding:0px;" title="<?php echo strtoupper(__('menu_winners_list'));?>"><?php echo strtoupper(__('menu_winners_list'));?></h2>
      <span class="arrow_onee" style="width:612px;"> &nbsp;</span> </div>
    <div class="feature_total">
      <?php
                if(count($products)>0){
		foreach($products as $product)
		{
		if(array_key_exists($product['auction_type'], $auction_types)){
		$typename = $auction_types[$product['auction_type']];
		$block = $typename::product_block($product['product_id'],10,array('offset'=>$offset,'limit' => REC_PER_PAGE));	
		//$content.=$block;
		echo $block;
		}
		}
		}
		?>     	
			<!-- If Condition Start-->
	
            <?php if(count($products)<=0):?>
            <div class="message_common">
            <h4><?php echo __("no_winner_auction_at_the_moment");?></h4>
            </div>
            <?php endif;?>
            <?php if(count($products)>0): ?>
             <div class="nauction_paginations">
            <?php echo $pagination->render(); ?>
            </div>
           <?php endif;?> 
    </div>
  </div>
</div></div></div></div>
<script type="text/javascript">
$(document).ready(function () {$("#winner_menu").addClass("fl active");});
</script>
