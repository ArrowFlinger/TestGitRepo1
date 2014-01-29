<?php defined("SYSPATH") or die("No direct script access."); ?>

<?php 
foreach($productsresult as $product_result):?>
		<div class="auction_item_content reserve">
          <div class="deal-top_f"> </div>
               
                <div class="deal-mid clearfix">
			<h3>
            	<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" >
					<?php echo strlen($product_result['product_name'])>20?substr(ucfirst($product_result['product_name']),0,22)."...":ucfirst($product_result['product_name']);?>
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
			 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
				<?php if($product_result['product_featured']==HOT){?><span class="hot_icon"></span><?php } ?>
			<!-- <span class="penny"></span> -->
                        <span class="reserve_bid_icon"></span>
                          </div>
	                <img src="<?php echo $product_img_path;?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>"/>
                    </a>
                        <div class="action_item_detail fl clr">
                          <p class="fl clr"><span style="float:left;"><?php echo __('retail_price_label')." :</span> ".$site_currency." ".$product_result['product_cost'];?></p>
                	
                               
</p>
                </div>
                    
                    
                </div>
            <div class="price-block fl">
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
                        </div><?php } else {?>
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
           
             </div>
                  <div id="auction_element_<?php echo $product_result['product_id'];?>">
                 
                  <div class="action_price fl clr"><p class="fl"><?php echo  $site_currency." ".Commonfunction::numberformat($product_result['current_price']);?></p>
                  </div>
                  
                   <div class="action_bidder_name fl clr">
                     
                   
		</div>
                      <div id="countdown_<?php echo $product_result['product_id'];?>"  class="countdown fl clr"><?php echo __("closed_text");?></div>

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
            	 <span class="read_more">            
                     <a  href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="more information">Read more</a>
</span>
               
               
            </div>
                                             
                 
              	</div>
<?php endforeach;?>
	
