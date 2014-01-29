<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="cart_head">
<ul>
     <li><a href="<?php echo URL_BASE;?>" title="Home"><?php echo __('menu_home');?></a></li>
          <li><a href="#" title="arr_bg"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
          <li class="active"><a title="<?php echo $selected_page_title; ?>"><?php echo $selected_page_title; ?></a></li>

</ul>
</div>
<form method="post" action=""> 
<!--add to cart-->
	<div class="cart_full" id="addtocartlist_page">
	<h2 class="cart_title" title="<?php echo __('menu_buynow_add_to_cart');?>"><?php echo __('menu_buynow_add_to_cart');?></h2>
	<div class="cart_main">
	<?php if($count_transaction>0):?>
		<div class="cart_main_inner">
			<div class="cart_tit_bg">
                            <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                                <thead>
                                    <tr>
                                        <th width="120" align="center"><b><?php echo __('product_image');?></b></th>
                                        <th width="100" align="center"><b><?php echo __('product_name');?></b></th>
                                          <th width="100" align="center"><b><?php echo __('product_amount');?></b></th>
                                           <th width="100" align="center"><b><?php  echo __('quantity_label');?></b></th>
                                            <th width="100" align="center"><b><?php echo __('sub_total_label'); ?></b></th>
                                             <th width="100" align="center"><b><?php  echo __('remove_label');?></b></th>
                    
                            </tr>
                                </thead>
			
			<?php 
        $count=$count_transaction;
	 $sfee=0;
        $i=0;
        foreach($transactions as $transaction):
	  $shippingfee=($transaction['shipping_fee']!='')?$transaction['shipping_fee']:0;
			      $sfee+=$shippingfee;
	
        $bg_none=($i==$count-1)?"bg_none":"";?>
			
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
                    <tr>
				<td width="120" align="center">
				<a><img src="<?php echo $product_img_path;?>" alt="<?php echo ucfirst($transaction['product_name']);?>" title="<?php echo ucfirst($transaction['product_name']);?>" width="83" height="83" /></a>
				</td>
                    
				<td width="100" align="center">
					<h3 ><?php echo ucfirst($transaction['product_name']);?></h3>
					<p>
					 <?php echo strlen(strip_tags($transaction['product_info']))>85?ucfirst(Text::limit_chars(strip_tags($transaction['product_info']),50))."...":ucfirst($transaction['product_info']);?>
										
					 </p>
				</td>
				<td width="100" align="center">
				   
				<?php echo  $site_currency . " " . Commonfunction::numberformat($transaction['product_cost']);?>
				
				</td>
				<td width="100" align="center">
					<div class="inner">
					<input type="hidden" name="amount[<?php echo $i; ?>]" value="<?php echo $transaction['amount'];?>" id="amount" />
						<input name="id[<?php echo $i;?>]" id="QTY" type="hidden"  value="<?php echo $transaction['productid'];?>" >
						
						
						<div class="fl">
						  <a class="inn_sp1" name="amount[<?php echo $i; ?>]" value="<?php echo $transaction['amount'];?>" id="<?php echo $i;?>" title="Minus"><img src="<?php echo IMGPATH; ?>minus.png" alt="Minus" /></a></div>
						<div class="fl">
						  <input style=" float:left; width: 40px; border-top:1px solid #ccc; border-bottom: 1px solid #ccc; text-align: center;" name="quantity[<?php echo $i;?>]" class="input" readonly="readonly"  id="QTY<?php echo $i;?>" type="text"  value="<?php echo $transaction['quantity'];?>"  >
						  <input name="id[<?php echo $i;?>]" id="QTY" type="hidden"  value="<?php echo $transaction['productid'];?>" >
						</div>
						<div class="fl"><a class="inn_sp2" name="id[<?php echo $i;?>]" id="<?php echo $i;?>" value="<?php echo $transaction['productid'];?>" title="Plus"><img src="<?php echo IMGPATH; ?>plus.png" alt="Plus" /></a></div>

						
					</div>
				</td>
			<td width="100" align="center">
			
			<?php
					    $subamount=($transaction['product_cost']*$transaction['quantity']);
					    $tamount[]=$subamount;
					    echo $site_currency . " " . Commonfunction::numberformat($subamount); ?>
			</td>
			
				
				<td width="100" align="center">
                                    <a  onclick="frmdel(<?php echo $transaction['id'];?>);" title="<?php echo __('remove_label');?> " style="cursor:pointer;">
                                        <img src="<?php echo IMGPATH; ?>delet.png" alt="Delete" /></a></td>
				<div class="clear"></div>
			</div>
          
			 <?php $i++;endforeach; 
        ?>
		
			
		</div>
		<div class="clear"></div>
		<?php foreach($transactions as $trans):
		         $amt[]=$trans['total_amt'];
			 $totalamount=array_sum($amt);			
		endforeach;		
		?>
        </tr>
        </table>
		
		<div class="grand_total" style="width:40%;text-align:right;">
			<span><?php  echo __('shipping_handing'); ?>:</span>
			<span class="amt"><?php
   $totalamount= array_sum($tamount);
    echo $site_currency . " " . Commonfunction::numberformat($sfee); ?></span>
		</div>
		
		
		
		<div class="grand_total" style="width:40%;text-align:right;">
			<span><?php echo __('grand_total'); ?> :</span>
			<span class="amt"><?php
			
			 $totalamount= array_sum($tamount)+$sfee;
			echo $site_currency." ".Commonfunction::numberformat($totalamount);?></span>
		</div>
	
		
		<div class="grand_total_btn">
			<div class="fr">
				<span class="ora_btn_lft">&nbsp;</span>
				<span class="ora_btn_mid">
                                <!--<a href="<?php echo URL_BASE;?>site/buynow/myaddresses" title="<?php echo __('check_out');?>"><input type="button" name="key" value="<?php echo __('check_out');?>"/></a>--><a href="<?php echo URL_BASE; ?>site/buynow/checkout"> <?php echo __('check_out'); ?>   </a></span>
				<span class="ora_btn_rgt">&nbsp;</span>
			</div>
			<div class="shop_btn">
				<span class="blue_btn_lft">&nbsp;</span>
				<span class="blue_btn_mid"><a style="cursor:pointer" title="<?php echo __('button_update_shopping_cart'); ?>"><input type="submit" name="update" value="<?php echo __('button_update_shopping_cart'); ?>" title="<?php echo __('button_update_shopping_cart'); ?>"/></a></span>
				<span class="blue_btn_rgt">&nbsp;</span>
			</div>
			<div class="fr">
				<span class="blue_btn_lft">&nbsp;</span>
				<span class="blue_btn_mid"><a href="<?php echo URL_BASE;?>auctions/live/" title="<?php echo strtoupper(__('continue_shopping_label'));?>" name="key" value="<?php echo strtoupper(__('continue_shopping_label'));?>"/><?php echo strtoupper(__('continue_shopping_label'));?></a></span>
				<span class="blue_btn_rgt">&nbsp;</span>
			</div>
			
		</div>
		<?php else:?>
		
		<div class="message_common">
		<h4><?php echo __("not_add_addtocart_products");?></h4>
		</div>
	
	<?php endif;?>
	</div>
	</form>
	</div>

	<div class="grand_total_btn" style="width:100%;float:left;margin:0 auto;clear:both;">
		<div class="nauction_pagination">
        <?php if($count_transaction > 0): ?>
        <p><?php echo $pagination->render(); ?></p>  
        <?php endif; ?>
        </div>
</div>
<!--add to cart-->
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
	//$("#users_menu").addClass("fl active");$("#addtocart_list_active").addClass("user_link_active");
	$(".inn_sp1").click(function () {
	           
		var id=$(this).attr('id');
		 
		var value=$("#QTY"+id).val();
			if(value != 1)
		{
		var newvalue=parseInt(value)-1;
		$("#QTY"+id).val(newvalue);	
		}	
	});
	$(".inn_sp2").click(function () {
		var id=$(this).attr('id');
		
		var value=parseInt($("#QTY"+id).val());
		
	
		 var newvalue=value+1;
		 $("#QTY"+id).val(newvalue);
	 		
	});
	
	});
</script>
