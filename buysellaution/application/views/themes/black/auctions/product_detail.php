<?php defined("SYSPATH") or die("No direct script access."); ?>

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
    
<div class="user" style="display:none;" ><?php echo $auction_userid;?></div></div>
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

//For Photo View Using Lightbox
    //=============================

    jQuery(function($) {
        $('#gallery a').lightBox();
    });
</script>
