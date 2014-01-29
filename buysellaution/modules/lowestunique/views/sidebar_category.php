<?php echo $css_script;?>
<div >
        <div class="gtop_l fl"></div>
        <div class="gtop_m fl"></div>
        <div class="gtop_r fl"></div>
</div>
<div class="gmid fl">
<!--search box-->
<div class="search fl">
<form action="/userjobs/search/" id="user_search" name="user_search" method="get">
		  <table cellspacing="0">
		    <tr>
		      <td>
		    <div class="text_left"></div>
		        <?php 
		        $searchValue = isset($_GET["search"])?$_GET["search"]:'Search';
		        ?>
			<span class="search_bg fl"><input type="text" value="<?php echo $searchValue; ?>" name="search" class="text_mid fl" onfocus="if (this.value=='Search') this.value='';" onblur="if (this.value=='') this.value='Search'" maxlength="300" /></span>
		<a onclick="document.user_search.submit()" class="fl" title="<?php echo __('search_label');?>"><img src="/public/images/search_button.png" width="28" height="26" alt="<?php echo __('search_label');?>" border="0" class="fl" /></a>  
			</td>
		    </tr>
		  </table>
		</form>
</div>
<!--search box end-->
    <?php if(count($job_categories) > 0)
    { 
	?>
   <ul>
        <?php 
        foreach($job_categories as $job_category){ 
//print_r($job_category);
		if(isset($cat_id))
			$selected_cat=$cat_id;
		else
			$selected_cat=RECENT_CAT;
        ?>
        <li ><a title="<?php echo $job_category['category_name'];?>" href="/category/pages/<?php echo $job_category['category_id'];?>" <?php echo ($selected_cat==$job_category['category_id'])?'class="active"':'';?> ><?php echo ucwords(Commonfunction::GetSubString($job_category['category_name'],LIMIT_SIDEBAR_CATEGORY));?></a></li>
        <?php } ?>        
        <!-- <li><a href="#">Other</a></li> -->
  </ul>
  <?php
  }else{
        echo __("category_not_found");
  }?>
</div>
<div class="gbot fl">
        <div class="gbot_l fl"></div>
        <div class="gbot_m fl"></div>
        <div class="gbot_r fl"></div>
</div>
        
