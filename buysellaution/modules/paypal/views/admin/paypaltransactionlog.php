 <?php defined("SYSPATH") or die("No direct script access.");
 
$total_count=count($page_data);

	       if($total_count > 0){

		    ?>
			
			<li><span class="title"><?php echo __('id_label'); ?>: </span> <span><?php echo ($page_data['ID'])?$page_data['ID']:"-";?></span></li>
			<li><span class="title"><?php echo __('ordered_time_label'); ?>: </span> <span><?php echo ($page_data['ORDERTIME'])?$page_data['ORDERTIME']:"-";?></span></li> 
			<li><span class="title"><?php echo __('username_label'); ?>: </span> <span style="color:#0B61B1"><?php echo ucfirst($page_data['username']);?></span></li> 
			<li><span class="title"><?php echo __('ip_label'); ?>: </span> <span><?php echo ($page_data['LOGIN_ID'])?$page_data['LOGIN_ID']:"-";?>  </span></li> 
			<li><span class="title"><?php echo __('transaction_type_label'); ?>: </span> <span><?php echo  ($page_data['TRANSACTIONTYPE'])?$page_data['TRANSACTIONTYPE']:"-";?> </span></li> 
			<li><span class="title"><?php echo __('transaction_no_label'); ?>: </span> <span><?php echo  ($page_data['TRANSACTIONID'])?$page_data['TRANSACTIONID']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('payer_email_label'); ?>: </span> <span><?php echo  ($page_data['EMAIL'])?$page_data['EMAIL']:"-";?> </span></li>
			
			<li><span class="title"><?php echo __('payment_date_label'); ?>: </span> <span><?php echo ($page_data['TIMESTAMP'])?$page_data['TIMESTAMP']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('receiver_email_label'); ?>: </span> <span><?php echo ($page_data['RECEIVER_EMAIL'])?$page_data['RECEIVER_EMAIL']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('payerid_label'); ?>: </span> <span><?php echo ($page_data['PAYERID'])?$page_data['PAYERID']:"-";?></span></li> 			
			
			<li><span class="title"><?php echo __('paypal_fees'); ?>: </span> <span><?php echo ($page_data['FEEAMT'])?$page_data['FEEAMT']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('product_cost'); ?>: </span> <span><?php echo ($page_data['AMT'])?$site_currency." ".Commonfunction::numberformat($page_data['AMT']):"-";?></span></li>
			
			<li><span class="title"><?php echo __('shipping_fee'); ?>: </span> <span><?php echo ($page_data['shipping_fee'])?$site_currency." ".$page_data['shipping_fee']:"-";?></span></li>			
			
			<li><span class="title"><?php echo __('total_amount',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?>: </span>
			<span><?php echo ($page_data['AMT'])?$site_currency." ".Commonfunction::numberformat($page_data['AMT']+$page_data['shipping_fee']):"-";?>
			</span></li>
			
			<li><span class="title"><?php echo __('currency_code_label'); ?>: </span> <span><?php echo ($page_data['CURRENCYCODE'])?$page_data['CURRENCYCODE']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('receipt_no_label'); ?>: </span> <span><?php echo ($page_data['CORRELATIONID'])?$page_data['CORRELATIONID']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('pending_status_label'); ?>: </span> <span><?php echo ($page_data['PAYMENTSTATUS']!='S')?$page_data['PAYMENTSTATUS']:__('success');?></span></li>
			
			<li><span class="title"><?php echo __('paypal_response_label'); ?>: </span> <span><?php echo ($page_data['PAYERSTATUS'])?$page_data['PAYERSTATUS']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('error_code_label'); ?>: </span> <span><?php echo ($page_data['REASONCODE'])?$page_data['REASONCODE']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('invoice_no_label'); ?>: </span> <span><?php echo ($page_data['INVOICEID'])?$page_data['INVOICEID']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('country_code_label'); ?>: </span> <span><?php echo ($page_data['COUNTRYCODE'])?$page_data['COUNTRYCODE']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('ack_label'); ?>: </span> <span><?php echo ($page_data['ACK'])?$page_data['ACK']:"-";?></span></li>
			
			<li><span class="title"><?php echo __('payment_type_label'); ?>: </span> <span><?php echo ($page_data['PAYMENTTYPE']!='O')?$page_data['PAYMENTTYPE']:__('offline');?></span></li>

		<?php    
		
       }else{
       ?>
	 <li><span class="title"><?php echo __('no_data');?></span></li> 
       
       <?php 
       }

?>