<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="container_inner fl clr" style="width:680px;">
    <div class="title-left title_temp1">
    <div class="title-right">
    <div class="title-mid">
  	<h2 class="fl clr" title="<?php echo __('testimonials');?>"><?php echo __('testimonials');?></h2> 
        </div>
        </div>
        </div>
         <div class="deal-left clearfix">
	<div class="action_deal_list clearfix" style="width:678px; padding:0px 0 15px 0px;">
	<div class="testimonial_list">
    
		<ul class="pb20">
		<?php 
		if($user_results){
		foreach($user_results as $testimonials_result):?>
		<li class="fl clr">
		
		
		
		 <div class="blog_user_image fl" style="position:relative;">
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
            <a href="javascript:;" onclick="showhide('<?php echo $testimonials_result['testimonials_id']; ?>')" >
            <img src="<?php echo $testimonials_result['thumb_url'];?>" width="100" height="100"/>
            <div class="thumb_video_list fl"></div></a>
            <div style="float:left;width:560px;text-align:right;" class="video<?php echo $testimonials_result['testimonials_id']; ?> videos" onmouseover="show('<?php echo $testimonials_result['testimonials_id']; ?>')"  style="display:none;position:relative;width:auto;padding:10px; background:#FFF;border:#ccc 1px solid;z-index:999;-moz-box-shadow:5px 5px 10px #333;-webkit-box-shadow:5px 5px 10px #333;box-shadow:5px 5px 10px #333;"><a href="javascript:;" onclick="hide('<?php echo $testimonials_result['testimonials_id']; ?>');" style="width:100%;text-align:right;" class="close<?php echo $testimonials_result['testimonials_id']; ?> fr clr"><?php echo __('close_video');?></a><br clear="right"/><?php echo $testimonials_result['embed_code']; ?></div>
            
           <?php
            } 
            } 
            if($testimonials_result['images']=="" && $testimonials_result['thumb_url']=="")
            {
            ?>
             <img src="<?php echo IMGPATH.NO_IMAGE; ?>" width="89" height="100"/>
             <?php
            }?>
        </div>
		
		
		
         <div class="testimonial_content">
        	<p class="clearfix"><span style="font-weight:bold; font-size:18px;"> &ldquo;</span><span style="margin:0px 3px;"><?php echo $testimonials_result['description'];?></span><span style="font-weight:bold; font-size:18px;">&rdquo;</span></p>
        </div>
        <div class="testimonial_content clearfix">
        	
            <label class=" user_name">
               <?php 
        //$country=($testimonials_result['country']!="")?$testimonials_result['country']:"IN";
        ?>
                 <?php echo  " - " . ucfirst($testimonials_result['username']);?>
            </label>
         	</div>
	           
      
        
       
       <?php /* <div class="blog-video-image fr">
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
	                <img src="<?php echo $users_img_path;?>" width="89"  height="100" />
                    </div> */?>
       
		
				
		</li>
      
		<?php endforeach; 
		}
		else
		{ ?>
		<h4 class="no_data fl clr"><?php echo __("no_data");?></h4> <?php
		}?>
        </ul>
	
        </div>
        <div class="pagination">
	<?php if($user_results > 0): ?>
	 <p><?php echo $pagination->render(); ?></p>  
	<?php endif; ?>
	</div>
	</div>
    </div>
    <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
</div>
<!--Right Sidebar Start-->
<?php include("auctions/right.php");?>
<!---Right Side bar End--->
<script type="text/javascript">
        function showhide(id)
        {
             $(".video"+id).toggle();
               return false;
        }ndotauction
               function show(id)
		{
                        $(".video"+id).show();
		}
		function hide(id)
		{
                        $(".video"+id).hide();
		}
</script>
