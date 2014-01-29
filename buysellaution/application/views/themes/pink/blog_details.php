<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="container_inner fl clr">
        <div class="title-left title_temp2">
        <div class="title-right">
        <div class="title-mid">
                <h2 class="fl clr" title="<?php echo __('view_blog');?>"><?php echo __('view_blog');?></h2>
        </div>
        </div>
        </div>
    <div class="deal_list  clearfix">
	<div id="managetable" class="blog_content_list fl clr">
		<ul class="fl pb20">
		<?php 
		if($blog_results)
		{
		foreach($blog_results as $blog_result):?>
                <li class="fl clr mt20">
                        <div class="blog_content fl">
                            <b class="blog_title  clr">
                                <a href="<?php echo URL_BASE;?>userblog/blog_inner/<?php echo $blog_result['blog_id'];?>" title="<?php echo ucfirst($blog_result['blog_title']);?>" >
                                    <?php echo ucfirst($blog_result['blog_title']);?>
                                </a>
                            </b>
                            <div class="blog_content clearfix">
                                <label class="fr blog_post_time mr10 mt5">
                                <?php echo date('F d Y  h:i A',strtotime($blog_result['created_date']));?>
                                </label>
                            </div>
                            <div class="blog_content mt10 clearfix"><?php echo ucfirst($blog_result['blog_description']);?></div>
                            <div class="testimonial_content ">
                                <b class="blog_command fl clr mt10">              
                                    <a href="<?php echo URL_BASE;?>userblog/blog_inner/<?php echo $blog_result['blog_id'];?>" title="<?php echo __('comments');?>(<?php  echo $blog_result['comments_count'] ?>)"  >
                                        <?php echo __('comments');?>(<?php  echo $blog_result['comments_count'] ?>)
                                    </a> 
                                </b>
                            </div>
                        </div>
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
	<?php if($blog_results > 0): ?>
	 <p><?php echo $pagination->render(); ?></p>  
	<?php endif; ?>
	</div>
    </div>
    <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
</div>
