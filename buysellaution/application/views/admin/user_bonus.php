<?php defined('SYSPATH') OR die("No direct access allowed."); 

 //Check the User bonus Type
$userbonus_count=count($user_bonus);

$table_css="";
if($userbonus_count>0)
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
                 
                 <div class="clr">&nbsp;</div>
                  <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>
                  
                  <?php if($userbonus_count > 0)
                  { ?>
                            <tr class="rowhead">
                                <th align="left" width="8%"><?php echo __('sno_label'); ?></th>
                                <th align="center" width="3%" ><?php echo __('action_label'); ?></th>
                                <th align="left" width="28%"><?php echo __('bonus_type'); ?></th>
                                <th align="left" width="20%"><?php echo __('bonus_amount'); ?></th>
                                <th align="left" width="25%"><?php echo __('username_label'); ?></th>
                               
                                <th align="center" width="18%"><?php echo __('bonus_created_date');?></th>                                
                            </tr>    
                            <?php 
                             $sno=$offset; /* For Serial No */
                             foreach($user_bonus as $userbonus)
                             {
                             $sno++;
                             $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                            ?>
                            <tr class="<?php echo $trcolor; ?>">
                                    <td width="8%" align="left">
                                        <?php echo $sno; ?>
                                    </td>
                                        <td align="center">
                                        <?php echo '<a href="'.URL_BASE.'adminauction/bonus_friends_list/'.$userbonus['created_date'].' " style="float:none; display:block;" target="_blank" title ='.__('view').' class="viewicon"></a>' ; ?>

                                        </td>
                                     <td align="left" width="28%">
                                        <?php echo ucfirst($userbonus['bonus_type']); ?>
                                    </td>
                                    <td align="left" width="20%">
                                        <?php  echo  $site_currency." ".Commonfunction::numberformat($userbonus['bonus_amount']); ?>
                                    </td>
                                       <td align="left" width="25%">
                                        <?php echo ucfirst($userbonus['username']); ?>
                                    </td>
                                  
                                    <td align="center" width="18%">
                                        <?php echo $userbonus['created_date']; ?>
                                    </td>
                                   
                            </tr>
                                <?php 
                                      } 
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

//For Delete the user bonus
//=========================

function frmdel_bonus(bonus_id)
{
    var answer = confirm("<?php echo __('delete_alert_user_bonus');?>")
    if (answer){
         window.location="<?php echo URL_BASE;?>adminauction/delete_user_bonus/"+bonus_id;
    }
    
    return false;  
} 
$(document).ready(function(){
      toggle(6);
});
</script>
