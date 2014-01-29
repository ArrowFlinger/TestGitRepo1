<?php defined('SYSPATH') OR die("No direct access allowed.");
//WebRupee
$sitesettings ="<span class='WebRupee'>".$site_settings[0]['site_paypal_currency']."</span>";
 //Check the User bonus Type
$bonustype_count=count($bonustype);

$table_css="";
if($bonustype_count>0)
{  $table_css='class="table_border"';  }


//For Notice Messages

$sucessful_message=Message::display();

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
            <form name="frmbonus" id="frmbonus" method="post">
                  <div style="float: right;padding-right:45px;">
                    <!--<input type="button" class="button" title="<?php echo __('button_add'); ?>"value="<?php echo __('button_add'); ?>" onclick="location.href='<?php echo URL_BASE?>adminauction/add_bonus'" />-->
                  </div>
                 <div class="clr">&nbsp;</div>
                  <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>
                  
                  <?php if($bonustype_count > 0)
                  { ?>
                            <tr class="rowhead">
                                    <th align="left" width="8%"><?php echo __('sno_label'); ?></th>
                                    <th align="left" width="38%"><?php echo __('bonus_type'); ?></th>
                                     <th align="left" width="20%"><?php echo __('bonus_amount'); ?></th>
                                    <th align="left" width="12%"><?php echo __('bonus_status_label');?></th>
                                    <th align="center" width="20%"><?php echo __('bonus_create_date');?></th>
                                    <th align="left" width="8%"><?php echo __('button_edit'); ?></th>
                                  <!--   <th align="center"><?php echo __('button_delete');?></th> -->
                            </tr>    
                            <?php 
                             $sno=$offset; /* For Serial No */
                             foreach($bonustype as $bonus)
                             {
                             $sno++;
                             $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                            ?>
                            <tr class="<?php echo $trcolor; ?>">
                                    <td width="8%" align="left">
                                        <?php echo $sno; ?>
                                    </td>
                                    <td align="left" width="38%">
                                        <?php echo ucfirst($bonus['bonus_type']); ?>
                                    </td>
                                     <td align="left" width="20%">
                                        <?php  echo $site_currency." ".Commonfunction::numberformat($bonus['bonus_amount']); ?>
                                    </td>
                                   <td align="left" width="12%">
                                        <?php echo $bonus['bonus_status']; ?>
                                    </td>
                                    <td align="center" width="20%">
                                        <?php echo $bonus['created_date']; ?>
                                    </td>
                                    <td align="center" width="8%" title="<?php echo __('button_edit'); ?>">
                                        <?php echo '<a href="'.URL_BASE.'adminauction/edit_bonus/'.$bonus['bonus_type_id'].' "  class="editicon"></a>' ; ?>
                                    </td>                                
                                <!--    <td align="center" title="<?php echo __('button_delete');?>">
                                        <?php                                                                               
                                        echo '<a  onclick="frmdel_bonus('.$bonus['bonus_type_id'].');" class="deleteicon" ></a>'; ?>     
                                   </td> -->
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
                </form>
        </div>
        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        <div class="clr">&nbsp;</div>
			   		
			
        <div class="pagination">
          <div><?php echo $pag_data->render(); ?></div>
        </div> 
         <div class="clr">&nbsp;</div> 

  </div>
</div>
<!--My div -->
<script language="javascript" type="text/javascript">
//For Delete the bonus
//====================

function frmdel_bonus(bonus_type_id)
{
    var answer = confirm("<?php echo __('delete_alert_bonus');?>")
    if (answer){
         window.location="<?php echo URL_BASE;?>adminauction/delete_bonus/"+bonus_type_id;
    }
    
    return false;  
} 
$(document).ready(function(){
      toggle(6);
});
</script>
