<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right" id="mytransactions_page">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('my_transactions'));?>" style="width:131px;"><?php echo strtoupper(__('my_transactions'));?></h1>
		<p style="width:588px;">&nbsp;</p>
	</div>
	<?php if($count_transaction>0):?>
	<div class="message_common">
		<div class="forms_common">
			<div class="title_cont_watchilist">
                                     <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                        <thead>
                            <tr>
                                
			<th width="110" align="center">
				<b><?php echo __('transaction_date');?></b>
			</th>
			<th width="100" align="center">
				<b><?php echo __('package_name');?></b>
			</th>
			<th width="150" align="center">
				<b><?php echo __('package_desc');?></b>
			</th>
			<th width="100" align="center">
				<b><?php echo __('total_amount');?></b>
			</th>
			<th width="60" align="center">
				<b><?php echo __('debit_label');?></b>
			</th>
			<th width="60" align="center">
				<b><?php  echo __('credit_label');?></b>
			</th>
                        </tr>
                                     </thead>
			 <?php foreach($transactions as $transaction):?>

			<tr>
			<td width="110" align="center">
				<h2><?php echo $transaction['transaction_date'];?></h2>
			</td>
			<td width="100" align="center">
					<?php $name=ucfirst(Commonfunction::get_name($transaction['type'],$transaction['packageid']));?>
				
			  <h2 title="<?php echo $name; ?>"><?php echo strlen($name)>19?ucfirst(Text::limit_chars($name,15))."...":ucfirst($name);?></h2>
			</td>

			<td width="150" align="center">
				<h2><?php echo ($transaction['description']!="")?((strlen($transaction['description'])>70)?ucfirst(Text::limit_chars($transaction['description'],66))."...":ucfirst($transaction['description'])):"--";?></h2>
			</td>
			<td width="100" align="center">
				<h2><?php echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);?></h2>
			</td>
			<td width="60" align="center">
				<h2><?php if($transaction['amount_type'] == CREDIT){echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);}else{echo "--";} ?></h2>
			</td>
			<td width="60" align="center">
				 <h2><?php if($transaction['amount_type'] == DEBIT){echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);}else{echo "--";} ?></h2>
			</td>
                        </tr>
			  <?php endforeach;?>
                                     </table>
			</div>
		</div>
	 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	</div>		
	<?php else:?>
	<div class="message_common">
		<h4  style="float:none;"><?php echo __("no_transaction_detail_at_the_moment");?></h4>
		</div>
	<?php endif;?>
	<?php if($count_transaction>0):?>
	<div class="nauction_paginations">
			<p><?php echo $pagination->render(); ?></p>
			</div>
		  <?php endif;?>  
	</div>
	</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function () {$("#my_transactions_active").addClass("act_class");});
</script>
