        <?php defined('SYSPATH') OR die("No direct access allowed."); 
$srch_from_date = isset($srch['fromdate'])?$srch['fromdate']:"";
$srch_to_date = isset($srch['todate'])?$srch['todate']:"";
//For sort All jobs order status
$sort_val = isset($srch["order_search"]) ? trim($srch["order_search"]) :''; 
//For search username

$username_list = isset($srch["username_search"]) ? $srch["username_search"] :'';

//For CSS class deefine in the table if the data's available
$total_transactions=count($buynow_transaction_list);
$table_css=$export_excel_button="";
$table_css="";
if($total_transactions > 0)
{  $table_css='class="table_border"';  }?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmtransaction" id="frmtransaction" action="buynow_transaction_search">
            <table class="list_table1 fl clr" border="0" width="110%" cellpadding="5" cellspacing="0">
                <tr>
					 <td valign="top"><label><?php echo __('user_label'); ?></label></td>
                    <td valign="top">
                        <select name="username_search" id="username_search">
							<option value=""><?php echo __('select_label'); ?></option>
				            <?php 
							//code to display username drop down
								foreach($all_username as $userlist) { 
								$selected_username="";  	
								$selected_username=($userlist['id']==trim($username_list)) ? " selected='selected' " : "";
								array_filter($userlist); 
							 ?>
                                <option value="<?php echo $userlist['id']; ?>"  <?php echo $selected_username; ?>><?php echo ucfirst($userlist['username']);?></option>
							
							<?php } ?>
                        </select>

                    </td>                  
             
                    <td valign="top"><label> <?php echo __('product_order',array(':param'=> $product_settings[0]['alternate_name']));?></label></td>

                    <td valign="top">
									<input type="text" name="order_search"  maxlength = "32" id="order_search" value="<?php echo isset($sort_val) ? trim($sort_val) :'';  ?>" />
										 <span class="search_info_label"><?php echo __('srch_info_order_keyword');?></span>
                    </td>
                    </tr>
 		    <tr>
		                     <td valign="top"><label><?php echo __('from_date_label');?></label></td>
		                     <td valign="top">
		                     <input type="text" name="fromdate" id="fromdate" value="<?php echo $srch_from_date; ?>" class="DatePicker" readonly="readonly">
		                     </td>
	 
	                             <td valign="top"><label><?php echo __('to_date_label');?></label></td>
		                     <td valign="top">             
             <input type="text" name="todate" id="todate" value="<?php echo $srch_to_date; ?>" class="DatePicker" readonly="readonly"> 
		                     </td> 
                    </tr> 
                  <tr>
		                <td colspan="4" style="padding-left:300px;">
		                   		<input type="submit" value="<?php echo __('button_search'); ?>" title="<?php echo __('button_search'); ?>" name="search_transaction" />
                           		<input type="button" value="<?php echo __('button_cancel'); ?>" title="<?php echo __('button_cancel'); ?>" onclick="location.href='<?php echo URL_BASE;?>admin/buynow/buynow'" />
                        </td>                    
                 </tr>
            </table>
<div class="clr">&nbsp;</div>
<table cellspacing="1" cellpadding="10" align="center" width="100%" <?php echo $table_css; ?>>
<?php if($total_transactions > 0){ ?>
	<!--** transactions Listings Starts Here ** -->
        <tr class="rowhead">
                <th align="left" width="3%"><?php echo __('sno_label'); ?></th>
               
                <th align="center" width="15%"><?php echo __('username_label'); ?></th>
                <th align="left" width="25%"><?php echo __('details_label'); ?></th>
               
                <th align="center" width="15%"><?php echo __('debit_label',array(':param'=>$site_settings[0]['site_paypal_currency'])); ?></th>
		
		
		<th align="left" width="7%"><?php echo __('transactions_type'); ?></th>
                <th align="center" width="10%"><?php echo __('transactions_created_date'); ?></th>
        </tr>    
        <?php 
         
         $sno=$offset; /* For Serial No */
         
         foreach($buynow_transaction_list as $all_transaction_list){
	   
         
         $sno++;
         
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; ?>
         <tr class="<?php echo $trcolor; ?>">
       
                <td align="left">
                <?php echo $sno; ?>
                </td>
                          
                <td align="left">
                <span style="color:#0B61B1">
                <?php echo ucfirst($all_transaction_list['username']);?></span>
                </td> 
                <td align="left">
                <b class="fl"><?php if($all_transaction_list['username']!=""){echo __('username_label').":"."&nbsp"." ";}else{echo "";}?></b>

                <span style="color:#0B61B1">	
                <?php echo ucfirst($all_transaction_list['username']);?>
                </span>
		
		
                <b class="fl clr mt5"><?php if($all_transaction_list['order_no']){ echo __('product_order',array(':param'=> $product_settings[0]['alternate_name'])).":".""."".$all_transaction_list['order_no']."<br/>";}else{echo "";}?>
                </b>
		
		
		<b class="fl clr mt5"><?php echo __('product_cost').":".""."".$site_currency." ".Commonfunction::numberformat(($all_transaction_list['amount']*$all_transaction_list['quantity']))."<br/>";?>
               </b>
		
		<?php $shippingfee=($all_transaction_list['shippingamount']!='')?$site_currency." ".Commonfunction::numberformat($all_transaction_list['shippingamount']):$site_currency." 0.00";?>
		
		<b class="fl clr mt5"><?php echo  __('shipping_fee').":".""."".$shippingfee."<br/>";?>
                </b>
	
                
                </td>                               
                                         
                <td align="center">
		 <?php $sfee=($all_transaction_list['shippingamount']!='')?$all_transaction_list['shippingamount']:0; ?>   
                <?php echo $site_currency." ".Commonfunction::numberformat(($all_transaction_list['amount']*$all_transaction_list['quantity'])+$sfee); ?>
                </td> 
                <td align="center">
                <?php echo  ucfirst($all_transaction_list['payment_type']); ?>
                </td>
                 <td align="center">
                <?php echo $all_transaction_list['transaction_date']; ?>
                </td>      
                </tr>
		<?php } 
		 }
	// ** transaction Listings Ends Here ** //
		 else { 
	// ** transaction is Found Means ** //
		?>
       	<tr>
        	<td class="nodata"><?php echo __('no_transaction'); ?></td>
        </tr>
        <?php } ?>
        
</table>
</form>
	</div>
	<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>	
<div class="clr">&nbsp;</div>

<div class="pagination">
	<?php if(($action != 'buynow_transaction_search') && $total_transactions > 0): ?>
	 <p><?php echo $pag_data->render(); ?></p> 
	<?php endif; ?>
</div>
<div class="clr">&nbsp;</div>

</div>

<script type="text/javascript">
$(function() {
		var dates = $( "#fromdate, #todate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: false,
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "fromdate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );

			}
		});
	});

$(document).ready(function(){
      toggle(7);
});
</script>
