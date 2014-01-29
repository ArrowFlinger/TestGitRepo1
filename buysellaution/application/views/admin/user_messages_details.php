<?php defined('SYSPATH') OR die("No direct access allowed."); 


//For sort All jobs order status
//==============================
$sort_val = isset($srch["order_search"]) ? $srch["order_search"] :''; 

//For search sender list
//=======================
$sendername_list = isset($srch["sender_search"]) ? $srch["sender_search"] :'';

//For search receiver list
//=========================
$receiver_list = isset($srch["receiver_search"]) ? $srch["receiver_search"] :'';

//For search job
//===================
//$job_list = isset($srch["job_search"]) ? $srch["job_search"] :'';

//For CSS class deefine in the table if the data's available
$total_user_messages=count($all_user_messages_list);

$table_css=$export_excel_button="";
$table_css="";
if($total_user_messages > 0)
{  $table_css='class="table_border"';  }?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle" >
        <form method="post" class="admin_form" name="frmusermsgs" id="frmusermsgs" action="user_messages_search">
            <table class="list_table1 fl clr" border="0" width="100%" cellpadding="5" cellspacing="0">
                <tr>

					<td><label><?php echo __('from_label'); ?></label></td>
                    <td>
                       <select name="sender_search" id="sender_search">
							<option value=""><?php echo __('select_label'); ?></option>
				            <?php 
							 //code to display username drop down
								foreach($all_sender_list as $senderlist) { 
								$selected_sender="";  	
								$selected_sender=($senderlist['userid1']==trim($sendername_list)) ? " selected='selected' " : ""; 
								array_filter($senderlist);
							 ?>
						
                                <option value="<?php echo $senderlist['userid1']; ?>"  <?php echo $selected_sender; ?>><?php echo ucfirst($senderlist['buyername']);?></option>
							
							<?php }  ?>
                        </select>                

                    </td>
                     <td><label><?php echo __('to_label');?>
                   </label></td>
                    <td>
                    
                    <select name="receiver_search" id="receiver_search" >
                            <option value=""><?php echo __('select_label'); ?></option>
                            
				            <?php 
							 //code to display all active job drop down
							 //=====================================
								foreach($all_receiver_list as $receiverlist) { 
								$selected_receiver="";  	
								$selected_receiver=($receiverlist['userid']==trim($receiver_list)) ? " selected='selected' " : "";
								array_filter($receiverlist); 
							 ?>
                                <option value="<?php echo $receiverlist['userid']; ?>"  <?php echo $selected_receiver; ?>><?php echo ucfirst($receiverlist['sellername']);?></option>
							
							<?php } ?>


                        </select>
                             
                    

                    </td>                   
             
                </tr>
                <tr>
                    <td><label> <?php echo __('job_order');?></label></td>

                    <td>
							<input type="text" name="order_search" maxlength="30" id="order_search" value="<?php echo isset($srch['order_search']) ? trim($srch['order_search']) :'';  ?>" />
                    <?php /*  <select name="order_search" id="order_search">
                            <option value=""><?php echo __('select_label'); ?></option>
 						   		 <?php 
						   		 //Code to display sort all order   
						   		 //===============================
									
									foreach($all_job_order as $order) 
									{ 
										$selected_order="";  	
										$selected_order=($order['order_no']==trim($sort_val)) ? " selected='selected' " : ""; ?>
			                    		<option value="<?php echo $order['order_no']; ?>"  <?php echo $selected_order; ?>>
			                    			<?php echo $order['order_no'];?>
			                    		</option>
				
								<?php }?>                           

                        </select>--> */?>
                        <span class="search_info_label"><?php echo __('srch_info_order_keyword');?></span>
                        
                    </td> 								 
                    <td><label><?php // echo $job_settings[0]['alternate_name'];?></label></td>
                    <td>
                        <select name="job_search" id="job_search">
                            <option value=""><?php echo __('select_label'); ?></option>
                            
				            <?php 
						/*	 //code to display all active job drop down
							 //=====================================
								foreach($all_job_list as $joblist) { 

								$selected_job="";  	
								$selected_job=($joblist['id']==trim($job_list)) ? " selected='selected' " : ""; 
							 ?>
                                <option value="<?php echo $joblist['id']; ?>"  <?php echo $selected_job; ?>><?php echo ucfirst(commonfunction::replace_job_title($joblist['job_title']));?></option>
							
							<?php } */ ?>


                        </select>
                    </td>                    
             
                 </tr>
                 <tr>
		                <td colspan="4" style="padding-left:300px;">
		                   		<input type="submit" value="<?php echo __('button_search'); ?>" title="<?php echo __('button_search'); ?>" name="search_user_msg" />
                           		<input type="button" value="<?php echo __('button_cancel'); ?>" title="<?php echo __('button_cancel'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/user_messages'" />
                        </td>                    
                 </tr>
                 </table>
            
