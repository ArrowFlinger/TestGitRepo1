<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('my_referral'));?>"><?php echo strtoupper(__('my_referral'));?></h1>
	<p>&nbsp;</p>
	</div>
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
	<div class="message_common"  >
		<div class="forms_common"  >
			<div class="title_cont_watchilist">
                                           <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="table-top">
                      
                        <thead>
                            <tr>
                                <th width="100" align="center"><b><?php echo __('friend_image');?></b></th>
                                  <th width="100" align="center"><b><?php echo __('Name');?></b></th>
                                     <th width="100" align="center"><b><?php echo __('status_label');?></b></th>
                                    
                               
                            </tr>
                        </thead>   

		<?php $i=1;foreach($ids as $id):?>
		<script type="text/javascript">
					$.getJSON("https://graph.facebook.com/<?php echo $id;?>",function(data){
						$(".name"+"<?php echo $i;?>").html(data.name);
					});
				</script>  
                                
		<tr>
			<td width="100" align="center">
				<h3><img width="100" height="100" src="https://graph.facebook.com/<?php echo $id;?>/picture" title="" alt="" align="center"/></h3>
			</td>
			<td width="100" align="center">
			<h2><p class="watch_list_title  name<?php echo $i;?>">--</p></h2>
			</td>
            
			<td width="100" align="center">
			<h2><?php if(count($status_ids)>0){
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
				?></h2>
		</td>

	
		<?php $i++; endforeach; ?>
	</tr>
                                           </table>
		</div>
			<?php }
			else
			{
			?>
			<div class="message_common">
			<h4><?php echo __("no_friends_invited_at_the_moment");?></h4> 
			</div>
			<?php 
			}?>
			<?php echo $include_facebook;
			$ids=json_encode(isset($exclude_ids)?explode(",",substr($exclude_ids,0,-1)):array());
			?>

		</div>

		  <div class="clear"></div>
						<div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
						
						
				

		<div class="login_middle_common_profil">
			<div class="grand_total_btn">
					<div class="fl">
				
						<span class="ora_btn_lft">&nbsp;</span>
						<span class="ora_btn_mid">
						  <a href="javascript:;" title="<?php echo strtoupper(__('send_invitation'));?>" class="fl" onclick='Auction.sendRequestViaMultiFriendSelector({"exclude_ids":<?php echo $ids;?>,"invite_text":"<?php echo FB_INVITE_TEXT;?>"}); return false;'> 
						
						<?php echo strtoupper(__('send_invitation'));?></a></span>
						<span class="ora_btn_rgt">&nbsp;</span>
					</div>
			</div>
			</div>
			
			
			</div>
		</div>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function () {$("#my_pending_active").addClass("act_class");});
</script>
