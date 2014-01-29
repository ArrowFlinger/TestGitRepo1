<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="action_content_left fl" id="lowest_mybids_page">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('placed_unique_bid_product');?>"><?php echo __('placed_unique_bid_product');?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
        <div class="action_deal_list  action_deal_list1 clearfix">	
        <?php if($count_bidhistory>0):?>	
        <div class="watch_list_items fl clr">	
		<div id="managetable" class="fl clr">
		<!--List products-->
		<div class="table-left">
        <div class="table-right">
        <div class="table-mid">
       <table width="660" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                <tr>
                        <th width="50" align="center"><b><?php echo __('image');?></b></th>
                        <th width="140" align="center"><b><?php echo __('title');?></b></th>
                        <th width="140" align="center"><b><?php echo __('end_time');?></b></th>
                        <th width="125" align="center" style="padding:0 0 0 25px;"><b><?php echo __('total_bids');?></b></th>
                        <th width="140" align="center"><b class="line_height"><?php echo __('auction_paid_price');?></b></th>
                        <th width="140" align="center"><b><?php echo __('status_label');?></b></li>
                </tr>
        </table>
        </div>
        </div>
        </div>
        <table width="670" border="0" align="left" cellpadding="0" cellspacing="0">
                <?php  
                foreach($bidhistories as $bidhistory):?>
				
				
                 <tr>
                        <td align="center" width="50" >
                        <a href="<?php echo URL_BASE;?>auctions/view_product_history/<?php echo $bidhistory['product_url'];?>" class="fl" style="margin:5px 0px">
                        <?php if(($bidhistory['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$bidhistory['product_image']))
                        { 
                        $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$bidhistory['product_image'];	
                        }
                        else
                        {
                        $product_img_path=IMGPATH.NO_IMAGE;
                        }
                        ?>
                        <img src="<?php echo $product_img_path;?>" width="50" style="margin-left:5px;" height="50" class="fl" title="<?php echo ucfirst($bidhistory['product_name']);?>"/>
                        </a>
                        </td>
                         <td align="center" width="140"><p class=" fl" style="width:100px; word-wrap:break-word;"><?php echo ucfirst($bidhistory['product_name']);?></p></td>	
                        <td align="center" width="140"><p class="fl" style="width:130px; word-wrap:break-word;"><?php echo $bidhistory['enddate'];?></p></td>
                        <td align="center" width="125"><p class="watch_list_time" style="width:138px;"><?php echo  $bidhistory['count('.BID_HISTORIES.'.product_id)'];
                        ?></p></td>
                        <td align="center" width="140"><b style="color:#3d3d3d; font-weight:normal;width:100px; word-wrap:break-word;"><?php echo  $site_currency." ".Commonfunction::numberformat($bidhistory['current_price']);?></b></td>
                        <td align="center" width="100">
                       <?php echo $bidhistory['in_auction']!=2?"<a href='".URL_BASE."auctions/view_product_history/".$bidhistory['product_url']."' class='delet_link fr' title='".__('live_text')."'>".__('live_text')."</a>":"<p class='watch_list_time fl'>".__('closed_text')."</p>";?>
                        </td>
                </tr>
                <?php endforeach; 
                ?>
       </table>
        </div>
        <div class="clear"></div>
        <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
        </div>
	
<?php else:?>
	<h4 class="no_data clr" style="float:none;"><?php echo __("no_unique_lowest_bid_price_at_the_moment");?></h4>
<?php endif;?>
<!--Pagination-->
<div class="pagination">
<p><?php echo $pagination->render(); ?></p>
</div>
<!--End of Pagination-->
</div>
</div>
        <div class="auction-bl">
        <div class="auction-br" style="width:660px;">
        <div class="auction-bm">
        </div>
        </div>
        </div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_bids1_active").addClass("user_link_active");});
</script>
