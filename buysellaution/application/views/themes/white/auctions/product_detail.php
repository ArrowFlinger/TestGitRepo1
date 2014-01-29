<?php defined("SYSPATH") or die("No direct script access.");?>

<link href="<?php echo CSSPATH;?>slider.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" src="<?php echo SCRIPTPATH;?>jquery.js"></script>-->
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>easy_jquery.js"></script>
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>easySlider1.5.js"></script>
<script type="text/javascript">
$.noConflict();
jQuery(document).ready(function(j) {
		j(document).ready(function(){	
			j("#slider").easySlider({
				controlsBefore:	'<p id="controls">',
				controlsAfter:	'</p>',
				auto: true, 
				continuous: true
			});
					
		});	
});
</script>
       <!--select_box_top-->
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
	Something wrong happen to display this product.
	<?php }
	?>   
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>

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
	});
});		
</script>	

