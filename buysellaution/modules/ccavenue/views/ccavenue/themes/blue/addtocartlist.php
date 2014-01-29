<?php defined("SYSPATH") or die("No direct script access."); ?>
<form method="post" action=""> 
<div class="content_full_out fl">
        <div class="title-left title_temp100">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('menu_buynow_add_to_cart');?>"><?php echo __('menu_buynow_add_to_cart');?></h2>
        </div>
        </div>
        </div>  			
        <div class="action_deal_list1 clearfix">	
        <?php if($count_transaction>0):?>
            <div class="watch_list_items watch_list_items2 trans_watch_list_items fl clr" style="width:934px; margin-left:10px;">	
		<div id="managetable" class="fl clr">
		<!--List products-->
         <div class="table-left table-left2">
        <div class="table-right bgnone">
        <div class="table-mid bgnone">		
        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                <tr>
			<th width="220" align="center"><b><?php echo __('product_image');?></b></th>
			<th width="220" align="center"><?php echo __('product_name');?></th>			
			<th width="230" align="center"><b><?php echo __('product_amount');?></b></th>  			
			<th width="200" align="center"><b><?php  echo __('quantity_label');?></b></th>
			<th width="200" align="center"><b><?php  echo __('remove_label');?></b></th>		
                </tr>
        </table>
        </div>
        </div>
       
		
        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="width:100%;border:none;">
        <?php 
        $count=$count_transaction;
        $i=0;
        foreach($transactions as $transaction):
        $bg_none=($i==$count-1)?"bg_none":"";?>
        <tr>
                
             
		 <td align="center" width="220" class="<?php echo $bg_none;?>">
         <p style=" margin:10px 0 0 0px;">	
		<?php 
				if(($transaction['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$transaction['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$transaction['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?>
		<img src="<?php echo $product_img_path;?>" width="50" height="50" title="<?php echo ucfirst($transaction['product_name']);?>" alt="<?php echo $transaction['product_name'];?>"/>		
		</p></td>
                    <td width="220" align="center" class="<?php echo $bg_none;?>"><span class="mail_link" style="display:block; padding:0 0 0 20px;"><?php echo ucfirst($transaction['product_name']);?>&nbsp;</span></td>
               
                <td align="center" width="230" class="<?php echo $bg_none;?>"><p><?php echo $site_currency." ".Commonfunction::numberformat($transaction['amount']);?></p></td>
                
               
		 <td align="center" width="200" class="<?php echo $bg_none;?>"> <div id="QtyCounter" style="margin-left:30px;">
        		<input type="hidden" name="amount[<?php echo $i; ?>]" value="<?php echo $transaction['amount'];?>" id="amount" />
			<input name="quantity[<?php echo $i;?>]" id="QTY<?php echo $i;?>" type="text"  value="<?php echo $transaction['quantity'];?>" >
			<input name="id[<?php echo $i;?>]" id="QTY" type="hidden"  value="<?php echo $transaction['productid'];?>" >
         
         <div class="count_all"><div class="QtyUp" id="<?php echo $i;?>"></div>
         <div class="QtyDown" id="<?php echo $i;?>"></div>
         </div>
         </div></td>
		 <td align="center" width="200" class="<?php echo $bg_none;?>"><p class="watch_list_time fl"><a onclick="frmdel(<?php echo $transaction['id'];?>);"  class="remove_card_icon"title="<?php echo __('remove_label');?> "> </a></p>
                </td>
               
        </tr>
        <?php $i++;endforeach; 
        ?>		
	</table><div class="buttons_continues">
	<div class="continue_shopping">
  <div class="continue_shopping_lft"></div>
  <div class="continue_shopping_mid"><input type="submit" name="update" title="<?php echo __('button_update_shopping_cart'); ?>"  value="<?php echo __('button_update_shopping_cart');?>"/></div>
  <div class="continue_shopping_rft"></div>
  
	</div>
    <div class="continue_shopping  mr10">
  <div class="continue_shopping_lft"></div>
  <div class="continue_shopping_mid">  <a href="<?php echo URL_BASE;?>auctions/live/" title="<?php echo __('back_label');?>" class="back_link fr"><?php echo __('back_label');?></a></div>
  <div class="continue_shopping_rft"></div>
  </div>
   
    </div>
             <div class="total_amt">
		<?php foreach($transactions as $trans):
		         $amt[]=$trans['total_amt'];
			 $totalamount=array_sum($amt);			
		endforeach;		
		?>		
		<!--<div><?php echo __('price_label'); ?> :<?php echo $site_currency." ".Commonfunction::numberformat($totalamount);?></div>
		<div><?php echo __('tax_label'); ?> :<?php  echo $site_currency." ".Commonfunction::numberformat(0);?></div>-->
		<div class="total_amt_innr">
		<b>Grand <?php echo __('total_label'); ?> </b>
                <span><?php echo $site_currency." ".Commonfunction::numberformat($totalamount);?></span>
                </div></div>
	<div class="check_out">
    	<div class="check_out_lft"></div>
        <div class="check_out_mid"> <a href="<?php echo URL_BASE;?>site/buynow/myaddresses"><?php echo __('check_out'); ?></a></div>
        <div class="check_out_rft"></div>
    
   </div>
	</div>
	
	<div class="clear"></div>
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>	
	</div><?php else:?>
	<h4 class="no_data clr" style="float:none;"><?php echo __("not_add_addtocart_products");?></h4>
	<?php endif;?>
        <!--Pagination-->
        <div class="pagination">
        <p><?php echo $pagination->render(); ?></p>
        </div>
        <!--End of Pagination-->
	</div> </div>
                <div class="auction-bl">
                <div class="auction-br">
                <div class="auction-bm">
                </div>
                </div>
                </div>

</div>
</form>
<script type="text/javascript">

function frmdel(transactionid)
{
    var answer = confirm("<?php echo __('delete_alert_cart_product');?>")
    if (answer){
         window.location="<?php echo URL_BASE;?>site/buynow/buynow_remove/"+transactionid;
    }
    
    return false;  
} 
$(document).ready(function () {
	$("#users_menu").addClass("fl active");$("#addtocart_list_active").addClass("user_link_active");
	$(".QtyUp").click(function () {
		var id=$(this).attr('id');
		var value=$("#QTY"+id).val();
		var newvalue=parseInt(value)+1;
		$("#QTY"+id).val(newvalue);		
	});
	$(".QtyDown").click(function () {
		var id=$(this).attr('id');
		var value=parseInt($("#QTY"+id).val());
		if(value != 1)
		{
		 var newvalue=value-1;
		 $("#QTY"+id).val(newvalue);
	 }		
	});
	
	});
</script>
