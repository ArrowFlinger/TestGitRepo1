<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
			<div class="title-right">
				<div class="title-mid">
					<h2 class="fl clr pl10" title="<?php echo __('menu_buynow_transaction');?>"><?php echo __('menu_buynow_transaction');?></h2>
				</div>
			</div>
        </div>  	
        <div class="action_deal_list  clearfix">	
        <?php if($count_transaction>0):?>
        <div class="watch_list_items watch_list_items2 trans_watch_list_items fl clr">	
		<div id="managetable" class="fl clr">
		<!--List products-->
        <div class="table-left">
			<div class="table-right">
				<div class="table-mid">		
					<table width="660" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
							<tr>
									<th  align="center"><?php echo __('transaction_date');?></th>
									<th width="120" align="center"><?php echo __('product_name');?></th>
									<th width="90" align="center"><b><?php echo __('product_info');?></b></th>
									<th width="120" align="center"><b><?php echo __('total_amount');?></b></th>
									<th width="110" align="center"><b><?php echo __('credit_label');?></b></th>
									<th width="100" align="center"><b><?php  echo __('debit_label');?></b></th>
									<th width="100" align="center"><b><?php  echo __('transactions_type');?></b></th>
							</tr>
					</table>
				</div>
			</div>
        </div>
		
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
        <?php 
        $count=$count_transaction;
        $i=0;
        foreach($transactions as $transaction):
        $bg_none=($i==$count-1)?"bg_none":"";?>
        <tr>
                <td align="left" width="100" class="<?php echo $bg_none;?>">
					<p class="fl"><?php echo $transaction['transaction_date'];?></p>
                </td>
                <td width="250" align="center" class="<?php echo $bg_none;?>">
					<span class="mail_link" style="display:block; padding:0 0 0 20px;"><?php echo ucfirst($transaction['product_name']);?></span>
                </td>
                <td align="center" class="<?php echo $bg_none;?>">
					<p class="fl"><?php echo $transaction['description']!=""?ucfirst($transaction['description']):"--";?></p>
                </td>
                <td align="center" width="150" class="<?php echo $bg_none;?>">
					<p><?php echo $site_currency." ".Commonfunction::numberformat($transaction['amount']);?></p>
                </td>
                <td align="center" width="100" class="<?php echo $bg_none;?>">
					<b style="color:#3d3d3d; font-weight:normal; padding:0 0 0 22px; width:51px;"><?php if($transaction['amount_type'] == CREDIT){echo $site_currency." ".Commonfunction::numberformat($transaction['amount']);}else{echo "--";} ?></b>
                </td>
                <td align="center" width="20" class="<?php echo $bg_none;?>">
					<p class="watch_list_time fl"> <?php if($transaction['amount_type'] == DEBIT){echo $site_currency." ".Commonfunction::numberformat($transaction['amount']);}else{echo "--";} ?></p>
                </td>
                <td align="center" class="<?php echo $bg_none;?>"><p class="fl">
					<?php if($transaction['amount_type'] == DEBIT){echo __('paypal');}else{echo __('offline');} ?></p></td>
                </td>
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
        <!--Pagination-->
        <div class="pagination">
        <p><?php echo $pagination->render(); ?></p>
        </div>
        <!--End of Pagination-->
	</div>
	<div class="auction-bl">
		<div class="auction-br">
			<div class="auction-bm">
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#products_transactions_active").addClass("user_link_active");});
</script>
