<?php defined("SYSPATH") or die("No direct script access."); ?>

<div class="my_message_right">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('menu_won_auctions_reserve'));?>"><?php echo strtoupper(__('menu_won_auctions_reserve'));?></h1>
		<p>&nbsp;</p>
	</div>
		<?php if(count($count_user_wonauctions)>0)
		{?>
			<div class="message_common">
			<div class="forms_common">
			<div class="title_cont_watchilist">
                                 <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                      
                        <thead>
                            <tr>
                                <th width="100" align="center"><b><?php echo __('image');?></b></th>
                                  <th width="100" align="center"><b><?php echo __('title');?></b></th>
                                     <th width="100" align="center"><b><?php echo __('end_time');?></b></th>
                                        <th width="100" align="center"><b><?php echo __('pay_amount');?></b></th>
                                             <th width="100" align="center"><b><?php echo __('status_label');?></b></th>
                            </tr>
                        </thead>
               
			
			<?php 		
			if($wonauctions_results)
			{	
				 $i=0;
				$count=count($count_user_wonauctions);
				foreach($wonauctions_results as $won_result):
				$bg_none=($i==$count-1)?'bg_none':"";?>
			
	<tr>
		<td width="100" align="center">
			<h3><a href="<?php echo url::base();?>auctions/view/<?php echo $won_result['product_url'];?>"><?php 
							
								if(($won_result['product_image'])!=""  && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$won_result['product_image']))
									{ 
									$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$won_result['product_image'];
									}
									else
									{
										$product_img_path=IMGPATH.NO_IMAGE;
									}
								?><img src="<?php echo $product_img_path;?>" width="100" height="100" title="<?php echo ucfirst($won_result['product_name']);?>"/></a>
			</h3>
		</td>
		<td width="100" align="center">
			<a   style="width:120px;" title="<?php echo ucfirst($won_result['product_name']);?>" href="<?php echo URL_BASE;?>auctions/view/<?php echo $won_result['product_url'];?>"><?php  echo wordwrap(ucfirst($won_result['product_name']),32,'<br />',1);?></a>
		</div>
		<td width="100" align="center">
			<h2><?php echo  $won_result['enddate'];?></h2>
		</td>
		 
	<td width="100" align="center">
	   <h2><?php echo  $site_currency." ".$won_result['amountpay'];?></h2>
	</td>
	<td width="100" align="center">
			<div class="paypopup">
			
			<?php			 
			if(!$won_result['order_status']){
		if($won_result['userid'] == 0){
				$param = array( array(array('form[id][]'=>$won_result['product_id'],'form[image][]'=>$won_result['product_image'],'form[product_url][]'=>URL_BASE.'auctions/view/'.$won_result['product_url'],'form[unitprice][]'=>$won_result['amountpay'],'form[quantity][]' => 1,'form[name][]' => $won_result['product_name'],'form[type]' =>'reserveauction','form[description][]' => $won_result['product_info'])),$currency_code,$i,URL_BASE."process/gateway");
				call_user_func_array('Commonfunction::showlinkdata', $param);
				}
				else
				{
				$param = array( array(array('form[id][]'=>$won_result['product_id'],'form[image][]'=>$won_result['product_image'],'form[product_url][]'=>URL_BASE.'auctions/view/'.$won_result['product_url'],'form[unitprice][]'=>$won_result['amountpay'],'form[quantity][]' => 1,'form[name][]' => $won_result['product_name'],'form[type]' =>'reserveauction','form[description][]' => $won_result['product_info'])),$currency_code,$i,URL_BASE."site/listingcost/buyproduct/".$won_result['product_id']); 
				call_user_func_array('Commonfunction::showlinkdata', $param);
				}		
			}
			else
			{
                               echo "<span style='color:green'>".__("order_completed")."</span>";         
			}?>
		</div>
		</td>
	</tr>
                                
	<?php $i++; endforeach; 
			}
			?> </table>
			
			<?php 
			}		
			else
			{ ?>
			<div class="message_common">
				<h4 class="no_data fl clr"><?php echo __("no_reserve_won_auction_at_the_moment");?></h4> 
			</div>
			<?php
			}?>

	</div>
	</div>
    	</div>
	<!--Pagination-->
			<div class="nauction_pagination">
				<p><?php echo $pagination->render(); ?></p>
			</div>
	<!--End of Pagination-->
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#reserveactive").parents('li').addClass("act_class");});
</script>
