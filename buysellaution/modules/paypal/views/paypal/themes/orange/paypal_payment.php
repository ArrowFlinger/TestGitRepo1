<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--container left start-->
   <h4 style="margin-left:15px;color:#333333;font-size:16px;border-bottom:1px dotted #666666"><?php echo __('paypal_title_lable');?></h4> 
   <h4 style="font-size:20px;margin-top:40px;font-family:Arial,Helvetica,sans-serif;color:#494C4D;margin-left:15px;height:100px"><?php echo __('paypal_desc_lable');?></h4>
      <form action="<?php echo URL_BASE;?>paypal/process"  method="post" id="payment_redirect" >
               <?php  $shipping_fee= isset($post['shipping_cost'])?(($post['shipping_cost']!='')?$post['shipping_cost']:0):0;?>
      <?php foreach($post as $key => $value)
    {
         if(is_array($value)){
        foreach($value as $v):
        ?>
                        <input type="hidden" name="form[<?php echo $key;?>][]" value="<?php echo $v;?>" > 
  <?php  endforeach; }
  else { ?>
    <input type="hidden" name="form[<?php echo $key;?>]" value="<?php echo $value;?>" > 
   <?php } } ?> 
  
      </form>
      <?php if(count($post['id'])==1): ?>
<div style="color:#C0C0C0;">
   <?php
   $quantity= isset($post['quantity'][0])?$post['quantity'][0]:1;
   echo __('you_are_purchasing',array(':param'=>"<b>".$post['name'][0]."</b>",':param1'=>"<b>".$site_currency." ".Commonfunction::numberformat(($post['unitprice'][0]*$quantity)+$shipping_fee)."</b>"));?>
</div>
<?php endif;?>
<div class="user" style="display:none;" >
   <?php echo $auction_userid;?>
</div>

<script type="text/javascript"> 
  
   $(document).ready(function() {
      function timedredirect(){
         var t=setTimeout(function(){$("#payment_redirect").submit();},100)
      }
     window.onload=timedredirect;
   });
  
  
  
</script>

