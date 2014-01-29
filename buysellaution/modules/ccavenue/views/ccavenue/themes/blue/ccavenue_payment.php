<div class="content_left_out fl"> 
   <div class="content_left fl mt15">    
      <div class="title-left title_temp1">
         <div class="title-right">
            <div class="title-mid">
               <h4 class="no_data fl clr"><?php echo __('Billing_Information');?></h4>
            </div>
         </div>
      </div>
      <div class="deal-left clearfix">
         <div class="action_deal_list clearfix">
            <div class="clear"></div>
<?/*  Customize Code   */?>
<form method="POST" name="ccavenue_form" action="https://www.ccavenue.com/shopzone/cc_details.jsp" name="DoDirectPaymentForm">
   Merchant_Id<input type=hidden name=Merchant_Id value="<?php echo $Merchant_Id; ?>"><br>
	Amount<input type=hidden name=Amount value="<?php echo $Amount; ?>"><br>
	Order_Id<input type=hidden name=Order_Id value="<?php echo $Order_Id; ?>"><br>
	Redirect_Url<input type=hidden name=Redirect_Url value="<?php echo $Redirect_Url; ?>"><br>
	Checksum<input type=hidden name=Checksum value="<?php echo $Checksum; ?>"><br>
	billing_cust_name<input type="hidden" name="billing_cust_name" value="<?php echo $billing_cust_name; ?>"> <br>
	<?/*billing_cust_address<input type="hidden" name="billing_cust_address" value="<?php echo $billing_cust_address; ?>"> <br>
	billing_cust_country<input type="hidden" name="billing_cust_country" value="<?php echo $billing_cust_country; ?>"> <br>
	billing_cust_state<input type="hidden" name="billing_cust_state" value="<?php echo $billing_cust_state; ?>"> <br>
	billing_zip<input type="hidden" name="billing_zip" value="<?php echo $billing_zip; ?>"> <br>
	billing_cust_tel<input type="hidden" name="billing_cust_tel" value="<?php echo $billing_cust_tel; ?>"> <br>*/ ?>
	billing_cust_email<input type="hidden" name="billing_cust_email" value="<?php echo $billing_cust_email; ?>"> <br>
	delivery_cust_name<input type="hidden" name="delivery_cust_name" value="<?php echo $delivery_cust_name; ?>"> <br>
	<?/*delivery_cust_address<input type="hidden" name="delivery_cust_address" value="<?php echo $delivery_cust_address; ?>"> <br>
	delivery_cust_country<input type="hidden" name="delivery_cust_country" value="<?php echo $delivery_cust_country; ?>"> <br>
	delivery_cust_state<input type="hidden" name="delivery_cust_state" value="<?php echo $delivery_cust_state; ?>"> <br>
	delivery_cust_tel<input type="hidden" name="delivery_cust_tel" value="<?php echo $delivery_cust_tel; ?>"> <br>
	delivery_cust_notes<input type="hidden" name="delivery_cust_notes" value="<?php echo $delivery_cust_notes; ?>"> <br>
	Merchant_Param<input type="hidden" name="Merchant_Param" value="<?php echo $Merchant_Param; ?>"> <br> 
	
	Merchant_Param<input type="hidden" name="Merchant_Param" value="'203','1','145','0','12','ccavenue'"> <br>
	
	billing_cust_city<input type="hidden" name="billing_cust_city" value="<?php echo $billing_city; ?>"> <br>
	billing_zip_code<input type="hidden" name="billing_zip_code" value="<?php echo $billing_zip; ?>"> <br>
	delivery_cust_city<input type="hidden" name="delivery_cust_city" value="<?php echo $delivery_city; ?>"><br> 
	delivery_zip_code<input type="hidden" name="delivery_zip_code" value="<?php echo $delivery_zip; ?>"> <br>*/ ?>
	<input type='submit' Value='Submit'>
</form>
<script>
//document.forms["ccavenue_form"].submit();
</script>
<?/*
	<form method="post" action="https://www.ccavenue.com/shopzone/cc_details.jsp" id="ccavenue_form">
	Merchant_Id<input type=hidden name=Merchant_Id value="M_mypocket_13956"><br>
	Amount<input type=hidden name=Amount value="10"><br>
	Order_Id<input type=hidden name=Order_Id value="145-20121221041058"><br>
	Redirect_Url<input type=hidden name=Redirect_Url value="http://192.168.1.89:3000//system/modules/gateway/ccavenue/redirecturl.php"><br>
	Checksum<input type=hidden name=Checksum value="925838154"><br>
	billing_cust_name<input type="hidden" name="billing_cust_name" value="siva"> <br>
	billing_cust_address<input type="hidden" name="billing_cust_address" value=""> <br>
	billing_cust_country<input type="hidden" name="billing_cust_country" value=""> <br>
	billing_cust_state<input type="hidden" name="billing_cust_state" value=""> <br>
	billing_zip<input type="hidden" name="billing_zip" value=""> <br>
	billing_cust_tel<input type="hidden" name="billing_cust_tel" value="34252354"> <br>
	billing_cust_email<input type="hidden" name="billing_cust_email" value="sivakumar.mr@ndot.in"> <br>
	delivery_cust_name<input type="hidden" name="delivery_cust_name" value="siva"> <br>
	delivery_cust_address<input type="hidden" name="delivery_cust_address" value=""> <br>
	delivery_cust_country<input type="hidden" name="delivery_cust_country" value=""> <br>
	delivery_cust_state<input type="hidden" name="delivery_cust_state" value=""> <br>
	delivery_cust_tel<input type="hidden" name="delivery_cust_tel" value="422345432"> <br>
	delivery_cust_notes<input type="hidden" name="delivery_cust_notes" value="SUB-MERCHANT TEST"> <br>
	Merchant_Param<input type="hidden" name="Merchant_Param" value="'203','1','145','0','12','ccavenue'"> <br>
	billing_cust_city<input type="hidden" name="billing_cust_city" value=""> <br>
	billing_zip_code<input type="hidden" name="billing_zip_code" value=""> <br>
	delivery_cust_city<input type="hidden" name="delivery_cust_city" value=""><br> 
	delivery_zip_code<input type="hidden" name="delivery_zip_code" value=""> <br>
	<!--<INPUT TYPE="submit" value="submit">-->
	</form>*/?>
<script>
document.forms["ccavenue_form"].submit();
</script>


<?/*  Customize Code   */?>
<div id="fb-root"></div>
            <div class="bidding_type">
               <div class="bidding_type_lft"></div>
               <div class="bidding_type_mid">
                  <div class="bidding_inner">
                     
                  </div>
               </div>
               <div class="bidding_type_rft"></div>
            </div>
         </div>
      </div>
   </div>   
   <div class="auction-bl">
      <div class="auction-br">
         <div class="auction-bm">
         </div>
      </div>
   </div>
</div>
     
     