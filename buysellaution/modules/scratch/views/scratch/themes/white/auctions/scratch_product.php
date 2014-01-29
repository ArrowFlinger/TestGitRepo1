<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript">
	$(document).ready(function () {$("#won_auctions_active").addClass("act_class");});
</script>
<div class="my_message_right" id="won_auctions_tpage">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('my_productlist'));?>"><?php echo strtoupper(__('my_productlist'));?></h1>
		<p>&nbsp;</p>
	</div>
		<?php if($count_user_watchlist>0)
		{?>
			<div class="message_common">
			<div class="forms_common">
			<div class="title_cont_watchilist">
                            
                                             <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                      
                        <thead>
                            <tr>
                                <th width="100" align="center"><b><?php echo __('image');?></b></th>
                                  <th width="100" align="center"><b><?php echo __('title');?></b></th>
                                     <th width="100" align="center"><b><?php echo __('amount');?></b></th>
                                        <th width="100" align="center"><b><?php echo __('total');?></b></th>
                                             <th width="100" align="center"><b><?php echo __('auctions');?></b></th>
                            </tr>
                        </thead>
		

			<?php 
                        $i=0;
                foreach($scratch_results as $product_result):?>
                        
	<tr>
		<td width="100" align="center">
			<h3>
			<?php if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$product_result['product_image']))
                        { 
                                $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$product_result['product_image'];
                        }
                        else
                        {
                                $product_img_path=IMGPATH.NO_IMAGE;
                        }
                        ?>
								 <img src="<?php echo $product_img_path;?>" width="100" height="100" title="<?php echo ucfirst($product_result['product_name']);?>"/></a>
			</h3>
		</td>
		<td width="100" align="center">
			<a style="width:130px;" title="<?php echo ucfirst($product_result['product_name']);?>" href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>"><?php  echo wordwrap(ucfirst($product_result['product_name']),32,'<br />',1);?></a>
		</td>
		
		<td width="100" align="center">
			<h2><?php echo $site_currency."".Commonfunction::numberformat($product_result['amount']);?></h2>
		</td>
		
		
				<td width="100" align="center">
			<h2><?php echo $site_currency."".Commonfunction::numberformat($product_result['total_amt']);?></h2>
		</td>
	
	<td width="100" align="center">
	   <h2>
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

	   </h2>
	</td>

	<?php  $i++; endforeach; 
			}
			 	
			else
			{ ?>
			<div class="message_common">
				<h4 style="float:none;" class="no_data fl clr"><?php echo __("no_won_scratch_product_at_the_moment");?></h4> 
			</div>
			<?php
			}?>
	</tr>
                                             </table>
	</div>
                            </div>
	</div>
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	<!--Pagination-->
			<div class="nauction_pagination">
				<p><?php echo $pagination->render(); ?></p>
			</div>
	<!--End of Pagination-->
	</div>
</div>

<script type="text/javascript">
$(document).ready(function () {$("#scratchactive").parents('li').addClass("act_class");});
</script>
