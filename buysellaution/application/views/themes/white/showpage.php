<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right">
<div class="message_common_border">
<?php  $count_cmspage=count($all_cmspage);
        if($count_cmspage > 0)
        {
			foreach($all_cmspage as $cms_content){ ?>
			<h1><?php echo $cms_content['page_title'];?></h1>
			<p>&nbsp;</p>
	</div>
<div class="message_common">

<?php echo $cms_content['page_description']; ?>

<?php }
        }
        else
        {?><div class="message_common">
        <h4 class="no_data fl clr"><?php echo __('no_page_found');?></h4>
        </div>
        <?php 	}			
        ?>
        
</div>
</div>
</div>
</div>
</div>
</div>

