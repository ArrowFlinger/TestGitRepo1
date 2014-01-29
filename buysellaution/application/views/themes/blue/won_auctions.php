<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('menu_won_auctions');?>>"><?php echo __('menu_won_auctions');?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
        <div class="action_deal_list  action_deal_list2 clearfix">	
        <?php if($count_user_wonauctions>0):?>	
        <div class="watch_list_items fl clr" id="won_auctions_page">	
		<div id="managetable" class="fl clr">
		<!--List products-->
                
                
               <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table_top">
                      
                   <thead>
                       <tr>
                           <th width="100"  align="center"><p><?php echo __('image');?></p></th>
                <th width="150"  align="center"><p><?php echo __('title');?></p></th>
                <th width="150"  align="center"><p><?php echo __('end_time');?></p></th>
                       <th width="120"  align="center"><p><?php echo __('price');?> </p></th>
                   <th width="100"  align="center"><p><?php echo __('options');?></p></th>
               <!--  <th width="100"  align="center"><p><?php //echo __('status_label');?></p></th>-->
                       </tr>
                   </thead>
  
                <?php
                $i=0;
                foreach($wonauctions_results as $won_result):?>
                <tr>
                        <td width="100"  align="center" >
                        <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $won_result['product_url'];?>" >
                        <?php if(($won_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image']))
                        { 
                        $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image'];	
                        }
                        else
                        {
                        $product_img_path=IMGPATH.NO_IMAGE;
                        }
                        ?>
                        <img src="<?php echo $product_img_path;?>" width="50" height="50" title="<?php echo ucfirst($won_result['product_name']);?>"/>
                        </a>
                        </td>
                        <?php /*<td align=""><p><?php echo ucfirst($won_result['typename']);?></p></td> */ ?>
                        <td width="150"  align="center"><p><?php echo ucfirst($won_result['product_name']);?></p></td>		
                        <td width="150"  align="center"><p><?php echo $won_result['enddate'];?></p></td>
                       
                        <td width="120"  align="center"><b><?php echo  $site_currency." ".Commonfunction::numberformat($won_result['current_price']);?></b></td>
						
                        <td width="100"  align="center">
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
                <?php  $i++; endforeach; 
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
</div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#won_auctions_active").addClass("user_link_active");});
</script>
