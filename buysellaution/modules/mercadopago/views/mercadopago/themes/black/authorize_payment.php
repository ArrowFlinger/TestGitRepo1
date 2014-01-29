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
<form method="POST" name="authorize_form" action="" name="DoDirectPaymentForm">
<div style="float:left;clear:both;width:800px; margin:0 auto;">
   <table  border="0" cellpadding="3" align='center' id="credit_table" width='100%'>
	<tr>
	<th align="left"><h2></h2></th>
	<?/*<th align="left"><h2><?php echo __('Billing_Address');?></h2></th>*/?>
	</tr>
	<tr>
	<?/*<td width='50%'><?php echo __('First_Name');?>:</td>*/?>
	<?/* <td><?php echo __('Address_1');?>:</td> */?>
	</tr>
	
	<tr>
	<?/*<td align=left>
	<input type="text" size="30" maxlength="25" name="firstName"  placeholder="<?php echo __('First_Name');?>" class="required" title="<?php echo __('First_Name');?>"
	value="<?php echo (isset($validator['firstName']))?$validator['firstName']:""; ?>">
	<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
	<?php echo (isset($error['firstName']))?$error['firstName']:"";  ?></span>
	</td>*/?>
	<?/* <td>
	<input type="text" size="25" maxlength="100" name="address1"  placeholder="<?php echo __('Address_1');?>" class="required" title="<?php echo __('Address_1');?>"
   value="<?php echo (isset($validator['address1']))?$validator['address1']:""; ?>">
	<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
	<?php echo (isset($error['address1']))?$error['address1']:"";  ?></span>
	</td>*/?>
	</tr>
	
	<tr>
		<?/*<td><?php echo __('Last_Name');?>:</td>*/?>
		<?/* <td><?php echo __('Address_2');?>:</td> */?>
	</tr>	
	
	<tr>
		<?/*<td>
		<input type="text" size="30" maxlength="32" name="lastName" placeholder='<?php echo __('Last_Name');?>' class="required" title="<?php echo __('Last_Name');?>"
		value="<?php echo (isset($validator['lastName']))?$validator['lastName']:""; ?>">
		<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
		<?php echo (isset($error['lastName']))?$error['lastName']:"";  ?></span>
		</td>*/?>
		<?/*<td><input type="text"  size="25" class="req_option" maxlength="100" name="address2" placeholder='<?php echo __('Address_2');?>'
		value="<?php echo (isset($validator['address2']))?$validator['address2']:""; ?>" title='<?php echo __('Address_2');?>'>
		<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
		<?php echo (isset($error['address2']))?$error['address2']:"";  ?></span>
		<br />
		<!--span style="width:200px;font:italic 12px arial;clear:both;">(optional)</span-->
		</td>*/?>
	</tr>
	<tr>
		<td><?php echo __('Card_Type');?>:</td>
		<?/*<td><?php echo __('City');?>:</td>*/?>
	</tr>	
	<tr>
	<td>
	<select name="creditCardType" class="credit_card">
		<option value="Visa" selected><?php echo __('Visa');?></option>
		<option value="MasterCard"><?php echo __('MasterCard');?></option>
		<option value="Discover"><?php echo __('Discover');?></option>
		<option value="Amex"><?php echo __('American_Express');?></option>
	</select>
	</td>
	<?/*<td>
	<input type="text" size="25" maxlength="40" name="city" placeholder='<?php echo __('City');?>' class="required" title="<?php echo __('City');?>"
	value="<?php echo (isset($validator['city']))?$validator['city']:""; ?>">
	<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
	<?php echo (isset($error['city']))?$error['city']:"";  ?></span>
	</td>*/?>
	</tr>
	<tr>
		<td><?php echo __('Card_Number');?>:</td>
		<?/*<td><?php echo __('State');?>:</td>*/?>
	</tr>
	<tr>	
		<td><input type="text" size="19" maxlength="19" name="creditCardNumber" placeholder='<?php echo __('Card_Number');?>' class="required" title="<?php echo __('Card_Number');?>"
		value="<?php echo (isset($validator['creditCardNumber']))?$validator['creditCardNumber']:""; ?>">
		<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
		<?php echo (isset($error['creditCardNumber']))?$error['creditCardNumber']:"";  ?></span>
		</td>
		<?/*<td><input type="text" size="10" name="state" placeholder='<?php echo __('State');?>' class="required" title="<?php echo __('State');?>"
	   value="<?php echo (isset($validator['state']))?$validator['state']:""; ?>"><br>
		<span style="width:200px;font:italic 12px arial;clear:both;">(<?php echo __('2_Characters');?>)</span>
		<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
		<?php echo (isset($error['state']))?$error['state']:"";  ?></span>
		</td>*/?>
	</tr>
	<tr>
		<td><?php echo __('Expiration_Date');?>:</td>
		<?/*<td><?php echo __('ZIP_Code');?>:</td>*/?>
	</tr>
	<tr>
		<td>
			<select name="expDateMonth" class="credit_card">
				<option value=1>01</option>
				<option value=2>02</option>
				<option value=3>03</option>
				<option value=4>04</option>
				<option value=5>05</option>
				<option value=6>06</option>
				<option value=7>07</option>
				<option value=8>08</option>
				<option value=9>09</option>
				<option value=10>10</option>
				<option value=11>11</option>
				<option value=12>12</option>
			</select>
			<select name="expDateYear" class="credit_card">
				<option value=2011 >2011</option>
				<option value=2012 selected>2012</option>
				<option value=2013>2013</option>
				<option value=2014>2014</option>
				<option value=2015>2015</option>
				<option value=2016>2016</option>
				<option value=2017>2017</option>
				<option value=2018>2018</option>
				<option value=2019>2019</option>
				<option value=2020>2020</option>
			</select>
		</td>
		<?/*<td>
		<input type="text" size="10" maxlength="10" minvalue="5" name="zip" placeholder='<?php echo __('Zip');?>' class="required" title="<?php echo __('Zip');?>"
	   value="<?php echo (isset($validator['zip']))?$validator['zip']:""; ?>">
		<br />
		<span style="width:200px;font:italic 12px arial;clear:both;">(<?php echo __('5_or_9_digits')?>)</span>
		<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
		<?php echo (isset($error['zip']))?$error['zip']:"";  ?></span>
		</td>*/?>
	</tr>
	
	<tr>
		<td><?php echo __('CVV');?>:</td>
		<?/*<td><?php echo __('Country');?>:</td>*/?>
	</tr>
	
	<tr>
		<td>
		<input type="text" size="3" maxlength="4" name="cvv2Number"  placeholder='<?php echo __('CVV');?>' class="required" title="<?php echo __('CVV');?>"
		value="<?php echo (isset($validator['cvv2Number']))?$validator['cvv2Number']:""; ?>">
		<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
		<?php echo (isset($error['cvv2Number']))?$error['cvv2Number']:"";  ?></span>
		</td>
		<?/*<td><input type="text" size="10" class="required"  name="countrycode" placeholder='<?php echo __('Country');?>' title="<?php echo __('Country');?>"
		value="<?php echo (isset($validator['countrycode']))?$validator['countrycode']:""; ?>">
		<br /><span style="width:200px;font:italic 12px arial;clear:both;">(<?php echo __('2_Characters');?>)</span>
		<br><span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
		<?php echo (isset($error['countrycode']))?$error['countrycode']:"";  ?></span>
		</td>*/?>
	</tr>

	</table>
   <input type="hidden" name="amount" id="amount" value="<?php echo $amount; ?>" />
   <input type="hidden" name="user" value="<?php echo $user;?>" />
	<input type="hidden" name="currency" value="<?php echo $currency;?>" />
	<input type="hidden" name="packname" value="<?php echo $pack_name;?>" />
	<input type="hidden" name="mail" value="<?php echo $email;?>" />
	<input type="hidden" name="pack_id" value="<?php echo $package_id;?>" />
	<span class="submit fl clr ml55"><input class="bnone " name='authorize_pay_submit' type="Submit" value="<?php echo __('Pay_Now');?>" id=""></span>

</div>
</form>
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
     
     