<?php defined("SYSPATH") or die("No direct script access."); ?>
<style type="text/css">
.won_action_items td p, .watch_list_items td p, .package_row2_colm2 b, .package_row2_colm1 label {
        width:87px;
        }
</style>

<div class="content_left_out fl">
<div class="action_content_left fl">
	<div class="title_temp1 fl clr pt10">
    	<h2 class="fl clr pl10" title="<?php echo __('my_transactions');?>"><?php echo __('my_transactions');?></h2>
    </div>    	
<?php if($count_transaction>0):?>
	<div class="watch_list_items fl clr">	
		<div id="managetable" class="fl clr">
		<!--List products-->		
		<table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
		<tr>
		<th align="center"><b><?php echo __('transaction_date');?></b></th>
		<th align="center"><b><?php echo __('package_name');?></b></th>
		<th align="center"><b><?php echo __('package_desc');?></b></th>
		<th align="center"><b><?php echo __('total_amount');?></b></th>
		<th align="center"><b><?php echo __('credit_label');?></b></th>
		<th align="center"><b><?php  echo __('debit_label');?></b></th>
		<th align="center"><b><?php  echo __('transactions_type');?></b></th>
		
		</tr>
		<?php 
		$count=$count_transaction;
		$i=0;
		foreach($transactions as $transaction):
		$bg_none=($i==$count-1)?"bg_none":"";?>
		<tr>
		<td align="center" width="130" class="<?php echo $bg_none;?>"><p class="fl"><?php echo $transaction['transaction_date'];?></p></td>
		<td width="80" align="center" class="<?php echo $bg_none;?>"><span class="mail_link">
		<?php echo ucfirst(Commonfunction::get_name($transaction['type'],$transaction['packageid']));?>
		</span></td>
		<td width="130" align="center" class="<?php echo $bg_none;?>"><p class="fl" title="<?php echo ucfirst(strip_tags($transaction['description'])); ?>"><?php echo $transaction['description']!=""?Text::limit_chars(ucfirst($transaction['description']),100):"--";?></p></td>
		<td align="center" width="100" class="<?php echo $bg_none;?>"><p><?php echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);?></p></td>
		<td align="center" width="100" class="<?php echo $bg_none;?>"><p style="font-weight:normal;"><?php if($transaction['amount_type'] == CREDIT){echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);}else{echo "--";} ?></p></td>
                <td align="center" width="20" class="<?php echo $bg_none;?>"><p class="watch_list_time fl"> <?php if($transaction['amount_type'] == DEBIT){echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);}else{echo "--";} ?></p>
                </td>
                <td align="center" class="<?php echo $bg_none;?>"><p class="fl">
              
		<?php echo $transaction['transaction_type'];?>
		</p></td>
		
		</tr>
		<?php $i++;endforeach; 
		
		?>
		</table>
		</div>
		<div class="clear"></div>
		<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	
	</div><?php else:?>
	<h4 class="no_data clr" style="float:none;"><?php echo __("no_transaction_detail_at_the_moment");?></h4>
	<?php endif;?>
	</div>
<!--Pagination-->
<div class="pagination">
 <p><?php echo $pagination->render(); ?></p>
</div>
<!--End of Pagination-->

</div>


<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_transactions_active").addClass("user_link_active");});
</script>
