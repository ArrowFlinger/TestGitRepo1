 <?php defined("SYSPATH") or die("No direct script access.");
	
       if(count($transactiondetails)>0)
       {
		  foreach($transactiondetails as $orders)
		 {
		
		    ?>
		    
			<li><span class="title"><?php echo __('buyerid_label'); ?>: </span> <span><?php echo $orders['gc_buyerid'];?></span></li>
			<li><span class="title"><?php echo __('serial_number');?>: </span> <span><?php echo $orders['serial_number'];?></span></li>
			<li><span class="title"><?php echo __('gc_order_no');?>: </span> <span><?php echo $orders['gc_orderno'];?></span></li> 
			<li><span class="title"><?php echo __('buyer_email');?>: </span> <span><?php echo $orders['buyer_email'];?></span></li>
			<li><span class="title"><?php echo __('buyer_name');?>: </span> <span><?php echo $orders['buyer_name'];?></span></li>
			<li><span class="title"><?php echo __('billing_address');?>: </span> <span><?php echo $orders['billingaddress'];?></span></li>
			<li><span class="title"><?php echo __('shipping_address');?>: </span> <span><?php echo $orders['shippingaddress'];?></span></li>
			<li><span class="title"><?php echo __('order_total');?>: </span> <span><?php echo $site_currency." ".Commonfunction::numberformat($orders['order_total']);?></span></li> 
			<li><span class="title"><?php echo __('order_currency');?>: </span> <span><?php echo $orders['order_currency'];?></span></li> 
			<li><span class="title"><?php echo __('financial_orderstate');?>: </span> <span><?php echo $orders['financial_orderstate'];?></span></li> 
			<li><span class="title"><?php echo __('fulfillment_orderstate');?>: </span> <span><?php echo $orders['fulfillment_orderstate'];?></span></li> 
			<li><span class="title"><?php echo __('gc_timestamp');?>: </span> <span><?php echo $orders['gc_timestamp'];?></span></li> 
		
		<?php    
		
		 }
       
       }else{
       ?>
	 <li><span class="title"><?php echo __('no_data');?></span></li> 
       
       <?php 
       }

?>