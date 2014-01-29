<?php defined('SYSPATH') OR die("No direct access allowed."); 
 
$get_ads_count=count($get_ads);

$table_css="";
if($get_ads_count>0)
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
            <form name="frmjob" id="frmjob" method="post">
                 
                 <div class="clr">&nbsp;</div>
        <table cellspacing="1" cellpadding="5" width="90%" align="center" <?php echo $table_css; ?>>

                <?php if($get_ads_count > 0)
                { ?>
                        <tr class="rowhead">
                        <th align="left" width="8%"><?php echo __('sno_label'); ?></th>
                        <th align="left" width="18%"><?php echo __('ads_title'); ?></th>
                        <th align="left" width="15%"><?php echo __('ads_image'); ?></th>
                   
                        <th align="center" width="18%"><?php echo __('ads_status_label');?></th>
                        <th align="center" width="8%"><?php echo __('button_edit'); ?></th>
                      

                        </tr>    
                        <?php 

                        $sno=$offset; /* For Serial No */  

                        foreach($get_ads as $ads)
                        {
                                $sno++;
                                $trcolor=($sno%2==0) ? 'oddtr' : 'eventr'; 
                                $ads_image_path=ADMINIMGPATH.NO_IMAGE;
				$image_title=__('no_photo');
                                //check if file exists or not
                                if(((isset($ads)) && $ads['ads_image']) && (file_exists(DOCROOT.ADS_IMGPATH.$ads['ads_image'])))
                                { 
                                        $ads_image_path = URL_BASE.ADS_IMGPATH.$ads['ads_image'];                         
                                        $image_title = ucfirst($ads['title']);
                                        $atag_end='</a>';										   
                                }	

                                ?>
                                
                               
                                <tr class="<?php echo $trcolor; ?>">

                                <td width="8%" align="center">
                                <?php echo $sno; ?>
                                </td>
                                <td align="center" width="18%">
                                <?php echo ucfirst($ads['title']); ?>
                                </td>
                                <td align="center" width="15%">
                                <img src="<?php echo $ads_image_path; ?>" title="<?php echo $image_title;?>" class="fl ml20" width="<?php echo ADS_SMALL_IMAGE_WIDTH;?>" height="<?php echo ADS_SMALL_IMAGE_HEIGHT;?>">
                                </td>
                              
                                <td align="center" width="18%">
                                <?php echo ($ads['ads_status'] == 'A')? __('active_label'): __('inactive_label'); ?>
                                </td>
                                <td align="center" width="8%">
                               
	<a href="<?php echo URL_BASE.'settings/edit_ads/'.$ads['ads_id'];?>" title ="<?php echo __('Edit'); ?>" class="editicon"></a>
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

//For Delete the ads
//=========================

function frmdel_ads(ads_id)
{
        var answer = confirm("<?php echo __('delete_alert_ads');?>")
        if (answer){
                window.location="<?php echo URL_BASE;?>settings/delete_ads/"+ads_id;
        }

        return false;  
} 

function frm_ads(ads_id,sus_status)
{

        switch (sus_status)
        {
                //if resumes means 			
                case 0:
                var answer = confirm("<?php echo __('inactive_alert_ads');?>")	
                break;
                //if hold means 		
                case 1:
                var answer = confirm("<?php echo __('active_alert_ads');?>")
                break;					
        } 


        if (answer){

                window.location="<?php echo URL_BASE;?>settings/active/"+"?id="+ads_id+"&&susstatus="+sus_status;
        }
}

$(document).ready(function(){
      toggle(1);
}); 

</script>
