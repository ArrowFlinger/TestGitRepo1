<?php defined('SYSPATH') OR die("No direct access allowed."); 
$sitesettings ="<span class='WebRupee'>". $site_settings[0]['site_paypal_currency']."</span>";
//For search values
//=================
$user_type_val = isset($srch["user_type"]) ? $srch["user_type"] :''; 
$status_val = isset($srch["status"]) ? $srch["status"] :''; 							
$keyword = isset($srch["keyword"]) ? $srch["keyword"] :''; 

//For CSS class deefine in the table if the data's available

$total_users=count($all_user_message);

$table_css=$export_excel_button="";
if($total_users>0)
{ 
	$table_css='class="table_border"'; 

	
}?>
<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">
        <form method="post" class="admin_form" name="frmusers" id="frmusers" action="search">
            <table class="list_table1 fl clr" border="0" width="100%" cellpadding="5" cellspacing="0">           
            </table>
<div class="clr">&nbsp;</div>

<table cellspacing="1" cellpadding="5" width="100%" align="center" <?php echo $table_css; ?>>
<?php if($total_users > 0){ ?>

                <tr class="rowhead">
                <th align="left" width="5%"><?php echo __('sno_label'); ?></th>
                <th align="left" width="20%" nowdrap="nowrap"><?php echo __('messgae_from'); ?></th>
                <th align="left" width="20%" nodwrap="nowrap"><?php echo __('messgae_to'); ?></th>
                <th align="left" width="28%" ndowrap="nowrap"><?php echo __('message_title'); ?></th>
                <th align="left" width="18%" ndowrap="nowrap"><?php echo __('message_date'); ?></th>
                <th align="left" width="10%"><?php echo __('message_status'); ?></th>
                </tr>
		<?php
		 $sno=$Offset; /* For Serial No */
		 foreach($all_user_message as $listings) {		 
		 //S.No Increment		
		 $sno++;       
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr';  		 
        ?>     
        <tr class="<?php echo $trcolor; ?>">
        <td width="5%"><?php echo $sno; ?></td>
        <td width="25%"><?php echo wordwrap($listings['usermessage_from'],25,'<br />',1); ?></td>
        <td width="25%"><?php echo wordwrap($listings['usermessage_to'],25,'<br />',1); ?></td>
        <?php if($listings['admin_msg_type'] == 'R')
                { ?>
        <td width="5%" ><a href="javascript:;" onclick="window.open('<?php echo URL_BASE;?>manageusers/reports_details/<?php echo $listings['usermessage_id']; ?>','','width=820,height=500')" style="color:OrangeRed"><?php echo ucfirst($listings['usermessage_subject']); ?></a> </td>
        <?php }
        else { ?>
        <td width="5%" ><a href="javascript:;" onclick="window.open('<?php echo URL_BASE;?>manageusers/reports_details/<?php echo $listings['usermessage_id']; ?>','','width=820,height=500')" ><?php echo ucfirst($listings['usermessage_subject']); ?></a> </td>
        <?php
        }
        ?>
        <td width="18%"><?php echo date('d-M-Y ',strtotime($listings['sent_date'])).date(' h:i A',strtotime($listings['sent_date']));?></td>
        <td width="10%"><?php echo ($listings['admin_msg_type'] == 'R')?__('read'):__('unread'); ?></td>	
        				
		</tr>
		<?php } 

 		 } 
		 
		//For No Records
		
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
<script language="javascript" type="text/javascript">
$(document).ready(function(){
      toggle(2);
});
</script>
