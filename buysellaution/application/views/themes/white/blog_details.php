<?php defined("SYSPATH") or die("No direct script access."); ?>

      <div class="dash_heads" id="blog_details_page">
        <ul>
          <li><a href="#" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
          <li><a href="#"><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
          <li class="active"><a href="#" title="News"><?php echo __('blog');?></a></li>
        </ul>
      </div>
     <?php include("auctions/left.php");?>
      <div class="banner_rgts">
        <div class="today_headss">
          <h2><?php echo __('blog');?></h2>
          <span class="arrow_oness">&nbsp; </span> </div>
        <div class="news_all" id="blog_details_page">
        <?php 
		if($blog_results)
		{
		foreach($blog_results as $blog_result):?>
          <div class="alls">
              <div class="uptors"><a title="<?php echo ucfirst($blog_result['blog_title']);?>"href="<?php echo URL_BASE;?>userblog/blog_inner/<?php echo $blog_result['blog_id'];?>"><?php echo ucfirst($blog_result['blog_title']);?></a>
              <p><?php echo date('F d Y  h:i A',strtotime($blog_result['created_date']));?></p>
            </div>
            <div class="news">
              <p><?php echo ucfirst($blog_result['blog_description']);?></p>
              <a href="<?php echo URL_BASE;?>userblog/blog_inner/<?php echo $blog_result['blog_id'];?>" title="<?php echo __('comments');?>(<?php  echo $blog_result['comments_count'] ?>)"  >
                                        <?php echo __('comments');?>(<?php  echo $blog_result['comments_count'] ?>)
                                    </a> 
            </div>
          </div>
          <?php endforeach;
          }
		else
		{ ?>
		<h4 class="no_data fl clr"><?php echo __("no_data");?></h4> <?php
		}?>
       
        
        </div>
        <div class="nauction_pagination">
	<?php if($blog_results > 0): ?>
	<p><?php echo $pagination->render(); ?></p>  
	<?php endif; ?>
	</div>
      </div>
    
