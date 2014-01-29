<?php defined("SYSPATH") or die("No direct script access."); 
?>

        <?php foreach($productsresult as $product_result):?>
            <div id="auction_<?php echo $product_result['product_id'];?>" class="auction_item auction_item_content" id="scratch_modules_live_page" name="<?php echo URL_BASE;?>auctions/process" data-id="<?php echo $product_result['product_id'];?>">
            <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
            <div class="deal-top_f">
               		
                </div>
                <div class="deal-mid clearfix">
                <!--product title-->
		<h3 class="fl clr">
                	<a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>">
						<?php echo strlen($product_result['product_name'])>20?substr(ucfirst($product_result['product_name']),0,20)."...":ucfirst($product_result['product_name']);?>
                    </a>
                </h3>
                <!--product image-->
                <div class="action_item_img fl"> 
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
<?php if($product_result['product_featured']==FEATURED){?><span class="feature_icon"></span><?php } ?>
<div class="pop_top_bg">
			 <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons"></span><?php } ?>
			 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
			 <?php if($product_result['product_featured']==HOT){?><span class="hot_icon"></span><?php } ?>
			 <span class="scratch_icon"></span>
</div>
	                <img src="<?php echo $product_img_path;?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>"/>
                    </a>
                     <div class="action_item_detail fl clr">
					<p class="fl"><span style="float:left"><?php echo __('retail_price_label')." :</span> ".$site_currency." ".$product_result['product_cost'];?></p>
                	<p class="fl clr mt5"><span class="fl"><?php echo __("time_to_label");?></span> <span style="float:left"><?php echo $product_result['timetobuy']; ?> <?php echo __('second_label');?></span>
</p>
                </div>
                </div>
              
               

                <!--Auctions process div-->                        	
               
                <?php if($status==3){?> <div class="futureday mt10"></div><?php } ?>
                
                 <div class="new_com">
               

		
            <!--scratch home starts -->
    <div class="scratch_home">
        
        <div class="scratch_price clearfix">
                <span class="scratch_price_left">&nbsp;</span>
                 <span class="scratch_price_mid"><a title="<?php echo __('scratch_label'); ?>" href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>"><?php echo __('scratch_label'); ?></a></span>
                 <span class="scratch_price_right">&nbsp;</span>
            </div>
        <?php if($status==3){?> <div class="futureday mt10"></div><?php } ?>
        <div class="scratch_reduction">   
        <p><?php echo __('reduction_fee_label');?> <b> <?php echo $site_currency." ".$product_result['bidamount'];?></b></p>
        <p><?php echo __('time_to_label');?>  <b><?php echo $product_result['timetobuy']." ".__('second_label');?></b></p>
        
                <span class="currentprice" style="display:none;"></span><span class="price" style="display:none;"></span>
        </div>
    </div>
     <!--scratch home ends -->
     
          <div class="countdown fl"><img src="<?php echo IMGPATH . 'ajax-loader.gif'; ?>"/></div>
        </div>
                <div class="user" style="display:none;" ><?php //echo $user;?></div>
        <!--End of Auctions process div-->
        <!--Share-->
     <div class="auction_share_icon fl clr mt5" style="height:65px;" >
        	<?php  /* <a title="share_label"><?php echo __('share_label');?> </a> */?>
			
			<a style="float:left;width:30px;" href="http://twitter.com/share?url=<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" target="_blank" title="Twitter" ><img src="<?php echo IMGPATH.'twitter_link_icon.png';?>" style="margin:2px 0px 0px 5px;"/></a>
            <a style="float:left;width:30px;" href="https://www.facebook.com/sharer.php?u=<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" target="_blank"  title="Facebook">
              <img src="<?php echo IMGPATH.'fbook_icon.png';?>" class="pl5 pr5 " style="padding-top:2px ;" /></a>
		
		   <a style="float:left;"><fb:like  style="width:auto;float:left;" href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"  ></fb:like><?php //echo $include_facebook;?>	<!--End of facebook-->	 </a>
        </div>         
           </div>
        <!--End of share-->
        <div class="watch_list fl clr">
                    

            <span class="read_more"><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>"><?php echo __('more_info');?></a></span>
        <a href="" title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist">
		      <?php echo __('add_to_watchlist');?>
        </a>
       </div>
        <!-- Message flash-->
        <div class="notice_nsg fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
     
       
        </div>
        <?php endforeach;?>
       
