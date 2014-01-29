<?php defined('SYSPATH') OR die("No direct access allowed.");

$srch_from_date = isset($srch['fromdate'])?$srch['fromdate']:"";
$srch_to_date = isset($srch['todate'])?$srch['todate']:"";
$sort_val=isset($srch['order_search'])?$srch['order_search']:"";

$refund_list_count=count($wonauctions_results);

$table_css="";
  $table_css='class="table_border"';
  
if($refund_list_count > 0)
{  $table_css='class="table_border"';  } ?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmrefundlist" id="frmrefundlist" action="refundlist_search">
            <table class="list_table1 fl clr" border="0" width="100%" cellpadding="5" cellspacing="0">
                <tr>
					
                    <td valign="top"><label> <?php echo __('product_name',array(':param'=> $product_settings[0]['alternate_name']));?></label></td>

                    <td valign="top">
                        <input type="text" name="order_search"  maxlength = "32" id="order_search" value="<?php echo isset($sort_val) ? trim($sort_val) :'';  ?>" />
                        <span class="search_info_label"><?php echo __('srch_info_product_keyword');?></span>
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
		                <td colspan="4" style="padding-left:300px;">
		                   		<input type="submit" value="<?php echo __('button_search'); ?>" title="<?php echo __('button_search'); ?>" name="search_refundlist" />
                           		<input type="button" value="<?php echo __('button_cancel'); ?>" title="<?php echo __('button_cancel'); ?>" onclick="location.href='<?php echo URL_BASE;?>adminauction/refundlist'" />
                        </td>                    
                 </tr>
            </table>
        </div>
</div>
           
            <?php

//For Notice Messages
//===================
$sucessful_message=Message::display();

if($sucessful_message) { ?>
    <div id="messagedisplay" class="padding_150">
         <div class="notice_message">
            <?php echo $sucessful_message; ?>
         </div>
    </div>
<?php } ?>
<div class="container_content fl clr">
    <div class="cont_container mt15 mt10">
        <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle">
                 <div class="clr" >&nbsp;</div>
                  
 
                      
           <?php 
                              $sno=0;/* For Serial No */ 
                  foreach($wonauctions_results as $won_amount)                                             
                 {
                        
                              $user_spents=$users->winner_user_amount_spent($won_amount['product_id'],$won_amount['lastbidder_userid']);
                              $user_spents_amount=count($user_spents);
				
				$amount=0;
				foreach($user_spents as $user_spent)
				{		
					$amount += $user_spent['price'];
				}
				
				
			        if($won_amount['product_cost']<$won_amount['current_price'])
			        {
				        $refund=($won_amount['current_price']-$won_amount['product_cost'])*$won_amount['current_price']; 
			        }
				else 
				{
					$refund="0"; 
				}
					                                                            
                                                                    
                                  if ($refund>$won_amount['product_cost'])
                                {	   ?>
                                <table cellspacing="1" cellpadding="5" width="100%" align="center" <?php echo $table_css; ?>>
                            <tr class="rowhead">
                                <th align="center" width="8%"><?php echo __('sno_label'); ?></th>
                                <th align="left" width="20%"><?php echo __('user_name'); ?></th>
                                <th align="left" width="20%"><?php echo __('product_name'); ?></th>
                                <th align="center" width="20%"><?php echo __('product_image'); ?></th>
                                <th align="center" width="15%"><?php echo __('product_cost'); ?></th>
                                <th align="center" width="22%"><?php echo __('user_paid_price');?></th>
                                <th align="center" width="22%"><?php echo __('user_refund');?></th>
                                 <th align="center" width="22%"><?php echo __('enddate_lable');?></th>
                            </tr> 
            <?php    break; } }?>
                <?php 
                              $sno=0;/* For Serial No */ 
                  foreach($wonauctions_results as $won_amount)                                             
                 {
                        
                              $user_spents=$users->winner_user_amount_spent($won_amount['product_id'],$won_amount['lastbidder_userid']);
                              $user_spents_amount=count($user_spents);
				
				$amount=0;
				foreach($user_spents as $user_spent)
				{		
					$amount += $user_spent['price'];
				}
				
				
			        if($won_amount['product_cost']<$amount)
			        {
				        $refund=($won_amount['current_price']-$won_amount['product_cost'])*$won_amount['current_price']; 
			        }
				else 
				{
					$refund="0"; 
				}
					                                                            
                                                                    
                                  if ($refund>$won_amount['product_cost'])
                                {		
                                 
                                     $sno++;
                                     
                                     $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                                    
                                    ?>
                                    <tr class="<?php echo $trcolor; ?>">
                                                                    
                                <td width="8%" align="center">
                                        <?php echo $sno; ?>
                                </td>
                                <td align="left" width="20%">
                                      <?php echo ucfirst($won_amount['username']); ?>
                                </td>
                                <td align="left" width="20%">
                                       <?php echo ucfirst($won_amount['product_name']); ?>
                                </td>
                                <td align="center" width="20%">
                                       <img src="<?php echo URL_BASE.PRODUCTS_IMGPATH_THUMB.$won_amount['product_image'];?>" width="90" height="50"/>
                                </td>

                                <td align="center" width="12%">
                                     <?php  echo  $site_currency." ".Commonfunction::numberformat($won_amount['product_cost']); ?>
                                </td>

                                <td align="center" width="28%">
                                <?php  echo  $site_currency." ".Commonfunction::numberformat($won_amount['current_price']); ?>
                                </td>
                                <td align="center" width="28%">
                                        <?php  echo  $site_currency." ".Commonfunction::numberformat($refund); ?>
                                </td> 
                                <td align="left" width="20%">
                                      <?php echo ucfirst($won_amount['enddate']); ?>
                                </td>                      

                                </tr>

                                <?php 
                               
                                     }
                      }
                                  
                
                if(isset($sno)==0 || $sno==0)
                { 
                ?>
                <table>
                <tr>
                <td class="nodata"><?php echo __('no_data'); ?></td>
                </tr>
                </table>
                <?php
                }
                ?>              
            </table>

        </form>
      </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        <div class="clr">&nbsp;</div>
			   		
         </div>
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

</script>

