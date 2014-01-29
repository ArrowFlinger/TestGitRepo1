<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out content_left_out1 fl">
<div class="action_content_left fl pb20">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('menu_buy_packages');?>"><?php echo __('menu_buy_packages');?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
        <div class="action_deal_list action_deal_list1 clearfix">
        <div class="bids_package_content1 fl clr">
		<div class="bids_package_content_top fl clr pb20"  style="display:none;">
               	<div class="bids_package_row1 fl clr">
            	<p class="fl"><?php echo __('If you have a coupon or discount code enter it in below to receive a discount.');?>
                 </p>
                </div>
                <div class="bids_package_row1 fl clr mt10">
                <label class="fl"><?php echo __('coupon_code_label');?>:</label>
                </div>
            <div class="bids_package_row1 fl clr mt15">
            	<div class="inputbox_out fl">
                	<input type="text" value="" name="" class="fl" title="<?php echo __('coupon_code_label');?>" />
                </div>
            	<div class="login_submit_btn coupon_submit_btn fl ml10">
                    <span class="login_submit_btn_left fl">&nbsp;</span>
                    <span class="login_submit_btn_middle fl"><input type="submit" value="<?php echo __('apply_coupon');?>" class="fl" title="<?php echo __('apply_coupon');?>" /></span>
                    <span class="login_submit_btn_left login_submit_btn_right fl">&nbsp;</span>
                </div>
            </div> 
        </div> 
        <?php if($count_package_result>0):?>
        <div class="bids_package_content_top fl clr ">
      
        <form action="method" class="coupon-form clearfix">
                <div class="row_colm1 fl clr mt20">
               
                </div>
        </form>
  
<div class="watch_list_items fl clr">
		<div id="managetable" class="fl clr">
	<!--List products-->
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-top">
                       <thead>   
                    <tr>
		                <th width="100" align="center" > <b><?php echo __('Name_label');?></b></th>
		                <th width="100" align="center"><b><?php echo __('Price_label');?></b></th>
		                <th width="130" align="center"><b><?php echo __('Options_label');?></b></th>
		                
		        </tr>
                    </thead>
           
                <?php  
                $count=$count_package_result;
                $i=0;
                foreach($package_results as $package_result):
                $bg_none=($i==$count-1)?'bg_none':"";
                ?>
                <tr>
                        <td  width="100" align="center" valign="top">
                        <div class=" <?php echo $bg_none;?>">
                        <label><?php echo ucfirst($package_result['name']);?></label>
                        </div>
                        </td>
                        <td width="100" align="center" valign="top">
                        <div class=" <?php echo $bg_none;?>"><span style="color:#3d3d3d;"><?php echo $site_currency;?></span> <b><?php echo Commonfunction::numberformat($package_result['price']);?></b></div>
                        </td>
                        <td  width="100" align="center" valign="top">
                        <div class=" <?php  echo $bg_none;?>">
                                <?php
		  
		  $param = array( array(array('form[id][]'=>$package_result['package_id'],'form[nauction_type]' =>'package','form[unitprice][]'=>$package_result['price'],'form[quantity][]' => 1,'form[name][]' => $package_result['name'],'form[type]' =>'package')),$site_currency,$i,URL_BASE."process/gateway");  
		    
		    call_user_func_array('Commonfunction::showlinkdata', $param);
		    
		    ?>
                        </div>
                        </td>
                </tr>
                <?php $i++; endforeach; ?>
                </table>
                </div>
</div>
	
	
</div>

<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
<?php else:?>
	<h4 class="no_data fl clr"><?php echo __("no_packages_at_the_moment");?></h4>
<?php endif;?>
        </div>
        </div>
        </div>
        <div class="auction-ba">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
     <div class="pagination">
        <?php if($package_results > 0): ?>
        <p class="fl"><?php echo $pagination->render(); ?></p>  
        <?php endif; ?>
        </div>
</div>
        <!--Pagination-->
       
        <!--End of pagination-->


<script type="text/javascript">
$(document).ready(function () {$("#packages_menu").addClass("fl active");$("#menu_purchas_active").addClass("user_link_active");});
</script>