<div class="clr">&nbsp;</div>
<table cellspacing="1" cellpadding="10" align="center" width="100%" <?php echo $table_css; ?>>
<?php if($total_user_messages > 0){ ?>
	<!--** Job Order Listings Starts Here ** -->
                    <tr class="rowhead">
        		         <th align="left" width="5%"><?php echo __('Select'); ?></th> 
				 <th align="left" width="5%"><?php echo __('sno_label'); ?></th>
				 <th align="center" width="10%" colspan="2"><?php echo __('action_label'); ?></th>
				 <th align="left" width="20%"><?php echo __('subject'); ?></th>
				 <th align="left" width="20%"><?php echo __('product_title_label'); ?></th>
				 <th align="center" width="5%"><?php echo __('order_id_label'); ?></th>
				 <th align="left" width="10%"><?php echo __('from_label'); ?></th>
				 <th align="left" width="10%"><?php echo __('to_label'); ?></th>
				 <th align="center" width="15%"><?php echo __('date');?></th>

        </tr>    
        <?php 
         
         $sno=$offset; /* For Serial No */
         
         foreach($all_user_messages_list as $all_messages_list){
         
         $sno++;
         
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
		 $class=($all_messages_list['flag_status']== ACTIVE) ? "active" : "inactive"; 
		 $class1=($all_messages_list['senderstatus']== ACTIVE) ? " "."activeusr" : " "."inactiveusr";
		 //echo $class1;
		?>
        <tr class="<?php echo $trcolor; ?>">
                <td align="center">
                    <input type="checkbox" name="msg_chk[]" id="msg_chk<?php echo $all_messages_list['usrid'];?>" value="<?php echo $all_messages_list['usrid'];?>" class="<?php echo $class;?><?php echo $class1;?>" />
                </td>        
                <td align="left">
                    <?php echo $sno; ?>
                </td>
                <td align="center"> 
                <?php

                	 $class=$title=$user_status=$class1=$title1=$user_status1='';
                	 // if($all_messages_list['sendertype'] != ADMIN)
                	  		if(($all_messages_list['sendertype'] != ADMIN) && ($all_messages_list['senderstatus'] == ACTIVE)){$class = 'deactivate_user'; $title =__('deactivate_user'); $user_status = 1;$all_messages_list['sendertype']=1;
                	  		//echo "dfdsfdf";
		 						    echo $atag_start="<a  onclick='frmchangeusrstatus(".$all_messages_list['usrid'].','.$user_status.")' id='changeusrstatus' class='$class' title='$title'>";
							       echo $atag_end="</a>"; 	                               	  		
                	  		
                	  		}
                	  	 if(($all_messages_list['sendertype'] != ADMIN) && ($all_messages_list['senderstatus'] == IN_ACTIVE)){$class1 = 'activate_user'; $title1 =__('activate_user'); $user_status1 = 0;$all_messages_list['sendertype']=1;
						    echo $atag_start="<a  onclick='frmchangeusrstatus(".$all_messages_list['usrid'].','.$user_status1.")' id='changeusrstatus' class='$class1' title='$title1'>";
					       echo $atag_end="</a>"; 	                							
							  }           	  	

?>                	 </td>
<td><?php
                	 
                $class = 'flagicon'; $title =__('flag'); $flag_status = 0;
				        //change suggestion status flag/unflag
				        //====================================
		           		if($all_messages_list['flag_status']== ACTIVE){$class = 'clearflagicon'; $title =__('clear_flag'); $flag_status = 1;}
						    echo $atag_start="<a  onclick='frmchangestatus(".$all_messages_list['id'].','.$flag_status.")' id='changestatus' class='$class' title='$title'>";
					       echo $atag_end="</a>"; 	                
						?>

                </td>
                <td align="left">
                    <a href= "/inbox/viewmessages/<?php echo $all_messages_list['random_number'];?>" target="_blank"><?php echo $all_messages_list['subject'];?></a>
							<?php if($all_messages_list['flag_status']== ACTIVE){  ?>            
                    <span class="flagged"><?php echo __('flagged');?></span>
                    <?php }?>
                </td>   
                 <td align="left">
                  <a href="/userjobs/job_title/<?php //echo $all_messages_list['job_url'];?>"> <?php //echo commonfunction::replace_job_title($all_messages_list['job_title']); ?></a>
                </td>                               
                <td align="center">
                    <?php echo $all_messages_list['order_no']; ?>
                </td>  
      
      			          
                <td align="left">
                		

                   <a href="/userjobs/profile/<?php echo $all_messages_list['sendername'];?>"; title ="<?php echo $all_messages_list['sendername']; ?>"> <?php echo $all_messages_list['sendername']; ?></a>
                </td>

                <td align="left">
                   <a href="/userjobs/profile/<?php echo $all_messages_list['receivername'];?>"; title ="<?php echo $all_messages_list['receivername']; ?>"> <?php echo $all_messages_list['receivername']; ?></a>
                </td>                               

                <td align="center">
                    <?php echo wordwrap($all_messages_list['sent_date'],15,'<br/>',1); ?>
                </td>

        </tr>
		<?php } 
		 }
	// ** Job orders Listings Ends Here ** //
		 else { 
	// ** No Job orders is Found Means ** //
		?>
       	<tr>
        	<td class="nodata"><?php echo __('no_data'); ?></td>
        </tr>
        <?php } ?>

