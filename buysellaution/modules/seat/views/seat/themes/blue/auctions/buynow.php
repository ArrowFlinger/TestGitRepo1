<?php foreach ($productsresult as $product_result): 

	//for get the buy seats count 
	$buyseat_count = Seat::get_buy_seatcount($product_result['product_id']);
	//end 

?>
    <div id="auction_<?php echo $product_result['product_id']; ?>" class="auction_item auction_item_content seat" name="<?php echo URL_BASE; ?>auctions/process" data-id="<?php echo $product_result['product_id']; ?>">
        <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type']; ?>"></div>
        <div class="deal-top_f"> </div>

        <div class="deal-mid seat_mid clearfix">
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
                        <?php if ($product_result['autobid'] == ENABLE) { ?><span class="autobid_icon"></span><?php } ?>
                        <?php if ($product_result['product_featured'] == HOT) { ?><span class="hot_icon"></span><?php } ?>
                            <span class="seaticon"></span>
                        </div>
                        <img src="<?php echo $product_img_path; ?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']); ?>" alt="<?php echo $product_result['product_name']; ?>"/>
                    </a>
                     <div class="action_item_detail">
                    <p><?php echo __('retail_price_label') . " : " . $site_currency . " " . $product_result['product_cost']; ?></p>
                    <p><?php echo __("time_countdown_label") . " : " . $product_result['bidding_countdown']; ?> secs</p>
                </div>
                </div>
               

            </div>
            <div class="text-block fl clearfix">
                <div class="seat_max">
            <div class="bidme_link_out buyseats_link fl clr">
                               <div class="width_bidme width_bidme_live buyseats_link buyseat_button1 buyseat_button clr">
                                   <span class="buy_seat_left fl"></span>
                                    <span class="buy_seat_mid fl">
                                    <a id="buy_seat" href="javascript:;" data-rel="seatpopup" name="sample" class="buy_seat"  title="<?php echo __('buy_seats_label');?>" rel="<?php echo URL_BASE;?>users/login?redirect=<?php echo urlencode(URL_BASE.'auctions/live/');?>" data-pid="<?php echo $product_result['product_id'];?>">
                                           <?php echo __("buy_seats_label");?>
                                        </a>
                               </span>
                                   <span class="buy_seat_right fl"></span>
                            </div>
                            
                             
                    </div>
                    
                    <?php //hide the seat status 
            		 //if($buyseat_count != $product_result['max_seat_limit']) { ?>
                               <div class="action_price clr"><p class="seat_info"><span id="bseats" class="buyseatss" ></span><?php echo '/'.$product_result['max_seat_limit']; ?> <?php echo __('seat_label');?></p></div>
                            <?php //} ?>        
            
            <?php //check the seat min limit before bidding
        //if($buyseat_count >= $product_result['min_seat_limit']) { ?>
           
               <div class="bidme_link_out fl clr">
                <center>
                        <div class="bidme_link width_bidme width_bidme_live clr" style="display:none;">
                                <span class="bidme_link_left fl">&nbsp;</span>
                                <span class="bidme_link_middle fl">
                                       <a href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="bid" data-auctiontype ="<?php echo $product_result['auction_type'];?>" title="<?php echo ($auction_userid=='')? __('login_label'):__('bid_me_label');?>" rel="<?php echo URL_BASE;?>users/login?redirect=<?php echo urlencode(URL_BASE.'auctions/live/');?>" id="<?php echo $product_result['product_id'];?>">
                                            <?php echo __("bid_me_label");?>
                                        </a>
                                </span>
                                <span class="bidme_link_left bidme_link_right fl">&nbsp;</span>
                        </div>
		        <!--Loader-->
		        <div class="loader<?php echo $product_result['product_id'];?>" style="display:none;"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>
            	</center>
            </div>   
            <?php //} ?>  
              
                <div class="action_price"><span class="currentprice"></span><span class="price" style="display:none;"></span></p></div>
                 </div>
                
                <div class="new_com"><!-- add for this div hide show by jagan -->
                 <div class="action_bidder_name fl clr">
                    <div class="auction_bit_left">
                    <span class="high" style="display:block;"><?php echo __('highest_bidder_label');?>: </span>
                    <span class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):"";?></span>
                    </div>
                    <div class="aution_bit_right">
                        <b>Bid</b>
                        <p>  <?php echo $site_currency." ".$product_result['bidamount'];?></p>
                        
                    </div>
		</div>
                
                <div class="user" style="display:none;" ><?php //echo $user; ?></div>


                <div class="countdown"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
                </div>
                <!--End of Auctions process div-->
                <div class="minimum_info fl clearfix buyseat_details" style="display:none;">
               <p><?php echo __('min_seat_limit');?>: <b><?php echo $product_result['min_seat_limit'];?></b></p>
                    <p><?php echo __('seat_cost');?>: <strong><?php echo $site_currency." ".$product_result['seat_cost'];?></strong></p>
                    <p><?php echo __('seat_enddate');?>: <b><?php echo date('M d, Y',strtotime($product_result['seat_enddate']));?></b></span></p>
            </div>
                <!--Share-->
                <div class="auction_share_icon mt5">
                    <a style="float:left; width:30px;"  href="http://twitter.com/share?url=<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" target="_blank" title="Twitter" ><img src="<?php echo IMGPATH . 'twitter_link_icon.png'; ?>" style="margin:2px 0px 0px 5px;"/></a>
                    <a  style="float:left; width:30px;" href="https://www.facebook.com/sharer.php?u=<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" target="_blank"  title="Facebook">
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
            <span class="read_more"><a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>">More Info</a></span>

            <a href="" title="<?php echo __('add_to_watchlist'); ?>" rel="<?php echo $product_result['product_id']; ?>" class="addwatchlist" name="<?php echo URL_BASE; ?>auctions/addwatchlist">
               <?php echo __('add_to_watchlist'); ?>
            </a>


        </div>
    </div>    

<?php endforeach; ?>
