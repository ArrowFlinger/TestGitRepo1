<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--container left start-->
<div class="content_left fl">

        <div class="title-left ">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" style="font:bold 14px/43px arial; color:#333;" title="<?php echo __('menu_buynow_add_to_cart');?>"><?php echo __('menu_buynow_add_to_cart');?></h2>
        </div>
        </div>
        </div>  	
        <div class="deal-left clearfix">
	<div class="action_deal_list clearfix">
   <h4 style="margin-left:15px;color:#333333;font-size:16px;font:bold 14px/30px arial;aborder-bottom:1px dotted #666666"><?php echo __('buynow_title_label');?></h4> 
   <h4 style="font-size:20px;margin-top:40px;font-family:Arial,Helvetica,sans-serif;color:#494C4D;margin-left:15px;height:100px"> <?php 
//product buynow amount and shipping fee.
$product_cost = $product_amount[0]['product_cost'] + $product_amount[0]['shipping_fee'];
echo __('you_are_purchasing_product',array(':param'=>"<b>".$product_amount[0]["product_name"]."</b>",':param1'=>"<b>".$site_currency." ".Commonfunction::numberformat($product_cost)."</b>"));?></h4>
		
        <form action="<?php echo URL_BASE;?>site/buynowpayment/buynow_addtocart"  method="post" id="payment_redirect" >
                <input type="hidden" name="product_id" value="<?php echo $product_id;?>" >
                <input type="hidden" name="product_name" value="" >   
                <input type="hidden" name="AMT" value="<?php echo $product_amount[0]['product_cost'];?>" >  
                <input type="hidden" name="pay_order" value="1">

		
		 <div class="dashbord_icon fl mt35" style="margin-left:212px;">
                        <span class="add_address_left fl">&nbsp;</span>
                        <span class="add_address_middle fl">
                        
			<input type="submit" value="<?php echo __('purchase_this_auction_now');?>" class="fl">
                        </span>
                        <span class="add_address_left add_address_right fl">&nbsp;</span>
                </div>
        </form> 
       

 
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
<div class="action_deal_list2"></div> 
	</div>
 <div class="auction-bl">
                <div class="auction-br_rg">
                <div class="auction-bm">
                </div>
                </div>
                </div>
</div>
</div>
