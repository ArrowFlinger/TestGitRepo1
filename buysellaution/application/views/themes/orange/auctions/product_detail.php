<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript" src="<?php echo URL_BASE; ?>public/js/jquery.jcarousel.pack.js"> </script>	
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE;?>public/orange/css/skin.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE;?>public/orange/css/slidder-css/jquery.jcarousel.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>public/orange/css/slidder-css/skin.css"/>
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

<script type="text/javascript">
	$(document).ready(function () {
		
		//jCarousel Plugin
	    $('#carousel').jcarousel({
			vertical: true,
			scroll: 1,
			auto: 2,
			wrap: 'last',
			initCallback: mycarousel_initCallback
	   	});

	//Front page Carousel - Initial Setup
   	$('div#slideshow-carousel a img').css({'opacity': '1.0'});
   	$('div#slideshow-carousel a img:first').css({'opacity': '1.0'});
   	$('div#slideshow-carousel li a:first').append('<span class="arrow"></span>')

  
  	//Combine jCarousel with Image Display
    $('div#slideshow-carousel li a').hover(
       	function () {
        		
       		if (!$(this).has('span').length) {
        		$('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '1.0'});
   	    		$(this).stop(true, true).children('img').css({'opacity': '1.0'});
       		}		
       	},
       	function () {
        		
       		$('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '1.0'});
       		$('div#slideshow-carousel li a').each(function () {

       			if ($(this).has('span').length) $(this).children('img').css({'opacity': '1.0'});

       		});
        		
       	}
	).click(function () {

	      	$('span.arrow').remove();        
		$(this).append('<span class="arrow"></span>');
       	$('div#slideshow-main li').removeClass('active');        
       	$('div#slideshow-main li.' + $(this).attr('rel')).addClass('active');	
        	
       	return false;
	});


});

//Carousel Tweaking
function mycarousel_initCallback(carousel) {
	
	// Pause autoscrolling if the user moves with the cursor over the clip.
	carousel.clip.hover(function() {
		carousel.stopAuto();
	}, function() {
		carousel.startAuto();
	});
}
	
</script>

<!--Map-->

 <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
 <style type="text/css"> 
      #map-canvas {
        width: 960px;
        height: 190px
      }
	   .price_table{ border:1px solid #E2E1E1; border-bottom:0px;background:#E8E8E8; }
	  .price_table td{ border-bottom:1px solid #E2E1E1; }
	   .price_table  td { color:#BB006F;}
</style> 
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
<!--Map End-->

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
<!-- container_inner   CLASS END-->		               
