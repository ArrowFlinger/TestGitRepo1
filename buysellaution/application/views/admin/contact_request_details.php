<?php defined('SYSPATH') OR die("No direct access allowed."); 

//For CSS class define in the table if the data's available
//===========================================================
$total_contact_requests=count($all_contact_requests_list);

$table_css="";
if($total_contact_requests > 0)
{  $table_css='class="table_border"';  }?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmcontactreq" id="frmcontactreq">
			<div class="clr">&nbsp;</div>
			<div <?php if($total_contact_requests > 0){ ?>class= "overflow-block"<?php }?>> 
			<table cellspacing="1" cellpadding="20" align="center" width="170%" <?php echo $table_css; ?>>
			<?php if($total_contact_requests > 0){ ?>
			<!--** Contact Request Listings Starts Here ** -->
				<tr class="rowhead">
						<th align="left" width="5%"><?php echo __('Select'); ?></th> 
						<th align="left" width="2%"><?php echo __('sno_label'); ?></th>
						<th align="center" width="6%"><?php echo __('action_label'); ?></th>
						<th align="center" width="12%"><?php echo __('created_date');?></th>
						<th align="left" width="10%"><?php echo __('username_label'); ?></th>
						<th align="left" width="20%"><?php echo __('email_label'); ?></th>
						<th align="left" width="20%"><?php echo __('subject_label'); ?></th>
						<th align="left" width="20%"><?php echo __('message_label'); ?></th>
						<th align="left" width="10%"><?php echo __('telephone_label'); ?></th>
						<th align="left" width="30%"><?php echo __('ip_address'); ?></th>

       			 </tr>    
				<?php 
				 
				 $sno=$offset; /* For Serial No */
				 
				 foreach($all_contact_requests_list as $all_contact_requests){
				 
				 $sno++;
				 
				 $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
				 
				?>
				<tr class="<?php echo $trcolor; ?>">
                <td align="center">
                    <input type="checkbox" name="contact_chk[]" id="contact_chk<?php echo $all_contact_requests['id'];?>" value="<?php echo $all_contact_requests['id'];?>" />
                </td>
                <td align="center">
                    <?php echo $sno; ?>
                </td>
                <td>
                    <?php echo '<a  onclick="frmdel_contact('.$all_contact_requests['id'].');" class="deleteicon"  style="float:left; padding:10px;" title='.__('delete_label').'></a>'; ?>
                     <?php echo '<a  onclick="frmrply_contact('.$all_contact_requests['id'].');" class="replyicon" title='.__('reply_lable').'></a>'; ?>
                </td>

                <td align="center">
                    <?php echo wordwrap($all_contact_requests['request_date'],15,'<br/>',1); ?>
                </td>

               
               <td align="left">
                  <?php echo ucfirst($all_contact_requests['name']);?>
                </td>               
                <td align="left">
                   <?php echo $all_contact_requests['email']; ?>
                </td>
                 <td align="left">
                   <?php if($all_contact_requests['subject']){echo __('other_label')." / ".$all_contact_requests['subject'];}else{ echo $all_contact_requests['subject1'];} ?>
                </td> 
                 <td align="left">
                 <?php echo Text::limit_chars($all_contact_requests['message'],25);?>
                 
                </td> 
                  <td align="left">
                   <?php echo $all_contact_requests['telephone']; ?>
                </td>                                              
                <td>
                   <?php echo $all_contact_requests['ip']; ?>
                </td>


        </tr>
		<?php } 
		 }
	// ** Contact Request Listings Ends Here ** //
		 else { 
	// ** Contact Request is Found Means ** //
		?>
       	<tr>
        	<td class="nodata"><?php echo __('no_data'); ?></td>
        </tr>
        <?php } ?>

</table>
</div>

</form>
	</div>
	<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>	
<div class="clr">&nbsp;</div>
<!--Select All & More Actions Div -->
 <?php if($total_contact_requests > 0){ ?>
<div>
    <div class="select_all">
       <b> <a href="javascript:selectToggle(true, 'frmcontactreq');" title="<?php echo __('all_label');?>"><?php echo __('all_label');?></a></b> |<b> <a href="javascript:selectToggle(false, 'frmcontactreq');" title="<?php echo __('select_none');?>"><?php echo __('select_none');?></a></b>
        <span style="padding-left:10px;">
            <select name="more_action" id="more_action">
                <option value=""><?php echo __('more_label'); ?></option>
                <option value="del" ><?php echo __('delete_label'); ?></option>
            </select>
         </span>
	</div>
</div>
<?php }?>
<!--Select All & More Actions Div -->
<div class="pagination">
<?php if($total_contact_requests > 0): ?>
 <p><?php echo $pag_data->render(); ?></p>  
<?php endif; ?>
</div>
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
	//For replying contact request 
	//============================
	function frmrply_contact(req_id)
	{
	   window.location="<?php echo URL_BASE;?>manageusers/auto_reply_contact_request/"+req_id;
		//return false;  
	} 
	
	function frmdel_contact(req_id)
	{
	  var answer = confirm("<?php echo __('delete_alert_contact_request');?>")
		if (answer){
		    window.location="<?php echo URL_BASE;?>manageusers/contact_request_delete/"+req_id;
		}
		
		return false;  
	}
	
	//for More action Drop Down
	//=========================
	$('#more_action').change(function() {

		//select drop down option value
		//======================================
		var selected_val= $('#more_action').val();
	
		//perform more action contact request delete
		//============================================
		if(selected_val){
				var confirm_msg =  "<?php echo __('delete_alert_contact_request');?>";
				//Find checkbox whether selected or not and do more action
				//============================================================
				if($('input[type="checkbox"]').is(':checked'))
				{
			   		 var ans = confirm(confirm_msg)
			   		 if(ans){
						 document.frmcontactreq.action="<?php echo URL_BASE;?>manageusers/contact_request_delete/"+"?type="+selected_val;
						 document.frmcontactreq.submit();
					 }else{
					 	$('#more_action').val('');
					 }

				}
				else{
				//alert for no record select
				//=============================
					alert("<?php echo __('alert_contact_request_select');?>")	
					$('#more_action').val('');
				}				

			}
			return false;  
	});

$(document).ready(function(){
      toggle(2);
});

</script>


