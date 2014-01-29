<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
<div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
        <div class="content_middle" >
    <!-- Open the facebook popup -->
<script type="text/javascript">
	var win2;
	function fbconnect(docroot)
	{
	  win2 = window.open(docroot+'facebook-connect.html',null,'width=650,location=0,status=0,height=400');
	  checkChild();  	
	}
	
	function checkChild() 
	{
		  if (win2.closed) {
			window.location.reload(true);
		  } else setTimeout("checkChild()",1);
	}
</script>    
    <!-- Facebook Profile -->
    <fieldset class="field field_content">         
        <legend class="legend title_legend"><?php echo __('facebook_account'); ?></legend>
        <?php 
         if(count($social_media_facebook)>0)
			{
     		foreach($social_media_facebook as  $social_account)
			{
			   
				?>
                    <table cellpadding="5" cellspacing="5">
                    <tr>
                    <td valign="top">
                    <img src="<?php echo $social_account['image_url'];?>" alt="<?php echo $social_account['first_name'];?>" title="<?php echo $social_account["first_name"];?>"/>
                    </td>
                    <td valign="top">
                    	<p><?php echo $social_account["first_name"];?></p>
                        <p><?php echo $social_account["email_id"];?> </p>
                        <p><?php echo __('updated_on'); ?><?php echo $social_account["cdate"];?></p>
                        <p><a href="<?php echo URL_BASE;?>socialnetwork/deletefacebook/?acc_id=<?php echo $social_account['id'];?>" title="<?php echo  __('remove_facebook_account'); ?>" class="fbook_cancel_link"><?php echo __('remove_facebook_account'); ?></a></p>
                    </td>
                    </tr>
                    </table>
                <?php 
                   }
		}
		else
		{
		?>
	            <a href="<?php echo URL_BASE;?>socialnetwork/addfacebook"  title="<?php echo __('add_facebook_account'); ?>" class="fbook_cancel_link"><?php echo __('add_facebook_account'); ?></a>
        <?php } ?>
	</fieldset>

	<!-- twitter account -->
		<!-- <fieldset class="field field_content">         
		<legend class="legend title_legend"><?php echo __('twitter_account'); ?></legend> 
		<?php 
		if($social_media>0)
		{
			foreach($social_media as  $social_account)
			{
			?>
			<table cellpadding="5" cellspacing="5">
			<tr>
			<td valign="top">
			<img src="<?php echo $social_account['image_url'];?>" alt="<?php echo $social_account['first_name'];?>" title="<?php echo $social_account['first_name'];?>"/>
			</td>
			<td valign="top">
			<p><?php echo $social_account["first_name"];?></p>
			<p><?php echo __('updated_on'); ?><?php echo $social_account["cdate"];?></p>
			<p><a href="<?php echo DOCROOT;?>system/modules/twitter/delete_account.php?acc_id=<?php echo $social_account['id'];?>" title="<?php echo __('remove_twitter_account'); ?>" class="fbook_cancel_link"><?php echo __('remove_twitter_account'); ?></a></p>
			</td>
			</tr>
			</table>
			<?php 
			}
		}
		else
		{
		?>
		<a href="<?php echo URL_BASE;?>socialnetwork/addtwitter" title="<?php echo __('add_twitter_account'); ?>" class="fbook_cancel_link"z><?php echo __('add_twitter_account'); ?></a>
		<?php } ?>
	</fieldset> -->
      </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
</div>

</div>
<script type="text/javascript">
$(document).ready(function(){
      toggle(8);
});
</script>
