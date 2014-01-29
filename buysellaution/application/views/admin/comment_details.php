<?php defined("SYSPATH") or die("No direct script access."); ?>
<?php echo $welcomestyle =Html::style('public/admin/css/admin_style.css'); ?>

<div class="msg_content_outer fl">
	<div class="msg_content_inner">
		<div class="msg_details_content fl clr">
            <div class="msg_details_title fl clr">
            
                <h2 class="fl clr pl10" title="<?php echo mb_convert_encoding(__('comments_details'),'utf-16','utf-8');?>"><?php echo mb_convert_encoding(__('comments_details'),'utf-16','utf-8') ;?></h2>
                </div>
            <div class="user_msg_list fl clr">
                    <div id="managetable" class="fl clr">
                     <?php 
                 if($message_results>0){ 
                 
                    foreach($message_results as $message_result):
                    ?> 
                      
            <div class="msg_detail_content fl">
                        <table width="760" border="0" align="left" cellpadding="10" cellspacing="0">
                            <tr>
                                <td width="740" align="left">
                                    <table width="740" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <p class="msg_from_detail fl clr"><b><?php echo __('username_label')."  :";?></b> <?php echo ucfirst($message_result['username_blog']);?></p>
                                                <p class="msg_from_detail fl clr mt5"><b><?php echo __('user_email')."  :";?></b> <?php echo $message_result['useremail'];?></p>                                    </td>
                                        </tr>
                                        <tr><td>
                                                    
                                                    <br><p class="msg_from_detail fl clr mt5"><b><?php echo __('user_description')."  :";?></b><br> <?php echo ucfirst($message_result['comment']);?></p>  </td></tr> 
                                         <tr><td>
                                                    
                                                    <br><p class="msg_from_detail fl clr mt5"><b><?php echo mb_convert_encoding(__('user_posted_date'),'utf-16','utf-8')."  :";?></b> <?php echo date('F d Y ',strtotime($message_result['created_date_blog']))."at ".date('h:i A',strtotime($message_result['created_date_blog']));?></p>  </td></tr>             
                                                
                                    </table>
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
