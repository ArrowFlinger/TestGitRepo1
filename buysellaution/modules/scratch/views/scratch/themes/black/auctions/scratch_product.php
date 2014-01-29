<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out content_left_out1 fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr" title="<?php echo __('my_productlist');?>"><?php echo __('my_productlist');?></h2>
        </div>
        </div>
        </div>
           <div class="deal-left clearfix">    
        <div class="action_deal_list  action_deal_list2 clearfix">	 
        <div class="watch_list_items watch_list_items1 fl clr">
        <div id="managetable" class="fl clr">
        <?php if($count_user_watchlist>0){ ?>
        <!--List products-->
		
                <div class="table-left">
                <div class="table-right">
                <div class="table-mid">		
                <table width="660" border="0" align="center" cellpadding="0" cellspacing="0"  class="table-top watch-table">
                        <tr>    <th width="100" align="center"><b><?php echo __('image');?></b></th>
                                <th width="100" align="center"><b><?php echo __('title');?></b></th>
                                <th width="100" align="center"><b><?php echo __('amount');?></b></th>
                                <th width="100" align="center"><b><?php echo __('total');?></b></th>
                                <th width="150" align="center"><b><?php echo __('actions');?></b></th>
                        </tr>
                </table>
                </div>
                </div>
                </div>
        <table width="660" border="0" align="center" cellpadding="0" cellspacing="0" id="scarach_product_table">
                <?php  
                $i=0;
                foreach($scratch_results as $product_result):?>
                <tr>
                        <td align="center" width="100">
                        <?php if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$product_result['product_image']))
                        { 
                                $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$product_result['product_image'];
                        }
                        else
                        {
                                $product_img_path=IMGPATH.NO_IMAGE;
                        }
                        ?>
                        <img src="<?php echo $product_img_path;?>" width="50" height="50"  title="<?php echo ucfirst($product_result['product_name']);?>" />
                        </td>
                        <td width="100" align="center"><a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo ucfirst($product_result['product_name']);?>" class="fl"><p><?php echo ucfirst($product_result['product_name']);?></p></a></td>
                        <td width="100" align="center"><p><?php echo $site_currency."".Commonfunction::numberformat($product_result['amount']);?></p></td>
                        <td width="100" align="center"><p><?php echo $site_currency."".Commonfunction::numberformat($product_result['total_amt']);?></p></td>
                        <td width="150" align="center">
                 <?php  
                        if(!$product_result['order_status']){

				$shipping_fee=($product_result['shipping_fee']!='')?$product_result['shipping_fee']:0;
				if($product_result['userid'] == 0){
					
					$param = array( array(array('form[id][]'=>$product_result['productid'],'form[image][]'=>$product_result['product_image'],'form[product_url][]'=>$product_result['product_url'],'form[unitprice][]'=>$product_result['amount'],'form[shipping_cost]'=>$shipping_fee,'form[quantity][]' => 1,'form[name][]' => $product_result['product_name'],
					'form[type]' =>'wonauction','form[nauction_type]' =>'product')),
					$site_currency,$i,URL_BASE."process/gateway");
					call_user_func_array('Commonfunction::showlinkdata', $param);
				}
				else
				{ 
					$param = array( array(array('form[id][]'=>$product_result['productid'],'form[image][]'=>$product_result['product_image'],'form[product_url][]'=>$product_result['product_url'],'form[unitprice][]'=>$product_result['amount'],'form[shipping_cost]'=>$shipping_fee,'form[quantity][]' => 1,'form[name][]' => $product_result['product_name'],
					'form[type]' =>'wonauction','form[nauction_type]' =>'product')),
					$site_currency,$i,URL_BASE."site/listingcost/buyproduct/".$product_result['productid']);
					call_user_func_array('Commonfunction::showlinkdata', $param);
				}
			}
			else
			{
			echo "<span style='color:green'>".__("order_completed")."</span>";         
			}
			?>
                     </td>
                </tr>
                <?php $i++; endforeach; 
                }
                else
                {
                ?>
                        <h4 class="no_data fl clr"><?php echo __("no_won_scratch_product_at_the_moment");?></h4> 
                <?php 
                }?>
        </table>
	</div></div>
	<div class="clear"></div>
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	</div>
        <!--Pagination-->
        <div class="pagination">
        <?php if($count_user_watchlist > 0): ?>
        <p><?php echo $pagination->render(); ?></p>  
        <?php endif; ?>
        </div>
        <!--End of Pagination-->    </div>
    </div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
        </div>

<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#scratchactive").addClass("user_link_active");

});
</script>
