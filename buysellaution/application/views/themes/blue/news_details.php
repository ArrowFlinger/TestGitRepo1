<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="container_inner fl clr">
    <!--Right Sidebar Start-->
<?php include("auctions/right.php");?>
<!---Right Side bar End--->
<div style="width:680px; float:left;">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr" title="<?php echo __('view_news');?>"><?php echo __('view_news');?></h2> 
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
        <div class="action_deal_list clearfix" style="width:670px;">
        <div id="managetable" class="news_list fl clr">
		<ul class="fl pb20">
		<?php 
		if($news_results){
		foreach($news_results as $news_result):?>
		
		<li class="fl clr">
        	<b class="fl clr news_title"><?php echo ucfirst($news_result['news_title']);?></b>
            <span class="fl clr news_posted_time mt10">
                <?php echo $news_result['created_date'];?>
            </span>
            <div class="news_posted_command fl clr mt10">
             	<?php echo ucfirst($news_result['news_description']);?>
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
	<?php if($news_results > 0): ?>
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

</div>

<script type="text/javascript">
$(document).ready(function () {$("#news_menu").addClass("fl active");});
</script>
