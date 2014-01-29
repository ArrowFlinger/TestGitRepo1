<?php defined("SYSPATH") or die("No direct script access."); ?>
	<div class="my_message_right" id="my_message_page">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('my_message'));?>"><?php echo __('my_message');?></h1>
		<p>&nbsp;</p>
	</div>
	<?php if($count_user_message>0){ ?>
	<div class="message_common">
		<div class="forms_common">
			<div class="title_cont_watchilist">
                       <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                           <thead>
                               <tr>
			<th width="60" align="center">
		<b><?php echo __('from_lable');?></b>
                       </th>
			<th width="100" align="center">
				<b><?php echo __('subject_lable');?></b>
                       </th>
			<th width="200" align="center">
				<b><?php echo __('message_lable');?></b>
                       </th>
			<th width="60" align="center">
				<b><?php echo __('Delete');?></b>
                       </th>
                       </tr>
                           </thead>
		
	<?php  foreach($message_results as $message_result): ?>
	
                    <tr>       
            
		<td width="60" align="center">
		<a><?php echo $message_result['usermessage_from'];?></a>		
                </td>
		<td width="100" align="center">
			<a href="<?php echo URL_BASE;?>users/my_message_details/<?php echo $message_result['usermessage_id'];?>" title="<?php echo $message_result['usermessage_subject'];?>" >                    
			<?php echo strlen($message_result['usermessage_subject'])>25?ucfirst(Text::limit_chars($message_result['usermessage_subject'],20))."...":ucfirst($message_result['usermessage_subject']);?>
                        </a>
                </td>
		<td width="200" align="center">
			<!--<h2><?php echo strlen(strip_tags(HTML::chars($message_result['usermessage_message'])))>35?ucfirst(Text::limit_chars(strip_tags(HTML::chars($message_result['usermessage_message'])),30))."...":ucfirst(strip_tags(HTML::chars($message_result['usermessage_message'])));?></h2>-->
                
                        <?php echo strip_tags(strlen($message_result['usermessage_message']))>35?ucfirst(Text::limit_chars(strip_tags($message_result['usermessage_message']),100))."...":ucfirst(strip_tags($message_result['usermessage_message']));?>     

		</td>
		<td width="60" align="center">
			<a href="<?php echo URL_BASE;?>users/my_message/<?php echo $message_result['usermessage_id'];?>" onclick=" return confirmDelete('<?php echo __('are_you_sure_delete');?>');" title="<?php echo __('button_delete');?>">
                            <img src="<?php echo IMGPATH;?>delet.png" alt="<?php echo __('button_delete');?>" border="0" />
                        </a>
		</td>
                     
            </tr>
	<?php endforeach; ?>
                  
                       </table>
	<?php }
			else
			{?>
				<div class="message_common">
					<h4 class=""><?php echo __("no_my_messages_auction_at_the_moment");?></h4> 
				</div>
			<?php 
			}?>
	<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
	</div>
	</div>
        </div>
	<!--Pagination-->
	<div class="nauction_pagination">
			<?php if($count_user_message > 0): ?>
			<p><?php echo $pagination->render(); ?></p>  
			<?php endif; ?>
	</div>
	<!--End of Pagination-->
	
	</div>
	</div>

	<script type="text/javascript">
	$(document).ready(function () {$("#my_message_active").addClass("act_class");});
	</script>
