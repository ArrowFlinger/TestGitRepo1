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
<link href="<?php echo CSSPATH;?>slider.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>jquery1.js"></script>
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>easy_jquery.js"></script>
<script type="text/javascript" src="<?php echo SCRIPTPATH;?>easySlider1.5.js"></script>
<script type="text/javascript">
$.noConflict();
jQuery(document).ready(function(j) {
		j(document).ready(function(){	
			j("#slider").easySlider({
				controlsBefore:	'<p id="controls">',
				controlsAfter:	'</p>',
				auto: true, 
				continuous: true
			});
					
		});	
});
</script>
</head>
<?php
$id="";
$c_date =Commonfunction::getCurrentTimeStamp();
foreach($productsresult as $product_result):$id.= $product_result['product_id'];?>

<?php if($product_result['product_process']!=CLOSED){?>
<script type="text/javascript">
$(document).ready(function(){

});
</script>
<?php } 
else {
?> 
<?php }?>
<script type="text/javascript">
$(document).ready(function(){
Auction.bidhistory();				   
});
</script>


<div class="container">
<!-- start content-->
<div class="detail_block">
     
    <div class="detail_page_top">
       <h1 class="detail_title"><?php echo $product_result['product_name'];?></h1>
    <div class="detail-inner white-inner clearfix">
        <div class="fl">
            <!-- slidder style starts -->
            <?php 
    			if(($product_result['product_image'])!="" && file_exists(DOCROOT.PRODUCTS_IMGPATH_THUMB.$product_result['product_image']))
	       		{ 
					$product_img_path=URL_BASE.PRODUCTS_IMGPATH_THUMB.$product_result['product_image'];
					$product_full_size=URL_BASE.PRODUCTS_IMGPATH.$product_result['product_image'];					
				}
				else
				{
					$product_full_size=IMGPATH.NO_IMAGE;
					$product_img_path=IMGPATH.NO_IMAGE;
					
				}
			?>
            <div class="detail_page_top_left">
            <!---<ul>
            <li> <a href="#"> <img src="public/images/bag_img.png" width="353" height="297" alt="img" /> </a> </li>
            
            </ul>-->
			<!---slide_show-->
			<div id="slide_container">
                            <div id="slide_content">
                                    <div id="slider">
                                            <ul>							
                                                    <?php  $productimage_count = explode(",",$product_result['product_gallery']);
					if($product_result['product_image']=="")
					{ 
					$no_img_path=IMGPATH.NO_IMAGE;
					?>
					<li><a href="#" title="1"> <img src="<?php echo $no_img_path;?>" width="353" height="297" alt="" /></a></li>
					<?php
					}
					else
					{ ?>
                    <li> <a href="<?php echo $product_full_size;?>" title="<?php echo __('image');?>"> <img src="<?php echo $product_img_path;?>" class="image0"  alt="<?php echo $product_result['product_name'];?>" width="81" height="54"  /> </a> </li>
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
                                    </div>
                            </div>

                         </div>

			<!--slide_show-->
           <?php if($product_result['product_featured']==FEATURED){?>
            <div class="detail_left_feature_tag">
            
            </div>
            <?php } ?>           
            <div class="detail_feature_bott_lft"><div class="sliders">           
				
              <?php if($product_result['product_featured']==HOT){?>
              <a href="#"><img width="14" height="19" alt="Hot" title="Hot" src="<?php echo IMGPATH; ?>head_top4_bg.png"/></a>
              <?php }?>
              <?php  if($product_result['dedicated_auction']==ENABLE){?>
              <a href="#"><img width="19" height="19" alt="Bonus" title="Bonus" src="<?php echo IMGPATH; ?>head_top5_bg.png"/></a><?php }?>
              </div>
              <a href="#"><img width="24" height="25" alt="plus" title="plus" src="<?php echo IMGPATH; ?>plus_bg.png"/></a>             </div>
             
             <div class="detail_left_social_link">
             
             <?php if($product_result['product_process']!=CLOSED){?>
             <div class="social_sec">
			 <p><?php echo __('share_label');?> :</p>
			 <?php $url=URL_BASE."auctions/view/".$product_result['product_url'];?>
			 
			  <script type="text/javascript">
                        (function()
                        {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                        })();
                        </script>
			<g:plusone size="medium" annotation="none"></g:plusone>
			 <a href="http://twitter.com/share?url=<?php echo $url;?>&amp;text=<?php echo $product_result['product_name'];?>" target="_blank"  title="Twitter" class="fl">
			 <img src="<?php echo IMGPATH;?>s2.png" alt="Twitter" border="0" class="fl"/>
			</a>
			<a href="https://www.facebook.com/sharer.php?u=<?php echo $url;?>&t=<?php echo $product_result['product_name'];?>" title="Facebook" class="fl" target="_blank">
			<img src="<?php echo IMGPATH;?>s3.png" alt="Facebook" border="0" />
			</a>
			 <fb:like href="<?php echo $url = URL_BASE.'auctions/view/'.$product_result['product_url'];?>" layout="button_count" width="84" send="false" ref="" style="border:none;"></fb:like>
			 </div>
             </div>
            <?php }?>
        
        </div>
           </div>  
              <!-- slidder style ends -->
        <div class="orange_bidhistory_right"><h2><?php echo __('product_description');?></h2>
            <p><?php echo $product_result['product_info'];?></p>
                </div>
   
          <!-- table style starts -->
      <div class="blue_tab_outer bid_history1">
            <div class="blue_tab_inner">
                <ul><li><span class="blue_tab_mid"><?php echo __('bid_history_label');?></span></li></ul>
                
            </div>
            <div class="tab_cont_bg">
                 <div class="bid_history" id="<?php echo URL_BASE;?>site/lowestunique/bid_history/<?php echo $id;?>" rel="<?php echo $product_result['lastbidder_userid'];?>"  name="<?php echo $auction_userid;?>"><img src="<?php echo IMGPATH.'ajax-loader.gif';?>"/> 
                </div>
            
        </div>  
        
        <!-- table style ends --> 
        
    </div>
    </div>
</div>
</div>
<?php endforeach;?>
