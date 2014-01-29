<?php defined("SYSPATH") or die("No direct script access.");?>
<script type="text/javascript">
$(document).ready(function(){		
		 Auction.getauctionstatus(8,"","",{'search':'<?php echo $category;?>'});
});
</script>

<div class="banner_rgt">
        <div class="today_headss">
                            <h2 title="<?php echo ($category!='')?(__('category_selected').' : '.$category):__('ALL_CATEGORIES');?>">
			    
			    
			    <?php echo ($category!='')?(__('category_selected').' : '.$category):__('ALL_CATEGORIES');?></h2>
                            <span class="arrow_one_fet"> &nbsp;</span>
                            
                        </div>
                        <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
        <div class="feature_total">
	
		<?php
		      
		if(count($products)>0){      
		foreach($products as $product)
		{
		if(array_key_exists($product['auction_type'], $auction_types)){
		$typename = $auction_types[$product['auction_type']];
		$block = $typename::product_block($product['product_id'],7,array('category_id'=>$category_id));	
		//$content.=$block;
		echo $block;
		}
		}
		}
		?>     
		
		
		
		
		
		
		
         <div class="user" style="display:none;" ><?php echo $user;?></div>
		<div class="clear"></div>
		
		<?php if(count($products)<=0){?>
		<div class="message_common">
			<h4 class=""><?php echo __("no_auctions_found_in_this_category");?></h4>
		</div>
		<?php }?>
		<?php if(count($products)>0){?>
		<div class="nauction_pagination">
			<?php echo $pagination->render(); ?>
		</div>
		<?php }?>
	
</div>
</div>
</div>
</div>
</div>
</div>

