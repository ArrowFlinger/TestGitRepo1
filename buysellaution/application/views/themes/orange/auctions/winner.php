<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fr"  style="width:690px;">
    <div class="action_content_left fl pb20"  style="width:690px;">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
             	 <h2 class="fl clr" title="<?php echo __('menu_winners_list');?>"><?php echo __('menu_winners_list');?></h2>
        </div>
        </div>
        </div>
         <div class="deal-left clearfix">
	<div class="action_deal_list clearfix" style="width:687px;">
        <div class="winner_list_out clr">
        
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
			<!-- If Condition Start-->

        <!-- If Condition END-->
            <!-- No Data START-->	
           <?php if(count($products)<=0):?>
            <h4 class="no_data fl clr"><?php echo __("no_winner_auction_at_the_moment");?></h4>
            <?php endif;?>
            <!-- No Data START-->
        </div> 
         <!--Pagination START-->
    <div class="pagination fl">
        <p>	<?php if(count($products)>0): ?><?php echo $pagination->render(); ?><?php endif;?></p> 
    </div>
    <!--Pagination END-->
        </div>
        </div>
        <div class="auction-bl" style="width:690px;">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#winner_menu").addClass("fl active");});
</script>
<!--Right Sidebar Start-->
<?php include("right.php");?>
<!---Right Side bar End--->
