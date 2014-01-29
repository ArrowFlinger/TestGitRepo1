<?php defined("SYSPATH") or die("No direct script access."); ?>
<?php echo $welcomestyle =Html::style('public/admin/css/admin_style.css'); ?>
<div class="msg_content_outer fl">
	<div class="msg_content_inner">
		<div class="msg_details_content fl clr">
            <div class="msg_details_title fl clr">
                 <h2 class="fl clr pl10" title="<?php echo mb_convert_encoding(__('message_details'),'utf-16','utf-8');?>"><?php echo mb_convert_encoding(__('message_details'),'utf-16','utf-8');?> </h2> 
               <!-- <h2 class="fl clr pl10" title="<?php echo __('message_details');?>"><?php echo __('message_details');?> </h2> -->
                
            </div>
    		<div class="user_msg_list fl clr">
	        <div id="managetable" class="fl clr">
	         <?php 
		 if($message_results>0){ 
	        foreach($message_results as $message_result):
	        ?> 
			<div class="msg_detail_title fl">
					 <b><?php echo mb_convert_encoding(__('sub'),'utf-16','utf-8');?> <?php echo $message_result['usermessage_subject'];?></b> 
					<!-- <b><?php echo __('sub');?> <?php echo $message_result['usermessage_subject'];?></b> -->
           		 </div>   
	<div class="msg_detail_content fl">
            	<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                	<tr>
                    	
                        <td width="565" align="right">
                        	<table width="565" border="0" cellpadding="5" cellspacing="0">
                            	<tr>
                                	<td>
                                    	<p class="msg_from_detail fl clr"><b><?php echo __('auctions_team');?></b> <?php echo $message_result['usermessage_from'];?></p>
                                        <p class="msg_from_detail fl clr mt5">to <?php echo $message_result['usermessage_to'];?></p>                                    
                                      </td>
                                </tr>
                                <tr>
                                	<td>
                                    	<p class="msg_from_detail fl clr mt20">
                                        </td>
                                </tr>
                                <tr>
                                	<td>
                                        <p class="msg_from_detail">	<?php echo $message_result['usermessage_message'];?> </p>
                                        </p>
                                        <p class="msg_from_detail">	<?php echo "Date & Time :".date('d-M-Y ',strtotime($message_result['sent_date'])).date(' h:i A',strtotime($message_result['sent_date']));?> 
                                        </p>
                                        <!--THANKS AND REGADS-->
                                        <p class="regards_detail fl clr mt20">
                                        	<span><?php echo __('thanks_and_regards');?></span><br />
                                            <strong><?php echo __('auctions_team');?></strong>
                                        </p>
                                    </td>
                                </tr>	
                            </table>
                        </td>
                        <td width="25" valign="top" align="left">
				<?php 
				
				//code to remove or delete photo link
						$user_image_path=ADMINIMGPATH.NO_IMAGE;
						$light_box_class=$delete_link=$atag_start=$atag_end="";
						$image_title=__('no_photo');
						//check if file exists or not
						if(((isset($message_result)) && $message_result['photo']) && (file_exists(DOCROOT.USER_IMGPATH.$message_result['photo'])))
				        {
				                   $user_image_path = URL_BASE.USER_IMGPATH.$message_result['photo'];
				                   $atag_start='<a href='.$user_image_path.' title='.$image_title.'>';
						   $atag_end='</a>';
						 }
                                        ?>
                		<img src="<?php echo $user_image_path;?>" alt="User Name" width="100" height="100" class="fl mt3 msg_user_icon"/>        
                        </td>
                    </tr>
                </table>
                
               
            </div>
		
 <?php endforeach; ?>
		<?php }
	        ?>
	       	                
	        </div></div>
		</div>
	</div>
</div>
