 <?php defined("SYSPATH") or die("No direct script access.");
	
       if(count($transactiondetails)>0)
       {
       
       
       
		 foreach($transactiondetails as $orders)
		 {
		
		    ?>
		    
		<li><span class="title"><?php echo __('payerid_label'); ?>: </span> <span>#<?php echo $orders['PAYERID'];?></span></li>
		<li><span class="title"><?php echo __('authorize_payer_status');?>: </span> <span><?php echo $orders['PAYERSTATUS'];?></span></li>
		
		<li><span class="title"><?php echo __('firstname');?>: </span> <span><?php echo $orders['FIRSTNAME'];?></span></li> 
		<li><span class="title"><?php echo __('lastname');?>: </span> <span><?php echo ($orders['LASTNAME']!='')?$orders['LASTNAME']:"-";?></span></li> 
		<li><span class="title"><?php echo __('email');?>: </span> <span><?php echo $orders['EMAIL'];?></span></li> 
		<li><span class="title"><?php echo __('authorize_acknowledgement');?>: </span> <span><?php echo $orders['ACK'];?></span></li> 
		<li><span class="title"><?php echo __('authorize_payment_status');?>: </span> <span><?php echo $orders['PAYMENTSTATUS'];?></span></li> 
		
		<li><span class="title"><?php echo __('authorize_invoice_id');?>: </span> <span><?php echo $orders['INVOICEID'];?></span></li>
	        <li><span class="title"><?php echo __('product_amount');?>: </span> <span><?php echo $site_currency." ".Commonfunction::numberformat($orders['AMT']+$orders['SHIPPINGAMT']);?></span></li> 

		<li><span class="title"><?php echo __('user_agent');?>: </span> <span><?php echo $orders['USER_AGENT'];?></span></li>
		    
		    
		    
		<?php    
		
		 }
       
       }else{
       ?>
	 <li><span class="title"><?php echo __('no_data');?></span></li> 
       
       <?php 
       }

?>