<?php defined("SYSPATH") or die("No direct script access."); 
?>
        <?php foreach($productsresult as $product_result):
	if($product_result['in_auction']==2){
	?>
	
	<div class="auction_item_content seat" name="<?php echo URL_BASE;?>auctions/process">
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
        <span class="seaticon"></span>
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
				<p class="fl clr"><span style="float:left"><?php echo __('retail_price_label')." :</span> ".$site_currency." ".$product_result['product_cost'];?></p>
                	<p class="fl clr mt5"><span class="fl"><?php echo __("time_countdown_label")." :"?></span>  <span style="display:block;"><?php echo $product_result['bidding_countdown'];?> secs</span>
</p>

			</div>
            </div><a class="more_info_link fl" href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="more information"></a>
			
			
                  <div id="auction_element_<?php echo $product_result['product_id'];?>">
                  <div id="countdown_<?php echo $product_result['product_id'];?>"  class="countdown fl clr"><?php echo __("closed_text");?></div>
                  <div class="action_price fl clr"><p>
                    <span style="display:block;"><?php echo __('auction_price_label');?>:</span> <?php echo  $site_currency." ".$product_result['current_price'];?></p>
                  </div>
                  <div class="action_bidder_name fl clr">
                      <div class="auction_bit_left">
                         <span class="high" style="display:block;"><?php echo __('highest_bidder_label');?>: </span>
                         <span class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):ucfirst($product_result['username']);?></span>
                     </div>
                    <div class="aution_bit_right">
                        <b>Bid</b>
                        <p>  <?php echo $site_currency." ".$product_result['bidamount'];?></p>
                        
                    </div>
                      
			
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
				echo "<b>".$site_currency." ".$product_result['current_price']."</b>";
				}
				?></p>
                    </div>
                  <div class="action_item_detail fl clr pb10">
                    <p class="fl clr"><b><?php echo __("ended_on_label");?>:</b> <?php echo $status=$auction->date_to_string($product_result['enddate']);?></p>
                  </div>
                 </div>
                 </div>
                  <div class="watch_list fl clr">
            <span class="read_more" style="margin-top:10px;">   <a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="more information">More</a></span>
                        
                </div>
              	</div>
	
	<?php } else { ?>
            <div id="auction_<?php echo $product_result['product_id'];?>" class="auction_item auction_item_content seat" name="<?php echo URL_BASE;?>auctions/process" data-id="<?php echo $product_result['product_id'];?>">
            <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
            <div class="deal-top_f">
               		
                </div>
                <div class="deal-mid clearfix">
                <!--product title-->
		<h3 class="fl clr">
                	<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>">
						<?php echo strlen($product_result['product_name'])>20?substr(ucfirst($product_result['product_name']),0,20)."...":ucfirst($product_result['product_name']);?>
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
<?php if($product_result['product_featured']==FEATURED){?><span class="feature_icon"></span><?php } ?>
<div class="pop_top_bg">
			 <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons"></span><?php } ?>
			 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
			 <?php if($product_result['product_featured']==HOT){?><span class="hot_icon"></span><?php } ?>
			 <span class="seaticon"></span>
</div>
	                <img src="<?php echo $product_img_path;?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>"/>
                    </a>
                     <div class="action_item_detail fl clr">
					<p class="fl"><span style="float:left"><?php echo __('retail_price_label')." :</span> ".$site_currency." ".$product_result['product_cost'];?></p>
                	<p class="fl clr mt5"><span class="fl"><?php echo __("time_countdown_label")." :"?></span> <span style="float:left"><?php echo $product_result['bidding_countdown'];?> secs</span>
</p>
                </div>
                </div>
              
                <div class="bidme_link_out fl clr">
                <center>
                        <div class="bidme_link width_bidme width_bidme_live clr">
                                <span class="bidme_link_left fl">&nbsp;</span>
                                <span class="bidme_link_middle fl">
                                        <a href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="fl bid" data-auctiontype ="<?php echo $product_result['auction_type'];?>" title="<?php echo ($auction_userid=='')? __('login_label'):__('bid_me_label');?>" rel="<?php echo URL_BASE;?>users/login/" id="<?php echo $product_result['product_id'];?>">
                                            <?php echo __("bid_me_label");?>
                                        </a>
                                </span>
                                <span class="bidme_link_left bidme_link_right fl">&nbsp;</span>
                        </div>
		        <!--Loader-->
		        <div class="loader<?php echo $product_result['product_id'];?>" style="display:none;"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>
            	</center>
            </div>   
              <div class="action_price fl clr">
				  <p><span style="display:none;"><?php echo __('price_label');?>:</span><span class="currentprice"></span><span class="price" style="display:none;"></span></p>
			  </div>
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
                             <!--Loader-->
                            <div class="loader<?php echo $product_result['product_id']; ?>" style="display:none;"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
                    </div>
                    <div class="action_price fl clr"><p class="seat_info"><span id="bseats" class="buyseatss" ></span><?php echo '/'.$product_result['max_seat_limit']; ?> <?php echo __('seat_label');?></p></div>
                <!--Auctions process div-->                        	
              
                <?php if($status==3){?> <div class="futureday mt10"></div><?php } ?>
               <div class="new_com">
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
                <div class="user" style="display:none;" ><?php //echo $user;?></div>                       
                  <div class="countdown fl clr"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>
                  <div class="bid_price fl clr" style="display:none;"><p class="fl clr"><?php echo __("bid_label");?>: <?php echo $site_currency." ".$product_result['bidamount'];?></p></div>    
            </div>        
                  
         <div class="minimum_info fl clearfix buyseat_details" style="display:none;">
                <p><?php echo __('min_seat_limit');?>: <b><?php echo $product_result['min_seat_limit'];?></b></p>
                    <p><?php echo __('seat_cost');?>: <strong><?php echo $site_currency." ".$product_result['seat_cost'];?></strong></p>
                    <p><?php echo __('seat_enddate');?>: <b><?php echo date('M d, Y',strtotime($product_result['seat_enddate']));?></b></span></p>
            </div>          
        <!--End of Auctions process div-->
        <!--Share-->
        <div class="auction_share_icon fl clr mt5">
     <a style="float:left; width:30px;"  href="http://twitter.com/share?url=<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" target="_blank" title="Twitter" ><img src="<?php echo IMGPATH.'twitter_link_icon.png';?>" style="margin:2px 0px 0px 5px;"/></a>
        <a style="float:left; width:30px;" href="https://www.facebook.com/sharer.php?u=<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" target="_blank"  title="Facebook">
        <img src="<?php echo IMGPATH.'fbook_icon.png';?>" class="pl5 pr5 " style="padding-top:2px ;" /></a>
        <!--Like--> 
        <!--Facebook-->
       
        <fb:like style="float:left; width:auto;" href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"  ></fb:like>	<!--End of facebook-->	   
        </div>          
           </div>
        <!--End of share-->
        <div class="watch_list fl clr">
                    

            <span class="read_more"><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>">More Info</a></span>
        <a href="" title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist">
		      +  <?php echo __('add_to_watchlist');?>
        </a>
       </div>
        <!-- Message flash-->
        <div class="notice_nsg fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
     
       
        </div>
        <?php } endforeach;?>
       
