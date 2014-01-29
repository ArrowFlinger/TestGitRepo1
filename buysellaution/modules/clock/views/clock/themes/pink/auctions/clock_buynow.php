<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="main_container_outer fl clr">
   <div class="main_container_in">
      <div class="main_container fl clr">
         <div class="wrapper_outer" id="process_page">
            <div class="wrapper_inner">
               <div class="wrapper">
                  <div class="auctions_black_authorize_top_bg">
                     <div class="auctions_black_authorize_top_left"></div>
                     <div class="auctions_black_authorize_top_mid">
                        <h2><?php echo __('clock_buynow_label');?></h2>
                     </div>
                     <div class="auctions_black_authorize_top_right"></div>
                  </div>
                  <div class="actions_black_autorize_mid_bg">
                     <div class="container_right">
                        <form id="paymentsubmit" method="post" name="paymentsubmit" action="<?php echo URL_BASE;?>process/gateway">
				<input type="hidden" value="<?php echo $product_result['id'];?>" name="form[id][]">
            <input type="hidden" value="<?php echo $product_result['unitprice'];?>" name="form[unitprice][]">
            <input type="hidden" value="1" name="form[quantity][]">
            <input type="hidden" value="<?php echo $product_result['name'] ?>" name="form[name][]">
            <input type="hidden" value="clockauction" name="form[type]">
               
            <div id="managetable" class="fl clr" style="width:945px !important;">
	       
			<!-- /******/ -->
	       <div class="container_left">
		  <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $productdetails['product_url'];?>">
		     <img src="<?php echo URL_BASE.''.PRODUCTS_IMGPATH_THUMB.''.$productdetails['product_image'];?>"
			title="<?php echo $productdetails['product_name'];?>"
			alt="<?php echo $productdetails['product_name'];?>" height="100" width="148">
		  </a>
               </div>
               <div class="container_right">
		  <div class="product_name">
		     <strong><?php echo __('Product_Name'); ?></strong><p><?php echo $productdetails['product_name'];?></p>
		  </div>
                  <div class="amount">
                     <strong><?php echo __('Price_value'); ?>:</strong><p><font class="">$</font> <?php echo $product_result['unitprice'];?></p>
                  </div>
		  <div class="amount">
		     <strong><?php echo __('product_description'); ?>:</strong>
		     <p><?php echo $productdetails['product_info'];?></p>
                  </div>
        <div class="amount">
		     <strong><?php echo __('start_time_label'); ?>:</strong>
		     <p><?php echo Commonfunction::date_to_string($productdetails['startdate']); ?></p>
                  </div>
        
        <div class="amount">
		     <strong><?php echo __('end_time_label'); ?>:</strong>
		     <p><?php echo Commonfunction::date_to_string($productdetails['enddate']); ?></p>
                  </div>
        
		  <div class="amount">
                      <div class="fl">
		     <div class="buy_now_l" style="margin: 0 0 0 0px;"></div>
	       <div class="buy_now_mid">
	       <a onclick="$('#paymentsubmit').submit();" href="javascript:;" title="<?php echo __('buynow_lable')?>">
	       <?php echo __('buynow_lable')?>
	       </a></div>
                       <div class="buy_now_r"></div>
                      </div>
	     <div class="fl">
	        <div class="buy_now_l" style="margin: 0 0 0 5px;"></div>
	        <div class="buy_now_mid">
	       <a id="paymentcancel" href="javascript:;" title="<?php echo __('Cancel')?>" >
	       <?php echo __('Cancel')?>
	       </a></div>
	          <div class="buy_now_r"></div>
             </div>
		  </div>       
	       </div>
	    </div>
	 </div>
	 <!-- /******/ -->
            </div>
         </form>
        
                     </div>
                  </div>
               </div>
               <div class="actions_black_autorize_bottom_bg">
                  <div class="authorize_border_bg_left"></div>
                  <div class="authorize_border_bg_mid"></div>
                  <div class="authorize_border_bg_right"></div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">

$("#paymentcancel").click(function(){
               
                       $.ajax({
                       url:'<?php echo URL_BASE;?>site/clock/buynowcancel',
                       type:'post',
                       data:'pid=<?php echo $productdetails["product_id"] ?>',
                       dataType:'json',
                       complete:function(data)
                       {
                               console.log(data.responseText);        
                       },
                       success:function(data)
                       {
                               $("#paymentcancel").html(console.log);        
                       }
                       
                       });  
                       history.go(-1);              
               
       });

</script>
