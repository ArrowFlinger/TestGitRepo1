<?php defined("SYSPATH") or die("No direct script access."); ?>
<?php if($count_closed_recently >0){  ?>
	<div class="sidebar_action fl clr mt15">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h4 class="fl clr" title="<?php echo __('recently_closed_auctions');?>"><?php echo __("recently_closed_auctions");?></h4></div>
        </div>
        </div>
        <div class="deal-left clearfix">
	<div class="action_deal_list clearfix">
		<div class="sidebar_future_action fl clr">
			<?php 
			foreach($recently_results as $closed_result):?>
			<div class="future_auction fl clr">
			<div class="future_auction_left fl">
                <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $closed_result['product_url'];?>"  title="<?php echo $closed_result['product_name'];?>">
                     <?php 
				
				if(($closed_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$closed_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$closed_result['product_image'];
				}
				else
				{	
					$product_img_path=IMGPATH.NO_IMAGE;					
				}
			?>
	                <img src="<?php echo $product_img_path;?>" width="60" height="60" align="middle" title="<?php echo ucfirst($closed_result['product_name']);?>"/>
                </a>
            </div>
			<div class="future_auction_right fl ml10">
                        <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $closed_result['product_url'];?>" class="clr future_auction_name" title="<?php echo $closed_result['product_name'];?>">
                        <?php echo ucfirst($closed_result['product_name']);?>
                        </a>
                <p><?php echo ucfirst(Text::limit_chars($closed_result['product_info'],300));?></p>
		</div>
                <div class="future_end_detail fl  mt5">
                    <p class="fl clr"><span style="padding:0 0 18px;"><?php echo $status=__("ended_on_label").":</span> ".$auction->date_to_string($closed_result['enddate']);?></p>
              </div>
              <div class="future_auction_detail fl  mt5">
                    <p class="fl clr"><span style="padding:0 0 18px;"><?php echo __('auction_price_label')?>: </span> <?php echo $site_currency;?> <b><?php echo Commonfunction::numberformat($closed_result['current_price']);?></b></p>
                     </div>
            </div>
                <?php endforeach; ?>
                <div class="pagination">
                <?php if($count_closed_result_index > 0): ?>
                <p class="fl"><?php echo $pagination_recently->render(); ?></p>  
                <?php endif; ?>
                </div>
                </div>
        </div>
        </div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
	</div>
<?php }?>
