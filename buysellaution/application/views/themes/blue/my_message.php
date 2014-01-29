<?php defined("SYSPATH") or die("No direct script access.");
$read="read";
$unread="unread";
?>
<style>
.read{ background:#fff;}
.read font,.read span,.read a,.read p{ color:#333; font-weight:normal;}

.unread{ background:#D8d8d8;}
.unread font,.unread span,.unread a,.unread p{ color:#fff;}
</style>
<div class="content_left_out content_left_out1 fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('my_message');?>"><?php echo __('my_message');?></h2>   
        </div>
        </div>
        </div>
        <div class="deal-left clearfix">
	<div class="action_deal_list action_deal_list2 clearfix">
    	<div class="watch_list_items fl clr">
		<div id="managetable" class="fl clr">
		<?php if($count_user_message>0){ ?>
		<!--List for Messages-->
        <div class="table-left">
        <div class="table-right">
        <div class="table-mid">	
		<table width="100" border="0" cellpadding="0" cellspacing="0" class="table-top">
		        <tr>
		                <th align="center" width="193" style="padding:0"> <b><?php echo __('from_lable');?> </b></th>
		                <th width="152" align="center" style="padding:0"> <b><?php echo __('subject_lable');?></b></th>
		                <th  align="center" style="padding:0"> <b><?php echo __('message_lable');?> </b></th>
		                <th align="center" style="padding:0"> <b> <?php echo __('Delete');?> </b></th>
		        </tr>
                </table>
        </div>
        </div>
        </div>
        <table width="100" border="0" cellpadding="0" cellspacing="0" align="left">
		<?php 
		
		foreach($message_results as $message_result):
		 if($message_result['msg_type']==UNREAD){ $class="unread";$strong_open= "<strong>";$strong_close="</strong>";}
		else{ $class="read";$strong_open= "";$strong_close="";}?>		
		<tr class="cells <?php echo $class;?>" id="<?php echo $message_result['usermessage_id'];?>">		
		        <td width="193" style="padding:5px 0"><font class="user_email"><?php echo $strong_open.$message_result['usermessage_from'].$strong_close;?></font></td>
		        <td width="152" style="padding:5px 0" align="center">
		        <a href="<?php echo URL_BASE;?>users/my_message_details/<?php echo $message_result['usermessage_id'];?>" title="<?php echo $message_result['usermessage_subject'];?>" > <?php echo $strong_open.Text::limit_chars($message_result['usermessage_subject'],20).$strong_close;?></a>
		        </td>
		        <td style="padding:5px 0;" id="my_message_message_title" ><span class="message_title fl"><?php //echo $strong_open.Text::limit_chars(HTML::chars($message_result['usermessage_message']),5).$strong_close;?>
                        
                       <?php echo strip_tags(strlen($message_result['usermessage_message']))>35?ucfirst(Text::limit_chars(strip_tags($message_result['usermessage_message']),100))."...":ucfirst(strip_tags($message_result['usermessage_message']));?>   
                                                
                        </span>
		        </td>
		        <td align="center" style="padding:5px 0;"><a href="<?php echo URL_BASE;?>users/my_message/<?php echo $message_result['usermessage_id'];?>" onclick=" return confirmDelete('<?php echo __('are_you_sure_delete');?>');" title="<?php echo __('button_delete');?>" class="remove_link fl"><?php echo __('button_delete');?></a>
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

    </div>
    <div class="auction-bl">
    <div class="auction-br">
    <div class="auction-bm">
    </div>
    </div>
    </div>
    </div>

<script type="text/javascript">
//$(".cells").css({'background-color':'#f8f8f8','cursor':'pointer','color':'#fff!important'});
var msgarray=new Array();
var k=0;
function in_array(needle, haystack)
{
    for(var key in haystack)
    {
        if(needle === haystack[key])
        {
            return true;
        }
    }

    return false;
}


       
        $("#users_menu").addClass("fl active");$("#my_message_active").addClass("user_link_active");
</script>
