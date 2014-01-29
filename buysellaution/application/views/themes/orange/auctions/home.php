<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript">
$(document).ready(function(){
Auction.getauctionstatus(5);	
});
</script>
<!-- setting equal height script--> 
<div class="banner-top-block clearfix">
<div class="banner-block fr">
<!-- Banner Slide START-->
	<script type="text/javascript">
		
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: '<?php echo IMGPATH;?>loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true
			});
		});
	</script>
<style type="text/css">
.fb_edge_widget_with_comment span.fb_edge_comment_widget {
	z-index:0 !important;
	}
.fb_edge_widget_with_comment {
	z-index:1 !important;
	}
</style>
    <div id="container">
		<div id="example">
			<div id="slides">
				<div class="slides_container">
				<?php foreach($banners as $banner):?>
                    	        <img src="<?php echo URL_BASE.BANNER_IMGPATH.$banner['banner_image'];?>" width="700" height="201" alt="<?php echo $banner['title'];?>">
				<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
    <div style="clear:left;"></div>
    <!-- Banner Slide END-->
 </div>
 <!--Right Sidebar Start-->
<?php include("right.php");?>
<!--Right Sidebar End-->
</div>
<div class="content_left_out fl">
 <div class="title-left title_temp1">
<div class="title-right">
<div class="title-mid">
<h2 class="fl" title="<?php echo __('menu_live_online_auctions');?>"><?php echo __('menu_live_online_auctions');?></h2>  
</div>
</div>
</div>
        <div class="deal-left clearfix">
	<div class="action_deal_list clearfix seat_bid_content_outer">
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
	$block=$content="";
	if(count($auction_types) > 0){
	foreach($auction_types as $typeid => $typename){
		
				if(isset($liveproducts[$typeid])){
					$block = $typename::product_block($liveproducts[$typeid],5);
					$content .= $block;
					echo $block;
				}						
		}
	} 
	if(trim($content)=="") { $count = false;}
	?>    		
		<div class="user" style="display:none;" ><?php echo $user;?></div>
		<div class="clear"></div>
		<?php if(!$count){?>
	<h4 class="no_data fl clr"><?php echo __("no_live_auction_at_the_moment");?></h4>
	<?php }?><?php echo $include_facebook;?>
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
		$(document).ready(function(){
		FB.Event.subscribe('edge.create',
			function(response) {
			insert_fbuser();
			//alert('You liked the URL: ' + response);
			});
		});

		
		</script>
		     
	</div>
        
    </div>
    <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
</div>
<!-- Recently closed-Auction-->
<?php  echo new View(THEME_FOLDER."recently_closed"); ?>


<!-- offline mode view includes ends here -->
</div>
<script type="text/javascript">
$(document).ready(function () {$("#home_menu").addClass("fl active");});
</script>
