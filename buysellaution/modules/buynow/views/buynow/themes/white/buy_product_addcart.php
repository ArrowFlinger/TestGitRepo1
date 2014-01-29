<!--login start-->


<div class="cart_head">
<ul>
  <li><a href="<?php echo URL_BASE;?>" title="Home"><?php echo __('menu_home');?></a></li>
          <li><a href="#" title="arr_bg"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
          <li class="active"><a title="<?php echo $selected_page_title; ?>"><?php echo $selected_page_title; ?></a></li>
</ul>
</div>
<!--add to cart-->
	<div class="cart_full">
	<h2 class="cart_title"><?php echo __('menu_buynow_add_to_cart');?></h2>
	<div class="cart_main">
		<div class="cart_main_inner">
		
		   <h4 style="margin-left:15px;color:#333333;font-size:16px;border-bottom:1px dotted #666666"><?php echo __('buynow_title_label');?></h4> 
   <h4 style="font-size:20px;margin-top:40px;font-family:Arial,Helvetica,sans-serif;color:#494C4D;margin-left:15px;height:100px"> <?php 
//product buynow amount and shipping fee.
$product_cost = $product_amount[0]['product_cost'] + $product_amount[0]['shipping_fee'];
echo __('you_are_purchasing',array(':param'=>"<b>".$product_amount[0]["product_name"]."</b>",':param1'=>"<b>".$site_currency." ".Commonfunction::numberformat($product_cost)."</b>"));?></h4>
		
        <form action="<?php echo URL_BASE;?>site/buynowpayment/buynow_addtocart"  method="post" id="payment_redirect" >
                <input type="hidden" name="product_id" value="<?php echo $product_id;?>" >
                <input type="hidden" name="product_name" value="" >   
                <input type="hidden" name="AMT" value="<?php echo $product_amount[0]['product_cost'];?>" >  
                <input type="hidden" name="pay_order" value="1">

		
		 <div class="dashbord_icon fl mt35" style="margin-left:212px;">
                        <span class="add_address_left fl ">&nbsp;</span>
                        <span class="add_address_middle fl" style="width:280px;">
                        
			<input type="submit" value="<?php echo __('purchase_this_auction_now');?>" title="<?php echo __('purchase_this_auction_now');?>" class="fl">
                        </span>
                        <span class="add_address_left add_address_right fl">&nbsp;</span>
                </div>
        </form> 
       

 
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>

				</div>
	
	</div></div>
<!--add to cart-->