</table>
</form>
	</div>
	<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>	
<div class="clr">&nbsp;</div>
<!--Select All & More Actions Div -->
 <?php if($total_user_messages > 0){ ?>
<div>
    <div class="select_all">
        <!--<?php echo __('select_alone');?>--><b><a rel="group_1" href="#select_all">
        <?php echo __('all_label');?></a></b><span class="pr2 pl2">|</span><b><a rel="group_1" href="#select_none">
        <?php echo __('select_none');?></a> | <b><a href="" class="select-flagged"><?php echo __('flagged_label');?></a></b>
		   </b><span class="pr2 pl2">|</span><b><a href="" class="select-unflagged"><?php echo __('unflagged_label');?></a></b>
		   <span class="pr2 pl2">|</span><b><a href="" class="select-activatedusr"><?php echo __('activated_label');?></a></b>
		   <span class="pr2 pl2">|</span><b><a href="" class="select-inactivatedusr"><?php echo __('inactivated_label');?></a></b>
        <span style="padding-left:10px;">
            <select name="more_action" id="more_action">
                <option value=""><?php echo __('more'); ?></option>
                <option value="del" ><?php echo __('delete'); ?></option>
                <option value="flag"><?php echo __('flag');?></option>
                <option value="unflag"><?php echo __('clear_flag');?></option>
                <option value="active"><?php echo __('active_user_label');?></option>
                <option value="inactive"><?php echo __('inactive_user_label');?></option>
            </select>
         </span>
	</div>
</div>
<?php }?>
<!--Select All & More Actions Div -->
<?php if(($action != 'user_messages_search') && $total_user_messages > 0): ?>
 <p><?php echo $pag_data->render(); ?></p> 
 <p><?php //echo $pag_data->displayed(); 
 ?></p> 
