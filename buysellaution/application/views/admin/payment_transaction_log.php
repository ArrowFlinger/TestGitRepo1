<?php defined('SYSPATH') OR die("No direct access allowed."); 

//For CSS class define in the table if the data's available
$total_log=count($all_payment_transaction_log);

$table_css="";
if($total_log > 0)
{  $table_css='class="table_border"';  }?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmcontactreq" id="frmcontactreq">
			<div class="clr">&nbsp;</div>
			<div<?php if($total_log > 0){ ?> class= "overflow-block"<?php } ?>>
			<table cellspacing="1" cellpadding="10" align="center" width="150%" <?php echo $table_css; ?>>
			<?php if($total_log > 0){ ?>
			<!--** payment transaction log Listings Starts Here ** -->
				<tr class="rowhead">
						<th align="left" width="2%"><?php echo __('sno_label'); ?></th>
						<th align="center" width="3%" ><?php echo __('action_label'); ?></th>
						<th align="center" width="15%"><?php echo __('transactions_created_date');?></th>
						<th align="left" width="10%"><?php echo __('username_label'); ?></th>
						<th align="left" width="10%"><?php echo __('transactionid_label'); ?></th>
						<th align="center" width="10%"><?php echo __('email_label'); ?></th>
						<th align="center" width="15%"><?php echo __('total_amount',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?></th>
						<th align="center" width="10%"><?php echo __('paypal_fees',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?></th>
						<th align="center" width="10%"><?php echo __('status_label'); ?></th>
						<th align="center" width="10%"><?php echo __('paypal_response_label'); ?></th>
						<th align="left" width="20%"><?php echo __('error_code_label'); ?></th>
						<th align="center" width="20%"><?php echo __('ip_address'); ?></th>

       			 </tr>    
				<?php 
				 
				 $sno=$offset; /* For Serial No */
				 
				 foreach($all_payment_transaction_log as $all_payment_transaction){
				 
				 $sno++;
				 
				 $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
				 
				?>
				<tr class="<?php echo $trcolor; ?>">
                <td align="left">
                    <?php echo $sno; ?>
                </td>
                <td align="center">
                <?php echo '<a href="'.URL_BASE.'paymentlog/show_payment_log/'.$all_payment_transaction['TIMESTAMP'].' " style="float:none; display:block;" target="_blank" title ='.__('view').' class="viewicon"></a>' ; ?>
   
                </td>

                <td align="center">
                    <?php echo wordwrap($all_payment_transaction['TIMESTAMP'],15,'<br/>',1); ?>
                </td>

                <td align="left">
                  <?php echo ucfirst($all_payment_transaction['username']); ?>
                </td>
               <td align="center">
                  <?php if($all_payment_transaction['TRANSACTIONID']){echo $all_payment_transaction['TRANSACTIONID'];}else{echo "_ _";} ?>
                </td>               
                <td align="center">
                   <?php if($all_payment_transaction['EMAIL']){echo $all_payment_transaction['EMAIL'];}else{echo "_ _";} ?>
                </td>                
                <td align="center">
					<?php echo $site_currency." ".Commonfunction::numberformat($all_payment_transaction['AMT']);?>
                </td>                
                 <td align="center">
                   <?php echo $site_currency." ".Commonfunction::numberformat($all_payment_transaction['FEEAMT']); ?>
                </td> 
                  <td align="center">
                  <?php if($all_payment_transaction['PAYMENTSTATUS']!='S'){echo $all_payment_transaction['PAYMENTSTATUS'];}else{echo __('success');} ?>
                </td>                                              
                <td align="center">
                <?php if($all_payment_transaction['PAYERSTATUS']){echo $all_payment_transaction['PAYERSTATUS'];}else{echo "_ _";} ?>
                </td>
                <td align="center">
                <?php if($all_payment_transaction['REASONCODE']){echo $all_payment_transaction['REASONCODE'];}else{echo "_ _";} ?>
                </td>                                              
                <td align="center">
                   <?php echo $all_payment_transaction['LOGIN_ID']; ?>
                </td>               


        </tr>
		<?php } 
		 }
	// ** payment transaction log Listings Ends Here ** //
		 else { 
	// ** payment transaction log Listings is Found Means ** //
		?>
       	<tr>
        	<td class="nodata"><?php echo __('no_data'); ?></td>
        </tr>
        <?php } ?>

</table>
</div>

</form>
	</div>
	<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>	
<div class="clr">&nbsp;</div>

<div class="pagination">
<?php if($total_log > 0): ?>
 <p><?php echo $pag_data->render(); ?></p>  
<?php endif; ?>
</div>
<div class="clr">&nbsp;</div>

</div>
<script type="text/javascript">

$(document).ready(function(){
      toggle(7);
});
</script>
