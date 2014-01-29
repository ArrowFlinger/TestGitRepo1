<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left real fl">
        <div class="title-left title_temp1">
        <div class="title-right del">
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
		
            <table width="940" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top" style="width:930px!important;">
                <thead>
                <tr>
                        <th width="130" align="center"><b><?php echo __('product_name');?></b></th>
                        <th width="200" align="center"><b><?php echo __('product_info');?></b></th>
                        <th width="100" align="center"><b><?php echo __('total_amount');?></b></th> 
                        <th width="100" align="center"><b><?php  echo __('transactions_type');?></b></th>
                </tr>
    </thead>
		
             
        <?php 
        $count=$count_transaction;
        $i=0;
        foreach($transactions as $transaction):
        $bg_none=($i==$count-1)?"bg_none":"";?>
        <tr>
               
                <td width="130" align="center" class="<?php echo $bg_none;?>"><span class="mail_link" style="display:block; padding:0 0 0 20px;">
		<?php if($transaction['amount_type'] == DEBIT){ ?>
		 <a href="<?php echo URL_BASE;?>site/buynow/show_payment_log/<?php echo $transaction['product_id'];?>"><?php echo ucfirst($transaction['product_name']);?></a><?php }else{   echo ucfirst($transaction['product_name']); } ?> 
			
		</span></td>
                <td  width="200" align="center" class="<?php echo $bg_none;?>"><p ><?php echo $transaction['description']!=""?ucfirst($transaction['description']):"--";?></p></td>
                <td align="center" width="100" class="<?php echo $bg_none;?>"><p><?php echo $site_currency." ".Commonfunction::numberformat((($transaction['amount']*$transaction['quantity'])+$transaction['shippingamount']));?></p></td>
         
                <td width="100" align="center" class="<?php echo $bg_none;?>"><p >
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
        </div></div>
        <!--End of Pagination-->
                <div class="auction-bl">
                <div class="auction-br now">
                <div class="auction-bm">
                </div>
                </div>
		 
                </div>
		 
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#products_transactions_active").addClass("user_link_active");});
</script>
