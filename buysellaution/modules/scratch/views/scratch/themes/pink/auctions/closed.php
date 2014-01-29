<?php defined("SYSPATH") or die("No direct script access."); ?>

	<?php 
        foreach($productsresult as $product_result):?>
                <div class="auction_item_content" name="<?php echo URL_BASE;?>auctions/process">
                <div class="deal-top_f">
               
                </div>
        <div class="deal-mid clearfix">
                <h3>
                        <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" >
	                        <?php echo strlen($product_result['product_name'])>20?substr(ucfirst($product_result['product_name']),0,20)."...":ucfirst($product_result['product_name']);?>
                        </a>
                </h3>
			<!--product image-->
		<div class="action_item_img fl">
                        <div class="pop_top_bg">
       <span class="scratch_icon"></span>
                        </div>
                <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="fl">
			<?php 
				if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_result['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
				}
			?>
	         <img src="<?php echo $product_img_path;?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>" /><?php if($product_result['product_process']==CLOSED && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image"/><?php } ?>
                </a>
                <div class="action_item_detail fl clr">
				<p class="fl clr"><span style="float:left"><?php echo __('retail_price_label')." :</span> ".$site_currency." ".Commonfunction::numberformat($product_result['product_cost']);?></p>
                	<p class="fl clr mt5"><span class="fl"><?php echo __("time_countdown_label")." :"?></span>  <span style="display:block;"><?php echo $product_result['bidding_countdown'];?> secs</span>
</p>

			</div>
            </div><a class="more_info_link fl" href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="more information"></a>
			
			
                  <div id="auction_element_<?php echo $product_result['product_id'];?>">
                  <div id="countdown_<?php echo $product_result['product_id'];?>"  class="countdown fl clr"><?php echo __("closed_text");?></div>
                  <div class="action_price fl clr"><p>
                    <span style="display:block;"><?php echo __('auction_price_label');?>:</span> <?php echo  $site_currency." ".Commonfunction::numberformat($product_result['current_price']);?></p>
                  </div>
                  <div class="action_bidder_name fl clr">
                      <p><b><?php echo __('see_myprice_label');?></b> <?php echo $product_result['bids']; ?></p>
                        <p><b><?php echo __('reduction_fee_label');?> </b><?php echo $site_currency." ".$product_result['bidamount'];?></p>
                        <p><b><?php echo __('time_to_label');?></b> <?php echo $product_result['timetobuy']." ".__('second_label');?></p>
                      
			
                  </div>
			<div class="bidme_link_out fl clr">
                        <center>
                                <?php if($product_result['product_process']==CLOSED && $product_result['lastbidder_userid']!=0){?>
                                <div class="sold_link clr">
                                        <span class="soon_left fl">&nbsp;</span>
                                        <span class="soon_middle fl">
                                                <a title="<?php echo __('sold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>" class="future fl">
                                                <?php echo __('sold');?>
                                                </a>
                                        </span>
                                        <span class="soon_left soon_right fl">&nbsp;</span>
                                </div>
                                <?php } else {?>
                                <div class="sold_link clr">
                                        <span class="soon_left fl">&nbsp;</span>
                                        <span class="soon_middle fl">
                                                <a title="<?php echo __('un_sold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>" class="future fl">
                                                <?php echo __('un_sold');?>
                                                </a>
                                        </span>
                                        <span class="soon_left soon_right fl">&nbsp;</span>
                                </div>
                                <?php } ?>
                        </center>
                    </div>
                    <div class="action_item_detail fl clr">
                    <p class="fl clr"><span style="display:block;"><?php echo __('price_paid_user');?>:</span>
                            <?php 
				if($product_result['lastbidder_userid']==0)
				{
				echo "<b>".$site_currency." "."0"."</b>";
				}
				else
				{
				echo "<b>".$site_currency." ".Commonfunction::numberformat($product_result['current_price'])."</b>";
				}
				?></p>
                    </div>
                  <div class="action_item_detail fl clr pb10">
                    <p class="fl clr"><b><?php echo __("ended_on_label");?>:</b> <?php echo $status=$auction->date_to_string($product_result['enddate']);?></p>
                  </div>
                 </div>
                 </div>
                  <div class="watch_list fl clr">
            <span class="read_more" style="margin-top:10px;">   <a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="more information"><?php echo __('more_info');?></a></span>
                        
                </div>
              	</div>
         
	<?php endforeach;?>

