<?php defined('SYSPATH') OR die('No direct access allowed.'); 
$total_count=count($page_data);
?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
<h2><?php echo __('page_payment_log');?></h2>
		 <form method="post" enctype="multipart/form-data" class="admin_form" name="frmlog" id="frmlog">
                <table border="0" cellpadding="10" cellspacing="5" width="99%">
                <?php if($total_count > 0){ ?>
                        <tr>
                                <td width="35%" valign="top"><label><?php echo __('id_label'); ?></label></td>
                                <td>
				<?php echo ($page_data['ID'])?$page_data['ID']:"-";?>
                                </td>
                        </tr>
                        
                          <tr> 
                          <td valign="top"><label><?php echo __('ordered_time_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['ORDERTIME'])?$page_data['ORDERTIME']:"-";?>
                             </td>
                        </tr>                                                
                         <tr>
                                <td valign="top"><label><?php echo __('username_label'); ?></label></td>
                                <td> 
                        		            
        		   <span style="color:#0B61B1"> <?php echo ucfirst($page_data['username']);?></span>
                                </td>
                        </tr> 
                         <tr>
                                <td valign="top"><label><?php echo __('ip_label'); ?></label></td>
                                <td>
				<?php echo ($page_data['LOGIN_ID'])?$page_data['LOGIN_ID']:"-";?>          
                                </td>
                        </tr>
                        <tr>
                                <td width="35%" valign="top"><label><?php echo __('transaction_type_label'); ?></label></td>
                                <td>
				<?php echo  ($page_data['TRANSACTIONTYPE'])?$page_data['TRANSACTIONTYPE']:"-";?>   
                                </td>
                        </tr> 
                        <tr>
                         <td width="35%" valign="top"><label><?php echo __('transaction_no_label'); ?></label></td>
                            	<td>
				<?php echo  ($page_data['TRANSACTIONID'])?$page_data['TRANSACTIONID']:"-";?>   
                             </td>
                        </tr> 
                        <tr>
                         <td width="35%" valign="top"><label><?php echo __('payer_email_label'); ?></label></td>
                            	<td>
				<?php echo  ($page_data['EMAIL'])?$page_data['EMAIL']:"-";?> 
                             </td>
                        </tr> 
                         <tr>
                         <td valign="top"><label><?php echo __('payment_date_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['TIMESTAMP'])?$page_data['TIMESTAMP']:"-";?>
                             </td>
                        </tr> 
                         <tr>
                         <td valign="top"><label><?php echo __('receiver_email_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['RECEIVER_EMAIL'])?$page_data['RECEIVER_EMAIL']:"-";?>
                             </td>
                        </tr> 
                        <tr>
                         <td valign="top"><label><?php echo __('payerid_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['PAYERID'])?$page_data['PAYERID']:"-";?>
                             </td>
                        </tr>                                                                                                                                                
                         <tr>
                         <td valign="top"><label><?php echo __('paypal_fees'); ?></label></td>
                            	<td>
				<?php echo ($page_data['FEEAMT'])?$page_data['FEEAMT']:"-";?>
                             </td>
                        </tr> 
                         <tr>
                         <td valign="top"><label><?php echo __('product_cost',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?></label></td>
						<td>
							<?php echo ($page_data['AMT'])?$site_currency." ".Commonfunction::numberformat($page_data['AMT']-$page_data['SHIPPINGAMT']):"-";?>
						</td>
                        </tr> 
                        <tr>
                         <td valign="top"><label><?php echo __('shipping_fee',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?></label></td>
                            	<td>
				<?php echo ($page_data['SHIPPINGAMT'])?$site_currency." ".Commonfunction::numberformat($page_data['SHIPPINGAMT']):"-";?>
                             </td>
                        </tr> 
                         <tr>
                         <td valign="top"><label><?php echo __('total_amount',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?></label></td>
						<td>
							<?php echo ($page_data['AMT'])?$site_currency." ".Commonfunction::numberformat($page_data['AMT']):"-";?>
						</td>
                        </tr> 
                          <tr>
                         <td valign="top"><label><?php echo __('currency_code_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['CURRENCYCODE'])?$page_data['CURRENCYCODE']:"-";?>
                             </td>
                        </tr> 
                         <tr>
                         <td valign="top"><label><?php echo __('receipt_no_label'); ?></label></td>
                            	<td>
 				<?php echo ($page_data['CORRELATIONID'])?$page_data['CORRELATIONID']:"-";?>
                             </td>
                        </tr> 
                        <tr>                                                                                    
                          <td valign="top"><label><?php echo __('pending_status_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['PAYMENTSTATUS']!='S')?$page_data['PAYMENTSTATUS']:__('success');?>
				</td>
                        </tr>
                        <tr>      
                         <td valign="top"><label><?php echo __('pending_reason_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['PENDINGREASON'])?$page_data['PENDINGREASON']:"-";?>
                             </td>
                        </tr>
                        <tr> 
                          <td valign="top"><label><?php echo __('paypal_response_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['PAYERSTATUS'])?$page_data['PAYERSTATUS']:"-";?>
                             </td>
                        </tr> 
                        <tr>     
                         <td valign="top"><label><?php echo __('error_code_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['REASONCODE'])?$page_data['REASONCODE']:"-";?>
                             </td>
                        </tr> 
                         <tr>      
                         <td valign="top"><label><?php echo __('invoice_no_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['INVOICEID'])?$page_data['INVOICEID']:"-";?>
                             </td>
                        </tr>
                         <tr>                                                                                                                                                        
                         <td valign="top"><label><?php echo __('country_code_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['COUNTRYCODE'])?$page_data['COUNTRYCODE']:"-";?>	
                             </td>
                        </tr> 
                         <tr> 
                          <td valign="top"><label><?php echo __('ack_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['ACK'])?$page_data['ACK']:"-";?>	
                             </td>
                        </tr>
                         <tr> 
                          <td valign="top"><label><?php echo __('payment_type_label'); ?></label></td>
                            	<td>
				<?php echo ($page_data['PAYMENTTYPE']!='O')?$page_data['PAYMENTTYPE']:__('offline');?>	
				
                             </td>
                        </tr> 
					 		<?php } 
					
						// ** normal transaction  Listings Ends Here ** //
							 else { 
						// ** No normal transaction is Found Means ** //
							?>
					       	<tr>
					        	<td class="nodata"><?php echo __('no_data'); ?></td>
					        </tr>
					        <?php } ?>                                              

                </table>
        </form>
    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>

