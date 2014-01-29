
<?php foreach ($productsresult as $product_result): ?>
    <div id="auction_<?php echo $product_result['product_id']; ?>" class="auction_item auction_item_content future_auction_item reserve" name="<?php echo URL_BASE; ?>auctions/process">
        <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type']; ?>"></div>
        <div class="deal-top_f"> </div>

        <div class="deal-mid clearfix">
            <!--product title-->
            <?php
            if (($product_result['dedicated_auction'] == ENABLE) and ($product_result['product_featured'] != FEATURED) and ($product_result['product_featured'] != HOT)) {
                ?>
                <h3 class="bonus-title">
                    <a href="<?php echo url::base(); ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
                        <?php echo ucfirst(Text::limit_chars($product_result['product_name'], 16)); ?>
                    </a>
                </h3> 
                <?php
            } elseif ((($product_result['product_featured'] == FEATURED) and ($product_result['product_featured'] != HOT)) and ($product_result['dedicated_auction'] != ENABLE)) {
                ?>
                <h3 class="hot-title">
                    <a href="<?php echo url::base(); ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
                <?php echo ucfirst(Text::limit_chars($product_result['product_name'], 20)); ?>
                    </a>
                </h3> 
                        <?php
                    } elseif ((($product_result['product_featured'] != FEATURED) and ($product_result['product_featured'] == HOT)) and ($product_result['dedicated_auction'] != ENABLE)) {
                        ?>
                <h3 class="hot-title">
                    <a href="<?php echo url::base(); ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
                <?php echo ucfirst(Text::limit_chars($product_result['product_name'], 16)); ?>
                    </a>
                </h3> 
        <?php
    } elseif (($product_result['product_featured'] == FEATURED) && ($product_result['dedicated_auction'] == ENABLE)) {
        ?>
                <h3>
                    <a href="<?php echo url::base(); ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
                <?php echo ucfirst(Text::limit_chars($product_result['product_name'], 11)); ?>
                    </a>
                </h3> 
                <?php
            } elseif (($product_result['product_featured'] == HOT) && ($product_result['dedicated_auction'] == ENABLE)) {
                ?>
                <h3>
                    <a href="<?php echo url::base(); ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
        <?php echo ucfirst(Text::limit_chars($product_result['product_name'], 10)); ?>
                    </a>
                </h3> 
                <?php
            } else {
                ?>
                <h3>
                    <a href="<?php echo url::base(); ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="">
                        <?php echo ucfirst(Text::limit_chars($product_result['product_name'], 22)); ?>
                    </a>
                </h3> 
                <?php }
            ?>
            <div class="action_item_img fl">
                <a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo $product_result['product_name']; ?>" class="fl">
            <?php
            if (($product_result['product_image']) != "" && file_exists(DOCROOT . PRODUCTS_IMGPATH_THUMB . $product_result['product_image'])) {
                $product_img_path = URL_BASE . PRODUCTS_IMGPATH_THUMB . $product_result['product_image'];
            } else {
                $product_img_path = IMGPATH . NO_IMAGE;
            }
            ?><div class="pop_top_bg">
            <?php if ($product_result['dedicated_auction'] == ENABLE) { ?><span class="bonus_icons"></span><?php } ?>
            <?php if ($product_result['autobid'] == ENABLE) { ?><span class="autobid_icon"></span><?php } ?>
    <?php if ($product_result['product_featured'] == HOT) { ?><span class="hot_icon"></span><?php } ?>
                        <!-- <span class="penny"></span> -->
                        <span class="reserve_bid_icon"></span>
                    </div>            		<img src="<?php echo $product_img_path; ?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']); ?>" alt="<?php echo $product_result['product_name']; ?>"/>
                </a>
                <div class="action_item_detail fl clr">
                    <p class="fl clr"><?php echo __('retail_price_label') . " :  " . $site_currency . " " . $product_result['product_cost']; ?></p>
                   
                </div>

            </div>
            <div class="price-block fl">

                <div class="bidme_link_out fl clr">
                    <center>
                        <div class="soon_link clr">
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
						<div class="countdown_future fl clr" style="text-align:center;width:100%;font-weight:bold;background-color:#F4F4F4;"><?php echo __('comingsoon_text'); ?></div>


                        
                    </center>
                </div>
  <div class="action_price fl clr"><p class="fl"><span class="currentprice"></span></p></div>

                <div class="user" style="display:none;" ><?php //echo $user; ?></div>

                <!--Loader-->
                <div class="loader<?php echo $product_result['product_id']; ?>" style="display:none;"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
                </center>
            </div>
            <!-- Share Auction START-->
            <div class="action_bidder_name fl clr">
                
               
            </div>
            <div class="countdown countdown_future fl clr"><img src="<?php echo IMGPATH . 'ajax-loader.gif' ?>"/></div>
            <div class="auction_share_icon fl clr mt5">
                <a style="float:left;width:25px;" href="http://twitter.com/share?url=<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" target="_blank" title="Twitter" ><img src="<?php echo IMGPATH . 'twitter_link_icon.png'; ?>" style="margin:2px 0px 0px 5px;"/></a>
                <a style="float:left;width:25px;" href="https://www.facebook.com/sharer.php?u=<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" target="_blank"  title="Facebook">
                    <img src="<?php echo IMGPATH . 'fbook_icon.png'; ?>" class="pl5 pr5 " style="padding-top:2px ;" /></a>
                <!--Like--> 
                <!--Facebook-->

                <fb:like style="float:left;width:auto;" href="<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" layout="button_count" width="84" send="false" ref="" style="border:none;"  ></fb:like>
                <!--End of facebook-->	 
            </div>    

            <!-- Share Auction END-->
        </div>
        <div class="watch_list fl clr">
            <span class="read_more">                <a  href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="more information">Read more</a>
            </span>
            <a href="" title="<?php echo __('add_to_watchlist'); ?>" rel="<?php echo $product_result['product_id']; ?>" class="addwatchlist" name="<?php echo URL_BASE; ?>auctions/addwatchlist">
    <?php echo __('add_to_watchlist'); ?>
            </a>

        </div>


    </div>
<?php endforeach; ?>
        
