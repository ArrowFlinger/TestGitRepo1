<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="action_content_left fl reserve">
	<div class="title_temp1 fl clr pt10">
    	<h2 class="fl clr pl10" title="<?php echo __('menu_won_auctions_reserve');?>"><?php echo __('menu_won_auctions_reserve');?></h2>
    </div>    
<?php  if(count($wonauctions_results)>0):?>	
	<div class="watch_list_items fl clr">	
		<div id="managetable" class="fl clr">
		<!--List products-->
		
		<table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
		<tr>
                    <th width="74" align="center"><b><?php echo __('image');?></b></th>
                    <th width="130" align="center"><b><?php echo __('title');?></b></th>
                    <th width="120" align="center"><b><?php echo __('end_time');?></b></th> 
                    <th width="110" align="center"><b><?php echo __('pay_amount');?></b></th> 
                    <th width="120" align="center"><b><?php echo __('status_label');?></b></th>
		</tr>
		<?php $i=0;
		$count=count($count_user_wonauctions);
		foreach($wonauctions_results as $won_result):
		 
		$bg_none=($i==$count-1)?'bg_none':"";?>
		<tr>
		<td align="center" width="74"><a href="<?php echo url::base();?>auctions/view/<?php echo $won_result['product_url'];?>"><?php 
				
				if(($won_result['product_image'])!=""  && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
				}
			?><img src="<?php echo $product_img_path;?>" width="50" height="50" align="middle" title="<?php echo ucfirst($won_result['product_name']);?>"/></a></td>
		<td width="130" align="center" class="<?php echo $bg_none;?>"><p ><?php echo Text::limit_chars(ucfirst($won_result['product_name']),12);?></p></td>

		<td width="120" align="center" class="<?php echo $bg_none;?>"><p><?php echo  $won_result['enddate'];?></p></td>
		<td width="110" align="center" class="<?php echo $bg_none;?>"><b style="width:100%;"><?php echo  $site_currency." ".$won_result['amountpay'];?></b></td>
			 
				
		<td width="120" align="center" class="<?php echo $bg_none;?>"> 
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
		
		?>
		</table>
		</div>
		<div class="clear"></div>
		<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	</div>
	
<?php else:?>
	<h4 class="no_data clr" style="float:none;"><?php echo __("no_won_auction_at_the_moment");?></h4>
<?php endif;?>
<!--Pagination-->
<div class="pagination">
 <p><?php echo $pagination->render(); ?></p>
</div>
<!--End of Pagination-->
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#reserveactive").addClass("user_link_active");});
</script>
