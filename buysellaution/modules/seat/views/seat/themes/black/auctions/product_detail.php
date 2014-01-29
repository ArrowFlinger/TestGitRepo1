<?php defined("SYSPATH") or die("No direct script access."); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#hide").click(function(){
            $(".fun").hide();
        });
        $("#show").click(function(){
            $(".fun").show();
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
		
        //jCarousel Plugin
        $('#carousel').jcarousel({
            horizontal: true,
            scroll: 1,
            auto: 2,
            wrap: 'last',
            initCallback: mycarousel_initCallback
        });

        //Front page Carousel - Initial Setup
        $('div#slideshow-carousel a img').css({'opacity': '1.0'});
        $('div#slideshow-carousel a img:first').css({'opacity': '1.0'});
        $('div#slideshow-carousel li a:first').append('<span class="arrow"></span>')

  
        //Combine jCarousel with Image Display
        $('div#slideshow-carousel li a').hover(
       	function () {
        		
            if (!$(this).has('span').length) {
                $('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '1.0'});
                $(this).stop(true, true).children('img').css({'opacity': '1.0'});
            }		
       	},
       	function () {
        		
            $('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '1.0'});
            $('div#slideshow-carousel li a').each(function () {

                if ($(this).has('span').length) $(this).children('img').css({'opacity': '1.0'});

            });
        		
       	}
    ).click(function () {

            $('span.arrow').remove();        
            $(this).append('<span class="arrow"></span>');
            $('div#slideshow-main li').removeClass('active');        
            $('div#slideshow-main li.' + $(this).attr('rel')).addClass('active');	
        	
            return false;
        });


    });

    //Carousel Tweaking
    function mycarousel_initCallback(carousel) {
	
        // Pause autoscrolling if the user moves with the cursor over the clip.
        carousel.clip.hover(function() {
            carousel.stopAuto();
        }, function() {
            carousel.startAuto();
        });
    }
	
</script>

<?php
$id = "";
$c_date = Commonfunction::getCurrentTimeStamp();
foreach ($productsresult as $product_result):
    $id.= $product_result['product_id'];
    ?>
    <?php if ($product_result['product_process'] != CLOSED) { ?>
        <script type="text/javascript">
            $(document).ready(function(){
                Auction.getauctionstatus(6,"",'<?php echo $id; ?>');					   
            });
        </script>
    <?php
    } else {
        ?><script type="text/javascript">
            $(document).ready(function(){
                Auction.bidhistory();				   
            });
        </script>
    <?php } ?>

 
   
    <?php
    //for get the buy seats count 
    $buyseat_count = Seat::get_buy_seatcount($product_result['product_id']);
   // $booked_ids = Seat::get_buy_seat_userids($product_result['product_id']);
    //end
    if (($product_result['product_image']) != "" && file_exists(DOCROOT . PRODUCTS_IMGPATH_THUMB2 . $product_result['product_image'])) {
       $product_img_path = URL_BASE . PRODUCTS_IMGPATH_THUMB2 . $product_result['product_image'];
        $product_full_size = URL_BASE . PRODUCTS_IMGPATH_THUMB4 . $product_result['product_image'];
    } else {
        $product_full_size = IMGPATH . NO_IMAGE;
        $product_img_path = IMGPATH . NO_IMAGE;
    }
    ?>

    <!-- container_inner   CLASS START-->
    <div class="container_inner fl clr element<?php echo $product_result['product_id']; ?> seat">
        <!-- winning msg / outbid msg -->
        <div class="reserveMessage"></div>
        <!-- end msg -->
        <div class="title_temp2 fl clr">
            <h2 class="fl clr"><?php echo __('menu_product_detail'); ?></h2>
        </div>

        <div class="fun" style="display:none">
            <!--Google Map-->
            <div class="fun" >
                <div id="map-canvas"></div> 
            </div>
            <!--Map End-->
        </div>
        <!-- product_container START-->

        <div class="product_container fl clr ml10 mt20 auction_item re_product_container" id="auction_<?php echo $id; ?>" name="<?php echo URL_BASE; ?>auctions/process">
            <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type']; ?>"></div>
            <div class="product_title seat_product_title fl clr">
		   <!-- Message flash-->
                   <div class="notice_nsg2 fl clr" id="notice_msg<?php echo $product_result['product_id']; ?>" style="display:none;"></div>  <!-- end of Message flash-->
                <h2 class="fl clr"><?php echo Ucfirst($product_result['product_name']); ?></h2>
            </div>
            <div class="product_left fl">
                <div class="product_detail_top fl clr">
                    <div class="product_detail_top_left re_product_detail_top_left fl">

                        <div class="re_product-top">  </div>
                        <div class="product-middle re_product-middle clearfix">
                            <div class="productDetail" style="display:none;"><?php echo $product_result['product_id']; ?></div>
                            <div class="product_feature_outer">
    <?php if ($product_result['product_featured'] == FEATURED) { ?><span class="feature_icon_product"></span><?php } ?>
    <?php if ($product_result['dedicated_auction'] == ENABLE) { ?><span class="bonus_icons_product_top" title=""></span><?php } ?>
                                <?php if ($product_result['autobid'] == ENABLE) { ?><span class="autobid_icon"></span><?php } ?>
                                <?php if ($product_result['product_featured'] == HOT) { ?><span class="hot_icon_product_ic"></span><?php } ?>
                                <!-- <span class="penny_product"></span> -->
                                <span class="seat_product"></span>
                            </div>


                            <div id="slideshow-main">
                                <ul>
                                    <li class="p1 active">
                                        <a class="fl lightbox" title="<?php echo ucfirst($product_result['product_name']); ?>"> <img src="<?php echo $product_img_path; ?>" width="336" height="239" border="0" class="fl" /><?php if($product_result['lastbidder_userid']!=0 && $product_result['product_process']=="C"){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image" style="width:auto;height:auto;" /><?php } ?></a>
                                    </li>
    <?php
    $productimage_count = explode(",", $product_result['product_gallery']);
    if ($product_result['product_gallery'] == "") {
        $no_img_path = IMGPATH . NO_IMAGE;
        ?>

                                        <?php
                                    } else {
                                        $j = 2;
                                        foreach ($productimage_count as $productallname) {
                                            $product_fullimage_size=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb370x280/".$productallname;	
                                            ?>
                                            <li class="p<?php echo $j; ?> ">
                                                <a href="#">
                                                    <img src="<?php echo $product_fullimage_size; ?>" width="335" height="239" alt=""/>
                                                </a>
                                            </li>
                                            <?php
                                            $j++;
                                        }
                                    }
                                    ?>
                                </ul>										
                            </div>
                            <div id="slideshow-carousel">				
                                <ul id="carousel" class="jcarousel jcarousel-skin-tango">
                                    <li><a href="#" rel="p1"><img src="<?php echo $product_full_size; ?>" width="81" height="54" alt="#" /></a></li>
                                    <?php
                                    if ($product_result['product_gallery'] == "") {
                                        $no_img_path = IMGPATH . NO_IMAGE;
                                        ?>
        <?php
    } else {
        $productimage_count = explode(",", $product_result['product_gallery']);
        $j = 2;
        foreach ($productimage_count as $productallname) {
            $product_fullimage_size = URL_BASE . PRODUCTS_IMGPATH_THUMB150x150 . "thumb81x54/" . $productallname;
            ?>
                                            <li><a href="#" rel="p<?php echo $j; ?>"><img src="<?php echo $product_fullimage_size; ?>" width="81" height="54" alt="#"/></a></li> <?php
                                $j++;
                            }
                        }
    ?>
                                </ul>
                            </div>  
                        </div>
                        <div class="product_bottom_bg">
                                    <?php if ($product_result['product_process'] != CLOSED) { ?>
                                <div class="add_watch_list">
                                    <a href="javascript:;" class="future addwatchlist" title="Add to watchlist" rel="<?php echo $product_result['product_id']; ?>"  name="<?php echo URL_BASE; ?>auctions/addwatchlist"> <?php echo __('add_to_watchlist'); ?></a>
                                </div>
    <?php } ?>
                        </div>
                    </div>
                    <div class="product_detail_top_right seat_product_detail_top_right">

                        <div class="product_details_right_inner clearfix">
                            <div class="product_details_right_inner_top"></div>
                            <div class="product_details_right_inner_middle">
                                <table width="280" cellpadding="0" cellspacing="0" border="0" align="right" class="value-table fl">
                                    <tr>
                                        <th align="right" class="price_label"><?php echo __('price_label'); ?>&nbsp;:&nbsp;</th>
                                        <td align="left" class="price_label"><p><span class="currentprice"><?php echo ($product_result['product_process'] == CLOSED) ? $site_currency . " " . Commonfunction::numberformat($product_result['current_price']) : Commonfunction::numberformat($product_result['current_price']); ?></span><span class="price" style="display:none;"></span></p></td>
                                    </tr>
                                    <tr>
                                        <th align="right"><?php echo __('highest_bidder_label'); ?>&nbsp;:&nbsp;</th>
                                        <td align="left" ><p><span class="lastbidder"><?php echo ($product_result['lastbidder_userid'] == 0) ? __('no_bids_yet') : ucfirst($product_result['username']); ?></span></p></td>
                                    </tr>
                                    <tr>
                                        <td align="right" colspan="2">
                                            <div class="product_timer fl" style="width:100%;">
                                                <strong class="countdown fr" style="letter-spacing:0;font-size:16px;"><?php echo ($product_result['product_process'] != CLOSED) ? "<img src=" . IMGPATH . "ajax-loader.gif>" : __('closed_text'); ?></strong>
                                                <a href="javascript:;" onclick="window.location.reload(true);"><img src="<?php echo IMGPATH . 'timer_bg.png'; ?>" width="28" height="32" border="0" title="<?php echo __('with_each_bid_time_increases_by') . ' ' . $product_result['bidding_countdown'] . ' Secs'; ?>" class="fr mr10" /></a>
                                            </div>
                                        </td>
                                    </tr>
    <?php //if($buyseat_count >= $product_result['min_seat_limit']) {  ?>
                                    <tr>
                                        <td align="center" colspan="2">
					  <div class="loader<?php echo $id; ?>" style="display: none;"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
    <?php if ($product_result['startdate'] <= $c_date && $product_result['auction_process'] != HOLD): ?>
                                                <div class="bidme_link width_bidme clr" style="display:none;">
                                                    <div class="re_bidnow_left fl">&nbsp;</div>
                                                    <div class="re_bidnow_middle fl">
                                                        <div class="user" style="display:none;" ><?php //echo $user;?></div>
        <?php if ($product_result['product_process'] == LIVE) { ?>
                                                            <a href="javascript:;" name="<?php echo URL_BASE; ?>auctions/bid" class="bid"  rel="<?php echo URL_BASE; ?>users/login?redirect=<?php echo urlencode(URL_BASE.'auctions/view/'.$product_result['product_url']);?>" id="<?php echo $product_result['product_id']; ?>" data-auctiontype="<?php echo $product_result['auction_type']; ?>"><?php echo __('bid_me_label'); ?></a><?php } else if ($product_result['product_process'] == CLOSED) { ?>
                                                            <span id="link_<?php echo $product_result['product_id']; ?>"  class="future auction_link"><?php echo __('closed_text'); ?></span><?php } else if ($product_result['product_process'] == FUTURE) { ?><span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text'); ?></span><?php } ?>
                                                    </div>
                                                    <div class="re_bidnow_right fl">&nbsp;</div>
                                                </div>
    <?php endif; ?>
                                        </td>
                                    </tr>
    <?php //}  ?>
    <?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>
                                    <tr>
                                        <td align="center" colspan="2">
                                            <div  class="proding1"><a href="<?php echo URL_BASE; ?>site/buynow/buynow_addcart/<?php echo $product_result['product_id']; ?>" title="<?php echo __('Buy Now'); ?>"><img src="<?php echo IMGPATH; ?>buynow_3.png"></a>	</div>
                                        </td>
                                    </tr>
				    
				    <?php endif;?>
                                    <?php if ($product_result['product_process'] != CLOSED) { ?>
                                        <tr>

                                            <td align="center" colspan="2" ><b><span id="bseats" class="buyseatss" ><?php echo $buyseat_count;?></span><?php echo '/' . $product_result['max_seat_limit']; ?> <?php echo __('seat_label'); ?></b></td>
                                        </tr>
                                        <tr class="buyseats_link">
                                            <td align="center" colspan="2">
                                        <?php if ($product_result['startdate'] <= $c_date && $product_result['auction_process'] != HOLD): ?><?php if($product_result['userid']!= $auction_userid){?>
                                                    <div class="product_bidnow_links buyseat_button " style="display:none;">
                                                        <div class="det_buy_seats_left">&nbsp;</div>
                                                        <div class="det_buy_seats_middle">
                                                            <div class="user" style="display:none;" ><?php //echo $user; ?></div>
            <?php if ($product_result['product_process'] == LIVE) { ?>
                                                                <a  href="javascript:;" name="sample" class="buy_seat fl" data-rel="seatpopup"  title="<?php echo __('buy_seats_label'); ?>" rel="<?php echo URL_BASE; ?>users/login?redirect=<?php echo urlencode(URL_BASE.'auctions/view/'.$product_result['product_url']);?>" data-pid="<?php echo $product_result['product_id']; ?>"> <?php echo __("buy_seats_label"); ?></a>
                                                    <?php } else if ($product_result['product_process'] == CLOSED) { ?>
                                                                <span id="link_<?php echo $product_result['product_id']; ?>"  class="future auction_link"><?php echo __('closed_text'); ?></span><?php } else if ($product_result['product_process'] == FUTURE) { ?><span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text'); ?></span><?php } ?>

                                                            <!--<a href="#" title="Bid Now!" class="fl">Bid Now!</a>-->
                                                        </div>
                                                        <div class="det_buy_seats_right">&nbsp;</div>
                                                    </div> <?php }?>
                                                        <?php endif; ?>
                                            </td>
                                        </tr>
    <?php } else { ?>

                                        <tr>

                                            <td align="center" colspan="2" ><span id="bseats" class="buyseatss" ></span><b><?php echo $buyseat_count . '/' . $product_result['max_seat_limit']; ?> <?php echo __('seat_close_label'); ?></b></td>
                                        </tr>

                                    <?php } ?>
                                </table>
    <?php if ($product_result['buynow_status'] == ACTIVE && $product_result['product_process'] != 'C'): ?>	


                                    <div class="fl">
                                        <?php if ($product_result['product_process'] != CLOSED) { ?>
                                            <div class="product_detail_middle_right fr">
                                                <div class="product_share fl">
                                                    <p class="fl pr5"><?php echo __('share_label'); ?> : </p>
                                                    <ul class="fl">
                                                        <li class="fl">
                                                            <!-- Place this tag where you want the +1 button to render -->
                                                        <g:plusone size="medium" annotation="none"></g:plusone>

                                                        <!-- Place this render call where appropriate --> 
                                                        <script type="text/javascript">
                                                            (function()
                                                            {
                                                                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                                po.src = 'https://apis.google.com/js/plusone.js';
                                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                            })();
                                                        </script>


                                                        </li>
                                                        <li class="fl">
            <?php $url = URL_BASE . "auctions/view/" . $product_result['product_url'];
            ?>
                                                            <a href="http://twitter.com/share?url=<?php echo $url; ?>&amp;text=<?php echo $product_result['product_name']; ?>" target="_blank"  title="Twitter" class="fl">
                                                                <img src="<?php echo IMGPATH; ?>twitter_link_icon.png" alt="Twitter" border="0" class="fl"s/>
                                                            </a>
                                                        </li>
                                                        <li class="fl">
                                                            <a href="https://www.facebook.com/sharer.php?u=<?php echo $url; ?>&t=<?php echo $product_result['product_name']; ?>" title="Facebook" class="fl" target="_blank">
                                                                <img src="<?php echo IMGPATH; ?>fbook_icon.png" alt="Facebook" border="0" class="fl"s/>
                                                            </a>
                                                        </li>
                                                        <li class="fl">
                                                            <!--Facebook-->

                                                        <fb:like href="<?php echo $url = URL_BASE . 'auctions/view/' . $product_result['product_url']; ?>" layout="button_count" width="84" send="false" ref="" style="border:none; z-index:90;"></fb:like>

                                                        <!--End of facebook-->
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div><?php } ?>
                                    </div>
    <?php endif; ?>
                            </div>
                            <div class="product_details_right_inner_bottom"></div>
                        </div>
                        <div class="fl each_bid_statistics">
                            <div class="product_details_right_inner_top"></div>
                            <div class="product_details_right_inner_middle">
                                
                                <ul class="clearfix">
                                    <li>
                                        <span><?php echo __('With each bid, the auction price increases by_label');?></span>
                                        <strong><?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?></strong>
                                    </li>
                                    <li>
                                        <span><?php echo __('retail_price_label')?></span>
                                        <strong><?php echo $site_currency." ".Commonfunction::numberformat($product_result['product_cost']);?></strong>
                                    </li>
                                    <li>
                                        <span><?php echo __('price_paid_user');?></span>
                                        <strong><?php 
			$user_spents=$auction->winner_user_amount_spent($product_result['product_id'],$product_result['lastbidder_userid']);
                        $amount1=0;
                        foreach($user_spents as $user_spent)
                        {
                            $amount1 += $user_spent['price'];
                        }
                        echo "<b>".$site_currency." ".Commonfunction::numberformat($amount1)."</b>"; ?></strong>
                                    </li>
                                </ul>
                            </div>
                            <div class="product_details_right_inner_bottom"></div>
                        </div>
                        <div class="fl">
                            <div class="product_details_right_inner_top"></div>
                            <div class="product_details_right_inner_middle">
                                <div class="product_price_detail fl">
                                    <div class="price_detail_cnt fl clr">
                                        <p class="fl clr"><?php echo __('save_over_label');?></p>
                                        <label class="fl clr saveover"><?php  $saveover=$product_result['product_cost'] - $amount1;
						echo ($saveover>0)? $site_currency." ".Commonfunction::numberformat($saveover):$site_currency." ". 0;?></label>
                                        <b class="fl clr"><?php echo __('from_the_normal_retail_price_label');?> </b>
                                    </div>
                                </div>
                            </div>
                            <div class="product_details_right_inner_bottom"></div>
                        </div>
                    </div>

                   
                    
                </div>


                <!--product sidebar START-->
                <div class="product_sidebar fr">
    <?php //check the seat users
    //if ($booked_ids && $product_result['product_process'] != CLOSED) {
        ?>
                        <div class="account-left seat_user_bal_show" style="display:none;">
                            <div class="account-right">
                                <div class="account-mid">
                                    <div class=""><p class="fl"><?php echo __('user_bal_label'); ?> :</p><p class="fl"><span class="user_seat_amount" >-</span></p></div>
                                </div>
                            </div>
                        </div>
    <?php //} ?>
                    <!--product sidebar Bid History START-->
                    <div class="product_sidebar1 fl clr">
                        <div class="product_sidebar_tab fl">
                            <ul class="fl">
                                <li class="fl ml10">
                                    <a href="#" title="Bid History" class="fl">
                                        <span class="fl product_sidebar_tab_left">&nbsp;</span>
                                        <span class="fl product_sidebar_tab_middle pl5 pr5"><?php echo __('bid_history_label'); ?></span>
                                        <span class="fl product_sidebar_tab_left product_sidebar_tab_right">&nbsp;</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="product_sidebar_top fl clr"></div>
                        <div class="product_sidebar_middle fl clr">
                            <table cellpadding="0" cellspacing="0" border="0" width="305">
                                <tr>
                                    <th width="80" align="left"><?php echo __('Price_label'); ?></th>
                                    <th width="105" align="left"><?php echo __('Bidder_label'); ?></th>
                                    <th width="82" align="left"><?php echo __('Date_label'); ?></th>

                                </tr> 
                            </table>
                            <!--Bid history-->
                            <div class="bid_history" id="<?php echo URL_BASE; ?>site/seat/bid_history/<?php echo $id; ?>" style="" rel="<?php echo $product_result['lastbidder_userid']; ?>"  name="<?php echo $auction_userid; ?>"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div><!--End of bid history-->  
                                                
                        </div>
                        <div class="product_sidebar_top product_sidebar_btm fl clr"></div>
                    </div>

                    <!--Auction News END-->   
                </div>
                <!--product sidebar START-->
            </div>
            <div class="product_container fl clr pt10 ml20">
                <h2 class="product_detail_title fl clr"><?php echo __('product_description'); ?></h2>

                <p class="product_detail_description fl clr mt10"><?php echo $product_result['product_info']; ?></p>
            </div>
            <!-- product_container END-->
            <div class="product_container seat_product_container fl clr mt20 pt10 ml20">
                <div class="product_btm_content_left fl">
                    <div class="yello_top"><p><?php echo __('auctions_details');?></p></div>
                    <div class="yello_mid">
                        <table align="left" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <th align="left"><?php echo __('auction_id_label'); ?>: </th>
                                <td align="right"><p><?php echo $product_result['product_id']; ?></p></td>
                            </tr>
                            <tr>
                                <th align="left"><?php echo __('Auction_type_label'); ?> : </th>
                                <td align="right"><span><?php echo Ucfirst($product_result['typename']); ?></span></td>
                            </tr>
                            <tr>
                                <th align="left"><?php echo __('min_seat_limit');?> : </th>
                                <td align="right"><span><?php echo $product_result['min_seat_limit'];?></span></td>
                            </tr>
                            <tr>
                                <th align="left"><?php echo __('seat_cost');?> : </th>
                                <td align="right"><span><?php echo $site_currency." ".$product_result['seat_cost'];?></span></td>
                            </tr>
                            <tr>
                                <th align="left"><?php echo __('seat_enddate');?> : </th>
                                <td align="right"><span><?php echo date('M d, Y',strtotime($product_result['seat_enddate']));?></span></td>
                            </tr>
                        </table>

                    </div>
                    <div class="yello_bot"></div>
                </div>
                <div class="product_btm_content_middle fl ml20 pl5">
                    <div class="yello_top"><p><?php echo __('price_details');?></p></div>
                    <div class="yello_mid">
                        <table align="right" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <th align="left"><?php echo __('price_starts_from'); ?>: </th>
                                <td align="right"><span><?php echo $site_currency . " " . Commonfunction::numberformat($product_result['starting_current_price']); ?></span></td>
                            </tr>
                            <tr>
                                <th align="left"><?php echo __('start_time_label'); ?>: </th>
                                <td align="right"><span><?php echo Commonfunction::date_to_string($product_result['startdate']); ?></span></td>
                            </tr>
                            <tr>
                                <th align="left"><?php echo __('end_time_label'); ?>: </th>
                                <td align="right"><span><?php echo Commonfunction::date_to_string($product_result['enddate']); ?></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="yello_bot"></div>
                </div>
                <div class="shipping_detail re_shipping_detail fl">
                    <div class="yello_top"><p><?php echo __('shopping_details');?></p></div>
                    <div class="yello_mid">
                        <div class="shipping_title fl clr">
                            <p class="fl"><?php echo __('Shipping_fee_label'); ?> :</p>
                            <span class="fr"><?php echo $site_currency . " " . $product_result['shipping_fee']; ?></span>
                        </div>

                        <div class="shipping_title fl clr">
                            <p class="fl"><?php echo __('Shipping_information_label'); ?> :</p>
                            <span class="fr"><?php echo trim($product_result['shipping_info'])!=""?$product_result['shipping_info']:"-"; ?></span>
                        </div>
                    </div>
                    <div class="yello_bot"></div>
                </div>
            </div>    

            <!--Modal Window-->
    <?php /* <div id="dialog" title="<?php echo __('confirm_box'); ?>" style="display:none;">

      <div> <table cellpadding="8" cellspacing="18" width="400">
      <tr>
      <td style="padding:10px;"><?php echo __('price_label'); ?> </td>
      <td>:</td>
      <td style="padding:10px;"><?php echo ($product_result['product_process'] == CLOSED) ? $site_currency . " " . Commonfunction::numberformat($product_result['current_price']) : Commonfunction::numberformat($product_result['current_price']); ?></td>
      </tr>
      <tr>
      <td style="padding:10px;"><?php echo __('your_bid_label'); ?> </td>
      <td>:</td>
      <td style="padding:10px;"><span id="sample"></span></td>
      </tr>
      </table>
      </div>

      <div class="" ><a href="javascript:;" name="<?php echo URL_BASE; ?>auctions/bid" class="reservebid"  rel="<?php echo URL_BASE; ?>users/login/" id="<?php echo $product_result['product_id']; ?>" data-auctiontype="<?php echo $product_result['auction_type']; ?>"><button style="float:right;" ><?php echo __('confirm_bid_me_label'); ?></button></a></div>



      </div> */ ?>

            <div class="popupbox2" id="box">
                <div>
                    <div class="popup_inner popup_inner2">
                        <div class="popup_content">
                            <div class="pop_tl">
                                <div class="pop_tr">
                                    <div class="pop_tm">
                                        <h2><?php echo __("review_cofirm"); ?></h2>
                                        <a href="javascript:;" title="close" class="re_close cancel_reserve"  id="boxclose" ><?php echo __('close_lable'); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="popup_content_middle">
                                <div class="clearfix">
                                    <div class="re_image">
                                        <img src="<?php echo $product_img_path; ?>">
                                    </div>
                                    <div class="res_conent">
                                        <h3><?php echo $product_result['product_name']; ?></h3>

                                        <div class="content_info clearfix">
                                            <p class="res_label"><?php echo __('price_label'); ?> </p><span>:</span><p><?php echo ($product_result['product_process'] == CLOSED) ? $site_currency . " " . Commonfunction::numberformat($product_result['current_price']) : Commonfunction::numberformat($product_result['current_price']); ?></p>
                                        </div>
                                        <div class="content_info clearfix">
                                            <p class="res_label"><?php echo __('your_bid_label'); ?></p><span>:</span><p><span id="sample"></span></p>
                                        </div>

                                        <div class="re_confirm clearfix">
                                            <div href="javascript:;" name="<?php echo URL_BASE; ?>auctions/bid" class="re_confrim_bid reservebid"  rel="<?php echo URL_BASE; ?>users/login/" id="<?php echo $product_result['product_id']; ?>" data-auctiontype="<?php echo $product_result['auction_type']; ?>">
                                                <button><?php echo __('confirm_bid_me_label'); ?></button>
                                            </div>
                                            <div href="javascript:;" name="<?php echo URL_BASE; ?>auctions/bid" class="re_cancel_bid cancel_reserve"  rel="<?php echo URL_BASE; ?>users/login/" id="<?php echo $product_result['product_id']; ?>" data-auctiontype="<?php echo $product_result['auction_type']; ?>">
                                                <button><?php echo __("cancel_bid_label"); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pop_bl">
                                <div class="pop_br">
                                    <div class="pop_bm">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php endforeach; ?>       
