<?php defined("SYSPATH") or die("No direct script access.");?>
<script type="text/javascript">
$(document).ready(function(){		
		 Auction.getauctionstatus(8,"","",{'search':'<?php echo $value;?>'});
});
</script>
<div id="test" ></div>
<div class="content_left_out fl">
<div class="content_left fl">
    <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
               <h2 class="fl" title="<?php echo __('search_auctions');?>"><?php echo __('search_auctions');?></h2>
        </div>
        </div>
        </div>
   <div class="action_deal_list  clearfix">
   <?php 
    $count=true;	  
$content=$block="";
    if(count($auction_types) > 0){
					foreach($auction_types as $typeid => $typename){
								if(isset($products[$typeid])){
									$block = $typename::product_block($products[$typeid],8,array('search'=>$value));	
									$content.=$block;
									echo $block;							
								}
					}
				}
				if(trim($content)=="") { $count = false;}
				
		?>    	
        <div class="clear"></div>
        <?php if(!$count):?>
	<h4 class="no_data fl clr"><?php echo __("no_search_auction_found",array(":param" =>"<span style='font-size:18px;'>".$value."</span>" ));?></h4>
	<?php endif;?>
    <?php echo $include_facebook;?>
    <?php 
	
	        // To return user data
	        
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
        FB.Event.subscribe('edge.create',
         function(response) {
	        insert_fbuser();
	         //alert('You liked the URL: ' + response);
        });
        </script>
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
$(document).ready(function () {$("#live_menu").addClass("fl active");});
</script>
