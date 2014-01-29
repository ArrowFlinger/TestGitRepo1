<?php defined("SYSPATH") or die("No direct script access."); ?>
<div class="my_message_right" id="message_details_page">
	<div class="message_common_border">
		<h1 title="<?php echo strtoupper(__('my_message_details'));?>"><?php echo strtoupper(__('my_message_details'));?></h1>
	<p>&nbsp;</p>
	</div>
	<?php if($message_results>0){ 
	foreach($message_results as $message_result):
	?> 
	<div class="message_common">
	<div class="forms_common">
		<div class="title_cont">
		<div class="subject_msg_details">
			<h2><?php echo __('sub:');?> <?php echo $message_result['usermessage_subject'];?></h2>
			</div>
		</div>
		<div style="float:left;">
			<div class="form_new" style="width:95%;padding:5%">
				<?php 
				if(($message_result['photo'])!="" && file_exists(DOCROOT.USER_IMGPATH.$message_result['photo']))
				{ 
					$user_img_path=URL_BASE.USER_IMGPATH.$message_result['photo'];
				}
				else
				{	
					$user_img_path=IMGPATH.USER_NO_IMAGE2;					
				}
				?>
				<div id="uimg"><img src="<?php echo $user_img_path;?>" alt="User Name"  width="40" height="40" /></img>	</div>			
				<div id="ufrom"><br><br>
					<?php echo $site_settings[0]['site_name']; ?> 
					<?php echo __('from_label');?>:<?php echo $message_result['usermessage_from'];?><br/>
					<?php echo __('to_label');?>: <?php echo $message_result['usermessage_to'];?>
				</div><br><br>
				<div id="dat"><?php echo date('d-M-Y ',strtotime($message_result['sent_date'])).date(' h:i A',strtotime($message_result['sent_date']));?></div><br><br>
				<div id="usrn"><?php echo __('dear');?> <?php echo $message_result['username'];?></div><br><br>
				<div id="usrmsg"><?php echo $message_result['usermessage_message'];?></div>			
			</div>
		</div>
		 <div class="user" style="display:none;" ><?php echo $auction_userid;?></div>
		</div>
		</div></div>
	<?php break; endforeach; ?>
        <?php }
        else
        {?>
        <div class="message_common">
        <h4 class="no_data fl clr"><?php echo __("no_my_messages_auction_at_the_moment");?></h4> 
        </div>
        <?php 
        }?>
	</div>
		<div class="grand_total_btn_md" id="message_details_page_back">
			<div class="res_left"> </div>
			<div class="res_mid"><a href="<?php echo URL_BASE;?>users/my_message" title="<?php echo strtoupper(__('back_link'));?>" class="back_link fr"><?php echo strtoupper(__('back_link'));?></a>
		</div>
		<div class="res_right"></div>
		</div> 
	<script type="text/javascript">
	$(document).ready(function () {$("#my_message_active").addClass("act_class");});
	</script>
