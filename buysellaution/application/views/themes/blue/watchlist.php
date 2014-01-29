<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out content_left_out1 fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr" title="<?php echo __('my_watchlist');?>"><?php echo __('my_watchlist');?></h2>
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
                <table width="660" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top watch-table">
                        <tr>
                                <th width="70" align="left"><b><?php echo __('image');?></b></th>
                                <th width="150" align="center"><b><?php echo __('title');?></b></th>
                                <th width="150" align="center"><b class="title"><?php echo __('end_time');?></b></th>
                               <?php /* <th width="90" align="center"><b><?php echo __('price');?></b></th> */?>
                                <th width="88" align="center"><b><?php echo __('actions');?></b></th>
                        </tr>
                </table>
                </div>
                </div>
                </div>
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
                <?php 
                foreach($watch_results as $watch_result):?>
                <tr>
                        <td align="left" width="80">
                        <a href="<?php echo url::base();?>auctions/view/<?php echo $watch_result['product_url'];?>" class="fl">
                        <?php if(($watch_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$watch_result['product_image']))
                        { 
                                $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$watch_result['product_image'];
                        }
                        else
                        {
                                $product_img_path=IMGPATH.NO_IMAGE;
                        }
                        ?>
                        <img src="<?php echo $product_img_path;?>" width="50" height="50"  class="fl" title="<?php echo ucfirst($watch_result['product_name']);?>" />
                        </a>
                        </td>
                        <td align="center" width="160"><p class="watch_list_title" style="padding:0 0 0 0px;width:120px;text-align:center;"><?php echo ucfirst($watch_result['product_name']);?></p></td>
                        <td align="center" width="150"  ><p class="watch_list_time"><?php echo $watch_result['enddate'];?></p></td>
                       <?php /* <td align="center" width="80"><b  style="color:#3d3d3d; font-weight:normal;"><?php echo  $site_currency." ".Commonfunction::numberformat($watch_result['current_price']);?></b></td> */?>
                        <td align="center" width="95">
                        <a href="<?php echo url::base();?>users/watchlist/<?php echo $watch_result['watch_id'];?>" onclick=" return confirmDelete('<?php echo __('are_you_sure_delete');?>');" title="<?php echo __('button_delete');?>" class="delet_link fr" style="padding:0 0 0 15px;"><?php echo __('button_delete');?></a>
                        </td>
                </tr>
                <?php endforeach; 
                }
                else
                {
                ?>
                        <h4 class="no_data fl clr"><?php echo __("no_watchlist_auction_at_the_moment");?></h4> 
                <?php 
                }?>
        </table>
	</div>
	<div class="clear"></div>
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	</div>
        <!--Pagination-->
        <div class="pagination">
        <?php if($count_user_watchlist > 0): ?>
        <p><?php echo $pagination->render(); ?></p>  
        <?php endif; ?>
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
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_watchlist_active").addClass("user_link_active");});
</script>
