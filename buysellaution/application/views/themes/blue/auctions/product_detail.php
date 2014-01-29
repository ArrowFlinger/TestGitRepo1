<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript"> 
$(document).ready(function(){
  $("#hide").click(function(){
    $(".fun").hide();
  });
  $("#show").click(function(){
    $(".fun").show();
  });
});
</script>
 

<!--Map-->

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
 <style type="text/css"> 
      #map-canvas {
        width: 960px;
        height: 190px
      }
	   .price_table{ border:1px solid #E2E1E1; border-bottom:0px;background:#E8E8E8; }
	  .price_table td{ border-bottom:1px solid #D9D7D7; }
	   .price_table  td { color:#BB006F;}
    </style> 
<!--Map End-->
<?php if($product_results[0]['enddate']>= SERVER_DATE){?>
<script type="text/javascript">
$(document).ready(function(){
Auction.getauctionstatus(6,"",'<?php echo $pid;?>');					   
});
</script>
<?php } 
else {
?><script type="text/javascript">
$(document).ready(function(){
Auction.bidhistory();				   
});
</script>
<?php }?>
	<?php
	if(isset($auction_types[$type])){
	  $block = $auction_types[$type]::product_block($pid,6);
	  echo $block;
	}
	else
	{?>
	<!--Module not exits-->
	<?php echo __('module_not_exist');?>
<?php	}
	?>    		
    
    
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>

</div>
<?php 
			                // To return user data
			               
			                $url=URL_BASE."auctions/fblike";
			                $message=__('flike_alert_msg');
		                ?>
		                <?php echo $include_facebook;?>		
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
				FB.Event.subscribe('edge.create',
				function(response) {
				insert_fbuser();
				//alert('You liked the URL: ' + response);
				});
				});		
</script>	
