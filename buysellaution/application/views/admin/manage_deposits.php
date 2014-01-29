<?php defined('SYSPATH') OR die("No direct access allowed."); 

//For search values
//=================
$user_type_val = isset($srch["user_type"]) ? $srch["user_type"] :''; 
$status_val = isset($srch["status"]) ? $srch["status"] :''; 							
$keyword = isset($srch["keyword"]) ? $srch["keyword"] :''; 

//For CSS class deefine in the table if the data's available

$total_users=count($all_user_list_deposits);

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
<div style="float: right;">
    <div style="float:right;">
      
        <span >
        	<input type="button" class="button" title="<?php echo __('button_add'); ?>" value="<?php echo __('button_add'); ?>" onclick="location.href='<?php echo URL_BASE;?>manageusers/deposits'" />
        </span>
	</div>
</div>
<div class="clr">&nbsp;</div>

<table cellspacing="1" cellpadding="5" width="100%" align="center" <?php echo $table_css; ?>>
<?php if($total_users > 0){ ?>

	        <tr class="rowhead">
	        <th align="left" width="5%"><?php echo __('sno_label'); ?></th>
                <th align="left" width="15%" nowdrap="nowrap"><?php echo __('username_label'); ?></th>
                <th align="left" width="25%" nodwrap="nowrap"><?php echo __('email_label'); ?></th>
		
		<th align="left" width="18%" ndowrap="nowrap"><?php echo __('deposit_amount'); ?></th>
		<th align="left" width="18%" ndowrap="nowrap"><?php echo __('date_lable'); ?></th>
		<th align="left" width="10%"><?php echo __('status_label'); ?></th>
		</tr>
		<?php
                 $sno=$Offset; /* For Serial No */
		 foreach($all_user_list_deposits as $listings) {		 
		 //S.No Increment		
		 $sno++;       
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr';  		 
        ?>     
        <tr class="<?php echo $trcolor; ?>">
        <td width="5%"><?php echo $sno; ?></td>
        <td width="15%"><?php echo wordwrap(ucfirst($listings['username']),18,'<br />',1); ?></td>
        <td width="25%"><?php echo wordwrap($listings['email'],25,'<br />',1); ?></td>
        <td width="18%"><?php 
       echo  $site_currency." ".Commonfunction::numberformat($listings['package_amount']);?></td>
        <td width="18%"><?php echo date('d-M-Y ',strtotime($listings['order_date'])).date(' h:i A',strtotime($listings['order_date']));?></td>
        <td width="10%"><?php echo ($listings['status'] == 'A')?__('active_label'):__('inactive_label'); ?></td>			
			
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

<script type="text/javascript">
	$(document).ready(function(){
		  toggle(6);
	});
</script>
