<?php defined("SYSPATH") or die("No direct script access."); ?>

<?php 
$urlbase=substr_replace(URL_BASE, "", -1);

$test=explode("/",$urlbase);

if(count($test)==4){
   $u='/'.$test[3];
}else{
           $u="";
}
$l=substr($server_uri, -1);
$ubase=$server_uri;

if(($ubase!='/') && ($ubase!= $u.'/news/news_details') && ($ubase!=$u.'/users/testimonials_details') && ($ubase!=$u.'/userblog/blog_details') && ($ubase!=$u.'/userblog/blog_inner/'.$l)){?>
        <ul>
          <li><a href="<?php echo URL_BASE;?>" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
          <li><a><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
          <li class="active"><a title="<?php echo $selected_page_title;?>"><?php echo $selected_page_title; ?></a></li>
        </ul><?php } ?>
      </div>
<div id="banner">
  <div class="banner_inner">
    <div class="banner_total">
      <div class="banner_lft">
         <div class="server_time"> <span class="server_bg"><img src="<?php echo IMGPATH;?>time_bg.png" width="33" height="33" alt="img" /></span>
          <div class="server_rgt">
            <p><?php echo __('server_time_label'); ?></p>
            <ul>
              <li><b class="server_time_hrs"><?php echo date('h',time());?></b>
                <label><?php echo __('hours'); ?></label>
              </li>
              <li><b class="server_time_mins"><?php echo date('i',time());?></b>
                <label><?php echo __('min'); ?></label>
              </li>
              <li><b class="server_time_secs"><?php echo date('s',time());?></b>
                <label><?php echo __('sec'); ?></label>
              </li>
            </ul>
          </div>
        </div>
        <?php
        $adsdetails=Commonfunction::get_ads_details();        
        foreach($adsdetails as $adsdetail){
        ?>
		<?php   $ad_image_path=ADS_NOIMGPATH;

			if(( $adsdetail['ads_image']) && (file_exists(DOCROOT.ADS_IMGPATH.$adsdetail['ads_image'])))
			{ 
			   $ad_image_path = URL_BASE.ADS_IMGPATH.$adsdetail['ads_image'];		  								   
			}		
		?>        
      <a href="<?php echo $adsdetail['website']; ?>" target="_blank" class="side1"><img src="<?php echo $ad_image_path;?>"  width="<?php echo ADS_RESIZE_IMAGE_WIDTH;?>" height="<?php echo ADS_RESIZE_IMAGE_HEIGHT;?>" title="<?php echo ucfirst($adsdetail['title']);?>"  alt="<?php echo ucfirst($adsdetail['title']);?>" /></a>
      <?php }?>
      </div>
