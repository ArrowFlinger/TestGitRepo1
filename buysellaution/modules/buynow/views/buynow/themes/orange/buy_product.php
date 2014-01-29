<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--container left start-->

   <h4 style="margin-left:15px;color:#333333;font-size:16px;border-bottom:1px dotted #666666"><?php echo __('paypal_title_lable');?></h4> 
   <h4 style="font-size:20px;margin-top:40px;font-family:Arial,Helvetica,sans-serif;color:#494C4D;margin-left:15px;height:100px"><?php echo __('paypal_desc_lable');?></h4>
		
        <form action="<?php echo URL_BASE;?>site/buynowpayment/paypal"  method="post" id="payment_redirect" >
	<?php foreach($product_amount as $trans):
		         $amt[]=$trans['total_amt'];
			 $sipping[]=$trans['shipping_fee'];
			 $productname[]=$trans['product_name'];
			 $shipping_fee=($trans['shipping_fee']!='')?$trans['shipping_fee']:0;
			 $subamount=($trans['quantity']*$trans['product_cost'])+ $shipping_fee;
			 $tamt[]=$subamount;
				
		endforeach;
		$totalamount=array_sum($tamt);
		
		?>		
                <input type="hidden" name="product_id" value="<?php echo $product_id;?>" >
                <input type="hidden" name="product_name" value="" >   
                <input type="hidden" name="AMT" value="<?php echo $totalamount;?>" >  
                <input type="hidden" name="pay_order" value="1" >
        </form> 
       
<div style="color:#C0C0C0;"><?php 
echo __('you_are_purchasing_product',array(':param'=>"<b>".implode(",",$productname)."</b>",':param1'=>"<b>".$site_currency." ".Commonfunction::numberformat($totalamount)."</b>"));?> </div>
 
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
