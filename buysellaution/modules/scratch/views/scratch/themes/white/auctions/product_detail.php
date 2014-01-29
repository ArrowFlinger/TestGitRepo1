
<?php
 $id="";
$c_date =Commonfunction::getCurrentTimeStamp();

foreach($productsresult as $product_result):
$id.= $product_result['product_id']; 
?>
<div class="container_inner element<?php echo $product_result['product_id'];?>">
<div class="auction_item" id="auction_<?php echo $id;?>" name="<?php echo URL_BASE;?>auctions/process">
	<div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
<div class="banner_inner" id="detail_page">

<div class="signup_head">
<ul>
<li><a href="<?php echo URL_BASE;?>" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
<li><a href="#" title="arr_bg"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
<li class="active"><a href="#" title="<?php echo ucfirst($product_result['product_name']);?>"><?php echo ucfirst($product_result['product_name']);?></a></li>
</ul>
</div>
<script>


 a['scratchcount']=parseInt('<?php echo $product_result["timetobuy"]; ?>');

</script>
<!--detail page start-->
	
    <div class="detail_page_top">  
    
    <h1 class="detail_title"><?php echo ucfirst($product_result['product_name']);?></h1>
    	<div class="detail_page_top_left">
    	<?php 
		if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB2.$product_result['product_image']))
		{ 
		$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB2.$product_result['product_image'];
		$product_full_size=URL_BASE.PRODUCTS_IMGPATH.$product_result['product_image'];
		}
		else
		{
		$product_full_size=IMGPATH.NO_IMAGE;
		$product_img_path=IMGPATH.NO_IMAGE;

		}
		?>
        	
			<!---slide_show-->
			<div id="slide_container">

	
	<div id="slide_content">
	
		<div id="slider">
                                <a><img src="<?php echo URL_BASE.'public/'.THEME.'/auction/scratch/images/';?>scratch_product.png"  alt="Scratch Auction" title="<?php echo __('Scratch Auction'); ?>" /></a>
			<ul>							
			
				<ul>										
						<?php  $productimage_count = explode(",",$product_result['product_gallery']);
					if(($product_result['product_image']!=="") && ($product_result['product_gallery']=="") )
					{
					$product_full_size=URL_BASE.PRODUCTS_IMGPATH.$product_result['product_image'];
					?>
					<li> <a href="<?php echo $product_full_size;?>" title="Image"> <img src="<?php echo $product_full_size;?>" class="image0"  alt="test" width="81" height="54"  /> </a><?php if($product_result['product_process']==CLOSED  && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image"/><?php } ?> </li>					
					<?php
					}
					elseif(($product_result['product_image']=="")&&($product_result['product_gallery']=="") )
					{ 
					$no_img_path=IMGPATH.NO_IMAGE;?>
					<li> <a href="<?php echo $no_img_path;?>" title="Image"> <img src="<?php echo $no_img_path;?>" class="image0"  alt="test" width="81" height="54"  /> </a><?php if($product_result['product_process']==CLOSED  && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>"class="sold_image"/><?php } ?>  </li>					
					<?php
					}
					else
					{ ?>
                    <li> <a href="<?php echo $product_full_size;?>" title="Image"> <img src="<?php echo $product_full_size;?>" class="image0"  alt="test" width="81" height="54"  /> </a>
                    </li>
                    <?php
					foreach($productimage_count as $productallname)
					{
					  $gallary_main=explode(" ",$productallname);
					  $gallary_main_image=implode('_',$gallary_main);
					$product_fullimagee_size=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150.$gallary_main_image;
					//$product_thumb_size=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb100X100/".$productallname;					
					?>	
                                  
                    <li><a href="#" title="1"> <img src="<?php echo $product_fullimagee_size;?>" width="353" height="297" alt="1" /></a></li>
                    <?php					
					}
					}
					?>   
					</ul>
			</ul>
		</div>
	</div>
</div>
			<!--slide_show-->
            <div class="detail_left_feature_tag">
            
            </div>
          <div class="productDetail" style="display:none;"><?php echo $product_result['product_id'];?></div>  
            
            <div class="detail_feature_bott_lft">
            <div class="sliders">
             

			 <?php if($product_result['product_featured']==HOT){?>
			<a><img src="<?php echo IMGPATH;?>head_top4_bg.png" width="14" height="19" alt="<?php echo __('hot_label'); ?>"  title="<?php echo __('hot_label'); ?>"  /></a>
			<?php }?>
			
			 <?php  if($product_result['dedicated_auction']==ENABLE){?>
			<a><img src="<?php echo IMGPATH;?>head_top5_bg.png" width="19" height="19" alt="<?php echo __('bonus_label'); ?>"  title="<?php echo __('bonus_label'); ?>"/></a>
			<?php }?>
			</div>
              <a title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>" class="addwatchlist" name="<?php echo URL_BASE;?>auctions/addwatchlist"><img src="<?php echo IMGPATH;?>plus_bg.png" width="24" height="25" alt="<?php echo __('add_to_watchlist'); ?>" /></a>
             </div>
             
             <div class="detail_left_social_link">
            <?php if($product_result['product_process']!=CLOSED){?>
             <div class="social_sec">
			 <p><?php echo __('share_label');?>:</p>
			 	<?php $url=URL_BASE."auctions/view/".$product_result['product_url'];
					?>
			 <g:plusone size="medium" annotation="none"></g:plusone>
			     <script type="text/javascript">
                        (function()
                        {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                        })();
                        </script>
                        <a href="http://twitter.com/share?url=<?php echo $url;?>&amp;text=<?php echo $product_result['product_name'];?>" target="_blank"  title="Twitter" class="fl">
                                            <img src="<?php echo IMGPATH;?>s2.png" alt="Twitter" border="0" class="fl"s/>
                                        </a>
			 

			 
			 			<a href="https://www.facebook.com/sharer.php?u=<?php echo $url;?>&t=<?php echo $product_result['product_name'];?>" title="Facebook" class="fl" target="_blank">
                                            <img src="<?php echo IMGPATH;?>s3.png" alt="Facebook" border="0" />
                                        </a>
			
		                <fb:like href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"></fb:like>
			 </div>
			 <?php }?>
             </div>
        </div>
    	<div class="detail_page_top_mid">        
        <div class="detail_big_history"><h1><?php echo __('bid_history_label');?></h1>  </div>       
       <div class="bid_history" id="<?php echo URL_BASE;?>site/scratch/bid_history/<?php echo $id;?>" style="" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/></div>
 
        </div>

         <!--scratch detail 2 starts -->
        <div class="scratch_module">
            <div class="scratch_mid">
		<div id='show_pric' style="display:none;">
		<?php  if($product_result['current_price']<=$product_result['bidamount']){ ?>

		<p class="scratch_info"><?php echo __('your_price_label');?>: <span  class="currentprice"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".$product_result['current_price']:$product_result['current_price'];?></span></p>

		<?php  }else{ ?>

		<p class="scratch_info"><?php echo __('your_price_label');?>: <span  class="currentprice"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".$product_result['current_price']:$product_result['current_price'];?></span></p>

		 <?php }?>
		</div>

             <div class="scratch_buy_details clearfix">
                    <p class="credit clearfix"><span><?php echo __('see_myprice_label');?> </span><b><?php echo  $site_currency."".$product_result['bids']." ".__('bidamount_label'); ?></b></p>
                    <p class="credit clearfix"><span><?php echo __('time_to_label');?></span><b><?php echo $product_result['timetobuy']." ".__('second_label');?></b></p>
                </div>
                <div class="scratch_timer_display clearfix">

             <div class="hb_bg_mid" style="width:272px;border:none;background:none;min-height:0px;">      
			<ul class="clearfix">
				 <li class="roming" style="display:none;border:none;background:none;"><p class="fl"><?php echo __('price_label');?> :</p><p class="fl"><span class="currentprice"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".$product_result['current_price']:$product_result['current_price'];?></span><span class="price" style="display:none;"></span></p></li>
				<li style="border:none;background:none;"><h3 class="countdown"><?php echo ($product_result['product_process']!=CLOSED)?"<img src=".IMGPATH."ajax-loader.gif>":__('closed_text');?></h3>
					
					
					<label id="scratch_product_detail_timer" style="float:left;padding-left:50px;display:block;color:#666;">
					<span class="days">Days</span>
					<span class="hrs"> Hrs</span>
					<span class="min"> Min</span>
					<span class="sec"> Sec</span>
					</label>
				
				</li></ul></div>
                </div>
             
                <!--Buy now seconds div-->    
                      <?php  if($product_result['current_price']<=$product_result['bidamount']){ ?>

                      

                      
                      <div class="scratchbuycountdown" id="#roming_toptxt" style="display:none;">
                <div class="scratch_button scratch_button1 clearfix">
                    <p class="scratch_time"><?php echo __('time_to_label');?> <span style="font:bold 12px arial;color:#000;" class="showcountdown"> <?php echo $product_result['timetobuy']; ?></span><span> <?php echo __('seconds_label')?></p>
                    <div class="scratch_button_block">
                    <div class="scratch_price clearfix" >
                        <span class="scratch_price_left">&nbsp;</span>
                        <span class="scratch_price_mid"><a href="#" title="<?php echo __('buy_now_label');?>"><?php echo __('buy_now_label');?></a></span>
                        <span class="scratch_price_right">&nbsp;</span>
                    </div>
                   
                </div>
                </div>
                 <div class="scratch_cancel scratch_cancel1 clearfix" style="margin-top:10px;border:1px solid red;">
                        <span class="scratch_cancel_left">&nbsp;</span>
                        <span class="scratch_cancel_mid"><a href="<?php echo URL_BASE.'auctions/view/'.$product_result['product_url'];?>" title="<?php echo strtoupper (__('cancel_label'));?>"><?php echo __('cancel_label');?></a></span>
                        <span class="scratch_cancel_right">&nbsp;</span>
                    </div>
                    </div>  


                     </div>   
                     <?php  }else{ ?>

                     <div class="scratchbuycountdown" id="#roming_toptxt" style="display:none;">
                <div class="scratch_button scratch_button1 clearfix">

                
                    <p class="scratch_time"><?php echo __('time_to_label');?> <span style="font:bold 12px arial;color:#000;" class="showcountdown"> <?php echo $product_result['timetobuy']; ?></span><span> <?php echo __('seconds_label')?></p>
                    <div class="scratch_button_block">
                    <div class="scratch_price clearfix" style="margin-top:10px;">
                        <span class="scratch_price_left">&nbsp;</span>
                        <span class="scratch_price_mid"><a href="<?php echo URL_BASE;?>site/scratch/addtocart_list/<?php echo $product_result['product_id'];?>" title="<?php echo __('buy_now_label');?>"><?php echo __('buy_now_label');?></a></span>
                        <span class="scratch_price_right">&nbsp;</span>
                    </div>
                   
                </div>
                </div>
                 <div class="scratch_cancel scratch_cancel1 clearfix" style="margin-top:10px;">
                        <span class="scratch_cancel_left">&nbsp;</span>
                        <span class="scratch_cancel_mid"><a href="<?php echo URL_BASE.'auctions/view/'.$product_result['product_url'];?>" title="<?php echo strtoupper (__('cancel_label'));?>"><?php echo __('cancel_label');?></a></span>
                        <span class="scratch_cancel_right">&nbsp;</span>
                    </div>
                    </div>  
                     <?php }?>
                     <!--Buy now seconds div end-->

                     <!--scratch detail 1 starts -->          
                
                <?php if($product_result['startdate']<=$c_date && $product_result['auction_process']!=HOLD):?>
            <?php if($product_result['product_process']!=CLOSED){?>
            <!--Toggle start-->
            <div class="buynowok" style="margin-top:10px;">
				<div class="example1">
				<?php if($product_result['product_process']==LIVE){?>
                <div class="scratch_button clearfix">
                  
                    
                </div>
                <p class="scratch_cost" style="border-top:1px solid #C7C7C7; padding-top:5px;margin-top:6px;">
					<?php echo __('scratch_will_label');?> <?php echo $site_currency.$product_result['bids'];?> <?php echo __('price_low_label');?> <?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?>
					<?php echo __('then_you_label');?> <?php echo $product_result['timetobuy']; ?> <?php echo __('seconds_tobuy_label');?>
                </p>
                <div class="scratch_ok_cancel clearfix">
                    <div class="scratch_ok clearfix">
                        
						<span class="scratch_ok_left">&nbsp;</span>
                        <span class="scratch_ok_mid"><a href="javascript:;" id="<?php echo $product_result['product_id'];?>" name="<?php echo URL_BASE;?>auctions/bid" class="scratchbid" title="<?php echo __('ok_label'); ?>" rel="<?php echo URL_BASE;?>users/login/"  data-auctiontype="<?php echo $product_result['auction_type'];?>"><?php echo __('ok_label'); ?></a></span>
                        <span class="scratch_ok_right">&nbsp;</span>
						
                    </div>
                    <div class="scratch_cancel clearfix">
                        <span class="scratch_cancel_left">&nbsp;</span>
                        <span class="scratch_cancel_mid"><a href="#close-example1" id="close-example1" title="<?php echo strtoupper (__('cancel_label'));?>"><?php echo __('cancel_label');?></a></span>
                        <span class="scratch_cancel_right">&nbsp;</span>
                    </div>
                </div>
                <?php }else if($product_result['product_process']==CLOSED){ ?>
				<span id="link_<?php echo $product_result['product_id'];?>"  class="future auction_link"><?php echo __('closed_text');?></span><?php } else if($product_result['product_process']==FUTURE) { ?><span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text');?></span><?php } ?>


        


				</div>
		    </div>
           <?php }?>
           <!--Toggle end-->
         <?php endif;?>
                
                <div class="scratch_bidder">
                    <div class="white_scratch_bidder_tittle" style="background-color:#45A7D3;">
                        <p><?php echo __('with_each_bid');?></p>
                    </div>
                    <ul>
                        <li class="hb_li_padding_bottom_none">
                            <div class="hb_buy_now_left">
                                <p class="hb_font_weight_normal"><?php echo __('price_increases_by_label');?></p>
                            </div>
                            <div class="hb_buy_now_right hb_buy_now_right1">                           
                            
                                <b class="bidamount"><font class=""></font><?php echo $site_currency." ".Commonfunction::numberformat($product_result['bidamount']);?></b>
                            </div>					
                        </li>
                        <li class="hb_li_padding_bottom_none">
                            <div class="hb_buy_now_left">
                                <p class="hb_font_weight_normal"><?php echo __('retail_price_label')?></p>
                            </div>
                            <div class="hb_buy_now_right hb_buy_now_right1">
                                <b class="bidamount"><font class=""></font><?php echo $site_currency." ".Commonfunction::numberformat($product_result['product_cost']);?></b>
                            </div>					
                        </li>
                      
                        <?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>	
                        <div class="scratch_button_block" id="ecommersebuynow">
                        <div class="scratch_price clearfix" style="margin-top:10px;">
                        <span class="scratch_price_left">&nbsp;</span>
                        <span class="scratch_price_mid"><a href="<?php echo URL_BASE;?>site/buynow/buynow_addcart/<?php echo $product_result['product_id'];?>" title="<?php echo __('buy_now_label');?>"><?php echo __('buy_now_label');?></a></span>
                        <span class="scratch_price_right">&nbsp;</span>
                        </div>
                        </div>

                <?php endif;?>



                    </ul>
                </div>

            </div>
        </div>
            <!--scratch detail 1 ends -->

	</div>
    
    </div>
    <div class="notice_nsg2 fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> 
    <div class="detail_bottom_outer">
    
     <div class="detail_bottom_outer_top">
     <div class="detail-action_detail">  
     
     <h1><?php echo __('auctions_details');?></h1>
     
     <div class="detail-action_detail_lef"> 
     <h2><?php echo __('auction_id_label');?> :  </h2>
	 <h2><?php echo __('Auction_type_label');?> :</h2>     
     </div>
     
     <div class="detail-action_detail_rgt">
     <p><?php echo $product_result['product_id'];?>  </p>
     <p><?php echo Ucfirst($product_result['typename']);?> </p>
     
     </div>
     
     </div>
     
      <div class="detail-action_detail">  
     
     <h1><?php echo __('price_details');?></h1>
     
     <div class="detail-action_detail_lef"> 
       
    <h2> <?php echo __('price_starts_from');?> :</h2>
<h2><?php echo __('start_time_label');?> :</h2>
<h2><?php echo __('end_time_label');?> :</h2>
       
     
     
     </div>
     
     <div class="detail-action_detail_rgt">
     <p><?php echo $site_currency." ".$product_result['starting_current_price'];?>  </p>
     <p><?php echo Commonfunction::date_to_string($product_result['startdate']);?></p>
     <p><?php echo Commonfunction::date_to_string($product_result['enddate']);?> </p>
     
     </div>
     
     </div>
     
      <div class="detail-action_detail detail_last-bgnone">  
     
     <h1><?php echo __('shopping_details');?></h1>
     
     <div class="detail-action_detail_lef"> 
    
       <h2><?php echo __('Shipping_fee_label');?> :</h2>
<h2><?php echo __('Shipping_information_label');?> :</h2>
     </div>
     
     <div class="detail-action_detail_rgt">
     <p><?php echo $site_currency." ".$product_result['shipping_fee'];?>  </p>
     <p><?php echo $product_result['shipping_info'];?></p>
     
     </div>
      </div>
     </div>
     <div class="detail_product_description">
     <h1><?php echo __('product_description');?></h1>     
     <p><?php echo $product_result['product_info'];?></p>
     </div> 
    </div>
<!--detail end-->
</div>
</div>
</div>
<?php endforeach;?> 
<script type="text/javascript">



$(document).ready(function(){	

    $('.example1').show().before('<div class="scratch_price clearfix"><span class="scratch_price_left">&nbsp;</span><span class="scratch_price_mid" id="open_example22"><a href="#" id="open-example1" title="<?php echo __("scratch_label");?>"><?php if($product_result["product_process"]!=CLOSED){?><?php echo __("scratch_label");?> <?php }?></a></span><span class="scratch_price_right">&nbsp;</span></div>');
	
	$('a#open-example1').click(function() {
		$('.example1').slideDown(100);
		return false;
	});
	$('a#close-example1').click(function() {
		$('.example1').slideUp(100);
		return false;
	});
	$(document).ready(function () {
    $('span.scratch_ok_mid a').click(function () {
        $("#show_pric").show();
		});   

	});
});
$('.scratchbid').live('click',function(){ $('#ecommersebuynow').hide(); })
</script>
