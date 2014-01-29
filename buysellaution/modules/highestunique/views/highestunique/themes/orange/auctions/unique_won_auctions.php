<?php defined("SYSPATH") or die("No direct script access.");  ?>
<div class="content_left_out content_left_out1 fl">
        <div class="action_content_left fl">
    	<div class="title-left title_temp1">
                <div class="title-right">
                <div class="title-mid">
    	 	<h2 class="fl clr" title="<?php echo __('menu_won_auctions');?>"><?php echo __('menu_won_auctions');?></h2>
                </div>
                </div>
        </div>
         <div class="deal-left clearfix">
        <div class="action_deal_list action_deal_list2 clearfix">	
        <div class="won_action_items won_action_items1 clearfix">
        <div style="margin-top:10px;" id="managetable" class="fl clr">
       <?php if(count($wonauctions_results))
	{ ?>
        <!--List products-->
        <div class="table-left">
            <div class="table-right">
            <div class="table-mid">
		<div class="table-top lin_top_mid">
		   <ul>
		        <li style="width:87px" align="center"><b><?php echo __('image');?></b></li>
		        <li style="width:105px"><b><?php echo __('title');?></b></li>
		        <li style="width:120px;padding:0 0 0 0px;"><b><?php echo __('end_time');?></b></li>
		        <li style="width:100px;padding:0 0 0 0px;"><b><?php echo __('price');?></b></li>
		        <li style="width:113px"><b><?php echo __('auction_paid_price');?></b></li>		        
		        <li style="width:80px"><b><?php echo __('options');?></b></li>			
		   </ul>
                </div>
           </div>
           </div>
        </div>
        <div class="table-top top_ul">
        <?php 		
			
		$count=$count_user_wonauctions;
		$i=0;
		foreach($wonauctions_results as $won_result):
			if($usersid == $won_result['user_id']){
		$bg_none=($i==$count-1)?'bg_none':"";
		?>
		<ul>
		        <li style="width:87px" align="center" class="<?php echo $bg_none;?>"><a href="<?php echo url::base();?>auctions/view/<?php echo $won_result['product_url'];?>"><?php 
				
				        if(($won_result['product_image'])!=""  && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image']))
	               			{ 
					        $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$won_result['product_image'];
				        }
				        else
				        {
					        $product_img_path=IMGPATH.NO_IMAGE;
				        }
			        ?><img src="<?php echo $product_img_path;?>" width="50" height="50" title="<?php echo ucfirst($won_result['product_name']);?>"/></a></li>
		        <li style="width:105px" align="center" class="<?php echo $bg_none;?>"><p class="won_action_title fl"><?php echo wordwrap(ucfirst($won_result['product_name']),12,'<br />',1);?></p></li>

		        <li style="width:120px;" align="center" class="<?php echo $bg_none;?>"><p class="watch_list_time"><?php echo  $won_result['enddate'];?></p></li>
		        <li style="width:100px;" align="center" class="<?php echo $bg_none;?>"><b  style="color:#3d3d3d; font-weight:normal;"><?php echo  $site_currency." ".Commonfunction::numberformat($won_result['current_price']);?></b></li>
			<?php $user_spents=$users->winner_user_amount_spent($won_result['product_id'],$won_result['lastbidder_userid']);
						$amount=0;
					foreach($user_spents as $user_spent)
					{		
						$amount += $user_spent['price'];
					}
					
					?>
			
		        <li style="width:113px;" align="center" class="<?php echo $bg_none;?>"><b class="fl won_action_price won_action_price1"><?php echo $site_currency." ".Commonfunction::numberformat($amount); ?></b></li>
		        <!--<li style="width:100px;border:1px solid red;" align="center" class="<?php echo $bg_none;?>"><b class="fl won_action_price won_action_price1"><?php //echo $site_currency." ".Commonfunction::numberformat($refund); ?></b></li>-->
		
		        <li style="width:80px;" align="center" class="<?php echo $bg_none;?>">
			
			<?php if($won_result['status']==0)
				{
				?>
				<?php /*<a href="<?php echo url::base();?>users/buynow/<?php echo $won_result['product_url'];?>" class="view_link fl" title="<?php echo __('buy_now');?>"><?php echo __('buy_now');?></a> */?>
				<?php 
				}
				else
				{
				echo "Purchased";
				}
				?>
			<a href="<?php echo url::base();?>users/paymenttype/<?php echo $won_result['product_url'];?>" class="view_link fl" title="<?php echo __('buy_now');?>"><?php echo __('buy');?></a>
		</li>
		
		</ul>
  
		<?php } endforeach;  ?></div>
		<?php      }else { ?>
	
        <h4 class="no_data fl clr"><?php echo __("no_won_auction_at_the_moment");?></h4> <?php
        }?>
	 
        </div>
	</div>
	</div>
         <!--Pagination-->
        <div class="pagination">
        <p><?php echo $pagination->render(); ?></p>
        </div>
        <!--End of Pagination-->
   
    </div>
    <div class="auction-bl">
      <div class="auction-br" style="width:660px;">
    <div class="auction-bm" style="width:645px;">
    </div>
    </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#unique_won_auctions_active").addClass("user_link_active");});
</script>
