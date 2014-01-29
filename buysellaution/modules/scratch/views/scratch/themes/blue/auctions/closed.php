<?php 
foreach($productsresult as $product_result):?>
		<div class="auction_item_content" name="<?php echo URL_BASE;?>auctions/process">
         <div class="deal-top_f"> </div>
                <div class="deal-left1 clearfix">
                  <div class="deal-right clearfix">
                <div class="deal-mid clearfix">
                <div class="image-block fl">
			<h3>
            	<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" >
					<?php echo strlen($product_result['product_name'])>20?substr(ucfirst($product_result['product_name']),0,30)."...":ucfirst($product_result['product_name']);?>
                </a>
            </h3>
			<!--product image-->
			<div class="action_item_img">
            <div class="pop_top_bg">
      <span class="scratch_icon"></span>
                        </div>
                <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="">
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
                <div class="action_item_detail  clr" style="text-align:left;">
				<p><?php echo __('retail_price_label')." : ".$site_currency." ".$product_result['product_cost'];?></p>
			</div>
            </div>
            
                        <div class="bidme_link_out  clr">
                        <center>
                        <?php if($product_result['product_process']==CLOSED && $product_result['lastbidder_userid']!=0){?><div class="sold_link clr">
                        
                        <span class="soon_left soon_left1 fl">&nbsp;</span>
                        <span class="soon_middle soon_middle1 fl">
                        
                            <a title="<?php echo __('sold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>" class="future">
                               <?php echo __('sold');?>
                            </a>
                        </span>
                        <span class="soon_left soon_right soon_left1 soon_right1 fl">&nbsp;</span>
                        </div><?php } else {?>
                                <div class="sold_link clr">
                                        <span class="soon_left soon_left1 fl">&nbsp;</span>
                                        <span class="soon_middle soon_middle1 fl">
                                                <a title="<?php echo __('un_sold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>" class="future">
                                                <?php echo __('un_sold');?>
                                                </a>
                                        </span>
                                        <span class="soon_left soon_right soon_left1 soon_right1 fl">&nbsp;</span>
                                </div>
                                <?php } ?>
                        </center>
                    </div>
                          <div class="action_price"><p><?php echo  $site_currency." ".Commonfunction::numberformat($product_result['current_price']);?></p>
                  </div>
            </div>
            <div class="text-block fl clearfix">
            <div class="price-block clearfix">
		  <div class="action_bidder_name action_bidder_name_new fl clr">
                        <?php echo __('see_myprice_label');?> <?php echo $product_result['bids']; ?>
                        <?php echo __('reduction_fee_label');?> <?php echo $site_currency." ".$product_result['bidamount'];?>
                        <?php echo __('time_to_label');?><?php echo $product_result['timetobuy']." ".__('second_label');?>
                     
                </div>	
             <div id="countdown_<?php echo $product_result['product_id'];?>"  class="countdown"><?php echo __("closed_text");?></div>
             </div>
                  <div id="auction_element_<?php echo $product_result['product_id'];?>">
                 
                
                  
                
					
                    <div class="action_item_detail  clr" style="text-align:right;">
                    <p><span><?php echo __('price_paid_user');?>:</span>
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
                  <div class="action_item_detail  pb10" style="text-align:right;">
                    <p><b><?php echo __("ended_on_label");?>:</b> <?php echo $status=$auction->date_to_string($product_result['enddate']);?></p>
                  </div>
                  </div>
                 </div>
                </div>
                </div>
                </div>                 
               <div class="watch_list  clr">
            <span class="read_more" ><a style="margin-top:10px;" href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>"><?php echo __('more_info');?></a></span>



        </div>
              	</div>
<?php endforeach;?>	
