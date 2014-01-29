<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out content_left_out1 fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('my_transactions');?>"><?php echo __('my_transactions');?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">  	
        <div class="action_deal_list action_deal_list2 clearfix">	
        <?php if($count_transaction>0):?>
        <div class="watch_list_items watch_list_items2 fl clr">	
		<div id="managetable">
			          <table width="660" border="0" align="left" cellpadding="0" cellspacing="0"  class="table_top">
<thead>
                <tr>
                        <th width="100" width="center"><?php echo __('transaction_date');?></th>
                        <th width="100" width="center"><?php echo __('package_name');?></th>
                        <th width="100" width="center"><?php echo __('package_desc');?></th>
                        <th width="150" width="center"><?php echo __('total_amount');?></th>
                        <th width="100" width="center"><?php echo __('credit_label');?></th>
                        <th width="100" width="center"><?php  echo __('debit_label');?></th>
                        <th width="100" width="center"><?php  echo __('transactions_type');?></th>
                </tr>
                </thead>
  <tr>
        <?php 
        $count=$count_transaction;
        $i=0;
        foreach($transactions as $transaction):
        $bg_none=($i==$count-1)?"bg_none":"";?>
      
      
                <td width="100" width="center" class="<?php echo $bg_none;?>"><p><?php echo $transaction['transaction_date'];?> &nbsp;</p></td>
                
                <td width="100" width="center" class="<?php echo $bg_none;?>"><p class="mail_link" ><?php echo ucfirst(Commonfunction::get_name($transaction['type'],$transaction['packageid']));?> &nbsp;</p></td>
                <td width="100" width="center"  class="<?php echo $bg_none;?>"><p title="<?php echo ucfirst(strip_tags($transaction['description'])); ?>"><?php echo $transaction['description']!=""?ucfirst($transaction['description']):"--";?> &nbsp;</p></td>
                <td width="150" width="center"  class="<?php echo $bg_none;?>">
                <p><?php echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);?> &nbsp;</p></td>
                <td width="100" width="center" class="<?php echo $bg_none;?>"><p style="color:#3d3d3d; font-weight:normal;"><?php if($transaction['amount_type'] == CREDIT){echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);}else{echo "--";} ?> &nbsp;</p></td>
                <td width="100" width="center"   class="<?php echo $bg_none;?>"><p class="watch_list_time fl"> <?php if($transaction['amount_type'] == DEBIT){echo $site_currency." ".Commonfunction::numberformat($transaction['amount']+$transaction['shippingamount']);}else{echo "--";} ?> &nbsp;</p>
                </td>
                <td width="100" width="center"  class="<?php echo $bg_none;?>"> &nbsp; <p>
                <?php echo $transaction['transaction_type'];?></p>&nbsp;</td>
        	</tr>
        <?php $i++;endforeach; 
        ?>

	</table>
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
	</div>
	<?php if(count($transactions)>0){?>
    </div>
	<?php }?>
                <div class="auction-bl">
                <div class="auction-br">
                <div class="auction-bm">
                </div>
                </div>
                </div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_transactions_active").addClass("user_link_active");});
</script>
