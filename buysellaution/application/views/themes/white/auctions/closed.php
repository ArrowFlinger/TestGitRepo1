<?php defined("SYSPATH") or die("No direct script access."); ?>
 <div style="margin-left:4px;" class="banner_rgt">
        <div class="feature_total">      
			 <div class="today_headss">
				<h2 title="<?php echo strtoupper(__('CLOSED_AUCTIONS'));?>"><?php echo strtoupper(__('CLOSED_AUCTIONS'));?></h2>
			 <div class="arrow_one_closed"></div>         
        </div>
        <div class="feature_total">
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
			<?php  if(count($products)==0):?>
			<div class="message_common">
				<h4><?php echo __("no_closed_auction_at_the_moment");?></h4>
			</div>
		<?php endif;?>
	<div class="nauction_pagination">	
				<?php if(count($products)>0): ?>				
				<?php echo $pagination->render(); ?>
				<?php endif; ?>
	</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<!--banner end-->
<!--home add start-->
<!--home add end-->
<!--clients start-->
<!--clients end-->
		
<script type="text/javascript">
$(document).ready(function () {$("#closed_menu").addClass("fl active");});
</script>
