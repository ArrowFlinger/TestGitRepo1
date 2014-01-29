<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right" id="addresses_page">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('menu_my_addresses'));?>"><?php echo strtoupper(__('menu_my_addresses'));?></h1>
	<p>&nbsp;</p>
	</div>
	<div class="message_common">
	<div class="dasbord_common">
	<div class="das_inner">
			
				<div class="grand_total_btn">
				<?php $label1=($count_billing==0)?strtoupper(__('add_billing_address')):strtoupper(__('edit_billing_address'));?>
				<div class="shop_btn">
					<span class="blue_btn_lft">&nbsp;</span>
					<span class="blue_btn_mid"><a href="<?php echo URL_BASE;?>users/myaddresses/billing/add" title="<?php echo ($count_billing==0)?strtoupper(__('add_billing_address')):strtoupper(__('edit_billing_address'));?>" name="key" /><?php echo $label1;?></a></span>
					<span class="blue_btn_rgt">&nbsp;</span>
				</div>
				<div class="fr">
				<?php $label2=($count_shipping==0)?strtoupper(__('add_shipping_address')):(__('edit_shipping_address'));?>
					<span class="blue_btn_lft">&nbsp;</span>
					<span class="blue_btn_mid">  <a href="<?php echo URL_BASE.'users/myaddresses/shipping/add';?>" title="<?php echo ($count_shipping==0)?strtoupper(__('add_shipping_address')):strtoupper(__('edit_shipping_address'));?>" name="key"/><?php echo $label2; ?></a></span>
					<span class="blue_btn_rgt">&nbsp;</span>
				</div>
			</div>
		</div>

	</div>	
	<?php if($count_shipping >0){?>
	<div class="das_inner_text" style="width:auto;">
	<h3><?php echo __('shipping_address');?> :</h3>
	</div>
	<div class="forms_common">
	<div class="title_cont_watchilist">
               <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                   <thead>
                       <tr>
		<th width="100" align="center">
			<b><?php echo __('name_label');?></b>
		</th>
		<th width="100" align="center">
			<b><?php echo __('address');?></b>
		</th>
		<th width="100" align="center">
			<b><?php echo __('suburb_town');?></b>
		</th>
		<th width="100" align="center">
			<b><?php echo __('city');?></b>
		</th>
		<th width="100" align="center">
			<b><?php echo __('postcode');?></b>
		</div>
		<th width="100" align="center">
			<b><?php echo __('ph_no');?></b>
		</th>
		<th width="100" align="center">
			<b><?php echo __('options');?></b>
		</th>
        </tr>
	</thead>
	<tr>
	 <?php foreach($select_shipping_address as $shipping_address):?>

	<td width="100" align="center">
		<h2><?php echo ucfirst($shipping_address['name']);?></h2>		
        </td>	
	<td width="100" align="center">
		<h2>
			<?php $address= explode("+",$shipping_address['address']);
			$address2=(array_key_exists(1,$address))?", ".$address[1]:"";
			echo ucfirst($address[0].$address2);?>
		</h2>
	</td>
	<td width="100" align="center">
		<h2><?php echo ($shipping_address['town']=="")?__('-'):ucfirst($shipping_address['town']); ?></h2>
	</td>
	<td width="100" align="center">
	   <h2><?php echo ucfirst($shipping_address['city']);?></h2>		
	</td>
	<td width="100" align="center">
		<h2><?php echo $shipping_address['zipcode'];?></h2>
	</td>
	<td width="100" align="center">
		<h2><?php echo ($shipping_address['phoneno']=="")?__('-'):$shipping_address['phoneno']; ?></h2>
        </td>
	<td width="100" align="center">
		<h2><a href="<?php echo url::base();?>users/myaddresses/shipping/edit" title="<?php echo __('Edit');?>" class="delet_link"><?php echo __('Edit');?></a></h2>
	</td>
        
	 <?php endforeach; ?>
	</tr>

        </table>
        </div>
        </div>
	<?php } ?>
	 <?php if($count_billing >0){?>
	<div class="das_inner_text" style="width:auto;">
	<h3><?php echo __('billing_address');?> :</h3>
	</div>
	<div class="forms_common">
	<div class="title_cont_watchilist">
             <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                     <thead>
                       <tr>
		<th width="100" align="center">
			<b><?php echo __('name_label');?></b>
		</th>
                <th width="100" align="center">
			<b><?php echo __('address');?></b>
		</th>
                     <th width="100" align="center">
			<b><?php echo __('suburb_town');?></b>
		</th>
                       <th width="100" align="center">
			<b><?php echo __('city');?></b>
		</th>
                         <th width="100" align="center">
			<b><?php echo __('postcode');?></b>
		</th>
                          <th width="100" align="center">
			<b><?php echo __('ph_no');?></b>
		</th>
                                <th width="100" align="center">
			<b><?php echo __('options');?></b>
		</th>
                   </tr>
	</thead>
        
	<tr>
            
	<?php foreach($select_billing_address as $billing_address):?>
	<td width="100" align="center">
		<h2> <?php echo ucfirst($billing_address['name']);?></h2>		
	</td>
	<td width="100" align="center">
		<h2 ><?php $address= explode("+",$billing_address['address']);
		$address2=(array_key_exists(1,$address))?", ".$address[1]:"";
		echo ucfirst($address[0].$address2);?></h2>
	</td>
        
	<td width="100" align="center">
		<h2><?php echo ($billing_address['town']=="")?__('-'):ucfirst($billing_address['town']); ?></h2>
	</td>
	<td width="100" align="center">
	   <h2> <?php echo ucfirst($billing_address['city']);?></h2>		
	</td>
	<td width="100" align="center">
		<h2><?php echo $billing_address['zipcode'];?></h2>
	</td>
	<td width="100" align="center">
		<h2><?php echo ($billing_address['phoneno']=="")?__('-'):$billing_address['phoneno']; ?></h2>
	</td>
	<td width="100" align="center">
	   <a  href="<?php echo url::base();?>users/myaddresses/billing/edit" title="<?php echo __('Edit');?>" class="delet_link"><?php echo __('Edit');?></a>
	</td>
	 <?php endforeach; ?>
	</tr>
        </table>
	<?php } ?>
	</div>
        </div>


</div>
</div>


<script type="text/javascript">
$(document).ready(function () {$("#my_addresses_active").addClass("act_class");});
</script>
