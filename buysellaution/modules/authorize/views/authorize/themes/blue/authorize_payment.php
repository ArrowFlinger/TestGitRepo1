<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="wrapper_outer">
            <div class="wrapper_inner">
                <div class="wrapper">
                      <div class="auctions_black_authorize_top_bg">
                         <div class="auctions_black_authorize_top_left"></div>
                         <div class="auctions_black_authorize_top_mid">
                             <h2><?php echo __('authorize_authentication');?></h2>
                         </div>
                         <div class="auctions_black_authorize_top_right"></div>

                     </div>
		      
		      
		      
                     <div class="actions_black_autorize_mid_bg" id="authrize_payment_page">
                        <div class="mt15"></div>
                    
				<form method="POST" name="authorize_form" action="" name="DoDirectPaymentForm">
                            <div class="card_detail">
                                <label><?php echo __('Card_Type');?>:</label>
                                <div class="select_card_type">
                                    <div class="input_box_left"></div>
                                    <div class="input_box_mid">
                                        <div class="top_select">
                                    <select  name="creditCardType" class="select" title="<?php echo __('select_card_type');?>">     
														<option value="Visa" selected><?php echo __('Visa');?></option>
														<option value="MasterCard"><?php echo __('MasterCard');?></option>
														<option value="Discover"><?php echo __('Discover');?></option>
														<option value="Amex"><?php echo __('American_Express');?></option>                                        
														</select>
                                        </div>
                                    </div>
                                    <div class="input_box_right"></div>
                                    <span><?php echo __('ex_visa');?></span>
                                </div>
                            </div>
                            <div class="card_detail">
                                <label><?php echo __('Card_Number');?>:</label>
                                <div class="select_card_type">
                                    <div class="input_box_left"></div>
                                    <div class="input_box_mid">

   <input type="text"  maxlength="19" name="creditCardNumber"  title="<?php echo __('Card_Number');?>"
								value="<?php echo (isset($validator['creditCardNumber']))?$validator['creditCardNumber']:""; ?>" />
								                                    </div>
                                    <div class="input_box_right"></div>
                                    <span><?php echo __('eg_credit_card_number'); ?></span>
				    <span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
								<?php echo (isset($error['creditCardNumber']))?$error['creditCardNumber']:"";  ?></span>	
                                </div>

                            </div>
                            <div class="card_detail">
                                <label><?php echo __('Expiration_Date');?>:</label>
                                <div class="month">
                                    <div class="input_box_left"></div>
                                    <div class="input_box_mid">
                                        <div class="month_select">
                                       <select class="select"  name="expDateMonth" title="<?php echo __('month_label');?>">
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
                                        </div>
                                    </div>
                                    <div class="input_box_right"></div>
                                    <span><?php echo __('eg_expiration_month');?></span>
												
												
                                </div>
                                <div class="year">
                                    <div class="input_box_left"></div>
                                    <div class="input_box_mid">
                                        <div class="year_select">
                                      <select  name="expDateYear" class="select" title="<?php echo __('year_label'); ?>">
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
                                        </div>
                                    </div>
                                    <div class="input_box_right"></div>
                                    <span><?php echo __('eg_expiration_year'); ?></span>
                                </div>
										  
												 
                            </div>
                            <div class="card_detail">
                                <label><?php echo __('CVV');?>:</label>
                                <div class="select_card_type">
                                    <div class="input_box_left"></div>
                                    <div class="input_box_mid">
                                    <input type="text" maxlength="4" name="cvv2Number"   title="<?php echo __('CVV');?>"
		value="<?php echo (isset($validator['cvv2Number']))?$validator['cvv2Number']:""; ?>"   />		
						
                                    </div>
                                    <div class="input_box_right"></div>
                                    <span><?php echo __('eg_cvv'); ?></span>
				      <span style='font:bold 11px Arial, Helvetica, sans-serif;color:#f00;'>
				<?php echo (isset($error['cvv2Number']))?$error['cvv2Number']:"";  ?></span>
                                </div>                            
                            </div>
                            <div class="submit">
                                <div class="paynow_but_left"></div>
                                <div class="paynow_but_mid">
                                 <input name='authorize_pay_submit' type="Submit" value="<?php echo __('Pay_Now');?>">
                                </div>
                                <div class="paynow_but_right"></div>
                            </div>
			    <input type="hidden" name="amount" id="amount" value="<?php echo $amount; ?>" />
				<input type="hidden" name="user" value="<?php echo $user;?>" />
				<input type="hidden" name="currency" value="<?php echo $currency;?>" />
				<input type="hidden" name="packname" value="<?php echo $pack_name;?>" />
				<input type="hidden" name="mail" value="<?php echo $email;?>" />
				<input type="hidden" name="pack_id" value="<?php echo $package_id;?>" />
			    
                        </form>
                     </div>
                     <div class="actions_black_autorize_bottom_bg">
                         <div class="authorize_border_bg_left"></div>
                         <div class="authorize_border_bg_mid"></div>
                         <div class="authorize_border_bg_right"></div>
                     </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
	$(document).ready(function(){	

		if (!$.browser.opera) {
    
			// select element styling
			$('select.select').each(function(){
				var title = $(this).attr('title');
				if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
				$(this)
					.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
					.after('<span class="select">' + title + '</span>')
					.change(function(){
						val = $('option:selected',this).text();
						$(this).next().text(val);
						})
			});

		};
		
	});
</script>