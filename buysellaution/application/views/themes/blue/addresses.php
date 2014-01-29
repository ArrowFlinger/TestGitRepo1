<?php defined("SYSPATH") or die("No direct script access.");?>
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
                <h2 class="fl clr pl10" title="<?php echo __('menu_my_addresses');?>"><?php echo __('menu_my_addresses');?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
<div class="action_deal_list  action_deal_list2 clearfix">
<div class="address_content fl clr mt20 pb20">
    <!-- My addresses-->
    <div class="my_address_out fl clr">
	 <!--Add a Billing Address Link START-->
	<?php $label1=($count_billing==0)?__('add_billing_address'):__('edit_billing_address');?>
            <div class="add_bill_address fl">
                <span class="add_address_left fl">&nbsp;</span>
                <span class="add_address_middle fl">
                    <a href="<?php echo URL_BASE;?>users/myaddresses/billing/add" title="<?php echo ($count_billing==0)?__('add_billing_address'):__('edit_billing_address');?>" class="fl"> <?php echo $label1;?></a>
                </span>
                <span class="add_address_left add_address_right fl">&nbsp;</span>
            </div>
            <!--Add a Billing Address Link END-->
            <!--Add a Shipping Address START-->
		<?php $label2=($count_shipping==0)?__('add_shipping_address'):__('edit_shipping_address');?>
            <div class="add_bill_address fl ml20">
                <span class="add_address_left fl">&nbsp;</span>
                <span class="add_address_middle fl">
                    <a href="<?php echo URL_BASE.'users/myaddresses/shipping/add';?>" title="<?php echo ($count_shipping==0)?__('add_shipping_address'):__('edit_shipping_address');?>" class="fl"><?php echo $label2; ?></a>
                </span>
                <span class="add_address_left add_address_right fl">&nbsp;</span>
            </div>
            <!--Add a Shipping Address END-->
		<!--Shipping address-->
       	</div> 
		<?php if($count_shipping >0){?>
		<div class="watch_list_items address_watch_list_items fl clr mt10">
        <div class="add_bill_address fl">
        	<b><?php echo __('shipping_address');?></b>
       	</div>
		<div id="managetable" class="transaction_list fl clr mt10">
        <div class="table-left">
        <div class="table-right">
        <div class="table-mid">
		<table width="660" border="0" align="left" cellpadding="0" cellspacing="0" class="table-top">
		        <tr>
		                <th width="85" align="center"><b><?php echo __('name_label');?></b></th>
		                <th width="100" align="center"><b><?php echo __('address');?></b></th>
		                <th width="90" align="center"><b><?php echo __('suburb_town');?></b></th>
		                <th width="100" align="center"><b><?php echo __('city');?></b></th>
		                <th width="90" align="center"><b><?php echo __('postcode');?></b></th>
		                <th width="90" align="center"><b><?php echo __('ph_no');?></b></th>
		                <th width="115" align="center"><b><?php echo __('options');?></b></th>
		        </tr>
		</table>
        </div>
        </div>
        </div>
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
                <?php 
                foreach($select_shipping_address as $shipping_address):?>
                <tr>
                        <td align="left"><p class="watch_list_time"><?php echo ucfirst($shipping_address['name']);?></p></td>
                        <td align="center"><p class="watch_list_time"><?php $address= explode("+",$shipping_address['address']);
						                        $address2=(array_key_exists(1,$address))?", ".$address[1]:"";
						                        echo ucfirst($address[0].$address2);?></p></td>
                        <td align="center"><p class="watch_list_time"><?php echo ($shipping_address['town']=="")?__('-'):ucfirst($shipping_address['town']); ?></p></td>
                        <td align="center"><p class="watch_list_time"><?php echo ucfirst($shipping_address['city']);?></p></td>
                        <td align="center"><p class="watch_list_time"><?php echo $shipping_address['zipcode'];?></p></td>
                        <td align="center"><p class="watch_list_time"><?php echo ($shipping_address['phoneno']=="")?__('-'):$shipping_address['phoneno']; ?></p></td>
                        <td align="center"><p class="watch_list_time"><a href="<?php echo url::base();?>users/myaddresses/shipping/edit" title="<?php echo __('Edit');?>" class="delet_link fr"><?php echo __('Edit');?></a></p></td>
                </tr>
        <?php endforeach; ?>
        </table>
        </div>
        </div>
        <?php } ?>
        <!--End of shipping addresses-->

        <!--billing address-->
        <?php if($count_billing >0){?>
        <div class="watch_list_items address_watch_list_items fl clr">
        <div class="add_bill_address fl">
        <b><?php echo __('billing_address');?></b>
        </div>
        <div id="managetable" class="transaction_list fl clr mt10">
        <div class="table-left">
        <div class="table-right">
        <div class="table-mid">		
                <table width="660" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                        <tr>
                                <th width="72" align="center"><b><?php echo __('name_label');?></b></th>
                                <th width="97" align="center"><b><?php echo __('address');?></b></th>
                                <th width="88" align="center"><b><?php echo __('suburb_town');?></b></th>
                                <th width="79" align="center"><b><?php echo __('city');?></b></th>
                                <th width="87" align="center"><b><?php echo __('postcode');?></b></th>
                                <th width="84" align="center"><b><?php echo __('ph_no');?></b></th>
                                <th width="100" align="center"><b><?php echo __('options');?></b></th>
                        </tr>
                </table>
        </div>
        </div>
        </div>
		
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
        <?php 

        foreach($select_billing_address as $billing_address):?>
		<tr>
                        <td align="left"><p class="watch_list_time"><?php echo ucfirst($billing_address['name']);?></p></td>
                        <td align="center" width="200"><p class="watch_list_time"><?php $address= explode("+",$billing_address['address']);
					                                $address2=(array_key_exists(1,$address))?", ".$address[1]:"";
					                                echo ucfirst($address[0].$address2);?></p></td>
                        <td align="center" width="100"><p class="watch_list_time"><?php echo ($billing_address['town']=="")?__('-'):ucfirst($billing_address['town']); ?></p></td>
                        <td align="center" width="50"><p class="watch_list_time"><?php echo ucfirst($billing_address['city']);?></p></td>
                        <td align="center" width="100"><p class="watch_list_time"><?php echo $billing_address['zipcode'];?></p></td>
                        <td align="center" width="100"><p class="watch_list_time"><?php echo ($billing_address['phoneno']=="")?__('-'):$billing_address['phoneno']; ?></p></td>
                        <td align="center" width="100"><p class="watch_list_time"><a href="<?php echo url::base();?>users/myaddresses/billing/edit" title="<?php echo __('Edit');?>" class="delet_link fr"><?php echo __('Edit');?></a></p></td>
		</tr>
		<?php endforeach; ?>
        </table>
        </div>
        </div>
        <?php } ?>
	<!--End of billing addresses-->
		
</div>
</div>
</div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
</div><script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_addresses_active").addClass("user_link_active");});
</script>
