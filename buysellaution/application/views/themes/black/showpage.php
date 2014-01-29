<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl pb20">
<?php  $count_cmspage=count($all_cmspage);
		if($count_cmspage > 0)
		{
		    foreach($all_cmspage as $cms_content){ ?>
	<div class="title_temp1 fl clr">
    	<h2 class="fl clr" title="<?php echo $cms_content['page_title'];?>"><?php echo $cms_content['page_title'];?></h2>
    </div>
	<div class="winner_list_out fl clr mt10">
	 	
		<!--<h1 style="padding:6px; color:#c0c0c0; font-size:20px;"><?php echo $cms_content['page_title'];?></h1>-->
		<div style="padding:6px; color:#c0c0c0; font-size:12px; line-height:25px;" class=" article_content fl p10">
			
		      <?php echo $cms_content['page_description']; ?>
		</div>
		
	</div><?php
			    }
			}
			else
			{?>
				<h4 class="no_data fl clr"><?php echo __('no_page_found');?></h4>
		<?php 	}			
			 ?>
</div>

</div>


