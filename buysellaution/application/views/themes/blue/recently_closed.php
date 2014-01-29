<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>jquery.jcarousel.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo CSSPATH; ?>jquery.scroll.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CSSPATH; ?>skin.css" />
<script type="text/javascript">
	$(document).ready(function () {
	    $('#carousel').jcarousel({
			horizontal: true,
			scroll: 1,
			auto: 2,
			wrap: 'last',
			initCallback: mycarousel_initCallback,			
    		itemFallbackDimension: 300
	   	});

	//Front page Carousel - Initial Setup
   	$('div#slideshow-carousel a img').css({'opacity': '1'});
   	$('div#slideshow-carousel a img:first').css({'opacity': '1.0'});
   	$('div#slideshow-carousel li a:first').append('<span class="arrow"></span>')

  
  	//Combine jCarousel with Image Display
    $('div#slideshow-carousel li a').hover(
       	function () {
        		
       		if (!$(this).has('span').length) {
        		$('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '1'});
   	    		$(this).stop(true, true).children('img').css({'opacity': '1.0'});
       		}		
       	},
       	function () {
        		
       		$('div#slideshow-carousel li a img').stop(true, true).css({'opacity': '1'});
       		$('div#slideshow-carousel li a').each(function () {

       			if ($(this).has('span').length) $(this).children('img').css({'opacity': '1.0'});

       		});
        		
       	}
	).click(function () {

	      	$('span.arrow').remove();        
		$(this).append('<span class="arrow"></span>');
       	$('div#slideshow-main li').removeClass('active');        
       	$('div#slideshow-main li.' + $(this).attr('rel')).addClass('active');	
        	
       	//return false;
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
<?php if($count_closed_recently >0){  ?>
	<?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($userid) && ($user_type == ADMIN) ) ){?>
    <div id="slideshow-carousel" class="mt20">
	<div class="title-left title-left2 title_temp1">
		<div class="title-right title-right2">
			<div class="title-mid title-mid2">
				<h4 class="clr" title="<?php echo __('recently_closed_auctions');?>"><?php echo __("recently_closed_auctions");?></h4>
			</div>
		</div>
	</div>
	<div class="deal-left clearfix">
		<div class="action_deal_list clearfix">
			<?php if(count($closed_results_forslide)!=0)
			    { ?>
			<div class="sidebar_future_action fl clr">
				<ul id="carousel" style="width:100%;" class="jcarousel jcarousel-skin-tango">
 	<?php 	
	//Closed List
	$i=1;
		foreach($closed_results_forslide as $closed_result):
	?>
				    <li>
				        <div rel="p<?php echo $i;?>">
                <!--Old closed div-->
				                <div class="future_auction fl clr">
				                        <div class="future_auction_left">
			                                <a href="<?php echo url::base();?>auctions/view/<?php echo $closed_result['product_url'];?>" title="<?php echo ucfirst($closed_result['product_name']);?>" > 
                                        <?php 

                                        if(($closed_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$closed_result['product_image']))
                                        { 

                                        $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$closed_result['product_image'];
                                        }
                                        else
                                        {
                                        $product_img_path=IMGPATH.NO_IMAGE;
                                        }
                                        ?>
                                        <img src="<?php echo $product_img_path;?>" width="160" height="150" align="middle" title="<?php echo ucfirst($closed_result['product_name']);?>" alt="<?php echo $closed_result['product_name'];?>"/>
			                                </a>
				                        </div>
				                        <div class="future_auction_right">
				                                <a href="<?php echo url::base();?>auctions/view/<?php echo $closed_result['product_url'];?>" class="clr future_auction_name" title="<?php echo ucfirst($closed_result['product_name']);?>">
				                                <?php echo ucfirst(Text::limit_chars($closed_result['product_name'],35));?>
				                                </a>
				                                <p>
				                                <?php echo ucfirst(Text::limit_chars($closed_result['product_info'],100));?>
				                                </p>
					                        <div class="future_auction_detail clr mt5">
					                                <p class="clr"><span><?php echo __('end_time_label'); ?></span> <b><?php echo $auction->date_to_string($closed_result['enddate']);?></b> </p>
					                                <p class="clr"><span><?php echo __('start_price_label')?>:</span><span style="color:#249aca;"><?php echo $site_currency;?> <b><?php echo Commonfunction::numberformat($closed_result['current_price']);?></b></span></p>
					                        </div>	
					                </div>
					        </div>
                <!--End of old closed div-->
				        </div>
				  </li>
	    <?php $i++;?>
	    <?php endforeach;?>
				</ul>
			</div>
           <?php } 
    else 
    { ?>
			<div class="sidebar_future_action sidebar_future_action1 fl clr"><p><?php echo __('no_data'); ?></p></div>
    <?php
    }?>	
		</div>
	</div>
	<div class="auction-bl">
		 <div class="auction-br">
			 <div class="auction-bm">
			 </div>
		 </div>
	</div>
    </div>
   
    
   <?php }?>
<?php }?>
