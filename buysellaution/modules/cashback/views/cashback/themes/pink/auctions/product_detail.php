<?php $id="";
$c_date =Commonfunction::getCurrentTimeStamp();

foreach($productsresult as $product_result):$id.= $product_result['product_id'];?>
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
					$product_full_size=IMGPATH.NO_IMAGE;
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?> 
            
<!-- container_inner   CLASS START-->
<div class="container_inner fl clr element<?php echo $product_result['product_id'];?> cashback">
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
</div>
        <div class="title-left title_temp2">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr"><?php echo __('menu_product_detail');?></h2>
        </div>
        </div>
        </div>
        <div class="action_deal_list product_action_deal_list clearfix">
        <div class="product_title">
        <h2 class=""><?php              
        echo ucfirst($product_result['product_name']);?></h2>
        </div>
    <!-- product_container START-->
    <div class="product_container fl clr ml10 mt20 auction_item" id="auction_<?php echo $id;?>" name="<?php echo URL_BASE;?>auctions/process">
    <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
       <div class="clearfix">
    	  <div class="product_left  ml10 fl">
             <div class="product_content_top fl clr"></div>
                <div class="product_content_middle fl clr">    
                    <div class="product_detail_top fl clr">
                    	<div class="product_detail_top_left fl">
                        <div class="product-tl">
                        <div class="product-tr">
                        <div class="product-tm">
                        </div>
                        </div>
                        </div>
                    <div class="product-middle clearfix">
			<div class="productDetail" style="display:none;"><?php echo $product_result['product_id'];?></div>
                        <?php if($product_result['product_featured']==FEATURED){?><span class="feature_icon_product"></span><?php } ?>
                         <div class="product_icons">
                        <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons_product" title=""></span><?php } ?>
			 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
                        <?php if($product_result['product_featured']==HOT){?><span class="hot_icon_product"></span><?php } ?>
                        <span class="cashback_product"></span>
                         </div>
                         <div id="welcomeHero" class="clearfix" style="height:391px; padding:0 0 0 3px;">
		        <div id="slideshow-main">
			<ul>
				<li class="p1 active">
					<a class="fl lightbox" title="<?php echo ucfirst($product_result['product_name']);?>"> <img src="<?php echo $product_full_size;?>" width="361" height="285" border="0" class="fl" /><?php if($product_result['lastbidder_userid']!=0 && $product_result['product_process']=="C"){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image"/><?php } ?></a>
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
				                $product_fullimage_size=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150.$productallname; 
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
              
              <a href="javascript:;" class="future addwatchlist" title="Add to watchlist" rel="<?php echo $product_result['product_id'];?>"  name="<?php echo URL_BASE;?>auctions/addwatchlist"><?php echo __('add_to_watchlist');?></a>
              </div>
               
                </div>
                <div class="product_detail_top_right fr">
                <div class="price-container">
                        <div class="price-tl_f">                 
                        </div>
                        <div class="price-middle clearfix">
                        <table width="290" cellpadding="0" cellspacing="0" border="0" align="right" class="fl value-table1">
                        <tr>
	                        <th align="right" style="color:#ed0493;"><p style="width:50px;"><?php echo __('price_label');?> : </p></th>
                            
                            <td align="left" style="color:#ed0493;"><p><span class="currentprice" style="color:#ed0493;"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".$product_result['current_price']:$product_result['current_price'];?></span><span class="price" style="display:none;"></span></p></td>
                        </tr>
                        <tr>
	                        <th align="right"><?php echo __('highest_bidder_label');?> : </th>
                            <td align="left" ><b><strong class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):ucfirst($product_result['username']);?></strong></b></td>
                        </tr>
                        <tr>
	                        <td align="left" colspan="2">
                            	<div class="product_timer fl">
                                	
                                    <strong class="countdown"><?php echo ($product_result['product_process']!=CLOSED)?"<img src=".IMGPATH."ajax-loader.gif>":__('closed_text');?></strong>
                                </div>
                            </td>
                        </tr>
                        <tr>
	                        <td align="right" colspan="2">
	                        <?php if($product_result['startdate']<=$c_date && $product_result['auction_process']!=HOLD):?>
                            	<div class="product_bidnow_link fl">
                                	<span class="bidme_link_left bidme_link_left1 fl">&nbsp;</span>
                                    <div class="product_bidnow_middle bidme_link_middle bidme_link_middle1 fl">
							                      
		                        <?php if($product_result['product_process']==LIVE){?>
                        <a href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="bid" title="<?php //echo $error;?>"   rel="<?php echo URL_BASE;?>users/login?redirect=<?php echo urlencode(URL_BASE.'auctions/view/'.$product_result['product_url']);?>"  id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>"><?php echo __('bid_me_label');?></a><?php }else if($product_result['product_process']==CLOSED){ ?>
                        <span id="link_<?php echo $product_result['product_id'];?>"  class="future auction_link"><?php echo __('closed_text');?></span><?php } else if($product_result['product_process']==FUTURE) { ?><span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text');?></span><?php } ?>

                                    	</div>
                                   <span class="bidme_link_left bidme_link_right bidme_link_left1 bidme_link_right1 fl">&nbsp;</span>
                                </div>
                        <?php endif;?>
                            </td>
                        </tr> 
                        <tr><td align="center" colspan="2"> <!--Buy Now Auction-->
			<?php //if($product_result['product_status']==LIVE){ ?> 
			<?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>	

				<a href="<?php echo URL_BASE;?>site/buynow/buynow_addcart/<?php echo $product_result['product_id'];?>" title="<?php echo __('Buy Now');?>"><img src="<?php echo IMGPATH;?>buynow_2.png"></a>		
			
			<?php endif;?>
			<?php //}?>
		       <!--End Buy Now auction--> </td></tr>	
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
                            <div class="price-tl_f">                 
                        </div>
                  </div>
                   	<div class="product_bid_price fl mt15">
                          <div class="price-tl_f">                 
                        </div>
                          <div class="price-middle clearfix">
                        	<p><?php echo __('with_each_bid');?></p>
                            <table cellpadding="0" cellspacing="0" border="0" align="right" class="mt10   price_table" style="width:240px; ">
                            <tr>
                            <th align="center"><?php echo __('price_increases_by_label');?></th>
                               </tr>   <tr><td align="center"><p style="width:200px; color:#BB006F;"><?php echo $site_currency." ".$product_result['bidamount'];?></p></td>
                            </tr>
                            	<tr>
                                	<th align="center"><?php echo __('retail_price_label')?></th>
                                      </tr>   <tr> <td align="center"><p  style="width:200px; color:#BB006F;"><?php echo $site_currency." ".$product_result['product_cost'];?></p></td>
                                </tr>
                                <tr>
                                	<th align="center"><?php echo __('price_paid_user');?> </th>
                                       </tr>   <tr><td align="center"><p  style="width:200px; color:#BB006F;"><span class="pricepaid" style="color:#BB006F;"> <?php 
			
                        echo "".$site_currency." ".$product_result['current_price']."";
                        ?></span></p></td>
                                </tr>
                            </table>
                            </div>
                        <div class="price-tl_f">                 
                        </div>
                        </div>
                    	<div class="product_price_detail fl mt15">
                           <div class="price-tl_f">                 
                        </div>
                          <div class="save-middle clearfix">
                            	<div class="price_detail_cnt fl clr">
                                	<p class="fl clr mt5"><?php echo __('save_over_label');?></p>
                                    <label class="mt10 saveover" style="display:block;">
                                    	<?php  $saveover=$product_result['product_cost'] - $product_result['current_price'];
						echo ($saveover>0)? $site_currency." ".$saveover:$site_currency." ". 0;?>
                                    </label>
                                    <b class="fl clr mt10"><?php echo __('from_the_normal_retail_price_label');?> </b >
                                </div>
                            </div>
                            <div class="price-tl_f">                 
                        </div>
                        </div>
                        </div>	
                    </div>
                    <!-- Message flash-->
           <div class="notice_nsg2 fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
            </div>
            <div class="product_content_top product_content_btm fl clr"></div>
        </div>
        <!--product sidebar START-->
        <div class="product_sidebar fr">
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
                            <th width="100" align="center"><?php echo __('Price_label');?></th>
                            <th width="100" align="center"><?php echo __('Bidder_label');?></th>
                            <th width="100" align="center"><?php echo __('Date_label');?></th>
			    <th width="82" align="center"><?php echo __('Bid_typelabel');?></th>	
                        </tr> 
			</table>
		<!--Bid history-->
			 <div class="bid_history" id="<?php echo URL_BASE;?>auctions/bid_history/<?php echo $id;?>" style="float:left; width:250px;" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div><!--End of bid history-->                      
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
                	<td align="right"><span><?php echo __('cashback_auction_label');?></span></td>
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
        	<table align="right" cellpadding="0" cellspacing="0" border="0" width="310">
            	 <tr>
                	<th align="left"><?php echo __('price_starts_from');?>: </th>
                	<td align="right"><span><?php echo $site_currency." ".$product_result['starting_current_price'];?></span></td>
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
                <span class="fr"><?php echo $product_result['shipping_info'];?></span>
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
<?php endforeach;?>
<!-- container_inner   CLASS END-->
