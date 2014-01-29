<?php foreach ($productsresult as $product_result):
if($product_result['in_auction']==2){
?>

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
       <div class="highestunique"></div>
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
		  <div class="action_bidder_name fl clr">
                    <div class="auction_bit_left">
                        <span class="high" style="display:block;"><?php echo __('highest_bidder_label'); ?>: </span>
                        <span class="lastbidder"><?php echo ($product_result['lastbidder_userid'] == 0) ? __('no_bids_yet') : ""; ?></span>
                    </div>
                    <div class="aution_bit_right">
                        <b><?php echo __('bid_label')?></b>
                        <p>  <?php echo $site_currency . " " . $product_result['bidamount']; ?></p>

                    </div>
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
		
<?php } else {?>
    <!--Closed one-->

    <div id="auction_<?php echo $product_result['product_id']; ?>" class="auction_item auction_item_content" name="<?php echo URL_BASE; ?>auctions/process" data-id="<?php echo $product_result['product_id']; ?>">
        <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type']; ?>"></div>
        <div class="deal-top_f"> </div>

        <div class="deal-mid clearfix">
            <?php if ($product_result['product_featured'] == FEATURED) { ?><span class="feature_icon"></span><?php } ?>
              <h3>
                    <a href="<?php echo url::base(); ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
                        <?php echo ucfirst(Text::limit_chars($product_result['product_name'], 30)); ?>
                    </a>
                </h3> 
            <div class="image-block fl">
                <!--product title-->

              

                <!--product image-->
                <div class="action_item_img"> 
                    <a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>" class="" title="<?php echo $product_result['product_name']; ?>">
                        <?php
                        if (($product_result['product_image']) != "" && file_exists(DOCROOT . PRODUCTS_IMGPATH_THUMB . $product_result['product_image'])) {
                            $product_img_path = URL_BASE . PRODUCTS_IMGPATH_THUMB . $product_result['product_image'];
                        } else {
                            $product_img_path = IMGPATH . NO_IMAGE;
                        }
                        ?>
                        
                        <div class="pop_top_bg">

                        <?php if ($product_result['dedicated_auction'] == ENABLE) { ?><span class="bonus_icons"></span><?php } ?>
                        <?php if ($product_result['product_featured'] == HOT) { ?><span class="hot_icon"></span><?php } ?>
                            <span class="highestunique"></span>
                        </div>
                        <img src="<?php echo $product_img_path; ?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']); ?>" alt="<?php echo $product_result['product_name']; ?>"/>
                    </a>
                     <div class="action_item_detail">
                    <p><?php echo __('retail_price_label') . " : " . $site_currency . " " . $product_result['product_cost']; ?></p>
                   
                </div>
                </div>
               

            </div>
            <div class="text-block fl clearfix">

                <div class="price-block clearfix">
					<?php if($product_result['product_process'] != FUTURE){?>
                    <div class="bidme_link_out">
                        <center>
                            <div class="bidme_link width_bidme clr">
                                <span class="bidme_link_left fl">&nbsp;</span>
                                <span class="bidme_link_middle fl">
                                    <a href="javascript:;" name="<?php echo URL_BASE; ?>auctions/bid/<?php echo $product_result['product_id']; ?>" class="bid" title="<?php echo ($auction_userid == '') ? __('login_label') : __('bid_me_label'); ?>" rel="<?php echo URL_BASE; ?>users/login/" id="<?php echo $product_result['product_id']; ?>"  data-auctiontype ="<?php echo $product_result['auction_type']; ?>">
    <?php echo __("bid_me_label"); ?>
                                    </a>
                                </span>
                                <span class="bidme_link_left bidme_link_right fl">&nbsp;</span>
                            </div>
                            <!--Loader-->
                            <div class="loader<?php echo $product_result['product_id']; ?>" style="display:none;"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
                        </center>
                    </div>
                    <?php }?>
                    <!--Auctions process div-->                        	

                </div>
                <div class="action_price"><span class="currentprice"></span><span class="price" style="display:none;"></span></p></div>
                 <div class="action_bidder_name fl clr">
                    <div class="auction_bit_left">
                    <span class="high" style="display:block;"><?php echo __('highest_bidder_label');?>: </span>
                    <span class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):"";?></span>
                    </div>
                    <div class="aution_bit_right">
                        <b><?php echo __('bid_label');?></b>
                        <p>  <?php echo $site_currency." ".$product_result['bidamount'];?></p>
                        
                    </div>
		</div>
                
                <div class="user" style="display:none;" ><?php //echo $user; ?></div>


                <div class="countdown"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
                <!--End of Auctions process div-->
                <!--Share-->
                <div class="auction_share_icon mt5">
                    <a style="float:left; width:30px;"  href="http://twitter.com/share?url=<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" target="_blank" title="Twitter" ><img src="<?php echo IMGPATH . 'twitter_link_icon.png'; ?>" style="margin:2px 0px 0px 5px;"/></a>
                    <a style="float:left; width:30px;" href="https://www.facebook.com/sharer.php?u=<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" target="_blank"  title="Facebook">
                        <img src="<?php echo IMGPATH . 'fbook_icon.png'; ?>" class="pl5 pr5 " style="padding-top:2px ;" /></a>
                    <!--Like--> 
                    <!--Facebook-->


                    <fb:like style="float:left; width:auto;" href="<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" layout="button_count" width="84" send="false" ref="" style="border:none;"  ></fb:like>	<!--End of facebook-->	   
                </div>          
                <!--End of share-->

                <!-- Message flash-->
                <div class="notice_nsg fl clr" id="notice_msg<?php echo $product_result['product_id']; ?>" style="display:none;"></div> <!-- end of Message flash-->


            </div>


        </div>

        <div class="watch_list">
            <span class="read_more"><a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>"><?php echo __('more_info');?></a></span>

            <a href="" title="<?php echo __('add_to_watchlist'); ?>" rel="<?php echo $product_result['product_id']; ?>" class="addwatchlist" name="<?php echo URL_BASE; ?>auctions/addwatchlist">
                <?php echo __('add_to_watchlist'); ?>
            </a>


        </div>
    </div>    
    <?php 
}endforeach; ?>
