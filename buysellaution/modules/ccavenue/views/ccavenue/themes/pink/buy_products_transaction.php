<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl">
    <div class="title-left title_temp1" style="width:956px;">
        <div class="title-right">
        <div class="title-mid" >
        <h2 class="fl clr pl10" title="<?php echo __('menu_buynow_transaction');?>"><?php echo __('menu_buynow_transaction');?></h2>
        </div>
        </div>
        </div>  	
        <div class="action_deal_list  clearfix" style="width:954px;">	
        <?php if($count_transaction>0):?>
        <div class="watch_list_items watch_list_items2 trans_watch_list_items fl clr">	
		<div id="managetable" class="fl clr">
		<!--List products-->
                <div class="table-left" style="width:930px;">
        <div class="table-right">
        <div class="table-mid" style="width:918px">		
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top" style="width:940px;">
                <tr>
                        <th width="150" align="center"><b><?php echo __('product_name');?></b></th>
                        <th width="260" align="center"><b><?php echo __('product_info');?></b></th>
                        <th width="152" align="center"><b><?php echo __('total_amount');?></b></th> 
                        <th width="120" align="center"><b><?php  echo __('transactions_type');?></b></th>
                </tr>
        </table>
        </div>
        </div>
        </div>
		
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0" style="width:930px;">
        <?php 
        $count=$count_transaction;
        $i=0;
        foreach($transactions as $transaction):
        $bg_none=($i==$count-1)?"bg_none":"";?>
        <tr>
               
                <td width="150" align="center" class="<?php echo $bg_none;?>"><span class="mail_link" style="display:block; padding:0 0 0 20px;">
		<?php if($transaction['amount_type'] == DEBIT){ ?>
		 <a href="<?php echo URL_BASE;?>site/buynow/show_payment_log/<?php echo $transaction['product_id'];?>"><?php echo ucfirst($transaction['product_name']);?></a><?php }else{   echo ucfirst($transaction['product_name']); } ?> 
			
		</span></td>
                <td width="260" align="center" class="<?php echo $bg_none;?>"><p style="width:100%;text-align: center" ><?php echo $transaction['description']!=""?ucfirst($transaction['description']):"--";?></p></td>
                <td align="left" width="152" class="<?php echo $bg_none;?>"><p style=" text-align:center;width:100%;"><?php echo $site_currency." ".Commonfunction::numberformat($transaction['amount']);?></p></td>
         
                <td align="right" width="120" class="<?php echo $bg_none;?>"><p >
                <?php if($transaction['amount_type'] == DEBIT){echo __('paypal');}else{echo __('offline');} ?></p></td>
                </td>
		 
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
        <div class="pagination" style=" width:100%;clear: both; float:left;">
        <p><?php echo $pagination->render(); ?></p>
        </div>
        <!--End of Pagination-->
	</div>
    <div style="border-top:1px solid #ddd; width:955px;float-left;">
                </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#products_transactions_active").addClass("user_link_active");});
</script>
