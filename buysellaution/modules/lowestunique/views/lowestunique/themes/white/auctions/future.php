 <?php defined("SYSPATH") or die("No direct script access."); 
?>
  <?php foreach($productsresult as $product_result):?>
    <div id="auction_<?php echo $product_result['product_id'];?>" class="auction_item auction_item_content" name="<?php echo URL_BASE;?>auctions/process">
    	<div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
  		<div class="feature_left_box"> <div class="auction_lft">
		     <?php if ($product_result['product_featured'] == FEATURED) { ?>
              <span class="featured"><img src="<?php echo IMGPATH;?>Features.png"></span>
              <?php } ?>
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
                            <img src="<?php echo $product_img_path;?>" width="122" height="122" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>"/>
                        </a>
                        </div>
            <div class="auction_rgt">
              <label>  <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo ucfirst($product_result['product_name']);?>">
                     <?php echo strlen($product_result['product_name'])>19?ucfirst(Text::limit_chars($product_result['product_name'],15))."...":ucfirst($product_result['product_name']);?>
                        </a></label>
              <ul>
				<li> 
				<b><?php echo __('bid_to_beat');?>:  <span class="currentprice"></span></b> 
				</li>

			<div class="loader<?php echo $product_result['product_id'];?>" style="display:none;"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>

				<li>  
					<b><?php echo __('bid_label');?>:<span>  <?php echo $site_currency." ".$product_result['bidamount'];?></span> </b>
				</li>
				<li><div class="futureday mt10"></div></li>
			</ul>
             
            </div>
               
            <div class="auction_bott">
             
              <div class="feature_bott_lft" style="width:346px;">
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
					<div class="bidnow_lft"></div>
                	<div class="bidnow_mid"  style="width:94px;">
                	<p class="countdown countdown_future fl clr"><img src="<?php echo IMGPATH.'ajax-loader.gif'?>"/></p>
                	
               		 </div>
             
              	 <div class="bidnow_rgt"></div>
            </div>
          </div>
        </div></div>
              <?php endforeach;?>
