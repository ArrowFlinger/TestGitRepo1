<?php defined("SYSPATH") or die("No direct script access.");?>
<div class="action_content_left fl">
	<div class="title_temp1 fl clr pt10">
    	<h2 class="fl clr pl10" title="<?php echo __('menu_my_addresses');?>"><?php echo __('menu_my_addresses');?></h2>
    </div>
<div class="address_content fl clr mt20 pb20">
	
	<!-- My addresses-->
    <div class="my_address_out fl clr">
	 <!--Add a Billing Address Link START-->
	<?php $label1=($count_billing==0)?__('add_billing_address'):__('edit_billing_address');?>
            <div class="add_bill_address fl">
                <span class="add_address_left fl">&nbsp;</span>
                <span class="add_address_middle fl">
                    <a href="<?php echo URL_BASE;?>users/myaddresses/billing/add" title="<?php echo __('add_shipping_address');?>" class="fl"> <?php echo $label1;?></a>
                </span>
                <span class="add_address_left add_address_right fl">&nbsp;</span>
            </div>
            <!--Add a Billing Address Link END-->
            <!--Add a Shipping Address START-->
		<?php $label2=($count_shipping==0)?__('add_shipping_address'):__('edit_shipping_address');?>
           <div class="add_bill_address fl ml20">
                <span class="add_address_left fl">&nbsp;</span>
                <span class="add_address_middle fl">
                    <a href="<?php echo URL_BASE.'users/myaddresses/shipping/add';?>" title="<?php echo __('add_billing_address');?>" class="fl"><?php echo $label2; ?></a>
                </span>
                <span class="add_address_left add_address_right fl">&nbsp;</span>
            </div>
            <!--Add a Shipping Address END-->
		<!--Shipping address-->
       	</div> 
		<?php if($count_shipping >0){?>
		<div class="watch_list_items fl clr mt10">
        <div class="add_bill_address fl">
        	<b><?php echo __('shipping_address');?></b>
       	</div>
		<div id="managetable" class="transaction_list fl clr mt10">
		<table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
		<tr>
		<th width="150" align="center"><?php echo __('name_label');?></th>
		<th width="180" align="center"><b><?php echo __('address');?></b></th>
		<th width="100" align="center"><b><?php echo __('suburb_town');?></b></th>
		<th width="100" align="center"><b><?php echo __('city');?></b></th>
		<th width="80" align="center"><b><?php echo __('postcode');?></b></th>
		<th width="80" align="center"><b><?php echo __('ph_no');?></b></th>
		<th width="80" align="center"><b><?php echo __('options');?></b></th>
		
		</tr>
		
		<?php 
	
		foreach($select_shipping_address as $shipping_address):?>
		<tr>
		<td width="100" align="left"><p class="watch_list_time"><?php echo ucfirst($shipping_address['name']);?></p></td>
		<td width="100" align="center"><p class="watch_list_time"><?php $address= explode("+",$shipping_address['address']);
									$address2=(array_key_exists(1,$address))?", ".$address[1]:"";
									echo ucfirst($address[0].$address2);?></p></td>
		<td  align="center"><p class="watch_list_time"><?php echo ($shipping_address['town']=="")?__('-'):ucfirst($shipping_address['town']); ?></p></td>
		<td align="center"><p class="watch_list_time"><?php echo ucfirst($shipping_address['city']);?></p></td>
		<td align="center"><p class="watch_list_time"><?php echo $shipping_address['zipcode'];?></p></td>
		<td align="center"><p class="watch_list_time"><?php echo ($shipping_address['phoneno']=="")?__('-'):$shipping_address['phoneno']; ?></p></td>
		<td align="center"><p class="watch_list_time"><a href="<?php echo url::base();?>users/myaddresses/shipping/edit" title="<?php echo __('Edit');?>" class="delet_link fr"><?php echo __('Edit');?></a></p></td>
		
		</tr>
		<?php endforeach; ?>
		</table>
		</div></div><?php } ?>
	<!--End of shipping addresses-->

	<!--billing address-->
		<?php if($count_billing >0){?>
		<div class="watch_list_items fl clr">
        <div class="add_bill_address fl">
        	<b><?php echo __('billing_address');?></b>
       	</div>
		<div id="managetable" class="transaction_list fl clr mt10">
		<table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
		<tr>
		<th width="20%" align="center" ><?php echo __('name_label');?></th>
		<th width="30%" align="center"><b><?php echo __('address');?></b></th>
		<th width="10%" align="center"><b><?php echo __('suburb_town');?></b></th>
		<th width="10%" align="center"><b><?php echo __('city');?></b></th>
		<th width="10%" align="center"><b><?php echo __('postcode');?></b></th>
		<th width="10%" align="center"><b><?php echo __('ph_no');?></b></th>
		<th width="10%" align="center"<b><?php echo __('options');?></b></th>
		
		</tr>
		
		<?php 
	
		foreach($select_billing_address as $billing_address):?>
		<tr>
		<td width="20%" align="left"><p class="watch_list_time"><?php echo ucfirst($billing_address['name']);?></p></td>
		<td width="30%" align="center"><p class="watch_list_time"><?php $address= explode("+",$billing_address['address']);
									$address2=(array_key_exists(1,$address))?", ".$address[1]:"";
									echo ucfirst($address[0].$address2);?></p></td>
		<td width="10%" align="center"><p class="watch_list_time"><?php echo ($billing_address['town']=="")?__('-'):ucfirst($billing_address['town']); ?></p></td>
		<td width="10%" align="center"><p class="watch_list_time"><?php echo ucfirst($billing_address['city']);?></p></td>
		<td width="10%" align="center"><p class="watch_list_time"><?php echo $billing_address['zipcode'];?></p></td>
		<td width="10%" align="center"><p class="watch_list_time"><?php echo ($billing_address['phoneno']=="")?__('-'):$billing_address['phoneno']; ?></p></td>
		<td width="10%" align="center"><p class="watch_list_time"><a href="<?php echo url::base();?>users/myaddresses/billing/edit" title="<?php echo __('Edit');?>" class="delet_link fr"><?php echo __('Edit');?></a></p></td>
		
		</tr>
		<?php endforeach; ?>
		</table>
		</div></div><?php } ?>
	<!--End of billing addresses-->
		
</div>
</div><script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_addresses_active").addClass("user_link_active");});
</script>
