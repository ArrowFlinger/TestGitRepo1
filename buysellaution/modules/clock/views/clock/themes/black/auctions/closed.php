<?php 
foreach($productsresult as $product_result):	
?>
		<div class="auction_item_content clock clock_product_container">
			<h3>
            	<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" >
					<?php echo strlen($product_result['product_name'])>20?substr(ucfirst($product_result['product_name']),0,16)."...":ucfirst($product_result['product_name']);?>
                </a>
            </h3>
			<!--product image-->
			<div class="action_item_img fl"> 
                    <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" class="fl" title="<?php echo $product_result['product_name'];?>">
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
                        <div class="pop_top_bg">
			 <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons"></span><?php } ?>
			 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon" style="border:1px solid red;float:right "></span><?php } ?>
			 <?php if($product_result['product_featured']==HOT){?><span class="hot_icon"></span><?php } ?>
			 <span class="penny"></span>
                        </div>
	                <img src="<?php echo $product_img_path;?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>" /><?php if($product_result['product_process']==CLOSED && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image"/><?php } ?>
                    </a>
                    
                      <div class="action_item_detail fl clr">
                          
                          
					<p class="fl clr"><span><?php echo __('retail_price_label')." :</span> ".$site_currency." ".$product_result['product_cost'];?></p>
                	
                </div>
                </div>
            <a class="more_info_link fl" href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="more information"></a>
			<div class="action_item_detail fl clr">
				<p class="fl clr"><span style="display:block;"><?php echo __('retail_price_label')." : </span> ".$site_currency." ".$product_result['product_cost'];?></p>
			</div>
           
                  <div id="auction_element_<?php echo $product_result['product_id'];?>">
                  <div class="bidme_link_out fl clr">
                        <center>
                        <?php if($product_result['product_process']==CLOSED && $product_result['lastbidder_userid']!=0){?><div class="sold_link clr">
                        
                        <span class="soon_left fl">&nbsp;</span>
                        <span class="soon_middle fl">
                        
                            <a title="<?php echo __('sold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>" class="future fl">
                               <?php echo __('sold');?>
                            </a>
                        </span>
                        <span class="soon_left soon_right fl">&nbsp;</span>
                        </div><?php }  ?>
                        </center>
                    </div>
                  
                  <div class="action_price fl clr"><p class="fl">
                    <!--<span style="display:block;"><?php echo __('auction_price_label');?>:</span>--> <?php echo  $site_currency." ".Commonfunction::numberformat($product_result['current_price']);?></p>
                  </div>
                  
                  <div class="action_bidder_name fl clr">
                     <div class="auction_bit_left">
                         <span class="high" style="display:block;"><?php echo __('highest_bidder_label');?>: </span>
                         <span class="lastbidder" style=" font: normal 12px arial; color:#999;"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):"";?></span>
                     </div>
                    <div class="aution_bit_right">
                        <b>Bid</b>
                        <p>  <?php echo $site_currency." ".$product_result['bidamount'];?></p>
                        
                    </div>
		</div>
					<div id="countdown_<?php echo $product_result['product_id'];?>"  class="countdown fl clr"><?php echo __("closed_text");?></div>
                    <div class="action_item_detail fl clr">
                    <p class="fl clr"><span style="display:block;"><?php echo __('price_paid_user');?>:</span>
                            <?php $user_spents=$auction->winner_user_amount_spent($product_result['product_id'],$product_result['lastbidder_userid']);
                        $amount=0;
                        foreach($user_spents as $user_spent)
                        {
                            $amount += $user_spent['price'];
                        }
                        echo "<b>".$site_currency." ".Commonfunction::numberformat($amount)."</b>";
                        ?></p>
                    </div>
                  <div class="action_item_detail fl clr pb10">
                    <p class="fl clr"><b><?php echo __("ended_on_label");?>:</b> <?php echo $status=$auction->date_to_string($product_result['enddate']);?></p>
                  </div>
                 </div>
                 <div class="watch_list fl clr">
               
                    

            <span class="read_more_onn"><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>">More Info</a></span>
        <!--<a href="" title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist">
		      +  <?php echo __('add_to_watchlist');?>
        </a>-->
    
                 
                 </div>
              	</div>
<?php endforeach;?>
