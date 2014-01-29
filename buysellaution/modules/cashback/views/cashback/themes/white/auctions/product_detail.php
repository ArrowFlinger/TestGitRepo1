<?php
 $id="";
$c_date =Commonfunction::getCurrentTimeStamp();

foreach($productsresult as $product_result):
$id.= $product_result['product_id']; 
?>
<div class="container_inner element<?php echo $product_result['product_id'];?>">
<div class="auction_item" id="auction_<?php echo $id;?>" name="<?php echo URL_BASE;?>auctions/process">
	<div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
<div class="banner_inner" id="detail_page">

<div class="signup_head">
<ul>
<li><a href="<?php echo URL_BASE;?>" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
<li><a href="#" title="arr_bg"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
<li class="active"><a href="#" title="<?php echo ucfirst($product_result['product_name']);?>"><?php echo ucfirst($product_result['product_name']);?></a></li>
</ul>
</div>

<!--detail page start-->
	
    <div class="detail_page_top">  
    
    <h1 class="detail_title"><?php echo ucfirst($product_result['product_name']);?></h1>
    	<div class="detail_page_top_left">
    	<?php 
		if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB2.$product_result['product_image']))
		{ 
		$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB2.$product_result['product_image'];
		$product_full_size=URL_BASE.PRODUCTS_IMGPATH.$product_result['product_image'];
		}
		else
		{
		$product_full_size=IMGPATH.NO_IMAGE;
		$product_img_path=IMGPATH.NO_IMAGE;

		}
		?>
        	
			<!---slide_show-->
			<div id="slide_container">

	
	<div id="slide_content">
	
		<div id="slider">
			<ul>							
			
				<li><a href="#" title="<?php echo ucfirst($product_result['product_name']);?>"> <img src="<?php echo $product_img_path; ?>" width="353" height="297" alt="1" /></a><?php if($product_result['product_process']==CLOSED  && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image"/><?php } ?></li>
			<?php	
			    $product_gallery=$product_result['product_gallery'];
			    if($product_gallery!=''){
				$product_images=explode(",",$product_gallery);
				foreach($product_images as $product_image)
				{
				?>
				
				<li><a href="#" title="<?php echo ucfirst($product_result['product_name']);?>"> <img src="<?php echo URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."/thumb370x280/".$product_image; ?>" width="353" height="297" alt="3" /></a></li>	
				<?php } }?>	
			</ul>
		</div>
	</div>
</div>
			<!--slide_show-->
            <div class="detail_left_feature_tag">
            
            </div>
          <div class="productDetail" style="display:none;"><?php echo $product_result['product_id'];?></div>  
            
            <div class="detail_feature_bott_lft">
            <div class="sliders">
             <div title="<?php echo __('cashback_auction_label');?>" class="cash"></div>
			 <?php if($product_result['product_featured']==HOT){?>
			<a><img src="<?php echo IMGPATH;?>head_top4_bg.png" width="14" height="19" alt="<?php echo __('hot_label'); ?>"  title="<?php echo __('hot_label'); ?>"  /></a>
			<?php }?>
			
			 <?php  if($product_result['dedicated_auction']==ENABLE){?>
			<a><img src="<?php echo IMGPATH;?>head_top5_bg.png" width="19" height="19" alt="<?php echo __('bonus_label'); ?>"  title="<?php echo __('bonus_label'); ?>"/></a>
			<?php }?>
			</div>
              <a title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist"><img src="<?php echo IMGPATH;?>plus_bg.png" width="24" height="25" alt="<?php echo __('add_to_watchlist'); ?>" /></a>
             </div>
             
             <div class="detail_left_social_link">
            <?php if($product_result['product_process']!=CLOSED){?>
             <div class="social_sec">
			 <p><?php echo __('share_label');?> :</p>
			 	<?php $url=URL_BASE."auctions/view/".$product_result['product_url'];
					?>
			 <g:plusone size="medium" annotation="none"></g:plusone>
			     <script type="text/javascript">
                        (function()
                        {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                        })();
                        </script>
                        <a href="http://twitter.com/share?url=<?php echo $url;?>&amp;text=<?php echo $product_result['product_name'];?>" target="_blank"  title="Twitter" class="fl">
                                            <img src="<?php echo IMGPATH;?>s2.png" alt="Twitter" border="0" class="fl"s/>
                                        </a>
			 

			 
			 			<a href="https://www.facebook.com/sharer.php?u=<?php echo $url;?>&t=<?php echo $product_result['product_name'];?>" title="Facebook" class="fl" target="_blank">
                                            <img src="<?php echo IMGPATH;?>s3.png" alt="Facebook" border="0" />
                                        </a>
			
		                <fb:like href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"></fb:like>
			 </div>
			 <?php }?>
             </div>
           
        
        </div>


    	<div class="detail_page_top_mid">
        
        <div class="detail_big_history"><h1><?php echo __('bid_history_label');?></h1>  </div>
       
       <div class="bid_history" id="<?php echo URL_BASE;?>auctions/bid_history/<?php echo $id;?>" style="" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>
       
    
        
        
        
        </div>


    	<div class="detail_page_top_right">

		<div class="hb_bg_mid">
			<ul class="clearfix">
				<li><p><span><?php echo __('highest_bidder_label');?> :</span> <strong class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):ucfirst($product_result['username']);?></strong></p></li>	
				<li><h3 class="countdown"><?php echo ($product_result['product_process']!=CLOSED)?"<img src=".IMGPATH."ajax-loader.gif>":__('closed_text');?></h3>
					<label style=" float:left;padding-left:72px;display:block;color:#666;"><span class="hrs"><?php echo __('days_label'); ?></span><span class="min"><?php echo __('hrs_label'); ?></span><span class="min"><?php echo __('min_label'); ?></span><span class="sec"><?php echo __('sec_label'); ?></span></label>
				
				</li>
                                	
				<li>
					<div class="hb_buy_now_left">
						<h3 class="currentprice"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".Commonfunction::numberformat($product_result['current_price']):$product_result['current_price'];?></h3> 
						<span class="price" style="display:none;"></span>
					</div>
					<?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>	
					<div class="hb_buy_now_right">
						<div class="hb_buy_now_button">
							<div class="hb_buy_now_button_left">
							</div>
							<div class="hb_buy_now_button_mid">
								<p>
								<a href="<?php echo URL_BASE;?>site/buynow/buynow_addcart/<?php echo $product_result['product_id'];?>" title="<?php echo __('buy_now');?>"><?php echo __('buy_now');?></a>
								
								</p>
							</div>
							<div class="hb_buy_now_button_right">
							</div>
						</div>
					</div>

					<?php endif;?>
				</li>
				<?php if($product_result['startdate']<=$c_date && $product_result['auction_process']!=HOLD):?>
				<li>
				   <div class="bidme_link">
					<div class="hb_buy_now_left">
						<?php /*<div class="hb_place_bid">
							<span>$&nbsp;</span>
							<div class="hb_place_bid_tb">
								<input type="text" value="" />
							</div>
							<span>&nbsp;.00</span>
						</div>*/?>
						
					</div>
					<div class="hb_buy_now_right">
						<div class="hb_place_bid_button">
							<div class="hb_place_bid_button_left">
							</div>
							<div class="hb_place_bid_button_mid">
							
                             <p>   <?php if($product_result['product_process']==LIVE){?>
                        <a href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="bid" rel="<?php echo URL_BASE;?>users/login/" id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>" title="<?php echo __('place_my_bid_label');?>"><?php echo __('place_my_bid_label');?></a><?php }else if($product_result['product_process']==CLOSED){ ?>
                       <strong id="link_<?php echo $product_result['product_id'];?>"  ><?php echo __('closed_text');?></strong><?php } else if($product_result['product_process']==FUTURE) { ?><strong style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text');?></strong><?php } ?>
					</p>			
							</div>
							<div class="hb_place_bid_button_right">
							</div>
						</div>
					</div>
					</div>
				</li>
				<?php endif;?>
				<li class="border_none">
					<div class="hb_auction_header">
						<p><?php echo __('with_each_bid');?></p>
					</div>
				</li>
				<li class="hb_li_padding_bottom_none">
					<div class="hb_buy_now_left">
						<p class="hb_font_weight_normal"><?php echo __('price_increases_by_label');?></p>
					</div>
					<div class="hb_buy_now_right hb_buy_now_right1">
						<span class="hb_font_size_small"><p  class="bidamount"><?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?></p></span>
					</div>
					
				</li>
				
				<li class="hb_li_padding_bottom_none">
					<div class="hb_buy_now_left">
						<p class="hb_font_weight_normal"><?php echo __('retail_price_label')?></p>
					</div>
					<div class="hb_buy_now_right hb_buy_now_right1">
						<p class="hb_font_size_small"><?php echo $site_currency." ".Commonfunction::numberformat($product_result['product_cost']);?></p>
					</div>
					
				</li>
				
				<li class="hb_li_padding_bottom_none">
					<div class="hb_buy_now_left">
						<p class="hb_font_weight_normal"><?php echo __('price_paid_user');?></p>
					</div>
					<div class="hb_buy_now_right hb_buy_now_right1">
						<span class="hb_font_size_small"><p   class="pricepaid"> <?php 
			$user_spents=$auction->winner_user_amount_spent($product_result['product_id'],$product_result['lastbidder_userid']);
                        $amount1=0;
                        foreach($user_spents as $user_spent)
                        {
                            $amount1 += $user_spent['price'];
                        }
                        echo "".$site_currency." ".Commonfunction::numberformat($product_result['current_price'])."";
                        ?></p></span>
					</div>
					
				</li>
				<li class="border_none">
					<p class="save_over_text" style="padding-left:0px;"><?php echo __('save_over_label');?> <span   class="saveover">
                                    	<?php  $saveover=$product_result['product_cost'] - $product_result['current_price'];
					echo ($saveover>0)? $site_currency." ".Commonfunction::numberformat($saveover):$site_currency." ". "0.00";?>
                                    </span></p>
					<p class="hb_font_weight_normal"  style="padding-left:0px;"><b><?php echo __('from_the_normal_retail_price_label');?>!</b></p>
				</li>	
			</ul>
		</div>
		 
		
		</div>
	</div>
    
    </div>
    <div class="notice_nsg2 fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> 
    <div class="detail_bottom_outer">
    
     <div class="detail_bottom_outer_top">
     <div class="detail-action_detail">  
     
     <h1><?php echo __('auctions_details');?></h1>
     
     <div class="detail-action_detail_lef"> 
     <h2><?php echo __('auction_id_label');?> :  </h2>
	 <h2><?php echo __('Auction_type_label');?> :</h2>     
     </div>
     
     <div class="detail-action_detail_rgt">
     <p><?php echo $product_result['product_id'];?>  </p>
     <p><?php echo __('cashback_auction_label');?></p>
     
     </div>
     
     </div>
     
      <div class="detail-action_detail">  
     
     <h1><?php echo __('price_details');?></h1>
     
     <div class="detail-action_detail_lef"> 
       
    <h2> <?php echo __('price_starts_from');?> :</h2>
<h2><?php echo __('start_time_label');?> :</h2>
<h2><?php echo __('end_time_label');?> :</h2>
       
     
     
     </div>
     
     <div class="detail-action_detail_rgt">
     <p><?php echo $site_currency." ".$product_result['starting_current_price'];?>  </p>
     <p><?php echo Commonfunction::date_to_string($product_result['startdate']);?></p>
     <p><?php echo Commonfunction::date_to_string($product_result['enddate']);?> </p>
     
     </div>
     
     </div>
     
      <div class="detail-action_detail detail_last-bgnone">  
     
     <h1><?php echo __('shopping_details');?></h1>
     
     <div class="detail-action_detail_lef"> 
    
       <h2><?php echo __('Shipping_fee_label');?> :</h2>
<h2><?php echo __('Shipping_information_label');?> :</h2>
     
     
     </div>
     
     <div class="detail-action_detail_rgt">
     <p><?php echo $site_currency." ".$product_result['shipping_fee'];?>  </p>
     <p><?php echo $product_result['shipping_info'];?></p>
     
     </div>
      </div>
     </div>
     
     
     
     <div class="detail_product_description">
     <h1><?php echo __('product_description');?></h1>
     
     <p><?php echo $product_result['product_info'];?></p>
     
     
     </div>
    
    
    </div>



<!--detail end-->
</div>
</div>
</div>

<?php endforeach;?> 


