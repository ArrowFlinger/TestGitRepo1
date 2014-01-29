<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left_top fl">
        <div class="title-left title_temp2">
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
            <table width="660" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top" style="width:940px;">
                <tr>
                        <th width="120" align="center"><b><?php echo __('product_name');?></b></th>
                        <th  width="200" align="center"><b><?php echo __('product_info');?></b></th>
                        <th width="212" align="center"><b><?php echo __('total_amount');?></b></th> 
                        <th width="120" align="center"><b><?php  echo __('transactions_type');?></b></th>
                </tr>
        </table>
        </div>
        </div>
        </div>
		
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0" style="width:940px;">
        <?php 
        $count=$count_transaction;
        $i=0;
        foreach($transactions as $transaction):
        $bg_none=($i==$count-1)?"bg_none":"";?>
        <tr>
               
                <td width="120" align="left" ><span class="mail_link" style="display:block; padding:0 0 0 20px;">
		<?php if($transaction['amount_type'] == DEBIT){ ?>
		 <a href="<?php echo URL_BASE;?>site/buynow/show_payment_log/<?php echo $transaction['product_id'];?>"><?php echo ucfirst($transaction['product_name']);?></a><?php }else{   echo ucfirst($transaction['product_name']); } ?> 
			
		</span></td>
                <td align="center" width="200" ><p ><?php echo $transaction['description']!=""?ucfirst($transaction['description']):"--";?></p></td>
                <td align="center" width="212"><p><?php echo $site_currency." ".Commonfunction::numberformat((($transaction['amount']*$transaction['quantity'])+$transaction['shippingamount']));?></p></td>
         
                <td align="center" width="120"><p >
                <?php echo ucfirst($transaction['payment_type']);  ?></p></td>
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
        <div class="pagination">
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
