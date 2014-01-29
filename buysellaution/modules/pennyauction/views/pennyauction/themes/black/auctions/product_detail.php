<?php $id="";
$c_date =Commonfunction::getCurrentTimeStamp();
foreach($productsresult as $product_result):
$id.= $product_result['product_id']; 
?>
<?php if($product_result['product_process']!=CLOSED){?>
<script type="text/javascript">
$(document).ready(function(){
Auction.getauctionstatus(6,"",'<?php echo $id;?>');					   
});
</script>
<?php } 
else {
?><script type="text/javascript">
$(document).ready(function(){
Auction.bidhistory();				   
});
</script>
<?php }?>

<style type="text/css"> 
      #map-canvas {
        width: 950px;
        height: 190px
		
      }
.price_table{ border:1px solid #E2E1E1; border-bottom:0px;background:#E8E8E8; }
.price_table td{ border-bottom:1px solid #E2E1E1; }
.price_table  td { color:#BB006F;}
</style>

	<?php 
    			if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB3.$product_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB3.$product_result['product_image'];
					$product_full_size=URL_BASE.PRODUCTS_IMGPATH.$product_result['product_image'];
				}
				else
				{
					$product_full_size=IMGPATH.NO_IMAGE;
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?>
 
<!-- container_inner   CLASS START-->
<div class="container_inner fl clr element<?php echo $product_result['product_id'];?>">
	<div class="title_temp2 fl clr">
    	<h2 class="fl clr"><?php echo __('menu_product_detail');?></h2>
    </div>
	<div class="fun" style="display:none">
        <!--Google Map-->
                <div class="fun" >
                <div id="map-canvas"></div> 
                </div>
        <!--Map End-->
        </div>
	<!-- product_container START-->
 
	<div class="product_container fl clr ml10 mt20 auction_item" id="auction_<?php echo $id;?>" name="<?php echo URL_BASE;?>auctions/process">
	<div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
    	<div class="product_left fl">
        	<div class="product_content_top fl clr"></div>
            <div class="product_content_middle fl clr">
            	<div class="product_title fl clr">
                	<h2 class="fl clr"><?php echo ucfirst($product_result['product_name']);?></h2>
                </div>    
                    <div class="product_detail_top fl clr">
                    	<div class="product_detail_top_left fl">
			<div class="productDetail" style="display:none;"><?php echo $product_result['product_id'];?></div>
			 <div class="product_feature_outer">
				<?php if($product_result['product_featured']==FEATURED){?><span class="feature_icon_product"></span><?php } ?>
			        <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons_product_top" title=""></span><?php } ?>
				 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
				<?php if($product_result['product_featured']==HOT){?><span class="hot_icon_product_ic"></span><?php } ?>
                <span class="penny_product"></span>
                         </div>
				<div class="fl">
                        	<a class="fl lightbox" title="<?php echo ucfirst($product_result['product_name']);?>"> <img src="<?php echo $product_img_path;?>" width="200" height="200" border="0" class="fl" /><?php if($product_result['product_process']==CLOSED && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image"/><?php } ?></a></div>
                        </div>
                        
                        <div class="product_detail_top_right fr">
                        <table width="280" cellpadding="0" cellspacing="0" border="0" align="right" class="value-table fl">
                        <tr>
                                	<th align="left" width="65"><?php echo __('price_label');?> : </th>
                                    <td align="right"><p><span class="currentprice"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".Commonfunction::numberformat($product_result['current_price']):Commonfunction::numberformat($product_result['current_price']);?></span><span class="price" style="display:none;"></span></p></td>
                                </tr>
                        </table>
                        	<table width="280" cellpadding="0" cellspacing="0" border="0" align="right">
                            	
                                <tr>
                                	<th align="left"><?php echo __('highest_bidder_label');?> : </th>
                                    <td align="right" ><b><strong class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):ucfirst($product_result['username']);?></strong></b></td>
                                </tr>
                                <tr>
                                	<td align="right" colspan="2">
                                    	<div class="product_timer fr">
                                        	
                                            <strong class="countdown fr"><?php echo ($product_result['product_process']!=CLOSED)?"<img src=".IMGPATH."ajax-loader.gif>":__('closed_text');?></strong>
                                            <a href="javascript:;" onclick="window.location.reload(true);"><img src="<?php echo IMGPATH.'timer_bg.png';?>" width="28" height="32" border="0" title="<?php echo __('with_each_bid_time_increases_by').' '. $product_result['bidding_countdown'].' Secs';?>" class="fr mr10" /></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                	<td align="right" colspan="2">
					<?php if($product_result['startdate']<=$c_date && $product_result['auction_process']!=HOLD):?>
                                    	<div class="product_bidnow_link fr">
                                        	<div class="product_bidnow_left fl">&nbsp;</div>
                                            <div class="product_bidnow_middle fl">
											<div class="user" style="display:none;" ><?php //echo $user;?></div>
						<?php if($product_result['product_process']==LIVE){?>
		<a href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="bid"  rel="<?php echo URL_BASE;?>users/login/" id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>"><?php echo __('bid_me_label');?></a><?php }else if($product_result['product_process']==CLOSED){ ?>
		<span id="link_<?php echo $product_result['product_id'];?>"  class="future auction_link"><?php echo __('closed_text');?></span><?php } else if($product_result['product_process']==FUTURE) { ?><span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text');?></span><?php } ?>
			
                                            	<!--<a href="#" title="Bid Now!" class="fl">Bid Now!</a>-->
                                            </div>
                                            <div class="product_bidnow_left product_bidnow_right fl">&nbsp;</div>
                                        </div>
<?php endif;?>
                                    </td>
                                </tr>
				
                            </table>
			 <?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>	

				<div  class="proding1"><a href="<?php echo URL_BASE;?>site/buynow/buynow_addcart/<?php echo $product_result['product_id'];?>" title="<?php echo __('buy_now');?>"><img src="<?php echo IMGPATH;?>buynow_3.png"></a>	</div>	
			
			<?php endif;?>
                        </div>	
                    </div>
                    <!-- Message flash-->
           <div class="notice_nsg2 fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
                    <div class="product_detail_top fl clr mt20">
                    	<div class="product_detail_middle_left fl">
				
           <!--watchlist message--> 
			<div id="successaddwatchlist_<?php echo $product_result['product_id'];?>" class="info_msg mt5"></div>
	<!--end of watchlist message-->
				<?php if($product_result['product_process']!=CLOSED){?>
                        	<div class="add_watch_list fl pl5">
                                <span class="soon_left fl">&nbsp;</span>
                                <span class="soon_middle fl pl5 pr5">
                                    <a href="javascript:;" class="future fl addwatchlist" title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>"  name="<?php echo URL_BASE;?>auctions/addwatchlist"><?php echo __('add_to_watchlist');?></a>
                                </span>
                                <span class="soon_left soon_right fl">&nbsp;</span>
                            </div>
				<?php } ?>
		<!--Lightbox link-->
			<div id="gallery" class="fl">
                          <a href="<?php echo $product_full_size;?>" style="width: auto;font: bold 12px/20px arial;
color: #EDEDED;" class="fl lightbox" title="<?php echo ucfirst($product_result['product_name']);?>">  
			<div class="enlarge_image fl ml20 mt5">
				
                            	<?php echo __('Click_to_enlarge_Image_label');?></div></a>
                            </div>
                        </div>
			<?php if($product_result['product_process']!=CLOSED){?>
                        <div class="product_detail_middle_right fr">
                        	<div class="product_share fr">
                            	<p class="fl pr5"><?php echo __('share_label');?> : </p>
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
					<?php $url=URL_BASE."auctions/view/".$product_result['product_url'];
					?>
                                        <a href="http://twitter.com/share?url=<?php echo $url;?>&amp;text=<?php echo $product_result['product_name'];?>" target="_blank"  title="Twitter" class="fl">
                                            <img src="<?php echo IMGPATH;?>twitter_link_icon.png" alt="Twitter" border="0" class="fl"s/>
                                        </a>
                                    </li>
                                    <li class="fl">
                                        <a href="https://www.facebook.com/sharer.php?u=<?php echo $url;?>&t=<?php echo $product_result['product_name'];?>" title="Facebook" class="fl" target="_blank">
                                            <img src="<?php echo IMGPATH;?>fbook_icon.png" alt="Facebook" border="0" class="fl"s/>
                                        </a>
                                    </li>
                                    <li class="fl">
		<!--Facebook-->
				
		<fb:like href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none; z-index:90;"></fb:like>

<!--End of facebook-->
                                    </li>
                                </ul>
                            </div>
                        </div><?php } ?>
                    </div>
                    
                    <div class="product_detail_top fl clr mt20 pb20">
                    	<div class="product_bid_price fl mt15">
                        	<!--<p class="fl clr"><?php echo __('With each bid, the auction price increases by_label');?> <span><br/><?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?> </span></p>-->
                            <table cellpadding="0" cellspacing="0" border="0" align="right" class="mt10 mr10">
                            	<tr>
                                	<th align="right"><?php echo __('With each bid, the auction price increases by_label');?>:</th>
                                    <td align="left"><?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?></td>
                                </tr>                            
                            	<tr>
                                	<th align="right"><?php echo __('retail_price_label')?>:</th>
                                    <td align="left"><?php echo $site_currency." ".Commonfunction::numberformat($product_result['product_cost']);?></td>
                                </tr>
                                <tr>
                                	<th align="right"><?php echo __('price_paid_user');?> :</th>
                                    <td align="left"><span class="pricepaid"> <?php 
			$user_spents=$auction->winner_user_amount_spent($product_result['product_id'],$product_result['lastbidder_userid']);
                        $amount1=0;
                        foreach($user_spents as $user_spent)
                        {
                            $amount1 += $user_spent['price'];
                        }
                        echo "<b>".$site_currency." ".Commonfunction::numberformat($amount1)."</b>";
                        ?></span></td>
                                </tr>
                            </table>
                        </div>
                    	<div class="product_price_detail fr">
                        	<div class="product_price_top fl clr">
                            	<span class="price_top_left fl">&nbsp;</span><span class="product_price_top_middle fl">&nbsp;</span><span class="price_top_left price_top_right fl">&nbsp;</span>
                            </div>
                            <div class="price_detail_middle fl">
                            	<div class="price_detail_cnt fl clr">
                                	<p class="fl clr mt5"><?php echo __('save_over_label');?></p>
                                    <label class="fl clr mt15 saveover">
                                    	<?php  $saveover=$product_result['product_cost'] - $amount1;
						echo ($saveover>0)? $site_currency." ".Commonfunction::numberformat($saveover):$site_currency." ". 0;?>
                                    </label>
                                    <b class="fl clr mt15"><?php echo __('from_the_normal_retail_price_label');?> </b >
                                </div>
                            </div>
                            <div class="product_price_top fl clr">
                            	<span class="price_top_left price_btm_left fl">&nbsp;</span><span class="product_price_top_middle fl">&nbsp;</span><span class="price_top_left price_btm_right fl">&nbsp;</span>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="product_content_top product_content_btm fl clr"></div>
        </div>
      
  
        <!--product sidebar START-->
        <div class="product_sidebar fr">
        <!--product sidebar Bid History START-->
        	<div class="product_sidebar1 fl clr">
            	<div class="product_sidebar_tab fl">
                	<ul class="fl">
                    	<li class="fl ml10">
                        	<a href="#" title="Bid History" class="fl">
                            	<span class="fl product_sidebar_tab_left">&nbsp;</span>
                                <span class="fl product_sidebar_tab_middle pl5 pr5"><?php echo __('bid_history_label');?></span>
                                <span class="fl product_sidebar_tab_left product_sidebar_tab_right">&nbsp;</span>
                            </a>
                        </li>
                  </ul>
                </div>
            	<div class="product_sidebar_top fl clr"></div>
                <div class="product_sidebar_middle fl clr">
                	<table cellpadding="0" cellspacing="0" border="0" width="316">
                    	<tr>
                            <th width="80" align="center"><?php echo __('Price_label');?></th>
                            <th width="105" align="center"><?php echo __('Bidder_label');?></th>
                            <th width="82" align="center"><?php echo __('Date_label');?></th>
			<th width="82" align="center"><?php echo __('Bid_typelabel');?></th>
                        </tr> 
			</table>
		<!--Bid history-->
			 <div class="bid_history" id="<?php echo URL_BASE;?>auctions/bid_history/<?php echo $id;?>" style="" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div><!--End of bid history-->                      
                </div>
                <div class="product_sidebar_top product_sidebar_btm fl clr"></div>
            </div>
        
            <!--Auction News END-->   
        </div>
        <!--product sidebar START-->
    </div>
<div class="product_container fl clr pt10 ml20">
		<h2 class="product_detail_title fl clr"><?php echo __('product_description');?></h2>
		<p class="product_detail_description fl clr mt10"><?php echo $product_result['product_info'];?></p>
	</div>
    <!-- product_container END-->
    <div class="product_container fl clr mt20 pt10 ml20">
    	<div class="product_btm_content_left fl">
         <div class="yello_top"><p><?php echo __('auctions_details');?></p></div>
                <div class="yello_mid">
        	<table align="left" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<th align="left"><?php echo __('auction_id_label');?>: </th>
                	<td align="right"><p><?php echo $product_result['product_id'];?></p></td>
            	</tr>
                <tr>
                	<th align="left"><?php echo __('Auction_type_label');?> : </th>
                	<td align="right"><span><?php echo Ucfirst($product_result['typename']);?></span></td>
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
                	<th align="left"><?php echo __('price_starts_from');?>: </th>
                	<td align="right"><span><?php echo $site_currency." ".Commonfunction::numberformat($product_result['starting_current_price']);?></span></td>
            	</tr>
                <tr>
                	<th align="left"><?php echo __('start_time_label');?>: </th>
                	<td align="right"><span><?php echo Commonfunction::date_to_string($product_result['startdate']);?></span></td>
            	</tr>
                <tr>
                	<th align="left"><?php echo __('end_time_label');?>: </th>
                	<td align="right"><span><?php echo Commonfunction::date_to_string($product_result['enddate']);?></span></td>
            	</tr>
            </table>
            </div>
              <div class="yello_bot"></div>
        </div>
        <div class="shipping_detail fr">
        <div class="yello_top"><p><?php echo __('shopping_details');?></p></div>
                <div class="yello_mid">
        	<div class="shipping_title fl clr">
            	<p class="fl"><?php echo __('Shipping_fee_label');?> :</p>
                <span class="fr"><?php echo $site_currency." ".$product_result['shipping_fee'];?></span>
                </div>
                
                <div class="shipping_title fl clr">
            	<p class="fl"><?php echo __('Shipping_information_label');?> :</p>
                <span class="fr"><?php echo $product_result['shipping_info'];?></span>
                </div>
                </div>
                 <div class="yello_bot"></div>
        </div>
    </div>  
  
<?php endforeach;?>       
