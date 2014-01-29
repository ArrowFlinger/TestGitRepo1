<?php defined('SYSPATH') OR die('No direct access allowed.'); 
$total_count=count($page_data);
?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
<?php if($total_count > 0){ ?>    
    <h2><?php echo $page_data['page_title'];?></h2>
	<p><?php echo $page_data['page_description'];?></p>
<?php } else { ?>

					        	<?php echo __('no_data'); ?>

					        <?php } ?>      	
	
    </div>
    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
      toggle(8);
});
</script>
