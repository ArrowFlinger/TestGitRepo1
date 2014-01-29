<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('my_message');?>"><?php echo __('my_message');?></h2>
        </div>
        </div>
        </div>
    <div class="action_deal_list  clearfix">	 
    	<div class="watch_list_items fl clr">
		<div id="managetable" class="fl clr">
		<?php if($count_user_message>0){ ?>
		<!--List for Messages-->
	
		<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                    <thead>
                    <tr>
		<td width="200" align="center"><?php echo __('from_lable');?></td>
		<td width="200" align="center" ><b><?php echo __('subject_lable');?></b></td>
		<td width="200" align="center"><b><?php echo __('message_lable');?></b></td>
		<td width="200" align="center" ><b><?php echo __('Delete');?></b></td>
		</tr>
                </thead>

		
        
                        <?php 
                        foreach($message_results as $message_result):
                        ?>
                        <tr>
                                <td width="200" align="center"><p class="watch_list_title ">
                                <?php echo $message_result['usermessage_from'];?></p>
                                </td>
                                <td width="200" align="center"><p class="watch_list_title">
                                <a href="<?php echo URL_BASE;?>users/my_message_details/<?php echo $message_result['usermessage_id'];?>" title="<?php echo $message_result['usermessage_subject'];?>" > <?php echo Text::limit_chars(ucfirst($message_result['usermessage_subject']),5);?></a></p>
                                </td>
                                <td width="200" align="center">
								<p class="watch_list_title ">
                                <?php //echo Text::limit_chars(ucfirst(HTML::chars($message_result['usermessage_message'])),10);?>

                              <?php echo strip_tags(strlen($message_result['usermessage_message']))>35?ucfirst(Text::limit_chars(strip_tags($message_result['usermessage_message']),100))."...":ucfirst(strip_tags($message_result['usermessage_message']));?>   
                                
                                </p>
                                </td>
                                <td width="200" align="center"><a href="<?php echo URL_BASE;?>users/my_message/<?php echo $message_result['usermessage_id'];?>" onclick=" return confirmDelete('<?php echo __('are_you_sure_delete');?>');" title="<?php echo __('button_delete');?>" class="remove_link "><?php echo __('button_delete');?></a>
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
    <!--Pagination-->
<div class="pagination">
        <?php if($count_user_message > 0): ?>
        <p><?php echo $pagination->render(); ?></p>  
        <?php endif; ?>
</div>
<!--End of Pagination-->
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
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_message_active").addClass("user_link_active");});
</script>
