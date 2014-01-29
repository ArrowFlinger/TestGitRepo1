<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<form method="post" action=""> 
<div class="action_content_left_com fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('menu_buynow_add_to_cart');?>"><?php echo __('menu_buynow_add_to_cart');?></h2>
        </div>
        </div>
        </div> 
         	
        <div class="action_deal_list action_deal_list3 clearfix">	
        <?php if($count_transaction>0):?>
        <div class="watch_list_items watch_list_items2  item3 trans_watch_list_items fl clr">	
		<div id="managetable_3" class="fl clr">
		<!--List products-->
        <table width="925" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
            <thead>
                <tr>
			
			<th width="100" align="center" style=" border-bottom:1px solid #ccc;"><b><?php echo __('product_name');?></b></th>
			<th width="100" align="center" style="  border-bottom:1px solid #ccc;"><b><?php echo __('product_image');?></b></th>
			<th width="100" align="center" style="  border-bottom:1px solid #ccc;"><b><?php echo __('product_amount');?></b></th>
			<th width="100" align="center" style="  border-bottom:1px solid #ccc;"><b><?php  echo __('quantity_label');?></b>  </th>
			<th width="100" align="center" style=" border-bottom:1px solid #ccc;"><b><?php echo __('sub_total_label'); ?></b></th> 
			<th width="100" align="center" style="  border-bottom:1px solid #ccc;"><b><?php  echo __('remove_label');?></b></th>		
                </tr>
                   </thead>
        </table>
       <table width="925" border="0" align="left" cellpadding="0" cellspacing="0" class="addtocartlist_table">
        <?php 
        $count=$count_transaction;
	$sfee=0;
        $i=0;
        foreach($transactions as $transaction):
	$shippingfee=($transaction['shipping_fee']!='')?$transaction['shipping_fee']:0;
	$sfee+=$shippingfee;
        $bg_none=($i==$count-1)?"bg_none":"";?>
        <tr>
                
                <td width="100" align="center" class="<?php echo $bg_none;?>"><span class="mail_link" style="display:block; padding:0 0 0 3px; "><?php echo ucfirst($transaction['product_name']);?></span></td>
		 <td align="center" width="100" class="<?php echo $bg_none;?>"><p>	
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
               
                <td align="center" width="100" class="<?php echo $bg_none;?>">
                    <p><?php echo $site_currency . " " . Commonfunction::numberformat($transaction['product_cost']); ?></p>
                </td>                
               
		 <td align="left" width="100" class="<?php echo $bg_none;?>">
         <p class=" roling fl" style="padding-left:35px;*padding-left:15px;padding-left:35px\0/;width:60px;">
		 <span class="inn_sp">
	
			<input type="hidden" name="amount[<?php echo $i; ?>]" value="<?php echo $transaction['amount'];?>" id="amount" />
			<input name="quantity[<?php echo $i;?>]" id="QTY<?php echo $i;?>" type="text"  value="<?php echo $transaction['quantity'];?>"  style="width:25px!important;" >
			<input name="id[<?php echo $i;?>]" id="QTY" type="hidden"  value="<?php echo $transaction['productid'];?>" ></span>
          <span class="inn_sp1" style="width:22px;"id="<?php echo $i;?>"></span>
          <span class="inn_sp2" style="width:22px;" id="<?php echo $i;?>"></span>         
         </p>         
         </td>
	 
	<td align="center" width="100" class="<?php echo $bg_none;?>"><p style="width:100%;">
			<?php
					    $subamount=($transaction['product_cost']*$transaction['quantity']);
					    $tamount[]=$subamount;
					    echo $site_currency . " " . Commonfunction::numberformat($subamount); ?></p></td>                

	 
         <td align="center" width="100" class="<?php echo $bg_none;?>"><p class="watch_list_time"><a onclick="frmdel(<?php echo $transaction['id'];?>);" title="<?php echo __('remove_label');?>"> <img src="<?php echo IMGPATH;?>delete.png" width="14" height="16" /> </a></p>
                </td>
               
        </tr>
        <?php $i++;endforeach; 
        ?>		
	</table>
	
	<div class="ravel">
    <div class="real_comm">
    <div class="cart_on">
    <div class="sho_left"></div>
    <div class="sho_mid">
	<a href="<?php echo URL_BASE;?>auctions/live/" title="<?php echo __('back_label');?>" class="back_link fr"><?php echo __('back_label');?></a>
    </div>
    <div class="sho_right"></div>
    </div>
    <div class="cart_on">
    <div class="sho_left"></div>
    <div class="sho_mid">
	<input type="submit" name="update" title="<?php echo __('button_update_shopping_cart'); ?>" class="back_link fr"  value="<?php echo __('button_update_shopping_cart');?>"/>

    </div>
    <div class="sho_right"></div>
    </div>
    </div>
    
	</div>
	
	      <div class="ravel" style="border-top:1px solid #ddd;margin-top:20px;padding-top:10px;">
                    <div class="inner_so" style="width:100%;">
	
        <label style="width:75%; padding-right:20px;text-align:right;"><?php  echo __('shipping_handing'); ?></label>
    <h6 style="width:20%;text-align:left;"><?php
				$totalamount= array_sum($tamount);
				echo $site_currency . " " . Commonfunction::numberformat($sfee); ?></h6>

    </div>
    </div>
	
	
                <div class="ravel" style="border-top:1px solid #ddd;margin-top:20px;padding-top:10px;">
                    <div class="inner_so" style="width:100%">
		
        <label style="width:75%;padding-right:20px;text-align:right;"><?php echo __('grand_total'); ?></label>
    <h6 style="width:20%;text-align:left;"><?php
   $totalamount= array_sum($tamount)+$sfee;
    echo $site_currency . " " . Commonfunction::numberformat($totalamount); ?></h6>

    </div>
    </div>
    <div class="ravel">
        <div class="chic_ou" style="margin-top:10px;width:215px;">
    <div class="chi_left"></div>
        <div class="chi_mid"><a style="color:#000;line-height:15px;text-align:center;font-weight:bold;padding:8px 0px;float:left;" href="<?php echo URL_BASE;?>site/buynow/checkout"><?php echo __('check_out'); ?></a></div>
            <div class="chi_right"></div>
    </div>
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
	</div>
		<div class="auction-bl">
		<div class="auction-br">
		<div class="auction-bm">
                </div>
                </div>
                </div>
</div>
</form>
</div>
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
	$(".inn_sp1").click(function () {
		var id=$(this).attr('id');
		var value=$("#QTY"+id).val();
		var newvalue=parseInt(value)+1;
		$("#QTY"+id).val(newvalue);		
	});
	$(".inn_sp2").click(function () {
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
