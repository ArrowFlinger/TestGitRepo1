<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript">
	$(document).ready(function(){	

 item_len > 0 ? Auction.getauctionstatus(3):"";	
});
</script>
      <div class="banner_rgt" id="feature_page">
                        <!--feature part start-->
                        <div class="today_headss">
                            <h2 title="<?php echo strtoupper(__('menu_future_auctions'));?>"><?php echo __('menu_future_auctions');?></h2>
                            <span class="arrow_one_fet"> &nbsp;</span>
                            
                        </div>
                        <div class="feature_total">
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
	</div>
	<?php if(!$count){?>
	<div class="message_common">
		<h4 class="no_data fl clr"><?php echo __("no_future_auction_at_the_moment");?></h4>
	</div>
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
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function () {$("#future_menu").addClass("fl active");});
</script>
