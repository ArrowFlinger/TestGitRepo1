<?php defined("SYSPATH") or die("No direct script access."); ?>

<div class="dash_heads">
        <ul>
          <li><a href="#" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
          <li><a href="#"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
          <li class="active"><a href="#" title="<?php echo strtoupper(__('testimonials'));?>"><?php echo ucfirst(__('testimonials'));?></a></li>
        </ul>
      </div>
       <?php include("auctions/left.php");?>
		
       <div class="banner_rgts">
        <div class="today_headss">
          <h2><?php echo ucfirst(__('testimonials'));?></h2>
          <span class="arrow_oness">&nbsp; </span> </div>
        <div class="news_all">
         <?php 
        if($user_results)
        {
                foreach($user_results as $testimonials_result):?>
                <li>                    
                <div>
                <?php 
                if(($testimonials_result['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH.$testimonials_result['photo']))
                { 
                        $users_img_path=URL_BASE.USER_IMGPATH.$testimonials_result['photo'];
                }
                else
                {	
                        $users_img_path=IMGPATH.NO_IMAGE;
                }
                ?>
          <div class="alls" id="testimonials_details_page">
              <div class="uptors">

            </div>
            <div class="news" style="position:relative;float:left;">
                         
             
              <?php if ($testimonials_result['images'])
                {?>
                <?php 
                if(($testimonials_result['images'])!="" && file_exists(DOCROOT.TESTIMONIALS_IMGPATH.$testimonials_result['images']))
                { 
                        $testimonials_img_path=URL_BASE.TESTIMONIALS_IMGPATH.$testimonials_result['images'];
                }
                else
                {
                        $testimonials_img_path=IMGPATH.NO_IMAGE;
                }
                ?>
                        <img src="<?php echo $testimonials_img_path;?>" width="100" height="100"/>
                        
                <?php 
                } 
                else
                {
                        if($testimonials_result['thumb_url']) 
                        {?>
                        <a href="javascript:;" onclick="showhide('<?php echo $testimonials_result['testimonials_id']; ?>')" >
                        <img src="<?php echo $testimonials_result['thumb_url'];?>" width="100" height="100"/>
                        <div class="thumb_video_list fl"></div></a>
                        <div style="width:560px;" class="video<?php echo $testimonials_result['testimonials_id']; ?> videos" onmouseover="show('<?php echo $testimonials_result['testimonials_id']; ?>')"  style="display:none;position:absolute;width:450px;padding:10px; background:#FFF;border:#ccc 1px solid;z-index:999;-moz-box-shadow:5px 5px 10px #333;-webkit-box-shadow:5px 5px 10px #333;box-shadow:5px 5px 10px #333;"><a href="javascript:;" onclick="hide('<?php echo $testimonials_result['testimonials_id']; ?>');" class="close<?php echo $testimonials_result['testimonials_id']; ?> fr clr"><?php echo __('close_video');?></a><br clear="right"/><?php echo $testimonials_result['embed_code']; ?></div>
                        <?php
                        } 
                } 
                if($testimonials_result['images']=="" && $testimonials_result['thumb_url']=="")
                {
                ?>
                <img src="<?php echo IMGPATH.NO_IMAGE; ?>" width="100" height="100"/>
                <?php
                }?>
				
				
				<div class="testmonials_right_content">
				 <p><?php echo $testimonials_result['description'];?></p>
                
              <span class="test_username">  <?php echo  " - " . ucfirst($testimonials_result['username']);?></span>
				
				</div>
                
            </div>
          </div>        
          
        </div>
		 <?php endforeach;
                 }
        else
        { ?>
                <h4 class="no_data fl clr"><?php echo __("no_data");?></h4> <?php
        }?>
        
         <div class="nauction_pagination">
	<?php if($user_results > 0): ?>
	<p><?php echo $pagination->render(); ?></p>  
	<?php endif; ?>
	</div>
      </div>
<script type="text/javascript">
                function showhide(id)
                {
                        $(".video"+id).toggle();
                        return false;
                }
                function show(id)
                {
                        $(".video"+id).show();
                }
                function hide(id)
                {
                        $(".video"+id).hide();
                }
        </script>
