<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript" src="<?php echo URL_BASE; ?>public/js/jquery.jcarousel.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>public/pink/css/jquery.scroll.css" />
<link rel="stylesheet" type="text/css" href="<?php echo URL_BASE; ?>public/pink/css/skin.css" />
<script type="text/javascript">
	$(document).ready(function () {
	    $('#carousel').jcarousel({
			vertical: true,
			scroll: 1,
			auto: 2,
			wrap: 'last',
			initCallback: mycarousel_initCallback,			
    		itemFallbackDimension: 300
	   	});
	    $('#carousel1').jcarousel({
			vertical: true,
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
<!--Right side-->
<div class="sidebar_content fr">
<div class="sidebar_register_content fl clr">
    	<div class="sidebar_register_in fl clr">
       	   <p class="fl clr"><?php echo __('register_label');?><span><?php echo __('now_label');?> </span></p>
            <?php /*<span class="fl clr"><?php echo __('free_label');?></span>*/ ?>
            <div class="register_button_out fl clr">
            	<div class="login_button fl">
            	<?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($userid) && ($user_type == ADMIN) ) ){?>
		<?php if($auction_userid):?>
                	<div class="login_btn_left fl"></div>	
                    <div class="login_btn_middle fl">
                    	<a href="<?php echo URL_BASE;?>users/" title="<?php echo __('menu_users');?>" class="fl"><?php echo __('menu_users');?></a>
                     </div>
                    <div class="login_btn_left login_btn_right fl"></div>
                </div>
                <div class="login_button fl ml10">
                	<div class="login_btn_left fl"></div>
                    <div class="login_btn_middle fl">
                    	<a href="<?php echo URL_BASE;?>users/logout" title="<?php echo __('menu_logout');?>" class="fl"><?php echo __('menu_logout');?></a>
                     </div>
                    <div class="login_btn_left login_btn_right fl"></div>
		<?php else:?>
			<div class="login_btn_left fl"></div>	
                    <div class="login_btn_middle fl">
                    	<a href="<?php echo URL_BASE;?>users/login" title="<?php echo __('menu_signin');?>" class="fl"><?php echo __('menu_signin');?></a>
                     </div>
                    <div class="login_btn_left login_btn_right fl"></div>
                </div>
                <div class="login_button fl ml10">
                	<div class="login_btn_left fl"></div>
                    <div class="login_btn_middle fl">
                    	<a href="<?php echo URL_BASE;?>users/signup" title="<?php echo __('menu_register');?>" class="fl"><?php echo __('menu_register');?></a>
                     </div>
                    <div class="login_btn_left login_btn_right fl"></div>
		<?php endif;?>
		<?php } ?>
                </div>
            </div>
        </div>
    </div>
        <!--Sidebar Action Timer START-->
        <div class="sidebar_action_time_cnt fl clr mt10">
            <div class="timer_t"></div>
                <div class="timer_m">
                        <div class="action_server_time fl clr">
                                <div class="action_time_detail fl clr">
                                <span class="fl clr"><?php echo __('auction_timing_label');?></span>
                                <p class="fl clr mt5"><?php echo __('timing_label');?></p>
                                </div>
                        <div class="server_time_detail fl clr">
                        <span class="fl clr"><?php echo __('server_time_label');?></span>
                        <p class="fl clr mt5 server_time"><?php echo date(SERVER_TIME_FORMAT,time());?></p>
                        </div>
                </div>	    
        </div>
       <div class="timer_b"></div>
        </div>
        <!--Sidebar Action Timer END-->
        <!-- Refere Friend Start-->
        <div class="sidebar_refere_friend fl clr mt15">
        <div class="refere_friend_cnt fl clr">
        
        <p><?php echo __('tell_a_friend_label');?></p>
        <?php 
        if($auction_userid){
                $url=URL_BASE."users/friends_invite";
        }
        else
        {	
                $url=URL_BASE."users/login";
        }?>
        <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($userid) && ($user_type == ADMIN) ) ){?>
        <a href="<?php echo $url;?>" title="and earn Bonus" class="fl earn_bonus"><?php echo __('and_earn_bonus_label');?></a>
        <?php } ?>
        </div>
        </div>
        
        <!--Refere Friend END-->
         <?php if( ($site_settings[0]['maintenance_mode'] == IN_ACTIVE) || (isset($userid) && ($user_type == ADMIN) ) ){?>
    <div id="slideshow-carousel" class="mt20">
    <div class="sidebar_title fl clr"><h4 class="clr" title="<?php echo __('recently_closed_auctions');?>"><?php echo __("recently_closed_auctions");?></h4></div>
    <?php if(count($closed_results_forslide)!=0)
        { ?>
     	<div class="sidebar_future_action fl clr">
        <ul id="carousel" class="jcarousel jcarousel-skin-tango">
 	<?php 	
	//Closed List
	$i=1;
		foreach($closed_results_forslide as $closed_result):
	?>
            <li>
                <div rel="p<?php echo $i;?>">
                <!--Old closed div-->
                        <div class="future_auction fl clr">
                                <div class="future_auction_left fl">
                                        <a href="<?php echo url::base();?>auctions/view/<?php echo $closed_result['product_url'];?>" title="<?php echo ucfirst($closed_result['product_name']);?>" > 
                                        <?php 

                                        if(($closed_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$closed_result['product_image']))
                                        { 

                                        $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$closed_result['product_image'];
                                        }
                                        else
                                        {
                                        $product_img_path=IMGPATH.NO_IMAGE;
                                        }
                                        ?>
                                        <img src="<?php echo $product_img_path;?>" width="50" height="50" align="middle" title="<?php echo ucfirst($closed_result['product_name']);?>" alt="<?php echo $closed_result['product_name'];?>"/>
                                        </a>
                                </div>
                                <div class="future_auction_right fl ml10">
                                        <a href="<?php echo url::base();?>auctions/view/<?php echo $closed_result['product_url'];?>" class="fl clr future_auction_name" title="<?php echo ucfirst($closed_result['product_name']);?>">
                                        <?php echo ucfirst(Text::limit_chars($closed_result['product_name'],35));?>
                                        </a>
                                <div class="future_auction_detail fl clr mt5">
                                        <p class="fl clr"><span style="display:block;"><?php echo __('end_time_label'); ?></span> <b><?php echo $auction->date_to_string($closed_result['enddate']);?></b> </p>                                        
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
   
    <div id="slideshow-carousel" class="mt20">
       <div class="sidebar_title fl clr"><h4 class="clr" title="<?php echo __('future_auction_label');?>"><?php echo __("future_auction_label");?></h4>
       </div>
       <?php if(count($future_results_forslide)!=0)
        { ?>
       <div class="sidebar_future_action fl clr">
          <ul id="carousel1" class="jcarousel jcarousel-skin-tango">
 	<?php 	
	//future List
	$i=1;
	foreach($future_results_forslide as $future_result):
	?>
            <li>
                <div rel="p<?php echo $i;?>">
                        <div class="future_auction fl clr">
                                <div class="future_auction_left fl">
                                        <a href="<?php echo url::base();?>auctions/view/<?php echo $future_result['product_url'];?>" title="<?php echo ucfirst($future_result['product_name']);?>" > 
                                        <?php 
                                        if(($future_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB1.$future_result['product_image']))
                                        { 
                                        $product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB1.$future_result['product_image'];
                                        }
                                        else
                                        {
                                        $product_img_path=IMGPATH.NO_IMAGE;
                                        }
                                        ?>
                                        <img src="<?php echo $product_img_path;?>" width="50" height="50" align="middle" title="<?php echo ucfirst($future_result['product_name']);?>" alt="<?php echo $future_result['product_name'];?>"/>
                                        
                                        </a>
                                </div>
                                <div class="future_auction_right fl ml10">
                                        <a href="<?php echo url::base();?>auctions/view/<?php echo $future_result['product_url'];?>" class="fl clr future_auction_name" title="<?php echo ucfirst($future_result['product_name']);?>">
                                        <?php echo ucfirst(Text::limit_chars($future_result['product_name'],35));?>
                                        </a>
                                <div class="future_auction_detail fl clr mt5">
                                        <p class="fl clr"><span style="display:block;"><?php echo __('end_time_label'); ?></span> <b><?php echo $auction->date_to_string($future_result['enddate']);?></b></p>
                                        
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
   <?php }?>
   <!--Payment Methods END-->
</div>
