<?php defined('SYSPATH') OR die("No direct access allowed."); 
//For CSS class deefine in the table if the data's available
$total_pages=count($all_pages_list);

$table_css=$export_excel_button="";
$table_css="";
if($total_pages > 0)
{  $table_css='class="table_border"';  }?>

<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">

        <form method="post" class="admin_form" name="frmpages" id="frmpages" >
<div class="clr">&nbsp;</div>
<div class= "overflow-block static-details">
<table cellspacing="1" cellpadding="10" align="center" width="95%" <?php echo $table_css; ?>>
<?php if($total_pages > 0){ ?>
	<!--** Static Pages Listings Starts Here ** -->
        <tr class="rowhead">
        		<th align="left" width="5%"><?php echo __('sno_label'); ?></th>	
                <th align="center" width="5%" colspan="2"><?php echo __('action_label'); ?></th>
                <th align="left" width="15%"><?php echo __('page_title');?></th>
				<th align="center" width="60%"><?php echo __('page_description'); ?></th>
				<th align="left" width="5%"><?php echo __('status_label'); ?></th>
        </tr>    
        <?php 
         
         $sno=$offset; /* For Serial No */
         
         foreach($all_pages_list as $all_pages_list){
         
         $sno++;
         
         $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
		 
		?>
        <tr class="<?php echo $trcolor; ?>">
                <td align="center">
                    <?php echo $sno; ?>
                </td>
                <td> 
                	<?php echo '<a href="'.URL_BASE.'cms/edit_static_pages/'.$all_pages_list['id'].' " title ='.__('edit').'  class="editicon"></a>' ; ?>
                </td>
                <td>
                    <?php echo '<a href="'.URL_BASE.'cms/show_static_pages/'.$all_pages_list['id'].' " class="viewicon" title='.__('view').'  target="_blank"></a>'; ?>
                </td>

                <td align="left">
                    <?php echo $all_pages_list['page_title']; ?>
                </td>

                <td align="left">
                    <?php echo ucfirst(substr($all_pages_list['page_description'], 0, "150")); ?>
                </td>

                <td align="left">
                    <?php echo ($all_pages_list['status'] == 'A')?'Active':'Inactive'; ?>
                </td>


        </tr>
		<?php } 
		 }
	// ** Static Pages Listings Ends Here ** //
		 else { 
	// ** Static Pages is not Found Means ** //
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
<div class="pagination">
	<?php if($total_pages > 0): ?>
	 <p><?php echo $pag_data->render(); ?></p>  
	<?php endif; ?>
</div>
<div class="clr">&nbsp;</div>
</div>

<script type="text/javascript" language="javascript">

//For show  the static page content 
//==================================
function frmshow_static_content(view_id)
{
	window.location="<?php echo URL_BASE;?>cms/show_static_pages/"+view_id;

} 


$(document).ready(function(){
      toggle(8);
});
</script>
