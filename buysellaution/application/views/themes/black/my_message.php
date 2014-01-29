<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl">
	<div class="title_temp1 fl clr pt10">
    	<h2 class="fl clr pl10" title="<?php echo __('my_message');?>"><?php echo __('my_message');?></h2>
        </div>
    	<div class="watch_list_items fl clr" id="my_message_page">
		<div id="managetable" class="fl clr">
		<?php if($count_user_message>0){ ?>
		<!--List for Messages-->
		<table width="100" border="0" cellpadding="0" cellspacing="0">
		<tr>
		<th  align="center"><?php echo __('from_lable');?></th>
		<th  width="150" align="center"><b><?php echo __('subject_lable');?></b></th>
		<th align="center"><b><?php echo __('message_lable');?></b></th>
		<th align="center"><b><?php echo __('actions');?></b></th>
		</tr>
		<?php 
		foreach($message_results as $message_result):
		 if($message_result['msg_type']==UNREAD){$strong_open= "<strong>";$strong_close="</strong>";}
		else{$strong_open= "";$strong_close="";}?>		
		<tr>		
		<td ><font class="user_email"><?php echo $strong_open.$message_result['usermessage_from'].$strong_close;?></font></td>
		<td align="center">
		<a href="<?php echo URL_BASE;?>users/my_message_details/<?php echo $message_result['usermessage_id'];?>"  style="color:#D9B213;" title="<?php echo $message_result['usermessage_subject'];?>" > <?php echo $strong_open.Text::limit_chars($message_result['usermessage_subject'],20).$strong_close;?></a>
		</td>
		<td><span class="message_title">
<?php //echo $strong_open.Text::limit_chars(HTML::chars($message_result['usermessage_message']),8).$strong_close;?>

                <?php echo strip_tags(strlen($message_result['usermessage_message']))>35?ucfirst(Text::limit_chars(strip_tags($message_result['usermessage_message']),100))."...":ucfirst(strip_tags($message_result['usermessage_message']));?>  
                </span>
		</td>
		<td align="center"><a href="<?php echo URL_BASE;?>users/my_message/<?php echo $message_result['usermessage_id'];?>" onclick=" return confirmDelete('<?php echo __('are_you_sure_delete');?>');" title="<?php echo __('button_delete');?>" class="remove_link"><?php echo __('button_delete');?></a>
		</td>		
		</tr>		
		<?php endforeach; ?>
		</table>
		<?php }
		else
		{
		?>
		<h4 class="no_data fl clr"><?php echo __("no_my_messages_auction_at_the_moment");?></h4> 
		<?php 
		}?>
		</div>
		<div class="clear"></div>
		<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	</div>
	</div>
<!--Pagination-->
<div class="pagination">
<?php if($count_user_message > 0): ?>
 <p><?php echo $pagination->render(); ?></p>  
<?php endif; ?>
</div>
<!--End of Pagination-->
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_message_active").addClass("user_link_active");});
</script>
