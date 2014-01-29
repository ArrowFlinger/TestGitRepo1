<?php defined("SYSPATH") or die("No direct script access."); ?>
<?php //print_r($wonauctions_results);exit;?>
<div class="content_left_out fl" id="won_auctions_page">
<div class="action_content_left fl">
	<div class="title_temp1 fl clr">
    	<h2 class="fl clr" title="<?php echo __('menu_won_auctions');?>"><?php echo __('menu_won_auctions');?></h2>
    </div>
    	
    	
	<div class="won_action_items fl clr mt10">
	
		<div id="managetable" class="fl clr">
		<?php if($count_user_wonauctions){ ?>
		<!--List products-->
                <table width="" border="0" align="left" cellpadding="0" cellspacing="0" style="">
		<tr>
		<th style="width:100px;" align="center"><b style="width:100%;float:left;text-align:center;"><?php echo __('image');?></b></th>
		<th style="width:100px;" align="center"><b style="width:100%;float:left;text-align:center;"><?php echo __('title');?></b></th>
		<?php /*<th width="30" align="center"><b><?php echo __('bidding_type_label');?></b></th> */ ?>
		<th style="width:100px;" align="center"><b style="width:100%;float:left;text-align:center;"><?php echo __('end_time');?></b></th>
		<th style="width:100px;" align="center"><b style="width:80%;float:left;text-align:center;"><?php echo __('price');?></b></th>
		
		<th style="width:100px;" align="center"><b style="width:80%;float:left;text-align:center;"><?php echo __('options');?></b></th>
		
		</tr>
		<?php 
		
		if($wonauctions_results)
		{	
		$count=$count_user_wonauctions;
		$i=0;
		
		
		
		foreach($wonauctions_results as $won_result):
		
		$bg_none=($i==$count-1)?'bg_none':"";
		?>
		<tr>
		<td align="center" >
			
			
			
			<a href="<?php echo url::base();?>auctions/view/<?php echo $won_result['product_url'];?>"><?php 
				
				if(($won_result['product_image'])!=""  && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
				}
			?><img src="<?php echo $product_img_path;?>" width="50" height="50" align="middle" title="<?php echo ucfirst($won_result['product_name']);?>"/></a></td>
		<td style="width:100px;" align="center" class="<?php echo $bg_none;?>"><p style="width:100px;"><?php echo Text::limit_chars(ucfirst($won_result['product_name']),12);?></p></td>	

		<td style="width:100px;" align="center" class="<?php echo $bg_none;?>"><p style="width:100px;"><?php echo  $won_result['enddate'];?></p></td>
		<td style="width:100px;" align="center" class="<?php echo $bg_none;?>"><b style="width:100px;"><?php echo  $site_currency." ".Commonfunction::numberformat($won_result['current_price']);?></b></td>		
		
		<td style="width:100px;" align="center" class="<?php echo $bg_none;?>" id="wonauction_pagetdlink">
		<?php  
		if(!$won_result['order_status']){ 
				$shipping_fee=($won_result['shipping_fee']!='')?$won_result['shipping_fee']:0;	
			
					$param = array( array(array('form[id][]'=>$won_result['product_id'],'form[image][]'=>$won_result['product_image'],'form[product_url][]'=>$won_result['product_url'],'form[unitprice][]'=>$won_result['current_price'],'form[shipping_cost]'=>$shipping_fee,'form[quantity][]' => 1,'form[name][]' => $won_result['product_name'],
					'form[type]' =>'wonauction','form[nauction_type]' =>'product')),
					$site_currency,$i,URL_BASE."process/gateway");  
					call_user_func_array('Commonfunction::showlinkdata', $param);
				
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
		?>
		
		<?php 
		}		
		else
		{ ?>
		<h4 class="no_data fl clr"><?php echo __("no_won_auction_at_the_moment");?></h4> <?php
		}?>
		</table>
		</div>
	</div>
	</div>
	<!--Pagination-->
		<div class="pagination">
		<p><?php echo $pagination->render(); ?></p>
		</div>
		<!--End of Pagination-->
</div>
		
	
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#won_auctions_active").addClass("user_link_active");});
</script>
