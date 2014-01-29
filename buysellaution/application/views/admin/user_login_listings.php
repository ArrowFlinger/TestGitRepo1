<?php defined('SYSPATH') OR die("No direct access allowed."); 

   //Check the User Login IP's
   //=========================
   $user_loginip_count=count($all_user_login_list);

   $table_css="";
   if($user_loginip_count>0)
   {  $table_css='class="table_border"';  }
   

//For Notice Messages
//===================
$sucessful_message = Message::display();

if($sucessful_message) { ?>
    <div id="messagedisplay" class="padding_150">
         <div class="notice_message">
            <?php echo $sucessful_message; ?>
         </div>
    </div>
<?php } ?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmusers" id="frmusers" action="user_loginip_search">
            <table class="list_table1 fl clr" border="0" width="90%" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top"><label class="line_hgt24"><?php echo __('keyword_label'); ?></label></td>
                    <td><input type="text" name="search_username" maxlength="256" id="search_username" value="<?php echo isset($srch['search_username']) ? trim($srch['search_username']):''; ?>" />
                  	 <span class="search_info_label"><?php echo __('srch_info_login_keyword');?></span>
                    </td>
                     
                    <td  valign="top" style="padding:5px 0px;">
                        <input type="submit" value="<?php echo __('button_search'); ?>" name="search_loginip" title="<?php echo __('button_search'); ?>" />
						</td>
						<td valign="top" style="padding:5px 0px;width:50px;">
                        <input type="button" value="<?php echo __('button_cancel'); ?>" title="<?php echo __('button_cancel'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/loginlistings'" />
                    </td>
                </tr>
            </table>

<div class="clr">&nbsp;</div>
<?php if($user_loginip_count > 0){?>
<!--<div class= "overflow-block">-->
<?php }?>

<table cellspacing="1" cellpadding="5" width="100%" align="center" <?php echo $table_css; ?>>

<?php if($user_loginip_count > 0){ ?>

	<tr class="rowhead">
		<th align="left" width="8%"><?php echo __('Select'); ?></th>
        <th align="left" width="10%" colspan="1"><?php echo __('action_label'); ?></th>
		<th align="left" width="10%"><?php echo __('User Name'); ?></th>
		<th align="left" width="10%"><?php echo __('Login Time'); ?></th>

		<th align="left" width="10%"><?php echo __('User login IP'); ?></th>
		<th align="left" width="50%"><?php echo __('User agent'); ?></th>
	</tr>
		<?php

         $sno=$Offset; /* For Serial No */

		 foreach($all_user_login_list as $listings) {

		 $sno++;
        
         //For Odd / Even Rows
         //===================
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr';       
		
        ?>     

        <tr class="<?php echo $trcolor; ?>">

			<td width="8%" align="center"><input type="checkbox" name="user_login_chk[]" id="user_login_chk<?php echo $listings['id'];?>" value="<?php echo $listings['id'];?>" /></td>
			
			<td width="10%" align="center"><?php echo '<a  onclick="frmdel_user('.$listings['id'].');" class="deleteicon" title="Delete"> </a>'; ?></td>
            <td width="15%"><?php echo ucfirst($listings['username']);
 ?></td>
			<td width="12%"><?php echo $listings['last_login']; ?></td>
			<td width="20%"><?php echo $listings['login_ip']; ?></td>
			<td><?php echo $listings['user_agent']; ?></td>
		</tr>
		<?php } 
		 } 
		 else { 
		?>
       	<tr>
        	<td class="nodata"><?php echo __('no_data'); ?></td>
        </tr>
        <?php } ?>
</table>
<?php if($user_loginip_count > 0){?>
</div>
<?php }?>
</form>
</div>
<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
<div class="clr">&nbsp;</div>
<!--Select All & More Actions Div -->
 <?php if($user_loginip_count > 0){ ?>
<div>
    <div class="select_all">
         <b><a href="javascript:selectToggle(true, 'frmusers');"><?php echo __('all_label');?></a></b> | <b><a href="javascript:selectToggle(false, 'frmusers');"><?php echo __('select_none');?></a></b>
        <span style="padding-left:10px;">
            <select name="more_action" id="more_action">
                <option value=""><?php echo __('more'); ?></option>
            
                <option value="del" ><?php echo __('delete'); ?></option>
            
            </select>
         </span>
	</div>
</div>
<?php }?>
<!--Select All & More Actions Div -->

<div class="pagination">
	<?php if(($action != 'user_loginip_search') && ($user_loginip_count > 0)): ?>
	 <p><?php echo $pag_data->render(); ?></p>  
	<?php endif; ?>
<div class="clr">&nbsp;</div>

</div>

</div>
<!--My div End-->
<script language="javascript" type="text/javascript">
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
//For Delete the users
//=====================
function frmdel_user(userid)
{
   var answer = confirm("<?php echo __('delete_alert2');?>")
    if (answer){
        window.location="<?php echo URL_BASE;?>manageusers/userlogin_delete/"+userid;
    }
    
    return false;  
} 

	//function for block ip/unblock ip
	//================================
	function frmchangestatus(block_id, block_status)
	{
		//check whether ip block/unblock
		switch (block_status)
		{
			//if IP unblock 
			//==========================
			case 1:
			var answer = confirm("<?php echo __('unblock_ip_alert');?>")	
			break;
			//if IP block 
			//==========================
			case 0:
			var answer = confirm("<?php echo __('block_ip_alert');?>")
			break;	
	
		}
			if (answer){
				//redirect to Manage users controller for update status of IP block status
				//===================================================================
				window.location="<?php echo URL_BASE;?>manageusers/update_banIP_status/"+"?id="+block_id+"&&status="+block_status;
			}
	}
 
$('#more_action').change(function() {
	var selected_val= $('#more_action').val();
	if(selected_val){
		if($('input[type="checkbox"]').is(':checked'))
		{
	   		 var ans = confirm("<?php echo __('delete_alert2');?>")
	   		 if(ans){
				 document.frmusers.action="<?php echo URL_BASE;?>manageusers/userlogin_delete/";
				 document.frmusers.submit();
			 }else{
			 	$('#more_action').val('');
			 }
		}else{
			alert("<?php echo __('delete_alert1');?>");
			$('#more_action').val('');
		}
	}
	return false;  
});

$(document).ready(function(){
      toggle(2);
});
</script>
