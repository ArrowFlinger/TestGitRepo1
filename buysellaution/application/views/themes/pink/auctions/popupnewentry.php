<?php defined("SYSPATH") or die("No direct script access.");?>

<style type="text/css">
.block_container{position:fixed;
	bottom:0; right:0; margin:0px 25px 0 5px; 
	background:#fff; box-shadow:1px 1px 5px #888;z-index:998; border-radius:3px 3px 0px 0px; }
.top_block{ border-radius:3px 3px 0px 0px; color:#fff; background:#333;}
.top_block .heading{ font-size:12px;font-weight:600; padding:5px; position:relative; }
.blocks{
	
	}
.product_blocks{ width:300px; padding:5px; border-bottom:1px #ccc solid; margin:5px;}
.product_blocks:hover{ background:#F5F5F5;}

.product_blocks .prd_images{ float:left; width:70px; position:relative;}
.product_blocks .right_contents{float:left;}.product_blocks .right_contents h4 a{ color:#333; font-size:11px; font-weight:bold; text-transform:uppercase;}
.product_blocks .right_contents ul{ display:inline-block; font-size:11px; }
.product_blocks .prd_images a .new_flag{ position:absolute; top:0; right:0; margin:-5px -20px 0 0;background:url('<?php echo URL_BASE.'public/'.THEME;?>/images/new-flag.png') no-repeat; width:50px; height:50px; display:block;}
.close_popup{ cursor:pointer; position:absolute; right:0; top:0; margin:5px 5px 0 0px;padding:2px 3px; border-radius:2px; font-weight:bold; color:#999;}
.close_popup:hover{ background:#fff; color:#333; }
</style>
<script type="text/javascript">
$(document).ready(function(){	
$(".product_blocks:last").css('border-bottom','none');
});

</script>
<?php if($count_live_result>0):?>
<div class="block_container">
<div class="top_block"><div class="heading"><marquee direction="left" width="290">New Products comes into Live auction. Start Bidding...</marquee> <br class="clear" /></div> <div class="close_popup clear" onclick="$(this).parent().parent().slideUp();">X</div></div>
<div class="blocks">
	
        <?php  foreach($result as $product_result):?>
        <div class="product_blocks">
        		
        		<div class="prd_images"><a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo ucfirst($product_result['product_name']);?>">
                        <?php 
		
				if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_result['product_image']))
					{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_result['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}?>
	                <img src="<?php echo $product_img_path;?>" width="60" height="60" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>" id="prdimage"/><span class="new_flag"></span>
                    </a></div>
                    <div class="right_contents">
                        <h4>
                             <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo ucfirst($product_result['product_name']);?>" class="auction_title fl">
                                <?php echo Text::limit_chars(ucfirst($product_result['product_name']),20);?>
                            </a>
                        </h4>
                        <ul>
                        	<li><?php echo __('retail_price_label')." : ".$site_currency." ".'<strong>'.$product_result['product_cost'].'</strong>';?> </li>
                            <li><?php echo __("bid_label");?>:  <?php echo $site_currency." ".$product_result['bidamount'];?></li>
                            <li><?php echo Text::limit_chars($product_result['product_info'],30);?></li>
                        </ul>
                    </div>
        		
                
                
                <div class="clear"></div>
        </div>       
        <?php endforeach;?>
        
</div>
</div>
        <?php endif;?>
        
        
