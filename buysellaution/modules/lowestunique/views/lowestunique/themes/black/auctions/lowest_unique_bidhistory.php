<?php defined('SYSPATH') or die('No direct script access.');?>
<link rel="stylesheet" type="text/css" href="<?php echo CSSPATH;?>jquery.ad-gallery.css"/>
<?php
$id="";
$c_date =Commonfunction::getCurrentTimeStamp();
foreach($productsresult as $product_result):$id.= $product_result['product_id'];?>

<?php if($product_result['product_process']!=CLOSED){?>
<script type="text/javascript">
$(document).ready(function(){

});
</script>
<?php } 
else {
?> 
<?php }?>
<script type="text/javascript">
$(document).ready(function(){
Auction.bidhistory();				   
});
</script>
<div class="container">
<!-- start content-->
<div class="detail_block">
    <div class="detail-tl">
        <div class="detail-tr">
            <div class="detail-tm">
                <h1 class="pro_title"><?php echo __('menu_product_detail');?></h1>
                
            </div>
        </div>
    </div>
    <?php 
    			if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_result['product_image']))
	       		{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_result['product_image'];
					$product_full_size=URL_BASE.PRODUCTS_IMGPATH.$product_result['product_image'];					
				}
				else
				{
					$product_full_size=IMGPATH.NO_IMAGE;
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?>
    <div class="detail-inner clearfix" id="lowest_unique_bidhistory_page">
         <!--Orange_bidhistory-->
        <div class="orange_bidhistory_common">
            <div class="orange_bidhistory_all">
                <div class="orange_bidhistory_left">
                    <div class="orange_bidhistory_top"></div>
                    <div class="orange_bidhistory_mid">
                        <div class="feature_label"></div>
                        <div class="bonus_icon_lowest"></div>
                        <div class="peak_icon_lowest"></div>
                        <?php if($product_result['product_featured']==FEATURED){?><span class="feature_label"></span><?php } ?>
<?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icon" title=""></span><?php } ?>
<?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
<?php if($product_result['product_featured']==HOT){?><span class="hot_icon_product"></span><?php } ?>
<?php  $productimage_count = explode(",",$product_result['product_gallery']);
					if($product_result['product_image']=="") 
					{ 
					$no_img_path=IMGPATH.NO_IMAGE;					
					?>
					<a href="#"><img src="<?php echo $no_img_path;?>" alt="img" border="0" title="Image" height="200px" width="300px" /></a>
					<?php
					}
					else
					{ ?>
                        <a href="#"><img src="<?php echo $product_full_size;?>" alt="<?php echo $product_result['product_name'];?>" border="0" title="Image" height="200px" width="300px" /></a>
                        <?php }
					?>
					</div>
                    <div class="orange_bidhistory_but"></div>
                </div>
                <div class="orange_bidhistory_right"><h2><?php echo __('product_description');?></h2>
                    <p><?php echo $product_result['product_info'];?></p>
                </div>
            </div>
        </div>
        <!--Orange_bidhistory end--> 
           <!-- table style starts --> 
        <div class="blue_tab_outer bid_history1">
            <div class="blue_tab_inner">
                <ul><li><span class="blue_tab_lft_black">&nbsp;</span><span class="blue_tab_mid"><?php echo __('bid_history_label');?></span><span class="blue_tab_rft">&nbsp;</span></li></ul>
                
            </div>
            <div class="tab_cont_bg">
                <div class="bid_history" id="<?php echo URL_BASE;?>site/lowestunique/bid_history_all/<?php echo $id;?>" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/> 
            </div>
        
              <!-- table style ends --> 
   
    <div class="detail-bl">
        <div class="detail-br">
            <div class="detail-bm">                
            </div>
        </div>
    </div>
</div>
</div>
<?php endforeach;?>
