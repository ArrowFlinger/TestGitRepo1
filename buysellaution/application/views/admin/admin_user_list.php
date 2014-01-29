<?php defined('SYSPATH') OR die("No direct access allowed."); 

//For search values
//=================
$user_type_val = isset($srch["user_type"]) ? $srch["user_type"] :''; 
$status_val = isset($srch["status"]) ? $srch["status"] :''; 							
$keyword = isset($srch["keyword"]) ? $srch["keyword"] :''; 

//For CSS class deefine in the table if the data's available

$total_users=count($all_user_list);

$table_css=$export_excel_button="";
if($total_users>0)
{ 
	$table_css='class="table_border"'; 

	$export_excel_button='<span>
        				<input type="button"  title="'.__('button_export').'" class="button" value="'.__('button_export').'" 
        				onclick="location.href=\''.URL_BASE.'manageusers/export?keyword='.$keyword.'&status='.$status_val.'&type='.$user_type_val.'\'" />
    				</span>';
}?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmusers" id="frmusers" action="search">
            <table class="list_table1 fl clr" border="0" width="100%" cellpadding="5" cellspacing="0">
                <tr>
                    <td valign="top"><label style="padding-top:5px;display:block;"><?php echo __('keyword_label'); ?></label></td>
                    <td>
	            	<input type="text" name="keyword" maxlength="256" id="keyword" value="<?php echo isset($srch['keyword']) ? trim($srch['keyword']) :''; ?>" />
	            	 <span class="search_info_label"><?php echo __('srch_info_usr_keyword');?></span>
                    </td>
                    <td>
						<label><?php echo __('usertype_label'); ?></label>
                    </td>
                    <td>
                        <select name="user_type" id="user_type">
							<option value=""><?php echo __('select_label'); ?></option>
				            <?php 
								
								$selected_user_type="";
								foreach($filter as $user_type_key => $usertype_text) {   	
								$selected_user_type=($user_type_key==$user_type_val) ? " selected='selected' " : ""; 
							?>
                                
                                <option value="<?php echo $user_type_key; ?>"  <?php echo $selected_user_type; ?>><?php echo $usertype_text;?></option>
							
							<?php }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label><?php echo __('status_label');?></label></td>
                    <td>
                        <select name="status" id="status">
                            <option value=""><?php echo __('select_label'); ?></option>    
				            <?php foreach($status AS $status_key => $allstatus) { 
							
								 $selected_status=($status_val==$status_key) ? ' selected="selected" ' : " "; 
							
							?>  
                                
                                <option value="<?php echo $status_key; ?>"  <?php echo $selected_status; ?> ><?php echo $allstatus;?></option>
                                
						    <?php }?>
                        </select>
                    </td>
                    <td colspan="2">
                        <input type="submit" value="<?php echo __('button_search'); ?>" name="search_user" title="<?php echo __('button_search'); ?>" />
                        <input type="button" value="<?php echo __('button_cancel'); ?>" title="<?php echo __('button_cancel'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/index'" />
                    </td>
                </tr>
            </table>

<div class="clr">&nbsp;</div>
<div style="float: right;">
    <div style="float:right;">
        <?php echo $export_excel_button; ?>
        <span >
        	<input type="button" class="button" title="<?php echo __('button_add'); ?>" value="<?php echo __('button_add'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/add'" />
        </span>
	</div>
</div>
<div class="clr">&nbsp;</div>

<table cellspacing="1" cellpadding="5" width="100%" align="center" <?php echo $table_css; ?>>
<?php if($total_users > 0){ ?>

	<tr class="rowhead">
		<th align="left"><?php echo __('sno_label'); ?></th>
        <th align="left" width="18%" ndowrap="nowrap"><?php echo __('fname_label'); ?></th>
		<th align="left" width="18%" ndowrap="nowrap"><?php echo __('lname_label'); ?></th>
		<th align="left" width="25%" nodwrap="nowrap"><?php echo __('email_label'); ?></th>
		<th align="left" width="15%" nowdrap="nowrap"><?php echo __('username_label'); ?></th>
		<th align="left" width="13%" nowrdap="nowrap"><?php echo __('usertype_label'); ?></th>
		<th align="left" width="10%"><?php echo __('status_label'); ?></th>
		<th align="left" width="5%"><?php echo __('Edit'); ?></th>
		<th align="left"><?php echo __('Delete'); ?></th>
		</tr>
		<?php

         $sno=$Offset; /* For Serial No */

		 foreach($all_user_list as $listings) {
		 
		 //S.No Increment
		 //==============
		 $sno++;
        
         //For Odd / Even Rows
         //===================
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr';  
		 
        ?>     

        <tr class="<?php echo $trcolor; ?>">

			<td width="5%"><?php echo $sno; ?></td>
                        <td width="18%"><?php echo wordwrap(ucfirst($listings['firstname']),12,'<br />',1); ?></td>
			<td width="18%"><?php echo wordwrap(ucfirst($listings['lastname']),12,'<br />',1); ?></td>
			<td width="25%"><?php echo wordwrap($listings['email'],25,'<br />',1); ?></td>
			<td width="15%"><?php echo wordwrap(ucfirst($listings['username']),12,'<br />',1); ?></td>
			<td width="12%"><?php echo ($listings['usertype'] == 'A')?__('Admin'):__('user_label'); ?></td>
			<td width="10%">
			<?php if($listings['status'] == 'D')
			{
			echo __('delete_label');
			}
			else
			{
			 echo ($listings['status'] == 'A')? __('active_label'): __('inactive_label'); 
			 }?></td>
			<td width="5%" title="<?php echo __('Edit'); ?>"><?php echo '<a href="'.URL_BASE.'manageusers/edit/'.$listings['id'].' " class="editicon"></a>' ; ?></td>
			<td align="center" title="<?php echo __('button_delete');?>">
			<?php if($listings['status'] == 'D')
			{
			echo "--";
			}
			else
			{ ?>
			<?php if($listings['usertype'] != 'A'){echo '<a onclick="frmdel_user('.$listings['id'].');" class="deleteicon"> </a>';}else{echo "_";} 
			}?></td>
		</tr>
		<?php } 

 		 } 
		 
		//For No Records
		//==============
	     else{ ?>
       	<tr>
        	<td class="nodata"><?php echo __('no_data'); ?></td>
        </tr>
		<?php } ?>
</table>
</form>
</div>
<div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
  <div class="clr">&nbsp;</div>
  <div class="pagination">
		<?php if(($action != 'search') && $total_users > 0): ?>
		 <p><?php echo $pag_data->render(); ?></p>  
		<?php endif; ?> 
  </div>
  <div class="clr">&nbsp;</div>
</div>

<script type="text/javascript" language="javascript">
//For Delete the users
//=====================
function frmdel_user(userid)
{
   var answer = confirm("<?php echo __('delete_alert2');?>")
    
	if (answer){
        window.location="<?php echo URL_BASE;?>manageusers/delete/"+userid;
    }
    
    return false;  
}  
$(document).ready(function(){
      toggle(2);
});
</script>
