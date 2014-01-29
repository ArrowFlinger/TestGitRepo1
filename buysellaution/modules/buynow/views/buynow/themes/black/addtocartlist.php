<?php defined("SYSPATH") or die("No direct script access."); ?>
<style type="text/css">
.inner_one_top{
width:158px;

}
</style>

<form method="post" action=""> 
    <div class="content_left_out fl">
        <div class="action_content_left_top fl">
            <div class="title-left title_temp4">
                <div class="title-right">
                    <div class="title-mid">
                        <h2 class="fl clr pl10" title="<?php echo __('menu_buynow_add_to_cart'); ?>"><?php echo __('menu_buynow_add_to_cart'); ?></h2>
                    </div>
                </div>
            </div>  	
            <div class="action_deal_list  clearfix">	
                <?php if ($count_transaction > 0): ?>
                    <div class="watch_list_items1 watch_list_items2 trans_watch_list_items fl clr">	
                        <div id="managetable" class="fl clr">
                            <!--List products-->

                            <div class="tab_one_top">
                                <div class="inner_one_top">
                                    <p><?php echo __('product_image'); ?></p>
                                </div>
                                <div class="inner_one_top">
                                    <p><?php echo __('product_name'); ?></p>
                                </div>
				
				<div class="inner_one_top">
                                    <p><?php echo __('product_cost'); ?></p>
                                </div>
				<div class="inner_one_top">
                                    <p><?php echo __('quantity_label'); ?></p>
                                </div>
				
                                <div class="inner_one_top">
                                    <p><?php echo __('sub_total_label'); ?></p>
                                </div>
                                                             
                                
                                <div class="inner_one_top">
                                    <p><?php echo __('remove_label'); ?></p>
                                </div>
                            </div>		



                            <div class="tab_one_top1 tab_one_top_add">

                                <?php
                                $count = $count_transaction;
				$sfee=0;
                                $i = 0;
                                foreach ($transactions as $transaction):
				$shippingfee=($transaction['shipping_fee']!='')?$transaction['shipping_fee']:0;
				$sfee+=$shippingfee;
                                    $bg_none = ($i == $count - 1) ? "bg_none" : "";
                                    ?>

                                    <div class=" <?php echo $bg_none; ?>"  style="clear:both; float:left; margin-top:10px;width:100%;">
                                        <div class="p_inn" style="width:155px;">	
                                            <?php
                                            if (($transaction['product_image']) != "" && file_exists(DOCROOT . PRODUCTS_IMGPATH_THUMB . $transaction['product_image'])) {
                                                $product_img_path = URL_BASE . PRODUCTS_IMGPATH_THUMB . $transaction['product_image'];
                                            } else {
                                                $product_img_path = IMGPATH . NO_IMAGE;
                                            }
                                            ?>
                                            <img src="<?php echo $product_img_path; ?>" width="50" height="50" title="<?php echo ucfirst($transaction['product_name']); ?>" alt="<?php echo $transaction['product_name']; ?>" class="cent"/>		
                                        </div>
                                        <div class="inner_one_top">
                                            <h5 class="<?php echo $bg_none; ?>"><span class="mail_link" style="display:block;"><?php echo ucfirst($transaction['product_name']); ?></span></h5>
                                        </div>

                                        <div class="inner_one_top">
                                            <h5 class="<?php echo $bg_none; ?>"><p><?php echo $site_currency . " " . Commonfunction::numberformat($transaction['product_cost']); ?></p></h5>
                                        </div>
                                       
                                       

                                        <div class="inner_one_top">
                                            
			<p class=" roling fl" style="width:75px;">
			<span class="inn_sp">	
			<input type="hidden" name="amount[<?php echo $i; ?>]" value="<?php echo $transaction['amount'];?>" id="amount" />
			<input name="quantity[<?php echo $i;?>]" id="QTY<?php echo $i;?>" type="text"  value="<?php echo $transaction['quantity'];?>"  style="width:25px!important;" >
			<input name="id[<?php echo $i;?>]" id="QTY" type="hidden"  value="<?php echo $transaction['productid'];?>" ></span>
			<span class="inn_sp1" style="width:27px;"id="<?php echo $i;?>"></span>
			<span class="inn_sp2" style="width:27px;" id="<?php echo $i;?>"></span>         
         </p>   </h5></div>
					 
					 <div class="inner_one_top">
                                            <h5 class="<?php echo $bg_none; ?>"><p><?php
					    $subamount=($transaction['product_cost']*$transaction['quantity']);
					    $tamount[]=$subamount;
					    echo $site_currency . " " . Commonfunction::numberformat($subamount); ?></p></h5>
					    
                                        </div>
                                        <div class="inner_one_top">
                                            <h5 class="<?php echo $bg_none; ?>"><p class="watch_list_time fl"><a class="rem" onclick="frmdel(<?php echo $transaction['id']; ?>);" title="<?php echo __('remove_label'); ?>"> <?php echo __('remove_label'); ?></a></p>
                                            </h5></div>
        <?php $i++;
        endforeach;
        ?>		

                                </div>
                                  <div class="tab_one_top3">
                                    <div class="ta_right">
                                        <div class="inner_tab_left">
                                            <div class="new_left"></div>
                                            <div class="new_mid">
                                                <a href="<?php echo URL_BASE; ?>auctions/live/" title="<?php echo __('back_label'); ?>" class="back_link fl"><?php echo __('back_label'); ?></a>
                                            </div>
                                            <div class="new_right"></div>
                                        </div>
                                        <div class="inner_tab_left">
                                            <div class="new_left"></div>
                                            <div class="new_mid" style="width:210px;padding: 0px;margin:0px;"> <input type="submit" style="margin:5px 0 0 0px; padding:0px;width:210px;cursor:pointer" name="update" title="<?php echo __('button_update_shopping_cart'); ?>"  value="<?php echo __('button_update_shopping_cart'); ?>" /></div>
                                            <div class="new_right"></div>
                                        </div>
                                    </div>
                                      
                                </div>
				  
				<div class="tab_one_top3">
                                    <div class="conn_left" style="width:100%; float:left;">
									<h4 style="float:left;width:810px;text-align:right;"><?php  echo __('shipping_handing'); ?></h4>                                       
									<label style="float:right;width:130px;text-align:left;"><?php
   $totalamount= array_sum($tamount);
    echo $site_currency . " " . Commonfunction::numberformat($sfee); ?></label>
                                       
                                    </div>

                                </div>  
				  
                                <div class="tab_one_top3">
                                    <div class="conn_left" style="width:100%; float:left;">
                                       
 <h4 style="float:left;width:810px;text-align:right;"><?php echo __('grand_total'); ?></h4>
									   <label style="float:right;width:130px;text-align:left;"><?php
   $totalamount= array_sum($tamount)+$sfee;
    echo $site_currency . " " . Commonfunction::numberformat($totalamount); ?></label>
                                       
                                    </div>

                                </div>
                                <div class="tab_one_top3">
                                    <div class="yell_one">
                                        <div class="ye_left"></div>
                                        <div class="ye_mid"><a style="float:left;padding-top:8px;" href="<?php echo URL_BASE; ?>site/buynow/checkout"> <?php echo __('check_out'); ?>   </a> </div>
                                        <div class="ye_right"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                                <div class="user" style="display:none;" ><?php echo $auction_userid; ?></div>	
                            </div>

                        <?php else: ?>
                            <h4 class="no_data clr" style="float:none;"><?php echo __("not_add_addtocart_products"); ?></h4>
                        <?php endif; ?>
                        <!--Pagination-->
                        <div class="pagination">
                            <p><?php echo $pagination->render(); ?></p>
                        </div>
                        <!--End of Pagination-->
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
</div>
<script type="text/javascript">
    function frmdel(transactionid)
    {
        var answer = confirm("<?php echo __('delete_alert_cart_product'); ?>")
        if (answer){
            window.location="<?php echo URL_BASE; ?>site/buynow/buynow_remove/"+transactionid;
        }
    
        return false;  
    } 
    $(document).ready(function () {$("#users_menu").addClass("fl active");$("#addtocart_list_active").addClass("user_link_active");});
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
