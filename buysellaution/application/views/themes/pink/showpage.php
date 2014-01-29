<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl pb20">
<?php  $count_cmspage=count($all_cmspage);
        if($count_cmspage > 0)
        {
                foreach($all_cmspage as $cms_content){ ?>
                        <div class="title-left">
                        <div class="title-right">
                        <div class="title-mid">
                        <h2 class="fl clr product_detail_title" title="<?php echo $cms_content['page_title'];?>"><?php echo $cms_content['page_title'];?></h2>
                        <span class="title-arrow">&nbsp;</span>
                        </div>
                        </div>
                        </div>
	                <div class="winner_list_out deal_list clearfix">
		                <div style="padding:15px; line-height:18px; color:#3d3d3d; font-size:12px;" class=" article_content fl p10">
		                      <?php echo $cms_content['page_description']; ?>
		                </div>
	                </div>
                        <div class="auction-bl">
                        <div class="auction-br">
                        <div class="auction-bm">
                        </div>
                        </div>
                        </div>
	        <?php
                }
        }
        else
        {?>
        <h4 class="no_data fl clr"><?php echo __('no_page_found');?></h4>
        <?php 	}			
        ?>
</div>
</div>
