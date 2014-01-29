<?php defined("SYSPATH") or die("No direct script access."); ?>
<script type="text/javascript">
			$(document).ready(function(){	Auction.getauctionstatus(5);	
	});
	</script>
<link href="<?php echo CSSPATH;?>style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSSPATH;?>slider.css" rel="stylesheet" type="text/css" />	
<link rel="stylesheet" type="text/css" href="public/css/stylish-select.css" />
<!--<script type="text/javascript" src="<?php echo SCRIPTPATH;?>jquery.js"></script>-->

<script type="text/javascript" src="<?php echo SCRIPTPATH;?>scripts.js"></script>
<script src="public/js/jquery.stylish-select.js" type="text/javascript"></script>	

<div class="banner_rgt">
     <div class="banner_top_part">
          <div class="wrap">
           <div id="slide-holder">
              <div id="slide-runner"> 
				<?php $m=0;
				foreach($banners as $banner):?>
				<a href="">
					<img id="slide-img-<?php echo $m++; ?>" src="<?php echo BANNER_IMGPATH.$banner['banner_image'];?>" width="715" height="250" class="slide" alt="img" />
				</a> 
				<?php endforeach;?>

                <div id="slide-controls">
                  <p id="slide-client" class="text"><strong>post: </strong><span></span></p>
                  <p id="slide-desc" class="text"></p>
                  <p id="slide-nav"></p>
                </div>
              </div>
              <!--content featured gallery here -->
            </div>	
		<script type="text/javascript">
		if(!window.slider) var slider={};slider.data=[
		<?php $m=0; foreach($banners as $banner):?>
		{"id":"slide-img-<?php echo $m++; ?>","client":"nature beauty","desc":"nature beauty photography"},
		<?php endforeach;?>];
		
		</script>
          </div>
        </div>
 
           
        <div class="today_head">
			<div class="today_head_lft">
				<h2 title="<?php echo strtoupper(__('today_auction'));?>"><?php echo __('today_auction');?></h2>
			</div>
			<div class="arrow_one"></div>
				<div class="today_head_rgt">
					<p><a href="<?php echo URL_BASE.'auctions/live'; ?>" title="<?php echo  __('view_all');?>"><?php echo  __('view_all');?></a></p>
				</div>
			</div>
        <div class="feature_total">
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
		  <?php if(!$count){?>
		  <div class="message_common">
			<h4 class="no_data fl clr"><?php echo __("no_live_auction_at_the_moment");?></h4>
			</div>
			<?php }?>
       
         <div class="today_head">
         <div class="today_head_lft">
          <h2 title="<?php echo __('FUTURE_AUCTION');?>"><?php echo __('FUTURE_AUCTION');?></h2>
          </div>
          <div class="arrow_one"></div>
             <div class="today_head_rgt">
          <p><a href="<?php echo URL_BASE.'auctions/future'; ?>" title="<?php echo  __('view_all');?>"><?php echo  __('view_all');?></a></p>
          </div>
        </div>
        <div class="feature_total">
		<script type="text/javascript">
		$(document).ready(function(){	

		item_len > 0 ? Auction.getauctionstatus(3):"";	
		});
		</script>
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
	<div class="message_common">
		<h4 ><?php echo __("no_future_auction_at_the_moment");?></h4>
	</div>
	<?php }?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div></div></div></div></div></div>
<script type="text/javascript">
$(document).ready(function () {$("#home_menu").addClass("fl active");});
</script>
	<script type="text/javascript">

    $(function () {

  

        $('a').on('click', function (e) {

            /// <param name="e" type="jQuery.Event">jQuery Event Object</param>

            var target = e.target,

                $target = $(target),

                currentTarget = e.currentTarget,

                $currentTarget = $(currentTarget);

  

            $target.log('I am the target');

            $currentTarget.log('I am the currentTarget');

        });

  

    });

</script>
