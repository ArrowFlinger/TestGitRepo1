<?php defined("SYSPATH") or die("No direct script access.");?>
<script type="text/javascript">

$(document).ready(function(){	
		var o=0;
		
		$('.auction_item').each(function(){
			
			var auctionId    = $(this).attr('id');
			var prd_id = $(this).find('.addwatchlist').attr('rel');
			oldpids[o]=prd_id;				
			a[auctionId] = $('#' + auctionId);
			a[auctionId]['countdown'] = $('#' + auctionId + ' .countdown');
			a[auctionId]['bid'] = $("#"+auctionId+' .bid');
			a[auctionId]['bidme_link'] = $('#' + auctionId + ' .bidme_link');
			a[auctionId]['futureday'] = $("#"+auctionId+' .futureday');				
			a[auctionId]['comingsoon'] = $("#"+auctionId+' .comingsoon');
			
			o++;
			
		});
		if($(".user").html())
		{
			$(".bid").click(function()
			{		
			
			var url=$(this).attr("name");
			var id=$(this).attr("id");
			if($(this).hasClass('new_block')){	
				Auction.bid(baseurl+'auctions/bid/',id);	
			}
			});
		}
		if(!$(".user").html())
		{
			$(".bid").mouseover(function(){
				$(this).html(language.login_labels);
				$(this).click(function(){
					window.location=$(this).attr("rel");
				});
			});
			$(".bid").mouseout(function(){
				$(this).html(language.bid_me_label);
			});
		}
		$(".addwatchlist").click(function(){
			var pid=$(this).attr('rel');
			var url=$(this).attr('name');
			
			$(".loader"+pid).show();
			var display_msg=$("#notice_msg"+pid);
			if($(".user").html())
			{
				$.ajax({
					url:url,
					type:'GET',
					data:'pid='+pid,
					contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
					complete:function(data){
						$(".loader"+pid).hide();
							
						var msg=data.responseText;	
						if(msg==1)
						{
							$(display_msg).show();
							$(display_msg).html(language.added_in_your_watchlist);
							$(display_msg).fadeOut(5000);
						}
						else
						{
							$(display_msg).show();
							$(display_msg).css({"color":"#F00"});
							$(display_msg).html(language.already_in_your_watchlist);
							$(display_msg).fadeOut(5000);
						}
					}
					});
			}
			else
			{
				$(".loader"+pid).hide();
				$(display_msg).show();
				$(display_msg).html(language.login_access);
				$(display_msg).fadeOut(5000);
			}
		return false;		
		});	
		
		
		
		// Auction.getauctionstatus(a['status']);
});//Document ready ends
</script>
<?php if($count_live_result>0):?>
        <?php  foreach($result as $product_result):?>
                       <div id="auction_<?php echo $product_result['product_id'];?>" class="auction_item auction_item_content" name="<?php echo URL_BASE;?>auctions/process" rel="value">
            <div class="deal-tl">
               		 <div class="deal-tr">
                		<div class="deal-tm">
                		</div>
                	 </div>
                </div>
                 <div class="deal-left1 clearfix">
                  <div class="deal-right clearfix">
                <div class="deal-mid clearfix">
              <div class="image-block fl">
                 <!--product title-->
               
                <h3>
                	<a href="<?php echo url::base();?>auctions/view/<?php echo $product_result['product_url'];?>" title="<?php echo $product_result['product_name'];?>" class="">
                	<?php echo ucfirst(Text::limit_chars($product_result['product_name'],30));?>
                        </a>
                </h3> 
               
                <!--product image-->
                <div class="action_item_img"> 
                    <a href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" class="" title="<?php echo $product_result['product_name'];?>">
                        <?php 
				
				if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_result['product_image'];
				}
				else
				{
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?>
                        <?php if($product_result['product_featured']==FEATURED){?><span class="feature_icon"></span><?php } ?>
			 <?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icons"></span><?php } ?>
				<?php if($product_result['product_featured']==HOT){?><span class="hot_icon"></span><?php } ?>
	                <img src="<?php echo $product_img_path;?>" width="150" height="150" title="<?php echo ucfirst($product_result['product_name']);?>" alt="<?php echo $product_result['product_name'];?>"/>
                    </a>
                </div>
                <div class="action_item_detail">
					<p><?php echo __('retail_price_label')." : ".$site_currency." ".$product_result['product_cost'];?></p>
                	<p><?php echo __("time_countdown_label")." : ".$product_result['bidding_countdown'];?> secs</p>
                </div>
                </div>
                 <div class="text-block fl clearfix">
                <a class="more_info_link fl" href="<?php echo URL_BASE;?>auctions/view/<?php echo $product_result['product_url'];?>" title="more information"></a>
                <div class="price-block clearfix">
                
                            
                <!--Auctions process div-->                        	
                <div class="countdown"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>
                </div>
                <div class="action_price"><span class="currentprice"></span><span class="price" style="display:none;"></span></p></div>
                <div class="action_bidder_name"><span><?php echo __('highest_bidder_label');?>:</span> <span class="lastbidder"><?php echo ($product_result['lastbidder_userid']==0)?__('no_bids_yet'):"";?></span>
	               
		</div>
            <div class="user" style="display:none;" ><?php echo $user;?></div>
            <div class="bidme_link_out">
                <center>
                <div class="bidme_link width_bidme clr">
                <span class="bidme_link_left fl">&nbsp;</span>
                <span class="bidme_link_middle fl">
                <a href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" id="<?php echo $product_result['product_id'];?>" class="bid new_block" title="<?php echo ($auction_userid=='')? __('login_label'):__('bid_me_label');?>" rel="<?php echo URL_BASE;?>users/login/" >
                    <?php echo __("bid_me_label");?>
                </a>
                </span>
                <span class="bidme_link_left bidme_link_right fl">&nbsp;</span>
            </div>
		<!--Loader-->
		<div class="loader<?php echo $product_result['product_id'];?>" style="display:none;"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>
            	</center>
            </div>   
            <div class="bid_price"><p><?php echo __("bid_label");?>: <?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?></p></div>
            
           
            <!--End of Auctions process div-->
		<!--Share-->
	<div class="auction_share_icon mt5">
        	<a style="float:left;width:30px;" title="share_label"><?php echo __('share_label');?> </a><a  href="http://twitter.com/share?url=<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" target="_blank" title="Twitter" ><img src="<?php echo IMGPATH.'twitter_link_icon.png';?>" style="margin:2px 0px 0px 5px;"/></a>
            <a style="float:left;width:30px;" href="https://www.facebook.com/sharer.php?u=<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" target="_blank"  title="Facebook">
              <img src="<?php echo IMGPATH.'fbook_icon.png';?>" class="pl5 pr5 " style="padding-top:2px ;" /></a>
		<!--Like--> 
		<!--Facebook-->
		<?php 
			// To return user data
			$user_detail=FB::instance()->me();
			echo $fid=$user_detail['id'];
			$url=URL_BASE."auctions/fblike";
			$message=__('flike_alert_msg');
		?>
     		<script type="text/javascript">
		function insert_fbuser()
		{
			$.ajax({
				type:'GET',
				url:'<?php echo $url;?>',
				data:'fuserid=<?php echo $fid;?>',
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
    		});
		
		</script>
		
		<fb:like style="float:left;width:auto;" href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"  ></fb:like><?php echo $include_facebook;?>	<!--End of facebook-->	   
        </div>          
	<!--End of share-->
            <div class="watch_list">
            	<span class="watch_list_left fl">&nbsp;</span>
                <span class="watch_list_middle fl">
                <a href="" title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist">
					<?php echo __('add_to_watchlist');?>
                </a>
                </span>
                <span class="watch_list_left watch_list_right fl">&nbsp;</span>
            </div>
           <!-- Message flash-->
           <div class="notice_nsg fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> <!-- end of Message flash-->
           </div>
           </div>
            </div>
             </div>
              <div class="deal-bl">
               		 <div class="deal-br">
                		<div class="deal-bm">
                		</div>
                	 </div>
                </div>
           
           
            </div>
        
        <?php endforeach;?>
        
        <div class="clear"></div>
        <?php endif;?>
