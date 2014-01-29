
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="<?php echo CSSPATH;?>ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<style type="text/css"> 
.success_bidder{border:1px solid #F2F2F2;background: url(<?php echo IMGPATH;?>sucess_bg.png) repeat-x left top; height:24px; width:952px; margin:0 0 10px 0;padding:4px;}
.success_bidder p {background: url(<?php echo IMGPATH;?>tick.png) no-repeat left top; color:#77BE19; padding:5px 0 5px 30px; font:bold 12px arial;}
.lower_bidder{border:1px solid #F2F2F2;background: url(<?php echo IMGPATH;?>sucess_bg.png) repeat-x left top; height:24px; width:952px; margin:0 0 10px 0;padding:4px;}
.lower_bidder p {background: url(<?php echo IMGPATH;?>wrong.png) no-repeat left top; color:#D01123; padding:5px 0 5px 30px; font:bold 12px arial;}

</style>

<?php $id="";
$c_date =Commonfunction::getCurrentTimeStamp();

foreach($productsresult as $product_result):$id.= $product_result['product_id'];?>
<?php if($product_result['product_process']!=CLOSED){?>
<script type="text/javascript">
$(document).ready(function(){
Auction.getauctionstatus(6,"",'<?php echo $id;?>');					   
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
<div class="container_inner element<?php echo $product_result['product_id'];?>">
<div class="auction_item" id="auction_<?php echo $id;?>" name="<?php echo URL_BASE;?>auctions/process">
	<div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>
<div class="banner_inner" id="detail_page">

<div class="signup_head">
	<!-- winning msg / outbid msg -->
	<div class="reserveMessage"></div>
	<!-- end msg -->
<ul>
<li><a href="<?php echo URL_BASE;?>" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
<li><a href="#" title="arr_bg"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
<li class="active"><a href="#" title="<?php echo ucfirst($product_result['product_name']);?>"><?php echo ucfirst($product_result['product_name']);?></a></li>
</ul>
</div>
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
			<div id="slide_container">	
	<div id="slide_content">	
		<div id="slider">
			<ul>			
				<li><a href="#" title="<?php echo ucfirst($product_result['product_name']);?>"> <img src="<?php echo $product_img_path; ?>" width="353" height="297" alt="1" /></a><?php if($product_result['product_process']==CLOSED  && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>" style="float:left;"class="sold_image"/><?php } ?></li>
			<?php	
			    $product_gallery=$product_result['product_gallery'];
			    if($product_gallery!=''){
				$product_images=explode(",",$product_gallery);
				foreach($product_images as $product_image)
				{
				?>
				
				<li><a href="#" title="<?php echo ucfirst($product_result['product_name']);?>"> <img src="<?php echo URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."/thumb370x280/".$product_image; ?>" width="353" height="297" alt="3" /></a><?php if($product_result['product_process']==CLOSED  && $product_result['lastbidder_userid']!=0){?><img src="<?php echo IMGPATH.SOLD_IMAGE;?>" style="float:left;"class="sold_image"/><?php } ?></li>	
				<?php } }?>	
			</ul>
		</div>
	</div>

</div>
            <div class="detail_left_feature_tag">            
            </div>
              <div title="<?php echo __('reserve_auction_label');?>" class="reserve_product"> </div>           
          <div class="productDetail" style="display:none;"><?php echo $product_result['product_id'];?></div>  
            
            <div class="detail_feature_bott_lft">
            <div class="sliders">
             <div title="<?php echo __('reserve_auction_label');?>" class="reserve_white"></div>
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
			 <p><?php echo __('share_label');?> :</p>
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
       
       <!--Bid history-->
		<?/*
		<div class="bid_history" id="<?php echo URL_BASE;?>site/reserve/bidhistories?pid=<?php echo $id;?>"
			style="" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>">
			<img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/>
		</div>*/?>
		<div class="bid_history" id="<?php echo URL_BASE;?>site/reserve/bidhistories?pid=<?php echo $id;?>"
			style="float:left; width:250px;" rel="<?php echo $product_result['lastbidder_userid'];?>" name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/>
		</div>
		<!--End of bid history--> 
		
        </div>
    	<div class="detail_page_top_right">
		
		<div class="hb_bg_mid">
			<ul class="clearfix">
				
				<li>
					<h3  class="countdown">
						<?php echo ($product_result['product_process']!=CLOSED)?"<img src=".IMGPATH."ajax-loader.gif>":__('closed_text');?>
					</h3>
					<label style=" float:left;padding-left:72px;display:block;color:#666;">
						<span class="hrs"><?php echo __('days_label'); ?></span>
						<span class="hrs"><?php echo __('hrs_label'); ?></span>
						<span class="min"><?php echo __('min_label'); ?></span>
						<span class="sec"><?php echo __('sec_label'); ?></span>
					</label>
				
				</li>                               	
				<li>
					<div class="hb_buy_now_left">
						<h3 class="currentprice"><?php echo ($product_result['product_process']==CLOSED)?$site_currency." ".Commonfunction::numberformat($product_result['current_price']):$product_result['current_price'];?></h3>
						<span class="price" style="display:none;"></span>
					</div>
					<?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>
					<div class="hb_buy_now_right">
						<div class="hb_buy_now_button">
							<div class="hb_buy_now_button_left"></div>
							<div class="hb_buy_now_button_mid">
								<p><a href="<?php echo URL_BASE;?>site/buynow/buynow_addcart/<?php echo $product_result['product_id'];?>" title="<?php echo __('Buy Now');?>"><?php echo __('buy_now');?></a></p>
							</div>
							<div class="hb_buy_now_button_right"></div>
						</div>
					</div>
					<?php endif;?>
				</li>
				<li>
					<?php if($product_result['startdate']<=$c_date && $product_result['auction_process']!=HOLD):?>
					<?php 
					  if($product_result['product_process']==LIVE){?>
					  <?php echo __("enter_amt_lable"); ?>
					<div class="hb_buy_now_left">
						<div class="hb_place_bid">
							
							<span><?php echo $site_currency; ?>&nbsp;</span>
							<div class="hb_place_bid_tb">
								<form method="post" id="reserve_form">
								<div class="fl"><input type="text" name="bidamount" id="yourbidding" class="savetext" maxlength="10" value="" /><input type="hidden"  id="currency" class="savetext" value="<?php echo $site_currency;?>" /><p style="font: normal 11px arial;"></p></div>
								</form>
								
							</div>
							<span>&nbsp;.00</span>
						</div>
						<?php } //end ?>
					</div>
					<?php if($product_result['product_process']==LIVE){ ?>
					<div class="hb_buy_now_right">
						<div class="hb_place_bid_button">
							<div class="hb_place_bid_button_left">
							</div>
							<div class="hb_place_bid_button_mid">
								<p><a href="javascript:;" title="<?php echo __('bid_me_label');?>" rel="<?php echo URL_BASE;?>users/login/" class="fl popup" id="dialog_link" data-rel="box"><?php echo __('bid_me_label');?></a></p>
							</div>
							<div class="hb_place_bid_button_right">
							</div>
						</div>
					</div>
					<?php }else if($product_result['product_process']==CLOSED){ ?>
					<span id="link_<?php echo $product_result['product_id'];?>"  class="future auction_link">
					<?php echo __('closed_text');?></span><?php } 
                        else if($product_result['product_process']==FUTURE) { ?>
                        <span style="display:none;" class="comingsoon future"><?php echo __('comingsoon_text');?></span><?php }
                         ?>
                      <?php endif;?>    
				</li>
					
			</ul>
                 <div class="increment_block">
                        <a href="javascript:;"  class="popup increment" title="<?php echo __('increment_label'); ?>" onClick="document.getElementById('fade1').style.display='block';
      document.getElementById('box1').style.display='block';"><?php echo __('increment_label'); ?></a>
                              <div id="fade1"></div>
                        <div class="popupbox2" id="box1">
                            <div>
                            <div class="popup_inner">
                                <div class="popup_content">
                                    <div class="pop_tl">
                                        <div class="pop_tr">
                                            <div class="pop_tm">
                                                <h2><?php echo __('increment_label'); ?></h2>
                                                <a href="javascript:;" title="close" class="re_close" onClick="document.getElementById('box1').style.display='none';
   document.getElementById('fade1').style.display='none'"><?php echo __("close_label"); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="popup_content_middle">
                                        <ul class="increment_list">
                                            <li>
                                                <div class="clearfix">
                                                    <p class="re_price"><b><?php echo __('price_range'); ?></b></p>
                                                    <p class="re_bid"><b><?php echo __('price_range_increment'); ?></b></p>
                                                </div>   
                                            </li> 
                                            <?php  if(isset($incrementvalues)) { 
                                            
                                            foreach($incrementvalues as $key => $increment) { ?>
                                             <li>
                                                <div class="clearfix">
                                                      <p class="re_price"><?php echo $site_currency."".$increment['minrange']; ?> - <?php echo $site_currency."".$increment['maxrange']; ?></p>
                                                    <p class="re_bid"><?php echo $site_currency."".$increment['price']; ?></p>
                                                </div> 
                                            </li>
                                            <?php  } } ?>
                                             
                                        </ul>
                                      
                                    </div>
                                    
                                </div>
                            </div>
                            </div>
                         </div>
                  <div class="reserve_how"> <a href="<?php echo URL_BASE; ?>cmspage/page/how-it-works" title="<?php echo __('howit_works'); ?>" class="increment"><?php echo __('howit_works'); ?></a></div>         
		</div>
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
     <p><?php echo Ucfirst($product_result['typename']);?></p>
     
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

<!--Modal Window-->
<div id="dialog" title="<?php echo __('confirm_box');?>" style="display:none;">
	<div>	
	</div>                                    
<div class="" >
  <a href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="reservebid"  rel="<?php echo URL_BASE;?>users/login/" id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>"><button style="float:right;" ><?php echo __('confirm_bid_me_label');?></button></a></div>
 
</div>

<div id="fade"></div>
   <div class="popupbox2" id="box">
                            <div>
                            <div class="popup_inner popup_inner2">
                                <div class="popup_content">
                                    <div class="pop_tl">
                                        <div class="pop_tr">
                                            <div class="pop_tm">
                                                <h2><?php echo __("review_cofirm"); ?></h2>
                                                <a href="javascript:;" title="close" class="re_close cancel_reserve"  id="boxclose" ><?php echo __('close_lable'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="popup_content_middle">
                                        <div class="clearfix">
                                            <div class="re_image">
                                                <img src="<?php echo $product_img_path; ?>">
                                            </div>
                                            <div class="res_conent">
                                                <h3><?php echo $product_result['product_name']; ?></h3>
                                                
                                                <div class="content_info clearfix">
                                                    <p class="res_label"><?php echo __('price_label');?> </p><span>:</span><p><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".Commonfunction::numberformat($product_result['current_price']):$site_currency." ".Commonfunction::numberformat($product_result['current_price']);?></p>
                                                </div>
                                                <div class="content_info clearfix">
                                                    <p class="res_label"><?php echo __('your_bid_label');?></p><span>:</span><p><span id="sample"></span></p>
                                                </div>
                                          
	                               <div class="re_confirm clearfix">
                                           <div href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="re_confrim_bid reservebid"  rel="<?php echo URL_BASE;?>users/login/" id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>">
                                               <button><?php echo __('confirm_bid_me_label');?></button>
                                           </div>
                                            <div href="javascript:;" name="<?php echo URL_BASE;?>auctions/bid" class="re_cancel_bid cancel_reserve"  rel="<?php echo URL_BASE;?>users/login/" id="<?php echo $product_result['product_id'];?>" data-auctiontype="<?php echo $product_result['auction_type'];?>">
                                               <button><?php echo __("cancel_bid_label"); ?></button>
                                           </div>
                                       </div>
	                              </div>
                                        </div>
                                    </div>
                                    <div class="pop_bl">
                                        <div class="pop_br">
                                            <div class="pop_bm">
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                         </div>
<?php endforeach;?> 
<script type="text/javascript">

//login check when bidding
	if(!$(".user").html())
		{
	$("#dialog_link").mouseover(function(){
		$(this).html(language.login_labels);
		$(this).click(function(){
			window.location=$(this).attr("rel");
		});
	});
	$("#dialog_link").mouseout(function(){
		$(this).html(language.bid_me_label);
	});
	}
	//end
	
// Dialog	
			
	$('#dialog').dialog({
		autoOpen: false,
		width: 500,
		modal: true
              
	});
	$("#yourbidding").keyup(function(){
	$(this).val()!=""?$(this).css({'border-color':'#ccc'}):"";});
	if($(".user").html())
		{
	$('#dialog_link').click(function(){
	if($('#yourbidding').val()!="")
	{
	
		$('#dialog').dialog('open');
		$('#sample').text($('#yourbidding').val());
	}else
	{ 
	  $("#yourbidding").css({'border':'1px solid red'});
	}
		return false;
		
	});
	}
	
</script>   


<script type="text/javascript">
//For Photo View Using Lightbox
    //=============================

    jQuery(function($) {
    	$(".savetext").ForceNumericOnly(true);
    });
    
    //validation for text box amount enter
	jQuery.fn.ForceNumericOnly =
	function(digitonly)
	{
	    var dot = digitonly || false; 
	    return this.each(function()
	    {
	
		$(this).keydown(function(e)

		{ 
		    
		    var key = e.charCode || e.keyCode || 0;
		    // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
		    if(!dot)
		    {
			return (
			    key == 8 || 
			    key == 9 ||
			    key == 46 ||
			    key == 36 || key == 35 ||
			    (key >= 37 && key <= 40) ||
			    (key >= 48 && key <= 57) ||
			    (key >= 96 && key <= 105));
		    }
		    else
		    {
			//Need deciaml point
			return (
			    key == 8 ||
			    key == 190 ||
			    key == 110 ||
			    key == 9 ||
			    key == 46 ||
			    key == 36 || key == 35 ||
			    (key >= 37 && key <= 40) ||
			    (key >= 48 && key <= 57) ||
			    (key >= 96 && key <= 105));
		    }
		});
	    });
	};
    
</script>