<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript">
	$(document).ready(function () {$("#won_auctions_active").addClass("act_class");});
</script>
<div class="my_message_right" id="won_auctions_tpage">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('menu_won_auctions'));?>"><?php echo strtoupper(__('menu_won_auctions'));?></h1>
		<p>&nbsp;</p>
	</div>
		<?php if($count_user_wonauctions)
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
                                      <th width="100" align="center"><b><?php echo __('price');?></b></th>
                                        <th width="100" align="center"><b><?php echo __('status');?></b></th>
                            </tr>
                        </thead>
     
			
			<?php 		
			if($wonauctions_results)
			{	
				$count=$count_user_wonauctions;
				$i=0;
				foreach($wonauctions_results as $won_result):
				$bg_none=($i==$count-1)?'bg_none':"";
			?>
	<tr>
		<td width="100" align="center">
			<h3>
                            <a href="<?php echo url::base();?>auctions/view/<?php echo $won_result['product_url'];?>"><?php 
							
								if(($won_result['product_image'])!=""  && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image']))
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
			<a  title="<?php echo ucfirst($won_result['product_name']);?>" href="<?php echo URL_BASE;?>auctions/view/<?php echo $won_result['product_url'];?>"><?php  echo wordwrap(ucfirst($won_result['product_name']),32,'<br />',1);?></a>
		</td>
		
		<td width="100" align="center">
			<h2><?php echo  $won_result['enddate'];?></h2>
		</td>
		
		<?php $user_spents=$users->winner_user_amount_spent($won_result['product_id'],$won_result['lastbidder_userid']);
				//print_r($user_spents);exit;
							$amount=0;
						foreach($user_spents as $user_spent)
						{		
							$amount += $user_spent['price'];
						}
						
						?>				
				<?php /*
					if($won_result['product_cost']<$won_result['current_price'])
					{
						$refund=($won_result['current_price']-$won_result['product_cost'])*$won_result['current_price']; 
					}
					else 
					{
						$refund="0"; 
					}*/
				?>
				<td width="100" align="center">
			<h2><?php echo $site_currency." ".Commonfunction::numberformat( $won_result['current_price']); ?></h2>
		</td>
	
	<td width="100" align="center">
	   <h2>
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

	   </h2>
	</td>
	
                           
	<?php  $i++; endforeach; 
        
			}
			?>
			
			<?php 
			}		
			else
			{ ?>     
			<div class="message_common">
				<h4  style="float:none;"><?php echo __("no_won_auction_at_the_moment");?></h4>
			</div>
			<?php
			}?>
   </tr>
                             </table>
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
$(document).ready(function () {$("#won_menu").addClass("act_class");});
</script>
