<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="content_left_out fl">
<div class="action_content_left fl">
        <div class="title-left title_temp1">
        <div class="title-right">
        <div class="title-mid">
        <h2 class="fl clr pl10" title="<?php echo __('my_referral');?>"><?php echo __('my_referral');?></h2>
        </div>
        </div>
        </div>
     <div class="action_deal_list  clearfix">
	<div class="watch_list_items fl clr">
		<div id="managetable" class="fl clr">
		<?php if($count_referrals>0){ 
		?>
		<!--List products-->
		<?php 
		$ids=array_filter(explode(",",$referrals[0]['friends_ids']));
		if(count($check_status)>0)
		{
			$status_ids=array_filter(explode(",",$check_status[0]['friend_ids']));
		}
		else
		{
			$status_ids[]="";
		}
		?>
        <div class="table-left">
        <div class="table-right">
        <div class="table-mid">
		<table width="660" border="0" align="left" cellpadding="0" cellspacing="0" class="table-top">
		        <tr>
		                <td width="150" align="left"><?php echo __('friend_image');?></td>
		                <td width="200" align="center"><b><?php echo __('Name');?></b></td>
		                <td width="100" align="center"><b><?php echo __('status_label');?></b></td>
		        </tr>
                </table>
        </div>
        </div>
        </div>
	<?php $i=1;foreach($ids as $id):?>
        <script type="text/javascript">
	        $.getJSON("https://graph.facebook.com/<?php echo $id;?>",function(data){
		        $(".name"+"<?php echo $i;?>").html(data.name);
	        });
        </script>
        <table width="660" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr>
                        <td align="center" width="50">
                        <img src="https://graph.facebook.com/<?php echo $id;?>/picture" class="fl" title="" alt="" align="center"/>
                        </td>
                        <td align="center" class=""><p class="watch_list_title  name<?php echo $i;?>">--</p></td>
                        <td align="center" width="100" class=""><p class="watch_list_title">
                        <?php 
                        if(count($status_ids)>0){
                                if(is_array($status_ids) && in_array($id,$status_ids))
                                {
                                        echo __("accepted");
                                }
                                else
                                {
                                        echo __("pending");
                                }
                        }	
                        else
                        {
                                echo __("pending");
                        }
                        ?>
                        </p></td>
                </tr><?php $i++; endforeach; ?>
        </table>
	<?php }
	else
	{
	?>
	<h4 class="no_data fl clr"><?php echo __("no_friends_invited_at_the_moment");?></h4> 
	<?php 
	}?>
	</div>
    <?php echo $include_facebook;
	$ids=json_encode(isset($exclude_ids)?explode(",",substr($exclude_ids,0,-1)):array());
	?>
        <div class="clear"></div>
                <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
                </div>
                        <div class="add_bill_address fl pt10" style="padding:10px 10px 10px 20px;margin-left:200px;">
                                <span class="add_address_left fl">&nbsp;</span>
                                <span class="add_address_middle fl">
                               <a href="javascript:;" title="<?php echo __('send_invitation');?>" class="fl" onclick='Auction.sendRequestViaMultiFriendSelector({"exclude_ids":<?php echo $ids;?>,"invite_text":"<?php echo FB_INVITE_TEXT;?>"}); return false;'> <?php echo __('send_invitation');?></a>
                                </span>
                                <span class="add_address_left add_address_right fl">&nbsp;</span>
                        </div>
        </div>
        <div class="auction-bl">
        <div class="auction-br">
        <div class="auction-bm">
        </div>
        </div>
        </div>
	</div>
        <!--Pagination-->
        <div class="pagination fl">
        </div>
        <!--End of Pagination-->
</div>
<script type="text/javascript">
$(document).ready(function () {$("#users_menu").addClass("fl active");$("#my_pending_active").addClass("user_link_active");});
</script>
