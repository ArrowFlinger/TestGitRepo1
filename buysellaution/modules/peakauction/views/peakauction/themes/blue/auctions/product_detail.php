<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript" src="<?php echo URL_BASE;?>public/js/jquery.jcarousel.pack.js"> </script>
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE;?>public/blue/css/skin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE;?>public/blue/css/slidder-css/jquery.jcarousel.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE;?>public/blue/css/slidder-css/skin.css"/>
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
			vertical: true,
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
<?php $id=""; 
$c_date =Commonfunction::getCurrentTimeStamp();
foreach($productsresult as $product_result):
$id.= $product_result['product_id'];
?>


<!--Map-->
<style type="text/css"> 
      #map-canvas {
        width: 960px;
        height: 190px
      }
	   .price_table{ border:1px solid #E2E1E1; border-bottom:0px;background:#E8E8E8; }
	  .price_table td{ border-bottom:1px solid #D9D7D7; }
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
					$product_img_path=IMGPATH.NO_IMAGE;
					$product_small_size=IMGPATH.NO_IMAGE;
					
				}
			?> 
 
<!-- container_inner   CLASS START-->
<div class="container_inner fl clr element<?php echo $product_result['product_id'];?>">
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
	<div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr"><?php echo __('menu_product_detail');?></h2>
        </div>
        </div>
        </div>
	<div class="deal-left clearfix">
	<div class="action_deal_list product_action_deal_list clearfix">
        <div class="product_title">
        <h2 class=""><?php              
        echo ucfirst($product_result['product_name']);?></h2>
        </div>
	<!-- product_container START-->
    <div class="product_container clr mt15 auction_item" id="auction_<?php echo $id;?>" name="<?php echo URL_BASE;?>auctions/process">
    <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>	
       <div class="clearfix">
          <div class="top-block clearfix">
              <div class="slide-block fl">	
                        <div class="product-tl">
                        <div class="product-tr">
                        <div class="product-tm">
                        </div>
                        </div>
                        </div>
                    <div class="product-middle clearfix">
			<div class="productDetail" style="display:none;"><?php echo $product_result['product_id'];?></div>
                         <div class="product_feature_outer">
                        <?php if($product_result['product_featured']==FEATURED){?><span class="feature_icon_product"></span><?php } ?>
                        <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons_product" title=""></span><?php } ?>
			 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
                        <?php if($product_result['product_featured']==HOT){?><span class="hot_icon_product"></span><?php } ?>
                         <span class="peak_icon_product"></span>
                         </div>
     <div id="welcomeHero">
		<div id="slideshow-main">
			<ul>
				<li class="p1 active">
					<a class="fl lightbox" title="<?php echo ucfirst($product_result['product_name']);?>"> <img src="<?php echo $product_full_size;?>" width="365" height="285" border="0" class="fl" /><?php if($product_result['product_process']=="C" && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.PRODUCTSOLD_IMAGE;?>"class="sold_image"/><?php } ?></a>
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
		<div id="slideshow-carousel">				
			  <ul id="carousel" class="jcarousel jcarousel-skin-tango">
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
                    <a href="javascript:;" class="future addwatchlist" title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>"  name="<?php echo URL_BASE;?>auctions/addwatchlist"><?php echo __('add_to_watchlist');?></a>
                </div>
                <?php } ?>
		<!--Lightbox link-->
                </div>
        </div>
                <div class="product-bl">
                <div class="product-br">
                <div class="product-bm">
                </div>
                </div>
                </div>
                </div>
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
            	<div class="product-tl" style="background:none; border-left:1px solid #E2E1E1;">
                        <div class="product-tr">
                        <div class="product-tm">
                        </div>
                        </div>
                        </div>
                <div class="product-middle clearfix">
                	<ul class="bidding-table clearfix">
                            <li class="fl" style="width:100px;"><?php echo __('Price_label');?></li>
                            <li class="fl" style="width:100px;"><?php echo __('Bidder_label');?></li>
                            <li class="fl" style="width:130px;"><?php echo __('Date_label');?></li>
			     <li class="fl" style="width:80px;"><?php echo __('Bid_typelabel');?></li>
			</ul>
		<!--Bid history-->
			 <div class="bid_history" id="<?php echo URL_BASE;?>auctions/bid_history/<?php echo $id;?>" style="" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div><!--End of bid history-->                      
                </div>
               <div style="border-top:1px solid #ddd;" >
                        
                        </div>
            </div>
        </div>
        <!--product sidebar START-->
    </div>
    </div>
    <div class="product_detail_top_right clearfix">
                <div class="price-container fl">
                        <div class="price-tl">
                        <div class="price-tr">
                        <div class="price-tm">
                        </div>
                        </div>
                        </div>
                        <div class="price-middle clearfix">
                        <ul class="timer-list">
                        <li class="roming"><p class="fl" style="font-size:14px; font-weight:bold;color:#E37C00;  text-align:center;"><?php echo __('price_label');?> :</p><p class="fl"  style="font-size:14px; font-weight:bold;"><span class="currentprice" style="color:#E37C00;"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".$product_result['current_price']:$product_result['current_price'];?></span><span class="price" style="display:none;"></span></p></li>
                       
                        <li> <p class="fl" style="font-size:14px; font-weight:bold;  margin:0 0 0 10px;"><?php echo __('highest_bidder_label');?>:</p><p class="fl" style="font-size:14px; font-weight:bold;"><b><strong class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):ucfirst($product_result['username']);?></strong></b></p> </li>
                        
                        <li style="padding:5px 0 0 0;"><div class="product_timer fl">
                                        <strong class="countdown"><?php echo ($product_result['product_process']!=CLOSED)?"<img src=".IMGPATH."ajax-loader.gif>":__('closed_text');?></strong>
                                </div></li>
                                <li>  <?php if($product_result['startdate']<=$c_date && $product_result['auction_process']!=HOLD):?>
                        <div class="product_bidnow_link fl">
	                        <span class="bidme_link_left bidme_link_left1 fl">&nbsp;</span>
                                <div class="product_bidnow_middle bidme_link_middle bidme_link_middle1 fl">
	                        <div class="user" style="display:none;" ><?php //echo $user;?></div>
                                <?php if($product_result['product_process']==LIVE){?>
                        <a href="javascript:;" id="<?php echo $product_result['product_id'];?>" name="<?php echo URL_BASE;?>auctions/bid" class="bid"   rel="<?php echo URL_BASE;?>users/login/" data-auctiontype="<?php echo $product_result['auction_type'];?>"><?php echo __('bid_me_label');?></a><?php }else if($product_result['product_process']==CLOSED){ ?>
                        <span id="link_<?php echo $product_result['product_id'];?>"  class="future auction_link"><?php echo __('closed_text');?></span><?php } else if($product_result['product_process']==FUTURE) { ?><span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text');?></span><?php } ?>
                           </div>
                           <span class="bidme_link_left bidme_link_right bidme_link_left1 bidme_link_right1 fl">&nbsp;</span>
                        </div>
                        <?php endif;?></li>
                        </ul>
			 <?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>	

				 <div class="buy_now_l"></div>
                            <div class="buy_now_mid">
				<a href="<?php echo URL_BASE;?>site/buynow/buynow_addcart/<?php echo $product_result['product_id'];?>" title="<?php echo __('buy_now');?>"><?php echo __('buy_now');?></a>		
                            </div>
                            <div class="buy_now_r"></div>
			
			<?php endif;?>
			<?php if($product_result['product_process']!=CLOSED){?>
                        <div class="product_detail_middle_right fl clearfix">
                        	<div class="product_share  clearfix">
                            	
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
                                    <li class="fl">
		                <!--Facebook-->		               		
		                <fb:like href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"></fb:like>
                <!--End of facebook-->
                                    </li>
                                </ul>
                            </div>
                        </div><?php } ?>
                            </div>
                            <div class="price-bl">
                            <div class="price-br">
                            <div class="price-bm">
                            </div>
                            </div>
                            </div>
                  </div>
                  <div class="save-block fl">
                   	<div class="product_bid_price fl">
                            <div class="price-tl">
                            <div class="price-tr">
                            <div class="price-tm">
                            </div>
                            </div>
                            </div>
                          <div class="price-middle clearfix">
                        	<p><?php echo __('with_each_bid');?></p>
                            <table cellpadding="0" cellspacing="0" border="0" align="right" class="mt10   price_table" style="width:234px; ">
                            <tr>
                            <th align="center"><?php echo __('price_increases_by_label');?></th>
                               </tr>   
                               <tr><td align="center"><p style="width:200px;color:#E37C00;"><?php echo $site_currency." ".$product_result['bidamount'];?></p></td>
                            </tr>
                            	<tr>
                                	<th align="center"><?php echo __('retail_price_label')?></th>
                                      </tr>   <tr> <td align="center"><p  style="width:200px;color:#E37C00;"><?php echo $site_currency." ".Commonfunction::numberformat($product_result['product_cost']);?></p></td>
                                </tr>
                                <tr>
                                	<th align="center"><?php echo __('price_paid_user');?> </th>
                                       </tr>   <tr><td align="center"><p  style="width:200px;color:#E37C00;"><span class="pricepaid" style="color:#E37C00;"> <?php 
			$user_spents=$auction->winner_user_amount_spent($product_result['product_id'],$product_result['lastbidder_userid']);
                        $amount1=0;
                        foreach($user_spents as $user_spent)
                        {
                            $amount1 += $user_spent['price'];
                        }
                        echo "".$site_currency." ".Commonfunction::numberformat($product_result['current_price'])."";
                        ?></span></p></td>
                                </tr>
                            </table>
                            </div>
                             <div class="price-bl">
                            <div class="price-br">
                            <div class="price-bm">
                            </div>
                            </div>
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
                                	<p class="clr"><?php echo __('save_over_label');?></p>
                                    <label  style="display:block; float:none; padding:0 0 7px" class="saveover">
                                    	<?php  $saveover=$product_result['product_cost'] - $product_result['current_price'];
					echo ($saveover>0)? $site_currency." ".Commonfunction::numberformat($saveover):$site_currency." ". 0;?>
                                    </label>
                                    <b class="clr"><?php echo __('from_the_normal_retail_price_label');?> </b >
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
                        <div class="product_desc fl">  
                            <div class="title-left1">
                            <div class="title-right1">
                            <div class="title-mid1">
                            <h2 class="product_detail_title product_detail_title1"><?php echo __('product_description');?></h2>
                            </div>
                            </div>
                            </div>
		                 <div class="price-middle clearfix"><p class="product_detail_description"><?php echo $product_result['product_info'];?></p></div>
                          <div class="price-bl">
                            <div class="price-br">
                            <div class="price-bm">
                            </div>

                            </div>
                            </div>
                       	</div>
                        </div>  
                    <!-- Message flash-->
           <div class="notice_nsg2 fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> 
           <!-- end of Message flash-->
          <!--product sidebar START-->
    </div>
    <!-- product_container END-->
    <div class="product_container product_container1 fl clr mt20 pt10">
    	<div class="product_btm_content_left fl">
        <div class="title-left1">
    <div class="title-right1">
    <div class="title-mid1">
    <h2 class="product_detail_title"><?php echo __('auctions_details');?></h2>
    </div>
    </div>
    </div>
    <div class="table-block" style="border-bottom:0px;">
        	<table align="left" cellpadding="0" cellspacing="0" border="0" width="298">
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
        </div>
        <div class="product_btm_content_middle fl">
         <div class="title-left1">
    <div class="title-right1">
    <div class="title-mid1">
    <h2 class="product_detail_title"><?php echo __('price_details');?></h2>
    </div>
    </div>
    </div>
     <div class="table-block" style="border-bottom:0px;">
        	<table align="right" cellpadding="0" cellspacing="0" border="0" width="298">
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
        </div>
        <div class="shipping_detail fl">
        <div class="title-left1">
    <div class="title-right1">
    <div class="title-mid1">
    <h2 class="product_detail_title"><?php echo __('shopping_details');?></h2>
    </div>
    </div>
    </div> 
    <div class="table-block">
    <div class="shopping-block clearfix">
        	<div class="shipping_title fl clr">
            	<p class="fl"><?php echo __('Shipping_fee_label');?> :</p>
                <span class="fr"><?php echo $site_currency." ".$product_result['shipping_fee'];?></span>
                </div>
                
                <div class="shipping_title fl clr">
            	<p class="fl"><?php echo __('Shipping_information_label');?> :</p>
                <span class="fr"><?php echo $product_result['shipping_info'];?></span>
                </div>
           </div>
            </div>
        </div>
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
