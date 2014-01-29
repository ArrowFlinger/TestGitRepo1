<?php defined("SYSPATH") or die("No direct script access."); ?>
<div>
<?php  $count_cmspage=count($all_cmspage);
	if($count_cmspage > 0)
	{
	    foreach($all_cmspage as $cms_content)
	    { ?>
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr" title="<?php echo $cms_content['page_title'];?>"><?php echo $cms_content['page_title'];?></h2>
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
	<div class="action_deal_list clearfix">
	<div class="winner_list_out fl clr mt10">
		<div style="padding:6px 6px 6px 21px; color:#3d3d3d; font-size:12px; line-height:25px;" class=" article_content fl p10">
		      <?php echo $cms_content['page_description']; ?>
		</div>
	</div>
	<?php
             }
        }
        else
        {?>
        <h4 class="no_data fl clr"><?php echo __('no_page_found');?></h4>
        <?php 	
        } ?>
        </div>
        </div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
</div>
