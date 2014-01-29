<?php foreach ($productsresult as $product_result): ?>
    <div id="auction_<?php echo $product_result['product_id']; ?>" class="auction_item auction_item_content future_auction_item" name="<?php echo URL_BASE; ?>auctions/process">
 <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
        <div class="deal-top_f"> </div>

        <div class="deal-mid clearfix">
            <div class="image-block fl">
                <!--product title-->
 <?php if ($product_result['product_featured'] == FEATURED) { ?><span class="feature_icon"></span><?php } ?>
                <h3>
                    <a href="<?php echo url::base(); ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
                        <?php echo ucfirst(Text::limit_chars($product_result['product_name'], 30)); ?>
                    </a>
                </h3> 

                <div class="action_item_img">
                    <a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
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
                            <div class="highestunique"></div>
                        </div>
                        <img src="<?php echo $product_img_path; ?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']); ?>" alt="<?php echo $product_result['product_name']; ?>"/>
                    </a>
                     <div class="action_item_detail">
                    <p><?php echo __('retail_price_label') . " :  " . $site_currency . " " . $product_result['product_cost']; ?></p>
                    
                </div>
                </div>
               

            </div>
            <div class="text-block fl clearfix">
                <div class="price-block clearfix" style="padding:0px;">
  <div class="bidme_link_out">
                    <center>
                     <?php	/* <div class="soon_link clr">
                            <span class="soon_left fl">&nbsp;</span>
                            <span class="soon_middle fl">
                                <a title="<?php echo __('comingsoon_text'); ?>" name="<?php echo URL_BASE; ?>auctions/bid/<?php echo $product_result['product_id']; ?>" class="future fl">
    <?php echo __('comingsoon_text'); ?>
                                </a>
                            </span>
                            <span class="soon_left soon_right fl">&nbsp;</span>
                        </div>
						*/ ?>
						<div class="countdown_future fl clr" style="text-align:center;width:100%;font-weight:bold;height:40px;line-height:40px;background-color:#F4F4F4;"><?php echo __('comingsoon_text'); ?></div>
                        <!--Loader-->
                        <div class="loader<?php echo $product_result['product_id']; ?>" style="display:none;"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
                    </center>
                </div>
                       <div class="action_price"><p><span class="currentprice"></span></p></div>
                           <div class="action_bidder_name fl clr">
                    <div class="auction_bit_left">
                        <span class="high" style="display:block;"><?php echo __('highest_bidder_label'); ?>: </span>
                        <span class="lastbidder"><?php echo ($product_result['lastbidder_userid'] == 0) ? __('no_bids_yet') : ""; ?></span>
                    </div>
                    <div class="aution_bit_right">
                        <b>Bid</b>
                        

                    </div>
                </div>
                </div>
                <div class="futureday mt10"></div>
             
               
                <div class="user" style="display:none;" ><?php //echo $user; ?></div>
                       

              

                <!-- Message flash-->
                <div class="notice_nsg fl clr" id="notice_msg<?php echo $product_result['product_id']; ?>" style="display:none;"></div> <!-- end of Message flash-->
            </div>
        </div>

        <div class="watch_list  clr">
            <span class="read_more"><a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>">More Info</a></span>

            <a href="" title="<?php echo __('add_to_watchlist'); ?>" rel="<?php echo $product_result['product_id']; ?>" class="addwatchlist" name="<?php echo URL_BASE; ?>auctions/addwatchlist">
    <?php echo __('add_to_watchlist'); ?>
            </a>


        </div>

    </div> 
<?php endforeach; ?>	
