<?php defined('SYSPATH') OR die("No direct access allowed."); 
//For search values
//=================

//For CSS class deefine in the table if the data's available

$total_users=count($user_results);


$table_css=$export_excel_button="";
$table_css="";
if($total_users > 0)
{  $table_css='class="table_border"';  }?>


<div class="container_content fl clr">
<div class="cont_container mt15 mt10">
    <div class="content_top"><div class="top_left"></div><div class="top_center"></div><div class="top_rgt"></div></div>
    <div class="content_middle">


<div class="clr">&nbsp;</div>

<table  cellspacing="1" cellpadding="5" width="100%" align="center" <?php echo $table_css; ?>>
<?php if($total_users > 0){ 

?>

	<tr class="rowhead">
		<th align="left" width="5%"><?php echo __('sno_label'); ?></th>
        <th align="left" width="18%" ndowrap="nowrap"><?php echo __('username_label'); ?></th>
		<th align="left" width="15%" ndowrap="nowrap"><?php echo __('posted_label'); ?></th>
		<th align="left" width="25%" nodwrap="nowrap"><?php echo __('email_label'); ?></th>		
		<th align="left"  width="5%"><?php echo __('status_label'); ?></th>
		<th  align="left"  width="5%"><?php echo __('testimonials_bonus_label'); ?></th>
		<th align="left" width="5%"><?php echo __('Edit'); ?></th>
		<th align="center" ><?php echo __('Delete'); ?></th>
		</tr>
		<?php
                $sno=$Offset; /* For Serial No */
                foreach($user_results as $listings) {
                //S.No Increment
                $sno++;
                //For Odd / Even Rows
                $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
        ?>     

        <tr class="<?php echo $trcolor; ?>">
                <td width="5%"><?php echo $sno; ?></td>
                <td width="20%"><?php echo ucfirst($listings['username']); ?></td>
                <td width="15%"><?php echo   $listings['date']; ?> </td>
                <td width="25%"><?php echo $listings['email']; ?></td>
                <td align="center"  width="5%">
                <?php 
                $class = 'unsuspendicon'; $title =__('active_label'); $suspend_status =0;
                if($listings['testimonials_status']==IN_ACTIVE){$class = 'blockicon'; $title =__('inactive_label'); $suspend_status = 1; }
                echo "<a  onclick='frm_auction(".$listings['testimonials_id'].','.$suspend_status.")' class='$class' title='$title'></a>"; ?> </td>
                <!--Testimonials Bonus-->
                <td align="center"  width="5%">
                <?php 
                $class = 'unsuspendicon'; $title =__('bonus_active'); $suspend_status =0;
                if($listings['testimonials_bonus']==IN_ACTIVE){$class = 'blockicon'; $title =__('bonus_inactive'); $suspend_status = 1; }
                echo "<a  onclick='bonus_auctions(".$listings['id'].','.$listings['testimonials_id'].','.$suspend_status.")' class='$class' title='$title'></a>"; ?> 
                </td>
                
                  <!--Testimonials Bonus End-->
                <td width="5%"  align="center" title="<?php echo __('Edit'); ?>"><?php echo '<a href="'.URL_BASE.'manageusers/manage_testimonials/'.$listings['testimonials_id'].' " class="editicon"></a>' ; ?></td>
                <td  align="center" title="<?php echo __('button_delete');?>"><?php if($listings['testimonials_status'] != '5'){echo '<a onclick="frmdel_user('.$listings['testimonials_id'].');" class="deleteicon"> </a>';}else{echo "_";} ?></td>
                
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
	 <p><?php echo $pagination->render(); ?></p>  
	<?php endif; ?> 
  </div>
  <div class="clr">&nbsp;</div>
</div>

<script type="text/javascript" language="javascript">
//For Delete the users
//=====================
        function frmdel_user(testimonials_id)
        {

           var answer = confirm("<?php echo __('delete_alert3');?>")
            
	        if (answer){
                window.location="<?php echo URL_BASE;?>manageusers/testimonials_delete/"+testimonials_id;
            }
            
            return false;  
        }  

        function frm_auction(testimonials_id,sus_status)
        {
      
                switch (sus_status)
                {
                //if resumes means 			
                case 0:
                  var answer = confirm("<?php echo __('inactive_alert_auction');?>")	
                break;
                //if hold means 		
                case 1:
                  var answer = confirm("<?php echo __('active_alert_auction');?>")
                break;					
                } 
                if (answer){

                window.location="<?php echo URL_BASE;?>manageusers/resumes/"+"?id="+testimonials_id+"&&susstatus="+sus_status;
                }
        }        
         function bonus_auctions(user_id,testimonials_id,sus_status)
        {
    
                switch (sus_status)
                {
                 			
                case 0:
                  var answer = confirm("<?php echo __('already_bonus_active');?>")	
                break;
                 		
                case 1:
                  var answer = confirm("<?php echo __('bonus_alert_auction');?>")
                break;					
                } 
                if (answer){

                window.location="<?php echo URL_BASE;?>manageusers/testimonials_amount/"+"?id="+user_id+"&&testimonialsid="+testimonials_id+"&&susstatus="+sus_status;
                }
                
                
        }

$(document).ready(function(){
      toggle(2);
});
</script>
