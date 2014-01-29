<?php defined("SYSPATH") or die("No direct script access."); ?>
	<div class="dash_heads">
		<ul>
			<li><a href="<?php echo URL_BASE;?>" title="<?php echo __('menu_home');?>"><?php echo __('menu_home');?></a></li>
			<li><a href=""><img src="<?php echo IMGPATH;?>arr_bg.png" width="13" height="11" alt="Arrow" /></a></li>
			<li class="active"><a title="<?php echo __('menu_news');?>"><?php echo __('menu_news');?></a></li>
		</ul>
	</div> 
<?php include("auctions/left.php");?>
	<div class="banner_rgts" id="news_details_page" >
		<div class="today_headss">
		  <h2 title="<?php echo strtoupper(__('view_news'));?>"><?php echo strtoupper(__('view_news'));?></h2>
		  <span class="arrow_oness">&nbsp; </span> </div>
		<div class="news_all">
	
	<?php  if($news_results)
	{
		foreach($news_results as $news_result):?>
		<div class="alls">
			<div class="uptors"><span style="width:60%;float:left;" title="<?php echo ucfirst($news_result['news_title']);?>">
				<?php echo ucfirst($news_result['news_title']);?></span>
				<p style="width:38%;float:left;text-align:right;"><?php echo $news_result['created_date'];?></p>
			</div>
			<div class="news">
				<p><?php echo ucfirst($news_result['news_description']);?></p>
			</div>
			</div>
		<?php endforeach;?>
	
		<?php
	}
	else
	{ ?>
	<div style="margin:20px;">
		<div class="message_common" style="width:649px;">
			<h4 class="no_data fl clr"><?php echo __("no_data");?></h4> 
		
	<?php
	}
	?>
	</div>
	<div class="nauction_pagination">
	<?php if($news_results > 0): ?>
	<p><?php echo $pagination->render(); ?></p>  
	<?php endif; ?>
	</div>
			</div>
	

	</div>	
</div>
    </div>
   </div>
  </div>
</div></div>
<script type="text/javascript">
$(document).ready(function () {$("#news_menu").addClass("fl active");});
</script>
