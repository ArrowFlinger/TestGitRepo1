<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('menu_buynow_add_to_cart');?>"><?php echo __('menu_buynow_add_to_cart');?></h2>
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
			
			<th width="120" align="center"><?php echo __('product_name');?></th>
			<th width="100" align="center"><b><?php echo __('product_image');?></b></th>
			<th width="130" align="center"><b><?php echo __('total_amount');?></b></th>   
			<th width="100" align="center"><b><?php  echo __('option_label');?></b></th>
			<th width="100" align="center"><b><?php  echo __('quantity_label');?></b></th>
			<th width="100" align="center"><b><?php  echo __('remove_label');?></b></th>		
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
                
                <td width="250" align="center" class="<?php echo $bg_none;?>"><span class="mail_link" style="display:block; padding:0 0 0 20px;"><?php echo ucfirst($transaction['product_name']);?></span></td>
		 <td align="center" width="200" class="<?php echo $bg_none;?>"><p>	
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
               
                <td align="center" width="150" class="<?php echo $bg_none;?>"><p><?php echo $site_currency." ".Commonfunction::numberformat($transaction['amount']);?></p></td>
                
                <td align="center" width="100" class="<?php echo $bg_none;?>"><p class="watch_list_time fl"><?php if($useramount > $transaction['amount']){ ?>

				<a href="<?php echo URL_BASE;?>site/buynow/buynow_offline/<?php echo $transaction['product_id'];?>" title="<?php echo __('buynow_label');?>"><?php echo __('pay_label');?></a>
			<?php	}else{ ?>
			<a href="<?php echo URL_BASE;?>site/buynow/buynow_auction/<?php echo $transaction['product_id'];?>" title="<?php echo __('Buy Now');?>">Pay</a>
			<?php } ?>
		 </p>
		 <td align="left" width="100" class="<?php echo $bg_none;?>"><p class="fl"><?php echo $transaction['quantity'];?></p></td>
		 <td align="left" width="100" class="<?php echo $bg_none;?>"><p class="watch_list_time fl"><a href="<?php echo URL_BASE;?>site/buynow/buynow_remove/<?php echo $transaction['id'];?>" title="<?php echo __('remove_label');?>"> <?php echo __('remove_label');?> </a></p>
                </td>
               
        </tr>
        <?php $i++;endforeach; 
        ?>		
	</table>
	
	<div class="clr pt10">
	<a href="<?php echo URL_BASE;?>auctions/live/" title="<?php echo __('back_label');?>" class="back_link fr"><?php echo __('back_label');?></a>
	</div>
	<div style="color:#E76A16;  border-bottom:2px solid #E76A16; width:250px;padding:10px"> Price Summary:</div>
		<?php foreach($transactions as $trans):
		         $amt[]=$trans['amount'];
			 $totalamount=array_sum($amt);			
		endforeach;
		
		?>
		
		<div><?php echo __('price_label'); ?> :<?php echo $site_currency." ".Commonfunction::numberformat($totalamount);?></div>
		<div><?php echo __('tax_label'); ?> :<?php  echo $site_currency." ".Commonfunction::numberformat(0);?></div>
		<div><?php echo __('total_label'); ?> :<?php echo $site_currency." ".Commonfunction::numberformat($totalamount);?></div>	
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
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#addtocart_list_active").addClass("user_link_active");});
</script>
