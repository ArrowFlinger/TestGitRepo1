<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--container left start-->
   <h4 style="margin-left:15px;color:#333333;font-size:16px;border-bottom:1px dotted #666666"><?php echo __('paypal_title_lable');?></h4> 
   <h4 style="font-size:20px;margin-top:40px;font-family:Arial,Helvetica,sans-serif;color:#494C4D;margin-left:15px;height:100px"><?php echo __('mercado_desc_lable');?></h4>
        <form action="<?php echo URL_BASE;?>mercadopago/mercadopago_result"  method="post" id="payment_redirect">
                <input type="text" name="package_id" value="<?php echo $package_id;?>">
                <input type="text" name="package_title" value="" >   
                <input type="text" name="AMT" value="<?php echo $package_amount;?>">  
                <input type="text" name="pay_order" value="1">
        </form> 
<div class="user" style="display:none;"><?php echo $auction_userid;?></div>
<script type="text/javascript"> 
        $(document).ready(function()
        {
			function timedredirect()
				{
					var t=setTimeout(function(){$("#payment_redirect").submit();},1000)
				}
				window.onload=timedredirect;
        }); 
</script>
