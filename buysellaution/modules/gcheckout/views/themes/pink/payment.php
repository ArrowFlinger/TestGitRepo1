<?php defined("SYSPATH") or die("No direct script access."); ?>
<!--container left start-->
<h4 style="margin-left:15px;color:#333333;font-size:16px;border-bottom:1px dotted #666666"><?php echo __('gc_title_lable');?></h4> 
<h4 style="font-size:20px;margin-top:40px;font-family:Arial,Helvetica,sans-serif;color:#494C4D;margin-left:15px;height:100px">
<?php echo __('gc_desc_lable');?>
</h4>
   <form action="<?php echo URL_BASE;?>payment/pay"  method="post" id="payment_redirect" >
  <?php foreach($post as $key => $value)
    {
         if(is_array($value)){
        foreach($value as $v):
        ?>
                        <input type="hidden" name="form[<?php echo $key;?>][]" value="<?php echo $v;?>" > 
  <?php  endforeach; }} ?> </form>
    <?php echo ($currency_code =="USD" || $currency_code=="EUR") ? $button : __('checkout_currency_problem');?>
  
<div style="color:#C0C0C0;">

<?php echo __('payvia_googlecheckout');?></div>
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
