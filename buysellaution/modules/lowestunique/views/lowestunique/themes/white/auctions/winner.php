<?php defined("SYSPATH") or die("No direct script access.");?> 
<?php foreach($productsresult as $winner_result):?>
<div class="winner_total">
        <div class="winner_toatl_left">
         <?php if(($winner_result['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH.$winner_result['photo']))
                    { 
                        $user_img_path=URL_BASE.USER_IMGPATH.$winner_result['photo'];
                    }
                    else
                    {
                        $user_img_path=IMGPATH.NO_IMAGE;
                    }
          ?>
           <img src="<?php echo $user_img_path;?>" alt="<?php echo ucfirst($winner_result['username']);?>" title="<?php echo ucfirst($winner_result['username']);?>" width="78" height="78"  border="0"/>       
          <div class="winner_img"><img src="<?php echo IMGPATH; ?>winn_imgaes.png" width="31" height="40" alt="Winn" border="0"/>
           <p><?php echo ucfirst($winner_result['username']);?></p>
          <strong><?php echo __('closed_on_label');?> :</strong> <span><?php echo  $auction->date_to_string($winner_result['enddate']); ?></span></div>
        </div>
        <div class="winner_toatl_right">
         <?php if(($winner_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH.$winner_result['product_image']))
			{							
				$product_img_path=URL_BASE.PRODUCTS_IMGPATH.$winner_result['product_image'];
			}
			else
			{
				$product_img_path=IMGPATH.NO_IMAGE;
			}
			?>
          <div class="watch"><img src="<?php echo $product_img_path;?>"  width="122" height="122" alt="<?php echo ucfirst($winner_result['product_name']);?>" title="<?php echo ucfirst($winner_result['product_name']);?>" border="0"/></div>
          <div class="watch_rgt"><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $winner_result['product_url'];?>" title="<?php echo ucfirst($winner_result['product_name']);?>">

          <?php echo strlen($winner_result['product_name'])>30?ucfirst(Text::limit_chars($winner_result['product_name'],26))."...":ucfirst($winner_result['product_name']);?>
		  </a>
			<ul>
				<li><strong><?php echo __('retail_price_label')?> :</strong>
					<p> <?php echo $site_currency;?> <?php echo $winner_result['product_cost'];?></p>
				</li>
				<li><strong><?php echo __('auction_price_label')?> : </strong>
					<p> <?php echo $site_currency;?> <?php echo Commonfunction::numberformat($winner_result['current_price']);?></p>
				</li>
				<li><strong><?php echo __('savings_label')?> :</strong>
					<p><?php echo (round(((1-($winner_result['current_price']/$winner_result['product_cost']))*100),2))>0 ? round(((1-($winner_result['current_price']/$winner_result['product_cost']))*100),2): 0;?>%</p>
				</li>
			</ul>
          </div>
        </div>
      </div>
<?php endforeach;?>  
