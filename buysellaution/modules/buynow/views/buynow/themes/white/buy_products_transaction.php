<!--login start-->
<div class="cart_head">
<ul>
          <li><a href="<?php echo URL_BASE;?>" title="Home"><?php echo __('menu_home');?></a></li>
          <li><a href="#" title="arr_bg"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
          <li class="active"><a title="<?php echo $selected_page_title; ?>"><?php echo $selected_page_title; ?></a></li>
</ul>
</div>
<!--add to cart-->
<?php if($count_transaction>0):?>
	<div class="cart_full">
	<h2 class="cart_title" title="<?php echo __('menu_buynow_transaction');?>" style="width:238px;"><?php echo __('menu_buynow_transaction');?></h2>
	<div class="cart_main">
		<div class="cart_main_inner">
			<div class="cart_tit_bg">
                      <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                      
                        <thead>
                            <tr>
                                <th width="100" align="center"><b><?php echo __('product_name');?></b></th>
                                  <th width="100" align="center"><b><?php echo __('product_info');?></b></th>
                                     <th width="100" align="center"><b><?php echo __('total_amount');?></b></th>
                                      <th width="100" align="center"><b><?php  echo __('transactions_type');?></b></th>
                            
                               
                            </tr>
                        </thead> 

				
		
			
			<?php 
        $count=$count_transaction;
      
        foreach($transactions as $transaction):
        ?>
			<tr>
			
				<td width="100" align="center">
					<h3>	<?php if($transaction['amount_type'] == DEBIT){ ?>

		
				<a href="<?php echo URL_BASE;?>site/buynow/show_payment_log/<?php echo $transaction['product_id'];?>"><?php echo ucfirst($transaction['product_name']);?></a>
			</h3>

			<?php }
			else{  echo ucfirst($transaction['product_name']); } ?></h3>
				
				</td>
				<td width="100" align="center">
					<div class="inner">
							<?php echo $transaction['description']!=""?ucfirst($transaction['description']):"--";?>
					</div>
				</td>
				<td width="100" align="center" style="color: #EE7E2C;">
                                    <?php echo $site_currency." ".Commonfunction::numberformat((($transaction['amount']*$transaction['quantity'])+$transaction['shippingamount']));?>
                                </td>
				
				<td width="100" align="center">
				 <?php echo ucfirst($transaction['payment_type']);  ?>
				</td>
		
                        		
				
		
		 <?php endforeach;
		        
        ?>	
       </tr>
                      </table>
        <div class="clear"></div>
		<?php else:?>
		<div class="message_common">
		
	<h4 class="no_data clr" style="float:none;"><?php echo __("no_transaction_detail_at_the_moment");?></h4>
	</div>
<?php endif;?>
		
		
	
	
			
		
	</div>
	<div class="grand_total_btn">
		
        <?php if($count_transaction > 0): ?>
        <div class="nauction_pagination">
        <p><?php echo $pagination->render(); ?></p>
        </div>  
        <?php endif; ?>
        
</div>
	</div>
<!--add to cart-->
</div>
<!--login end-->

