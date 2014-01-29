<?php defined("SYSPATH") or die("No direct script access.");?> 
<?php foreach($productsresult as $product_result):
	if($product_result['in_auction']==2){
	?>
		<div class="feature_left_box"> <div class="auction_lft">			  
			<div class="feature_lable"></div>
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
			<img src="<?php echo $product_img_path; ?>" width="122" height="122" title="<?php echo ucfirst($product_result['product_name']); ?>" alt="<?php echo $product_result['product_name']; ?>" /><?php if ($product_result['product_process'] == CLOSED && $product_result['lastbidder_userid'] != 0) { ?><img src="<?php echo IMGPATH . SOLD_IMAGE; ?>"class="sold_image"/><?php } ?>
			</a>
		</div>
            <div class="auction_rgt">
				<label>
					<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo ucfirst($product_result['product_name']);?>" >
					<?php echo strlen($product_result['product_name'])>20?substr(ucfirst($product_result['product_name']),0,15)."...":ucfirst($product_result['product_name']);?></a>
				</label>
				<ul>
					<li> <b><?php echo __('closed_price');?> :<span><?php echo  $site_currency." ".Commonfunction::numberformat($product_result['current_price']);?></span></b></li>
					<li> <b><?php echo __('highest_bidder_label');?> : </b><p><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):ucfirst($product_result['username']);?></p> </li>
				</ul>             
            </div>
            <div class="auction_bott">
            <div class="feature_bott_lft">
				<div class="sliders">
					<div title="<?php echo __('reserve_auction_label');?>"class="reserve_white"></div>
					 <?php if($product_result['product_featured']==HOT){?>
					<a><img src="<?php echo IMGPATH;?>head_top4_bg.png" width="14" height="19" alt="<?php echo __('hot_label'); ?>"  title="<?php echo __('hot_label'); ?>"  /></a>
					<?php }?>
					
					 <?php  if($product_result['dedicated_auction']==ENABLE){?>
					<a><img src="<?php echo IMGPATH;?>head_top5_bg.png" width="19" height="19" alt="<?php echo __('bonus_label'); ?>"  title="<?php echo __('bonus_label'); ?>"/></a>
					<?php }?>
				</div>
				<a title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist"><img src="<?php echo IMGPATH;?>plus_bg.png" width="24" height="25" alt="<?php echo __('add_to_watchlist'); ?>" /></a>
            </div>
            <div class="feature_bott_rgt">
				<div class="bidnow_lft"></div>
				<div class="bidnow_mid" style="cursor:pointer;">
				<p>
					<?php  if(($product_result['product_process']==CLOSED) && ($product_result['lastbidder_userid']!=0)){?>
					<a title="<?php echo __('sold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>">
					<?php echo __('sold');?></a>
					<?php }else{ ?>
					<a title="<?php echo __('unsold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>"><?php echo __('unsold');?></a><?php }?>
                </p>
                </div>
                <div class="bidnow_rgt"></div>               
              </div>
			 </div>
            </div>
<?php } else { ?>

<div id="auction_<?php echo $product_result['product_id'];?>" class="auction_item auction_item_content" name="<?php echo URL_BASE;?>auctions/process" data-id="<?php echo $product_result['product_id'];?>">
    <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
         <div class="feature_box">
         <div class="feature_lable"></div>
            <div class="feature_lft">
              <?php if ($product_result['product_featured'] == FEATURED) { ?>
              <span class="featured"><img src="<?php echo IMGPATH;?>Features.png"></span>
              <?php } ?>
            <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>"> 

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
            <img src="<?php echo $product_img_path;?>" width="82" title="<?php echo ucfirst($product_result['product_name']);?>" height="83" alt="<?php echo $product_result['product_name'];?>"  /></a></div>
            <div class="feature_rgt">
				<label>
					<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo ucfirst($product_result['product_name']);?>">
					 <?php echo strlen($product_result['product_name'])>19?ucfirst(Text::limit_chars($product_result['product_name'],15))."...":ucfirst($product_result['product_name']);?>
					</a>
				</label>
				<ul style="width:130px;">  
					<li>
						<b><?php echo __('bid_to_beat');?>: </b>
						<div style="color:#EE7E3F;font-weight:bold;" class="currentprice"></div>
						<div  style="color:#EE7E3F;font-weight:bold;" class="loader<?php echo $product_result['product_id'];?>" style="display:block;"><?php if($product_result['current_price']=='' || $product_result['current_price']==0) {?><?php echo $site_currency." "."0";?><?php }?></div>				
						<p><span style="display:none;"><?php echo __('price_label');?>:</span><div class="price" style="display:none;"></div></p>
					</li>				
					
				</ul>				
				<p class="countdown fl clr"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></p>
            </div>            
          <?php if($status==3){?> <div class="futureday mt10"></div><?php } ?>
            <div class="feature_bott">
              <div class="feature_bott_lft">
				<div class="sliders">
					<div title="<?php echo __('reserve_auction_label');?>"class="reserve_white"></div>
					 <?php if($product_result['product_featured']==HOT){?>
					<a><img src="<?php echo IMGPATH;?>head_top4_bg.png" width="14" height="19" alt="<?php echo __('hot_label'); ?>"  title="<?php echo __('hot_label'); ?>"  /></a>
					<?php }?>
					
					 <?php  if($product_result['dedicated_auction']==ENABLE){?>
					<a><img src="<?php echo IMGPATH;?>head_top5_bg.png" width="19" height="19" alt="<?php echo __('bonus_label'); ?>"  title="<?php echo __('bonus_label'); ?>"/></a>
					<?php }?>
				</div>
              <a title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist"><img src="<?php echo IMGPATH;?>plus_bg.png" width="24" height="25" alt="<?php echo __('add_to_watchlist'); ?>" /></a>
             </div>
             <div class="feature_bott_rgt" style="margin:0 10px 0 0;">
				 <?php if($product_result['product_process']!=FUTURE){?>
             <div class="bidme_link">
				<div class="bidnow_lft"></div>
					<div class="bidnow_mid">                
						 <p>
							 <a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" id="<?php echo $product_result['product_id']; ?>" name="<?php echo URL_BASE; ?>auctions/bid/" class="bid" title="<?php echo ($auction_userid == '') ? __('logins_label') : __('bid_now_label'); ?>" rel="<?php echo URL_BASE; ?>users/login/"  data-auctiontype ="<?php echo $product_result['auction_type']; ?>">
							 <?php echo __("bid_now_label");?> </a>
						 </p>                                        
					</div>
                <div class="bidnow_rgt"></div>
                </div>
                <?php }?>
              </div>
            </div>
            <!--  <div class="loader<?php echo $product_result['product_id'];?>" style="display:none;"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>-->
             <div class="notice_nsg fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
           </div>
          </div>
  <?php }?>        
<?php endforeach; ?>
