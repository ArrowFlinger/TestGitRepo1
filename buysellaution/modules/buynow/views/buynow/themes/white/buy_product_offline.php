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
	<h2 class="cart_title" title="<?php echo strtoupper(__('buynow_offline_title_lable'));?>"><?php echo __('buynow_offline_title_lable');?></h2>
	<div class="cart_main">
		<div class="cart_main_inner">
		
	 <h4 style="font-size:20px;margin-top:40px;font-family:Arial,Helvetica,sans-serif;color:#494C4D;margin-left:15px;height:100px"><?php echo __('buynow_offline_desc_lable');?></h4>
		
        <form action="<?php echo URL_BASE;?>site/buynowpayment/offline"  method="post" id="payment_redirect" >
		<?php foreach($product_amount as $trans):
		         $amt[]=$trans['total_amt'];
			 $sipping[]=$trans['shipping_fee'];
			 $quantity[]=$trans['quantity'];
			 $totalamount=array_sum($amt);
			 $sippingamt=array_sum($sipping);
			 $qty=array_sum($quantity);			
		endforeach;			
		?>	
                <input type="hidden" name="product_id" value="" >
                <input type="hidden" name="product_name" value="" >   
                <input type="hidden" name="AMT" value="<?php echo $totalamount;?>" >  
                <input type="hidden" name="pay_order" value="<?php echo $qty;?>">
        </form> 
       
<div style="color:#C0C0C0;">
<?php 
//product buynow amount and shipping fee.
$product_cost = $totalamount + $sippingamt;
echo __('you_are_purchasing',array(':param'=>"<b>".$product_amount[0]["product_name"]."</b>",':param1'=>"<b>".$site_currency." ".Commonfunction::numberformat($product_cost)."</b>"));?>
</div> 
 
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>

<script type="text/javascript"> 
        $(document).ready(function() {
        function timedredirect()
        {
        var t=setTimeout(function(){$("#payment_redirect").submit();},1000)
        }
        window.onload=timedredirect;
        }); 
</script>
<div class="action_deal_list2"></div> 


				</div>
	
	</div>
