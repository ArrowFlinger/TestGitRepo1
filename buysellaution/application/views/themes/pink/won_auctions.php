<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl" id="won_auctions_page">
        <div class="action_content_left fl">
    	<div class="title-left title_temp1">
                <div class="title-right">
                <div class="title-mid">
    	 	<h2 class="fl clr" title="<?php echo __('menu_won_auctions');?>"><?php echo __('menu_won_auctions');?></h2>
                </div>
                </div>
        </div>
        <div class="action_deal_list  clearfix">	
        <div class="won_action_items won_action_items1 clearfix">
        <div id="managetable" class="fl clr">
        <?php if($count_user_wonauctions)
        { ?>
        <!--List products-->

		<table width="663" border="0" align="left" cellpadding="0" cellspacing="0" class="table-top">
                    <thead>
                    <tr>
		        <th  width="120" align="center"><b><?php echo __('image');?></b></th>
		        <th  width="120" align="center"><b><?php echo __('title');?></b></th>
				<?php /*<th width="30" align="center"><b><?php echo __('bidding_type_label');?></b></th> */ ?>
		        <th  width="120" align="center"><b><?php echo __('end_time');?></b></th>
		        <th  width="120" align="center"><b><?php echo __('price');?></b></th>
		        
		        <th  width="120" align="center"><b><?php echo __('options');?></b></th>
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
		        <td width="120" align="center" class="<?php echo $bg_none;?>"><a  href="<?php echo url::base();?>auctions/view/<?php echo $won_result['product_url'];?>"><?php 
				
				        if(($won_result['product_image'])!=""  && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image']))
	               			{ 
					        $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image'];
				        }
				        else
				        {
					        $product_img_path=IMGPATH.NO_IMAGE;
				        }
			        ?><img src="<?php echo $product_img_path;?>" width="50" height="50" title="<?php echo ucfirst($won_result['product_name']);?>"/></a></td>
			        
		        <td width="120" align="center" class="<?php echo $bg_none;?>"><p  class="won_action_title"><?php echo wordwrap(ucfirst($won_result['product_name']),12,'<br />',1);?></p></td>

		        <td width="120" align="center"  class="<?php echo $bg_none;?>"><p  class="watch_list_time"><?php echo  $won_result['enddate'];?></p></td>
		        <td width="120" align="center"  class="<?php echo $bg_none;?>"><b style="color:#333;"><?php echo  $site_currency." ".Commonfunction::numberformat($won_result['current_price']);?></b></td>
			
		        <td width="120" align="center"  class="<?php echo $bg_none;?>">
		        
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
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#won_auctions_active").addClass("user_link_active");});
</script>

