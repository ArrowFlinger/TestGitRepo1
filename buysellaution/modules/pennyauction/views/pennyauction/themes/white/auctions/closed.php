<?php defined("SYSPATH") or die("No direct script access."); ?>
<?php  foreach($productsresult as $product_result):?>
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
              <label><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo ucfirst($product_result['product_name']);?>" >
					<?php echo strlen($product_result['product_name'])>20?substr(ucfirst($product_result['product_name']),0,15)."...":ucfirst($product_result['product_name']);?>
                </a></label>
              <ul>
                <li> <b><?php echo __('closed_price');?> :<span><?php echo  $site_currency." ".Commonfunction::numberformat($product_result['current_price']);?></span></b></li>
                <li> <b><?php echo __('highest_bidder_label');?> : </b><p><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):ucfirst($product_result['username']);?></p> </li>
              </ul>
             
            </div>
            <div class="auction_bott">
               <div class="feature_bott_lft"><div class="sliders">
                 <a><img src="<?php echo IMGPATH;?>head_top2_bg.png" width="18" height="18" alt="<?php echo __('penny_label'); ?>"  title="<?php echo __('penny_label'); ?>" /></a>
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
                <div class="bidnow_mid" style="cursor:pointer;"><p>
                   <?php  if($product_result['product_process']==CLOSED && $product_result['lastbidder_userid']!=0){?>
                 <a title="<?php echo __('sold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>">
                               <?php echo __('sold');?>
                            </a>
                            <?php }else{ ?>
                            <a title="<?php echo __('unsold');?>" name="<?php echo URL_BASE;?>auctions/bid/<?php echo $product_result['product_id'];?>">
                               <?php echo __('unsold');?>
                            </a>
                            <?php }?>
                            </p>
                </div>
                <div class="bidnow_rgt"></div>
               
              </div>
			 </div>
            </div>
            <?php endforeach;?>
