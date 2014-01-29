<?php defined("SYSPATH") or die("No direct script access."); 
?> 
<?php foreach($productsresult as $product_result):?>
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
              <label><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo ucfirst($product_result['product_name']);?>">

             <?php echo strlen($product_result['product_name'])>19?ucfirst(Text::limit_chars($product_result['product_name'],15))."...":ucfirst($product_result['product_name']);?>

					</a></label>
              <ul style="width:130px;">  
					<li>
						<b><?php echo __('bid_to_beat');?>: </b>
						<div style="color:#EE7E3F;font-weight:bold;" class="currentprice"></div>
						<div  style="color:#EE7E3F;font-weight:bold;" class="loader<?php echo $product_result['product_id'];?>" style="display:block;"><?php if($product_result['current_price']=='' || $product_result['current_price']==0) {?><?php echo $site_currency." "."0";?><?php }?></div>
					
						<p><span style="display:none;"><?php echo __('price_label');?>:</span><div class="price" style="display:none;"></div></p>
					</li>
				
					<li>
						<b><span  style="color:#000;"><?php echo __('bid_label');?> : <span><?php echo $site_currency." ".$product_result['bidamount'];?></span></b>
				   
						<div class="bid_price fl clr" style="display:none;"><p class="fl clr"><?php echo __("bid_label");?>: <?php echo $site_currency." ".$product_result['bidamount'];?></p></div>
					</li>
				</ul>
				
              <p class="countdown fl clr"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></p>
            </div>
          
            <div class="feature_bott">
              <div class="feature_bott_lft">
              <div class="sliders">
     
		
			<a><img src="<?php echo IMGPATH;?>lowestunique.png" width="18" height="18" alt="<?php echo __('lowestunique_label'); ?>"  title="<?php echo __('lowestunique_label'); ?>"  /></a>		

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
              <div class="bidme_link">
                <div class="bidnow_lft"></div>
                <div class="bidnow_mid">
                
                 <p>  <a href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>" title="<?php echo __('bid_me_label');?>"><?php echo __('bid_me_label');?> </a></p>
                                        
                </div>
                <div class="bidnow_rgt"></div>
                </div>
              </div>
            </div>
           
             <div class="notice_nsg fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
           </div>
          </div>
          
<?php endforeach; ?>