<?php endif; ?>
<div class="clr">&nbsp;</div>

</div>
<script type="text/javascript" language="javascript">

	function selectToggle(toggle, form) {
		var myForm = document.forms[form];
		for( var i=0; i < myForm.length; i++ ) { 
		    if(toggle) {
		        myForm.elements[i].checked = "checked";
		    } 
		    else
		    { myForm.elements[i].checked = ""; }
		}
	}

	
	//function for flag message
	//===================================
	function frmchangestatus(message_id, flag_status)
	{


		switch (flag_status)
		{
			//if flag active means 
			//====================
			case 0:
			var answer = confirm("<?php echo __('flag_active_alert');?>")	
			break;
			//if clear flag means 
			//===================
			case 1:
			var answer = confirm("<?php echo __('clear_flag_alert');?>")
			break;				

	
		}
			if (answer){
				//redirect to manageusers controller for update status of flag
				//=============================================================
				window.location="<?php echo URL_BASE;?>manageusers/update_flag_status/"+"?id="+message_id+"&&flagstatus="+flag_status;
			}
	}
	//function for change user message
	//===================================
	function frmchangeusrstatus(sender_id,sender_status)
	{

		switch (sender_status)
		{
			//if sender active means 
			//====================
			case 1:
			var answer = confirm("<?php echo __('sender_status_deactive_alert');?>")	
			break;
			//if sender inactive means 
			//=======================
			case 0:
			var answer = confirm("<?php echo __('sender_status_active_alert');?>")
			break;				

	
		}
			if (answer){
				//redirect to manageusers controller for update sender status 
				//=============================================================
				window.location="<?php echo URL_BASE;?>manageusers/update_sender_status/"+"?id="+sender_id+"&&senderstatus="+sender_status;
			}
	}
	
	
	//for More action Drop Down
	//=========================
	$('#more_action').change(function() {

		//select drop down option value
		//======================================
		var selected_val= $('#more_action').val();

		//perform more action like delete,flag,unflag user message
		//========================================================
		switch (selected_val){
				//	Current Action "DELETE"
				//=========================
				case "del":
				var confirm_msg =  "<?php echo __('delete_alert_user_msg');?>";
				break;
				//	Current Action "FLAG"
				//=============================
				case "flag":
				var confirm_msg =  "<?php echo __('flag_active_alert');?>";
				break;
				//	Current Action "UNFLAG"	
				//===========================
				case "unflag":
				var confirm_msg =  "<?php echo __('clear_flag_alert');?>";
				break;
				
				//	Current Action "Active user"
				//=================================
				case "active":
				//()
				var confirm_msg =  "<?php echo __('sender_status_active_alert');?>";
				break;
				//	Current Action "InAcitve user"	
				//===================================
				case "inactive":
				var confirm_msg =  "<?php echo __('sender_status_deactive_alert');?>";
				break;
			}
	
			//Find checkbox whether selected or not and do more action
			//============================================================
			if($('input[type="checkbox"]').is(':checked'))
			{
		   		 var ans = confirm(confirm_msg)
		   		 if(ans){
					 document.frmusermsgs.action="<?php echo URL_BASE;?>manageusers/more_job_action/"+selected_val;
					 document.frmusermsgs.submit();
				 }else{
				 	$('#more_action').val('');
				 }

			}
			else{
			//alert for no record select
			//=============================
				alert("<?php echo __('alert_user_msg_select');?>")	
				$('#more_action').val('');
			}	
		
			return false;  
	});	
	</script>


