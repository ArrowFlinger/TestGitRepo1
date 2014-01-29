<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="container_inner fl clr">
	<div class="title_temp2 fl clr">
    	<h2 class="fl clr" title="<?php echo __('testimonials');?>"><?php echo __('testimonials');?></h2>
    </div>
	<div id="managetable" class="testimonial_list fl clr ml20">
		<ul class="fl pb20">
		<?php 
		if($user_results){
		foreach($user_results as $testimonials_result):?>
		
		<li class="fl clr mt20">
		<!--<div class="blog_user_image fl bg_none">
            	
	            <?php /*
				
				if(($testimonials_result['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH.$testimonials_result['photo']))
	       			{ 
					$users_img_path=URL_BASE.USER_IMGPATH.$testimonials_result['photo'];
				}
				else
				{	
					$users_img_path=IMGPATH.NO_IMAGE;
				}
			
	                <img src="<?php echo $users_img_path;?>" />*/?>
            
        </div> -->
        
       <div class="blog_user_image fl">
        <?php if ($testimonials_result['images'])
        {	?>
       
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
	                <img src="<?php echo $testimonials_img_path;?>" width="150" height="150"/>
           
            <?php 
            } 
            else
            {
           if($testimonials_result['thumb_url']) 
            {?>
            <a style="position:relative;" href="javascript:;" onclick="showhide('<?php echo $testimonials_result['testimonials_id']; ?>')" >
            <img src="<?php echo $testimonials_result['thumb_url'];?>" width="100" height="100"/>
            <div class="thumb_video_list fl" style="position:absolute;*top:70px;*left:0px;"></div></a>
            <div style="width:560px;" class="video<?php echo $testimonials_result['testimonials_id']; ?> videos" onmouseover="show('<?php echo $testimonials_result['testimonials_id']; ?>')"  style="display:none;position:absolute;width:auto;padding:10px; background:#FFF;border:#ccc 1px solid;z-index:999;-moz-box-shadow:5px 5px 10px #333;-webkit-box-shadow:5px 5px 10px #333;box-shadow:5px 5px 10px #333;"><a href="javascript:;" onclick="hide('<?php echo $testimonials_result['testimonials_id']; ?>');" class="close<?php echo $testimonials_result['testimonials_id']; ?> fr clr" style="color:red;"><?php echo __('close_video');?></a><br clear="right"/><?php echo $testimonials_result['embed_code']; ?></div>
            
           <?php
            } 
            } 
            if($testimonials_result['images']=="" && $testimonials_result['thumb_url']=="")
            {
            ?>
             <img src="<?php echo IMGPATH.NO_IMAGE; ?>" width="150" height="150"/>
             <?php
            }?>
        </div>
		
		<div class="testimonial_content fl">
        	<p class="fl clr"><?php echo $testimonials_result['description'];?></p>
        </div>
		 
		<div class="testimonial_content fl">
        	
            <label class="fl user_name mr10 mt20">
		<?php //echo $testimonials_result['date']." Posted by - ". ucfirst($testimonials_result['username']);?>
		<?php 
		// $country=($testimonials_result['country']!="")?$testimonials_result['country']:"IN";
		?>
                 <?php echo  " - " . ucfirst($testimonials_result['username']);?>
            </label>
         	</div>
				
		</li>
		<?php endforeach; 
		}
		else
		{ ?>
		<h4 class="no_data fl clr"><?php echo __("no_data");?></h4> <?php
		}?>
		</table>
	</div>
	<div class="pagination">
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
