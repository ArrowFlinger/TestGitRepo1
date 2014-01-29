<?php $id="";
$c_date =Commonfunction::getCurrentTimeStamp();

foreach($productsresult as $product_result):$id.= $product_result['product_id'];
//for get the buy seats count 
	$buyseat_count = Seat::get_buy_seatcount($product_result['product_id']);
	//$booked_ids = Seat::get_buy_seat_userids($product_result['product_id']);
	//end
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
<!--Map End-->
	<?php
	
    			if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB2.$product_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_result['product_image'];
					$product_full_size=URL_BASE.PRODUCTS_IMGPATH_THUMB2.$product_result['product_image'];
					$product_small_size=URL_BASE.PRODUCTS_IMGPATH_THUMB6.$product_result['product_image'];
					
				}
				else
				{
					$product_full_size=IMGPATH.NO_IMAGE;
					$product_small_size=IMGPATH.NO_IMAGE;
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?> 
            
<!-- container_inner   CLASS START-->
<div class="container_inner fl clr element<?php echo $product_result['product_id'];?> seat">
<div class="container-block">
        <div class="content-block clearfix">
                <div class="content-left-block"></div>
                <div class="content-mid-block">
                <p class="desc fl"><b><?php echo __('a');?></b><?php echo " ";?><span><?php echo __('live');?></span><?php echo " ";?><?php echo __('watch_bids_happen');?></p>
                        <div class="button-block fr">
                        <div class="show-button actives fl"><a id="show" href="javascript:;"><?php echo __('show');?></a></div>
                        <div class="hide-button button fl"><a id="hide" href="javascript:;"><?php echo __('hide');?></a></div>
                        </div>
                </div>
        <div class="content-right-block"></div>
        </div>
        <div class="fun">
        <!--Google Map-->
                <div class="fun" >
                <div id="map-canvas"></div> 
                </div>
        <!--Map End-->
        </div>
        <!-- winning msg / outbid msg -->
        <div class="reserveMessage"></div>
        <!-- end msg -->
</div>
        <div class="title-left title_temp2">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr"><?php echo __('menu_product_detail');?></h2>
        </div>
        </div>
        </div>
        <div class="action_deal_list product_action_deal_list clearfix">
         <!-- Message flash-->
           <div class="notice_nsg2 fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
        <div class="product_title">
                	<h2 class=""><?php echo Ucfirst($product_result['product_name']);?></h2>
                       </div>
    <!-- product_container START-->
    <div class="product_container fl clr ml10 mt10 auction_item re_product_container re_product_container_seat" id="auction_<?php echo $id;?>" name="<?php echo URL_BASE;?>auctions/process">
    <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
       <div class="clearfix">
    	  <div class="product_left fl">
             <div class="product_content_top fl clr"></div>
                <div class="product_content_middle fl clr">    
                    <div class="product_detail_top fl clr">
                        
                    	<div class="product_detail_top_left re_product_detail_top_left fl fl">
                        <div class="re_product-top">  </div>
                        <div class="product-middle re_product-middle clearfix">
			<div class="productDetail" style="display:none;"><?php echo $product_result['product_id'];?></div>
                        <?php if($product_result['product_featured']==FEATURED){?><span class="feature_icon_product"></span><?php } ?>
                         <div class="product_icons">
                        <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons_product" title=""></span><?php } ?>
			 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
                        <?php if($product_result['product_featured']==HOT){?><span class="hot_icon_product"></span><?php } ?>
                        <!--<span class="penny_product"></span>-->
                         <span class="seat_product"></span>
                         </div>
                         <div id="welcomeHero" class="clearfix" style="height:391px; padding:0 0 0 3px;">
		        <div id="slideshow-main">
			<ul>
				<li class="p1 active">
                                    <a class="fl lightbox" title="<?php echo ucfirst($product_result['product_name']);?>"> <img src="<?php echo $product_full_size;?>" width="361" height="285" border="0" class="fl" /><?php if($product_result['lastbidder_userid']!=0 && $product_result['product_process']=="C"){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image" style="width:auto;height:auto;" /><?php } ?></a>
				</li>
				<?php  $productimage_count = explode(",",$product_result['product_gallery']);
                                 if($product_result['product_gallery']=="") 
                                 { 
				 $no_img_path=IMGPATH.NO_IMAGE;
				 ?>
				 
				 <?php
				 }
				 else
				 {
				        $j=2;
                                        foreach($productimage_count as $productallname)
				        {
				                $product_fullimage_size=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."/thumb370x280/".$productallname; 
				                ?>
				                <li class="p<?php echo $j;?> ">
				                <a href="#">
					                <img src="<?php echo $product_fullimage_size;?>" width="370" height="284" alt=""/>
				                </a>
				                </li>
				                 <?php
				                $j++;
				        }
				}
                                ?>
			</ul>										
		</div>
		<div id="slideshow-carousel" class="clearfix">				
			  <ul id="carousel" class="jcarousel jcarousel-skin-tango clearfix">
				<li><a href="#" rel="p1"><img src="<?php echo $product_small_size;?>" width="73" height="64" alt="#" /></a></li>
				 <?php if($product_result['product_gallery']=="") { 
				 $no_img_path=IMGPATH.NO_IMAGE;
				 ?>
				 <?php
				 }
				 else
				 {
                                        $productimage_count=explode(",",$product_result['product_gallery']);
                                        $j=2;
                                                foreach($productimage_count as $productallname)
                                                {
                                                $product_fullimage_size=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb73x64/".$productallname; 
                                                ?>
                                                <li><a href="#" rel="p<?php echo $j;?>"><img src="<?php echo $product_fullimage_size;?>" width="73" height="64" alt="#"/></a></li> <?php
                                                $j++;}
                                }
                                ?>
			  </ul>
		</div>
                <div class="clear"></div>
                </div>  
        <div class="product_detail_middle_left">
        <!--watchlist message--> 
        <div id="successaddwatchlist_<?php echo $product_result['product_id'];?>" class="info_msg mt5"></div>
        <!--end of watchlist message-->
                <?php if($product_result['product_process']!=CLOSED){?>
                <div class="add_watch_list pl5">
                </div>
                <?php } ?>
		<!--Lightbox link-->
                </div>
        </div>
                              <div class="product_bottom_bg">
              
              <a href="javascript:;" class="future addwatchlist" title="Add to watchlist" rel="<?php echo $product_result['product_id'];?>"  name="<?php echo URL_BASE;?>auctions/addwatchlist"> <?php echo __('add_to_watchlist');?></a>

              </div>
               
                </div>
                <div class="product_detail_top_right fl">
                <div class="price-container" style="padding:0px;">
                        <div class="price-tl_f">                 
                        </div>
                        <div class="price-middle clearfix">
                        <table width="290" cellpadding="0" cellspacing="0" border="0" align="right" class="fl value-table1">
                        
                        <tr>
	                        <th align="right" style="color:#ed0493;"><p style="width:50px;float:right;"><?php echo __('price_label');?> : </p></th>
                            
                            <td align="left" style="color:#ed0493;"><p><span class="currentprice" style="color:#ed0493;"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".$product_result['current_price']:$product_result['current_price'];?></span><span class="price" style="display:none;"></span></p></td>
                        </tr>
                        <tr  class="bidme_link">
	                        <th align="right"><?php echo __('highest_bidder_label');?> : </th>
                            <td align="left" ><b><strong class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):ucfirst($product_result['username']);?></strong></b></td>
                        </tr>
                        <tr class="bidme_link">
	                        <td align="left" colspan="2">
                            	<div class="product_timer fl">
                                	
                                    <strong class="countdown" style="float:none;"><?php echo ($product_result['product_process']!=CLOSED)?"<img src=".IMGPATH."ajax-loader.gif>":__('closed_text');?></strong>
                                </div>
                            </td>
                        </tr>
                        
                       <?php //if($buyseat_count >= $product_result['min_seat_limit']) { ?>
                                <tr class="bidme_link" style="display:none;">
	                        <td align="right" colspan="2">
	                        <?php if($product_result['startdate']<=$c_date && $product_result['auction_process']!=HOLD):?>
                            	<div class="product_bidnow_link fl" style="display:none;">
                                	<span class="bidme_link_left bidme_link_left1 fl">&nbsp;</span>
                                    <div class="product_bidnow_middle bidme_link_middle bidme_link_middle1 fl">
							                      
		                        <?php if($product_result['product_process']==LIVE){?>
                       <a href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="bid"  rel="<?php echo URL_BASE;?>users/login?redirect=<?php echo urlencode(URL_BASE.'auctions/view/'.$product_result['product_url']);?>" id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>"><?php echo __('bid_me_label');?></a><?php }else if($product_result['product_process']==CLOSED){ ?>
                        <span id="link_<?php echo $product_result['product_id'];?>"  class="future auction_link"><?php echo __('closed_text');?></span><?php } else if($product_result['product_process']==FUTURE) { ?><span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text');?></span><?php } ?>

                                    	</div>
                                   <span class="bidme_link_left bidme_link_right bidme_link_left1 bidme_link_right1 fl">&nbsp;</span>
                                </div>
                        <?php endif;?>
<!--Loader-->
                            <div class="loader<?php echo $product_result['product_id']; ?>" style="display:none;"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
                            </td>
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"> <!--Buy Now Auction-->
			<?php //if($product_result['product_status']==LIVE){ ?> 
			<?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>
                                <div class="buy_now_button">
                                <div class="buy_now_l"></div>
                                <div class="buy_now_mid">
				<a href="<?php echo URL_BASE;?>site/buynow/buynow_addcart/<?php echo $product_result['product_id'];?>" title="<?php echo __('Buy Now');?>"><?php echo __('Buy Now');?></a>		
                                </div>
                                <div class="buy_now_r"></div>
                                </div>
			<?php endif;?>
			<?php //}?>
		       <!--End Buy Now auction--> </td></tr>
                         
                         <?php //} ?>
                                 <?php if($product_result['product_process']!=CLOSED) {  ?>
                                 <tr>
                            <td align="center" colspan="2"><p class="seat_available"><span id="bseats" class="buyseatss" ></span><b><?php echo '/'.$product_result['max_seat_limit']; ?> <?php echo __('seat_label');?></b></p></td>
                        </tr>
                                <tr class="buyseats_link">
	                        <td align="right" colspan="2">
	                        <?php if($product_result['startdate']<=$c_date && $product_result['auction_process']!=HOLD):?>
	                        <?php if($product_result['userid']!= $auction_userid){?>
                            	<div class=" fl buyseat_button " style="display:none;">
                                	<span class="bidme_link_left bidme_link_left1 product_bidnow_seat_left fl">&nbsp;</span>
                                    <div class="product_bidnow_middle bidme_link_middle bidme_link_middle1 product_bidnow_seat_middle fl">
							                      
		                        <?php if($product_result['product_process']==LIVE){?>
                        <a style="width:79px;"   href="javascript:;" name="sample" class="buy_seat fl" data-rel="seatpopup"  title="<?php echo __('buy_seats_label');?>" rel="<?php echo URL_BASE;?>users/login?redirect=<?php echo urlencode(URL_BASE.'auctions/view/'.$product_result['product_url']);?>" data-pid="<?php echo $product_result['product_id'];?>"> <?php echo __("buy_seats_label");?></a><?php }else if($product_result['product_process']==CLOSED){ ?>
                        <span id="link_<?php echo $product_result['product_id'];?>"  class="future auction_link"><?php echo __('closed_text');?></span><?php } else if($product_result['product_process']==FUTURE) { ?><span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text');?></span><?php } ?>

                                    	</div>
                                   <span class="bidme_link_left bidme_link_right bidme_link_left1 bidme_link_right1 product_bidnow_seat_right fl">&nbsp;</span>
                                </div> <?php }?>
                        <?php endif;?>
                            </td>
                        </tr>    
                          
                        <?php } else { ?>
                         <tr>   	 
                                     <td align="center" colspan="2"><span id="bseats" class="buyseatss" ></span><b style="display:block;"><?php echo $buyseat_count.'/'.$product_result['max_seat_limit']; ?> <?php echo __('seat_close_label');?></b></td>
                                </tr>
                                
				 <?php } ?>
                             
                                 
                        	
                        </table>
			<?php if($product_result['product_process']!=CLOSED){?>
                        <div class="product_detail_middle_right fl clearfix">
                        	<div class="product_share  clearfix">
                            	<p class="fl pr5"><?php echo __('share_label');?> : </p>
                                <ul class="fl clearfix">
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
                                    <li class="fl" >
		               
		                <fb:like href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none; "></fb:like>
                <!--End of facebook-->
                                    </li>
                                </ul>
                            </div>
                        </div><?php } ?>
                            </div>
                            <div class="price-tb_f"> 
                                
                        </div>
                  </div>
                     <div class="save-block fl">
                   	<div class="product_bid_price fl">
                             <div class="price-tl_f">                 
                        </div>
                          <div class="price-middle price-middle1 clearfix">
                        	<p><?php echo __('seat_with_each_bid_auction');?></p>
                            <table cellspacing="0" cellpadding="0" border="0" align="right" style="width:225px; " class="mt10 price_table">
                            <tbody><tr>
                            <th align="center"><?php echo __('with_each_bid_auction_increase_by');?></th>
                               </tr>   
                               <tr><td align="center"><p style="width:200px;color:#C5047D;"><?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?></p></td>
                            </tr>
                            	<tr>
                                	<th align="center"><?php echo __('seat_retail_price_label')?></th>
                                      </tr>   <tr> <td align="center"><p style="width:200px;color:#C5047D;"><?php echo $site_currency." ".Commonfunction::numberformat($product_result['product_cost']);?></p></td>
                                </tr>
                                <tr>
                                	<th align="center"><?php echo __('seat_price_paid_user');?></th>
                                       </tr>   <tr><td align="center"><p style="width:200px;color:#C5047D;"><span style="color:#C5047D;" class="pricepaid"><?php 
			$user_spents=$auction->winner_user_amount_spent($product_result['product_id'],$product_result['lastbidder_userid']);
                        $amount1=0;
                        foreach($user_spents as $user_spent)
                        {
                            $amount1 += $user_spent['price'];
                        }
                        echo "<b>".$site_currency." ".Commonfunction::numberformat($amount1)."</b>"; ?></span></p></td>
                                </tr>
                            </tbody></table>
                            </div>
                             <div class="price-tb_f">                 
                        </div>
                        </div>
                    	<div class="product_price_detail fl mt15">
                            <div class="save-tl">
                            <div class="save-tr">
                            <div class="save-tm">
                            </div>
                            </div>
                            </div>
                          <div class="save-middle clearfix">
                            	<div class="price_detail_cnt fl clr">
                                	<p class="clr"><?php echo __('seat_save_over_label');?></p>
                                    <label class="saveover" style="display:block; float:none; padding:0 0 7px"><font class="">$</font> 1,184.80</label>
                                    <b class="clr" style="padding:0 0 0 40px;"><?php echo __('seat_from_the_normal_retail_price_label');?></b>
                                </div>
                            </div>
                            <div class="save-bl">
                            <div class="save-br">
                            <div class="save-bm">
                            </div>
                            </div>
                            </div>
                        </div>
                        </div>
                   	 <?php /* <div class="increment_block">
                        <a href="javascript:;"  class="popup increment" title="<?php echo __('increment_label'); ?>" onClick="document.getElementById('fade1').style.display='block';
      document.getElementById('box1').style.display='block';"><?php echo __('increment_label'); ?></a>
                              <div id="fade1"></div>
                        <div class="popupbox2" id="box1">
                            <div>
                            <div class="popup_inner">
                                <div class="popup_content">
                                    <div class="pop_tl">
                                        <div class="pop_tr">
                                            <div class="pop_tm">
                                                <h2><?php echo __('increment_label'); ?></h2>
                                                <a href="javascript:;" title="close" class="re_close" onClick="document.getElementById('box1').style.display='none';
   document.getElementById('fade1').style.display='none'">close</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="popup_content_middle">
                                        <ul class="increment_list">
                                            <li>
                                                <div class="clearfix">
                                                    <p class="re_price"><b><?php echo __('price_range'); ?></b></p>
                                                    <p class="re_bid"><b><?php echo __('price_range_increment'); ?></b></p>
                                                </div>   
                                            </li> 
                                            <?php  if(isset($incrementvalues)) { 
                                            
                                            foreach($incrementvalues as $key => $increment) { ?>
                                             <li>
                                                <div class="clearfix">
                                                      <p class="re_price"><?php echo $site_currency."".$increment['minrange']; ?> - <?php echo $site_currency."".$increment['maxrange']; ?></p>
                                                    <p class="re_bid"><?php echo $site_currency."".$increment['price']; ?></p>
                                                </div> 
                                            </li>
                                            <?php  } } ?>
                                        </ul>
                                      
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
                        <div class="reserve_how"> <a href="<?php echo URL_BASE; ?>cmspage/page/how-it-works" title="<?php echo __('howit_works'); ?>" class="increment"><?php echo __('howit_works'); ?></a></div>
                        </div> */ ?>
                        </div>	
                       
                    </div>
                   
            </div>
            <div class="product_content_top product_content_btm fl clr"></div>
        </div>
        <!--product sidebar START-->
        <div class="product_sidebar fr">
            <?php //check the seat users
                       // if($booked_ids && $product_result['product_process']!=CLOSED) { ?>
                          <div class="account-left seat_user_bal_show" style="display:none;">
                                <div class="account-right">
                                      <div class="account-mid">
                                           <div class=""><p class="fl">  <?php echo __('user_bal_label');?> : </p>
                                            <p><span class="user_seat_amount" ></span></p>
                                      </div>
                                </div>
                          </div>
                          </div>
                        <?php //} ?>
        <!--product sidebar Bid History START-->
        	<div class="product_sidebar1 fl clr">
            	<div class="product_sidebar_tab fl">
                	<ul class="clearfix">
                    	<li class="fl active">
                        	 <span class="fl product_sidebar_tab_left">&nbsp;</span>
                                <span class="fl product_sidebar_tab_middle pl5 pr5"><?php echo __('bid_history_label');?></span>
                                <span class="fl product_sidebar_tab_left product_sidebar_tab_right">&nbsp;</span>
                         </li>
                      
                  </ul>
                </div>
                <div class="bid-block clearfix fl">
            
                <div class="product-middle1 clearfix">
                	<table cellpadding="0" cellspacing="0" border="0" width="284" class="bidding-table">
                    	 <tr>
                  <th width="100" style="width:86px; word-wrap:break-word !important;display:block; float:left;"  align="center"><?php echo __('Price_label');?></th>
                  <th width="100"  style="width:85px; word-wrap:break-word !important;display:block; float:left;" align="center"><?php echo __('Bidder_label');?></th>
                  <th width="100" style="width:87px; word-wrap:break-word !important;display:block; float:left;"  align="center" style="width:60px;"><?php echo __('Date_label');?></th>
                  
                </tr>
			</table>
		<!--Bid history-->
			 <div class="bid_history" id="<?php echo URL_BASE;?>site/seat/bid_history/<?php echo $id;?>" style="float:left; width:250px;" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div><!--End of bid history-->                      
                </div>
              
            </div>
        </div>
        <!--product sidebar START-->
    </div>
  </div>
<div class="product_container product_desc clr pt10">
    <h2 class="product_detail_title product_detail_title1"><?php echo __('product_description');?></h2>
		<p class="product_detail_description"><?php echo $product_result['product_info'];?></p>
	</div>
    <!-- product_container END-->
    <div class="product_container product_container1 fl clr mt20 pt10">
    	<div class="product_btm_content_left fl">
        <div class="title-left">
    <div class="title-right">
    <div class="title-mid">
    <h2 class="product_detail_title"><?php echo __('auctions_details');?></h2>
    </div>
    </div>
    </div>
        	<table align="left" cellpadding="0" cellspacing="0" border="0" width="310">
            	<tr>
                	<th align="left"><?php echo __('auction_id_label');?>: </th>
                	<td align="right"><p><?php echo $product_result['product_id'];?></p></td>
            	</tr>
                <tr>
                	<th align="left"><?php echo __('Auction_type_label');?> : </th>
                	<td align="right"><span><?php echo Ucfirst($product_result['typename']);?></span></td>
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
              <div class="border_bottom_tab"></div>
        </div>
        <div class="product_btm_content_middle fl">
         <div class="title-left">
    <div class="title-right">
    <div class="title-mid">
    <h2 class="product_detail_title"><?php echo __('price_details');?></h2>
    </div>
    </div>
    </div>
        	<table align="right" cellpadding="0" cellspacing="0" border="0" width="310" class="fl">
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
              <div class="border_bottom_tab"></div>
        </div>
      
        <div class="shipping_detail fl">
        <div class="title-left">
    <div class="title-right">
    <div class="title-mid">
    <h2 class="product_detail_title"><?php echo __('shopping_details');?></h2>
    </div>
    </div>
    </div>
    <div class="shopping-block clearfix">
        	<div class="shipping_title fl clr">
            	<p class="fl"><?php echo __('Shipping_fee_label');?> :</p>
                <span class="fr"><?php echo  $site_currency." ".$product_result['shipping_fee'];?></span>
            </div>
            
            <div class="shipping_title fl clr" style="border-bottom:0;">
            	<p class="fl"><?php echo __('Shipping_information_label');?> :</p>
                <span class="fr"><?php echo trim($product_result['shipping_info'])!=""?$product_result['shipping_info']:"-";?></span>
            </div>
            
            </div>
              <div class="border_bottom_tab"></div>
        </div>

    </div>    
    </div>
    </div>
    <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
<!--Modal Window-->

<div id="fade"></div>
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
                                                    <p class="res_label"><?php echo __('price_label');?> </p><span>:</span><p><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".Commonfunction::numberformat($product_result['current_price']):Commonfunction::numberformat($product_result['current_price']);?></p>
                                                </div>
                                                <div class="content_info clearfix">
                                                    <p class="res_label"><?php echo __('your_bid_label');?></p><span>:</span><p><span id="sample"></span></p>
                                                </div>
                                          
	                               <div class="re_confirm clearfix">
                                           <div href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="re_confrim_bid reservebid"  rel="<?php echo URL_BASE;?>users/login/" id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>">
                                               <button><?php echo __('confirm_bid_me_label');?></button>
                                           </div>
                                            <div href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="re_cancel_bid cancel_reserve"  rel="<?php echo URL_BASE;?>users/login/" id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>">
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




<?php endforeach;?>    

<script type="text/javascript">

		
//login check when bidding
	if(!$(".user").html())
		{
	$("#dialog_link").mouseover(function(){
		$(this).html(language.login_labels);
		$(this).click(function(){
			window.location=$(this).attr("rel");
		});
	});
	$("#dialog_link").mouseout(function(){
		$(this).html(language.bid_me_label);
	});
	}
	//end
	
// Dialog	
	 
	$("#yourbidding").keyup(function(){
	$(this).val()!=""?$(this).css({'border-color':'#ccc'}):"";});
	if($(".user").html())
		{
	$('#dialog_link').click(function(){
	if($('#yourbidding').val()!="")
	{
	
		$('#dialog').dialog('open');
		$('#sample').text($('#yourbidding').val());
	}else
	{ 
	  $("#yourbidding").css({'border':'1px solid red'});
	}
		return false;
		
	});
	}
	
</script>   


<script type="text/javascript">
//For Photo View Using Lightbox
    //=============================

    jQuery(function($) {
    	$(".savetext").ForceNumericOnly(true);
    });
    
    //validation for text box amount enter
	jQuery.fn.ForceNumericOnly =
	function(digitonly)
	{
	    var dot = digitonly || false; 
	    return this.each(function()
	    {
	
		$(this).keydown(function(e)

		{ 
		    
		    var key = e.charCode || e.keyCode || 0;
		    // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
		    if(!dot)
		    {
			return (
			    key == 8 || 
			    key == 9 ||
			    key == 46 ||
			    key == 36 || key == 35 ||
			    (key >= 37 && key <= 40) ||
			    (key >= 48 && key <= 57) ||
			    (key >= 96 && key <= 105));
		    }
		    else
		    {
			//Need deciaml point
			return (
			    key == 8 ||
			    key == 190 ||
			    key == 110 ||
			    key == 9 ||
			    key == 46 ||
			    key == 36 || key == 35 ||
			    (key >= 37 && key <= 40) ||
			    (key >= 48 && key <= 57) ||
			    (key >= 96 && key <= 105));
		    }
		});
	    });
	};
    
</script>
<!-- container_inner   CLASS END-->
