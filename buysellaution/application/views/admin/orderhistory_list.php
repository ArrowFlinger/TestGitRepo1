        <?php defined('SYSPATH') OR die("No direct access allowed."); 
$srch_from_date = isset($_REQUEST['fromdate'])?$_REQUEST['fromdate']:"";
$srch_to_date = isset($_REQUEST['todate'])?$_REQUEST['todate']:"";
//For sort All jobs order status
$sort_val = isset($_REQUEST["order_search"]) ? trim($_REQUEST["order_search"]) :''; 
//For search username

$username_list = isset($_REQUEST["username_search"]) ? $_REQUEST["username_search"] :'';

//For CSS class deefine in the table if the data's available
$total_transactions=count($all_transaction_list);
$table_css=$export_excel_button="";
$table_css="";
if($total_transactions > 0)
{  $table_css='class="table_border"';  }?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmtransaction" id="frmtransaction">
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
		                     <input type="text" name="fromdate" id="fromdate" value="<?php echo $srch_from_date; ?>" class="DatePicker" >
		                     </td>
	 
	                             <td valign="top"><label><?php echo __('to_date_label');?></label></td>
		                     <td valign="top">             
		                     <input type="text" name="todate" id="todate" value="<?php echo $srch_to_date; ?>" class="DatePicker" > 
		                     </td> 
                    </tr>
		     <tr>
		    <td><label><?php echo __('auction_type_label');?></label></td>
		    <td valign="top">
		                     <select name="filter_type">
					<option value=""><?php echo __('all_label'); ?></option>
					
					  <?php foreach($auction_type as $types): ?>
					<option value="<?php echo ucfirst($types['typename']);?>" <?php echo (isset($srch['filter_type']) && $srch['filter_type']=="A")?"selected=selected":"";?>><?php echo ucfirst($types['typename']);?></option>
					<?php  endforeach;?>
					
				     </select>
		                     </td>
		    <td><label><?php echo __('Order Status');?></label></td>
		    <td valign="top">
		                     <select name="filter_order">
					<option value=""><?php echo __('all_label'); ?></option>
					<option value="P" <?php echo (isset($srch['filter_order']) && $srch['filter_order']=="P")?"selected=selected":"";?>>Pending</option>
					<option value="S"<?php echo (isset($srch['filter_order']) && $srch['filter_order']=="S")?"selected=selected":"";?>>Success</option>
					<option value="C"<?php echo (isset($srch['filter_order']) && $srch['filter_order']=="C")?"selected=selected":"";?>>Completed</option>
					
				     </select>
		                     </td>
		    
		  </tr>
		     
                  <tr>
		                <td colspan="4" style="padding-left:300px;">
		                   		<input type="submit" value="<?php echo __('button_search'); ?>" title="<?php echo __('button_search'); ?>" name="search_transaction" />
                           		<input type="button" value="<?php echo __('button_cancel'); ?>" title="<?php echo __('button_cancel'); ?>" onclick="location.href='<?php echo URL_BASE;?>transaction/orderhistory'" />
                        </td>                    
                 </tr>
		 
            </table>
<div class="clr">&nbsp;</div>
<table cellspacing="1" cellpadding="10" align="center" width="100%" <?php echo $table_css; ?>>
<?php if($total_transactions > 0){ ?>
	<!--** transactions Listings Starts Here ** -->
        <tr class="rowhead">
                <th align="left" width="3%"><?php echo __('sno_label'); ?></th>
               
                <th align="center" width="15%"><?php echo __('buyer_name'); ?>/<?php echo __('action_label'); ?></th>
                <th align="left" width="25%"><?php echo __('description_label'); ?></th>
                <th align="left" width="15%"><?php echo __('auction_type_label'); ?></th>
                <th align="center" width="15%"><?php echo __('Order Status'); ?></th>
                <th align="left" width="7%"><?php echo __('transactions_type'); ?></th>
                 <th align="center" width="10%"><?php echo __('transactions_created_date'); ?></th>
        </tr>    
        <?php 
         
         $sno=$offset; /* For Serial No */
         
         foreach($all_transaction_list as $all_transaction_list){
	//print_r($all_transaction_list);exit;         
         $sno++;
         
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; ?>
         <tr class="<?php echo $trcolor; ?>">
       
                <td align="left">
                <?php echo $sno; ?>
                </td>
                          
                <td align="left">
                <span style="color:#0B61B1">
                <?php echo ucfirst($all_transaction_list['username']);?> <br/><br/>
		</span>
		 <?php echo '<a href="'.URL_BASE.'transaction/orderhistory/'.$all_transaction_list['order_id'].' " class="viewicon" title='.__('view').'  ></a>'; ?>
		<?php if($all_transaction_list['shipping_status']!='S'){
		?>
		<img src="<?php echo ADMINIMGPATH."notshipped.png";?>" width="20" style="position: absolute; margin: -6px 0 0 5px;" title="Shipping is pending."/>
		<?php } else {?>
		<img src="<?php echo ADMINIMGPATH."shipped.png";?>" width="20" style="position: absolute; margin: -6px 0 0 5px;" title="Completed on shipping."/>
		<?php } ?>
                </td> 
                <td align="left">
                <b class="fl"></b>

                <span style="color:#0B61B1">	
                <?php echo ucfirst($all_transaction_list['product_name']);?>
                </span>	
                <b class="fl clr mt5"><?php if($all_transaction_list['res_order']){ echo __('product_order',array(':param'=> $product_settings[0]['alternate_name'])).":".""."".$all_transaction_list['res_order']."<br/>";}else{echo "";}?>
                </b> 
                <table style="clear:both;float:left;width:100%;">
                </table>
                </td>                               
                <td align="center">
                 <?php echo ucfirst($all_transaction_list['bidmethod']);?>
                </td>                               
                <td align="center">
		    <?php $status=$all_transaction_list['order_status'];
		    
		    switch($status)
		    {
			case 'P':
			    
			    echo __('pending_status');
			    break;
			case 'C':
			    echo __('completed_status');
			    break;
			default:
			     echo __('success_status');
			
		    }
		    
		    
		    ?>
                </td> 
                <td align="center">
                <?php if($all_transaction_list['payment_type']!='offline'){echo ucfirst($all_transaction_list['payment_gatway']	);}else{ echo __('offline');} ?>
                </td> 
                 <td align="center">
                <?php echo $all_transaction_list['order_date']; ?>
                </td>      
                </tr>
		<?php } 
		 }
	// ** transaction Listings Ends Here ** //
		 else { 
	// ** transaction is Found Means ** //
		?>
       	<tr>
        	<td class="nodata"><?php echo __('no_data'); ?></td>
        </tr>
        <?php } ?>
        
</table>
</form>
	</div>
	<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>	
<div class="clr">&nbsp;</div>
<div class="pagination">
	<?php if(($action != 'transaction_search') && $total_transactions > 0): ?>
	 <p><?php echo $pag_data->render(); ?></p> 
	<?php endif; ?>
</div>
<div class="clr">&nbsp;</div>

</div>

<script type="text/javascript">
$(function() {
    
      toggle(7);
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

</script>

