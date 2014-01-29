<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript">
	$(document).ready(function(){	

 item_len > 0 ? Auction.getauctionstatus(3):"";	
});
</script>
<div class="content_left_out fl" id="black_future_page">
	<div class="content_left fl">
	<div class="title_temp1 fl clr">
    	<h2 class="fl" title="<?php echo __('menu_future_auctions');?>"><?php echo __('menu_future_auctions');?></h2>
    </div>
    <div class="action_deal_list fl clr seat_bid_content_outer">
	<div class="bidding_type">
        <div class="bidding_type_lft"></div>
        <div class="bidding_type_mid">
          <div class="bidding_inner"><span><?php echo __('bidding_type_label');?>:</span>
              <ul class="clearfix">
              <li><a title="<?php echo __('beginner_label');?>" class="beginner_icon"><?php echo __('beginner_label');?></a></li>
              <li><a title="<?php echo __('penny_label');?>" class="penny_auction_icon"><?php echo __('penny_label');?></a></li>
              <li><a title="<?php echo __('peak_label');?>" class="peak_auction"><?php echo __('peak_label');?></a></li>             
              <li><a title="<?php echo __('bonus_label');?>" class="bonus_auction_icon"><?php echo __('bonus_label');?></a></li>
              <li><a title="<?php echo __('hot_label');?>" class="hot_icon1"><?php echo __('hot_label');?></a></li> 
            </ul>
          </div>
        </div>
        <div class="bidding_type_rft"></div>
    </div>
	 <?php 
    	$count=true;
	$content=$block="";
	if(count($auction_types) > 0){
	foreach($auction_types as $typeid => $typename){
		
				if(isset($products[$typeid])){
					$block = $typename::product_block($products[$typeid],3);
					$content.=$block;
					echo $block;
				}						
		}
	} 
	if(trim($content)=="") { $count = false;}
	?>    	
	
	<div class="clear"></div>
	<!--Pagination-->
		<div class="pagination">
		<?php if($count ): ?>
		<p><?php //echo $pagination->render(); ?></p>  
		<?php endif; ?>
		</div>
	<!--End of Pagination-->
	 <?php if(!$count){?>
	<h4 class="no_data fl clr"><?php echo __("no_future_auction_at_the_moment");?></h4>
	<?php }?>
	<?php echo $include_facebook;?>	
 	<?php 
	                
	                $url=URL_BASE."auctions/fblike";
	                $message=__('flike_alert_msg');
                ?>
                <script type="text/javascript">
                function insert_fbuser()
                {
	                $.ajax({
		                type:'GET',
		                url:'<?php echo $url;?>',
		                data:'',
		                complete:function(data){
			                var msg=data.responseText;
			                if(msg==1)
			                {
				                alert("<?php echo __('flike_alert_msg');?>");
			                }
			                else if(msg==11)
			                {
				                alert("<?php echo __('flike_alert_msg2');?>");
			                }		
		                }
	                });
                }
               $(document).ready(function(){
				   try{
						FB.Event.subscribe('edge.create',
							function(response) {
							insert_fbuser();
							//alert('You liked the URL: ' + response);
							});
						}catch(e){
							Auction.showConsole(e);
						}
		});

                </script>

 
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#future_menu").addClass("fl active");});
</script>
