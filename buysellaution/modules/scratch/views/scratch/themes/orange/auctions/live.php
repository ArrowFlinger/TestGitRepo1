<?php defined("SYSPATH") or die("No direct script access.");?>

<?php foreach($productsresult as $product_result):?>            
            <div id="auction_<?php echo $product_result['product_id'];?>" class="auction_item auction_item_content" name="<?php echo URL_BASE;?>auctions/process" data-id="<?php echo $product_result['product_id'];?>">
	    <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div> 	
            <div class="deal-top_f"> </div>
                
                <div class="deal-mid clearfix">
               <?php if($product_result['product_featured']==FEATURED){?><span class="feature_icon"></span><?php } ?>
                 <!--product title-->
                <?php
                if(($product_result['dedicated_auction']==ENABLE) and ($product_result['product_featured']!=FEATURED) and ($product_result['product_featured']!=HOT))
                {
                ?>
                <h3 class="bonus-title">
                	<a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="">
                	<?php echo ucfirst(Text::limit_chars($product_result['product_name'],16));?>
                        </a>
                </h3> 
                <?php                
                }
                elseif((($product_result['product_featured']==FEATURED) and ($product_result['product_featured']!=HOT))and($product_result['dedicated_auction']!=ENABLE)) 
                {
                ?>
                <h3 class="hot-title">
                	<a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="">
                	<?php echo ucfirst(Text::limit_chars($product_result['product_name'],20));?>
                        </a>
                </h3> 
                <?php
                }
                elseif((($product_result['product_featured']!=FEATURED) and ($product_result['product_featured']==HOT))and($product_result['dedicated_auction']!=ENABLE)) 
                {
                ?>
                <h3 class="hot-title">
                	<a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="">
                	<?php echo ucfirst(Text::limit_chars($product_result['product_name'],16));?>
                        </a>
                </h3> 
                <?php
                }
                elseif(($product_result['product_featured']==FEATURED) && ($product_result['dedicated_auction']==ENABLE))
                {
                ?>
                <h3>
                	<a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="">
                	<?php echo ucfirst(Text::limit_chars($product_result['product_name'],11));?>
                        </a>
                </h3> 
                <?php
                }
                elseif(($product_result['product_featured']==HOT) && ($product_result['dedicated_auction']==ENABLE))
                {
                ?>
                <h3>
				
                	<a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="">
                	<?php echo ucfirst(Text::limit_chars($product_result['product_name'],10));?>
                        </a>
                </h3> 
                <?php
                }
                else
                {
                ?>
                <h3>
                	<a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="">
                	<?php echo ucfirst(Text::limit_chars($product_result['product_name'],22));?>
                        </a>
                </h3> 
                <?php
                } ?>
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
                        <div class="pop_top_bg">
			 <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons"></span><?php } ?>
			 <?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
				<?php if($product_result['product_featured']==HOT){?><span class="hot_icon"></span><?php } ?>
			<span class="scratch_icon"></span>
                        </div>
	                <img src="<?php echo $product_img_path;?>" width="148" height="100" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>"/>
                    </a>
                       <div class="action_item_detail fl clr">
					<p class="fl clr"><?php echo __('retail_price_label')." : ".$site_currency." ".$product_result['product_cost'];?></p>
                	<p class="fl clr mt5"><?php echo __("time_countdown_label")." : ".$product_result['bidding_countdown'];?> secs</p>
                </div>
                </div>
                <a class="more_info_link fl" href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="more information"></a>
                <div class="price-block fl">
             
                            
                <!--Auctions process div-->                        	
          
		 <?php if($status==3){?> <div class="futureday mt10"></div><?php } ?>
                </div>
               
		<!--scratch home starts -->
    <div class="scratch_home">
        
        <div class="scratch_price clearfix">
                <span class="scratch_price_left">&nbsp;</span>
                 <span class="scratch_price_mid"><a title="SEE MY PRICE" href="<?php echo URL_BASE; ?>auctions/view/<?php echo $product_result['product_url']; ?>"   title="<?php echo __('scratch_label'); ?>"><?php echo __("scratch_label"); ?></a></span>
                 <span class="scratch_price_right">&nbsp;</span>
				 
				  <div class="action_price" style="float:left;width:90%;text-align:center;" >
					 <span class="currentprice" style="float:left;text-align:center;width:100%"> <?php echo $site_currency." ".Commonfunction::numberformat($product_result['product_cost']);?></span>
					<span class="currentprice" style="display:none;"></span><span class="price" style="display:none;"></span></p></div>
				 
				 
				 
            </div>
        <div class="scratch_reduction">   
        <p><?php echo __('reduction_fee_label');?> <b> <?php echo $site_currency." ".$product_result['bidamount'];?></b></p>
        <p><?php echo __('time_to_label');?> <b><?php echo $product_result['timetobuy']." ".__('second_label');?></b></p>
        </div>
    </div>
     <!--scratch home ends -->
            <div class="user" style="display:none;" ><?php //echo $user;?></div>
          
            <div class="bid_price fl clr" style="display:none;"><p class="fl clr"><?php echo __("bid_label");?>: <?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?></p></div>
            

                
                 <div class="countdown fl clr"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>
            <!--End of Auctions process div-->
		<!--Share-->
<div class="auction_share_icon fl clr mt5">
        	<a style="float:left;width:25px;" href="http://twitter.com/share?url=<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" target="_blank" title="Twitter" ><img src="<?php echo IMGPATH.'twitter_link_icon.png';?>" style="margin:2px 0px 0px 5px;"/></a>
            <a style="float:left;width:25px;" href="https://www.facebook.com/sharer.php?u=<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" target="_blank"  title="Facebook">
              <img src="<?php echo IMGPATH.'fbook_icon.png';?>" class="pl5 pr5 " style="padding-top:2px ;" /></a>
		<!--Like--> 
		<!--Facebook-->
		<fb:like style="float:left;width:auto;" href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"  ></fb:like>	<!--End of facebook-->	   
        </div>           
	<!--End of share-->
          
           <!-- Message flash-->
           <div class="notice_nsg fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
           </div>
            <div class="watch_list fl clr">
            	 <span class="read_more">                <a  href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo __('more_info');?>"><?php echo __('more_info');?></a>
</span>
                <a href="" title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist">
					<?php echo __('add_to_watchlist');?>
                </a>
               
            </div>
           
            </div>        
<?php endforeach;?>
