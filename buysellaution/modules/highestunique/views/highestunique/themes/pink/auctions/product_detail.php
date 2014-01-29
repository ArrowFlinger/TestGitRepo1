<?php defined('SYSPATH') or die('No direct script access.');?>
<link rel="stylesheet" type="text/css" href="<?php echo CSSPATH;?>jquery.ad-gallery.css"/>
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>jquery.ad-gallery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){	
			// select element styling
			$('select.select').each(function(){
				var title = $(this).attr('title');
				if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
				$(this)
					.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
					.after('<span class="select">' + title + '</span>')
					.change(function(){
						val = $('option:selected',this).text();
						$(this).next().text(val);
						})
			});
	});
</script>
<script type="text/javascript">
 
  $(function() {
    $('img.image1');
    $('img.image1');
    $('img.image4');
    $('img.image5');
    var galleries = $('.ad-gallery').adGallery();
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
     
  });
 
  </script>
<?php

$id="";
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
<div class="container_inner fl clr element<?php echo $product_result['product_id'];?>">
<div class="container">
<div class="detail_block">
    <div class="detail-tl">
        <div class="detail-tr">
            <div class="detail-tm">
                <h1 class="pro_title"><?php echo __('menu_product_detail');?></h1>
                
            </div>
        </div>
    </div>
    <?php 
    			if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB5.$product_result['product_image']))
	       			{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_result['product_image'];
					$product_full_size=URL_BASE.PRODUCTS_IMGPATH_THUMB5.$product_result['product_image'];
					$product_small_size=URL_BASE.PRODUCTS_IMGPATH_THUMB4.$product_result['product_image'];
					
				}
				else
				{
					$product_full_size=IMGPATH.NO_IMAGE;
					$product_small_size=IMGPATH.NO_IMAGE;
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?>
<div class="product_container clr auction_item" id="auction_<?php echo $id;?>" name="<?php echo URL_BASE;?>auctions/process">
     <div class="auction_type" data-auctiontype="<?php echo $product_result['auction_type'];?>"></div>				
    <div class="detail-inner clearfix" id="highest_product_detail_page">
            <div class="match_banner">
                <div class="slider-top"></div>
                  <!-- Slider part starts -->
                <div class="slider-mid">
<?php if($product_result['product_featured']==FEATURED){?><span class="feature_label"></span><?php } ?>
<?php if($product_result['dedicated_auction']==ENABLE){?><span class="bonus_icon" title=""></span><?php } ?>
<?php if($product_result['autobid']==ENABLE){?><span class="autobid_icon"></span><?php } ?>
<?php if($product_result['product_featured']==HOT){?><span class="hot_icon_product"></span><?php } ?>                    
                    <div class="highestunique_big"></div>               
                    <div id="gallery" class="ad-gallery">
                        <div class="ad-image-wrapper"> </div>
                        <div class="ad-controls"> </div>
                            <div class="ad-nav">
                              <div class="ad-thumbs">
                                <ul class="ad-thumb-list">
					<?php  $productimage_count = explode(",",$product_result['product_gallery']);
					if(($product_result['product_gallery']=="")&&($product_result['product_image'] =="")) 
					{ 
					$no_img_path=IMGPATH.NO_IMAGE;
					?>
					<li> <a href="<?php echo $no_img_path;?>" title="Image"> <img src="<?php echo $no_img_path;?>" class="image0"  alt="test" width="81" height="54"  /> </a> </li>
					<?php
					}
					elseif(($product_result['product_gallery']=="")&&($product_result['product_image']!==""))
					{
						$product_full_size=URL_BASE.PRODUCTS_IMGPATH_THUMB5.$product_result['product_image'];
						?>
						<li> <a href="<?php echo $product_full_size;?>" title="Image"> <img src="<?php echo $product_small_size;?>" class="image0"  alt="test" width="81" height="54"  /> </a> </li>
						<?php }
					else
					{ ?>
					<li> <a href="<?php echo $product_full_size;?>" title="Image"> <img src="<?php echo $product_full_size;?>" class="image0"  alt="test" width="81" height="54"  /> </a> </li>
					<?php
					foreach($productimage_count as $productallname)
					{
					  $gallary_main=explode(" ",$productallname);
					  $gallary_main_image=implode('_',$gallary_main);
					$product_fullimagee_size=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb254x239/".$gallary_main_image;
					$product_thumb_size=URL_BASE.PRODUCTS_IMGPATH_THUMB150x150."thumb81x54/".$productallname;				
					?>					
					<li> <a href="<?php echo $product_fullimagee_size;?>" title="Image"> <img src="<?php echo $product_thumb_size;?>" class="image0"  alt="test" width="81" height="54"  /> </a> </li>					
					<?php					
					}
					}
					?>					
                                 
								</ul>
                              </div>
                            </div>
                       </div>
                </div>
                   <!-- Slider part starts -->
                      <!-- Watchlist part starts -->
                       <div class="watchlist">
              <div id="successaddwatchlist_<?php echo $product_result['product_id'];?>" class="info_msg mt5"></div>
				<?php if($product_result['product_process']!=CLOSED){ ?>
				<a href="javascript:;" class="future addwatchlist" title="<?php echo __('add_to_watchlist');?>" rel="<?php echo $product_result['product_id'];?>"  name="<?php echo URL_BASE;?>auctions/addwatchlist"><?php echo __('add_to_watchlist');?></a>               
                <?php } ?>
              </div>
                        <!-- Watchlist part ends -->
               <div class="slider-bottom"></div>
             </div>
         <!-- price time and shart part starts -->
        <div class="history_block clearfix">
            <div class="price-block1">
                <h2><?php echo __('Price_label');?></h2>                
                <p class="currentprice"><?php echo ($product_result['product_process']==CLOSED)? $site_currency." ".$product_result['current_price']:$site_currency." ".$product_result['current_price'];?></p>
            </div>
            <div class="timer-block">
                <h2><?php if($product_result['product_process']!=CLOSED){ echo __('time_left');}?></h2>
					<div class="countdown clearfix">
                <div class="timer clearfix">                
                  <strong class="countdown"><?php echo ($product_result['product_process']!=CLOSED)?"<img src=".IMGPATH."ajax-loader.gif>":__('closed_text');?></strong>
                </div>
                </div>                
            </div>
            <div class="share-block">            	
                <div class="buy-block">
				<?php if($product_result['buynow_status']==ACTIVE && $product_result['product_process']!='C'):?>                  
				  <div class="buy-left">
                   
                        <div class="buy-right">
                            <div class="buy-mid">                            
                                <a href="<?php echo URL_BASE;?>site/buynow/buynow_addcart/<?php echo $product_result['product_id'];?>" title="<?php echo __('buy_now');?>"><?php echo __('buy_now');?></a>                                
                            </div> 
                        </div>  
                    </div><?php endif;?>
                    <?php if($product_result['product_process']!=CLOSED){?>
                    <div class="share clearfix">
                        <p style="line-height:12px;"><?php echo __('share_label');?> : </p>
                        <?php $url=URL_BASE."auctions/view/".$product_result['product_url'];?>
                        <script type="text/javascript">
                        (function()
                        {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                        })();
                        </script>
                        <ul>
                            <li class="twit" style="width:20px;float:left;border:1px soid green;"><a href="http://twitter.com/share?url=<?php echo $url;?>&amp;text=<?php echo $product_result['product_name'];?>" target="_blank"  title="Twitter" class="fl">
                                            <img style="width:16px;height:16px;" src="<?php echo IMGPATH;?>s2.png" alt="Twitter" border="0" class="fl"/>
                                        </a></li>
                            <li class="face"><a href="https://www.facebook.com/sharer.php?u=<?php echo $url;?>&t=<?php echo $product_result['product_name'];?>" title="Facebook" class="fl" target="_blank">
                                            <img src="<?php echo IMGPATH;?>s3.png" alt="Facebook" border="0" />
                                        </a></li>
                            <li class="flike"><fb:like href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"></fb:like></li>
                        </ul>
                    </div> <?php }?>
                </div>
            </div>
        </div>
          <!-- price time and share part ends -->
            <!-- table part starts -->
            <!--Bid history-->
			<!--End of bid history-->     
        <div class="blue_tab_outer blue_tab_outer1">
			<div class="blue_tab_inner">
                <ul><li><span class="blue_tab_lft">&nbsp;</span><span class="blue_tab_mid"><?php echo __('bid_history_label');?></span><span class="blue_tab_rft">&nbsp;</span></li></ul>                
            </div>
            <div class="tab_cont_bg">
				<div class="bid_history" id="<?php echo URL_BASE;?>site/highestunique/bid_history/<?php echo $id;?>" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/>
				</div>
            </div>            
        </div>           
          <!-- table part ends -->        
        <div class="blue_pro_dis">
            <b><?php echo __('product_description');?></b>
            <p><?php echo $product_result['product_info'];?></p>            
        </div>
         <!-- Message flash-->
           <div class="notice_nsg2 fl clr" id="notice_msg<?php echo $product_result['product_id'];?>" style="display:none;"></div> 
           <!-- end of Message flash-->
           <!-- Self Single Selection  part starts -->
              <?php if($product_result['product_process']==LIVE){?>
        <div class="blue_self">
          
            <div class="blue_self_lft"></div>
            <div class="blue_self_mid">
                
                <div class="self_single_selection">
                    <label><?php echo __('slf_single');?><span>(<span class="WebRupee"><?php echo $site_currency; ?></span>)</span></label>
                    <form method="post" name="lowestunique" id="bidform_single">
                    <input type="hidden" name="totalbidamount" value="<?php echo $product_result['bidamount'];?>">
					<input type="hidden" name="length" value="1">
					<input type="hidden" name="single" value="5">
                    <div class="clearfix" style="width:309px">                    
                        <div class="selection_input">
                            <div class="selection_input_left"></div>
                            <div class="selection_input_middle">                            
                                <input type="text" name="range1" id="ran" value="" maxlength="6"  title="<?php echo __('enter_bid_amt')?>" />
                            </div>
                            <div class="selection_input_right"></div>
                        </div>
					  
                        <div class="bid_me_submit">
                            <div class="bid_me_submit_left"></div>
                            <div class="bid_me_submit_middle">


                            <a href="javascript:;" name="<?php echo URL_BASE; ?>site/lowestunique/bid/<?php echo $product_result['product_id']; ?>" class="bid" title="<?php echo ($auction_userid == '') ? __('login_label') : __('bid_me_label'); ?>" rel="<?php echo URL_BASE; ?>users/login/" id="<?php echo $product_result['product_id']; ?>"  data-auctiontype ="<?php echo $product_result['auction_type']; ?>" data-formid="bidform_single"> <?php echo __("bid_me_label"); ?></a>

                            </div>
                            <div class="bid_me_submit_right"></div>                           
                        </div>
                        
                    </div></form>  
                </div> 
                <div class="default_selection">
                    <label><?php echo __('default_label');?></label>
                    <div class="clearfix">
                        <div class="selection_input">
                            <div class="selection_input_left"></div>
                            <div class="selection_input_middle">
                                <select name="bid_range"  id="bid_range" class="blk_txt12"> 
                                    <option value=""><?php echo __('select_label');?></option>			
			<?php
			$j=1.00;
			for($i=0.01;$i<200;$i++)
			{?>
			<option name="range" value="<?php echo $i."-".number_format($j,2);?>"><?php echo $i."-".number_format($j,2);?></option>

			<?php 
			$j++;}
			?>								                       
                </select>
                            </div>
                            <div class="selection_input_right"></div>
                        </div>
                    </div>
                </div>
                <div class="self_single_selection_to">
                    <label><?php echo __('slf_single');?><b>(<?php echo $site_currency; ?>)</b></label>
                    <div class="clearfix">
                        <div class="selection_input">
                            <div class="selection_input_left"></div>
                            <div class="selection_input_middle">
                                <input type="text" name="multifrom" maxlength="6"  value="" title="<?php echo __('enter_bid_amt')?>" />
                            </div>
                            <div class="selection_input_right"></div>
                        </div>
                        <span><?php echo __('to');?></span>
                        <div class="selection_input">
                            <div class="selection_input_left"></div>
                            <div class="selection_input_middle">
                                <input type="text" name="multito" maxlength="6"  value="" title="<?php echo __('enter_bid_amt')?>" />
                            </div>
                            <div class="selection_input_right"></div>
                        </div>
                        <div class="proceed_submit">
                            <div class="proceed_submit_left"></div>
                            <div class="proceed_submit_middle">
                                <input name="multiple_proceed" id="multiple_proceed" type="submit" value="<?php echo __('proceed_label');?>" title="<?php echo __('proceed_label');?>" />
                            </div>
                            <div class="proceed_submit_right"></div>
                        </div>
                       
                    </div> 
                </div>
            </div>
            <div class="blue_self_rft"></div>
            
        </div> <?php }?>
            <!-- Self Single Selection  part ends -->
        <div class="bidding_options_content">
            <!-- Check box part starts -->
            <div class="bidding_options_left">
                <ul class="clearfix">
                    <div id="bidlimits"></div>                   
                </ul>
                <div class="bottom_sproceed_submit">
                    
                </div>
            </div>
            <div id="bid_conform" >
				<div class="bidding_options_right"  style="display:none">
					<div class="bidding_options_right_inner_left">
					</div>
				</div>
			</div>
           
        </div>
    </div>
    <?php if($product_result['product_process']==LIVE){?>
<?php }?>
    <div class="detail-bl" style="width:940px;">
        <div class="detail-br">
            <div class="detail-bm">
                
            </div>
        </div>
    </div>
</div>
</div>
<?php endforeach;?>

<script type="text/javascript">
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

//Call
	
$(document).ready(function(){
	$("#ran").ForceNumericOnly(true);//Accepts digit with decimal
	
 });



	$('.bid_checkall').live('click',function(){
		if($(this).is(':checked'))
		{
			$(".bid_rangelist").attr('checked',true);
		}
		else
		{
			$(".bid_rangelist").removeAttr('checked');
		}
	});	
	$("#bid_range").change(function(){ 
	var add="";
	value = $(this).val();	
	$split = value.split("-");
	$first = parseFloat($split[0]);
	$sec = parseFloat($split[1]);			 
	add+='<div class="bidding_options_left">';
	add+='<input type="checkbox" class="bid_checkall"><span style="font:bold 12px arial;color:#CD017D;"><?php echo __("check_label");?><span>';
	add+='<ul class="clearfix">';		
	add+='</ul>';	
	
	for($i=$first;$i<=$sec;$i+=0.01)
	{
		if($i==$sec)
		{
			break;
		}
	  
	 
	   add+='<li><input class="bid_rangelist" type="checkbox" name="chckpr[]"  value="'+$i.toFixed(2)+'">';
           add+='<span>'+$i.toFixed(2)+' </span></li>';
	   
	   	
	}
	add+='<div class="proceed_submit" id="confirm">';
    add+='<div class="proceed_submit_left"></div>';
    add+='<div class="proceed_submit_middle">';
	add+='<input class="" type="submit" style="" value="Proceed" name="confirm">';
	add+='</div>';
	add+='<div class="proceed_submit_right"></div>';
	add+='</div>';
	add+='</ul>';
	add+='</div>';	
	   $('#bidlimits').html(add);
		  
});
	$('.bid_rangelist').live('click',function(){
	$('#bid_conform').html('');
	});

	//Multi
	$("#multiple_proceed").click(function(){

		var add="";
	value = $(this).val();
	
	$split1 = $("input[name=multifrom]").val();
	$split2 = $("input[name=multito]").val();
	
	if(($split1!='' && $split2!=''))
	{
	
	$first = parseFloat($split1);
	$sec = parseFloat($split2);
	
	if(!(isNaN($split1) && isNaN($split2))){
		
		if($first>=0.01 && $first<=200.00){
			
			
		
		if($sec>=0.01 && $sec<=200.00){
		
		
	   if($sec>$first)
	   {
	
	
	
	var count=new Array(),j=0;
	for($i=$first;$i<=$sec;$i+=0.01)
	{
		if($i==$sec)
		{
			break;
		}
	      count[j]=$i;
		
		j++;
	   	

	}		

if(count.length>100){
$('#bidlimits').html("<?php echo __('bid_limit_greater_than_100'); ?>");	

}else{
	for($i=$first;$i<=$sec;$i+=0.01)
	{
		if($i==$sec)
		{
			break;
		}  
	   
	   add+='<li><input class="bid_rangelist" type="checkbox" name="chckpr[]"  value="'+$i.toFixed(2)+'">';
       add+='<span style="">'+$i.toFixed(2)+' </span></li>';   
	   	
		}
                 
		add+='<div class="bidding_options_left">';
		add+='<input type="checkbox" class="bid_checkall"><span style="font:bold 12px arial;color:#999;"><?php echo __("check_label");?><span>';
		add+='<ul class="clearfix">';
		add+='<li>';
		add+='</li>';
		add+='</ul>';
		add+='</li>';
		add+='<div class="bottom_sproceed_submit">';
		add+='<div class="proceed_submit_left"></div>';
		add+='<div class="proceed_submit_middle">';     
		add+='<input id="confirm" type="submit" value="Proceed" name="confirm">';
		add+='</div>';
		add+='<div class="proceed_submit_right"></div>';
		add+='</div>';
	   $('#bidlimits').html(add);	
}

	 }else{
		
		$('#bidlimits').html("<?php echo __('second_range_greater_than_first_range'); ?>");	
		
	   }
	   
	   
	     }else{
		
		$('#bidlimits').html("<?php echo __('range_must_be_0.1_to_200'); ?>");	
		
	   }
	   
	   }else{
		
		$('#bidlimits').html("<?php echo __('range_must_be_0.1_to_200'); ?>");	
		
	   } 
	   
	}else{
		
		$('#bidlimits').html("<?php echo __('please_enter_only_numbers'); ?>");	
	}
	
	
	
	}else{
		
		
		$('#bidlimits').html("<?php echo __('please_enter_range_values'); ?>");	
	}


	});	

$("#confirm").live('click',function(){
	
	var bidfee="<?php echo $product_result['bidamount']; ?>",range="",add="",productid="<?php echo $product_result['product_id'];?>",userbalance="<?php if($product_result['dedicated_auction']==ENABLE){echo $site_currency.' '.$user_current_bonus;}else{ echo  $site_currency.' '.$user_current_balance; }?>";
$('html, body').animate({scrollTop:700}, 'slow');
	i=1;
	$('.bid_rangelist:checked').each(function(){		
		range+='<li>';
		range+='<span> '+$(this).val()+'</span>';
		range+='</li>';
		range+='<input class="" type="hidden" name="range'+i+'" value="'+$(this).val()+'">';
		i++;
	});
	
	if(parseInt($('.bid_rangelist:checked').length)>0){
	
	var placedlength=parseInt($('.bid_rangelist:checked').length)*bidfee;	

	
	add+='<form method="post" name="highestunique" id="bidform" action="">';
		add+='<div class="bidding_options_right">';
		add+='<div class="bidding_options_right_inner_left">';
		add+='<p><span class="bidding_info_title"> <?php echo __("balance_label");?> </span><span class="bidding_info_colon">:</span> <span class="bidding_info_value">'+userbalance+'</span></p>';
		//add+='<span class="bidding_info_value"><?php echo __("bidding_amount");?> :'+bidfee+' <span></p>';				
		add+='<p><span class="bidding_info_title"><?php echo __("place_bid");?></span><span class="bidding_info_colon">:</span> <span class="bidding_info_value">'+placedlength+'</span></p>';		
		//add+='<span class="bidding_info_value"><?php echo __("remain_label");?> :0 </span></p>';		
		
		add+='<input type="hidden" name="totalbidamount" value="'+placedlength+'">';
		add+='<input type="hidden" name="length" value="'+parseInt($('.bid_rangelist:checked').length)+'">';
		add+='<input type="hidden" name="single" value="">';
		add+='<div class="bidding_options_right_submit">';
		add+='<div class="bid_me_submit_left"></div>';
		add+='<div class="bid_me_submit_middle">';
		
		add+='<a href="javascript:;" name="<?php echo URL_BASE; ?>site/highestunique/bid/<?php echo $product_result["product_id"]; ?>" class="bid" title="<?php echo ($auction_userid == '') ? __('login_label') : __('bid_me_label'); ?>" rel="<?php echo URL_BASE; ?>users/login/" id="<?php echo $product_result["product_id"]; ?>"  data-auctiontype ="<?php echo $product_result["auction_type"]; ?>" data-formid="bidform"> <?php echo __("bid_me_label"); ?></a>';
		add+='</div>';
		add+='<div class="bid_me_submit_right"></div>';
		
		add+='</div>';
		add+='<div class="bidding_options_left bidding_info_bottom_values">';
		add+='<ul class="clearfixf">';
		add+=range;
		add+='</ul>';
		add+='</div>';		
		add+='</div>';
		add+='<div class="bidding_options_right_inner_right">';
		add+='<p><?php echo __("bidding_amount");?>:'+bidfee+'</p>';
		add+='</div>';
		add+='</div>';
		
 add+='</form>';

	 $('#bid_conform').html(add);
	 
	  }else{
		var display_msg=$("#notice_msg<?php echo $product_result['product_id'];?>");
		$(display_msg).show();
		$(display_msg).html("<?php echo __('atleast_select_one_range');?>");
		$(display_msg).fadeOut(5000);
	}
	 

});
$('.bid').live('click',function(){ $('.bidding_options_content').hide(); })
$('#bid_range').change(function(){ $('.bidding_options_content').show(); })
$('#multiple_proceed').live('click',function(){ $('.bidding_options_content').show(); })
</script>
